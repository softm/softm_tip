<%
/** 
 * <pre>
 *  설  명 :  404에러
 *  작성자 :  KMSLAB 개발팀
 *  작성일 :  2012-03-06
 *
 *  기타사항 :
 *  
 * Copyrights 2011 by GS ITM. All right reserved.
 * </pre>
*/
%>
<%@page language="java" contentType="text/html; charset=utf-8" pageEncoding="utf-8"%>
<%@page import="com.kogas.dms.common.Util"%>
<%@page errorPage="/common/error.jsp" %>
<%@include file="/inc/common.inc" %>
<div id="404" class="404" style="padding-left:10px; padding-right:10px">
    <table cellpadding="0" width="100%" cellspacing="0"    style="border:1px solid #f99d29">
        <tr>
             <td height="100" align="center">
                <ul id="404"  class="404"  width="100%" >
                    <li class="fl1" style="width:50px;padding-left:0px;"><img src="/images/icon_caution.gif"> </li>
                    <li class="fl1 point_text" style="width:80%;padding-right:0px">- 페이지를 찾을 수 없습니다.<br>
                    서비스 이용에 불편을 드려서 죄송합니다.
                    </li>
                </ul>
            </td>
        </tr>
    </table>
<div>
<%@ include file="/inc/footer.inc" %>