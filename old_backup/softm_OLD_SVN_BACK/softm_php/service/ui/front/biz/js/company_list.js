function onInit(argus) {
    Util.Load.script({src:"/service/ui/css/grid1.css",type:"css"});
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
            className  : "front.Company",
            method     : { "list":"front.Company.select", "save":"save" },
            argus      : {
                p_navi_function:"fGetList"
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
        		getUI("front/biz","biz_interest_company_view",{
        			method:"POST",
        			argus : {
                        p_company_no:GRID.row.getValue(o.tr,"company_no")
        			},
        			target:"#contents",
        			loadui:false
        		});
        	}
        }

//,        row:{
//        	onclick:function(o) {
//        		//        		console.debug(o);
//        		getUI("test/company","write",{
//        			method:"POST",
//        			argus : {
//        				p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no")
//        				//p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no"),
//        			},
//        			target:"#contents"
//        		});
//        	}
//        }

    });
    fGetList(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
    $(".btn_modify").click(function(e) {
        var tbl = $S("tbl_list");
        if ( tbl == null ) return;
        var td = $(this).get(0).parentNode;
        var tr = td.parentNode;
        //var userNo = tr.cells[0].innerText;
        //companyNo = GRID.getValue(tbl,tr.rowIndex,"company_no");
        // alert(tbl + " / " + companyNo );
        //if ( SOFTMARGUMENT.p_user_level == 2 ) {
        //}
        getUI("test/company","write",{
            method:"POST",
            argus : {
              p_company_no:GRID.getValue($S("tbl_list"),tr.rowIndex,"company_no")
              //p_company_no:GRID.getValue(tbl,tr.rowIndex,"company_no"),
            },
            target:"#contents"
            ,loadui:false
        });
        e.preventDefault();
    });

    $(".btn_delete").click(function(e) {
      //              console.debug($(this));
      var td = $(this).get(0).parentNode;
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

// 조회
function fGetList(s) {
    // GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    // GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
    // setRestore("s_gubun",$S("s_gubun").value );
    // setRestore("s_search",$S("s_search").value );
    // setRestore("p_navi_start",s,true);

    //alert( Form.value($N("s_adviser_field")[0] ));
    //console.debug(typeof($N("s_adviser_field")));

	setRestore("s_hope_biz_type"      , function() {
		  Form.setValue($N("s_hope_biz_type"),getRestoreValue("s_hope_biz_type_value"))
		});
	setRestore("s_hope_biz_type_value",Form.value($N("s_hope_biz_type")),true);

    setRestore("s_biz_field"     ,Form.value($N("s_biz_field"     )));
    setRestore("s_biz_classified",Form.value($N("s_biz_classified")));

    GRID["tbl_list"].setArgus("s_hope_biz_type"     ,Form.value($N("s_hope_biz_type"     )));
    GRID["tbl_list"].setArgus("s_biz_field"     ,Form.value($N("s_biz_field"     )));
    GRID["tbl_list"].setArgus("s_biz_classified",Form.value($N("s_biz_classified")));
    GRID["tbl_list"].setArgus("s_hope_biz_type" ,Form.value($N("s_hope_biz_type"      )));
    GRID["tbl_list"].setArgus("p_company_type"  ,SOFTMARGUMENT.p_company_type);

    GRID["tbl_list"].setCondition("COMPANY_NM_KR",$S("s_company_nm").value).setLike();

    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function fileDownload() {
	call("FORM","common.Common","saveDownload",
		{
		p_file_nm:"기업정보.xls",
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
}