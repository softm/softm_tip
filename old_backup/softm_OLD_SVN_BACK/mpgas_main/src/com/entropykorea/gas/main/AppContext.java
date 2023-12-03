package com.entropykorea.gas.main;

import android.content.Context;
import android.content.SharedPreferences;
import android.database.sqlite.SQLiteDatabase;

import com.entropykorea.ewire.database.SqliteManager;

public class AppContext {
	public static final String PREF_KEY = "MPGAS";

	public static Context getContext() {
		return WApplication.mInstance;
	}

	public static SQLiteDatabase getSQLiteDatabase() {
		return WApplication.mInstance.mSqliteDatabase;
	}

	public static SqliteManager getSqliteManager() {
		return WApplication.mInstance.mSqliteManager;
	}

	/* AppContext Storage: Data Transfer */
	public static void putValue(Class<?> cls, Object value) {
		String key = cls.getName();
		WApplication.mInstance.saveObject(key, value);
	}

	public static <T> T getValue(Class<?> cls) {
		String key = cls.getName();
		T t = (T) WApplication.mInstance.loadObject(key);
		return t;
	}

	// TO store key-values
	public static void putValue(String key, Object value) {
		WApplication.mInstance.saveObject(key, value);
	}

	public static <T> T getValue(String key) {
		T t = (T) WApplication.mInstance.loadObject(key);
		return t;
	}

	public static <T> T removeValue(Class<?> cls) {
		String key = cls.getName();
		T t = (T) WApplication.mInstance.removeObject(key);
		return t;
	}

	public static <T> T remove(String key) {
		T t = (T) WApplication.mInstance.removeObject(key);
		return t;
	}

	// Shared Preference
	public static SharedPreferences getAppPref() {
		SharedPreferences pref = getContext().getSharedPreferences(PREF_KEY, 0);
		return pref;
	}

	// To redirect to UI Thread
	public static void post(Runnable r) {
		WApplication.mInstance.mHandler.post(r);
	}

	public static void postDelayed(Runnable r, int millis) {
		WApplication.mInstance.mHandler.postDelayed(r, millis);
	}

	// // UI Conversion
	// public static int dp2px(float dp) {
	// return (int)(WApplication.mInstance.mDesity * dp);
	// }
	//
	// public static int getScreenWidth() {
	// return WApplication.mInstance.mDisplay.getWidth();
	// }
}
