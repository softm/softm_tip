<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script>
document.title="로그인";
$( document ).ready(function() {
	// ui 깨져서 유지함.
	$(document).find('#navi').css({'width':'80px'})	
	new main_size('small');		
	
	showLoading();
	loadBasicInformation();
	
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
    
    $( "body" ).on( "click", "#btnSend", function() {
        var vRules = {
                rules: {
                   mobile_agency_cd: {required: true}
                 , mobile_no1: {required: true,number:true}
                 , mobile_no2: {required: true,number:true}
                 , mobile_no3: {required: true,number:true}
            }
            , messages: {
                   "mobile_agency_cd": "통신사를 확인하세요."
                 , "mobile_no1": "휴대폰번호를 확인하세요."
                 , "mobile_no2": "휴대폰번호를 확인하세요."
                 , "mobile_no3": "휴대폰번호를 확인하세요."
            }
        };

        if ( validate('#wForm',vRules) ) {
	        showLoading();
	        $("#certMobileProc01Form [name='cert_hp_com']").val($("#wForm [name='mobile_agency_cd']").val()); // 휴대폰_통신사
	        $("#certMobileProc01Form [name='cert_hp_no1']").val($("#wForm [name='mobile_no1']"      ).val()); // 휴대폰_연락처1
	        $("#certMobileProc01Form [name='cert_hp_no2']").val($("#wForm [name='mobile_no2']"      ).val()); // 휴대폰_연락처2
	        $("#certMobileProc01Form [name='cert_hp_no3']").val($("#wForm [name='mobile_no3']"      ).val()); // 휴대폰_연락처3
	        $("#certMobileProc01Form [name='member_no'  ]").val($("#wForm [name='member_no' ]"      ).val()); // 사번
	        var d = $("#certMobileProc01Form").serialize();
	        exec("/certMobileProc01.do", d,function(data) {
	            
	            if ( data.RESULT_CD == RESULT_CD.OK ) {
	              //alert("인증번호가 발송되었습니다.");
	        		$("#certMobileProc02Form [name='cert_loanreq_seq']").val(data.CERT_LOANREQ_SEQ); // 인증일련번호
	        		$("#certMobileProc02Form [name='cert_auth_result']").val(data.CERT_AUTH_RESULT); // 인증결과
	        		$("#certMobileProc02Form [name='cert_auth_no']"    ).val(data.CERT_AUTH_NO    ); // 인증고유번호
	            } else {
	        		$("#certMobileProc02Form [name='cert_loanreq_seq']").val(""); // 인증일련번호
	        		$("#certMobileProc02Form [name='cert_auth_result']").val(""); // 인증결과              	
	        		$("#certMobileProc02Form [name='cert_auth_no']"    ).val(""); // 인증고유번호            	
	            }
	        });
        }
    });
    
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
// 인증확인 //////////////////////// // // //
        var vRules1 = {
                rules: {
                   cert_auth_no: {required: true}
            }
            , messages: {
                   "cert_auth_no": "인증요청을 진행해주세요."
            }
        };
        var vRules2 = {
                rules: {
                 cert_auth_key: {required: true}
            }
            , messages: {
                 "cert_auth_key": "SMS인증번호를 확인하세요."
            }
        };
        
        if ( OP || ( DEBUG && $("#wForm [name='member_no']").val().indexOf("9990") == -1 ) ) {
		    if ( !validate('#certMobileProc02Form',vRules1) || !validate('#wForm',vRules2) ) {
	        	return;
			}
        }
        showLoading();
        $("#certMobileProc02Form [name='cert_loanreq_seq']").val($("#wForm [name='cert_loanreq_seq']").val()); // SMS인증번호
        $("#certMobileProc02Form [name='cert_hp_com']"     ).val($("#wForm [name='mobile_agency_cd']").val()); // 휴대폰_통신사
        $("#certMobileProc02Form [name='cert_hp_no1']"     ).val($("#wForm [name='mobile_no1']"      ).val()); // 휴대폰_연락처1
        $("#certMobileProc02Form [name='cert_hp_no2']"     ).val($("#wForm [name='mobile_no2']"      ).val()); // 휴대폰_연락처2
        $("#certMobileProc02Form [name='cert_hp_no3']"     ).val($("#wForm [name='mobile_no3']"      ).val()); // 휴대폰_연락처3
        $("#certMobileProc02Form [name='member_no']"       ).val($("#wForm [name='member_no']"       ).val()); // 사번
        $("#certMobileProc02Form [name='cert_auth_key']"   ).val($("#wForm [name='cert_auth_key']"   ).val()); // SMS 인증번호

        var d = $("#certMobileProc02Form").serialize();
        exec("/certMobileProc02.do", d,function(data) {
              
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                  //alert("인증확인됨.");
        		  window.isAuth = true;                  
                  $("#btnLogin").removeAttr("disabled");
                  $("#wForm [name='member_no']").focus();
                  
                  if ( !$("#wForm [name='member_no']").val() ) {
                      alert("아이디를 확인하세요.");
                      $("#wForm [name='member_no']").focus();
                      return;
                  } else if ( !$("#wForm [name='member_pw']").val() ) {
                      alert("비밀번호를 확인하세요.");
                      $("#wForm [name='member_pw']").focus();
                      return;
                  }

                  showLoading();
                  var mNo = $("#wForm [name='member_no']").val();
                  $("#loginProcForm [name='member_no'       ]").val(mNo); // 
                  $("#loginProcForm [name='member_mac'      ]").val(	INFO.MAC_ADDRESS ); // 
                  $("#loginProcForm [name='member_pw'       ]").val($("#wForm [name='member_pw']").val()); // 
                  $("#loginProcForm [name='mobile_agency_cd']").val($("#wForm [name='mobile_agency_cd']").val()); // 
                  $("#loginProcForm [name='mobile_no1'      ]").val($("#wForm [name='mobile_no1']").val()); // 
                  $("#loginProcForm [name='mobile_no2'      ]").val($("#wForm [name='mobile_no2']").val()); // 
                  $("#loginProcForm [name='mobile_no3'      ]").val($("#wForm [name='mobile_no3']").val()); // 
                  //$("#loginProcForm [name='cert_loanreq_seq']").val($("#wForm [name='cert_loanreq_seq']").val()); // 
                  //$("#loginProcForm [name='cert_auth_result']").val($("#wForm [name='cert_loanreq_seq']").val()); // 

                  var d = $("#loginProcForm").serialize();
                  exec("/loginProc.do", d,function(data) {
                        if ( data.RESULT_CD == RESULT_CD.OK ) {
                      	  	setMemberInfo(mNo);
                            goUrl("/mainView.do");
                        } else {
                      	  return;
                        }
                  });                  
              } else {
            	  return;
              }
        });
//////////////////////// 인증확인 // // //
    });
	
    (function(global){
    	// 통신사
        getCodeValue([48],function(code){
        	createCombo("#wForm [name='mobile_agency_cd']",code.CODEGRP48,"-선택-","1");    	
    		hideLoading();
        	if ( DEBUG ) {
                $("#wForm [name='mobile_agency_cd']").val("1");    		
        	}
        });

    	// TODO SOFTM 삭제
    	if ( DEBUG ) {
            $("#wForm [name='member_no'   ]").val("99904"); //
            $("#wForm [name='member_pw'   ]").val("foresys#@1"); //

            $("#wForm [name='mobile_no2'      ]").val("9071"); //
            $("#wForm [name='mobile_no3'      ]").val("7218"); //
            $("#wForm [name='cert_auth_key'   ]").val("1234560"); //
    	}
    })(window);	
});
</script>
<body>
<div id="layout">

	<div id="wrap">
		<div id="wrapper">

			<div id="contentsarea" class="bg_main">

				<div id="contents">

					<div class="loginPage">
<form id="loginProcForm">
    <input type="text" name="member_no"          class="hidden"/>
    <input type="text" name="member_mac"         class="hidden"/>
    <input type="text" name="member_pw"          class="hidden"/>
    <input type="text" name="mobile_agency_cd"   class="hidden"/>
    <input type="text" name="mobile_no1"         class="hidden"/>
    <input type="text" name="mobile_no2"         class="hidden"/>
    <input type="text" name="mobile_no3"         class="hidden"/>
    <input type="text" name="cert_loanreq_seq"   class="hidden"/>
    <input type="text" name="cert_auth_result"   class="hidden"/>
</form>

<form id="certMobileProc01Form">
    <input type="text" name="cert_type_info" value="L" class="hidden"/>
    <input type="text" name="cert_hp_no1"      class="hidden"/>
    <input type="text" name="cert_hp_no2"      class="hidden"/>
    <input type="text" name="cert_hp_no3"      class="hidden"/>
    <input type="text" name="cert_hp_com"      class="hidden"/>
    <input type="text" name="member_no"        class="hidden"/>
</form>
<form id="certMobileProc02Form" alert focus>
    <input type="text" name="cert_type_info" value="L" class="hidden"/>
    <input type="text" name="cert_loanreq_seq"   class="hidden"/>
    <input type="text" name="cert_auth_no"       class="hidden"/>
    <input type="text" name="cert_auth_key"      class="hidden"/>
    
    <input type="text" name="cert_hp_no1"      class="hidden"/>
    <input type="text" name="cert_hp_no2"      class="hidden"/>
    <input type="text" name="cert_hp_no3"      class="hidden"/>
    <input type="text" name="cert_hp_com"      class="hidden"/>
    <input type="text" name="member_no"        class="hidden"/>
</form>
<form id="wForm" alert focus>
						<h1 class="logo"></h1>

						<div class="input_wrap">
							<input type="text" name="member_no" value="" class="designInput themeWhite" title="아이디" placeholder="아이디를 입력하세요" />
							<span class="btnX"></span>
						</div>

						<div class="input_wrap">
							<input type="password" name="member_pw" value="" class="designInput themeWhite" title="" placeholder="비밀번호를 입력하세요" />
						</div>

						<div class="input_wrap">
							<select class="designSelect themeWhite minWidth90" title="" name="mobile_agency_cd">
								<option value="SKT">SKT</option>
							</select>
							
							<select class="designSelect themeWhite minWidth60" title="" name="mobile_no1" value="" maxlength="3">
								<option value="010" selected>010</option>
								<option value="011">011</option>
								<option value="016">016</option>
								<option value="017">017</option>
								<option value="018">018</option>
								<option value="019">019</option>
							</select>
							<input type="text" class="designInput themeWhite width50 numeric" title="" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="mobile_no2" size="3" value="" maxlength="4">
							<input type="text" class="designInput themeWhite width50 numeric" title="" type="number" min="0" pattern="[0-9]*" inputmode="numeric" name="mobile_no3" size="3" value="" maxlength="4">
						</div>
						<button type="button" class="btn btn_gray_login" id="btnSend">인증번호발송</button>
						
<!-- 						<button type="button" class="btn btn_gray_login" id="btnConfirm">인증번호재전송</button> -->

						<div class="input_wrap">
							<input type="number" style="color:#FFF" class="designInput themeWhite" title="" placeholder="인증번호를 입력하세요" name="cert_auth_key" value="">
						</div>

						<button type="submit" class="btn btn_blue_login" id="btnLogin">로그인</button>
					</div>
</form>
				</div> <!-- // contnets -->
			</div><!-- //bg_main -->

		</div>
	</div>

</div> <!-- // layout -->
<%@include file="/inc/footer.jsp" %>