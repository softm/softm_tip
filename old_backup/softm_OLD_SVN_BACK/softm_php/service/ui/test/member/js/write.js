if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_user_no) {
    call("JSON","test.member.Member","get",
        {
			p_user_no:argus.p_user_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/member","write",{
                        argus : {p_user_no:item.user_no}
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
    if ( !(SOFTMARGUMENT.p_user_no) ) { // 입력
        removeClass(f.user_no,"required")
;
    } else {
    }
    var exec = false;
    var invalidCb = {
        user_id:function(){ Effect.twinkle(f.user_id);},
        user_level:function(){ Effect.twinkle(f.user_level);},
        passwd:function(){ Effect.twinkle(f.passwd);},
        user_name:function(){ Effect.twinkle(f.user_name);},
        company_name:function(){ Effect.twinkle(f.company_name);},
        state:function(){ Effect.twinkle(f.state);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.member.Member',SOFTMARGUMENT.p_user_no?'update':'insert',
            call('JSON','test.member.Member',SOFTMARGUMENT.p_user_no?'update':'insert',
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
                    user_no:f.user_no.value.trim(),
                    user_id:f.user_id.value.trim(),
                    user_level:f.user_level.value.trim(),
                    passwd:f.passwd.value.trim(),
                    user_name:f.user_name.value.trim(),
                    nick_name:f.nick_name.value.trim(),
                    company_name:f.company_name.value.trim(),
                    country_code:f.country_code.value.trim(),
                    sex:f.sex.value.trim(),
                    e_mail:f.e_mail.value.trim(),
                    jumin_no:f.jumin_no.value.trim(),
                    company_no:f.company_no.value.trim(),
                    tel1:f.tel1.value.trim(),
                    tel2:f.tel2.value.trim(),
                    tel3:f.tel3.value.trim(),
                    tel4:f.tel4.value.trim(),
                    address1:f.address1.value.trim(),
                    address2:f.address2.value.trim(),
                    post_no:f.post_no.value.trim(),
                    email_yn:f.email_yn.value.trim(),
                    access:f.access.value.trim(),
                    reg_date:f.reg_date.value.trim(),
                    acc_date:f.acc_date.value.trim(),
                    state:f.state.value.trim(),
                    agreement:f.agreement.value.trim(),
                    agreement_date:f.agreement_date.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_user_no = json.insert_id;
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
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
	document.body.scrollTop = 0;
	getUI("test/member","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.member.Member","delete",
        {
            p_user_no:SOFTMARGUMENT.p_user_no
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
