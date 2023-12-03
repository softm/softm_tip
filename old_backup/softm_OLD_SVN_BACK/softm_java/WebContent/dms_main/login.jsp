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
String back = StringUtils.defaultString(request.getParameter("BACKURL"));  // main menu index
%>
<form id=lForm name=lForm onsubmit='return fLogin(this);'>
<input type='text' name='back' value="<%=!back.equals("")?back:"/service.jsp?p_prg=dms_main/index"%>">
<center>
<table border=1>
	<tr>
		<td colspan="2" align=center>
			<b><font size=5>로그인 페이지</font></b>
		</td>
	</tr>
	<tr><td>아이디 : </td><td><input type="text" name="EMP_NO"/></td></tr>
	<tr><td>비밀번호 : </td><td><input type="password" name="USER_PW"/></td></tr>
	<tr>
		<td colspan="2" align=center>
			<button type="submit">로그인</submit>&nbsp;&nbsp;
		</td>
	</tr>
</table>
</center>
</form>
