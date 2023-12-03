package com.entropykorea.gas.as.bean;

public class MinCust {
 
 public int REQUIRE_IDX = 0; // 민원인덱스(PK)(FK) INTEGER NOT NULL 민원인덱스
 public String HOUSE_NO = ""; // 수용가번호(PK) VARCHAR2(14) NOT NULL N/A
 public String FAKE_HOUSE_NO = ""; // 가수용가번호
 public String CUST_NO = ""; // 고객번호(PK) VARCHAR2(10) NOT NULL 고객번호
 public String CUST_NM = ""; // 고객명 VARCHAR2(50) NULL 고객명
 public String TEL_NO = ""; // 전화번호 VARCHAR2(30) NULL 전화번호
 public String WORK_TEL_NO = "";// 직장전화번호 VARCHAR2(30) NULL 직장전화번호
 public String HP_NO = ""; // 핸드폰번호 VARCHAR2(30) NULL 핸드폰
 public String TEL_CD = ""; // 주전화번호구분코드 VARCHAR2(20) NULL 주전화번호구분코드(MA290)
}
