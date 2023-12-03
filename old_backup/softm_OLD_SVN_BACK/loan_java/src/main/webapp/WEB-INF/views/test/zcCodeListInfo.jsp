<%@ page language="java" contentType="application/javascript; charset=UTF-8" pageEncoding="UTF-8"%>
<%@page import="com.google.gson.Gson"%>
<%@page import="java.util.HashMap"%>
<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core"%>
<%@include file="/inc/common_json.jsp" %>
<%!
/**
 * CodeListItemDTO
 * @author softm 
 */
public class CodeListItemDTO {
	
		private String CODE;	
		private String NAME;
		public String getCODE() {
			return CODE;
		}
		public void setCODE(String cODE) {
			CODE = cODE;
		}
		public String getNAME() {
			return NAME;
		}
		public void setNAME(String nAME) {
			NAME = nAME;
		}
		public CodeListItemDTO(String cODE, String nAME) {
			super();
			CODE = cODE;
			NAME = nAME;
		}
		
		
}
%>
<%
Gson gson = new Gson();
HashMap data = new HashMap();
data.put("RESULT_CD","0");
//data.put("RESULT_MSG","성공");

//zccodeList	공통코드리스트요청

String codegrp = request.getParameter("codegrp");
String [] arrCodegrp = codegrp.split( "," );
for (int j = 0 ; j < arrCodegrp.length; j++) {
	java.util.ArrayList<CodeListItemDTO> list = new java.util.ArrayList<CodeListItemDTO>() ;
	if ("A07".equals(arrCodegrp[j]) ) {
		list.add(new CodeListItemDTO("01","자금용도1" ));
		list.add(new CodeListItemDTO("02","자금용도2" ));
	} else if ("A01".equals(arrCodegrp[j]) ) {
		list.add(new CodeListItemDTO("01","주민등록증" ));
		list.add(new CodeListItemDTO("02","운전면허증" ));
	} else if ("A03".equals(arrCodegrp[j]) ) {
		list.add(new CodeListItemDTO("01","일반사업자" ));
		list.add(new CodeListItemDTO("02","면세사업자" ));
	} else if ("A04".equals(arrCodegrp[j]) ) {
		list.add(new CodeListItemDTO("01","본인" ));
		list.add(new CodeListItemDTO("02","본인외" ));
	} else if ("A05".equals(arrCodegrp[j]) ) { // 사업장 접근성
		list.add(new CodeListItemDTO("01","사업장 접근성1" ));
		list.add(new CodeListItemDTO("02","사업장 접근성2" ));
	} else if ("A06".equals(arrCodegrp[j]) ) { // 주소
		list.add(new CodeListItemDTO("01", "아파트"));
		list.add(new CodeListItemDTO("02", "단독"  ));
		list.add(new CodeListItemDTO("03", "빌라"  ));
		list.add(new CodeListItemDTO("04", "연립"  ));
		list.add(new CodeListItemDTO("05", "다세대"));
		list.add(new CodeListItemDTO("06", "기타"  ));
		list.add(new CodeListItemDTO("07", "임대"  ));
		list.add(new CodeListItemDTO("08", "기숙사"));
		list.add(new CodeListItemDTO("09", "관사"  ));
	} else if ("A02".equals(arrCodegrp[j]) ) { // 주택소유형태
		list.add(new CodeListItemDTO("01","자가" ));  // 자가  
		list.add(new CodeListItemDTO("04","전세" ));  // 전세  
		list.add(new CodeListItemDTO("05","월세" ));  // 월세  
		list.add(new CodeListItemDTO("06","기타" ));  // 기타  
		list.add(new CodeListItemDTO("07","공동명의" ));  // 공동명의
		
	} else if ("Z12".equals(arrCodegrp[j]) ) { // 사업장소유형태
		list.add(new CodeListItemDTO("01","자가" ));
		list.add(new CodeListItemDTO("02","임대" ));
	}
	data.put("CODEGRP" + arrCodegrp[j].toUpperCase(),list);
}

//jQuery11120815090643519593_1485333130400({"CODEGRP78":[{"CODE":"01","NAME":"근로소득원천징수영수증(년)"},{"CODE":"02","NAME":"갑종근로소득(월)"},{"CODE":"03","NAME":"건강보험료(본인부담분)"},{"CODE":"04","NAME":"국민연금(본인부담분)"},{"CODE":"05","NAME":"최저생계비적용(가구수환산)"},{"CODE":"06","NAME":"통장사본확인"},{"CODE":"07","NAME":"근로소득원천징수부"},{"CODE":"08","NAME":"소득금액증명원"},{"CODE":"09","NAME":"통장거래내역은행발급분"},{"CODE":"10","NAME":"급여지급사실확인서"},{"CODE":"11","NAME":"통장 + 급여지급사실확인서"},{"CODE":"90","NAME":"기타"}],"CODEGRP48":[{"CODE":"KTF","NAME":"KTF"},{"CODE":"KTU","NAME":"KT알뜰폰"},{"CODE":"LGT","NAME":"LGT"},{"CODE":"LGU","NAME":"LG알뜰폰"},{"CODE":"SKT","NAME":"SKT"},{"CODE":"SKU","NAME":"SKT알뜰폰"}]})
if ( DATA_TYPE.equals("jsonp") ) { //jsonp
	out.write(callBack + "(" + gson.toJson(data) + ")");
	System.out.println(callBack + "(" + gson.toJson(data) + ")");
} else if ( DATA_TYPE.equals("json") ) { //json
	out.println ( gson.toJson(data) ) ;
}
%>