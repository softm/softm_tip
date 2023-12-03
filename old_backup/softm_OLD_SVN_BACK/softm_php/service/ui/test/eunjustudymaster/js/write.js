
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_s_id) {
    call("JSON","test.eunjustudymaster.EunJuStudyMaster","get",
        {
			p_s_id:argus.p_s_id
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/eunjustudymaster","write",{
                        argus : {p_s_id:item.s_id}
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
    if ( !(SOFTMARGUMENT.p_s_id) ) { // 입력
        removeClass(f.s_id,"required")
;
    } else {
    }
    var exec = false;
    var invalidCb = {
        yyyy:function(){ Effect.twinkle(f.yyyy);},
        term:function(){ Effect.twinkle(f.term);},
        gubun:function(){ Effect.twinkle(f.gubun);},
        hak:function(){ Effect.twinkle(f.hak);},
        ban:function(){ Effect.twinkle(f.ban);},
        num:function(){ Effect.twinkle(f.num);},
        reg_date:function(){ Effect.twinkle(f.reg_date);},
        user_no:function(){ Effect.twinkle(f.user_no);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.eunjustudymaster.EunJuStudyMaster',SOFTMARGUMENT.p_s_id?'update':'insert',
            call('JSON','test.eunjustudymaster.EunJuStudyMaster',SOFTMARGUMENT.p_s_id?'update':'insert',
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
                    s_id:f.s_id.value.trim(),
                    yyyy:f.yyyy.value.trim(),
                    term:f.term.value.trim(),
                    gubun:f.gubun.value.trim(),
                    hak:f.hak.value.trim(),
                    ban:f.ban.value.trim(),
                    num:f.num.value.trim(),
                    mem_name:f.mem_name.value.trim(),
                    sex:f.sex.value.trim(),
                    result_1:f.result_1.value.trim(),
                    result_2:f.result_2.value.trim(),
                    reg_date:f.reg_date.value.trim(),
                    content:f.content.value.trim(),
                    user_no:f.user_no.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_s_id = json.insert_id;
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
	getUI("test/eunjustudymaster","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.eunjustudymaster.EunJuStudyMaster","delete",
        {
            p_s_id:SOFTMARGUMENT.p_s_id
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
