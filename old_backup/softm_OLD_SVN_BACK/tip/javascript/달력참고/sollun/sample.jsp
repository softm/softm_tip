<%@ page contentType="text/html; charset=euc-kr" %>
<%@ page import="SolLun" %>
<jsp:useBean id="test" class="SolLun"/>
<%
String action = request.getParameter("action");
String date   = request.getParameter("date");
String sleap  = request.getParameter("leap");

boolean leap  = false;
if(action == null) action = "";
if(date   == null) date   = "";
if(sleap  == null) sleap  = "";
if(sleap.equals("0")) leap  = false;
else leap = true;

int yyyy = 0;
int mm   = 0;
int dd   = 0;
String in_sol_date = "";
String in_lun_date = "";
String lun_date = "";
String sol_date = "";

if(action.equals("lun")) {

    yyyy = Integer.parseInt(date.substring(0,4));
    mm   = Integer.parseInt(date.substring(5,7));
    dd   = Integer.parseInt(date.substring(8,10));
    in_sol_date = date;
    lun_date = test.SolToLun(yyyy,mm,dd);

}
if(action.equals("sol")) {

    yyyy = Integer.parseInt(date.substring(0,4));
    mm   = Integer.parseInt(date.substring(5,7));
    dd   = Integer.parseInt(date.substring(8,10));
//    if(yyyy%4 == 0 && yyyy%100>0 && yyyy%400==0) leap = true;
//    else leap = false;
    
    in_lun_date = date;
    sol_date = test.LunToSol(yyyy,mm,dd,leap);
}
%>

<HTML>
<BODY>
    <FORM method="post" action="sample.jsp">
        <INPUT type="hidden" name="action" value="lun">
        <INPUT type="text" name="date" size="10" maxlength="10" value="<%=in_sol_date%>">
        <INPUT type="submit" value="양력을 음력으로">
        <%=lun_date%>
    </FORM><BR>
    <FORM method="post" action="sample.jsp">
        <INPUT type="hidden" name="action" value="sol">
<%
if(sleap.equals("0")) {
%>
        <INPUT type="radio" name="leap" value="0" checked>평달
        <INPUT type="radio" name="leap" value="1">윤달
<%
} else {
%>
        <INPUT type="radio" name="leap" value="0">평달
        <INPUT type="radio" name="leap" value="1" checked>윤달
<%
}
%>
        <INPUT type="text" name="date" size="10" maxlength="10" value="<%=in_lun_date%>">
        <INPUT type="submit" value="음력을 양력으로">
        <%=sol_date%>
    </FORM>
</BODY>
</HTML>
