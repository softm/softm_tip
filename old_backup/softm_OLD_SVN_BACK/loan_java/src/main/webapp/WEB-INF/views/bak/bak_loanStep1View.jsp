<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="사전품의STEP1입력";
$( document ).ready(function() {
	function isValid() {
        if ( !$("#wForm [name='user_name']").val() ) {
            alert("이름을 확인하세요.");
            $("#wForm [name='user_name']").focus();
            return false;
        } else if ( juminCheck( $("#wForm [name='user_idno1']").val(),  $("#wForm [name='user_idno2']").val()) ) {
            alert("주민번호를 확인하세요.");
            $("#wForm [name='user_idno1']").focus();
            return false;
        } else if ( !$("#wForm [name='mobile_agency_cd']").val() ) {
            alert("통신사를 확인하세요.");
            $("#wForm [name='mobile_agency_cd']").focus();
            return false;
       } else if ( !$("#wForm [name='mobile_no1']").val() ) {
            alert("휴대폰번호를 확인하세요.");
            $("#wForm [name='mobile_no1']").focus();
            return false;
        } else if ( !$("#wForm [name='mobile_no2']").val() ) {
            alert("휴대폰번호를 확인하세요.");
            $("#wForm [name='mobile_no2']").focus();
            return false;
        } else if ( !$("#wForm [name='mobile_no3']").val() ) {
            alert("휴대폰번호를 확인하세요.");
            $("#wForm [name='mobile_no3']").focus();
            return false;
        }
        return true;
	}

    $( "body" ).on( "click", "#btnSend", function() {
        if ( !isValid() ) {
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
            if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
            if ( data.RESULT_CD == RESULT_CD.OK ) {
              //alert("인증번호가 발송되었습니다.");
        		$("#certMobileProc02Form [name='cert_auth_no']").val(data.CERT_AUTH_NO); // 인증고유번호              
            } else {
            }
        });
    });
    $( "body" ).on( "click", "#btnNotAuth", function() {
        event.preventDefault();
        showLoading();
        //TODO SOFTM NOT DEFINE
      //$("#statProcForm [name='notdefined']").val($("#wForm [name='mobile_agency_cd']").val());
        var d = $("#statProcForm").serialize();
        exec("/statProc.do", d,function(data) {
            if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
            if ( data.RESULT_CD == RESULT_CD.OK ) {
              //alert("인증번호가 발송되었습니다.");
              //TODO SOFTM API NOTDEFINED
        	   //$("#certMobileProc02Form [name='cert_auth_no']").val(data.CERT_AUTH_NO); // 인증고유번호              
        		$("#certMobileProc02Form [name='cert_auth_no']").val("NOTAUTH"); // 인증고유번호              
            } else {
            }
            checkNext();
        });
    });
	
    $( "body" ).on( "click", "#btnConfirm", function() {
        if ( !$("#certMobileProc02Form [name='cert_auth_no']").val() ) {
            alert("인증요청을 진행해주세요.");
            return;
        }
        
        if ( !$("#wForm [name='cert_loanreq_seq']").val() ) {
            alert("SMS인증번호를 확인하세요.");
            $("#wForm [name='cert_loanreq_seq']").focus();
            return;
        }

        showLoading();
        $("#certMobileProc02Form [name='cert_loanreq_seq']").val($("#wForm [name='cert_loanreq_seq']").val()); // SMS인증번호
        var d = $("#certMobileProc02Form").serialize();
        exec("/certMobileProc02.do", d,function(data) {
              if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                  //alert("인증번호가 발송되었습니다.");
                  $("#btnLogin").removeAttr("disabled");
                  $("#wForm [name='user_name']").focus();
              } else {
              }
        });
        checkNext();
    });
    
    $( "form" ).on( "submit", function( event ) {
    	if  ( !$('#wForm').valid() ) {
    		var validator = $('#wForm').validate();
        	//console.info ( validator );
     	    var errors = validator.numberOfInvalids();
    	    if (errors) {
				if (validator.errorList.length > 0) alert(validator.errorList[0].message);
    	      	validator.errorList[0].element.focus();    	      
    	    } 
			return false;
    	}
        if ( !isValid() ) {
        	return false;
        }
/*         if ( !$("#wForm [name='fund_use']").val() ) {
            alert("자금용도를 확인하세요.");
            $("#wForm [name='fund_use']").focus();
            return false;
        } else if ( !$("#wForm [name='before_want_amt']").val() ) {
            alert("필요자금을 확인하세요.");
            $("#wForm [name='before_want_amt']").focus();
            return false;
       }
	   if ( !$("#chkTerms").is(":checked") ) {
            alert("동의서내용에 동의해야합니다.");
            $("#chkTerms").focus();
            return false;
	   }  
*/       
        showLoading();
        $("#wForm [name='user_idno']").val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val()); //
        var d = $("#wForm").serialize();
        exec("/consultProc.do", d,function(data) {
              if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                  // data.LOANREQ_SEQ         신청번호
                  // data.PT_CUST_NO          고객번호
                  // data.LOAN_STATE_CD
                  // data.ADMIN_NO
                  goUrl( "/consultResultView.do" 
                		                         + "?loanreq_seq=" + data.LOANREQ_SEQ 
                		                         + "&pt_cust_no="  + data.PT_CUST_NO 
				  );
              } else {
              }
        });        
    });
    
    // 통신사
    getCodeValue(["48"],function(code){
    	createCombo("#wForm [name='mobile_agency_cd']",code.CODEGRP48,"통신사", "SKT");
    });
    
    // 신분증진위확인
    getCodeValueForZC(["A01"],function(codeZC){
    	createRadio("#wForm #check_confirm",codeZC.CODEGRPA01,"idcard_verify","01");
    });
    
	showLoading();
    function info() {
          var params=[];
          params.push("loanreq_seq=${param.loanreq_seq}");
          params.push("pt_cust_no=${param.pt_cust_no}");
          exec("/loanStep1Info.do", params.join("&"),function(data) {
                //if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
                if ( data.RESULT_CD == RESULT_CD.OK ) {
                	$("[name='user_name']").text(data.USER_NAME);
                	$("[name='user_idno']").text(data.USER_IDNO);
                	$("[name='mobile_no']").text(data.MOBILE_NO1 + "-" + data.MOBILE_NO2 + "-" + data.MOBILE_NO3);
/*
                	text(data.LOANREQ_SEQ);                               신청번호
                	text(data.PT_CUST_NO);                                고객번호
                	text(data.USER_IDNO);                                 주민번호
                	text(data.MOBILE_NO1);                                휴대폰_연락처1
                	text(data.MOBILE_NO2);                                휴대폰_연락처2
                	text(data.MOBILE_NO3);                                휴대폰_연락처3
                	text(data.LOAN_STATE_CD);                             신청상태
                	text(data.ADMIN_NO);                                  담당자
                	text(data.IDCARD_VERIFY);                             신분증진위확인구분
                	text(data.IDCARD_ISSUE_DAY);                          발급일자
                	text(data.IDCARD_LICENSE_NUM);                        면허번호
                	text(data.IDCARD_VERIFY_RESULT);                      신분증진위확인증결과
                	text(data.IDCARD_VERIFY_DT);                          신분증진위확인증일시
*/
                	
                } else {
                }
          });
    };
    info();
	hideLoading();  
	
	$("#wForm [name='idcard_issue_day']").val(CONST.CURRENT_DATE);
	//"loanStep1Info
	//(사전품의step1입력)"		

    $('#wForm').validate({ 
        onfocusout: false,
        //errorPlacement: $.datepicker.errorPlacement,
        errorPlacement: function(error, element) {
        }
        , rules: {
        	idcard_issue_day: {required: true,dpDate: true}
        }
        , messages: {
        	"idcard_issue_day": "발급일자를 확인하세요."
        }        
        , submitHandler: function(form) {
      	} 
        , invalidHandler: function(event, validator) {
        }
        , showErrors: function(errorMap, errorList) {
        }
    });
});
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
<form id="certMobileProc01Form">
    <input type="text" name="cert_type_info" value="L" class="hidden"/>
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
    <input type="text" name="cert_loanreq_seq"   class="hidden"/>
    <input type="text" name="cert_auth_no"       class="hidden"/>
    <input type="text" name="cert_auth_key"      class="hidden"/>
</form>

<form id="statProcForm">
    <input type="text" name="loanreq_seq"   class="hidden"/>
    <input type="text" name="pt_cust_no"   class="hidden"/>
    <input type="text" name="loan_state_cd"   class="hidden"/>
    <input type="text" name="admin_no"   class="hidden"/>
    <input type="text" name="notdefined"   class="hidden"/>
</form>

<div class='main' id="page1">
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
    <input type="text" name="admin_no"      class="hidden"/>
    <input type="text" name="info_auth_way"      class="hidden"/>
    <input type="text" name="info_auth"      class="hidden"/>
    <input type="text" name="cert_cre_dt"      class="hidden"/>

<table border="1" >
	<tr><th colspan="4" align="left">개인정보입력</th></tr>
	<tr><td>성명	</td><td colspan="3" name="user_name" ></td></tr>
	<tr><td>주민번호</td><td colspan="3" name="user_idno" >	
	</td></tr>
	<tr><td>휴대폰<td colspan="3" name="mobile_no">
	</td>
	</tr>
	
	<tr>
	<td>*신분증진위확인</td><td colspan="3" id="check_confirm">	
	</td>
	</tr>
 
	<tr><td>인증번호</td><td colspan="3"><input type="text" name="cert_loanreq_seq" value="1"/>
	<button type="button" id="btnConfirm">인증확인</button>
	<!-- <button type="button" id="btnReSend">인증번호재전송</button> -->	
	</td>
	</tr>
	
	<tr>
	<td>발급일자</td><td>
		<input type="text" name="idcard_issue_day" class="datepicker"/>
	</td>
    <td>면허번호</td>
    <td>
		<input type="text" name="idcard_license_num"/>
		<button type="button" id="btnConfirm">인증확인</button>
	</td>
	</tr>
	
	<tr><td colspan="4">
	    <button type="submit" id="btnNext">다음</button>
	</td>
	</tr>
</table>
</form>
		</td>
	</table>
</div>
<div class='main hide' id="page2"><div>
<%@include file="/inc/footer.jsp" %>