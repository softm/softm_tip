<?
if ( !function_exists('_head') ) { exit; }

if      ( $exec == 'delete'                                          ) { $_title = '���� - '   . $_dboard_ver;$msgNo = '0026';}
if      ( $exec == 'delete_comment' || $poll_exec == 'delete_comment') { $_title = '�ǰ߱� ���� - ' . $_dboard_ver; $msgNo = '0029';}

if(!eregi($HTTP_HOST,$HTTP_REFERER)) {
    MessageC ('S', $msgNo,"", $skinDir);
} else {
    if ( $exec == 'delete' ) {
        $tmp_title = $title;
        include $libDir . "bbs_one_row_retrive.php"    ; // �Խñ� �Ѱ� ��ȸ
    } else if ( $exec == 'delete_comment' || $poll_exec == 'delete_comment') {
        $tmp_title = $title;
        include $libDir . "comment_one_row_retrive.php"; // �ǰ߱� �Ѱ� ��ȸ
    }

    $title = $tmp_title;
    // ������ ��б� Ȯ��
    if ( $login_yn == 'Y' ) { // �α��� �ѳ� ��
       if ( $admin_yn == 'Y' || ( $exec == 'delete'         && $w_user_id && $w_user_id == $user_id )
                             || ( ( $exec == 'delete_comment' || $poll_exec == 'delete_comment' ) && $c_user_id && $c_user_id == $user_id ) ) { // �ڱ�� ������ 
           $hide_password_s = "<!--"; $hide_password_e = "-->";
       } else {
           $hide_password_s = ""; $hide_password_e = "";
       }
    } else { // �α��� �� �ѳ� ��
        $hide_password_s = ""; $hide_password_e = "";
    }

    include $skinDir ."ask_password.php"; // �н����� �䱸
}
?>