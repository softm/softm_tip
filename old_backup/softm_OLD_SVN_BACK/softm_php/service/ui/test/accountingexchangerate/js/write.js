if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_accounting_no) {
    call("JSON","test.accountingexchangerate.AccountingExchangeRate","get",
        {
			p_accounting_no:argus.p_accounting_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/accountingexchangerate","write",{
                        argus : {p_accounting_no:item.accounting_no}
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
    if ( !(SOFTMARGUMENT.p_accounting_no) ) { // 입력
        removeClass(f.accounting_no,"required")
;
    } else {
    }
    var exec = false;
    var invalidCb = {
        country_code:function(){ Effect.twinkle(f.country_code);},
        class_name:function(){ Effect.twinkle(f.class_name);},
        accounting_year:function(){ Effect.twinkle(f.accounting_year);},
        reg_user_id:function(){ Effect.twinkle(f.reg_user_id);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.accountingexchangerate.AccountingExchangeRate',SOFTMARGUMENT.p_accounting_no?'update':'insert',
            call('JSON','test.accountingexchangerate.AccountingExchangeRate',SOFTMARGUMENT.p_accounting_no?'update':'insert',
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
                    accounting_no:f.accounting_no.value.trim(),
                    country_code:f.country_code.value.trim(),
                    class_name:f.class_name.value.trim(),
                    accounting_year:f.accounting_year.value.trim(),
                    margin_rate:f.margin_rate.value.trim(),
                    markup_rate:f.markup_rate.value.trim(),
                    sgna_rate:f.sgna_rate.value.trim(),
                    exchange_rate:f.exchange_rate.value.trim(),
                    use_yn:f.use_yn.value.trim(),
                    reg_date:f.reg_date.value.trim(),
                    mod_date:f.mod_date.value.trim(),
                    reg_user_id:f.reg_user_id.value.trim(),
                    mod_user_id:f.mod_user_id.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_accounting_no = json.insert_id;
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
	getUI("test/accountingexchangerate","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.accountingexchangerate.AccountingExchangeRate","delete",
        {
            p_accounting_no:SOFTMARGUMENT.p_accounting_no
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
