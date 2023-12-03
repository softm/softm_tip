if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}
function onInit(argus) {
	if ( USER_LEVEL == 0 ) {
		alert("로그인후 이용할 수 있습니다.");
		document.location.href = "/sub.php?flashmenu=11912";
		return false;
	} else if ( USER_LEVEL < 2 ) {
		alert("기업회원만 이용할 수 있습니다.");
		document.location.href = "/sub.php?flashmenu=11901";
		return false;
	}	
    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
    GRID.init({
        requestType : "JSON"        , // JSON, POST
        dataType    : "xml"         , // xml, json
        table_id    : "tbl_list"    , // Table Id
        editevent   : "ondblclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        setting     : {
            "delete": false,
            "insert": false
        },
        service_infor:{
            className  : "front.BizConsult",
            method     : { "list":"front.BizConsult.select2", "save":"save" },
            argus      : {
                p_navi_function:"fGetList"
            }
        },
        row:{
        	onclick:function(o) {
        		//        		console.debug(o);
        		getUI("front/biz","biz_consult_write",{
        			method:"POST",
        			argus : {
        				p_consult_no:GRID.getValue(o.tId,o.tr.rowIndex,"consult_no"),
        				p_proc_type:3
        			},
        			target:"#contents",
        			loadui:false
        		});
        	}
        }
    });
    fGetList(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
//    $S("btn_xls_down").onclick = function() {
//    	fileDownload("xls");	
//    }
//    
//    $S("btn_doc_down").onclick = function() {
//    	fileDownload("doc");	
//    }
}

// 조회
function fGetList(s) {
	GRID["tbl_list"].setArgus("s_company_type"  ,Form.value($N("s_company_type")));
	GRID["tbl_list"].setArgus("s_biz_field"     ,Form.value($N("s_biz_field")));
	GRID["tbl_list"].setArgus("s_company_nm_kr" ,Form.value($N("s_company_nm_kr" )));
	GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function fileDownload(fExt) {
	fExt = !fExt?"xls":fExt;
	call("FORM","common.Common","saveDownload",
		{
		p_file_nm:"기업정보." + fExt,
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
	return false;
}