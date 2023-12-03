package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class MinFeeSpec extends BaseSpec {
  
  private String fileName = "min_fee.dat";
  private String tableName = "MIN_FEE";
  private FieldSpec[] fieldSpecs = { 
  new FieldSpec("AREA_CD         ",1   ,false,false),//지역코드(PK)
  new FieldSpec("ITEM_CD         ",20  ,false,false),//물품코드(PK)
  new FieldSpec("ITEM_NM         ",100 ,false,false),//물품명
  new FieldSpec("PROC_UNIT_PRICE ",10  ,false,false),//처리단가
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
