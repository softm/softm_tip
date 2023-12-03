<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="메인";
$( document ).ready(function() {
	// ui 깨져서 유지함.
	$(document).find('#navi').css({'width':'80px'})	
	new main_size('small');		
		
	showLoading();
    function list() {
          var params=[];
              params.push("foo=bar");
          exec("/mainDataRoomListInfo.do", params.join("&"),function(data) {
                //
                if ( data.RESULT_CD == RESULT_CD.OK ) {
                    $( "#list01 .list" ).empty();
                    $( "#list01Template" ).tmpl( data.LIST ).appendTo( "#list01 .list" );                    
                } else {
                }
          });
    };
    list();

	hideLoading();
    //window.localStorage.removeItem("lnbSeq");
	$( "body" ).dblclick(function() {
		  $("#test").show();
	});
});
</script>
<script id="list01Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${TITLE}</td>
    <td>\${REG_DATE}</td>
</tr>
</script>
<body>
<span id="test" style="display:none"">
<button onclick='openOZ("LoanPic","loanreq_seq=201703000083");'>LoanPic</button>
<button onclick='openOZ("SignDoc","loanreq_seq=201703000083");'>SignDoc</button>
<button onclick='openOZ("SignPic","loanreq_seq=201703000083");'>SignPic</button>
<br/>
gubun : <input type="text" id="gubunNm" value="LoanPicTest" style="border:1px solid black"/> <br/>
loanreq_seq : <input type="text" id="loanreqSeq" value="201703003158"  style="border:1px solid black"/> <br/>
<button onclick='openOZ($("#gubunNm").val(),"loanreq_seq="+$("#loanreqSeq").val());'>Test</button>
</span>
<div id="layout">

	<div id="wrap">
		<div id="wrapper">

			<div id="contentsarea" class="bg_main">

				<div id="header">
					<div class="loginArea">
						<span class="profile_img"><em class="img"><img id="imgMyPic" src="/images/profile.jpg" alt="이미지" /></em></span>
						<span class="name" id="spnUserName">${sessionScope.ss_user.member_nm}</span>
						<span class="team" id="spnDeptName">${sessionScope.ss_user.dept_nm}</span>
						<button type="button" class="btn btn_logout1" id="btnLogout">로그아웃</button>
					</div>
					
				</div>

				<div id="contents">

					<div class="mainPage">

						<h1 class="logo"></h1>

						<div class="mainMenu_wrap">
							<ul class="mainMenu">
								<li class="menu01" id="btnGoConsult">
									<dl>
										<dt class="menu_title">
											<div class="menu_img"></div> 
											고객상담
										</dt>
										<dd class="menu_content">
											고객님의 등록하고<br />상담일정을 확인합니다.
										</dd>
									</dl>
								</li>
								<li class="menu02" id="btnGoLoanStep">
									<dl>
										<dt class="menu_title">
											<div class="menu_img"></div> 
											사전품의
										</dt>
										<dd class="menu_content">
											고객님에 대한<br /> 사전품의를 합니다.
										</dd>
									</dl>
								</li>
								<li class="menu03" id="btnGoDealContract">
									<dl>
										<dt class="menu_title">
											<div class="menu_img"></div> 
											거래약정
										</dt>
										<dd class="menu_content">
											여신거래작성을<br />기재합니다.
										</dd>
									</dl>
								</li>
								<li class="menu04" id="btnGoCustMng">
									<dl>
										<dt class="menu_title">
											<div class="menu_img"></div> 
											고객관리
										</dt>
										<dd class="menu_content">
											고객의 일정 및 상태를<br />관리해 드립니다.
										</dd>
									</dl>
								</li>
								<li class="menu05" id="btnGoDataRoom">
									<dl>
										<dt class="menu_title">
											<div class="menu_img"></div> 
											업무자료실
										</dt>
										<dd class="menu_content">
											업무에 필요한 자료들을<br />모아뒀습니다.
										</dd>
									</dl>
								</li>
							</ul>
						</div>

					</div>

				</div> <!-- // contnets -->
			</div><!-- //bg_main -->

		</div>
	</div>
<!-- <table id="list01"><tbody class="header"><tr><th>제목</th><th>날짜</th></tr></tbody>
    <tbody class="list"></tbody>
</table> -->
</div> <!-- // layout -->
<div class='main hide' id="page2"><div>
<%@include file="/inc/footer.jsp" %>