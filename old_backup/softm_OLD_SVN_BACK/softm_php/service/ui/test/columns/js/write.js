
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( ) {
    call("JSON","test.columns.Columns","get",
        {
			
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/columns","write",{
                        argus : {}
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
        table_schema:function(){ Effect.twinkle(f.table_schema);},
        table_name:function(){ Effect.twinkle(f.table_name);},
        column_name:function(){ Effect.twinkle(f.column_name);},
        ordinal_position:function(){ Effect.twinkle(f.ordinal_position);},
        is_nullable:function(){ Effect.twinkle(f.is_nullable);},
        data_type:function(){ Effect.twinkle(f.data_type);},
        column_type:function(){ Effect.twinkle(f.column_type);},
        column_key:function(){ Effect.twinkle(f.column_key);},
        extra:function(){ Effect.twinkle(f.extra);},
        privileges:function(){ Effect.twinkle(f.privileges);},
        column_comment:function(){ Effect.twinkle(f.column_comment);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        alert('update/insert 조건 확인하세요.');
        //  call('FORM.FILE','test.columns.Columns',true?'update':'insert',
            call('JSON','test.columns.Columns',true?'update':'insert',
        //  call('FORM.FILE','test.columns.Columns',?'update':'insert',
        //  call('JSON','test.columns.Columns',?'update':'insert',
                // 선택1
//                {
//                    class_table:f.class_table.value.trim(),
//                    datbase_name:f.datbase_name.value.trim(),
//                    save_file:f.save_file.value.trim(),
//                    debugging:f.debugging.value.trim()
//                },
                // 선택2
                {
                    table_catalog:f.table_catalog.value.trim(),
                    table_schema:f.table_schema.value.trim(),
                    table_name:f.table_name.value.trim(),
                    column_name:f.column_name.value.trim(),
                    ordinal_position:f.ordinal_position.value.trim(),
                    column_default:f.column_default.value.trim(),
                    is_nullable:f.is_nullable.value.trim(),
                    data_type:f.data_type.value.trim(),
                    character_maximum_length:f.character_maximum_length.value.trim(),
                    character_octet_length:f.character_octet_length.value.trim(),
                    numeric_precision:f.numeric_precision.value.trim(),
                    numeric_scale:f.numeric_scale.value.trim(),
                    character_set_name:f.character_set_name.value.trim(),
                    collation_name:f.collation_name.value.trim(),
                    column_type:f.column_type.value.trim(),
                    column_key:f.column_key.value.trim(),
                    extra:f.extra.value.trim(),
                    privileges:f.privileges.value.trim(),
                    column_comment:f.column_comment.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
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
	getUI("test/columns","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.columns.Columns","delete",
        {
            
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
