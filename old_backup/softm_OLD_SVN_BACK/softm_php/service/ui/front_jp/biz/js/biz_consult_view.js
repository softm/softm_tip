if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var form = $S("wForm");
    if (jQuery.browser.msie) {}
//    alert('argus.p_proc_type : ' + argus.p_proc_type + " / " + 'argus.p_consult_no : ' + argus.p_consult_no );
    if ( argus.p_consult_no ) {
        call("JSON","front_jp.BizConsult","get",
            {
                p_consult_no:argus.p_consult_no
             //p_user_no:argus.p_user_no
            },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                if ( json["return"] == "200" ) { // success
                    var item = json.item;
                    getPhp("front_jp/biz","biz_consult_view",{
                        method:"POST",
                        argus : {
                            p_consult_no:item.consult_no,
                            p_company_no:item.company_no,
                            p_hope_biz_type:item.hope_biz_type,
                            p_open_limit:item.open_limit,
                            p_possible_lang:item.possible_lang
                        },
                        target:"#contents",
                        cb:function() {
                            onDataLoad(json,argus);
                        }
                    });
                    // loadui가 true
                    //onDataLoad(json,argus)
                } else if (json["return"] == "500") {
                    alert(json.message); // error
                }
            }
        );
    } else {
        // form.tel1.onfocus = Form.numeberOnly;
    }
}

function onDataLoad(json,argus) {
    var form = $S("wForm");
    if ( json ) {
    	if ( (json.filename1) ) {
    		$S("file1_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno1 + "','f1_" + argus.p_consult_no + "_');return false;\">" 
    		                            + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>";
    	}
    	if ( (json.filename2) ) {
    		$S("file2_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno2 + "','f2_" + argus.p_consult_no + "_');return false;\">" 
            + ( json.filename2 + ((json.fileext2)?".":"") + (json.fileext2) ) + "</a>";
    	}
    	if ( (json.filename3) ) {
    		$S("file3_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno3 + "','f3_" + argus.p_consult_no + "_');return false;\">" 
            + ( json.filename3 + ((json.fileext3)?".":"") + (json.fileext3) ) + "</a>";
    	}    	
    	Form.bind(json.fi,json.item,$S("wForm"),{
			tel:function(form,vv) {
				if ( vv ) {
					var vvS = vv.split("-");
					form.tel1.value = vvS[0];
					form.tel2.value = vvS[1];
					form.tel3.value = vvS[2];
				}
			},
			hp:function(form,vv) {
				if ( vv ) {
					var vvS = vv.split("-");
					form.hp1.value = vvS[0];
					form.hp2.value = vvS[1];
					form.hp3.value = vvS[2];
				}
			},
			fax:function(form,vv) {
				if ( vv ) {
					var vvS = vv.split("-");
					form.fax1.value = vvS[0];
					form.fax2.value = vvS[1];
					form.fax3.value = vvS[2];
				}
			}
	    });
    }
}

/**
 * 마이페이지 상담리스트에서 접근한경우 목록복귀
 */
function mypageList() {
    if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
    getUI("front_jp/biz","biz_consult_list");
}

function fileDownload(fNo,fNm) {
//    alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
    		p_file_no:fNo,
    		p_file_nm:fNm,
    		p_sub_dir:"biz"
    	}
    );
}

function fileDownloadCompany(fNo,fNm) {
    //alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
    		p_file_no:fNo,
    		p_file_nm:fNm,
    		p_sub_dir:"company"
    	}
    );
}