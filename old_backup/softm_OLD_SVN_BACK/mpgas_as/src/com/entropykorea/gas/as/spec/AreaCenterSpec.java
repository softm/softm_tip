package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;


public class AreaCenterSpec extends BaseSpec {

	private String fileName = "area_center.dat";
	private String tableName = "AREA_CENTER";
	private FieldSpec[] fieldSpecs = {
		new FieldSpec("AREA_CENTER_CD",      20 , true, false), // 고객센터코드(PK) 
		new FieldSpec("AREA_CENTER_NM",      100, false, false), // 고객센터명
		new FieldSpec("TEL_NO",			         30 , false, false), // 전화번호
	};
	
	public String whereClause = null;//"WHERE USER_ID = 'test'";
	
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
