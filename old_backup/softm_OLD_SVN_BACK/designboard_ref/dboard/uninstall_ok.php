<?
include ( "common/lib.inc"          ); // ���� ���̺귯��

include 'common/board_lib.inc' ; // �Խ��� ���̺귯��
include 'common/poll_lib.inc'  ; // ���� ���̺귯��
include 'common/event_lib.inc' ; // �̺�Ʈ ���̺귯��
include 'common/member_lib.inc'; // ��� ���̺귯��

include ( "common/message.inc"      ); // ���� ������ ó��

if ( ereg($HTTP_HOST,$HTTP_REFERER) && ereg( "(uninstall.php)$", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {

    if ( !$config ) { 
        Message ('P', '0002', 'MOVE:setup.php:�̵�');
    }

    $memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

    if ( $memInfor['admin_yn'] == "N" ) {
        //redirectPage ("admin.php");     // ������ �̵�
        head("�����κ��� ����");        // Header ���
        Message ('U', '0003', 'MOVE:admin.php:���ư���');
    } else {
        if ( $host_nm && $db_nm && $id && $driver ) {
            include ( "common/db_connect.inc"   ); // Data Base ���� Ŭ����

            // �����ͺ��̽��� �����մϴ�.
            $db = initDBConnection ("$host_nm","$db_nm", "$id", "$password", "$driver");
            if ( isTable($tb_bbs_infor   , $db_nm, $driver) ) {
                $sql  = "select bbs_id from $tb_bbs_infor order by no desc";
                $stmt = multiRowSQLQuery($sql);
                while ( $row = multiRowFetch  ($stmt) ) {
                    $bbs_id = $row['bbs_id'];
                    if ( isTable($tb_bbs_data    . "_" . $bbs_id, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_data"    . "_" . $bbs_id . ";", $driver); /* �Խ���               */ }
                    if ( isTable($tb_bbs_comment . "_" . $bbs_id, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_comment" . "_" . $bbs_id . ";", $driver); /* �Խ��� ���� �亯     */ }
                    if ( isTable($tb_bbs_category ."_" . $bbs_id, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_category". "_" . $bbs_id . ";", $driver); /* �Խ��� ī�װ�      */ }
                }
                simpleSQLExecute("drop table $tb_bbs_infor   ;", $driver); /* �Խ��� ����          */
            }

            if ( isTable($tb_bbs_abstract, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_abstract;", $driver); /* �Խù� ���� ����     */ }
            if ( isTable($tb_bbs_skin    , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_skin    ;", $driver); /* �Խ��� ��Ų ����     */ }
            if ( isTable($tb_bbs_grant   , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_bbs_grant   ;", $driver); /* �Խ��� ����ں� ���� */ }

            if ( isTable($tb_poll_master  , $db_nm, $driver) ) { 
                $sql  = "select no from $tb_poll_master order by no desc";
                $stmt = multiRowSQLQuery($sql);
                while ( $row = multiRowFetch  ($stmt) ) {
                    $poll_id = $row['no'];
                    if ( isTable($tb_poll_comment . "_" . $poll_id, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_comment" . "_" . $poll_id . ";", $driver); /* ���� ���� ���� �亯  */ }
                }

                simpleSQLExecute("drop table $tb_poll_master  ;", $driver); /* ���� ���� ����       */
            }

            if ( isTable($tb_poll_item    , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_item    ;", $driver); /* ���� ���� �׸�       */ }
            if ( isTable($tb_poll_skin    , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_skin    ;", $driver); /* ���� ���� ��Ų       */ }
            if ( isTable($tb_poll_grant   , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_grant   ;", $driver); /* ���� ���� ��� ����  */ }

            if ( isTable($tb_member       , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_member       ;", $driver); /* ȸ�� ����            */ }
            if ( isTable($tb_member_kind  , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_member_kind  ;", $driver); /* ȸ�� ����            */ }
            if ( isTable($tb_member_config, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_member_config;", $driver); /* ȸ�� ���� �� ����    */ }

            if ( isTable($tb_post               , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_post            ;", $driver); /* ���� ��ȣ            */ }
            if ( isTable($tb_event              , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event           ;", $driver); /* �̺�Ʈ ����          */ }
            if ( isTable($tb_event_grant        , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event_grant     ;", $driver); /* �̺�Ʈ ����          */ }
            if ( isTable($tb_event_item         , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event_item      ;", $driver); /* �̺�Ʈ �׸�          */ }
            if ( isTable($tb_point_infor        , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_point_infor     ;", $driver); /* �Խ��� ����Ʈ ����   */ }
            if ( isTable($tb_poll_point_infor   , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_poll_point_infor;", $driver); /* ���� ����Ʈ ����     */ }

            if ( isTable($tb_event_result_master, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event_result_master;", $driver); /* �̺�Ʈ ��� ���� */ }
            if ( isTable($tb_event_result_detail, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_event_result_detail;", $driver); /* �̺�Ʈ ��� �� */ }
            if ( isTable($tb_login_abstract     , $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_login_abstract     ;", $driver); /* �α��� ����      */ }

            if ( isTable($tb_dic_member_statistic, $db_nm, $driver) ) { simpleSQLExecute("drop table $tb_dic_member_statistic     ;", $driver); /* ȸ�� ���	*/ }

            closeDBConnection ($driver); // �����ͺ��̽����� ���� ������ ���� �մϴ�.

            if ( file_exists ( 'config.php' ) ) {
                @unlink ('config.php');
            }
            @session_destroy ();

            head("�����κ��� ����");        // Header ���
            Message ('U', '0013', 'MOVE:setup.php:�̵�');
    //      redirectPage ("admin.php"); // ������ �̵�
            footer(); // Footer ���
        }
    }
}
?>