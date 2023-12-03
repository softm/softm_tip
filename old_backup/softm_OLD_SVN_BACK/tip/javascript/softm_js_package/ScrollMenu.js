var scroll_ID = null;

function setScroll_Id(objid) {
    var ie = ( document.all     ) ? 1 : 0;
    var ns6 = document.getElementById && !document.all ? 1 : 0
    var obj = null;
    if ( ie  ) { obj = eval ( "document.all." + objid ); }
    if ( ns6 ) { obj = eval ( "document.getElementById(\"" + objid + "\")"); }

    if ( typeof( obj ) == "object" ) {
        scroll_ID = obj;
    }
}

function ScrollMenu() {	
    if (scroll_ID != null ) {
        var args = ScrollMenu.arguments;
        var Tbtop  = args[0];
        if ( isNaN ( Tbtop ) ) {
            Tbtop  = 0;
        }
    //        Tbtop  = 220 + Tbtop; 
        scroll_ID.style.top = document.body.scrollTop + Tbtop;

    //    Menu.style.top = document.body.scrollTop + 10;
    }
}