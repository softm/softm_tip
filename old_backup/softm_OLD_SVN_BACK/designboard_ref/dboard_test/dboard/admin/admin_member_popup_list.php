<?
$baseDir = '../';
include $baseDir. 'common/lib.inc'          ; // ���� ���̺귯��
include $baseDir. 'common/member_lib.inc'   ; // ��� ���̺귯��
include $baseDir. 'common/db_connect.inc'   ; // Data Base ���� Ŭ����
include $baseDir. "common/message.inc"      ; // ���� ������ ó��

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
if ( $memInfor['admin_yn'] == "Y" ) {
?>
<html>
<head>
<title>�ο�� �˻�</title>
<link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>
<?
// �����ͺ��̽��� �����մϴ�.
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
    <td colspan='10' height="40" bgcolor="#FFFFFF" class="text_01">&nbsp;&nbsp;&nbsp;<B>ȸ�� �˻�</B> : �� <span class='text_04'><?=$tot?>��</span> �˻� �Ǿ����ϴ�.</td>
  </tr>

  <tr> 
    <td width="40" bgcolor="#FFFFFF" class="text_01" align="center"><b><a href="#">��ȣ</a></b></td>
    <td bgcolor="#FFFFFF" class="text_04" align="center" width="120"><b><a href="#"><font color="BF0909">�̸�</font></a></b></td>
    <td width="120" bgcolor="#FFFFFF" class="text_01" align="center"><b><a href="#">���̵�</a></b></td>
    <td width="250" bgcolor="#FFFFFF" class="text_01" align="center"><b><a href="#">�̸���</a></b></td>
    <td width="50" bgcolor="#FFFFFF" class="text_01" align="center"><b>����</b></td>
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
closeDBConnection (); // �����ͺ��̽� ���� ���� ����
} else {
}
?>