if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

var p_req_no = null;
var p_mode = null;
var wForm = null;
function onInit(argus) {
	p_req_no = argus.p_req_no;
	p_mode = p_req_no?"U":"I";
	wForm = $S("wForm");
	wForm.p_req_no.value = p_req_no?p_req_no:"0";
	wForm.p_mode.value = p_mode;
	init();
}

function init() {
	if  ( p_mode == 'U' ) {
		if ( p_req_no ) {
			call('JSON',"dms_biz/bd_request/get_detail",
				{s_req_no:p_req_no},
			    function(json) {
			        if ( json['return'] == '200' ) { // success   
			            //console.debug(json.insert_id);
			            //alert(json.message); // success
			            UI.bind(json.data,{
			            	wriet_date:function(el,v) {
			            		el.innerHTML = v.substring(0,4) + "-" + v.substring(4,6) + "-" + v.substring(6,8);
			            	},
			            	end_date:function(el,v) {
				            	el.innerHTML = v.substring(0,4) + "-" + v.substring(4,6) + "-" + v.substring(6,8);
				            }
			            });
			            // 안건 데이터 양식 파일
			        	$S("item_real_att_file").innerHTML = "<a href='#' onclick='return fDownloadItem(" + json.data_item.item_no + ");'>" + json.data_item.display_att_file + "</a>";
			        	
			            if ( json.data.real_att_file ) {
		            	    $S("real_att_file").innerHTML = "<a href='#' onclick='fDownload(" + json.data.req_no + ");'>" + json.data.display_att_file + "</a>"
		            	                                  + "<input type=checkbox name='delete_yn_att_file' value='Y'/>삭제" 
		            	    ;
			            } else {
			            	$S("real_att_file").innerHTML = "";
			            }
			            if      ( json.data.req_gubun == '1' ) wForm.req_gubun[0].checked = true; 
			            else if ( json.data.req_gubun == '2' ) wForm.req_gubun[1].checked = true; 
			        } else {
			            alert(json.message); // error
			        }
			    }
			);
		} else {
			alert("조회정보가 불충분 합니다.")			
		}
	} else {
		var wrietDate =  wForm.wriet_date.value ;
	    var endDate = wrietDate.toDate().calDate({day:7});
	    wForm.end_date.value = endDate.toDateString("yyyy-mm-dd");
	}
    return false;
}

function fDownloadItem(p_item_no) {
//	console.debug($S("list_data").offsetParent.tHead);
	call('FORM',"dms_biz/bd_item/download",
	{
//      	p_file:encodeURIComponent(fName+"." + fExt),
		p_type:"",
		p_item_no:p_item_no
	});
	return false;
}
function fDownload(p_req_no) {
//	console.debug($S("list_data").offsetParent.tHead);
	call('FORM',"dms_biz/bd_request/download",
			{
//      	p_file:encodeURIComponent(fName+"." + fExt),
		p_type:"",
		p_req_no:p_req_no
			});
	return false;
}

function fExec() {
    var f = $S('wForm');
        var exec = false;
        var invalidCb = {
//        	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }
        	item_no:function(){ Effect.twinkle($S("btn_item_open"));$S("btn_item_open").focus(); },
        	dept_id:function(){ Effect.twinkle($S("btn_dept_open"));$S("btn_dept_open").focus(); }
        };
        
        if ( Form.validate(f ,invalidCb) ) {
        	var title = !""?"저장하시겠습니까?":"저장하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('FORM.FILE',"dms_biz/bd_request/update",
                	{},
                    function(str) {
                        var json = eval("(" + str + ")" );    
                        if ( json['return'] == '200' ) { // success      
                            if ( json.mode == 'I' ) {
        	                    alert(json.message);
        	                	document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_list";        	                    
                            } else if ( json.mode == 'U' ) {
        	                    alert(json.message);
//                                onInit(SOFTMARGUMENT); 
        	                	document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_view&p_req_no=" + ( p_req_no?p_req_no:"" );
                            }
                        } else {
                            alert(json.message); // error
                        }
                    },f
                );
            }
        }
    return false;
}

function fRequest() {
    var exec = false;
    var invalidCb = {
//    	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }    
    };
	var title = !""?"요청하시겠습니까?":"요청하시겠습니까?";
    if ( confirm(title) ) {
        exec = true;
    }
    if ( exec ) { 
//            call('FORM.FILE',"bbs/write",
        call('JSON',"dms_biz/bd_request/request",
        	{
        		p_req_no:wForm.p_req_no.value
        	},
            function(json) {
//                    var json = eval("(" + str + ")" );    
                if ( json['return'] == '200' ) { // success      
            		if ( $S("calendarDiv") ) $S("calendarDiv").style.display = "none";
                    alert(json.message);
                	document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_list";
                } else if (json['return'] == '500') {
                    alert(json.message); // error
                }
            }
        );
    }
    return false;
}

function fDelete() {
	var exec = false;
	var invalidCb = {
//    	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }    
	};
	var title = !""?"삭제하시겠습니까?":"삭제하시겠습니까?";
	if ( confirm(title) ) {
		exec = true;
	}
	if ( exec ) { 
//            call('FORM.FILE',"bbs/write",
		call('JSON',"dms_biz/bd_request/delete",
				{
			p_mode:"D",
			p_req_no:wForm.p_req_no.value
				},
				function(json) {
//                    var json = eval("(" + str + ")" );    
					if ( json['return'] == '200' ) { // success      
						if ( $S("calendarDiv") ) $S("calendarDiv").style.display = "none";
						if ( json.mode == 'D' ) {
							alert(json.message);
							document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_list";
						}
					} else if (json['return'] == '500') {
						alert(json.message); // error
					}
				}
		);
	}
	return false;
}

function fList() {
//	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
	document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_list";
//	history.go(-2);
	return false;
}
