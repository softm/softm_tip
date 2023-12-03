    <!--
    function ObjectChecked ( Obj, SelectedVal ) {

        if ( isNaN ( Obj.length ) ) {
            if ( Obj.value == SelectedVal ) {
                Obj.checked = true;
            } else {
                Obj.checked = false;
            }
        } else {
            for (i=0 ; i<Obj.length; i++) {
                if ( Obj[i].value == SelectedVal ){
                    Obj[i].checked = true;
                    break;
                } else {
                    Obj[0].checked = false;
                }
            }
        }
    }


    function ObjectMutiChecked ( Obj, SelectedVal ) {

        if ( isNaN ( Obj.length ) ) {
            if ( Obj.value == SelectedVal ) {
                Obj.checked = true;
            }
        } else {
            for (var i=0 ; i<Obj.length; i++) {
                if ( Obj[i].value == SelectedVal ){
                    Obj[i].checked = true;
                    break;
                }
            }
        }
    }

    function ObjectCheck ( Obj, idx ) {

        if ( isNaN ( Obj.length ) ) {
            Obj.checked = true;
        } else {
            for (i=0 ; i<Obj.length; i++) {
                if ( i == idx ){
                    Obj[i].checked = true;
                    break;
                } else {
                    Obj[i].checked = false;
                }
            }
        }
    }

    function isChecked ( Obj ) {
        var rtn = false;
        if ( typeof( Obj.length ) == "undefined" ) {
            if ( Obj.checked ) {
                rtn = true;
            } else {
                rtn = false;
            }
        } else {
            for ( var i=0; i<Obj.length; i++){
                if ( Obj[i].checked ) {
                    rtn = true;
                    break;
                }
            }
        }
        return rtn;
    }

    function checkedIndex ( Obj ) {
        var rtn = -1;
        if ( typeof( Obj.length ) == "undefined" ) {
            if ( Obj.checked ) {
                rtn = 0;
            }
        } else {
            for ( var i=0; i<Obj.length; i++){
                if ( Obj[i].checked ) {
                    rtn = i;
                    break;
                }
            }
        }
        return rtn;
    }

    function checkedValue ( Obj ) {
        var rtn = "";
        if ( typeof( Obj.length ) == "undefined" ) {
            if ( Obj.checked ) {
                rtn = Obj.value;
            } else {
                rtn = "";
            }
        } else {
            for ( var i=0; i<Obj.length; i++){
                if ( Obj[i].checked ) {
                    rtn = Obj[i].value;
                    break;
                }
            }
        }
        return rtn;
    }

    function ObjectCheckedClear ( Obj ) {
        if ( isNaN ( Obj.length ) ) {
            Obj.checked = false;
        } else {
            for (i=0 ; i<Obj.length; i++) {
                Obj[i].checked = false;
            }
        }
    }
    //-->