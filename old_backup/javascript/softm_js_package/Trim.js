//******************************************************/
//** Function Name    : Trim
//** Description      : 문자열 공백 제거
//** Argument1        : TheString ( 시작 일자 )
//** Argument2        : Gubun     ( '1' : 문자열의 앞과 뒤 부분의   공백 제거 )
//                                ( '2' : 문자열 전체에 포함된 모든 공백 제거 )
//******************************************************/

<!--
/*============================공백 제거를 위한 Trim함수======================================*/
function Trim(TheString, Gubun) 
{ 
    var RtnString = "";
//    document.write ( "start::" + TheString + ":::end<BR>");
    if ( TheString != '' && TheString.length > 0 ) {
        if ( isNaN (Gubun) || Gubun == '' || Gubun == '1' ) {
//            document.write ( "start::" + TheString.replace ( /^\s*/ , "" ).replace ( /\s*$/ , "" ) + ":::end<BR>");
            RtnString = TheString.replace ( /^\s*/ , "" ).replace ( /\s*$/ , "" );
        } else if ( Gubun == '2' ) {
//            document.write ( "start::" + TheString.replace ( /[\s*]/g , "" ) + ":::end");
            RtnString = TheString.replace ( /[\s*]/g , "" );
        }
    }
    return RtnString;
} 
/*============================END 공백 제거를 위한 Trim함수==================================*/
//-->

