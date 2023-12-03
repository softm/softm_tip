if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

var STATE = "0";
var PAGE_GUBUN = "";
function onInit(argus) {
    var f = $S("wForm");
//    console.debug(argus.p_tech_no);
//    console.debug(argus.p_consult_no);
    if (jQuery.browser.msie) {}
    if ( argus.p_tech_no && !argus.p_consult_no ) { // 상담신청.
    	PAGE_GUBUN = "write";
	    call("JSON","front.TechSeed","existCheck",
        {
			p_tech_no:argus.p_tech_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            if ( json["return"] == "200" ) { // success
                if (json.count) {
	                getPhp("admin/tech","tech_seed_consult_write",{ argus : { p_consult_no:argus.p_consult_no,p_tech_no:argus.p_tech_no }, target:"#contents" });
	                Form.bind(json.fi,json.item,f);
                } else {
                	alert("기술매칭을 위한 기본정보가 존재하지 않습니다.");
                	목록();
                }
            } else if (json["return"] == "500") {
                alert(json.message); // error
            }
        }
	    );
    } else { // 상담신청 수정 ( 마이페이지 - 기술매칭신청 )
    	PAGE_GUBUN = "update";
	    call("JSON","admin.TechSeedConsult","get",
        {
	    	p_consult_no:argus.p_consult_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            //var item = json.item;
            if ( json["return"] == "200" ) { // success
                if (json.item) {
                	STATE = parseInt(json.item.state);
	                getPhp("admin/tech","tech_seed_consult_write",{ argus : { p_consult_no:argus.p_consult_no,p_tech_no:argus.p_tech_no }, target:"#contents" });
//	                console.debug(json.item);
	                var f = $S("wForm");
	                Form.bind(json.fi,json.item,f);
	                Form.bind(json.seed_fi,json.seed_item,f);
	                if ( (json.filename1) ) {
	            		$S("file1_infor").innerHTML = "<a href=# onclick=\"파일다운로드('" + json.fileno1 + "','f1_" + json.item.tech_no + "_');return false;\">"
	            		                            + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>"
	                    ;
	            	}
	                callJSONSyncToJson('common.Common','getTechCategoryName',
			                {
	            				s_l_cat:json.seed_item.tech_l_cat,
	            				s_m_cat:json.seed_item.tech_m_cat,
	            				s_s_cat:json.seed_item.tech_s_cat
			                },
	                        function (json) {
			                	var tech_cat_item = eval("("+json+")");
//				                	console.debug(tech_cat_item);
			                	$S("area_tech_l_cat").innerHTML = tech_cat_item.l_nm?tech_cat_item.l_nm:"미분류";
			                	$S("area_tech_m_cat").innerHTML = tech_cat_item.m_nm?tech_cat_item.m_nm:"미분류";
			                	$S("area_tech_s_cat").innerHTML = tech_cat_item.s_nm?tech_cat_item.s_nm:"미분류";
	                        }
	                    );
                } else {
                	alert("기술매칭신청가 존재하지 않습니다.");
                	목록();
                }
            } else if (json["return"] == "500") {
                alert(json.message); // error
            }
        }
	    );
    }
}

function 실행() {
    var f = $S('wForm');
    var exec = false;
    var invalidCb = {
    		tech_sn_field:function(){ f.tech_sn_field[0].focus();Effect.twinkle(f.tech_sn_field[0].parentNode);}
    };

    if ( Form.validate( f ,invalidCb) )
    {
        if ( confirm("저장하시겠습니까?") ) {
            exec = true;
        }
        if ( exec ) {
            call('FORM','admin.TechSeedConsult',PAGE_GUBUN == "write"?'insert':'update',
            	{},
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_tech_no = json.insert_id;
                        }
                        목록();
                        if ( PAGE_GUBUN == "write" ) {
	                        alert("기술매칭이 신청되었습니다.\n"+
	                        	  "진행과정은 마이페이지에서 확인 가능합니다."); // success
                        } else if ( PAGE_GUBUN == "update" ) {
                            alert(json.message); // success
                        }
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
	getUI("admin/tech","tech_seed_consult_list");
    return false;
}

function 삭제() {
    var f = $S('wForm');
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","admin.TechSeedConsult","delete",
        {
        	p_consult_no:f.p_consult_no.value,
        	p_worker_no:f.p_worker_no.value
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
  		p_sub_dir:"tech_seed"
  	}
  );
}