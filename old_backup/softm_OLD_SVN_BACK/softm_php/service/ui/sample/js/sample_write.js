function onInit() {
    //alert("load");
    //alert(Util.Browser.msie);
    if (jQuery.browser.msie) {
        document.wForm.user_name.onfocus=Util.Form.placeHolder;
        document.wForm.user_id.onfocus=Util.Form.placeHolder;
      //document.wForm.passwd.onfocus=Util.Form.placeHolder;
      //document.wForm.passwd.setAttribute("org_type",document.wForm.passwd.type);
      //document.wForm.passwd.type = "text";
    }
}
function 가입하기() {
    var uName = $('#wForm input[name="user_name"]').val().trim();
    var uId   = $('#wForm input[name="user_id"]'  ).val().trim();
    var passwd= $('#wForm input[name="passwd"]'   ).val().trim();
    //alert("가입하기 : " + uName + " / " + uId + " / " + uId );
    if (!uName) {
        Effect.twinkle($('#wForm input[name="user_name"]')[0]).focus();
    } else if (!uId) {
        Effect.twinkle($('#wForm input[name="user_id"]')[0]).focus();
    //} else if ( !isEmail(uId) ) {
    //    alert("이메일주소를 입력해 주세요.");
    } else if (!passwd) {
        Effect.twinkle($('#wForm input[name="passwd"]')[0]).focus();
    } else {
        if (confirm("가입하시겠습니까?")) {
        	callService({
                bData:{service    : 'MEMBER'       ,
                       className  : 'front.Member',
                       method     : 'simpleWriteExec'     ,
                       argus      : {
                                      p_user_name:uName,
                                      p_user_id:uId,
                                      p_passwd:passwd
                                    }
                },
                cb:function(xmlDoc){
                    var json  = Util.xml2json(xmlDoc);
                    //alert("rtn.xml : " + rtn.xml);
                    //alert("xml.code : " + xml.status.code);
                    //alert(JSON.stringify(json));
                    if (json.status.code == "ERROR") {
                        alert(json.status.message);
                    } else {
                        getUI("front/member","simple_write_end",{params:null,method:'POST',target:"index_content",lib_include:true});
                        alert(json.status.message);
                    }
                    //alert(xml.result.code);
                },
                debug:false,
                contentType:"text/xml; charset=UTF-8"
            });
        }
    }
    return false;
}
