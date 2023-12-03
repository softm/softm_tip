package com.entropykorea.gas.gum.common;

import java.text.SimpleDateFormat;
import java.util.Calendar;

import android.util.Log;

import com.entropykorea.gas.gum.BuildConfig;


public class DLog {

	public static final String TAG = "MPGAS";
	
	public DLog() {
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
			if( BuildConfig.DEBUG ) {
				Log.d(TAG, getNow() + ' ' + str );
			}
			break;
		case Log.ERROR:
			Log.e(TAG, getNow() + ' ' + str );
			break;
		case Log.WARN:
			Log.w(TAG, getNow() + ' ' + str );
			break;
		case Log.INFO:
			Log.i(TAG, getNow() + ' ' + str );
			break;
		}
	}
	
	public static void d( String str ) {
		show( str, Log.DEBUG );
	}
	
	public static void d( String...strings ) {
		String str = "";
		for( String string : strings ) {
			str += string;
			str += " ";
		}
		show( str, Log.DEBUG );
	}
	
	public static void e( String str ) {
		show( str, Log.ERROR );
	}

	public static void e( String...strings ) {
		String str = "";
		for( String string : strings ) {
			str += string;
			str += " ";
		}
		show( str, Log.ERROR );
	}

	public static void i( String str ) {
		show( str, Log.INFO );
	}
	
	public static void i( String...strings ) {
		String str = "";
		for( String string : strings ) {
			str += string;
			str += " ";
		}
		show( str, Log.INFO );
	}

	public static void w( String str ) {
		show( str, Log.WARN );
	}

	public static void w( String...strings ) {
		String str = "";
		for( String string : strings ) {
			str += string;
			str += " ";
		}
		show( str, Log.WARN );
	}

}
