<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="약정내역결과";
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
        exec("/loanagreeInfo.do", window.kParams.join("&"),function(data) {
	              if ( data.RESULT_CD == RESULT_CD.OK ) {
	          	    if ( data.CODE_VAL2 == "S" ) {
	          	    	if ( data.LOAN_STATE_CD < 65 ) {
	                    	$("#btnOzDoc").removeClass("dsNone"); // 전자약정      			
	          	    	} else if ( data.LOAN_STATE_CD == 65 || data.LOAN_STATE_CD == 66 || data.LOAN_STATE_CD == 67 ) { // data.LOAN_STATE_CD >= 65
		                    $("#btnOzPic").removeClass("dsNone"); // 원본파일촬영
		          	    }
	          	     }
            	  //console.info(data);
                  $("#tdUser_name").text(data.USER_NAME);
                  $("#tdUser_idno").text(data.USER_IDNO.substring(0,6) + "-" +data.USER_IDNO.substring(6,13));
                  $("#tdMobile_no").text(data.MOBILE_NO1 + "-" + data.MOBILE_NO2 + "-" + data.MOBILE_NO3);
                  $("#tdGoods").text(data.GOODS);
//                   자택주소		"RPOST_CD || RADDR1 || RADDR2
//                   N_HZIP || N_HADDR1 || N_HADDR2"                  
                  $("#tdRaddr").html(data.RPOST_CD.substring(0,3) + "-" + data.RPOST_CD.substring(3,6) + " " + data.RADDR1 + " " + data.RADDR2 + "<BR/>"
                		           + data.N_HZIP + " " + data.N_HADDR1 + " " + data.N_HADDR2                		  
                		            );
//                   실거주지주소		"LPOST_CD || LADDR1 || LADDR2
//                   N_RZIP || N_RADDR1 || N_RADDR2"
                  $("#tdLaddr").html(data.LPOST_CD.substring(0,3) + "-" + data.LPOST_CD.substring(3,6) + " " + data.LADDR1 + " " + data.LADDR2 + "<BR/>"
       		           + data.N_RZIP + " " + data.N_RADDR1 + " " + data.N_RADDR2
       		        
       		            );
                    window.list10Seq=0;
					$( "#LIST_PSLOANTemplate" ).tmpl( data.LIST_PSLOAN ).appendTo( "#LIST_PSLOAN .list" );
					
              } else {
              }
        });
        
	    $( "body" ).on( "click", "#btnOzDoc", function() { // openOZ 전자약정
            event.preventDefault();
	        openOZ("SignDoc",window.kParams.join("&"));	        
	    });
        
	    $( "body" ).on( "click", "#btnOzPic", function() { // openOZ 원본파일촬영
            event.preventDefault();
	        openOZ("SignPic",window.kParams.join("&"));	        
	    });
        //hideLoading();

    })(window);
});

</script>
<script id="LIST_PSLOANTemplate" type="text/x-jquery-tmpl">
    <tr>
        <th scope="row">대출금액</th>
        <td>금 \${formatNumber(PSLOAN_AMT)}원
        </td>
        <th scope="row">결재일</th>
        <td>\${formatDate(PSINTER_PAY_DATE)}</td>
    	<td class="invisible"></td>
    </tr>

    <tr style="padding-bottom:10px">
        <th scope="row">자금용도</th>
        <td>\${PSLOAN_TYPE_NM}</td>
        <th scope="row">기간(월/일)</th>
        <td>\${PSLOAN_PERIOD}
{{if PSLOAN_REPAY_CD=='CDR' }}
일
{{else}}
월
{{/if}}
        </td>
    	<td class="invisible"></td>
    </tr>
    <tr style="padding-bottom:10px">
        <th scope="row">상환구분</th>
        <td>\${PSLOAN_REPAY_NM}</td>
        <th scope="row">이율</th>
        <td>\${PSLOAN_RT} %
        </td>
    	<td class="invisible"></td>
    </tr>

    <tr>
	    <td colspan="5" style="height:10px"></td>
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
                    <h3 class="title">약정내역결과</h3>
<!--                     <div class="step_wrap">
                        <ul class="step">
                            <li class="current"><span>01</span>약정내역결과</li>
                            <li><span>02</span></li>
                            <li><span>03</span></li>
                            <li><span>04</span></li>
                        </ul>
                    </div> -->
                </div>

<form id="wForm" alert focus>
                <div id="contents">
                    <div class="title_box">
                        <h4 class="title">신청인정보</h4>
                    </div>
<!--
                    <div class="tbl_write">
                        <table class="list_tbl03" summary="">
                         -->
                    <div class="tbl_box">
                        <table class="list_tbl02" summary="">
                            <caption>신청인정보</caption>
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
                                    <th scope="row">연락처</th>
                                    <td id="tdMobile_no">
                                    </td>
                                    <th scope="row">대출상품</th>
                                    <td id="tdGoods">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">자택주소</th>
                                    <td id="tdRaddr" colspan="3">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">실거주지주소</th>
                                    <td id="tdLaddr" colspan="3">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="title_box">
                        <h4 class="title">대출약정정보</h4>
                    </div>
                    <div class="tbl_box">
						<table id="LIST_PSLOAN" class="list_tbl02" summary="">
							<caption>신정원 대부업고유 채무불이행 정보</caption>
							<colgroup>
								<col style="width:20%;" />
								<col style="width:25%;" />
								<col style="width:20%;" />
								<col style="width:25%;" />
								<col style="width:*;" />
							</colgroup>
							<tbody class="list">
							</tbody>
						</table>
                    </div>
                    <div class="btn_wrap">
                        <button type="button" id="btnOzDoc"  class="btn btn_normal btn_green dsNone">전자약정</button>
                        <button type="submit" id="btnOzPic" class="btn btn_normal btn_green dsNone">원본파일촬영</button>
                    <div>
                </div>
</form>

            </div>
        </div>
    </div>

</div> <!-- // layout -->
<%@include file="/inc/footer.jsp" %>