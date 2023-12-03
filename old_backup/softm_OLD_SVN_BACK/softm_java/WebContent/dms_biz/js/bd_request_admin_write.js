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
			call('JSON',"dms_biz/bd_request/get",
				{s_req_no:p_req_no},
			    function(json) {
			        if ( json['return'] == '200' ) { // success   
			            //console.debug(json.insert_id);
			            //alert(json.message); // success
			            Form.bind(json.data,$S("wForm"));
		        		var wDate = json.data.wriet_date ;
		        		var eDate = json.data.end_date   ;
		                wForm.wriet_date.value = wDate.substring(0,4) + "-" + wDate.substring(4,6) + "-" + wDate.substring(6,8);
		                wForm.end_date.value   = eDate.substring(0,4) + "-" + eDate.substring(4,6) + "-" + eDate.substring(6,8);			        	
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

function fExec() {
    var f = $S('wForm');
        var exec = false;
        var invalidCb = {
//        	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }
        	item_no:function(){ Effect.twinkle($S("btn_item_open"));$S("btn_item_open").focus(); },
        	dept_id:function(){ Effect.twinkle($S("btn_dept_open"));$S("btn_dept_open").focus(); }
        };
        
        if ( Form.validate(f ,invalidCb) ) {
        	var title = !""?"저장하시겠습니까?":"수정하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('FORM.FILE',"dms_biz/bd_request/write",
                	{},
                    function(str) {
                        var json = eval("(" + str + ")" );    
                        if ( json['return'] == '200' ) { // success      
                            if ( json.mode == 'I' ) {
        	                    alert(json.message);
        	                	document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_list";        	                    
                            } else if ( json.mode == 'U' ) {
        	                    alert(json.message);
                                onInit(SOFTMARGUMENT);    	                    
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
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
	history.go(-1);
	return false;
}

function fDownload(p_item_no) {
//	console.debug($S("list_data").offsetParent.tHead);
	call('FORM',"dms_biz/bd_item/download",
			{
//      	p_file:encodeURIComponent(fName+"." + fExt),
		p_type:"",
		p_item_no:p_item_no
			});
	return false;
}

function fOpenApprovalRequest() {
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_approval_request', 550, 368,'pop_approval_request',{scrollbars:'yes'}).focus();
	return false;
}

function fOpenCostCenter() {
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_cost_center', 550, 368,'pop_cost_center',{scrollbars:'yes'}).focus();
	return false;
}

function fOpenCostIzCode() {
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_cost_iz_code', 550, 368,'pop_cost_iz_code',{scrollbars:'yes'}).focus();
	return false;
} 

function fOpenReferenceList() {
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_reference_list', 550, 368,'pop_reference_list',{scrollbars:'yes'}).focus();
	return false;
} 


function fChoiceHwp(e,o) {
		document.body.onmousedown = function(ee) {
		    var o = window.event?window.event.srcElement:ee.target;
//		    alert( o.name == "rdo_hwp_type");
			if (o.name == "rdo_hwp_type" || (  o.parentNode && o.parentNode.id == "file_choice" ) ) {
			} else {
				$S("file_choice").style.display = "none";
			}
		};
	$S("file_choice").style.top  = Util.DOM.getY(o) + 10;	
	$S("file_choice").style.left = Util.DOM.getX(o) + 60;
	$S("file_choice").style.display = "block";

	return false;
}

function fOpenHwp(e,gubun) {
    var e = window.event?window.event:e;	
	if( gubun == "1" ) { // 보고 안건 서식
		wForm.rdo_hwp_type[0].checked = true;
	} else if( gubun == "2" ) { // 전회 이사회 부의안건 서식
		wForm.rdo_hwp_type[1].checked = true;		
	}
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_hwp&p_gubun='+gubun, 550, 368,'pop_hwp',{scrollbars:'yes',fullscreen:'yes'}).focus();	
}

function fOpenItem() {
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_item', 550, 368,'pop_item',{scrollbars:'yes'}).focus();
	return false;
} 

function setItem(itemNo,itemName) {
	wForm.item_no.value = itemNo;
}

function fOpenManagerDept() {
	UI.openWindow('/popup.jsp?p_prg=dms_popup/pop_manager_dept', 550, 368,'pop_manager_dept',{scrollbars:'yes'}).focus();
	return false;
} 

function setDept(deptId,deptName) {
	wForm.dept_id.value = deptId;
}

