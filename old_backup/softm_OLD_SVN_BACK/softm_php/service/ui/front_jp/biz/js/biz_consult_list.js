if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}
function onInit(argus) {
    Util.Load.script({src:"/service/ui/css/grid1.css",type:"css"});
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
            className  : "front_jp.BizConsult",
            method     : { "list":"front_jp.BizConsult.select", "save":"save" },
            argus      : {
                p_navi_function:"fGetList"
            }
        },
        row:{
        	onclick:function(o) {
        		//        		console.debug(o);
        		if ( $S("calendarDiv") ) $S("calendarDiv").style.display = "none";        		
        		getUI("front_jp/biz","biz_consult_view",{
        			method:"POST",
        			argus : {
        				p_consult_no:GRID.getValue(o.tId,o.tr.rowIndex,"consult_no")
        			},
        			target:"#contents",
        			loadui:false
        		});
        	}
        }

    });
    fGetList(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
//    $S("btn_xls_down").onclick = function() {fileDownload("xls");}
//    $S("btn_doc_down").onclick = function() {fileDownload("doc");}    
}

// 조회
function fGetList(s) {
//    setRestore("s_frm_reg_date",Form.value($N("s_frm_reg_date")));
//    setRestore("s_to_reg_date" ,Form.value($N("s_to_reg_date" )));
//    setRestore("s_state"       ,Form.value($N("s_state"       )));
//    setRestore("s_woker_nm"    ,Form.value($N("s_woker_nm"    )));
//
//	GRID["tbl_list"].setArgus("s_frm_reg_date",Form.value($N("s_frm_reg_date")));
//	GRID["tbl_list"].setArgus("s_to_reg_date" ,Form.value($N("s_to_reg_date" )));
//	GRID["tbl_list"].setArgus("s_state"       ,Form.value($N("s_state"       )));
//	GRID["tbl_list"].setArgus("s_woker_nm"    ,Form.value($N("s_woker_nm"    )));
	GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function fileDownload(fExt) {
	fExt = !fExt?"xls":fExt;
	call("FORM","common.Common","saveDownload",
		{
		p_file_nm:"비지니스상담." + fExt,
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
	return false;
}