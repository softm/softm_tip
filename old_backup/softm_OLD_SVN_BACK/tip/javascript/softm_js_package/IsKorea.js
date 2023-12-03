<!--
//**************** ¼öÄ¡ Ã½Å© ***************************//
//** Function Name	: IsKorea **************************//
//** Argument1		: argu_str ( ÀÔ·ÂµÈ ¹®ÀÚ¿­ )********//
//** Return °ª		: 1 :  ¿Ã¹Ù¸¥ ÇÑ±Û°ª ***************//
//** Return °ª		: 2 :  ¿Ã¹Ù¸£Áö¾ÊÀ½ ( ¿Ã¹Ù¸£Áö ¾ÊÀº ÇÑ±Û°ª Æ÷ÇÔ ) //
//** Return °ª		: 3 :  ¿Ã¹Ù¸£Áö¾ÊÀ½ ( ¿µ¹®°ª Æ÷ÇÔ ) //
//** Return °ª		: 4 :  ¿Ã¹Ù¸£Áö¾ÊÀ½ ( ¼ýÀÚ°ª Æ÷ÇÔ ) //
//** Return °ª		: 5 :  ¿Ã¹Ù¸£Áö¾ÊÀ½ ( Æ¯¼ö¹®ÀÚ Æ÷ÇÔ ) //
//******************************************************//
function IsKorea(argu_str)
{
    var ch = 0;
    for(var i = 0; i < argu_str.length; i++) {
        var chr = escape(argu_str.substr(i,1));

        chr1 = chr.charAt(1);

        if ( IsNumber(chr1) ) {
//            alert ( 'Æ¯¼ö¹®ÀÚ°ª Æ÷ÇÔ' );
            return 5;
        }
        chr1 = chr.charAt(1);
//        alert ( chr1 );
        if ( chr1 == 'u' ) {
            key_num = chr.substr(2,(chr.length-1));
        // °¡ : %uAC00
        // ÆR : %uD7A3
            if((key_num < "AC00") || (key_num > "D7A3")) { 
//                alert ( '¿Ã¹Ù¸£Áö ¾ÊÀº ÇÑ±Û Æ÷ÇÔ' );
                return 2; 
            }
//            alert ( '¿Ã¹Ù¸¥ ÇÑ±Û' );
        } else if ( chr1 == '' ) {
            if ( IsNumber(argu_str.substr(i,1)) ) {
//                alert ( '¼ýÀÚ°ª Æ÷ÇÔ' );
                return 4;
            } else {
//                alert ( '¿µ¹®°ª Æ÷ÇÔ' );
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