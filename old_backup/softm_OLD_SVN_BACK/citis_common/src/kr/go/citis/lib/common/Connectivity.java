package kr.go.citis.lib.common;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

/**
 * Connectivity
 * @author softm
 */
public class Connectivity {
	
	public static boolean isConnected(Context context) {

		ConnectivityManager manager = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
		NetworkInfo mobile = manager.getNetworkInfo(ConnectivityManager.TYPE_MOBILE);
		NetworkInfo wifi = manager.getNetworkInfo(ConnectivityManager.TYPE_WIFI);

		if ((mobile!=null && mobile.isConnected()) || (wifi!=null && wifi.isConnected())) {
			return true;
		} else {
		}

		return false;
	}

}
