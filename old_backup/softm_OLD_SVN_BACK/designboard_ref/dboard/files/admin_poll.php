<?
include 'common/poll_lib.inc'  ; // ���� ���̺귯��
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��

$branch   = ( !$branch ) ? "list" : $branch;
if ( $branch == 'list' ) {
    if ( !$HTTP_POST_VARS['how_many'] ) {
        $how_many = $HTTP_COOKIE_VARS["poll_many"]; // ��Ű �о� ����
    } else {
        if ( $how_many ) { setcookie ("poll_many", $how_many, mktime() + 60*60*24*365,"/"); } // $how_many ���� ������
    }
}

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ���������� ����

if ( $memInfor['admin_yn'] == "N" ) {
    logs ( '������ �ƴ�.',FALSE);
    //redirectPage ("admin.php");     // ������ �̵�
    head("����_�����������");      // Header ���
    _css ($skinDir); // css ����
    Message ('U', '0003', 'MOVE:admin.php:���ư���');

} else {
    logs ( '������ �Դϴ�.',FALSE);
    head("����_�����������","poll_OnLoad();");        // Header ���
    _css ($skinDir); // css ����
	include 'common/js/common_js.php'; // ���� javascript
	include 'common/js/admin_poll_js.php'; // ���� poll javascript
?>

<SCRIPT LANGUAGE='javascript'>
<!--
    function poll_OnLoad() {
        var branch = '<?=$branch?>';
        if ( branch == 'itemsetup' ) {
            exploerInitial ();
            abstractSource ();
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT
    //      headerDocument.body.innerHTML = document.boardSetupForm.header.value;
    //      footerDocument.body.innerHTML = document.boardSetupForm.footer.value;
            headerDocument.dataForm.header.value = document.pollItemSetupForm.header.value;
            footerDocument.dataForm.footer.value = document.pollItemSetupForm.footer.value;
            sucUrlToggle();
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
    $branch   = ( !$branch ) ? "list" : $branch;
    include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
    // �����ͺ��̽��� �����մϴ�.
    $db = initDBConnection ();

    $package = 'poll';
    if ( $branch == 'list' ) {
        include ( 'admin/admin_poll_list.php'       ); // ���� ���� ��ȸ
    } else if ( $branch == 'itemsetup' ) {
        include ( 'admin/admin_poll_itemsetup.php'  ); // ���� �׸� ����
    } else if ( $branch == 'grant' ) {
        include ( 'admin/admin_poll_grant.php'      ); // ���� ���� ����
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_poll_exec.php'       ); // ���� ���� ���� ����
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
