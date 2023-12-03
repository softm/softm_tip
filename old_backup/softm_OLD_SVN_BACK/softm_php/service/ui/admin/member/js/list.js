 ARGUS = null;

function onInit(argus) {
//    $S("btnReg").onclick =회원등록
    $("#btnReg").click(function(e) {
        회원등록();
        e.preventDefault();
    });
	listInit(argus);
}

function listInit(argus) {
    Util.Load.script({src:"/service/ui/css/grid_mj.css",type:"css"});
	
//	alert(listInit);
    GRID.init({
        requestDataType : "POST"        , // JSON, POST
        responseDataType: "XML"        , // JSON, XML, TEXT
        table_id    : "tbl_list"    , // Table Id
        editevent   : "onclick"  , // onfocus, onclick, ondblclick : onclick과 onfous는 다르게 동작됨.
        confirm     : false         ,
        setting     : {
            "delete": false,
            "insert": false
        },
        service_infor:{
            className  : 'admin.Member',
            method     : { "list":"admin.Member.select", "save":"save" },
            argus      : {
                p_navi_function:"fGetList"
            }
        },
        onload:function(o) { // o.mode : I/U/D/M/R/SORT
            //log(["onload mode : " + o.mode,o]);
            // alert("onload");
            if ( o.data.return == "200" ) {
                if ( o.mode == "U" || o.mode == "D" ) alert(o.data.message);
            }
            onLoad(o,argus);
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
//        row:{
//        	onclick:function(o) {
////        		console.debug(o);
//            	getUI("admin/company","write",{
//            		method:'POST',
//            		argus : {
//            				p_company_no:GRID.getValue(o.tId,o.tr.rowIndex,'company_no'),
//            				p_user_no   :GRID.getValue(o.tId,o.tr.rowIndex,'user_no')
//            		},
//            		target:"#contents",
//            		lib_include:true,
//            		loadjs:true,
//            		loadcss:false,
//            		cb:function() {
//            		}
//            	});
//        	}
//        },
        cell:{
            color:{
                'save'  :'#ff0'
            },
            "COMPANY_NM_KR":{
                onchange:function(o) {
                    if (confirm("저장하시겠습니까?")) {
                        return true;
                    } else {
                        return false;
                    }
                },
                onblur:function(o) { // event 리턴처리 안됨.
                }
            },
            "USER_NAME":{
                onchange:function(o) {
                    if (confirm("저장하시겠습니까?")) {
                        return true;
                    } else {
                        return false;
                    }
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
        }
    });
//    fGetList(getRestoreValue('p_navi_start')?getRestoreValue('p_navi_start'):1);
    fGetList(getRestoreValue('p_navi_start')?getRestoreValue('p_navi_start'):1);

//    $S("save_btn").onclick = fileDownload;
}

function onLoad() {
    $(".btn_modify").unbind("click");
    $(".btn_modify").click(function(e) {
        if ( $S("tbl_list") == null ) return;
        //            	console.debug($(this));
        var td = GRID.cell.getTd($(this).get(0).parentNode);
        var tr = td.parentNode;
        var userNo = tr.cells[0].innerText;
        userLevel = GRID.getValue($S("tbl_list"),tr.rowIndex,"USER_LEVEL");
        userNo    = GRID.getValue($S("tbl_list"),tr.rowIndex,"USER_NO");
//        alert($S("tbl_list") + " / " + companyNo + " / " + userLevel + " / " + userNo);
//        alert(SOFTMARGUMENT.p_user_level);
//        alert( userLevel );
        getUI("admin/member","write",{
            argus :{p_user_no:userNo,p_user_level:userLevel},
            loadui:false,
            loadcss:true
        });
        e.preventDefault();
    });

    $(".btn_delete").unbind("click");
    $(".btn_delete").click(function(e) {
//            	console.debug($(this));
        var td = $(this).get(0).parentNode;
        var tr = td.parentNode;
//            	console.debug(td);
//            	console.debug(tr.cells[0].innerText);
        if( confirm("!!! 주의 !!!" + "\n" +
                "해당회원의 모든 자료가 삭제되며 복구할 수 없습니다." + "\n" +
                "정말로 회원을 삭제하시겠습니까?") ) {
//            		console.debug("td:",td.offsetParent);
            GRID.submit({td:td,mode:'D'});
            onInit(SOFTMARGUMENT);
        }
        e.preventDefault();
    });
}

// 조회
function fGetList(s) {
//	alert(s);
//	console.debug(SOFTMARGUMENT);
//	setRestore('f',function() {alert('a');} );
// alert(ARGUS.p_user_level);
//	GRID["tbl_list"].setArgus('p_user_level',SOFTMARGUMENT.p_user_level );	
//	if ( SOFTMARGUMENT.p_user_level ) GRID["tbl_list"].setCondition( "USER_LEVEL", SOFTMARGUMENT.p_user_level).setEqual();
//    GRID["tbl_list"].setCondition( $S("s_gubun").value,$S("s_search").value).setLike();
    GRID["tbl_list"].load({pagenavi_pos:s});
//    SOFTMARGUMENT.p_navi_start=s;
//	setRestore('s_gubun',$S("s_gubun").value );
//	setRestore('s_search',$S("s_search").value );
	setRestore('p_navi_start',s,true);
//	console.debug("fGetList", SOFTMARGUMENT);
	return false;
}
function 회원등록() {
    getUI("admin/member","write",{
        argus :{},
        loadjs:true,
        loadui:false,
        loadcss:true
    });
}

function fileDownload() {
  call('FORM','common.Common','saveDownload',
  {
  	p_file_nm:"회원정보.doc",
  	p_data:
  		"<table>" +
  		$S("tbl_list").tHead.outerHTML +
  		$S("tbl_list").tBodies[0].outerHTML+
  		"</table>"
      }
  );
}
