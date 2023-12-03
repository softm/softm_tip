<?
$allSame = false;
if ( $member_level == 'all' ) {
    $sql = "select count(distinct concat(no,'-',point,'-',use_st)) from $tb_point_infor where bbs_id = '$bbs_id'";
    $cnt1 = simpleSQLQuery($sql);
// echo $sql . '<BR>';

    if ( $cnt1 == 5 ) {
        $allSame = true;
//      echo '모두 같음';
    }
}

$sql  = "select no, member_level, use_st, point, etc, reg_date from $tb_point_infor";
if ( $member_level == 'all' && $allSame ) {
    $where  = " where member_level = '99'";
    $where .= " and   bbs_id       = '$bbs_id'"      ;
} else {
    $where  = " where member_level = '$member_level'";
    $where .= " and   bbs_id       = '$bbs_id'"      ;
}
$sql .= $where;
$stmt = multiRowSQLQuery($sql);
while ( $row = multiRowFetch  ($stmt) ) {
    $no                = $row['no'          ];
    $key         [$no] = $row['key'         ];
    $member_level[$no] = $row['member_level'];
    $use_st      [$no] = $row['use_st'      ];
    $point       [$no] = $row['point'       ];
    $etc         [$no] = $row['etc'         ];
}

while (list ( $key, $val ) = each ($pointInfor) ) {
    if  ( $val ) {
?>
              <tr>
                <td height="1" colspan="3" align="center" background="images/bg2.gif" class="bg_line2" bgcolor="fafafa" class="text_01"></td>
              </tr>
              <tr>
                <td width="100" align="center" bgcolor="fafafa" class="text_01"><?=$val?></td>
                <td width="30" align="center" bgcolor="fafafa">
<?
        $checked = ( $use_st[$key] == '1' || ( $member_level == 'all' && !$allSame ) ) ? "checked" : "";
?>
                <input type="checkbox"  name="tmp_use_st[]" value="1" <?=$checked?>>
                <input type="hidden"    name="use_st[]"     value=""         >
                <input type='hidden'    name="no[]"         value="<?=$key?>">
                </td>
                <td bgcolor="fafafa">
<?
    if ( !$point[$key] && $point[$key] != '0' ) { $pointVal = "1"; } else { $pointVal = $point[$key]; }
?>
                <input name="point[]" type="text" size="15" value="<?=$pointVal?>" style='text-align:right' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };'>포인트</td>
              </tr>
<?
    }
}
?>
