<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( "common/lib.inc"          ); // 공통 라이브러리
include ( "common/message.inc"      ); // 에러 페이지 처리

if ( !$config ) {
    MessageHead('U', '0012', 'MOVE:setup.php:이동');
}

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "N" ) {
    logs ( '관리자 아님' );
    //redirectPage ("admin.php");     // 페이지 이동
    head("디자인보드 삭제");        // Header 출력
	css(); // css 출력
    MessageExit('U', '0003', 'MOVE:admin.php:돌아가기');
} else {
    logs ( '관리자 입니다.',FALSE);
    head("디자인보드 삭제");        // Header 출력
	css(); // css 출력
	include $baseDir.'common/js/common_js.php'; // 공통 javascript
?>

<script type='text/javascript'>
<!--
    function setupForm_Sumbit() {
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
        if ( confirm('디보드 삭제후 복구가 불가능하며 재설치 하실 수 있습니다.\n디보드를 삭제하시겠습니까?') ) {
            return true;
        } else {
            return false;
        }
    }
//-->
</SCRIPT>
</head>
<body>
<form name='setupForm' action="uninstall_ok.php" method='POST' onsubmit='return setupForm_Sumbit();'>
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
                                        <td><b>디자인보드 <?=$_dboard_ver?> - [ 디자인보드 삭제 ]</b></td>
                                      </tr>
                                      <tr>
                                        <td height="5"></td>
                                      </tr>
                                      <tr>
                                        <td><font color="BF0909">디자인 보드 게시판, 설문, 회원 정보 모두가 삭제 됩니다.<br>
                              설치전 단계로 초기화 되며 다시 설치 하실 수 있습니다</font></td>
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
                        <input type="text" name="host_nm" value="">
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
                      <td height="10" align="right"> <input type='image' src="images/button_uninstall.gif" width="79" height="30">
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
?>
