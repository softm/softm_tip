<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="신청대상목록";
$( document ).ready(function() {

    function list(params) {
    	showLoading();    	
    	  window.listSeq = 0;
          exec("/loanListInfo.do", params.join("&"),function(data) {
                //if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
                if ( data.RESULT_CD == RESULT_CD.OK ) {
                    $( "#list01 .list" ).empty();
                    $( "#list01Template" ).tmpl( data.LIST ).appendTo( "#list01 .list" );                    
                } else {
                }
                
                $( "body" ).off( "click", "#list01 .list #btn").on( "click", "#list01 .list #btn", function() { //
                	var gubun = $(this).attr("gubun");
                    if ( gubun == "I" ) {
                        var params=[];
                        //신청번호		LOANREQ_SEQ
                        //고객번호		PT_CUST_NO
                        var idx = $(this).index();
                        params.push("loanreq_seq=" + data.LIST[idx].LOANREQ_SEQ);
                        params.push("pt_cust_no="  + data.LIST[idx].PT_CUST_NO );
            			goUrl("loanStep1View.do?" + params.join("&"));
                    } else  if ( gubun == "U" ) {
                    	
                    } else  if ( gubun == "P" ) {
                    	
                    }
                });
                
          });
      	hideLoading();
    };
    var params=[];
	// 고객상담 : con
	// 사전품의 : loan
	// 여신약정 : sign
  	<c:if test='${statgroup != null && statgroup != ""}'>
        <c:set var="statgroup"    value="con"/>
        params.push("statgroup=con");
    </c:if>
    <c:if test='${statgroup == null || statgroup == ""}'>
        params.push("statgroup=${statgroup}");
    </c:if>
    list(params);
    
    $( "body" ).on( "click", "[name='btnLoanList']", function() { // 
    	var id = ($(this).attr("gubun"));
    	$(this).parent().find("[name='btnLoanList']").css("font-weight","");
    	$(this).css("font-weight","bold");
        list(["statgroup="+id]);    
    });
    
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
<td>\${REGISTER_NO}</td>
<td>\${MOBILE_NO}</td>
<td align="center"> \${LOAN_STATE_CD}    
{{if LOAN_STATE_CD==window.LOAN_STATE_CD.LOAN_CHECK_END || LOAN_STATE_CD==window.LOAN_STATE_CD.LOAN_CONSULT_START }}
	<button id="btn" gubun="U">수정</button>
{{else LOAN_STATE_CD==window.LOAN_STATE_CD.CONSULT_END}}
	<button id="btn" gubun="I">등록하기</button>
{{else LOAN_STATE_CD==window.LOAN_STATE_CD.LOAN_DOCUMENTA || LOAN_STATE_CD==window.LOAN_STATE_CD.LOAN_DOCUMENTB || LOAN_STATE_CD==window.LOAN_STATE_CD.LOAN_DOCUMENT_MODIFY }}
	<button id="btn" gubun="P">촬영</button>
{{else}}
-
{{/if}}
</td>
</tr>

</script>
<body>
${statgroup}
<div class='main' id="page1">
	<span id="sesName">${sessionScope.ss_user.member_nm}</span> / <span  id="sesDeptName">${sessionScope.ss_user.dept_nm}</span> <button type="button" id="btnLogout">로그아웃</button>
	<br/>
	<br/>
	<button id="slidePage">slidePage</button>
	<table>
		<td valign="top">
			<br/>
			<button type="button" id="btnGoConsult" >고객상담</button>
			<br/>	
			<button type="button" id="btnGoLoanStep"><B>사전품의<B></button>
			<br/>	
			<button type="button" id="btnGoDealContract" >여신거래약정</button>
			<br/>	
			<button type="button" id="btnGoCustMng" >고객관리</button>
			<br/>	
			<button type="button" id="btnGoDataRoom">업무자료실</button>
		</td>
		<td valign="top">
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

<table id="list01"><tbody class="header"><tr>
<th>No</th>
<th>고객명</th>
<th>주민등록번호</th>
<th>휴대폰번호</th>
<th>사전품의</th>
</tr></tbody>
    <tbody class="list"></tbody>
</table>
		</td>
	</table>
</div>
<div class='main hide' id="page2"><div>
<%@include file="/inc/footer.jsp" %>