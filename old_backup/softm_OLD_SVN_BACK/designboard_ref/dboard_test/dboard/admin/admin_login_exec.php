<?
if ( function_exists('head') ) {
    if ( $branch == 'exec' && preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && ( preg_match( "/(admin_login.php)/", $HTTP_REFERER) || preg_match( "/(admin_member_formsetup.php)$/", $HTTP_REFERER) ) && $REQUEST_METHOD == 'POST' ) {
        if ( $gubun == 'loginsetup' ) {
            $sql  = "delete from $tb_login_abstract;";
            simpleSQLExecute($sql);
            if ( !escapeYN () ) { // magic_quotes_gpc Off
                $message   = addslashes($message  );
            }
            if ( !$scroll_yn  ) { $scroll_yn  = 'N'; }
            if ( !$message_yn ) { $message_yn = 'N'; }
            $sql  = "insert into $tb_login_abstract ( skin_no, skin_name, display_mode, window_width, window_height, left_pos, top_pos, scroll_yn, suc_mode, suc_url, message, base_path, upd_date ) values ( ";
            $sql .= "'0', '$skin_name', '$display_mode', '$window_width', '$window_height', '$left_pos', '$top_pos', '$scroll_yn', '$suc_mode', '$suc_url', '$message', '$base_path', '".getYearToSecond()."' );";
            simpleSQLExecute($sql);   /* 로그인 추출 입력 */

            $f=@file($baseDir . "config.php");
            $old_login_skin = trim(str_replace("\n","",$f[8]));
            if ( $old_login_skin != $login_skin ) {
                $driver     = trim(str_replace("\n","",$f[1]));
                $host_nm    = trim(str_replace("\n","",$f[2]));
                $db_nm      = trim(str_replace("\n","",$f[3]));
                $id         = trim(str_replace("\n","",$f[4]));
                $password   = trim(str_replace("\n","",$f[5]));
                $base_dir   = trim(str_replace("\n","",$f[6]));
                $setup_dir  = trim(str_replace("\n","",$f[7]));
                /* 데이터베이스 설정 정보 수집 */
                $setupInfor  = "<?\n";
                $setupInfor .= $driver      . "\n"; // 드라이버
                $setupInfor .= $host_nm     . "\n"; // host 명
                $setupInfor .= $db_nm       . "\n"; // db 명
                $setupInfor .= $id          . "\n"; // 사용자 아이디
                $setupInfor .= $password    . "\n"; // 사용자 비밀번호
                $setupInfor .= $base_dir    . "\n"; // 기반 디렉토리
                $setupInfor .= $setup_dir   . "\n"; // 설치 루트
                $setupInfor .= $login_skin  . "\n"; // 내부 스킨
                $setupInfor .= "?>";
                $fp = @fopen ( "config.php", "w") Or MessageExit('U', '0006',"");
                fwrite ( $fp, $setupInfor,strlen($setupInfor) );
                @chmod("config.php"     ,0707);
            }
            $params['branch'] = 'setup';
            formMove('test','admin_login.php', $params);// 멤버 종류 관리 (조회) 이동
        }
        else { // Parameter 조작의 경우
    //      logs ( '$gubun : ' . $gubun, true );
            redirectPage("admin_login.php"); // 게시판 관리 (조회) 이동
        }
    }
}
?>