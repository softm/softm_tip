function onInit() {
	var form = $S('wForm');
    //if (jQuery.browser.msie) {}
//	alert(USER_LEVEL);
	if ( USER_LEVEL == 0 ) {
//		document.location.href = "/";
		alert("로그인후 이용할 수 있습니다.");
		document.location.href = "/sub.php?flashmenu=11912";
		return false;
	}
    if ( USER_LEVEL == 2 ) {
        //alert(USER_NO);
        call('JSON','front.Company','get',
            {p_company_no:COMPANY_NO},
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                //console.debug(json);
                if ( json["return"] == '200' ) { // success
//                	alert(json.message); // success
                	if ( (json.filename1) ) {
                		$S("file1_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno1 + "','f1_" + COMPANY_NO + "_');return false;\">" 
                		                            + ( json.filename1 + ((json.fileext1)?".":"") + (json.fileext1) ) + "</a>"
                								    + "<INPUT TYPE=CHECKBOX name=file1_delete value='Y'> 삭제" ;
                	}
                	if ( (json.filename2) ) {
                		$S("file2_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno2 + "','f2_" + COMPANY_NO + "_');return false;\">" 
                        + ( json.filename2 + ((json.fileext2)?".":"") + (json.fileext2) ) + "</a>"
					    + "<INPUT TYPE=CHECKBOX name=file2_delete value='Y'> 삭제" ;
                	}
                	if ( (json.filename3) ) {
                		$S("file3_infor").innerHTML = "<a href=# onclick=\"fileDownload('" + json.fileno3 + "','f3_" + COMPANY_NO + "_');return false;\">" 
                        + ( json.filename3 + ((json.fileext3)?".":"") + (json.fileext3) ) + "</a>"
					    + "<INPUT TYPE=CHECKBOX name=file3_delete value='Y'> 삭제" ;
                	}
                	
//					Util.domReady(
//						function() {
//							log(json.item);
//							alert(json.fi + ' / ' + json.item);
                	Form.bind(json.fi,json.item,$S('wForm'),{
								company_code:function(form,vv) {
									if ( vv ) {
										form.company_code1.value = vv.substring(0,3);
										form.company_code2.value = vv.substring(3,5);
										form.company_code3.value = vv.substring(5);
									}
								},
								establish_date:function(form,vv) {
//									alert("x" + vv);
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
//	                        alert( items.length );
//	                        var l = items.length;
	                        var l = 5;
	                        for (var i=0; i<l;i++ ) {
	                        	try {
		                            var product_kr = (items[i]['product_kr']);
		                            var product_en = (items[i]['product_en']);
		                            var product_jp = (items[i]['product_jp']);
		                            $S('wForm')["product_kr[]"][i].value = product_kr;
		                            $S('wForm')["product_en[]"][i].value = product_en;
		                            $S('wForm')["product_jp[]"][i].value = product_jp;
	                        		
	                        	} catch(e) {
//	                        		alert(i);
	                        	}
//	                        	alert(v);
	                        }
//						}
                        
//					);
//            	    form['re_passwd'].value = form['passwd'].value;
                    $S('wForm')["biz_classified[]"][8].onclick = function () {
                    	$S('wForm').biz_classified_etc.disabled = !this.checked ;
                    	$S('wForm').biz_classified_etc.focus();
                    }
                    if ($S('wForm')["biz_classified[]"][8].checked) {
                    	$S('wForm').biz_classified_etc.disabled = false;
                    }	                        
                } else if (json["return"] == '500') {
                    alert(json.message); // error
                }
            }
        );
    } else {
        $S('wForm')["biz_classified[]"][8].onclick = function () {
        	$S('wForm').biz_classified_etc.disabled = !this.checked ;
        	$S('wForm').biz_classified_etc.focus();
        }
        if ($S('wForm')["biz_classified[]"][8].checked) {
        	$S('wForm').biz_classified_etc.disabled = false;
        }    	
    }
    
    // 기업회원 가입 전단계이면.
    if ( USER_LEVEL != 2 ) {
        $S('wForm').company_code1.focus();    	
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

//    $S("btn_delete").onclick = function() {
//
//    }
//
//	$S("btn_list").onclick = function() {
//    	//document.location.href = "";
//    }
    
}
function fileDownload(fNo,fNm) {
//    alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
    		p_file_no:fNo,
    		p_file_nm:fNm,
    		p_sub_dir:"company"
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
	        call('FORM.FILE','front.Company',USER_LEVEL==1?'insert':'update',
	            {
	            },
    		    function(xmlDoc){
//	            	alert(xmlDoc);
	                var json  = Util.xml2json(xmlDoc);
	                if ( json["return"] == '200' ) { // success
	                    alert(json.message); // success
//	                    document.location.href = "/service/front.php?sub=mypage&mode=company_write";
	                    document.location.href = "/sub.php?flashmenu=11902";
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

function checkJumin(ssn1,ssn2) {
    var ssn = ssn1+ ssn2;
    if (ssn.length != 13) {
        return false;
    }
    var a=ssn.substring(0,1);
    var b=ssn.substring(1,2);
    var c=ssn.substring(2,3);
    var d=ssn.substring(3,4);
    var e=ssn.substring(4,5);
    var f=ssn.substring(5,6);
    var g=ssn.substring(6,7);
    var h=ssn.substring(7,8);
    var i=ssn.substring(8,9);
    var j=ssn.substring(9,10);
    var k=ssn.substring(10,11);
    var l=ssn.substring(11,12);
    var m=ssn.substring(12,13);
    var sum = 2*a + 3*b + 4*c+ 5*d + 6*e+ 7*f+ 8*g + 9*h+ 2*i+3*j+ 4*k+ 5*l;
    var r1 = sum%11;
    var temp = 11* ((sum-r1)/11) + 11 - sum;
    var r2 = temp%10;
    var temp1 = temp- 10*((temp-r2)/10);
    if (m != temp1) {
        return false;
    }
    return true;
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
