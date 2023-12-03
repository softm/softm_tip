<%
/** 
 * <pre>
 *  설  명 :  error page 처리 ( ajax용 )
 *  작성자 :  KMSLAB 개발팀
 *  작성일 :  2012-01-25
 *
 *  기타사항 :
 *  
 * Copyrights 2011 by GS ITM. All right reserved.
 * </pre>
*/
%>
<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ page isErrorPage="true" %>
<%@ page import="java.util.*, java.io.*,java.util.Date" %>
<font color=red><%=exception!=null?exception.getMessage():"" %></font>
