<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>
<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="/images/sp3_title01.gif"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:5px;"><img src="/images/sp3_title01_5.gif"></td>
          </tr>
		  <tr>
            <td align="right" style="padding-right:15px;">처리상태 : 등록대기</td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!----------------------------------------- 안건 상세정보 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">구분</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><label>
                  <select name="box" id="box">
                    <option>의결안건</option>
                    <option>의결안건</option>
                    <option>의결안건</option>
                  </select>
                </label></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">회의명</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><select name="select2" id="select2">
                  <option>이사회</option>
                  <option>이사회</option>
                  <option>이사회</option>
                </select></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">사업유형</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><select name="select3" id="select3">
                  <option>국내투자</option>
                  <option>국내투자</option>
                  <option>국내투자</option>
                </select></td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">사업상태</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><select name="select4" id="select4">
                  <option>신규</option>
                  <option>신규</option>
                  <option>신규</option>
                </select></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">안건명</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><label>
                  <input name="textfield" type="text" id="textfield" value="2012년도 예산운영계획(안)" size="80">
                </label></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">품의서</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input name="textfield2" type="text" id="textfield2" value="XXXXXXXXXX"><a href="#" onfocus='blur()'><img src="/images/btn_dodbogi.gif" border="0" align="absmiddle"></a></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">제안부서</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input name="textfield6" type="text" id="textfield6" value="기획홍보실"></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">코스트센터</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input name="textfield3" type="text" id="textfield3" value="ZZZZZZZ"><a href="#" onfocus='blur()'><img src="/images/btn_dodbogi.gif" border="0" align="absmiddle"></a></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">자금운용사업</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input name="textfield4" type="text" id="textfield4" value="YYYYYYY"><a href="#" onfocus='blur()'><img src="/images/btn_dodbogi.gif" border="0" align="absmiddle"></a></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">예산반영여부</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><label>
                  <input type="radio" name="radio" id="radio" value="radio">
                  Y 
                  <input type="radio" name="radio2" id="radio2" value="radio2">
                N</label></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">가용예산</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input name="textfield5" type="text" id="textfield5" value="200,000,000">
                  (원)</td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">예산금액</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><input name="textfield7" type="text" id="textfield7" value="100,000,000">
(원)</td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">관련근거</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><label>
                  <textarea name="textfield8" cols="80" rows="5" id="textfield8">주주총회의 소집과 이에 제출할 안건</textarea>
                </label><a href="#" onfocus='blur()'><img src="/images/btn_dodbogi.gif" border="0" align="absmiddle"></a></td>
              </tr>
			  <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">파일작성</td>
                <td bgcolor="#ffffff" style="padding-left:5px;"><a href="#" onfocus='blur()'><img src="/images/btn_input.gif" border="0"></a></td>
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
			   <a href="#" onfocus='blur()'><img src="/images/btn_save.gif" border="0"></a>&nbsp;
			   <a href="#" onfocus='blur()'><img src="/images/btn_list.gif" border="0"></a></td>
			    </tr>
				</table>
				</td>
          </tr>
		  <tr>
            <td>&nbsp;</td>
          </tr>
		  
		  <tr>
		    <td><img src="/images/sp_bottom.gif"></td>
		  </tr>
        </table>