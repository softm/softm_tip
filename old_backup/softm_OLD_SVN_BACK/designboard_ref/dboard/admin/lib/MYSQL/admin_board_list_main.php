<?
$print_no = $tot - $s + 2;

$sql  = "select no, bbs_id, design_method from $tb_bbs_infor ";

if ( $sort == 'bbs_id' || $sort == 'no' ) {
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
                        <input type="checkbox" name="chk_no[]" value="<?=$row['no'] . '$$' . $row['bbs_id']?>">
                      </td>
                      <td bgcolor="F7F7F7" class="text_01" align="center"><?=$print_no?></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center">
<b>
<?
if ( $row[design_method] == '2' ) {
?>
	<a href="files/<?=$row['bbs_id']?>.php" target='_dboard<?=$row['bbs_id']?>'>
<?
} else {
?>
	<a href="dboard.php?id=<?=$row['bbs_id']?>" target='_dboard<?=$row['bbs_id']?>'>
<?
}
?>
		<?=$row['bbs_id']?>
	</a>
</b>
                      </td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="moveSetupPage     (<?=$row['no']?>);return false;">설정</a></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="moveGrantPage     (<?=$row['no']?>);return false;">설정</a></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="moveAbstractPage  (<?=$row['no']?>);return false;">추출</a></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="moveBackUpPage    (<?=$row['no']?>);return false;">백업</a></td>
                      <td bgcolor="F7F7F7" class="text_03" align="center"><a href="#" onClick="deleteData        (<?=$row['no']?>,'<?=$row['bbs_id']?>');return false;">삭제</a></td>
                    </tr>
<?
} // while END
?>