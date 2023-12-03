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
<title>����_�̺�Ʈ �׸� ����</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="<?=$baseDir?>style.css" type="text/css">
<?
	include $baseDir.'common/js/common_js.php'; // ���� javascript
	include $baseDir.'common/js/admin_event_js.php'; // ���� event javascript
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var libDir = '<?=$libDir?>';
//-->
</SCRIPT>
<SCRIPT LANGUAGE='javascript'>
<!--

    function mainInsert() {
        var item     = document.eventItemInsertForm.item.value     ;
        var itemName = document.eventItemInsertForm.item_name.value;

        if ( item == "" ) {
            alert( '������ ������ �������ּ���.' );
            document.eventItemInsertForm.item.focus()   ;
            return false;
        } else {
            if ( itemName == '' ) {
                alert('�׸��̸��� �Է����ּ���.');
                document.eventItemInsertForm.item_name.focus(); return false;
            }
            if ( strLength(itemName) > 255 ) {
                alert ("255���̳��� �Է��� �ּ���.");
                document.eventItemInsertForm.item_name.focus();
                return false;
            }
            document.eventItemInsertForm.gubun.value = 'main_insert';
            return true;
        }
    }

    function mainUpdate() {
        var updateExec = true;
        var itemName  = document.eventItemForm["item_name[]"];
        var i;
        for ( i=1;i<itemName.length; i++ ) {
            if ( itemName[i].value == '' ) { 
                updateExec = false;
                break;
            }
        }

        if ( updateExec == false ) {
            alert ( i + ' ��° �׸���� �Էµ��� �ʾҽ��ϴ�.' );
            itemName[i].focus();
        }
        document.eventItemForm.gubun.value = 'main_update';
        return updateExec;

    }

    function viewDetail(gNo) {
        var preGno = document.eventDetailItemForm.g_no.value;
        var preinsertitemObj = getObject( '_dboard_detail_' + preGno );
        if ( typeof ( preinsertitemObj) != 'undefined' && gNo != preGno ) {
            preinsertitemObj.style.position   = 'absolute';
            preinsertitemObj.style.visibility = 'hidden'  ;
            preinsertitemObj.style.zIndex     = -1        ;
        }
        var obj = getObject('_dboard_detail_' + gNo);
        if ( obj.style.visibility == 'hidden' ) {
            obj.style.position   = 'relative';
            obj.style.visibility = 'visible' ;
            obj.style.zIndex     = 10        ;
            obj.style.top        = 0         ;
            obj.style.left       = 0         ;
        } else {
            obj.style.position   = 'absolute';
            obj.style.visibility = 'hidden'  ;
            obj.style.zIndex     = -1        ;
        }
        document.eventDetailItemForm.g_no.value = gNo;
    }

    function detailInsert(gNo) {
        insertitemObj = eval ( 'document.eventItemForm.detail_item_name' + gNo );
        var itemName = insertitemObj.value;
        if ( itemName == '' ) {
            alert('�׸��̸��� �Է����ּ���.');
            insertitemObj.focus(); return false;
        }
        if ( strLength(itemName) > 255 ) {
            alert ("255���̳��� �Է��� �ּ���.");
            insertitemObj.focus();
            return false;
        }

        document.eventDetailItemForm.item_name.value = itemName;
        document.eventDetailItemForm.gubun.value = 'detail_insert';
        document.eventDetailItemForm.g_no.value = gNo;
        document.eventDetailItemForm.submit();
        return true;
    }

    function detailUpdate(gNo, cnt) {
        if ( cnt > 0 ) {
            var updateExec = true;
            var itemName  = document.eventItemForm["item_name[]"];
            var i;
            for ( i=1;i<itemName.length; i++ ) {
                if ( itemName[i].value == '' ) { 
                    updateExec = false;
                    break;
                }
            }
            if ( updateExec == false ) {
                alert ( i + ' ��° �׸���� �Էµ��� �ʾҽ��ϴ�.' );
                itemName[i].focus();
            }
            document.eventItemForm.u_g_no.value = gNo;
            document.eventItemForm.gubun.value  = 'detail_update';
            document.eventItemForm.submit();
        } else {
            alert ( '������ �׸��� �����ϴ�.' );
        }
    }


    var preViewWin = null;
    function preView (eventId, gNo) {
        var url = libDir + 'admin_event_popup_item_preview.php?event_id=' + eventId + '&g_no=' + gNo;
        if ( preViewWin != null ) { preViewWin.close(); }
        preViewWin = popWindow(url,200,200,-1,-1,'preViewWin',"location=no,toolbar=no,menubar=no,resizable=yes,scrollbars=YES");
        preViewWin.focus();
    }
//-->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
// �����ͺ��̽��� �����մϴ�.
$db = initDBConnection ();
?>
<table width="500" border="0" cellspacing="0" cellpadding="0">
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
          <td class="text_01"> <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
              <tr>
                <td><font color="BF0909">+</font> <b>�̺�Ʈ �׸� ����<br>
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
                <td>�̺�Ʈ �׸��� ���� �Ͻ� �� �ֽ��ϴ�.</td>
              </tr>
              <tr>
                <td align="right" height="5"></td>
              </tr>
            </table>

            <table width="100%" border="0" cellspacing="0" cellpadding="5">
<form name='eventItemInsertForm'  action='<?=$libDir?>admin_event_popup_item_exec.php' onSubmit='return mainInsert();'>
    <input type='hidden' name='gubun' value=''>
    <input type='hidden' name='event_id' value='<?=$event_id?>'>
    <input type='hidden' name='g_no'  value=''>
              <tr>
                <td height="1" colspan="10" align="right" background="<?=$baseDir?>images/bg2.gif" bgcolor="fafafa" class="text_01"></td>
              </tr>
              <tr bgcolor="eeeeee">
                <td colspan="10" bgcolor="eeeeee" class="text_01">����
                    <select name="item" class="jm_01">
                        <option value='' >����          </option>
                        <option value='1'>���� ����   </option>
                        <option value='2'>üũ   ����   </option>
                        <option value='3'>���   ����   </option>
                        <option value='4'>��Ƽ ��� ����</option>
                        <option value='5'>�ؽ�Ʈ ����   </option>
                        <option value='6'>�Է� ����     </option>
                        <option value='7'>��й�ȣ ���� </option>
                    </select>
                    &nbsp;<input type='text' name='item_name' size='30'>&nbsp;<input type='image' border="0" src="<?=$baseDir?>images/button_bplus.gif" width="43" height="20" align="top">
                </td>
              </tr>
</form>
            </table>

            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr> 
                <td height="1" colspan="10" align="center" background="<?=$baseDir?>images/bg2.gif" bgcolor="fafafa" class="text_01"></td>
              </tr>
              <tr> 
                <td width="40" align="center" bgcolor="fafafa" class="text_01"><strong>��ȣ</strong></td>
                <td            align="center" bgcolor="fafafa"                ><strong>����</strong></td>
                <td            align="center" bgcolor="fafafa"                ><strong>�׸��</strong></td>
                <td width="90" align="center" bgcolor="fafafa"                ><strong>���μ���</strong></td>
                <td width="45" align="center" bgcolor="fafafa"                ><strong>����</strong></td>
              </tr>
              <tr> 
                <td height="1" colspan="10" align="right" bgcolor="fafafa" class="text_01" background="<?=$baseDir?>images/bg2.gif"></td>
              </tr>
<form name='eventItemForm' method='post' action='<?=$libDir?>admin_event_popup_item_exec.php' onSubmit='return mainUpdate();'>
    <input type="hidden" name="event_id"    value="<?=$event_id?>">
    <input type="hidden" name="gubun"       value="">
    <input type="hidden" name="g_no[]"      value="">
    <input type="hidden" name="seq[]"       value="">
    <input type="hidden" name="item[]"      value="">
    <input type="hidden" name="item_name[]" value="">
    <input type="hidden" name="u_g_no"      value="">
<?
    include $libDir . "admin_event_popup_item_list_main.php";
?>
            </table>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td height="10" align="right">
                  <input type='image' src="<?=$baseDir?>images/button_ok2.gif" width="66" height="30">
                  <a href='#' onClick='self.close();return false;'><img src="<?=$baseDir?>images/button_close.gif" width="66" height="30" border='0'></a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
</form>

<form name='eventDetailItemForm' method='post' action='<?=$libDir?>admin_event_popup_item_exec.php'>
    <input type="hidden" name="event_id"    value="<?=$event_id?>">
    <input type="hidden" name="gubun"       value="">
    <input type="hidden" name="g_no"        value="<?=$c_g_no?>">
    <input type="hidden" name="item_name"   value="">
<form>
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