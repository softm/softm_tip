package kr.co.loanoidop;

import java.net.NetworkInterface;
import java.util.Collections;
import java.util.List;

import org.apache.commons.lang3.StringEscapeUtils;
import org.apache.commons.lang3.StringUtils;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Intent;
import android.util.Log;
import android.webkit.WebView;

/**
 * WUtil
 * @author softm
 */
public class WUtil {
	final static int REQUEST_OZVIEW_OPEN = 0;

	/**
	 * WUtil.getMacAddress("wlan0")
	 * @param interfaceName
	 * @return
	 */
	public static String getMacAddress( String interfaceName ) {
		//String interfaceName = "wlan0";
		String macAddress = "";
        try {
            List<NetworkInterface> interfaces = Collections.list(NetworkInterface.getNetworkInterfaces());
            for (NetworkInterface intf : interfaces) {
                if (interfaceName != null) {
                    if (!intf.getName().equalsIgnoreCase(interfaceName)) continue;
                }
                byte[] mac = intf.getHardwareAddress();
                if (mac==null) return "";
                StringBuilder buf = new StringBuilder();
                for (int idx=0; idx<mac.length; idx++)
                    buf.append(String.format("%02X:", mac[idx]));
                if (buf.length()>0) buf.deleteCharAt(buf.length()-1);
                macAddress = buf.toString();
            }
        } catch (Exception ex) { } // for now eat exceptions
        return macAddress;
	}

	public static void openOZ(Activity context,String ozr, String params) {
	    Intent i = new Intent(context,OZViewerActivity.class); // ¸ÞÀÎ
	    	   i.putExtra("ozr", ozr);
	    	   i.putExtra("params", params);
	           i.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP | Intent.FLAG_ACTIVITY_SINGLE_TOP);
	    //context.startActivity(i);
	    context.startActivityForResult(i, REQUEST_OZVIEW_OPEN);
	}


	public static String toDefault(String v) {
		return StringUtils.isEmpty(v)?"":v;
	}

	@SuppressLint("NewApi")
	public static void webScript(WebView mWebView, String json) {
		//"{gubun:'LoanPic',result:'complete'}
		// ff("{aaa:\'test\',bbb:\'test\'}")
		String encFnJson = "callForNative(\"" + StringEscapeUtils.escapeEcmaScript(json) + "\")";
	    if (android.os.Build.VERSION.SDK_INT >= android.os.Build.VERSION_CODES.KITKAT) {

	    	mWebView.evaluateJavascript(encFnJson, null);
	    } else {
	    	mWebView.loadUrl("javascript:"+encFnJson);
	    }
		Log.d("webExec",encFnJson);
	}
}