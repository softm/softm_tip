package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class CodeSpec extends BaseSpec {
  
  private String fileName = "code.dat";
  private String tableName = "CODE";
  private FieldSpec[] fieldSpecs = { 
  new FieldSpec("TYPE_CD  ", 20, true, false), // 구분코드
  new FieldSpec("CD       ", 20, false, false),// 코드
  new FieldSpec("CD_NM    ", 100, false, false),// 코드명
  new FieldSpec("MGT_CHAR1", 20, false, false),// 관리문자1
  new FieldSpec("MGT_CHAR2", 20, false, false),// 관리문자2
  new FieldSpec("MGT_CHAR3", 20, false, false),// 관리문자3
  new FieldSpec("MGT_CHAR4", 20, false, false),// 관리문자4
  new FieldSpec("MGT_CHAR5", 20, false, false),// 관리문자5
  new FieldSpec("MGT_CHAR6", 20, false, false),// 관리문자6
  new FieldSpec("MGT_NUM1 ", 10, false, false),// 관리숫자1
  new FieldSpec("MGT_NUM2 ", 10, false, false),// 관리숫자2
  new FieldSpec("ORD      ", 10, false, false), // 정렬
  new FieldSpec("REMARK   ", 10, false, false), // 비고
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
