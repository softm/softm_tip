<?
// 관리자
$sql  = "select a.no no, a.member_level member_level,";
$sql .= " a.grant_poll grant_poll, a.grant_poll_result grant_poll_result, a.grant_write grant_write,";
$sql .= " b.member_nm member_nm";
$sql .= " from $tb_poll_grant a , $tb_member_kind b";
$sql .= " where a.no           = $poll_id";
$sql .= " and   a.member_level = b.member_level";
$sql .= " and   a.member_level = 99;";

$row = singleRowSQLQuery($sql);

$member_level       = $row['member_level'       ];
$grant_poll         = $row['grant_poll'         ];
$grant_poll_result  = $row['grant_poll_result'  ];
$grant_write        = $row['grant_write'        ];
$member_nm          = $row['member_nm'          ];

$grant_character_image = $grantCharStr[$member_level];

$print_no = $tot + 2;
$idx=1;
?>
    <input type="hidden" name="grant[]">
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>">
    <input type="hidden" name='update_yn[]'     value="N"                 >
                                <tr>
                                  <td height="20" bgcolor="F7F7F7" align="center">
                                    <input type="checkbox" name="chk_no[]" value="<?=$member_level?>" onClick='return false;' checked disabled>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp;<?=$member_nm?></td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<a href="#" onClick="var win = window.open('admin/admin_poll_popup_point_grant_list.php?poll_id=<?=$poll_id?>&member_level=<?=$member_level?>','point_win','scrollbars=yes,top=40,left=95,width=420,height=228');win.focus();return false;">설정</a>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_poll[]" value="<?=$grant_poll?>" onClick='return false;'checked disabled>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_poll_result[]" value="<?=$grant_poll_result?>" onClick='return false;' checked disabled>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_write[]" value="<?=$grant_write?>" onClick='return false;' checked disabled>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">

<?
$checked = '';
if ( $grant_character_image == '1' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_character_image[]" value="<?=$grant_character_image?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>
                                </tr>

<?
// 비회원
$sql  = "select a.no no, a.member_level member_level,";
$sql .= " a.grant_poll grant_poll, a.grant_poll_result grant_poll_result, a.grant_write grant_write,";
$sql .= " b.member_nm member_nm";
$sql .= " from $tb_poll_grant a , $tb_member_kind b";
$sql .= " where a.no           = $poll_id";
$sql .= " and   a.member_level = b.member_level";
$sql .= " and   a.member_level = 0;";
$row = singleRowSQLQuery($sql);

$member_level       = $row['member_level'       ];
$grant_poll         = $row['grant_poll'         ];
$grant_poll_result  = $row['grant_poll_result'  ];
$grant_write        = $row['grant_write'        ];
$member_nm          = $row['member_nm'          ];

$grant_character_image = $grantCharStr[$member_level];

$print_no = $tot + 1;
$idx=2;
?>
    <input type="hidden" name="grant[]">
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>">
    <input type="hidden" name='update_yn[]'     value="N"                 >
                                <tr>
                                  <td height="20" bgcolor="F7F7F7" align="center">
<?
$checked = '';
if ( $grant_poll == 'Y' && $grant_poll_result == 'Y' && $grant_write == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="chk_no[]" value="<?=$member_level?>" <?=$checked?> onClick="checkedToggle('<?=$idx?>');">
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp;<?=$member_nm?></td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
-
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_poll == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_poll[]" value="<?=$grant_poll?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_poll_result == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_poll_result[]" value="<?=$grant_poll_result?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_write == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_write[]" value="<?=$grant_write?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_character_image[]" value="<?=$grant_character_image?>" onClick='return false;' disabled>
                                  </td>
                                </tr>
<?
$print_no = $tot + 1;
$sql  = "select a.no no, a.member_level member_level,";
$sql .= " a.grant_poll grant_poll, a.grant_poll_result grant_poll_result, a.grant_write grant_write,";
$sql .= " b.member_nm member_nm";
$sql .= " from $tb_poll_grant a , $tb_member_kind b";
$sql .= " where a.no           = $poll_id";
$sql .= " and   a.member_level = b.member_level";
$sql .= ' and   a.member_level != 99 && a.member_level != 0 ';
$sql .= ' order by a.member_level ';
$stmt = multiRowSQLQuery($sql);

while ( $row = multiRowFetch  ($stmt) ) {
    $print_no--;
    $member_level       = $row['member_level'       ];
    $grant_poll         = $row['grant_poll'         ];
    $grant_poll_result  = $row['grant_poll_result'  ];
    $grant_write        = $row['grant_write'        ];
    $member_nm          = $row['member_nm'          ];

    $grant_character_image = $grantCharStr[$member_level];

    $idx++;
?>
    <input type="hidden" name="grant[]">
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>">
    <input type="hidden" name='update_yn[]'     value="N"                 >
<?
$checked = '';
if ( $grant_poll == 'Y' && $grant_poll_result == 'Y' && $grant_write == 'Y' && $grant_character_image == '1' ) $checked = 'checked';
?>
                                <tr>
                                  <td height="20" bgcolor="F7F7F7" align="center">
                                    <input type="checkbox" name="chk_no[]" value="<?=$member_level?>" <?=$checked?> onClick="checkedToggle('<?=$idx?>');">
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp;<?=$member_nm?></td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<a href="#" onClick="var win = window.open('admin/admin_poll_popup_point_grant_list.php?poll_id=<?=$poll_id?>&member_level=<?=$member_level?>','point_win','scrollbars=yes,top=40,left=95,width=420,height=228');win.focus();return false;">설정</a>
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_poll == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_poll[]" value="<?=$grant_poll?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_poll_result == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_poll_result[]" value="<?=$grant_poll_result?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_write == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_write[]" value="<?=$grant_write?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>


                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_character_image == '1' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_character_image[]" value="<?=$grant_character_image?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>
                                </tr>
<?
} // while END
?>