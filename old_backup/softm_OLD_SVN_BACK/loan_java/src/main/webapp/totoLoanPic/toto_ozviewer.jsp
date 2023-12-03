<%@ page language="java" import="oz.db.*,java.sql.*,sun.misc.*,java.io.*,java.net.URLDecoder" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, target-densitydpi=medium-dpi" />
<title>Test</title>

<script type="text/javascript" src="../toto/js/jquery.min.js"></script>
<script type="text/javascript" src="../toto/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="../toto/js/jquery-ui.js"></script>

<script src="oztotoframework.js"></script>
<!--script src="./js/main.js" charset="UTF-8"></script-->


<script language="javascript">

alert("<%=request.getParameter("loanreq_seq")%>");
//alert(OZTotoFramework.device.getUUID());
var ozviewer = new OZTotoFramework.OZViewer();
	$(document).ready(function() {

		ozviewer.addEventListener("OZUserEvent", function(event){
			alert("a");
//s			OZTotoFramework.util.alert("trigger");

			//2nd arg of _TriggerOCXUserEvnet
			//var bizFlag = event.param2;
			var bizFlag = "AAAA";
			OZTotoFramework.dispatchEvent("Search_ZipCode", { name: bizFlag });

			event.result="";
		}); 

//		var params = "connection.servlet=http://211.116.251.120/oz/server";
		var params = "connection.servlet=http://ods.charmloan.co.kr/oz70/server";		
		    params += "\n" + "connection.reportname=cBusinessCard01.ozr";
	     // params += "\n" + "connection.reportname=loanAgree.ozr";
			params += "\n" + "font.fontnames=font_dotum,font_gulim";
			params += "\n" + "font.font_dotum.url=res://NanumBarunGothic.ttf";
			params += "\n" + "font.font_dotum.name=나눔바른고딕";
			params += "\n" + "font.font_gulim.url=res://NanumBarunGothicBold.ttf";
			params += "\n" + "font.font_gulim.name=나눔바른고딕";
			params += "\n" + "connection.inputjson={'USER_NAME':'홍길동','USER_IDNO':'','CTAX_NO':'1245678903','N_HADDR':'서울특별시 가산디지털단지역','N_RADDR':'경기도 고양시 일산역','MOBILE_NO':'01012345678','MOBILE_AGENCY_CD':'KTU','MOBILE_CONNECTION':'01','PSLOAN_PERIOD':'05','LTEL_NO':'021234567','AFTER_WANT_AMT':'','INTER_PAY_DATE':'','LOAN_PERIOD':'','LOAN_RT':''}";
//			params += "\n" + "connection.inputjson={'USER_NAME':'홍길동'}";
/*
			font.fontnames=font_dotum,font_gulim
			font.font_dotum.url=res://NanumBarunGothic.ttf
			font.font_dotum.name=나눔바른고딕
			font.font_gulim.url=res://NanumBarunGothicBold.ttf
			font.font_gulim.name=나눔바른고딕
 */
			
//		var params = "connection.servlet=http://ods.charmloan.co.kr/oz70/server";
//			params += "\n" + "connection.reportname=sample.ozr";

		ozviewer.createViewer("bottom", params, "\n");
		ozviewer.setVisible(true);
	});

	function closeReport(){
		ozviewer.dispose();
        ozviewer.setVisible(false);
		OZTotoFramework.storage.removeCategory(category);
	}

	var eventHandler = function(event){
//		OZTotoFramework.util.alert("evnt:::"+event.flag);
		ozviewer.document.setGlobal("zip_call",  event.flag);

/*
		ozviewer.document.setGlobal("zipcode_R",  event.roadZipcode);
		ozviewer.document.setGlobal("address_R",  event.roadAddress);
		ozviewer.document.setGlobal("zipcode_J",  event.jibunZipcode);
		ozviewer.document.setGlobal("address_J",  event.jibunAddress);
*/
		ozviewer.getInformation("INPUT_TRIGGER_CLICK");

	};
/*
	var eventHandler = function(event){
		OZTotoFramework.util.alert("evnt1:::"+event.flag);
            setTimeout(function(event) {
				OZTotoFramework.util.alert("evnt2:::"+event.flag);
		ozviewer.document.setGlobal("zip_call",  event.flag);
		ozviewer.document.setGlobal("zipcode_R",  event.roadZipcode);
		ozviewer.document.setGlobal("address_R",  event.roadAddress);
		ozviewer.document.setGlobal("zipcode_J",  event.jibunZipcode);
		ozviewer.document.setGlobal("address_J",  event.jibunAddress);

		ozviewer.getInformation("INPUT_TRIGGER_CLICK");
            }, 1000);

	};
*/

	OZTotoFramework.addEventListener("addrResult", eventHandler);
var eventHandler = function(event){
//	OZTotoFramework.util.alert("evnt:::"+event.flag);
	ozviewer.document.setGlobal("zip_call",  event.flag);

/*
	ozviewer.document.setGlobal("zipcode_R",  event.roadZipcode);
	ozviewer.document.setGlobal("address_R",  event.roadAddress);
	ozviewer.document.setGlobal("zipcode_J",  event.jibunZipcode);
	ozviewer.document.setGlobal("address_J",  event.jibunAddress);
*/
	ozviewer.getInformation("INPUT_TRIGGER_CLICK");

};

	
function fnValid() {
	 var check = ozviewer.GetInformation("INPUT_CHECK_VALIDITY");
	 alert(check);
}

function fnClose() {
	if(confirm("닫으시겠습니까?")) {
		ozviewer.Script("close");
	}
}

function fnNext() {
	var params = "connection.servlet=http://ods.charmloan.co.kr/oz70/server";		
   params += "\n" + "connection.reportname=loanApply.ozr";
// params += "\n" + "connection.reportname=loanAgree.ozr";
	params += "\n" + "font.fontnames=font_dotum,font_gulim";
	params += "\n" + "font.font_dotum.url=res://NanumBarunGothic.ttf";
	params += "\n" + "font.font_dotum.name=나눔바른고딕";
	params += "\n" + "font.font_gulim.url=res://NanumBarunGothicBold.ttf";
	params += "\n" + "font.font_gulim.name=나눔바른고딕";
	params += "\n" + "connection.inputjson={'USER_NAME':'홍길동','USER_IDNO':'','CTAX_NO':'1245678903','N_HADDR':'서울특별시 가산디지털단지역','N_RADDR':'경기도 고양시 일산역','MOBILE_NO':'01012345678','MOBILE_AGENCY_CD':'KTU','MOBILE_CONNECTION':'01','PSLOAN_PERIOD':'05','LTEL_NO':'021234567','AFTER_WANT_AMT':'','INTER_PAY_DATE':'','LOAN_PERIOD':'','LOAN_RT':''}";

	ozviewer.CreateReportEx(params, ";");

	//ozviewer.createViewer("bottom", params, "\n");
	//ozviewer.setVisible(true);
}

function closeViewer(){ 
//	  ozviewer.dispose();

	  ozviewer.getInformation("INPUT_JSON", function(jsonV){
//	   OZTotoFramework.util.alert("jsonV ::"+jsonV);
		// jsonV
		  OZTotoFramework.dispatchEvent("CloseViewer", { data : "{\"gubun\":\"LoanPic\",\"result\":\"complete\"}" });
	  });
	  
//	OZTotoFramework.dispatchEvent("CloseViewer", { jsonD : "tttest" });
	 }
	
</script>

</head>
<body onload="noBack();" onpageshow="if(event.persisted) noBack();" onunload="" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<span>
	<button onclick="if(this.ozdisabled == 'true') {return;} closeViewer();">closeViewer</button>
	<button onclick="if(this.ozdisabled == 'true') {return;} closeReport();">close</button>
	<button onclick="if(this.ozdisabled == 'true') {return;} fnValid();">fnValid</button>
	<button onclick="if(this.ozdisabled == 'true') {return;} fnClose();">fnClose</button>
	<button onclick="if(this.ozdisabled == 'true') {return;} fnNext();">fnNext</button>
</span>

</body>
</html>