if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}
function onInit(argus) {
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
            className  : "admin.BizConsult",
            method     : { "list":"admin.BizConsult.select2", "save":"save" },
            argus      : {
                p_navi_function:"fGetList"
            }
        },
        row:{
        	onclick:function(o) {
        		//        		console.debug(o);
//        		alert(GRID.getValue(o.tId,o.tr.rowIndex,"consult_no"));
        		if ( $S("calendarDiv") ) $S("calendarDiv").style.display = "none";        		
        		getJs("admin/biz","biz_consult_write",{
        			argus : {
        				p_consult_no:GRID.getValue(o.tId,o.tr.rowIndex,"consult_no"),
        				p_proc_type:2
        			}
        		});
        	}
        }

    });
    fGetList(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
}

// 조회
function fGetList(s) {
    setRestore("s_biz_field"       ,Form.value($N("s_biz_field"       )));
    setRestore("s_biz_classified"       ,Form.value($N("s_biz_classified"       )));
    setRestore("s_state"       ,Form.value($N("s_state"       )));
    setRestore("s_keyword"    ,Form.value($N("s_keyword"    )));

	GRID["tbl_list"].setArgus("s_biz_field"       ,Form.value($N("s_biz_field"       )));
	GRID["tbl_list"].setArgus("s_biz_classified"       ,Form.value($N("s_biz_classified"       )));
	GRID["tbl_list"].setArgus("s_state"       ,Form.value($N("s_state"       )));
	GRID["tbl_list"].setArgus("s_keyword"    ,Form.value($N("s_keyword"    )));
	GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function fileDownload(fExt) {
	fExt = !fExt?"xls":fExt;
	call("FORM","common.Common","saveDownload",
		{
		p_file_nm:"비지니스매칭." + fExt,
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
	return false;
}