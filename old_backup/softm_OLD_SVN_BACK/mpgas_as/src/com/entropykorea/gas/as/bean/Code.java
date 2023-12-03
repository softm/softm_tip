package com.entropykorea.gas.as.bean;

public class Code {
  // ====== 민원 테이블 ======
  // 사용자 USER
  // 공통코드 CODE
  // 공급자 PROVIDER
  // 고객센터 AREA_CENTER
  // 민원 MIN
  // 민원고객정보수정 MIN_CUST
  // 민원수수료 MIN_FEE
  // 민원수수료수납 MIN_FEE_PAY
  // 미납요금 MIN_UNPAID_PRICE
  // 법적비용 MIN_LEGAL_FEE
  
  public String TYPE_CD = ""; // 구분코드(PK) VARCHAR2(20) NOT NULL 구분코드
  public String CD = ""; // 코드(PK) VARCHAR2(20) NOT NULL 코드
  public String CD_NM = ""; // 코드명 VARCHAR2(100) NOT NULL 코드명
  public String MGT_CHAR1 = ""; // 관리문자1 VARCHAR2(20) NULL 관리문자1
  public String MGT_CHAR2 = ""; // 관리문자2 VARCHAR2(20) NULL 관리문자2
  public String MGT_CHAR3 = ""; // 관리문자3 VARCHAR2(20) NULL 관리문자3
  public String MGT_CHAR4 = ""; // 관리문자4 VARCHAR2(20) NULL 관리문자4
  public String MGT_CHAR5 = ""; // 관리문자5 VARCHAR2(20) NULL 관리문자5
  public String MGT_CHAR6 = ""; // 관리문자6 VARCHAR2(20) NULL 관리문자6
  public String MGT_NUM1 = ""; // 관리숫자1 NUMBER NULL 관리숫자1
  public String MGT_NUM2 = ""; // 관리숫자2 NUMBER NULL 관리숫자2
  public String ORD = ""; // 정렬 INTEGER NULL 정렬
  public String REMARK = ""; // 비고 VARCHAR2(500) NULL 비고
}
