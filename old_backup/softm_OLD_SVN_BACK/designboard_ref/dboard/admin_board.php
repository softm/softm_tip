<?
include 'common/board_lib.inc' ; // �Խ��� ���̺귯��
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��

$branch   = ( !$branch ) ? "list" : $branch;

if ( !$HTTP_POST_VARS['how_many'] ) {
    $how_many = $HTTP_COOKIE_VARS["board_" .$branch . "_many"]; // ��Ű �о� ����
} else {
    if ( $how_many ) { setcookie ("board_" .$branch . "_many", $how_many, mktime() + 60*60*24*365,"/"); } // $how_many ���� ������
}

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
// �����ͺ��̽��� �����մϴ�.
$db = initDBConnection ();

$section_manager = simpleSQLQuery("select operator_id from $tb_bbs_infor where no = '$no'");
// echo 'section_manager : ' . $section_manager . ' / ' . $memInfor[user_id];
if ( strpos($section_manager, $memInfor[user_id] . '\'') ) {
	$bbs_operator = 'Y';
	// �ο�� �������� �̵�.

    logs ( '������ �ƴ�' );
    //redirectPage ("admin.php");     // ������ �̵�
    head("����_�Խ��ǰ���");        // Header ���
    _css ($skinDir); // css ����
    Message ('U', '0003', 'MOVE:admin.php:���ư���');
} else if ( $memInfor['admin_yn'] == "Y" ) {
    logs ( '������ �Դϴ�.',FALSE);
    head("����_�Խ��ǰ���","board_OnLoad();");        // Header ���
    _css ($skinDir); // css ����
	include 'common/js/common_js.php'; // ���� javascript
	include 'common/js/admin_board_js.php'; // ���� board javascript
?>
<SCRIPT LANGUAGE='javascript'>
<!--
    function board_OnLoad() {
        var branch = '<?=$branch?>';
        if ( branch == 'setup' ) {
//          exploerInitial ();
//          abstractSource ();

            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT
            headerDocument.dataForm.header.value = document.boardSetupForm.header.value;
            footerDocument.dataForm.footer.value = document.boardSetupForm.footer.value;
            loginSkinEnabled();
        } else if ( branch == 'abstract' ) {
            exploerInitial ();
            abstractSource ();
            displayContentInputButton();
            toggleNoticeContent();
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT
            headerDocument.dataForm.header.value = document.boardAbstractForm.header.value;
            footerDocument.dataForm.footer.value = document.boardAbstractForm.footer.value;
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
          <td height="40" bgcolor="015966"> </td>
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
          <td bgcolor="F7F7F7" valign="top"> 
<?
    $package = 'board';
    if ( $branch == 'list' ) {
        include ( 'admin/admin_board_list.php'         ); // �Խ��� ���� ��ȸ
    } else if ( $branch == 'setup' ) {
        include ( 'admin/admin_board_setup.php'        ); // �Խ��� ���� ����
    } else if ( $branch == 'grant' ) {
        include ( 'admin/admin_board_grant.php'        ); // �Խ��� ���� ����
    } else if ( $branch == 'abstract' ) {
        include ( 'admin/admin_board_abstract.php'     ); // �Խ��ǹ� ����
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_board_exec.php'         ); // �Խ��� �Է�
    }
?>
          </td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
<?
    footer(); // Footer ���
} else {
    logs ( '������ �ƴ�' );
    //redirectPage ("admin.php");     // ������ �̵�
    head("����_�Խ��ǰ���");        // Header ���
    Message ('U', '0003', 'MOVE:admin.php:���ư���');
}
closeDBConnection (); // db disconnect
?>