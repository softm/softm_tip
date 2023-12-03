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

data.put( "LOANREQ_SEQ", "loanreq_seq" ); // 신청번호
data.put( "PT_CUST_NO", "pt_cust_no" ); // 고객번호
data.put( "USER_IDNO", "7612201231742" ); // 주민번호
data.put( "MOBILE_NO1", "010" ); // 휴대폰_연락처1
data.put( "MOBILE_NO2", "9071" ); // 휴대폰_연락처2
data.put( "MOBILE_NO3", "7218" ); // 휴대폰_연락처3
data.put( "LOAN_STATE_CD", "13" ); // 신청상태
data.put( "ADMIN_NO", "admin_no" ); // 담당자
data.put( "IDCARD_VERIFY", "IDCARD_VERIFY" ); // 신분증진위확인구분
data.put( "IDCARD_ISSUE_DAY", "IDCARD_ISSUE_DAY" ); // 발급일자
data.put( "IDCARD_LICENSE_NUM", "IDCARD_LICENSE_NUM" ); // 면허번호
data.put( "IDCARD_VERIFY_RESULT", "N" ); // 신분증진위확인증결과
data.put( "IDCARD_VERIFY_DT", "IDCARD_VERIFY_DT" ); // 신분증진위확인증일시

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
	out.write(callBack + "(" + gson.toJson(data) + ")");
	System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
	out.println ( gson.toJson(data) ) ;
}
%>