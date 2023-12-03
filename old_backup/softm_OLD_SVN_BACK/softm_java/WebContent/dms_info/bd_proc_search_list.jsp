<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>

<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="/images/sp1_title07.gif"></td>
          </tr>
          
          <tr>
            <td style="padding-left:5px;"><img src="/images/sp3_title02_1.gif"></td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!----------------------------------------- 검색조건 테이블 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#ffffff"><table width="730" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80" height="30" align="center">회의일</td>
                    <td align="left"><label>
                      <input name="textfield" type="text" id="textfield" size="10">&nbsp;<img src="/images/btn_cal.gif">
                    ~
                    <input name="textfield2" type="text" id="textfield2" size="10">&nbsp;<img src="/images/btn_cal.gif">
                    </label></td>
                    <td align="center" width="80">의안명</td>
                    <td align="left"><input name="textfield3" type="text" id="textfield3" size="35" /></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">회차</td>
                    <td align="left"><input name="textfield5" type="text" id="textfield5" size="35"></td>
                    <td align="center">회의명</td>
                    <td><select name="select2" id="select2">
                      <option>전체전체전체전체</option>
                    </select></td>
                  </tr>
                </table></td>
              </tr>
            </table>
			<!----------------------------------------- 검색조건테이블 끝 --------------------------------------------->
			</td>
          </tr>
		  <tr>
            <td><table width="100%">
			    <tr>
				<!---------------------- 검색버튼 부분 -------------------------------->
					<td><a href="#" onfocus='blur()'><img src="/images/btn_search.gif" align="right" border="0"></a></td>
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
                <td height="30" align="center" bgcolor="#e0e0e0">번호</td>
                <td align="center" bgcolor="#e0e0e0">회차</td>
                <td align="center" bgcolor="#e0e0e0">회의일</td>
                <td align="center" bgcolor="#e0e0e0">회의명</td>
                <td align="center" bgcolor="#e0e0e0">작성일</td>
                <td align="center" bgcolor="#e0e0e0">첨부</td>
                <td align="center" bgcolor="#e0e0e0">조회</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">366</td>
                <td align="center" bgcolor="#ffffff">892</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">이사회</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td align="center" bgcolor="#ffffff"><img src="/images/icon_han.gif" width="16" height="16" /></td>
                <td align="center" bgcolor="#ffffff">10</td>
              </tr>
              <tr>
                <td height="100" colspan="7" bgcolor="#ffffff" style="padding-left:5px;">의안목록<br />
                  1. 감사위원회.위원 추천<br />
                  2. 제29기 정기 주주총회. 소집<br />
                  3. 전회 이사회 부의안건 추진현황</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">366</td>
                <td align="center" bgcolor="#ffffff">892</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td bgcolor="#ffffff"><span style="padding-left:5px;">이사회</span></td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td align="center" bgcolor="#ffffff"><img src="/images/icon_han.gif" width="16" height="16" /></td>
                <td align="center" bgcolor="#ffffff">12</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">366</td>
                <td align="center" bgcolor="#ffffff">892</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">이사회</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td align="center" bgcolor="#ffffff"><img src="/images/icon_han.gif" width="16" height="16" /></td>
                <td align="center" bgcolor="#ffffff">52</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">366</td>
                <td align="center" bgcolor="#ffffff">892</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">경영위원회</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td align="center" bgcolor="#ffffff"><img src="/images/icon_han.gif" width="16" height="16" /></td>
                <td align="center" bgcolor="#ffffff">12</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">366</td>
                <td align="center" bgcolor="#ffffff">892</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td bgcolor="#ffffff" style="padding-left:5px;">2012년도 예산운영계획(안)</td>
                <td align="center" bgcolor="#ffffff">2012-06-20</td>
                <td align="center" bgcolor="#ffffff"><img src="/images/icon_han.gif" width="16" height="16" /></td>
                <td align="center" bgcolor="#ffffff">13</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff" style="padding-left:10px;">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff" style="padding-left:10px;">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff" style="padding-left:10px;">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
              </tr>
              <tr>
                <td height="30" align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff" style="padding-left:10px;">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
                <td align="center" bgcolor="#ffffff">...</td>
              </tr>
              </table>
			<!-- 답변유형 리스트 테이블 끝 -->
			</td>
          </tr>
		  <tr>
            <td height="40" align="center">
		<!--------------------------- 목록 페이징테이블 시작 --------------->
			<table width="250" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><img src="/images/btn_arr_LL.gif" width="18" height="18" /></td>
    <td><img src="/images/btn_arr_L.gif" width="18" height="18" /></td>
    <td align="center">1 2 3 4 5 6 7 8 9 10</td>
    <td><img src="/images/btn_arr_R.gif" width="18" height="18" /></td>
    <td><img src="/images/btn_arr_RR.gif" width="18" height="18" /></td>
  </tr>
</table>