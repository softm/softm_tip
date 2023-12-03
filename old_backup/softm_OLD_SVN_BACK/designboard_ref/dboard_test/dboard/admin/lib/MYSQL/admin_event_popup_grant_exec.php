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
    closeDBConnection (); // 데이터베이스 연결 설정 해제
}
?>