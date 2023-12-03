    <!--
    document.body.onmousedown = MouseObjectPosition;
    var  xPos = 0;
    var  yPos = 0;
    function MouseObjectPosition (e) {
        var ie = ( document.all     ) ? 1 : 0;
        var ns = document.getElementById && !document.all ? 1 : 0;
        if ( ie ) {
            xPos = window.document.body.scrollLeft + window.event.clientX;
            yPos = window.document.body.scrollTop  + window.event.clientY;
        } else if( ns ) {
            xPos = e.pageX;
            yPos = e.pageY;
        }
//        alert ( xPos + " / " + yPos );
    }

    function getMouseXPos() {
        return xPos;
    }
    function getMouseYPos() {
        return yPos;
    }
    //-->