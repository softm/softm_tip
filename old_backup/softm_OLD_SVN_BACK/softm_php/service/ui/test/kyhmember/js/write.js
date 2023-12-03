
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_no) {
    call("JSON","test.kyhmember.KyhMember","get",
        {
			p_no:argus.p_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/kyhmember","write",{
                        argus : {p_no:item.no}
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
        Form.bind(json.item,f,{
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
    if ( !(SOFTMARGUMENT.p_no) ) { // 입력
        removeClass(f.no,"required")
;
    } else {
    }
    var exec = false;
    var invalidCb = {
        user_id:function(){ Effect.twinkle(f.user_id);},
        member_level:function(){ Effect.twinkle(f.member_level);},
        password:function(){ Effect.twinkle(f.password);},
        post_no:function(){ Effect.twinkle(f.post_no);},
        news_yn:function(){ Effect.twinkle(f.news_yn);},
        reg_date:function(){ Effect.twinkle(f.reg_date);},
        acc_date:function(){ Effect.twinkle(f.acc_date);},
        user_id_open:function(){ Effect.twinkle(f.user_id_open);},
        member_level_open:function(){ Effect.twinkle(f.member_level_open);},
        name_open:function(){ Effect.twinkle(f.name_open);},
        sex_open:function(){ Effect.twinkle(f.sex_open);},
        e_mail_open:function(){ Effect.twinkle(f.e_mail_open);},
        home_open:function(){ Effect.twinkle(f.home_open);},
        tel_open:function(){ Effect.twinkle(f.tel_open);},
        address_open:function(){ Effect.twinkle(f.address_open);},
        post_no_open:function(){ Effect.twinkle(f.post_no_open);},
        point_open:function(){ Effect.twinkle(f.point_open);},
        picture_image_open:function(){ Effect.twinkle(f.picture_image_open);},
        character_image_open:function(){ Effect.twinkle(f.character_image_open);},
        birth_open:function(){ Effect.twinkle(f.birth_open);},
        age_open:function(){ Effect.twinkle(f.age_open);},
        access_open:function(){ Effect.twinkle(f.access_open);},
        nick_name_open:function(){ Effect.twinkle(f.nick_name_open);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.kyhmember.KyhMember',SOFTMARGUMENT.p_no?'update':'insert',
            call('JSON','test.kyhmember.KyhMember',SOFTMARGUMENT.p_no?'update':'insert',
                // 선택1
//                {
//                    class_table:f.class_table.value.trim(),
//                    datbase_name:f.datbase_name.value.trim(),
//                    save_file:f.save_file.value.trim(),
//                    debugging:f.debugging.value.trim()
//                },
                // 선택2
                //{
//                    no:f.no.value.trim(),
//                    user_id:f.user_id.value.trim(),
//                    member_level:f.member_level.value.trim(),
//                    password:f.password.value.trim(),
//                    name:f.name.value.trim(),
//                    sex:f.sex.value.trim(),
//                    e_mail:f.e_mail.value.trim(),
//                    tel:f.tel.value.trim(),
//                    address:f.address.value.trim(),
//                    post_no:f.post_no.value.trim(),
//                    member_st:f.member_st.value.trim(),
//                    news_yn:f.news_yn.value.trim(),
//                    reg_date:f.reg_date.value.trim(),
//                    acc_date:f.acc_date.value.trim(),
//                    jumin:f.jumin.value.trim(),
//                    home:f.home.value.trim(),
//                    point:f.point.value.trim(),
//                    user_id_open:f.user_id_open.value.trim(),
//                    member_level_open:f.member_level_open.value.trim(),
//                    name_open:f.name_open.value.trim(),
//                    sex_open:f.sex_open.value.trim(),
//                    e_mail_open:f.e_mail_open.value.trim(),
//                    home_open:f.home_open.value.trim(),
//                    tel_open:f.tel_open.value.trim(),
//                    address_open:f.address_open.value.trim(),
//                    post_no_open:f.post_no_open.value.trim(),
//                    point_open:f.point_open.value.trim(),
//                    picture_image_open:f.picture_image_open.value.trim(),
//                    character_image_open:f.character_image_open.value.trim(),
//                    birth:f.birth.value.trim(),
//                    age:f.age.value.trim(),
//                    birth_open:f.birth_open.value.trim(),
//                    age_open:f.age_open.value.trim(),
//                    access:f.access.value.trim(),
//                    access_open:f.access_open.value.trim(),
//                    hint:f.hint.value.trim(),
//                    answer:f.answer.value.trim(),
//                    nick_name:f.nick_name.value.trim(),
//                    nick_name_open:f.nick_name_open.value.trim()
                //},
                Form.json(f),
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_no = json.insert_id;
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
	document.body.scrollTop = 0;
	getUI("test/kyhmember","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.kyhmember.KyhMember","delete",
        {
            p_no:SOFTMARGUMENT.p_no
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

function fileDownload(fNo,fNm) {
    alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
        p_file_no:fNo,
        p_file_nm:fNm,
        p_sub_dir:"[디렉토리명]"
     }
    );
} 
