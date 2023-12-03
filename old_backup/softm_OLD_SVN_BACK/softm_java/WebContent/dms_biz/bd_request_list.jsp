<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>
		<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="images/sp3_title02.gif"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:5px;"><img src="images/sp3_title02_1.gif"></td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
<form id="sForm" name="sForm" method="POST" onsubmit="return fList(null,1);">   
<input type="submit" style="display:none">          
			<!----------------------------------------- 검색조건 테이블 --------------------------------------->
<%
if ( ADMIN_YN.equals("Y") ) {
%>
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#ffffff"><table width="730" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80" height="30" align="center">등록일</td>
                    <td align="left"><label>
<input type='text' name='s_wriet_date_frm' id='s_wriet_date_frm' value='<%=(yy+"-01-01")%>' readonly  size="10" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.sForm.s_wriet_date_frm,"yyyy-mm-dd",this)'>
~
<input type='text' name='s_wriet_date_to' id='s_wriet_date_to' value='<%=(yy+"-"+String.format("%02d-%02d", mm,dd))%>' readonly  size="10" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.sForm.s_wriet_date_to,"yyyy-mm-dd",this)'>
                    </label></td>
                    <td align="center" width="80">이사명</td>
                    <td align="left"><input name="s_ko_name" type="text" id="s_ko_name" size="35" /></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">제목</td>
                    <td align="left"><input name="s_title" type="text" id="s_title" size="35"></td>
                    <td align="center">처리상태</td>
                    <td><label><span id="tag_status">-구분-</span></label></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">답변유형</td>
                    <td align="left"><label><span id="tag_req_gubun">-구분-</span></label></td>
                    <td align="center">담당부서</td>
                    <td><input name="s_dept_id" type="text" id="s_dept_id" size="30">&nbsp;
                    <a href=# onclick="return fOpenManagerDept();" id="btn_dept_open"><img src="images/btn_dodbogi.gif" align="absmiddle"></a>              
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table>
<%
} else {
%>
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#ffffff"><table width="730" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80" height="30" align="center">등록일</td>
                    <td align="left"><label>
<input type='text' name='s_wriet_date_frm' id='s_wriet_date_frm' value='<%=(yy+"-01-01")%>' readonly  size="10" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.sForm.s_wriet_date_frm,"yyyy-mm-dd",this)'>
~
<input type='text' name='s_wriet_date_to' id='s_wriet_date_to' value='<%=(yy+"-"+String.format("%02d-%02d", mm,dd))%>' readonly  size="10" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.sForm.s_wriet_date_to,"yyyy-mm-dd",this)'>
                    </label></td>
		                     
                    <td align="center" width="80">이사명</td>
                    <td align="left"><input name="s_charge_user" type="text" id="s_charge_user" size="35" /></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">제목</td>
                    <td align="left"><input name="s_title" type="text" id="s_title" size="35"></td>
                    <td align="center">&nbsp</td>
                    <td>&nbsp</td>
                  </tr>
                </table></td>
              </tr>
            </table>
<%
}
%>            
</form>	            
			<!----------------------------------------- 검색조건테이블 끝 --------------------------------------------->
			</td>
          </tr>
		  <tr>
            <td><table width="100%">
			    <tr>
				<!---------------------- 검색버튼 부분 -------------------------------->
					<td><a href="#" onfocus='blur()' onclick="return fList(null,1);"><img src="images/btn_search.gif" align="right" border="0"></a></td>
			    </tr>
				</table>
				</td>
          </tr>
		  <tr>
            <td>&nbsp;</td>
          </tr>
		  
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!-- 답변유형 리스트 테이블 시작 -->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
			    <td height="30" align="center" bgcolor="#e0e0e0">답변<br />
		        유형</td>
                <td height="30" align="center" bgcolor="#e0e0e0">이사명</td>
                <td align="center" width="240" bgcolor="#e0e0e0">제목</td>
                <td align="center" bgcolor="#e0e0e0">등록일</td>
                <td align="center" bgcolor="#e0e0e0">제출마감일</td>
                <td align="center" bgcolor="#e0e0e0">작성자</td>
                <td align="center" bgcolor="#e0e0e0">담당부서</td>
                <td align="center" bgcolor="#e0e0e0">처리상태</td>
              </tr>
              <tbody id="list_data">
              <tr>
                <td colspan="8" tabindex='1' height="30" align="center" bgcolor="#ffffff">검색된 자료가 없습니다.</td>
              </tr>              
              </tbody>
            <!--   <tfoot>
              	<tr>
              	<td id="page_navi1" height="30" bgcolor="#ffffff" style="text-align:center" align=center colspan="8">
              	</td>
              	</tr>
              </tfoot>   -->                   

              </table>
			<!-- 답변유형 리스트 테이블 끝 -->
			</td>
          </tr>
		  <tr>
		  <!-- 컨트롤 버튼 부분 시작 -->
            <td height="40" align="right" style="padding-right:5px;">
<%
if ( ADMIN_YN.equals("Y") ) {
%>            
			   <a href="#" onfocus='blur()' onclick="return fGoAdminWrite();"><img src="images/btn_reg_1.gif" border="0"></a>&nbsp;
			   <a href="#" onfocus='blur()' onclick="return fExcel();"><img src="images/btn_exel.gif" border="0"></a></td>
<%
}
%>
          </tr>
		  
		  <tr>
		    <td><img src="images/sp_bottom.gif"></td>
		  </tr>
        </table>
        
			<table width="250" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td id="page_navi" height="30" bgcolor="#ffffff" style="text-align:center" ></td>
  </tr> 
  </table>        

