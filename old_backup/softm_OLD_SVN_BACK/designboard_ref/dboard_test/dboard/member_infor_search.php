<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include 'common/member_lib.inc'; // ��� ���̺귯��
include 'common/lib.inc'       ; // ���� ���̺귯��
include 'common/message.inc'   ; // ���� ������ ó��
include 'common/db_connect.inc'; // Data Base ���� Ŭ����

// �����ͺ��̽��� �����մϴ�.
$db   = initDBConnection (); // �����ͺ��̽��� �����մϴ�.

$memInfor = getMemInfor();      // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
$memForm  = getMemFormSetup (0  ); // ȸ�� �� ����

// logs ($memForm['member_level'] . '<BR>',true);
// logs ($memForm['sex'         ] . '<BR>',true);
// logs ($memForm['agreement'   ] . '<BR>',true);
// logs ($memForm['name'        ] . '<BR>',true);
// logs ($memForm['e_mail'      ] . '<BR>',true);
// logs ($memForm['jumin'       ] . '<BR>',true);
// logs ($memForm['tel'         ] . '<BR>',true);
// logs ($memForm['address'     ] . '<BR>',true);
// logs ($memForm['news_yn'     ] . '<BR>',true);

head("���̵��й�ȣ�н�");        // Header ���
css();

    echo ( "\n<script type='text/javascript'>\n" );
    echo ( " var exec = '".$exec ."';\n" );
    echo ( " var id   = '".$id   ."';\n" );
    echo ( " var no   = '".$no   ."';\n" );
    echo ( " var npop = '".$npop ."';\n" );
    echo ( "</SCRIPT>\n" );

	include $baseDir.'common/js/common_js.php'; // ���� javascript
	include $baseDir.'common/js/member_js.php'; // ȸ�� javascript
?>
<script type='text/javascript'>
<!--
    function memberInforSearchOnLoad() {
      var y = parseInt(document.body.clientHeight) / 2 + parseInt(document.body.scrollTop ) - ( parseInt(document.body.clientHeight ) / 2 );
      window.moveTo(0, y);
    }

    function writeData() {
        if ( typeof ( document.memberInforSearchForm.name ) == 'object' && inStrAllBlankCheck (document.memberInforSearchForm.name) ) {
            alert ("�̸� �Է��� Ȯ���� �ּ���.");
            document.memberInforSearchForm.name.focus();
            return false;
        }
        // ������ ��� �ֹ� ��ȣ �˻縦 ����
        if ( typeof ( document.memberInforSearchForm.jumin_1 ) == 'object' && !juminCheck (document.memberInforSearchForm.jumin_1.value, document.memberInforSearchForm.jumin_2.value) ) {
            alert ("�ֹι�ȣ �Է��� Ȯ���� �ּ���.");
            document.memberInforSearchForm.jumin_1.focus();
            return false;
        }
        var mode     = '<?=$mode?>'      ;
        var succ_url = '<?=$succ_url?>'  ;
        var url = 'member_infor_search_exec.php?id=' + id + '&exec=' + exec + '&no=' + no + '&npop' + npop;
        url += ( mode != ''     ) ? '&mode='     + mode    : '';
        url += ( succ_url != '' ) ? '&succ_url=' + succ_url: '';
        document.memberInforSearchForm.action = url;
        return true;
    }

    function inStrAllBlankCheck (argu) {
        if ( typeof ( argu ) == "object" ) argu = argu.value;
        var ch1="";
        for (var i=0;i<argu.length;i++) ch1 += " ";
        if ( argu == ch1 ) return true;
        else return false;
    }
//-->
</SCRIPT>
<style>
body {margin:0px 0px 0px 0px;overflow:hidden }
</style>
</head>
<body onLoad='memberInforSearchOnLoad();'>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<form name='memberInforSearchForm' method='post' action='member_infor_search_exec.php' onSubmit='return writeData();'>
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
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
              <tr>
                <td><font color="BF0909">+</font> <b>���̵�/��й�ȣ ã��</b></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td>ȸ������ ������ �����ϽǶ��� �����Ͻ� ���� �ּҷ� �߼۵˴ϴ�.</td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
            </table>
<? if ( $memForm['jumin'] == 'Y' ) {?>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="fafafa">
                <td colspan="2" align="right" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td width="100" align="right" class="text_01"><b>�̸�</b></td>
                <td>
                  <input type="text" name="name" maxlength="20">
                </td>
              </tr>
              <tr>
                <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td align="right" class="text_01"><b>�ֹε�Ϲ�ȣ</b></td>
                <td>
                  <input type="text" name="jumin_1" maxlength="6">
                  -
                  <input type="text" name="jumin_2" maxlength="7">
                </td>
              </tr>

<? } else {?>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="fafafa">
                <td colspan="2" align="right" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td width="100" align="right" class="text_01"><b>�̸�</b></td>
                <td>
                  <input type="text" name="name" size='34' maxlength="20">
                </td>
              </tr>
              <tr>
                <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
              </tr>
<? }?>
<? if ( $memForm['hint'] == 'Y' ) {?>
              <tr>
                <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td width="100" align="right" class="text_01"><b>��Ʈ</b></td>
                <td>
                <select name='hint'>
                    <option value=''  >----------- ��Ʈ ���� -----------</option>
                    <option value='1' >���� ���� ��1ȣ��?             </option>
                    <option value='2' >���� ģ�� ģ�� �̸���?         </option>
                    <option value='3' >���� ���� �����ϴ� ��������?   </option>
                    <option value='4' >�� ������?                     </option>
                    <option value='5' >�����ϴ� ����?                 </option>
                </select>
                </td>
              </tr>

              <tr>
                <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td width="100" align="right" class="text_01"><b>�亯</b></td>
                <td>
                <input type='text' name='answer' size='34' maxlength="100" value='<?=$answer?>'>
                </td>
              </tr>
<? }?>
              <tr bgcolor="fafafa">
                <td align="right" colspan="2" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td height="10" align="right">
                <input type='image' src="images/button_ok2.gif" width="66" height="30">
                <a href='#' onClick='self.close();'><img src="images/button_close.gif" width="66" height="30" border='0'></a>
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
</form>
</table>
<br>
<?
footer(); // Footer ���
?>
