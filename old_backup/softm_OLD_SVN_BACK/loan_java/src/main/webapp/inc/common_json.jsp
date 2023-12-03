<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%
request.setCharacterEncoding("UTF-8");
//response.setCharacterEncoding("UTF-8");

String DATA_TYPE = "jsonp"; // json / jsonp
String callBack = request.getParameter("callback");

if ( DATA_TYPE.equals("json") ) { //json
	response.setContentType("application/json");
	//response.setCharacterEncoding("UTF-8");
	response.setHeader("Access-Control-Allow-Origin", "*");
	response.setHeader("Access-Control-Allow-Methods", "POST, GET, OPTIONS, DELETE, HEAD, PUT");
	response.setHeader("Access-Control-Max-Age", "3600");
	response.setHeader("Access-Control-Allow-Credentials", "true");
	response.setHeader("Access-Control-Allow-Headers", "x-requested-with");
} else if ( DATA_TYPE.equals("jsonp") ) { //jsonp
}
%>
