<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include 'common/event_lib.inc' ; // 게시판 라이브러리
include 'common/member_lib.inc'; // 멤버 라이브러리
include 'common/lib.inc'       ; // 공통 라이브러리
include 'common/message.inc'   ; // 에러 페이지 처리

$branch   = ( !$branch ) ? "list" : $branch;
if ( !$_POST['how_many'] ) {
    $how_many = $_COOKIE["event_" .$branch . "_many"]; // 쿠키 읽어 오기
} else {
    if ( $how_many ) { setcookie ("event_" .$branch . "_many", $how_many, time() + 60*60*24*365,"/"); } // $how_many 값이 있으면
}

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "N" ) {
    logs ( '관리자 아님' );
    //redirectPage ("admin.php");     // 페이지 이동
    head("어드민_이벤트관리");        // Header 출력
    css ($skinDir); // css 설정
    MessageExit('U', '0003', 'MOVE:admin.php:돌아가기');
} else {
    logs ( '관리자 입니다.',FALSE);
    head("어드민_이벤트관리");        // Header 출력
    css ($skinDir); // css 설정
	include 'common/js/common_js.php'; // 공통 javascript
	include 'common/js/admin_event_js.php'; // 어드민 event javascript
?>


<script type='text/javascript'>
<!--
    function event_OnLoad() {
        var branch = '<?=$branch?>';
        if ( branch == 'setup' ) {
            exploerInitial ();
            abstractSource ();
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            headerDocument.dataForm.header.value = document.eventSetupForm.header.value;
            enabledPopUp();
            loginSkinEnabled();
        } else if ( branch == 'result_write' ) {
            passwordEnabled();
        }
    }
//-->
</SCRIPT>
</head>
<body onLoad='event_OnLoad();'>
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
    include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
    // 데이터베이스에 접속합니다.
	$db = initDBConnection (); // db connect

    $package = 'event';
    if ( $branch == 'list' ) {
        include ( 'admin/admin_event_list.php'         ); // 이벤트 관리 조회
    } else if ( $branch == 'setup' ) {
        include ( 'admin/admin_event_setup.php'        ); // 이벤트 관리 설정
    } else if ( $branch == 'result' ) {
        include ( 'admin/admin_event_result.php'       ); // 이벤트 결과
    } else if ( $branch == 'result_write' ) {
        include ( 'admin/admin_event_result_write.php' ); // 이벤트 결과 보기
    } else if ( $branch == 'exec' ) {
        include ( 'admin/admin_event_exec.php'         ); // 이벤트 입력
    }
    closeDBConnection (); // db disconnect
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