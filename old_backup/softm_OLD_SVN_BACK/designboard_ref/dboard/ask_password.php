<?
if ( !function_exists('_head') ) { exit; }

if      ( $exec == 'delete'                                          ) { $_title = '삭제 - '   . $_dboard_ver;$msgNo = '0026';}
if      ( $exec == 'delete_comment' || $poll_exec == 'delete_comment') { $_title = '의견글 삭제 - ' . $_dboard_ver; $msgNo = '0029';}

if(!eregi($HTTP_HOST,$HTTP_REFERER)) {
    MessageC ('S', $msgNo,"", $skinDir);
} else {
    if ( $exec == 'delete' ) {
        $tmp_title = $title;
        include $libDir . "bbs_one_row_retrive.php"    ; // 게시글 한건 조회
    } else if ( $exec == 'delete_comment' || $poll_exec == 'delete_comment') {
        $tmp_title = $title;
        include $libDir . "comment_one_row_retrive.php"; // 의견글 한건 조회
    }

    $title = $tmp_title;
    // 삭제및 비밀글 확인
    if ( $login_yn == 'Y' ) { // 로그인 한넘 이
       if ( $admin_yn == 'Y' || ( $exec == 'delete'         && $w_user_id && $w_user_id == $user_id )
                             || ( ( $exec == 'delete_comment' || $poll_exec == 'delete_comment' ) && $c_user_id && $c_user_id == $user_id ) ) { // 자기글 삭제시 
           $hide_password_s = "<!--"; $hide_password_e = "-->";
       } else {
           $hide_password_s = ""; $hide_password_e = "";
       }
    } else { // 로그인 안 한넘 이
        $hide_password_s = ""; $hide_password_e = "";
    }

    include $skinDir ."ask_password.php"; // 패스워드 요구
}
?>