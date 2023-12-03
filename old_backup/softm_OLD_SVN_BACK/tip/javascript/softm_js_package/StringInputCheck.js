<!--
//**************** 수치 첵크 ***************************//
//** Function Name	: StringInputCheck *****************//
//** Argument1		: argu_str ( 입력된 문자열 )    ****//
//******************************************************//
function StringInputCheck(argu_str) 
{
//            alert ( "탄답니다. " );
    if ( typeof ( argu_str ) == "object" ) {
        argu_str = argu_str.value;
    }
    var ch1="";
    for (var i=0;i<argu_str.length;i++) {    ch1 += " ";        }
    if ( argu_str == ch1 ) {
//            alert ( "에러발생 " );
        return false;
    }
//            alert ( "성공 " );
    return true;
}
//-->