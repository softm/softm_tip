<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@page import="java.net.URLDecoder"%>
<%@page import="com.google.gson.Gson"%>
<%@include file="/inc/common_json.jsp" %>
<%
response.setContentType("application/javascript");
response.setHeader("Content-Disposition", "inline");
String data = request.getParameter("data");
try {
	if(data != null){
		//data = new String(data.getBytes("8859_1"),"UTF-8"); 
	}
} catch (Exception e) {
	e.printStackTrace();
} finally {
	//out.print(URLDecoder.decode(data));
	data = data.substring(1,data.length()-1);
	//data = data.replaceAll("\\\"", "\"");
	if ( DATA_TYPE.equals("jsonp") ) { //jsonp
		out.write(callBack + "(" + data + ")");
		System.out.println(callBack + "(" + data + ")");
	} else if ( DATA_TYPE.equals("json") ) { //json
		out.println ( data ) ;
	}	
}
%>