<?
$print_no = $tot - $s + 2;

$sql  = "select no event_id, title from $tb_event ";

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
                    <tr align="center">
                      <td height="20" bgcolor="F7F7F7" align="center"> 
                        <input type="checkbox" name="chk_no[]" value="<?=$row['event_id']?>">
                      </td>
                      <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center">
<b>
<!--a href='dboard.php?id=<?=$row['bbs_id']?>' target='bbs_<?=$row['bbs_id']?>'-->
<!--a href='#' onClick='viewBbsPage("<?=$row['bbs_id']?>");return false;' onFocus='this.blur()' -->
                        <a href="devent.php?event_id=<?=$row['event_id']?>" target='_devent<?=$row['event_id']?>'>
                        <?=$row['title']?>
                        </a>
</b>
                      </td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="moveSetupPage     (<?=$row['event_id']?>);return false;">설정</a></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="moveGrantPage     (<?=$row['event_id']?>);return false;">설정</a></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="moveResultPage    (<?=$row['event_id']?>);return false;">보기</a></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="deleteData        (<?=$row['event_id']?>);return false;">삭제</a></td>
                    </tr>
<?
} // while END
?>