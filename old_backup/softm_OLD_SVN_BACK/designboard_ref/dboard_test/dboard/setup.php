<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
/*****************************************************************/
/* 함수명: setUpDir1                                             */
/* 설치 디렉토리를 구합니다.                                     */
/*****************************************************************/
function setUpDir1 () {
    global $_SERVER;
    // (_ _);
    $_rtn = $_SERVER["SCRIPT_FILENAME"];
    $_rtn = str_replace("\\","/",$_rtn);
    $endP = strrpos($_rtn,'/') + 1;
    $_rtn = substr($_rtn, 0, $endP);
//    echo '<font color="red">' . $_rtn . '</font><BR>';
    return $_rtn;
}

$setupDir = setUpDir1 ();
include ( "common/lib.inc"          ); // 공통 라이브러리
include ( "common/message.inc"      ); // 에러 페이지 처리
include ( "common/message_table.inc"); // 에러 메시지
$onloadScript = "";
if ( $config ) {
//  redirectPage("setup2.php");
    head("DB세팅화면_SQLDB세팅");                                                // Header 출력
    css ();
    MessageExit("U", "0001");
} else {
    if ( !is_writeable ( './' ) ) {
        head("DB세팅화면_SQLDB세팅");          // Header 출력
        css ();
        MessageExit('U', '0006',"");
    } else {
        session_save_path("data/session");
        session_set_cookie_params(0, '/');
        @session_cache_limiter('');
        @session_start  ();
        @session_destroy();
        head("DB세팅화면_SQLDB세팅");          // Header 출력
        css ();
//         $onloadScript = "document.setupForm.host_nm.focus();";
		include 'common/js/common_js.php'; // 공통 javascript
?>
<script type='text/javascript'>
<!--
	window.onload=function() {
		document.setupForm.host_nm.focus();
		getObject('progress_bar').style.visibility="hidden";
	}
var doubleTrans = false; // 두번 폼이 전송되지 않도록 처리.

    function setupForm_Sumbit() {
        if ( doubleTrans ) { return false; }
        if ( inStrAllBlankCheck (document.setupForm.host_nm.value) ) {
            alert ("Host Name을 입력해주세요.");
            document.setupForm.host_nm.focus();
            return false;
        }
        if ( inStrAllBlankCheck (document.setupForm.db_nm.value) ) {
            alert ("DB Name을 입력해주세요.");
            document.setupForm.db_nm.focus();
            return false;
        }

        if ( inStrAllBlankCheck (document.setupForm.id.value) ) {
            alert ("ID를 입력해주세요.");
            document.setupForm.id.focus();
            return false;
        }

        installProgress();
        doubleTrans = true;
        return true;
    }

    function inStrAllBlankCheck (argu) {
        if ( typeof ( argu ) == "object" ) argu = argu.value;
        var ch1="";
        for (var i=0;i<argu.length;i++) ch1 += " ";
        if ( argu == ch1 ) return true;
        else return false;
    }

    function installProgress() {
        var x = parseInt(document.body.clientWidth ) / 2 + parseInt(document.body.scrollLeft) - ( 300 / 2 );
        var y = parseInt(document.body.clientHeight) / 2 + parseInt(document.body.scrollTop ) - ( 120 / 2 );
        var progressObj = getObject('progress_bar');
        objectMoveTo( progressObj, x,y);
        objectShow  ( progressObj     );
    }

    function objectMoveTo(id,X,Y, tier) {
        var obj = null;
        if ( typeof(id) == 'object' ) obj = id;
        else obj = getObject(id, tier);
        if ( obj != null && typeof(obj) == 'object' ) {
                          obj.style.left = X;
            if ( Y != 0 ) obj.style.top  = Y;
        }
    }

    function objectShow( id, tier ) {
        var obj = null;
        if ( typeof(id) == 'object' ) obj = id;
        else obj = getObject(id, tier);
        if ( obj != null && typeof(obj) == 'object' ) obj.style.visibility="visible"
/*        obj.style.zIndex=0;     Object들의 기본적인 zIndex 값은 0 입니다. */
    }
//-->
</SCRIPT>
<?
body('onload="'.$onloadScript."'");
?>
<!--------------------- 추가중
    ■ DesignBoard 회원 가입 안내

1. Designboard.net 은 홈페이지를 구축하기 위한 게시판 및 기타 솔루션을 다운받을수 있고 자유롭게 커뮤니케이션을 할수 있습니다.

2. 회원가입을 하셔야 다운로드및 글쓰기가 가능합니다.

3. 회원가입시 받는 회원정보에 관하여 관리자는 비밀을 유지할 책임이 있으며 다른 목적으로 이용하지 않습니다.

4. 회원가입시 받는 주민등록번호는 중복가입 방지를 위함이며, 암호화 되어 저장되므로 관리자 및 그 어느 누구도 알 수 없습니다.

5. 회원이 ID와 비밀번호를 사용하여 발생하는 모든 결과에 대한 책임은 회원본인에게 있습니다.

6. 디자인보드 홈페이지에 상식에 어긋나는 액션을 취하는 회원에 대해서는 제재를 가할 수 있습니다.

7. 회원은 원할때 탈퇴할 수 있으며 탈퇴와 동시에 모든 정보는 영구히 삭제되며 재가입이 가능합니다. (탈퇴는 개인정보 수정에서 하실 수 있습니다.)

8. 디자인보드 가입 및 사용은 디자인보드 라이센스 및 디자인보드의 정책에 동의함을 전제로 합니다.

9. 디자인보드를 사용함에 있어서 피해는 회원 본인에게 있으며 디자인보드는 그 책임을 지지 않습니다. (물론 도와드릴수는 있습니다. ^_^)

10.  디자인보드를 찾아주신 모든 분들께 감사드립니다. ^___________^ /
-------------------------------->
<!--    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>
          <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
            <tr>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_01.gif" width="17" height="17"></td>
              <td background="<?=$baseDir?>images/join_bg01.gif">&nbsp;</td>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_02.gif" width="17" height="17"></td>
            </tr>
            <tr>
              <td background="<?=$baseDir?>images/join_bg02.gif">&nbsp;</td>
              <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td>
                            <textarea name="textarea4" class="textarea_03" style="width:100%" rows="10">
    <?=_htmlspecialchars ($memForm['agreement_content'], ENT_QUOTES);?>
                            </textarea>
                          </td>
                        </tr>
                        <tr>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td class="text_01">
                            <input type="checkbox" name="agree_chk" value="Y">
                            위의 온라인 회원 약관에 동의합니다.</td>
                        </tr>
                        <tr>
                          <td height="10"></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
              <td background="<?=$baseDir?>images/join_bg03.gif">&nbsp;</td>
            </tr>
            <tr>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
              <td background="<?=$baseDir?>images/join_bg04.gif"></td>
              <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
--------------------- 추가중 -------------------------------->
<form name='setupForm' action="setup_ok.php" method='POST' onsubmit='return setupForm_Sumbit();'>
    <input type="hidden" name="driver"     value="MYSQL">

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
                      <td>
                        <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" class="text_01">
                          <tr bgcolor="#FFFFFF">
                            <td colspan="2" height="30" align="center">
                              <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                <tr>
                                  <td width="10" bgcolor="F7F7F7"></td>
                                  <td bgcolor="F7F7F7" class="text_01">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                      <tr>
                                        <td><b>디자인보드 <?=$_dboard_ver?> - [ DB Setting ]</b></td>
                                      </tr>
                                      <tr>
                                        <td height="5"></td>
                                      </tr>
                                      <tr>
                                        <td><font color="BF0909">데이터베이스를 세팅합니다.<br>
                                          DB 설정정보는 해당 서버관리자에게 문의하시기 바랍니다.</font></td>
                                      </tr>
                                    </table>

                                  </td>
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
                      <td width="100" align="right" class="text_01"><b>Host Name</b></td>
                      <td>
                        <input type="text" name="host_nm" value="localhost">
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" class="text_01"><b>DB Name</b></td>
                      <td>
                        <input type="text" name="db_nm" value="">
                      </td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" class="text_01"><b>ID</b></td>
                      <td>
                        <input type="text" name="id" value="">
                      </td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" colspan="2" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
                    </tr>
                    <tr bgcolor="fafafa">
                      <td align="right" class="text_01"><b>Password</b></td>
                      <td>
                        <input type="password" name="password" value="">
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
                      <td height="10" align="right"> <input type='image' src="images/button_ss.gif" width="79" height="30">
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
<img id='progress_bar' style='visibility:hidden;position:absolute;left:0px;top:0px;z-index:1' src='images/install_progress.gif'>
</form>
<?
    }
}
    footer(); // Footer 출력
?>
