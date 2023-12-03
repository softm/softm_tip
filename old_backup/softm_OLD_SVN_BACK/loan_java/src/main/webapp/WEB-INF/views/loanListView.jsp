<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="신청대상목록";
$( document ).ready(function() {

    function list(statgroup) {
    	showLoading();    	
    	  window.listSeq = 0;
      	// 고객상담 : con
      	// 사전품의 : loan
      	// 여신약정 : sign
        var params=[];
            params.push("statgroup=" + statgroup);
          exec("/loanListInfo.do", params.join("&"),function(data) {
                //
                if ( data.RESULT_CD == RESULT_CD.OK ) {
                    $( "#list01 .list" ).empty();
                    $( "#list01Template" ).tmpl( data.LIST ).appendTo( "#list01 .list" );                    
                } else {
                }
                
                $( "body" ).off( "click", "#list01 .list [name='btn']").on( "click", "#list01 .list [name='btn']", function() { //
                	var gubun = $(this).attr("gubun");
                    var idx = $("#list01 .list [name='btn']").index($(this));
                    //alert( data.LIST[idx].LOANREQ_SEQ + " / " + data.LIST[idx].PT_CUST_NO );
                    
                    var params=[];
                        params.push("loanreq_seq=" + data.LIST[idx].LOANREQ_SEQ);
                        params.push("pt_cust_no="  + data.LIST[idx].PT_CUST_NO );
                    if (statgroup == "con") {
                    	params.push("lnbSeq=1");
                    } else if (statgroup == "loan") {                        
                    	params.push("lnbSeq=2");
                    } else if (statgroup == "sign") {                        
                    	params.push("lnbSeq=3");
                    }

                    if ( statgroup == "con" ) {
            			goUrl("consultResultView.do?" + params.join("&"));
                    } else if ( statgroup == "sign" ) {
            			goUrl("loanagreeView.do?" + params.join("&"));
                    } else { // loan
	                    if ( gubun == "step1" ) {
	            			goUrl("loanStep1View.do?" + params.join("&"));
	                    } else if ( gubun == "step2" ) {
	            			goUrl("loanStep2View.do?" + params.join("&"));
	                    } else if ( gubun == "step3" ) {
	            			goUrl("loanStep3View.do?" + params.join("&"));
	                    }
                    }
                });
          });
      	//hideLoading();
    };
    
    $( "body" ).on( "click", "[name='btnLoanList']", function() { // 
    	var id = ($(this).attr("gubun"));
    	$(this).parent().find("[name='btnLoanList']").css("font-weight","");
    	$(this).css("font-weight","bold");
        list(id);    
    });
    
    (function () {
        var params=[];
    	// 고객상담 : con
    	// 사전품의 : loan
    	// 여신약정 : sign
            list("${statgroup}");
    })();
	//showLoading();
   	//hideLoading();   
});

// index..
function fListSeq() {
	return ++window.listSeq;
}
</script>
<script id="list01Template" type="text/x-jquery-tmpl">
<tr>
<td>\${fListSeq(0)}</td>
<td>\${USER_NAME}</td>
<td>\${REGISTER_NO.substring(0,6)}-*******</td>
<td>\${MOBILE_NO.substring(0,MOBILE_NO.length-3)}***</td>
<td align="center">    
{{if LOAN_STATE_CD==window.LOAN_STATE_CD.CONSULT_END && IDCARD_VERIFY_RESULT==window.IDCARD_VERIFY_RESULT_TYPE.SUCCESS }}
    <button name="btn" gubun="step2" type="button" class="btn btn_middle btn_blueline">등록하기</button>

{{else CODE_VAL2=='J' && LOAN_STATE_CD!=window.LOAN_STATE_CD.CONSULT_END }}
    <button name="btn" gubun="step3" type="button" class="btn btn_middle btn_blueline">\${LOAN_STATE_NM}</button>

{{else CODE_VAL2=='C' }}
    <button name="btn" gubun="step3" type="button" class="btn btn_middle btn_blueline">\${LOAN_STATE_NM}</button>

{{else}}
    <button name="btn" gubun="step1" type="button" class="btn btn_middle btn_blueline">등록하기</button>
{{/if}}
</td>
<td>\${formatDate(LOANREQ_DATIME)}</td>
</tr>
</script>
<body>
<div id="layout">

    <div id="wrap">
        <div id="wrapper">
            <div class="navi_action">
                <div class="navi_hidebtn"></div>
            </div>
            <!-- LNB area -->
            <div id="navi" >
            </div>

            <!-- contents area -->
            <div id="contentsarea">
				<!-- title_area-->
				<div class="title_wrap">
					<h3 class="title">사전품의</h3>
				</div>
				<div id="contents">
<%-- ${statgroup}
	<button type="button" name="btnLoanList"  gubun="con"
<c:if test='${statgroup == "con"}'>
style="font-weight:bold"
</c:if>
>고객상담</button>
<button type="button" name="btnLoanList" gubun="loan"
<c:if test='${statgroup == "loan"}'>
style="font-weight:bold"
</c:if>
>사전품의</button>

<button type="button" name="btnLoanList" gubun="sign"
<c:if test='${statgroup == "sign"}'>
style="font-weight:bold"
</c:if>
>여신거래약정</button>
 --%>
						<ul class="tabs" data-ui="tabs_UI">
							<li gubun="con" name="btnLoanList"
<c:if test='${statgroup == "con"}'>
class="on"
</c:if>
							>고객상담<span name=spnCntCon>02</span></li>						
							<li gubun="loan" name="btnLoanList"
<c:if test='${statgroup == "loan"}'>
class="on"
</c:if>
							>사전품의<span name=spnCntLoan>00</span></li>						
							<li gubun="sign" name="btnLoanList"
<c:if test='${statgroup == "sign"}'>
class="on"
</c:if>
							>여신거래약정<span name=spnCntSign>00</span></li>						
							
						</ul>
						
<!-- 					<div class="title_box">
						<h4 class="title">대상고객목록</h4>
					</div> -->
					<div class="tbl_box">
						<table id="list01" class="list_tbl01" summary="NO,고객명,주민등록번호,휴대폰번호,사전품의">
							<caption>조회</caption>
							<colgroup>
								<col style="width:5%;" />
								<col style="width:18%;" />
								<col style="width:*" />
								<col style="width:20%;" />
								<col style="width:23%;" />
								<col style="width:14%;" />
							</colgroup>
							<thead>
								<tr>
									<th scope="col">NO</th>
									<th scope="col">고객명</th>
									<th scope="col">주민등록번호</th>
									<th scope="col">휴대폰번호</th>
									<th scope="col">사전품의</th>
									<th scope="col">신청일자</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>																	
					</div>
								
<!--
 					<div class="btn_wrap">
						<button type="button" class="btn btn_normal btn_green">신규등록</button>
					<div>
-->
				</div>
            </div>	
        </div>
    </div>

</div> <!-- // layout -->
<%@include file="/inc/footer.jsp" %>