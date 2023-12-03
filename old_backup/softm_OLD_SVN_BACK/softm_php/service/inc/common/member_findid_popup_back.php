<?
/*
 Filename        : /member_findid_popup.php
 Fuction         : 아이디비밀번호 찾기
 Comment         :
 시작 일자       : 2012-05-20,
 수정 일자       : 2010-05-20, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
require_once '../../lib/common.lib.inc';
require_once SERVICE_DIR . '/classes/common/Session.php';
$memInfor = Session::getSession();
$mode = !$_GET["mode"]?"login":$_GET["mode"];
require_once SERVICE_DIR . '/inc/header.inc'   ; // header
?>
<script language="Javascript1.2" type="text/javascript" src="<?=HTTP_URL?>/service/js/session.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function 아이디비밀번호찾기실행() {
    if ( Form.validate( document.wForm ) )
    {
		callJSONSyncToText('common.Common','findIdSendMail',
            {
			    toname  :document.wForm.toname.value,
                to      :document.wForm.to.value
            },
            function (v) {
				if( v == "1" ) {
                    document.getElementById("area01").style.display = "none";
                    document.getElementById("area02").style.display = "inline";
                    document.getElementById("send_email").innerText = document.wForm.to.value;
                    document.getElementById("send_name").innerText  = document.wForm.toname.value;
                   // alert("발송되었습니다.");
                } else if( v == "0" ) {
                    alert("가입된 메일정보가 없습니다.");
                } else {
                    alert("메일서버 오류 관리자에게 문의하세요.");
                }
            }
        );
    }
    return false;
}

function 아이디비밀번호찾기팝업(tr) {
	var win = UI.openWindow('/service/inc/common/member_findid_popup.php', 450, 250,'w_findid_mail',{scrollbars:'no'}).focus();
	return false;
}
//-->
</script>
<?
//require(SERVICE_DIR . "/inc/top.inc"); // footer
?>
<!-- <a href=# onclick="return 아이디비밀번호찾기팝업();">아이디비밀번호찾기팝업</a>  -->
<form name="wForm" method="post" onsubmit="return 아이디비밀번호찾기실행();">
<div id=area01>
<table border="0" cellpadding="0" cellspacing="0" id="popup" width="400" align="center">
    <tr>
        <td  class="top"><img src='/images/pop_idpass.jpg'> </td>
    </tr>
    <tr>
        <td ><br>아이디,비밀번호를 확인하시려면 아래 빈칸에 본인의 이름과 <br>가입시 등록한 이메일주소를 입력하십시오. </td>
    </tr>
</table><br>
	<table border="0" cellpadding="0" cellspacing="0"  width="300" align="center">
		<tr>
            <td width="100"  height="30px" >이름</td>
        <td><input type="text" name="toname" style="width:200px" class="required alert focus" message="가입시 등록한 이름을 입력해주세요."/><td>
      </tr>
	   <tr>
        <td height="30px" >이메일</td>
        <td><input type="text" name="to" style="width:200px" class="required alert focus email" message="이메일 주소를 입력해주세요."/><td>
      </tr>
	  <tr>
         <td  colspan="2">&nbsp;</td>
		 </tr>
	  <tr>
         <td  colspan="2" align="center">
 	<input type=image src="/images/btn_search02.jpg" />&nbsp;
	<a href="#" title="닫기"   onclick="self.close();"><img src="/images/btn_close.jpg" width="80"  height="25" /></a>
		</td>
		 </tr>
    </table><br><br>
</div>
<span id=area02 style="display:none">
 	<table border="0" cellpadding="0" cellspacing="0" id="popup" width="400" align="center">
	  <tr>
	    <td  class="top"><img src='/images/pop_idpass.jpg'> </td>
	  </tr>
	</table><br>
	<table border="0" cellpadding="0" cellspacing="0"  width="300" align="center">
	  <tr>
	    <td height="30px"  align="center">가입시 입력한 이메일(<B><span id=send_email></span></B>)로<BR>아이디와 비밀번호가 전송되었습니다. <br><strong>이름 : <span id=send_name></span> 님</strong></td>
	 </tr>
	  <tr>
	    <td>&nbsp; </td>
	 </tr>
	<tr>
	<td align="center"> &nbsp;
	<a href="#" title="닫기"   onclick="self.close();"><img src="/images/btn_close.jpg" width="80"  height="25" /></a></td>
	</tr>
	</table><br><br>
</span>
</form>
<?
require(SERVICE_DIR . "/inc/inner_footer.inc"); // footer
?>