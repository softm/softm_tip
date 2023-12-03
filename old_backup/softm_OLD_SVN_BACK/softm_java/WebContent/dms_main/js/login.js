function onInit(argus) {
	//	console.debug(argus);
}

function fLogin(f){
    var user_id = f.EMP_NO.value.trim();
    var passwd  = f.USER_PW.value.trim();
//    console.debug(dms);
//    return false;
    if (!user_id) {
        //Alert.show({id:'message_box',message:'회원아이디를 정확히 입력해 주세요!',ok:function(){f.user_id.focus();}});
        alert('회원아이디를 정확히 입력해 주세요!'); 
        f.EMP_NO.focus();
//    } else if (!passwd) { 
//        //Alert.show({id:'message_box',message:'비밀번호를 정확히 입력해 주세요!',ok:function(){f.passwd.focus();}});
//        alert('비밀번호를 정확히 입력해 주세요!');
//        f.USER_PW.focus();
    } else {
        call('JSON',"member/login",
            {
        		p_user_id:user_id,
        		p_passwd:passwd
        	},
            function(json) {
                if ( json['return'] == '200' ) { // success      
//                	alert(json.message);
                    //document.location.href = f.back.value.trim()?f.back.value.trim():document.location.href.replace(/#/g,'');
                	document.location.href = "service.jsp?p_prg=dms_main/main";
                } else {
                    alert(json.message); // error
                }
            }
        );

    }
    return false;
}
