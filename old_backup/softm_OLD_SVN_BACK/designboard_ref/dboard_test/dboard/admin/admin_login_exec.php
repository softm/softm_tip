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
            simpleSQLExecute($sql);   /* �α��� ���� �Է� */

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
                /* �����ͺ��̽� ���� ���� ���� */
                $setupInfor  = "<?\n";
                $setupInfor .= $driver      . "\n"; // ����̹�
                $setupInfor .= $host_nm     . "\n"; // host ��
                $setupInfor .= $db_nm       . "\n"; // db ��
                $setupInfor .= $id          . "\n"; // ����� ���̵�
                $setupInfor .= $password    . "\n"; // ����� ��й�ȣ
                $setupInfor .= $base_dir    . "\n"; // ��� ���丮
                $setupInfor .= $setup_dir   . "\n"; // ��ġ ��Ʈ
                $setupInfor .= $login_skin  . "\n"; // ���� ��Ų
                $setupInfor .= "?>";
                $fp = @fopen ( "config.php", "w") Or MessageExit('U', '0006',"");
                fwrite ( $fp, $setupInfor,strlen($setupInfor) );
                @chmod("config.php"     ,0707);
            }
            $params['branch'] = 'setup';
            formMove('test','admin_login.php', $params);// ��� ���� ���� (��ȸ) �̵�
        }
        else { // Parameter ������ ���
    //      logs ( '$gubun : ' . $gubun, true );
            redirectPage("admin_login.php"); // �Խ��� ���� (��ȸ) �̵�
        }
    }
}
?>