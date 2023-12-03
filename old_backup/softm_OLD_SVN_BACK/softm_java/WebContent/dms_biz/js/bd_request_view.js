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
			        	
			        	$S("real_att_file").innerHTML = "<a href='#' onclick='return fDownload(" + json.data.req_no + ");'>" + json.data.display_att_file + "</a>";
			        	if ( json.data.status != "2" ) $S("btn_request").style.display = "none";
			        	
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
        call('JSON',"dms_biz/bd_request/update_status",
        	{
        		p_req_no:wForm.p_req_no.value,
        		p_status:"2" // 등록완료
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

function fGoWrite() {
	var p_req_no = wForm.p_req_no.value;
	document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_write&p_req_no=" + ( p_req_no?p_req_no:"" );
}

function fList() {
//	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
//	history.go(-1);
	document.location.href = "/service.jsp?p_prg=dms_biz/bd_request_list";
	return false;
}