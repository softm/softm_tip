<?
$baseDir = '../';
include $baseDir . 'common/board_lib.inc' ; // �Խ��� ���̺귯��
include $baseDir . 'common/member_lib.inc'; // ��� ���̺귯��
include $baseDir . 'common/lib.inc'       ; // ���� ���̺귯��
include $baseDir . 'common/db_connect.inc'; // Data Base ���� Ŭ����
include $baseDir . 'common/message.inc'   ; // ���� ������ ó��

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
if ( $memInfor['admin_yn'] == "Y" ) {
?>
<html>
<head>
<title>����Ʈ ����</title>
<link rel="stylesheet" href="../style.css" type="text/css">
<SCRIPT LANGUAGE='javascript'>
<!--
	function isNumber(argu_number)
	{
		var Number = "1234567890";
		var ii=0;
		var L = argu_number.length;

		for (var i=0; i < L; i++) {
			ch1 = argu_number.substring(i,i+1);
			if ( i == 0 ) {
				if ( ch1 != '-' && Number.indexOf(ch1) < 0 ) {
					ii = 0;
					break;
				} else {
					ii=10;
				}
			} else {
				if ( Number.indexOf(ch1) < 0 ) { ii = 0; break; }
				else { ii=10; }
			}
		}
		if ( ii == 10 ) return true;
		else return false;
	}
    function checkedToggle() {
        var tmp_use_st = document.pointSetupForm [ "tmp_use_st[]" ];
        for ( var i=1; i<tmp_use_st.length; i++ ) {
            if ( tmp_use_st[i].checked ) { 
                tmp_use_st[i].checked = false;
            } else {
                tmp_use_st[i].checked = true;
            }
        }
    }

    function formCheck() {
        var tmp_use_st = document.pointSetupForm [ "tmp_use_st[]" ];
        var use_st     = document.pointSetupForm [ "use_st[]"     ];
        for ( var i=1; i<tmp_use_st.length; i++ ) {
            if ( tmp_use_st[i].checked ) { 
                use_st[i].value   = '1' ;
            } else {
                use_st[i].value   = '2' ;
            }
        }
        return true;
    }
//-->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
// �����ͺ��̽��� �����մϴ�.
$db = initDBConnection ();
$libDir = "../admin/lib/" . $sysInfor['driver'] . '/';

    if ( !$how_many ) {
        $how_many = 10;
    } else {
        $how_many = (int)$how_many;
    }
    $page_many= 10;
    $s = ( !$s ) ? 1 : $s;

    $pointInfor = array("","�Խù� �ۼ�", "�ǰ߱� �ۼ�", "���� ���ε�", "�ٿ�ε�", "����ۼ�");

    // ȸ�� �������� ��ȸ
    if ( $member_level != 'all' ) {
        $sql = "select member_nm from $tb_member_kind where member_level = '$member_level'";
    //  echo $sql;
        $member_nm = simpleSQLQuery($sql);
    } else {
        $member_nm = '��ü';
    }
?>
<table width="400" border="0" cellspacing="0" cellpadding="0">
<form name='pointSetupForm' action='<?=$libDir?>admin_board_popup_point_grant_exec.php' onSubmit='return formCheck();'>
<input type='hidden' name='member_level' value='<?=$member_level?>'>
<input type='hidden' name='bbs_id'       value='<?=$bbs_id?>'      >
<input type='hidden' name='gubun'        value='point_grant_update'>
<input type="hidden" name="no[]"    >
<input type="hidden" name="tmp_use_st[]">
<input type="hidden" name="use_st[]">
<input type="hidden" name="point[]" >
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
          <td class="text_01"> <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
              <tr> 
                <td><font color="BF0909">+</font> <b><?=$member_nm?> ����Ʈ ���� [ <?=$bbs_id?> ]<br>
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
                <td>
<?
    if ( $member_level != 'all' ) {
        echo "���� �ش��ϴ� ȸ�������� ����Ʈ�� ���� �Ͻ� �� �ֽ��ϴ�.";
    } else {
        echo "��ü ȸ�� ������ ����Ʈ�� �ѹ��� ����˴ϴ�.";
    }
?>
                
                </td>
              </tr>
              <tr> 
                <td align="right" height="5"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="eeeeee"> 
                <td align="center" class="text_01"><strong>����Ʈ ����</strong></td>
                <td align="center"><a href='#' onClick='checkedToggle();return false;'>���</a></td>
                <td>����Ʈ ����</td>
              </tr>

<?
    include $libDir . "admin_board_popup_point_grant_list_main.php";
?>

              <tr> 
                <td height="1" colspan="3" align="center" background="../images/bg2.gif" bgcolor="fafafa" class="text_01"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="10"></td>
              </tr>
              <tr> 
                <td height="10" align="right"> <input type='image' src="../images/button_ok2.gif" width="66" height="30"> 
                  <a href='#' onClick='window.close();return false;'><img src="../images/button_close.gif" width="66" height="30" border='0'></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td background="../images/join_bg03.gif"></td>
  </tr>
  <tr> 
    <td width="17" height="17"><img src="../images/join_03.gif" width="17" height="17"></td>
    <td background="../images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="../images/join_04.gif" width="17" height="17"></td>
  </tr>
</form>
</table>
</body>
</html>
<?
closeDBConnection (); // �����ͺ��̽� ���� ���� ����
} else {
}
?>