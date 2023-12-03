<?
$baseDir = '../';
include $baseDir. 'common/lib.inc'          ; // 공통 라이브러리
include $baseDir. 'common/member_lib.inc'   ; // 멤버 라이브러리
include $baseDir. 'common/db_connect.inc'   ; // Data Base 연결 클래스
include $baseDir. "common/message.inc"      ; // 에러 페이지 처리

$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음
if ( $memInfor['admin_yn'] == "Y" ) {
?>
<html>
<head>
<title>부운영자 검색</title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
<?
// 데이터베이스에 접속합니다.
$db = initDBConnection ();
$libDir = "../admin/lib/" . $sysInfor['driver'] . '/';

    if ( !$how_many ) {
        $how_many = 10;
    } else {
        $how_many = (int)$how_many;
    }
    $page_many= 10;
    $s = ( !$s ) ? 1 : $s;
?>

<?
//  if ( $s >= $how_many + 1 ) { $cur_many = $more_many; } else { $cur_many = $how_many; }

    $sql  = "select count(user_id) from $tb_member ";
    $where  = " where user_id != ''";
    $where .= " and   member_level != '99' ";

    $operator_id = stripslashes($operator_id);

    if ( $operator_id ) {
        $where .= " and user_id not in ( $operator_id )";
    }

    if ( $search_gb ) {
        $where .= " and $search_gb LIKE '" . $search . "%'";
    }


    $sql .= $where;
//  logs ( '$sql : '. $sql . '<BR>' , true);
    if ( !$tot ) { $tot = simpleSQLQuery($sql); }
?>
<table border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC">
  <tr> 
    <td colspan='10' height="40" bgcolor="#FFFFFF" class="text_01">&nbsp;&nbsp;&nbsp;<B>회원 검색</B> : 총 <span class='text_04'><?=$tot?>명</span> 검색 되었습니다.</td>
  </tr>

  <tr> 
    <td width="40" bgcolor="#FFFFFF" class="text_01" align="center"><b><a href="#">번호</a></b></td>
    <td bgcolor="#FFFFFF" class="text_04" align="center" width="120"><b><a href="#"><font color="BF0909">이름</font></a></b></td>
    <td width="120" bgcolor="#FFFFFF" class="text_01" align="center"><b><a href="#">아이디</a></b></td>
    <td width="250" bgcolor="#FFFFFF" class="text_01" align="center"><b><a href="#">이메일</a></b></td>
    <td width="50" bgcolor="#FFFFFF" class="text_01" align="center"><b>선택</b></td>
  </tr>
<?
    if ( $s > $tot ) {
        if ( $p_exec == "delete" ) { $s = $s - $how_many; if ( $s < 0 ) $s = 1; }
        else                       { $s = 1; }
    }

    include $libDir . "admin_member_popup_list_main.php";
?>

</table>
</body>
</html>
<?
closeDBConnection (); // 데이터베이스 연결 설정 해제
} else {
}
?>