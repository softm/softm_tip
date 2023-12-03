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

data.put( "CODE_VAL2"    , "S"); // 상태코드2

data.put( "USER_NAME"    , "홍길동"); // 성명      
data.put( "USER_IDNO"    , "7612201231742" ); // 주민번호    
data.put( "MOBILE_NO1"   , "010" ); // 휴대폰_연락처1
data.put( "MOBILE_NO2"   , "9071" ); // 휴대폰_연락처2
data.put( "MOBILE_NO3"   , "7218" ); // 휴대폰_연락처3
data.put( "LOAN_STATE_CD", "64" ); // 신청상태
data.put( "LOAN_STATE_CD", "65" ); // 신청상태
data.put( "GOODS", "대출상품(GOODS)" ); // 대출상품(GOODS)

data.put( "RPOST_CD", "423013" ); // RPOST_CD
data.put( "RADDR1"  , "경기도 광명시 광명3동 159-42" ); // RADDR1
data.put( "RADDR2"  , "서해박속낙지전문점" ); // RADDR2
data.put( "N_HZIP"  , "423014" ); // N_HZIP
data.put( "N_HADDR1", "경기도 광명시 광명4동 158-41" ); // N_HADDR1    
data.put( "N_HADDR2", "동해박속낙지전문점" ); // N_HADDR2

data.put( "LPOST_CD", "523013" ); // RPOST_CD
data.put( "LADDR1"  , "서울시 구로구 온수동 159-42" ); // RADDR1
data.put( "LADDR2"  , "서해전문점" ); // RADDR2
data.put( "N_RZIP"  , "523014" ); // N_HZIP
data.put( "N_RADDR1", "서울시 구로구 온수동 158-41" ); // N_HADDR1    
data.put( "N_RADDR2", "동해전문점" ); // N_HADDR2    

java.util.ArrayList<HashMap> list9 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("PSLOANREQ_SEQ"     ,"00101"); // 세부신청번호
	item.put("PSLOAN_AMT"        ,"1234567890"); // 대출금액
	item.put("PSLOAN_TYPE_NM"    ,"자금용도"); // 자금용도
	item.put("PSLOAN_REPAY_NM"   ,"상환방법"); // 상환방법
	item.put("PSINTER_PAY_DATE"  ,"20161215"); // 결제일
	item.put("PSLOAN_PERIOD"     ,"10"); // 기간
	item.put("LOAN_REPAY_PERIOD" ,"사유코드코드"); // 상환기간(일월구분)
	item.put("PSLOAN_RT"         ,"88"); // 이율
	item.put("PRVT_GRNTY_BEGIN_DT"  ,"20161215"); // 
	item.put("PRVT_GRNTY_UPDATE_DT" ,"20161216"); // 변경일자
	item.put("PRVT_GRNTY_AMOUNT" ,"10000000"); // 개설금액
	item.put("PSLOAN_REPAY_CD", "CDR" ); // 상환방법코드
	
	list9.add(item);
}
data.put("LIST_PSLOAN",list9); // 대부업채무불이행정보

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
    out.write(callBack + "(" + gson.toJson(data) + ")");
    System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
    out.println ( gson.toJson(data) ) ;
}
%>