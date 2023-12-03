package com.entropykorea.ewire.spec;



public class FieldSpec {

	public String name;
	public Integer length;
	public Boolean isKey;
	public Boolean isEncrypt;
	
	public FieldSpec( String name, Integer length, Boolean isKey, Boolean isEncrypt ) {
		this.name = name;
		this.length = length;
		this.isKey = isKey;
		this.isEncrypt = isEncrypt;
	}
}
