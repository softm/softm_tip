#TITLE=softm_GRD
#INFO
New Cliptext library
#SORT=y

#T= class='required trim focus alert' maxlength=20 minlength=0 message='이름를 입력해주세요.'
 class='required trim focus alert' maxlength=20 minlength=0 message='이름를 입력해주세요.'
#T=$("#btnReg").click(function(e) {
    $("#btnReg").click(function(e) {
        회원등록();
        e.preventDefault();
    });
#T=$('#lForm input[name="save_user_id"]').is(":checked")
$('#lForm input[name="save_user_id"]').is(":checked")
#T=<input type='text' name='user_id' id='user_id' size=100 style='width:200px;<?=$addStyle?>' <?=$addProp?> value='' class='required trim focus alert' maxlength=100 minlength=0 message='아이디를 입력해주세요.' />
<input type='text' name='user_id' id='user_id' size=100 style='width:200px;<?=$addStyle?>' <?=$addProp?> value='' class='required trim focus alert' maxlength=100 minlength=0 message='아이디를 입력해주세요.' />
#T=<span id="">^!</span>
<span id="">^!</span>
#T=add link to td
    $('.col2').each(function(index, element){
        var tn = $(element).text();
        $(element).html('<a href="https://tracking.dpd.de/cgi-bin/delistrack?pknr='+tn+'&typ=1&lang=de">'+tn+'</a>');
    });


#T=call('FORM.FILE','front.BizConsult',SOFTMARGUME
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
            call('FORM.FILE','front.BizConsult',SOFTMARGUMENT.p_consult_no?'update':'insert',
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
//                                        document.location.href = "/service/front.php?sub=mypage&mode=biz_consult_list";
                                        document.location.href = "/sub.php?flashmenu=11903";
                           	} else if ( SOFTMARGUMENT.p_proc_type == 3 ) {
                                alert("비즈니스 상담매칭이 등록 되었습니다. " + "\n"
                                        + "신청하신 정보를 마이페이지에서 확인 가능합니다." + "\n"
                                        + "정확한 상담을 위해서 기업정보를 다시 확인해 주시기 바랍니다.");
//                                        alert(json.message); // success
//                                        document.location.href = "/service/front.php?sub=mypage&mode=biz_match_list";
                                document.location.href = "/sub.php?flashmenu=11904";                                
                           	}                                    
                        } else if ( json.mode == 'U' ) {
                        	if ( SOFTMARGUMENT.p_proc_type == 2 )
                        		onInit(SOFTMARGUMENT);                        		
//                        		document.location.href = "/service/front.php?sub=mypage&mode=biz_consult_list";
                        	else if ( SOFTMARGUMENT.p_proc_type == 3 )
                        		onInit(SOFTMARGUMENT);
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
#T=console.debug(areaEl);
console.debug(^!);
#T=datepicker 
if ( typeof(languageCode) == "undefined" ) {
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js",type:"js"});
    Util.Load.script({src:"/service/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css",type:"css"});
}

<?php
	$frmDate = Util::getTodayString();
	$toDate  = Util::getDateAdd ($frmDate, 'MONTH', 1 );
	$frmDate = substr($frmDate, 0, strlen($frmDate)-9);
	$toDate  = substr($toDate, 0, strlen($toDate)-9);
?>
    <input type='text' name='s_frm_reg_date' value='<?=$frmDate?>' readonly  style='width:100px' maxlength= />
    &nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.s_frm_reg_date,"yyyy-mm-dd",this)'>
    ~
    <input type='text' name='s_to_reg_date'  value='<?=$toDate?>' readonly  style='width:100px' maxlength= />
    &nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.s_to_reg_date,"yyyy-mm-dd",this)'>     
#T=function fGetList(s) {
// 조회
function fGetList(s) {
    setRestore("s_biz_field"       ,Form.value($N("s_biz_field"       )));
    setRestore("s_biz_classified"       ,Form.value($N("s_biz_classified"       )));
    setRestore("s_state"       ,Form.value($N("s_state"       )));
    setRestore("s_keyword"    ,Form.value($N("s_keyword"    )));

	GRID["tbl_list"].setArgus("s_biz_field"       ,Form.value($N("s_biz_field"       )));
	GRID["tbl_list"].setArgus("s_biz_classified"       ,Form.value($N("s_biz_classified"       )));
	GRID["tbl_list"].setArgus("s_state"       ,Form.value($N("s_state"       )));
	GRID["tbl_list"].setArgus("s_keyword"    ,Form.value($N("s_keyword"    )));
	GRID["tbl_list"].load({pagenavi_pos:s});
    return false;
}
#T=GRID - cell - onclick
        cell:{
	        "btn":{
	        	onclick:function(o) {
	        		alert( GRID.getValue(o.tId,o.tr.rowIndex,"company_no") );
	        	},	        	
	            onchange:function(o) {
	                return true;
	            },
	            onblur:function(o) { // event 리턴처리 안됨.
	            }
	        }        
        }
#T=GRID - row- onclick
 
        row:{
        	onclick:function(o) {
        		//        		console.debug(o);
        		getUI("front/biz","biz_consult_write",{
        			method:"POST",
        			argus : {
        				p_consult_no:GRID.getValue(o.tId,o.tr.rowIndex,"consult_no"),
        				p_proc_type:3
        			},
        			target:"#contents",
        			loadui:false
        		});
        	}
        }
#T=GRID - xls,doc 저장
    $S("btn_xls_down").onclick = function() {fileDownload("xls");}
    $S("btn_doc_down").onclick = function() {fileDownload("doc");}
function fileDownload(fExt) {
	fExt = !fExt?"xls":fExt;
	call("FORM","common.Common","saveDownload",
		{
		p_file_nm:"기업정보." + fExt,
		p_data:
		"<table>" +
			$S("tbl_list").tHead.outerHTML +
			$S("tbl_list").tBodies[0].outerHTML+
		"</table>"
		}
	);
	return false;
}
#T=GRID.getValue($S("tbl_list"),tr.rowIndex,"proc_cd")
GRID.getValue($S("tbl_list"),tr.rowIndex,"proc_cd")
#T=javascript - call
function 관심기업() {
    call('POST','front.InterestCompany','insert',
    {
    },
    function(xmlDoc){
        var json  = Util.xml2json(xmlDoc);
        if ( json['return'] == '200' ) { // success
            //console.debug(json.insert_id);
            if ( json.mode == 'I' ) {
                //SOFTMARGUMENT.p_consult_no = json.insert_id;
            }
            //$S('btn_list').click();
            onInit(SOFTMARGUMENT);
            alert("관심기업으로 등록되었습니다. " + "\n"
                + "매칭신청은 마이페이지에서 가능합니다.");
//                    alert(json.message); // success
            document.location.href = "/service/front.php?sub=mypage&mode=biz_consult_list";
        } else if (json['return'] == '500') {
            alert(json.message); // error
        }
    }
    //,f // requestType이 FORM, FORM.FILE의 경우
    );
}

#T=realpath(dirname(dirname(__FILE__)))
realpath(dirname(dirname(__FILE__)))
#T=removeClass / addClass
    if ( LOGIN ) {
    	if ( !$S('wForm').passwd.value.trim() ) {
        	removeClass($S('wForm').passwd	 ,"required");
        	removeClass($S('wForm').re_passwd,"required");    		
    	} else {
        	addClass($S('wForm').passwd	  ,"required");
        	addClass($S('wForm').re_passwd,"required");
    	}
    	removeClass($S('wForm').user_email,"required");
    } else {

    }
#T=Util::createGory 
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 'user_level';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " id=user_level"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_USER_LEVEL;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>
#T=Util::createGory - 'RADIO',
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'biz_field';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = ""  ;
    $creategory_setup['properties'      ] = " class='no-input'"  ;
    $creategory_setup['loop_end_tag'      ] = "&nbsp;"  ;
    $selectInfo = Base::$CODE_BIZ_FIELD;
    $selectInfo['setup'] = $creategory_setup;
   	print Util::createGory ('RADIO',$selectInfo);
?>
#T=파일 상단 주석
<?
/**
 * Filename        : /company_infor.inc
 * Fuction         : 기업정보-보기
 * @version        : 1.0
 * # using
 * include_once SERVICE_DIR . '/classes/inc/common/company_infor.inc';
*/
?>
#