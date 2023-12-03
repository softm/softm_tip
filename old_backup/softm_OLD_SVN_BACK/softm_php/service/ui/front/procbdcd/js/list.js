function onInit(argus) {
	 // 레이어팝업
	$(".popup_close").click(function(e){
        e.preventDefault();
		$(".layer_popup , .bg_popup").fadeOut();
		// $(this).parent().hide();
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
            className  : "front.ProcBdCd",
            method     : { "list":"front.ProcBdCd.select", "save":"save" },
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
    조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);

    callJSONSync('common.Common','getProcInfo',
    {
        p_proc_cd:SOFTMARGUMENT.p_proc_cd
    },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
//                console.info(json.item)
                var  items = json.item;
                if ( json['return'] == '200' ) { // success
                  $("#proc_nm").text(items.PROC_NM);
                } else if (json['return'] == '500') {
                    alert(json.message); // error
                }
                if ( argus.p_proc_cd ) {
                    $("#p_proc_cd").val(argus.p_proc_cd);
                }
 
                조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
            }
            // requestType이 FORM, FORM.FILE의 경우 
            //,f
    );

}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
    $('tbody td.col1').each(function(index, element){
        var proc_cd     = GRID.getValue("tbl_list",index+1,"PROC_CD"    );
        var proc_it_cd  = GRID.getValue("tbl_list",index+1,"PROC_IT_CD" );
        var proc_bd_cd  = GRID.getValue("tbl_list",index+1,"PROC_BD_CD" );
        //console.info( proc_cd,proc_it_cd,proc_bd_cd );
        var txt = $(element).text();
        if ( txt ) {
            $(element).html('<a href="/reginfo.php?p_proc_cd='    + proc_cd
                            +                    '&p_proc_it_cd=' + proc_it_cd
                            +                    '&p_proc_bd_cd=' + proc_bd_cd
                            + '"><u>' + txt + '</u></a>');
        } else {
            $(element).html('');
        }
    });
}

function 조회(s) {
    GRID["tbl_list"].setArgus("p_proc_cd"  ,SOFTMARGUMENT.p_proc_cd);
    GRID["tbl_list"].setArgus("p_proc_it_cd"  ,SOFTMARGUMENT.p_proc_it_cd);

    //setRestore("s_l_cat",f.s_l_cat.value);
    setRestore("p_navi_start",s,true);
    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}
