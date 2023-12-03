<?
///날짜계산

$today=date("Ymd");

$t_year=substr($today,0,4);

$t_month=substr($today,4,2);

$t_day=substr($today,6,2);

   $sitelink2=$data[sitelink2]=stripslashes($data[sitelink2]);

$total_today=Day_Count($t_year,$t_month,$t_day);

$day_count=$sitelink2-$total_today;		//남은 날짜 계산

/* Check New Comment <?=comment_new?> */

$last_comment = mysql_fetch_array(mysql_query("select * from $t_comment"."_$id where parent='$data[no]' order by reg_date desc limit 1"));
$last_comment_time = $last_comment['reg_date'];
if(time()-$last_comment_time<60*60*12) $comment_new = "<img src='$dir/new2.gif' border=0  style=\"cursor:hand\" title=\"".$last_comment['memo']."\"  align=absmiddle>";
elseif(time()-$last_comment_time<60*60*24) $comment_new = "<font color=blue  style=\"cursor:hand\" title=\"".$last_comment['memo']."\">*</font>";
else $comment_new = "";

/* Check New Article to <?=$new?> */

if(time()-$data['reg_date']<60*60*12 && $hit>=100) $bg=ivory;
elseif(time()-$data['reg_date']<60*60*12 && $hit<100) $bg=honeydew;
elseif(time()-$data['reg_date']<60*60*24 && $hit>=100) $bg=ivory;
elseif(time()-$data['reg_date']<60*60*24 && $hit<100) $bg=lightcyan;
elseif(time()-$data['reg_date']>=60*60*24 && $hit>=100) $bg=ivory;
else $bg="ffffff";

?>

  <tr align=center bgcolor=<?=$bg?> onMouseOver=this.style.backgroundColor='#FAFAFA' onMouseOut=this.style.backgroundColor='<?=$bg?>'>
    <td nowrap class=tah7><?=$number?></td>
    <td><input type=checkbox name=cart value="<?=$data[no]?>"></td>
    <td nowrap style='word-break:break-all;' class=Orangered><b><?=$name?></div></b></td>
    <td align=left class=tah8><b class=gray>
<?
	$view_date = $data[sitelink1];
	$b = explode("/",$view_date); 
    echo "<font class=Orange>$b[0]</font>년	<font class=Orange>$b[1]</font>월 <font class=Orange>$b[2]</font>일";
?> 
		</b></td>
    <td align=center><?if($data[file_name1]) {?><img src="<?=$dir?>/icon/<?echo "$data[file_name1]"?>.gif" border=0 align=absmiddle><?} else {?><?}?></td>
    <td align=left style='word-break:break-all;'><?=$hide_category_start?><b class=palevioletred>[<?=$category_name?>]</b><?=$hide_category_end?> <?=$insert?><?=$subject?><font class=tah7><b class=steelblue><?=$comment_num?></b></font></td>
    <td align=center><font class=tah7><b class=royalblue>
<?
if($day_count == 0){
    echo "<font class=red>Today</font>";
}else{
    if($day_count < 0){
		$day_count*=-1;
		echo "<font class=yellowgreen>Past $day_count</font>";
	}else{
		echo "D-$day_count";
	}
}
?>
		</b></font></td>
  </tr>
  <tr>
    <td colspan=9 height=1 bgcolor=#EFEFEF><img src=<?=$dir?>/images/dot.gif width=1 height=1></td>
  </tr>
