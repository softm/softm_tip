<?
$print_no = $tot - $s + 2;

$sql  = "select * from $tb_bbs_category" . "_" . $bbs_id;
$sql .= $where;

$sql .= ' order by o_seq asc';

$stmt = multiRowSQLQuery($sql);
$print_no = 0;
while ( $row = multiRowFetch  ($stmt) ) {
    $print_no++;
    $no     = $row['no'    ];
    $o_seq  = $row['o_seq' ];
    $name   = $row['name'  ];
    $etc    = $row['etc'   ];
?>
              <tr bgcolor="fafafa"> 
                <td width="20" align="center" class="text_01">
                <input type="hidden" name="no[]" value="<?=$no?>">
<?
//    echo $o_seq;

                    if ( strlen ( $o_seq ) == 1 ) {
                        echo '0' . $o_seq;
                    } else {
                        echo $o_seq;
                    }

?>
                </td>
                <td> <input type="text" name="name[]" style="width:100%" value='<?=$name?>'></td>
                <td width="47"><a href='<?=$libDir?>admin_board_category_exec.php?gubun=order&bbs_id=<?=$bbs_id?>&no=<?=$no?>&o_seq=<?=$o_seq?>&arrow=up'  ><img src="../images/button_up.gif" width="21" height="20" border='0'></a>
                <a href='<?=$libDir?>admin_board_category_exec.php?gubun=order&bbs_id=<?=$bbs_id?>&no=<?=$no?>&o_seq=<?=$o_seq?>&arrow=down'><img src="../images/button_down.gif" width="21" height="20" border='0'></a></td>
                <td width="43"><a href='<?=$libDir?>admin_board_category_exec.php?gubun=delete&bbs_id=<?=$bbs_id?>&no=<?=$no?>&o_seq=<?=$o_seq?>'><img src="../images/button_del.gif" width="43" height="20" align="absmiddle" border='0'></a></td>
              </tr>

              <tr> 
                <td align="right" class="text_01" colspan="4" height="1" bgcolor="fafafa" background="images/bg2.gif"></td>
              </tr>
<?
} // while END
?>