<!--
//**************** 수치 첵크 ***************************//
//** Function Name  : IsNumber       *******************//
//** Argument1      : argu_number ( 입력된 숫자 값 )****//
//******************************************************//
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