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

data.put( "USER_NAME", "테스트" ); // 성명

data.put( "RESULT_CD"            , "0"                      ); // 결과코드
data.put( "RESULT_MSG"           , ""                       ); // 결과메시지
data.put( "LOANREQ_SEQ"          , "12340"                  ); // 신청번호
data.put( "PT_CUST_NO"           , "99904"                  ); // 고객번호
data.put( "USER_NAME"            , "김지훈"                 ); // 성명
data.put( "USER_IDNO"            , "76122201231742"         ); // 주민번호
data.put( "MOBILE_NO1"           , "010"                    ); // 휴대폰_연락처1
data.put( "MOBILE_NO2"           , "9071"                   ); // 휴대폰_연락처2
data.put( "MOBILE_NO3"           , "7218"                   ); // 휴대폰_연락처3
data.put( "LOAN_STATE_CD"        , "LOAN_STATE_CD"          ); // 신청상태
data.put( "ADMIN_NO"             , "ADMIN_NO"               ); // 담당자
data.put( "FUND_USE"             , "02"               ); // 자금용도
data.put( "EXIST_CD"             , "11"               ); // 대출구분
data.put( "LTEL_NO1"             , "010"               ); // 자택_연락처1
data.put( "LTEL_NO2"             , "9071"               ); // 자택_연락처2
data.put( "LTEL_NO3"             , "7218"               ); // 자택_연락처3
data.put( "RADDR"                , "경기도 광명시 광명3동 159-42"                  ); // 자택주소
data.put( "LIVING_CD"            , 	"03"); // 주거형태
data.put( "HOUSE_OWN_CD"         , "01"           ); // 주택소유형태
data.put( "HOUSE_LEASE"          , "100000"            ); // 주택보증금
data.put( "LIVE_SOLO"            , "Y"              ); // 가족관계 - 단독
data.put( "LIVE_DAD"             , "N"               ); // 가족관계 - 부
data.put( "LIVE_MOM"             , "N"               ); // 가족관계 - 모
data.put( "LIVE_MATE"            , "N"              ); // 가족관계 - 배우자
data.put( "LIVE_CHILD"           , "N"             ); // 가족관계 - 자녀
data.put( "LIVE_BROTHER"         , "N"           ); // 가족관계 - 형제
data.put( "LIVE_RELATION"        , "N"          ); // 가족관계 - 친척
data.put( "LIVE_ETC"             , "N"               ); // 가족관계 - 기타
data.put( "CAR_OWN_YN"           , "N"             ); // 차량보유현황
data.put( "COMPANY_NM"           , "내마음대로"             ); // 상호명
data.put( "COMPANY_TYPE"         , "02"           ); // 사업자구분
data.put( "CTAX_NO"              , "1234567890"                ); // 사업자등록번호 
data.put( "CTEL_NO1"             , "02"               ); // 사업장_연락처1
data.put( "CTEL_NO2"             , "2682"               ); // 사업장_연락처2
data.put( "CTEL_NO3"             , "7211"               ); // 사업장_연락처3
data.put( "CADDR"                , "서울시 구로구 온수동 온수힐스테이트 APT"                  ); // 사업장주소
data.put( "OPENING_DY"           , "19990111"             ); // 현사업업력
data.put( "COMPANY_REALOPER"     , "02"       ); // 사업장실운영자
data.put( "COMPANY_REALOPER_MEMO", "COMPANY_REALOPER_MEMO"  ); // 사업장실운영자메모
data.put( "COMPANY_APPR"         , "접근성 용이함."           ); // 사업장 접근성
data.put( "WORKER_CNT"           , "56565655"             ); // 종업원수
data.put( "PERSON_COST"          , "12121212"            ); // 인건비
data.put( "MERCHAN_COST"         , "99956"           ); // 상품원가
data.put( "PLACE_OWN_CD"         , "02"           ); // 사업장소유형태
data.put( "PLACE_GUARAN_AMT"     , "1234"       ); // 사업장입대차계약내용(보증금)
data.put( "PLACE_RENT_AMT"       , "5678"         ); // 사업장입대차계약내용(월세금)
data.put( "MONTHPAY_DEFAULT"     , "N"       ); // 월세납부현황(체납)
data.put( "TAXPAY_DEFAULT"       , "N"       ); //   국세및지방세체납내역
data.put( "CARD_SALE_AMT"        , "888888"          ); // 월평균매출액(카드매출)
data.put( "CASH_SALE_AMT"        , "222222"          ); // 월평균매출액(현금매출)
data.put( "ANUL_PRIN_INT_AMT"    , "ANUL_PRIN_INT_AMT"     ); // 월.대출금불입금액

data.put( "MERCHAN_RATE"    , "70"     ); // 상품원가율
data.put( "MONTH_PRIN_INT_AMT"    , "12340"     ); // 

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
    out.write(callBack + "(" + gson.toJson(data) + ")");
    System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
    out.println ( gson.toJson(data) ) ;
}
%>