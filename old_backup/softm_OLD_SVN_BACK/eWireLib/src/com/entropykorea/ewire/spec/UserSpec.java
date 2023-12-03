package com.entropykorea.ewire.spec;


public class UserSpec extends BaseSpec {

	private String fileName = "user.dat";
	private String tableName = "USER";
	private FieldSpec[] fieldSpecs = {
		new FieldSpec("USER_ID",        20,  true, false),    
		new FieldSpec("USER_NM",        50,  false, false),
		new FieldSpec("PW",      		20,  false, true),
		new FieldSpec("DEPT_CD",        20,  false, false),
		new FieldSpec("HP_NO",          30,  false, false),
		new FieldSpec("LEVEL_CD",       20,  false, false),
		new FieldSpec("PDA_USER_YN",    1 ,  false, false),
		new FieldSpec("AREA_CENTER_CD", 20,  false, false),
		new FieldSpec("GUM_AUTH_YN",    1 ,  false, false),
		new FieldSpec("CHG_AUTH_YN",    1 ,  false, false),
		new FieldSpec("CHK_AUTH_YN",    1 ,  false, false),
		new FieldSpec("REQ_AUTH_YN",    1 ,  false, false),
		new FieldSpec("DEF_AUTH_YN",	1 ,	 false, false),
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
