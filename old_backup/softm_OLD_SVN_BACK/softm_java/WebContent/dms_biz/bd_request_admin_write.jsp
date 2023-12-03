<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>
<%
String p_req_no = StringUtils.defaultString(request.getParameter("p_req_no"),"");
out.println ("p_req_no : " +  p_req_no);
out.println ("EMP_NO : " +  EMP_NO);
%>
<form id=wForm name=wForm enctype='multipart/form-data' method='post' AUTOCOMPLETE='OFF' onsubmit='return fExec();'>
<input type='hidden' name='p_mode' size=10 value=''/>
<input type='hidden' name='p_req_no' size=10 value=''/>
<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
  <tr>
    <td><img src="images/sp3_title02.gif"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="padding-left:5px;"><img src="images/sp3_title02_4.gif"></td>
  </tr>
  <tr>
          <td bgcolor="#ffffff" align="center">
	<!----------------------------------------- 자료요구정보 --------------------------------------->
	<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
            <tr>
              <td height="30" bgcolor="#e0e0e0" style="width:90px;padding-left:10px;">제목</td>
              <td bgcolor="#ffffff" style="padding-left:10px;">
              <input type="text" name="title" class='required trim focus alert' message='제목을 입력해주세요.' size="80">
              </td>
            </tr>
            <tr>
              <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">관련 안건</td>
              <td bgcolor="#ffffff" style="padding-left:10px;">
              <input name="item_no" type="text" id="item_no" size="80" class='required trim alert' message='관련안건을 입력해주세요.' />
			  <a href=# onclick="return fOpenItem();" id="btn_item_open"><img src="images/btn_dodbogi.gif" align="absmiddle"></a>
              </td>
            </tr>
            <tr>
              <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">등록일</td>
              <td bgcolor="#ffffff" style="padding-left:10px;">
             <input type="text" name="wriet_date" id="wriet_date" value='<%=(yy+"-"+String.format("%02d-%02d", mm,dd))%>' readonly ></td>
            </tr>
            <tr>
              <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">제출 마감일</td>
              <td bgcolor="#ffffff" style="padding-left:10px;"><label>
              <input type='text' name='end_date' id='end_date' value='<%=(yy+"-"+String.format("%02d-%02d", mm,dd))%>' readonly  size="10" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.wForm.end_date,"yyyy-mm-dd",this)'>              
              </label>
              </td>
            </tr>
            <tr>
              <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">담당 부서</td>
              <td bgcolor="#ffffff" style="padding-left:10px;"><input type="text" name="dept_id" id="dept_id" class='required trim alert' message='담당부서를 선택해주세요.' />
              &nbsp;
			  <a href=# onclick="return fOpenManagerDept();" id="btn_dept_open"><img src="images/btn_dodbogi.gif" align="absmiddle"></a>              
              </td>
            </tr>
            <tr>
              <td height="100" bgcolor="#e0e0e0" style="padding-left:10px;">요청내용</td>
              <td bgcolor="#ffffff" style="padding-left:10px;"><textarea name="req_context" id="req_context" cols="70" rows="5" class='required trim alert' message='요청내용을 입력해주세요.' ></textarea></td>
            </tr>
    </table>
	<!----------------------------------------- 자료요구정보 끝 --------------------------------------------->
	</td>
        </tr>
  <tr>
  <!-- 컨트롤 버튼 부분 시작 -->
          <td height="40" align="right" style="padding-right:5px;">
<%
if ( p_req_no.equals("") ) {
%>          
	   <input type="image" src="images/btn_save.gif" border="0">&nbsp;
	   <a href="#" onfocus='blur()' onclick="return fList();"><img src="images/btn_list.gif" border="0"></a>
<%
} else {
%>
	   <a href="#" onfocus='blur()' onclick="return fDelete();"><img src="images/btn_del.gif" border="0"></a>&nbsp;
	   <input type="image" src="images/btn_save.gif" border="0">&nbsp;
	   <a href="#" onfocus='blur()' onclick="return fRequest();"><img src="images/btn_request.gif" border="0"></a>&nbsp;
	   <a href="#" onfocus='blur()' onclick="return fList();"><img src="images/btn_list.gif" border="0"></a>
<%
}
%>
		</td>
        </tr>
  <tr>
    <td><img src="images/sp_bottom.gif"></td>
  </tr>
</table>
</form>