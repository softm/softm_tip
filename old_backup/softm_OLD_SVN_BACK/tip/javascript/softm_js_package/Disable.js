    <!--
    //**************** Object의 상태를 활성화 합니다. *********//
    //** Function Name    : ReadOnly     **********************//
    //** Argument1        : obj     ( Object                 ) //
    //** Argument2        : status  ( ReadOnly상태 : boolean ) //
    //** Argument3        : bgcolor ( 배경색                 ) //
    //*********************************************************//
    function Disable ( obj, status, bgcolor ) {
        if ( status == true ) { obj.value = ""; }
        obj.disabled                = status;     // ReadOnly 상태의 설정
        obj.style.backgroundColor   = bgcolor ;   // Backgroud ColorSetting 속성
    }
    //-->