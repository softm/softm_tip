function onInit(argus) {
	$("#area_map").click(function(e){
//        지역조회('11');
        지역조회('26');
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
            className  : "front.RegInfo",
            method     : { "list":"front.RegInfo.select", "save":"save" },
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
//        		getUI("test/reginfo","write",{
//        			method:"POST",
//        			argus : {
//        				p_reg_no:GRID.getValue(o.tId,o.tr.rowIndex,"reg_no")
//        				//p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,"company_no"),
//        			},
//        			target:"#contents",
//        			loadui:false
//        		});
//        	}
//        }
        ,
        cell:{
            color:{
                'save'  :'#ff0'
            },
            "company_area":{
                onchange:function(o) {
                    if (confirm("저장하시겠습니까?")) {
                        return true;
                    } else {
                        return false;
                    }
                },
                onblur:function(o) { // event 리턴처리 안됨.
                }
            },
            "state":{
                onchange:function(o) {
                    if (confirm("'"+o.td.firstChild.nodeValue+"' 상태로 변경하시겠습니까?")) {
                        return true;
                    } else {
                        return false;
                    }
                },
                onblur:function(o) { // event 리턴처리 안됨.
                }
            }
        }

    });

    // 기준정보 조회
    callJSONSync('front.ProcBdCd','get',
        {
            p_proc_bd_cd:SOFTMARGUMENT.p_proc_bd_cd
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var  items = json.item;
            if ( json['return'] == '200' ) { 
                if ( items ) {
//                    console.info(items)
                    Form.bind(items,document.iForm,{
                        m_amt:function(f,vv) {
                            $("#m_amt").text(vv.numberFormat());
                        }
                        ,
                        l_amt:function(f,vv) {
                            $("#l_amt").text(vv.numberFormat());
                        }
                        ,
                        e_amt:function(f,vv) {
                            $("#e_amt").text(vv.numberFormat());
                        }
                        ,
                        t_amt:function(f,vv) {
                            $("#t_amt").text(vv.numberFormat());
                        }
                        ,proc_bd_nm :function(f,vv) {$("#proc_bd_nm" ).text(vv);}
                        ,proc_dt_nm :function(f,vv) {$("#proc_dt_nm" ).text(vv);}
                        ,proc_nm    :function(f,vv) {$("#proc_nm"    ).text(vv);}
                        ,proc_it_nm :function(f,vv) {$("#proc_it_nm" ).text(vv);}
                        ,std        :function(f,vv) {$("#std"        ).text(vv);}
                        ,unit       :function(f,vv) {$("[name='unit']").text(vv);}

                    });
                } else {
                }
            } else if (json['return'] == '500') {
            }
        }
    );
    
    조회(getRestoreValue("p_navi_start")?getRestoreValue("p_navi_start"):1);
}

function onLoad(o,argus) { // o.mode : I/U/D/M/R/SORT
    $(".btn_navy").unbind("click");
    $(".btn_navy").click(function(e) {
        e.preventDefault();
        var tbl = $S("tbl_list");
        if ( tbl == null ) return;
        var td = GRID.cell.getTd($(this).get(0));
        var tr = td.parentNode;
        var p_reg_no = GRID.getValue("tbl_list",tr.rowIndex,"REG_NO");
        openPopupDetail (p_reg_no);
    });

    if ( argus.p_reg_no ) {
        openPopupDetail (SOFTMARGUMENT.p_reg_no);
    }

	 // 레이어팝업
	$(".popup_close").click(function(e){
		$(".layer_popup , .bg_popup").fadeOut();
        e.preventDefault();
		//$(this).parent().hide();
	});
}
function openPopupDetail (p_reg_no) {
    $(".layer_popup , .bg_popup").fadeIn();

    // 업체정보 조회
    callJSONSync('front.RegInfo','get',
        {
            p_reg_no:p_reg_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var  items = json.item;
            if ( json['return'] == '200' ) { 
                if ( items ) {
//                    console.info(items)
                    Form.bind(items,null,{
                        company_nm          :function(f,vv) {$("#company_nm"        ).text(vv);}
                       ,company_homepage    :function(f,vv) {$("#company_homepage"  ).text(vv);}
                       ,company_tel         :function(f,vv) {$("#company_tel"       ).text(vv);}
                       ,company_addr        :function(f,vv) {$("#company_addr"      ).text(vv);}
                       ,std                 :function(f,vv) {$("#std"               ).text(vv);}
                       ,company_homepage    :function(f,vv) {$("#company_homepage"  ).text(vv);}
                       ,etc                 :function(f,vv) {
//                        alert(vv);
                           $("#etc"               ).html(vv);
                        }
                       ,m_amt:function(f,vv) {
                            $("#c_m_amt").text(vv.numberFormat());
                        }
                        ,
                        l_amt:function(f,vv) {
                            $("#c_l_amt").text(vv.numberFormat());
                        }
                        ,
                        e_amt:function(f,vv) {
                            $("#c_e_amt").text(vv.numberFormat());
                        }
                        ,
                        t_amt:function(f,vv) {
                            $("#c_t_amt").text(vv.numberFormat());
                        }
                        ,proc_dt_nm     :function(f,vv) {$("#c_proc_dt_nm" ).text(vv);}
                        ,std            :function(f,vv) {$("#std"        ).text(vv);}
                        ,unit           :function(f,vv) {$("[name='c_unit']").text(vv);}
                    });
                } else {
                }
            } else if (json['return'] == '500') {
            }
        }
    );
}
function 지역조회(p_area) {
    조회(1,p_area);
}

function 조회(s,p_area) {
    var f = document.sForm;
    GRID["tbl_list"].setArgus("p_area"          ,p_area?p_area:""           );
    GRID["tbl_list"].setArgus("p_proc_cd"       ,SOFTMARGUMENT.p_proc_cd   );
    GRID["tbl_list"].setArgus("p_proc_it_cd"    ,SOFTMARGUMENT.p_proc_it_cd);
    GRID["tbl_list"].setArgus("p_proc_bd_cd"    ,SOFTMARGUMENT.p_proc_bd_cd);
    //GRID["tbl_list"].setCondition( "USER_LEVEL", ARGUS.p_user_level).setEqual();
    //GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
    //GRID["tbl_list"].setArgus("s_search",f.s_search.value);

    //setRestore("s_l_cat",f.s_l_cat.value);
    setRestore("p_navi_start"   ,s,true);
    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

