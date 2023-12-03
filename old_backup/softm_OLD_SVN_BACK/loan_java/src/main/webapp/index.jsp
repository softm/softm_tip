<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib prefix="c"    uri="http://java.sun.com/jsp/jstl/core" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
$( document ).ready(function() {
});
</script>
<style>
</style>
</head>
<body>
<c:choose>
    <c:when test='${sessionScope.ss_user==null}'>
		<c:redirect url="loginView.do"/>
    </c:when>
    <c:otherwise>
		<c:redirect url="mainView.do"/>
    </c:otherwise>
</c:choose>
<%@include file="/inc/footer.jsp" %>