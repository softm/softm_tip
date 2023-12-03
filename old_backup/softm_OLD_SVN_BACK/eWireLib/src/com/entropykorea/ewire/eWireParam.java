package com.entropykorea.ewire;


public class eWireParam {
	
	private String mString = null;
	private String[] mSplit = null;
	
	public eWireParam(){
	}
	
	public eWireParam( String str ) {
		this.mString = str;
		split();
	}
	
	public void split( ) {
		if( this.mString != null )
			mSplit = this.mString.split("\\|");
		else
			mSplit = null;
	}
	
	public String get(){
		if( this.mString == null ) {
			return "";
		}
		return this.mString;
	}
	
	public String get( int p ){
		if( this.mSplit == null )
			return "";
		if( p < 0 || p >= this.mSplit.length )
			return "";
		return mSplit[p];
	}
	
	public int len() {
		if( this.mSplit == null )
			return 0;
		return this.mSplit.length;
	}
	
	public void add( String str ){
		if( len() != 0 )
			this.mString += "|";
		else
			this.mString = "";
		this.mString += str;
		split();
	}

}
