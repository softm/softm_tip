<?
/*
 Filename        : /send_mail_popup.php
 Fuction         : 메일발송
 Comment         :
 시작 일자       : 2012-05-16,
 수정 일자       : 2012-05-16, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
require_once '../../lib/common.lib.inc';
require_once SERVICE_DIR . '/classes/common/Session.php';
$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$mode = !$_GET["mode"]?"login":$_GET["mode"];
$p_onload= !$_GET["p_onload"]?"p_onload":$_GET["p_onload"];
// echo "mode : " .$mode;
require_once SERVICE_DIR . '/inc/header.inc'   ; // header
?>
<script language="Javascript1.2" type="text/javascript" src="<?=HTTP_URL?>/service/js/session.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function 메일발송실행() {
	var subject = document.wForm.subject.value.trim();
	var message = document.wForm.message.value.trim();
	if ( !subject ) {
		alert("제목을 입력해주세요.");
		document.wForm.subject.focus();
    } else if ( !message ) {
		alert("내용을 입력해주세요.");
		document.wForm.message.focus();
	} else 	
		callJSONSyncToText('common.Common','sendMailForAdmin',
            {
                to      :document.wForm.to.value      ,
                toname  :document.wForm.toname.value  ,
                from    :document.wForm.from.value    ,
                fromname:document.wForm.fromname.value,
                subject :document.wForm.subject.value ,
                message :document.wForm.message.value
            },
            function (v) {
				if( v == "1" ) {
                    alert("발송되었습니다.");
                    self.close();
                } else {
                    alert("메일 발송에 실패했습니다.\n관리자에게 문의하세요.");
                }
            }
        );
    return false;	
}

function 메일발송팝업(tr) {
	var win = UI.openWindow('/service/inc/common/send_mail_popup.php', 650, 650,'w_send_mail',{scrollbars:'no'}).focus();
	return false;
}
<?
if ($p_onload) {
?>
window.onload = function() {
    opener.<?=$p_onload?>();
}
<?
}
?>
//-->
</script>
<?
//require(SERVICE_DIR . "/inc/top.inc"); // footer
?>
<!-- <a href=# onclick="return 메일발송팝업();">메일발송팝업</a> -->

<form name="wForm" method="post" onsubmit="return 메일발송실행();">
<table border="0" cellpadding="0" cellspacing="0" id="popup" width=100%
	align="center">
	<tr>
		<td class="top"><img src='/images/pop_mail.jpg'>
		</td>
	</tr>
	<tr>

</table>
<br>
<table border="0" cellpadding="0" cellspacing="0" id="admin2"
	width="100%">
	<tr>
		<td width="150" class="bt" id="t1">발송자 선택</td>
		<td class="bt br2">
			<select name="from">
				<option value='softmnet@gmail.com'>softmnet@gmail.com</option>
				<option value='softmnet1@gmail.com'>softmnet1@gmail.com</option>
				<option value='softmnet2@gmail.com'>softmnet2@gmail.com</option>
			</select> /  <input type=text name="fromname" style="width:55%" value='관리좌' />
		</td>
	</tr>
	<tr>
		<td width="150" class="bt" id="t1">수신자이름/메일</td>
		<td class="bt br2"><input type=text name="to" style="width:40%" value='softmnet@gmail.com' /> / <input type=text name="toname" style="width:45%" value='김지훈' /></td>
	</tr>
	<tr>
		<td width="150" id="t1">제목</td>
		<td align="left"><input type=text name="subject" style="width:95%" /></td>
	</tr>
	
	<tr>
		<td width="150" id="t1">내용</td>
		<td align="left"><textarea name="message"
				cols="45" rows="20" style="width:95%"></textarea></td>
	</tr>
	
	</table>
<br><br>
 
	<div align="center">
  	<a href="#" title="보내기" onclick="return 메일발송실행();"><img src="/images/btn_send.jpg" width="80"  height="25" /></a>&nbsp;
	<a href="#" title="닫기"   onclick="self.close();"><img src="/images/btn_close.jpg" width="80"  height="25" /></a>
</div>
</form>
<?
require(SERVICE_DIR . "/inc/footer.inc"); // footer
?>