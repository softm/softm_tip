<?
$print_no = $tot - $s + 2;

$sql  = "select no, g_no, seq, o_seq, item, item_name from $tb_event_item";
$where  = " where no = '$event_id'";
$where .= " and seq = '0'";

$sql .= $where;
$stmt = multiRowSQLQuery($sql);
$i = 0;
while ( $row = multiRowFetch  ($stmt) ) {
    $i++;
    $no         = $row['no'         ];
    $g_no       = $row['g_no'       ];
    $seq        = $row['seq'        ];
    $o_seq      = $row['o_seq'      ];
    $item       = $row['item'       ];
    $item_name  = $row['item_name'  ];
?>
    <input type="hidden" name="g_no[]"      value="<?=$g_no?>">
    <input type="hidden" name="seq[]"       value="<?=$seq?>" >

              <tr>
                <td align="center" bgcolor="fafafa" class="text_01"><strong><?=$g_no?></strong></td>
                <td align="center" bgcolor="fafafa">
                <select name="item[]" class="jm_01">
                    <option value='1'>라디오 단추   </option>
                    <option value='2'>체크   단추   </option>
                    <option value='3'>목록   상자   </option>
                    <option value='4'>멀티 목록 상자</option>
                    <option value='5'>텍스트 상자   </option>
                    <option value='6'>입력 영역     </option>
                    <option value='7'>비밀번호 상자 </option>
                </select>
<script type="text/javascript">
<!--
    var selectItem  = document.eventItemForm["item[]"];
    selectItem[<?=$i?>].selectedIndex = <?=($item-1)?>;
//-->
</SCRIPT>
                </td>
                <td align="center" bgcolor="fafafa"><input type="text" name="item_name[]" value="<?=$item_name?>"></td>
                <td align="center" bgcolor="fafafa"><a href='#' onClick='viewDetail(<?=$g_no?>);return false;'>설정</a></td>
                <td align="center" bgcolor="fafafa"><a href='<?=$libDir?>admin_event_popup_item_exec.php?event_id=<?=$no?>&g_no=<?=$g_no?>&gubun=main_delete'>삭제</a></td>
              </tr>

              <tr background="../images/bg2.gif" class="bg_line2">
                <td height="1" colspan="5" align="center" bgcolor="fafafa" class="text_01"></td>
              </tr>
              <tr>
                <td colspan="5" align="center" bgcolor="fafafa" class="text_01">

<?
    if ( $c_g_no == $g_no ) {
?>
                  <table width="100%" border="0" cellpadding="20" cellspacing="1" bgcolor="cccccc" id='_dboard_detail_<?=$g_no?>' style='position:relative;visibility:visible;z-index:10'>
<?
    }  else {
?>
                  <table width="100%" border="0" cellpadding="20" cellspacing="1" bgcolor="cccccc" id='_dboard_detail_<?=$g_no?>' style='position:absolute;visibility:hidden;z-index:-1;top:-100;left:-100;'>
<?
    }
?>
                    <tr>
                      <td bgcolor="#FFFFFF">
<?
    include $libDir . "admin_event_popup_item_detail_list_main.php";
?>

                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
<?
}

?>

