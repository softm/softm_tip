<?
$baseDir = '../';
include $baseDir . "common/lib.inc"         ; // ���� ���̺귯��
include $baseDir . "common/message.inc"     ; // ���� ������ ó��
include $baseDir . 'common/db_connect.inc'  ; // Data Base ���� Ŭ����
$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( $memInfor['admin_yn'] == "Y" ) {
    $mailNo = '';
    if ( $send == '0' ) { // ���� ȸ�� ���� �߼�
        for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
            if ( $i == sizeof($chk_no) - 1 ) {
                $mailNo .= "'" . $chk_no[$i] . "'" ;
            } else {
                $mailNo .= "'" . $chk_no[$i] . "',";
            }
        }
        setcookie ("mailNo", $mailNo);
        echo "<title>���� ��������</title>\n";
    } else if ( $send == '1' ) {
        setcookie ("mailNo", $mailNo);
        echo "<title>���� ��������</title>\n";
    } else if ( $send == '2' ) {
        setcookie ("mailNo", $user_id);
        echo "<title>���� ��������</title>\n";
    } else if ( $send == '3' ) { // �̺�Ʈ ���� ����
        for ( $i=1; $i <= sizeof($chk_no)-1;$i++) {
            if ( $i == sizeof($chk_no) - 1 ) {
                $mailNo .= "'" . $chk_no[$i] . "'" ;
            } else {
                $mailNo .= "'" . $chk_no[$i] . "',";
            }
        }
        setcookie ("mailNo"  , $mailNo  );
        setcookie ("event_id", $event_id);
        echo "<title>���� �̺�Ʈ</title>\n";
    } else if ( $send == '4' ) { // �̺�Ʈ ��ü ����
        setcookie ("mailNo"  , $mailNo  );
        setcookie ("event_id", $event_id);
        echo "<title>���� �̺�Ʈ</title>\n";
    }
    include $baseDir . 'common/js/common_js.php'; // ���� javascript
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