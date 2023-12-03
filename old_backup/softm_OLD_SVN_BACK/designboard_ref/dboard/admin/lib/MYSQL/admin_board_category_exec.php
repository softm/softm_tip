<?
$baseDir = '../../../';
include $baseDir . 'common/board_lib.inc' ; // �Խ��� ���̺귯��
include $baseDir . 'common/lib.inc'    ; // ���� ���̺귯��
include $baseDir . 'common/message.inc'; // ���� ������ ó��

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
if ( $memInfor['admin_yn'] == "Y" ) {
include ( '../../../common/db_connect.inc'   ); // Data Base ���� Ŭ����
    // �����ͺ��̽��� �����մϴ�.
    $db = initDBConnection ();
    if ( $gubun == 'insert' ) {
        // ī�װ� ����
        $newNo = simpleSQLQuery("select MAX(no) + 1 from $tb_bbs_category" . "_" . $bbs_id);
        if ( !$newNo ) $newNo = 1;
        $newOseq = simpleSQLQuery("select MAX(o_seq) + 1 from $tb_bbs_category" . "_" . $bbs_id);
        if ( !$newOseq ) $newOseq = 1;
        $sql  = "insert into $tb_bbs_category" . "_" . $bbs_id . " ( no, o_seq, name, etc ) values ";
        $sql .= "($newNo, $newOseq, '$name', '');";
        simpleSQLExecute($sql);
    } else if ($gubun == 'update') {
        for ( $i=1; $i <= sizeof($no)-1;$i++) {
            $tmpNo   = $no   [$i];
            $tmpName = $name [$i];
            // magic_quotes_gpc Off
            if ( !escapeYN () ) {
                $tmpName    = addslashes($name[$i]);
            }
            $sql  = "update $tb_bbs_category" . "_" . $bbs_id . " set ";
            $sql .= " no    = '$tmpNo'     ,";
            $sql .= " name  = '$tmpName'    ";
            $sql .= " where no     = '$tmpNo'"  ;
            simpleSQLExecute($sql);
        }
    } else if ($gubun == 'delete') {
            $sql  = "delete from $tb_bbs_category" . "_" . $bbs_id;
            $sql .= " where no     = '$no'"  ;
            simpleSQLExecute($sql);

            $sql  = "update $tb_bbs_category" . "_" . $bbs_id . " set ";
            $sql .= " o_seq    = o_seq - 1     ";
            $sql .= " where o_seq     > '$o_seq'"  ;
            simpleSQLExecute($sql);
    } else if ($gubun == 'order') {
            $o_seq = ( int ) $o_seq;
            $limitOrder = simpleSQLQuery("select MAX(no) from $tb_bbs_category" . "_" . $bbs_id );
            if ( $arrow == 'up' && $o_seq > 1 ) {
                $o_seq = $o_seq - 1;
                $sql  = "update $tb_bbs_category" . "_" . $bbs_id . " set ";
                $sql .= " o_seq    = o_seq + 1     ";
                $sql .= " where o_seq  = '$o_seq'"  ;
                simpleSQLExecute($sql);
                $sql  = "update $tb_bbs_category" . "_" . $bbs_id . " set ";
                $sql .= " o_seq    = o_seq - 1     ";
                $sql .= " where no     = '$no'"  ;
                simpleSQLExecute($sql);
            } else if ( $arrow == 'down' && $limitOrder > $o_seq ) {
                $o_seq = $o_seq + 1;
                $sql  = "update $tb_bbs_category" . "_" . $bbs_id . " set ";
                $sql .= " o_seq    = o_seq - 1     ";
                $sql .= " where o_seq  = '$o_seq'"  ;
                simpleSQLExecute($sql);
                $sql  = "update $tb_bbs_category" . "_" . $bbs_id . " set ";
                $sql .= " o_seq    = o_seq + 1     ";
                $sql .= " where no     = '$no'"  ;
                simpleSQLExecute($sql);
            }
    }
    redirectPage("../../admin_board_category_popup_list.php?bbs_id=$bbs_id"); // �Խ��� ���� (��ȸ) �̵�
    closeDBConnection (); // �����ͺ��̽� ���� ���� ����
}
?>