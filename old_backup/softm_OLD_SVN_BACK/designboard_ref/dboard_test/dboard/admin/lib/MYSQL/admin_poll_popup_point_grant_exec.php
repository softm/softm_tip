<?
$baseDir = '../../../';
include $baseDir . 'common/poll_lib.inc'  ; // 설문 라이브러리
include $baseDir . 'common/member_lib.inc'; // 멤버 라이브러리
include $baseDir . 'common/lib.inc'       ; // 공통 라이브러리
include $baseDir . 'common/_service.inc'  ; // 서비스 영역
include $baseDir . 'common/message.inc'   ; // 에러 페이지 처리

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
if ( $memInfor['admin_yn'] == "Y" ) {
include ( $baseDir . 'common/db_connect.inc'   ); // Data Base 연결 클래스
    // 데이터베이스에 접속합니다.
    $db = initDBConnection ();

    $pollInfor = getPollInfor ($poll_id);
    if ( $pollInfor && $gubun == 'point_grant_update' ) {
        if ( $member_level != 'all' ) {
            for ( $i=1; $i <= sizeof($no)-1;$i++) {
                if ( $point[$i] ) {
                    $sql  = "SELECT COUNT(no) FROM $tb_poll_point_infor ";
                    $sql .= " WHERE poll_no     = '$poll_id'";
                    $sql .= " AND member_level  = '$member_level'";
                    $sql .= " AND no            = '" . $no[$i] . "'";
                    $existChk = simpleSQLQuery($sql);
                    if ( $use_st[$i] == '1' ) {
                        $use_stVal = "1";
                    } else {
                        $use_stVal = "2";
                    }
                    if ( !$existChk ) {
                        /* 포인트 정보     */
                        $sql  = "insert into $tb_poll_point_infor ( ";
                        $sql .= " no, poll_no, member_level, use_st, point, etc, reg_date";
                        $sql .= " ) values ( ";
                        $sql .= "'" . $no           [$i]. "',";
                        $sql .= "'" . $poll_id          . "',";
                        $sql .= "'" . $member_level     . "',";
                        $sql .= "'" . $use_stVal        . "',";
                        $sql .= "'" . $point        [$i]. "',";
                        $sql .= "'" . $etc          [$i]. "',";
                        $sql .= "'" . getYearToSecond() . "'" ;
                        $sql .= ");";
                    } else {
                        $sql  = "update $tb_poll_point_infor set";
                        $sql .= " use_st       = '" . $use_stVal        . "',";
                        $sql .= " point        = '" . $point        [$i]. "',";
                        $sql .= " etc          = '" . $etc          [$i]. "',";
                        $sql .= " reg_date     = '" . getYearToSecond() . "' ";
                        $sql .= " WHERE poll_no     = '$poll_id'";
                        $sql .= " AND member_level  = '$member_level'";
                        $sql .= " AND no            = '" . $no[$i] . "'";
                    }
    //              logs ( '$sql : '. $sql . '<BR>' , true);
                    simpleSQLExecute($sql);
                }
            }
        } else {

            $sql  = "SELECT * FROM $tb_member_kind";
            $sql .= " where member_level != 0";
            $sql .= " order by member_level";
//          echo $sql;

            $stmt = multiRowSQLQuery($sql);

            while ( $row = multiRowFetch  ($stmt) ) {
                for ( $i=1; $i <= sizeof($no)-1;$i++) {
                    $params['point_' . $no[$i]] = $point    [$i];
                    $params['usest_' . $no[$i]] = $use_st   [$i];

                    $sql  = "SELECT COUNT(no) FROM $tb_poll_point_infor ";
                    $sql .= " WHERE poll_no     = '$poll_id'";
                    $sql .= " AND member_level  = '" . $row[member_level] ."'";
                    $sql .= " AND no            = '" . $no[$i] . "'";
                    $existChk = simpleSQLQuery($sql);
                    if ( $use_st[$i] == '1' ) {
                        $use_stVal = "1";
                    } else {
                        $use_stVal = "2";
                    }
                    if ( !$existChk ) {
                        /* 포인트 정보     */
                        $sql  = "insert into $tb_poll_point_infor ( ";
                        $sql .= " no, poll_no, member_level, use_st, point, etc, reg_date";
                        $sql .= " ) values ( ";
                        $sql .= "'" . $no           [$i]. "',";
                        $sql .= "'" . $poll_id          . "',";
                        $sql .= "'" . $row[member_level]. "',";
                        $sql .= "'" . $use_stVal        . "',";
                        $sql .= "'" . $point        [$i]. "',";
                        $sql .= "'" . $etc          [$i]. "',";
                        $sql .= "'" . getYearToSecond() . "'" ;
                        $sql .= ");";
                    } else {
                        $sql  = "update $tb_poll_point_infor set";
                        $sql .= " use_st       = '" . $use_stVal        . "',";
                        $sql .= " point        = '" . $point        [$i]. "',";
                        $sql .= " etc          = '" . $etc          [$i]. "',";
                        $sql .= " reg_date     = '" . getYearToSecond() . "' ";
                        $sql .= " WHERE poll_no     = '$poll_id'";
                        $sql .= " AND member_level  = '" . $row[member_level] ."'";
                        $sql .= " AND no            = '" . $no[$i] . "'";
                    }
//                  logs ( '$sql : '. $sql . '<BR>' , true);
                    simpleSQLExecute($sql);
                }
            }
        }

    }
    // 포인트 권한 설정 팝업으로 복귀
    redirectPage("../../admin_poll_popup_point_grant_list.php?poll_id=$poll_id&member_level=$member_level");
    closeDBConnection (); // 데이터베이스 연결 설정 해제
}
?>