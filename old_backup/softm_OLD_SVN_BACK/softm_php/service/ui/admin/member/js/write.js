var ARGUS = null;
function onInit(argus) {
    ARGUS = argus;
//    alert(argus.p_user_no);
    if (jQuery.browser.msie) {}
    if ( ARGUS.p_user_no ) {
        call('JSON','admin.Member','get',
            {
                p_user_no:argus.p_user_no
            },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                if ( json["return"] == '200' ) { // success
    //              alert(json.message); // success
                    getPhp("admin/member","write",{
                        method:'POST',
                        argus : {
    //                        p_company_no:json.company_no,
                            p_user_no:json.item.user_no
    //                        p_user_level:json.user_level
                        },
                        target:"#contents",
                        cb:function() {
                            onDataLoad(json,argus);
                        }
                    });
                    // loadui가 true
                    //onDataLoad(json,argus)
                } else if (json["return"] == '500') {
                    alert(json.message); // error
                }
            }
        );
    } else {
        getPhp("admin/member","write",{
            method:'POST',
            argus : {
            },
            target:"#contents",
            cb:function() {
            }
        });
    }
}

function 목록() {
    getUI("admin/member","list",{
        method:'POST',
        target:"#contents",
        argus:{p_user_level:'',p_user_no:''}
    });	
}
function onDataLoad(json,argus) {
    var form = $S("wForm");
	Form.bind(json.item,$S('wForm')
            ,{
                user_email:function(form,vv) {
                    if ( vv ) {
                        var vvS = vv.split("@");
                        form.user_email1.value = vvS[0];
                        form.user_email2.value = vvS[1];
                        form.s_email_select.value = vvS[1];
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
                birth:function(form,vv) {
                    if ( vv ) {
                        form.birth1.value = vv.substr(0,4);
                        form.birth2.value = parseInt(vv.substr(4,2),10);
                        form.birth3.value = parseInt(vv.substr(6,2),10);
                    }
                }
            }
        );
}

function 실행() {
    if ( $S('wForm').user_email1.value || $S('wForm').user_email2.value )
    {
        $S('wForm').user_email.value = $S('wForm').user_email1.value + '@' + $S('wForm').user_email2.value;
        addClass($S('wForm').user_email,"required");
        addClass($S('wForm').user_email,"email");
    } else {
        $S('wForm').user_email.value = "";
        removeClass($S('wForm').user_email,"required");
        removeClass($S('wForm').user_email,"email");
    }

    if ( $S('wForm').tel1.value != '' || $S('wForm').tel2.value != '' || $S('wForm').tel3.value != ''  )
    {
        addClass($S('wForm').tel1,"required");
        addClass($S('wForm').tel2,"required");
        addClass($S('wForm').tel3,"required");
    } else {
        removeClass($S('wForm').tel1,"required");
        removeClass($S('wForm').tel2,"required");
        removeClass($S('wForm').tel3,"required");
    }

    if ( $S('wForm').passwd_hint.value )
    {
        addClass($S('wForm').passwd_correct,"required");
    } else {
        removeClass($S('wForm').passwd_correct,"required");
    }
    
    if (
        Form.validate( $S('wForm') ,{
            user_email:function(){Effect.twinkle($S('wForm').user_email1).focus()}
        })
    )
    {

        var b = $("#password_change").is(":checked");
        if ( $("#passwd").attr("disabled") ) {
            if ( $S('wForm').passwd.value != $S('wForm').re_passwd.value ) {
                alert("비밀번호와 비밀번호확인이 다릅니다.");
                Effect.twinkle($S('wForm').passwd);
                return false;
            }
        }
    	var exec = false;
    	if ( !$("#user_no").val() ) {
        	if ( confirm("가입하시겠습니까?") ) {
            	exec = 중복검사();
        	} 
    	} else {
    		if ( $S('wForm').passwd.value.trim() ) {
            	if ( confirm("비밀번호를 수정하시겠습니까?") ) {
                	exec = true;
            	}
    		} else {
            	if ( confirm("수정하시겠습니까?") ) {
                	exec = true;
            	}
    		}
    	}
    	if ( exec ) {
    	    // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
            //  call(requestType,className,method,argus,cb,form)
	        call('JSON','admin.Member',ARGUS.p_user_no?"update":"register",
	        	    Form.json($S("wForm"))
	            ,
	            function(xmlDoc){
	                var json  = Util.xml2json(xmlDoc);
	                if ( json["return"] == '200' ) { // success
	                    alert(json.message); // success
	                    목록();
	                } else if (json["return"] == '500') {
	                    alert(json.message); // error
	                }
	            }
	        );
    	}
    }
    return false;
}

var dupCheck = false;
function 중복검사() {
	if ( !$S('wForm').user_id.value ) return false;
	callJSONSync('front.Member','checkDupId',
	    {
	    	p_user_id:$S('wForm').user_id.value.trim()
	    },
	    function(xmlDoc){
	        var json  = Util.xml2json(xmlDoc);
	        if ( json["return"] == '200' ) { // success
//	            alert(json.message); // success
	            dupCheck = true;
	        } else if (json["return"] == '500') {
	            alert(json.message); // error
	            dupCheck = false;
	        }
	    }
	);
	return dupCheck;
}

function 비밀번호변경() {
    var b = $("#password_change").is(":checked");
        $("#passwd").attr("disabled",!b);
        $("#re_passwd").attr("disabled",!b);

    if (b) {
        $("#passwd").focus();
    } else {
        $("#passwd").val("");
        $("#re_passwd").val("");
    }
}

