<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%
	String BASE_ROOT = "/";
	String REST_ROOT = "/rest";
	request.setCharacterEncoding("UTF-8");
	String SELF_URL = request.getRequestURL().toString();

	// 세션에 저장되어 있는 사용자 정보를 검색한다.
	// String EMP_NO   = session.getAttribute("EMP_NO"  )==null?"" :(String)session.getAttribute("EMP_NO"  );
	// String EMP_NM    = session.getAttribute("EMP_NM"   )==null?"" :(String)session.getAttribute("EMP_NM"   );
	// String AUTH_DIVIDE  = session.getAttribute("AUTH_DIVIDE" )==null?"" :(String)session.getAttribute("AUTH_DIVIDE" );
	// String LOGIN_YN   = session.getAttribute("LOGIN_YN"  )==null?"N":(String)session.getAttribute("LOGIN_YN"  );
	// String ADMIN_YN   = session.getAttribute("ADMIN_YN"  )==null?"N":(String)session.getAttribute("ADMIN_YN"  );

	// boolean LOGIN_CHECK = true; //로그인체크
	// boolean GRANT_CHECK = true; //권한체크
	//final String SITE_TITLE = "참 저축은행";
	final String SITE_TITLE = "";

	String strUrl = javax.servlet.http.HttpUtils.getRequestURL(request).toString();
    pageContext.setAttribute("strUrl", strUrl) ;
    
    String uri = request.getRequestURI();
    String pageName = uri.substring(uri.lastIndexOf("/")+1);
    pageContext.setAttribute("pageName", pageName) ;
    
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
