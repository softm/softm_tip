<?
/*
* include �Ǿ������� �˻�
**/
if( defined("_dpoll_lib_included") ) return;
    define ("_dpoll_lib_included", true);

$_dpoll_ver         = 'dpoll 1.00';
$_dpoll_ver_str     = '1.00';
$_dpoll_start_date  = '2004.09.04';
$_dpoll_update_date = '2004.09.04';

include 'lib/var/table.inc'; // ���̺� ���� ����

/*
* �Լ���: getPollInfor
* ����  : ���� ���� ������ ��ȸ �մϴ�.
* Argus : $pollId : ���� ���̵�
**/
function getPollInfor ($pollId) {
    global $tb_poll_master;
    $sql = "select * from $tb_poll_master where no='$pollId';";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $pollInfor = singleRowSQLQuery($sql);
    return $pollInfor;
}

/*
* �Լ���: getRecentPollNo
* ����  : ���� �ֱ� ���� ��ȣ�� ��ȸ �մϴ�.
**/
function getRecentPollNo () {
    global $tb_poll_master;
    $sql = "select max(no) no from $tb_poll_master;";
    $no = simpleSQLQuery($sql);
    return $no;
}

/*
* �Լ���: getPollGrant
* ����  : ���� ���� ���� ��ȸ �մϴ�.
* Argus : $pollId      : ���� ���̵�
*       : $memberLevel : ȸ�� ����
**/
function getPollGrant ($pollId,$memberLevel) {
    global $tb_poll_grant;
    $sql = "select * from $tb_poll_grant where no='$pollId' and member_level = $memberLevel;";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $pollGrant = singleRowSQLQuery($sql);
    return $pollGrant;
}

/*
* �Լ���: getPollPointGrant
* ����  : �Խ��Ǻ� ����Ʈ ������ ��ȸ �մϴ�.
* Argus : $pollId : ���� ���̵�
*
   1 : "���� ��ǥ"
   2 : "�ǰ߱� �ۼ�"
**/
function getPollPointGrant ($pollId, $memberLevel, $no) {
    global $tb_poll_point_infor;
    $point = 0;
    if ( $memberLevel > 0 ) { // ��ȸ���� �ƴϸ�
        global $tb_point_infor, $tb_member;
        $sql = "select point from $tb_poll_point_infor where poll_no='$pollId' and no = '$no' and member_level = '$memberLevel';";
        $point = (int) simpleSQLQuery($sql);
    }
    return $point;
}

/*
* �Լ���: pollFormCreate
* ����  : ���α׷������� ���Ǵ� �⺻ ���� �����մϴ�.
**/
function pollFormCreate() {
	global $_dpoll_form_included;
	global $PHP_SELF,$poll_id, $poll_no, $poll_exec, $p_no;
    global $baseDir;

	if(!$_dpoll_form_included) {
echo "
<span id='_dpoll_member_layer_box' style='position:absolute;z-index:1'></span>
<TABLE border=0 cellspacing=0 cellpadding=0 align='center'><FORM name='pollPageForm' METHOD=POST ACTION='". getUrlPath ($PHP_SELF) . getReqPageName ($PHP_SELF) ."'><input name='poll_id' type=hidden value='$poll_id'><input name='poll_no' type=hidden value='$poll_no'><input name='poll_exec' type=hidden value='$poll_exec'><input name='p_no' type=hidden value='$p_no'></FORM></TABLE>
<TABLE border=0 cellspacing=0 cellpadding=0 align='center'><FORM name='pollMailForm' METHOD=POST ACTION=''><input name='gubun' type=hidden value=''><input name='member_level' type=hidden value=''><input name='poll_id' type=hidden value='$poll_id'><input name='user_id' type=hidden value=''><input name='to_name' type=hidden value=''><input name='to_mail' type=hidden value=''><input name='outlook_mail' type=hidden value='outlook_mail'></FORM></TABLE>
";
echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'>";
echo "<FORM  name='PollForm' METHOD=POST ACTION='" . $baseDir . "dpoll.php'>";
echo "<input name=poll_id type=hidden value='$poll_id'><input name=poll_no type=hidden value='$poll_no'><input name=poll_exec type=hidden value='$poll_exec'><input name=p_no type=hidden value='$p_no'>";
echo "</FORM></TABLE>";
		$_dpoll_form_included = true;
	}
}
?>