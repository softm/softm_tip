    <!--
    function ObjectSelected( Obj, SelectedVal ) {
        if ( typeof ( Obj ) == "object" ) {
            for (i=0 ; i<Obj.length; i++) {
                if ( Obj[i].value == SelectedVal ){
    //                        alert ( document.MyForm.retriveYear[i].value );
                    Obj.selectedIndex = i;
                    break;
                } else {
                    Obj.selectedIndex = 0;
                }
            }
        }
    }
    function ObjectMutiSelected ( Obj, SelectedVal ) {

        if ( typeof ( Obj ) == "object" ) {
            for (i=0 ; i<Obj.length; i++) {
                if ( Obj.options[i].value == SelectedVal ){
                    Obj.options[i].selected = true;
                    break;
                }
            }
        }
    }

    function ObjectMutiSelectClear ( Obj ) {

        if ( typeof ( Obj ) == "object" ) {
            for (i=0 ; i<Obj.length; i++) {
                Obj.options[i].selected = false;
            }
        }
    }
    //-->