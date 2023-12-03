var valid = false;
function 로그인() {
    if (
        Form.validate( $S('lForm') ,{
	        user_id:function(){ Effect.twinkle($S('lForm').user_id);},
	        passwd:function(){ Effect.twinkle($S('lForm').passwd);}
        })
    )
    {

    // requestType : 'POST', // JSON, POST, FORM, FORM.FILE
    //  call(requestType,className,method,argus,cb,form)
        call('JSON','common.Session','login',
            {
        	p_user_id:$S('lForm').uid.value.trim(),
        	p_passwd:$S('lForm').upass.value.trim()
            //, save_user_id:$('#lForm input[name="save_user_id"]').is(":checked")?"Y":"N"
            },
//            function(xmlDoc){
           	function(json){
//                var json  = Util.xml2json(xmlDoc);
//                alert(json);
                if ( json["return"] == '200' ) { // success
//                    alert(json.message); // success
					if (  $S('lForm').back.value ) document.location.href = $S('lForm').back.value;
                    else document.location.href = "/";
                } else if (json["return"] == '500') {
                    alert(json.message); // error
                }
            }
        );
    }
    return false;
}

function 회원정보팝업() { // 510*415 
	var win = UI.openWindow('/service/inc/common/member_regist_popup.php', 510, 415,'w_mem_reg',{scrollbars:'yes'}).focus();
	return false;
}
function 아이디비밀번호찾기팝업() { // 510*500 
	var win = UI.openWindow('/service/inc/common/member_findid_popup.php', 510, 500,'w_findid_mail',{scrollbars:'yes'}).focus();
	return false;
}

function idCheck(userId) {
    var rtn = {check:true,message:''};
    if (userId.trim()) {
        if ( userId.length < 4 || userId.length > 20 ) {
            rtn.message = "아이디는 4자 이상, 20자 이하여야 합니다.";
            rtn.check = false;
        } else if ( !userId.trim() ) {
            rtn.message = "아이디가 입력되지 않았거나 공백 문자를 사용하셨습니다.";
            rtn.check = false;
        } else if ( !isAlphaNum (userId) ) {
            rtn.message = "'영문', '숫자', '_'만 입력할 수 있습니다.";
            rtn.check = false;
        } else {
            rtn.message = "사용할 수 있는 아이디입니다.";
            rtn.check = true;
        }
    } else {
        rtn.message = "아이디를 입력해주세요.";
        rtn.check = false;
    }
    return rtn;
}

function isAlphaNum (argu)
{
    var AlphaNum = "1234567890_ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var ch1 = '';
    var ii=0;
    var L = argu.length;
    argu = argu.toUpperCase();
    for (var i=0; i < L; i++) {
        ch1 = argu.charAt(i);
        if ( AlphaNum.indexOf(ch1) < 0 ) { ii = 0; break; }
        else { ii=10; }
    }
    if ( ii == 10 ) { return true; } else { return false; }
}

function setSession(k,v) {
    // 기준정보 조회
    callJSONSync('common.Common','setSession',
        {
            k:k
            ,
            v:v
        },
        function(xmlDoc){
            var json  = Util.xml2json(xmlDoc);
            var  items = json.item;
            if ( json['return'] == '200' ) { 
                if ( items ) {
                } else {
                }
            } else if (json['return'] == '500') {
            }
        }
    );
}
