<?
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó����

$branch   = ( !$branch ) ? "setup" : $branch;

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( $memInfor['admin_yn'] == "N" ) {    
    logs ( '������ �ƴ�' );
    //redirectPage ("admin.php");     // ������ �̵�
    head("����_�α��ΰ���");        // Header ���
    _css ($skinDir); // css ����
    Message ('U', '0003', 'MOVE:admin.php:�̵�');
} else {
    logs ( '������ �Դϴ�.' );
    head("����_�α��ΰ���", "login_OnLoad();");        // Header ���
    _css ($skinDir); // css ����
	include 'common/js/common_js.php'; // ���� javascript
	include 'common/js/admin_login_js.php'; // ���� login javascript
?>
<SCRIPT LANGUAGE='javascript'>
<!--
function login_OnLoad() {
	var branch = '<?=$branch?>';
	if ( branch == 'setup' ) {
		exploerInitial ();
		displayModeToggle();
		enabledPopUp();
		sucModeChange();
		abstractSource ();
	}
}
//-->
</SCRIPT>


<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr> 
    <td valign="top" height="122"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="70"> 
<?
    include ( 'admin_top.php' ); // ���� �޴�
?>
          </td>
        </tr>
        <tr> 
          <td height="1" bgcolor="003A43"></td>
        </tr>
        <tr> 
          <td height="40" bgcolor="015966"></td>
        </tr>
        <tr> 
          <td height="1" bgcolor="003A43"></td>
        </tr>
        <tr> 
          <td height="10"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td valign="top" class="unnamed1"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr> 
          <td width="200" bgcolor="F5F5F5" valign="top"> 
<?
    include ( 'admin_left_menu.php'          ); // ���� �޴�
?>
          </td>
          <td bgcolor="FAFAFA" valign="top"> 
<?
    include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
    // �����ͺ��̽��� �����մϴ�.
    $db = initDBConnection ();

    $package = 'board';
    if ( $branch == 'setup' ) {
        include ( 'admin/admin_login_setup.php'); // �α��� ����.����
//  } else if ( $branch == 'nl_write' ) {
//      include ( 'admin/admin_member_nl_write.php' ); // ���� ���� �Է�
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_login_exec.php' ); // �α��� �Է�
    }
    closeDBConnection (); // �����ͺ��̽� ���� ���� ����
?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
    footer(); // Footer ���
}// else END
?>