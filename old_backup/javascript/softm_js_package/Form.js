<!--

/* Object에 포커스를 줍니다. */
function setFocus (obj){
    if ( typeof ( obj ) == 'object' ) {
        obj.focus();
    } else {
        window.status = "setFocus JavaScript 오류 발생1 +" + obj ;
    }
}
                                                
/* Form Element에 값을 할당합니다. */
function setObjectValue (obj1, obj2) {
    if ( typeof ( obj1 ) == "object" && typeof ( obj2 ) == "object" ) {
        obj1.value = obj2.value;
    } else {
        window.status = "setObjectValue JavaScript 오류 발생1 +" + obj1 + " / " + obj2 ;
    }
}

/* Form Element에 값을 할당합니다. */
function setValue (obj, value){
    if ( typeof ( obj ) == 'object' ) {
            obj.value = value;
    } else {
        window.status = "setValue JavaScript 오류 발생1 +" + obj + " / " + value ;
    }
}

/* Form A의 값을 Form B 로 카피 합니다. */
function copyElement (frmParentStr,frmPropNm, toParentStr,toPropNm) {
    var frmObj = eval ( frmParentStr + "." + frmPropNm   );
    var toObj  = eval ( toParentStr  + "." + toPropNm    );
//  alert ( " copyElement : " + typeof ( frmObj )  + ' / ' + typeof ( toObj ) );

    if ( typeof ( frmObj ) == "object" && typeof ( toObj ) == "object" ) {
        toObj.value = frmObj.value;
    } else {
//        window.status = "copyElement JavaScript 오류 발생1 + " + toObj );
    }
}

/* Form Element에 값을 얻어옵니다. */
function getValue (obj){
    if ( typeof ( obj ) == 'object' ) {
        return obj.value;
    } else {
        window.status = "getValue JavaScript 오류 발생2 + " + obj ;
        return '';
    }
}

/* Form을 Action 페이지를 지정하여 서브밋함. */
// enctype : application/x-www-form-urlencoded
//         : multipart/form-data                : 파일전송시
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
        window.status = "submitForm JavaScript 오류 발생" ;
    }
}

/* Form을 mode값을 할당합니다. */
/* 입력 mode : 'insert' */
/* 수정 mode : 'update' */
/* 삭제 mode : 'delete' */
function process (form, mode){
    if ( typeof( form ) == 'object' ) {
        if ( mode != '' && typeof( mode ) != 'undefined' ) {
            form.p_mode.value = mode;
        }
    } else {
        window.status = "process JavaScript 오류 발생" ;
    }
}
//->