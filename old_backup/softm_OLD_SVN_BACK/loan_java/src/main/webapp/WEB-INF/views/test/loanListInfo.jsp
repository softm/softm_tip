<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="com.google.gson.Gson"%>
<%@page import="java.util.HashMap"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@include file="/inc/common_json.jsp" %>
<%
Gson gson = new Gson();
HashMap data = new HashMap();
data.put("RESULT_CD","0");
//data.put("RESULT_MSG","성공");

java.util.ArrayList<HashMap> list = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put( "LOANREQ_SEQ", "11233" + i ); // 신청번호
	item.put( "PT_CUST_NO", "12340" + i ); // 고객번호
	item.put( "USER_NAME", "홍길동" ); // 고객명
	item.put( "REGISTER_NO", "7612201234567" ); // 주민등록번호
	item.put( "MOBILE_NO", "010-9071-7218" ); // 휴대폰번호
	item.put( "LOAN_STATE_CD", i==0?"21":"13" ); // 처리상태
	item.put( "IDCARD_VERIFY_RESULT", i==0?"Y":"N" ); // 처리상태
	item.put( "CODE_VAL2", i==0?"J":"N" ); // 처리상태
	item.put( "LOANREQ_DATIME", "2017.01.19" ); // 등록일자
//  item.put( "LOANREQ_SEQ", "3232" ); // 수정일자
//	item.put( "LOANREQ_SEQ", "1" ); // 신청번호
	item.put( "PT_CUST_NO", "99904" ); // 고객번호
	item.put( "ADMIN_NO", "123456" ); // 담당자
	item.put( "LOAN_STATE_NM", "상태값." ); // 담당자

	list.add(item);
}
data.put("LIST",list);

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
	out.write(callBack + "(" + gson.toJson(data) + ")");
	System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
	out.println ( gson.toJson(data) ) ;
}
%>