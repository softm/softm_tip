<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
/*****************************************************************/
/* �Լ���: setUpDir1                                             */
/* ��ġ ���丮�� ���մϴ�.                                     */
/*****************************************************************/
function setUpDir1 () {
    global $_SERVER;
    // (_ _);
    $_rtn = $_SERVER["SCRIPT_FILENAME"];
    $_rtn = str_replace("\\","/",$_rtn);
    $endP = strrpos($_rtn,'/') + 1;
    $_rtn = substr($_rtn, 0, $endP);
//    echo '<font color="red">' . $_rtn . '</font><BR>';
    return $_rtn;
}

$setupDir = setUpDir1 ();
include ( "common/lib.inc"          ); // ���� ���̺귯��
include ( "common/message.inc"      ); // ���� ������ ó��
include ( "common/message_table.inc"); // ���� �޽���
$onloadScript = "";
if ( $config ) {
//  redirectPage("setup2.php");
    head("DB����ȭ��_SQLDB����");                                                // Header ���
    css ();
    MessageExit("U", "0001");
} else {
    if ( !is_writeable ( './' ) ) {
        head("DB����ȭ��_SQLDB����");          // Header ���
        css ();
        MessageExit('U', '0006',"");
    } else {
        session_save_path("data/session");
        session_set_cookie_params(0, '/');
        @session_cache_limiter('');
        @session_start  ();
        @session_destroy();
        head("DB����ȭ��_SQLDB����");          // Header ���
        css ();
//         $onloadScript = "document.setupForm.host_nm.focus();";
		include 'common/js/common_js.php'; // ���� javascript
?>
<script type='text/javascript'>
<!--
	window.onload=function() {
		document.setupForm.host_nm.focus();
		getObject('progress_bar').style.visibility="hidden";
	}
var doubleTrans = false; // �ι� ���� ���۵��� �ʵ��� ó��.

    function setupForm_Sumbit() {
        if ( doubleTrans ) { return false; }
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

        installProgress();
        doubleTrans = true;
        return true;
    }

    function inStrAllBlankCheck (argu) {
        if ( typeof ( argu ) == "object" ) argu = argu.value;
        var ch1="";
        for (var i=0;i<argu.length;i++) ch1 += " ";
        if ( argu == ch1 ) return true;
        else return false;
    }

    function installProgress() {
        var x = parseInt(document.body.clientWidth ) / 2 + parseInt(document.body.scrollLeft) - ( 300 / 2 );
        var y = parseInt(document.body.clientHeight) / 2 + parseInt(document.body.scrollTop ) - ( 120 / 2 );
        var progressObj = getObject('progress_bar');
        objectMoveTo( progressObj, x,y);
        objectShow  ( progressObj     );
    }

    function objectMoveTo(id,X,Y, tier) {
        var obj = null;
        if ( typeof(id) == 'object' ) obj = id;
        else obj = getObject(id, tier);
        if ( obj != null && typeof(obj) == 'object' ) {
                          obj.style.left = X;
            if ( Y != 0 ) obj.style.top  = Y;
        }
    }

    function objectShow( id, tier ) {
        var obj = null;
        if ( typeof(id) == 'object' ) obj = id;
        else obj = getObject(id, tier);
        if ( obj != null && typeof(obj) == 'object' ) obj.style.visibility="visible"
/*        obj.style.zIndex=0;     Object���� �⺻���� zIndex ���� 0 �Դϴ�. */
    }
//-->
</SCRIPT>
<?
body('onload="'.$onloadScript."'");
?>
<!--------------------- �߰���
    �� DesignBoard ȸ�� ���� �ȳ�

1. Designboard.net �� Ȩ�������� �����ϱ� ���� �Խ��� �� ��Ÿ �ַ���� �ٿ������ �ְ� �����Ӱ� Ŀ�´����̼��� �Ҽ� �ֽ��ϴ�.

2. ȸ�������� �ϼž� �ٿ�ε�� �۾��Ⱑ �����մϴ�.

3. ȸ�����Խ� �޴� ȸ�������� ���Ͽ� �����ڴ� ����� ������ å���� ������ �ٸ� �������� �̿����� �ʽ��ϴ�.

4. ȸ�����Խ� �޴� �ֹε�Ϲ�ȣ�� �ߺ����� ������ �����̸�, ��ȣȭ �Ǿ� ����ǹǷ� ������ �� �� ��� ������ �� �� �����ϴ�.

5. ȸ���� ID�� ��й�ȣ�� ����Ͽ� �߻��ϴ� ��� ����� ���� å���� ȸ�����ο��� �ֽ��ϴ�.

6. �����κ��� Ȩ�������� ��Ŀ� ��߳��� �׼��� ���ϴ� ȸ���� ���ؼ��� ���縦 ���� �� �ֽ��ϴ�.

7. ȸ���� ���Ҷ� Ż���� �� ������ Ż��� ���ÿ� ��� ������ ������ �����Ǹ� �簡���� �����մϴ�. (Ż��� �������� �������� �Ͻ� �� �ֽ��ϴ�.)

8. �����κ��� ���� �� ����� �����κ��� ���̼��� �� �����κ����� ��å�� �������� ������ �մϴ�.

9. �����κ��带 ����Կ� �־ ���ش� ȸ�� ���ο��� ������ �����κ���� �� å���� ���� �ʽ��ϴ�. (���� ���͵帱���� �ֽ��ϴ�. ^_^)

10.  �����κ��带 ã���ֽ� ��� �е鲲 ����帳�ϴ�. ^___________^ /
-------------------------------->
<!--    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
          <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_01.gif" width="17" height="17"></td>
              <td background="<?=$baseDir?>images/join_bg01.gif">&nbsp;</td>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_02.gif" width="17" height="17"></td>
            </tr>
            <tr>
              <td background="<?=$baseDir?>images/join_bg02.gif">&nbsp;</td>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>
                            <textarea name="textarea4" class="textarea_03" style="width:100%" rows="10">
    <?=_htmlspecialchars ($memForm['agreement_content'], ENT_QUOTES);?>
                            </textarea>
                          </td>
                        </tr>
                        <tr>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td class="text_01">
                            <input type="checkbox" name="agree_chk" value="Y">
                            ���� �¶��� ȸ�� ����� �����մϴ�.</td>
                        </tr>
                        <tr>
                          <td height="10"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td background="<?=$baseDir?>images/join_bg03.gif">&nbsp;</td>
            </tr>
            <tr>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
              <td background="<?=$baseDir?>images/join_bg04.gif"></td>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
--------------------- �߰��� -------------------------------->
<form name='setupForm' action="setup_ok.php" method='POST' onsubmit='return setupForm_Sumbit();'>
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
                                        <td><b>�����κ��� <?=$_dboard_ver?> - [ DB Setting ]</b></td>
                                      </tr>
                                      <tr>
                                        <td height="5"></td>
                                      </tr>
                                      <tr>
                                        <td><font color="BF0909">�����ͺ��̽��� �����մϴ�.<br>
                                          DB ���������� �ش� ���������ڿ��� �����Ͻñ� �ٶ��ϴ�.</font></td>
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
                        <input type="text" name="host_nm" value="localhost">
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
                        <input type="password" name="password" value="">
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
                      <td height="10" align="right"> <input type='image' src="images/button_ss.gif" width="79" height="30">
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
<img id='progress_bar' style='visibility:hidden;position:absolute;left:0px;top:0px;z-index:1' src='images/install_progress.gif'>
</form>
<?
    }
}
    footer(); // Footer ���
?>
