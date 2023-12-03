package com.entropykorea.ewire.util;

public class IntegerEx {
	private Integer value;
	
	public IntegerEx( Integer value )
	{
		this.value = value;
	}
	
	public Integer getValue()
	{
		return this.value;
	}
	

	public static Integer parseInt( String s )
	{
		Integer val = 0;
		
		String str = s.replaceAll("[^0-9]+","");
		
		try {
			val = Integer.parseInt(str);
		} catch (NumberFormatException e) {
			val = 0;
		}		

		return val;
	}
	
	public static String parseNumberString( String s )
	{
		return parseInt(s).toString();
	}
	


}
