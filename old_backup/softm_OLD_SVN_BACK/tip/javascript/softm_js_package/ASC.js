<!--
function ASC(v) {
    var initvalue = parseInt(v);
    var remainder = 16;
    var i = 0;
    hexvalue  = new Array();
    var share     = 16;
    while ( share >= 16 ) { 
        share     = parseInt( initvalue / 16 ) ;
        remainder = initvalue % 16;
        if ( remainder == 15 ) { hexvalue[i] = "F"; }
        if ( remainder == 14 ) { hexvalue[i] = "E"; }
        if ( remainder == 13 ) { hexvalue[i] = "D"; }
        if ( remainder == 12 ) { hexvalue[i] = "C"; }
        if ( remainder == 11 ) { hexvalue[i] = "B"; }
        if ( remainder == 10 ) { hexvalue[i] = "A"; }
        if ( remainder != 10 && remainder != 11 && remainder != 13  && remainder != 14 && remainder != 15 ) hexvalue[i] = remainder;
        initvalue = share;
        i++;
    }
    hexvalue.reverse();
    var returnvale = share + "" + hexvalue.join("");
    return returnvale;
}
//-->