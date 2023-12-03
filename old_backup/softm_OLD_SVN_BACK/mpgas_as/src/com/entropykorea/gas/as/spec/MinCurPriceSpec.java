package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class MinCurPriceSpec extends BaseSpec {
  
  private String fileName = "min_cur_price.dat";
  private String tableName = "MIN_CUR_PRICE";
  
  private FieldSpec[] fieldSpecs = { 
  new FieldSpec("REQUIRE_IDX",10,true,false), //민원인덱스(PK)(FK)
  new FieldSpec("BF_METER",10,false,false),   //전월지침
  new FieldSpec("USE_AMOUNT",10,false,false), //사용량
  new FieldSpec("USE_PRICE",10,false,false),  //사용요금
  new FieldSpec("BASE_PRICE ",10,false,false), //기본요금
  new FieldSpec("PENALTY_PRICE ",10  ,false,false),//위약금
  new FieldSpec("UNSEAL_PRICE ",10  ,false,false),//봉인해제비용 
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
