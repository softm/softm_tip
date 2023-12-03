<?
$print_no = $tot - $s + 2;
$sql  = "select * from $tb_poll_master ";
$sql .= $where;

if ( $sort == 'no' || $sort == 'title' ) {
    if ( $desc == 'desc' ) {
        $sql .= " order by $sort desc";
    } else {
        $sql .= " order by $sort";
    }
} else {
    $sql .= " order by no desc";
}

$sql .= " limit " . ( $s - 1 ) . ", " . $how_many;

$stmt = multiRowSQLQuery($sql);

while ( $row = multiRowFetch  ($stmt) ) {
    $print_no--;
?>

                    <tr> 
                      <td bgcolor="F7F7F7" width="50" height="20" align="center"> 
                        <input type="checkbox" name="chk_no[]" value="<?=$row['no']?>">
                      </td>
                      <td bgcolor="F7F7F7" width="50" align="center" class="text_01"><?=$print_no?></td>
                      <td bgcolor="F7F7F7">
                      &nbsp;&nbsp
<?
$urlStr  = '?poll_id='           . $row['no'          ];
$urlStr .= '&poll_exec=poll'                           ;
?>
						<a href="dpoll.php<?=$urlStr?>" target='_devent<?=$row['no']?>'>
                        <?=$row['title']?>
                        </a>

                      </td>
                      <td bgcolor="F7F7F7" align="center" class="text_03"><a href="#" onClick="moveItemSetupPage  (<?=$row['no']?>);return false;">설정</a></td>
                      <td bgcolor="F7F7F7" align="center" class="text_03"><a href="#" onClick="moveItemGrantPage  (<?=$row['no']?>);return false;">설정</a></td>
                      <td bgcolor="F7F7F7" align="center" class="text_03"><a href="#" onClick="deleteData(<?=$row['no']?>);return false;">삭제</a></td>
                    </tr>
<?
} // while END
?>