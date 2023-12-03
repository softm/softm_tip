
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_proc_bd_cd_no) {
    call("JSON","test.procbdcd.ProcBdCd","get",
        {
			p_proc_bd_cd_no:argus.p_proc_bd_cd_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/procbdcd","write",{
                        argus : {p_proc_bd_cd_no:item.proc_bd_cd_no}
                    });
                    onDataLoad(json,argus);
                } else if (json["return"] == "500") {
                    alert(json.message); // error
                }
            } else {
                alert("수정할 자료가 없습니다.");
                목록();
            }
        }
    );
    } else {
        onDataLoad(null,argus);
    // form.tel1.onfocus = Form.numeberOnly;
    }

}

function onDataLoad(json,argus) {
    var f = document.wForm;
    if(json) {
        Form.bind(json.fi,json.item,f,{
//    company_code:function(f,vv) {
//       if ( vv ) {
//       f.company_code3.value = vv.substring(5);  
//       }
//       }
        });
    }
}

function 실행() {
    var f = $S('wForm');
    if ( !(SOFTMARGUMENT.p_proc_bd_cd_no) ) { // 입력
        removeClass(f.proc_bd_cd_no,"required")
;
    } else {
    }
    var exec = false;
    var invalidCb = {
        proc_bd_cd:function(){ Effect.twinkle(f.proc_bd_cd);},
        proc_bd_nm:function(){ Effect.twinkle(f.proc_bd_nm);},
        proc_dt_nm:function(){ Effect.twinkle(f.proc_dt_nm);},
        proc_cd:function(){ Effect.twinkle(f.proc_cd);},
        proc_it_cd:function(){ Effect.twinkle(f.proc_it_cd);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.procbdcd.ProcBdCd',SOFTMARGUMENT.p_proc_bd_cd_no?'update':'insert',
            call('JSON','test.procbdcd.ProcBdCd',SOFTMARGUMENT.p_proc_bd_cd_no?'update':'insert',
                // 선택1
//                {
//                    class_comment:f.class_comment.value.trim(),
//                    class_table:f.class_table.value.trim(),
//                    datbase_name:f.datbase_name.value.trim(),
//                    save_file:f.save_file.value.trim(),
//                    debugging:f.debugging.value.trim()
//                },
                // 선택2
                {
                    proc_bd_cd_no:f.proc_bd_cd_no.value.trim(),
                    proc_bd_cd:f.proc_bd_cd.value.trim(),
                    proc_bd_nm:f.proc_bd_nm.value.trim(),
                    proc_dt_nm:f.proc_dt_nm.value.trim(),
                    proc_cd:f.proc_cd.value.trim(),
                    proc_it_cd:f.proc_it_cd.value.trim(),
                    std:f.std.value.trim(),
                    unit:f.unit.value.trim(),
                    m_amt:f.m_amt.value.trim(),
                    l_amt:f.l_amt.value.trim(),
                    e_amt:f.e_amt.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_proc_bd_cd_no = json.insert_id;
                        }
                        //$S('btn_list').click();
                        onInit(SOFTMARGUMENT);
                        alert(json.message); // success
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
	document.body.scrollTop = 0;
	getUI("test/procbdcd","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.procbdcd.ProcBdCd","delete",
        {
            p_proc_bd_cd_no:SOFTMARGUMENT.p_proc_bd_cd_no
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
