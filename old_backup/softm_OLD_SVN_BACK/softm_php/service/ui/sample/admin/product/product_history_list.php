<?
//require_once HOME_DIR . '/inc/form.inc';
require_once HOME_DIR . '/inc/var.inc';
?>
<DIV STYLE="width:347px;HEIGHT:20px;background-color:#000;padding-top:0;">
<button style='color:#000;float:right;width:15px;height:20px' onclick='$("area02").style.display="none";'>x</button>
</DIV>
<DIV STYLE="overflow-y:scroll; width:347px;HEIGHT:160px;">
<table width='330' border=0 cellpadding=0 cellspacing=0 id=list-box style='margin:0px; padding:0; border:0px solid #000'>
<input type=hidden id='p_prod_no' value='<?=$s_prod_no?>'/>
<?
$where  = " WHERE PROD_NO = '" .$s_prod_no."'";

$sql = " SELECT "
     . " COUNT(*) "
     . " FROM "
     .  TB_PRODUCT_HISTORY . " "
     . ( $where ? $where :"" );
//echo 'sql : ' . $sql . ' /<BR>';
$totCnt = $db->simpleSQLQuery ($sql);
$page_tab['tot'      ] = $totCnt ;

$sql = " SELECT "
     . " * "
     . " FROM "
     .  TB_PRODUCT_HISTORY
     . ( $where ? $where :"" )
     . " ORDER BY HISTORY_SEQ ASC";
//echo 'sql : ' . $sql . ' /<BR>';
?>
<colgroup>
    <col width="50"/><!-- No      -->
    <col width="85"/><!-- 연장일자-->
    <col width="85"/><!-- 만료일자-->
    <col width="50"/><!-- 사용수  -->
    <col width="30"/><!-- 기간    -->
    <col width="30"/><!--     -->
</colgroup>
  <tr class=lock_head>
    <th>No          </th>
    <th>연장일자    </th>
    <th>만료일자    </th>
    <th>사용수      </th>
    <th>기간        </th>
    <th><input type=checkbox class=check onclick='toggleCheckBox(this,"chk_history_seq");'/></th>
  </tr>
<?
$stmt = $db->multiRowSQLQuery ($sql);
$cnt = 0;
$print_no = $totCnt - $page_tab['s'] + 2; // 현재 보여지는 번호.
while ( $rs = $db->multiRowFetch  ($stmt) ) {
    $cnt++;
    $print_no--;
?>
  <tr>
    <td><?=sprintf('%02d',$cnt)?></td>
    <td><?=substr($rs[RENEW_DATE],5)?></td>
    <td><?=substr($rs[EXPIRE_DATE],5)?></td>
    <td><?=$rs[USE_CNT]?></td>
    <td><?=$rs[PERIOD]?></td>
    <td><a href=# class=sky_link>
      <input type=checkbox name=chk_history_seq value=<?=$rs[HISTORY_SEQ]?> class=check/>
    </a></td>
  </tr>

<?
}
if ( $cnt == 0 ) {
?>

  <tr>
    <td colspan=6>조회된 자료가 없습니다.</td>
  </tr>
<?
}
?>
</table>
</DIV>
<table width='347' border=0 cellpadding=0 cellspacing=0 style='margin:0px; padding:0; border:0px solid #000'>
  <tr >
    <td colspan=6 style='text-align:right'>
     <a href='#' onclick='매물히스토리선택삭제();return false;'><img src=/img/bt_delete02.gif width=54 height=22 align=absmiddle /></a>
     </td>
    </tr>
</table>