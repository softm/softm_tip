<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include 'common/event_lib.inc' ; // �Խ��� ���̺귯��
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��

$branch   = ( !$branch ) ? "list" : $branch;
if ( !$_POST['how_many'] ) {
    $how_many = $_COOKIE["event_" .$branch . "_many"]; // ��Ű �о� ����
} else {
    if ( $how_many ) { setcookie ("event_" .$branch . "_many", $how_many, time() + 60*60*24*365,"/"); } // $how_many ���� ������
}

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( $memInfor['admin_yn'] == "N" ) {
    logs ( '������ �ƴ�' );
    //redirectPage ("admin.php");     // ������ �̵�
    head("����_�̺�Ʈ����");        // Header ���
    css ($skinDir); // css ����
    MessageExit('U', '0003', 'MOVE:admin.php:���ư���');
} else {
    logs ( '������ �Դϴ�.',FALSE);
    head("����_�̺�Ʈ����");        // Header ���
    css ($skinDir); // css ����
	include 'common/js/common_js.php'; // ���� javascript
	include 'common/js/admin_event_js.php'; // ���� event javascript
?>


<script type='text/javascript'>
<!--
    function event_OnLoad() {
        var branch = '<?=$branch?>';
        if ( branch == 'setup' ) {
            exploerInitial ();
            abstractSource ();
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            headerDocument.dataForm.header.value = document.eventSetupForm.header.value;
            enabledPopUp();
            loginSkinEnabled();
        } else if ( branch == 'result_write' ) {
            passwordEnabled();
        }
    }
//-->
</SCRIPT>
</head>
<body onLoad='event_OnLoad();'>
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
    include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����
    // �����ͺ��̽��� �����մϴ�.
	$db = initDBConnection (); // db connect

    $package = 'event';
    if ( $branch == 'list' ) {
        include ( 'admin/admin_event_list.php'         ); // �̺�Ʈ ���� ��ȸ
    } else if ( $branch == 'setup' ) {
        include ( 'admin/admin_event_setup.php'        ); // �̺�Ʈ ���� ����
    } else if ( $branch == 'result' ) {
        include ( 'admin/admin_event_result.php'       ); // �̺�Ʈ ���
    } else if ( $branch == 'result_write' ) {
        include ( 'admin/admin_event_result_write.php' ); // �̺�Ʈ ��� ����
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_event_exec.php'         ); // �̺�Ʈ �Է�
    }
    closeDBConnection (); // db disconnect
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