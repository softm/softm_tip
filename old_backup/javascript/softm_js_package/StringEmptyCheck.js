<!--
//**************** ��ġ ýũ ***************************//
//** Function Name	: StringEmptyCheck *****************//
//** Argument1		: argu_str ( �Էµ� ���ڿ� )    ****//
//******************************************************//
function StringEmptyCheck(argu_str) 
{
  var ii = 0;
  var ch1="";
  for (var i=0;i<argu_str.length;i++)
  {
      var ch1 = argu_str.substring(i,i+1);
      if ( ch1 != " " ) { ii=10;}
      else {ii = 0; break;}
  }

  if ( ii == 0 ){ return false;} else { return true; }

}
//-->