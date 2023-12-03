<!--
//**************** ��ġ ýũ ***************************//
//** Function Name	: IsKorea **************************//
//** Argument1		: argu_str ( �Էµ� ���ڿ� )********//
//** Return ��		: 1 :  �ùٸ� �ѱ۰� ***************//
//** Return ��		: 2 :  �ùٸ������� ( �ùٸ��� ���� �ѱ۰� ���� ) //
//** Return ��		: 3 :  �ùٸ������� ( ������ ���� ) //
//** Return ��		: 4 :  �ùٸ������� ( ���ڰ� ���� ) //
//** Return ��		: 5 :  �ùٸ������� ( Ư������ ���� ) //
//******************************************************//
function IsKorea(argu_str)
{
    var ch = 0;
    for(var i = 0; i < argu_str.length; i++) {
        var chr = escape(argu_str.substr(i,1));

        chr1 = chr.charAt(1);

        if ( IsNumber(chr1) ) {
//            alert ( 'Ư�����ڰ� ����' );
            return 5;
        }
        chr1 = chr.charAt(1);
//        alert ( chr1 );
        if ( chr1 == 'u' ) {
            key_num = chr.substr(2,(chr.length-1));
        // �� : %uAC00
        // �R : %uD7A3
            if((key_num < "AC00") || (key_num > "D7A3")) { 
//                alert ( '�ùٸ��� ���� �ѱ� ����' );
                return 2; 
            }
//            alert ( '�ùٸ� �ѱ�' );
        } else if ( chr1 == '' ) {
            if ( IsNumber(argu_str.substr(i,1)) ) {
//                alert ( '���ڰ� ����' );
                return 4;
            } else {
//                alert ( '������ ����' );
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