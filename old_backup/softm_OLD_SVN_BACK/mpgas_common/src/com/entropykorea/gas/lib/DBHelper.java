package com.entropykorea.gas.lib;

import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteException;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;
/**
 * DBHelper
 * @author softm 
 */
public class DBHelper extends SQLiteOpenHelper{
	
	public SQLiteDatabase DB;
	public static String DBPath;
	public static String DBName = "";
	public static final int version = 61;
	public static int db_user_version = -1;
	public static Context currentContext;
	public static String TBL_CODE = "code"; // 공통코드
	public static final String TAG = "MPGAS";
	
	public DBHelper(Context context) {
		super(context, DBHelper.DBName, null, version);
		currentContext = context;
		try {
			DB = currentContext.openOrCreateDatabase(DBHelper.DBPath + DBHelper.DBName, SQLiteDatabase.OPEN_READWRITE, null);
			Cursor c = DB.rawQuery("pragma user_version", null);
	        if (c.moveToNext()) {
	        	db_user_version = c.getInt(0);
	        	Log.i(TAG,"db_user_version : " + db_user_version);
	        }
		} catch (Exception e) {
		} finally {
			DB.close();
		}
	}

	private boolean checkDbExists() {
		SQLiteDatabase checkDB = null;

		try {
			checkDB = SQLiteDatabase.openDatabase(DBHelper.DBPath + DBHelper.DBName, null,
					SQLiteDatabase.OPEN_READONLY);

		} catch (SQLiteException e) {

			// database does't exist yet.

		}

		if (checkDB != null) {

			checkDB.close();

		}

		return checkDB != null ? true : false;
	}

	@Override
	public void onCreate(SQLiteDatabase db) {
		// TODO Auto-generated method stub
		
	}

	@Override
	public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
		// TODO Auto-generated method stub
		
	}
}