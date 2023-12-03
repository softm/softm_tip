<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script>
document.title="로그인";
$( document ).ready(function() {
	loadBasicInformation();

    $( "body" ).on( "click", "#btnSend", function() {
        if ( !$("#wForm [name='mobile_agency_cd']").val() ) {
            alert("통신사를 확인하세요.");
            $("#wForm [name='mobile_agency_cd']").focus();
            return;
        } else if ( !$("#wForm [name='mobile_no1']").val() ) {
            alert("휴대폰번호를 확인하세요.");
            $("#wForm [name='mobile_no1']").focus();
            return;
        } else if ( !$("#wForm [name='mobile_no2']").val() ) {
            alert("휴대폰번호를 확인하세요.");
            $("#wForm [name='mobile_no2']").focus();
            return;
        } else if ( !$("#wForm [name='mobile_no3']").val() ) {
            alert("휴대폰번호를 확인하세요.");
            $("#wForm [name='mobile_no3']").focus();
            return;
        }

        showLoading();
        $("#certMobileProc01Form [name='cert_hp_com']").val($("#wForm [name='mobile_agency_cd']").val()); // 휴대폰_통신사
        $("#certMobileProc01Form [name='cert_hp_no1']").val($("#wForm [name='mobile_no1']"      ).val()); // 휴대폰_연락처1
        $("#certMobileProc01Form [name='cert_hp_no2']").val($("#wForm [name='mobile_no2']"      ).val()); // 휴대폰_연락처2
        $("#certMobileProc01Form [name='cert_hp_no3']").val($("#wForm [name='mobile_no3']"      ).val()); // 휴대폰_연락처3
        $("#certMobileProc01Form [name='member_no'  ]").val($("#wForm [name='member_no' ]"      ).val()); // 사번
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
                  $("#wForm [name='member_no']").focus();
              } else {
              }
        });
    });
    
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        if ( !$("#wForm [name='member_no']").val() ) {
            alert("ID를 확인하세요.");
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
              if ( data.RESULT_MSG ) alert(data.RESULT_MSG);
              if ( data.RESULT_CD == RESULT_CD.OK ) {
            	  setMemberInfo(mNo);
                  goUrl("/mainView.do");
              } else {
              }
        });
    });
    
    //debugger;
	// code.CODEGRP48
	// 통신사
    getCodeValue([48],function(code){
    	createCombo("#wForm [name='mobile_agency_cd']",code.CODEGRP48,"-선택-","SKT");    	
    });
	hideLoading();
});
</script>
<body>
<div class='main' id="page1">
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
<form id="certMobileProc02Form">
    <input type="text" name="cert_loanreq_seq"   class="hidden"/>
    <input type="text" name="cert_auth_no"       class="hidden"/>
    <input type="text" name="cert_auth_key"      class="hidden"/>
</form>
<form id="wForm">
<table>
<tr><td>ID</td><td><input type="text" name="member_no" value="99904"/></td></tr>
<tr><td>비밀번호</td><td><input type="password" name="member_pw" value="foresys#@1"/></td></tr>
<tr><td>통신사</td><td>
<select name="mobile_agency_cd">
</select>
<input type="text" name="mobile_no1" size="3" value="1" maxlength="3"/> -
<input type="text" name="mobile_no2" size="3" value="2" maxlength="4"/> -
<input type="text" name="mobile_no3" size="3" value="3" maxlength="4"/>
<button type="button" id="btnSend">인증번호발송</button>
</td>
</tr>
<tr><td>SMS인증번호</td><td><input type="text" name="cert_loanreq_seq" value="1"/>
<button type="button" id="btnConfirm">인증번호재전송</button>
</td></tr>

<tr><td colspan="2">
<!--
    <button type="submit" id="btnLogin" disabled="disabled">로그인</button>
-->
    <button type="submit" id="btnLogin">로그인</button>
</td>
</tr>
</table>
</form>
    </div>
<%@include file="/inc/footer.jsp" %>