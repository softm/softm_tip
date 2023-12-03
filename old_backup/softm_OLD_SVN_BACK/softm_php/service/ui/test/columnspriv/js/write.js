
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_host && argus.p_db && argus.p_user && argus.p_table_name && argus.p_column_name) {
    call("JSON","test.columnspriv.ColumnsPriv","get",
        {
			p_host:argus.p_host,
        				p_db:argus.p_db,
        				p_user:argus.p_user,
        				p_table_name:argus.p_table_name,
        				p_column_name:argus.p_column_name
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/columnspriv","write",{
                        argus : {p_host:item.host,
p_db:item.db,
p_user:item.user,
p_table_name:item.table_name,
p_column_name:item.column_name}
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
        timestamp:function(){ Effect.twinkle(f.timestamp);},
        column_priv:function(){ Effect.twinkle(f.column_priv);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.columnspriv.ColumnsPriv',SOFTMARGUMENT.p_host&&SOFTMARGUMENT.p_db&&SOFTMARGUMENT.p_user&&SOFTMARGUMENT.p_table_name&&SOFTMARGUMENT.p_column_name?'update':'insert',
            call('JSON','test.columnspriv.ColumnsPriv',SOFTMARGUMENT.p_host&&SOFTMARGUMENT.p_db&&SOFTMARGUMENT.p_user&&SOFTMARGUMENT.p_table_name&&SOFTMARGUMENT.p_column_name?'update':'insert',
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
                    host:f.host.value.trim(),
                    db:f.db.value.trim(),
                    user:f.user.value.trim(),
                    table_name:f.table_name.value.trim(),
                    column_name:f.column_name.value.trim(),
                    timestamp:f.timestamp.value.trim(),
                    column_priv:f.column_priv.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_host = json.p_host;
                            SOFTMARGUMENT.p_db = json.p_db;
                            SOFTMARGUMENT.p_user = json.p_user;
                            SOFTMARGUMENT.p_table_name = json.p_table_name;
                            SOFTMARGUMENT.p_column_name = json.p_column_name;
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
	getUI("test/columnspriv","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.columnspriv.ColumnsPriv","delete",
        {
            p_host:SOFTMARGUMENT.p_host,
            p_db:SOFTMARGUMENT.p_db,
            p_user:SOFTMARGUMENT.p_user,
            p_table_name:SOFTMARGUMENT.p_table_name,
            p_column_name:SOFTMARGUMENT.p_column_name
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
