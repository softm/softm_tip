<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>
<form id=wForm name=wForm enctype='multipart/form-data' method='post' AUTOCOMPLETE='OFF' onsubmit='return fExec();'>
<input type='hidden' name='p_mode' size=10 value=''/>
<input type='hidden' name='p_item_no' size=10 value=''/>
<input type='hidden' name='p_schedule_no' size=10 value=''/>
<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="images/sp3_title01.gif"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:5px;"><img src="images/sp3_title01_4.gif"></td>
          </tr>
		  <tr>
            <td align="right" style="padding-right:15px;">처리상태 : <span id="status_name">등록대기</span></td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!----------------------------------------- 안건 상세정보 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td width="100" height="30" align="center" bgcolor="#e0e0e0">구분</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><label>
                  <span id="item_devision_name">-구분-</span>
                </label></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">회의명</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><span id="item_code2_name">-회의명-</span></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">사업유형</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><span id="item_code3_name">-사업유형-</span></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">사업상태</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><span id="item_code4_name">-사업상태-</span></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">안건명</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><label>
                  <span name="item_name"></span>
                </label></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">품의서</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <span name="approval_request"></span>
                </td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">제안부서</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <span name="dept_code"></span>
                </td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">코스트센터</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <span name="coast_center"></span>
                </td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">자금운용사업</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <span name="funds_dept"></span>
                </td>                
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">예산반영여부</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <span name="amt_yn"></span>
                </td>
              </tr>

			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">가용예산</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <span name="avaiable_budget"></span>
                </td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">예산금액</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <span name="budget_amount"></span>
                </td>                
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">관련근거</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <pre name="reference"></pre>
                </td>                
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">파일작성</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <span id="real_att_file" style="width:210px;text-align:left"></span>
                </td>
              </tr>
            </table>
			<!----------------------------------------- 회의리스트 끝 --------------------------------------------->
			</td>
          </tr>
		  <tr>
            <td><table width="100%">
			    <tr>
				<!---------------------- 안건등록버튼 부분 -------------------------------->
					<td height="40" align="right" style="padding-right:5px;">
			   <a href="#" onfocus='blur()' onclick="return fDelete();"><img src="images/btn_del.gif" border="0"></a>&nbsp;
			   <a href="#" onfocus='blur()' onclick="return fGoWrite();"><img src="images/btn_edit.gif" border="0"></a>&nbsp;
			   <a href="#" onfocus='blur()' onclick="return fList();"><img src="images/btn_list.gif" border="0"></a>
			   		</td>			   
			    </tr>
				</table>
				</td>
          </tr>
		  <tr>
            <td>&nbsp;</td>
          </tr>
		  
		  <tr>
		    <td><img src="images/sp_bottom.gif"></td>
		  </tr>
        </table>
<div id="file_choice" style="position:absolute;top:0px;left:0px;background-color:white;display:none">
	<span onClick="fOpenHwp(event,'1');" style="cursor:pointer"><input name="rdo_hwp_type" type="radio" value="1" > 보고 안건 서식</span>
	<span onClick="fOpenHwp(event,'2');" style="cursor:pointer"><input name="rdo_hwp_type" type="radio" value="2" > 전회 이사회 부의안건 서식</span>
</div>        
</form>        