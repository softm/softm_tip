<?
$baseDir = '../';
include $baseDir . 'common/event_lib.inc' ; // �̺�Ʈ ���̺귯��
include $baseDir . 'common/member_lib.inc'; // ��� ���̺귯��
include $baseDir . 'common/lib.inc'       ; // ���� ���̺귯��
include $baseDir . 'common/db_connect.inc'; // Data Base ���� Ŭ����
include $baseDir . 'common/message.inc'   ; // ���� ������ ó��

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
if ( $memInfor['member_level'] == 99 ) {
    $libDir = $baseDir . "admin/lib/" . $sysInfor['driver'] . '/';
?>
<html>
<head>
<title>���� �̺�Ʈ ���� �� ����Ʈ ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="<?=$baseDir?>style.css" type="text/css">
<?
	include $baseDir.'common/js/common_js.php'; // ���� javascript
	include $baseDir.'common/js/admin_event_js.php'; // ���� poll javascript
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var libDir = '<?=$libDir?>';
//-->
</SCRIPT>
<SCRIPT LANGUAGE='javascript'>
<!--
    function updateData() {
        document.eventGrantForm.target = '';
        document.eventGrantForm.gubun.value  = 'grant_update';
        document.eventGrantForm.action = libDir + 'admin_event_popup_grant_exec.php';
        return true;
    }

    function changeData (idx) {
        var updateYn                = document.eventGrantForm ["update_yn[]"    ];
        var grant_join              = document.eventGrantForm ["grant_join[]"   ];
        var grant                   = document.eventGrantForm ["grant[]"        ];
        grant[idx].value = '';

        if ( grant_join             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }

        updateYn[idx].value = 'Y';
    }
//-->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
// �����ͺ��̽��� �����մϴ�.
$db = initDBConnection ();
?>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_01.gif" width="17" height="17"></td>
    <td background="<?=$baseDir?>images/join_bg01.gif"></td>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_02.gif" width="17" height="17"></td>
  </tr>
  <tr>
    <td background="<?=$baseDir?>images/join_bg02.gif"></td>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="text_01">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
              <tr>
                <td><font color="BF0909">+</font> <b>����Ʈ ����<br>
                  </b></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td background="<?=$baseDir?>images/bg2.gif" height="1"></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td>���� �ش��ϴ� ȸ�������� ����Ʈ�� ���� �Ͻ� �� �ֽ��ϴ�.</td>
              </tr>
              <tr>
                <td align="right" height="5"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td height="1" colspan="3" align="right" background="<?=$baseDir?>images/bg2.gif" bgcolor="fafafa" class="text_01"></td>
              </tr>
              <tr bgcolor="eeeeee">
                <td align="center" class="text_01"><strong>ȸ������</strong></td>
                <td align="center">����</td>
                <td>����Ʈ ����</td>
              </tr>
<form name='eventGrantForm' method='post' onSubmit='return updateData();'>
    <input type='hidden' name='event_id'        value='<?=$event_id?>'>
    <input type='hidden' name='gubun'           value=''>
    <input type='hidden' name='update_yn[]'     value="">
    <input type="hidden" name='grant[]'         value="">
    <input type="hidden" name="grant_join[]"    value="">
    <input type="hidden" name="join_point[]"    value="">
    <input type="hidden" name="member_level[]"  value="">
<?
    include $libDir . "admin_event_popup_grant_list_main.php";
?>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td height="10" align="right">
                  <input type='image' src="<?=$baseDir?>images/button_ok2.gif" width="66" height="30" border='0'>
                  <a href='#' onClick='self.close();return false;'><img src="<?=$baseDir?>images/button_close.gif" width="66" height="30" border='0'></a></td>
              </tr>
            </table></td>
        </tr>
</form>
      </table>
    </td>
    <td background="<?=$baseDir?>images/join_bg03.gif"></td>
  </tr>
  <tr>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
    <td background="<?=$baseDir?>images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
  </tr>
</table>
</body>
</html>
<?
closeDBConnection (); // �����ͺ��̽� ���� ���� ����
} else {
}
?>