if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
    var f = $S("wForm");
    if (jQuery.browser.msie) {}
    Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
        var LR = new Common.createELTechCat("RADIO","L","tech_l_cat","1차카테고리").setLang("JP").make("43").append($S("area_tech_l_cat"));        
//        L.setNextObject(M);
//        LR.element.className = "required trim focus alert ";
//        LR.element.setAttribute("message","선택해주세요.");
    }});  	                
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
            call('FORM.FILE','front_jp.TechSeed','insert',
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
//                        목록();
//                        alert(json.message); // success
	                    alert("신청되었습니다.(일어)"); // success
                        //document.location.href="/service/front_jp.php?sub=tech&mode=tech_seed_write";
                        document.location.href="/sub.php?flashmenu=10903";
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
