<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>

<form id="sForm" name="sForm" method="POST" onsubmit="return fList(null,1);">

	<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="/images/sp2_title02.gif"></td>
          </tr>
          
          <tr>
            <td style="padding-left:5px;"><img src="/images/sp3_title02_2.gif"></td>
          </tr>
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!----------------------------------------- 검색조건 테이블 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#ffffff"><table width="730" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="80" height="30" align="center">구분</td>
                    <td align="left"><div id="tag_div_code">-구분-</div></td>
                    <td align="center" width="80">제목</td>
                    <td align="left"><input name="s_subject" type="text" id="s_subject" size="35" /></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">내용</td>
                    <td align="left"><input name="s_context" type="text" id="s_context" size="35"></td>
                    <td align="center">&nbsp;</td>
                    <td>&nbsp;</td>
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
					<td><a href="#" onfocus='blur()' onclick="return fSubmit();"><img src="/images/btn_search.gif" align="right" border="0"></a></td>
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
			<thead>
              <tr>
                <td height="30" align="center" bgcolor="#e0e0e0">번호</td>
                <td align="center" bgcolor="#e0e0e0">구분</td>
                <td align="center" bgcolor="#e0e0e0">제목</td>
                <td align="center" bgcolor="#e0e0e0">등록자</td>
                <td align="center" bgcolor="#e0e0e0">등록일</td>
                <td align="center" bgcolor="#e0e0e0">조회</td>
              </tr>
              </thead>
              <tbody id="list_data"></tbody>
              </table>
			<!-- 답변유형 리스트 테이블 끝 -->
			</td>
          </tr>
		  <tr>
            <td height="40" align="center">
		<!--------------------------- 목록 페이징테이블 시작 --------------->
			<table width="250" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td><td id="page_navi" height="30" bgcolor="#ffffff" style="text-align:center" align=center></td>
  </tr>
</table>
		<!--------------------------- 목록 페이징테이블 끝 --------------->	
			</td>
          </tr>
		  <tr>
            <td><table width="100%">
			    <tr>

					<td><a href="#" onfocus='blur()' onclick="return fWrite();"><img src="/images/btn_reg_1.gif" align="right" border="0"></a></td>
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