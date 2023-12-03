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

data.put( "CTITLE", "공지사항" ); // 카테고리
data.put( "USER_NAME", "홍길동" ); // 작성자
data.put( "TITLE", "개인정보 취급 강화에 따른 필수 확인사항입니다." ); // 제목
data.put( "CONTENT", "컨텐츠내용<BR/>컨텐츠내용컨텐츠내용컨텐츠내용컨텐츠내용" ); // 컨텐츠내용
data.put( "FILE_NO", "1" ); // 파일번호
data.put( "FILE_NAME", "개인정보취급방침개정_0124.hwp" ); // 첨부파일

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
    out.write(callBack + "(" + gson.toJson(data) + ")");
    System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
    out.println ( gson.toJson(data) ) ;
}
%>