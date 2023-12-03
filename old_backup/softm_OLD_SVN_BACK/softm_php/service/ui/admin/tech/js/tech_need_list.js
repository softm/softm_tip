function onInit(argus) {
    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
    GRID.init({
        requestType : "POST"        , // JSON, POST
        dataType    : "xml"         , // xml, json
        table_id    : "tbl_list"    , // Table Id
        editevent   : "ondblclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        setting     : {
            "delete": false,
            "insert": false
        },
        service_infor:{
            className  : "admin.TechConsult",
            method     : { "list":"admin.TechConsult.select", "save":"save" },
            argus      : {
                p_navi_function:"조회"
            }
        },
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            // log(["onload mode : " + o.mode,o]);
            if ( o.mode == "U" || o.mode == "D" ) alert(o.data.message);
            onLoad(o,argus);
        },
        row:{
        	onclick:function(o) {
        		//        		console.debug(o);
                getUI("admin/tech","tech_need_write",{
        			method:"POST",
        			argus : {
        				p_consult_no:GRID.getValue(o.tId,o.tr.rowIndex,"consult_no")
        				//p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no"),
        			},
        			target:"#contents"
        		});
        	}
        }
    });

    var f = $S("sForm");
    
    Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
        var L = new Common.createELTechCat("SELECT","L","s_l_cat","1차카테고리").make(getRestoreValue("s_l_cat")).append($S("area_tech_l_cat"));
        var M = new Common.createELTechCat("SELECT","M","s_m_cat","2차카테고리").make(getRestoreValue("s_l_cat"),getRestoreValue("s_m_cat")).append($S("area_tech_m_cat"));
        var S = new Common.createELTechCat("SELECT","S","s_s_cat","3차카테고리").make(getRestoreValue("s_l_cat"),getRestoreValue("s_m_cat"),getRestoreValue("s_s_cat")).append($S("area_tech_s_cat"));
        L.setNextObject(M);
        M.setNextObject(S);
        L.element.attachEvent("onchange",function() {
            M.element.attachEvent("onchange",function() {
            	조회(1);
                S.element.attachEvent("onchange",function() {
                	조회(1);        	
                });
            });
            조회(1);        	
        });

        조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);        
    }});
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
}

// 조회
function 조회(s) {
	var f = document.sForm;
    // GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    // GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
//	alert(f.s_l_cat.value);
//    console.debug("조회:" , SOFTMARGUMENT["RESTORE"]);
    GRID["tbl_list"].setArgus("s_l_cat"          ,f.s_l_cat.value);
    GRID["tbl_list"].setArgus("s_m_cat"          ,f.s_m_cat.value);
    GRID["tbl_list"].setArgus("s_s_cat"          ,f.s_s_cat.value);
    GRID["tbl_list"].setArgus("s_tech_nm"        ,f.s_tech_nm.value);
    GRID["tbl_list"].setArgus("s_trade_hope_type",f.s_trade_hope_type.value);
    GRID["tbl_list"].setArgus("s_keyword"        ,f.s_keyword.value);
    
    setRestore("p_navi_start",s,true);
    // 변수로 저장
    setRestore("s_tech_nm",f.s_tech_nm.value);
    setRestore("s_trade_hope_type",f.s_trade_hope_type.value);
    setRestore("s_keyword",f.s_keyword.value);
    
    setRestore("s_l_cat",f.s_l_cat.value ,true);
    setRestore("s_m_cat",f.s_m_cat.value ,true);
    setRestore("s_s_cat",f.s_s_cat.value ,true);
    
    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function fileDownload(fExt) {
	call("FORM","common.Common","saveDownload",
		{
		p_file_nm:"한국기업니즈관리." + fExt,
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
}