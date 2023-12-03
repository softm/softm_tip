package com.entropykorea.gas.as.bean;

import java.io.Serializable;

public class Provider implements Serializable{
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
  
  public String CO_NM = "";// 공급자명
  public String CEO_NM = "";// 대표자명
  public String CO_NO = "";// 사업자번호
  public String ADDR = "";// 주소
  public String ROAD_ADDR1 = "";// 도로명주소1
  public String ROAD_ADDR2 = "";// 도로명주소2
  public String TEL_NO = "";// 전화번호
  public String VAN_NO = "";// 가맹점번호
  public String VAN_CARD_NO = "";// 신용카드VAN번호
}
