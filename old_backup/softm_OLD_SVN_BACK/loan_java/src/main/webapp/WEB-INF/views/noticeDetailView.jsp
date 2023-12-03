<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="업무자료실";
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
        exec("/noticeDetailInfo.do", window.kParams.join("&"),function(data) {
	              if ( data.RESULT_CD == RESULT_CD.OK ) {
            	  //console.info(data);
				  $("#bTitle").text(data.TITLE);
                  $("#tdUser_name").text(data.USER_NAME);
                  $("#tdContent").html(data.CONTENT);
                  //alert(data.FILE_NO);
                  if ( data.FILE_NO ) {
                      $("#spnFile").removeClass("dsNone");
                	  $("#spnFile").find(".file_name").text(data.FILE_NAME);
                	  $("#spnFile").find(".file_name").attr("file_no", data.FILE_NO);
              	    $( "body" ).on( "click", "#spnFile .file_name", function() { // openOZ
            			event.preventDefault();
						alert("파일다운로드");              	    	
            	    });
                  }
              } else {
              }
        });
        
	    $( "body" ).on( "click", "#btnList", function() { // openOZ
            event.preventDefault();
        	//var notice_seq = $(this).closest("tr").attr("notice_seq");
            var params=[];
            //    params.push("notice_seq=" + notice_seq);
    			goUrl("noticeListView.do?" + params.join("&"));
	    });
       // hideLoading();

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
        <td>\${PSLOAN_RT}
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
<form id="wForm" alert focus>

				<!-- title_area-->
				<div class="title_wrap">
					<h3 class="title">업무자료실</h3>
				</div>

				<div id="contents">

					<div class="title_box">
						<h4 class="title">상세정보</h4>
					</div>
					<div class="tbl_box">
						<table class="list_tbl02" summary="고객명,CB등급,신용관리정보,연체발생일,대출정보(당행제외),신용카드,보증채무(당행제외)">
							<caption>신용정보 상세</caption>
							<colgroup>
								<col style="width:16%;" />
								<col style="width:*;" />
							</colgroup>
							<tbody>
								<tr>
									<th scope="row">제목</th>
									<td><b id="bTitle">개인정보 취급 강화에 따른 필수 확인사항 입니다.</b></td>
								</tr>
								<tr>
									<th scope="row">작성자</th>
									<td id="tdUser_name">작성자</td>
								</tr>
								<tr>
									<th scope="row">내용</th>
									<td id="tdContent" class="contents">컨텐츠내용</td>
								</tr>
								<tr>
									<th scope="row">첨부파일</th>
									<td>
									<span id="spnFile" class="dsNone">
									<span class="icon icon_file">files</span><span class="file_name">개인정보취급방침개정_0124.hwp</span>
									</span>
									</td>
								</tr>
							</tbody>
						</table>																	
					</div>

					<div class="btn_wrap">
						<button type="button" id="btnList" class="btn btn_normal btn_grayline">목록</button>
					</div>

				</div>

</form>

            </div>
        </div>
    </div>

</div> <!-- // layout -->
<%@include file="/inc/footer.jsp" %>