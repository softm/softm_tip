//******************************************************/
//** Function Name    : Retrive
//** Description      : ��ȸ�� Form��ü, ������ġ , �� �ڷ���� �Ѱ� ������ 
//                    : submit �մϴ�.
//** Argument1        : form     : �� Object
//** Argument2        : start    : ���� ��ġ
//** Argument3        : totcount : �� �ڷ��
//******************************************************/
<!--
    function Retrive(form, start, totcount ) {
        if ( typeof ( form ) == 'object' ) {
            if ( typeof ( form.p_start ) == 'object' ) {
                form.p_start.value    = '1';
            }
            if ( typeof ( form.p_totcount ) == 'object' ) {
                form.p_totcount.value = '' ;
            }
            form.submit();
        } else {
            alert ( "JavaScript ���� �߻�" );
        }
    }

//******************************************************/
//** Function Name    : PageTab
//** Description      : ������ ���� Ŭ���ؼ� ������ �̵��� �����մϴ�.
//**                  : ���� �̸��� PageTabForm�� �̿��ؾ� �մϴ�.
//** Argument1        : start    : ���� ��ġ
//** Argument2        : totcount : �� �ڷ��
//** Argument3        : action   : �� Object�� �׼� URL
//******************************************************/
    function PageTab ( start, totcount, action ) {
        if ( typeof ( document.PageTabForm ) == 'object' ) {
            if ( typeof ( document.PageTabForm.p_start ) == 'object' ) {
                document.PageTabForm.p_start.value    = start    ;
            }
            if ( typeof ( document.PageTabForm.p_totcount ) == 'object' ) {
                document.PageTabForm.p_totcount.value = totcount ;
            }
            document.PageTabForm.submit();
        } else {
            alert ( "JavaScript ���� �߻�" );
        }
    }
//******************************************************/
//** Function Name    : FormClear
//** Description      : �������ǿ� �̿�Ǵ� �� �ʱ�ȭ
//******************************************************/
    function FormClear (obj) {

        var formObj = null;
        if ( typeof( obj ) == 'object' ) {
            formObj = obj;
        } else {
            formObj = document.PageTabForm;
        }

        if ( typeof ( formObj ) == 'object' ) {
            if ( typeof ( formObj.p_start ) == 'object' ) {
                formObj.p_start.value    = 1;
            }
            if ( typeof ( formObj.p_totcount ) == 'object' ) {
                formObj.p_totcount.value = 0;
            }
        }
    }
//-->