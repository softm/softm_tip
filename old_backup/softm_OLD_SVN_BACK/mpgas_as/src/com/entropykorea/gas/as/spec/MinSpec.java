package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class MinSpec extends BaseSpec {
  
  private String fileName = "min.dat";
  private String tableName = "MIN";
  private FieldSpec[] fieldSpecs = { 
      
  new FieldSpec("REQUIRE_IDX       ",10 ,true, false),
  new FieldSpec("REQUIRE_CD        ",20 ,false,false),
  new FieldSpec("HOUSE_NO          ",13 ,false,false),
  new FieldSpec("FAKE_HOUSE_NO     ",10 ,false,false),
  new FieldSpec("AREA_CD           ",1  ,false,false),
  new FieldSpec("SECTOR_CD         ",3  ,false,false),
  new FieldSpec("COMPLEX_CD        ",7  ,false,false),
  new FieldSpec("BLDG_CD           ",10 ,false,false),
  new FieldSpec("AREA_NM           ",50 ,false,false),
  new FieldSpec("SECTOR_NM         ",50 ,false,false),
  new FieldSpec("COMPLEX_NM        ",50 ,false,false),
  new FieldSpec("BLDG_NM           ",50 ,false,false),
  new FieldSpec("BLDG_NO           ",50 ,false,false),
  new FieldSpec("ROOM_NO           ",50 ,false,false),
  new FieldSpec("ROAD_NM           ",80 ,false,false),
  new FieldSpec("CO_NM             ",50 ,false,false),
  new FieldSpec("PURPOSE_CD        ",20 ,false,false),
  new FieldSpec("HOUSE_STATUS_CD   ",20 ,false,false),
  new FieldSpec("HOUSE_LIVING_CD   ",20 ,false,false),
  new FieldSpec("CUST_NO           ",10 ,false,false),
  new FieldSpec("CUST_NM           ",50 ,false,false),
  new FieldSpec("TEL_NO            ",30 ,false,false),
  new FieldSpec("WORK_TEL_NO       ",30 ,false,false),
  new FieldSpec("HP_NO             ",30 ,false,false),
  new FieldSpec("TEL_CD            ",20 ,false,false),
  new FieldSpec("GM_NO             ",20 ,false,false),
  new FieldSpec("ACCEPT_DT         ",19 ,false,false),
  new FieldSpec("REQUEST_REQUIRE_DT",8  ,false,false),
  new FieldSpec("REQUEST_BEGIN_DT  ",20 ,false,false),
  new FieldSpec("REQUEST_REMARK    ",500,false,false),
  new FieldSpec("PUSH_REQ_YN       ",1  ,false,false),
  new FieldSpec("VIR_ACC_NO_IBK    ",20 ,false,false),
  new FieldSpec("VIR_ACC_NO_NH     ",20 ,false,false),
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
