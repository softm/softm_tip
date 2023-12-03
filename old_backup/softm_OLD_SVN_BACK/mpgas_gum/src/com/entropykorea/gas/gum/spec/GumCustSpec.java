package com.entropykorea.gas.gum.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;


public class GumCustSpec extends BaseSpec {

	private String fileName = "gum_cust.dat";
	private String tableName = "GUM_CUST";
	private FieldSpec[] fieldSpecs = {
		new FieldSpec("READ_IDX",            10 , true, false), // 검침인덱스(PK)
		new FieldSpec("BILL_YM",             6  , true, false), // 작업년월(PK)
		new FieldSpec("TURN",                10 , true, false), // 차수(PK)
		new FieldSpec("METER_CREATE_DT",     8  , true, false), // 검침생성일자(PK)
		new FieldSpec("HOUSE_NO",            13 , true, false), // 수용가번호(PK)
		new FieldSpec("CUST_NO",             10 , false, false), // 고객번호
		new FieldSpec("CUST_NM",             50 , false, false), // 성명
		new FieldSpec("TEL_NO",              30 , false, false), // 전화번호
		new FieldSpec("HP_NO",               30 , false, false), // 핸드폰번호
		new FieldSpec("WORK_TEL_NO",         30 , false, false), // 직장전화번호
		new FieldSpec("TEL_CD",              20 , false, false), // 주전화번호구분코드
	};
	
	public String whereClause = "WHERE READ_IDX IN (SELECT READ_IDX FROM GUM WHERE END_YN='Y' AND SEND_YN='N')";
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
