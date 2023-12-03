<?
if ( function_exists('_head') ) {
    $baseWall = "^http^ftp^https"; // 멀 막아야 할까염.
    $IJTSEC = false;
    if ( ( $IJTERROR = strpos ( $libDir, "://") ) > 0 ) {
        if ( strpos ( $baseWall, substr ( $libDir, 0 , $IJTERROR ) ) < 1 ) { $IJTSEC = true; }
    } else { $IJTSEC = true; }

    if ( $IJTSEC ) {
        if ( ( $package == 'board' && $displayView[2] && $bbsGrant['grant_comment'] == 'Y' ) || ( $package == 'poll' && $opiniony_yn == 'Y' && $pollGrant['grant_write'] == 'Y' ) )
        {
            $name          = $memInfor['name' ]; // 이름
            // 의견글 폼
            if ( $login_yn == 'Y' ) { // 로그인 한넘은 비밀번호 다 막구요
               $hide_password_s = "<!--"; $hide_password_e = "-->";
    //         if ( $admin_yn == 'Y' ) { // 이름은 어드민만 수정할 수 있어요..
                    $hide_name_s     = ""; $hide_name_e     = "";
    //         } else {
    //              $hide_name_s     = "<!--"; $hide_name_e     = "-->";
    //         }
            } else { // 로그인 안 한넘 은 이름이랑 패스워드랑 다버요요
                $hide_password_s = ""; $hide_password_e = "";
                $hide_name_s     = ""; $hide_name_e     = "";
            }

            if ( $package == 'board' ) {
                $displayCharacter = $displayList[9]       ;
            } else if ( $package == 'poll' ) {
                $displayCharacter = '1'                   ; // 설문에서 회원이미지는 스킨 의존적으로 반영됨
            }

            $character = '';    // 회원 아이콘
            $character = printMemberIcon($memInfor['member_level'], $user_id, $displayCharacter ); // 회원 아이콘

            if ( file_exists($skinDir ."view_write_comment.php" ) ) {
                include $skinDir ."view_write_comment.php"; //  의견글 입력 스킨
            }
        }
    }
}
?>