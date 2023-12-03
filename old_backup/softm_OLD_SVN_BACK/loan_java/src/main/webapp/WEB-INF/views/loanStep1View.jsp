<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="사전품의STEP1입력";
$( document ).ready(function() {
	// 진위요청
    $( "body" ).on( "click", "#btnReq", function() {
    	window.isAuth = false;
        /*
           jQuery.validator.addMethod("testValid", function(value, element, params) {
                 return false;
           }, "테스트 검사했습니다.");
        */
        var vRules = {
                rules: {
                   idcard_issue_day: {required: true,dpDate: true, dated:true}
                 , idcard_license_num: {required: function(element){
                     return $("#wForm [name='idcard_verify'][value='" + SCRA_ID_CARD_TYPE.DRIVE + "']").is(":checked");
                   }
                   //,testValid:true
                 }
            }
            , messages: {
                  "idcard_issue_day": "발급일자를 확인하세요."
                 ,"idcard_license_num": "면허번호를 확인하세요."
            }
        };

     // if ( isValid('#wForm',vRules1) ) {
    	if ( validate('#wForm',vRules) ) {
            showLoading();
            $("#scrapIdcardProcForm [name='idcard_verify']"     ).val($("#wForm [name='idcard_verify']:checked").val()); // 신분증진위확인구분
            $("#scrapIdcardProcForm [name='idcard_issue_day']"  ).val($("#wForm [name='idcard_issue_day']").val()     ); // 발급일자
            $("#scrapIdcardProcForm [name='idcard_license_num']").val($("#wForm [name='idcard_license_num']").val()   ); // 면허번호
            var d = $("#scrapIdcardProcForm").serialize();
            exec("/scrapIdcardProc.do", d,function(data) {
                  
                  if ( data.RESULT_CD == RESULT_CD.OK ) {
                      //alert("진위요청 확인.");
                      //$("#wForm [name='user_name']").focus();
                      window.isAuth = true;
                  } else {
                  }
            });
    	}
    });

	// 다음
    $( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        
        var vRules = {
                rules: {
                   idcard_issue_day: {required: true,dpDate: true, dated:true}
                 , idcard_license_num: {required: function(element){
                     return $("#wForm [name='idcard_verify'][value='" + SCRA_ID_CARD_TYPE.DRIVE + "']").is(":checked");
                   }
                   //,testValid:true
                 }
            }
            , messages: {
                  "idcard_issue_day": "발급일자를 확인하세요."
                 ,"idcard_license_num": "면허번호를 확인하세요."
            }
        };

    	if ( !window.isAuth ) {
    		alert("진위여부 확인을 진행해주세요.");
      //} else if ( isValid('#wForm',vRules1) ) {
    	} else if ( validate('#wForm',vRules) ) {    		
    		if ( confirm("신청하시겠습니까?") ) {
		        showLoading();
		        $("#wForm [name='user_idno']").val($("#wForm [name='user_idno1']").val() + $("#wForm [name='user_idno2']").val()); //
		        var d = $("#wForm").serialize();
		        exec("/loanStep1Proc.do", d,function(data) {
		              if ( data.RESULT_CD == RESULT_CD.OK ) {
		                  goUrl( "/loanStep2View.do"
		                          + "?" + window.kParams.join("&")
		                  );
		              } else {
		              }
		        });
    		}
		}
    });

    $( "body" ).on( "click", "#btnCancel", function() { // 취소
        //if ( confirm("취소하시겠습니까?") ) {
             //goUrl("/consultView.do");
             history.go(-1);
        //}
    });
    
    (function(global){
        window.kParams=[];
        window.kParams.push("loanreq_seq=${param.loanreq_seq}");
        window.kParams.push("pt_cust_no=${param.pt_cust_no}");
        
    	//console.info("global :" , global);
        // 통신사
        getCodeValue(["48"],function(code){
            createCombo("#wForm [name='mobile_agency_cd']",code.CODEGRP48,"통신사", "SKT");
        });

        // 신분증진위확인
        getCodeValueForZC(["A01"],function(codeZC){
            createRadio("#wForm #check_confirm",codeZC.CODEGRPA01,"idcard_verify","01");
        });

        showLoading();
        exec("/loanStep1Info.do", window.kParams.join("&"),function(data) {
              //
              if ( data.RESULT_CD == RESULT_CD.OK ) {
                  if ( data.IDCARD_VERIFY_RESULT == IDCARD_VERIFY_RESULT_TYPE.SUCCESS ) {
                      goUrl( "/loanStep2View.do"
                              + "?" + window.kParams.join("&")
    				  );
                  } else {
	                  $("#scrapIdcardProcForm [name='user_idno']").val(data.USER_IDNO);
	                  $("#scrapIdcardProcForm [name='user_name']").val(data.USER_NAME);
	                  $("#tdUser_name").text(data.USER_NAME);
	                  $("#tdUser_idno").text(data.USER_IDNO.substring(0,6) + "-" +data.USER_IDNO.substring(6,13));
	                  $("#tdMobile_no").text(data.MOBILE_NO1 + "-" + data.MOBILE_NO2 + "-" + data.MOBILE_NO3);	                  
                  }            	  
              } else {
              }
        });

        //hideLoading();

        //$("#wForm [name='idcard_issue_day']").val(CONST.CURRENT_DATE);
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
	<input type="text" name="user_name"          class="hidden"/>
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
                            <li class="current"><span>01</span>개인정보입력</li>
                            <li><span>02</span></li>
                            <li><span>03</span></li>
                        </ul>
                    </div>
                </div>

<form id="wForm" alert focus>
<input type="text" name="loanreq_seq"          class="hidden" value="${param.loanreq_seq}"/>
                <div id="contents">
                    <div class="title_box">
                        <h4 class="title">개인정보입력</h4>
                    </div>
                    <div class="tbl_write">
                        <table class="list_tbl03" summary="이름,주민등록번호,통신사,자금용도">
                            <caption>개인정보입력</caption>
                            <colgroup>
                                <col style="width:170px;" />
                                <col style="width:*;" />
                            </colgroup>

                            <tbody>
                                <tr>
                                    <th scope="row">이름</th>
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
                                    <th scope="row">신분증 진위확인</th>
                                    <td id="check_confirm">
                                        <input type="radio" class="designRadiobutton" id="radio3_1" name="radio3" checked="checked">
                                        <label for="radio3_1" class="add_text">주민등록증</label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="radio" class="designRadiobutton" id="radio3_2" name="radio3">
                                        <label for="radio3_2" class="add_text">운전면허증</label>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">발급일자</th>
                                    <td>
                                        <input type="text" class="designInput datepicker" title="발급일자"  name="idcard_issue_day"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">면허번호</th>
                                    <td>
                                        <input type="text" name="idcard_license_num" class="designInput" />
        <button type="button" class="btn btn_middle btn_blueline" id="btnReq">진위요청</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="btn_wrap">
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