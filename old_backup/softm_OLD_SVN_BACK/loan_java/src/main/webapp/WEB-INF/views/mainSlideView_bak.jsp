<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib prefix="c"      uri="http://java.sun.com/jsp/jstl/core"      %>
<%@ taglib prefix="fmt"    uri="http://java.sun.com/jsp/jstl/fmt"       %>
<%@ taglib prefix="fn"     uri="http://java.sun.com/jsp/jstl/functions" %>
<%@ page import="java.util.Calendar" %> 
<%@include file="/inc/common.jsp" %>
<script>
document.title="메인";
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
	
	$( "body" ).off("click", "#btnCalc").on( "click", "#btnCalc", function() {
		//window.open("http://www.naver.com");
		window.open("http://consumer.fss.or.kr/fss/seomin/service/fun/popup_cal/cal.jsp");
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

    var params=[];
    params.push("foo=bar");
	exec("/mainSlideInfo.do", params.join("&"),function(data) {
      //
      if ( data.RESULT_CD == RESULT_CD.OK ) {
          $( "#spnCnt1" ).text(( ( '00' + data.CNT_C).slice( -2 ) ));
          $( "#spnCnt2" ).text(( ( '00' + data.CNT_J).slice( -2 ) ));
          $( "#spnCnt3" ).text(( ( '00' + data.CNT_S).slice( -2 ) ));
          $( "#spnCnt4" ).text(( ( '00' + data.CNT_E).slice( -2 ) ));
          
          if ( data.CNT_C > 0 ) $( "#spnCnt1" ).closest("li").addClass("todo");
          if ( data.CNT_J > 0 ) $( "#spnCnt2" ).closest("li").addClass("todo");
          if ( data.CNT_S > 0 ) $( "#spnCnt3" ).closest("li").addClass("todo");
          if ( data.CNT_E > 0 ) $( "#spnCnt4" ).closest("li").addClass("todo");
          
      } else {
      }
      
  		calendar_date(); // 좌측달력 ui_common.js      
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
								<div class="list_count"><span class="num" id="spnCnt1">00</span>건</div>
							</li>
							<li>
								<div class="list_title">품의</div>
								<div class="list_count"><span class="num" id="spnCnt2">00</span>건</div>
							</li>
							<li>
								<div class="list_title">약정</div>
								<div class="list_count"><span class="num" id="spnCnt3">00</span>건</div>
							</li>
							<li>
								<div class="list_title">실행</div>
								<div class="list_count"><span class="num" id="spnCnt4">00</span>건</div>
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
<!-- 
<div id="dialog" title="금융계산기" style="display:none">
    <iframe id="myIframe" src="" frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>
</div>
 -->					
				</div>
				<div class="calendar">
					<span class="num year">2017</span>년
					<span class="num month">1</span>월 
					<span class="num day">9</span>일
					<span class="icon icon_arrow_white"></span>
					<div class="calendar_wrap">
						<input type="text" class="btn_datepicker calendarInput">
					</div>
				</div>
				
<!-- 
				<div class="calendar">
					<span class="num year">${year}</span>년
					<span class="num month">${month}</span>월 
					<span class="num day">${day}</span>일
					<span class="icon icon_arrow_white"></span>
      <table border ='1'>
        <tr>
        <td align= center><a class="anchor_month prev" href='?curYear=${prevYear}&curMonth=${prevMonth}&curDay=${prevDay}'>&lt;&lt;</a></td>
        <td colspan='5' align= center>${year}년 ${month}월 </td>
        <td align= center><a class="anchor_month next" href='?curYear=${nextYear}&curMonth=${nextMonth}&curDay=${nextDay}'>&gt;&gt;</a></td>
        </tr>
        <tr><td>Sun</td><td>Mon</td><td>Tus</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td></tr>
        <tr>
<%--
--%>        
        <c:forEach var="i" begin="${prevDay-sOfDay+2}" end="${prevDay}" varStatus="status">
        	<td></td>
        </c:forEach>
        <c:forEach var="i" begin="1" end="${eOfDay}" varStatus="status">
            <c:choose>
                <c:when test='${(sOfDay-2+i) mod 7 ==0}'>
                    <td>
            <c:if test='${day == i}'>
            <b>
            </c:if>
                    <a class="anchor_month set" href='?curYear=${year}&curMonth=${month}&curDay=${i}'><font color='red'><c:out value="${i}"/></font></a>
            <c:if test='${day == i}'>
            </b>
            </c:if>
                    </td>
                </c:when>
                <c:when test='${(sOfDay-1+i) mod 7 ==0}'>
                    <td>
            <c:if test='${day == i}'>
            <b>
            </c:if>
                    <a class="anchor_month set" href='?curYear=${year}&curMonth=${month}&curDay=${i}'><font color='blue'><c:out value="${i}"/></font></a>
            <c:if test='${day == i}'>
            </b>
            </c:if>
                    </td>
                </c:when>
                <c:otherwise>
                    <td>
            <c:if test='${day == i}'>
            <b>
            </c:if>
                    <a class="anchor_month set" href='?curYear=${year}&curMonth=${month}&curDay=${i}'><font color='black'><c:out value="${i}"/></font></a>
            <c:if test='${day == i}'>
            </b>
            </c:if>
                    </td>
                </c:otherwise>
            </c:choose>
            
            <c:if test='${(sOfDay-1+i) mod 7 ==0}'>
                </tr><tr>
            </c:if>
        </c:forEach>

<%--
--%>
        <c:forEach var="i" begin="${sOfNextDay}" end="7" varStatus="status">
        	<td></td>        
        </c:forEach>
        </tr>
      </table>
				</div>
-->
      
      