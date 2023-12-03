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
if ( $config ) {
    $memInfor = getMemInfor();
    if ( $memInfor['member_level'] == 99 ) {
        set_time_limit ( 0 );
        $isIncDbConn = false; 
        if ( !$db ) {
	        $db = initDBConnection ();
	        $isIncDbConn = true;
        }
        
        if ( PATCH_VERSION < 3.454 ) { //3.454 ��ġ
            $columnType = getColumnType($tb_member, 'password');
            if ( $columnType != 'varchar(41)' ) {
            	$patch_title = "��й�ȣ/�ֹι�ȣ ���̺� ���� ����";            	
                $patch_msg .= '1. ��й�ȣ �ڸ��� ���� 20 -> 41'.PHP_EOL;
                simpleSQLExecute('alter table ' . $tb_member . " modify password VARCHAR (41) NOT NULL;"); /* ��й�ȣ   */
                $patch_msg .= '2. �ֹι�ȣ �ڸ��� ���� 20 -> 41' .PHP_EOL;
                simpleSQLExecute('alter table ' . $tb_member . " modify jumin    VARCHAR (41)         ;"); /* �ֹι�ȣ   */
                $patch_execute = true;  

            // set patch version-------------------------------------------------------
                $send_data = array();
                $send_data['base_dir'      ] = $sysInfor["base_dir"  ]     ;
                $send_data['SERVER_NAME'   ] = $_SERVER["SERVER_NAME"]     ;
                $send_data['SERVER_PORT'   ] = $_SERVER["SERVER_PORT"]     ;
                $send_data['SERVER_ADDR'   ] = $_SERVER["SERVER_ADDR"]     ;
                $send_data['DBOARD_VERSION'] = $_dboard_ver_str            ;
                $url  = "http://".DBOARD_DOMAIN."/DBD/rest/set_version.php";
                //$cType = "text/plain";
                //echo urlencode(json_encode($send_data));
                $v = get_url_fsockopen( $url,"v=".urlencode(json_encode($send_data)),$cType );
            // -------------------------------------------------------set patch version
            }
            
            // ���̱׷��̼� ����.
            //$mig_version = '3.454';
            //$mig_info[]="��й�ȣ ������ ����(��ȣȭ ���濡���� ���̱׷��̼�).";
            //$mig_info[]="�ֹι�ȣ ������ ����(��ȣȭ ���濡���� ���̱׷��̼�).";            
        } 
        
        if ( PATCH_VERSION < 3.458 ) { //3.458 ��ġ
            $sql  = "select no, bbs_id, design_method from $tb_bbs_infor ";
            $stmt = multiRowSQLQuery($sql);
            while ( $row = multiRowFetch  ($stmt) ) {
                $columnType = getColumnType($tb_bbs_data . "_" . $row['bbs_id'], 'password');
                $patch_title = "# ��й�ȣ ���̺� ���� ����";
                if ( $columnType != 'varchar(41)' ) {
                    $patch_msg .= ' 1. ' . $row['bbs_id']  . '-�Խ��� ��й�ȣ �ڸ��� ���� 20 -> 41'.PHP_EOL;
                    simpleSQLExecute('alter table ' . $tb_bbs_data      . "_" . $row['bbs_id'] . " modify password VARCHAR (41) ;"); /* ��й�ȣ   */
                    simpleSQLExecute('alter table ' . $tb_bbs_comment   . "_" . $row['bbs_id'] . " modify password VARCHAR (41) ;"); /* ��й�ȣ   */
                    $patch_execute = true;  
                }
            }

            $sql  = "select no, title from $tb_poll_master ";
            $stmt = multiRowSQLQuery($sql);
            while ( $row = multiRowFetch  ($stmt) ) {
                $columnType = getColumnType($tb_poll_comment . "_" . $row['no'], 'password');
                if ( $columnType != 'varchar(41)' ) {
                    $patch_msg .= ' 2. ' . $row['title']  . '-���� ��й�ȣ �ڸ��� ���� 20 -> 41'.PHP_EOL;
                    simpleSQLExecute('alter table ' . $tb_poll_comment . "_" . $row['no'] . " modify password VARCHAR (41)  ;"); /* ��й�ȣ   */
                    $patch_execute = true;  
                }
            }

            if ( $patch_execute ) {
            // set patch version-------------------------------------------------------
                $send_data = array();
                $send_data['base_dir'      ] = $sysInfor["base_dir"  ]     ;
                $send_data['SERVER_NAME'   ] = $_SERVER["SERVER_NAME"]     ;
                $send_data['SERVER_PORT'   ] = $_SERVER["SERVER_PORT"]     ;
                $send_data['SERVER_ADDR'   ] = $_SERVER["SERVER_ADDR"]     ;
                $send_data['DBOARD_VERSION'] = $_dboard_ver_str            ;
                $url  = "http://".DBOARD_DOMAIN."/DBD/rest/set_version.php";
                //$cType = "text/plain";
                //echo urlencode(json_encode($send_data));
                $v = get_url_fsockopen( $url,"v=".urlencode(json_encode($send_data)),$cType );
            // -------------------------------------------------------set patch version
            }
        }

        if ( $patch_msg ) {
        	$patch_msg .=  '�� �Ϸ�Ǿ����ϴ�';
        }
        if ($isIncDbConn) {
        	closeDBConnection ();
        }
    }
}
?>