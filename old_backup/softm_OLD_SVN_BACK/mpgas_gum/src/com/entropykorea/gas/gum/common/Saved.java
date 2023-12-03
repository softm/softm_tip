package com.entropykorea.gas.gum.common;

import java.util.HashMap;

public class Saved {
	
	HashMap<String,Object> mData = null;
	
	public Saved() {
		mData = new HashMap<String,Object>();
	}

	public Object put(String key, Object value) {
		mData.put(key, value);
		return value;
	}
	
	public Object get(String key) {
		return mData.get(key);
	}
	
	public boolean equals(String key, Object value) {
		Object object = mData.get( key );
		
		if( object == null ) {
			return true;
		}
			
		if( object.equals(value) ) {
			return true;
		} 
		return false;
	}

}
