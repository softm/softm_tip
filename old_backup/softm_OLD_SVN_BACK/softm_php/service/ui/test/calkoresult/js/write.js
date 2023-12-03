if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_esti_no && argus.p_seq) {
    call("JSON","test.calkoresult.CalkoResult","get",
        {
			p_esti_no:argus.p_esti_no,
        				p_seq:argus.p_seq
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/calkoresult","write",{
                        argus : {p_esti_no:item.esti_no,
p_seq:item.seq}
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
        qty:function(){ Effect.twinkle(f.qty);},
        code:function(){ Effect.twinkle(f.code);},
        value:function(){ Effect.twinkle(f.value);},
        standard:function(){ Effect.twinkle(f.standard);},
        category:function(){ Effect.twinkle(f.category);},
        reg_user_id:function(){ Effect.twinkle(f.reg_user_id);},
        reg_user_email:function(){ Effect.twinkle(f.reg_user_email);},
        o_seq:function(){ Effect.twinkle(f.o_seq);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.calkoresult.CalkoResult',SOFTMARGUMENT.p_esti_no&&SOFTMARGUMENT.p_seq?'update':'insert',
            call('JSON','test.calkoresult.CalkoResult',SOFTMARGUMENT.p_esti_no&&SOFTMARGUMENT.p_seq?'update':'insert',
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
                    esti_no:f.esti_no.value.trim(),
                    seq:f.seq.value.trim(),
                    qty:f.qty.value.trim(),
                    code:f.code.value.trim(),
                    value:f.value.value.trim(),
                    specification:f.specification.value.trim(),
                    standard:f.standard.value.trim(),
                    pre_crc_code:f.pre_crc_code.value.trim(),
                    category:f.category.value.trim(),
                    mat_no:f.mat_no.value.trim(),
                    crc_xml_data:f.crc_xml_data.value.trim(),
                    save_xml_data:f.save_xml_data.value.trim(),
                    send_xml_data:f.send_xml_data.value.trim(),
                    log_xml_data:f.log_xml_data.value.trim(),
                    tp_xml_data:f.tp_xml_data.value.trim(),
                    opt_amt:f.opt_amt.value.trim(),
                    tp_amt:f.tp_amt.value.trim(),
                    crc_send_date:f.crc_send_date.value.trim(),
                    crc_recv_date:f.crc_recv_date.value.trim(),
                    tp_send_date:f.tp_send_date.value.trim(),
                    tp_recv_date:f.tp_recv_date.value.trim(),
                    save_date:f.save_date.value.trim(),
                    sap_esti_no:f.sap_esti_no.value.trim(),
                    send_mail:f.send_mail.value.trim(),
                    send_mail_date:f.send_mail_date.value.trim(),
                    state:f.state.value.trim(),
                    margin_rate:f.margin_rate.value.trim(),
                    markup_rate:f.markup_rate.value.trim(),
                    sgna_rate:f.sgna_rate.value.trim(),
                    exchange_rate:f.exchange_rate.value.trim(),
                    copy_esti_no:f.copy_esti_no.value.trim(),
                    copy_seq:f.copy_seq.value.trim(),
                    reg_date:f.reg_date.value.trim(),
                    reg_user_id:f.reg_user_id.value.trim(),
                    reg_user_email:f.reg_user_email.value.trim(),
                    o_seq:f.o_seq.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_esti_no = json.p_esti_no;
                            SOFTMARGUMENT.p_seq = json.p_seq;
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
	getUI("test/calkoresult","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.calkoresult.CalkoResult","delete",
        {
            p_esti_no:SOFTMARGUMENT.p_esti_no,
            p_seq:SOFTMARGUMENT.p_seq
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
