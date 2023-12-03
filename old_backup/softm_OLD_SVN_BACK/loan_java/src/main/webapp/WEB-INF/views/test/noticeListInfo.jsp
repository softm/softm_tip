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

java.util.ArrayList<HashMap> list = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<20;i++) {
	HashMap item = new HashMap();
	item.put( "NOTICE_SEQ", i+1 ); // 신청번호
	if ( i % 3 == 0 ) {
		item.put( "CTITLE", "공지사항" ); // 카테고리
		item.put( "TITLE", "개인정보 취급 강화에 따른 필수 확인사항입니다." ); // 제목
		item.put( "USER_NAME", "홍길동" ); // 고객명
	} else  if ( i % 3 == 1 ) {
		item.put( "CTITLE", "타이틀" ); // 카테고리
		item.put( "TITLE", "정기예금 금리인하 안내" ); // 제목
		item.put( "USER_NAME", "이순신" ); // 고객명
	} else  if ( i % 3 == 2 ) {
		item.put( "CTITLE", "항목미정" ); // 카테고리
		item.put( "TITLE", "항목미정금융분야 개인정보보호를 위한 홍보 동영상" ); // 제목
		item.put( "USER_NAME", "세종대왕" ); // 고객명
	}	
	item.put( "FILE_NO", "1" + i ); // 파일번호
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