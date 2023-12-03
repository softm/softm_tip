<!--
//**************** 수치 첵크 ***************************//
//** Function Name    : IsAlpha.js *******************//
//** Argument1        : argu_str ( 입력된 문자열 )****//
//******************************************************//
function IsAlpha(argu_str)
{
// 65    A ~ 90  Z
// 97    a ~ 122 z
    var ii=0;
    for (var i=0; i < argu_str.length; i++) {
        ch1 = argu_str.substring(i,i+1);
        if ( ( ch1.charCodeAt(i) >= 65 && ch1.charCodeAt(i) <= 90 ) || ( ch1.charCodeAt(i) >= 97 && ch1.charCodeAt(i) <= 122 ) ) {
            ii = 10;
        } else {
            ii = 0;
            break; 
        }
    }
    if ( ii == 10 ) {    return true; } else {     return false; }
}
//-->