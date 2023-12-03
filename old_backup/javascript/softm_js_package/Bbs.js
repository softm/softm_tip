//******************************************************/
//** Function Name    : Retrive
//** Description      : 조회시 Form객체, 시작위치 , 총 자료수를 넘겨 받은후 
//                    : submit 합니다.
//** Argument1        : form     : 폼 Object
//** Argument2        : start    : 시작 위치
//** Argument3        : totcount : 총 자료수
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
            alert ( "JavaScript 오류 발생" );
        }
    }

//******************************************************/
//** Function Name    : PageTab
//** Description      : 패이지 탭을 클릭해서 페이지 이동을 실행합니다.
//**                  : 폼의 이름은 PageTabForm을 이용해야 합니다.
//** Argument1        : start    : 시작 위치
//** Argument2        : totcount : 총 자료수
//** Argument3        : action   : 폼 Object의 액션 URL
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
            alert ( "JavaScript 오류 발생" );
        }
    }
//******************************************************/
//** Function Name    : FormClear
//** Description      : 페이지탭에 이용되는 값 초기화
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