<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="신용정보조회결과";
$( document ).ready(function() {
	
	showLoading();
    function list() {
    	window.list10Seq=0;
          var params=[];
              params.push("pt_cust_no=${param.pt_cust_no}");
          exec("/consultResultInfo.do", params.join("&"),function(data) {
                //if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
                if ( data.RESULT_CD == RESULT_CD.OK ) {
                	var userIdno = data.USER_IDNO;
                    $( "#view01Template" ).tmpl( data ).appendTo( "#view01 .view" );
					//LIST01~10
					for ( var i=1;i<=10; i++ ) {
	                    var idStr = "list" + ( ( '00' + i).slice( -2 ) );
	                    $( "#"+idStr+" .list" ).empty();
						if ( i == 1 ) {
	                    	$( "#spnLOAN_TOT_CNT" ).text(data.LOAN_TOT_CNT);
						} else if ( i == 2 ) {
		                    $( "#spnCASH_TOT_CNT" ).text(data.CASH_TOT_CNT);							
						}
	                    
	                    $( "#"+idStr+"Template" ).tmpl( data["LIST"+i] ).appendTo( "#"+idStr +" .list" );
					}
					
                    $( "#view02Template" ).tmpl( data ).appendTo( "#view02 .view" );
                    $( "#view07Template" ).tmpl( data ).appendTo( "#list07 .view" );
                    $( "#view08Template" ).tmpl( data ).appendTo( "#list08 .view" );
					
                } else {
                }
          });
    };
    list();
	hideLoading();
	
    $( "body" ).on( "click", "#btnReq", function() { // 사전품의신청
 	    $("#statProcForm [name='loan_state_cd']").val(LOAN_STATE_CD.CONSULT_END); // 상태
        var d = $("#statProcForm").serialize();
        exec("/statProc.do", d,function(data) {
            if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
            if ( data.RESULT_CD == RESULT_CD.OK ) {
            	goUrl("/loanListView.do?statgroup=con");
            } else {
            }
        });    
    });
    
    $( "body" ).on( "click", "#btnCancel", function() { // 상담취소
    	if ( confirm("취소하시겠습니까?") ) {
            $("#statProcForm [name='loan_state_cd']").val(LOAN_STATE_CD.CONSULT_CANCEL); // 상태    	      
    	    var d = $("#statProcForm").serialize();
    	    exec("/statProc.do", d,function(data) {
    	        if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
    	        if ( data.RESULT_CD == RESULT_CD.OK ) {
    	        	goUrl("/consultView.do");    	            	
    	        } else {
    	        }
    	    });
    	}
    });
    
});

// index..
function fList10Seq() {
	return ++window.list10Seq;
}
</script>

<script id="list01Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${LOAN_REASON_NM   }</td>
    <td>\${LOAN_COMPANY_NAME}</td>
    <td>\${LOAN_BRANCH_NAME }</td>
    <td>\${formatDate(LOAN_BEGIN_DT)   }</td>
    <td>\${formatDate(LOAN_UPDATE_DT)   }</td>
    <td>\${formatNumber(LOAN_AMOUNT)      }</td>
    <td>\${LOAN_MORT_YN     }</td>
</tr>
</script>

<script id="list02Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${CASH_REASON_NM}</td>
    <td>\${CASH_COMPANY_NAME}</td>
    <td>\${CASH_BRANCH_NAME}</td>
    <td>\${formatDate(CASH_BEGIN_DT)}</td>
    <td>\${formatDate(CASH_UPDATE_DT)}</td>
    <td>\${formatNumber(CASH_AMOUNT)}</td>
</tr>
</script>


<script id="list03Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${GRNTY_REASON_NM}</td>
    <td>\${GRNTY_COMPANY_NAME}</td>
    <td>\${GRNTY_BRANCH_NAME}</td>
    <td>\${formatDate(GRNTY_BEGIN_DT)}</td>
    <td>\${formatDate(GRNTY_UPDATE_DT)}</td>
    <td>\${formatNumber(GRNTY_AMOUNT)}</td>
</tr>
</script>

<script id="list04Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${GRNTY_REASON_NM}</td>
    <td>\${GRNTY_COMPANY_NAME}</td>
    <td>\${GRNTY_BRANCH_NAME}</td>
    <td>\${formatDate(GRNTY_BEGIN_DT)}</td>
    <td>\${formatDate(GRNTY_UPDATE_DT)}</td>
    <td>\${formatNumber(GRNTY_AMOUNT)}</td>
</tr>
</script>

<script id="list05Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${CBSCORE_CODE}</td>
    <td>\${CBSCORE_NAME}</td>
</tr>
</script>
<script id="list06Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${CBSCORE_CODE}</td>
    <td>\${CBSCORE_NAME}</td>
</tr>
</script>
<script id="list07Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${DEBT_CODE}</td>
    <td>\${formatDate(DEBT_LOAN_DATE)}</td>
    <td>\${formatNumber(DEBT_LOAN_VAL)}</td>
</tr>
</script>
<script id="list08Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${PRVT_LOAN_COMPANY_IND_CODE_NM}</td>
    <td>\${formatDate(PRVT_LOAN_BEGIN_DT)}</td>
    <td>\${formatNumber(PRVT_LOAN_AMOUNT)}</td>
</tr>
</script>

<script id="list09Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${PRVT_GRNTY_REASON_NM}</td>
    <td>\${formatDate(PRVT_GRNTY_BEGIN_DT)}</td>
    <td>\${formatDate(PRVT_GRNTY_UPDATE_DT)}</td>
</tr>
</script>
<script id="list10Template" type="text/x-jquery-tmpl">
<tr>
    <td>\${fList10Seq(0)}</td>
    <td>\${PRVT_DEFAULT_REASON_NM}</td>
    <td>\${formatDate(PRVT_DEFAULT_BEGIN_DT)}</td>
    <td>\${formatDate(PRVT_DEFAULT_PROVIDE_DT)}</td>
    <td>\${formatNumber(PRVT_DEFAULT_DEFAULT_AMOUNT)}</td>
</tr>
</script>

<script id="view01Template" type="text/x-jquery-tmpl">
	<tr><th>성명</th><td>\${USER_NAME}</td><th>주민번호</th><td>\${USER_IDNO.substring(0,6)}-\${USER_IDNO.substring(6,13)}</td></tr>
	<tr><th>휴대폰</th><td>\${MOBILE_AGENCY_CD} \${MOBILE_NO1}-\${MOBILE_NO2}-\${MOBILE_NO3}</td><th>필요금액</th><td>\${formatNumber(BEFORE_WANT_AMT)}</td></tr>
	<tr><th>자금용도</th><td>\${FUND_USE}</td><th></th><td></td></tr>
</script>

<script id="view02Template" type="text/x-jquery-tmpl">
	<tr><th>신용위헙평점</th><td>\${formatNumber(CBSCORE_SCORE)}</td><td>\${CBSCORE_GRADE}</td><td>\${formatNumber(CBSCORE_REFERENCE1)}</td><td>\${CBSCORE_REFERENCE2}</td></tr>
</script>

<script id="view07Template" type="text/x-jquery-tmpl">
	<tr><th>대부업대출 총건수</th><td>\${formatNumber(DLOAN_TOT_COUNT)}</td><th>대부업대출 누적건수</th><td>\${formatNumber(DLOAN_ACC_COUNT)}</td></tr>
	<tr><th>대부업대출 응답건수</th><td>\${formatNumber(DLOAN_RES_COUNT)}</td><th>대부업대출 총금액</th><td>\${formatNumber(DLOAN_TOT_AMT)}</td></tr>
</script>
<script id="view08Template" type="text/x-jquery-tmpl">
	<tr><th>대부업대출 총건수<BR/>(대부업 이외항목 포함)</th><td>\${formatNumber(SUMMARY_PRVT_TOT_AMT)}</td><th>대부업대출 누적건수</th><td>\${formatNumber(SUMMARY_PRVT_NOTDEFINED)}</td></tr>
	<tr><th>대부업대출 응답건수<BR/>(대부업 이외항목 포함)</th><td>\${formatNumber(DLOAN_TOT_AMT)}</td><th>대부업대출 총금액</th><td>\${formatNumber(0)}</td></tr>
</script>
<body>

<form id="statProcForm">
    <input type="text" name="loanreq_seq"   class="hidden" value="${param.loanreq_seq}"/>
    <input type="text" name="pt_cust_no"    class="hidden" value="${param.pt_cust_no}"/>
    <input type="text" name="loan_state_cd" class="hidden" />
    <input type="text" name="admin_no"      class="hidden"/>
</form>
<div class='main' id="page1">
pt_cust_no : ${param.pt_cust_no}<Br/>
	<span id="sesName">${sessionScope.ss_user.member_nm}</span> / <span  id="sesDeptName">${sessionScope.ss_user.dept_nm}</span> <button type="button" id="btnLogout">로그아웃</button>
	<br/>
	<br/>
	<button id="slidePage">slidePage</button>
	<table>
		<td valign="top">
			<br/>
			<button type="button" id="btnGoConsult" ><B>고객상담<B></button>
			<br/>
			<button type="button" id="btnGoLoanStep">사전품의</button>
			<br/>
			<button type="button" id="btnGoDealContract" >여신거래약정</button>
			<br/>
			<button type="button" id="btnGoCustMng" >고객관리</button>
			<br/>
			<button type="button" id="btnGoDataRoom">업무자료실</button>
			<br/>
		</td>
		<td>
<form id="wForm">
    <input type="text" name="user_idno"      class="hidden"/>
    <input type="text" name="admin_no"       class="hidden"/>
    <input type="text" name="info_auth_way"  class="hidden"/>
    <input type="text" name="info_auth"      class="hidden"/>
    <input type="text" name="cert_cre_dt"    class="hidden"/>
    
<table id="view01">
	<tr>
	<th>고객정보</th>
	</tr>
    <tbody class="view"></tbody>
	</tr>
</table>

<table id="list01">
	<tr>
	<th>대출정보(<span id="spnLOAN_TOT_CNT"></span> 건)														[금액단위 : 천원]</th>
	</tr>
	<tr>
	<th>사유코드</th>
	<th>발생기관</th>
	<th>발생지점</th>
	<th>개설일자</th>
	<th>변경일자</th>
	<th>개설금액</th>
	<th>담보여부</th>
	</tr>
    <tbody class="list"></tbody>
</table>

<table id="list02">
	<tr>
	<th>현금서비스정보(<span id="spnCASH_TOT_CNT"></span> 건)														[금액단위 : 천원]</th>
	</tr>
	<tr>
	<th>사유코드</th>
	<th>발생기관</th>
	<th>발생지점</th>
	<th>개설일자</th>
	<th>변경일자</th>
	<th>개설금액</th>
	</tr>

    <tbody class="list"></tbody>
</table>

<table id="list03">
	<tr>
	<th>채무보증정보(<span id="spnGRNTY_TOT_CNT"></span> 건)														[금액단위 : 천원]</th>
	</tr>
	<tr>
	<th>사유코드</th>
	<th>발생기관</th>
	<th>발생지점</th>
	<th>개설일자</th>
	<th>변경일자</th>
	<th>개설금액</th>
	</tr>

    <tbody class="list"></tbody>
</table>

<table id="list04">
	<tr>
	<th>개인계좌별대출정보(<span id="spnCASH_TOT_CNT"></span> 건)														[금액단위 : 천원]</th>
	</tr>
	<tr>
	<th>사유코드      </th>
	<th>발생기관명    </th>
	<th>발생지점명    </th>
	<th>전은연업권코드</th>
	<th>발생기관코드  </th>
	<th>개설일,발생일 </th>
	<th>변경일        </th>
	<th>금액          </th>
	<th>계좌번호      </th>
	<th>대출구분      </th>
	</tr>

    <tbody class="list"></tbody>
</table>

<table id="view02">
	<tr>
	<th>금융 CB스코어[<span id="spnCASH_TOT_CNT11111111111"></span>]</th>
	</tr>
	<tr>
	<th>CB스코어구분명</th>
	<th>신용평점      </th>
	<th>신용등급      </th>
	<th>등급별불량율  </th>
	<th>누적순위      </th>
    <tbody class="view"></tbody>
</table>


<table id="list05">
	<tr>
	<th>평점사유코드-긍정적요인</th>
	</tr>
	<tr>

	<th>사유코드      </th>
	<th>사유설명      </th>
	</tr>

    <tbody class="list"></tbody>
</table>


<table id="list06">
	<tr>
	<th>평점사유코드-부정적요인</th>
	</tr>
	<tr>

	<th>사유코드      </th>
	<th>사유설명      </th>
	</tr>

    <tbody class="list"></tbody>
</table>

<table id="list07">
	<tr>
	<th>대부업계 종합대출정보(1차)														[금액단위 : 천원]</th>
	</tr>
    <tbody class="view"></tbody>
    
	<tr>
	<th>업계코드</th>
	<th>대출일자</th>
	<th>대출잔액</th>
	</tr>
    <tbody class="list"></tbody>
</table>

<table id="list08">
	<tr>
	<th>신정원 대부업고유 대출정보(2차)														[금액단위 : 천원]</th>
	</tr>
    <tbody class="view"></tbody>
    	
	<tr>
	<th>업계코드</th>
	<th>대출일자</th>
	<th>대출잔액</th>
	</tr>
    <tbody class="list"></tbody>
</table>

<table id="list09">
	<tr>
	<th>신정원 대부업고유 채무보증 정보</th>
	</tr>
	<tr>
	<th>사유코드      </th>
	<th>개설일자      </th>
	<th>변경일자      </th>
	<th>개설금액      </th>
	</tr>

    <tbody class="list"></tbody>
</table>

<table id="list10">
	<tr>
	<th>신정원 대부업고유 채무불이행 정보</th>
	</tr>
	<tr>
	<th>순번    </th>
	<th>사유코드</th>
	<th>발생일  </th>
	<th>제공일  </th>
	<th>연체금액</th>
	</tr>
    <tbody class="list"></tbody>
</table>

</form>
		</td>
	</table>
	<button id="btnReq">사전품의신청</button>
	<button id="btnCancel">상담취소</button>
</div>

<div class='main hide' id="page2"><div>
<%@include file="/inc/footer.jsp" %>