<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="java.util.*"%>
<%@include file="/inc/common.inc" %>

<form id=wForm name=wForm enctype='multipart/form-data' method='post' AUTOCOMPLETE='OFF' onsubmit='return fExec();'>
<input type='hidden' name='p_mode' size=10 value=''/>
<input type='hidden' name='p_no' size=10 value=''/>

		<table width="756" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
          <tr>
            <td><img src="/images/sp2_title01.gif"></td>
          </tr>
          
		  <tr>
            <td bgcolor="#ffffff" align="center">
<table width="730" border="0" cellspacing="1" cellpadding="0" bgcolor="#cccccc">
              <tr>
                <td height="30" align="center" bgcolor="#ffffff"><table width="730" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="110" height="30" align="center">구분:</td>
                    <td width="272" align="left"><div id="tag_div_code">-구분-</div></td>
                    <td align="center" width="158">등록자:</td>
                    <td width="190" align="left"><input type="hidden" name="writer" id="write" value="<%=EMP_NO %>">
                    	<input type="text" name="ename" id="ename" value="<%=EMP_NM %>" readonly/></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">제목:</td>
                    <td align="left"><input name="subject" type="text" id="textfield2" size="35" /></td>
                    <td align="center">등록일:</td>
                    <td><input type="text" name="write_date" id="textfield3" readonly/></td>
                  </tr>
                  <tr>
                    <td height="30" colspan="4" align="center"><textarea name="context" id="textarea" class="textarea" cols="110" rows="20"></textarea></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">첨부파일 :</td>
                    <td colspan="3" align="left"><input type="file" name="att_file" style="width:310px"/><span id="real_att_file" style="width:210px;text-align:left"></span></td>
                  </tr>
				  <tr>
                    <td height="30" align="center">상위게시일 :</td>
                    <td colspan="3" align="left"><input type="text" name="view_end_date" style="width:310px"/></td>
                  </tr>
                  <tr>
                    <td height="30" align="center">&nbsp;</td>
                    <td colspan="3" height="40" align="right" style="padding-right:5px;">
			   <a href="#" onfocus='blur()' onclick="fExec()"><img src="/images/btn_save.gif" border="0"></a>&nbsp;
			   <a href="#" onfocus='blur()' onclick="fList()"><img src="/images/btn_list.gif" border="0"></a></td>
                  </tr>
                </table></td>
              </tr>
            </table>