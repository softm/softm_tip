<?
$baseDir = '../../../';
include $baseDir . 'common/event_lib.inc' ; // 이벤트 라이브러리
include $baseDir . 'common/lib.inc'       ; // 공통 라이브러리
include $baseDir . 'common/_service.inc'  ; // 서비스 영역
include $baseDir . 'common/message.inc'   ; // 에러 페이지 처리


$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
if ( $memInfor['admin_yn'] == "Y" ) {
include ( $baseDir . 'common/db_connect.inc'   ); // Data Base 연결 클래스
    // 데이터베이스에 접속합니다.
    $db = initDBConnection ();
    $eventInfor = getEventInfor ($event_id);
//    echo $gubun;
    if ( $eventInfor ) {
        if ( $gubun == 'main_insert' ) {
            $sql = "select MAX(g_no) + 1 from $tb_event_item";
            $sql .= " where no     = '". $event_id  . "'";
            $newGno = simpleSQLQuery($sql);
            if ( !$newGno ) $newGno = 1;

            // magic_quotes_gpc Off
            if ( !escapeYN () ) {
                $item_name    = addslashes($item_name);
            }
            $sql  = "insert into $tb_event_item ( ";
            $sql .= " no, g_no, seq, o_seq, item, item_name";
            $sql .= " ) values ( ";
            $sql .= "'" . $event_id . "',";
            $sql .= "'" . $newGno   . "',";
            $sql .= "'0',"; // 메인은 순번을      0으로 사용합니다.
            $sql .= "'0',"; // 메인은 정렬 순서를 0으로 사용합니다.
            $sql .= "'" . $item     . "',";
            $sql .= "'" . $item_name. "' ";
            $sql .= ");";
//          logs ( '$sql : '. $sql . '<BR>' , true);
            simpleSQLExecute($sql);
            redirectPage("../../admin_event_popup_item.php?event_id=$event_id");
        } else if ( $gubun == 'main_update' ) {
//          echo 'ㅋㅋ' . sizeof($seq);
            for ( $i=1; $i <= sizeof($seq)-1;$i++) {
                if ( $item [$i] ) {
                    // magic_quotes_gpc Off
                    if ( !escapeYN () ) {
                        $tmpName    = addslashes($item_name[$i]);
                    } else {
                        $tmpName = $item_name   [$i];
                    }
                    $sql  = "update $tb_event_item set ";
                    $sql .= " g_no         = '" .$g_no        [$i]. "',";
                    $sql .= " seq          = '" .$seq         [$i]. "',";
                    $sql .= " item         = '" .$item        [$i]. "',";
                    $sql .= " item_name    = '" .$tmpName         . "' ";
                    $sql .= " where no     = '". $event_id        . "'";
                    $sql .= " and   g_no   = '". $g_no        [$i]. "'";
                    $sql .= " and   seq    = '". $seq         [$i]. "'";
                    simpleSQLExecute($sql);
                }
            }
            redirectPage("../../admin_event_popup_item.php?event_id=$event_id");
        } else if ($gubun == 'main_delete') {
            $sql  = "delete from $tb_event_item";
            $sql .= " where no     = '". $event_id . "'";
            $sql .= " and   g_no   = '". $g_no     . "'";
            simpleSQLExecute($sql);
            redirectPage("../../admin_event_popup_item.php?event_id=$event_id");
        } else if ($gubun == 'detail_insert') {
            $sql = "select MAX(seq) + 1 from $tb_event_item";
            $sql .= " where no     = '". $event_id  . "'";
            $sql .= " and   g_no   = '". $g_no      . "'";
            $newSeq = simpleSQLQuery($sql);
            if ( !$newSeq ) $newSeq = 1;

            // magic_quotes_gpc Off
            if ( !escapeYN () ) {
                $item_name    = addslashes($item_name);
            }
            $sql  = "insert into $tb_event_item ( ";
            $sql .= " no, g_no, seq, o_seq, item, item_name";
            $sql .= " ) values ( ";
            $sql .= "'" . $event_id . "',";
            $sql .= "'" . $g_no     . "',";
            $sql .= "'" . $newSeq   . "',"; // 순번
            $sql .= "'" . $newSeq   . "',"; // 정렬 순서
            $sql .= "'" . $item     . "',";
            $sql .= "'" . $item_name. "' ";
            $sql .= ");";
//          logs ( '$sql : '. $sql . '<BR>' , true);
            simpleSQLExecute($sql);
            redirectPage("../../admin_event_popup_item.php?event_id=$event_id&c_g_no=$g_no");
        } else if ( $gubun == 'detail_update' ) {
            for ( $i=1; $i <= sizeof($seq)-1;$i++) {
                if ( !$item[$i] && $u_g_no == $g_no[$i] ) {
                    // magic_quotes_gpc Off
                    if ( !escapeYN () ) {
                        $tmpName    = addslashes($item_name[$i]);
                    } else {
                        $tmpName = $item_name   [$i];
                    }
                    $sql  = "update $tb_event_item set ";
                    $sql .= " item_name    = '" .$tmpName       . "' ";
                    $sql .= " where no     = '". $event_id      . "'";
                    $sql .= " and   g_no   = '". $u_g_no        . "'";
                    $sql .= " and   seq    = '". $seq       [$i]. "'";
    //              logs ( '$sql : '. $sql . '<BR>' , true);
                    simpleSQLExecute($sql);
                }
            }
            redirectPage("../../admin_event_popup_item.php?event_id=$event_id&c_g_no=". $u_g_no);
        } else if ($gubun == 'detail_delete') {
            $sql  = "delete from $tb_event_item";
            $sql .= " where no     = '". $event_id . "'";
            $sql .= " and   g_no   = '". $g_no     . "'";
            $sql .= " and   seq    = '". $seq      . "'";
            simpleSQLExecute($sql);

            $sql  = "update $tb_event_item set ";
            $sql .= " o_seq    = o_seq - 1     ";
            $sql .= " where no     = '". $event_id  . "'";
            $sql .= " and   g_no   = '". $g_no      . "'";
            $sql .= " and   o_seq  > '". $o_seq     . "'";
            simpleSQLExecute($sql);

            redirectPage("../../admin_event_popup_item.php?event_id=$event_id&c_g_no=$g_no");
        } else if ( $gubun == 'order' ) {
            $o_seq = ( int ) $o_seq;
            $sql  = " select MAX(o_seq) from $tb_event_item";
            $sql .= " where no     = '". $event_id  . "'";
            $sql .= " and   g_no   = '". $g_no      . "'";
            $limitOrder = simpleSQLQuery( $sql );
            if ( $arrow == 'up' && $o_seq > 1 ) {
                $o_seq = $o_seq - 1;
                $sql  = "update $tb_event_item set ";
                $sql .= " o_seq    = o_seq + 1     ";
                $sql .= " where no     = '". $event_id  . "'";
                $sql .= " and   g_no   = '". $g_no      . "'";
                $sql .= " and   o_seq  = '". $o_seq     . "'";
                simpleSQLExecute($sql);
                $sql  = "update $tb_event_item set ";
                $sql .= " o_seq    = o_seq - 1     ";
                $sql .= " where no     = '". $event_id  . "'";
                $sql .= " and   g_no   = '". $g_no      . "'";
                $sql .= " and   seq    = '". $seq       . "'";
                simpleSQLExecute($sql);
            } else if ( $arrow == 'down' && $limitOrder > $o_seq ) {
                $o_seq = $o_seq + 1;
                $sql  = "update $tb_event_item set ";
                $sql .= " o_seq    = o_seq - 1     ";
                $sql .= " where no     = '". $event_id  . "'";
                $sql .= " and   g_no   = '". $g_no      . "'";
                $sql .= " and   o_seq  = '". $o_seq     . "'";
                simpleSQLExecute($sql);
                $sql  = "update $tb_event_item set ";
                $sql .= " o_seq    = o_seq + 1     ";
                $sql .= " where no     = '". $event_id  . "'";
                $sql .= " and   g_no   = '". $g_no      . "'";
                $sql .= " and   seq    = '". $seq       . "'";
                simpleSQLExecute($sql);
            }
            redirectPage("../../admin_event_popup_item.php?event_id=$event_id&c_g_no=$g_no");
        }
    }
    closeDBConnection (); // 데이터베이스 연결 설정 해제
}
?>