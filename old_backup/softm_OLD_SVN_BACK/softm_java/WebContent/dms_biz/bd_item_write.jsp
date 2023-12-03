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
            <td style="padding-left:5px;"><img src="images/sp3_title01_5.gif"></td>
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
                  <span id="tag_item_devision">-구분-</span>
                </label></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">회의명</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><span id="tag_item_code2">-회의명-</span></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">사업유형</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><span id="tag_item_code3">-사업유형-</span></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">사업상태</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><span id="tag_item_code4">-사업상태-</span></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">안건명</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><label>
                  <input type="text" name="item_name" class='required trim focus alert' message='내용을 입력해주세요.' size="80">
                </label></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">품의서</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input type="text" name="approval_request" class='required trim focus alert' message='품의서를 선택해주세요.'><a href="#" onfocus='blur()' onclick="return fOpenApprovalRequest();"><img src="images/btn_dodbogi.gif" border="0" align="absmiddle"></a></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">제안부서</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input nype="text" name="dept_code"  value=""></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">코스트센터</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input type="text" name="coast_center" class='required trim focus alert' message='코스트센터를 선택해주세요.'><a href="#" onfocus='blur()' onclick="return fOpenCostCenter();"><img src="images/btn_dodbogi.gif" border="0" align="absmiddle"></a></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">자금운용사업</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input type="text" name="funds_dept" class='required trim focus alert' message='자금운용사업을 선택해주세요.'><a href="#" onfocus='blur()' onclick="return fOpenCostIzCode();"><img src="images/btn_dodbogi.gif" border="0" align="absmiddle"></a></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">예산반영여부</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                  <input name="amt_yn" type="radio" value="Y" checked onclick="fAmtChange();">
                  Y 
                  <input name="amt_yn" type="radio" value="N" onclick="fAmtChange();">
                N</td>
              </tr>

			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">가용예산</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input type="text" name="avaiable_budget" onchange="return fChkAmt();" message='가용예산을 숫자로 입력하세요.'>(원)</td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">예산금액</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input type="text" name="budget_amount" onchange="return fChkAmt();" message='예산금액을 숫자로 입력하세요.' >(원)</td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">관련근거</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><label>
                  <textarea name="reference" cols="70" rows="5" class='required trim focus alert' message='관련근거를 입력해주세요.'></textarea>
                </label><a href="#" onfocus='blur()' onclick="return fOpenReferenceList();"><img src="images/btn_dodbogi.gif" border="0" align="absmiddle"></a></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">파일작성</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">
                <a href="#" onfocus='blur()' onClick="return fChoiceHwp(event,this);"><img src="images/btn_input.gif" border="0" align="absmiddle"></a>
                <input type="file" name="att_file" style="display:inline;vertical-align:middle"/>
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
			   <input type="image" src="images/btn_save.gif" border="0">
			   <a href="#" onfocus='blur()' onclick="return fList();"><img src="images/btn_list.gif" border="0"></a></td>
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