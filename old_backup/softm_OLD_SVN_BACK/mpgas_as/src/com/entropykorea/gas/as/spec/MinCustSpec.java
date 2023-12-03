package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class MinCustSpec extends BaseSpec {
  
  private String fileName = "min_cust.dat";
  private String tableName = "MIN_CUST";
  
  private FieldSpec[] fieldSpecs = { 
  new FieldSpec("REQUIRE_IDX     ",10,true,false), //민원인덱스(PK)
  new FieldSpec("HOUSE_NO        ",13,true,false),//수용가번호(PK)
  new FieldSpec("FAKE_HOUSE_NO   ",10,true,false),//가수용가번호(PK)
  new FieldSpec("CUST_NO         ",10,true,false),//고객번호(PK)(FK)
  new FieldSpec("CUST_NM         ",50,false,false),//고객명
  new FieldSpec("TEL_NO          ",30,false,false),//전화번호
  new FieldSpec("WORK_TEL_NO     ",30,false,false),//직장전화번호
  new FieldSpec("HP_NO           ",30,false,false),//핸드폰번호
  new FieldSpec("TEL_CD          ",20,false,false),//주전화번호구분코드
  };
  
  public String whereClause = "WHERE REQUIRE_IDX IN (SELECT REQUIRE_IDX FROM MIN WHERE END_YN = 'Y' AND SEND_YN='N')";

  
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
