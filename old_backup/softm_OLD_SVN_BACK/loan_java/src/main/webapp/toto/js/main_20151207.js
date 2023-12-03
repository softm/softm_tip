// 모바일인지 , PC인지 구별하기 위한 js
var isMobile = {
    Android: function() {
        return /Android/i.test(navigator.userAgent);
    },
    BlackBerry: function() {
        return /BlackBerry/i.test(navigator.userAgent);
    },
    iOS: function() {
        return /iPhone|iPad|iPod/i.test(navigator.userAgent);
    },
    Windows: function() {
        return /IEMobile/i.test(navigator.userAgent);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
    }
};

var param = '';
var schParams = '';	//리스트 검색조건

var tempFile = '';	//기존계약서 파일 유무 체크

var G_DS_AGEN = '';
var G_CONTRACT_CONFIRM_MSG = "";

var contract_type = '';

$(document).ready(function() {
	
	//***** 화면 공통 start *****/
	//영업담당,오픈담당
	param = 'ozds.enable=true&ozds.format=json&ozds.odifullpath=/CLEANTOPIA_SALES_USER.odi';
	ajax_load(param, '/cleantopia/server', fn_type_sale);
	
	if($("#sch_sn_sales").val() != ""){
		$("#sel_sn_sales").val($("#sch_sn_sales").val());
	}
	if($("#sch_sn_open").val() != ""){
		$("#sel_sn_open").val($("#sch_sn_open").val());
	}
	//***** 화면 공통 end *****/
	
	if ($("form").attr("name") == "frm_01"){
		//진행상태
		param = 'ozds.enable=true&ozds.format=json&ozds.odifullpath=/CLEANTOPIA_CHAIN_STATE.odi';
		param += '&sch_group_id=CD02';
		ajax_load(param, '/cleantopia/server', fn_chain_state);
		if($("#sch_tp_jinh").val() != ""){
			$("#sel_tp_jinh").val($("#sch_tp_jinh").val());
		}
		
		fn_store_list_data();
	}
	
	if ($("form").attr("name") == "frm_02"){
		param = 'ozds.enable=true&ozds.format=json&ozds.odifullpath=/CLEANTOPIA_CHAIN_STATE.odi';
		param += '&sch_group_id=CD05';
		ajax_load(param, '/cleantopia/server', fn_chain_state);
		
		if($("#sch_tp_jinh").val() != ""){
			$("#sel_tp_jinh").val($("#sch_tp_jinh").val());
		}
		fn_contract_list_data();
	}
	
	if ($("form").attr("name") == "frm_03"){
		param = 'ozds.enable=true&ozds.format=json&ozds.odifullpath=/CLEANTOPIA_CHAIN_STATE.odi';
		param += '&sch_group_id=CD05';
		ajax_load(param, '/cleantopia/server', fn_chain_state);
		
		if($("#sch_tp_jinh").val() != ""){
			$("#sel_tp_jinh").val($("#sch_tp_jinh").val());
		}
		$("#sch_date").mask("9999-99-99",{placeholder:"____-__-__"});		
	}
	
	$("#searchlist").click(function(){
		fn_store_list_data('S');
	});
	
	$("#searchlist_contract").click(function(){
		fn_contract_list_data('S');
	});
	
	$("#showreport_statisics").click(function(){
		var gubunFlag = document.getElementsByName("sch_gubun");
		var gubunValue = "";
		for (var i=0; i<gubunFlag.length; i++){
			if(gubunFlag[i].checked == true){
				gubunValue = gubunFlag[i].value;
			}
		}
		
		var sch_ds_agen = $("#sch_ds_agen").val();
		var sch_date 	= $("#sch_date").val();
		var sch_sn_sales= $("#sch_sn_sales").val();
		var sch_sn_open = $("#sch_sn_open").val();
		var sch_tp_jinh = $("#sch_tp_jinh").val();
		
		param = 'sch_gubun='+gubunValue;					// 구분:전체,신규,기존
		param += '&sch_ds_agen='+sch_ds_agen;
		param += '&sch_dt_frco='+sch_date;
		param += '&sch_sn_sales='+sch_sn_sales;
		param += '&sch_sn_open='+sch_sn_open;
		param += '&sch_tp_jinh='+sch_tp_jinh;
		
		param = param.replace(/=/gi,'":"');
		param = param.replace(/&/gi,'","');
		param = '"'+param+'"';
		
		var arrayParams = JSON.parse("{" + param + "}");

		post_to_url('./cleantopia_statisics_list.jsp', arrayParams);
	});
	
	$("#sch_dt_frco").datepicker({ 
		showButtonPanel: true, 
		currentText: '오늘', 
		closeText: '닫기', 
		dateFormat: 'yy-mm-dd',
		monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		dayNames: ['일','월','화','수','목','금','토'],
	    dayNamesShort: ['일','월','화','수','목','금','토'],
	    dayNamesMin: ['일','월','화','수','목','금','토'],
	    showMonthAfterYear: true,
	    yearSuffix: '년',
		changeMonth: true, 
	    changeYear: true });
	
	$("#sch_dt_frco").datepicker('setDate', '');
	
	//영업담당
	$("#sel_sn_sales").change(function(){
		$("#sch_sn_sales").val($("#sel_sn_sales option:selected").val());
	});
	//오픈담당
	$("#sel_sn_open").change(function(){
		$("#sch_sn_open").val($("#sel_sn_open option:selected").val());
	});
	//진행상태
	$("#sel_tp_jinh").change(function(){
		$("#sch_tp_jinh").val($("#sel_tp_jinh option:selected").val());
	});
	//logout
	$("#userLogout").click(function(){
		location.href="./cleantopia_logout.jsp";
	});
	
	

});

function ajax_load(param, url, callback){		
	$.ajax({
		type	: 'POST',
		url		: url,  
		data 	: param,
		async	: false,
		success : callback,
		error	: function(xhr, message, errorThrown){
        	var msg = xhr.status + " / " + message + " / " + errorThrown;
        	alert(msg);
        	$("#jsonData").html(msg + xhr.responseText);
		}
	});
}

function fn_type_sale(data){
	$('#sel_sn_sales').empty();
	$('#sel_sn_sales').append($('<option>', { 
    	value: "99",
        text : "전체" 
    }));	
	$(data.SQL_SALES_USER).each(function(index, item) {
		$('#sel_sn_sales').append($('<option>', { 
			value: item.CD_SANO,
			text : item.DS_NAME,
			selectedIndex : 0
		}));
	});
	
	$('#sel_sn_open').empty();
	$('#sel_sn_open').append($('<option>', { 
    	value: "99",
        text : "전체" 
    }));	
	$(data.SQL_SALES_USER).each(function(index, item) {
		$('#sel_sn_open').append($('<option>', { 
			value: item.CD_SANO,
			text : item.DS_NAME,
			selectedIndex : 0
		}));
	});
}

function fn_chain_state(data){
	$('#sel_tp_jinh').empty();
	$('#sel_tp_jinh').append($('<option>', { 
    	value: "99",
        text : "전체" 
    }));	
	$(data.SQL_CHAIN_STATE).each(function(index, item) {
		$('#sel_tp_jinh').append($('<option>', { 
			value: item.CODE_ID,
			text : item.NAME,
			selected: 9
		}));
	});
}

function fn_store_list_data(arg){
	if(arg == "S") $('#pageNum').val("1");
	var num = $('#pageNum').val();
	
	param = 'ozds.enable=true&ozds.format=json&ozds.odifullpath=/CLEANTOPIA_STOREINFOLIST.odi';
	param += '&sch_ds_agen='+$('#sch_ds_agen').val();	// 대리점명
	param += '&sch_dt_frco='+$('#sch_dt_frco').val();	// 현재매장계약일
	param += '&sch_sn_sales='+$('#sch_sn_sales').val();	// 영업담당
	param += '&sch_sn_open='+$('#sch_sn_open').val();	// 오픈담당
	param += '&sch_tp_jinh='+$('#sch_tp_jinh').val();	// 진행상태
	param += '&sRowNum='+(num-1)*10;
	param += '&mRowCount=10';

	schParams = param;
	ajax_load(param, '/cleantopia/server', fn_store_list);
}

//1.리스트 띄우기(PC, 모바일, 가맹점조회) ========================================================
function fn_store_list(data){

	var tr_color = "";
	var id = "#store_list";
	
	var tempSelectBoxString = settingSelectBoxData(data);
	var tempSelectBoxString2 = settingSelectBoxData2(data);
	
	$(id).empty();
	$(data.SQL_STOREINFOLIST).each(function(index, item) {
		if(index%2 == 0){
    		tr_color = "class='trclass'";
    	}else{
    		tr_color = "class='trclass2'";
    	}
		var tr_last = id + " tr:last";
		
		$(id).append("<tr style='text-align: center; height:35px;'" + tr_color +"></tr>");
		$(tr_last).append("<td>"+(index+1)+"</td>");			// 번호
		$(tr_last).append("<td>"+item.CD_AGEN+"</td>");			// 가맹점코드
		$(tr_last).append("<td><a href='javascript:void(0);' onclick='javascript:showDetail(\""+item.CD_AGEN+"\");'>"+item.DS_AGEN+"</a></td>");	// 가맹점명
		$(tr_last).append("<td>"+item.TP_JINH_NAME+"</td>");	// 진행구분
		$(tr_last).append("<td>"+item.CD_TYPE_NAME+"</td>");	// 매장형태
		$(tr_last).append("<td>"+item.TP_GUBN_NAME+"</td>");	// 매장구분
		
		$(tr_last).append("<td style='text-align: left; padding-left: 5px;'>"+item.DS_ADDR1+"</td>");		// 지역구분
		$(tr_last).append("<td>"+item.DS_PRES+"</td>");			// 대표자
		$(tr_last).append("<td>"+item.SN_OPEN_NAME+"</td>");	// 오픈담당
		$(tr_last).append("<td>"+item.SN_SALES_NAME+"</td>");	// 영업담당
		$(tr_last).append("<td>"+item.DT_FRCO+"</td>");			// 현재매장계약일
		$(tr_last).append("<td><select id='sel_ct_type_"+index+"'>"+tempSelectBoxString+"</select></td>");
		$(tr_last).append("<td><select id='sel_doc_type_"+index+"'>"+tempSelectBoxString2+"</select></td>");
		$(tr_last).append("<td><input type='button' id='documents' value='계약서' onclick='fn_contract_show(\""+item.CD_AGEN+"\",\""+item.DS_AGEN+"\",\""+item.CD_TYPE_NAME+"\",this);'></td>");
	});
	
	var totalCnt = "0";
	$(data.SQL_TOTALCNT).each(function(index, item) {
		totalCnt = item.TOTALCNT;
	});
	
	var totalPage = Math.floor(totalCnt/10);
	if((totalCnt%10)>0){
		totalPage += 1;
	}
	if(totalPage <= 0) totalPage = "1";
	
	$('#page-selection').bootpag({
		total: totalPage,
		page: $('#pageNum').val(),
		maxVisible: 10
	});
}

function settingSelectBoxData(data){
	var tempStr = "";
	$(data.SQL_CONTRACT_TYPE).each(function(index, item) {
		tempStr += "<option value='"+item.CODE_ID+"'>"+item.NAME+"</option>";
	});
	return tempStr;
}

function settingSelectBoxData2(data){
	var tempStr = "";
	$(data.SQL_DOC_TYPE).each(function(index, item) {
		tempStr += "<option value='"+item.CODE_ID+"'>"+item.NAME+"</option>";
	});
	return tempStr;
}

function showDetail(sch_cd_agen){
	location.href="./cleantopia_store_detail.jsp?sch_cd_agen="+sch_cd_agen;
}

function fn_store_detail(data){
	$(data.SQL_STOREINFODETAIL).each(function(index, item){
        $('#lab_CD_AGEN').html(item.CD_AGEN);	// 대리점코드
        $("#lab_DS_AGEN").html(item.DS_AGEN);	// 대리점명
       
        $('#lab_DS_PRES').html(item.DS_PRES);	// 대표자
        $("#lab_DS_ADDR").html(item.DS_ADDR1);	// 주소
        
        $('#lab_DS_TENO').html(item.DS_TENO);	// 전화번호
        $("#lab_DS_HANP").html(item.DS_HANP);	// 휴대폰번호
        
        $('#lab_CD_TYPE_NAME').html(item.CD_TYPE_NAME);	// 매장형태
        $("#lab_TP_GUBN_NAME").html(item.TP_GUBN_NAME);	// 매장구분
        $('#lab_TP_JINH_NAME').html(item.TP_JINH_NAME);	// 진행상태
        
        $("#lab_DT_SIJK").html(item.DT_SIJK);	// 최초영업개시일
        $('#lab_DT_FRCO').html(item.DT_FRCO);	// 현재매장계약일
        $("#lab_DT_OPEN").html(item.DT_OPEN);	// 현재매장영업개시일
        
        $("#lab_SN_OPEN_NAME").html(item.SN_OPEN_NAME);		// 오픈담당
        $("#lab_SN_SALES_NAME").html(item.SN_SALES_NAME);	// 영업담당
	});
}

function fn_contract_show(cd_agen, ds_agen, cd_type_name, btn){
	
	var rowIdx = btn.parentElement.parentElement.rowIndex;
	var compIdx = rowIdx - 3;	//title row 3
	var compId = "";
	
	G_DS_AGEN = ds_agen;	//fn_temp_check() 메세지 에서 사용하기 위해 전역번수로 선언
	
	//콤보박스로 넘긴 값을 type으로 한다.
	//계약구분
	compId = "#sel_ct_type_"+compIdx + " option:selected";
	var ct_type_name = $(compId).text();
	//대리점형태
	compId = "#sel_doc_type_"+compIdx + " option:selected";
	var doc_type_name = $(compId).text();
	
	G_CONTRACT_CONFIRM_MSG = "아래 정보로 계약서 작성을 하시겠습니까?";
	G_CONTRACT_CONFIRM_MSG += "\n 매장명 : ["+G_DS_AGEN+"]";
	G_CONTRACT_CONFIRM_MSG += "\n 매장형태 : ["+cd_type_name+"]"; 
	G_CONTRACT_CONFIRM_MSG += "\n 계약구분 : ["+ct_type_name+"]"; 
	G_CONTRACT_CONFIRM_MSG += "\n 계약형태 : ["+doc_type_name+"]"; 
	
	if(isMobile.any()) {
		//alert("2.isMobile");
		
		/*OZTotoFramework.addEventListener("nativeToJS_btnClick_Confirm", function(event){
			fn_contract_info(cd_agen, btn);
		});
		OZTotoFramework.dispatchEvent("JSTONative_btnClick_Confirm", { title: "cleantopia", msg : G_CONTRACT_CONFIRM_MSG});
		OZTotoFramework.removeEventListener("nativeToJS_btnClick_Confirm", function(event){});
		*/
		
		if (confirm(G_CONTRACT_CONFIRM_MSG) == true){
			fn_contract_info(cd_agen, btn);
		}else{
			return;
		}
	}else{
		if (confirm(G_CONTRACT_CONFIRM_MSG) == true){
			fn_contract_info(cd_agen, btn);
		}else{
			return;
		}
	}
}

function fn_contract_info(cd_agen, btn){
	
	var rowIdx = btn.parentElement.parentElement.rowIndex;
	var compIdx = rowIdx - 3;	//title row 3
	var compId = "";
	var report_type = "";
	
	//계약구분
	compId = "#sel_ct_type_"+compIdx + " option:selected";
	contract_type = $(compId).val();
	//대리점형태
	compId = "#sel_doc_type_"+compIdx + " option:selected";
	doc_type = $(compId).val();
	
	param = 'ozds.enable=true&ozds.format=json&ozds.odifullpath=/CLEANTOPIA_OZDLIST.odi&sch_cd_agen='+cd_agen;
	ajax_load(param, '/cleantopia/server', fn_temp_check);
	
	if (tempFile == "nothing"){
		/*if(contract_type == "1" || contract_type == "2")	//계약구분 1:신규, 2:양도양수
			report_type = "R";
		else												//계약구분 3:재계약, 4:명의변경
			report_type = "D";*/
		
		report_type = "R";
		// 대리점형태
		compId = "#sel_doc_type_"+compIdx + " option:selected";
		var doc_type = $(compId).val();
		
		param = $('#frm_01').serialize();
		param += '&reportType='+report_type;
		param += '&cd_agen='+cd_agen;
		param += '&ct_type='+contract_type;
		param += '&doc_type='+doc_type;
		param += '&ozd_path=';
		param += '&contract_id=';
		param += '&oz_chain_state=';
		
		param = param.replace(/=/gi,'":"');
		param = param.replace(/&/gi,'","');
		param = '"'+param+'"';
		
		var arrayParams = JSON.parse("{" + param + "}");

		post_to_url('./cleantopia_ozviewer.jsp', arrayParams);
	}
}

//가맹점조회-계약서 버튼 클릭시 체크
//계약구분-신규 일 경우 임시저장된 계약서가 있는지 체크 (TB_CONTRACT)
//임시저장된 계약건이 있을 경우 메세지 보여줌
//임시저장된 계약건이 없을 경우 OZR 띄움
function fn_temp_check(data){	//임시저장 체크
	//alert("4.call fn_temp_check");
	
	var ozdPath = "";
	var ozChainState = "";
	
	$(data.SQL_OZDLIST).each(function(index, item) {
		//ozdPath = item.OZD_FILE_PATH;
		ozChainState = item.OZ_CHAIN_STATE;
	});
	
	if(contract_type == "1" && ozChainState == "2"){
		G_CONTRACT_CONFIRM_MSG = "'"+G_DS_AGEN+"'점은 신규계약이 완료된 상태입니다. 계약상태 변경 후 진행해 주십시오."; 
		if(isMobile.any()) {
			/*OZTotoFramework.addEventListener("nativeToJS_btnClick_Alert", function(event){});
			OZTotoFramework.dispatchEvent("JSTONative_btnClick_Alert", { title: "cleantopia", msg : G_CONTRACT_CONFIRM_MSG});
			OZTotoFramework.removeEventListener("nativeToJS_btnClick_Alert", function(event){});*/
			alert(G_CONTRACT_CONFIRM_MSG);
		}else{
			alert(G_CONTRACT_CONFIRM_MSG);
		}
	}else{
		
		if(ozChainState == "0"){
			G_CONTRACT_CONFIRM_MSG = "'"+G_DS_AGEN+"'점은 '임시저장' 상태의 계약이 이미 존재하므로 계약현황조회 화면에서 계약서 작성을 진행해 주십시오."; 
			if(isMobile.any()) {
				/*OZTotoFramework.addEventListener("nativeToJS_btnClick_Alert", function(event){});
				OZTotoFramework.dispatchEvent("JSTONative_btnClick_Alert", { title: "cleantopia", msg : G_CONTRACT_CONFIRM_MSG});
				OZTotoFramework.removeEventListener("nativeToJS_btnClick_Alert", function(event){});*/
				alert(G_CONTRACT_CONFIRM_MSG);
			}else{
				alert(G_CONTRACT_CONFIRM_MSG);
			}
			tempFile = "temp";
		}else if(ozChainState == "1"){
			//alert("기존 계약 데이터 있음");
			tempFile = "success";
		}else{
			//alert("임시저장 데이터 없음");
			tempFile = "nothing";
		}
		
		if(tempFile == "success"){
			G_CONTRACT_CONFIRM_MSG = "'"+G_DS_AGEN+"'점은 '승인대기' 상태의 계약이 이미 존재하므로 계약을 할 수 없습니다.";
			if(isMobile.any()) {
				/*OZTotoFramework.addEventListener("nativeToJS_btnClick_Alert", function(event){});
				OZTotoFramework.dispatchEvent("JSTONative_btnClick_Alert", { title: "cleantopia", msg : G_CONTRACT_CONFIRM_MSG});
				OZTotoFramework.removeEventListener("nativeToJS_btnClick_Alert", function(event){});*/
				alert(G_CONTRACT_CONFIRM_MSG);
			}else{
				alert(G_CONTRACT_CONFIRM_MSG);
			}
		}
	}	
}

function fn_contract_list_data(){
	var gubunFlag = document.getElementsByName("gubun");
	var gubunValue = "";
	for (var i=0; i<gubunFlag.length; i++){
		if(gubunFlag[i].checked == true){
			gubunValue = gubunFlag[i].value;
		}
	}
	
	var num = $('#pageNum').val();
	
	param = 'ozds.enable=true&ozds.format=json&ozds.odifullpath=/CLEANTOPIA_CONTRACTINFOLIST.odi';
	param += '&sch_gubun='+gubunValue;					// 구분:전체,신규,기존
	param += '&sch_ds_agen='+$('#sch_ds_agen').val();	// 대리점명
	param += '&sch_dt_frco='+$('#sch_dt_frco').val();	// 현재매장계약일
	param += '&sch_sn_sales='+$('#sch_sn_sales').val();	// 영업담당
	param += '&sch_sn_open='+$('#sch_sn_open').val();	// 오픈담당
	param += '&sch_tp_jinh='+$('#sch_tp_jinh').val();	// 진행상태
	param += '&sRowNum='+(num-1)*10;
	param += '&mRowCount=10';
	
	ajax_load(param, '/cleantopia/server', fn_contract_list);
}

//2.리스트 띄우기(PC, 모바일, 계약현황조회) ========================================================
function fn_contract_list(data){

	var tr_color = "";
	var id = "#contract_list";
	
	$(id).empty();
	$(data.SQL_CONTRACTINFOLIST).each(function(index, item) {
		if(index%2 == 0){
    		tr_color = "class='trclass'";
    	}else{
    		tr_color = "class='trclass2'";
    	}
		var tr_last = id + " tr:last";
		
		$(id).append("<tr style='text-align: center; height:35px;'" + tr_color +"></tr>");
		$(tr_last).append("<td>"+(index+1)+"</td>");			// 번호
		$(tr_last).append("<td>"+item.CD_AGEN+"</td>");			// 대리점코드
		$(tr_last).append("<td><a href='javascript:void(0);' onclick='javascript:showDetail2(\""+item.CONTRACT_ID+"\");'>"+item.DS_AGEN+"</a></td>");	// 가맹점명
		$(tr_last).append("<td>"+item.TP_JINH_NAME+"</td>");	// 진행구분
		$(tr_last).append("<td>"+item.CHAIN_TYPE_NAME+"</td>");	// 매장형태
		$(tr_last).append("<td>"+item.TP_GUBN_NAME+"</td>");	// 매장구분
		
		$(tr_last).append("<td>"+item.CONTRACT_TYPE_NAME+"</td>");	// 계약구분
		$(tr_last).append("<td style='text-align: left; padding-left: 5px;'>"+item.DS_ADDR1+"</td>");		// 지역구분
		$(tr_last).append("<td>"+item.DS_PRES+"</td>");			// 대표자
		$(tr_last).append("<td>"+item.SN_OPEN_NAME+"</td>");	// 오픈담당
		$(tr_last).append("<td>"+item.SN_WRITE_NAME+"</td>");	// 계약서작성자
		$(tr_last).append("<td>"+item.DT_FRCO+"</td>");			// 현재매장계약일
		$(tr_last).append("<td>"+item.OZ_CHAIN_STATE_NAME+"</td>");			// OZ계약진행상태
		$(tr_last).append("<td><input type='button' id='documents' value='계약서보기' onclick='fn_contract_ozd_show(\""+item.OZD_FILE_PATH+"\",\""+item.CONTRACT_ID+"\",\""+item.OZ_CHAIN_STATE+"\",\""+item.CD_AGEN+"\",\""+item.CONTRACT_TYPE+"\",\""+item.DOC_TYPE+"\");'></td>");
	});
	
	var totalCnt = "0";
	$(data.SQL_TOTALCNT).each(function(index, item) {
		totalCnt = item.TOTALCNT;
	});
	
	var totalPage = Math.floor(totalCnt/10);
	if((totalCnt%10)>0){
		totalPage += 1;
	}
	if(totalPage <= 0) totalPage = "1";
	
	$('#page-selection').bootpag({
		total: totalPage,
		page: $('#pageNum').val(),
		maxVisible: 10
	});
}

function showDetail2(sch_contract_id){
	location.href="./cleantopia_contract_detail.jsp?sch_contract_id="+sch_contract_id;
}
function fn_contract_detail(data){
	$(data.SQL_CONTRACTINFODETAIL).each(function(index, item){
        $('#lab_CD_AGEN').html(item.CD_AGEN);	// 대리점코드
        $("#lab_DS_AGEN").html(item.DS_AGEN);	// 대리점명
       
        $('#lab_DS_PRES').html(item.DS_PRES);	// 대표자
        $("#lab_DS_ADDR").html(item.DS_ADDR1);	// 주소
        
        $('#lab_DS_TENO').html(item.DS_TENO);	// 전화번호
        $("#lab_DS_HANP").html(item.DS_HANP);	// 휴대폰번호
        
        $('#lab_CD_TYPE_NAME').html(item.CD_TYPE_NAME);	// 매장형태
        $("#lab_TP_GUBN_NAME").html(item.TP_GUBN_NAME);	// 대리점구분
        $('#lab_TP_JINH_NAME').html(item.TP_JINH_NAME);	// 진행상태
        $('#lab_CONTRACT_TYPE').html(item.CD_CONTRACT_TYPE_NAME);	// 계약구분
        
        $("#lab_DT_SIJK").html(item.DT_SIJK);	// 최초영업개시일
        $('#lab_DT_FRCO').html(item.DT_FRCO);	// 현재매장계약일
        $("#lab_DT_OPEN").html(item.DT_OPEN);	// 현재매장영업개시일
        
        $("#lab_SN_OPEN_NAME").html(item.SN_OPEN_NAME);		// 오픈담당
        $("#lab_SN_SALES_NAME").html(item.SN_SALES_NAME);	// 영업담당
	});
}

//계약서 OZD
function fn_contract_ozd_show(ozd_path, contract_id, oz_chain_state, cd_agen, ct_type, doc_type){
	
	param = $('#frm_02').serialize();
	param += '&reportType=D';
	param += '&cd_agen='+cd_agen;
	param += '&ct_type='+ct_type;
	param += '&doc_type='+doc_type;
	param += '&ozd_path='+ozd_path;
	param += '&contract_id='+contract_id;
	param += '&oz_chain_state='+oz_chain_state;
	
	param = param.replace(/=/gi,'":"');
	param = param.replace(/&/gi,'","');
	param = '"'+param+'"';
	
	var arrayParams = JSON.parse("{" + param + "}");

	post_to_url('./cleantopia_ozviewer.jsp', arrayParams);
}

function post_to_url(path, params, method){
	method = method || "post";  //method 부분은 입력안하면 자동으로 post가 된다.

    var form = document.createElement("form");
    form.setAttribute("method", method);
    form.setAttribute("action", path);


    for(var key in params) {
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", key);
        hiddenField.setAttribute("value", params[key]);
        form.appendChild(hiddenField);
    }

    document.body.appendChild(form);
    form.submit();
}