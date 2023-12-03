if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}
var P_ENGINEER_NO = 0;
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    P_ENGINEER_NO = argus.p_engineer_no;    
    if ( P_ENGINEER_NO ) {
	    call("JSON","front_jp.JpEngineer","get",
	        {
				p_engineer_no:argus.p_engineer_no
	        },
	        function(xmlDoc){
	            var json  = Util.xml2json(xmlDoc);
	            var item = json.item;
	            if ( item ) {
	                if ( json["return"] == "200" ) { // success
	                    // alert(json.message); // success
	                    getPhp("front_jp/engineer","jp_engineer_write",{
	                        argus : {p_engineer_no:item.engineer_no}
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
        if ( toValue(json.fileno1) ) {
            $S("file1_infor").innerHTML = "<a href=# onclick=\"파일다운로드('" + json.fileno1 + "','f1_" + P_ENGINEER_NO + "_');return false;\">"
                                        + ( json.filename1 + (toValue(json.fileext1)?".":"") + toValue(json.fileext1) ) + "</a>"
                                        + "<INPUT TYPE=CHECKBOX name=file1_delete value='Y'> 삭제" ;
        } else {
            $S("file1_infor").innerHTML = "";
        }
        if ( toValue(json.fileno2) ) {
            $S("file2_infor").innerHTML = "<a href=# onclick=\"파일다운로드('" + json.fileno2 + "','f2_" + P_ENGINEER_NO + "_');return false;\">"
            + ( json.filename2 + (toValue(json.fileext2)?".":"") + toValue(json.fileext2) ) + "</a>"
            + "<INPUT TYPE=CHECKBOX name=file2_delete value='Y'> 삭제" ;
        } else {
            $S("file2_infor").innerHTML = "";
        }    	
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
        nm_kr:function(){ Effect.twinkle(f.nm_kr);}
};

    if ( Form.validate(f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }

        if ( exec ) {
            call('FORM.FILE','front_jp.JpEngineer',P_ENGINEER_NO?'update':'insert',
                {
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_engineer_no = json.insert_id;
                        }
                        //$S('btn_list').click();
//                        onInit(SOFTMARGUMENT);
	                    alert("신청되었습니다.(일어)"); // success
//                        목록();
        	            document.location.href = "/service/front_jp.php?sub=engineer&mode=jp_engineer_write";
                    } else if (json['return'] == '500') {
                        alert(json.message); // error
                    }
                }
                ,f
            );
        }
    }
    return false;
}

function 목록() {
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
	document.body.scrollTop = 0;
	getUI("front_jp/engineer","jp_engineer_list");
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","front_jp.JpEngineer","delete",
        {
            p_engineer_no:P_ENGINEER_NO
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

function 파일다운로드(fNo,fNm) {
//  alert(fNo + " / " + fNm);
  call('FORM','common.Common','fileDownload',
      {
  		p_file_no:fNo,
  		p_file_nm:fNm,
  		p_sub_dir:"jp_engineer"
  	}
  );
}