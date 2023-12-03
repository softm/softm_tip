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
              params.push("loanreq_seq=${param.loanreq_seq}");
          exec("/consultResultInfo.do", params.join("&"),function(data) {
                //
                if ( data.RESULT_CD == RESULT_CD.OK ) {                
                    var userIdno = data.USER_IDNO;
                    
                    $("#cssProcForm [name='loan_state_cd']").val(data.LOAN_STATE_CD); // CSS 재조회시 조회시 상태 셋팅
                    $("#cssProcForm [name='register_no']").val(userIdno); // CSS 재조회시 주민번호 셋팅
                    
                    $( "#view01Template" ).tmpl( data ).appendTo( "#view01 .view" );
                    
                    $( "#spnLOAN_TOT_CNT" ).text(data.LOAN_TOT_CNT);
                    $( "#spnCASH_TOT_CNT" ).text(data.CASH_TOT_CNT);
                    $( "#spnGRNTY_TOT_CNT" ).text(data.GRNTY_TOT_CNT);
                    $( "#spnPES_LOAN_TOT_COUNT" ).text(data.PES_LOAN_TOT_COUNT);                    
                    //LIST01~10
				var keyArr = [
					"LIST_LOAN"        , // 대출정보                   1
					"LIST_CASH"        , // 현금서비스정보             2
					"LIST_GRNTY"       , // 채무보증정보               3
					"LIST_PES"         , // 개인계좌별대출정보         4
					"LIST_CBS_GOOD"    , // 평점사유코드-긍정적요인    5
					"LIST_CBS_BAD"     , // 평점사유코드-부정적요인    6
					"LIST_DEBT"        , // 대부업종합대출정보(1차)    7
					"LIST_PRVT_LOAN"   , // 대부업대출정보(2차)        8
					"LIST_PRVT_GRNTY"  , // 대부업채무불이행정보       9
					"LIST_PRVT_DEFAULT", // 대부업채무불이행정보       10
					"LIST_CBSCORE"       // 금융 CB스코어[RK0400_000]  11
				];
                 // for ( var i=1;i<=10; i++ ) {
                    for ( var i in keyArr) {
                    	console.info(keyArr[i]);
                    	var idStr = keyArr[i];
                     // var idStr = "list" + ( ( '00' + i).slice( -2 ) );
                        $( "#"+idStr+" .list" ).empty();
                        if ( i == 1 ) {
                        } else if ( i == 2 ) {
                        }

                        $( "#"+idStr+"Template" ).tmpl( data[idStr] ).appendTo( "#"+idStr +" .list" );
                    }

                    $( "#view07Template" ).tmpl( data ).appendTo( "#view07 .view" );
                    $( "#view08Template" ).tmpl( data ).appendTo( "#view08 .view" );

                } else {
                }
          });
    };
    list();
    //hideLoading();

    $( "body" ).on( "click", "#btnReq", function() { // 사전품의신청
        $("#statProcForm [name='loan_state_cd']").val(LOAN_STATE_CD.CONSULT_END); // 상태
        var d = $("#statProcForm").serialize();
        exec("/statProc.do", d,function(data) {
            
            if ( data.RESULT_CD == RESULT_CD.OK ) {
                goUrl("/loanListView.do?statgroup=con&lnbSeq=4");
            } else {
            }
        });
    });

    $( "body" ).on( "click", "#btnCancel", function() { // 상담취소
        if ( confirm("취소하시겠습니까?") ) {
            $("#statProcForm [name='loan_state_cd']").val(LOAN_STATE_CD.CONSULT_CANCEL); // 상태
            var d = $("#statProcForm").serialize();
            exec("/statProc.do", d,function(data) {
                
                if ( data.RESULT_CD == RESULT_CD.OK ) {
                    goUrl("/consultView.do");
                } else {
                }
            });
        }
    });
    
    $( "body" ).on( "click", "#btnCSS", function() { // CSS 재조회
        if ( confirm("CSS 조회를 하시겠습니까?") ) {
            var d = $("#cssProcForm").serialize();
            showLoading();
            exec("/cssProc.do", d,function(data) {
                if ( data.RESULT_CD == RESULT_CD.OK ) {
                	goUrl("/consultResultView.do"
                			+ "?loanreq_seq=" + '${param.loanreq_seq}'
                            + "&pt_cust_no="  + '${param.pt_cust_no}'
                            + "&lnbSeq=1"
                			);
                } else {
                	hideLoading();
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

<script id="LIST_LOANTemplate" type="text/x-jquery-tmpl">
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

<script id="LIST_CASHTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${CASH_REASON_NM}</td>
    <td>\${CASH_COMPANY_NAME}</td>
    <td>\${CASH_BRANCH_NAME}</td>
    <td>\${formatDate(CASH_BEGIN_DT)}</td>
    <td>\${formatDate(CASH_UPDATE_DT)}</td>
    <td>\${formatNumber(CASH_AMOUNT)}</td>
</tr>
</script>


<script id="LIST_GRNTYTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${GRNTY_REASON_NM}</td>
    <td>\${GRNTY_COMPANY_NAME}</td>
    <td>\${GRNTY_BRANCH_NAME}</td>
    <td>\${formatDate(GRNTY_BEGIN_DT)}</td>
    <td>\${formatDate(GRNTY_UPDATE_DT)}</td>
    <td>\${formatNumber(GRNTY_AMOUNT)}</td>
</tr>
</script>

<script id="LIST_PESTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${PES_REASON_NM}</td>
    <td>\${PES_COMPANY_NAME}</td>
    <td>\${PES_BRANCH_NAME}</td>
    <td>\${PES_BANK_CODE_NM}</td>
    <td>\${formatDate(PES_BEGIN_DT)}</td>
    <td>\${formatDate(PES_UPDATE_DT)}</td>
    <td>\${formatNumber(PES_AMOUNT)}</td>
    <td>\${PES_LOAN_TYPE_NM}</td>
</tr>
</script>

<script id="LIST_CBS_GOODTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${CBSCORE_CODE}</td>
    <td class="alignLeft">\${CBSCORE_NAME}</td>
</tr>
</script>
<script id="LIST_CBS_BADTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${CBSCORE_CODE}</td>
    <td class="alignLeft">\${CBSCORE_NAME}</td>
</tr>
</script>
<script id="LIST_DEBTTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${DEBT_CODE}</td>
    <td>\${formatDate(DEBT_LOAN_DATE)}</td>
    <td>\${formatNumber(DEBT_LOAN_VAL)}</td>
</tr>
</script>
<script id="LIST_PRVT_LOANTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${PRVT_LOAN_COMPANY_IND_CODE_NM}</td>
    <td>\${formatDate(PRVT_LOAN_BEGIN_DT)}</td>
    <td>\${formatNumber(PRVT_LOAN_AMOUNT)}</td>
</tr>
</script>

<script id="LIST_PRVT_GRNTYTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${PRVT_GRNTY_REASON_NM}</td>
    <td>\${formatDate(PRVT_GRNTY_BEGIN_DT)}</td>
    <td>\${formatDate(PRVT_GRNTY_UPDATE_DT)}</td>
    <td>\${formatNumber(PRVT_GRNTY_AMOUNT)}</td>
</tr>
</script>
<script id="LIST_PRVT_DEFAULTTemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${fList10Seq(0)}</td>
    <td>\${PRVT_DEFAULT_REASON_NM}</td>
    <td>\${formatDate(PRVT_DEFAULT_BEGIN_DT)}</td>
    <td>\${formatDate(PRVT_DEFAULT_PROVIDE_DT)}</td>
    <td>\${formatNumber(PRVT_DEFAULT_DEFAULT_AMOUNT)}</td>
</tr>
</script>

<script id="view01Template" type="text/x-jquery-tmpl">
                                <tr>
                                    <th scope="row">고객명</th>
                                    <td>\${USER_NAME}</td>
                                    <th scope="row">주민번호</th>
                                    <td>\${USER_IDNO.substring(0,6)}-\${USER_IDNO.substring(6,13)}</td>
                                </tr>
                                <tr>
                                    <th scope="row">휴대폰</th>
                                    <td>\${MOBILE_AGENCY_CD} \${MOBILE_NO1}-\${MOBILE_NO2}-\${MOBILE_NO3}</td>
                                    <th scope="row">필요금액</th>
                                    <td>\${formatNumber(BEFORE_WANT_AMT)} 만원</td>
                                </tr>
                                <tr>
                                    <th scope="row">자금용도</th>
                                    <td>\${FUND_USE}</td>
                                    <th scope="row"></th>
                                    <td></td>
                                </tr>
</script>

<script id="LIST_CBSCORETemplate" type="text/x-jquery-tmpl">
<tr>
    <td>\${CBSCORE_TYPE_NM}</td>
    <td>\${formatNumber(CBSCORE_SCORE)}</td>
    <td>\${CBSCORE_GRADE}</td>
    <td>\${CBSCORE_REFERENCE2}</td>
    <td>\${NICE_SOHO_GRADE}</td>
    <td>\${formatNumber(NICE_SOHO_AVG)}</td>
</tr>
</script>

<script id="view07Template" type="text/x-jquery-tmpl">
    <tr><th>대부업대출 총건수</th><td>\${formatNumber(DLOAN_TOT_COUNT)}</td><th>대부업대출 누적건수</th><td>\${formatNumber(DLOAN_ACC_COUNT)}</td><td class="invisible"></td></tr>
    <tr><th>대부업대출 응답건수</th><td>\${formatNumber(DLOAN_RES_COUNT)}</td><th>대부업대출 총금액</th><td>\${formatNumber(DLOAN_TOT_AMT)}</td><td class="invisible"></td></tr>
</script>
<script id="view08Template" type="text/x-jquery-tmpl">
    <tr><th>대부업대출 총건수<BR/>(대부업 이외항목 포함)</th><td>\${formatNumber(SUMMARY_PRVT_TOT_AMT)}</td><th>대부업대출 누적건수</th><td>\${formatNumber(SUMMARY_ACC_PRVT_CNT)}</td><td class="invisible"></td></tr>
    <tr><th>대부업대출 총금액</th><td colspan="3">\${formatNumber(SUMMARY_PRVT_TOT_AMT)}</td><td class="invisible"></td></tr>
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
<form id="statProcForm">
    <input type="text" name="loanreq_seq"   class="hidden" value="${param.loanreq_seq}"/>
    <input type="text" name="pt_cust_no"    class="hidden" value="${param.pt_cust_no}"/>
    <input type="text" name="loan_state_cd" class="hidden" />
    <input type="text" name="admin_no"      class="hidden"/>
</form>

<form id="cssProcForm">
    <input type="text" name="loanreq_seq"   class="hidden" value="${param.loanreq_seq}"/>
    <input type="text" name="pt_cust_no"    class="hidden" value="${param.pt_cust_no}"/>
    <input type="text" name="loan_state_cd" class="hidden" />
    <input type="text" name="register_no"   class="hidden"/>
</form>

<%-- pt_cust_no : ${param.pt_cust_no}<Br/> --%>
<form id="wForm">
    <input type="text" name="user_idno"      class="hidden"/>
    <input type="text" name="admin_no"       class="hidden"/>
    <input type="text" name="info_auth_way"  class="hidden"/>
    <input type="text" name="info_auth"      class="hidden"/>
    <input type="text" name="cert_cre_dt"    class="hidden"/>

                <!-- title_area-->
                <div class="title_wrap">
                    <h3 class="title">고객상담</h3>
                    <div class="step_wrap">
                        <ul class="step">
							<li><span>01</span></li>
							<li class="current"><span>02</span>신용정보 조회결과</li>
                            
                        </ul>
                    </div>
                </div>

                <div id="contents">

                    <div class="title_box">
                        <h4 class="title">고객정보</h4>
                    </div>
                    <div class="tbl_box">
                        <table id="view01" class="list_tbl02" summary="">
                            <caption>고객정보</caption>
                            <colgroup>
                                <col style="width:20%;" />
                                <col style="width:30%;" />
                                <col style="width:20%;" />
                                <col style="width:30%;" />
                            </colgroup>
                            <tbody class="view">

                            </tbody>
                        </table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">대출정보 ( <span id="spnLOAN_TOT_CNT"></span> 건 ) </h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>                        
                        <!--  [금액단위 : 천원] -->
                    </div>
                    <div class="tbl_box">
						<table id="LIST_LOAN" class="list_tbl01" summary="">
							<caption>조회</caption>
							<colgroup>
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:15%;" />
							</colgroup>
							<thead>
								<tr>
								    <th scope="col">사유코드</th>
								    <th scope="col">발생기관</th>
								    <th scope="col">발생지점</th>
								    <th scope="col">개설일자</th>
								    <th scope="col">변경일자</th>
								    <th scope="col">개설금액</th>
								    <th scope="col">담보여부</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>
                    </div>


                    <div class="title_box">
                        <h4 class="title">현금서비스정보 ( <span id="spnCASH_TOT_CNT"></span> 건 ) </h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>                        
                        <!--  [금액단위 : 천원] -->
                    </div>
                    <div class="tbl_box">
						<table id="LIST_CASH" class="list_tbl01" summary="">
							<caption>조회</caption>
							<colgroup>
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:20%;" />
								<col style="width:20%;" />
								<col style="width:15%;" />
							</colgroup>
							<thead>
								<tr>
								    <th scope="col">사유코드</th>
								    <th scope="col">발생기관</th>
								    <th scope="col">발생지점</th>
								    <th scope="col">개설일자</th>
								    <th scope="col">변경일자</th>
								    <th scope="col">개설금액</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">채무보증정보 ( <span id="spnGRNTY_TOT_CNT"></span> 건 ) </h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>                        
                        <!--  [금액단위 : 천원] -->
                    </div>
                    <div class="tbl_box">
						<table id="LIST_GRNTY" class="list_tbl01" summary="">
							<caption>조회</caption>
							<colgroup>
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:15%;" />
								<col style="width:20%;" />
								<col style="width:20%;" />
								<col style="width:15%;" />
							</colgroup>
							<thead>
								<tr>
								    <th scope="col">사유코드</th>
								    <th scope="col">발생기관</th>
								    <th scope="col">발생지점</th>
								    <th scope="col">개설일자</th>
								    <th scope="col">변경일자</th>
								    <th scope="col">개설금액</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">개인계좌별대출정보 ( <span id="spnPES_LOAN_TOT_COUNT"></span> 건 ) </h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>                        
                        <!--  [금액단위 : 천원] -->
                    </div>
                    <div class="tbl_box">
						<table id="LIST_PES" class="list_tbl01" summary="">
							<caption>조회</caption>
							<colgroup>
								<col style="width:15%;" />
								<col style="width:10%;" />
								<col style="width:10%;" />
								<col style="width:10%;" />
								<col style="width:15%;" />
								<col style="width:20%;" />
								<col style="width:10%;" />
								<col style="width:10%;" />
							</colgroup>
							<thead>
								<tr>
								    <th scope="col">사유코드      </th>
								    <th scope="col">발생기관명    </th>
								    <th scope="col">발생지점명    </th>
								    <th scope="col">전은연업권코드</th>
								    <th scope="col">개설일,발생일 </th>
								    <th scope="col">변경일        </th>
								    <th scope="col">금액          </th>
								    <th scope="col">대출구분      </th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">금융 CB스코어[RK0400_000]</h4>
                    </div>
                    <div class="tbl_box">
                        <table id="LIST_CBSCORE" class="list_tbl01" summary="">
                            <caption>금융 CB스코어[RK0400_000]</caption>
                            <colgroup>
                                <col style="width:20%;" />
                                <col style="width:16%;" />
                                <col style="width:16%;" />
                                <col style="width:16%;" />
                                <col style="width:16%;" />
                                <col style="width:16%;" />
                            </colgroup>
							<thead>
                                    <tr>
                                    <th scope="col">CB스코어구분명</th>
                                    <th scope="col">신용평점      </th>
                                    <th scope="col">신용등급      </th>
                                    <th scope="col">누적순위      </th>
                                    <th scope="col">소호등급     </th>
                                    <th scope="col">소호평점     </th>
                                    </tr>							
							</thead>
							<tbody class="list">
							</tbody>
                        </table>
                    </div>
               
                    <div class="title_box">
                        <h4 class="title">평점사유코드-긍정적요인 </h4>
                    </div>
                    <div class="tbl_box">
						<table id="LIST_CBS_GOOD" class="list_tbl01" summary="">
							<caption>조회</caption>
							<colgroup>
								<col style="width:30%;" />
								<col style="width:70%;" />
							</colgroup>
							<thead>
								<tr>
								    <th scope="col">사유코드</th>
								    <th scope="col">사유설명</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>
                    </div>
                    
                    <div class="title_box">
                        <h4 class="title">평점사유코드-부정적요인 </h4>
                    </div>
                    <div class="tbl_box">
						<table id="LIST_CBS_BAD" class="list_tbl01" summary="">
							<caption>조회</caption>
							<colgroup>
								<col style="width:30%;" />
								<col style="width:70%;" />
							</colgroup>
							<thead>
								<tr>
								    <th scope="col">사유코드</th>
								    <th scope="col">사유설명</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">대부업계 종합대출정보(1차)</h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>                        
                        <!--  [금액단위 : 천원] -->                        
                    </div>
                    <div class="tbl_box">
                        <table id="view07" class="list_tbl02" summary="">
                            <caption>대부업계 종합대출정보(1차)</caption>
                            <colgroup>
                                <col style="width:29%;" />
                                <col style="width:21%;" />
                                <col style="width:29%;" />
                                <col style="width:21%;" />
                            </colgroup>                            
                            <tbody class="view">

                            </tbody>
                         </table>
                         <br/>
                         <table id="LIST_DEBT" class="list_tbl01" summary="">
                            <colgroup>
                                <col style="width:34%;" />
                                <col style="width:33%;" />
                                <col style="width:33%;" />
                            </colgroup> 
							<thead>
                                    <tr>
                                    <th scope="col">업계코드</th>
                                    <th scope="col">대출일자      </th>
                                    <th scope="col">대출잔액      </th>
                                    </tr>							
							</thead>
							<tbody class="list">
							</tbody>							
                        </table>
                    </div>
                    
                    <div class="title_box">
                        <h4 class="title">신정원 대부업고유 대출정보(2차)</h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>                        
                        <!--  [금액단위 : 천원] -->                        
                    </div>
                    <div class="tbl_box">
                        <table id="view08" class="list_tbl02" summary="">
                            <caption>신정원 대부업고유 대출정보(2차)</caption>
                            <colgroup>
                                <col style="width:29%;" />
                                <col style="width:21%;" />
                                <col style="width:29%;" />
                                <col style="width:21%;" />
                            </colgroup>                            
                            <tbody class="view">

                            </tbody>
                         </table>
                         <br/>
                         <table id="LIST_PRVT_LOAN" class="list_tbl01" summary="">
                            <colgroup>
                                <col style="width:34%;" />
                                <col style="width:33%;" />
                                <col style="width:33%;" />
                            </colgroup> 
							<thead>
                                    <tr>
                                    <th scope="col">업계코드</th>
                                    <th scope="col">대출일자      </th>
                                    <th scope="col">대출잔액      </th>
                                    </tr>							
							</thead>
							<tbody class="list">
							</tbody>							
                        </table>
                    </div>
                    
                    <div class="title_box">
                        <h4 class="title">신정원 대부업고유 채무보증 정보</h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>                        
                    </div>
                    <div class="tbl_box">
						<table id="LIST_PRVT_GRNTY" class="list_tbl01" summary="">
							<caption>신정원 대부업고유 채무보증 정보</caption>
							<colgroup>
								<col style="width:32%;" />
								<col style="width:23%;" />
								<col style="width:23%;" />
								<col style="width:22%;" />
							</colgroup>
							<thead>
								<tr>
								    <th scope="col">사유코드</th>
								    <th scope="col">개설일자</th>
								    <th scope="col">변경일자</th>
								    <th scope="col">개설금액</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>
                    </div>
                    
                    <div class="title_box">
                        <h4 class="title">신정원 대부업고유 채무보증 정보</h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>                        
                    </div>
                    <div class="tbl_box">
						<table id="LIST_PRVT_DEFAULT" class="list_tbl01" summary="">
							<caption>신정원 대부업고유 채무불이행 정보</caption>
							<colgroup>
								<col style="width:10%;" />
								<col style="width:23%;" />
								<col style="width:22%;" />
								<col style="width:20%;" />
								<col style="width:25%;" />
							</colgroup>
							<thead>
								<tr>
								    <th scope="col">순번  </th>
								    <th scope="col">사유코드</th>
								    <th scope="col">발생일 </th>
								    <th scope="col">제공일 </th>
								    <th scope="col">연체금액</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>
                    </div>
                    <div class="btn_wrap">
                    	<button type="button" class="btn btn_normal btn_grayline" id="btnCSS">CSS 재조회</button>
                        <button type="button" class="btn btn_normal btn_grayline" id="btnCancel">상담취소</button>
                        <button type="button" class="btn btn_normal btn_green" id="btnReq">사전품의신청</button>
                    </div>
                </div>
</form>
        	</div>
    	</div>
	</div> <!-- // layout -->
</div>
<%@include file="/inc/footer.jsp" %>