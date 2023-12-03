<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
if ( $_POST['host_nm'] && $_POST['db_nm'] && $_POST['id'] && $_POST['driver'] ) {
    @set_time_limit ( 0 );
    error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice�� ������ ��翡���� �������ض�~ )
    include 'common/db_connect.inc'   ; // Data Base ���� Ŭ����

    include 'common/lib.inc'    	  ;
    include 'common/board_lib.inc'    ; // �Խ��� ���̺귯��
    include 'common/poll_lib.inc'     ; // ���� ���̺귯��
    include 'common/event_lib.inc'    ; // �̺�Ʈ ���̺귯��
    include 'common/member_lib.inc'   ; // ��� ���̺귯��

    include 'common/message.inc'      ; // ���� ������ ó��
	include 'common/message_table.inc'; // �޽���

    // �����ͺ��̽��� �����մϴ�.
    $db = new DBConnection($_POST['host_nm'],$_POST['db_nm'], $_POST['id'], $_POST['password'], $_POST['driver']);
    $rtn = false;
    if ( $_POST['driver'] == "MYSQL" ) {
        $rtn = $db->mysqlConnect2();
        @mysql_select_db($_POST['db_nm'], $db->connect);
    }
    if ( !$rtn ) {
        $err = new Message("D", mysql_errno(),mysql_error(),"");
    } else {
        /// ��� ������ �Ǹ� ���丮 ������ �ٲ� �ݴϴ�.
        @mkdir("./data"           ,0707);
        @chmod("./data"           ,0707);
        @mkdir("./data/file"      ,0707);
        @chmod("./data/file"      ,0707);
        @mkdir("./data/session"   ,0707);
        @chmod("./data/session"   ,0707);
        @mkdir("./data/poll"      ,0707);
        @chmod("./data/poll"      ,0707);
        @mkdir("./data/html"      ,0707);
        @chmod("./data/html"      ,0707);
        @mkdir("./data/member"    ,0707);
        @chmod("./data/member"    ,0707);
        @mkdir("./data/member/character"  ,0707);
        @chmod("./data/member/character"  ,0707);
        @mkdir("./data/member/picture"    ,0707);
        @chmod("./data/member/picture"    ,0707);
        @mkdir("./data/event"     ,0707);
        @chmod("./data/event"     ,0707);
        @mkdir("./data/tmp"       ,0707);
        @chmod("./data/tmp"       ,0707);
        @mkdir("./files"     ,0707);
        @chmod("./files"     ,0707);

//      include ( "common/lib.inc"          ); // ���� ���̺귯��

        $rtn = unWritableDirError (); // ��ġ ���丮 ����

        if ( $rtn && !$config ) {
    /*
            echo " host_nm : $host_nm  <BR>";
            echo " db_nm   : $db_nm    <BR>";
            echo " id      : $id       <BR>";
            echo " password: $password <BR>";
            echo " driver  : $driver   <BR>";
    */

            $baseD  = baseDir  ();  // �� ���� ��� ���
            $setupD = setUpDir ();  // ���� ��ġ ���

            session_save_path("data/session");
            session_set_cookie_params(0, '/');
        //  session_cache_limiter('nocache, must_revalidate'); // ĳ�� ���� ���ƶ�
            @session_cache_limiter('');
            $_s_setup_ok = '1';
            @session_start();
            if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                @session_register("_s_setup_ok");
            } else {
                $_SESSION['_s_setup_ok'] = $_s_setup_ok;  // 4.10 ���� ó��.
            }
//var_dump($_SESSION);
//phpinfo();
//exit;
            /* �����ͺ��̽� ���� ���� ���� */
            $setupInfor  = "<?\n";
            $setupInfor .= $driver   . "\n"; // ����̹�
            $setupInfor .= $host_nm  . "\n"; // host ��
            $setupInfor .= $db_nm    . "\n"; // db ��
            $setupInfor .= $id       . "\n"; // ����� ���̵�
            $setupInfor .= $password . "\n"; // ����� ��й�ȣ
            $setupInfor .= $baseD    . "\n"; // ��� ���丮
            $setupInfor .= $setupD   . "\n"; // ��ġ ��Ʈ
            $setupInfor .= 'dlogin_standard' . "\n"; // ��ġ ��Ʈ
            $setupInfor .= "?>";

            $fp = @fopen ( "config.php", "w");
            if (!$fp) {
				//echo $setupD;
                $errMsg = "<B>��ġ ���丮 ����</B>�� <B><font color='red'>707</font></B>�� ������ �ּ���.<BR>|* ------------- <B>��ġ ��� </B> ------------- *|<BR><B>". $setupD ."</B> <BR>|* _____________________________________ *|";
                $err = new Message("U","0006", $errMsg,"");
            } else {
				//echo $setupInfor;
                fwrite ( $fp, $setupInfor,strlen($setupInfor) );
                @chmod("config.php"     ,0707);
                $sysInfor = array();
                $sysInfor["driver"] = $driver;

                include ( "schema.sql"      ); // ��Ű��
                // ���̺� ���� �˻� �� ���̺� ����
                if ( !isTable($tb_bbs_infor     , $db_nm, $driver) ) { simpleSQLExecute($tb_bbs_infor_schm    , $driver);   /* �Խ��� ����          */ }
                if ( !isTable($tb_bbs_abstract  , $db_nm, $driver) ) { simpleSQLExecute($tb_bbs_abstract_schm , $driver);   /* �Խù� ���� ����     */ }
                if ( !isTable($tb_bbs_skin      , $db_nm, $driver) ) { simpleSQLExecute($tb_bbs_skin_schm     , $driver);   /* �Խ��� ��Ų ����     */ }
                if ( !isTable($tb_bbs_grant     , $db_nm, $driver) ) { simpleSQLExecute($tb_bbs_grant_schm    , $driver);   /* �Խ��� ����ں� ���� */ }
                if ( !isTable($tb_member        , $db_nm, $driver) ) { simpleSQLExecute($tb_member_schm       , $driver);   /* ȸ�� ����            */ }
                if ( !isTable($tb_member_kind   , $db_nm, $driver) ) { simpleSQLExecute($tb_member_kind_schm  , $driver);   /* ȸ�� ���� ����       */ }
                if ( !isTable($tb_member_config , $db_nm, $driver) ) { simpleSQLExecute($tb_member_config_schm, $driver);   /* ȸ�� ���� �� ����    */ }
                if ( !isTable($tb_dic_member_statistic , $db_nm, $driver) ) { simpleSQLExecute($tb_dic_member_statistic_schm , $driver);   /* ȸ�� ���   */ }

                if ( !isTable($tb_poll_master   , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_master_schm  , $driver);   /* ���� ���� ����       */ }
                if ( !isTable($tb_poll_item     , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_item_schm    , $driver);   /* ���� ���� �׸�       */ }
                if ( !isTable($tb_poll_skin     , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_skin_schm    , $driver);   /* ���� ���� ��Ų       */ }
                if ( !isTable($tb_poll_grant    , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_grant_schm   , $driver);   /* ���� ���� ��� ����  */ }
                if ( !isTable($tb_event         , $db_nm, $driver) ) { simpleSQLExecute($tb_event_schm        , $driver);   /* �̺�Ʈ ����          */ }

                if ( !isTable($tb_event_grant       , $db_nm, $driver) ) { simpleSQLExecute($tb_event_grant_schm        , $driver);   /* �̺�Ʈ ����          */ }
                if ( !isTable($tb_event_item        , $db_nm, $driver) ) { simpleSQLExecute($tb_event_item_schm         , $driver);   /* �̺�Ʈ �׸�          */ }
                if ( !isTable($tb_point_infor       , $db_nm, $driver) ) { simpleSQLExecute($tb_point_infor_schm        , $driver);   /* �Խ��� ����Ʈ ����   */ }
                if ( !isTable($tb_poll_point_infor  , $db_nm, $driver) ) { simpleSQLExecute($tb_poll_point_infor_schm   , $driver);   /* ����   ����Ʈ ����   */ }

                if ( !isTable($tb_event_result_master, $db_nm, $driver)) { simpleSQLExecute($tb_event_result_master_schm, $driver);   /* �̺�Ʈ ��� ����     */ }
                if ( !isTable($tb_event_result_detail, $db_nm, $driver)) { simpleSQLExecute($tb_event_result_detail_schm, $driver);   /* �̺�Ʈ ��� ��     */ }
                if ( !isTable($tb_login_abstract     , $db_nm, $driver)) { simpleSQLExecute($tb_login_abstract_schm     , $driver);   /* �α��� ����          */ }

                // ��ȸ��
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_config where member_level = 0 ;", $driver );
                if ( !$existChk ) {
                    $sql  = "insert into $tb_member_config (member_level, agreement, agreement_content, name, sex, e_mail, home, jumin, tel, address, news_yn, point_yn, picture_image, character_image) values ";
                    $sql .= "(0,'Y','\-���� ���\-','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');";
                  //logs ( '$sql :  / ' . $existChk . ' / ' . $sql . '<BR>' , true);
                    simpleSQLExecute($sql,$driver);
                }

                // ȸ��
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_config where member_level = 1 ;", $driver );
                if ( !$existChk ) {
                    $sql  = "insert into $tb_member_config (member_level, agreement, agreement_content, name, sex, e_mail, home, jumin, tel, address, news_yn, point_yn, picture_image, character_image) values ";
                    $sql .= "(1,'Y','\-���� ���\-','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');";
        //          logs ( '$sql :  / ' . $existChk . ' / ' . $sql . '<BR>' , true);
                    simpleSQLExecute($sql,$driver);
                }

                // ������
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_config where member_level = 99;", $driver );
                if ( !$existChk ) {
                    $sql  = "insert into $tb_member_config (member_level, agreement, agreement_content, name, sex, e_mail, home, jumin, tel, address, news_yn, point_yn, picture_image, character_image) values ";
                    $sql .= "(99,'N','\-���� ���\-','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y','Y');";
        //          logs ( '$sql :  / ' . $existChk . ' / ' . $sql . '<BR>' , true);
                    simpleSQLExecute($sql,$driver);
                }
                // ��ȸ��
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_kind where member_level = 0;", $driver );
                if ( !$existChk ) {
                    // ��ȸ��
                    $sql  = "insert into $tb_member_kind ( member_level, member_nm, etc, reg_date ) values (0 , '��ȸ��'  , 'ȸ�������� ���� ���� ����� �׷� �Դϴ�.','". getYearToSecond() ."');";
                    simpleSQLExecute($sql, $driver);
                }
                // ȸ��
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_kind where member_level = 1;", $driver );
                if ( !$existChk ) {
                    // ȸ��
                    $sql  = "insert into $tb_member_kind ( member_level, member_nm, etc, reg_date ) values (1 , '�Ϲ�ȸ��', 'ȸ�� ���Խ� �⺻ ȸ�� �׷� �Դϴ�.','". getYearToSecond() ."');";
                    simpleSQLExecute($sql, $driver);
                }
                // ������
                $existChk = simpleSQLQuery("select count(member_level) from $tb_member_kind where member_level = 99;", $driver );
                if ( !$existChk ) {
                    // ������
                    $sql  = "insert into $tb_member_kind ( member_level, member_nm, etc, reg_date ) values (99, '������'  , '������ ȸ�� �׷� �Դϴ�.','". getYearToSecond() ."');";
                    simpleSQLExecute($sql, $driver);
                }

                $existCnt = simpleSQLQuery("select count(*) from $tb_dic_member_statistic;", $driver );
                $existCnt = (int) $existCnt;

                if ( $existCnt == 0  ) {
                    simpleSQLExecute("insert into $tb_dic_member_statistic ( cnt ) values ( 0 );", $driver ); /* �� ȸ���� �ʱ�ȭ */
                }

                if ( isTable($tb_post          , $db_nm, $driver) ) {
        //            simpleSQLExecute("drop table $tb_post;", $driver); /* ���� ��ȣ ���̺� ���� */
                }

                if ( !isTable($tb_post          , $db_nm, $driver) ) {
                    simpleSQLExecute($tb_post_schm         , $driver);   /* ���� ��ȣ            */
        //          logs ( '$tb_post_schm :  / '. $tb_post_schm . '<BR>' , true);
                    if (version_compare(PHP_VERSION, '5.0.0', '<')) { // php4
                        include "common/lib/CROSS_VERSION/setup_ok.40000.php";
                    } else {
                        include "common/lib/CROSS_VERSION/setup_ok.50000.php";
                    }

                    // �ε��� ����
        //          simpleSQLExecute($tb_post_idx0, $driver);
        //          simpleSQLExecute($tb_post_idx1, $driver);
        //          simpleSQLExecute($tb_post_idx2, $driver);
                }
                closeDBConnection ($driver); // �����ͺ��̽����� ���� ������ ���� �մϴ�.
                redirectPage ("setup2.php"); // ������ �̵�
            }
        } else {
            @session_destroy ();
            // redirectPage ("setup.php"); // ������ �̵�
            exit;
        }
    }
    if ( $err ) {
        define ("NOT_INCLUDE_HTML_HEAD", true);
        head("DB����ȭ��_SQLDB����");
        css();
        body();
        include "message.php";
        footer();
    }

} // if END
else {
    @session_destroy ();
    echo "\n<meta http-equiv=\"refresh\" content=\"0; url=setup.php\">";
}
?>