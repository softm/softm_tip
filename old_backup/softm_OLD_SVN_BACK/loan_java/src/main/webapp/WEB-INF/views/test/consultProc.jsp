<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="com.google.gson.Gson"%>
<%@page import="java.util.HashMap"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@include file="/inc/common_json.jsp" %>
<%
Gson gson = new Gson();
HashMap data = new HashMap();
data.put("RESULT_CD","0");
data.put("RESULT_MSG","신청되었습니다.");
data.put("LOANREQ_SEQ","12340");
data.put("PT_CUST_NO","1");
data.put("LOAN_STATE_CD","01");
data.put("ADMIN_NO","1");

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
	out.write(callBack + "(" + gson.toJson(data) + ")");
	System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
	out.println ( gson.toJson(data) ) ;
}
%>