<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( "common/lib.inc"          ); // ���� ���̺귯��
include ( "common/message.inc"      ); // ���� ������ ó��

if ( !$config ) {
    MessageHead('U', '0012', 'MOVE:setup.php:�̵�');
}

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����

if ( $memInfor['admin_yn'] == "N" ) {
    logs ( '������ �ƴ�' );
    //redirectPage ("admin.php");     // ������ �̵�
    head("�����κ��� ����");        // Header ���
	css(); // css ���
    MessageExit('U', '0003', 'MOVE:admin.php:���ư���');
} else {
    logs ( '������ �Դϴ�.',FALSE);
    head("�����κ��� ����");        // Header ���
	css(); // css ���
	include $baseDir.'common/js/common_js.php'; // ���� javascript
?>

<script type='text/javascript'>
<!--
    function setupForm_Sumbit() {
        if ( inStrAllBlankCheck (document.setupForm.host_nm.value) ) {
            alert ("Host Name�� �Է����ּ���.");
            document.setupForm.host_nm.focus();
            return false;
        }
        if ( inStrAllBlankCheck (document.setupForm.db_nm.value) ) {
            alert ("DB Name�� �Է����ּ���.");
            document.setupForm.db_nm.focus();
            return false;
        }

        if ( inStrAllBlankCheck (document.setupForm.id.value) ) {
            alert ("ID�� �Է����ּ���.");
            document.setupForm.id.focus();
            return false;
        }
        if ( confirm('�𺸵� ������ ������ �Ұ����ϸ� �缳ġ �Ͻ� �� �ֽ��ϴ�.\n�𺸵带 �����Ͻðڽ��ϱ�?') ) {
            return true;
        } else {
            return false;
        }
    }
//-->
</SCRIPT>
</head>
<body>
<form name='setupForm' action="uninstall_ok.php" method='POST' onsubmit='return setupForm_Sumbit();'>
    <input type="hidden" name="driver"     value="MYSQL">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center">
      <table width="400" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="17" height="17"><img src="images/join_01.gif" width="17" height="17"></td>
          <td background="images/join_bg01.gif"></td>
          <td width="17" height="17"><img src="images/join_02.gif" width="17" height="17"></td>
        </tr>
        <tr>
          <td background="images/join_bg02.gif"></td>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="text_01">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td>
                        <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" class="text_01">
                          <tr bgcolor="#FFFFFF">
                            <td colspan="2" height="30" align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                <tr>
                                  <td width="10" bgcolor="F7F7F7"></td>
                                  <td bgcolor="F7F7F7" class="text_01">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                      <tr>
                                        <td><b>�����κ��� <?=$_dboard_ver?> - [ �����κ��� ���� ]</b></td>
                                      </tr>
                                      <tr>
                                        <td height="5"></td>
                                      </tr>
                                      <tr>
                                        <td><font color="BF0909">������ ���� �Խ���, ����, ȸ�� ���� ��ΰ� ���� �˴ϴ�.<br>
                              ��ġ�� �ܰ�� �ʱ�ȭ �Ǹ� �ٽ� ��ġ �Ͻ� �� �ֽ��ϴ�</font></td>
                                      </tr>
                                    </table>

                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                  </td>
                    </tr>
                    <tr>
                      <td height="5"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr bgcolor="fafafa">
                      <td colspan="2" align="right" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td width="100" align="right" class="text_01"><b>Host Name</b></td>
                      <td>
                        <input type="text" name="host_nm" value="">
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" class="text_01"><b>DB Name</b></td>
                      <td>
                        <input type="text" name="db_nm" value="">
                      </td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" class="text_01"><b>ID</b></td>
                      <td>
                        <input type="text" name="id" value="">
                      </td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" class="text_01"><b>Password</b></td>
                      <td>
                        <input type="password" name="password">
                      </td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="10"></td>
                    </tr>
                    <tr>
                      <td height="10" align="right"> <input type='image' src="images/button_uninstall.gif" width="79" height="30">
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
          <td background="images/join_bg03.gif"></td>
        </tr>
        <tr>
          <td width="17" height="17"><img src="images/join_03.gif" width="17" height="17"></td>
          <td background="images/join_bg04.gif" height="17"></td>
          <td width="17" height="17"><img src="images/join_04.gif" width="17" height="17"></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
<?
    footer(); // Footer ���
}
?>
