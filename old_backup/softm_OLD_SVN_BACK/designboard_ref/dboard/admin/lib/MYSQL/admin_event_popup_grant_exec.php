<?
$baseDir = '../../../';
include $baseDir . 'common/event_lib.inc' ; // �̺�Ʈ ���̺귯��
include $baseDir . 'common/lib.inc'       ; // ���� ���̺귯��
include $baseDir . 'common/_service.inc'  ; // ���� ����
include $baseDir . 'common/message.inc'   ; // ���� ������ ó��

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
if ( $memInfor['admin_yn'] == "Y" ) {
include ( $baseDir . 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
    // �����ͺ��̽��� �����մϴ�.
    $db = initDBConnection ();
    $eventInfor = getEventInfor ($event_id);
    if ( $eventInfor && $gubun == 'grant_update' ) {
        for ( $i=1; $i <= sizeof($update_yn)-1;$i++) {
            if ( $update_yn[$i] == 'Y' ) {
                $key        = explode ( '$', $grant[$i] );
                $join_grant = $key[0];
                $sql  = "update $tb_event_grant set";
                $sql .= " grant_join            = '" . $join_grant     . "',";
                $sql .= " join_point            = '" . $join_point[$i] . "' ";
                $sql .= " where no = '$event_id'";
                $sql .= " and member_level = '" . $member_level [$i] . "';";
//              echo $sql . '<BR>';
                simpleSQLExecute($sql);
            }
        }
        redirectPage('../../admin_event_popup_grant.php?event_id=' . $event_id);
    }
    closeDBConnection (); // �����ͺ��̽� ���� ���� ����
}
?>