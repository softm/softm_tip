package com.entropykorea.gas.main.common;

import android.os.Environment;

import com.entropykorea.gas.main.BuildConfig;

public class Constants {

	public Constants()
	{
		
	}

	//public static final boolean REALESE 					= true; // ip test/real 변경 (eWire,update)
	public static final boolean DEBUG 					= BuildConfig.DEBUG; // > ADT r17

	public static final String	LOG_TAG						= "MPGAS";  // LogCat의 tag Name

	// for eWire 
	public static final int		SERVER_CONNECTION_TIMEOUT	= 60000;	// 60 sec	
	public static final int		SERVER_READ_TIMEOUT			= 300000;	// 5 min			
	public static String 		Encoding					= "KSC5601";
	
	private static String 		eWireServerIP_T				= "110.8.124.30"; // eWire IP
	private static String		eWireServerPort_T			= "4000";	// eWire PORT
	
	private static String 		eWireServerIP_R				= "110.8.124.30"; //  eWire IP
	private static String		eWireServerPort_R			= "4000";	// eWire PORT
	
	public static String getEwireServerIp() {
		if( DEBUG ) {
			return eWireServerIP_T;
		}
		return eWireServerIP_R;
	}
	
	public static String getEwireServerPort() {
		if( DEBUG ) {
			return eWireServerPort_T;
		}
		return eWireServerPort_R;
	}

	public static String		root_path = Environment.getExternalStorageDirectory().getAbsolutePath()+"/.mpgas"; // /sdcard/mpgas
	public static String		main_path = root_path+"/main"; // /sdcard/mpgas/main

	private static String 		updateServerUrl_T			= "http://110.8.124.30:4001/mobile/setup.xml";
	private static String 		updateServerUrl_R			= "http://110.8.124.30:4001/mobile/setup.xml"; // for test
	
	public static String getUpdateServerUrl() {
		if( DEBUG ) {
			return updateServerUrl_T;
		}
		return updateServerUrl_R;
	}


}
