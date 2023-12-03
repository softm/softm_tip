<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@ page language="java" import="org.apache.commons.lang3.StringUtils, java.util.Hashtable, org.apache.log4j.Logger, org.apache.log4j.BasicConfigurator" %>
<%!
	final Logger logger = Logger.getLogger(getClass());
%>

<%
	String BASE_ROOT = "/";
	String REST_ROOT = "/rest";
	request.setCharacterEncoding("euc-kr");
	String SELF_URL = request.getRequestURL().toString();

	// 세션에 저장되어 있는 사용자 정보를 검색한다.
	String EMP_NO   = session.getAttribute("EMP_NO"  )==null?"" :(String)session.getAttribute("EMP_NO"  );
	String EMP_NM    = session.getAttribute("EMP_NM"   )==null?"" :(String)session.getAttribute("EMP_NM"   );
	String AUTH_DIVIDE  = session.getAttribute("AUTH_DIVIDE" )==null?"" :(String)session.getAttribute("AUTH_DIVIDE" );
	String LOGIN_YN   = session.getAttribute("LOGIN_YN"  )==null?"N":(String)session.getAttribute("LOGIN_YN"  );
	String ADMIN_YN   = session.getAttribute("ADMIN_YN"  )==null?"N":(String)session.getAttribute("ADMIN_YN"  );

	boolean LOGIN_CHECK = true; //로그인체크
	boolean GRANT_CHECK = true; //권한체크
	final String SITE_TITLE = "KOGAS 이사회 업무관리";

	String strUrl = javax.servlet.http.HttpUtils.getRequestURL(request).toString();

	java.util.GregorianCalendar bCal = new java.util.GregorianCalendar();
	int yy   = bCal.get(java.util.Calendar.YEAR);
	int mm   = bCal.get(java.util.Calendar.MONTH)+1;
	int dd   = bCal.get(java.util.Calendar.DATE);
	int hh   = bCal.get(java.util.Calendar.HOUR_OF_DAY );
	int mi   = bCal.get(java.util.Calendar.MINUTE );
	int ss  = bCal.get(java.util.Calendar.SECOND );
	int wNum = bCal.get(java.util.Calendar.DAY_OF_WEEK );
	
	String[] wStrArray = new String[]{"","일","월","화","수","목","금","토"};
	
	String toDayStr = yy+"년 "+String.format("%02d",mm)+"월 "+String.format("%02d",dd)+"일 ("+wStrArray[wNum]+")";
%>