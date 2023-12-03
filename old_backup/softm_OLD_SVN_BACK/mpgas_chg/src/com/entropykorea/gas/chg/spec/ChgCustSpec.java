package com.entropykorea.gas.chg.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class ChgCustSpec extends BaseSpec {

	private String fileName = "chg_cust.dat";
	private String tableName = "CHG_CUST";
	private FieldSpec[] fieldSpecs = {
	        new FieldSpec("GM_CHG_YM"           ,   6  , true , false),
	        new FieldSpec("HOUSE_NO"            ,   13 , true , false),
	        new FieldSpec("CUST_NO"             ,   10 , true , false),
	        new FieldSpec("CUST_NM"             ,   50 , false, false),
	        new FieldSpec("TEL_NO"              ,   30 , false, false),
	        new FieldSpec("WORK_TEL_NO"         ,   30 , false, false),
	        new FieldSpec("HP_NO"               ,   30 , false, false),
	        new FieldSpec("TEL_CD"              ,   20 , false, false),
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
