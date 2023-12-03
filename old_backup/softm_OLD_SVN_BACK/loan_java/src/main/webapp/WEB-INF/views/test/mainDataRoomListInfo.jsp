<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="com.google.gson.Gson"%>
<%@page import="java.util.HashMap"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@include file="/inc/common_json.jsp" %>
<%
Gson gson = new Gson();
HashMap data = new HashMap();
data.put("RESULT_CD","0");
//data.put("RESULT_MSG","조회성공");

java.util.ArrayList<HashMap> list = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put( "TITLE", "개인정보 취급 강화에 따른 필수 확인사항 입니다." ); // 신청번호
	item.put( "PT_CUST_NO", "1" ); // 고객번호
	item.put( "REG_DATE", "2017.01.19" ); // 
	list.add(item);
}
data.put("LIST",list);

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
	out.write(callBack + "(" + gson.toJson(data) + ")");
	System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
	out.println ( gson.toJson(data) ) ;
}
%>