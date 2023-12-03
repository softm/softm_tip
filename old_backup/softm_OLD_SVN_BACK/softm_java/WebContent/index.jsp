<%
/**
 * 
 * Filename        : /sub00/login.jsp
 * Fuction         : login
 * Comment         : 
 * 시작 일자       : 2012-06-19,
 * 수정 일자       : 2012-06-19, Kim. JiHoon v1.0 first
 * 작 성 자        : 김 지 훈
 * 수 정 자        :
 * @version        : 1.0
 * @author         : Copyright (c) ~
*/
%>
<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@include file="/inc/common.inc" %>
<%
	response.sendRedirect("/service.jsp?p_prg=dms_main/index");
%>