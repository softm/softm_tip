
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_post_seq) {
    call("JSON","test.post.Post","get",
        {
			p_post_seq:argus.p_post_seq
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/post","write",{
                        argus : {p_post_seq:item.post_seq}
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
    if ( !(SOFTMARGUMENT.p_post_seq) ) { // 입력
        removeClass(f.post_seq,"required")
;
    } else {
    }
    var exec = false;
    var invalidCb = {
        zipcode:function(){ Effect.twinkle(f.zipcode);},
        sido:function(){ Effect.twinkle(f.sido);},
        gugun:function(){ Effect.twinkle(f.gugun);},
        dong:function(){ Effect.twinkle(f.dong);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.post.Post',SOFTMARGUMENT.p_post_seq?'update':'insert',
            call('JSON','test.post.Post',SOFTMARGUMENT.p_post_seq?'update':'insert',
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
                    post_seq:f.post_seq.value.trim(),
                    zipcode:f.zipcode.value.trim(),
                    sido:f.sido.value.trim(),
                    gugun:f.gugun.value.trim(),
                    dong:f.dong.value.trim(),
                    bunji:f.bunji.value.trim(),
                    x1:f.x1.value.trim(),
                    y1:f.y1.value.trim(),
                    x2:f.x2.value.trim(),
                    y2:f.y2.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_post_seq = json.insert_id;
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
	getUI("test/post","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.post.Post","delete",
        {
            p_post_seq:SOFTMARGUMENT.p_post_seq
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
