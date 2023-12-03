package com.entropykorea.gas.gum.ewire;

import java.io.File;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.eWireData;
import com.entropykorea.ewire.eWireTrans;
import com.entropykorea.ewire.spec.CodeSpec;
import com.entropykorea.gas.gum.AppContext;
import com.entropykorea.gas.gum.common.Constants;
import com.entropykorea.gas.gum.common.DLog;
import com.entropykorea.gas.gum.common.DateString;
import com.entropykorea.gas.gum.spec.AreaCenterSpec;
import com.entropykorea.gas.gum.spec.GumCreateDtSpec;
import com.entropykorea.gas.gum.spec.GumCustSpec;
import com.entropykorea.gas.gum.spec.GumResultSpec;
import com.entropykorea.gas.gum.spec.GumSpec;
import com.entropykorea.gas.gum.spec.ProviderSpec;

public class CallTrans {
	
	public final static int JOB_GUM_CREATE_DT_DOWN = 0;
	public final static int JOB_GUM_DOWN = 1;
	public final static int JOB_GUM_UP = 2;
	
	private String SERVER_IP = "110.8.124.30";
	private String SERVER_PORT = "4000";
	
	private final static String ZIPFILENAME = "/sdcard/.mpgas/gum/data.zip";
	private final static String FILEPATH = "/sdcard/.mpgas/gum/";
	
	private Context mContext = null;
	private SQLiteDatabase mSqliteDatabase = null;

	private String mUserId = "";
	private String mDeviceNumber = "";
	
	private String mJobYm = "";
	private String mTurn = "";
	private String mCreateDt = "";
	
	private String mCommand = "";
	private String mInstruction = "";
	private String mParam = "";
	
	private int mJobType = 0;
	
	public CallTrans( Context ctx, String serverIp, String serverPort, String userId, String deviceNumber ) {
		this.mContext = ctx;
		this.mSqliteDatabase = AppContext.getSQLiteDatabase();
		this.mUserId = userId;
		this.mDeviceNumber = deviceNumber;
		this.SERVER_IP = serverIp;
		this.SERVER_PORT = serverPort;
	}

	//	gum_create_dt_down	DOWN|/DATA/GUM/DN/(YYYYMMDD)/DN_GUM_(기기번호)_hhmmss.ZIP|작업년월|차수|기기번호
	//	gum_down DOWN|/DATA/GUM/DN/(YYYYMMDD)/DN_GUM_(기기번호)_hhmmss.ZIP|작업년월|차수|생성일자|기기번호
	//	gum_up UP|/DATA/GUM/UP/(YYYYMMDD)/UP_GUM_(기기번호)_hhmmss.ZIP|작업년월|차수|생성일자|기기번호	

	public void setParam( String jobYm, String turn, String createDt ) {
		this.mJobYm = jobYm;
		this.mTurn = turn;
		this.mCreateDt = createDt;
	}
	
	public void callTrans(int jobType, String jobYm, String turn, String createDt) {
		this.mJobType = jobType;
		switch( jobType ) {
		case JOB_GUM_CREATE_DT_DOWN:
			callGumCreateDtDown( jobYm, turn );
			break;
		case JOB_GUM_DOWN:
			callGumDown( jobYm, turn, createDt );
			break;
		case JOB_GUM_UP:
			callGumUpload( jobYm, turn, createDt );
			break;
		}
	}
	
	private void callGumCreateDtDown( String jobYm, String turn ) {
		
		//	gum_create_dt_down	DOWN|/DATA/GUM/DN/(YYYYMMDD)/DN_GUM_(기기번호)_hhmmss.ZIP|작업년월|차수|기기번호
		String format = "DOWN|/DATA/GUM/DN/%s/DN_GUM_%s_%s.ZIP|%s|%s|%s";

		setParam( jobYm, turn, "" );
		this.mCommand = "C";
		this.mInstruction = "gum_create_dt_down";
		this.mParam = String.format(format, 
				DateString.getTodayYMD(),
				mDeviceNumber,
				DateString.getTodayHMS(),
				mJobYm,
				mTurn,
				mDeviceNumber );

		DLog.d( this.mParam );
		
		callTrans();
				
	}
	
	private void callGumDown( String jobYm, String turn, String createDt ) {
		
		//	gum_down DOWN|/DATA/GUM/DN/(YYYYMMDD)/DN_GUM_(기기번호)_hhmmss.ZIP|작업년월|차수|생성일자|기기번호
		String format = "DOWN|/DATA/GUM/DN/%s/DN_GUM_%s_%s.ZIP|%s|%s|%s|%s";

		setParam( jobYm, turn, createDt );
		this.mCommand = "C";
		this.mInstruction = "gum_down";
		this.mParam = String.format(format, 
				DateString.getTodayYMD(),
				mDeviceNumber,
				DateString.getTodayHMS(),
				mJobYm,
				mTurn,
				mCreateDt,
				mDeviceNumber );
		
		DLog.d( this.mParam );
		
		callTrans();
	}

	private void callGumUpload( String jobYm, String turn, String createDt ) {
		//	gum_up UP|/DATA/GUM/UP/(YYYYMMDD)/UP_GUM_(기기번호)_hhmmss.ZIP|작업년월|차수|생성일자|기기번호	
		String format = "UP|/DATA/GUM/UP/%s/UP_GUM_%s_%s.ZIP|%s|%s|%s|%s";

		setParam( jobYm, turn, createDt );
		this.mCommand = "C";
		this.mInstruction = "gum_up";
		this.mParam = String.format(format, 
				DateString.getTodayYMD(),
				mDeviceNumber,
				DateString.getTodayHMS(),
				mJobYm,
				mTurn,
				mCreateDt,
				mDeviceNumber );
		
		DLog.d( this.mParam );

		callExport();
	}

    // interface
	//public void onFinished(boolean result, String resultMessage);

	public interface onFinished {
		void onFinished(int jobType, boolean result, String resultMessage);
		void preExcute(int jobType);
		void postExcute(int jobType);
	}

	private onFinished callbackOnFinished = null;

	public void setOnFinished(onFinished callback) {
		this.callbackOnFinished = callback;
	}

	// eWire
	
	private void callTrans() {
		
		// eWire
		eWireTrans ewireTrans = new eWireTrans( mContext ){

			@Override
			public void onFinished(boolean result, String resultMessage) {
				if( result ) {
					// 다운의 경우 import 실행
					if( mJobType == JOB_GUM_UP ) {
						if( callbackOnFinished != null ) {
							callbackOnFinished.onFinished( mJobType, result, resultMessage );
						}
					} else {
						callImport();
					}
				} else {
					if( callbackOnFinished != null ) {
						callbackOnFinished.onFinished( mJobType, result, resultMessage );
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
		if( mJobType == JOB_GUM_CREATE_DT_DOWN ) {
			ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_WAIT);
			ewireTrans.setShowStatusBar(true);
		} else {
			ewireTrans.setDialogType(eWireTrans.DIALOGTYPE_PROGRESS);
			ewireTrans.setShowStatusBar(false);
		}
		ewireTrans.setDisplayMessage(eWireTrans.DEFAULT_DISPLAYMESSAGE);
		ewireTrans.setShowError(true);
		
		if( mJobType == JOB_GUM_UP ) {
			// 업로드의 경우 
			ewireTrans.setSoundPlay(true);
		} else {
			ewireTrans.setSoundPlay(false);
		}
		
		// eWire Thread
		ewireTrans.excuteTrans();
	}
	
	private void callImport() {
		
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
					callbackOnFinished.onFinished( mJobType, result, resultMessage );
				} 

			}

			@Override
			public void preExcute() {
				if( callbackOnFinished != null ) {
					callbackOnFinished.preExcute( mJobType );
				} 
			}

			@Override
			public void postExcute() {
				if( callbackOnFinished != null ) {
					callbackOnFinished.postExcute( mJobType );
				} 
			}
			
		};
		ewireData.setDatabase( mSqliteDatabase );
		ewireData.setZipfilename( ZIPFILENAME );
		ewireData.setOutputFolder( FILEPATH );
		Object[] databasespecication = {
				new CodeSpec(),
				new GumCreateDtSpec(),
				new GumSpec(),
				new ProviderSpec(),
				new AreaCenterSpec(),
		};
		ewireData.setDatabaseSpecication(databasespecication);
		
		// option
		//ewireData.setDialogType(eWireData.DIALOGTYPE_NONE);
		//ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
		//ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT_PROGRESS);
		if( mJobType == JOB_GUM_CREATE_DT_DOWN ) {
			ewireData.setDialogType(eWireTrans.DIALOGTYPE_WAIT);
			ewireData.setShowStatusBar(true);
			ewireData.setSoundPlay(false);
		} else {
			ewireData.setDialogType(eWireData.DIALOGTYPE_PROGRESS);
			ewireData.setShowStatusBar(false);
			ewireData.setSoundPlay(true);
		}
		ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
		ewireData.setShowError(true);
		
		if( Constants.DEBUG ) {
			ewireData.setDeleteAfterImport(false);
		}
		
		
		// do thread
		ewireData.excuteImport();
	}
	
	private void callExport() {
		
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

				if( result ) {
					callTrans();
				} else {
					if( callbackOnFinished != null ) {
						callbackOnFinished.onFinished( mJobType, result, resultMessage );
					}
				}

			}

			@Override
			public void preExcute() {
				if( callbackOnFinished != null ) {
					callbackOnFinished.preExcute( mJobType );
				} 
			}

			@Override
			public void postExcute() {
				if( callbackOnFinished != null ) {
					callbackOnFinished.postExcute( mJobType );
				} 
			}
			
		};
		ewireData.setDatabase( mSqliteDatabase );
		ewireData.setZipfilename( ZIPFILENAME );
		ewireData.setOutputFolder( FILEPATH );
		Object[] databasespecication = {
				new GumResultSpec(),
				new GumCustSpec(),
		};
		ewireData.setDatabaseSpecication(databasespecication);
		
		// option
		//ewireData.setDialogType(eWireData.DIALOGTYPE_NONE);
		ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT);
		//ewireData.setDialogType(eWireData.DIALOGTYPE_WAIT_PROGRESS);
		//ewireData.setDialogType(eWireData.DIALOGTYPE_PROGRESS);
		ewireData.setShowStatusBar(true);
		ewireData.setDisplayMessage(eWireData.DEFAULT_DISPLAYMESSAGE);
		ewireData.setShowError(true);
		
		// do thread
		ewireData.excuteExport();
		
	}
	
	
	
}
