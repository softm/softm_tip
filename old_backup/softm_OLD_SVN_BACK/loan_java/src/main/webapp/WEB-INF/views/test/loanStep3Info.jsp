<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="com.google.gson.Gson"%>
<%@page import="java.util.HashMap"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@include file="/inc/common_json.jsp" %>
<%
Gson gson = new Gson();
HashMap data = new HashMap();
data.put("RESULT_CD","0");
//data.put("RESULT_MSG","성공");

data.put( "BEFORE_WANT_AMT"                        , "1110000"                      ); // 필요자금

data.put( "LOANREQ_SEQ"                        , "0000"                      ); // 신청번호
data.put( "PT_CUST_NO"                         , "0000"                      ); // 고객번호
data.put( "USER_NAME"                          , "테스트"                      ); // 성명
data.put( "USER_IDNO"                          , "7612201231742"                      ); // 주민번호
data.put( "MOBILE_NO1"                         , "010"                      ); // 휴대폰_연락처1
data.put( "MOBILE_NO2"                         , "9071"                      ); // 휴대폰_연락처2
data.put( "MOBILE_NO3"                         , "7218"                      ); // 휴대폰_연락처3
data.put( "LOAN_STATE_CD"                      , "13"                      ); // 신청상태
data.put( "ADMIN_NO"                           , "0001"                      ); // 담당자
data.put( "FUND_USE"                           , "01"                      ); // 자금용도
data.put( "EXIST_CD"                           , "01"                      ); // 대출구분
data.put( "LIVING_CD"                          , "01"                      ); // 주거형태
data.put( "HOUSE_OWN_CD"                       , "01"                      ); // 주택소유형태
data.put( "HOUSE_LEASE"                        , "01"                      ); // 주택보증금
data.put( "CAR_OWN_YN"                         , "Y"                      ); // 차량보유현황
data.put( "COMPANY_NM"                         , "내마음대로"                      ); // 상호명
data.put( "COMPANY_TYPE"                       , "01"                      ); // 사업자구분
data.put( "CTEL_NO1"                           , "02"                      ); // 사업장_연락처1
data.put( "CTEL_NO2"                           , "2682"                      ); // 사업장_연락처2
data.put( "CTEL_NO3"                           , "7211"                      ); // 사업장_연락처3
data.put( "CADDR"                              , "경기도 광명시 광명3동 159-42"                      ); // 사업장주소
data.put( "COMPANY_REALOPER"                   , "홍길당"                      ); // 사업장실운영자
data.put( "COMPANY_REALOPER_MEMO"              , "역세권"                      ); // 사업장실운영자메모
data.put( "COMPANY_APPR"                       , "용이함"                      ); // 사업장 접근성
data.put( "PERSON_COST"                        , "1000"                      ); // 인건비
data.put( "MERCHAN_RATE"                       , "30"                         ); // 상품원가율
data.put( "PLACE_GUARAN_AMT"                   , "30000000"                      ); // 사업장입대차계약내용(보증금)
data.put( "PLACE_RENT_AMT"                     , "800000"                      ); // 사업장입대차계약내용(월세금)
data.put( "CARD_SALE_AMT"                      , "10000000"                      ); // 월평균매출액(카드매출)
data.put( "CASH_SALE_AMT"                      , "100000000"                      ); // 월평균매출액(현금매출)
data.put( "MONTH_PRIN_INT_AMT"                  , "20000000"                      ); // 월.대출금불입금액
data.put( "DELAY_ISSUE_DAY"                    , "10"                      ); // 연체발생일
data.put( "DELAY_CNT"                          , "11"                      ); // 연체건수
data.put( "CASH_TOT_CNT"                       , "12"                      ); // 현금서비스건
data.put( "CASH_TOT_AMT"                       , "200000000"                      ); // 현금서비스금액
data.put( "SUMMARY_PRVT_CNT"                   , "13"                      ); // 대부업사용건수
data.put( "SUMMARY_PRVT_TOT_AMT"               , "30000000"                      ); // 대부업사용금액
data.put( "LOAN_TOT_CNT"                       , "14"                      ); // 대출정보건수
data.put( "LOAN_TOT_AMT"                       , "40000000"                      ); // 대출정보금액
data.put( "3MONTHLOAN_TOT_CNT"                 , "15"                      ); // 최근3개월내대출건수
data.put( "3MONTHLOAN_TOT_AMT"                 , "5000000"                      ); // 최근3개월내대출금액
data.put( "NICE_ALL_GRADE"                     , "C"                      ); // CB등급
data.put( "CBCARD_CNT"                         , "16"                      ); // 신용카드보유건수
data.put( "GRNTY_LOAN_CNT"                     , "17"                      ); // 보증채무(당행제외)
data.put( "CUTOFF_LIVE_SOLO"                   , "Y"                      ); // 단독세대여부
data.put( "CUTOFF_HOUSE_LEASE"                 , "Y"                      ); // 보증금 1000만원 미만 월세거주자
data.put( "CUTOFF_COMPANY_REALOPER"            , "Y"                      ); // 사업장등록증상 운영자와 실운영자가 다른경우
data.put( "CUTOFF_CBSCORE_NEG"                 , "Y"                      ); // 과거신용판단해제이력보유자
data.put( "CUTOFF_DELAY_DAYS"                  , "Y"                      ); // 10일이상연체여부
data.put( "CUTOFF_CBS_BAD"                      , "Y"                      ); // 평점사유부정적요인
data.put( "CUTOFF_SUMMARY_PRVT"                      , "Y"                      ); // 대부업사용      
data.put( "CUTOFF_LOAN_TOT"                      , "Y"                      ); // 대출정보        
data.put( "CUTOFF_3MONTHLOAN_TOT"                      , "Y"                      ); // 최근3개월내 대출

data.put( "CUTOFF_CASH_TOT_CNT"                      , "Y"                      ); // 현금서비스3건500만원초과
data.put( "BEFORE_WANT_AMT"                      , "11111212"                      ); // 필요자금
data.put( "CUTOFF_CBSCORE_NEG_NM"                      , "평점사유부정적요인(내용)"                      ); // 평점사유부정적요인(내용)

data.put( "OPENING_DY"                         , "20111212"                      ); // 사업업력
data.put( "RADDR"                         , "서울시 구로구 온수동 온수힐스테이트"                      ); // 사업업력
data.put( "LIVE_SOLO"            , "Y"              ); // 가족관계 - 단독
data.put( "LIVE_DAD"             , "N"               ); // 가족관계 - 부
data.put( "LIVE_MOM"             , "Y"               ); // 가족관계 - 모
data.put( "LIVE_MATE"            , "N"              ); // 가족관계 - 배우자
data.put( "LIVE_CHILD"           , "Y"             ); // 가족관계 - 자녀
data.put( "LIVE_BROTHER"         , "N"           ); // 가족관계 - 형제
data.put( "LIVE_RELATION"        , "N"          ); // 가족관계 - 친척
data.put( "LIVE_ETC"             , "N"               ); // 가족관계 - 기타

data.put( "CODE_VAL2"            , "J"               ); // 

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
    out.write(callBack + "(" + gson.toJson(data) + ")");
    System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
    out.println ( gson.toJson(data) ) ;
}
%>