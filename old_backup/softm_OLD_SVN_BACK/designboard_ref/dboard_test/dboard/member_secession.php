<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( 'common/lib.inc'          ); // ���� ���̺귯��
include ( 'common/message.inc'      ); // ���� ������ ó��
include ( 'common/db_connect.inc'   ); // Data Base ���� Ŭ����

// �����ͺ��̽��� �����մϴ�.
$db   = initDBConnection (); // �����ͺ��̽��� �����մϴ�.

$memInfor = getMemInfor();      // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
$login_yn = $memInfor['login_yn']; // �α��� ����

if ( $login_yn == 'Y') {
    head('ȸ�� Ż��');  // Header ���
    css();
?>
<style>
body {margin:0px 0px 0px 0px;overflow:hidden}
</style>
<?
    echo ( "\n<script type='text/javascript'>\n" );
    echo ( " var exec = '".$exec ."';\n" );
    echo ( " var id   = '".$id   ."';\n" );
    echo ( " var no   = '".$no   ."';\n" );
    echo ( " var npop = '".$npop ."';\n" );
    echo ( "</SCRIPT>\n" );
?>

<table width="400" border="0" cellspacing="0" cellpadding="0">
    <form name='memberRegForm' method='post' action='<?=$baseDir?>member_register_exec.php' onSubmit='if( confirm("Ż�� �Ͻðڽ��ϱ�?") ) return true; else return false;'>
        <input type='hidden' name='mexec' value='secession'>
        <input type='hidden' name='succ_url' value='<?=$succ_url?>'>
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
                <td><font color="BF0909">+</font> <b>ȸ��Ż���û</b></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="fafafa">
                <td align="right" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td class="text_01">ȸ��Ż�� ��û�� ��� ó���Ǹ� ȸ�������� ��� �����ǰ� �ٷ� �ٸ� ���̵��
                  �簡���� �����մϴ�. <br>
                  ȸ��Ż�� �Ͻðڽ��ϱ�?<br>
                  Ż���û�� �ϽðԵǸ� ��Ҵ� �Ұ����ϴ� ������ �������ֽñ� �ٶ��ϴ�.</td>
              </tr>
              <tr bgcolor="fafafa">
                <td align="right" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td height="10" align="right"><input type='image' src="<?=$baseDir?>images/button_secession.gif" width="66" height="30">
                  <a href='#' onClick='self.close();return false;'><img src="<?=$baseDir?>images/button_close.gif" width="66" height="30" border='0'></a></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td background="<?=$baseDir?>images/join_bg03.gif"></td>
  </tr>
  <tr>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
    <td background="<?=$baseDir?>images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
  </tr>
    </form>
</table>

<?
    closeDBConnection (); // �����ͺ��̽� ���� ���� ����
    footer(); // Footer ���
} else {
    echo ( "<script type='text/javascript'>\n");
    echo ( "<!--\n");
    echo ( "    function windowClose() {\n");
    echo ( "        if ( typeof( opener ) == 'object' ) {\n");
    echo ( "            self.close();\n");
    echo ( "        } else {\n");
    echo ( "            history.back();\n");
    echo ( "        }\n");
    echo ( "    }\n");
    echo ( "//-->\n");
    echo ( "</SCRIPT>\n");
    Message('P', '0012',"javascript:windowClose();:Ȯ��", $skinDir); // ȸ�� ������ �������� �ʽ��ϴ�.
}
?>

