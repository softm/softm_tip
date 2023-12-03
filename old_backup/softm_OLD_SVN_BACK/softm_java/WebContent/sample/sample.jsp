<%
/** 
 * <pre>
 *  설  명 :  샘플 - 조회
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
<form id="sForm" name="sForm" method="POST" onsubmit="return fList(null,1);">
		<!----------------------------------------- 안건등록 시작 ------------------------------------------>
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
          	<div id="tag_div_code">-구분-</div>
          	<input type="text" value='' name="s_subject">
          	<button type=submit>검색</button>
            </td>
          </tr>           
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!----------------------------------------- 회의리스트 테이블 시작 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
			<colgroup>
			<col width="40"/>
			<col width="60"/>
			<col width=""/>
			<col width="50"/>
			<col width="60"/>
			<col width="100"/>
			<col width="50"/>
			</colgroup>
			  <thead>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">번호</td>
                <td align="center" bgcolor="#e0e0e0">구분</td>
                <td align="center" bgcolor="#e0e0e0">제목</td>
                <td align="center" bgcolor="#e0e0e0">등록자</td>
                <td align="center" bgcolor="#e0e0e0">등록일</td>
                <td align="center" bgcolor="#e0e0e0">파일</td>                
                <td align="center" bgcolor="#e0e0e0">조회</td>
              </tr>
			  </thead>              
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
			</td>
          </tr>
		  <tr>
            <td>
            	<table width="100%">
			    <tr><td height="25" style="padding-left:13px;"><font color="#ff0000">※ 제출 마감일 이후에는 안건 작성이 불가능 합니다.</font></td>
				    <!---------------------- 안건등록버튼 부분 -------------------------------->
					<td> 
					<button type="button" onclick="fListDownload('파일다운로드','xls');" align="right" >엑셀</button>
					<a href="#" onfocus='blur()' onclick="return fWrite();"><img src="/images/btn_reg.gif" align="right" border="0"></a>
					</td>
			    </tr>
				</table>
			</td>
          </tr>
		   
		  <tr>
		    <td><img src="/images/sp_bottom.gif"></td>
		  </tr>
        </table>
       </form>  
		<!----------------------------------------- 안건등록 끝 ------------------------------------------>