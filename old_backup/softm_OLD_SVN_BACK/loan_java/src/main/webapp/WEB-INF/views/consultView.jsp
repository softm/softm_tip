<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib prefix="c"    uri="http://java.sun.com/jsp/jstl/core" %>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script src="/xk/js/xkeypad_config.js"></script>
<script src="/xk/js/xkeypad_mobile.js"></script>

<script>
document.title="고객상담";
$( document ).ready(function() {
	var gXKModuleArray = new Array(2);
	
	// XK 입력필드 2개 설정
	gXKModuleArray[0] = new XKModule();
	gXKModuleArray[1] = new XKModule();
	
	// 입력완료 or 닫기 동작 완료시 호출되는 callback 함수
// 	function closeCallback0(result) {
// 		// result
// 		//		닫기	 : XK_CLOSE
// 		//		입력완료 : XK_ENTER
// 		console.log(result);

// 		//alert("result === " + result);

// 		if(result == "XK_ENTER") {
// 			//alert("AA___login Go!");
// 		} else if(result == "XK_CLOSE") {
// 			//alert("AA___XK_CLOSE");
// 		} else {
// 			//alert("AA___xxxx");
// 		}
// 	}
	
// 	function closeCallback1(result) {
// 		// result
// 		//		닫기	 : XK_CLOSE
// 		//		입력완료 : XK_ENTER
// 		console.log(result);

// 		//alert("result === " + result);

// 		if(result == "XK_ENTER") {
// 			//alert("BB___login Go!");
// 		} else if(result == "XK_CLOSE") {
// 			//alert("BB___XK_CLOSE");
// 		} else {
// 			//alert("BB___xxxx");
// 		}
// 	}
	// 인풋 클릭 시 XK 키패드 실행
	//function viewKeypad(aXKModule, aEditBox) {
	//function viewKeypad(aXKModule, aEditBox, aMaxInput) {	// 20170306 : hsecure
	// 1. aEditBox  : 인풋 태그
	// 2. aIndx     : XK 객체 인덱스
	// 3. aMaxInput : XK Maxlength 
	window.viewKeypad= function (aEditBox, aIndex, aMaxInput) {	// 20170306 : hsecure
		//
		var form = document.wForm;
		
		// 키패드 영역 Div Id로 사용되는 String
		var aName = "xk-pad" + aIndex; 
		var aRet = 0;
		var aKeyType = "number";
	
		// 키패트 타입 (문자열 / 숫자) 반환
// 		for(var i=0; i < form.keyPadTypeSelect.length; i++) {
// 			if(form.keyPadTypeSelect[i].checked == true) {
// 				aKeyType = form.keyPadTypeSelect[i].value;
// 			}
// 		}
		
		//alert("g_XKBasePath == " + g_XKBasePath);
	
// 		<input type="radio" name="keyPadTypeSelect" value="qwertysmart" checked>Qwertysmart</input>
// 		<input type="radio" name="keyPadTypeSelect" value="number">Number</input>
		
		// 키패드를 생성하는 함수 initialize (retrun : -1(지원하지 않는 기기), -2(다른 키패드가 실행 중)
		//aRet = aXKModule.initialize(aName, aEditBox, aKeyType);
		//aRet = aXKModule.initialize(aName, aEditBox, aKeyType, aMaxInput);	// 20170306 : hsecure
		aRet = gXKModuleArray[aIndex].initialize(aName, aEditBox, aKeyType, 20);	// 20170306 : hsecure
		
		// 입력완료 or 닫기 동작 완료시 호출되는 callback 함수 설정.
		//var aFunction = (new Function("return " + "closeCallback"+aIndex))();
		//aFunction (aResult);
		
		//aXKModule.setCloseCallback(closeCallback);			// 20170306 : hsecure
		//alert("closeCallback"+aIndex);
		//gXKModuleArray[aIndex].setCloseCallback(eval("closeCallback"+aIndex));	// 20170306 : hsecure
		//gXKModuleArray[aIndex].setCloseCallback(eval(aFunction));	// 20170306 : hsecure
	
		//alert(aRet);
		
		if(aRet == -1) {
			alert("지원하지 않는 기기 입니다.");
		}
	
		//else if(aRet == -2)
		//	alert("이미 키패드가 실행 중입니다.");
	}
		
	/*
	*/
    $( "body" ).on( "click", "[name='user_idno2']", function() {
    	//viewKeypad(this, 0, 4);
    	viewKeypad($(this)[0], 0, 7);
    });
			
    $( "body" ).on( "click", "[name='idcard_license_num']", function() {
    	viewKeypad(this, 1);
    });
			
	$( "body" ).on( "keyup", "#wForm [name='user_idno1']", function() {
        event.preventDefault();
        console.info("jumin",event);        
        if( event.code.indexOf("Shift") == -1 && event.code.indexOf("Tab") == -1 && event.code.indexOf("Arrow") ) {
	        if ( $(this).val().length == 6 ) {
	        	$(this).form().find("[name='user_idno2']").focus().select();
	        }
        }
    });    
	
    $( "body" ).on( "change", "#wForm [name='mobile_no1']", function() {
        event.preventDefault();
        $(this).form().find("[name='mobile_no2']").focus().select();
    });

    $( "body" ).on( "keyup", "#wForm [name='mobile_no2']", function() {
        event.preventDefault();
        //if( event.code.indexOf("Shift") == -1 && event.code.indexOf("Tab") == -1 && event.code.indexOf("Arrow") && event.code.indexOf("End") == -1 ) {
        if( event.code.indexOf("Digit") > -1 || event.code.indexOf("Numpad") > -1 ) {
	        if ( $(this).val().length == 4 ) {
	        	$(this).form().find("[name='mobile_no3']").focus().select();
	        }
        }
    });
	
	// 인증요청	
    $( "body" ).on( "click", "#btnSend", function() {
      //if ( !isValid('#wForm',vRules1) ) {
        if ( !isValidBasic() ) {
            return false;
        }
        showLoading();
        $("#certMobileProc01Form [name='register_no']").val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val()); // 주민번호
        $("#certMobileProc01Form [name='cert_user_name']").val($("#wForm [name='user_name']").val()); // 휴대폰_통신사

        $("#certMobileProc01Form [name='cert_hp_com']").val($("#wForm [name='mobile_agency_cd']").val()); // 휴대폰_통신사
        $("#certMobileProc01Form [name='cert_hp_no1']").val($("#wForm [name='mobile_no1']"      ).val()); // 휴대폰_연락처1
        $("#certMobileProc01Form [name='cert_hp_no2']").val($("#wForm [name='mobile_no2']"      ).val()); // 휴대폰_연락처2
        $("#certMobileProc01Form [name='cert_hp_no3']").val($("#wForm [name='mobile_no3']"      ).val()); // 휴대폰_연락처3

        var d = $("#certMobileProc01Form").serialize();
        exec("/certMobileProc01.do", d,function(data) {

            if ( data.RESULT_CD == RESULT_CD.OK ) {
                //alert("인증번호가 발송되었습니다.");
                $("#certMobileProc02Form [name='register_no']").val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val()); // 주민번호
                $("#certMobileProc02Form [name='cert_user_name']").val($("#wForm [name='user_name']").val()); // 휴대폰_통신사
                $("#certMobileProc02Form [name='service_cd']").val($("#wForm [name='service_cd']").val()); // 휴대폰_통신사
                //$("#certMobileProc02Form [name='cert_loanreq_seq']").val(data.CERT_LOANREQ_SEQ); // 인증일련번호
                $("#certMobileProc02Form [name='cert_auth_result']").val(data.CERT_AUTH_RESULT); // 인증결과
                $("#certMobileProc02Form [name='cert_auth_no']"    ).val(data.CERT_AUTH_NO    ); // 인증고유번호
              } else {
                $("#certMobileProc02Form [name='register_no']"     ).val(""); // 주민번호
                $("#certMobileProc02Form [name='cert_user_name']"  ).val(""); // 휴대폰_통신사
                //$("#certMobileProc02Form [name='cert_loanreq_seq']").val(""); // 인증일련번호
                $("#certMobileProc02Form [name='cert_auth_result']").val(""); // 인증결과
                $("#certMobileProc02Form [name='cert_auth_no']"    ).val(""); // 인증고유번호
              }
        });
    });

	// 미인증처리
    $( "body" ).on( "click", "#btnNotAuth", function() {
        event.preventDefault();
        if ( !isValidBasic() ) {        
            return false;
        }        
        window.isAuth = false;
        showLoading();
        $("#wForm [name='loan_state_cd']").val(LOAN_STATE_CD.NEXT_AUTH); // 후선인증요청
        $("#wForm [name='user_idno']").val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val()); //
        var d = $("#wForm").serialize();
        exec("/consultProc.do", d,function(data) {
            if ( data.RESULT_CD == RESULT_CD.OK ) {
                goUrl( "/loanListView.do?lnbSeq=4"
				);
//                 goUrl( "/consultResultView.do"
//                         + "?loanreq_seq=" + loanreqSeq
// 				);
            } else {
            }
            checkNext();
        });
    });
    
	// 인증확인
    $( "body" ).on( "click", "#btnConfirm", function() {
        if ( !$("#certMobileProc02Form [name='cert_auth_no']").val() ) {
            alert("인증요청을 진행해주세요.");
            return;
        }

        if ( !$("#wForm [name='cert_auth_key']").val() ) {
            alert("SMS인증번호를 확인하세요.");
            $("#wForm [name='cert_auth_key']").focus();
            return;
        }

        showLoading();
        window.isAuth = false;
        // SMS인증번호
        $("#certMobileProc02Form [name='register_no']"     ).val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val()); // 주민번호
        $("#certMobileProc02Form [name='cert_user_name']"  ).val($("#wForm [name='user_name']"       ).val()); // 인증고객명
        $("#certMobileProc02Form [name='cert_hp_com']"     ).val($("#wForm [name='mobile_agency_cd']").val()); // 휴대폰_통신사
        $("#certMobileProc02Form [name='cert_hp_no1']"     ).val($("#wForm [name='mobile_no1']"      ).val()); // 휴대폰_연락처1
        $("#certMobileProc02Form [name='cert_hp_no2']"     ).val($("#wForm [name='mobile_no2']"      ).val()); // 휴대폰_연락처2
        $("#certMobileProc02Form [name='cert_hp_no3']"     ).val($("#wForm [name='mobile_no3']"      ).val()); // 휴대폰_연락처3
        $("#certMobileProc02Form [name='member_no']"       ).val($("#wForm [name='member_no']"       ).val()); // 사번
        $("#certMobileProc02Form [name='cert_auth_key']"   ).val($("#wForm [name='cert_auth_key']"   ).val()); // SMS 인증번호

        var d = $("#certMobileProc02Form").serialize();
        exec("/certMobileProc02.do", d,function(data) {
            $("#wForm [name='info_auth_way']" ).val('05'); //
            $("#wForm [name='info_auth']"     ).val('00'); //
            $("#scrapIdcardProcForm [name='user_name']").val(data.USER_NAME);
            $("#scrapIdcardProcForm [name='user_idno']").val(data.REGISTER_NO);
            $("#scrapIdcardProcForm [name='user_idno']").val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val()); //            
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                  //alert("인증확인됨.");
                  window.isAuth = true;
                  $("#btnLogin").removeAttr("disabled");
                //$("#wForm [name='user_name']").focus();
                  $( "[name='trReally']" ).fadeOut().fadeIn(function() {
                  	//$("#wForm [name='idcard_issue_day']").focus();
                  });
              } else {
              }
        });
        checkNext();
    });

	// 진위요청
    $( "body" ).on( "click", "#btnReq", function() {
    	if ( !window.isAuth ) {
    		alert("인증확인을 해주세요.");
    		return;
    	}
	     /*
	        jQuery.validator.addMethod("testValid", function(value, element, params) {
	              return false;
	        }, "테스트 검사했습니다.");
	     */
	     var vRules = {
	             rules: {
	                idcard_issue_day: {required: true,dpDate: true}
	              , idcard_license_num: {required: function(element){
	                  return $("#wForm [name='idcard_verify'][value='" + SCRA_ID_CARD_TYPE.DRIVE + "']").is(":checked");
	                }
	                //,testValid:true
	              }
	         }
	         , messages: {
	               "idcard_issue_day": "발급일자를 확인하세요."
	              ,"idcard_license_num":"면허번호를 확인하세요."
	         }
	     };
	
	  //if ( isValid('#wForm',vRules1) ) {
	 	if ( validate('#wForm',vRules) ) {
            showLoading();
            $("#scrapIdcardProcForm [name='idcard_verify']"     ).val($("#wForm [name='idcard_verify']:checked").val()); // 신분증진위확인구분
            $("#scrapIdcardProcForm [name='idcard_issue_day']"  ).val($("#wForm [name='idcard_issue_day']").val()     ); // 발급일자
            $("#scrapIdcardProcForm [name='idcard_license_num']").val($("#wForm [name='idcard_license_num']").val()   ); // 면허번호
            
            $("#scrapIdcardProcForm [name='user_name']").val($("#wForm [name='user_name']").val());
            $("#scrapIdcardProcForm [name='user_idno']").val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val());
            
            var d = $("#scrapIdcardProcForm").serialize();
            exec("/scrapIdcardProc.do", d,function(data) {
                  if ( data.RESULT_CD == RESULT_CD.OK ) {
                      $("#wForm [name='idcard_verify_result']").val(data.IDCARD_VERIFY_RESULT);
                      $("#wForm [name='idcard_verify_dt']").focus(data.IDCARD_VERIFY_DT);
                  } else {
                  }
            });
    	}
    });
	
    $( "body" ).on( "change", "#chkTerms", function() {
        checkNext();
    });

    $( "body" ).on( "click", "#btnTerms", function() {
        if ( $("#vwTerms textarea").attr("rows") == "1" ) {
            $("#vwTerms textarea").attr("rows","10");
        } else {
            $("#vwTerms textarea").attr("rows","1");
        }
    });

    // 다음
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        if ( !window.isAuth ) {
            alert("인증을 진행해주세요.");
            return false;
        }
        if ( !isValidBasic() ) {        
            return false;
        }

        if ( !$("#wForm [name='fund_use']").val() ) {
            alert("자금용도를 확인하세요.");
            $("#wForm [name='fund_use']").focus();
            return false;
        } else if ( !$("#wForm [name='before_want_amt']").val() ) {
            alert("필요자금을 확인하세요.");
            $("#wForm [name='before_want_amt']").focus();
            return false;
       }
       if ( $("[name='chkTerms1']:checked").val() != "Y" ) {
       //if ( !$("#chkTerms").is(":checked") ) {
            alert("동의서내용에 동의해야합니다.");
            $("#chkTerms").focus();
            return false;
       }
        showLoading();
        $("#wForm [name='user_idno']").val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val()); //
        
		var info1 = gXKModuleArray[0].get_sessionInfo();
        $("#wForm [name='xksessionid1']").val(info1.sessionId); // XK 세션ID         
        $("#wForm [name='xkindexed1']").val(info1.input); // XK 사용자 입력 인덱스 값 
        $("#wForm [name='xksectoken1']").val(info1.secToken); // XK 세션Token      
    
        var d = $("#wForm").serialize();
        exec("/consultProc.do", d,function(data) {
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                  goUrl( "/consultResultView.do"
                                                 + "?loanreq_seq=" + data.LOANREQ_SEQ
                                                 + "&pt_cust_no="  + data.PT_CUST_NO
                  );
              } else {
              }
        });
    });

    $( "body" ).on( "click", "#btnCancel", function() {
        event.preventDefault();
        showLoading();
        //TODO SOFTM NOT DEFINE
      //$("#statProcForm [name='notdefined']").val($("#wForm [name='mobile_agency_cd']").val());
        history.go(-1);
        hideLoading();
    });
    
    (function(global){
        //console.info("global :" , global);
        showLoading();
        // 통신사
        getCodeValue(["48"],function(code){
            createCombo("#wForm [name='mobile_agency_cd']",code.CODEGRP48,"-선택-", "1");
            //createCombo("#wForm [name='mobile_agency_cd']",code.CODEGRP48,"-선택-", "SKT");
        });

        // 자금용도
        getCodeValueForZC(["A07"],function(codeZC){
            createCombo("#wForm [name='fund_use']",codeZC.CODEGRPA07,"-선택-");
        });
        
     	// 유입경로
        getCodeValueForZC(["A10"],function(codeZC){
            createCombo("#wForm [name='receive_cd']",codeZC.CODEGRPA10,"-선택-");
        });

        // 신분증진위확인
        getCodeValueForZC(["A01"],function(codeZC){
            createRadio("#wForm #check_confirm",codeZC.CODEGRPA01,"idcard_verify","01");
        });

        var params=[];
        exec("/consultInfo.do", params.join("&"),function(data) {
              //
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                $("#certMobileProc01Form [name='cert_loanreq_seq']"
                + ", #certMobileProc02Form [name='cert_loanreq_seq']"
                + ", #wForm [name='cert_loanreq_seq']"
                + ", #wForm [name='loanreq_seq']"
                + ", #statProcForm [name='loanreq_seq']"
                ).val(data.LOANREQ_SEQ); // 신청번호
                window.loanreqSeq = data.LOANREQ_SEQ;
              } else {
              }
        });
        hideLoading();
        
    	// TODO SOFTM 삭제
    	if ( DEBUG ) {
            $("#wForm [name='mobile_no2'      ]").val("9071"); //
            $("#wForm [name='mobile_no3'      ]").val("7218"); //
            $("#wForm [name='cert_auth_key'   ]").val("1234560"); //
            
            $("#wForm [name='user_name'   ]").val("김지훈"); //
            $("#wForm [name='user_idno1'   ]").val("711012"); //
            $("#wForm [name='user_idno2'   ]").val("1234570"); //
    	}
    	
    })(window);
});

function isValidBasic() {
    /*
    jQuery.validator.addMethod("juminValid", function(value, element, params) {
          return juminCheck( $("#wForm [name='user_idno1']").val(),  $("#wForm [name='user_idno2']").val());
          //return false;
    }, "주민번호를 확인하세요.");
     */
    var vRules1 = {
            rules: {
               user_name: {required: true}
             , mobile_agency_cd: {required: true}
             , mobile_no1: {required: true}
             , mobile_no2: {required: true}
             , mobile_no3: {required: true}
             , user_idno1: {required:true, number:true } // $("#wForm [name='user_idno1']").focus();
             , user_idno2: {required:true, number:true } // $("#wForm [name='user_idno1']").focus();
        }
        , messages: {
                "user_name": "이름을 확인하세요."
               ,"mobile_agency_cd": "통신사를 확인하세요."
               ,"mobile_no1": "휴대폰번호를 확인하세요."
               ,"mobile_no2": "휴대폰번호를 확인하세요."
               ,"mobile_no3": "휴대폰번호를 확인하세요."
               ,"mobile_agency_cd": "통신사를 확인하세요."
        }
    };
    if ( !juminCheck( $("#wForm [name='user_idno1']").val(),  $("#wForm [name='user_idno2']").val()) ) {
    	alert("주민번호가 올바르지 않습니다.");
    	return false;
    }
    return validate('#wForm',vRules1);
}

function checkNext() {
    if ( $("#certMobileProc02Form [name='cert_auth_no']").val()
      //&& $("#chkTerms").is(":checked")
    ) {
        $("#btnNext").removeAttr("disabled");
    } else {
        $("#btnNext").attr("disabled","disabled");
    }
}

function juminCheck(jumin1, jumin2){
      check = false;
      total = 0;
      temp = new Array(13);

      for(i=1; i<=6; i++)
      temp[i] = jumin1.charAt(i-1);
      for(i=7; i<=13; i++)
      temp[i] = jumin2.charAt(i-7);

      for(i=1; i<=12; i++){
        k = i + 1;
        if(k >= 10)
         k = k % 10 + 2;
        total = total + temp[i] * k;
      }
      mm = temp[3] + temp[4];
      dd = temp[5] + temp[6];

      totalmod = total % 11;
      chd = 11 - totalmod;
      if(chd == temp[13] && mm < 13 && dd < 32 && (temp[7]==1 || temp[7]==2))
        check=true;
       return check;
}
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

<form id="certMobileProc01Form">
    <input type="text" name="cert_type_info" value="C" class="hidden"/>
    <input type="text" name="register_no"           class="hidden"/>
    <input type="text" name="cert_user_name"        class="hidden"/>
    <input type="text" name="cert_cert_type"        class="hidden" value="M"/>
    <input type="text" name="cert_hp_no1"           class="hidden"/>
    <input type="text" name="cert_hp_no2"           class="hidden"/>
    <input type="text" name="cert_hp_no3"           class="hidden"/>
    <input type="text" name="cert_hp_com"           class="hidden"/>
    <input type="text" name="cert_loanreq_seq"      class="hidden"/>
</form>

<form id="certMobileProc02Form">
    <input type="text" name="cert_type_info" value="C" class="hidden"/>
    <input type="text" name="register_no"           class="hidden"/>
    <input type="text" name="cert_user_name"        class="hidden"/>
    <input type="text" name="cert_cert_type"        class="hidden" value="M"/>
    <input type="text" name="cert_loanreq_seq"   class="hidden"/>
    <input type="text" name="cert_auth_no"       class="hidden"/>
    <input type="text" name="cert_auth_key"      class="hidden"/>

    <input type="text" name="cert_hp_no1"      class="hidden"/>
    <input type="text" name="cert_hp_no2"      class="hidden"/>
    <input type="text" name="cert_hp_no3"      class="hidden"/>
    <input type="text" name="cert_hp_com"      class="hidden"/>
    <input type="text" name="member_no"        class="hidden"/>
    <input type="text" name="service_cd"        class="hidden"/>
</form>

<form id="statProcForm">
    <input type="text" name="loanreq_seq"   class="hidden"/>
    <input type="text" name="pt_cust_no"   class="hidden"/>
    <input type="text" name="loan_state_cd"   class="hidden"/>
    <input type="text" name="admin_no"   class="hidden"/>
    <input type="text" name="notdefined"   class="hidden"/>
</form>

<form id="scrapIdcardProcForm">
    <input type="text" name="user_name"          class="hidden"/>
    <input type="text" name="user_idno"          class="hidden"/>
    <input type="text" name="idcard_verify"      class="hidden"/>
    <input type="text" name="idcard_issue_day"   class="hidden"/>
    <input type="text" name="idcard_license_num" class="hidden"/>
</form>
                <!-- title_area-->
                <div class="title_wrap">
                    <h3 class="title">고객상담</h3>
                    <div class="step_wrap">
                        <ul class="step">
                            <li class="current"><span>01</span>고객상담</li>
                            <li><span>02</span></li>
                        </ul>
                    </div>
                </div>

                <div id="contents">
<form id="wForm" focus alert>
    <input type="text" name="loan_state_cd"   class="hidden"/>
    <input type="text" name="loanreq_seq"       class="hidden"/>
    <input type="text" name="cert_loanreq_seq"  class="hidden"/>
    <input type="text" name="user_idno"         class="hidden"/>
    <input type="text" name="admin_no"          class="hidden"/>
    <input type="text" name="info_auth_way"     class="hidden"/>
    <input type="text" name="info_auth"         class="hidden"/>
    <input type="text" name="cert_cre_dt"       class="hidden"/>
    
    <input type="text" name="idcard_verify_result"       class="hidden" value= "N"/>
    <input type="text" name="idcard_verify_dt"       class="hidden"/>    
		    
    <input type="text" name="xksessionid1"       class="hidden"/>    
    <input type="text" name="xkindexed1"       class="hidden"/>    
    <input type="text" name="xksectoken1"       class="hidden"/>    

                    <div class="title_box">
                        <h4 class="title">약관동의</h4>
                    </div>
                    <div class="agree_box">
                        <div class="agree_title">
                            <h5 class="title">개인(신용)정보 수집.이용.제공 동의서(여신금융거래)</h5>
                            <div class="agree_radio">
                                <input type="radio" name="chkTerms1" value="Y" class="designRadiobutton" id="radio1_1" >
                                <label for="radio1_1" class="add_text">동의합니다.</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="chkTerms1" value="N" class="designRadiobutton" id="radio1_2" checked="checked">
                                <label for="radio1_2" class="add_text">동의하지 않습니다.</label>
                            </div>
                        </div>
                        <div class="agree_data">
                            <div class="indiv">
                               	<c:import url="/inc/agree01.jsp" />
                            </div>
                        </div>
<!--                        <div class="agree_title">
                            <h5 class="title">대출약관</h5>
                            <div class="agree_radio">
                                <input type="radio" name="chkTerms2" value="Y" class="designRadiobutton" id="radio2_1">
                                <label for="radio2_1" class="add_text">동의합니다.</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" name="chkTerms2" value="N" class="designRadiobutton" id="radio2_2" checked="checked">
                                <label for="radio2_2" class="add_text">동의하지 않습니다.</label>
                            </div>
                        </div>
                        <div class="agree_data">
                            <div class="indiv">
                                약관내용<br>약관내용<br>약관내용<br>약관내용<br>약관내용<br>약관내용<br>약관내용<br>약관내용<br>약관내용<br>약관내용<br>약관내용<br>
                            </div>
                        </div> -->
                    </div>

                    <div class="title_box">
                        <h4 class="title">개인정보입력</h4>
                    </div>
                    <div class="tbl_write">
                        <table class="list_tbl03" summary="이름,주민등록번호,통신사,자금용도">
                            <caption>개인정보입력</caption>
                            <colgroup>
                                <col style="width:170px;">
                                <col style="width:*;">
                            </colgroup>
                            <tbody>
                                <tr>
                                    <th scope="row">성명</th>
                                    <td>
                                        <input type="text" class="designInput" title="이름" name="user_name" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">주민등록번호</th>
                                    <td>
                                        <input type="text" min="0" max="999999" pattern="[0-9]*" inputmode="numeric" class="designInput numeric" name="user_idno1" value="" size="6" maxlength="6"  />
                                        <b>-</b>
                                        <input type="text" min="0" max="9999999" pattern="[0-9]*" inputmode="numeric" class="designInput numeric" name="user_idno2" value="" size="7" maxlength="7"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">휴대폰</th>
                                    <td>
                                        <select class="designSelect minwidth100" title="통신사" name="mobile_agency_cd">
<!--                                            <option value="SKT">SKT</option>
                                            <option value="KT">KT</option>
                                            <option value="LG">LG</option> -->
                                        </select>

                            <select class="designSelect minwidth100" title="국번" name="mobile_no1" value="1" maxlength="3">
                                <option value="010" selected>010</option>
                                <option value="011">011</option>
                                <option value="016">016</option>
                                <option value="017">017</option>
                                <option value="018">018</option>
                                <option value="019">019</option>
                            </select>

                            <input type="text" class="designInput width100 numeric" title="번호1" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="mobile_no2" size="3" value="" maxlength="4">
                            <input type="text" class="designInput width100 numeric" title="번호2" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="mobile_no3" size="3" value="" maxlength="4">
        <button type="button" class="btn btn_middle btn_blueline" id="btnSend">인증요청</button>
        <button type="button" class="btn btn_middle btn_blueline" id="btnNotAuth">미인증처리</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">인증번호</th>
                                    <td>
                                        <input type="number" class="designInput" title="인증번호" name="cert_auth_key" style="border-bottom:1px solid #dbdbdb;"/>
        								<button type="button" class="btn btn_middle btn_blueline" id="btnConfirm">인증확인</button>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">대출상품</th>
                                    <td>
								        <select name="service_cd" class="designSelect minwidth100">
								        	<option value="GM100">가맹점론</option>
								        	<option value="GM200">참구매자금론</option>
								        	<option value="GM300">일반자금대출</option>								        	
								        </select>
                                    </td>
                                
                                <tr>
                                    <th scope="row">자금용도</th>
                                    <td>
        <select name="fund_use" class="designSelect minwidth100">
        </select>


                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">유입경로</th>
                                    <td>
        <select name="receive_cd" class="designSelect minwidth100">
        </select>


                                    </td>
                                </tr>
                                
                                <tr>
                                    <th scope="row">필요자금</th>
                                    <td>
<input type="text" min="0" inputmode="numeric" class="designInput amount" title="필요자금" placeholder="필요자금" name="before_want_amt" >만원
                                    </td>
                                </tr>
                                <tr name="trReally" style="display:none">
                                    <th scope="row">신분증 진위확인</th>
                                    <td id="check_confirm">
                                        <input type="radio" class="designRadiobutton" id="idcard_verify_1" name="idcard_verify" checked="checked">
                                        <label for="idcard_verify_1" class="add_text">주민등록증</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" class="designRadiobutton" id="idcard_verify_2" name="idcard_verify">
                                        <label for="idcard_verify_2" class="add_text">운전면허증</label>
                                    </td>
                                </tr>
                                <tr name="trReally" style="display:none">
                                    <th scope="row">발급일자</th>
                                    <td>
                                        <input type="text" class="designInput datepicker" title="발급일자"  name="idcard_issue_day"/>
                                    </td>
                                </tr>
                                <tr name="trReally" style="display:none">
                                    <th scope="row">면허번호</th>
                                    <td>
                                        <input type="text" name="idcard_license_num" class="designInput" />
        <button type="button" class="btn btn_middle btn_blueline" id="btnReq">진위요청</button>
                                    </td>
                                </tr>
</span>                                
                            </tbody>
                        </table>
                    </div>

                    <div class="btn_wrap">
                    <!--
                     -->
                        <button type="button" id="btnCancel" class="btn btn_normal btn_grayline">취소</button>
                        <button type="submit" id="btnNext" class="btn btn_normal btn_green">다음</button>
                    <div>

                </div>
</form>                
            </div>

        </div>
    </div>

</div> <!-- // layout -->

<%@include file="/inc/footer.jsp" %>