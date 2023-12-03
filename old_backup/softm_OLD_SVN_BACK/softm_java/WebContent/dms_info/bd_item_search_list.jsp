<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>

<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="/images/sp1_title06.gif"></td>
          </tr>
          
          <tr>
            <td style="padding-left:5px;"><img src="/images/sp3_title02_1.gif"></td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
<form id="sForm" name="sForm" method="POST" onsubmit="return fList(null,1);">            
			<!----------------------------------------- 검색조건 테이블 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#ffffff"><table width="730" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80" height="30" align="center">제안일</td>
                    <td align="left"><label>
<input type='text' name='s_bd_start_day_frm' id='s_bd_start_day_frm' value='<%=(yy+"-01-01")%>' readonly  size="10" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.sForm.s_bd_start_day_frm,"yyyy-mm-dd",this)'>
~
<input type='text' name='s_bd_start_day_to' id='s_bd_start_day_to' value='<%=(yy+"-"+String.format("%02d-%02d", mm,dd))%>' readonly  size="10" maxlength= />&nbsp;<img src="/images/btn_cal.gif" onclick='displayCalendar(document.sForm.s_bd_start_day_to,"yyyy-mm-dd",this)'>
                    </label></td>
                    <td align="center" width="80">회의명</td>
                    <td align="left"><span id="tag_name_code">-구분-</span></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">회차</td>
                    <td align="left"><input name="s_bd_no" type="text" id="s_bd_no" size="35"></td>
                    <td align="center">의안명</td>
                    <td><label>
                      <input name="s_item_name" type="text" id="s_item_name" size="35" />
                    </label></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">제안부서</td>
                    <td align="left"><input name="s_dept_code" type="text" id=""s_dept_code"" size="30" />
&nbsp;<a href="#" onclick="return fOpenManagerDept();"><img src="/images/btn_dodbogi.gif" /></a></td>
                    <td align="center">의결결과</td>
                    <td><span id="tag_result_code">-구분-</span>
                    </td>
                  </tr>
                </table></td>
              </tr>
            </table>
			<!----------------------------------------- 검색조건테이블 끝 --------------------------------------------->
</form>			
			</td>
          </tr>
		  <tr>
            <td><table width="100%">
			    <tr>
				<!---------------------- 검색버튼 부분 -------------------------------->
					<td><a href="#" onfocus='blur()' onclick="return fList(null,1);"><img src="/images/btn_search.gif" align="right" border="0"></a></td>
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
                <td height="30" align="center" bgcolor="#e0e0e0">회차</td>
                <td align="center" bgcolor="#e0e0e0">제안일</td>
                <td align="center" bgcolor="#e0e0e0">의안번호</td>
                <td align="center" bgcolor="#e0e0e0">의안명</td>
                <td align="center" bgcolor="#e0e0e0">제안부서</td>
                <td align="center" bgcolor="#e0e0e0">의결결과</td>
                <td align="center" bgcolor="#e0e0e0">첨부</td>
                <td align="center" bgcolor="#e0e0e0">조회</td>
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
              <!-- <tr>
			    <td height="30" align="center" bgcolor="#ffffff">이사회</td>
                <td height="30" align="center" bgcolor="#ffffff">366</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td align="center" bgcolor="#ffffff">892</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">2012년도 예산운영계획(안)</td>
                <td align="center" bgcolor="#ffffff">기획홍보실</td>
                <td align="center" bgcolor="#ffffff">원안의결</td>
                <td align="center" bgcolor="#ffffff"><img src="/images/icon_han.gif" width="16" height="16" /></td>
                <td align="center" bgcolor="#ffffff">10</td>
              </tr> -->
              </table>
			<!-- 답변유형 리스트 테이블 끝 -->
			</td>
          </tr>
		  <tr>
            <td height="40" align="center" colspan="8" >
		<!--------------------------- 목록 페이징테이블 시작 --------------->
			<table width="100%" border="0" cellspacing="1" cellpadding="0">
				<tr>
					<td id="page_navi" height="30" bgcolor="#ffffff"
						style="text-align: center"></td>
				</tr>

				<tr>
					<td height="30" bgcolor="#ffffff" style="text-align: center">
						<a href=# onclick="return fExcel();"><img
							src="images/btn_exel.gif" align=right /></a>
					</td>
				</tr>
			</table>
		</td>  
  		</tr>

</table>