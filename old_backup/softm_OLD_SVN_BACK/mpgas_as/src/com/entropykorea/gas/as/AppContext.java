package com.entropykorea.gas.as;

import android.content.Context;
import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.database.SqliteManager;

public class AppContext {

	public static Context getContext() {
		return SharedApplication.mInstance;
	}

	public static SQLiteDatabase getSQLiteDatabase() {
		return SharedApplication.mInstance.mSqliteDatabase;
	}

	public static SqliteManager getSqliteManager() {
		return SharedApplication.mInstance.mSqliteManager;
	}
}
