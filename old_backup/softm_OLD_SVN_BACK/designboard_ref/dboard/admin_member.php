<?
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��

$branch   = ( !$branch ) ? "list" : $branch;
if ( $branch == 'list' ) {
    if ( !$HTTP_POST_VARS['how_many'] ) {
        $how_many = $HTTP_COOKIE_VARS["member_many"]; // ��Ű �о� ����
    } else {
        if ( $how_many ) { setcookie ("member_many", $how_many, mktime() + 60*60*24*365,"/"); } // $how_many ���� ������
    }
}

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( $memInfor['admin_yn'] == "N" ) {
    logs ( '������ �ƴ�' );
    //redirectPage ("admin.php");     // ������ �̵�
    head("����_�������");        // Header ���
    _css ($skinDir); // css ����
    Message ('U', '0003', 'MOVE:admin.php:�̵�');
} else {
    logs ( '������ �Դϴ�.' );
    head("����_�������", "member_OnLoad();");        // Header ���
    _css ($skinDir); // css ����
	include 'common/js/common_js.php'; // ���� javascript
	include 'common/js/admin_member_js.php'; // ���� member javascript
?>
<SCRIPT LANGUAGE='javascript'>
<!--
    function member_OnLoad() {
        var branch = '<?=$branch?>';
        if ( branch == 'list' ) {
//            alert ('');
            var searchGb = '<?=$search_gb?>';
            objectSelected (document.memberForm.search_gb, searchGb ); 
        } else if ( branch == 'loginsetup' ) {
            exploerInitial ();
            displayModeToggle();
            enabledPopUp();
            document.loginAbstractForm.suc_mode.selectedIndex = sucModeSelectedIndex;
            sucModeChange();
            abstractSource ();
        } else if ( branch == 'formsetup' ) {
            hintEssentialCond();
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

    $package = 'member';
    if ( $branch == 'list' ) {
        include ( 'admin/admin_member_list.php'     ); // ȸ�� ���� ��ȸ
    } else if ( $branch == 'write' ) {
        include ( 'admin/admin_member_write.php'    ); // ȸ�� ���� ����
    } else if ( $branch == 'kind' )  {
        include ( 'admin/admin_member_kind.php'     ); // ȸ�� ���� ����
    } else if ( $branch == 'formsetup' )  {
        include ( 'admin/admin_member_formsetup.php'); // ȸ�� ������ ����
//  } else if ( $branch == 'nl_write' ) {
//      include ( 'admin/admin_member_nl_write.php' ); // ���� ���� �Է�
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_member_exec.php'     ); // �Խ��� �Է�
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