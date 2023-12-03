package com.entropykorea.gas.main.common;

import java.text.SimpleDateFormat;
import java.util.Calendar;

import android.util.Log;


public class DLog {

	public static final String TAG = "MPGAS";
	public static boolean show = true;
	
	public DLog() {
	}
	
	public DLog(boolean show) {
		this.show = show;
	}
	
	private static String getNow() {
		String current;
		Calendar calendar = Calendar.getInstance();
		SimpleDateFormat dateFormat = new SimpleDateFormat("yyyyMMddHHmmssSSS");
		current = dateFormat.format(calendar.getTime());
		return current;
	}
	
	private static void show( String str, int type ) {
		switch( type ) {
		case Log.DEBUG: 
			if( show ) {
				Log.d(TAG, getNow() + ' ' + str );
			}
			break;
		case Log.ERROR:
			Log.d(TAG, getNow() + ' ' + str );
			break;
		case Log.WARN:
			Log.w(TAG, getNow() + ' ' + str );
			break;
		case Log.INFO:
			Log.d(TAG, getNow() + ' ' + str );
			break;
		}
	}
	
	public static void d( String str ) {
		show( str, Log.DEBUG );
	}
	
	public static void e( String str ) {
		show( str, Log.ERROR );
	}

	public static void i( String str ) {
		show( str, Log.INFO );
	}
	
	public static void w( String str ) {
		show( str, Log.WARN );
	}

}
