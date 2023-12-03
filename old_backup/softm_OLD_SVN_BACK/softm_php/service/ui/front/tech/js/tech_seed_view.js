if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_tech_no ) {
	    call("JSON","front.TechSeed","get",
	        {
				p_tech_no:argus.p_tech_no
	        },
	        function(xmlDoc){
	            var json  = Util.xml2json(xmlDoc);
	            if ( json["return"] == "200" ) { // success
//	                  alert(json.message); // success
	                var item = json.item;
	                //console.debug(argus.p_tech_no);
	                if (item) {
		                getPhp("front/tech","tech_seed_view",{ argus : { p_tech_no:item.tech_no }, target:"#contents" });
		                onDataLoad(json,argus);
		                var f = $S("wForm");	                
		                callJSONSyncToJson('common.Common','getTechCategoryName',
				                {
		            				s_l_cat:item.tech_l_cat,
		            				s_m_cat:item.tech_m_cat,
		            				s_s_cat:item.tech_s_cat
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
	                	alert("조회된 자료가 없습니다.");
	                	목록();
	                }
	            } else if (json["return"] == "500") {
	                alert(json.message); // error
	            }
	        }
	    );
    } else {
    }
}

function onDataLoad(json,argus) {
    var form = $S("wForm");
    Form.bind(json.fi,json.item,$S("wForm"));
    if ( (json.filename1) ) {
		$S("file1_infor").innerHTML = "<a href=# onclick=\"파일다운로드('" + json.fileno1 + "','f1_" + json.item.tech_no + "_');return false;\">" 
		                            + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>"
        ;
	}
}

function 목록() {
    if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
    getUI("front/tech","tech_seed_list");
    return false;
}
function 신청() {
	if ( USER_LEVEL >= 2 || USER_LEVEL >= 'Z'  ) {	
	    getUI("front/tech","tech_seed_consult_write",{
			method:"POST",
			argus : {
				p_tech_no:document.wForm.p_tech_no.value,
				p_consult_no:''
			},
			target:"#contents",
			loadui:false
		});
	} else {
		alert("기업회원만 이용할 수 있습니다.");
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