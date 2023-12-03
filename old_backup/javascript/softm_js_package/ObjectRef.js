    function getObject1( objStr, tier ) {
        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        if (is.ie) {
            /* IE */
            obj = eval( docStr + ".all['" + objStr + "']");
        } else if ( is.ns ) {
            /* NS */
            obj = eval( docStr + ".getElementById('" + objStr + "');");
        }
        return obj;
    }


    function getObject( objStr, tier ) {
        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        if (is.ie) {
            /* IE */
            obj = eval( docStr + ".all['" + objStr + "']");
        } else if ( is.ns ) {
            /* NS */
            obj = eval( docStr + ".getElementById('" + objStr + "');");
        }
        return obj;
    }

    function objectShow( id, tier ) {
        var obj = null;
        if ( typeof(id) == 'object' ) {
            obj = id;
        } else {
            obj = getObject(id, tier);
        }
        if ( obj != null && typeof(obj) == 'object' ) { 
            obj.style.visibility="visible"
        }
/*        obj.style.zIndex=0;     Object들의 기본적인 zIndex 값은 0 입니다. */
    }

    function objectHide( id, tier ) {
        var obj = null;
        if ( typeof(id) == 'object' ) {
            obj = id;
        } else {
            obj = getObject(id, tier);
        }
        if ( obj != null && typeof(obj) == 'object' ) { 
            obj.style.visibility="hidden"
        }
    }

    function objectBackColor( id, color, tier ) {
        var obj = null;
        if ( typeof(id) == 'object' ) {
            obj = id;
        } else {
            obj = getObject(id, tier);
        }
        if ( obj != null && typeof(obj) == 'object' ) { 
            obj.style.backgroundColor = color;
        }
    }

    function objectColor( id, color, tier ) {
        var obj = null;
        if ( typeof(id) == 'object' ) {
            obj = id;
        } else {
            obj = getObject(id, tier);
        }
        if ( obj != null && typeof(obj) == 'object' ) { 
            obj.style.color = color;
        }
    }

    function objectMoveTo(id,X,Y, tier) {
        var obj = null;
        if ( typeof(id) == 'object' ) {
            obj = id;
        } else {
            obj = getObject(id, tier);
        }
        if ( obj != null && typeof(obj) == 'object' ) { 
                          obj.style.left = X;
            if ( Y != 0 ) obj.style.top  = Y;
        }
    }

    /* sytle의 Position 값을 설정합니다.
       static , relative, absolute*/
    function objectPosition(id,position, tier) {
        var obj = null;
        if ( typeof(id) == 'object' ) {
            obj = id;
        } else {
            obj = getObject(id, tier);
        }
        if ( obj != null && typeof(obj) == 'object' ) { 
            obj.style.position=position;
        }
    }