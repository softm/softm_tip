<!--
//**************** 수치 첵크 ***************************//
//** Function Name	: IsKorea **************************//
//** Argument1		: argu_str ( 입력된 문자열 )********//
//** Return 값		: 1 :  올바른 한글값 ***************//
//** Return 값		: 2 :  올바르지않음 ( 올바르지 않은 한글값 포함 ) //
//** Return 값		: 3 :  올바르지않음 ( 영문값 포함 ) //
//** Return 값		: 4 :  올바르지않음 ( 숫자값 포함 ) //
//** Return 값		: 5 :  올바르지않음 ( 특수문자 포함 ) //
//******************************************************//
function IsKorea(argu_str)
{
    var ch = 0;
    for(var i = 0; i < argu_str.length; i++) {
        var chr = escape(argu_str.substr(i,1));

        chr1 = chr.charAt(1);

        if ( IsNumber(chr1) ) {
//            alert ( '특수문자값 포함' );
            return 5;
        }
        chr1 = chr.charAt(1);
//        alert ( chr1 );
        if ( chr1 == 'u' ) {
            key_num = chr.substr(2,(chr.length-1));
        // 가 : %uAC00
        // 힣 : %uD7A3
            if((key_num < "AC00") || (key_num > "D7A3")) { 
//                alert ( '올바르지 않은 한글 포함' );
                return 2; 
            }
//            alert ( '올바른 한글' );
        } else if ( chr1 == '' ) {
            if ( IsNumber(argu_str.substr(i,1)) ) {
//                alert ( '숫자값 포함' );
                return 4;
            } else {
//                alert ( '영문값 포함' );
                return 3;
            }
        }
    } 
    return 1;
}

function IsNumber(argu_number)
{
      var Number = "1234567890.";
      var ii=0;
      var L = argu_number.length;

    for (var i=0; i < L; i++) {
        ch1 = argu_number.substring(i,i+1);
          if ( Number.indexOf(ch1) < 0 ) { ii = 0; break; }
          else { ii=10; }
    }
    if ( ii == 10 ) { return true; } else { return false; }
}
//-->