<?
/*
* include 되었는지를 검사
**/
if( defined("_dboard_service_included") ) return;
    define ("_dboard_service_included", true);

if ( !$config ) {
    head    (); // Header 출력
    Message ('U', '0002',"" ); // 설치가 완료 되지 않았습니다.
    footer  ()               ; // Footer 출력
}

/*
* 함수명: _notice_css
* 설명  : notice style sheet
* Argus : dir : css 경로명.
**/
function _notice_css($css_name, $dir) {
    echo ( "<link rel=stylesheet href='" . $dir . $css_name . ".css' type='text/css'>\n" );
}

/*
* 함수명: _css
* 설명  : 상단 부분 출력
* Argus : dir : css 경로명.
**/
function _poll_css($css_name, $dir) {
    echo ( "<link rel=stylesheet href='" . $dir . $css_name . ".css' type='text/css'>\n" );
}

/*
* 함수명: setPointGrant
* 설명  : 게시판별 포인트 정보를 수정 합니다.
* Argus : $bbsId : 게시판 아이디
* Argus : $point : 가산/감산 포인트
**/
function setPointGrant ($user_id, $point=0) {
    global $tb_member, $HTTP_SESSION_VARS, $_s_memInfor;
    $_s_memInfor = $HTTP_SESSION_VARS["_s_memInfor"];
    $mPoint      = $_s_memInfor['point']; // 회원 포인트
    $point       = (int) $point;
    $sign        = '+'; // 부호
    $_s_memInfor['point'] = $mPoint + $point; // 포인트 기록
    if ( $point < 0 ) { $sign = '-'; $point = abs($point); }
    $sql  = "update $tb_member";
    $sql .= " set point = point $sign $point";
    $sql .= " where user_id = '" . $user_id . "';";
    simpleSQLExecute($sql);
    @session_register("_s_memInfor");
}
?>