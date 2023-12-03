
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_class_name) {
    call("JSON","test.calkoclassname.CalkoClassName","get",
        {
			p_class_name:argus.p_class_name
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/calkoclassname","write",{
                        argus : {p_class_name:item.class_name}
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
    var exec = false;
    var invalidCb = {
        model_type:function(){ Effect.twinkle(f.model_type);},
        passenger:function(){ Effect.twinkle(f.passenger);},
        velocity:function(){ Effect.twinkle(f.velocity);},
        use_type:function(){ Effect.twinkle(f.use_type);},
        class:function(){ Effect.twinkle(f.class);},
        seq:function(){ Effect.twinkle(f.seq);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.calkoclassname.CalkoClassName',SOFTMARGUMENT.p_class_name?'update':'insert',
            call('JSON','test.calkoclassname.CalkoClassName',SOFTMARGUMENT.p_class_name?'update':'insert',
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
                    class_name:f.class_name.value.trim(),
                    model_type:f.model_type.value.trim(),
                    passenger:f.passenger.value.trim(),
                    velocity:f.velocity.value.trim(),
                    use_type:f.use_type.value.trim(),
                    class:f.class.value.trim(),
                    seq:f.seq.value.trim(),
                    use_yn:f.use_yn.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_class_name = json.p_class_name;
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
	getUI("test/calkoclassname","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.calkoclassname.CalkoClassName","delete",
        {
            p_class_name:SOFTMARGUMENT.p_class_name
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
