<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="com.google.gson.Gson"%>
<%@page import="java.util.HashMap"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@include file="/inc/common_json.jsp" %>
<%
Gson gson = new Gson();
HashMap data = new HashMap();
data.put("RESULT_CD","0");
//data.put("RESULT_MSG","인증되었습니다.");
data.put("RESULT_MSG","");

data.put("REGISTER_NO",     "1");
data.put("CERT_USER_NAME",  "테스트");
data.put("CERT_CERT_TYPE",  "1");
data.put("CERT_LOANREQ_SEQ",     "1");
data.put("CERT_AUTH_RESULT",     "1");
data.put("CERT_AUTH_NO",     "0123456789");
data.put("REGISTER_NO",     "7612201231742");

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
	out.write(callBack + "(" + gson.toJson(data) + ")");
	System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
	out.println ( gson.toJson(data) ) ;
}
%>