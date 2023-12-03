package com.entropykorea.gas.gum.common;

import java.io.StringWriter;
import java.text.DecimalFormat;
import java.util.Properties;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

import javax.xml.transform.OutputKeys;
import javax.xml.transform.Transformer;
import javax.xml.transform.TransformerFactory;
import javax.xml.transform.dom.DOMSource;
import javax.xml.transform.stream.StreamResult;

import org.w3c.dom.Document;

import android.content.Context;
import android.content.pm.PackageManager;
import android.content.pm.PackageManager.NameNotFoundException;
import android.widget.Toast;

import com.entropykorea.ewire.dialog.LongTimeDialog;

public class Utils {
		
	/**
	 * 전화번호 검사 (2,3)-(3,4)-(4)
	 * @param phoneNumber
	 * @return
	 */
	public static boolean isPhoneNumber(String phoneNumber) {
		boolean returnValue = false;
		String regex = "(\\d{2,3})-(\\d{3,4})-(\\d{4})";
		Pattern p = Pattern.compile(regex);
		Matcher m = p.matcher(phoneNumber);
		if (m.matches()) {
			returnValue = true;
		}
		return returnValue;
	}
	
	/**
	 * 전화번호 검사 (3,4)-(4)
	 * @param phoneNumber
	 * @return
	 */
	public static boolean isPhoneNumber2(String phoneNumber) {
		boolean returnValue = false;
		String regex = "(\\d{3,4})-(\\d{4})";
		Pattern p = Pattern.compile(regex);
		Matcher m = p.matcher(phoneNumber);
		if (m.matches()) {
			returnValue = true;
		}
		return returnValue;
	}

	/**
	 * 두개의 문자열을 판단해서 " " 를 포함해서 합침
	 * @param first
	 * @param second
	 * @return
	 */
	public static String stringAppend(String first, String second) {
		String str = new String();
		
		str = first;
		if( first.length() > 0 && second.length() > 0 ) {
			str += " ";
		}
		str += second;
		return str;
	}

	public static String substring(String str, int s, int e) {

		if (str == null) {
			return "";
		} else {
			if (str.length() < s || s > e) {
				return "";
			} else {
				if (str.length() < e) {
					return str.substring(s);
				} else {
					return str.substring(s, e);
				}
			}
		}
	}

	public static String makeDateString(String str) {
		String reDate = new String();
		int len = str.length();

		if (len >= 4) {
			reDate += substring(str.trim(), 0, 4) + "년";
		}

		if (len >= 6) {
			reDate += substring(str.trim(), 4, 6) + "월";
		}

		if (len >= 8) {
			reDate += substring(str.trim(), 6, 8) + "일";
		}

		return reDate;
	}

	public static String getCommaString(String s) {
		String result = new String();
		Integer num = 0;

		try {
			num = Integer.parseInt(s);
			DecimalFormat df = new DecimalFormat("###,###");
			result = df.format(num);
		} catch (NumberFormatException e) {
			result = "";
		}

		return result;
	}

	public static String maskingString(String str) {
		String reStr = "";
		int length = str.length();
		int masklength = length > 4 ? length - 4 : length;

		for (int i = 0; i < length; i++) {
			if (i < masklength) {
				reStr += "*";
			} else {
				reStr += str.charAt(i);
			}
		}

		return reStr;
	}

	public static int length(String str) {
		if (str == null)
			return 0;

		int length = str.length();

		for (int i = 0; i < str.length(); i++) {
			if (str.charAt(i) > 256)
				length++;
		}

		return length;
	}

	public static String makeFrontSpaceSting(String str, int len) {
		String result = new String();
		int strlen = length(str);

		if (strlen >= len)
			return str;

		for (int i = 0; i < (len - strlen); i++) {
			result += " ";
		}

		if (str != null)
			result += str;

		return result;
	}

	/**
	 * 2.1 에서는 정상작동하지 않음 Since: API Level 8
	 * 
	 * @param doc
	 * @return
	 */
	public static String documentToString(Document doc) {

		TransformerFactory trf = TransformerFactory.newInstance();
		String xmlStr = "";

		try {
			StringWriter sw = new StringWriter();
			Properties output = new Properties();

			output.setProperty(OutputKeys.INDENT, "yes");
			output.setProperty(OutputKeys.ENCODING, "UTF-8");

			Transformer transformer = trf.newTransformer();
			transformer.setOutputProperties(output);
			transformer.transform(new DOMSource(doc), new StreamResult(sw));
			xmlStr = sw.getBuffer().toString();
		} catch (Exception e) {
		}
		return xmlStr;
	}

	public static void testRun(Context ctx, String message) {

		new LongTimeDialog(ctx, message, true, ctx) {
			@Override
			public Boolean doBackground(Object obj) {
				try {
					Thread.sleep(2000);
				} catch (InterruptedException e) {
					e.printStackTrace();
					return false;
				}
				return true;
			}

			@Override
			public void doEndExecute(Object obj, Boolean result) {
				Toast.makeText((Context) obj, "DONE", Toast.LENGTH_LONG).show();
			}
		}.show();

	}

}
