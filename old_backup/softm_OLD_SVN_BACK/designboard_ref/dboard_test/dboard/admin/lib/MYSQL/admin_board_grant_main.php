<?
// 관리자
$sql  = "select a.no no, a.member_level member_level,";
$sql .= " a.grant_list grant_list, a.grant_view grant_view, a.grant_write grant_write,";
$sql .= " a.grant_answer grant_answer, a.grant_comment grant_comment, a.grant_down grant_down,";
$sql .= " b.member_nm member_nm";
$sql .= " from $tb_bbs_grant a , $tb_member_kind b";
$sql .= " where a.no           = $no";
$sql .= " and   a.member_level = b.member_level";
$sql .= " and   a.member_level = 99;";
$row = singleRowSQLQuery($sql);

$bbs_no       = $row['no'           ];
$member_level = $row['member_level' ];
$grant_list   = $row['grant_list'   ];
$grant_view   = $row['grant_view'   ];
$grant_write  = $row['grant_write'  ];
$grant_answer = $row['grant_answer' ];
$grant_comment= $row['grant_comment'];
$grant_down   = $row['grant_down'   ];
$member_nm    = $row['member_nm'    ];

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
<a href="#" onClick="var win = window.open('admin/admin_board_popup_point_grant_list.php?bbs_id=<?=$bbs_id?>&member_level=<?=$member_level?>','point_win','scrollbars=yes,top=40,left=95,width=420,height=325');win.focus();return false;">설정</a>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_list[]" value="<?=$grant_list?>" onClick='return false;'checked disabled>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_view[]" value="<?=$grant_view?>" onClick='return false;' checked disabled>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_write[]" value="<?=$grant_write?>" onClick='return false;' checked disabled>
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_answer[]" value="<?=$grant_answer?>" onClick='return false;' checked disabled>
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_comment[]" value="<?=$grant_comment?>" onClick='return false;' checked disabled>
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_down[]" value="<?=$grant_down?>" onClick='return false;' checked disabled>
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_character_image[]" value="<?=$grant_character_image?>" onClick='return false;' checked disabled>
                                  </td>
                                </tr>

<?
// 비회원
$sql  = "select a.no no, a.member_level member_level,";
$sql .= " a.grant_list grant_list, a.grant_view grant_view, a.grant_write grant_write,";
$sql .= " a.grant_answer grant_answer, a.grant_comment grant_comment, a.grant_down grant_down,";
$sql .= " b.member_nm member_nm";
$sql .= " from $tb_bbs_grant a , $tb_member_kind b";
$sql .= " where a.no           = $no";
$sql .= " and   a.member_level = b.member_level";
$sql .= " and   a.member_level = 0;";
$row = singleRowSQLQuery($sql);

$bbs_no       = $row['no'           ];
$member_level = $row['member_level' ];
$grant_list   = $row['grant_list'   ];
$grant_view   = $row['grant_view'   ];
$grant_write  = $row['grant_write'  ];
$grant_answer = $row['grant_answer' ];
$grant_comment= $row['grant_comment'];
$grant_down   = $row['grant_down'   ];
$member_nm    = $row['member_nm'    ];
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
if ( $grant_list == 'Y' && $grant_view == 'Y' && $grant_write == 'Y' && $grant_answer == 'Y' && $grant_comment == 'Y' && $grant_down == 'Y' ) $checked = 'checked';
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
if ( $grant_list == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_list[]" value="<?=$grant_list?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_view == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_view[]" value="<?=$grant_view?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
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
if ( $grant_answer == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_answer[]" value="<?=$grant_answer?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_comment == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_comment[]" value="<?=$grant_comment?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_down == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_down[]" value="<?=$grant_down?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
                                    <input type="checkbox" name="grant_character_image[]" value="<?=$grant_character_image?>" onClick='return false;' disabled>
                                  </td>
                                </tr>
<?
$print_no = $tot + 1;
$sql  = "select a.no no, a.member_level member_level,";
$sql .= " a.grant_list grant_list, a.grant_view grant_view, a.grant_write grant_write,";
$sql .= " a.grant_answer grant_answer, a.grant_comment grant_comment, a.grant_down grant_down,";
$sql .= " b.member_nm member_nm";
$sql .= " from $tb_bbs_grant a , $tb_member_kind b";
$sql .= " where a.no           = $no";
$sql .= " and   a.member_level = b.member_level";
$sql .= ' and   a.member_level != 99 && a.member_level != 0 ';
$sql .= ' order by a.member_level ';
$stmt = multiRowSQLQuery($sql);

while ( $row = multiRowFetch  ($stmt) ) {
    $print_no--;
    $bbs_no       = $row['no'           ];
    $member_level = $row['member_level' ];
    $grant_list   = $row['grant_list'   ];
    $grant_view   = $row['grant_view'   ];
    $grant_write  = $row['grant_write'  ];
    $grant_answer = $row['grant_answer' ];
    $grant_comment= $row['grant_comment'];
    $grant_down   = $row['grant_down'   ];
    $member_nm    = $row['member_nm'    ];

    $grant_character_image = $grantCharStr[$member_level];

    $idx++;
?>
    <input type="hidden" name="grant[]">
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>">
    <input type="hidden" name='update_yn[]'     value="N"                 >
<?
$checked = '';
if ( $grant_list == 'Y' && $grant_view == 'Y' && $grant_write == 'Y' && $grant_answer == 'Y' && $grant_comment == 'Y' && $grant_down == 'Y' && $grant_character_image == '1' ) $checked = 'checked';
?>
                                <tr>
                                  <td height="20" bgcolor="F7F7F7" align="center">
                                    <input type="checkbox" name="chk_no[]" value="<?=$member_level?>" <?=$checked?> onClick="checkedToggle('<?=$idx?>');">
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp;<?=$member_nm?></td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<a href="#" onClick="var win = window.open('admin/admin_board_popup_point_grant_list.php?bbs_id=<?=$bbs_id?>&member_level=<?=$member_level?>','point_win','scrollbars=yes,top=40,left=95,width=420,height=325');win.focus();return false;">설정</a>
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_list == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_list[]" value="<?=$grant_list?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_view == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_view[]" value="<?=$grant_view?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
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
if ( $grant_answer == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_answer[]" value="<?=$grant_answer?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_comment == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_comment[]" value="<?=$grant_comment?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?
$checked = '';
if ( $grant_down == 'Y' ) $checked = 'checked';
?>
                                    <input type="checkbox" name="grant_down[]" value="<?=$grant_down?>" <?=$checked?>  onClick="allCheckedToggle('<?=$idx?>');">
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