package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;


public class ProviderSpec extends BaseSpec {

	private String fileName = "provider.dat";
	private String tableName = "PROVIDER";
	private FieldSpec[] fieldSpecs = {
		new FieldSpec("CO_NM",               100, false, false), // 공급자명
		new FieldSpec("CEO_NM",              50, false, false), // 대표자명
		new FieldSpec("CO_NO",               20, false, false), // 사업자번호
		new FieldSpec("ADDR",                255, false, false), // 주소
		new FieldSpec("ROAD_ADDR1",          255, false, false), // 도로명주소1
		new FieldSpec("ROAD_ADDR2",          255, false, false), // 도로명주소2
		new FieldSpec("TEL_NO",              30, false, false), // 전화번호
		new FieldSpec("VAN_NO",              20, false, false), // 가맹점번호
		new FieldSpec("VAN_CARD_NO",		     20, false, false), // 신용카드VAN번호
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
