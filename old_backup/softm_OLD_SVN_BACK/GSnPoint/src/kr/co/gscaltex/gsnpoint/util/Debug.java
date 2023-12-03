package kr.co.gscaltex.gsnpoint.util;

import android.util.Log;

public class Debug {
	public static final String LogTag = "palmia";

	public static void trace(int style, String msg) {
		//return ;
		
		switch (style) {
			case Log.VERBOSE : {
				Log.v(LogTag, msg);
				break;
			}
			case Log.DEBUG : {
				Log.d(LogTag, msg);
				break;
			}
			case Log.INFO : {
				Log.i(LogTag, msg);
				break;
			}
			case Log.WARN : {
				Log.w(LogTag, msg);
				break;
			}
			case Log.ERROR : {
				Log.e(LogTag, msg);
				break;
			}			
		}
	}
	
	public static void trace(String tag, String msg) {
		Log.d(tag, msg);
	}
}
