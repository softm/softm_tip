var ARGUS = null;
var P_COMPANY_NO = null;
function onInit(argus) {
	ARGUS = argus;
	P_COMPANY_NO = argus.p_company_no;
	//console.debug(P_COMPANY_NO);
	if ( P_COMPANY_NO ) {
	    call('JSON','admin.Company','getJp',
	            {
	                p_company_no:P_COMPANY_NO
	            },
	            function(xmlDoc){
	                var json  = Util.xml2json(xmlDoc);
	                if ( json["return"] == '200' ) { // success
	                    var item = json.item;
	                    //alert(item.user_no);
	                    getPhp("admin/company","jp_company_write",{
	                        method:'POST',
	                        argus : {
	                            p_company_no:item.company_no,
	                            p_user_no:item.user_no,
	                            p_user_level:SOFTMARGUMENT.p_user_level
	                        },
	                        target:"#contents",
	                        cb:function() 
	                        {
	                            var items = json.item1;
	                            //console.debug(json.item1);
	                            var l = 5;
	                            for (var i=0; i<l;i++ ) {
	                                try {
	                                    var product_kr = toValue(items[i]['product_kr']);
	                                    var product_en = toValue(items[i]['product_en']);
	                                    var product_jp = toValue(items[i]['product_jp']);
	                                    $S('wForm')["product_kr[]"][i].value = product_kr;
	                                    $S('wForm')["product_en[]"][i].value = product_en;
	                                    $S('wForm')["product_jp[]"][i].value = product_jp;

	                                } catch(e) {
	                                }
	                            }

	                            onDataLoad(json,argus)	                            
	                        }
	                    });

	                } else if (json["return"] == '500') {
	                    alert(json.message); // error
	                }
	            }
	        );
	} else {
		onDataLoad(null,argus)
	}
}
function onDataLoad(json,argus) {
    var form = $S("wForm");
    if ( json ) {
    	
    	var form = $S('wForm');
        if ( toValue(json.fileno1) ) {
            $S("file1_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno1 + "','f1_" + P_COMPANY_NO + "_');return false;\">"
                                        + ( json.filename1 + (toValue(json.fileext1)?".":"") + toValue(json.fileext1) ) + "</a>"
                                        + "<INPUT TYPE=CHECKBOX name=file1_delete value='Y'> 삭제" ;
        } else {
            $S("file1_infor").innerHTML = "";
        }
        if ( toValue(json.fileno2) ) {
            $S("file2_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno2 + "','f2_" + P_COMPANY_NO + "_');return false;\">"
            + ( json.filename2 + (toValue(json.fileext2)?".":"") + toValue(json.fileext2) ) + "</a>"
            + "<INPUT TYPE=CHECKBOX name=file2_delete value='Y'> 삭제" ;
        } else {
            $S("file2_infor").innerHTML = "";
        }
        if ( toValue(json.fileno3) ) {
            $S("file3_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno3 + "','f3_" + P_COMPANY_NO + "_');return false;\">"
            + ( json.filename3 + (toValue(json.fileext3)?".":"") + toValue(json.fileext3) ) + "</a>"
            + "<INPUT TYPE=CHECKBOX name=file3_delete value='Y'> 삭제" ;
        } else {
            $S("file3_infor").innerHTML = "";
        }
        
    	// 상담
    	if ( (json.filename4) ) {
    		$S("file4_infor").innerHTML = "<a href=# onclick=\"fileDownloadConsult('" + json.fileno4 + "','f4_" + json.item2.consult_no + "_');return false;\">" 
    		                            + ( json.filename4 + ((json.fileext4)?".":"") + (json.fileext4) ) + "</a>"
    								    + "<INPUT TYPE=CHECKBOX name=file4_delete value='Y'> 삭제" ;
    	}
    	if ( (json.filename5) ) {
    		$S("file5_infor").innerHTML = "<a href=# onclick=\"fileDownloadConsult('" + json.fileno5 + "','f5_" + json.item2.consult_no + "_');return false;\">" 
            + ( json.filename5 + ((json.fileext5)?".":"") + (json.fileext5) ) + "</a>"
		    + "<INPUT TYPE=CHECKBOX name=file5_delete value='Y'> 삭제" ;
    	}
    	if ( (json.filename6) ) {
    		$S("file6_infor").innerHTML = "<a href=# onclick=\"fileDownloadConsult('" + json.fileno6 + "','f6_" + json.item2.consult_no + "_');return false;\">" 
            + ( json.filename6 + ((json.fileext6)?".":"") + (json.fileext6) ) + "</a>"
		    + "<INPUT TYPE=CHECKBOX name=file6_delete value='Y'> 삭제" ;
    	} 
    	
        Form.bind(json.fi,json.item,form,{
            establish_date:function(form,vv) {
//                                  alert("x" + vv);
                if ( vv ) {
                    var vvS = vv.split("-");
                    form.establish_date1.value = parseInt(vvS[0]);
                    form.establish_date2.value = parseInt(vvS[1]);
                    form.establish_date3.value = parseInt(vvS[2]);
                }
            }
        });
        Form.bind(json.fi2,json.item2,form,{
        	tel:function(form,vv) {
        		form.worker_tel.value = vv;
        	},
	        fax:function(form,vv) {
	        	form.worker_fax.value = vv;
	        },
	        hp:function(form,vv) {
	        	form.worker_hp.value = vv;
	        }
        });
    }
    
    $S('wForm')["biz_classified[]"][8].onclick = function () {
        $S('wForm').biz_classified_etc.disabled = !this.checked ;
        $S('wForm').biz_classified_etc.focus();
    }
    
    if ($S('wForm')["biz_classified[]"][8].checked) {
        $S('wForm').biz_classified_etc.disabled = false;
    }
    
    $S('wForm').company_code1.onfocus = Form.numeberOnly;
    $S('wForm').company_code2.onfocus = Form.numeberOnly;
    $S('wForm').company_code3.onfocus = Form.numeberOnly;

    $S('wForm').worker_cnt.onfocus = Form.numeberOnly;
}
function 실행() {
	var f = $S('wForm');
	var exec = true;
    if (
	    Form.validate( f ,{
	        biz_field:function(){ f.biz_field[0].focus();Effect.twinkle(f.biz_field[0].parentNode);},
	        hope_biz_type:function(){ f.hope_biz_type[0].focus();Effect.twinkle(f.hope_biz_type[0].parentNode);},
	        open_limit:function(){ f.open_limit[0].focus();Effect.twinkle(f.open_limit[0].parentNode);},
	        "biz_classified[]":function(){ Effect.twinkle(f["biz_classified[]"][0].parentNode);},
	        jp_trade_yn:function(){ f.jp_trade_yn[0].focus();f.jp_trade_yn[0].focus();Effect.twinkle(f.jp_trade_yn[0].parentNode);},
	        etc_trade_yn:function(){ f.etc_trade_yn[0].focus(); f.etc_trade_yn[0].focus();Effect.twinkle(f.etc_trade_yn[0].parentNode);}
	        })
    )
    {
    	if ( exec ) {
    	    // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
            //  call(requestType,className,method,argus,cb,form)
//    		log(JSON.stringify(Form.jsonData(f)));
//    		call(requestType,className,method,argus,cb,form) {
	        call('FORM.FILE','admin.Company',P_COMPANY_NO?'updateJp':'insertJp',
	            {
	            },
    		    function(xmlDoc){
//	            	alert(xmlDoc);
	                var json  = Util.xml2json(xmlDoc);
	                if ( json["return"] == '200' ) { // success
	                    alert(json.message); // success
//	                    console.debug(json.insert_id);
	                    if ( json.insert_id ) {
//		                    SOFTMARGUMENT.p_company_no = json.insert_id
	                    }
//	                    onInit(SOFTMARGUMENT);
	                    목록();
//	                    document.location.href = "front.php?sub=mypage&mode=company_write";
	                } else if (json["return"] == '500') {
	                    alert(json.message); // error
	                }
    		    },
    			$S("wForm")
    		);
    	}
    }
    return false;
}

function 목록() {
    getUI("admin/company","jp_company_list",{
        method:'POST',
        target:"#contents"
    });
}

function 삭제() {
    if( confirm("!!! 주의 !!!" + "\n" +
		        "해당일본기업의 모든 자료가 삭제되며 복구할 수 없습니다." + "\n" +
		        "정말로 기업정보를 삭제하시겠습니까?") ) {
	    call('JSON','admin.Company','deleteJp',
            { p_company_no:P_COMPANY_NO },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                if ( json["return"] == '200' ) { // success
                    alert(json.message); // success
                // $S("btn_list").click();
                    목록();
                } else if (json["return"] == '500') {
                    alert(json.message); // error
                }
            }
	    );
    }
}

/**
 * 사업자 번호 검사
 * @param bizID
 * @returns {Boolean}
 */
function checkBizRegNo(bizID)
{
    var checkID = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5, 1);
    var i, Sum=0, c2, remander;        bizID = bizID.replace(/-/gi,'');
    for (i=0; i<=7; i++){
           Sum += checkID[i] * bizID.charAt(i);
    }

    c2 = "0" + (checkID[8] * bizID.charAt(8));
    c2 = c2.substring(c2.length - 2, c2.length);

    Sum += Math.floor(c2.charAt(0)) + Math.floor(c2.charAt(1));

    remander = (10 - (Sum % 10)) % 10 ;

    if(bizID.length != 10){
           return false;
    }else if (Math.floor(bizID.charAt(9)) != remander){
           return false;
    }else{
           return true;
    }
}

/**
 * 파일 다운로드.
 * @param fNo
 * @param fNm
 */
function fileDownload(fNo,fNm) {
//  alert(fNo + " / " + fNm);
  call('FORM','common.Common','fileDownload',
      {
  		p_file_no:fNo,
  		p_file_nm:fNm,
  		p_sub_dir:"company"
  	}
  );
}
/**
 * 파일 다운로드.
 * @param fNo
 * @param fNm
 */
function fileDownloadConsult(fNo,fNm) {
//	alert(fNo + " / " + fNm);
	call('FORM','common.Common','fileDownload',
			{
		p_file_no:fNo,
		p_file_nm:fNm,
		p_sub_dir:"biz"
			}
	);
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