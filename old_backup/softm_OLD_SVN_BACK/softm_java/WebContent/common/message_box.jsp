<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@include file="/inc/common.inc" %>
<%
String p_message = StringUtils.defaultString(request.getParameter("p_message"));
String p_ok      = StringUtils.defaultString(request.getParameter("p_ok"));
String p_height  = StringUtils.defaultString(request.getParameter("p_height"));
%>
<table cellspacing="0" cellpadding="0" border="0" class="text_01" align=center <%=(!p_height.equals("")?"style='height:" + p_height+";vertical-align:center;border: 1 solid red'":"style='vertical-align:middle'")%> style=''>
<td style="background-color:#FFF">
<table width="300" cellspacing="0" cellpadding="0" border="0" class="text_01" style="background-color:#FFF">
<tbody>
    <tr bgcolor="#cccccc"> 
      <td height="10" bgcolor="#ffffff"></td>
    </tr>
    <tr bgcolor="#cccccc"> 
      <td height="2" bgcolor="#f5f5f5"></td>
    </tr>
    <tr bgcolor="#cccccc"> 
      <td height="1" bgcolor="#cccccc"></td>
    </tr>
    <tr> 
      <td height="20" align="right"></td>
    </tr>    <tr bgcolor="#cccccc"> 
      <td bgcolor="#ffffff" align="center"><b><%=p_message%></b></td>
    </tr>
    <tr bgcolor="#cccccc">
      <td height="10" bgcolor="#ffffff"></td>
    </tr> 
    <tr bgcolor="#cccccc"> 
      <td height="2" bgcolor="#f5f5f5"></td>
    </tr>
    <tr bgcolor="#cccccc"> 
      <td height="1" bgcolor="#cccccc"></td>
    </tr>
    <tr> 
      <td height="20" align="right"></td> 
    </tr>
    <tr align="center">  
      <td height="30"><a onclick="<%=p_ok%>" href="#"><img border="0" src="<%=BASE_ROOT%>/images/softm/confirm.gif"></a></td>
    </tr>
    <tr> 
      <td height="20"></td>
    </tr>
    <tr> 
      <td height="1" bgcolor="#cccccc"></td>
    </tr>
    <tr> 
      <td height="2" bgcolor="#f5f5f5"></td>
    </tr>
</tbody>
</table>
</td>
</table>
