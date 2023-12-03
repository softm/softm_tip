<?
$baseDir = '../';
include $baseDir . "common/lib.inc"         ; // 공통 라이브러리
include $baseDir . "common/message.inc"     ; // 에러 페이지 처리
include $baseDir . 'common/db_connect.inc'  ; // Data Base 연결 클래스
$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "Y" ) {
    $mailNo = '';
    if ( $send == '0' ) { // 선택 회원 메일 발송
        for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
            if ( $i == sizeof($chk_no) - 1 ) {
                $mailNo .= "'" . $chk_no[$i] . "'" ;
            } else {
                $mailNo .= "'" . $chk_no[$i] . "',";
            }
        }
        setcookie ("mailNo", $mailNo);
        echo "<title>어드민 뉴스레터</title>\n";
    } else if ( $send == '1' ) {
        setcookie ("mailNo", $mailNo);
        echo "<title>어드민 뉴스레터</title>\n";
    } else if ( $send == '2' ) {
        setcookie ("mailNo", $user_id);
        echo "<title>어드민 뉴스레터</title>\n";
    } else if ( $send == '3' ) { // 이벤트 선택 메일
        for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
            if ( $i == sizeof($chk_no) - 1 ) {
                $mailNo .= "'" . $chk_no[$i] . "'" ;
            } else {
                $mailNo .= "'" . $chk_no[$i] . "',";
            }
        }
        setcookie ("mailNo"  , $mailNo  );
        setcookie ("event_id", $event_id);
        echo "<title>어드민 이벤트</title>\n";
    } else if ( $send == '4' ) { // 이벤트 전체 메일
        setcookie ("mailNo"  , $mailNo  );
        setcookie ("event_id", $event_id);
        echo "<title>어드민 이벤트</title>\n";
    }
    include $baseDir . 'common/js/common_js.php'; // 공통 javascript
?>
<frameset rows="79,0,329,*" frameborder="NO" border="1" framespacing="0"> 
  <frame name="saveArea"      id='saveArea' scrolling="NO" noresize src="admin_member_nl_write_top.php?send=<?=$send?>" >
  <frame name="translateArea" id='translateArea' src="admin_member_nl_send.php">
  <frame name="progressArea"  id='progressArea' scrolling="NO" noresize src="admin_member_nl_write_bottom.php">
  <frame name="buttonArea"    id='buttonArea' src="admin_member_nl_write_button.php">
</frameset>
<noframes>
</body></noframes>
<?
}
?>