<%
/** 
 * <pre>
 *  설  명 :  샘플 - 작성
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
String p_no = request.getParameter("p_no");
%>
<!-- <form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'> -->
<form id=wForm name=wForm enctype='multipart/form-data' method='post' AUTOCOMPLETE='OFF' onsubmit='return fExec();'>
<input type='hidden' name='p_mode' size=10 value=''/>
<input type='hidden' name='p_no' size=10 value=''/>
<table border="0" cellpadding="0" cellspacing="0" id="admin2" width="700">
    <tr>
	<td id="t1"><span id="pt">*</span> 구분</td>
	<td>
	<div id="tag_div_code">-구분-</div>
	</td>
  </tr>
    <tr>
	<td id="t1"><span id="pt">*</span> 제목</td>
	<td><input type="text" name="subject" style="width:510px" class='required trim focus alert' maxlength=100 minlength=0 message='제목을 입력해주세요.'/></td>
  </tr>
  <tr>
    <td id="t1"><span id="pt">*</span> 내용</td>
	<td><textarea name="context" cols="45" rows="5" style="width:510px" class='required trim focus alert' message='내용을 입력해주세요.'/></textarea></td>
  </tr>
    <tr>
	<td id="t1"><span id="pt">*</span> 작성자</td>
	<td><input type="text" name="writer" style="width:510px" class='required trim focus alert' maxlength=100 minlength=0 message='작성자를 입력해주세요.' value="<%=EMP_NM%>" /></td>
  </tr>
    <tr>
	<td id="t1"><span id="pt">*</span> 첨부파일</td>
	<td><input type="file" name="att_file" style="width:310px"/><span id="real_att_file" style="width:210px;text-align:left"></span></td>
  </tr>
</table>
<div id="form_btn">
<button type="submit">저장</button>
<button type="button" onclick="fList()">목록</button>
</div>
</form>