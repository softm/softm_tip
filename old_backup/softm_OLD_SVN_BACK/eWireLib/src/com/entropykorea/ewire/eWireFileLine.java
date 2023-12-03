package com.entropykorea.ewire;

public class eWireFileLine extends eWireFile {
	
	private Integer lineLength = 0;
	
	public eWireFileLine() {
	}
	
	public void setFieldLengths( Integer fieldLength ) {
		
		this.lineLength = fieldLength;
		//this.lineLength += 2; // 0x0d 0x0a
		super.setFileReadLen(lineLength);
	}

	public boolean isReadBlock() {
		long fileLength = super.getFileLength();
		
		if( fileLength % lineLength != 0 ) {
			return false;
		}
		return true;
	}
	
	public int getRawCounts() {
		return super.getTotalReadBlock();
	}
	
}
