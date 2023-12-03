package com.entropykorea.gas.chg;

import java.util.HashMap;

import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;
import android.util.Log;

import com.entropykorea.ewire.database.SqliteManager;
import com.entropykorea.gas.lib.AppContext;
import com.entropykorea.gas.lib.Constant;
import com.entropykorea.gas.lib.DefaultApplication;
import com.entropykorea.gas.lib.Var;

public class WApplication extends DefaultApplication {

	public static final String TAG = "MPGAS";

	public static SQLiteDatabase mSqliteDatabase = null;
	public static SqliteManager mSqliteManager = null;
	public static WApplication mInstance = null;
	public Handler mHandler = new Handler();

	HashMap<String, Object> mStorage = new HashMap<String, Object>();
	
	@Override
	public void onCreate() {
		Log.i(TAG, "Application:Create ###############################");
		mInstance = this;
		super.onCreate();
	}

	@Override
	public void onTerminate() {
		Log.i(TAG, "Application:Terminate ############################");
		mSqliteManager.close();

		super.onTerminate();
	}

	@Override
	protected void onInitDataBase() {
		
		mSqliteDatabase = getDatabase();
		
		if( mSqliteManager == null ) {
			mSqliteManager = new SqliteManager( getBaseContext(), mSqliteDatabase );
		}

		if( mSqliteManager.getVersion() == 0 ) {
			mSqliteManager.importSql(R.raw.createtable);
		} 
		// 데이타 버전 1 의 경우 데이타 삭제 ( 버전 2 로 많은 변화 )
		// WApplication 에서 데이타 삭제 
		else if (mSqliteManager.getVersion() == 1) {
			mSqliteManager.importSql(R.raw.droptable);
			mSqliteManager.importSql(R.raw.createtable);
		}	
		
		// run at MainActivity 
		//		 else if( dbManager.isVersionDiff( DBUSERVERSION ) ) {
		//		 
		//			new LongTimeDialog( getApplicationContext(), "데이타 업그레이드 중입니다.\n잠시만 기다리십시요.", true ) {
		//				
		//				@Override
		//				public Boolean doBackground() {
		//					// upgrade
		//					if( !dbManager.upgradeTables( R.raw.createtable ) ) {
		//						return false;
		//	 				}
		//					return true;
		//				}
		//				
		//				@Override
		//				public void doEndExecute(Boolean result) {
		//					if( result ) {
		//						
		//					} else {
		//						//alert( "데이타 업그레이드 실패입니다." );
		//					}
		//					
		//				}
		//			}.show();
		//		}
	}
	
	public String getUserId() {
		Var var = AppContext.getValue("VAR");
		return var.USER_ID;
	}
	
	public String getMachineId() {
		Var var = AppContext.getValue("VAR");		
		return var.EQUIP_CD;
	}
	
	public String getBarCodeType() {
		Var var = AppContext.getValue("VAR");
//		return Constant.CODE_BARCODE_BLUETOOTH; // 블루투스타입
		return Constant.CODE_BARCODE_SELF; // 자체바코드
//		return "Y".equals(var.BARCD_EQUIP_USE_YN)?Constant.CODE_BARCODE_BLUETOOTH:Constant.CODE_BARCODE_SELF;
	}	
}



