package com.entropykorea.gas.as.bean;

import java.io.Serializable;

public class Min implements Serializable {

  public    int REQUIRE_IDX             = 0;//민원인덱스(PK)
  public String REQUIRE_CD              ="";//민원구분
  public String HOUSE_NO                ="";//수용가번호
  public String FAKE_HOUSE_NO           ="";//가수용가번호
  public String AREA_CD                 ="";//지역코드
  public String SECTOR_CD               ="";//구역코드
  public String COMPLEX_CD              ="";//단지코드
  public String BLDG_CD                 ="";//건물코드
  public String AREA_NM                 ="";//지역명
  public String SECTOR_NM               ="";//구역명
  public String COMPLEX_NM              ="";//단지명
  public String BLDG_NM                 ="";//건물명
  public String BLDG_NO                 ="";//번지
  public String ROOM_NO                 ="";//호수
  public String ROAD_NM                 ="";//도로명
  public String CO_NM                   ="";//상호
  public String PURPOSE_CD              ="";//용도코드
  public String HOUSE_STATUS_CD         ="";//수용가상태코드
  public String HOUSE_LIVING_CD         ="";//수용가주거구분
  public String CUST_NO                 ="";//고객번호
  public String CUST_NM                 ="";//고객명
  public String TEL_NO                  ="";//전화번호
  public String WORK_TEL_NO             ="";//직장전화번호
  public String HP_NO                   ="";//핸드폰번호
  public String TEL_CD                  ="";//주전화번호구분코드
  public String GM_NO                   ="";//계량기번호
  public String ACCEPT_DT               ="";//접수일시
  public String REQUEST_REQUIRE_DT      ="";//요청일자
  public String REQUEST_BEGIN_DT        ="";//방문요청시작시각
  public String REQUEST_REMARK          ="";//요청메모
  public String PUSH_REQ_YN             ="";//독촉여부
  public String VIR_ACC_NO_IBK          ="";//기업은행가상계좌번호 
  public String VIR_ACC_NO_NH           ="";//농협가상계좌번호
  
  //---------------------------------------이하 업데이트부분
  
  public String PROC_RESULT_CD          ="";//처리결과코드
  public String PROC_USER_CD            ="";//처리자
  public String PROC_DT                 ="";//처리일시
  public String PROC_REMARK             ="";//처리메모
  public String PAID_GAS_PRICE          ="";//요금수납금액
  public String PAID_FEE_PRICE          ="";//수수료수납금액
  public String BASE_PRICE              ="";//전출-기본요금
  public String USE_AMOUNT              ="";//전출-사용량
  public String USE_PRICE               ="";//전출-사용요금
  public String PENALTY_PRICE           ="";//위약금
  public String UNSEAL_PRICE            ="";//봉인해제비용
  public String BF_METER                ="";//전월지침
  public String METER                   ="";//현재지침
  public String MV_IN_CUST_NM           ="";//전입-고객명
  public String MV_IN_TEL_NO            ="";//전입-전화번호
  public String MV_IN_WORK_TEL_NO       ="";//전입-직장전화번호
  public String MV_IN_HP_NO             ="";//전입-핸드폰번호
  public String MV_IN_TEL_CD            ="";//전입-주전화번호구분코드
  public String CARD_COMPANY            ="";//카드사(매입사)
  public String CARD_NUM                ="";//카드번호
  public String CARD_YM                 ="";//카드유효년월
  public String CARD_AMT                ="";//카드승인금액
  public String CARD_MONTHS             ="";//카드할부개월
  public String CARD_TRANS_NUM          ="";//카드승인번호
  public String CARD_TRANS_DATE         ="";//카드승인일시
  public String CARD_STATUS             ="";//카드승인상태
  public String CARD_CANCEL_TRANS_NUM   ="";//카드취소승인번호
  public String CARD_CANCEL_TRANS_DATE  ="";//카드취소승인일시
  public String CASH_AMT                ="";//현금수납액
  public String SEAL_CD                 ="";//봉인방법
  public String LAST_CALC_TIME          ="";//최종요금계산일시
  public String PAY_INFO_SMS_REQ_YN     ="";//입금정보문자발송요청여부
  public String READ_SMS_RECV_YN        ="";//검침SMS수신동의여부
  public String CHG_SMS_RECV_YN         ="";//교체SMS수신동의여부
  public String CHECKUP_SMS_RECV_YN     ="";//점검SMS수신동의여부
  public String BILL_SMS_RECV_YN        ="";//고지SMS수신동의여부
  public String UNPAID_SMS_RECV_YN      ="";//체납SMS수신동의여부
  public String SIGN_FILE_NM            ="";//서명파일명
  public String PHOTO_FILE_NM           ="";//사진파일명
  public String PHOTO_FILE_NM2          ="";//사진파일명2
  public String END_YN                  ="";//완료여부
  public String SEND_YN                 ="";//송신여부
  
  // 뷰에서 별도 추가
  public String ADDRESS = "";// 주소: 전남 목포 석현동 952-2
  public int TOT_PRICE = 0; //총액 
  //public int TOT_GAS_PRICE = 0;// 요금계산금액
  //public int TOT_FEE_PRICE = 0;// 수수료총액금액
//  public int PAID_PRICE = 0;// 실수납액 
//  public int FEE_PRICE = 0;// 수수
  // 영수증 추가
  // public String TYPE = "";// 청구서 종류
  // public String CARD_TRADER_NUM = "";// 가맹점번호
  // public String TEL = "";// Tel 061-282-0011
  // public String CARD_TRADER = "";// 가맹점명 목포도시가스(주)
  // public String BUSINESS_NUM = "";// 사업자번호 4118101998
  // public String AGENT = "";// 대표자명 정경오
  
}
