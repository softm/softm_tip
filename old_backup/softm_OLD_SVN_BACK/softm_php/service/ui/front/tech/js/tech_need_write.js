if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}
var STATE = "0";
function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    if ( argus.p_consult_no) {
	    call("JSON","front.TechConsult","get",
	        {
				p_consult_no:argus.p_consult_no
	        },
	        function(xmlDoc){
	            var json  = Util.xml2json(xmlDoc);
	            var item = json.item;
	            if ( item ) {
	                if ( json["return"] == "200" ) { // success
	                    // alert(json.message); // success
	                	STATE = item.state;
	                    getPhp("front/tech","tech_need_write",{
	                        argus : {p_consult_no:item.consult_no}
	                    })
	                    onDataLoad(json,argus);
	                    //alert(item.tech_l_cat);
		                Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
		                	var f = document.wForm;    	
		                    var L = new Common.createELTechCat("RADIO","L","tech_l_cat").make(item.tech_l_cat).append($S("area_tech_l_cat"));
//		                    L.element.attachEvent("onchange",function() {
//		                    });
		                }});	                
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
            L.element.attachEvent("onchange",function() {
            });
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
    f.trade_hope_type[5].onclick = function () {
    	f.trade_hope_type_etc.disabled = !this.checked ;
    	f.trade_hope_type_etc.focus();
    }
    if ( f.trade_hope_type[5].checked ) {
    	f.trade_hope_type_etc.disabled = false;
    }    
}

function 실행() {
	if ( USER_LEVEL < 2 ) {
        alert("기업회원만 이용할 수 있습니다.");
        return false;
    }
    var f = $S('wForm');
    if (  parseInt(STATE) < 3 ) {
        var exec = false;
        var invalidCb = {
        	trade_hope_type:function(){ Effect.twinkle(f.trade_hope_type[0].parentNode);f.trade_hope_type[0].focus(); }    
        };
        if ( Form.validate(f ,invalidCb) ) {
        	var title = !f.p_consult_no.value?"저장하시겠습니까?":"기술니즈신청을 수정하시겠습니까?";
            if ( confirm(title) ) {
                exec = true;
            }
            if ( exec ) {
                call('FORM','front.TechConsult',SOFTMARGUMENT.p_consult_no?'update':'insert',
                	{},
                    function(xmlDoc){
                        var json  = Util.xml2json(xmlDoc);
                        if ( json['return'] == '200' ) { // success      
                            //console.debug(json.insert_id);
                            if ( json.mode == 'I' ) {
        	                    alert("기술니즈 등록이 신청되었습니다.\n"
        		                    	+ "진행과정은 마이페이지에서 확인 가능합니다."
        	                    );
        	                    목록();    	                    
                            } else if ( json.mode == 'U' ) {
        	                    alert("정보가 수정되었습니다.");
                                onInit(SOFTMARGUMENT);    	                    
                            }
                            //alert(json.message); // success
                        } else if (json['return'] == '500') {
                            alert(json.message); // error
                        }
                    },f
                );
            }
        }
    } else {
    	alert("검토중에 있어서 수정할 수 없습니다.");
    }
    return false;
}

function 목록() {
	if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
//	getUI("front/mypage","tech_need_list");
//	document.location.href = "/service/front.php?sub=mypage&mode=tech_need_list";
	document.location.href = "/sub.php?flashmenu=11906";
	return false;
}

function 삭제() {
    var f = $S('wForm');
    if (  parseInt(STATE) < 3 ) {    
	    if( confirm("삭제하시겠습니까?") ) {
	        call("JSON","front.TechConsult","delete",
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
    } else {
    	alert("검토중에 있어서 삭제할 수 없습니다.");
    }
    return false;
}
