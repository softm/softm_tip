<?
// 관리자
$row = singleRowSQLQuery("select member_level, member_nm, etc, point from $tb_member_kind where member_level = 99;");
$member_level = $row['member_level' ];
$member_nm    = $row['member_nm'    ];
$etc          = $row['etc'          ];
$point        = $row['point'        ];
$reg_date     = $row['reg_date'     ];
$print_no = $tot + 2;
$idx=1;
?>
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>">
    <input type='hidden' name='update_yn[]'     value="N"                 >
                                <tr> 
                                  <td height="20" bgcolor="F7F7F7" align="center"> 
                                    <input type="checkbox" name="chk_no[]" value="<?=$member_level?>" onClick='return false;' disabled>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=$member_level?></td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="member_nm[]" style="width:90%" value="<?=$member_nm?>" onChange='updateToggle(<?=$idx?>);'>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="etc[]" style="width:95%" value='<?=$etc?>' onChange='updateToggle(<?=$idx?>);'>
                                  </td>

                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="point[]" maxlength='10' style="width:90%;text-align:right" value='<?=$point?>' onChange='return updateToggle(<?=$idx?>);'>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">삭제</td>
                                </tr>
<?
// 비회원
$row = singleRowSQLQuery("select member_level, member_nm, etc, point from $tb_member_kind where member_level = 0;");
$member_level = $row['member_level' ];
$member_nm    = $row['member_nm'    ];
$etc          = $row['etc'          ];
$point        = $row['point'        ];
$reg_date     = $row['reg_date'     ];
$print_no = $tot + 1;
$idx=2;
?>
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>">
    <input type='hidden' name='update_yn[]'     value="N"                 >
                                <tr> 
                                  <td height="20" bgcolor="F7F7F7" align="center"> 
                                    <input type="checkbox" name="chk_no[]" value="<?=$member_level?>" onClick='return false;' disabled>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=$member_level?></td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="member_nm[]" style="width:90%" value="<?=$member_nm?>" onChange='updateToggle(<?=$idx?>);'>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="etc[]" style="width:95%" value='<?=$etc?>' onChange='updateToggle(<?=$idx?>);'>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="point[]" maxlength='10' style="width:90%;text-align:right" value='<?=$point?>' onChange='updateToggle(<?=$idx?>);'>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">삭제</td>
                                </tr>
<?
$print_no = $tot + 1;

$sql  = "select member_level, member_nm, etc, point from $tb_member_kind";
$sql .= ' where member_level != 99 && member_level != 0 ';
$sql .= ' order by member_level';
$stmt = multiRowSQLQuery($sql);

while ( $row = multiRowFetch  ($stmt) ) {
    $print_no--;
    $member_level = $row['member_level' ];
    $member_nm    = $row['member_nm'    ];
    $etc          = $row['etc'          ];
    $point        = $row['point'        ];
    $reg_date     = $row['reg_date'     ];
    $idx++;
?>
    <input type='hidden' name='member_level[]'  value="<?=$member_level?>">
    <input type='hidden' name='update_yn[]'     value="N"                 >
                                <tr> 
                                  <td height="20" bgcolor="F7F7F7" align="center"> 
<?if ( $member_level != 1 ) {?>
                                    <input type="checkbox" name="chk_no[]" value="<?=$member_level?>">
<?} else {?>
                                    <input type="checkbox" name="chk_no[]" value="<?=$member_level?>" onClick='return false;' disabled>
<?}?>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_01" align="center"><?=$member_level?></td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="member_nm[]" style="width:90%" value="<?=$member_nm?>"  onChange='updateToggle(<?=$idx?>);'>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="etc[]" style="width:95%" value='<?=addslashes($etc)?>' onChange='updateToggle(<?=$idx?>);'>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03">&nbsp;&nbsp; 
                                    <input type="text" name="point[]" maxlength='10' style="width:90%;text-align:right" value='<?=$point?>' onChange='updateToggle(<?=$idx?>);'>
                                  </td>
                                  <td bgcolor="F7F7F7" class="text_03" align="center">
<?if ( $member_level != 1 ) {?>
                                  <a href="javascript:deleteData('<?=$member_level?>');">삭제</a>
<?} else {?>
                                    삭제
<?}?>

                                  </td>
                                </tr>
<?
} // while END
?>