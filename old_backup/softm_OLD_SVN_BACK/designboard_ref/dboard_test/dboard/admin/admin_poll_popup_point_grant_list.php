<?
$baseDir = '../';
include $baseDir . 'common/poll_lib.inc'  ; // 설문 라이브러리
include $baseDir . 'common/member_lib.inc'; // 멤버 라이브러리
include $baseDir . 'common/lib.inc'       ; // 공통 라이브러리
include $baseDir . 'common/db_connect.inc'; // Data Base 연결 클래스
include $baseDir . 'common/message.inc'   ; // 에러 페이지 처리

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
if ( $memInfor['admin_yn'] == "Y" ) {
?>
<html>
<head>
<title>포인트 설정</title>
<link rel="stylesheet" href="<?=$baseDir?>style.css" type="text/css">
<?
	include $baseDir.'common/js/common_js.php'; // 공통 javascript
	include $baseDir.'common/js/admin_poll_js.php'; // 어드민 poll javascript
?>
<script type='text/javascript'>
<!--
    function checkedToggle() {
        var tmp_use_st = document.pointSetupForm [ "tmp_use_st[]" ];
        for ( var i=1; i<tmp_use_st.length; i++ ) {
            if ( tmp_use_st[i].checked ) { 
                tmp_use_st[i].checked = false;
            } else {
                tmp_use_st[i].checked = true;
            }
        }
    }

    function formCheck() {
        var tmp_use_st = document.pointSetupForm [ "tmp_use_st[]" ];
        var use_st     = document.pointSetupForm [ "use_st[]"     ];
        for ( var i=1; i<tmp_use_st.length; i++ ) {
            if ( tmp_use_st[i].checked ) { 
                use_st[i].value   = '1' ;
            } else {
                use_st[i].value   = '2' ;
            }
        }
        return true;
    }
//-->
</SCRIPT>
</head>
<body>
<?
// 데이터베이스에 접속합니다.
$db = initDBConnection ();
$libDir = $baseDir . "admin/lib/" . $sysInfor['driver'] . '/';

    if ( !$how_many ) {
        $how_many = 10;
    } else {
        $how_many = (int)$how_many;
    }
    $page_many= 10;
    $s = ( !$s ) ? 1 : $s;

    $pointInfor = array("","설문투표", "의견글");

    // 회원 종류별명 조회
    if ( $member_level != 'all' ) {
        $sql = "select member_nm from $tb_member_kind where member_level = '$member_level'";
    //  echo $sql;
        $member_nm = simpleSQLQuery($sql);
    } else {
        $member_nm = '전체';
    }

    // 설문 조사명 조회
    $sql = "select title from $tb_poll_master where no = '$poll_id'";
    $poll_nm = simpleSQLQuery($sql);

?>
<table width="400" border="0" cellspacing="0" cellpadding="0">
<form name='pointSetupForm' action='<?=$libDir?>admin_poll_popup_point_grant_exec.php' onSubmit='return formCheck();'>
<input type='hidden' name='member_level' value='<?=$member_level?>'>
<input type='hidden' name='poll_id'      value='<?=$poll_id?>'     >
<input type='hidden' name='gubun'        value='point_grant_update'>
<input type="hidden" name="no[]"    >
<input type="hidden" name="tmp_use_st[]">
<input type="hidden" name="use_st[]">
<input type="hidden" name="point[]" >
  <tr> 
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_01.gif" width="17" height="17"></td>
    <td background="<?=$baseDir?>images/join_bg01.gif"></td>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_02.gif" width="17" height="17"></td>
  </tr>
  <tr> 
    <td background="<?=$baseDir?>images/join_bg02.gif"></td>
    <td> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td class="text_01"> <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
              <tr> 
                <td><font color="BF0909">+</font> <b><?=$member_nm?> 포인트 설정 [ <?=$poll_nm?> ]<br>
                  </b></td>
              </tr>
              <tr> 
                <td height="5"></td>
              </tr>
              <tr> 
                <td background="<?=$baseDir?>images/bg2.gif" class="bg_line2" height="1"></td>
              </tr>
              <tr> 
                <td height="5"></td>
              </tr>
              <tr> 
                <td>
<?
    if ( $member_level != 'all' ) {
        echo "현재 해당하는 회원종류의 포인트를 설정 하실 수 있습니다.";
    } else {
        echo "전체 회원 종류의 포인트가 한번에 변경됩니다.";
    }
?>
                </td>
              </tr>
              <tr> 
                <td align="right" height="5"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="eeeeee"> 
                <td align="center" class="text_01"><strong>포인트 종류</strong></td>
                <td align="center"><a href='#' onClick='checkedToggle();return false;'>사용</a></td>
                <td>포인트 점수</td>
              </tr>

<?
    include $libDir . "admin_poll_popup_point_grant_list_main.php";
?>

              <tr> 
                <td height="1" colspan="3" align="center" background="<?=$baseDir?>images/bg2.gif" class="bg_line2" bgcolor="fafafa" class="text_01"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td height="10"></td>
              </tr>
              <tr> 
                <td height="10" align="right"> <input type='image' src="<?=$baseDir?>images/button_ok2.gif" width="66" height="30"> 
                  <a href='#' onClick='window.close();return false;'><img src="<?=$baseDir?>images/button_close.gif" width="66" height="30" border='0'></a></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
    <td background="<?=$baseDir?>images/join_bg03.gif"></td>
  </tr>
  <tr> 
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
    <td background="<?=$baseDir?>images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
  </tr>
</form>
</table>
</body>
</html>
<?
closeDBConnection (); // 데이터베이스 연결 설정 해제
} else {
}
?>