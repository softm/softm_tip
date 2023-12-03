<?
include 'common/poll_lib.inc'  ; // 설문 라이브러리
include 'common/member_lib.inc'; // 멤버 라이브러리
include 'common/lib.inc'       ; // 공통 라이브러리
include 'common/message.inc'   ; // 에러 페이지 처리

$branch   = ( !$branch ) ? "list" : $branch;
if ( $branch == 'list' ) {
    if ( !$HTTP_POST_VARS['how_many'] ) {
        $how_many = $HTTP_COOKIE_VARS["poll_many"]; // 쿠키 읽어 오기
    } else {
        if ( $how_many ) { setcookie ("poll_many", $how_many, mktime() + 60*60*24*365,"/"); } // $how_many 값이 있으면
    }
}

$memInfor = getMemInfor(); // 세션에 저장되어있는 설문정보를 읽음

if ( $memInfor['admin_yn'] == "N" ) {
    logs ( '관리자 아님.',FALSE);
    //redirectPage ("admin.php");     // 페이지 이동
    head("어드민_설문조사관리");      // Header 출력
    _css ($skinDir); // css 설정
    Message ('U', '0003', 'MOVE:admin.php:돌아가기');

} else {
    logs ( '관리자 입니다.',FALSE);
    head("어드민_설문조사관리","poll_OnLoad();");        // Header 출력
    _css ($skinDir); // css 설정
	include 'common/js/common_js.php'; // 공통 javascript
	include 'common/js/admin_poll_js.php'; // 어드민 poll javascript
?>

<SCRIPT LANGUAGE='javascript'>
<!--
    function poll_OnLoad() {
        var branch = '<?=$branch?>';
        if ( branch == 'itemsetup' ) {
            exploerInitial ();
            abstractSource ();
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT
    //      headerDocument.body.innerHTML = document.boardSetupForm.header.value;
    //      footerDocument.body.innerHTML = document.boardSetupForm.footer.value;
            headerDocument.dataForm.header.value = document.pollItemSetupForm.header.value;
            footerDocument.dataForm.footer.value = document.pollItemSetupForm.footer.value;
            sucUrlToggle();
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
          <td height="40" bgcolor="015966"></td>
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
          <td bgcolor="FAFAFA" valign="top"> 
<?
    $branch   = ( !$branch ) ? "list" : $branch;
    include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
    // 데이터베이스에 접속합니다.
    $db = initDBConnection ();

    $package = 'poll';
    if ( $branch == 'list' ) {
        include ( 'admin/admin_poll_list.php'       ); // 설문 관리 조회
    } else if ( $branch == 'itemsetup' ) {
        include ( 'admin/admin_poll_itemsetup.php'  ); // 설문 항목 설정
    } else if ( $branch == 'grant' ) {
        include ( 'admin/admin_poll_grant.php'      ); // 설문 권한 설정
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_poll_exec.php'       ); // 설문 조사 관련 실행
    }
    closeDBConnection (); // 데이터베이스 연결 설정 해제
?>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
    footer(); // Footer 출력
}// else END
?>
