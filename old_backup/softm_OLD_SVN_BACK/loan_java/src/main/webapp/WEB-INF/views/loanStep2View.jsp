<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="사전품의정보입력";
$( document ).ready(function() {
    $( "body" ).on( "keyup", "#wForm [name='ltel_no1']", function() {
        event.preventDefault();
        console.info(event);
        //if( event.code.indexOf("Shift") == -1 && event.code.indexOf("Tab") == -1 && event.code.indexOf("Arrow") && event.code.indexOf("End") == -1 ) {
        if( event.code.indexOf("Digit") > -1 || event.code.indexOf("Numpad") > -1 ) {
	        if ( $(this).val()=="02" && $(this).val().length == 2 ||
	             $(this).val().length >= 3
	        ) {
	        	$(this).form().find("[name='ltel_no2']").focus().select();
	        }
        }
    });
    $( "body" ).on( "keyup", "#wForm [name='ltel_no2']", function() {
        event.preventDefault();
        //if( event.code.indexOf("Shift") == -1 && event.code.indexOf("Tab") == -1 && event.code.indexOf("Arrow") && event.code.indexOf("End") == -1 ) {
        if( event.code.indexOf("Digit") > -1 || event.code.indexOf("Numpad") > -1 ) {
	        if ( $(this).val().length == 4 ) {
	        	$(this).form().find("[name='ltel_no3']").focus().select();
	        }
        }
    });
    $( "body" ).on( "keyup", "#wForm [name='ctel_no1']", function() {
        event.preventDefault();
        console.info(event);
        //if( event.code.indexOf("Shift") == -1 && event.code.indexOf("Tab") == -1 && event.code.indexOf("Arrow") && event.code.indexOf("End") == -1 ) {
        if( event.code.indexOf("Digit") > -1 || event.code.indexOf("Numpad") > -1 ) {
	        if ( $(this).val()=="02" && $(this).val().length == 2 ||
	             $(this).val().length >= 3
	        ) {
	        	$(this).form().find("[name='ctel_no2']").focus().select();
	        }
        }
    });
    $( "body" ).on( "keyup", "#wForm [name='ctel_no2']", function() {
        event.preventDefault();
        //if( event.code.indexOf("Shift") == -1 && event.code.indexOf("Tab") == -1 && event.code.indexOf("Arrow") && event.code.indexOf("End") == -1 ) {
        if( event.code.indexOf("Digit") > -1 || event.code.indexOf("Numpad") > -1 ) {
	        if ( $(this).val().length == 4 ) {
	        	$(this).form().find("[name='ctel_no3']").focus().select();
	        }
        }
    });
    
    $( "body" ).on( "keyup", "#wForm [name='ctax_no1']", function() {
        event.preventDefault();
        console.info(event);
        if( event.code.indexOf("Digit") > -1 || event.code.indexOf("Numpad") > -1 ) {
	        if ( $(this).val().length >= 3 ) {
	        	$(this).form().find("[name='ctax_no2']").focus().select();
	        }
        }
    });

    $( "body" ).on( "keyup", "#wForm [name='ctax_no2']", function() {
        event.preventDefault();
        if( event.code.indexOf("Digit") > -1 || event.code.indexOf("Numpad") > -1 ) {
	        if ( $(this).val().length == 2 ) {
	        	$(this).form().find("[name='ctax_no3']").focus().select();
	        }
        }
    });
    
    // 다음
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        /*
            jQuery.validator.addMethod("testLive", function(value, element, params) {
                alert("testLive");
                 return $("#wForm [name='live']:checked").length==0?false:true;
           }, "가족관계를 선택해주세요.");
        */
        var vRules = {
                rules: {
                   fund_use: {required: true}
                 , living_cd: {required: true}
                 , house_own_cd: {required: true}
                 , house_lease: {required: function() {return $("#wForm [name='house_lease']").val() == HOUSE_OWN_CD_TYPE.OWN?false:true }}
                 , ctax_no1: {required: function() {return $("#wForm [name='ctax_no1']").val() + $("#wForm [name='ctax_no2']").val() +$("#wForm [name='ctax_no3']").val()?true:false}}
                 , ctax_no2: {required: function() {return $("#wForm [name='ctax_no1']").val() + $("#wForm [name='ctax_no2']").val() +$("#wForm [name='ctax_no3']").val()?true:false}}
                 , ctax_no3: {required: function() {return $("#wForm [name='ctax_no1']").val() + $("#wForm [name='ctax_no2']").val() +$("#wForm [name='ctax_no3']").val()?true:false}}
                 , live:{required:true}
                 , month_prin_int_amt:{required:true}
                 , raddr: {required: true}
                 , company_nm: {required: true}
                 , company_type: {required: true}
                 , place_own_cd: {required: true}
                 , opening_dy: {required: true,trim:true}
                 , company_realoper: {required: true}
                 , worker_cnt: {required: true,number:true}
                 , person_cost: {required: true,number:true}
                 , card_sale_amt: {required: true,number:true}
                 , cash_sale_amt: {required: true,number:true}
                 , merchan_rate: {required: true,number:true}
                 , place_guaran_amt: {required: true,number:true}
                 , place_rent_amt: {required: true,number:true}
            }
            ,groups: { // groups all messages into one
                   company_type: 'company_type_1 company_type_2'
               }
            , messages: {
                   "fund_use": "자금용도를 선택해주세요."
                 , "living_cd": "주거형태를 선택해주세요."
                 , "house_own_cd": "주택소유형태를 선택해주세요."
                 , "raddr":"자택주소를 확인하세요."
                 , "live":"가존관계를 확인하세요."
                 , "company_nm": "상호를 확인하세요."
                 , "company_type": "사업자구분을 확인하세요."
                 , "place_own_cd": "사업장소유형태을 확인하세요."
                 , "opening_dy": "현사업업력을 확인하세요."
                 , "company_realoper": "사업장실운영자를 확인하세요."
                 , "company_realoper": "사업장실운영자를 확인하세요."
                 , "worker_cnt": "종업원수를 확인하세요."
                 , "person_cost": "인건비를 확인하세요."
                 , "card_sale_amt": "월평균매출액(카드매출)을 확인하세요."
                 , "cash_sale_amt": "월평균매출액(현금매출)을 확인하세요."
                 , "merchan_cost": "상품원가을 확인하세요."
                 , "place_guaran_amt": "사업장입대차계약내용(보증금)를 확인하세요."
                 , "place_rent_amt": "사업장입대차계약내용(월세금)를 확인하세요."
            }
        };
        
        /* if ( !window.isAuth ) {
            alert("진위여부 확인을 진행해주세요.");
        } else */
        //if ( isValid('#wForm',vRules) ) {
        if ( validate('#wForm',vRules) ) {
            if ( confirm("저장하시겠습니까?") ) {
                showLoading();
                $("#wForm [name='ctax_no']").val($("#wForm [name='ctax_no1']").val() + "-" + $("#wForm [name='ctax_no2']").val() + "-" + $("#wForm [name='ctax_no3']").val()); 
                var d = $("#wForm").serialize();
                exec("/loanStep2Proc.do", d,function(data) {
                      if ( data.RESULT_CD == RESULT_CD.OK ) {
                          goUrl( "/loanStep3View.do"
                                  + "?" + window.kParams.join("&")
                          );
                      } else {
                      }
                });
            }
        }
    });

    // 주거형태
    $( "body" ).on( "change", "#wForm [name='house_own_cd']", function( event ) {
    	// 자가::> 보증금, 자가아님 ::> 시세
        if ( $(this).val() == HOUSE_OWN_CD_TYPE.OWN || $(this).val() == HOUSE_OWN_CD_TYPE.SHARE ) { // 자가 || 공동명의
            //$("#wForm [name='house_lease']").val("").attr("disabled","disabled");
            $("#wForm [name='house_lease']").val("").attr("placeholder","시세");
        } else {
            //$("#wForm [name='house_lease']").removeAttr("disabled");
            $("#wForm [name='house_lease']").attr("placeholder","보증금");
        }
    });
    // 가족관계
    $( "body" ).on( "change", "#wForm [name='live']", function( event ) {
        var idx = $(this).index() / 2;
        //console.info($(this));
        //console.info(idx, $(this).is(":checked"));
        if ( idx == 0 ) { 
        	if ( $(this).is(":checked") ) {
	        	for ( var i=1;i<8;i++) { // 1~7
	        		//$(this).form().find("[name='live']").eq(i).attr("disabled","disabled");
	        		//$(this).form().find("[name='live']").eq(i).removeAttr("checked");
	    			$(this).form().find("[name='live']").eq(i)[0].checked=false;	        		
	        	}
    		}
        } else {
        	if ( $("#wForm [name='live']:checked").length == 0 ) {
	    		$(this).form().find("[name='live']").eq(0)[0].checked=true;
	    		//$(this).form().find("[name='live']").eq(0).removeAttr("disabled");
        	} else {
	    		$(this).form().find("[name='live']").eq(0)[0].checked=false;        		
	    		//$(this).form().find("[name='live']").eq(0).attr("disabled","disabled");
        	}
        }
        $(this).form().find("[name='live_solo'    ]").val($(this).form().find("[name='live']").eq(0).is(":checked")?"Y":"N");
        $(this).form().find("[name='live_dad'     ]").val($(this).form().find("[name='live']").eq(1).is(":checked")?"Y":"N");
        $(this).form().find("[name='live_mom'     ]").val($(this).form().find("[name='live']").eq(2).is(":checked")?"Y":"N");
        $(this).form().find("[name='live_mate'    ]").val($(this).form().find("[name='live']").eq(3).is(":checked")?"Y":"N");
        $(this).form().find("[name='live_child'   ]").val($(this).form().find("[name='live']").eq(4).is(":checked")?"Y":"N");
        $(this).form().find("[name='live_brother' ]").val($(this).form().find("[name='live']").eq(5).is(":checked")?"Y":"N");
        $(this).form().find("[name='live_relation']").val($(this).form().find("[name='live']").eq(6).is(":checked")?"Y":"N");
        $(this).form().find("[name='live_etc'     ]").val($(this).form().find("[name='live']").eq(7).is(":checked")?"Y":"N");
    });

    (function(global){
        window.kParams=[];
        window.kParams.push("loanreq_seq=${param.loanreq_seq}");
        window.kParams.push("pt_cust_no=${param.pt_cust_no}");

        //console.info("global :" , global);
        showLoading();
    /////////
        exec("/loanStep2Info.do", window.kParams.join("&"),function(data) {
              //
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                  //console.info(data);
                  $("#tdMobile_no").text(data.MOBILE_NO1 + "-" + data.MOBILE_NO2 + "-" + data.MOBILE_NO3);
                  //$("#tdUser_idno").text(data.MOBILE_NO1 + "-" + data.MOBILE_NO2 + "-" + data.MOBILE_NO3);
                    // 자금용도, *주택소유형태(보증금) (A02), 사업자구분(A03), 사업장소유형태(Z12), 사업장실운영자(A04)
                    getCodeValueForZC(["A07","A02","A03","Z12","A04"],function(code){
                        createCombo("#wForm [name='fund_use']"    ,code.CODEGRPA07,"", data.FUND_USE);
                        createCombo("#wForm [name='house_own_cd']",code.CODEGRPA02,"", data.HOUSE_OWN_CD);
                        $( "#wForm [name='house_own_cd']").trigger("change");
                        createRadio("#spnCompany_type",code.CODEGRPA03,"company_type", data.COMPANY_TYPE);
                        createRadio("#tdPlace_own_cd",code.CODEGRPZ12,"place_own_cd", data.PLACE_OWN_CD);
                        createRadio("#spnCompany_realoper",code.CODEGRPA04,"company_realoper", data.COMPANY_REALOPER);
                        $( "body" ).on( "change", "#wForm [name='company_realoper']", function( event ) {
							$("#wForm [name='company_realoper_memo']").val("").attr("disabled",$(this).val() == "02"?false:true);
							if ( $(this).val() == "02" ) {
								$("#wForm [name='company_realoper_memo']").focus();
							}
                        });
                    });

                    // 주거형태
                    getCodeValueForZC(["A06"],function(code){
                        createCombo("#wForm [name='living_cd']",code.CODEGRPA06,"", data.LIVING_CD);
                    });
                    var sFamilyCd = [];
                    if ( data.LIVE_SOLO    == "Y") sFamilyCd.push("01");
                    if ( data.LIVE_DAD     == "Y") sFamilyCd.push("02");
                    if ( data.LIVE_MOM     == "Y") sFamilyCd.push("03");
                    if ( data.LIVE_MATE    == "Y") sFamilyCd.push("04");
                    if ( data.LIVE_CHILD   == "Y") sFamilyCd.push("05");
                    if ( data.LIVE_BROTHER == "Y") sFamilyCd.push("06");
                    if ( data.LIVE_RELATION== "Y") sFamilyCd.push("07");
                    if ( data.LIVE_ETC     == "Y") sFamilyCd.push("08");

                    // 가족관계
                    createCheckbox("#tdLive",CODE_FAMILY,"live", sFamilyCd);
                    
                    // 상품원가
                    var merchanRate = parseInt(data.MERCHAN_RATE,10);
                    var saleAmt = Math.trunc(parseInt(data.CARD_SALE_AMT,10) +  parseInt(data.CASH_SALE_AMT,10));
                    $("#wForm [name='merchan_rate']").val(merchanRate);
                    $("#wForm [name='sale_amt']"    ).val(formatNumber(saleAmt));
                    $("#wForm [name='sale_amt2']"   ).val(formatNumber(Math.trunc(merchanRate/100*saleAmt)));
                    
                    $( "body" ).on( "keyup", "#wForm [name='card_sale_amt'], [name='cash_sale_amt'], [name='merchan_rate']", function( event ) {
                        var merchanRate = parseInt($("#wForm [name='merchan_rate']").cleanVal(),10);
                        var saleAmt = Math.trunc(parseInt($("#wForm [name='card_sale_amt']").cleanVal(),10) +  parseInt($("#wForm [name='cash_sale_amt']").cleanVal(),10));
                        //$("#wForm [name='merchan_rate']").val(merchanRate);
                        $("#wForm [name='sale_amt']"    ).val(formatNumber(saleAmt));
                        $("#wForm [name='sale_amt2']"    ).val(formatNumber(Math.trunc(merchanRate/100*saleAmt)));
                    });
                    
                    // 월세납부현황(체납)
                    createRadio("#tdMonthpay_default",CODE_YN_TYPE1,"monthpay_default", data.MONTHPAY_DEFAULT);
                    // 국세및지방세(체납)
                    createRadio("#tdTaxpay_default",CODE_YN_TYPE1,"taxpay_default", data.TAXPAY_DEFAULT);

                    bindJsonToForm(data,"#wForm",{
                        user_name:function(form,v) {
                            $("#tdUser_name").text(v);
                        },
                        user_idno:function(form,v) {
                           form.find("#tdUser_idno").text(v.substring(0,6) + "-" +v.substring(6,13));
                        },
                        fund_use:function(form,v) {
                          // 자금용도
                        },
                        living_cd:function(form,v) {

                        },
                        ctax_no:function(form,v) {
                        	//000 - 00 - 00000
                        	//1234567890
                           //$("#wForm [name='ctax_no']").val(v.substring(0,3) + "-" +v.substring(3,6)+"-"+v.substring(3,6));
                           $("#wForm [name='ctax_no1']").val(v.substring(0,3));
                           $("#wForm [name='ctax_no2']").val(v.substring(3,5));
                           $("#wForm [name='ctax_no3']").val(v.substring(5,10));
                        },
                        opening_dy:function(form,v) {
                           try {
                           	//moment(v,"YYYY.MM.DD").format("YYYY-MM-DD")
                             // $("#wForm [name='opening_dy']").val(moment(v,"YYYYMMDD").format("YYYY-MM"));
                           } catch(e) {
                           }
                        },
                        house_lease:function(form,v) {
                            $(form).find("[name='house_lease']").val(formatNumber(v));
                        },
                        month_prin_int_amt:function(form,v) {
                            $(form).find("[name='month_prin_int_amt']").val(formatNumber(v));
                        },
                        person_cost:function(form,v) {
                            $(form).find("[name='person_cost']").val(formatNumber(v));
                        },
                        worker_cnt:function(form,v) {
                            $(form).find("[name='worker_cnt']").val(formatNumber(v));
                        },
                        card_sale_amt:function(form,v) {
                            $(form).find("[name='card_sale_amt']").val(formatNumber(v));
                        },
                        cash_sale_amt:function(form,v) {
                            $(form).find("[name='cash_sale_amt']").val(formatNumber(v));
                        },
                        place_guaran_amt:function(form,v) {
                            $(form).find("[name='place_guaran_amt']").val(formatNumber(v));
                        },
                        place_rent_amt:function(form,v) {
                            $(form).find("[name='place_rent_amt']").val(formatNumber(v));
                        }
                    });
                    
              } else {
              }
        });

        hideLoading();

        $("#wForm [name='idcard_issue_day']").val(CONST.CURRENT_DATE);
    })(window);
});

function checkNext() {
    if ( $("#scrapIdcardProcForm [name='cert_auth_no']").val()
      //&& $("#chkTerms").is(":checked")
    ) {
        $("#btnNext").removeAttr("disabled");
    } else {
        $("#btnNext").attr("disabled","disabled");
    }
}
</script>
<body>
<form id="scrapIdcardProcForm">
    <input type="text" name="user_idno"          class="hidden"/>
    <input type="text" name="idcard_verify"      class="hidden"/>
    <input type="text" name="idcard_issue_day"   class="hidden"/>
    <input type="text" name="idcard_license_num" class="hidden"/>
</form>

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
                            <li class="current"><span>02</span>사전품의정보입력</li>
                            <li><span>03</span></li>
                        </ul>
                    </div>
                </div>
<form id="wForm" alert focus>
<input type="text" name="loanreq_seq"          class="hidden" value="${param.loanreq_seq}"/>
<input type="text" name="pt_cust_no"          class="hidden" value="${param.pt_cust_no}"/>
<input type="text" name="ctax_no"          class="hidden" value=""/>
                <div id="contents">
                    <div class="title_box">
                        <h4 class="title">사전품의정보입력</h4>
                    </div>
                    <div class="tbl_write">
                        <table class="list_tbl03" summary="">
                            <caption>개인정보입력</caption>
                            <colgroup>
                                <col style="width:170px;" />
                                <col style="width:*;" />
                            </colgroup>

                            <tbody>
                                <tr>
                                    <th scope="row">성명</th>
                                    <td id="tdUser_name">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">주민등록번호</th>
                                    <td id="tdUser_idno">
                                        <!-- <input type="text" class="designInput" title="주민등록번호" /> <b>-</b> <input type="text" class="designInput" title="주민등록번호" /> -->
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">휴대폰</th>
                                    <td id="tdMobile_no">
<!--                                        <select class="designSelect minwidth100" title="통신사">
                                            <option value="SKT">SKT</option>
                                            <option value="KT">KT</option>
                                            <option value="LG">LG</option>
                                        </select>
                                        <select class="designSelect minwidth100" title="국번">
                                            <option value="010">010</option>
                                            <option value="2">011</option>
                                            <option value="3">016</option>
                                            <option value="3">017</option>
                                            <option value="3">018</option>
                                        </select>
                                        <input type="text" class="designInput width100" title="번호1" />
                                        <input type="text" class="designInput width100" title="번호2" />
                                        <button type="button" class="btn btn_middle btn_blueline">인증번호발송</button> -->
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">자금용도</th>
                                    <td>
        <select name="fund_use" class="designSelect minwidth100">
        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">대출구분</th>
                                    <td>신규</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="title_box">
                        <h4 class="title">고객정보</h4>
                    </div>
                    <div class="tbl_write">
                        <table class="list_tbl03" summary="">
                            <caption>고객정보</caption>
                            <colgroup>
                                <col style="width:170px;" />
                                <col style="width:*;" />
                            </colgroup>

                            <tbody>
                                <tr>
                                    <th scope="row">연락처(자택)</th>
                                    <td>
                            <input type="text" class="designInput width100 numeric" title="번호1" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ltel_no1" size="3" value="02" maxlength="4">
                            <input type="text" class="designInput width100 numeric" title="번호2" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ltel_no2" size="3" value="2682" maxlength="4">
                            <input type="text" class="designInput width100 numeric" title="번호3" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ltel_no3" size="3" value="7211" maxlength="4">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">자택주소</th>
                                    <td>
                                        <input type="text" class="designInput width100per" name="raddr" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">주거형태</th>
                                    <td>
        <select name="living_cd" class="designSelect minwidth100">
        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">주택소유형태(보증금)</th>
                                    <td>
        <select name="house_own_cd" class="designSelect minwidth100">
        </select>
        <input type="text" min="0" style="text-align: right;" class="designInput amount" title="보증금" placeholder="보증금" name="house_lease" > 만원
                                    </td>
                                </tr>
    <input type="text" name="live_solo"     class="hidden"/>
    <input type="text" name="live_dad"      class="hidden"/>
    <input type="text" name="live_mom"      class="hidden"/>
    <input type="text" name="live_mate"     class="hidden"/>
    <input type="text" name="live_child"    class="hidden"/>
    <input type="text" name="live_brother"  class="hidden"/>
    <input type="text" name="live_relation" class="hidden"/>
    <input type="text" name="live_etc"      class="hidden"/>

                                <tr>
                                    <th scope="row">가족관계</th>
                                    <td id="tdLive">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">월.대출금불입금액</th>
                                    <td>
<input type="text" min="0" class="designInput amount" style="text-align: right;" title="월.대출금불입금액" placeholder="월.대출금불입금액" name="month_prin_int_amt" > 만원
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">차량보유현황</th>
                                    <td id="tdCar_own_yn">
                                        <input type="radio" class="designRadiobutton" id="car_own_yn_1" name="car_own_yn" value="Y">
                                        <label for="car_own_yn_1" class="add_text">보유</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" class="designRadiobutton" id="car_own_yn_2" name="car_own_yn" value="N">
                                        <label for="car_own_yn_2" class="add_text">미보유</label>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>


                    <div class="title_box">
                        <h4 class="title">사업장정보</h4>
                    </div>
                    <div class="tbl_write">
                        <table class="list_tbl03" summary="">
                            <caption>사업장정보</caption>
                            <colgroup>
                                <col style="width:170px;" />
                                <col style="width:*;" />
                            </colgroup>

                            <tbody>
                                <tr>
                                    <th scope="row">상호명/사업자구분</th>
                                    <td>
                                        <input type="text" class="designInput" name="company_nm" value=""/>
                                        <span id="spnCompany_type"></span>

<label for="company_type" class="error" style="display:none;">Please choose one.</label>

                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">사업장소유형태</th>
                                    <td id="tdPlace_own_cd">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">사업자등록번호</th>
                                    <td>
                            <input type="text" class="designInput numeric" style="width:50px" title="번호1" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ctax_no1" size="3" value="" maxlength="3">-
                            <input type="text" class="designInput numeric" style="width:20px" title="번호2" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ctax_no2" size="2" value="" maxlength="2">-
                            <input type="text" class="designInput numeric" style="width:60px" title="번호3" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ctax_no3" size="5" value="" maxlength="5">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">사업장연락처</th>
                                    <td>
                            <input type="text" class="designInput width100 numeric" title="번호1" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ctel_no1" size="3" value="02" maxlength="4">
                            <input type="text" class="designInput width100 numeric" title="번호2" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ctel_no2" size="3" value="2682" maxlength="4">
                            <input type="text" class="designInput width100 numeric" title="번호3" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="ctel_no3" size="3" value="7211" maxlength="4">
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">사업장주소</th>
                                    <td>
                                        <input type="text" class="designInput width100per" name="caddr" value=""/>
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">현사업업력</th>
                                    <td>
                                        <input type="text" class="designInput" title="사업시작일"  name="opening_dy"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">사업장실운영자</th>
                                    <td>
                                    <span id="spnCompany_realoper">
                                    </span>
                                     <input type="text" class="designInput width50per" name="company_realoper_memo" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">사업장 접근성</th>
                                    <td>
                                        <textarea class="designTextarea" name="company_appr" maxlength="500"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="title_box">
                        <h4 class="title">사업수지현황</h4>
                    </div>
                    <div class="tbl_write">
                        <table class="list_tbl03" summary="">
                            <caption>사업수지현황</caption>
                            <colgroup>
                                <col style="width:170px;" />
                                <col style="width:*;" />
                            </colgroup>

                            <tbody>
                                <tr>
                                    <th scope="row">인건비(종업원수)</th>
                                    <td>
                            <input type="text" class="designInput width100 amount" title="인건비"   min="0" inputmode="numeric" name="person_cost" maxlength="10"> 만원&nbsp;&nbsp;&nbsp;
                            <input type="text" class="designInput width100 amount" title="종업원수" min="0" inputmode="numeric" name="worker_cnt"  maxlength="10"> 명
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">월평균매출액(카드매출/현금매출)</th>
                                    <td>
                            <input type="text" class="designInput width100 amount" title="카드매출" min="0" inputmode="numeric" name="card_sale_amt" maxlength="10"> 만원
                            <input type="text" class="designInput width100 amount" title="현금매출" min="0" inputmode="numeric" name="cash_sale_amt" maxlength="10"> 만원
                            <input type="text" class="designInput width100 amount" title="합산"     min="0" inputmode="numeric" name="sale_amt" maxlength="10" readonly> 만원
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">상품원가</th>
                                    <td>
                            <input type="text" class="designInput width100 amount" title="상품원가" min="0" inputmode="numeric" name="merchan_rate" maxlength="3"> %&nbsp;&nbsp;&nbsp;
                            <input type="text" class="designInput width100 amount" min="0" pattern="[0-9]*" inputmode="numeric" name="sale_amt2" maxlength="10" readonly onfocus="this.blur()"> 만원
                                   </td>
                                </tr>
                                <tr>
                                    <th scope="row">사업장입대차계약내용(보증금/월세금)</th>
                                    <td>
                            <input type="text" class="designInput width100 amount" title="보증금"  min="0" inputmode="numeric" name="place_guaran_amt" maxlength="10"> 만원
                            <input type="text" class="designInput width100 amount" title="월세금" min="0" inputmode="numeric" name="place_rent_amt" maxlength="10"> 만원
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">월세납부현황(체납) </th>
                                    <td id="tdMonthpay_default">
                                    </td>
                                </tr>

                                <tr>
                                    <th scope="row">국세및지방세(체납) </th>
                                    <td id="tdTaxpay_default">
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="btn_wrap">
<!--                         <button type="button" id="btnCancel" class="btn btn_normal btn_grayline">취소</button>
 -->                        <button type="submit" id="btnNext" class="btn btn_normal btn_green">다음</button>
                    <div>

                </div>
</form>

            </div>
        </div>
    </div>

</div> <!-- // layout -->
<%@include file="/inc/footer.jsp" %>