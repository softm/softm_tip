<!--------공지사항의 notice 시작------------>
<?
$result_y=mysql_query("select * from zetyx_board_$id where headnum<=-2000000000 order by no desc limit 5") or die(mysql_error());
	if (mysql_num_rows($result_y)) { //오늘일정 있으면..........
				echo ("
<table cellspacing=0 cellpadding=0 width='100%' border=0 align='center'>
	<tr>
		<td valign=top align=center>
			<fieldset>
  	  	<legend><b><img src=$dir/notice_head.gif><font style='color:hotpink;font-family:tahoma;font-size:8pt;font-weight:bold;'> 공지사항</font><br></b></legend>
			<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
				<tr>
					<td bgcolor=#ffffe9 class=tah9>
							");
                        while($cal=mysql_fetch_array($result_y))
                        {
                        $cal[subject] = stripslashes($cal[subject]);

                        $reg_date=date("m/d",$cal[reg_date]);



				echo ("
									<a href=./view.php?id=$id&no=$cal[no] onfocus='this.blur()'>
									<b class=yellowgreen>$cal[subject]</b></a>
									<b class=tan >($reg_date)</b><br><marquee behavior=scroll direction=LEFT scrollamount=3 onMouseover='stop()' onMouseout='start()'>$cal[memo]</marquee>
							");
                        }
				echo ("
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
							");
	}
	
	else { //이번 달 일기 없으면 아무것도 출력하지 않음....
		echo "";

	}

?>
<!--------공지사항의 notice 끝 ----------->

