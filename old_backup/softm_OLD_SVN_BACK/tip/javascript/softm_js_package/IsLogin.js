<!--
function IsLogin (strLogin,Max,Min) { 
//*********************************** ID     체크********************************************//
    var ii  = 0;
    var ch1 = "";

    if (strLogin == "" || strLogin.length < Min || strLogin.length > Max) {
        alert("ID는 "+ Min + "~" + Max + "자리로 입력하세요.");
        return false;
    }

    ii  =  StringEmptyCheck(strLogin);

    /*----------------------------------- 특수 문자 체크 ----------------------------------------*/
    for( i=0 ; i < strLogin.length; i++){
          var ch1 = strLogin.substring(i,i+1);
        if ( !( ( ch1 >= 'a') && ( ch1 <= 'z' ) || ( ch1 >= 'A') && ( ch1 <= 'Z' ) ||( ch1 >= '0' ) && ( ch1 <= '9'  ) )  ) {
                jj=0;
                break;
        }else{  jj=10; }
    }

    if (( strLogin== "" ) || ( ii == 0 ) || ( jj == 0 )) {
        alert("ID 입력이 올바르지 않습니다.");
        return false;
    }
}
/************************************사용자 아이디 체크 END***********************************/
//-->