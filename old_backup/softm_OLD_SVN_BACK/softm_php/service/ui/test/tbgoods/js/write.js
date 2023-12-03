if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:serviceBase+"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:serviceBase+"/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_gid) {
    call("JSON","test.tbgoods.TbGoods","get",
        {
			p_gid:argus.p_gid
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/tbgoods","write",{
                        argus : {p_gid:item.gid}
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
    var exec = false;
    var invalidCb = {
        seller_id:function(){ Effect.twinkle(f.seller_id);},
        category:function(){ Effect.twinkle(f.category);},
        viewn:function(){ Effect.twinkle(f.viewn);},
        sale_type:function(){ Effect.twinkle(f.sale_type);},
        sale_ing:function(){ Effect.twinkle(f.sale_ing);},
        gstatus:function(){ Effect.twinkle(f.gstatus);},
        upload_pic:function(){ Effect.twinkle(f.upload_pic);},
        use_option:function(){ Effect.twinkle(f.use_option);},
        gname:function(){ Effect.twinkle(f.gname);},
        model:function(){ Effect.twinkle(f.model);},
        brand:function(){ Effect.twinkle(f.brand);},
        makec:function(){ Effect.twinkle(f.makec);},
        price:function(){ Effect.twinkle(f.price);},
        sale_price:function(){ Effect.twinkle(f.sale_price);},
        dealer_price:function(){ Effect.twinkle(f.dealer_price);},
        asv:function(){ Effect.twinkle(f.asv);},
        size:function(){ Effect.twinkle(f.size);},
        used:function(){ Effect.twinkle(f.used);},
        hdd:function(){ Effect.twinkle(f.hdd);},
        pay_type:function(){ Effect.twinkle(f.pay_type);},
        card_nm:function(){ Effect.twinkle(f.card_nm);},
        qunt:function(){ Effect.twinkle(f.qunt);},
        qunt_control:function(){ Effect.twinkle(f.qunt_control);},
        store_in_day:function(){ Effect.twinkle(f.store_in_day);},
        point:function(){ Effect.twinkle(f.point);},
        freebie:function(){ Effect.twinkle(f.freebie);},
        deliv_price:function(){ Effect.twinkle(f.deliv_price);},
        special:function(){ Effect.twinkle(f.special);},
        comment:function(){ Effect.twinkle(f.comment);},
        date:function(){ Effect.twinkle(f.date);},
        click:function(){ Effect.twinkle(f.click);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','test.tbgoods.TbGoods',SOFTMARGUMENT.p_gid?'update':'insert',
            call('JSON','test.tbgoods.TbGoods',SOFTMARGUMENT.p_gid?'update':'insert',
                // 선택1
//                {
//                    class_table:f.class_table.value.trim(),
//                    datbase_name:f.datbase_name.value.trim(),
//                    save_file:f.save_file.value.trim(),
//                    debugging:f.debugging.value.trim()
//                },
                // 선택2
                //{
//                    gid:f.gid.value.trim(),
//                    seller_id:f.seller_id.value.trim(),
//                    category:f.category.value.trim(),
//                    viewn:f.viewn.value.trim(),
//                    sale_type:f.sale_type.value.trim(),
//                    sale_ing:f.sale_ing.value.trim(),
//                    gstatus:f.gstatus.value.trim(),
//                    upload_pic:f.upload_pic.value.trim(),
//                    use_option:f.use_option.value.trim(),
//                    gname:f.gname.value.trim(),
//                    model:f.model.value.trim(),
//                    brand:f.brand.value.trim(),
//                    makec:f.makec.value.trim(),
//                    price:f.price.value.trim(),
//                    sale_price:f.sale_price.value.trim(),
//                    dealer_price:f.dealer_price.value.trim(),
//                    asv:f.asv.value.trim(),
//                    size:f.size.value.trim(),
//                    used:f.used.value.trim(),
//                    hdd:f.hdd.value.trim(),
//                    pay_type:f.pay_type.value.trim(),
//                    card_nm:f.card_nm.value.trim(),
//                    qunt:f.qunt.value.trim(),
//                    qunt_control:f.qunt_control.value.trim(),
//                    store_in_day:f.store_in_day.value.trim(),
//                    point:f.point.value.trim(),
//                    freebie:f.freebie.value.trim(),
//                    deliv_price:f.deliv_price.value.trim(),
//                    special:f.special.value.trim(),
//                    comment:f.comment.value.trim(),
//                    date:f.date.value.trim(),
//                    click:f.click.value.trim(),
//                    etc:f.etc.value.trim()
                //},
                Form.json(f),
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_gid = json.p_gid;
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
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
	document.body.scrollTop = 0;
	getUI("test/tbgoods","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.tbgoods.TbGoods","delete",
        {
            p_gid:SOFTMARGUMENT.p_gid
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
