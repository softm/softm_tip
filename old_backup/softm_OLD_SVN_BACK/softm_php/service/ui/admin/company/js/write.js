var ARGUS = null;

function onInit(argus) {
	ARGUS = argus;
	var form = $S('wForm');
    call('JSON','admin.Company','get',
        {
            p_company_no:SOFTMARGUMENT.p_company_no
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            if ( json["return"] == '200' ) { // success
                var item = json.item;
                //alert(item.user_no);
                getPhp("admin/company","write",{
                    method:'POST',
                    argus : {
                        p_company_no:item.company_no,
                        p_user_no:item.user_no,
                        p_user_level:SOFTMARGUMENT.p_user_level
                    },
                    target:"#contents",
                    cb:function() 
                    {
                        var form = $S('wForm');
                        if ( toValue(json.fileno1) ) {
                            $S("file1_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno1 + "','f1_" + argus.p_company_no + "_');return false;\">"
                                                        + ( json.filename1 + (toValue(json.fileext1)?".":"") + toValue(json.fileext1) ) + "</a>"
                                                        + "<INPUT TYPE=CHECKBOX name=file1_delete value='Y'> 삭제" ;
                        } else {
                            $S("file1_infor").innerHTML = "";
                        }
                        if ( toValue(json.fileno2) ) {
                            $S("file2_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno2 + "','f2_" + argus.p_company_no + "_');return false;\">"
                            + ( json.filename2 + (toValue(json.fileext2)?".":"") + toValue(json.fileext2) ) + "</a>"
                            + "<INPUT TYPE=CHECKBOX name=file2_delete value='Y'> 삭제" ;
                        } else {
                            $S("file2_infor").innerHTML = "";
                        }
                        if ( toValue(json.fileno3) ) {
                            $S("file3_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno3 + "','f3_" + argus.p_company_no + "_');return false;\">"
                            + ( json.filename3 + (toValue(json.fileext3)?".":"") + toValue(json.fileext3) ) + "</a>"
                            + "<INPUT TYPE=CHECKBOX name=file3_delete value='Y'> 삭제" ;
                        } else {
                            $S("file3_infor").innerHTML = "";
                        }

                        Form.bind(json.fi,json.item,$S('wForm'),{
                            company_code:function(form,vv) {
                                if ( vv ) {
                                    form.company_code1.value = vv.substring(0,3);
                                    form.company_code2.value = vv.substring(3,5);
                                    form.company_code3.value = vv.substring(5);
                                }
                            },
                            establish_date:function(form,vv) {
                //                                  alert("x" + vv);
                                if ( vv ) {
                                    var vvS = vv.split("-");
                                    form.establish_date1.value = parseInt(vvS[0]);
                                    form.establish_date2.value = parseInt(vvS[1]);
                                    form.establish_date3.value = parseInt(vvS[2]);
                                }
                            },
                            tel:function(form,vv) {
                                if ( vv ) {
                                    var vvS = vv.split("-");
                                    form.tel1.value = vvS[0];
                                    form.tel2.value = vvS[1];
                                    form.tel3.value = vvS[2];
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
                        $S('wForm').tel1.onfocus = Form.numeberOnly;
                        $S('wForm').tel2.onfocus = Form.numeberOnly;
                        $S('wForm').tel3.onfocus = Form.numeberOnly;
                        $S('wForm').fax1.onfocus = Form.numeberOnly;
                        $S('wForm').fax2.onfocus = Form.numeberOnly;
                        $S('wForm').fax3.onfocus = Form.numeberOnly;

                        $S("btn_delete").onclick = function() {
                            if( confirm("!!! 주의 !!!" + "\n" +
                                        "해당기업회원의 모든 자료가 삭제되며 복구할 수 없습니다." + "\n" +
                                        "정말로 회원을 삭제하시겠습니까?") ) {
                                call('JSON','admin.Company','delete',
                                        { p_user_no:SOFTMARGUMENT.p_user_no, p_company_no:SOFTMARGUMENT.p_company_no },
                                        function(xmlDoc){
                                            var json  = Util.xml2json(xmlDoc);
                                            if ( json["return"] == '200' ) { // success
                                                alert(json.message); // success
                                            // $S("btn_list").click();
                                            } else if (json["return"] == '500') {
                                                alert(json.message); // error
                                            }
                                        }
                                    );
                            }
                        }

                        $S("btn_list").onclick = function() {
                            getUI("admin/member","list",{
                                method:'POST',
                                target:"#contents",
                                lib_include:true,
                                loadjs:true,
                                loadcss:true,
                                cb:function() {
                                }
                            });
                        }
                    }
                });

            } else if (json["return"] == '500') {
                alert(json.message); // error
            }
        }
    );
}

function 실행() {
	var f = $S('wForm');
	var exec = true;
    if (
	    Form.validate( f ,{
	    	company_code1:function(){ Effect.twinkle(f.company_code1);},
	    	company_code2:function(){ Effect.twinkle(f.company_code2);},
	    	company_code3:function(){ Effect.twinkle(f.company_code3);},
	        company_type:function(){ Effect.twinkle(f.company_type);},
	        company_nm_kr:function(){ Effect.twinkle(f.company_nm_kr);},
	        company_nm_en:function(){ Effect.twinkle(f.company_nm_en);},
	        ceo_nm_kr:function(){ Effect.twinkle(f.ceo_nm_kr);},
	        ceo_nm_en:function(){ Effect.twinkle(f.ceo_nm_en);},
	        biz_field:function(){ f.biz_field[0].focus();Effect.twinkle(f.biz_field[0].parentNode);},
	        "biz_classified[]":function(){ Effect.twinkle(f["biz_classified[]"][0].parentNode);},
	        biz_name:function(){ Effect.twinkle(f.biz_name);},
	        jp_trade_yn:function(){ f.jp_trade_yn[0].focus();f.jp_trade_yn[0].focus();Effect.twinkle(f.jp_trade_yn[0].parentNode);},
	        etc_trade_yn:function(){ f.etc_trade_yn[0].focus(); f.etc_trade_yn[0].focus();Effect.twinkle(f.etc_trade_yn[0].parentNode);}
	        })
    )
    {
    	if ( !checkBizRegNo(f.company_code1.value + f.company_code2.value + f.company_code3.value) ) {
    		alert("사업자번호가 올바르지 않습니다.");
    		exec = false;
    	} else{
//    		alert("valid");
    	}
    	if ( exec ) {
    	    // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
            //  call(requestType,className,method,argus,cb,form)
//    		log(JSON.stringify(Form.jsonData(f)));
//    		call(requestType,className,method,argus,cb,form) {
	        call('FORM.FILE','admin.Company',SOFTMARGUMENT.p_company_no?'update':'insert',
	            {
	            },
    		    function(xmlDoc){
//	            	alert(xmlDoc);
	                var json  = Util.xml2json(xmlDoc);
	                if ( json["return"] == '200' ) { // success
	                    alert(json.message); // success
//	                    console.debug(json.insert_id);
	                    if ( json.insert_id ) {
		                    SOFTMARGUMENT.p_company_no = json.insert_id
	                    }
	                    onInit(SOFTMARGUMENT);
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

function 우편번호팝업() {
	var win = UI.openWindow('/service/inc/common/post_search_popup.php?callbackfunction=setZipCodeData', 350, 300,'w_zipcode_search',{scrollbars:'no'}).focus();
	return false;
}
function setZipCodeData(data) {
	document.wForm.zip_code.value = data.zipcode;
	document.wForm.addr_kr.value = data.address.trim();
	//console.debug(data);
}