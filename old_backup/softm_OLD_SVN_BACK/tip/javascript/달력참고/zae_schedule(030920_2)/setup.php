<?
$mem_no = $member[no] ? $member[no] : "-1";		
?>
<? include("luncal.inc") ?>
<? include("$dir/script/cal.php") ?>
<? include("$dir/script/hideshow.php") ?>
<?

if ($HTTP_COOKIE_VARS[hide_0]) $display[hide_0] = "none"; else $display[hide_0] = "inline";
if ($HTTP_COOKIE_VARS[hide_1]) $display[hide_1] = "none"; else $display[hide_1] = "inline";
if ($HTTP_COOKIE_VARS[hide_2]) $display[hide_2] = "none"; else $display[hide_2] = "inline";
if ($HTTP_COOKIE_VARS[hide_3]) $display[hide_3] = "none"; else $display[hide_3] = "inline";
if ($HTTP_COOKIE_VARS[hide_4]) $display[hide_4] = "none"; else $display[hide_4] = "inline";
if ($HTTP_COOKIE_VARS[hide_5]) $display[hide_5] = "none"; else $display[hide_5] = "inline";

?>
<script language="JavaScript">

function hide(id) {

	target = document.all[id];

	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + 7);

	if (target.style.display == 'none') {
		target.style.display = 'inline';
		document.cookie = id + "=0; path=/; expires=" + todayDate.toGMTString() + ";"
	} else {
		target.style.display = 'none';
		document.cookie = id + "=1; path=/; expires=" + todayDate.toGMTString() + ";"
	}


}

</script>
<script>
<!--
	function zb_formresize(obj) {
		obj.rows += 3;
	}
// -->
</script>
<table width=<?=$width?> border="0" cellspacing="0" cellpadding="0">
<?=$memo_on_sound?>
	<tr>
    <td colspan="2" align=right width=100%><?=$a_member_memo?><span onClick="swapImage('memozzz','','<?=$dir?>/member_memo_off.gif',0)"><?=$member_memo_icon?></span></a></td>
  </tr>
  <tr>
    <td align=right >
	    <table border=0 cellspacing=0 cellpadding=0 width=99%>
  			<tr>
       		<td valign=bottom align=left>
						<span style='cursor:hand'  onClick="hide('hide_5');" onfocus=blur()><img src=<?=$dir?>/images/tb_0.gif border=0></span>
 						<span style='cursor:hand'  onClick="hide('hide_0');" onfocus=blur()><img src=<?=$dir?>/images/tb_1.gif border=0></span>
 						<span style='cursor:hand'  onClick="hide('hide_4');" onfocus=blur()><img src=<?=$dir?>/images/tb_2.gif border=0></span>
						<span style='cursor:hand'  onClick="hide('hide_1');" onfocus=blur()><img src=<?=$dir?>/images/tb_3.gif border=0></span>
 						<span style='cursor:hand'  onClick="hide('hide_2');" onfocus=blur()><img src=<?=$dir?>/images/tb_4.gif border=0></span>
 						<span style='cursor:hand'  onClick="hide('hide_3');" onfocus=blur()><img src=<?=$dir?>/images/tb_5.gif border=0></span>
 						<a href="<?=$dir?>/backup.php?id=<?=$id?>&year=<?=$year?>&month=<?=$month?>" target=_blank onfocus=blur()><img src=<?=$dir?>/images/tb_6.gif border=0></a>
 						<a href="#" onclick="window.print()" onfocus=blur()><img src=<?=$dir?>/images/tb_7.gif border=0></a>
					</td>
	    		<td align=right>
							<?
								if($member[level]==1) { $birth="<a href=birthday.php?id=".$id."> <img src=$dir/images/tb_9.gif border=0></a>";
																				$anniversary="<a href=anniversary.php?id=".$id."> <img src=$dir/images/tb_8.gif border=0></a>";
								}
							?>
     				<?=$anniversary?>
     				<?=$birth?>
						<?=$a_member_join?><img src=<?=$dir?>/images/setup_join.gif border=0></a>
						<?=$a_member_modify?><img src=<?=$dir?>/images/setup_info.gif border=0></a>
						<?=$a_member_memo?><img src=<?=$dir?>/images/setup_memo.gif border=0></a>
						<?=$a_login?><img src=<?=$dir?>/images/setup_login.gif border=0></a>
						<?=$a_logout?><img src=<?=$dir?>/images/setup_logout.gif border=0></a>
						<?=$a_setup?><img src=<?=$dir?>/images/setup_admin.gif border=0></a>
      		</td>
      	</tr>
			</table>
		</td>
	</tr>
</table>
<? include("$dir/script/cal_print.php") ?>

