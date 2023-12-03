package com.entropykorea.gas.main;

import java.io.File;
import java.util.HashMap;

import android.content.res.Configuration;
import android.database.sqlite.SQLiteDatabase;
import android.os.Handler;
import android.util.Log;

import com.entropykorea.ewire.database.SqliteManager;
import com.entropykorea.gas.lib.DefaultApplication;
import com.entropykorea.gas.main.common.Constants;
import com.entropykorea.gas.main.database.Var;

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

		// create directory 
		try {
			File f = new File( Constants.root_path );
			if( !f.isDirectory() )
				f.mkdirs();
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		// 전역변수 생성
		Var var = new Var();
		mStorage.put("VAR", var);
		
		super.onCreate();
	}

	@Override
	public void onConfigurationChanged(Configuration newConfig) {
		// Log.i(TAG, "Application:ConfigurationChanged");
		super.onConfigurationChanged(newConfig);
	}

	@Override
	public void onTerminate() {
		Log.i(TAG, "Application:Terminate ############################");
		mSqliteManager.close();

		super.onTerminate();
	}

	public void saveObject(String key, Object value) {
		mStorage.put(key, value);
	}

	public Object loadObject(String key) {
		return mStorage.get(key);
	}

	public Object removeObject(String key) {
		return mStorage.remove(key);
	}
	
//	private void openDatabase() {
//		
//		//mSqliteDatabase = getDatabase();
//
//		if (mSqliteManager == null) {
//			mSqliteManager = new SqliteManager(getBaseContext(),
//					mSqliteDatabase);
//			mSqliteManager.open( "/sdcard/mpgas/gum/gum.db" );
//		}
//
//		if (mSqliteManager.getVersion() == 0) {
//			mSqliteManager.importSql(R.raw.createtable);
//		}
//	}

	@Override
	protected void onInitDataBase() {

		mSqliteDatabase = getDatabase();

		if (mSqliteManager == null) {
			mSqliteManager = new SqliteManager(getBaseContext(),
					mSqliteDatabase);
		}

		if (mSqliteManager.getVersion() == 0) {
			mSqliteManager.importSql(R.raw.createtable);
		}

		// run at MainActivity
		// else if( dbManager.isVersionDiff( DBUSERVERSION ) ) {
		//
		// new LongTimeDialog( getApplicationContext(),
		// "데이타 업그레이드 중입니다.\n잠시만 기다리십시요.", true ) {
		//
		// @Override
		// public Boolean doBackground() {
		// // upgrade
		// if( !dbManager.upgradeTables( R.raw.createtable ) ) {
		// return false;
		// }
		// return true;
		// }
		//
		// @Override
		// public void doEndExecute(Boolean result) {
		// if( result ) {
		//
		// } else {
		// //alert( "데이타 업그레이드 실패입니다." );
		// }
		//
		// }
		// }.show();
		// }
	}

}
