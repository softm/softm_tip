<?
include 'common/board_lib.inc' ; // 게시판 라이브러리
include 'common/member_lib.inc'; // 멤버 라이브러리
include 'common/lib.inc'       ; // 공통 라이브러리
include 'common/message.inc'   ; // 에러 페이지 처리

$branch   = ( !$branch ) ? "list" : $branch;

if ( !$HTTP_POST_VARS['how_many'] ) {
    $how_many = $HTTP_COOKIE_VARS["board_" .$branch . "_many"]; // 쿠키 읽어 오기
} else {
    if ( $how_many ) { setcookie ("board_" .$branch . "_many", $how_many, mktime() + 60*60*24*365,"/"); } // $how_many 값이 있으면
}

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
// 데이터베이스에 접속합니다.
$db = initDBConnection ();

$section_manager = simpleSQLQuery("select operator_id from $tb_bbs_infor where no = '$no'");
// echo 'section_manager : ' . $section_manager . ' / ' . $memInfor[user_id];
if ( strpos($section_manager, $memInfor[user_id] . '\'') ) {
	$bbs_operator = 'Y';
	// 부운영자 페이지로 이동.

    logs ( '관리자 아님' );
    //redirectPage ("admin.php");     // 페이지 이동
    head("어드민_게시판관리");        // Header 출력
    _css ($skinDir); // css 설정
    Message ('U', '0003', 'MOVE:admin.php:돌아가기');
} else if ( $memInfor['admin_yn'] == "Y" ) {
    logs ( '관리자 입니다.',FALSE);
    head("어드민_게시판관리","board_OnLoad();");        // Header 출력
    _css ($skinDir); // css 설정
	include 'common/js/common_js.php'; // 공통 javascript
	include 'common/js/admin_board_js.php'; // 어드민 board javascript
?>
<SCRIPT LANGUAGE='javascript'>
<!--
    function board_OnLoad() {
        var branch = '<?=$branch?>';
        if ( branch == 'setup' ) {
//          exploerInitial ();
//          abstractSource ();

            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT
            headerDocument.dataForm.header.value = document.boardSetupForm.header.value;
            footerDocument.dataForm.footer.value = document.boardSetupForm.footer.value;
            loginSkinEnabled();
        } else if ( branch == 'abstract' ) {
            exploerInitial ();
            abstractSource ();
            displayContentInputButton();
            toggleNoticeContent();
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT
            headerDocument.dataForm.header.value = document.boardAbstractForm.header.value;
            footerDocument.dataForm.footer.value = document.boardAbstractForm.footer.value;
        }
    }
//-->
</SCRIPT>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr> 
    <td valign="top" height="122"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="70"> 
<?
    include ( 'admin_top.php' ); // 왼쪽 메뉴
?>
          </td>
        </tr>
        <tr> 
          <td height="1" bgcolor="003A43"></td>
        </tr>
        <tr>
          <td height="40" bgcolor="015966"> </td>
        </tr>
        <tr> 
          <td height="1" bgcolor="003A43"></td>
        </tr>
        <tr> 
          <td height="10"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td valign="top" class="unnamed1"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr>
          <td width="200" bgcolor="F5F5F5" valign="top"> 
<?
    include ( 'admin_left_menu.php'          ); // 왼쪽 메뉴
?>
          </td>
          <td bgcolor="F7F7F7" valign="top"> 
<?
    $package = 'board';
    if ( $branch == 'list' ) {
        include ( 'admin/admin_board_list.php'         ); // 게시판 관리 조회
    } else if ( $branch == 'setup' ) {
        include ( 'admin/admin_board_setup.php'        ); // 게시판 관리 설정
    } else if ( $branch == 'grant' ) {
        include ( 'admin/admin_board_grant.php'        ); // 게시판 권한 관리
    } else if ( $branch == 'abstract' ) {
        include ( 'admin/admin_board_abstract.php'     ); // 게시판물 추출
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_board_exec.php'         ); // 게시판 입력
    }
?>
          </td>
        </tr>
      </table>
      </td>
    </tr>
  </table>
<?
    footer(); // Footer 출력
} else {
    logs ( '관리자 아님' );
    //redirectPage ("admin.php");     // 페이지 이동
    head("어드민_게시판관리");        // Header 출력
    Message ('U', '0003', 'MOVE:admin.php:돌아가기');
}
closeDBConnection (); // db disconnect
?>