<!--

/* Object�� ��Ŀ���� �ݴϴ�. */
function setFocus (obj){
    if ( typeof ( obj ) == 'object' ) {
        obj.focus();
    } else {
        window.status = "setFocus JavaScript ���� �߻�1 +" + obj ;
    }
}
                                                
/* Form Element�� ���� �Ҵ��մϴ�. */
function setObjectValue (obj1, obj2) {
    if ( typeof ( obj1 ) == "object" && typeof ( obj2 ) == "object" ) {
        obj1.value = obj2.value;
    } else {
        window.status = "setObjectValue JavaScript ���� �߻�1 +" + obj1 + " / " + obj2 ;
    }
}

/* Form Element�� ���� �Ҵ��մϴ�. */
function setValue (obj, value){
    if ( typeof ( obj ) == 'object' ) {
            obj.value = value;
    } else {
        window.status = "setValue JavaScript ���� �߻�1 +" + obj + " / " + value ;
    }
}

/* Form A�� ���� Form B �� ī�� �մϴ�. */
function copyElement (frmParentStr,frmPropNm, toParentStr,toPropNm) {
    var frmObj = eval ( frmParentStr + "." + frmPropNm   );
    var toObj  = eval ( toParentStr  + "." + toPropNm    );
//  alert ( " copyElement : " + typeof ( frmObj )  + ' / ' + typeof ( toObj ) );

    if ( typeof ( frmObj ) == "object" && typeof ( toObj ) == "object" ) {
        toObj.value = frmObj.value;
    } else {
//        window.status = "copyElement JavaScript ���� �߻�1 + " + toObj );
    }
}

/* Form Element�� ���� ���ɴϴ�. */
function getValue (obj){
    if ( typeof ( obj ) == 'object' ) {
        return obj.value;
    } else {
        window.status = "getValue JavaScript ���� �߻�2 + " + obj ;
        return '';
    }
}

/* Form�� Action �������� �����Ͽ� �������. */
// enctype : application/x-www-form-urlencoded
//         : multipart/form-data                : �������۽�
function submitForm (form, action, enctype, method){
    if ( typeof( form ) == 'object' ) {
        if ( typeof( action ) != 'undefined' && action != '' ){
            form.action = action;
        }
        if ( typeof( enctype ) != 'undefined' && enctype != '' ){
            form.enctype = enctype;
        }

        if ( typeof( method ) != 'undefined' && method != '' ){
            form.method = method;
        }

        form.submit();
    } else {
        window.status = "submitForm JavaScript ���� �߻�" ;
    }
}

/* Form�� mode���� �Ҵ��մϴ�. */
/* �Է� mode : 'insert' */
/* ���� mode : 'update' */
/* ���� mode : 'delete' */
function process (form, mode){
    if ( typeof( form ) == 'object' ) {
        if ( mode != '' && typeof( mode ) != 'undefined' ) {
            form.p_mode.value = mode;
        }
    } else {
        window.status = "process JavaScript ���� �߻�" ;
    }
}
//->