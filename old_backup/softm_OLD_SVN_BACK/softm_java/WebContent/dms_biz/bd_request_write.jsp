<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>
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
            <td style="padding-left:5px;"><img src="images/sp3_title02_2.gif"></td>
          </tr>
		  <tr>
            <td align="right" style="padding-right:15px;">처리상태 : <span name="status_name"></span></td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!----------------------------------------- 자료요구정보 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">등록일</td>
                <td bgcolor="#ffffff" style="padding-left:10px;"><div name="wriet_date"></div></td>
                <td bgcolor="#e0e0e0" style="padding-left:10px;">제출마감일</td>
                <td bgcolor="#ffffff" style="padding-left:10px;"><div name="end_date"></div></td>
              </tr>
              <tr>
                <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">제목</td>
                <td bgcolor="#ffffff" style="padding-left:10px;"><div name="title"></div></td>
                <td bgcolor="#e0e0e0" style="padding-left:10px;">관련 안건</td>
                <td bgcolor="#ffffff" style="padding-left:10px;">2012년도 예산운영계획안</td>
              </tr>
              <tr>
                <td height="100" bgcolor="#e0e0e0" style="padding-left:10px;">요청내용</td>
                <td colspan="3" bgcolor="#ffffff" style="padding-left:5px;"><div name="req_context"></div></td>
              </tr>
              <tr>
                <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">답변서 서식</td>
                <td colspan="3" bgcolor="#ffffff" style="padding-left:5px;"><span id="item_real_att_file" style="width:210px;text-align:left"></span></td>
              </tr>
			  </table>
			<!----------------------------------------- 자료요구정보 끝 --------------------------------------------->
			</td>
          </tr>
		  <tr>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td style="padding-left:5px;"><img src="images/sp3_title02_3.gif"></td>
          </tr>
		  
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!-- 답변유형 리스트 테이블 시작 -->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">답변유형</td>
                <td colspan="3" bgcolor="#ffffff" style="padding-left:10px;">
                  <input type="radio" name="req_gubun" value="1"  class='required trim focus alert' message='답변유형을 선택해주세요.'/>
                구두 
                <input type="radio" name="req_gubun" value="2"  class='required trim focus alert' message='답변유형을 선택해주세요.'/>
                서면</td>
              </tr>
              <tr>
                <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">담당자</td>
                <td bgcolor="#ffffff" style="padding-left:10px;"><div name="charge_user"></div></td>
                <td bgcolor="#e0e0e0" style="padding-left:10px;">담당부서</td>
                <td bgcolor="#ffffff" style="padding-left:10px;"><div name="dept_id"></div></td>
              </tr>
              <tr>
                <td height="100" bgcolor="#e0e0e0" style="padding-left:10px;">답변내용</td>
                <td colspan="3" bgcolor="#ffffff" style="padding-left:10px;"><label>
                  <textarea name="ans_context" id="ans_context" cols="75" rows="5" class='required trim focus alert' message='답변내용을 입력해주세요.'></textarea>
                </label></td>
              </tr>
              <tr>
                <td height="30" bgcolor="#e0e0e0" style="padding-left:10px;">첨부파일</td>
                <td colspan="3" bgcolor="#ffffff" style="padding-left:10px;">
                <input type="file" name="att_file" style="display:inline;vertical-align:middle"/>
                <span id="real_att_file" style="width:210px;text-align:left"></span>                
                </td>
              </tr>
		    </table>
			<!-- 안건등록 리스트 테이블 끝 -->
			</td>
          </tr>
		  <tr>
		  <!-- 컨트롤 버튼 부분 시작 -->
            <td height="40" align="right" style="padding-right:5px;">
			   <input type="image" src="images/btn_save.gif" border="0">
			   <a href="#" onfocus='blur()' onclick="fList();"><img src="images/btn_list.gif" border="0"></a></td>
          </tr>
		  
		  <tr>
		    <td><img src="images/sp_bottom.gif"></td>
		  </tr>
        </table>
		<!----------------------------------------- 안건등록 끝 ------------------------------------------>
</form>