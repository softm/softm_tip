package com.entropykorea.gas.main.ewire;

import java.io.File;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.eWireData;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.spec.UserSpec;
import com.entropykorea.gas.main.AppContext;
import com.entropykorea.gas.main.common.Constants;
import com.entropykorea.gas.main.common.DLog;
import com.entropykorea.gas.main.common.DateString;

public class CallTrans {
	
	private final static String ZIPFILENAME = Constants.main_path + "/data.zip";
	private final static String FILEPATH = Constants.main_path;

	private String SERVER_IP = "110.8.124.30";
	private String SERVER_PORT = "4000";
	
	private Context mContext = null;
	private SQLiteDatabase mSqliteDatabase = null;

	private String mUserId = "";
	private String mDeviceNumber = "";
	private String mCommand = "";
	private String mInstruction = "";
	private String mParam = "";
	
	public CallTrans( Context ctx, String serverIp, String serverPort, String userId, String deviceNumber ) {
		this.mContext = ctx;
		this.mSqliteDatabase = AppContext.getSQLiteDatabase();
		this.mUserId = userId;
		this.mDeviceNumber = deviceNumber;
		this.SERVER_IP = serverIp;
		this.SERVER_PORT = serverPort;
	}
	
	
	// user_down DOWN|/DATA/COMMON/DN/(YYYYMMDD)/DN_USER_(기기번호)_hhmmss.ZIP
	
	public void callTrans() {
		doGumUserDown();
	}
	
	private void doGumUserDown() {
		
		// user_down DOWN|/DATA/COMMON/DN/(YYYYMMDD)/DN_USER_(기기번호)_hhmmss.ZIP
		String format = "DOWN|/DATA/COMMON/DN/%s/DN_GUM_%s_%s.ZIP";

		this.mCommand = "C";
		this.mInstruction = "user_down";
		this.mParam = String.format(format, 
				DateString.getTodayYMD(),
				mDeviceNumber,
				DateString.getTodayHMS()
				);

		DLog.d( this.mParam );
		
		doTrans();
				
	}

    // interface
	//public void onFinished(boolean result, String resultMessage);

	public interface onFinished {
		void onFinished(boolean result, String resultMessage);
		void preExcute();
		void postExcute();
	}

	private onFinished callbackOnFinished = null;

	public void setOnFinished(onFinished callback) {
		this.callbackOnFinished = callback;
	}

	// eWire
	
	private void doTrans() {
		
		// eWire
		eWireTrans ewireTrans = new eWireTrans( mContext ){

			@Override
			public void onFinished(boolean result, String resultMessage) {
				if( result ) {
						doImport();
				} else {
					if( callbackOnFinished != null ) {
						callbackOnFinished.onFinished( result, resultMessage );
					}
				}
			}
			
		};
		ewireTrans.setServerIp(SERVER_IP);
		ewireTrans.setServerPort(SERVER_PORT);
		ewireTrans.setUserId(mUserId);
		ewireTrans.setCommand(mCommand);
		ewireTrans.setInstruction(mInstruction);
		ewireTrans.setParam(mParam);
		ewireTrans.setFileName(ZIPFILENAME);
		
		// option
		ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_WAIT);
		ewireTrans.setShowStatusBar(true);
		ewireTrans.setDisplayMessage(eWireTrans.DEFAULT_DISPLAYMESSAGE);
		ewireTrans.setShowError(true);
		ewireTrans.setSoundPlay(false);
		
		// eWire Thread
		ewireTrans.excuteTrans();
	}
	
	private void doImport() {
		
		// create directory
		try {
			File f = new File( FILEPATH );
			if( !f.isDirectory() )
				f.mkdirs();
		} catch (Exception e) {
			e.printStackTrace();
			return;
		}		
		
		// set ewiredata
		eWireData ewireData = new eWireData( mContext ) {

			@Override
			public void onFinished(boolean result, String resultMessage) {

				if( callbackOnFinished != null ) {
					callbackOnFinished.onFinished( result, resultMessage );
				} 

			}

			@Override
			public void preExcute() {
				if( callbackOnFinished != null ) {
					callbackOnFinished.preExcute();
				} 
			}

			@Override
			public void postExcute() {
				if( callbackOnFinished != null ) {
					callbackOnFinished.postExcute();
				} 
			}
			
		};
		ewireData.setDatabase( mSqliteDatabase );
		ewireData.setZipfilename( ZIPFILENAME );
		ewireData.setOutputFolder( FILEPATH );
		Object[] databasespecication = {
				new UserSpec(),
		};
		ewireData.setDatabaseSpecication(databasespecication);
		
		// option
		//ewireData.setDialogType(eWireData.DIALOGTYPE_NONE);
		//ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
		//ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT_PROGRESS);
		ewireData.setDialogType(eWireTrans.DIALOGTYPE_WAIT);
		ewireData.setShowStatusBar(true);
		ewireData.setSoundPlay(false);
		ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
		ewireData.setShowError(true);
		
		// do thread
		ewireData.excuteImport();
	}
	
	
	
}
