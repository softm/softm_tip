<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( 'common/lib.inc'          ); // 공통 라이브러리
include ( 'common/message.inc'      ); // 에러 페이지 처리
include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스

// 데이터베이스에 접속합니다.
$db   = initDBConnection (); // 데이터베이스에 접속합니다.

$memInfor = getMemInfor();      // 세션에 저장되어있는 회원정보를 읽음
$login_yn = $memInfor['login_yn']; // 로그인 여부

if ( $login_yn == 'Y') {
    head('회원 탈퇴');  // Header 출력
    css();
?>
<style>
body {margin:0px 0px 0px 0px;overflow:hidden}
</style>
<?
    echo ( "\n<script type='text/javascript'>\n" );
    echo ( " var exec = '".$exec ."';\n" );
    echo ( " var id   = '".$id   ."';\n" );
    echo ( " var no   = '".$no   ."';\n" );
    echo ( " var npop = '".$npop ."';\n" );
    echo ( "</SCRIPT>\n" );
?>

<table width="400" border="0" cellspacing="0" cellpadding="0">
    <form name='memberRegForm' method='post' action='<?=$baseDir?>member_register_exec.php' onSubmit='if( confirm("탈퇴 하시겠습니까?") ) return true; else return false;'>
        <input type='hidden' name='mexec' value='secession'>
        <input type='hidden' name='succ_url' value='<?=$succ_url?>'>
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
          <td class="text_01">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
              <tr>
                <td><font color="BF0909">+</font> <b>회원탈퇴신청</b></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="fafafa">
                <td align="right" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td class="text_01">회원탈퇴 신청시 즉시 처리되며 회원정보는 모두 삭제되고 바로 다른 아이디로
                  재가입이 가능합니다. <br>
                  회원탈퇴를 하시겠습니까?<br>
                  탈퇴신청을 하시게되면 취소는 불가능하니 신중해 결정해주시기 바랍니다.</td>
              </tr>
              <tr bgcolor="fafafa">
                <td align="right" height="1" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td height="10" align="right"><input type='image' src="<?=$baseDir?>images/button_secession.gif" width="66" height="30">
                  <a href='#' onClick='self.close();return false;'><img src="<?=$baseDir?>images/button_close.gif" width="66" height="30" border='0'></a></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td background="<?=$baseDir?>images/join_bg03.gif"></td>
  </tr>
  <tr>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
    <td background="<?=$baseDir?>images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
  </tr>
    </form>
</table>

<?
    closeDBConnection (); // 데이터베이스 연결 설정 해제
    footer(); // Footer 출력
} else {
    echo ( "<script type='text/javascript'>\n");
    echo ( "<!--\n");
    echo ( "    function windowClose() {\n");
    echo ( "        if ( typeof( opener ) == 'object' ) {\n");
    echo ( "            self.close();\n");
    echo ( "        } else {\n");
    echo ( "            history.back();\n");
    echo ( "        }\n");
    echo ( "    }\n");
    echo ( "//-->\n");
    echo ( "</SCRIPT>\n");
    Message('P', '0012',"javascript:windowClose();:확인", $skinDir); // 회원 정보가 존재하지 않습니다.
}
?>

