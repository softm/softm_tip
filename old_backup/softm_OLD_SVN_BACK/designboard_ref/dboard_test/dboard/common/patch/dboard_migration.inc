<?
include_once ( 'common/lib.inc'          ); // ���� ���̺귯��
include_once ( 'common/message.inc'      ); // ���� ������ ó��
include_once ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
include_once ( 'common/_service.inc'     ); // ���� ȭ�� ����
include_once ( 'common/file.inc'         ); // ���� �ý��� ����
include_once ( 'common/lib/var/table.inc'); // ���̺� ���� ����

$patch_execute = false;
$patch_title   = "";
$patch_msg     = "";
$mig_version = 0; // ���̱׷��̼� ����. ����Ʈ�� �������� ���̱׷��̼ǹ����� �������� ���̱׷��̼� ����.
$mig_info    = array();
$is_db_schema_update = true; // DB������Ʈ����.(false�̸� designboard.net�� ���� ��ũ�Ѵ�.)

if ( $config ) {
    $memInfor = getMemInfor();
    if ( $memInfor['member_level'] == 99 ) {
        set_time_limit ( 0 );
        $isIncDbConn = false; 
        if ( !$db ) {
	        $db = initDBConnection ();
	        $isIncDbConn = true;
        }
        
        if ( MIG_VERSION ==  0.001 ) { // ���Ű�� �ֽ�ȭ.
        	$is_db_schema_update = false;
        } 
        
        if ($isIncDbConn) {
        	closeDBConnection ();
        }
    }
}

/**
 * DB������Ʈ����.(false�̸� designboard.net�� ���� ��ũ�Ѵ�.)
 */
define(IS_DB_SCHEMA_UPDATE,$is_db_schema_update);
?>