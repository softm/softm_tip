package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class MinFeePaySpec extends BaseSpec {
  
  private String fileName = "min_fee_pay.dat";
  private String tableName = "MIN_FEE_PAY";
  
  private FieldSpec[] fieldSpecs = { 
  new FieldSpec("REQUIRE_IDX     ",10,true,false), //민원인덱스(PK)(FK)
  new FieldSpec("AREA_CD         ",1, true,false), //지역코드(PK)
  new FieldSpec("ITEM_CD         ",20,true,false), //물품코드(PK)
  new FieldSpec("PROC_UNIT_PRICE ",10,false,false),//처리단가
  new FieldSpec("PROC_QTY        ",10,false,false),//처리수량
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
