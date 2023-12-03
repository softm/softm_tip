<%@page import="java.util.HashMap"%>
<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="com.google.gson.Gson"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@include file="/inc/common_json.jsp" %>
<%
Gson gson = new Gson();
HashMap data = new HashMap();
data.put("RESULT_CD","0");
//data.put("RESULT_MSG","성공");
data.put("LOANREQ_SEQ"  ,"1");
data.put("PT_CUST_NO"   ,"11");
data.put("LOAN_STATE_CD","C");
data.put("ADMIN_NO"     ,"1");

data.put("USER_NAME"       ,"테스터");
data.put("USER_IDNO"       ,"1234561234567");
data.put("MOBILE_AGENCY_CD"  ,"SK");
data.put("MOBILE_NO1"        ,"010");
data.put("MOBILE_NO2"        ,"9071");
data.put("MOBILE_NO3"        ,"7218");

data.put("BEFORE_WANT_AMT" ,"10000000");
data.put("FUND_USE"        ,"자금용도코드명");

data.put("DLOAN_TOT_COUNT"        ,"10000");    // 대부업대출 총건수
data.put("DLOAN_RES_COUNT"        ,"100000");   // 대부업대출 응답건수
data.put("DLOAN_ACC_COUNT"        ,"1000000");  // 대부업대출 누적건수
data.put("DLOAN_TOT_AMT"          ,"10000000"); // 대부업대출 총금액

data.put("SUMMARY_PRVT_CNT"        ,"10000");    // 대부업대출 응답건수
data.put("SUMMARY_PRVT_NOTDEFINED"              ,"10000");    // 대부업대출 누적건수
data.put("SUMMARY_PRVT_TOT_AMT"    ,"10000");    // 대부업대출 총금액 
data.put("SUMMARY_ACC_PRVT_CNT"    ,"10000");    // 

data.put("LOAN_TOT_CNT" ,"10");
java.util.ArrayList<HashMap> list1 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("LOAN_REASON_NM"        ,"대출정보");
	item.put("LOAN_COMPANY_NAME"     ,"softm");
	item.put("LOAN_BRANCH_NAME"      ,"abcdefg");
	item.put("LOAN_BEGIN_DT"         ,"20170119");
	item.put("LOAN_UPDATE_DT"        ,"20170119");
	item.put("LOAN_AMOUNT"           ,"1234");
	item.put("LOAN_MORT_YN"          ,"Y");
	list1.add(item);
}
data.put("LIST_LOAN",list1); // 대출정보

data.put("CASH_TOT_CNT" ,"20");
java.util.ArrayList<HashMap> list2 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("CASH_REASON_NM"      ,"현금서비스정보");
	item.put("CASH_COMPANY_NAME"   ,"softm");
	item.put("CASH_BRANCH_NAME"    ,"abcdefg");
	item.put("CASH_BEGIN_DT"       ,"20170119");
	item.put("CASH_UPDATE_DT"      ,"20170119");
	item.put("CASH_AMOUNT"         ,"1234");
	list2.add(item);
}
data.put("LIST_CASH",list2); // 현금서비스정보

data.put("GRNTY_TOT_CNT" ,"30");
java.util.ArrayList<HashMap> list3 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("GRNTY_REASON_NM"      ,"채무보증정보");
	item.put("GRNTY_COMPANY_NAME"   ,"softm");
	item.put("GRNTY_BRANCH_NAME"    ,"abcdefg");
	item.put("GRNTY_BEGIN_DT"       ,"20170119");
	item.put("GRNTY_UPDATE_DT"      ,"20170119");
	item.put("GRNTY_AMOUNT"         ,"1234");
	list3.add(item);
}
data.put("LIST_GRNTY",list3); // 채무보증정보

data.put("PES_LOAN_TOT_COUNT" ,"40");
java.util.ArrayList<HashMap> list4 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("PES_REASON_NM"         ,"사유코드"); // 사유코드
	item.put("PES_COMPANY_NAME"      ,"발생기관명"); // 발생기관명
	item.put("PES_BRANCH_NAME"       ,"발생저점명"); // 발생저점명
	item.put("PES_BANK_CODE_NM"      ,"전은연업권코드"); // 전은연업권코드
	item.put("PES_COMPANY_CODE"      ,"발생기관코드"); // 발생기관코드
	item.put("PES_BEGIN_DT"          ,"20170119"); // 개설일,발생일
	item.put("PES_UPDATE_DT"         ,"20170119"); // 변경일자
	item.put("PES_AMOUNT"            ,"123456789"); // 금액
	item.put("PES_ACOUNT_NO"         ,"계좌번호"); // 계좌번호
	item.put("PES_LOAN_TYPE_NM"      ,"대출구분"); // 대출구분
	list4.add(item);
}
data.put("LIST_PES",list4); // 개인계좌별대출정보

java.util.ArrayList<HashMap> listCbscore = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("CBSCORE_TYPE_NM"      ,"신용위헙평점"); // CB스코어구분명		
	item.put("CBSCORE_SCORE"        ,"10000"); // 신용평점
	item.put("CBSCORE_GRADE"        ,"A");    // 신용등급
	item.put("CBSCORE_REFERENCE1"   ,"10.11");// 등급별불량율
	item.put("CBSCORE_REFERENCE2"   ,"1");    // 누적순위
	
	item.put("NICE_SOHO_GRADE"   ,"1000");    // 
	item.put("NICE_SOHO_AVG"   ,"2000");    // 
	listCbscore.add(item);
}
data.put("LIST_CBSCORE",listCbscore); // 금융 CB스코어[RK0400_000]

java.util.ArrayList<HashMap> list5 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("CBSCORE_CODE"      ,"평점사유코드-긍정적요인");
	item.put("CBSCORE_NAME"   ,"평점사유코드-긍정적요인 설명");
	list5.add(item);
}
data.put("LIST_CBS_GOOD",list5); // 평점사유코드-긍정적요인

java.util.ArrayList<HashMap> list6 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("CBSCORE_CODE"      ,"평점사유코드-부정적요인");
	item.put("CBSCORE_NAME"   ,"평점사유코드-부정적요인 설명");
	list6.add(item);
}
data.put("LIST_CBS_BAD",list6); // 평점사유코드-부정적요인

java.util.ArrayList<HashMap> list7 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("DEBT_CODE"           ,"업권코드"); // 업권코드
	item.put("DEBT_LOAN_DATE"      ,"20161213"); // 대출일자
	item.put("DEBT_LOAN_VAL"       ,"100000000"); // 대출잔액
	list7.add(item);
}
data.put("LIST_DEBT",list7); // 대부업종합대출정보(1차)

java.util.ArrayList<HashMap> list8 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("PRVT_LOAN_COMPANY_IND_CODE_NM" ,"업권코드"); // 업권코드
	item.put("PRVT_LOAN_BEGIN_DT"            ,"20161214"); // 대출일자
	item.put("PRVT_LOAN_AMOUNT"              ,"10000000"); // 대출잔액
	list8.add(item);
}
data.put("LIST_PRVT_LOAN",list8); // 대부업대출정보(2차)

java.util.ArrayList<HashMap> list9 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("PRVT_GRNTY_REASON_NM" ,"사유코드코드"); // 사유코드코드
	item.put("PRVT_GRNTY_BEGIN_DT"  ,"20161215"); // 개설일자
	item.put("PRVT_GRNTY_UPDATE_DT" ,"20161216"); // 변경일자
	item.put("PRVT_GRNTY_AMOUNT" ,"10000000"); // 개설금액
	list9.add(item);
}
data.put("LIST_PRVT_GRNTY",list9); // 대부업채무불이행정보

java.util.ArrayList<HashMap> list10 = new java.util.ArrayList<HashMap>() ;
for ( int i=0;i<2;i++) {
	HashMap item = new HashMap();
	item.put("PRVT_DEFAULT_REASON_NM"      ,"업권코드");    // 사유코드
	item.put("PRVT_DEFAULT_BEGIN_DT"       ,"20161217"); // 발생일
	item.put("PRVT_DEFAULT_PROVIDE_DT"     ,"20161218"); // 제공일
	item.put("PRVT_DEFAULT_DEFAULT_AMOUNT" ,"10000000"); // 연체금액
	list10.add(item);
}
data.put("LIST_PRVT_DEFAULT",list10); // 대부업채무불이행정보

if ( DATA_TYPE.equals("jsonp") ) { //jsonp
	out.write(callBack + "(" + gson.toJson(data) + ")");
	System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
	out.println ( gson.toJson(data) ) ;
}
%>