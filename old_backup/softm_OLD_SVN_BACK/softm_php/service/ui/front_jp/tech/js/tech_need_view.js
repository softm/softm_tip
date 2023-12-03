if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_consult_no) {
	    call("JSON","front_jp.TechConsult","get",
	        {
				p_consult_no:argus.p_consult_no
	        },
	        function(xmlDoc){
	            var json  = Util.xml2json(xmlDoc);
	            var item = json.item;
	            if ( item ) {
	                if ( json["return"] == "200" ) { // success
	                    // alert(json.message); // success
	                    getPhp("front_jp/tech","tech_need_view",{
	                        argus : {
	                        	p_consult_no:item.consult_no,
	                        	p_trade_hope_type:item.trade_hope_type,
	                        	p_possible_lang:item.possible_lang
	                        }
	                    })
	                    onDataLoad(json,argus);
	                    //alert(item.tech_l_cat);
		                callJSONSyncToJson('common.Common','getTechCategoryName',
				                {
		            				s_l_cat:item.tech_l_cat,
		            				s_m_cat:item.tech_m_cat,
		            				s_s_cat:item.tech_s_cat,
		            				s_lang:'JP'
				                },		                        
		                        function (json) {
				                	var tech_cat_item = eval("("+json+")");
//				                	console.debug(tech_cat_item);
				                	$S("area_tech_l_cat").innerHTML = tech_cat_item.l_nm?tech_cat_item.l_nm:"-";
				                	$S("area_tech_m_cat").innerHTML = tech_cat_item.m_nm?tech_cat_item.m_nm:"-"; 
				                	$S("area_tech_s_cat").innerHTML = tech_cat_item.s_nm?tech_cat_item.s_nm:"-";
		                        }
		                    );
		                
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
        Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
        	var f = document.wForm;    	
            var L = new Common.createELTechCat("RADIO","L","tech_l_cat").make().append($S("area_tech_l_cat"));
            L.elements[0].checked = true;
        }});    	
    }
}

function onDataLoad(json,argus) {
    var f = $S("wForm");
    if ( json ) {
        Form.bind(json.fi,json.item,$S("wForm"),{
    		tel:function(f,vv) {
    			if ( vv ) {
    				var vvS = vv.split("-");
    				f.tel1.value = vvS[0];
    				f.tel2.value = vvS[1];
    				f.tel3.value = vvS[2];
    			}
    		},
    		hp:function(f,vv) {
    			if ( vv ) {
    				var vvS = vv.split("-");
    				f.hp1.value = vvS[0];
    				f.hp2.value = vvS[1];
    				f.hp3.value = vvS[2];
    			}
    		},
    		fax:function(f,vv) {
    			if ( vv ) {
    				var vvS = vv.split("-");
    				f.fax1.value = vvS[0];
    				f.fax2.value = vvS[1];
    				f.fax3.value = vvS[2];
    			}
    		}
        });
    }
}

function 목록() {
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
	getUI("front_jp/tech","tech_need_list");
	return false;
}
