<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( "common/lib.inc"          ); // ���� ���̺귯��
include ( 'common/message.inc'      ); // ���� ������ ó��
include ( "common/db_connect.inc"   ); // Data Base ���� Ŭ����

head("DB����ȭ��_������������");       // Header ���
css();
if ( !$config ) {
   Message("U", "0002", "MOVE:setup.php:�̵�");
} else {
    if ( $_SESSION['_s_setup_ok'] == '1' ) {
        include 'common/js/common_js.php'; // ���� javascript
?>


<script type='text/javascript'>
<!--
    function inStrAllBlankCheck (argu) {
        if ( typeof ( argu ) == "object" ) argu = argu.value;
        var ch1="";
        for (var i=0;i<argu.length;i++) ch1 += " ";
        if ( argu == ch1 ) return true;
        else return false;
    }

    function setupForm_Sumbit() {
        if ( inStrAllBlankCheck (document.setupForm.id.value) ) {
            alert ("ID�� �Է����ּ���.");
            document.setupForm.id.focus();
            return false;
        }

        if ( inStrAllBlankCheck (document.setupForm.password.value) ) {
            alert ("Password�� �Է����ּ���.");
            document.setupForm.password.focus();
            return false;
        }
        return true;
    }
//-->
</SCRIPT>
<?
body();
?>
<form name='setupForm' action="setup2_ok.php" method='POST' onsubmit='return setupForm_Sumbit();'>
    <input type="hidden" name="driver"     value="MYSQL">

<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center">
<span class="text_04"><B>+ �����κ��� ��ġ�� ���������� �Ϸ� �Ǿ����ϴ�. +</B></span><BR><BR>
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
                                <tr bgcolor="F7F7F7">
                                  <td width="10"></td>
                                  <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                      <tr>
                                        <td><b>�����κ��� <?=$_dboard_ver?> - [ Admin Setting ]</b></td>
                                      </tr>
                                      <tr>
                                        <td height="5"></td>
                                      </tr>
                                      <tr>
                                        <td class="text_04">
                                          �� ȭ�鿡���� ������ ���̵� �����մϴ�.<br>
                                          �����Ͻô� ���̵�� ��й�ȣ�� �� ����Ͻñ� �ٶ��ϴ�.
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr bgcolor="F7F7F7">
                                  <td colspan='2'>�� ������ ���̵� ���� �������� �����ø� �缳ġ �ؾ� �մϴ�.</td>
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
                      <td width="100" align="right" class="text_01"><b>���̵�</b></td>
                      <td>
                        <input type="text" name="id" value="admin">
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" class="text_01"><b>��й�ȣ</b></td>
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
                      <td height="10" align="right"> <input type='image' src="images/button_next.gif" width="79" height="30">
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
    } else {
        Message('S', '0003',"");
    }
} // else END
footer(); // Footer ���
?>