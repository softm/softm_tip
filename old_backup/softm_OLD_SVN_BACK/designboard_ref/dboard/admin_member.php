<?
include 'common/member_lib.inc'; // 멤버 라이브러리
include 'common/lib.inc'       ; // 공통 라이브러리
include 'common/message.inc'   ; // 에러 페이지 처리

$branch   = ( !$branch ) ? "list" : $branch;
if ( $branch == 'list' ) {
    if ( !$HTTP_POST_VARS['how_many'] ) {
        $how_many = $HTTP_COOKIE_VARS["member_many"]; // 쿠키 읽어 오기
    } else {
        if ( $how_many ) { setcookie ("member_many", $how_many, mktime() + 60*60*24*365,"/"); } // $how_many 값이 있으면
    }
}

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "N" ) {
    logs ( '관리자 아님' );
    //redirectPage ("admin.php");     // 페이지 이동
    head("어드민_멤버관리");        // Header 출력
    _css ($skinDir); // css 설정
    Message ('U', '0003', 'MOVE:admin.php:이동');
} else {
    logs ( '관리자 입니다.' );
    head("어드민_멤버관리", "member_OnLoad();");        // Header 출력
    _css ($skinDir); // css 설정
	include 'common/js/common_js.php'; // 공통 javascript
	include 'common/js/admin_member_js.php'; // 어드민 member javascript
?>
<SCRIPT LANGUAGE='javascript'>
<!--
    function member_OnLoad() {
        var branch = '<?=$branch?>';
        if ( branch == 'list' ) {
//            alert ('');
            var searchGb = '<?=$search_gb?>';
            objectSelected (document.memberForm.search_gb, searchGb ); 
        } else if ( branch == 'loginsetup' ) {
            exploerInitial ();
            displayModeToggle();
            enabledPopUp();
            document.loginAbstractForm.suc_mode.selectedIndex = sucModeSelectedIndex;
            sucModeChange();
            abstractSource ();
        } else if ( branch == 'formsetup' ) {
            hintEssentialCond();
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
    include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
    // 데이터베이스에 접속합니다.
    $db = initDBConnection ();

    $package = 'member';
    if ( $branch == 'list' ) {
        include ( 'admin/admin_member_list.php'     ); // 회원 관리 조회
    } else if ( $branch == 'write' ) {
        include ( 'admin/admin_member_write.php'    ); // 회원 정보 수정
    } else if ( $branch == 'kind' )  {
        include ( 'admin/admin_member_kind.php'     ); // 회원 종류 설정
    } else if ( $branch == 'formsetup' )  {
        include ( 'admin/admin_member_formsetup.php'); // 회원 가입폼 설정
//  } else if ( $branch == 'nl_write' ) {
//      include ( 'admin/admin_member_nl_write.php' ); // 뉴스 레터 입력
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_member_exec.php'     ); // 게시판 입력
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