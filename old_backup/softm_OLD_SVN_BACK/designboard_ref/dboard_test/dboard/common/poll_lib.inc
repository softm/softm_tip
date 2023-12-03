<?
/*
* include 되었는지를 검사
**/
if( defined("_dpoll_lib_included") ) return;
    define ("_dpoll_lib_included", true);

$_dpoll_ver         = 'dpoll 1.00';
$_dpoll_ver_str     = '1.00';
$_dpoll_start_date  = '2004.09.04';
$_dpoll_update_date = '2004.09.04';

include 'lib/var/table.inc'; // 테이블 정보 설정

/*
* 함수명: getPollInfor
* 설명  : 설문 조사 정보를 조회 합니다.
* Argus : $pollId : 설문 아이디
**/
function getPollInfor ($pollId) {
    global $tb_poll_master;
    $sql = "select * from $tb_poll_master where no='$pollId';";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $pollInfor = singleRowSQLQuery($sql);
    return $pollInfor;
}

/*
* 함수명: getRecentPollNo
* 설명  : 가장 최근 설문 번호를 조회 합니다.
**/
function getRecentPollNo () {
    global $tb_poll_master;
    $sql = "select max(no) no from $tb_poll_master;";
    $no = simpleSQLQuery($sql);
    return $no;
}

/*
* 함수명: getPollGrant
* 설명  : 설문 조사 권한 조회 합니다.
* Argus : $pollId      : 설문 아이디
*       : $memberLevel : 회원 레벨
**/
function getPollGrant ($pollId,$memberLevel) {
    global $tb_poll_grant;
    $sql = "select * from $tb_poll_grant where no='$pollId' and member_level = $memberLevel;";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $pollGrant = singleRowSQLQuery($sql);
    return $pollGrant;
}

/*
* 함수명: getPollPointGrant
* 설명  : 게시판별 포인트 정보를 조회 합니다.
* Argus : $pollId : 설문 아이디
*
   1 : "설문 투표"
   2 : "의견글 작성"
**/
function getPollPointGrant ($pollId, $memberLevel, $no) {
    global $tb_poll_point_infor;
    $point = 0;
    if ( $memberLevel > 0 ) { // 비회원이 아니면
        global $tb_point_infor, $tb_member;
        $sql = "select point from $tb_poll_point_infor where poll_no='$pollId' and no = '$no' and member_level = '$memberLevel';";
        $point = (int) simpleSQLQuery($sql);
    }
    return $point;
}

/*
* 함수명: pollFormCreate
* 설명  : 프로그램내에서 사용되는 기본 폼을 생성합니다.
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