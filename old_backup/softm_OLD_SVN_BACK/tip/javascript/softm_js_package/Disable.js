    <!--
    //**************** Object�� ���¸� Ȱ��ȭ �մϴ�. *********//
    //** Function Name    : ReadOnly     **********************//
    //** Argument1        : obj     ( Object                 ) //
    //** Argument2        : status  ( ReadOnly���� : boolean ) //
    //** Argument3        : bgcolor ( ����                 ) //
    //*********************************************************//
    function Disable ( obj, status, bgcolor ) {
        if ( status == true ) { obj.value = ""; }
        obj.disabled                = status;     // ReadOnly ������ ����
        obj.style.backgroundColor   = bgcolor ;   // Backgroud ColorSetting �Ӽ�
    }
    //-->