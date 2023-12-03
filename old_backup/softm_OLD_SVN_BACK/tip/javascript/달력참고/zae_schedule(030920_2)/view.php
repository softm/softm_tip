<? include "$dir/script/day_print.php";?>
<table width=<?=$width?> border="0" style="display:<?=$display[hide_0]?>;" id="hide_0">
<tr><td></td></tr></table>
<table width=0 border="0"  style="display:<?=$display[hide_1]?>;" id="hide_1">
<tr><td></td></tr></table>
<table width=0 border="0" style="display:<?=$display[hide_2]?>;" id="hide_2">
<tr><td></td></tr></table>
<table width=0 border="0" style="display:<?=$display[hide_3]?>;" id="hide_3">
<tr><td></td></tr></table>
<table width=0 border="0" style="display:<?=$display[hide_4]?>;" id="hide_4">
<tr><td></td></tr></table>
<script>
document.title = '<?=$setup[title]?> - <?=$subject?>';
</script>
<?
///날짜계산

$today=date("Ymd");

$t_year=substr($today,0,4);

$t_month=substr($today,4,2);

$t_day=substr($today,6,2);

   $sitelink2=$data[sitelink2]=stripslashes($data[sitelink2]);

$total_today=Day_Count($t_year,$t_month,$t_day);

$day_count=$sitelink2-$total_today;		//남은 날짜 계산

?>
<table width=<?=$width?> border=0 cellspacing=0 cellpadding=0>
  <tr> 
    <td height=3 bgcolor=silver></td>
  </tr>
  <tr> 
    <td height=20 class=tah7 style=padding-left:10px><b>View Schedule</td>
  </tr>
  <tr> 
    <td height=2 bgcolor=gray></td>
  </tr>
</table>
<table width=<?=$width?> border=0 cellspacing=0 cellpadding=0>
	<tr height=20>
		<td width=100% align=center>
		<b class=gray><? if ($data[category]=='2'){?>
		<img src="<?=$dir?>/icon/hot.gif"  align=absmiddle alt='중요한 일정입니다'>&nbsp;<?}?>
<?
	$view_date = $data[sitelink1];
	$b = explode("/",$view_date); 
	$diarydate = mktime(0,0,0,$b[1],$b[2],$b[0]);
	$date = date("w",$diarydate);
if($date==0) $yoil="일요일";
elseif($date==1) $yoil="월요일";
elseif($date==2) $yoil="화요일";
elseif($date==3) $yoil="수요일";
elseif($date==4) $yoil="목요일";
elseif($date==5) $yoil="금요일";
else $yoil="토요일";
    echo "<font class=blue2>$b[0]</font>년	<font class=blue2>$b[1]</font>월 <font class=blue2>$b[2]</font>일 <font class=blue2>$yoil</font>";
?> 
<?=$total_target?>의 일정 </b>
<?
if($day_count == 0){
    echo "<img src='$dir/icon/icon.gif' align=absmiddle><font class=ver9 color=red> 오늘 일정입니다.</font>";
}else{
    if($day_count < 0){
		$day_count*=-1;
		echo "<img src='$dir/icon/icon.gif' align=absmiddle><font class=ver9 color=red> 이미 $day_count 일 지난 일정입니다.</font>";
	}else{
		echo "<img src='$dir/icon/icon.gif' align=absmiddle><font class=ver9 color=red> 앞으로 $day_count 일 남았습니다.</font>";
	}
}
?>
</td>
	</tr>
</table>
<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>><tr><td height=1 bgcolor=ececec></td></tr></table>
<table border=0 cellspacing=0 cellpadding=0 width=<?=$width?>>
<tr>
	<td class=gul9 style=padding:8px;word-break:break-all;>
		<table border=0 cellspacing=0 cellpadding=0 width=100%>
			<tr>
 				<td class=orangered>
				 <b class=hotpink>Title</b> :: <? if ($data[file_name1]){?><img src=<?=$dir?>/icon/<? echo "$data[file_name1]"?>.gif border=0>&nbsp;<?}?><font class=gul9><?=$subject?></font>
				</td>
				<td align=right class=tah7>
				<a href="#comment" onfocus=this.blur() class=tah7><?=$comment_num?><? if($comment_num) {echo (" comments");}	?>	</a>
				Posted at <?=$reg_date?>, Hit : <b><?=number_format($hit)?></b>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr><td height=1 bgcolor=ececec></td></tr>
<tr>
	<td valign=top bgcolor=white>
		<table border=0 cellspacing=0 width=100% style=table-layout:fixed height=30 class=list0>
		<tr>
    <td nowrap style=padding-left:10px class=tah8 align=right>
				<b><?=$name?></b>&nbsp;
				<?
					if($data['homepage']) {
				?><a href="<?=$data['homepage']?>" target=_blank><font class=ver8>(Homepage)</font></a><?
					}
				?>
			</td>
		</tr>
		</table>
		<table border=0 cellspacing=0 cellpadding=10 width=100% padding=8>
		<tr>
			<td>

				<?=$hide_download2_start?><font class=list_link>- <b>Download #1 : <?=$a_file_link2?><?=$file_name2?> (<?=$file_size2?>)</a>, Download : <?=$file_download2?></font><br><?=$upload_image2?><?=$hide_download2_end?>
		
				<img src=<?=$dir?>/t.gif border=0 width=10><br>
				<?=$memo?>
				<div align=right class=ver7><?=$ip?></div>
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>

<img src=<?=$dir?>/t.gif border=0 height=2><br>

<?if($member['level']<=$setup['grant_comment']){?>
<?=$hide_comment_start?>
<table border=0 cellspacing=0 cellpadding=0 height=1 width=<?=$width?>>
<tr><td height=1 class=line1 style=height:1px><img src=<?=$dir?>/t.gif border=0 height=1></td></tr>
</table>
<img src=/images/t.gif border=0 height=8><br>
<table width=<?=$width?> cellspacing=1 cellpadding=4>
<col width=100></col><col width=8></col><col width=></col><col width=100></col>
<tr valign=top bgcolor=white>
	<td>
		<table border=0 cellspacing=0 cellpadding=0 width=100% style=table-layout:fixed>
		<tr>
			<td class=blue1>코멘트<br> <b>공지사항</b></td>
		</tr>
		</table>
	</td>
	<td width=8 class=line2 style=padding:0px><img src=/images/t.gif border=0 width=8></td>
	<td class=blue2>코멘트에 관한 공지사항은 <br>이곳에 넣어주세요..^^</td>
	<td align=right><font class=ver7><?=date("Y-m-d")?><br><?=date("H:i:s")?></font></td>
</tr>
</table>
<img src=/images/t.gif border=0 height=8><br>
<?=$hide_comment_end?>
<?}?>
