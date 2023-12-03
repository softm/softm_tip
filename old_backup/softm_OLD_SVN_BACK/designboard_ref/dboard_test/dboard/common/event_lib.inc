<?
/*
* include �Ǿ������� �˻�
**/
if( defined("_devent_lib_included") ) return;
    define ("_devent_lib_included", true);

$_devent_ver         = 'devent 1.00';
$_devent_ver_str     = '1.00';
$_devent_start_date  = '2004.09.04';
$_devent_update_date = '2004.09.04';

include 'lib/var/table.inc'; // ���̺� ���� ����

/*
* �Լ���: getEventInfor
* ����  : �̺�Ʈ ������ ��ȸ �մϴ�.
* Argus : $eventId : �̺�Ʈ ���̵�
**/
function getEventInfor ($eventId) {
    global $tb_event;
    $sql = "select * from $tb_event where no='$eventId';";
    $eventInfor = singleRowSQLQuery($sql);
    return $eventInfor;
}

/*
* �Լ���: getEventGrant
* ����  : �̺�Ʈ ���� ��ȸ �մϴ�.
* Argus : $eventId     : �̺�Ʈ ���̵�
*       : $memberLevel : ȸ�� ����
**/
function getEventGrant ($eventId,$memberLevel) {
    global $tb_event_grant;
    $sql = "select * from $tb_event_grant where no='$eventId' and member_level = $memberLevel;";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $eventGrant = singleRowSQLQuery($sql);
    return $eventGrant;
}

/*
* �Լ���: getRecentEventNo
* ����  : ���� �ֱ� �̺�Ʈ ��ȣ�� ��ȸ �մϴ�.
**/
function getRecentEventNo () {
    global $tb_event;
    $sql = "select max(no) no from $tb_event;";
    $no = simpleSQLQuery($sql);
    return $no;
}

/*
* �Լ���: eventFormCreate
* ����  : ���α׷������� ���Ǵ� �⺻ ���� �����մϴ�.
**/
function eventFormCreate() {
	global $_devent_form_included;
	global $PHP_SELF; 
	if(!$_devent_form_included) {
echo "
<span id='_devent_member_layer_box' style='position:absolute;z-index:1'></span>
<TABLE border=0 cellspacing=0 cellpadding=0 align='center'><FORM name='eventPageForm' METHOD=POST ACTION='". getUrlPath ($PHP_SELF) . getReqPageName ($PHP_SELF) ."'></FORM></TABLE>
<TABLE border=0 cellspacing=0 cellpadding=0 align='center'><FORM name='eventMailForm' METHOD=POST ACTION=''><input name='gubun' type=hidden value=''><input name='member_level' type=hidden value=''><input name='user_id' type=hidden value=''><input name='to_name' type=hidden value=''><input name='to_mail' type=hidden value=''><input name='outlook_mail' type=hidden value='outlook_mail'></FORM></TABLE>
";
		$_devent_form_included = true;
	}
}
?>