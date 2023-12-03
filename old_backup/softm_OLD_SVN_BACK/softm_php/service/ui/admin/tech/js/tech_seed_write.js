if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_tech_no ) {
	    call("JSON","admin.TechSeed","get",
	        {
				p_tech_no:argus.p_tech_no
	        },
	        function(xmlDoc){
	            var json  = Util.xml2json(xmlDoc);
	            if ( json["return"] == "200" ) { // success
//	                  alert(json.message); // success
	                var item = json.item;
//	                console.debug(argus.p_tech_no);
	                if (item) {
		                getPhp("admin/tech","tech_seed_write",{ argus : { p_tech_no:item.tech_no }, target:"#contents" });
		                onDataLoad(json,argus);
		                var f = $S("wForm");	                
		                Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
		                    var L = new Common.createELTechCat("SELECT","L","tech_l_cat","1차카테고리").make(f.tech_l_cat.value).append($S("area_tech_l_cat"));
		                    var M = new Common.createELTechCat("SELECT","M","tech_m_cat","2차카테고리").make(f.tech_l_cat.value,f.tech_m_cat.value).append($S("area_tech_m_cat"));
		                    var S = new Common.createELTechCat("SELECT","S","tech_s_cat","3차카테고리").make(f.tech_l_cat.value,f.tech_m_cat.value,f.tech_s_cat.value).append($S("area_tech_s_cat"));
		                    L.setNextObject(M);
		                    M.setNextObject(S);
		                }});  	                
	                } else {
	                	alert("수정할 자료가 없습니다.");
	                	목록();
	                }
	            } else if (json["return"] == "500") {
	                alert(json.message); // error
	            }
	        }
	    );
    } else {
        Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
            var L = new Common.createELTechCat("SELECT","L","tech_l_cat","1차카테고리").make(f.tech_l_cat.value).append($S("area_tech_l_cat"));
            var M = new Common.createELTechCat("SELECT","M","tech_m_cat","2차카테고리").make(f.tech_l_cat.value,f.tech_m_cat.value).append($S("area_tech_m_cat"));
            var S = new Common.createELTechCat("SELECT","S","tech_s_cat","3차카테고리").make(f.tech_l_cat.value,f.tech_m_cat.value,f.tech_s_cat.value).append($S("area_tech_s_cat"));
            L.setNextObject(M);
            M.setNextObject(S);
        }});  	                
    }
}

function onDataLoad(json,argus) {
    var form = $S("wForm");
    Form.bind(json.fi,json.item,$S("wForm"));
    if ( (json.filename1) ) {
		$S("file1_infor").innerHTML = "<a href=# onclick=\"파일다운로드('" + json.fileno1 + "','f1_" + json.item.tech_no + "_');return false;\">" 
		                            + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>"
								    + "<INPUT TYPE=CHECKBOX name=file1_delete value='Y'> 삭제" ;
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
            call('FORM.FILE','admin.TechSeed',SOFTMARGUMENT.p_tech_no?'update':'insert',
            	{},
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
                        //console.debug(json.insert_id);
                        if ( json.mode == 'I' ) {
                            SOFTMARGUMENT.p_tech_no = json.insert_id;
                        }
                        //$S('btn_list').click();
//                        onInit(SOFTMARGUMENT);
                        목록();
                        alert(json.message); // success
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
    getUI("admin/tech","tech_seed_list");
    return false;
}

function 삭제() {
    var f = $S('wForm');	
    if( confirm("삭제하시겠습니까?") ) {
        call("JSON","admin.TechSeed","delete",
        {
            p_tech_no:f.p_tech_no.value,
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