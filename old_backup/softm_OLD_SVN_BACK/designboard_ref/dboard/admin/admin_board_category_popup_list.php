<?
$baseDir = '../';
include $baseDir . 'common/board_lib.inc' ; // �Խ��� ���̺귯��
include $baseDir . 'common/lib.inc'       ; // ���� ���̺귯��
include $baseDir . 'common/db_connect.inc'; // Data Base ���� Ŭ����
include $baseDir . 'common/message.inc'   ; // ���� ������ ó��
$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
if ( $memInfor['admin_yn'] == "Y" ) {
    $db = initDBConnection ();
    $libDir = "lib/" . $sysInfor['driver'] . '/';
?>
<html>
<head>
<title><?=$bbs_id?> �Խ��� - ī�װ� ����</title>
<link rel="stylesheet" href="../style.css" type="text/css">
<SCRIPT LANGUAGE="JavaScript">
<!--
    function categoryInsert() {
        if ( document.categoryInsertForm.name.value == '' ) {
            alert ( 'ī�װ����� �Է����ּ���.' );
            document.categoryInsertForm.name.focus();
            return false;
        }
        return true;
    }

    function categoryUpdate() {
        var updateExec = true;
        var categoryName  = document.categoryForm["name[]"];
        var i;
        for ( i=1;i<categoryName.length; i++ ) {
            if ( categoryName[i].value == '' ) { 
                updateExec = false;
                break;
            }
        }

        if ( updateExec == false ) {
            alert ( i + ' ��° ī�װ����� �Էµ��� �ʾҽ��ϴ�.' );
            categoryName[i].focus();
        }

        return updateExec;
    }
//-->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad='document.categoryInsertForm.name.focus();'>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="17" height="17"><img src="../images/join_01.gif" width="17" height="17"></td>
    <td background="../images/join_bg01.gif"></td>
    <td width="17" height="17"><img src="../images/join_02.gif" width="17" height="17"></td>
  </tr>
  <tr> 
    <td background="../images/join_bg02.gif"></td>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="text_01">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
<form name='categoryInsertForm' method='post' action='<?=$libDir?>admin_board_category_exec.php' onSubmit='return categoryInsert();'>
    <input type='hidden' name='bbs_id'  value='<?=$bbs_id?>'>
    <input type='hidden' name='gubun'  value='insert'>
              <tr> 
                <td><font color="BF0909">+</font> <b>ī�װ��߰�/����<br>
                  </b></td>
              </tr>
              <tr> 
                <td height="5"></td>
              </tr>
              <tr> 
                <td background="../images/bg2.gif" height="1"></td>
              </tr>
              <tr> 
                <td height="5"></td>
              </tr>
              <tr> 
                <td>���� �ش��ϴ� �Խ����� ī�װ��� ���� �Ͻ� �� �ֽ��ϴ�.</td>
              </tr>
              <tr> 
                <td align="right" height="5"></td>
              </tr>
              <tr> 
                <td height="5"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr> 
                      <td background="../images/bg2.gif" height="1"></td>
                      <td background="../images/bg2.gif" height="1"></td>
                      <td background="../images/bg2.gif" height="1"></td>
                    </tr>
                    <tr> 
                      <td bgcolor="fafafa" align="right" colspan="2"> <input type="text" name="name" style="width:100%"></td>
                      <td bgcolor="fafafa" align="right" width="43"> <input type='image' src="../images/button_ca_ok.gif" width="43" height="20" align="absmiddle"></td>
                    </tr>
                  </table>
                </td>
              </tr>
</form>
            </table>


            <table width="100%" border="0" cellspacing="0" cellpadding="5">
<form name='categoryForm' method='post' action='<?=$libDir?>admin_board_category_exec.php' onSubmit='return categoryUpdate();'>
    <input type='hidden' name='bbs_id'  value='<?=$bbs_id?>'>
    <input type='hidden' name='gubun'   value='update'>
    <input type="hidden" name="no[]"    value="">
    <input type="hidden" name="name[]"  value="">
              <tr bgcolor="fafafa"> 
                <td colspan="4" align="right" class="text_01" height="1" background="../images/bg2.gif"></td>
              </tr>
<?
        include $libDir . "admin_board_category_list_main.php";
?>
            </table>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="10"></td>
              </tr>
              <tr> 
                <td height="10" align="right"> <input type='image' src="../images/button_ok2.gif" width="66" height="30"> 
                  <a href='#' onclick='self.close();return false;' onblur='return false;'><img src="../images/button_close.gif" width="66" height="30" border='0'></a></td>
              </tr>
</form>
            </table>

          </td>
        </tr>
      </table>
    </td>
    <td background="../images/join_bg03.gif"></td>
  </tr>
  <tr> 
    <td width="17" height="17"><img src="../images/join_03.gif" width="17" height="17"></td>
    <td background="../images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="../images/join_04.gif" width="17" height="17"></td>
  </tr>
</table>
<br>
</body>
</html>
<?
closeDBConnection (); // �����ͺ��̽� ���� ���� ����
} else {
}
?>