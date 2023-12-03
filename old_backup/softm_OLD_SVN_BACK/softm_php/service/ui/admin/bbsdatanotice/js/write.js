
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_no) {
    call("JSON","admin.BbsDataNotice","get",
        {
			p_no:argus.p_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("admin/bbsdatanotice","write",{
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
        console.info(json.filename1);
        if ( (json.filename1) ) {
            $S("file1_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno1 + "','f1_" + argus.p_no + "_');return false;\">" 
                                        + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>"
                                        + "<INPUT TYPE=CHECKBOX name=file1_delete value='Y'> 삭제" ;
        }
        Form.bind(json.item,f,{
                CONTENT:function(form,vv) {
                    if ( vv ) {
                    }
                }

        });
    }
}

function 실행() {
    var f = $S('wForm');
    var exec = false;
    var invalidCb = {
    };

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }
        if ( exec ) {
        // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
        //  call(requestType,className,method,argus,cb,form)
            call('FORM.FILE','admin.BbsDataNotice',SOFTMARGUMENT.p_no?'update':'insert',
//          call('JSON','admin.BbsDataNotice',SOFTMARGUMENT.p_no?'update':'insert',
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
                    p_test:"Y"
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_no = json.p_no;
                        }
                        //$S('btn_list').click();
                        //onInit(SOFTMARGUMENT);
                        alert(json.message); // success
                        목록();
                    } else if (json['return'] == '500') {
                        alert(json.message); // error
                    }
                }
                // requestType이 FORM, FORM.FILE의 경우 
                ,f
            );
        }
    }
    return false;
}

function 목록() {
	document.body.scrollTop = 0;
	getUI("admin/bbsdatanotice","list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","admin.BbsDataNotice","delete",
        {
            p_no:SOFTMARGUMENT.p_no
        },
        function(xmlDoc){
             var json  = Util.xml2json(xmlDoc);
             if ( json["return"] == "200" ) { // success
                alert(json.message); // success
//                목록();
                document.location.href= "/admin_bbs.php";
             } else if (json["return"] == "500") {
                 alert(json.message); // error
             }
         }
         );
    }
return false;
}

function fileDownload(fNo,fNm) {
//    alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
    		p_file_no:fNo,
    		p_file_nm:fNm,
    		p_sub_dir:"bbsnotice"
    	}
    );
}