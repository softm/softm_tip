//******************************************************/
//** Function Name    : Trim
//** Description      : ���ڿ� ���� ����
//** Argument1        : TheString ( ���� ���� )
//** Argument2        : Gubun     ( '1' : ���ڿ��� �հ� �� �κ���   ���� ���� )
//                                ( '2' : ���ڿ� ��ü�� ���Ե� ��� ���� ���� )
//******************************************************/

<!--
/*============================���� ���Ÿ� ���� Trim�Լ�======================================*/
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
/*============================END ���� ���Ÿ� ���� Trim�Լ�==================================*/
//-->

