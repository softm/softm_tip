<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib prefix="c"      uri="http://java.sun.com/jsp/jstl/core"      %>
<%@ taglib prefix="fmt"    uri="http://java.sun.com/jsp/jstl/fmt"       %>
<%@ taglib prefix="fn"     uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ page import="java.util.Calendar" %> 
<%@include file="/inc/common.jsp" %>
<script>
$( document ).ready(function() {
	$( "body" ).off("click", "#slideHidePage").on( "click", "#slideHidePage", function() {
	    var options = {direction:"left"};
		$("#page1").show();	    
		$( "#navi" ).hide( "slide", options, 500, function() {

		});
	});
	
	$( "body" ).off("click", ".anchor_month").on( "click", ".anchor_month", function() {
        event.preventDefault();
		var href = $(this).attr("href");
		var params = href.substr(1).split("&");
		if ( $(this).hasClass("prev") ) {
		}
	    loadUi("#navi","/mainSlideView.do",params,function(){});    			    
	});
	
	
	$( "body" ).off("mousedown", "#dialog .layer_popup .popup_header").on( "mousedown", "#dialog .layer_popup .popup_header", function() {
        event.preventDefault();
			$("#dialog .layer_popup").css("zIndex",2000);        	
			$("#dialog2 .layer_popup").css("zIndex",1000);        	
        console.info($("#dialog .layer_popup"))
        console.info($("#dialog2 .layer_popup"))
	});
	
	
	$( "body" ).off("mousedown", "#dialog2 .layer_popup .popup_header").on( "mousedown", "#dialog2 .layer_popup .popup_header", function() {
        event.preventDefault();
			$("#dialog .layer_popup").css("zIndex",1000);        	
			$("#dialog2 .layer_popup").css("zIndex",2000);        	
        console.info($("#dialog .layer_popup"))
        console.info($("#dialog2 .layer_popup"))
	});
	
	//$( "#dialog .popup_header" ).draggable();
	$( "#dialog .layer_popup" ).draggable();
	$( '#dialog .layer_popup .popup_header').addTouch();	
	$( "#dialog2 .layer_popup" ).draggable();
	$( '#dialog2 .layer_popup .popup_header').addTouch();
    //$( "#dialog" ).draggable({ handle: ".layer_popup .popup_header" });
    //$( "#draggable2" ).draggable({ cancel: "p.ui-widget-header" });
    
	$( "body" ).off("click", "#btnCalc").on( "click", "#btnCalc", function() {
		//window.open("http://www.naver.com");
		//window.open("http://consumer.fss.or.kr/fss/seomin/service/fun/popup_cal/cal.jsp");
		//$('#myIframe').attr('src','http://consumer.fss.or.kr/fss/seomin/service/fun/popup_cal/cal.jsp');
		//debugger;
		layer_popup('840','730','dialog');
/* 		
	    $("#dialog").dialog({
	        autoOpen: true,
	        modal: true,
	        resizable: true,
	        height: 'auto',
	        width: 'auto',
	        show: "fade",
	        hide: "fade",	        
	        open: function(ev, ui){
	           $('#myIframe').attr('src','http://금융계산기...');
	        }
	    }); */
	});

    
	$( "body" ).off("click", "#btnCalc2").on( "click", "#btnCalc2", function() {
		//window.open("http://www.naver.com");
		//window.open("http://consumer.fss.or.kr/fss/seomin/service/fun/popup_cal/cal.jsp");
		$('#myIframe2').attr('src','http://www.numerics.info/calculator');
		//debugger;
		layer_popup('1010','730','dialog2');
// 		setInterval(function(){
// 			hideKeyboard();
// 		}, 1);
		setKeyboard(false);
	});
	
	$('#dialog2').on('dialogclose', function(event) {
	     alert('closed');
	});
	
    $("#myIframe2").bind("load", function(){
        //$(this).contents().find("#input").focus();
    });
	
    var params=[];
    params.push("foo=bar");
	exec("/mainSlideInfo.do", params.join("&"),function(data) {
      if ( data.RESULT_CD == RESULT_CD.OK ) {
          $( "[name='spnCntCon' ]" ).text(( ( '00' + data.CNT_C).slice( -2 ) ));
          $( "[name='spnCntLoan']" ).text(( ( '00' + data.CNT_J).slice( -2 ) ));
          $( "[name='spnCntSign']" ).text(( ( '00' + data.CNT_S).slice( -2 ) ));
          $( "[name='spnCntExec']" ).text(( ( '00' + data.CNT_E).slice( -2 ) ));
          
          if ( data.CNT_C > 0 ) $( "[name='spnCntCon' ]" ).closest("li").addClass("todo");
          if ( data.CNT_J > 0 ) $( "[name='spnCntLoan']" ).closest("li").addClass("todo");
          if ( data.CNT_S > 0 ) $( "[name='spnCntSign']" ).closest("li").addClass("todo");
          if ( data.CNT_E > 0 ) $( "[name='spnCntExec']" ).closest("li").addClass("todo");
          
      } else {
      }
	});
	
});
</script>
<%
// http://localhost:8080/testCalMonthJstl.do?curYear=2016&curMonth=10&curDay=
    Calendar cal = Calendar.getInstance();
    int year = 0, month = 0, day = 0;
    try {
        year  = Integer.parseInt(request.getParameter("curYear"));
        month = Integer.parseInt(request.getParameter("curMonth"));
        day   = Integer.parseInt(request.getParameter("curDay"));
        if ( month > 12 || month < 1 ) throw new Exception("월입력 오류");
    } catch (Exception ex) {
        year  = cal.get(Calendar.YEAR);
        month = cal.get(Calendar.MONTH)+1;
        day   = cal.get(Calendar.DAY_OF_MONTH);
    }
    
    cal.set(Calendar.YEAR , year     );
    cal.set(Calendar.MONTH, month-1  );
    cal.set(Calendar.DATE , day      );
	int curDayNum = cal.get(java.util.Calendar.DAY_OF_WEEK );

	String dayNames[] = new String[]{"","일","월","화","수","목","금","토"};	
	String dayName = dayNames[curDayNum];
	
    cal.set(Calendar.YEAR , year     );
    cal.set(Calendar.MONTH, month-1  );
    cal.set(Calendar.DATE , 1        );
    int sOfDay = cal.get(Calendar.DAY_OF_WEEK); //1일이 어떤 요일  >> 현재 요일 (일요일은 1, 토요일은 7)
    int eOfDay  = cal.getActualMaximum(Calendar.DAY_OF_MONTH); //해당 월의 마지막 날짜
    
    // 이전달 마지막일자
    cal.set(Calendar.YEAR , year     );
    cal.set(Calendar.MONTH, month-1  );
    cal.set(Calendar.DATE , 0        );
    pageContext.setAttribute("prevYear" , cal.get(Calendar.YEAR )  );
    pageContext.setAttribute("prevMonth", cal.get(Calendar.MONTH)+1);
    pageContext.setAttribute("prevDay"  , cal.get(Calendar.DATE )  );

    // 다음달 첫일자
    cal.set(Calendar.YEAR , year     );
    cal.set(Calendar.MONTH, month    );
    cal.set(Calendar.DATE , 1        );
    pageContext.setAttribute("nextYear" , cal.get(Calendar.YEAR )  );
    pageContext.setAttribute("nextMonth", cal.get(Calendar.MONTH)+1);
    pageContext.setAttribute("nextDay"  , cal.get(Calendar.DATE )  );
    pageContext.setAttribute("sOfNextDay", cal.get(Calendar.DAY_OF_WEEK)  );

    pageContext.setAttribute("year"     , year      );
    pageContext.setAttribute("month"    , month     );
    pageContext.setAttribute("day"      , day       );
    pageContext.setAttribute("sOfDay"   , sOfDay    );
    pageContext.setAttribute("eOfDay"   , eOfDay    );
    
    pageContext.setAttribute("dayName"  , dayName);

%>
<%--
sOfDay :> ${sOfDay}<br/>
eOfDay :> ${eOfDay}<br/>
sOfNextDay :> ${sOfNextDay}<br/>
eOfDay + sOfNextDay :> ${eOfDay + sOfNextDay}<br/> 
--%>
				<div class="logo_wrap">
					<h2 class="logo">참저축은행 | ODS</h1>
				</div>
				<div class="indiv">
					<div class="login_wrap">
						<div class="login_info">
							<div class="profile_img">
								<div class="img"><img id="imgMyPic" src="/images/profile.jpg" alt="이미지" /></div>
							</div>
							<div class="profile_info">
								<span class="name" id="spnUserName">${sessionScope.ss_user.member_nm}</span>
								<span class="team" id="spnDeptName">${sessionScope.ss_user.dept_nm}</span>
							</div>
							<div class="logout">
								<button type="button" class="btn btn_logout2" id="btnLogout">로그아웃</button> 
							</div>
						</div>	
					</div>
					<div class="list_wrap">
						<ul class="list_box">
							<li>
								<div class="list_title">상담</div>
								<div class="list_count"><span class="num" name="spnCntCon">00</span>건</div>
							</li>
							<li>
								<div class="list_title">품의</div>
								<div class="list_count"><span class="num" name="spnCntLoan">00</span>건</div>
							</li>
							<li>
								<div class="list_title">약정</div>
								<div class="list_count"><span class="num" name="spnCntSign">00</span>건</div>
							</li>
							<li>
								<div class="list_title">실행</div>
								<div class="list_count"><span class="num" name="spnCntExec">00</span>건</div>
							</li>
						</ul>
					</div>	
					<div class="lnb_wrap">
						<ul class="lnb">
							<li 
<c:if test='${param.lnbSeq == "1"}'>
							class="current"
</c:if>
							onclick="location.href='';" id="btnGoConsult" ><span class="icon icon_lnb01"></span><span class="text">고객상담</span></li>
							<li
<c:if test='${param.lnbSeq == "2"}'>
							class="current"
</c:if>
							 id="btnGoLoanStep"><span class="icon icon_lnb02"></span><span class="text">사전품의</span></li>
							<li
<c:if test='${param.lnbSeq == "3"}'>
							class="current"
</c:if>
							id="btnGoDealContract"><span class="icon icon_lnb03"></span><span class="text">여신거래약정</span></li>
							<li
<c:if test='${param.lnbSeq == "4"}'>
							class="current"
</c:if>
							id="btnGoCustMng"><span class="icon icon_lnb04"></span><span class="text">고객관리</span></li>
							<li
<c:if test='${param.lnbSeq == "5"}'>
							class="current"
</c:if>
							id="btnGoDataRoom"><span class="icon icon_lnb05"></span><span class="text">업무자료실</span></li>
						</ul>
					</div>
					<button type="button" class="btn btn_calculator" id="btnCalc"><span class="icon icon_calculator"></span>금융계산기</button>
					<BR/>
					<button type="button" class="btn btn_calculator" id="btnCalc2" style="margin-top:5px"><span class="icon icon_calculator"></span>일반계산기</button>
				</div>
				<div class="calendar">
					<span class="num year">2017</span>년
					<span class="num month">1</span>월 
					<span class="num day">9</span>일
					<span class="icon icon_arrow_white"></span>
					<div class="calendar_wrap">
						<input type="button" class="btn_datepicker calendarInput">
					</div>
				</div>
				

<div id="dialog" style="display: none">

	<div class="layer_popup" data-ui="popup">
		<div class="layer_popup_inner">
			<div class="popup_header dialog1">
				<h1 class="title">금융거래계산기</h1>
				<span class="btn btn_close_pop" onclick="closeLayer('dialog');setKeyboard(true);">닫기</span>
			</div>
			<div class="popup_content">
				<div class="scroll_area">
<!-- 					<div class="title_box">
						<h4 class="title">타이틀</h4>
					</div> -->
    <iframe id="myIframe" src="http://consumer.fss.or.kr/fss/seomin/service/fun/popup_cal/cal.jsp" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen width="800" height="560"></iframe>
					<div class="btn_wrap">
<!-- 					
						<button type="button" class="btn btn_normal btn_grayline" onclick="closeLayer('dialog');">취소</button>
						 -->
						<button type="button" class="btn btn_normal btn_green" onclick="closeLayer('dialog');setKeyboard(true);">닫기</button>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>

<div id="dialog2" style="display: none;">

	<div class="layer_popup" data-ui="popup">
		<div class="layer_popup_inner">
			<div class="popup_header dialog2">
				<h1 class="title">일반계산기</h1>
				<span class="btn btn_close_pop" onclick="closeLayer('dialog2');setKeyboard(true);">닫기</span>
			</div>
			<div class="popup_content">
				<div class="scroll_area">
<!-- 					<div class="title_box">
						<h4 class="title">타이틀</h4>
					</div> -->
    <iframe id="myIframe2" src="" onload="this.contentWindow.focus()" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen width="960" height="560"></iframe>
					<div class="btn_wrap">
<!-- 					
						<button type="button" class="btn btn_normal btn_grayline" onclick="closeLayer('dialog');">취소</button>
						 -->
						<button type="button" class="btn btn_normal btn_green" onclick="closeLayer('dialog2');setKeyboard(true);">닫기</button>
					</div>

				</div>
			</div>
		</div>
	</div>

</div>

				