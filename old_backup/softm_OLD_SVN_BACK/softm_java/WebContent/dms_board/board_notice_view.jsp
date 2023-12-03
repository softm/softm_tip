<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>
<%
String p_no= request.getParameter("p_no");
%>
<form id=wForm name=wForm enctype='multipart/form-data' method='post' AUTOCOMPLETE='OFF' onsubmit='return 실행();'>
<input type='hidden' name='no' size=10 value='<%=p_no%>'/>

<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="/images/sp2_title01.gif"></td>
          </tr>
          
		  <tr>
            <td bgcolor="#ffffff" align="center">
			<!----------------------------------------- 검색조건 테이블 --------------------------------------->
			<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#ffffff"><table width="730" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="110" height="30" align="center">구분:</td>
                    <td width="272" align="left"><div id="code_name"></div></td>
                    <td align="center" width="158">등록자:</td>
                    <td width="190" align="left"><div id="ename"></div></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">제목:</td>
                    <td align="left"><div id="subject"></div></td>
                    <td align="center">등록일:</td>
                    <td><div id="write_date"></div></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="4" align="center"><textarea name="context" id="textarea" class="textarea" cols="110" rows="20" readonly></textarea></div></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">첨부파일 :</td>
                    <td colspan="3" align="left"><div id="real_att_file"></div></td>
                  </tr>
                </table></td>
              </tr>
            </table>
			<!----------------------------------------- 검색조건테이블 끝 --------------------------------------------->
			</td>
          </tr>
		  <tr>
            <td height="40" align="right" style="padding-right:5px;">
			   <a href="#" onfocus='blur()' onclick="fGoUpdate(<%=p_no%>)"><img src="/images/btn_edit.gif" border="0"></a>&nbsp;
               <a href="#" onfocus='blur()' onclick="fDelete(<%=p_no%>)"><img src="/images/btn_del.gif" border="0"></a>&nbsp;
			   <a href="#" onfocus='blur()' onclick="fList()"><img src="/images/btn_list.gif" border="0"></a></td>
          </tr>
		  <tr>
            <td height="30" style="padding-left:10px;">
			<div id="next_data"></div>
			</td>
          </tr>
		  <tr>
		    <td><img src="/images/sp_bottom.gif"></td>
		  </tr>
        </table>
        </form>