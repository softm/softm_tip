package com.entropykorea.gas.gum.common;

import com.entropykorea.gas.gum.BuildConfig;

import android.os.Environment;

public class Constants {

	public Constants()
	{
		
	}

	//public static final boolean DEBUG 					= false; 
	public static final boolean DEBUG 					= BuildConfig.DEBUG; // > ADT r17  

	public static final String	LOG_TAG						= "MPGAS";  // LogCat의 tag Name
	
	public static String		root_path = Environment.getExternalStorageDirectory().getAbsolutePath()+"/.mpgas"; // /sdcard/.mpgas
	public static String		main_path = root_path+"/main"; // /sdcard/.mpgas/main

	
}
