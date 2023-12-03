package com.entropykorea.gas.gum.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;


public class GumCreateDtSpec extends BaseSpec {

	private String fileName = "gum_create_dt.dat";
	private String tableName = "GUM_CREATE_DT";
	private FieldSpec[] fieldSpecs = {
		new FieldSpec("METER_CREATE_DT",               8, false, false), // 검침생성일자
	};
	
	public String whereClause = null;//"WHERE USER_ID = 'test'";
	public String selectClause = null;
	
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
		return selectClause;
	}

}
