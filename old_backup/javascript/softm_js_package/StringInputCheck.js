<!--
//**************** ��ġ ýũ ***************************//
//** Function Name	: StringInputCheck *****************//
//** Argument1		: argu_str ( �Էµ� ���ڿ� )    ****//
//******************************************************//
function StringInputCheck(argu_str) 
{
//            alert ( "ź��ϴ�. " );
    if ( typeof ( argu_str ) == "object" ) {
        argu_str = argu_str.value;
    }
    var ch1="";
    for (var i=0;i<argu_str.length;i++) {    ch1 += " ";        }
    if ( argu_str == ch1 ) {
//            alert ( "�����߻� " );
        return false;
    }
//            alert ( "���� " );
    return true;
}
//-->