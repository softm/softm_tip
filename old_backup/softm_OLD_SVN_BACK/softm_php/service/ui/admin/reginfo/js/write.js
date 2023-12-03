if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:serviceBase+"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:serviceBase+"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_reg_no) {
        callJSONSync("admin.RegInfo","get",
            {
                p_reg_no:argus.p_reg_no
            },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                var item = json.item;
                if ( item ) {
                    if ( json["return"] == "200" ) { // success
                        // alert(json.message); // success
                        getPhp("admin/reginfo","write",{
                            argus : {p_reg_no:item.REG_NO}
                        });
                    } else if (json["return"] == "500") {
                        alert(json.message); // error
                    }
                    argus.p_proc_cd  = item.PROC_CD;
                    argus.p_proc_it_cd = item.PROC_IT_CD;
                    argus.p_proc_bd_cd = item.PROC_BD_CD;
//                    console.info(argus.p_proc_cd,argus.proc_it_cd,argus.proc_bd_cd);
                    loadSelectBox(argus);
//                    console.info(json,argus);
                    onDataLoad(json,argus);
                } else {
                    alert("수정할 자료가 없습니다.");
                    목록();
                }
            }
        );
    } else {
        loadSelectBox(argus);
        onDataLoad(null,argus);
    // form.tel1.onfocus = Form.numeberOnly;
    }
    $("#m_amt,#l_amt,#e_amt").keyup(function(e) {
        $("#t_amt").val( ( parseInt($("#m_amt").val()?$("#m_amt").val():0,10) + parseInt($("#l_amt").val()?$("#l_amt").val():0,10) + parseInt($("#e_amt").val()?$("#e_amt").val():0,10) ).numberFormat() );
    });
}

function loadSelectBox(argus) {
    callJSONSync('common.Common','getProcegory',
        	{},
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                var  items = json.item;
                if ( json['return'] == '200' ) { // success      
                	$("#p_proc_cd").find('option').remove();
            		$("#p_proc_cd").append("<option value=''>-선택-</option>");
                    if ( items && items.PROC_CD  ) {
                        $("#p_proc_cd").append("<option value='"+items.PROC_CD+"'>"+items.PROC_NM+"</option>");
                    } else {
                        $.each(items, function(key, value) {
                            $("#p_proc_cd").append("<option value='"+value.PROC_CD+"'>"+value.PROC_NM+"</option>");
                        });
                    }
                    if ( argus.p_proc_cd ) {
                        $("#p_proc_cd").val(argus.p_proc_cd);
                    }
                    $("#p_proc_cd").change(function(e) {
                        callJSONSync('common.Common','getProcItCdegory',
                            {
                                proc_cd:$("#p_proc_cd").val()
                            },
                            function(xmlDoc){
                                var json  = Util.xml2json(xmlDoc);
                                $("#p_proc_it_cd").find('option').remove();
                                var  items = json.item;

                                if ( json['return'] == '200' ) { 
                                    if ( items ) {
                                        if ( items.PROC_IT_CD ) {
                                            $("#p_proc_it_cd").append("<option value='"+items.PROC_IT_CD+"'>"+items.PROC_IT_NM+"</option>");
                                        } else {
                                            $.each(items, function(key, value) {
                                                $("#p_proc_it_cd").append("<option value='"+value.PROC_IT_CD+"'>"+value.PROC_IT_NM+"</option>");
                                            });
                                        }
                                    } else {
                                        $("#p_proc_it_cd").append("<option value=''>-없음-</option>");
                                    }

                                } else if (json['return'] == '500') {
                                }

                                if ( argus.p_proc_it_cd ) {
                                    $("#p_proc_it_cd").val(argus.p_proc_it_cd);
                                }

                                $("#p_proc_it_cd").change(function(e) {
                                    callJSONSync('common.Common','getProcBdCdegory',
                                        {
                                            proc_it_cd:$("#p_proc_it_cd").val()
                                        },
                                        function(xmlDoc){
                                            var json  = Util.xml2json(xmlDoc);
                                            $("#p_proc_bd_cd").find('option').remove();
                                            var  items = json.item;
                                            if ( json['return'] == '200' ) { 
                                                if ( items ) {
                                                    if ( items.PROC_BD_CD ) {
                                                        $("#p_proc_bd_cd").append("<option value='"+items.PROC_BD_CD+"'>"+items.PROC_BD_NM+"</option>");
                                                    } else {
                                                        $.each(items, function(key, value) {
                                                            $("#p_proc_bd_cd").append("<option value='"+value.PROC_BD_CD+"'>"+value.PROC_BD_NM+"</option>");
                                                        });
                                                    }
                                                } else {
                                                    $("#p_proc_bd_cd").append("<option value=''>-없음-</option>");
                                                }
                                            } else if (json['return'] == '500') {
                                            }
                                            $("#p_proc_bd_cd").trigger("change");
                                            if ( argus.p_proc_bd_cd ) {
                                                $("#p_proc_bd_cd").val(argus.p_proc_bd_cd);
                                            }
                                        }
                                    );
                                    if ( $("#p_proc_it_cd").val() ) {
                                        $("#proc_it_nm").val($("#p_proc_it_cd option:selected").text()).focus();
                                    } else {
                                        $("#proc_it_nm").val("");
                                    }
                                });
                                $("#p_proc_it_cd").trigger("change");
                            }
                        );
                    });

                    $("#p_proc_bd_cd").change(function(e) {
                            if ( $("#p_proc_bd_cd").val() ) {
                                $("#proc_bd_nm").val($("#p_proc_bd_cd option:selected").text()).focus();
                            } else {
                                $("#proc_bd_nm").val("");
                            }
                    });
                    $("#p_proc_cd").trigger("change");

                } else if (json['return'] == '500') {
                    alert(json.message); // error
                }
            }
            // requestType이 FORM, FORM.FILE의 경우 
            //,f
    );
}

function onDataLoad(json,argus) {
    var f = document.wForm;
    if(json) {
        Form.bind(json.item,f,{
            reg_no:function(f,vv) {
               if ( vv ) {
                f.p_reg_no.value = vv;  
               }
            }
            ,
            proc_cd:function(f,vv) {
               if ( vv ) {
                f.p_proc_cd.value = vv;  
               }
            }
            ,
            proc_it_cd:function(f,vv) {
               if ( vv ) {
                f.p_proc_it_cd.value = vv;  
               }
            }
            ,
            proc_bd_cd:function(f,vv) {
               if ( vv ) {
                f.p_proc_bd_cd.value = vv;  
               }
            }
            ,
            company_tel:function(form,vv) {
                if ( vv ) {
                    var vvS = vv.split("-");
                    form.company_tel1.value = vvS[0];
                    form.company_tel2.value = vvS[1];
                    form.company_tel3.value = vvS[2];
                }
            }
            ,
            m_amt:function(form,vv) {
                form.t_amt.value = (parseInt(json.item.M_AMT,10) +  parseInt(json.item.L_AMT,10) + parseInt(json.item.E_AMT,10)).numberFormat();
            }
        });
    }
}

function 실행() {
    var f = $S('wForm');
    if ( !(SOFTMARGUMENT.p_reg_no) ) { // 입력
        removeClass(f.reg_no,"required");
    } else {
    }

    if ( $S('wForm').company_tel1.value != '' || $S('wForm').company_tel2.value != '' || $S('wForm').company_tel3.value != ''  )
    {
        addClass($S('wForm').company_tel1,"required");
        addClass($S('wForm').company_tel2,"required");
        addClass($S('wForm').company_tel3,"required");
    } else {
        removeClass($S('wForm').company_tel1,"required");
        removeClass($S('wForm').company_tel2,"required");
        removeClass($S('wForm').company_tel3,"required");
    }

    var exec = false;
    var invalidCb = {
    };
    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','admin.RegInfo',SOFTMARGUMENT.p_reg_no?'update':'insert',
            call('JSON','admin.RegInfo',SOFTMARGUMENT.p_reg_no?'update':'insert',
                Form.json(f)
                ,
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_reg_no = json.insert_id;
                        }
                        //$S('btn_list').click();
                        onInit(SOFTMARGUMENT);
                        alert(json.message); // success
                        목록();
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

function 목록() {
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
	document.body.scrollTop = 0;
	getUI("admin/reginfo","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","admin.RegInfo","delete",
        {
            p_reg_no:SOFTMARGUMENT.p_reg_no
        },
        function(xmlDoc){
             var json  = Util.xml2json(xmlDoc);
             if ( json["return"] == "200" ) { // success
                 alert(json.message); // success
                 목록();
             } else if (json["return"] == "500") {
                 alert(json.message); // error
             }
         }
         );
    }
return false;
}
