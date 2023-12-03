var p_item_no = null;
var p_schedule_no = null;
var p_mode = null;
var wForm = null;
function onInit(argus) {
//	console.debug(argus);
//    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
	p_item_no = argus.p_item_no;
	p_schedule_no = argus.p_schedule_no;
	p_mode = argus.p_mode;
	wForm = $S("wForm");
	wForm.p_item_no.value = p_item_no?p_item_no:"0";
	wForm.p_mode.value = p_mode?p_mode:"I";
	wForm.p_schedule_no.value = p_schedule_no;
	fAmtChange();	
	init();
}

function init() {
	if  ( p_mode == 'U' ) {
		if ( p_item_no ) {
			call('JSON',"dms_biz/bd_item/get_update",
				{s_item_no:p_item_no},
			    function(json) {
			        if ( json['return'] == '200' ) { // success   
			            //console.debug(json.insert_id);
			            //alert(json.message); // success
			        	var s_code = "";
			     	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
			     	        var itemDevision = new Common.createArrangeElement("select","item_devision","").make(json.data_item_devision,s_code).append($S("tag_item_devision"));
			     	        itemDevision.element.onchange = function(){ }
			     	        itemDevision.element.className="required trim focus alert";
			     	        itemDevision.element.setAttribute("message","구분을 선택해주세요.");
			     	        var itemCode2 = new Common.createArrangeElement("select","item_code2","").make(json.data_item_code2,s_code).append($S("tag_item_code2"));
			     	        itemCode2.element.onchange = function(){ }
			     	        itemCode2.element.className="required trim focus alert";
			     	        itemCode2.element.setAttribute("message","회의명을 선택해주세요.");
			     	        var itemCode3 = new Common.createArrangeElement("select","item_code3","").make(json.data_item_code3,s_code).append($S("tag_item_code3"));
			     	        itemCode3.element.onchange = function(){ }
			     	        itemCode3.element.className="required trim focus alert";
			     	        itemCode3.element.setAttribute("message","사업유형을 선택해주세요.");
			     	        var itemCode4 = new Common.createArrangeElement("select","item_code4","").make(json.data_item_code4,s_code).append($S("tag_item_code4"));
			     	        itemCode4.element.onchange = function(){ }
			     	        itemCode4.element.className="required trim focus alert";
			     	        itemCode4.element.setAttribute("message","사업상태를 선택해주세요.");
			     	        
				            Form.bind(json.data,$S("wForm"));
				            if ( json.data.real_att_file ) {
			            	    $S("real_att_file").innerHTML = "<a href='#' onclick='fDownload(" + json.data.item_no + ");'>" + json.data.display_att_file + "</a>"
			            	                                  + "<input type=checkbox name='delete_yn_att_file' value='Y'/>삭제" 
			            	    ;
				            } else {
				            	$S("real_att_file").innerHTML = "";
				            }
				        	wForm.p_schedule_no.value = json.data.schedule_no;
				        	$S("status_name").innerText = json.status_name;
			     	    }});
			     	    
			        } else {
			            alert(json.message); // error
			        }
			    }
			);
		} else {
			alert("조회정보가 불충분 합니다.")			
		}
	} else {
		call('JSON',"dms_biz/bd_item/get_item_code",
			{},
		    function(json) {
		        if ( json['return'] == '200' ) { // success   
		        	var s_code = "";
		     	    Util.Load.script({src:"/js/common.js",type:'js',callback:function(){
		     	        var itemDevision = new Common.createArrangeElement("select","item_devision","").make(json.data_item_devision,s_code).append($S("tag_item_devision"));
		     	        itemDevision.element.onchange = function(){ }
		     	        itemDevision.element.className="required trim focus alert";
		     	        itemDevision.element.setAttribute("message","구분을 선택해주세요.");
		     	        var itemCode2 = new Common.createArrangeElement("select","item_code2","").make(json.data_item_code2,s_code).append($S("tag_item_code2"));
		     	        itemCode2.element.onchange = function(){ }
		     	        itemCode2.element.className="required trim focus alert";
		     	        itemCode2.element.setAttribute("message","회의명을 선택해주세요.");
		     	        var itemCode3 = new Common.createArrangeElement("select","item_code3","").make(json.data_item_code3,s_code).append($S("tag_item_code3"));
		     	        itemCode3.element.onchange = function(){ }
		     	        itemCode3.element.className="required trim focus alert";
		     	        itemCode3.element.setAttribute("message","사업유형을 선택해주세요.");
		     	        var itemCode4 = new Common.createArrangeElement("select","item_code4","").make(json.data_item_code4,s_code).append($S("tag_item_code4"));
		     	        itemCode4.element.onchange = function(){ }
		     	        itemCode4.element.className="required trim focus alert";
		     	        itemCode4.element.setAttribute("message","사업상태를 선택해주세요.");
		     	    }});
		        } else {
		            alert(json.message); // error
		        }
		    }
		);		
	
	}
    return false;
}

function fExec() {
    var f = $S('wForm');
        var exec = false;
        var invalidCb = {
//        	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }    
        };
        
        if ( fChkAmt() && Form.validate(f ,invalidCb) ) {
        	var title = !""?"저장하시겠습니까?":"수정하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('FORM.FILE',"dms_biz/bd_item/write",
                	{},
                    function(str) {
                        var json = eval("(" + str + ")" );    
                        if ( json['return'] == '200' ) { // success      
                            if ( json.mode == 'I' ) {
        	                    alert(json.message);
        	                	document.location.href = "/service.jsp?p_prg=dms_biz/bd_item_list";        	                    
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

function fList() {
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
//	getUI("sample","sample",{params:""});
//	document.location.href = "/service.jsp?p_prg=sample/sample";
	if ( p_mode == "I" ) {
		history.go(-1);
	} else {
		history.go(-3);		
	}
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
function fAmtChange() {
	if ( wForm.amt_yn[0].checked ) {
		wForm.avaiable_budget.disabled  = false;
		wForm.budget_amount.disabled = false;
		wForm.avaiable_budget.className = "required number trim focus alert";
		wForm.budget_amount.className = "required number trim focus alert";
	} else {
		wForm.avaiable_budget.disabled = true ;
		wForm.budget_amount.disabled = true ;
		wForm.avaiable_budget.className = "";
		wForm.budget_amount.className = "";
	}
}

function fChkAmt() {
//	console.debug(wForm.avaiable_budget.value.toNumber(),wForm.budget_amount.value.toNumber())
	if ( wForm.avaiable_budget.value.toNumber() < wForm.budget_amount.value.toNumber()  ) {
		alert("예산금액이 가용예산금액을 초과하였습니다.");
		
		return false;
	} else {
		return true;
	}
}
