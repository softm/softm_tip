package kr.co.gscaltex.gsnpoint.qr;

import android.util.Log;

public class Debug {
	public static final String LogTag = "palmia";

	public static void trace(int style, String msg) {
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
}
