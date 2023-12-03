<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( "common/lib.inc"          ); // 공통 라이브러리
include ( "common/message.inc"      ); // 에러 페이지 처리

if ( $config ) {
    $memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
    if ( $memInfor['admin_yn'] == "Y" ) {
        $retunPage ="admin_setup.php";
        redirectPage($retunPage); // 로그인후 복귀
    } else {
        head("DB세팅화면_관리자로그인");          // Header 출력
        css(); // css 출력
        $id = $_COOKIE["setup_id"];
		include 'common/js/common_js.php'; // 공통 javascript
		include 'common/js/login_js.php'; // 로그인 javascript
?>
<script type="text/javascript">
<!--
function inStrAllBlankCheck (argu) {
	if ( typeof ( argu ) == "object" ) argu = argu.value;
	var ch1="";
	for (var i=0;i<argu.length;i++) ch1 += " ";
	if ( argu == ch1 ) return true;
	else return false;
}
//-->
</SCRIPT>
</head>
<body onLoad='document.loginForm.user_id.focus();'>
    <form name='loginForm' action="login_ok.php" method='POST' onsubmit='return loginFormSubmit(this);'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
      <tr>
        <td align="center">
          <table width="400" border="0" cellspacing="0" cellpadding="0">
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
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td> <img src="images/logo2.gif" width="321" height="44"></td>
                        </tr>
                        <tr>
                          <td height="5"></td>
                        </tr>
                      </table>
                      <table width="100%" border="0" cellspacing="0" cellpadding="5">
                        <tr bgcolor="fafafa">
                          <td colspan="2" align="right" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td width="100" align="right" class="text_01"><b>아이디</b></td>
                          <td>
                            <input type="text" name="user_id" value='<?=$id?>'>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" class="text_01"><b>비밀번호</b></td>
                          <td>
                            <input type="password" name="password">
                          </td>
                        </tr>
                        <tr bgcolor="fafafa">
                          <td align="right" colspan="2" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
                        </tr>
                      </table>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td height="10" align="right"> <input type='image' src="images/button_alogin.gif" width="79" height="30">
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
          </table>
        </td>
      </tr>
    </table>
    </form>
<?
        footer(); // Footer 출력
    }
} // if END
else {
	head("DB세팅화면_관리자로그인");          // Header 출력
	css (); // css 출력
	MessageExit("U", "0002", "MOVE:setup.php:설치 ..");
} // else END
?>