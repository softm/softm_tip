<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="고객상담";
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

    // btnNext
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        if ( !isValid() ) {
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
	   if ( !$("#chkTerms").is(":checked") ) {
            alert("동의서내용에 동의해야합니다.");
            $("#chkTerms").focus();
            return false;
	   }        
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
    	createCombo("#wForm [name='mobile_agency_cd']",code.CODEGRP48,"-선택-", "SKT");
    });
    
    // 자금용도
    getCodeValueForZC(["A07"],function(codeZC){
    	createCombo("#wForm [name='fund_use']",codeZC.CODEGRPA07,"-선택-");
    });
	showLoading();
	hideLoading(); 	
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
	<tr><th colspan="2" align="left">개인정보입력</th></tr>
	<tr><td>성명	</td><td><input type="text" name="user_name" value="홍길동"/></td></tr>
	<tr><td>주민번호</td><td><input type="text" name="user_idno1" value="711012" size="6" maxlength="6"/>
<input type="text" name="user_idno2" value="1234570" size="7" maxlength="7"/>	
	</td></tr>
	<tr><td>휴대폰<td>
		<select name="mobile_agency_cd">
		</select>
		<input type="text" name="mobile_no1" size="3" value="1" maxlength="3"/> -
		<input type="text" name="mobile_no2" size="3" value="2" maxlength="4"/> -
		<input type="text" name="mobile_no3" size="3" value="3" maxlength="4"/>
		<button type="button" id="btnSend">인증요청</button>
		<button type="button" id="btnNotAuth">미인증처리</button>
	</td>
	</tr>
	<tr><td>인증번호</td><td><input type="text" name="cert_loanreq_seq" value="1"/>
	<button type="button" id="btnConfirm">인증확인</button>
	<!-- <button type="button" id="btnReSend">인증번호재전송</button> -->	
	</td>
	
	<tr><td>자금용도</td><td><!-- CD.A07 -->
		<select name="fund_use">
		</select>
	</td></tr>
	<tr><td>필요자금</td><td><input type="number" min="0" pattern="[0-9]*" inputmode="numeric" placeholder="필요자금" name="before_want_amt" >천원</td></tr>
	</tr>

</table>

<table border="1" >
	<tr><th colspan="2" align="left">약관동의</th></tr>
	<tr><td>
  개인(신용)정보 수집.이용.제공 동의서(여신금융거래)															[약관보기]	
	</td>
	<td>	
	    <button type="button" id="btnTerms">[약관보기]</button>
	</td>
	</tr>
	<tr id="vwTerms"><td colspan="2">
	    <textarea rows="1" style="width:95%;resize: none;">약관내용
111111111111
222222222222
333333333333
444444444444
555555555555
666666666666</textarea>
	</td>
	</tr>
	<tr id="vwTerms"><td colspan="2">
	    <input type="checkbox" id="chkTerms" value="Y"/> 위의 내용을 충분히 숙지하고, 동의서에 동의합니다.
	</td>
	</tr>
	<tr><td colspan="2">
	    <button type="submit" id="btnNext" disabled="disabled">다음</button>
	</td>
	</tr>
</table>
</form>
		</td>
	</table>
</div>
<div class='main hide' id="page2"><div>
<%@include file="/inc/footer.jsp" %>