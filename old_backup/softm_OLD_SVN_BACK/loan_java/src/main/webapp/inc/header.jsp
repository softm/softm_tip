<%
/**
 * 
 * Filename        : /inc/header.inc
 * Fuction         : 헤더
 * Comment         : 
 * 시작 일자       : 2017-02-01,
 * 수정 일자       : 2017-02-01, Kim. JiHoon v1.0 first
 * 작 성 자        : 김 지 훈
 * 수 정 자        :
 * @version        : 1.0
 * @author         : Copyright (c) ~
*/
%>
<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>
<!doctype html>
<html>
<head>
<title><%=SITE_TITLE%></title>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
<meta http-equiv="Expires" content="0"/>
<meta http-equiv="Pragma" content="no-cache"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no" />
<!--
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="http://code.jquery.com/jquery-2.1.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
 -->
<script src="/js/jquery-2.1.1.js"></script>
<!--
 -->
<script src="/js/jquery.validate.js" type="text/javascript"></script>
<script src="/js/additional-methods.js" type="text/javascript"></script>

<script src="/js/jquery-ui.js"></script>
<script src="/js/jquery.tmpl.js" type="text/javascript"></script>
<script src="/js/jquery.ui.touch.js" type="text/javascript"></script>
<script src="/js/jquery.number.min.js" type="text/javascript"></script>


<script src="/js/jquery.ui.datepicker.validation.min.js" type="text/javascript"></script>
<script src="/js/jquery.mask.min.js" type="text/javascript"></script>
<script src="/js/moment.min.js" type="text/javascript"></script>

<script src="/js/const.js" type="text/javascript"></script>
<script src="/js/common.js" type="text/javascript"></script>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<!-- 
<link rel="stylesheet" href="/css/jquery-ui.css">
 -->
<c:if test='${fn:indexOf(pageName, "bak_") == -1 }'>
	<!-- Publish JS -->
	<script type="text/javascript" src="/js/ui_common.js"></script>

	<!-- Publish CSS -->
	<link rel="stylesheet" type="text/css" href="/css/ui_common.css" />
	<link rel="stylesheet" type="text/css" href="/css/layout.css" />
	<link rel="stylesheet" type="text/css" href="/css/contents.css" />
</c:if>

<link href="/css/common.css" rel="stylesheet" type="text/css" />
<style>
.hide { display:none}
.hidden { display:none; width:"100px"}
body{ display:none;}
</style>
</head>
<c:set var="statgroup"    value="${param.statgroup}"/>
<c:set var="lnbSeq"       value="${param.lnbSeq}"/>
<c:if test='${statgroup == null || statgroup == ""}'>
    <c:set var="statgroup"    value="con"/>
</c:if>
<c:if test='${lnbSeq == null || lnbSeq == ""}'>
    <c:set var="lnbSeq"    value="1"/>
</c:if>
<script>
	var lnbSeq = "<c:out value="${lnbSeq}"/>";
</script>