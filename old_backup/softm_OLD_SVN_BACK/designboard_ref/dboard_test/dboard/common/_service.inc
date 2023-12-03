<?
/*
* include �Ǿ������� �˻�
**/
if( defined("_dboard_service_included") ) return;
    define ("_dboard_service_included", true);

if ( !$config ) {
    MessageHead('U', '0002',"" ); // ��ġ�� �Ϸ� ���� �ʾҽ��ϴ�.
}

define("TAG_FILTER_TYPE1", "input|td|tr|table|div|span|textarea|xmp|pre|script|!DOCTYPE");
define("TAG_FILTER_TYPE2", "!DOCTYPE");

/*
* �Լ���: setPointGrant
* ����  : �Խ��Ǻ� ����Ʈ ������ ���� �մϴ�.
* Argus : $bbsId : �Խ��� ���̵�
* Argus : $point : ����/���� ����Ʈ
**/
function setPointGrant ($user_id, $point=0) {
    global $tb_member, $_SESSION, $_s_memInfor;
    $_s_memInfor = $_SESSION["_s_memInfor"];
    $mPoint      = $_s_memInfor['point']; // ȸ�� ����Ʈ
    $point       = (int) $point;
    $sign        = '+'; // ��ȣ
    $_s_memInfor['point'] = $mPoint + $point; // ����Ʈ ���
    if ( $point < 0 ) { $sign = '-'; $point = abs($point); }
    $sql  = "update $tb_member";
    $sql .= " set point = point $sign $point";
    $sql .= " where user_id = '" . $user_id . "';";
    simpleSQLExecute($sql);
    if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
        @session_register("_s_memInfor");
    } else {
        $_SESSION['_s_memInfor'] = $_s_memInfor;  // 4.10 ���� ó��.
    }
}
?>