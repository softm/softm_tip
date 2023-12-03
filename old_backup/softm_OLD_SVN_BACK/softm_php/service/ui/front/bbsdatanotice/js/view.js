
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_no) {
    call("JSON","front.BbsDataNotice","get",
        {
			p_no:argus.p_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var item = json.item;
            if ( item ) {
                if ( json["return"] == "200" ) { // success
                    // alert(json.message); // success
                    getPhp("front/bbsdatanotice","view",{
                        argus : {p_no:item.no}
                    });
                    onDataLoad(json,argus);
                } else if (json["return"] == "500") {
                    alert(json.message); // error
                }
            } else {
                alert("자료가 없습니다.");
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
                                        + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>";
        }
        Form.bind(json.item,f,{
                CONTENT:function(form,vv) {
                    if ( vv ) {
                    }
                }

        });
    }
}

function 목록() {
	document.body.scrollTop = 0;
	getUI("front/bbsdatanotice","list");
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
