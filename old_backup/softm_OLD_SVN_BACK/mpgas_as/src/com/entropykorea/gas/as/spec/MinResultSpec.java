package com.entropykorea.gas.as.spec;

import com.entropykorea.ewire.spec.BaseSpec;
import com.entropykorea.ewire.spec.FieldSpec;

public class MinResultSpec extends BaseSpec {
  
  private String fileName = "min_result.dat";
  private String tableName = "MIN";
  
  private FieldSpec[] fieldSpecs = { 
      new FieldSpec("REQUIRE_IDX         ",10  ,true,false),//민원인덱스(PK)
      new FieldSpec("PROC_RESULT_CD      ",20  ,false,false),//처리결과코드
      new FieldSpec("PROC_USER_CD        ",20  ,false,false),//처리자
      new FieldSpec("PROC_DT             ",19  ,false,false),//처리일시
      new FieldSpec("PROC_REMARK         ",2000,false,false),//처리메모
      new FieldSpec("PAID_GAS_PRICE      ",10  ,false,false),//요금수납금액
      new FieldSpec("PAID_FEE_PRICE      ",10  ,false,false),//수수료수납금액
      new FieldSpec("BASE_PRICE          ",10  ,false,false),//전출-기본요금
      new FieldSpec("USE_AMOUNT          ",10  ,false,false),//전출-사용량
      new FieldSpec("USE_PRICE           ",10  ,false,false),//전출-사용요금
      new FieldSpec("PENALTY_PRICE       ",10  ,false,false),//위약금
      new FieldSpec("UNSEAL_PRICE        ",10  ,false,false),//봉인해제비용 
      new FieldSpec("BF_METER            ",10  ,false,false),//전월지침
      new FieldSpec("METER               ",10  ,false,false),//현재지침
      new FieldSpec("MV_IN_CUST_NM       ",50  ,false,false),//전입-고객명
      new FieldSpec("MV_IN_TEL_NO        ",30  ,false,false),//전입-전화번호
      new FieldSpec("MV_IN_WORK_TEL_NO   ",30  ,false,false),//전입-직장전화번호
      new FieldSpec("MV_IN_HP_NO         ",30  ,false,false),//전입-핸드폰번호
      new FieldSpec("MV_IN_TEL_CD        ",20  ,false,false),//전입-주전화번호구분코드
      new FieldSpec("CARD_COMPANY        ",5   ,false,false),//카드사(매입사)
      new FieldSpec("CARD_NUM            ",50  ,false,false),//카드번호
      new FieldSpec("CARD_YM             ",4   ,false,false),//카드유효년월
      new FieldSpec("CARD_AMT            ",10  ,false,false),//카드승인금액
      new FieldSpec("CARD_MONTHS         ",2   ,false,false),//카드할부개월
      new FieldSpec("CARD_TRANS_NUM      ",8   ,false,false),//카드승인번호
      new FieldSpec("CARD_TRANS_DATE     ",19  ,false,false),//카드승인일시
      new FieldSpec("CASH_AMT            ",10  ,false,false),//현금수납액
      new FieldSpec("SEAL_CD             ",20  ,false,false),//봉인방법
      new FieldSpec("LAST_CALC_TIME      ",19  ,false,false),//최종요금계산일시
      new FieldSpec("PAY_INFO_SMS_REQ_YN ",1   ,false,false),//입금정보문자발송요청여부
      new FieldSpec("READ_SMS_RECV_YN    ",1   ,false,false),//검침SMS수신동의여부
      new FieldSpec("CHG_SMS_RECV_YN     ",1   ,false,false),//교체SMS수신동의여부
      new FieldSpec("CHECKUP_SMS_RECV_YN ",1   ,false,false),//점검SMS수신동의여부
      new FieldSpec("BILL_SMS_RECV_YN    ",1   ,false,false),//고지SMS수신동의여부
      new FieldSpec("UNPAID_SMS_RECV_YN  ",1   ,false,false),//체납SMS수신동의여부
      new FieldSpec("SIGN_FILE_NM        ",50  ,false,false),//서명파일명
      new FieldSpec("PHOTO_FILE_NM       ",50  ,false,false),//사진파일명
      new FieldSpec("PHOTO_FILE_NM2      ",50  ,false,false),//사진파일명2
  };
  
  public String whereClause = "WHERE REQUIRE_IDX IN (SELECT REQUIRE_IDX FROM MIN WHERE END_YN = 'Y' AND SEND_YN='N')";
  //public String whereClause = "WHERE END_YN = 'Y' AND SEND_YN='N'";
  
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
