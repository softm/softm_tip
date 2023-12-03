<!--    
////////////////////////////////////////////    
// 주민번호의 정확한 형식인지를 체크합니다.    
// strDT : 주민번호1, 주민번호2    
// return : true, false    
///////////////////////////////////////////    
function JuminCheck( ls_jumin1, ls_jumin2 ) {    
    
var chk =0;    
var ii = 0;    
var ch1 ="";    
var ls_jumin, ls_jumin1, ls_jumin2;    
    
ls_jumin = ls_jumin1 + ls_jumin2;    
    
if (ls_jumin1.length != 6){ return false; }    
    
if (ls_jumin2.length != 7){ return false; }    
    
for(var i = 0; i <=5 ; i++)    
chk = chk + ((i%8+2) * parseInt(ls_jumin1.substring(i,i+1)));    
    
for(var i = 6; i <=11 ; i++)    
chk = chk + ((i%8+2) * parseInt(ls_jumin2.substring(i-6,i-5)));    
    
chk = 11 - (chk %11);    
chk = chk % 10;    
    
if (chk != ls_jumin2.substring(6,7)){ return false; }    
    
return true;    
    
}    
//-->