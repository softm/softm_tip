<?
/*
* include 되었는지를 검사
**/
if( defined("_devent_lib_included") ) return;
    define ("_devent_lib_included", true);

$_devent_ver         = 'devent 1.00';
$_devent_ver_str     = '1.00';
$_devent_start_date  = '2004.09.04';
$_devent_update_date = '2004.09.04';

// 테이블 정보 설정
$tb_event               = "kyh_event";
$tb_event_grant         = "kyh_event_grant";
$tb_event_item          = "kyh_event_item";
$tb_event_result_master = "kyh_event_result_master";
$tb_event_result_detail = "kyh_event_result_detail";

/*
* 함수명: getEventInfor
* 설명  : 이벤트 정보를 조회 합니다.
* Argus : $eventId : 이벤트 아이디
**/
function getEventInfor ($eventId) {
    global $tb_event;
    $sql = "select * from $tb_event where no='$eventId';";
    $eventInfor = singleRowSQLQuery($sql);
    return $eventInfor;
}

/*
* 함수명: getEventGrant
* 설명  : 이벤트 권한 조회 합니다.
* Argus : $eventId     : 이벤트 아이디
*       : $memberLevel : 회원 레벨
**/
function getEventGrant ($eventId,$memberLevel) {
    global $tb_event_grant;
    $sql = "select * from $tb_event_grant where no='$eventId' and member_level = $memberLevel;";
//  logs ( '$sql : ' .  $sql . '<BR>', true);
    $eventGrant = singleRowSQLQuery($sql);
    return $eventGrant;
}

/*
* 함수명: getRecentEventNo
* 설명  : 가장 최근 이벤트 번호를 조회 합니다.
**/
function getRecentEventNo () {
    global $tb_event;
    $sql = "select max(no) no from $tb_event;";
    $no = simpleSQLQuery($sql);
    return $no;
}

/*
* 함수명: eventFormCreate
* 설명  : 프로그램내에서 사용되는 기본 폼을 생성합니다.
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