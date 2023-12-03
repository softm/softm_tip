package com.entropykorea.gas.chg.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class CodeSpec extends BaseSpec {

	private String fileName = "code.dat";
	private String tableName = "CODE";
	private FieldSpec[] fieldSpecs = {
		new FieldSpec("TYPE_CD",   20 , false, false),
		new FieldSpec("CD",        20 , false, false),
		new FieldSpec("CD_NM",     100, false, false),
		new FieldSpec("MGT_CHAR1", 20 , false, false),
		new FieldSpec("MGT_CHAR2", 20 , false, false),
		new FieldSpec("MGT_CHAR3", 20 , false, false),
		new FieldSpec("MGT_CHAR4", 20 , false, false),
		new FieldSpec("MGT_CHAR5", 20 , false, false),
		new FieldSpec("MGT_CHAR6", 20 , false, false),
		new FieldSpec("MGT_NUM1",  10 , false, false),
		new FieldSpec("MGT_NUM2",  10 , false, false),
		new FieldSpec("ORD",       10 , false, false),
		new FieldSpec("REMARK",    500, false, false),
	};
	
	public String whereClause = null;
	
	@Override
	public String getFileName() {
		return fileName;
	}
	
	@Override
	public String getTableName() {
		return tableName;
	}
	
	@Override
	public FieldSpec[] getFieldSpecs() {
		return fieldSpecs;
	}

	@Override
	public String getWhereClause() {
		return whereClause;
	}

	@Override
	public String getSelectClause() {
		// TODO Auto-generated method stub
		return null;
	}

}
