function onInit() {
//	alert("a");
 // create init
    Util.Load.script({src:"/service/ui/sample/css/test08.css",type:'css',callback:function(){}});
/*
    Util.Load.script({src:"/service/js/common.js",type:'js',callback:function(){
        var L = new Common.createELTechCat("SELECT","L","s_l_cat","1차카테고리").make("43").append($S("area_tech_l_cat"));
        var M = new Common.createELTechCat("SELECT","M","s_m_cat","2차카테고리").make("43","50").append($S("area_tech_m_cat"));
        var S = new Common.createELTechCat("SELECT","S","s_s_cat","3차카테고리").make("43","50","06").append($S("area_tech_s_cat"));
        L.setNextObject(M);
        M.setNextObject(S);
//        L.element.attachEvent("onchange",function() {
//        });

        var LR = new Common.createELTechCat("RADIO","L","s_rl_cat","1차카테고리").make("43").append($S("area_tech_rl_cat"));
        var MR = new Common.createELTechCat("RADIO","M","s_rm_cat","2차카테고리").make("43","50").append($S("area_tech_rm_cat"));
        var SR = new Common.createELTechCat("RADIO","S","s_rs_cat","3차카테고리").make("43","50","06").append($S("area_tech_rs_cat"));
        LR.setNextObject(MR);
        MR.setNextObject(SR);
    }});
*/
    GRID.init({
        requestType : "POST"        , // JSON, POST
        dataType    : "xml"         , // xml, json
        table_id    : "tbl_list"    , // Table Id
        editevent   : "ondblclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            log(["onload mode : " + o.mode,o]);
            if ( o.mode == 'U' ) {
            	alert("저장되었습니다.");
                fGetList(1);
            }
        },
        onsubmit    :function(o) {
            return true;
        },
        onfocus:function(o) {
            //var td= GRID.cell.getTd(o.td);
            //alert("a");
            return true;
        },
        ondelete:function(o) {
            if (confirm("삭제하시겠습니까")) {
                return true;
            } else {
                return false;
            }
        },
        onbeforeedit:function(o) {
            return true;
        },
        onchange:function(o) {
            var td= GRID.cell.getTd(o.td);
            //var countryCode = GRID.cell.getData(o.tId,td.parentNode.rowIndex,'COUNTRY_CODE');
            return true;
        },
        cell:{
            color:{
                'save'  :'#ff0'
            },
            "user_email":{
                onclick:function(o) {// event 리턴처리 됨.
                	console.debug(o);
                    return true;
                },
                onchange:function(o) { // event 리턴처리 안됨.
                    if (confirm("저장하시겠습니까?")) {
                        return true;
                    } else {
                        return false;
                    }
                },
                onblur:function(o) { // event 리턴처리 됨.
                }
            }
        },
        service_infor:{
               className  : 'sample.Sample',
               method     : { "list":"sample.Sample.get", "save":"save" },
               argus      : {
                   p_navi_function:"fGetList"
               }
        }
    });
    fGetList(1);

}

// 조회
function fGetList(s) {
//    alert( $S("s_search").value );
    if ( $S("s_user_id").value ) {
        GRID["tbl_list"].setCondition("USER_EMAIL like '%" + $S("s_user_id").value + "%'");
    }
    if ( $S("s_user_level").value ) {
        GRID["tbl_list"].setCondition("USER_LEVEL",$S("s_user_level").value).setEqual();
    }
    //GRID["tbl_list"].setCondition("USER_ID",$S("s_search").value).like();
    GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}

// 저장
function fExec() {
    if ( !GRID["tbl_list"].getChanged() ) {
        alert("변경된 내용이 없습니다");
    } else {
        if ( confirm("저장하시겠습니까?") ) {
            GRID["tbl_list"].save();
        }
    }
}

// 추가
function fNewRow() {
    var r = GRID.insertRow({table:'tbl_list'});
}

// 스킨변경
function fChgSkin(v) {
    Util.Load.script({src:"/service/ui/sample/css/test"+v.padLeft(0,2)+".css",type:'css'});
}

