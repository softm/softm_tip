<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="com.kogas.dms.common.Util"%>
<%@page errorPage="/common/error.jsp" %>
<%@include file="/inc/common.inc" %>
<%
String p_dir = StringUtils.defaultString(request.getParameter("p_dir"));  // 
String p_prg = StringUtils.defaultString(request.getParameter("p_prg"));  // 
//out.println("p_dir : " + p_dir + "<br>");
//out.println("p_prg : " + p_prg + "<br>");
%>
<%
boolean reqLogin = false;
try {
	if ( p_dir.equals( "sub03" ) ) {
		if ( LOGIN_YN.equals("N") && p_prg.equals( "sub03_1_write" ) ) {
			reqLogin = true;	
		}
	}
	if ( reqLogin ) {
		pageContext.include("/sub00/login.jsp");
	} else {
		if ( !p_dir.equals("") && !p_prg.equals("") ) {
			pageContext.include(p_dir + "/" + p_prg + ".jsp");
		} else {
		    throw new Exception("ui.jsp [ 적용할 ui가 없습니다. ]");
		}
	}
	

} catch ( ServletException e ) {
    throw new ServletException("ui.jsp [ 적용할 ui가 없습니다. ]");
} catch ( Exception e ) {
    throw new Exception(e);
}
%>	
