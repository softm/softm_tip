
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_qna_no) {
	    call("JSON","admin.Qna","get",
	        {
				p_qna_no:argus.p_qna_no
	        },
	        function(xmlDoc){
	            var json  = Util.xml2json(xmlDoc);
	            var item = json.item;
	            if ( item ) {
	                if ( json["return"] == "200" ) { // success
	                    // alert(json.message); // success
	                    getPhp("admin/qna","write",{
	                        argus : {p_qna_no:item.qna_no}
	                    });
	                    onDataLoad(json,argus);
	                    $("btnDel").show();
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
    if ( !(SOFTMARGUMENT.p_qna_no) ) { // 입력
        removeClass(f.qna_no,"required")
;
    } else {
    }
    var exec = false;
    var invalidCb = {
        q_content:function(){ Effect.twinkle(f.q_content);},
        a_content:function(){ Effect.twinkle(f.a_content);},
        qna_state:function(){ Effect.twinkle(f.qna_state);},
        reg_date:function(){ Effect.twinkle(f.reg_date);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        //  call('FORM.FILE','admin.Qna',SOFTMARGUMENT.p_qna_no?'update':'insert',
            call('JSON','admin.Qna',SOFTMARGUMENT.p_qna_no?'update':'insert',
                // 선택1
//                {
//                    class_comment:f.class_comment.value.trim(),
//                    class_table:f.class_table.value.trim(),
//                    datbase_name:f.datbase_name.value.trim(),
//                    save_file:f.save_file.value.trim(),
//                    debugging:f.debugging.value.trim()
//                },
                // 선택2
                Form.json(f),
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_qna_no = json.insert_id;
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
	getUI("admin/qna","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","admin.Qna","delete",
        {
            p_qna_no:SOFTMARGUMENT.p_qna_no
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
