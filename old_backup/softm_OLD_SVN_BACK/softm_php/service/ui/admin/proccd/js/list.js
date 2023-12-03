function onInit(argus) {
    $("#btnReg").click(function(e) {
        추가();
        e.preventDefault();
    });
    
    Util.Load.script({src:serviceBase+"/ui/css/grid_mj.css",type:"css"});
    GRID.init({
        requestDataType : "POST"        , // JSON, POST
        responseDataType: "xml"         , // JSON, XML, TEXT
        table_id    : "tbl_list"    , // Table Id
        editevent   : "onfocus"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        setting     : {
            "delete": false,
            "insert": false
        },
        service_infor:{
            className  : "admin.ProcCd",
            method     : { "list":"admin.ProcCd.select", "save":"save" },
            argus      : {
                p_navi_function:"조회"
            }
        },
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            // log(["onload mode : " + o.mode,o]);
            if ( o.data.return == "200" ) {
                if ( o.mode == "U" || o.mode == "D" ) alert(o.data.message);
            }
            onLoad(o,argus);
        }

//,        row:{
//        	onclick:function(o) {
//        		//        		console.debug(o);
//        		getUI("test/proccd","write",{
//        			method:"POST",
//        			argus : {
//        				p_proc_cd:GRID.getValue(o.tId,o.tr.rowIndex,"proc_cd")
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


function 추가() {
    var f = $S('aForm');
    var exec = false;
    var invalidCb = {
//        proc_nm:function(){ Effect.twinkle(f.proc_nm);}
    };

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("추가하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {    	
	        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
	        //  call(requestType,className,method,argus,cb,form)
	        //  call('FORM.FILE','test.proccd.ProcCd',SOFTMARGUMENT.p_proc_cd?'update':'insert',
	        call('JSON','admin.ProcCd','insert',
	        	Form.json(f),
	            function(xmlDoc){
	                var json  = Util.xml2json(xmlDoc);
	                if ( json['return'] == '200' ) { // success      
	                    //console.debug(json.insert_id);
	                    //$S('btn_list').click();
	                	alert(json.message); // success
	                    조회(1);
	                } else if (json['return'] == '500') {
	                    alert(json.message); // error
	                }
	            }
	            // requestType이 FORM, FORM.FILE의 경우 
	            //,f
	        );
        }
    }
    return false;
}


function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
	// btn_proc_it_cnt
	// btn_proc_bd_cnt
	// btn_reg_cnt
    $(".btn_proc_it_cnt").unbind("click");
    $(".btn_proc_it_cnt").click(function(e) {
        var tbl = $S("tbl_list");
        if ( tbl == null ) return;
        var td = GRID.cell.getTd($(this).get(0).parentNode);
        var tr = td.parentNode;
        document.location.href = "/admin_product.php?sub=procitcd&p_proc_cd="+GRID.getValue($S("tbl_list"),tr.rowIndex,"PROC_CD");
        e.preventDefault();
    });

    $(".btn_proc_bd_cnt").unbind("click");
    $(".btn_proc_bd_cnt").click(function(e) {
        var tbl = $S("tbl_list");
        if ( tbl == null ) return;
        var td = GRID.cell.getTd($(this).get(0).parentNode);
        var tr = td.parentNode;
        document.location.href = "/admin_product.php?sub=procbdcd&p_proc_cd="+GRID.getValue($S("tbl_list"),tr.rowIndex,"PROC_CD");
        e.preventDefault();
    });
    $(".btn_reg_cnt").unbind("click");
    $(".btn_reg_cnt").click(function(e) {
        var tbl = $S("tbl_list");
        if ( tbl == null ) return;
        var td = GRID.cell.getTd($(this).get(0).parentNode);
        var tr = td.parentNode;
        document.location.href = "/admin_reginfo.php?sub=reginfo&p_proc_cd="+GRID.getValue($S("tbl_list"),tr.rowIndex,"PROC_CD");
        e.preventDefault();
    });

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
    	getUI("test/proccd","write",{
    		method:"POST",
    		argus : {
    			p_proc_cd:GRID.getValue($S("tbl_list"),tr.rowIndex,"PROC_CD")
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
      }
      e.preventDefault();
    });
}

function 조회(s) {
    var f = document.sForm;
    //GRID["tbl_list"].setArgus("s_search"         ,f.s_search.value);
    GRID["tbl_list"].setCondition( "PROC_NM", f.s_search.value).setLike();
    //GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    //GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
    //GRID["tbl_list"].setArgus("s_search",f.s_search.value);

    //setRestore("s_l_cat",f.s_l_cat.value);
    setRestore("p_navi_start",s,true);
    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function 입력() {
    getUI("test/proccd","write",{
        method:"POST",
        target:"#contents",
        argus:{
        p_proc_cd:''
        }
    });
    return false;

}
function 파일다운로드() {
	call("FORM","common.Common","saveDownload", 
		{
		p_file_nm:"\"대공종코드.xls\"",
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
}