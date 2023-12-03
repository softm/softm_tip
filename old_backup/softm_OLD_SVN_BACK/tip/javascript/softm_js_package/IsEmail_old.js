<!--
//*----------------------------- Start E-Mail üũ -------------------------------------------*/
function IsEmail( arg_email )    {
//alert ( arg_email + ":end" );
var dotcount=0, acount=0;
var ch1, ch2, ch3;
var ii=null;
var L = arg_email.length;
    if ( arg_email != "" ) {
        for(var i=0;i < L ;i++) {
            var ch1 = arg_email.substring(i,i+1);
            if ( ch1 == " " || arg_email.length <= 5  || ch1 == ch2  || ch1 == ch3 ) {
                ii = 0;
                break;
            }
            if ( ch1 == "." ) { ++dotcount; ch2 = ch1;} else { ch2 = "";}
            if ( ch1 == "@" ) { ++acount; ch3 = ch1;} else { ch3 = "";}
        }
    }
/*	document.writeln ("dotcount : " + dotcount + "\n" ); 
	document.writeln ("acount : " + acount + "\n" ); 
	document.writeln ("arg_email.substring(0,1) : " + arg_email.substring(0,1) + "\n" ); 
	document.writeln ("arg_email.substring(L-1,L) : " + arg_email.substring(L-1,L) + "\n" ); 
	document.writeln ("arg_email.indexOf('@.') : " + arg_email.indexOf("@.") + "\n" ); 
	document.writeln ("arg_email.indexOf('.@') : " + arg_email.indexOf(".@") );*/
    if ( ii == 0 || dotcount < 1 || dotcount > 3 || acount != 1 || arg_email.substring(0,1) == "." || arg_email.substring(L-1,L) == "." || arg_email.substring(0,1) == "@" ||  arg_email.substring(L-1,L) == "@" || arg_email.indexOf("@.") > 0 || arg_email.indexOf(".@") > 0) 
    { return false; } 
    else { return true; }
}
//*----------------------------- End E-Mail üũ ---------------------------------------------*/
//-->