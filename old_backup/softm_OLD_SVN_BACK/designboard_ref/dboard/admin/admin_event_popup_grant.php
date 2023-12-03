<?
$baseDir = '../';
include $baseDir . 'common/event_lib.inc' ; // 이벤트 라이브러리
include $baseDir . 'common/member_lib.inc'; // 멤버 라이브러리
include $baseDir . 'common/lib.inc'       ; // 공통 라이브러리
include $baseDir . 'common/db_connect.inc'; // Data Base 연결 클래스
include $baseDir . 'common/message.inc'   ; // 에러 페이지 처리

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
if ( $memInfor['member_level'] == 99 ) {
    $libDir = $baseDir . "admin/lib/" . $sysInfor['driver'] . '/';
?>
<html>
<head>
<title>어드민 이벤트 권한 및 포인트 설정</title>
<meta http-equiv="Content-Type" content="text/html; charset=euc-kr">
<link rel="stylesheet" href="<?=$baseDir?>style.css" type="text/css">
<?
	include $baseDir.'common/js/common_js.php'; // 공통 javascript
	include $baseDir.'common/js/admin_event_js.php'; // 어드민 poll javascript
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var libDir = '<?=$libDir?>';
//-->
</SCRIPT>
<SCRIPT LANGUAGE='javascript'>
<!--
    function updateData() {
        document.eventGrantForm.target = '';
        document.eventGrantForm.gubun.value  = 'grant_update';
        document.eventGrantForm.action = libDir + 'admin_event_popup_grant_exec.php';
        return true;
    }

    function changeData (idx) {
        var updateYn                = document.eventGrantForm ["update_yn[]"    ];
        var grant_join              = document.eventGrantForm ["grant_join[]"   ];
        var grant                   = document.eventGrantForm ["grant[]"        ];
        grant[idx].value = '';

        if ( grant_join             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }

        updateYn[idx].value = 'Y';
    }
//-->
</SCRIPT>
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<?
// 데이터베이스에 접속합니다.
$db = initDBConnection ();
?>
<table width="400" border="0" cellspacing="0" cellpadding="0">
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
                <td><font color="BF0909">+</font> <b>포인트 설정<br>
                  </b></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td background="<?=$baseDir?>images/bg2.gif" height="1"></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td>현재 해당하는 회원종류의 포인트를 설정 하실 수 있습니다.</td>
              </tr>
              <tr>
                <td align="right" height="5"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td height="1" colspan="3" align="right" background="<?=$baseDir?>images/bg2.gif" bgcolor="fafafa" class="text_01"></td>
              </tr>
              <tr bgcolor="eeeeee">
                <td align="center" class="text_01"><strong>회원종류</strong></td>
                <td align="center">참가</td>
                <td>포인트 점수</td>
              </tr>
<form name='eventGrantForm' method='post' onSubmit='return updateData();'>
    <input type='hidden' name='event_id'        value='<?=$event_id?>'>
    <input type='hidden' name='gubun'           value=''>
    <input type='hidden' name='update_yn[]'     value="">
    <input type="hidden" name='grant[]'         value="">
    <input type="hidden" name="grant_join[]"    value="">
    <input type="hidden" name="join_point[]"    value="">
    <input type="hidden" name="member_level[]"  value="">
<?
    include $libDir . "admin_event_popup_grant_list_main.php";
?>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td height="10" align="right">
                  <input type='image' src="<?=$baseDir?>images/button_ok2.gif" width="66" height="30" border='0'>
                  <a href='#' onClick='self.close();return false;'><img src="<?=$baseDir?>images/button_close.gif" width="66" height="30" border='0'></a></td>
              </tr>
            </table></td>
        </tr>
</form>
      </table>
    </td>
    <td background="<?=$baseDir?>images/join_bg03.gif"></td>
  </tr>
  <tr>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
    <td background="<?=$baseDir?>images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
  </tr>
</table>
</body>
</html>
<?
closeDBConnection (); // 데이터베이스 연결 설정 해제
} else {
}
?>