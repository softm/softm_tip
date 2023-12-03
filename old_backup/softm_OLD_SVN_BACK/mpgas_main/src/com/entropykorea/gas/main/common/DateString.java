package com.entropykorea.gas.main.common;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import java.util.Locale;

public class DateString {
	public String mDateString;
	
	private Calendar mCalendar = null;
	private int mYear, mMonth, mDate, mHour, mMinute, mSecond;

	private static String mdatechar = "/";
	private static String mtimechar = ":";
	
	private static final String REGEX = "[^0-9]+";

	// CONSTANTS
	public static final int TYPE_DATE = 0;
	public static final int TYPE_TIME = 1;
	public static final int TYPE_DATETIME = 2;

	private int mTypeDateTime = 0;
	private Boolean mOk = false;

	public DateString() {
		_DateString( null, TYPE_DATETIME );
	}

	public DateString(String str) {
		_DateString( str, TYPE_DATETIME );
	}

	public DateString(String str, int settype) {
		_DateString( str, settype );
	}
	
	private void _DateString(String str, int settype) {
		if (str == null || str.length() == 0) {
			this.mDateString = new String();
		} else {
			// 숫자만 남기고 모두 제거
			this.mDateString = str.replaceAll(REGEX,"");
		}

		this.mTypeDateTime = settype;

		setToday();

		switch (settype) {
		case 0:
			parseDate(this.mDateString);
			break;
		case 1:
			parseTime(this.mDateString);
			break;
		default:
			parseDateTime(this.mDateString);
			break;
		}

	}

	private Boolean parseDate(String str) {
		String temp = str.replaceAll(REGEX,"");
		int strlength = temp.length();
		
		int y,m,d;

		if (strlength < 4)
			return false;

		y = Integer.parseInt(temp.substring(0, 4));
		year( y );
		
		if (strlength < 6)
			return true;

		m = Integer.parseInt(temp.substring(4, 6));
		month( m );
		
		if (strlength < 8)
			return true;

		d = Integer.parseInt(temp.substring(6, 8));
		date( d );
		
		return true;
	}

	private Boolean parseTime(String str) {
		String temp = str.replaceAll(REGEX,"");;
		int strlength = temp.length();
		
		int h,m,s;

		if (strlength < 2)
			return false;

		h = Integer.parseInt(temp.substring(0, 2));
		hour( h );

		if (strlength < 4)
			return true;

		m = Integer.parseInt(temp.substring(2, 4));
		minute( m );

		if (strlength < 6)
			return true;

		s = Integer.parseInt(temp.substring(4, 6));
		second( s );

		return true;
	}

	private Boolean parseDateTime(String str) {
		String temp = str.replaceAll(REGEX,"");
		int strlength = temp.length();

		if (strlength < 8) {
			return parseDate(temp);
		}

		parseDate(temp.substring(0, 8));
		return parseTime(temp.substring(8, strlength));
	}

	public void setToday() {
		mCalendar = new GregorianCalendar();
		parseCalendar();
	}
	
	private void parseCalendar() {
		mYear = mCalendar.get(Calendar.YEAR);
		mMonth = mCalendar.get(Calendar.MONTH) + 1;
		mDate = mCalendar.get(Calendar.DAY_OF_MONTH);
		mHour = mCalendar.get(Calendar.HOUR_OF_DAY);
		mMinute = mCalendar.get(Calendar.MINUTE);
		mSecond = mCalendar.get(Calendar.SECOND);
	}

	public String getStringFmt() {
		String str = new String();
		
		//parseCalendar();

		String date = String.format("%04d%s%02d%s%02d", mYear, mdatechar,
				mMonth, mdatechar, mDate);
		String time = String.format("%02d%s%02d%s%02d", mHour, mtimechar,
				mMinute, mtimechar, mSecond);

		switch (mTypeDateTime) {
		case 0:
			str = date;
			break;
		case 1:
			str = time;
			break;
		default:
			str = date + " " + time;
			break;
		}

		return str;
	}

	public String getStringFmt(int length) {

		String str = getStringFmt();
		if (str.length() < length) {
			length = str.length();
		}
		return str.substring(0, length);
	}

	public String getString() {

		String str = new String();
		
		//parseCalendar();

		String date = String.format("%04d%02d%02d", mYear, mMonth, mDate);
		String time = String.format("%02d%02d%02d", mHour, mMinute, mSecond);
		switch (mTypeDateTime) {
		case 0:
			str = date;
			break;
		case 1:
			str = time;
			break;
		default:
			str = date + time;
			break;
		}

		return str;
	}

	public String getString(int length) {

		String str = getString();
		if (str.length() < length) {
			length = str.length();
		}
		return str.substring(0, length);
	}

	// mYear, mMonth, mDay, mHour, mMinute, mSecond;
	public void add(int field, int value) {
		mCalendar.add(field, value);
		parseCalendar();
	}
	
	public int year() {
		return mYear;
	}

	public void year(int year) {
		mCalendar.set(Calendar.YEAR, year);
		mYear = mCalendar.get(Calendar.YEAR);
	}
	
	public int month() {
		return mMonth;
	}

	public void month(int month) {
		mCalendar.set(Calendar.MONTH, month-1);
		mMonth = mCalendar.get(Calendar.MONTH)+1;
	}

	public int date() {
		return mDate;
	}

	public void date(int day) {
		mCalendar.set(Calendar.DATE, day);
		mMonth = mCalendar.get(Calendar.DATE);
	}
	
	public int hour() {
		return mHour;
	}

	public void hour(int hour) {
		mCalendar.set(Calendar.HOUR, hour);
		mHour = mCalendar.get(Calendar.HOUR);
	}

	public int minute() {
		return mMinute;
	}

	public void minute(int minute) {
		mCalendar.set(Calendar.MINUTE, minute);
		mMinute = mCalendar.get(Calendar.MINUTE);
	}

	public int second() {
		return mSecond;
	}

	public void second(int second) {
		mCalendar.set(Calendar.SECOND, second);
		mSecond = mCalendar.get(Calendar.SECOND);
	}
	
	public void setDateChar(String chr) {
		mdatechar = chr;
	}

	public void setTimeChar(String chr) {
		mtimechar = chr;
	}
	
	// util

	public static String getToday() {
		Calendar cal = new GregorianCalendar();

		int Year = cal.get(Calendar.YEAR);
		int Month = cal.get(Calendar.MONTH) + 1;
		int Day = cal.get(Calendar.DAY_OF_MONTH);
		int Hour = cal.get(Calendar.HOUR_OF_DAY);
		int Minute = cal.get(Calendar.MINUTE);
		int Second = cal.get(Calendar.SECOND);

		String today = String.format("%04d%02d%02d%02d%02d%02d", Year, Month,
				Day, Hour, Minute, Second);

		return today;
	}

	public static String getTodayYMD() {
		Calendar cal = new GregorianCalendar();

		int Year = cal.get(Calendar.YEAR);
		int Month = cal.get(Calendar.MONTH) + 1;
		int Day = cal.get(Calendar.DAY_OF_MONTH);

		String today = String.format("%04d%02d%02d", Year, Month, Day);

		return today;
	}

	public static String getTodayHMS() {
		Calendar cal = new GregorianCalendar();

		int Hour = cal.get(Calendar.HOUR_OF_DAY);
		int Minute = cal.get(Calendar.MINUTE);
		int Second = cal.get(Calendar.SECOND);

		String today = String.format("%02d%02d%02d", Hour, Minute, Second);

		return today;
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

	/**
	 * YYYYMMDD -> YYYY/MM/DD
	 * 
	 * @param str
	 *            8 6
	 * @return "0000/00/00"
	 * @return "0000/00"
	 */
	public static String makeDateString(String str) {
		String reDate = "";

		if (str == null)
			return "";

		if (str.trim().length() < 6)
			return reDate;

		if (str.trim().length() >= 6)
			reDate = substring(str.trim(), 0, 4) + mdatechar
					+ substring(str.trim(), 4, 6);

		if (str.trim().length() >= 8)
			reDate += (mdatechar + substring(str.trim(), 6, 8));

		return reDate;
	}

	/**
	 * HHMMSS -> HH:MM:SS
	 * 
	 * @param str
	 *            6 4
	 * @return "00:00:00"
	 * @return "00:00"
	 */
	public static String makeTimeString(String str) {
		String reDate = "";

		if (str == null)
			return "";

		if (str.trim().length() < 4)
			return str;

		if (str.trim().length() >= 4)
			reDate = substring(str.trim(), 0, 2) + mtimechar
					+ substring(str.trim(), 2, 4);

		if (str.trim().length() >= 6)
			reDate += (mtimechar + substring(str.trim(), 4, 6));

		return reDate;
	}

	/**
	 * YYYYMMDDHHMMSS -> YYYY/MM/DD HH:MM:SS
	 * 
	 * @param str
	 *            14 12
	 * @return "0000/00/00 00:00:00"
	 * @return "0000/00/00 00:00"
	 */
	public static String makeDateTimeString(String str) {
		String reDate = "";

		if (str == null)
			return "";

		if (str.trim().length() < 12)
			return "";

		reDate = makeDateString(substring(str.trim(), 0, 8));
		reDate += " ";
		reDate += makeTimeString(substring(str.trim(), 8, str.trim().length()));

		return reDate;
	}

	/**
	 * Long(String) -> yyyyMMddHHmmss
	 * 
	 * @param str
	 * @return
	 */
	public static String convertDateFromLongString(String str) {
		SimpleDateFormat formatter = new SimpleDateFormat("yyyyMMddHHmmss",
				Locale.KOREA);
		long value = 0;
		Date date;

		try {
			value = Long.parseLong(str);
			date = new Date(value);
		} catch (NumberFormatException e) {
			e.printStackTrace();
			date = new Date();
		}

		return formatter.format(date);
	}

	public static int compareToday(String ymd) {
		SimpleDateFormat dateFormat = new SimpleDateFormat("yyyyMMdd");

		Date date_today = new Date();

		String str_today = dateFormat.format(date_today).trim();

		return str_today.compareTo(ymd);
	}

}
