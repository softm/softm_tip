package com.entropykorea.gas.as.bean;


public class User {
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
  
  public String USER_ID = ""; // 아이디(PK) VARCHAR2(20) NOT NULL 아이디
  public String USER_NM = ""; // 사용자명 VARCHAR2(50) NOT NULL 사용자명
  public String PW = ""; // 비밀번호 VARCHAR2(20) NOT NULL 비밀번호
  public String DEPT_CD = ""; // 부서코드(FK) VARCHAR2(20) NULL 부서코드
  public String HP_NO = ""; // 휴대전화번호 VARCHAR2(30) NULL 휴대전화번호
  public String LEVEL_CD = ""; // 관리레벨코드 VARCHAR2(20) NOT NULL 관리레벨코드(SY010)
  public String PDA_USER_YN = ""; // 현장지원사용자여부 CHAR(1) NOT NULL 현장지원사용자여부
  public String AREA_CENTER_CD = ""; // 고객센터코드(FK) VARCHAR2(20) NULL 고객센터코드
  public String GUM_AUTH_YN = ""; // 검침권한여부 CHAR(1) NOT NULL 검침권한여부
  public String CHG_AUTH_YN = ""; // 교체권한여부 CHAR(1) NOT NULL 교체권한여부
  public String CHK_AUTH_YN = ""; // 점검권한여부 CHAR(1) NOT NULL 점검권한여부
  public String REQ_AUTH_YN = ""; // 민원권한여부 CHAR(1) NOT NULL 민원권한여부
  public String DEF_AUTH_YN = ""; // 체납권한여부 CHAR(1) NOT NULL 채납권한여부
  
  //추가 
  public String EQUIP_CD =            "";
  public String BARCD_EQUIP_USE_YN =  "N";
  public String EWIRE_SERVER_IP =     "";
  public String EWIRE_SERVER_PORT =   "";
  public String UPDATE_SERVER_URL =   "";
}
