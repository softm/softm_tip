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
            className  : "test.calkocountry.CalkoCountry",
            method     : { "list":"test.calkocountry.CalkoCountry.select", "save":"save" },
            argus      : {
                p_navi_function:"조회"
            }
        },
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            // log(["onload mode : " + o.mode,o]);
            if ( o.mode == "U" || o.mode == "D" ) alert(o.data.message);
            onLoad(o,argus);
        }

//,        row:{
//        	onclick:function(o) {
//        		//        		console.debug(o);
//        		getUI("test/calkocountry","write",{
//        			method:"POST",
//        			argus : {
//        				p_country_code:GRID.getValue(o.tId,o.tr.rowIndex,"country_code"),
//        				p_destination:GRID.getValue(o.tId,o.tr.rowIndex,"destination")
//        				//p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no"),
//        			},
//        			target:"#contents",
//        			loadui:false
//        		});
//        	}
//        }

    });
    조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
    $(".btn_modify").click(function(e) {
        var tbl = $S("tbl_list");
        if ( tbl == null ) return;
        var td = GRID.cell.getTd($(this).get(0).parentNode);
        var tr = td.parentNode;
        //var userNo = tr.cells[0].innerText;
        //companyNo = GRID.getValue(tbl,tr.rowIndex,"company_no");
        // alert(tbl + " / " + companyNo );
        //if ( SOFTMARGUMENT.p_user_level == 2 ) {
        //}
        getUI("test/calkocountry","write",{
            method:"POST",
            argus : {
              p_country_code:GRID.getValue($S("tbl_list"),tr.rowIndex,"country_code"),
              p_destination:GRID.getValue($S("tbl_list"),tr.rowIndex,"destination")
              //p_company_no:GRID.getValue(tbl,tr.rowIndex,"company_no"),
            },
            target:"#contents"
            ,loadui:false
        });
        e.preventDefault();
    });

    $(".btn_delete").click(function(e) {
      //              console.debug($(this));
      var td = GRID.cell.getTd($(this).get(0).parentNode);
      var tr = td.parentNode;
      // console.debug(td);
      // console.debug(tr.cells[0].innerText);
      if( confirm("삭제하시겠습니까") ) {
      GRID.submit({
          td:td,mode:"D"});
          onInit(SOFTMARGUMENT);
      }
      e.preventDefault();
    });
}

function 조회(s) {
    var f = document.sForm;
    //GRID["tbl_list"].setArgus("s_search"         ,f.s_search.value);
    //GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    //GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
    //GRID["tbl_list"].setArgus("s_search",f.s_search.value);

    //setRestore("s_l_cat",f.s_l_cat.value);
    setRestore("p_navi_start",s,true);
    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function 입력() {
    getUI("test/calkocountry","write",{
        method:"POST",
        target:"#contents",
        argus:{
        p_country_code:'',
        p_destination:''
        }
    });
    return false;

}
function 파일다운로드() {
	call("FORM","common.Common","saveDownload", 
		{
		p_file_nm:"Country Code.xls",
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
}