<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="사전품의STEP3입력";
$( document ).ready(function() {
//    // 다음
//     $( "form" ).on( "submit", function( event ) {
//         event.preventDefault();
//         /* if ( !window.isAuth ) {
//             alert("진위여부 확인을 진행해주세요.");
//         } else */
//         //if ( isValid('#wForm',vRules1) ) {
//     });

    // 주거형태
    $( "body" ).on( "change", "#wForm [name='house_own_cd']", function( event ) {
        if ( $(this).val() == HOUSE_OWN_CD_TYPE.OWN ) {
            $("#wForm [name='house_lease']").removeAttr("disabled");
        } else {
            $("#wForm [name='house_lease']").attr("disabled","disabled");
        }
    });

    // 가족관계
    $( "body" ).on( "change", "#wForm [name='live']", function( event ) {
        var idx = $(this).index() / 2;
        //console.info(idx, $(this).is(":checked"));
        if ( idx == 0 ) $(this).form().find("[name='live_solo'    ]").val($(this).is(":checked")?"Y":"N");
        if ( idx == 1 ) $(this).form().find("[name='live_dad'     ]").val($(this).is(":checked")?"Y":"N");
        if ( idx == 2 ) $(this).form().find("[name='live_mom'     ]").val($(this).is(":checked")?"Y":"N");
        if ( idx == 3 ) $(this).form().find("[name='live_mate'    ]").val($(this).is(":checked")?"Y":"N");
        if ( idx == 4 ) $(this).form().find("[name='live_child'   ]").val($(this).is(":checked")?"Y":"N");
        if ( idx == 5 ) $(this).form().find("[name='live_brother' ]").val($(this).is(":checked")?"Y":"N");
        if ( idx == 6 ) $(this).form().find("[name='live_relation']").val($(this).is(":checked")?"Y":"N");
        if ( idx == 7 ) $(this).form().find("[name='live_etc'     ]").val($(this).is(":checked")?"Y":"N");
    });

    (function(global){
        window.kParams=[];
        window.kParams.push("loanreq_seq=${param.loanreq_seq}");
        window.kParams.push("pt_cust_no=${param.pt_cust_no}");

        //console.info("global :" , global);
        showLoading();
        exec("/loanStep3Info.do", window.kParams.join("&"),function(data) {
              //
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                  $("#tdMobile_no").text(data.MOBILE_NO1 + "-" + data.MOBILE_NO2 + "-" + data.MOBILE_NO3);
                  //$("#tdUser_idno").text(data.MOBILE_NO1 + "-" + data.MOBILE_NO2 + "-" + data.MOBILE_NO3);

                    var salesAmt = parseInt(data.CARD_SALE_AMT,10) + parseInt(data.CASH_SALE_AMT,10); // 월매출 = 매출합계 = 카드매출+현금매출
                    var merchanRate = parseInt( data.MERCHAN_RATE,10 ) / 100; // 상품원가비율 : 30
                    var merchanCost = Math.trunc(salesAmt * merchanRate); // 상품원가

                    $("#tdSale_amt").text(formatNumber(salesAmt)); //월매출
                    $("#tdMerchan_cost").text(formatNumber(merchanCost)); // 상품원가

                  //var placeGuaranAmt = parseInt(data.PLACE_GUARAN_AMT,10); // 임대료 = 월세
                    var placeGuaranAmt = parseInt(data.PLACE_RENT_AMT,10); // 임대료 = 월세
                    var personCost = parseInt(data.PERSON_COST); // 인건비
                    $("#tdPlace_rent_amt").text(formatNumber(placeGuaranAmt)); // 임대료 = 월세
                    $("#tdPerson_cost").text(formatNumber(personCost)); // 인건비
                    $("#tdBenifit").text(formatNumber(salesAmt -(merchanCost+placeGuaranAmt+personCost))); // 영업이익 = 월매출 - (상품원가+임대료+인건비)

                    $("#tdMonth_prin_int_amt").text(formatNumber(data.MONTH_PRIN_INT_AMT)); // 월.대출금불입금액

                    var surtax = (salesAmt - merchanCost)* 0.1 // (월매출 - 상품원가)* 0.1
                    $("#tdSurtax").text(formatNumber(surtax)); // 부가세

                    $("#tdCaddr").text(data.CADDR); // 사업장위치
                    $("#tdOpening_dy").text(formatDate(data.OPENING_DY) + " / " + data.COMPANY_TYPE ); // 사업업력/사업자구분
                    $("#tdCompany_appr").text(data.COMPANY_APPR); // 사업장접근성
                    $("#tdRegInfo").text(data.LIVING_CD + " / " + data.HOUSE_OWN_CD + " / " + data.RADDR ); // 거주현황 : 주거형태/ 주택소유형태/ 주소
					$("#tdCar_own_yn").text(data.CAR_OWN_YN + " / [" + data.HOUSE_OWN_CD+"] : "+ formatNumber(data.HOUSER_LEASE)); // 차량및재산보유현황

                    var sFamily = [];
                    if ( data.LIVE_SOLO    == "Y") sFamily.push("단독" );
                    if ( data.LIVE_DAD     == "Y") sFamily.push("부"  );
                    if ( data.LIVE_MOM     == "Y") sFamily.push("모"  );
                    if ( data.LIVE_MATE    == "Y") sFamily.push("배우자");
                    if ( data.LIVE_CHILD   == "Y") sFamily.push("자녀" );
                    if ( data.LIVE_BROTHER == "Y") sFamily.push("형제" );
                    if ( data.LIVE_RELATION== "Y") sFamily.push("친척" );
                    if ( data.LIVE_ETC     == "Y") sFamily.push("기타" );
                    // 가족관계
                    $("#tdSim01").text(sFamily.join(", "));
                    if (data.CUTOFF_LIVE_SOLO        == "Y") $("#chkSim01").attr("checked","checked"); // 단독세대여부
                    if (data.CUTOFF_HOUSE_LEASE      == "Y") $("#chkSim02").attr("checked","checked"); // 보증금 1000만원 미만 월세거주자
                    if (data.CUTOFF_COMPANY_REALOPER == "Y") $("#chkSim03").attr("checked","checked"); // 사업장등록증상 운영자와 실운영자가 다른경우
                    if (data.CUTOFF_CBSCORE_NEG      == "Y") $("#chkSim04").attr("checked","checked"); // 과거신용판단해제이력보유자
                    if (data.CUTOFF_DELAY_DAYS       == "Y") $("#chkSim05").attr("checked","checked"); // 10일이상연체여부
                    if (data.CUTOFF_CASH_TOT_CNT     == "Y") $("#chkSim06").attr("checked","checked"); // 현금서비스3건500만원초과
                    if (data.CUTOFF_SUMMARY_PRVT     == "Y") $("#chkSim07").attr("checked","checked"); // 대부업사용
                    if (data.CUTOFF_LOAN_TOT         == "Y") $("#chkSim08").attr("checked","checked"); // 대출정보
                    if (data.CUTOFF_3MONTHLOAN_TOT   == "Y") $("#chkSim09").attr("checked","checked"); // 최근3개월내 대출

                    $("#tdSim02").text(formatNumber(data.PLACE_RENT_AMT)                                                                ); // 사업장 보증금 ( 월세 )            
                    $("#tdSim03").text(data.COMPANY_REALOPER + " ( " + data.COMPANY_REALOPER_MEMO + " ) "                               ); // 사업장실운영자(사업장실운영자메모)
                    $("#tdSim04").text(data.CUTOFF_CBSCORE_NEG_NM                       ); // 평점사유코드-부정적요인 코드확인  
                    $("#tdSim05").text(formatNumber(data.DELAY_ISSUE_DAY        )  ); // 연체발생일/연체발생건수           
                    $("#tdSim06").text(formatNumber(data.CASH_TOT_CNT           ) + " / " + formatNumber(data.CASH_TOT_AMT          )   ); // 현금서비스건/금액                 
                    $("#tdSim07").text(formatNumber(data.SUMMARY_PRVT_CNT       ) + " / " + formatNumber(data.SUMMARY_PRVT_TOT_AMT  )   ); // 대부업사용건수/금액               
                    $("#tdSim08").text(formatNumber(data.LOAN_TOT_CNT           ) + " / " + formatNumber(data.LOAN_TOT_AMT          )   ); // 대출정보건수/금액                 
                    $("#tdSim09").text(formatNumber(data.MONTHLOAN_TOT_CNT  ) + " / " + formatNumber(data.MONTHLOAN_TOT_AMT )   ); // 최근3개월내대출건수/금액          

                    $("#tdSim10").text(data.NICE_ALL_GRADE  ); // CB등급
                    $("#tdSim11").text(formatNumber(data.CBCARD_CNT    )  ); // 신용카드보유건수
                    $("#tdSim12").text(formatNumber(data.GRNTY_LOAN_CNT)  ); // 보증채무(당행제외)

                    $("#tdHando").text(formatNumber(salesAmt * 3)); // 가능한도

                    bindJsonToForm(data,"#wForm",{
                        user_name:function(form,v) {
                            $("#tdUser_name").text(v);
                        },
                        user_idno:function(form,v) {
                           form.find("#tdUser_idno").text(v.substring(0,6) + "-" +v.substring(6,13));
                        },
                        before_want_amt:function(form,v) { // 필요금액
                            $("#tdBefore_want_amt").text(formatNumber(v) +" 만원");
                        },
                        fund_use:function(form,v) {
                            $("#tdFund_use").text(v);
                        },
                        living_cd:function(form,v) {

                        }
                    });

                    if ( data.CODE_VAL2 == "J" ) {
                    	$("#btnUpdate").removeClass("dsNone");
                	    $( "body" ).on( "click", "#btnUpdate", function() { // 수정
                            goUrl( "/loanStep2View.do"
                                    + "?" + window.kParams.join("&")
                            );                	             
                	    });                    	
                    }
              } else {
              }
        });
        
	    $( "body" ).on( "click", "#btnOz", function() { // openOZ
            event.preventDefault();
	        openOZ("LoanPic",window.kParams.join("&"));
	    });
        
        hideLoading();

    })(window);
});

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
                    <div class="step_wrap">
                        <ul class="step">
                            <li><span>01</span></li>
                            <li><span>02</span></li>
                            <li class="current"><span>03</span>조회결과</li>
                        </ul>
                    </div>
                </div>

<form id="wForm" alert focus>
                <div id="contents">
                    <div class="title_box">
                        <h4 class="title">고객정보</h4>
                        <div class="floatRight2">( 금액단위 : 천원 )</div>
                    </div>

<!--
                    <div class="tbl_write">
                        <table class="list_tbl03" summary="">
                         -->
                    <div class="tbl_box">
                        <table class="list_tbl02" summary="">
                            <caption>고객정보</caption>
                            <colgroup>
                                <col style="width:16%;" />
                                <col style="width:*;" />
                                <col style="width:16%;" />
                                <col style="width:*;" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th scope="row">성명</th>
                                    <td id="tdUser_name">
                                    </td>
                                    <th scope="row">주민등록번호</th>
                                    <td id="tdUser_idno">
                                        <!-- <input type="text" class="designInput" title="주민등록번호" /> <b>-</b> <input type="text" class="designInput" title="주민등록번호" /> -->
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">휴대폰</th>
                                    <td id="tdMobile_no">
                                    </td>
                                    <th scope="row">필요금액</th>
                                    <td id="tdBefore_want_amt">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">자금용도</th>
                                    <td id="tdFund_use" colspan="3">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">사업수지현황</h4>
                        <div class="floatRight2">( 금액단위 : 만원 )</div>
                    </div>
                    <div class="tbl_box">
                        <table class="list_tbl02" summary="">
                            <caption>사업수지현황</caption>
                            <colgroup>
                                <col style="width:16%;" />
                                <col style="width:*;" />
                                <col style="width:16%;" />
                                <col style="width:*;" />
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th scope="row" >구분</th>
                                    <th scope="row" class="alignCenter">월매출</th>
                                    <th scope="row" class="alignCenter">상품원가</th>
                                    <th scope="row" class="alignCenter">임대료</th>
                                    <th scope="row" class="alignCenter">인건비</th>
                                </tr>
                                <tr>
                                    <th scope="row">금액</th>
                                    <td class="alignCenter" id="tdSale_amt"></td>
                                    <td class="alignCenter" id="tdMerchan_cost"></td>
                                    <td class="alignCenter" id="tdPlace_rent_amt"></td>
                                    <td class="alignCenter" id="tdPerson_cost"></td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">구분</th>
                                    <th scope="row" class="alignCenter">영업이익</th>
                                    <th scope="row" class="alignCenter">부채비용</th>
                                    <th scope="row" class="alignCenter">부가세</th>
                                    <th scope="row" class="alignCenter">가능한도</th>
                                </tr>
                                <tr>
                                    <th scope="row">금액</th>
                                    <td class="alignCenter" id="tdBenifit"></td>
                                    <td class="alignCenter" id="tdMonth_prin_int_amt"></td>
                                    <td class="alignCenter" id="tdSurtax"></td>
                                    <td class="alignCenter" id="tdHando"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">신청정보</h4>
                    </div>
                    <div class="tbl_box">
                        <table class="list_tbl02" summary="">
                            <caption>신청정보</caption>
                            <colgroup>
                                <col style="width:16%;" />
                                <col style="width:*;" />
                                <col style="width:16%;" />
                                <col style="width:*;" />
                            </colgroup>
                            <tbody>
                                <tr><th scope="row">사업장위치         </th><td id="tdCaddr" colspan="4"></td></tr>
                                <tr><th scope="row">사업업력/사업자구분</th><td id="tdOpening_dy" colspan="4"></td></tr>
                                <tr><th scope="row">사업장접근성       </th><td id="tdCompany_appr" colspan="4"></td></tr>
                                <tr><th scope="row">거주현황           </th><td id="tdRegInfo" colspan="4"></td></tr>
                                <tr><th scope="row">차량및재산보유현황 </th><td id="tdCar_own_yn" colspan="4"></td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">심사항목</h4>
                    </div>
                    <div class="tbl_box">
                        <table class="list_tbl02" summary="">
                            <caption>심사항목</caption>
                            <colgroup>
                                <col style="width:5%;" />
                                <col style="width:31%;" />
                                <col style="width:*;" />
                                <col style="width:20%;" />
                                <col style="width:12%;" />
                            </colgroup>
                            <tbody>
                                <tr><th scope="row" class="alignCenter">&nbsp;</th>
                                    <th scope="row" class="alignCenter">항목</th>
                                    <th scope="row" class="alignCenter">내용</th>
                                    <th scope="row" class="alignCenter">기준</th>
                                    <th scope="row" class="alignCenter">해당사항</th>
                                </tr>
                                <tr>
                                    <th scope="row" rowspan="15" style="padding-left:0px;text-align:center">CUF<br/>-<br/>OFF</th>
                                    <th>단독세대</th><td id="tdSim01">부모, 딸, 아들</td><td>가족관계 없을시</td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim01" disabled="disabled"><label for="chkSim01" class="add_text"></label></td>
                                </tr>

                                <tr><th scope="row">보증금 1000만원 미만 월세거주자             </th><td id="tdSim02">&nbsp;</td><td>&nbsp;                </td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim02" disabled="disabled"><label for="checkbox1_3" class="add_text"></label></td></tr>
                                <tr><th scope="row">사업장등록증상 운영자와 실운영자가 다른경우 </th><td id="tdSim03">&nbsp;</td><td>&nbsp;                </td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim03" disabled="disabled"><label for="checkbox1_3" class="add_text"></label></td></tr>
                                <tr><th scope="row">과거신용판단해제이력보유자                  </th><td id="tdSim04">&nbsp;</td><td>&nbsp;                </td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim04" disabled="disabled"><label for="checkbox1_3" class="add_text"></label></td></tr>
                                <tr><th scope="row">최장연체일수                                </th><td id="tdSim05">&nbsp;</td><td>10일1이상연체         </td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim05" disabled="disabled"><label for="checkbox1_3" class="add_text"></label></td></tr>
                                <tr><th scope="row">현금서비스건/금액                           </th><td id="tdSim06">&nbsp;</td><td>3건 or 500만원초과    </td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim06" disabled="disabled"><label for="checkbox1_3" class="add_text"></label></td></tr>
                                <tr><th scope="row">대부업사용건수/금액                         </th><td id="tdSim07">&nbsp;</td><td>유                    </td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim07" disabled="disabled"><label for="checkbox1_3" class="add_text"></label></td></tr>
                                <tr><th scope="row">대출정보건수/금액                           </th><td id="tdSim08">&nbsp;</td><td>5건이상(신용만)       </td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim08" disabled="disabled"><label for="checkbox1_3" class="add_text"></label></td></tr>
                                <tr><th scope="row">최근3개월내 대출건수/금액                   </th><td id="tdSim09">&nbsp;</td><td>3건이상(신용만)       </td><td align="center"><input type="checkbox" class="designCheckbox" id="chkSim09" disabled="disabled"><label for="checkbox1_3" class="add_text"></label></td></tr>
                                <tr><th scope="row">CB등급                                      </th><td id="tdSim10">&nbsp;</td><td colspan="2">&nbsp;                </td></tr>
                                <tr><th scope="row">신용카드보유건수                            </th><td id="tdSim11">&nbsp;</td><td colspan="2">&nbsp;                </td></tr>
                                <tr><th scope="row">보증채무(당행제외)                          </th><td id="tdSim12">&nbsp;</td><td colspan="2">&nbsp;                </td></tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn_wrap">
                        <button type="button" id="btnUpdate"  class="btn btn btn_normal btn_grayline dsNone">수정</button>
                        <button type="submit" id="btnOz" class="btn btn_normal btn_green">전자문서등록</button>
                    </div>
                </div>
</form>

            </div>
        </div>
    </div>

</div> <!-- // layout -->
<%@include file="/inc/footer.jsp" %>