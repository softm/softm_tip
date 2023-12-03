<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@include file="/inc/common.jsp" %>
<%@include file="/inc/header.jsp" %>
<script src="/js/json_test_data.js" type="text/javascript"></script>
<script>
document.title="업무자료실";
$( document ).ready(function() {

    function list(page) {
    	showLoading();    	
    	window.listSeq = 0;
      	// 고객상담 : con
      	// 사전품의 : loan
      	// 여신약정 : sign
        var params=[];
            params.push("page=" + page);
          exec("/noticeListInfo.do", params.join("&"),function(data) {
        	  	if ( data.LIST instanceof Array ) {
	                if ( data.RESULT_CD == RESULT_CD.OK ) {
	                	if (page==1) $( "#list01 .list" ).empty();
	                    $( "#list01Template" ).tmpl( data.LIST ).appendTo( "#list01 .list" );                    
	                } else {
	                }
	                $( "body" ).on( "click", "#list01 .list [name='spnIconFile']", function() { //
	                	var notice_seq = $(this).closest("tr").attr("notice_seq");
	                    var params=[];
	                        params.push("notice_seq=" + notice_seq);
	                        alert("파일다운로드");
	            			//goUrl("fileDownload.do?" + params.join("&"));                    	
	                });
	                $( "body" ).on( "click", "#list01 .list [name='viewDetail']", function() { //
	                	var notice_seq = $(this).closest("tr").attr("notice_seq");
	                    var params=[];
	                        params.push("notice_seq=" + notice_seq);
	            			goUrl("noticeDetailView.do?" + params.join("&"));                    	
	                });
        	  	}
          });
      	//hideLoading();
    };
    
    $( "body" ).on( "click", "[name='btnLoanList']", function() { // 
    	var id = ($(this).attr("gubun"));
    	$(this).parent().find("[name='btnLoanList']").css("font-weight","");
    	$(this).css("font-weight","bold");
        list(id);    
    });
    
    (function () {
        var params=[];
            list(1);
    })();
	//showLoading();
   	//hideLoading();   
   	var page = 1;
/*     $("#contents").scroll(function() {
    	   if($("#contents").scrollTop() + window.innerHeight == $(document).height()) {
    	       // alert("bottom!");
    	       page++;
               list(page);
    	   }
    }); */
    
    		$("#contents").scroll(function() {    		
    		    var element = event.target;
    		    if ($("#contents")[0].scrollHeight - $("#contents").scrollTop() === $("#contents")[0].clientHeight) {
    		        //console.log('scrolled');
	    	       page++;
	               list(page);
    		    }
    		});
    
    
});

// index..
function fListSeq() {
	return ++window.listSeq;
}
</script>
<script id="list01Template" type="text/x-jquery-tmpl">
    <tr notice_seq="\${NOTICE_SEQ}">
    	<td>\${NOTICE_SEQ}</td>									
    	<td class="alignLeft" name="viewDetail">
{{if CTITLE=='공지사항' }}
<span class="icon icon_blue_box">공지사항</span>
{{else CTITLE=='타이틀' }}
<span class="icon icon_green_box">타이틀</span>
{{else}}
<span class="icon icon_red_box">항목미정</span>
{{/if}}
 \${TITLE}</td>
    	<td>\${USER_NAME}</td>
    	<td>
{{if CTITLE!='' }}
<span class="icon icon_file" name="spnIconFile">files</span>
{{/if}}
		</td>
    	<td><span name="viewDetail" lass="icon icon_Rarrow">></span></td>
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
					<h3 class="title">업무자료실</h3>
				</div>
				<div id="contents">
 					<div class="title_box">
						<h4 class="title">전체목록</h4>
					</div>
					<div class="tbl_box">
						<table id="list01" class="list_tbl01" summary="NO,고객명,주민등록번호,휴대폰번호,사전품의">
							<caption>조회</caption>
							<colgroup>
								<col style="width:8%;" />
								<col style="width:*" />
								<col style="width:20%;" />
								<col style="width:10%;" />
								<col style="width:5%;" />
							</colgroup>
							<thead>
								<tr>
									<th scope="col">NO</th>
									<th scope="col">제목</th>
									<th scope="col">작성자</th>
									<th scope="col">첨부파일</th>
									<th scope="col">&nbsp;</th>
								</tr>
							</thead>
							<tbody class="list">
							</tbody>
						</table>	
					</div>
								
<!--
 					<div class="btn_wrap">
						<button type="button" class="btn btn_normal btn_green">신규등록</button>
					<div>
-->
				</div>
            </div>	
        </div>
    </div>

</div> <!-- // layout -->
<%@include file="/inc/footer.jsp" %>