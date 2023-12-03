function onInit() {
//	alert("a");
 // create init
    GRID.init({
        requestType : "POST"        , // JSON, POST
        dataType    : "xml"         , // xml, json
        table_id    : "tbl_list"    , // Table Id
        editevent   : "ondblclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            log(["onload mode : " + o.mode,o]);
            if ( o.mode == 'S' ) {
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
            "USER_EMAIL":{
                onchange:function(o) {
                    return true;
                },
                onblur:function(o) { // event 리턴처리 안됨.
                }
            },
            "USER_LEVEL":{
                onchange:function(o) {
                    if (confirm("저장하시겠습니까?")) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        },
        service_infor:{
               className  : 'sample.Sample2',
               method     : { "list":"sample.Sample2.select", "save":"save" },
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
    Util.Load.script({src:"/service/ui/sample/css/test"+v.padLeft(0,2)+".css",type:'css',callback:function(){
    }});
}

