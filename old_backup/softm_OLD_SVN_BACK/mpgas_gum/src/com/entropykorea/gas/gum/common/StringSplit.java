package com.entropykorea.gas.gum.common;

public class StringSplit {
	String mString = null;
	String[] mSplit = null;

	protected void init() {
		mSplit = null;
	}

	public StringSplit() {
		init();
	}

	public StringSplit(String str) {
		init();
		split(str);
	}

	public StringSplit(String str, String token) {
		init();
		split(str,token);
	}
	
	public void split( String str ) {
		mString = str;
		if (str != null)
			mSplit = str.split("\\|");
	}

	public void split( String str, String token ) {
		mString = str;
		if (str != null)
			mSplit = str.split(token);
	}

	public int size() {
		if (mSplit == null)
			return 0;
		return mSplit.length;
	}
	
	public String get() {
		if( mString == null )
			return "";
		return mString;
	}

	public String get(int p) {
		if (mSplit == null)
			return "";
		if (p < 0 || p >= mSplit.length)
			return "";
		return mSplit[p];
	}
	
	public String getlast() {
		if (mSplit == null)
			return "";

		return mSplit[ mSplit.length - 1 ];
	}
}
