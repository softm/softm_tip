<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="메인";
$( document ).ready(function() {
	showLoading();
    function list() {
          var params=[];
              params.push("foo=bar");
          exec("/mainDataRoomListInfo.do", params.join("&"),function(data) {
                //if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
                if ( data.RESULT_CD == RESULT_CD.OK ) {
                    $( "#list01 .list" ).empty();
                    $( "#list01Template" ).tmpl( data.LIST ).appendTo( "#list01 .list" );                    
                } else {
                }
          });
    };
    list();

	hideLoading();  
});
</script>
<script id="list01Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${TITLE}</td>
    <td>\${REG_DATE}</td>
</tr>
</script>
<body>
<div class='main' id="page1">
<span id="sesName">${sessionScope.ss_user.member_nm}</span> / <span  id="sesDeptName">${sessionScope.ss_user.dept_nm}</span> <button type="button" id="btnLogout">로그아웃</button>
<br/>
<br/>
<button id="slidePage">slidePage</button>
<br/>
<br/>	
<button type="button" id="btnGoConsult"     >고객상담</button>
<button type="button" id="btnGoLoanStep"    >사전품의</button>
<button type="button" id="btnGoDealContract">여신거래약정</button>
<button type="button" id="btnGoCustMng"     >고객관리</button>
<button type="button" id="btnGoDataRoom"    >업무자료실</button>
<br/>
<br/>
<table id="list01"><tbody class="header"><tr><th>제목</th><th>날짜</th></tr></tbody>
    <tbody class="list"></tbody>
</table>
</div>
<div class='main hide' id="page2"><div>
<%@include file="/inc/footer.jsp" %>