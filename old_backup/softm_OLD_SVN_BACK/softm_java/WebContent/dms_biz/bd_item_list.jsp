<%
/** 
 * <pre>
 *  설  명 :  안건 등록
 *  작성자 :  김지훈
 *  작성일 :  2012-07-14
 *
 *  기타사항 :
 *  
 * Copyrights 2012 by KOGAS. All right reserved.
 * </pre>
*/
%>
<%@ page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@include file="/inc/common.inc" %>
<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="/images/sp3_title01.gif"></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td style="padding-left:5px;"><img src="/images/sp3_title01_1.gif"></td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
<form id="sForm" name="sForm" method="POST" onsubmit="return fList(null,1);">
			<!----------------------------------------- 회의리스트 테이블 시작 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">구분</td>
                <td align="center" bgcolor="#e0e0e0">회차</td>
                <td align="center" bgcolor="#e0e0e0">회의명</td>
                <td align="center" bgcolor="#e0e0e0">개최일</td>
                <td align="center" bgcolor="#e0e0e0">개최시간</td>
                <td align="center" bgcolor="#e0e0e0">개최장소</td>
                <td align="center" bgcolor="#e0e0e0">제출 마감일</td>
              </tr>
              
              <tbody id="list_data">
              <tr>
                <td colspan="7" tabindex='1' height="30" align="center" bgcolor="#ffffff">검색된 자료가 없습니다.</td>
              </tr>              
              </tbody>
              <tfoot>
              	<tr>
              	<td id="page_navi" height="30" bgcolor="#ffffff" style="text-align:center" align=center colspan="7">
              	</td>
              	</tr>
              </tfoot>
            </table>
			<!----------------------------------------- 회의리스트 끝 --------------------------------------------->
       </form>          			
			</td>
          </tr>
		  <tr>
            <td><table width="100%">
			    <tr>
				<!---------------------- 안건등록버튼 부분 -------------------------------->
					<td><a href="#" onclick="fGoWrite();" onfocus='blur()'><img src="/images/btn_reg.gif" align="right" border="0"></a></td>
			    </tr>
				</table>
				</td>
          </tr>
		  <tr>
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td style="padding-left:5px;"><img src="/images/sp3_title01_3.gif"></td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
<form id="wForm" name="wForm" method="POST">
			<!-- 안건등록 리스트 테이블 시작 -->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
			    <td height="30" align="center" bgcolor="#e0e0e0">
				<!------------------------ 의안번호 확정 체크박스 부분 시작 ------------------>
				<input type="checkbox" name="chk" onclick="fCheckAll(this.checked)" align="absmiddle">
                  </td>
                <td height="30" align="center" bgcolor="#e0e0e0">의안<br>번호</td>
                <td align="center" bgcolor="#e0e0e0">회의명</td>
                <td align="center" bgcolor="#e0e0e0">사업<br>유형</td>
                <td align="center" bgcolor="#e0e0e0">사업상태</td>
                <td align="center" bgcolor="#e0e0e0">안건명</td>
                <td align="center" bgcolor="#e0e0e0">담당자</td>
                <td align="center" bgcolor="#e0e0e0">제안부서</td>
				<td align="center" bgcolor="#e0e0e0">처리상태</td>
				<td align="center" bgcolor="#e0e0e0">첨부</td>
				<td align="center" bgcolor="#e0e0e0">의안번호<br>설정여부</td>

              </tr>
              
              <tbody id="list_data1">
              <tr>
                <td colspan="11" tabindex='1' height="30" align="center" bgcolor="#ffffff">검색된 자료가 없습니다.</td>
              </tr>              
              </tbody>
              <tfoot>
              	<tr>
              	<td id="page_navi1" height="30" bgcolor="#ffffff" style="text-align:center" align=center colspan="11">
              	</td>
              	</tr>
              </tfoot>
              </table>
			<!-- 안건등록 리스트 테이블 끝 -->
</form>			
			</td>
          </tr>
		  <tr>
		  <!-- 안건 리스트 컨트롤 버튼 부분 시작 -->
            <td height="40" align="right" style="padding-right:5px;">
			   <a href="#" onfocus='blur()' onclick="return fOpenReturnReason();"><img src="/images/btn_com.gif" border="0"></a>&nbsp;
			   <a href="#" onfocus='blur()' onclick="return fUpdateStatus(3);"><img src="/images/btn_confirm.gif" border="0"></a>&nbsp;
			   <a href="#" onfocus='blur()' onclick="return fDelete();"><img src="/images/btn_del.gif" border="0"></a></td>
          </tr>
		  
		  <tr>
		    <td><img src="/images/sp_bottom.gif"></td>
		  </tr>
        </table>
