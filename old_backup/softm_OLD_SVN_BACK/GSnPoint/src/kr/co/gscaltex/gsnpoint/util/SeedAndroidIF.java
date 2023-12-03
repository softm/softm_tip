package kr.co.gscaltex.gsnpoint.util;

import java.lang.reflect.Method;

import android.util.Base64;

public class SeedAndroidIF{

	/**
	 * 
	 * ��ȣȭ
	 * 
	 * @param text
	 * @param key
	 * @return
	 */
	public String encodeBase64(String text, String key) {
	    byte [] buf = null;
	    try {
	    	SeedX seed = new SeedX();	    	
	        Class Base64 = Class.forName("org.apache.commons.codec.binary.Base64");
	        Class[] parameterTypes = new Class[] { byte[].class };  
	        Method encodeBase64 = Base64.getMethod("encodeBase64", parameterTypes);
	        buf = (byte[])encodeBase64.invoke(Base64, seed.encrypt(text, key.getBytes(), "UTF-8"));
	    } catch (Exception e) {
	        e.printStackTrace();
	    }        
	    //return buf;
	    return new String(buf,0,buf.length);
	}
	
	/**
	 * 
	 * ��ȣȭ  ���ڵ�
	 * 
	 * @param text
	 * @param key
	 * @return
	 */
	public String decodeBase64(String text, String key) {
		String buf = "";		
	    try {
	    	SeedX seed = new SeedX();
	        Class Base64 = Class.forName("org.apache.commons.codec.binary.Base64");
	        Class[] parameterTypes = new Class[] { byte[].class };  
	        Method decodeBase64 = Base64.getMethod("decodeBase64", parameterTypes);
	        buf = seed.decryptAsString((byte[])decodeBase64.invoke(Base64,text.getBytes()), key.getBytes(), "UTF-8");
	        
	    } catch (Exception e) {
	        e.printStackTrace();
	    }        
	        
	    return buf;
	}
	
	public String decodeBase64(String text) throws IllegalArgumentException {	
		String buf="";
		try{
			buf = new String(Base64.decode(text,Base64.DEFAULT), "UTF-8");
		}catch (Exception e){
			e.printStackTrace();
		}
		return buf;
		//return new String(Base64.decode(text,Base64.DEFAULT), "UTF-8");
	}
}