<?
// 관리자
$sql  = "select a.no no, a.member_level member_level,";
$sql .= " a.grant_join grant_join, a.join_point join_point,";
$sql .= " b.member_nm member_nm";
$sql .= " from $tb_event_grant a , $tb_member_kind b";
$sql .= " where a.no           = $event_id";
$sql .= " and   a.member_level = b.member_level";
$sql .= " and   a.member_level = 99;";
$row = singleRowSQLQuery($sql);

$member_level = $row['member_level' ];
$grant_join   = $row['grant_join'   ];
$join_point   = $row['join_point'   ];
$member_nm    = $row['member_nm'    ];
$idx=1;
?>
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>"  >
    <input type="hidden" name='update_yn[]'     value="N"                   >
    <input type="hidden" name='grant[]'         value=""                    >
              <tr>
                <td height="1" colspan="3" align="center" background="../images/bg2.gif" bgcolor="fafafa" class="text_01"></td>
              </tr>
              <tr>
                <td width="100" align="center" bgcolor="fafafa" class="text_01"><?=$member_nm?></td>
<?
$checked = '';
if ( $grant_join == 'Y' ) $checked = 'checked';
?>
                <td width="30" align="center" bgcolor="fafafa"><input type="checkbox" name="grant_join[]" value="Y" <?=$checked?> onClick='changeData (<?=$idx?>);'>
                </td>
                <td bgcolor="fafafa"><input name="join_point[]" type="text" size="15" value='<?=$join_point?>' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };changeData (<?=$idx?>);' maxlength='10'>
                  포인트 </td>
              </tr>
<?
$sql  = "select a.no no, a.member_level member_level,";
$sql .= " a.grant_join grant_join, a.join_point join_point,";
$sql .= " b.member_nm member_nm";
$sql .= " from $tb_event_grant a , $tb_member_kind b";
$sql .= " where a.no           = $event_id";
$sql .= " and   a.member_level = b.member_level";
$sql .= ' and   a.member_level != 99 && a.member_level != 0 ';
$sql .= ' order by a.member_level ';
$stmt = multiRowSQLQuery($sql);

while ( $row = multiRowFetch  ($stmt) ) {
    $member_level = $row['member_level' ];
    $grant_join   = $row['grant_join'   ];
    $join_point   = $row['join_point'   ];
    $member_nm    = $row['member_nm'    ];
    $idx++;
?>
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>"  >
    <input type="hidden" name='update_yn[]'     value="N"                   >
    <input type="hidden" name='grant[]'         value=""                    >
              <tr>
                <td height="1" colspan="3" align="center" background="../images/bg2.gif" bgcolor="fafafa" class="text_01"></td>
              </tr>
              <tr>
                <td width="100" align="center" bgcolor="fafafa" class="text_01"><?=$member_nm?></td>
<?
$checked = '';
if ( $grant_join == 'Y' ) $checked = 'checked';
?>
                <td width="30" align="center" bgcolor="fafafa"><input type="checkbox" name="grant_join[]" value="Y" <?=$checked?> onClick='changeData (<?=$idx?>);'>
                </td>
                <td bgcolor="fafafa"><input name="join_point[]" type="text" size="15" value='<?=$join_point?>' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };changeData (<?=$idx?>);' maxlength='10'>
                  포인트 </td>
              </tr>

<?
} // while END
?>