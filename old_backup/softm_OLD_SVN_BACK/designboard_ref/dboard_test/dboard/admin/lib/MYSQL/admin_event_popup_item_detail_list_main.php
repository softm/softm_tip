                        <table width="100%" border="0" cellspacing="1" cellpadding="3">
                          <tr>
                            <td><strong>세부항목추가</strong>
                              <input type="text" name="detail_item_name<?=$g_no?>" size="36">
                              <a href='#' onClick='detailInsert(<?=$g_no?>);'><img border="0" src="../images/button_bplus.gif" width="43" height="20" align="top"></a>
                            </td>
                          </tr>
                          <tr>
                            <td height="5"></td>
                          </tr>
                        </table>

                        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="CCCCCC">
<?
$scripts = '';
if ( $item == 3 ) { // 목록 상자
    $scripts = '<select name="_dboard_item' . $g_no . '[]">' . "\n";
} else if ( $item == 4 ) { // 멀티 목록 상자
    $scripts = '<select name="_dboard_item' . $g_no . '[]">' . "\n";
}

$print_no = $tot - $s + 2;
$sql  = "select no, g_no, seq, o_seq, item, item_name from $tb_event_item";
$where  = " where no   = '$event_id'";
$where .= " and   g_no = '$g_no'"    ;
$where .= " and   seq  <> '0'";
$sql .= $where;
$sql .= ' order by o_seq asc';
$stmt_detail = multiRowSQLQuery($sql);

$detailCnt = 0;

while ( $row_detail = multiRowFetch  ($stmt_detail) ) {
    $i++;
    $detailCnt++;
    $no         = $row_detail['no'         ];
    $g_no       = $row_detail['g_no'       ];
    $seq        = $row_detail['seq'        ];
    $o_seq      = $row_detail['o_seq'      ];
    $item_name  = $row_detail['item_name'  ];

    if ( $item == 1 ) {
       $scripts .= '<input type="radio" name="_dboard_item' . $g_no . '[]" value="' . $seq . '">' . $item_name . "\n";
    } else if ( $item == 2 ) {
       $scripts .= '<input type="checkbox" name="_dboard_item' . $g_no . '[]" value="' . $seq . '">' . $item_name. "\n";
    } else if ( $item == 3 ) {
       $scripts .= '<option value="' . $seq . '">'. $item_name .'</option>'. "\n";
    } else if ( $item == 4 ) {
       $scripts .= '<option value="' . $seq . '">'. $item_name .'</option>'. "\n";
    } else if ( $item == 5 ) {
       $scripts .= '<input type="text" name="_dboard_item' . $g_no . '[]" value="">' . $item_name. "\n";
    } else if ( $item == 6 ) {
       $scripts .= '<textarea type="text" name="_dboard_item' . $g_no . '[]"></textarea>'. "\n";
    } else if ( $item == 7 ) {
       $scripts .= '<input type="password" name="_dboard_item' . $g_no . '[]" value="">' . $item_name. "\n";
    }
?>
    <input type="hidden" name="item[]"      value="">
    <input type="hidden" name="g_no[]"      value="<?=$g_no?>">
    <input type="hidden" name="seq[]"       value="<?=$seq?>" >
                          <tr>
                            <td width="30" align="center" bgcolor="#FFFFFF">
<?
                    if ( strlen ( $o_seq ) == 1 ) {
                        echo '0' . $o_seq;
                    } else {
                        echo $o_seq;
                    }

?>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp; <input name="item_name[]" type="text" value='<?=$item_name?>' size="37"></td>
                            <td width="54" align="center" bgcolor="#FFFFFF">
                            <a href='<?=$libDir?>admin_event_popup_item_exec.php?gubun=order&event_id=<?=$event_id?>&g_no=<?=$g_no?>&seq=<?=$seq?>&o_seq=<?=$o_seq?>&arrow=up'  >
                            <img src="../images/button_up.gif" width="21" height="20" border='0'></a>
                            <a href='<?=$libDir?>admin_event_popup_item_exec.php?gubun=order&event_id=<?=$event_id?>&g_no=<?=$g_no?>&seq=<?=$seq?>&o_seq=<?=$o_seq?>&arrow=down'>
                              <img src="../images/button_down.gif" width="21" height="20" border='0'></a></td>
                            <td width="50" align="center" bgcolor="#FFFFFF"><a href='<?=$libDir?>admin_event_popup_item_exec.php?gubun=detail_delete&event_id=<?=$event_id?>&g_no=<?=$g_no?>&seq=<?=$seq?>&o_seq=<?=$o_seq?>'><img src="../images/button_del.gif" width="43" height="20" align="absmiddle" border='0'></a></td>
                          </tr>

<?
} // while END

if ( $item == 3 || $item == 4 ) { // 목록 상자, 멀티 목록 상자
    $scripts .= '</select>';
}
?>
                        </table>
                        <table width="100%" border="0" cellspacing="1" cellpadding="3">
                          <tr>
                            <td height="10"></td>
                          </tr>
                          <tr>
                            <td><strong>삽입태그 </strong>(복사하신후 디자인만 수정해서 사용하세요.)</td>
                          </tr>
                          <tr>
                            <td height="5"></td>
                          </tr>
                          <tr>
                            <td>
<textarea name="textarea" rows="7" style='width:100%'>
<?
$scripts = _htmlspecialchars ( $scripts, ENT_QUOTES );
echo $scripts;
?>
</textarea>
                            </td>
                          </tr>
                          <tr>
                            <td align="right"><a href='#' onClick='detailUpdate(<?=$g_no?>,<?=$detailCnt?>);return false;'><img type='image' src="../images/button_c_modify.gif" border='0'></a></td>
                          </tr>
                        </table>