<?
/*
* include �Ǿ������� �˻�
**/
if( defined("_dboard_service_included") ) return;
    define ("_dboard_service_included", true);

if ( !$config ) {
    head    (); // Header ���
    Message ('U', '0002',"" ); // ��ġ�� �Ϸ� ���� �ʾҽ��ϴ�.
    footer  ()               ; // Footer ���
}

/*
* �Լ���: _notice_css
* ����  : notice style sheet
* Argus : dir : css ��θ�.
**/
function _notice_css($css_name, $dir) {
    echo ( "<link rel=stylesheet href='" . $dir . $css_name . ".css' type='text/css'>\n" );
}

/*
* �Լ���: _css
* ����  : ��� �κ� ���
* Argus : dir : css ��θ�.
**/
function _poll_css($css_name, $dir) {
    echo ( "<link rel=stylesheet href='" . $dir . $css_name . ".css' type='text/css'>\n" );
}

/*
* �Լ���: setPointGrant
* ����  : �Խ��Ǻ� ����Ʈ ������ ���� �մϴ�.
* Argus : $bbsId : �Խ��� ���̵�
* Argus : $point : ����/���� ����Ʈ
**/
function setPointGrant ($user_id, $point=0) {
    global $tb_member, $HTTP_SESSION_VARS, $_s_memInfor;
    $_s_memInfor = $HTTP_SESSION_VARS["_s_memInfor"];
    $mPoint      = $_s_memInfor['point']; // ȸ�� ����Ʈ
    $point       = (int) $point;
    $sign        = '+'; // ��ȣ
    $_s_memInfor['point'] = $mPoint + $point; // ����Ʈ ���
    if ( $point < 0 ) { $sign = '-'; $point = abs($point); }
    $sql  = "update $tb_member";
    $sql .= " set point = point $sign $point";
    $sql .= " where user_id = '" . $user_id . "';";
    simpleSQLExecute($sql);
    @session_register("_s_memInfor");
}
?>