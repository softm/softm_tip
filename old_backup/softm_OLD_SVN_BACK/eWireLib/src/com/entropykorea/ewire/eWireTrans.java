package com.entropykorea.ewire;

import java.lang.reflect.Field;

import android.content.Context;
import android.content.Intent;
import android.os.Handler;
import android.os.Message;
import android.widget.Toast;

import com.entropykorea.ewire.dialog.eWireTransDialog;

public abstract class eWireTrans {
	private Context context;
	
	public final static String BROADCAST_ACTION_EWIRETRANS = "com.entropykorea.ewire.EWIRETRANS";
	private final static int DEFAULT_SERVER_PORT = 4000; // default port
	public final static String DEFAULT_DISPLAYMESSAGE = "처리 중입니다.\n잠시만 기다리십시요"; // default message

	public final static int DIALOGTYPE_NONE = 0;
	public final static int DIALOGTYPE_WAIT = 1;
	public final static int DIALOGTYPE_PROGRESS = 2;
	public final static int DIALOGTYPE_WAIT_PROGRESS = 3;
	
	private final static int TRANS_DATA_TYPE_NONE = 0; // I MODE
	private final static int TRANS_DATA_TYPE_UP = 1; // C MODE UP
	private final static int TRANS_DATA_TYPE_DOWN = 2; // C MODE DOWN
	
	private String server_ip = new String();
	private String server_port = new String();
	private Integer server_port_number = DEFAULT_SERVER_PORT;
	private String userid = new String();
	private String command = new String();
	private String instruction = new String();
	private String param = new String();
	private String filename = new String();
	
	// options 
	private int dialogtype = 2; // 0: none  1: only progress  2: dialog + horizontal progress 3:
	private boolean showstatusbar = false;
	private boolean showerror = false;
	private boolean soundplay = false;
	private String displaymessage = DEFAULT_DISPLAYMESSAGE;
	
	private int delaytime = 0;

	private int currnet_trans_data_type = 0;
	private boolean deleteAfterTrans = true;

	// dialogs
	private eWireTransDialog progressDialog;
	
	public eWireTrans(Context context) {
		this.context = context;
	}
	
	public void setShowStatusBar( boolean showstatusbar ) {
		this.showstatusbar = showstatusbar;
	}
	
	// set (reflection)
	public void setData( String fieldName, String value ) {
		Class<?> cls = this.getClass();
		try {
			Field field = cls.getField( fieldName );
			Object t = cls.newInstance();
			field.set( t, value );
		} catch (Exception e) {
			e.printStackTrace();
		}
	}
	
	// set
	public void setServerIp( String server_ip ) {
		this.server_ip = server_ip;
	}
	
	public void setServerPort( String server_port ) {
		this.server_port = server_port;
	    try {
			this.server_port_number = Integer.getInteger( this.server_port );
		} catch (NumberFormatException e) {
			this.server_port_number = DEFAULT_SERVER_PORT;
		}
	}
	
	public void setUserId( String userid ) {
		this.userid = userid;
	}
	
	public void setCommand( String command ) {
		this.command = command;
	}
	
	public void setInstruction( String instruction ) {
		this.instruction = instruction;
	}
	
	public void  setParam( String param ) {
		this.param = param;
	}
	
	public void setFileName( String filename ) {
		this.filename = filename;
	}
	
	public void setDialogType( int type ) {
		this.dialogtype = type;
	}
	
	public void setShowError( boolean showerror ) {
		this.showerror = showerror;
	}
	
	public void setSoundPlay( boolean soundplay ) {
		this.soundplay = soundplay;
	}
	
	public void setDisplayMessage( String displaymessage ) {
		this.displaymessage = displaymessage;
	}
	
	public void setDelayTime( int milisecond ) {
		this.delaytime = milisecond;
	}
	
	public void setDeleteAfterTrans(boolean deleteAfterTrans) {
		this.deleteAfterTrans = deleteAfterTrans;
	}

	// interface
	public abstract void onFinished(boolean result, String resultMessage);
	
	public interface onFinished {
		void onFinished(boolean result, String resultMessage);
	}

	private onFinished callbackOnFinished = null;

	public void setOnFinished(onFinished callback) {
		this.callbackOnFinished = callback;
	}
	
	// error
	public String getErrorMessage() {
		return this.ewire.getErrorMessage();
	}
	
	public String getErrorMessageDetail() {
		return this.ewire.getErrorMessageDetail();
	}
	
	public String getErrorCode() {
		return this.ewire.getErrorCode();
	}
	
	// util
	private void sleep( int milisecond ) {
		try {
			Thread.sleep( milisecond );
		} catch (InterruptedException e) {
			e.printStackTrace();
		}
	}
	
	// 
	private void endTrans( boolean result ) {
		
		// wait
		if( this.delaytime > 0 ) {
			sleep( this.delaytime );
		}
		
		hideDialog();
		
		// 정상의 경우 
		if( result ) {
			if( this.soundplay ) {
				playSound();
			}
		} else {
			if( this.showerror ) {
				Toast.makeText(context, mResultMessage, Toast.LENGTH_SHORT).show();
			}
		}
		
		onFinished( result, mResultMessage );
		
		if( callbackOnFinished != null ) {
			callbackOnFinished.onFinished( result, mResultMessage );
			
		} else {

			// Broadcast
			Intent intent = new Intent();
			intent.setAction(BROADCAST_ACTION_EWIRETRANS);
			intent.putExtra("RESULT", result);
			intent.putExtra("RESULTMESSAGE", mResultMessage);
			context.sendBroadcast(intent);
		}
		
		// delete zip file 
		if( this.deleteAfterTrans && this.currnet_trans_data_type == this.TRANS_DATA_TYPE_UP ) {
			FileUtils.deleteFile(filename);
		}
		
	}
	
	public void playSound() {
		eWireSound.playOk(context);
	}

	public void showDialog() {
		if( progressDialog != null ) {
			hideDialog();
		}
		progressDialog = new eWireTransDialog(context, this.dialogtype, false, this.showstatusbar ); 
		progressDialog.setMessage(displaymessage);
		progressDialog.show();
	}
	
	public void hideDialog() {
		if( progressDialog != null ) {
			progressDialog.hide();
			progressDialog.dismiss();
			progressDialog = null;
		}
	}
	
	// set dialog progress
	public void setProgress(Integer current, Integer total) {
		progressDialog.setProgressBar(current, total);
		//eWireLog.d("EWIRE", "PP:" + current + " / " + total );
	}
	
	// eWreTrans callback
	eWire.OnPublishProgress cb_publishprogress = new eWire.OnPublishProgress() {
		
		@Override
		public void OnPublishProgress(Integer current, Integer total) {
			Message msg = mTransHandler.obtainMessage();
			msg.what = 9; 
			msg.arg1 = current;
			msg.arg2 = total;
			//eWireLog.d("EWIRE", "VALUE:" + current + "/" + total );
			mTransHandler.sendMessage(msg);
		}
	};

	
	eWire ewire;
	boolean mThreadRunning = false;
	
	public void excuteTrans() {
//		if( mThreadRunning == true )
//			return;
		showDialog();
		goTrans();
	}
	
	// eWireTrans thread
	TransThread mTransThread;
	String mResultMessage = new String();
	
	private void goTrans() {
		if( mThreadRunning == true )
			return;
		mResultMessage = "";
		mTransThread = new TransThread();
		mTransThread.start();
		mThreadRunning = true;
	}
	
	public String getResult() {
		return mResultMessage;
	}
	
	class TransThread extends Thread {
		public void run() {
			Message msg = mTransHandler.obtainMessage();

			if( Trans() ) {
				msg.what = 0; // 완료
			} else {
				msg.what = 1; // 에러
			}
			mTransHandler.sendMessage(msg);
		}
	}
	
	Handler mTransHandler = new Handler() {
		public void handleMessage(Message msg) {

			switch( msg.what )
			{
			case 0: // 완료
				//Toast.makeText(TransActivity.this, mTransResultMsg, Toast.LENGTH_SHORT).show();
				mThreadRunning = false;
				// end activity
				endTrans( true );
				break;
			case 1: // 에러
				//Toast.makeText(TransActivity.this, mTransResultMsg, Toast.LENGTH_SHORT).show();
				mThreadRunning = false;
				// end activity
				endTrans( false );
				break;
			case 9: // update progress
				setProgress( msg.arg1, msg.arg2 );
				//mProgressDialog.setProgress( msg.arg1 );
				break;
			}

		}
	};
		
	public boolean Trans() {
		boolean rtn = true;
		
		//String result;
		//eWireParam ep_result = new eWireParam();
		ewire = new eWire( server_ip, server_port );
		ewire.setOnPublishProgress(cb_publishprogress);
		
		this.currnet_trans_data_type = this.TRANS_DATA_TYPE_NONE;
		
		if( command.compareTo("I") == 0 ) {
			this.currnet_trans_data_type = this.TRANS_DATA_TYPE_NONE;
			
			if( ewire.transNone(userid, command, instruction, param ) ) {
				mResultMessage = ewire.getParam(); 
			} else {
				mResultMessage = ewire.getErrorCode() + ":" + ewire.getErrorMessage();
				rtn = false;
			}
		} else if( param.startsWith( "DOWN" ) ) {
			this.currnet_trans_data_type = this.TRANS_DATA_TYPE_DOWN;
			
			if( ewire.transDown(userid, command, instruction, param, filename) ) {
				mResultMessage = ewire.getParam(); 
			} else {
				mResultMessage = ewire.getErrorCode() + ":" + ewire.getErrorMessage();
				rtn = false;
			}
		} else if( param.startsWith( "UP" ) ) {
			this.currnet_trans_data_type = this.TRANS_DATA_TYPE_UP;
			
			if( ewire.transUp(userid, command, instruction, param, filename) ) {
				mResultMessage = ewire.getParam(); 
			} else {
				mResultMessage = ewire.getErrorCode() + ":" + ewire.getErrorMessage();
				rtn = false;
			}
		}
		
		return rtn;
	}
	
}
