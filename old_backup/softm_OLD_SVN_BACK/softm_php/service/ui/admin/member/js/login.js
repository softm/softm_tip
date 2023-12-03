function onInit() {
//	$S('lForm').user_id.onfocus = Form.numeberOnly;
//	$S('lForm').user_id.onfocus = function(e) { Form.numeberOnly(e,true); }
}

function 실행() {
    if (
        Form.validate( $S('wForm') ,{
	        user_id:function(){ Effect.twinkle($S('wForm').user_id);},
	        passwd:function(){ Effect.twinkle($S('wForm').passwd);}
        })
    )
    {

    // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
    //  call(requestType,className,method,argus,cb,form)
        call('JSON','common.Session','login',
            {
        	p_user_id:$S('wForm').user_id.value.trim(),
        	p_passwd:$S('wForm').passwd.value.trim()
            //, save_user_id:$('#lForm input[name="save_user_id"]').is(":checked")?"Y":"N"
            },
            function(xmlDoc){
                var json  = Util.xml2json(xmlDoc);
                //console.info("json:",json);
                if ( json["return"] == '200' ) { // success
                    alert(json.message); // success
					if (  $S('wForm').back.value ) document.location.href = $S('wForm').back.value;
                } else if (json["return"] == '500') {
                    alert(json.message); // error
                }
            }
        );
    }
    return false;
}
