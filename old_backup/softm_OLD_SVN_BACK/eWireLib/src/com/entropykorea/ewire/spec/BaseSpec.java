package com.entropykorea.ewire.spec;



public abstract class BaseSpec {
	private FieldSpec[] fieldSpec = null;
	
	public Integer getTotalLength() {
		Integer totalLength = 0;
		
		fieldSpec = getFieldSpecs();
		for( FieldSpec field : fieldSpec ) {
			totalLength += field.length;
		}
				
		return totalLength;
	}

	public abstract String getFileName();
	public abstract String getTableName();
	public abstract FieldSpec[] getFieldSpecs();

	public abstract String getWhereClause();
	public abstract String getSelectClause();
	
	
}
