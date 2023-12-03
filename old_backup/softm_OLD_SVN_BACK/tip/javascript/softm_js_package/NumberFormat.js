<!--
//**************** 수치 첵크 ***************************//
//** Function Name    : NumberFormat    ******************//
//** Argument1        : argu_number ( 입력된 숫자 값 )****//
//******************************************************//

function NumberFormat(text)
{
  num    = text;
  len_a1 = num.length;
  if( len_a1 > 3 )
  {
    
    num = num.toString().replace(/\$|\,/g,'');         
    num = Math.floor((num*100+0.5)/100).toString(); 
     
    for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++ ) 
    num = num.substring(0,num.length-(4*i+3))+','+num.substring(num.length-(4*i+3)); 
//    document.MyForm.aaa.value = num;
  }
   return num;
}
//-->