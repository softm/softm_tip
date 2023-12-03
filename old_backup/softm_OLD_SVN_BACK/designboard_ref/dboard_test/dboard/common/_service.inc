<?
/*
* include 되었는지를 검사
**/
if( defined("_dboard_service_included") ) return;
    define ("_dboard_service_included", true);

if ( !$config ) {
    MessageHead('U', '0002',"" ); // 설치가 완료 되지 않았습니다.
}

define("TAG_FILTER_TYPE1", "input|td|tr|table|div|span|textarea|xmp|pre|script|!DOCTYPE");
define("TAG_FILTER_TYPE2", "!DOCTYPE");

/*
* 함수명: setPointGrant
* 설명  : 게시판별 포인트 정보를 수정 합니다.
* Argus : $bbsId : 게시판 아이디
* Argus : $point : 가산/감산 포인트
**/
function setPointGrant ($user_id, $point=0) {
    global $tb_member, $_SESSION, $_s_memInfor;
    $_s_memInfor = $_SESSION["_s_memInfor"];
    $mPoint      = $_s_memInfor['point']; // 회원 포인트
    $point       = (int) $point;
    $sign        = '+'; // 부호
    $_s_memInfor['point'] = $mPoint + $point; // 포인트 기록
    if ( $point < 0 ) { $sign = '-'; $point = abs($point); }
    $sql  = "update $tb_member";
    $sql .= " set point = point $sign $point";
    $sql .= " where user_id = '" . $user_id . "';";
    simpleSQLExecute($sql);
    if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
        @session_register("_s_memInfor");
    } else {
        $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 세션 처리.
    }
}
?>