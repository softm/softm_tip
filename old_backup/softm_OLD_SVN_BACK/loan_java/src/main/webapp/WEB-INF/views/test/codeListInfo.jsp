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

//codeList	기본코드리스트요청
String codegrp = request.getParameter("codegrp");
String [] arrCodegrp = codegrp.split( "," );
for (int j = 0 ; j < arrCodegrp.length; j++) {
	java.util.ArrayList<CodeListItemDTO> list = new java.util.ArrayList<CodeListItemDTO>() ;
	if ("48".equals(arrCodegrp[j]) ) {
		list.add(new CodeListItemDTO("2","KTF"    ));		
		list.add(new CodeListItemDTO("6","KT알뜰폰" ));		
		list.add(new CodeListItemDTO("3","LGT"    ));		
		list.add(new CodeListItemDTO("7","LG알뜰폰" ));		
		list.add(new CodeListItemDTO("1","SKT"    ));		
		list.add(new CodeListItemDTO("5","SKT알뜰폰"));
	} else if ("78".equals(arrCodegrp[j]) ) {
		list.add(new CodeListItemDTO("01", "근로소득원천징수영수증(년)"));
		list.add(new CodeListItemDTO("02", "갑종근로소득(월)"          ));
		list.add(new CodeListItemDTO("03", "건강보험료(본인부담분)"    ));
		list.add(new CodeListItemDTO("04", "국민연금(본인부담분)"      ));
		list.add(new CodeListItemDTO("05", "최저생계비적용(가구수환산)"));
		list.add(new CodeListItemDTO("06", "통장사본확인"              ));
		list.add(new CodeListItemDTO("07", "근로소득원천징수부"        ));
		list.add(new CodeListItemDTO("08", "소득금액증명원"            ));
		list.add(new CodeListItemDTO("09", "통장거래내역은행발급분"    ));
		list.add(new CodeListItemDTO("10", "급여지급사실확인서"        ));
		list.add(new CodeListItemDTO("11", "통장 + 급여지급사실확인서" ));
		list.add(new CodeListItemDTO("90", "기타"                      ));
	} else if ("27".equals(arrCodegrp[j]) ) {
		list.add(new CodeListItemDTO("01", "아파트"));
		list.add(new CodeListItemDTO("02", "단독"  ));
		list.add(new CodeListItemDTO("03", "빌라"  ));
		list.add(new CodeListItemDTO("04", "연립"  ));
		list.add(new CodeListItemDTO("05", "다세대"));
		list.add(new CodeListItemDTO("06", "기타"  ));
		list.add(new CodeListItemDTO("07", "임대"  ));
		list.add(new CodeListItemDTO("08", "기숙사"));
		list.add(new CodeListItemDTO("09", "관사"  ));
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