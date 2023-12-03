if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

function onInit(argus) {
	initWrite(argus);
}

function initWrite(argus) {
    var form = $S("wForm");
    if (jQuery.browser.msie) {}
//    alert('argus.p_proc_type : ' + argus.p_proc_type + " / " + 'argus.p_consult_no : ' + argus.p_consult_no );
    if ( argus.p_proc_type == 2 || argus.p_proc_type == 3 ) { // 상담
        if ( argus.p_consult_no ) {
            call("JSON","admin.BizConsult","get",
                {
                    p_consult_no:argus.p_consult_no
                 //p_user_no:argus.p_user_no
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json["return"] == "200" ) { // success
                        var item = json.item;
                        getPhp("admin/biz","biz_consult_write",{
                            method:"POST",
                            argus : {
                                p_consult_no:item.consult_no,
                                p_proc_type:item.proc_type
                            },
                            target:"#contents",
                            cb:function() {
                                onDataLoad(json,argus);
                                initAdminCommentGrid();                                  
                            }
                        });
                        // loadui가 true
                        //onDataLoad(json,argus)
                    } else if (json["return"] == "500") {
                        alert(json.message); // error
                    }
                }
            );
        } else {
            // form.tel1.onfocus = Form.numeberOnly;
        }
    } else if ( argus.p_proc_type == 3 ) { // 매칭 ( 관심등록 )
    	onDataLoad(null,argus);
    }
}

function onDataLoad(json,argus) {
    var form = $S("wForm");
    if ( json ) {
    	if ( (json.filename1) ) {
    		$S("file1_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno1 + "','f1_" + argus.p_consult_no + "_');return false;\">" 
    		                            + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>"
    								    + "<INPUT TYPE=CHECKBOX name=file1_delete value='Y'> 삭제" ;
    	}
    	if ( (json.filename2) ) {
    		$S("file2_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno2 + "','f2_" + argus.p_consult_no + "_');return false;\">" 
            + ( json.filename2 + ((json.fileext2)?".":"") + (json.fileext2) ) + "</a>"
		    + "<INPUT TYPE=CHECKBOX name=file2_delete value='Y'> 삭제" ;
    	}
    	if ( (json.filename3) ) {
    		$S("file3_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno3 + "','f3_" + argus.p_consult_no + "_');return false;\">" 
            + ( json.filename3 + ((json.fileext3)?".":"") + (json.fileext3) ) + "</a>"
		    + "<INPUT TYPE=CHECKBOX name=file3_delete value='Y'> 삭제" ;
    	}    	
    	Form.bind(json.fi,json.item,$S("wForm"),{
			tel:function(form,vv) {
				if ( vv ) {
					var vvS = vv.split("-");
					form.tel1.value = vvS[0];
					form.tel2.value = vvS[1];
					form.tel3.value = vvS[2];
				}
			},
			hp:function(form,vv) {
				if ( vv ) {
					var vvS = vv.split("-");
					form.hp1.value = vvS[0];
					form.hp2.value = vvS[1];
					form.hp3.value = vvS[2];
				}
			},
			fax:function(form,vv) {
				if ( vv ) {
					var vvS = vv.split("-");
					form.fax1.value = vvS[0];
					form.fax2.value = vvS[1];
					form.fax3.value = vvS[2];
				}
			}
	    });
    }
}

function 실행() {
    var f = $S('wForm');
    if ( !(SOFTMARGUMENT.p_consult_no) ) { // 입력
        //removeClass(f.consult_no,"required");
    } else {
    }
    var exec = false;
    var invalidCb = {
    		consult_item:function(){ Effect.twinkle(f.consult_item); },
    		hope_biz_type:function(){ Effect.twinkle(f.hope_biz_type[0].parentNode); },
    		open_limit:function(){ Effect.twinkle(f.open_limit[0].parentNode); }
    };

    if ( Form.validate( f , invalidCb ) )
    {
    	var title = "저장하시겠습니까?";
    	if ( !SOFTMARGUMENT.p_consult_no ) {
    		if      ( SOFTMARGUMENT.p_proc_type == '2' ) title = "비지니스 상담을 신청하시겠습니까?"
        	else if ( SOFTMARGUMENT.p_proc_type == '3' ) title = "비지니스 매칭을 신청하시겠습니까?"    			
    	} else {
    		if      ( SOFTMARGUMENT.p_proc_type == '2' ) title = "비지니스 상담을 수정하시겠습니까?"
    		else if ( SOFTMARGUMENT.p_proc_type == '3' ) title = "비지니스 매칭을 수정하시겠습니까?"    			
    	}
        if ( confirm(title) ) {
            exec = true;
        }
        if ( exec ) {
            call('FORM.FILE','admin.BizConsult',SOFTMARGUMENT.p_consult_no?'update':'insert',
                {
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success
                        //console.debug(json.insert_id);
//                    	alert(json.mode);
                        if ( json.mode == 'I' ) {
                            //SOFTMARGUMENT.p_consult_no = json.insert_id;
                           	if ( SOFTMARGUMENT.p_proc_type == 2 ) {
                                alert("비즈니스 상담신청이 등록 되었습니다. " + "\n"
                                        + "신청하신 정보를 마이페이지에서 확인 가능합니다." + "\n"
                                        + "정확한 상담을 위해서 기업정보를 다시 확인해 주시기 바랍니다.");
//                                        alert(json.message); // success
                                        document.location.href = "/service/front.php?sub=mypage&mode=biz_consult_list";
                           	} else if ( SOFTMARGUMENT.p_proc_type == 3 ) {
                                alert("비즈니스 상담매칭이 등록 되었습니다. " + "\n"
                                        + "신청하신 정보를 마이페이지에서 확인 가능합니다." + "\n"
                                        + "정확한 상담을 위해서 기업정보를 다시 확인해 주시기 바랍니다.");
//                                        alert(json.message); // success
                                        document.location.href = "/service/front.php?sub=mypage&mode=biz_match_list";                           		
                           	}                                    
                        } else if ( json.mode == 'U' ) {
                        	if ( SOFTMARGUMENT.p_proc_type == 2 )
                        		initWrite(SOFTMARGUMENT);                        		
//                        		document.location.href = "/service/front.php?sub=mypage&mode=biz_consult_list";
                        	else if ( SOFTMARGUMENT.p_proc_type == 3 )
                        		initWrite(SOFTMARGUMENT);
//                        		document.location.href = "/service/front.php?sub=mypage&mode=biz_match_list";                        		
                        }
                    } else if (json['return'] == '500') {
                        alert(json.message); // error
                    }
                },f
            );
        }
    }
    return false;
}

function 삭제(p_consult_no) {
    var exec = false;
	var title = "삭제하시겠습니까?";
	if ( SOFTMARGUMENT.p_consult_no ) {
		if      ( SOFTMARGUMENT.p_proc_type == '2' ) title = "비지니스 상담을 삭제하시겠습니까?"
    	else if ( SOFTMARGUMENT.p_proc_type == '3' ) title = "비지니스 매칭을 삭제하시겠습니까?"    			
	    if ( confirm(title) ) {
	        exec = true;
	    }
	    if ( exec ) {
		    call('JSON','admin.BizConsult','delete',
			    { 
		    		p_consult_no:p_consult_no 
		    	},
			    function(xmlDoc){
			        var json  = Util.xml2json(xmlDoc);
			        if ( json['return'] == '200' ) { // success
			            //console.debug(json.insert_id);
			            if ( json.mode == 'D' ) {
			                if ( SOFTMARGUMENT.p_proc_type == 2 )
			                    document.location.href = "/service/admin.php?sub=biz&mode=biz_consult_list";
			                else if ( SOFTMARGUMENT.p_proc_type == 3 )
			                    document.location.href = "/service/admin.php?sub=biz&mode=biz_match_list";
			            }
			        } else if (json['return'] == '500') {
			            alert(json.message); // error
			        }
			    }
			);
	    }
	}
	return false;
}

/**
 * 마이페이지 상담리스트에서 접근한경우 목록복귀
 */
function mypageList() {
    if ( $S("calendarDiv") ) $S("calendarDiv").style.display="none";
    if ( SOFTMARGUMENT.p_proc_type == '2' ) { // 상담.
        getUI("admin/biz","biz_consult_list");
    } else if ( SOFTMARGUMENT.p_proc_type == '3' ) {  // 매칭
        getUI("admin/biz","biz_match_list");
    }
}

function fileDownload(fNo,fNm) {
//    alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
    		p_file_no:fNo,
    		p_file_nm:fNm,
    		p_sub_dir:"biz"
    	}
    );
}

function initAdminCommentGrid() {
    Util.Load.script({src:"/service/ui/css/grid.css",type:"css"});
    GRID.init({
        requestType : "POST"        , 
        dataType    : "xml"         , 
        table_id    : "tbl_comment_list"    , 
        editevent   : "ondblclick"  ,
        confirm     : false         ,
        setting     : {"delete": false,"insert": false },
        service_infor:{
            className  : "base.ConsultAdminComment",
            method     : { "list":"base.ConsultAdminComment.select", "save":"save" },
            argus      : {
                p_navi_function:"fGetAdminCommentList"
            }
        },
        onload:function(o) {
            GRID["tbl_comment_list"].table.tHead.style.height="0px";
//            GRID["tbl_comment_list"].table.style.width="600px";
            $(".btn_delete").click(function(e) {
                //              console.debug($(this));
                var td = $(this).get(0).parentNode;
                var tr = td.parentNode;
                if( confirm("삭제하시겠습니까") ) {
                GRID.submit({td:td,mode:"D"});
                	fGetAdminCommentList(1);    
//                	initAdminCommentGrid(SOFTMARGUMENT);
                }
                e.preventDefault();
              });            
        },
	    row:{
	    	onclick:function(o) {
	    	    var f = $S('wCForm');
	    	    f.p_seq.value  = GRID.getValue(o.tId,o.tr.rowIndex,'seq');	    	    
	    	    f.admin_comment.value = GRID.getValue(o.tId,o.tr.rowIndex,'admin_comment');	    		
	    	}
	    }        
    });
    
    fGetAdminCommentList(1);    
}
//조회
function fGetAdminCommentList(s) {
     GRID["tbl_comment_list"].setCondition( "proc_type", Form.value($N("p_proc_type"))).setEqual();
     GRID["tbl_comment_list"].setCondition( "consult_no", Form.value($N("p_consult_no"))).setEqual();
//	GRID["tbl_comment_list"].setArgus("s_consult_no",Form.value($N("p_consult_no")));
    GRID["tbl_comment_list"].load({pagenavi_pos:s});
    return false;
}

function 관리자코멘트입력() {
    var f = $S('wCForm');
    var exec = false;
    var invalidCb = {};
    if ( Form.validate( f ,invalidCb) ) {
        if ( confirm("저장하시겠습니까?") ) { exec = true; }
        if ( exec ) {
            call('JSON','base.ConsultAdminComment',f.p_seq.value?'update':'insert',
                {
                    p_proc_type:f.p_proc_type.value.trim(),
                    p_consult_no:f.p_consult_no.value.trim(),
                    p_seq:f.p_seq.value.trim(),
                    admin_comment:f.admin_comment.value.trim()
                },
                function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    if ( json['return'] == '200' ) { // success      
//                        alert(json.message); // success
                		f.admin_comment.value = "";
                		f.p_seq.value = "";
                    	if ( json.mode == "I") {
                    	} else {
                    	}
                        fGetAdminCommentList(1);                        
                    } else if (json['return'] == '500') {
                        alert(json.message); // error
                    }
                }
            );
        }
    }
    return false;
}
var mailWin = null;
function 메일발송팝업(tr) {
	mailWin = UI.openWindow('/service/inc/common/send_mail_popup.php?p_onload=메일주소설정', 650, 650,'w_send_mail',{scrollbars:'no'});
    mailWin.focus();
   // mailWin.document.wForm.to.value = document.wForm.email.value;
	return false;
}

function 메일주소설정() {
    mailWin.document.wForm.to.value = document.wForm.email.value;
    mailWin.document.wForm.toname.value = document.wForm.nm_kr.value;
}