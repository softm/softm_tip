package com.entropykorea.gas.gum.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;


public class GumResultSpec extends BaseSpec {

	private String fileName = "gum_result.dat";
	private String tableName = "GUM";
	private FieldSpec[] fieldSpecs = {
		new FieldSpec("READ_IDX",            10 , true, false), // 검침인덱스(PK)
		new FieldSpec("BILL_YM",             6  , true, false), // 작업년월(PK)
		new FieldSpec("TURN",                10 , true, false), // 차수(PK)
		new FieldSpec("METER_CREATE_DT",     8  , true, false), // 검침생성일자(PK)
		new FieldSpec("HOUSE_NO",            13 , true, false), // 수용가번호(PK)
		new FieldSpec("METER_CD",            20 , false, false), // 당월검침코드
		new FieldSpec("METER",               10 , false, false), // 당월검침지침
		new FieldSpec("ADJ_METER",           10 , false, false), // 당월보정지침
		new FieldSpec("UN_ADJ_METER",        10 , false, false), // 당월비보정지침
		new FieldSpec("TEMPER",              10 , false, false), // 당월온도
		new FieldSpec("PRESSURE",            10 , false, false), // 당월압력
		new FieldSpec("REV_FACTOR",          10 , false, false), // 당월보정계수
		new FieldSpec("COMP_FACTOR",         10 , false, false), // 당월압축계수
		new FieldSpec("OIL_YN",              1  , false, false), // 당월오일이상유무
		new FieldSpec("BATTERY_YN",          1  , false, false), // 당월보정기배터리이상유무
		new FieldSpec("PDA_METER_ERR_YN",    1  , false, false), // 계량기이상유무
		new FieldSpec("METER_USER_CD",       20 , false, false), // 검침작업자
		new FieldSpec("METER_DT",            8  , false, false), // 당월검침일자
		new FieldSpec("METER_TIME",          6  , false, false), // 당월검침시간
	};
	
	public String whereClause = "WHERE END_YN='Y' AND SEND_YN='N'";
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
