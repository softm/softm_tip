<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="com.kogas.dms.common.Util"%>
<%@page errorPage="/common/error.jsp" %>
<%@include file="/inc/common.inc" %>

<%
	String p_prg = StringUtils.defaultString(request.getParameter("p_prg"));  // main menu index
	String info[] = p_prg.split("/");
	String tmpDir = Util.stringJoin("/",Util.stringSlice(0,info.length-1,info));

	final String dir = (!tmpDir.equals("")?tmpDir:tmpDir);
	final String pg  = info[info.length-1];
	final int PARAM_LIMIT  = 20;
 
	Boolean ex = true;   
	String params = new String("");
	java.util.Enumeration<String> names = ((HttpServletRequest) request).getParameterNames();

	while (names.hasMoreElements()) {
    	String name = (String) names.nextElement();
    	if ( name.length() > PARAM_LIMIT ) { ex = false; break; }
    	String[] v = request.getParameterValues(name);

    	if ( !name.equals("p_prg") ) {
        	for(int i=0;i<v.length; i++) {
            	if (v[i].length() > PARAM_LIMIT ) { ex = false; break; }
            	params += (params.equals(""))?name + "=" + v[i]:"&"+name + "=" + v[i];
        	}
        	if ( !ex ) break;
    	}
	}

	if ( !ex ) return;
%>
<%@include file="/inc/header.inc" %>
<style>.textOf {overflow:hidden;text-overflow:ellipsis;}</style>
<script language="javascript" type="text/javascript" src="<%=REST_ROOT%>/member/session_js_var"></script>
<script language="javascript" type="text/javascript" src="<%=BASE_ROOT%>dms_main/js/login.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
	$(function() {
        if ( "<%=pg%>" ) getUI("<%=dir%>","<%=pg%>",{params:"<%=params%>"});
	});
//-->
</script>

<body leftmargin="0" topmargin="0" background="/images/bg_line.gif">
<table width="1300" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td>
		<!----- TOP 플레쉬 메뉴 시작 ---------------------------------------->
		<script>fFlash_Activate('/flash/menu.swf', '1008', '86');</script>
		<!----- TOP 플레쉬 메뉴 끝 ------------------------------------------>
<a href="/service.jsp?p_prg=dms_main/login">로그인</a>/
<a href="#" onclick="return Common.logout();">로그아웃</a>
<%=EMP_NM%> / <%=EMP_NO%> / <%=LOGIN_YN%> / <%=ADMIN_YN%>
	</td>
</tr>
<tr>
	<td>
		<table width="981" border="0" cellspacing="0" cellpadding="0">
      	<tr>
        	<td width="19">&nbsp;</td>
        	<td width="187" valign="top">
				<!----- 왼쪽 서브메뉴 시작 --------------------------------------->
				<%@include file="/inc/left.inc" %> 
				<!----- 왼쪽 서브메뉴 끝 ----------------------------------------->
			</td>
        	<td width="19">&nbsp;</td>
        	<td width="756" valign="top" id=contents></td>
		</tr>
		</table>
	</td>
</tr>
<tr>
	<td><img src="/images/bottom.gif"></td>
</tr>
</table>
<!----- 개발 디버깅 용도 --------------------------------------->
<%@include file="/inc/footer.inc" %>
