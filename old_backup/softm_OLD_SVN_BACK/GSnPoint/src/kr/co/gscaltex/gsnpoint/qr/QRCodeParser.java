package kr.co.gscaltex.gsnpoint.qr;

import java.io.StringReader;
import java.util.HashMap;

import org.xmlpull.v1.XmlPullParser;
import org.xmlpull.v1.XmlPullParserFactory;

import android.util.Log;

public class QRCodeParser {
	public static final String KEY_F_NM = "f_nm";
	public static final String KEY_ADDR = "addr";
	public static final String KEY_TTL = "ttl";
	public static final String KEY_TEL = "tel";
	public static final String KEY_P_DT = "p_dt";
	public static final String KEY_CNTT = "cntt";
	public static final String KEY_NULL = "null";

	public static HashMap<String, String> getList(String result) {
		HashMap<String, String> results = new HashMap<String, String>();
		result = result.trim();
		result = result.replace("&", ";");
		result = result.replace("\\", "");

		try {
			XmlPullParserFactory factory = XmlPullParserFactory.newInstance();
			factory.setNamespaceAware(true);
			XmlPullParser parser = factory.newPullParser();
			parser.setInput(new StringReader(result));
			int eventType = parser.getEventType();

			int index;
			int[] depth = new int[10];
			String[] name = new String[10];

			while (eventType != XmlPullParser.END_DOCUMENT) {
				if (eventType == XmlPullParser.START_DOCUMENT) {
				}
				else if (eventType == XmlPullParser.START_TAG) {
					index = parser.getDepth();
					depth[index] = 1;
					name[index] = parser.getName();
				}
				else if (eventType == XmlPullParser.END_TAG) {
					index = parser.getDepth();
					depth[index] = 0;
					name[index] = null;
				}
				else if (eventType == XmlPullParser.TEXT) {
					if (!parser.isWhitespace()) {
						index = parser.getDepth();
						String text = parser.getText();
						//Debug.trace(Log.DEBUG, "	name = "+name[index]+", text = "+text);

						if (name[index] == null) {
							results.put("null", result);
							break;
						}
						else {
							results.put(name[index], text);
						}
					}
				}

				eventType = parser.next(); 
			}
		}
		catch (Exception e) {
			//Debug.trace(Log.ERROR, e.toString());
			//results.add(result);
		}

		return results;
	}

}
