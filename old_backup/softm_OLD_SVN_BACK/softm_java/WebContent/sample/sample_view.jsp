<%
/** 
 * <pre>
 *  설  명 :  샘플 - 보기
 *  작성자 :  김지훈
 *  작성일 :  2012-07-09
 *
 *  기타사항 :
 *  
 * Copyrights 2012 by KOGAS. All right reserved.
 * </pre>
*/
%>
<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@include file="/inc/common.inc" %>
<%
String p_no= request.getParameter("p_no");
out.println("p_no : " + p_no);
%>
<!-- <form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'> -->
<form id=wForm name=wForm enctype='multipart/form-data' method='post' AUTOCOMPLETE='OFF' onsubmit='return 실행();'>
<input type='hidden' name='no' size=10 value=''/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
    <tr>
	<td id="t1"><span id="pt">*</span> 구분</td>
	<td>
	<div id="code_name"></div>
	</td>
  </tr>
    <tr>
	<td id="t1"><span id="pt">*</span> 제목</td>
	<td><div id="subject" style="width:510px"></div></td>
  </tr>
  <tr>
    <td id="t1"><span id="pt">*</span> 내용</td>
	<td><div id="context" cols="45" style="width:510px"></div></td>
  </tr>
    <tr>
	<td id="t1"><span id="pt">*</span> 작성자</td>
	<td><div id="writer" style="width:510px"></div></td>
  </tr>
    <tr>
	<td id="t1"><span id="pt">*</span> 첨부파일</td>
	<td><div id="real_att_file" style="width:510px"></div></td>
  </tr>
</table>
<div id="form_btn">
<button type="button" onclick="fGoUpdate(<%=p_no%>)">수정</button>
<button type="button" onclick="fDelete(<%=p_no%>)">삭제</button>
<button type="button" onclick="fList()">목록</button>
</div>
</form>