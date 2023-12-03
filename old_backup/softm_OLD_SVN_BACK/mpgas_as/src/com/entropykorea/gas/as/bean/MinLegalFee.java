package com.entropykorea.gas.as.bean;

public class MinLegalFee {
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
  
  public int REQUIRE_IDX = 0; // (PK)(FK) 수용가번호(PK)(FK)
  public String LEGAL_JOB = ""; // 법적조치내용
  public String LEGAL_PRICE = ""; // 법적금액
}
