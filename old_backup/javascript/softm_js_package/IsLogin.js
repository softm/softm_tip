<!--
function IsLogin (strLogin,Max,Min) { 
//*********************************** ID     üũ********************************************//
    var ii  = 0;
    var ch1 = "";

    if (strLogin == "" || strLogin.length < Min || strLogin.length > Max) {
        alert("ID�� "+ Min + "~" + Max + "�ڸ��� �Է��ϼ���.");
        return false;
    }

    ii  =  StringEmptyCheck(strLogin);

    /*----------------------------------- Ư�� ���� üũ ----------------------------------------*/
    for( i=0 ; i < strLogin.length; i++){
          var ch1 = strLogin.substring(i,i+1);
        if ( !( ( ch1 >= 'a') && ( ch1 <= 'z' ) || ( ch1 >= 'A') && ( ch1 <= 'Z' ) ||( ch1 >= '0' ) && ( ch1 <= '9'  ) )  ) {
                jj=0;
                break;
        }else{  jj=10; }
    }

    if (( strLogin== "" ) || ( ii == 0 ) || ( jj == 0 )) {
        alert("ID �Է��� �ùٸ��� �ʽ��ϴ�.");
        return false;
    }
}
/************************************����� ���̵� üũ END***********************************/
//-->