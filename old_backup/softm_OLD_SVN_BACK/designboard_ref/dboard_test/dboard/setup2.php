<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( "common/lib.inc"          ); // 공통 라이브러리
include ( 'common/message.inc'      ); // 에러 페이지 처리
include ( "common/db_connect.inc"   ); // Data Base 연결 클래스

head("DB세팅화면_관리계정세팅");       // Header 출력
css();
if ( !$config ) {
   Message("U", "0002", "MOVE:setup.php:이동");
} else {
    if ( $_SESSION['_s_setup_ok'] == '1' ) {
        include 'common/js/common_js.php'; // 공통 javascript
?>


<script type='text/javascript'>
<!--
    function inStrAllBlankCheck (argu) {
        if ( typeof ( argu ) == "object" ) argu = argu.value;
        var ch1="";
        for (var i=0;i<argu.length;i++) ch1 += " ";
        if ( argu == ch1 ) return true;
        else return false;
    }

    function setupForm_Sumbit() {
        if ( inStrAllBlankCheck (document.setupForm.id.value) ) {
            alert ("ID를 입력해주세요.");
            document.setupForm.id.focus();
            return false;
        }

        if ( inStrAllBlankCheck (document.setupForm.password.value) ) {
            alert ("Password를 입력해주세요.");
            document.setupForm.password.focus();
            return false;
        }
        return true;
    }
//-->
</SCRIPT>
<?
body();
?>
<form name='setupForm' action="setup2_ok.php" method='POST' onsubmit='return setupForm_Sumbit();'>
    <input type="hidden" name="driver"     value="MYSQL">

<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center">
<span class="text_04"><B>+ 디자인보드 설치가 성공적으로 완료 되었습니다. +</B></span><BR><BR>
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
                      <td>
                        <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" class="text_01">
                          <tr bgcolor="#FFFFFF">
                            <td colspan="2" height="30" align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                <tr bgcolor="F7F7F7">
                                  <td width="10"></td>
                                  <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                      <tr>
                                        <td><b>디자인보드 <?=$_dboard_ver?> - [ Admin Setting ]</b></td>
                                      </tr>
                                      <tr>
                                        <td height="5"></td>
                                      </tr>
                                      <tr>
                                        <td class="text_04">
                                          본 화면에서는 관리자 아이디를 생성합니다.<br>
                                          세팅하시는 아이디와 비밀번호를 꼭 기억하시기 바랍니다.
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                                <tr bgcolor="F7F7F7">
                                  <td colspan='2'>※ 관리자 아이디를 지금 생성하지 않으시면 재설치 해야 합니다.</td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
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
                        <input type="text" name="id" value="admin">
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
                      <td height="10" align="right"> <input type='image' src="images/button_next.gif" width="79" height="30">
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
    } else {
        Message('S', '0003',"");
    }
} // else END
footer(); // Footer 출력
?>