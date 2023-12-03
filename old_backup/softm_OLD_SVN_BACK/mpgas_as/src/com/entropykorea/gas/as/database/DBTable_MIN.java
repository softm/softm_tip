
package com.entropykorea.gas.as.database;

import android.provider.BaseColumns;

// DataBase Table
public final class DBTable_MIN {

    public static final class Columns implements BaseColumns {
      public final String REQUIRE_IDX = "REQUIRE_IDX";// (PK) 민원인덱스(PK)
      public final String REQUIRE_CD = "REQUIRE_CD";// 민원구분
      public final String HOUSE_NO = "HOUSE_NO";// 수용가번호
      public final String FAKE_HOUSE_NO = "FAKE_HOUSE_NO";// 가수용가번호
      
      
      public final String AREA_CD = "AREA_CD";// 지역코드
      public final String SECTOR_CD = "SECTOR_CD";// 구역코드
      public final String COMPLEX_CD = "COMPLEX_CD";// 단지코드
      public final String BLDG_CD = "BLDG_CD";// 건물코드
      public final String AREA_NM = "AREA_NM";// 지역명
      public final String SECTOR_NM = "SECTOR_NM";// 구역명
      public final String COMPLEX_NM = "COMPLEX_NM";// 단지명
      public final String BLDG_NM = "BLDG_NM";// 건물명
      public final String BLDG_NO = "BLDG_NO";// 번지
      public final String ROOM_NO = "ROOM_NO";// 호수
      public final String ROAD_NM = "ROAD_NM";// 도로명
      
      
      public final String CUST_NM = "CUST_NM";// 고객명
      public final String CO_NM = "CO_NM";// 상호
      public final String PURPOSE_CD = "PURPOSE_CD";// 용도코드
      public final String HOUSE_STATUS_CD = "HOUSE_STATUS_CD";// 수용가상태코드
      public final String HOUSE_LIVING_CD = "HOUSE_LIVING_CD";// 수용가주거구분
      public final String CUST_NO = "CUST_NO";// 고객번호
      public final String TEL_NO = "TEL_NO";// 전화번호
      public final String WORK_TEL_NO = "WORK_TEL_NO";// 직장전화번호
      public final String HP_NO = "HP_NO";// 핸드폰번호
      public final String TEL_CD = "TEL_CD";// 주전화번호구분코드
      public final String GM_NO = "GM_NO";// 계량기번호
      public final String ACCEPT_DT = "ACCEPT_DT";// 접수일시
      public final String REQUEST_REQUIRE_DT = "REQUEST_REQUIRE_DT";// 요청일자
      public final String REQUEST_BEGIN_DT = "REQUEST_BEGIN_DT";// 방문요청시작시각
      public final String REQUEST_REMARK = "REQUEST_REMARK";// 요청메모
      public final String PUSH_REQ_YN = "PUSH_REQ_YN";// 독촉여부
      public final String VIR_ACC_NO_IBK = "VIR_ACC_NO_IBK";// 기업은행가상계좌번호
      public final String VIR_ACC_NO_NH = "VIR_ACC_NO_NH";// 농협가상계좌번호
      public final String PROC_RESULT_CD = "PROC_RESULT_CD";// 처리결과코드
      public final String PROC_USER_CD = "PROC_USER_CD";// 처리자
      public final String PROC_DT = "PROC_DT";// 처리일시
      public final String PROC_REMARK = "PROC_REMARK";// 처리메모
      public final String PAID_GAS_PRICE = "PAID_GAS_PRICE";// 요금수납금액
      public final String PAID_FEE_PRICE = "PAID_FEE_PRICE";// 수수료수납금액
      public final String BASE_PRICE = "BASE_PRICE";// 전출-기본요금
      public final String USE_AMOUNT = "USE_AMOUNT";// 전출-사용량
      public final String USE_PRICE = "USE_PRICE";// 전출-사용요금
      public final String PENALTY_PRICE = "PENALTY_PRICE";//위약금
      public final String UNSEAL_PRICE = "UNSEAL_PRICE"; // 봉인해제비용
      public final String BF_METER = "BF_METER";// 전월지침
      public final String METER = "METER";// 현재지침
      public final String MV_IN_CUST_NM = "MV_IN_CUST_NM";// 전입-고객명
      public final String MV_IN_TEL_NO = "MV_IN_TEL_NO";// 전입-전화번호
      public final String MV_IN_WORK_TEL_NO = "MV_IN_WORK_TEL_NO";// 전입-직장전화번호
      public final String MV_IN_HP_NO = "MV_IN_HP_NO";// 전입-핸드폰번호
      public final String MV_IN_TEL_CD = "MV_IN_TEL_CD";// 전입-주전화번호구분코드
      public final String CARD_COMPANY = "CARD_COMPANY";// 카드사(매입사)
      public final String CARD_NUM = "CARD_NUM";// 카드번호
      public final String CARD_YM = "CARD_YM";// 카드유효년월
      public final String CARD_AMT = "CARD_AMT";// 카드승인금액
      public final String CARD_MONTHS = "CARD_MONTHS";// 카드할부개월
      public final String CARD_TRANS_NUM = "CARD_TRANS_NUM";// 카드승인번호
      public final String CARD_TRANS_DATE = "CARD_TRANS_DATE";// 카드승인일시
      public final String CARD_STATUS = "CARD_STATUS";// 카드승인상태
      public final String CARD_CANCEL_TRANS_NUM = "CARD_CANCEL_TRANS_NUM";// 카드취소승인번호
      public final String CARD_CANCEL_TRANS_DATE = "CARD_CANCEL_TRANS_DATE";// 카드취소승인일시
      public final String CASH_AMT = "CASH_AMT";// 현금수납액
      public final String SEAL_CD = "SEAL_CD";// 봉인방법
      public final String LAST_CALC_TIME = "LAST_CALC_TIME";// 최종요금계산일시
      public final String PAY_INFO_SMS_REQ_YN = "PAY_INFO_SMS_REQ_YN";// 입금정보문자발송요청여부
      public final String READ_SMS_RECV_YN = "READ_SMS_RECV_YN";// 검침SMS수신동의여부
      public final String CHG_SMS_RECV_YN = "CHG_SMS_RECV_YN";// 교체SMS수신동의여부
      public final String CHECKUP_SMS_RECV_YN = "CHECKUP_SMS_RECV_YN";// 점검SMS수신동의여부
      public final String BILL_SMS_RECV_YN = "BILL_SMS_RECV_YN";// 고지SMS수신동의여부
      public final String UNPAID_SMS_RECV_YN = "UNPAID_SMS_RECV_YN";// 체납SMS수신동의여부
      public final String SIGN_FILE_NM = "SIGN_FILE_NM";// 서명파일명
      public final String PHOTO_FILE_NM = "PHOTO_FILE_NM";// 사진파일명
      public final String PHOTO_FILE_NM2 = "PHOTO_FILE_NM2";// 사진파일명2
      public final String END_YN = "END_YN";//완료여부 
      public final String SEND_YN = "SEND_YN";// 송신여부// 주소: 전남 목포 석현동 952-2
               
    public static final String _TABLENAME = "MIN";

    }
}
