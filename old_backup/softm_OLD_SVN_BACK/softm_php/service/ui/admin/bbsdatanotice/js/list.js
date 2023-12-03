function onInit(argus) {
    Util.Load.script({src:serviceBase+"/ui/css/grid_mj.css",type:"css"});
    GRID.init({
        requestDataType : "POST"        , // JSON, POST
        responseDataType: "xml"         , // JSON, XML, TEXT
        table_id    : "tbl_list"    , // Table Id
        editevent   : "onclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        setting     : {
            "delete": false,
            "insert": false
        },
        service_infor:{
            className  : "admin.BbsDataNotice",
            method     : { "list":"admin.BbsDataNotice.select", "save":"save" },
            argus      : {
                p_navi_function:"조회"
            }
        },
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            // log(["onload mode : " + o.mode,o]);
            if ( o.data.return == "200" ) {
                if ( o.mode == "U" || o.mode == "D" ) {
                    alert(o.data.message);
                    document.location.href= "/admin_bbs.php";
                }
            }
            onLoad(o,argus);
        }

//,        row:{
//        	onclick:function(o) {
//        		//        		console.debug(o);
//        		getUI("test/bbsdatanotice","write",{
//        			method:"POST",
//        			argus : {
//        				p_no:GRID.getValue(o.tId,o.tr.rowIndex,"no")
//        				//p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no"),
//        			},
//        			target:"#contents",
//        			loadui:false
//        		});
//        	}
//        }
    });

    $("#s_search"      ).val(getRestoreValue("s_search"    ));
    $("#p_state"       ).val(getRestoreValue("s_gubun"     ));
    조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
    $(".btn_modify").unbind("click");
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
        getUI("admin/bbsdatanotice","write",{
            method:"POST",
            argus : {
              p_no:GRID.getValue($S("tbl_list"),tr.rowIndex,"NO")
              //p_company_no:GRID.getValue(tbl,tr.rowIndex,"company_no"),
            },
            target:"#contents"
            ,loadui:false
        });
        e.preventDefault();
    });

    $(".btn_delete").unbind("click");
    $(".btn_delete").click(function(e) {
      //              console.debug($(this));
      var td = GRID.cell.getTd($(this).get(0).parentNode);
      var tr = td.parentNode;
      // console.debug(td);
      // console.debug(tr.cells[0].innerText);
      if( confirm("삭제하시겠습니까") ) {
      GRID.submit({
          td:td,mode:"D"});
          조회(1);
          //onInit(SOFTMARGUMENT);
      }
      e.preventDefault();
    });

    $('tbody td.col4').each(function(index, element){
        var no = GRID.getValue("tbl_list",index+1,"NO");
        var fno = $(element).text();
        if ( fno != "0" && fno ) {
            $(element).html('<a href="#" onclick="fileDownload(' + fno + ',\'f1_'+no+'_\');"><img src="/images/contents/ico_file.jpg" alt="첨부파일있음" /></a>');
        } else {
            $(element).html('');
        }
        var td = GRID.getCell("tbl_list",index+1,"TITLE");
        $(td).html("<a href='/admin_bbs.php?mode=view&p_no=" + no + "'><u>"+$(td).text()+"</u></a>");
    });
}
function fileDownload(fNo,fNm) {
//    alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
    		p_file_no:fNo,
    		p_file_nm:fNm,
    		p_sub_dir:"bbsnotice"
    	}
    );
}
function 조회(s) {
    var f = document.sForm;
    //GRID["tbl_list"].setArgus("s_search"         ,f.s_search.value);
    //GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    //GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
    //GRID["tbl_list"].setArgus("s_search",f.s_search.value);
    GRID["tbl_list"].setArgus("s_gubun",f.s_gubun.value);
    GRID["tbl_list"].setArgus("s_search",f.s_search.value);
    //setRestore("s_l_cat",f.s_l_cat.value);
    setRestore("p_navi_start",s,true);
    setRestore("s_search"    ,$("#s_search"      ).val());
    setRestore("s_gubun"     ,$("#s_gubun"        ).val());

    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function 입력() {
    getUI("admin/bbsdatanotice","write",{
        method:"POST",
        target:"#contents",
        argus:{
        p_no:''
        }
    });
    return false;

}
function 파일다운로드() {
	call("FORM","common.Common","saveDownload", 
		{
		p_file_nm:"\"공지사항.xls\"",
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
}