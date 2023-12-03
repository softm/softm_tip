package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class MinUnpaidPriceSpec extends BaseSpec {
  
  private String fileName = "min_unpaid_price.dat";
  private String tableName = "MIN_UNPAID_PRICE";
  
  private FieldSpec[] fieldSpecs = { 
  new FieldSpec("REQUIRE_IDX",10,true,false), //민원인덱스(PK)(FK)
  new FieldSpec("CHE_MONTH  ",10,false,false),//미납월
  new FieldSpec("CHE_PRICE  ",10,false,false),//미납금액
  
  };
  
  public String whereClause = null;// "WHERE USER_ID = 'test'";
  
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
