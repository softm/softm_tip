package com.entropykorea.gas.as.bean;

public class MinFeePay {
  
  public String REQUIRE_IDX = ""; // 민원인덱스(PK)(FK) INTEGER NOT NULL 민원인덱스
  public String AREA_CD = ""; // 지역코드(PK) VARCHAR2(1) NOT NULL 지역코드
  public String ITEM_CD = ""; // 물품코드(PK) VARCHAR2(20) NOT NULL 물품코드
  public String PROC_UNIT_PRICE = ""; // 처리단가 NUMBER NULL 처리단가
  public int PROC_QTY = 0; // 처리수량 INTEGER NULL 처리수량
  
}
