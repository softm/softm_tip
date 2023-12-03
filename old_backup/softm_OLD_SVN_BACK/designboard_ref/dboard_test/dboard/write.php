<?
if ( ( $exec == 'insert' || $exec == 'update' || $exec == 'answer' ) && !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(write.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
    /* ------- 게시판 정보 -------------------------------------- */
    $max_capacity = $bbsInfor['max_capacity' ]; // 첨부용량제한 (MB)
    $displayWrite = $bbsInfor['display_write']; // 쓰기 표시 항목
    $displayList  = $bbsInfor['display_list' ]; // 메뉴표시 선택(리스트)

    if ( !$displayWrite[0] ) { $hide_e_mail_s      = "<!--"; $hide_e_mail_e      = "-->";} else { $hide_e_mail_s      = ""; $hide_e_mail_e      = "";} // 이메일
    if ( !$displayWrite[1] ) { $hide_home_s        = "<!--"; $hide_home_e        = "-->";} else { $hide_home_s        = ""; $hide_home_e        = "";} // 홈페이지
    if ( !$displayWrite[2] ) { $hide_file1_s       = "<!--"; $hide_file1_e       = "-->";} else { $hide_file1_s       = ""; $hide_file1_e       = "";} // 파일1
    if ( !$displayWrite[2] ) { $hide_file2_s       = "<!--"; $hide_file2_e       = "-->";} else { $hide_file2_s       = ""; $hide_file2_e       = "";} // 파일2
    if ( !$displayWrite[3] ) { $hide_html_yn_s     = "<!--"; $hide_html_yn_e     = "-->";} else { $hide_html_yn_s     = ""; $hide_html_yn_e     = "";} // HTML
    if ( !$displayWrite[4] ) { $hide_open_yn_s     = "<!--"; $hide_open_yn_e     = "-->";} else { $hide_open_yn_s     = ""; $hide_open_yn_e     = "";} // 비공개
    if ( !$displayWrite[5] ) { $hide_answer_mail_s = "<!--"; $hide_answer_mail_e = "-->";} else { $hide_answer_mail_s = ""; $hide_answer_mail_e = "";} // 답변시에 메일받음
	if ( !$displayWrite[6] ) { $hide_link1_s       = "<!--"; $hide_link1_e       = "-->";} else { $hide_link1_s       = ""; $hide_link1_e       = "";} // 링크1
	if ( !$displayWrite[6] ) { $hide_link2_s       = "<!--"; $hide_link2_e       = "-->";} else { $hide_link2_s       = ""; $hide_link2_e       = "";} // 링크2

    if ( !$displayList [9] ) { $hide_character_s   = "<!--"; $hide_character_e   = "-->";} else { $hide_character_s   = ""; $hide_character_e   = "";} // 회원 아이콘

    $grantCharStr = $bbsInfor['grant_character_image']; // 회원 아이콘 권한
    $character = '';
    if ( $exec == 'update' ) {
       $character = printMemberIcon($w_member_level          , $w_user_id, $displayList[9] );
    } else {
       $character = printMemberIcon($memInfor['member_level'], $user_id  , $displayList[9] );
    }

    // 입력 폼
    if ( $login_yn == 'Y' ) { // 로그인 한넘 이
       if ( $admin_yn == 'N' && $exec == 'update' && !$w_user_id ) { // 비회원글 수정시
           $hide_password_s = ""; $hide_password_e = "";
       } else {
           $hide_password_s = "<!--"; $hide_password_e = "-->";
       }
//     if ( $admin_yn == 'Y' ) {
            $hide_name_s     = ""; $hide_name_e     = "";
//     } else {
//          $hide_name_s     = "<!--"; $hide_name_e     = "-->";
//     }
    } else { // 로그인 안 한넘 이
       if ( $exec == 'update' && $w_user_id ) { // 회원글 수정을 하려구 ...
            MessageExitInner('S', '0025',"", $skinDir); // 수정
       } else {
            $hide_password_s = ""; $hide_password_e = "";
            $hide_name_s     = ""; $hide_name_e     = "";
       }
    }

    // 어드민만 보이게 [공지 사항]
    if ( $admin_yn == 'N' || $exec == 'answer' ) { $hide_ann_yn_s = "<!--"; $hide_ann_yn_e = "-->"; }
    else { $hide_ann_yn_s = ""; $hide_ann_yn_e = ""; }
    /* ---------------------------------------------------------- */

    echo ( "\n<script type='text/javascript'>\n" );
    echo ( "var html_yn  = '".$html_yn   ."';\n" );
    echo ( "var use_st   = '".$use_st    ."';\n" );
    echo ( "var mail_yn  = '".$mail_yn   ."';\n" );
    echo ( "</SCRIPT>\n" );
    $title = _htmlspecialchars ( $title,ENT_QUOTES);

    if ( $f_name1 && $exec == 'update' ) {
		$a_file1 = "<a href='" . $baseDir . "download.php?id=$id&no=$no&gubun=1' target='_dboard_iframe'>";
        $f_size1  = f_size($f_size1);
        $f_name1  = $f_name1 . '.' . $f_ext1;
        $f_infor1 = $baseDir . "data/file/" . $id. "/$f_date1.$f_ext1"; // 파일 실제 경로
    } else {
        $a_file1  = "<a href='#' style='display:none'>";
        $f_size1  = '';
        $f_name1  = '';
        $f_infor1 = '';
    }

    if ( $f_name2 && $exec == 'update' ) {
		$a_file2 = "<a href='" . $baseDir . "download.php?id=$id&no=$no&gubun=2' target='_dboard_iframe'>";
        $f_size2 = f_size($f_size2);
        $f_name2 = $f_name2 . '.' . $f_ext2;
        $f_infor2 = $baseDir . "data/file/" . $id. "/$f_date2.$f_ext2"; // 파일 실제 경로
    } else {
        $a_file2     = "<a href='#' style='display:none'>";
        $f_size2 = '';
        $f_name2 = '';
        $f_infor2= '';
    }
    $error = false;

    if ( $exec == 'insert' ) {
        if( $grant == 'N' ) {
            $error = true;
            Message('S', '0007',"", $skinDir); // 작성
        } else {
            $name             = $memInfor['name'    ]; // 이름
            $e_mail           = $memInfor['e_mail'  ]; // 이메일
            $home             = $memInfor['home'    ]; // 홈페이지
        }
    } else if ( $exec == 'update' ) {
        if(!preg_match("/${HTTP_HOST}/i",$HTTP_REFERER)) {
            $error = true;
            Message('S', '0025',"", $skinDir); // 수정
        }
    } else if ( $exec == 'answer' ) {
        if(!preg_match("/${HTTP_HOST}/i",$HTTP_REFERER)) {
            $error = true;
            Message('S', '0027',"", $skinDir); // 답변
        } else {
            $name             = $memInfor['name'    ]; // 이름
            $e_mail           = $memInfor['e_mail'  ]; // 이메일
            $home             = $memInfor['home'    ]; // 홈페이지

            if ( $mailSendMethod == '1' ) {    // 폼메일
                if ( $e_mail ) {
                    if ( !$mail_popup_width  ) { $mail_popup_width  = 515; }
                    if ( !$mail_popup_height ) { $mail_popup_height = 638; }
                    $a_e_mail = "<a href='#' onClick='openFormMail(\"$package\",\"$id\",\"$user_id\",\"". base64_encode($tmp_name) . "\", \"" . base64_encode($e_mail) . "\",$mail_popup_width, $mail_popup_height);return false;'>";
                }
            } else {                           // 아웃룩
                if ( $e_mail ) {
    //              $name = "<a href='mailto:$e_mail'>$name</a>";
                    $a_e_mail = "<a href='#' onClick='openOutLookMail(\"$package\",\"$id\",\"" . base64_encode($e_mail) . "\");return false;'>";
                }
            }

            //$title = ereg_replace("\[답글\] ","",$title);
            $title = preg_replace("/\[답글\] /","",$title);
            $title = stripslashes("[답글] $title");
    /*
            $subject = ereg_replace("\[답글\] ","",$answer["SUBJECT"]);
            $subject = stripslashes("[답글] $subject");
            $content_temp  = ">$writer 님이 작성하신 글 입니다.\n>";
            $content_temp .= ereg_replace("\n","\n>",$content);
            $content_temp.= "\n--------------------------------------------------------\n";
            $content = $content_temp;
    */
            $content = "\n\r\n\r[원본글] ==============================================================================\n\r" . $content;
        }
    }

    if ( !$error ) {
        include $skinDir ."/write.php"   ; // 글답변 화면

        if ( !$f_name1 ) echo ( "\n\n<script type='text/javascript'>\n" . " hideFileInfor('file1_delete'); hideFileInfor('file1_delete_lable'); \n</SCRIPT>\n" );
        if ( !$f_name2 ) echo ( "\n\n<script type='text/javascript'>\n" . " hideFileInfor('file2_delete'); hideFileInfor('file2_delete_lable'); \n</SCRIPT>\n" );
    }
} else {
    // 페이지 접근이 거부 되었습니다.
    Message('S', '0003',"MOVE:" . getReqPageName () . "$a_params&exec=list:이동 ..");
}
?>