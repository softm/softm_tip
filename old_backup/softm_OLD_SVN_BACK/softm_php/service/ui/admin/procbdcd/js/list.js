function onInit(argus) {
    $("#btnReg").click(function(e) {
        추가();
        e.preventDefault();
    });
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
            className  : "admin.ProcBdCd",
            method     : { "list":"admin.ProcBdCd.select", "save":"save" },
            argus      : {
                p_navi_function:"조회"
            }
        },
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            //console.info("onload mode : ",o.mode,o);
            if ( o.data.return == "200" ) {
                if ( o.mode == "U" || o.mode == "D" ) alert(o.data.message);
                if ( o.mode == "U" ) {
                    조회(1);
                }
            }
            onLoad(o,argus);
        }
        ,
        onchange:function(o) {
            var td= GRID.cell.getTd(o.td);
            //var countryCode = GRID.cell.getData(o.tId,td.parentNode.rowIndex,'COUNTRY_CODE');
            if (confirm("저장하시겠습니까?")) {
                //GRID.getValue("tbl_test",1,"USER_ID")
                return true;
            } else {
                return false;
            }
        },

//,        row:{
//        	onclick:function(o) {
//        		//        		console.debug(o);
//        		getUI("test/procbdcd","write",{
//        			method:"POST",
//        			argus : {
//        				p_proc_bd_cd_no:GRID.getValue(o.tId,o.tr.rowIndex,"proc_bd_cd_no")
//        				//p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no"),
//        			},
//        			target:"#contents",
//        			loadui:false
//        		});
//        	}
//        }

    });
    Util.Load.script({src:serviceBase+"/ui/css/grid_mj.css",type:"css"});
    callJSON('common.Common','getProcegory',
        	{},
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
//                console.info(json.item)
                var  items = json.item;
                if ( json['return'] == '200' ) { // success      
                    //console.debug(json.insert_id);
                    //$S('btn_list').click();
//                	alert(json.message); // success
//                    조회(1);
                    //alert(o.value instanceof Array );
                    //this instanceof Array
                	$("#p_proc_cd").find('option').remove();
            		$("#p_proc_cd").append("<option value=''>-선택-</option>");
                    if ( items && items.PROC_CD  ) {
                        $("#p_proc_cd").append("<option value='"+items.PROC_CD+"'>"+items.PROC_NM+"</option>");
                    } else {
                        $.each(items, function(key, value) {
                            $("#p_proc_cd").append("<option value='"+value.PROC_CD+"'>"+value.PROC_NM+"</option>");
    //                      console.info(value.proc_cd,value.proc_nm);
    //                      $("#sub").append("<option>" + value + "</option>");
                        });
                    }
                    if ( argus.p_proc_cd ) {
                        $("#p_proc_cd").val(argus.p_proc_cd);
                    }
                    조회(1);
                    $("#p_proc_cd").change(function(e) {
                        callJSON('common.Common','getProcItCdegory',
                            {
                                proc_cd:$("#p_proc_cd").val()
                            },
                            function(xmlDoc){
                                var json  = Util.xml2json(xmlDoc);
                //                console.info(json.item)
                                $("#p_proc_it_cd").find('option').remove();
                                var  items = json.item;
                                if ( json['return'] == '200' ) { 
                                    if ( items ) {
                                        if ( items.PROC_IT_CD ) {
                                            $("#p_proc_it_cd").append("<option value='"+items.PROC_IT_CD+"'>"+items.PROC_IT_NM+"</option>");
                                        } else {
                                            $.each(items, function(key, value) {
                                                $("#p_proc_it_cd").append("<option value='"+value.PROC_IT_CD+"'>"+value.PROC_IT_NM+"</option>");
                        //                		console.info(value.proc_cd,value.proc_nm);
                        //                		$("#sub").append("<option>" + value + "</option>"); 
                                            });
                                        }
                                    } else {
                                        $("#p_proc_it_cd").append("<option value=''>-없음-</option>");
                                    }
                                    조회(1);
                                } else if (json['return'] == '500') {
                                }
                            }
                        );
                    });

                    $("#p_proc_it_cd").change(function(e) {
                        조회(1);
                    });

                	$("#p_proc_it_cd").find('option').remove();
            		$("#p_proc_it_cd").append("<option value=''>-없음-</option>");
                } else if (json['return'] == '500') {
                    alert(json.message); // error
                }
            }
            // requestType이 FORM, FORM.FILE의 경우 
            //,f
    );
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
    $(".btn_reg_cnt").unbind("click");
    $(".btn_reg_cnt").click(function(e) {
        var tbl = $S("tbl_list");
        if ( tbl == null ) return;
        var td = GRID.cell.getTd($(this).get(0).parentNode);
        var tr = td.parentNode;
        var proc_cd = GRID.getValue($S("tbl_list"),tr.rowIndex,"PROC_CD");
        var proc_it_cd = GRID.getValue($S("tbl_list"),tr.rowIndex,"PROC_IT_CD");
        var proc_bd_cd = GRID.getValue($S("tbl_list"),tr.rowIndex,"PROC_BD_CD");
        document.location.href = "/admin_product.php?sub=reginfo&p_proc_cd="   + proc_cd
                                                             + "&p_proc_it_cd="+ proc_it_cd
                                                             + "&p_proc_bd_cd="+ proc_bd_cd
        ;
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
        getUI("test/procbdcd","write",{
            method:"POST",
            argus : {
              p_proc_bd_cd_no:GRID.getValue($S("tbl_list"),tr.rowIndex,"PROC_BD_CD_NO")
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
}

function 조회(s) {
    var f = document.sForm;
    //GRID["tbl_list"].setArgus("s_search"         ,f.s_search.value);
    //GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    //GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
    //GRID["tbl_list"].setArgus("s_search",f.s_search.value);

    GRID["tbl_list"].setArgus("p_proc_cd"  ,$("#p_proc_cd").val());
    GRID["tbl_list"].setArgus("p_proc_it_cd"  ,$("#p_proc_it_cd").val());
    GRID["tbl_list"].setCondition( "PROC_BD_NM" , f.s_search.value).setLike();

    //setRestore("s_l_cat",f.s_l_cat.value);
    setRestore("p_navi_start",s,true);
    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

function 입력() {
    getUI("test/procbdcd","write",{
        method:"POST",
        target:"#contents",
        argus:{
        p_proc_bd_cd_no:''
        }
    });
    return false;

}
function 파일다운로드() {
	call("FORM","common.Common","saveDownload", 
		{
		p_file_nm:"\"공종항목내역코드.xls\"",
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
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
	        call('JSON','admin.ProcBdCd','insert',
	        	Form.json(f),
	            function(xmlDoc){
	                var json  = Util.xml2json(xmlDoc);
	                if ( json['return'] == '200' ) { // success      
	                    //console.debug(json.insert_id);
	                    //$S('btn_list').click();
	                	alert(json.message); // success
	                    조회(1);
                        $("#proc_bd_nm").val("");
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