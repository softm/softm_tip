
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( ) {
    call("JSON","test.kyhpost.KyhPost","get",
        {
			
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("test/kyhpost","write",{
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
        zipcode:function(){ Effect.twinkle(f.zipcode);},
        dong:function(){ Effect.twinkle(f.dong);},
        st:function(){ Effect.twinkle(f.st);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
        alert('update/insert 조건 확인하세요.');
        //  call('FORM.FILE','test.kyhpost.KyhPost',true?'update':'insert',
            call('JSON','test.kyhpost.KyhPost',true?'update':'insert',
        //  call('FORM.FILE','test.kyhpost.KyhPost',?'update':'insert',
        //  call('JSON','test.kyhpost.KyhPost',?'update':'insert',
                // 선택1
//                {
//                    class_table:f.class_table.value.trim(),
//                    datbase_name:f.datbase_name.value.trim(),
//                    save_file:f.save_file.value.trim(),
//                    debugging:f.debugging.value.trim()
//                },
                // 선택2
                //{
//                    zipcode:f.zipcode.value.trim(),
//                    sido:f.sido.value.trim(),
//                    gugun:f.gugun.value.trim(),
//                    dong:f.dong.value.trim(),
//                    ri:f.ri.value.trim(),
//                    bunji:f.bunji.value.trim(),
//                    st:f.st.value.trim()
                //},
                Form.json(f),
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
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
	getUI("test/kyhpost","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","test.kyhpost.KyhPost","delete",
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
