<table cellspacing=0 cellpadding=0 width='<?=$width?>' border=0 align='center'>
	<tr style="display:<?=$display[hide_5]?>;" id="hide_5">
		<td valign=top align=center style=padding-top:5px>
<table cellspacing=0 cellpadding=0 width='100%' border=0 align='center'>
	<tr>
		<td valign=top align=center>
			<fieldset>
  	  	<legend><b><img src=<?=$dir?>/icon/icon_etc.gif><font style='color:hotpink;font-family:tahoma;font-size:8pt;font-weight:bold;'> HELP</font><br></b></legend>
			<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
				<tr>
					<td bgcolor=#ffffe9 class=tah9>
 이 페이지가 보이시는 분은 스케줄 게시판에 처음 접속하신 분이십니다.<br> 
이 스케줄 게시판은 방문자님이 원하시는 설정대로 보여줄 수 있습니다.<br> 
분홍색의 manager 버튼 옆으로 늘어선 색색의 버튼은 누르실 때 마다 각각의 화면이 보여지게 됩니다.<br>
빨강색의 month는 해당월의 일정이 달력모양으로 출력됩니다.<br>
주황색의 week는 주간 일정을 보여줍니다.<br>
파랑색의 list는 게시판 형태로 일정을 보여줍니다.<br>
연녹색의 notice는 공지사항을 보여주는 곳이며, <br>
청남색의 myplan은 자신의 중요일정과 최근 7일내의 일정을 보여줍니다.<br>
한번 누를 때마다 보여지고 사라짐이 반복됩니다. 한번 설정하시면 계속해서 그 모양대로 보여지게 됩니다.^^<br>
모든 설정을 마치셨으면 분홍색의 manager 버튼을 눌러주시면 이 페이지도 사라집니다.^^

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
<table cellspacing=0 cellpadding=0 width='<?=$width?>' border=0 align='center'>
	<tr style="display:<?=$display[hide_4]?>;" id="hide_4">
		<td valign=top align=center style=padding-top:5px>
<? include "$dir/week.php";?>
		</td>
	</tr>
</table>
<table cellspacing=0 cellpadding=0 width='<?=$width?>' border=0 align='center'>
	<tr style="display:<?=$display[hide_3]?>;" id="hide_3">
		<td valign=top align=center style=padding-top:5px>
<? include "$dir/today.php";?>
<? include "$dir/hot_day.php";?>
<? include "$dir/share.php";?>
		</td>
	</tr>
</table>
<table cellspacing=0 cellpadding=0 width='<?=$width?>' border=0 align='center'>
	<tr style="display:<?=$display[hide_2]?>;" id="hide_2">
		<td valign=top align=center style=padding-top:5px>
<? include "$dir/notice.php";?>
		</td>
	</tr>
</table>

<table width=<?=$width?> border="0" cellspacing="0" cellpadding="0">
  <tr  style="display:<?=$display[hide_0]?>;" id="hide_0">
    <td  style=padding-top:5px>
<table cellspacing=0 cellpadding=0 width='100%' border=1 bordercolor=E6E6E6 style='border-collapse:collapse;' frame=void id=main>
	<tr>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png><font color=red>Sun</font></td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Mon</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Tue</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Wed</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Thu</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Fri</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png><font color=blue>Sat</font></td>
	</tr>
	<tr>
<?
dbconn();

//count는 <tr>태그를 넘기기위한 변수. 변수값이 7이되면 <tr>태그를 삽입한다.

$count=0;

//첫번째 주에서 빈칸을 1일전까지 빈칸을 삽입
for($i=0; $i<$first; $i++){
	echo "
	<td height='$td_height' width='$td_width' bgcolor=f6f6f6>&nbsp;</td>";
	$count++;
}

//===========날짜를 테이블에 표시=================//
for($day=1;$day<=$total_day;$day++){
	$count++;


//오늘 표시
if($day==$t_day && $month==$t_month && $year==$t_year){
	$m_out_color=$today_out_color;
	$m_over_color=$today_over_color;
	$day_color=$today_color;
}

else {//오늘이 아니면...

	if ($count==1) {//일요일
		$m_out_color=$sun_out_color;
		$m_over_color=$sun_over_color;
		$day_color=$sun_color;

	}

	elseif ($count==7) {//토요일
		$m_out_color=$sat_out_color;
		$m_over_color=$sat_over_color;
		$day_color=$sat_color;

	}

	else {//평일
		$m_out_color=$else_out_color;
		$m_over_color=$else_over_color;
		$day_color=$else_color;
	}

}//오늘이 아니면...끝

//===========내용보이는곳 (이 부분만 수정해서 사용할것)========================

echo "

<td valign=top bgcolor='$m_out_color' height='$td_height' width='$td_width' onMouseOut=this.style.backgroundColor='' onMouseOver=this.style.backgroundColor='#FBFBFB' style='word-break:break-all;padding:0px;'>";

	$view_date = "$year/$month/$day";
  $d_day = Day_Count($year,$month,$day);
  $lunday=sol2lun($year,$month,$day);

echo "
<table border=0 width=100%><tr><td>
<A HREF='write.php?$href&mode=write&year=$year&month=$month&day=$day&sitelink2=$d_day' onfocus=blur()>
<font color='$day_color' style='font-family:tahoma;font-size:8pt;font-weight:bold'>$day</font></a>
</td>";

if($day==5 || $day==15 || $day==25) 
{ 
echo "
<td align=right>
<font color='indigo' style='font-family:tahoma;font-size:7pt'>    (- $lunday[1]-$lunday[2])</font>
</td>"; 
}
echo "</tr></table>"; 



$query_a="select * from zetyx_board_$id where sitelink1='$view_date'";
$result_a=mysql_query($query_a, $connect);

	while($cal_3=mysql_fetch_array($result_a))
	{


		$file_name1=$cal_3[file_name1]=stripslashes($cal_3[file_name1]);
		if ($cal_3[file_name1]) { $cal_icon="<img src=".$dir."/icon/".$cal_3[file_name1].".gif border=0>" ;}
		else { $cal_icon = ""; }

		$subject=str_replace("\r\n","&lt;br&gt;",$cal_3[subject]);
		$subject=str_replace("'","",$subject);
		$subject=cut_str($subject,$setup[cut_length]);
		list_check(&$cal_3);

	//------관리자가 아닐때 비밀글 내용대신 다른거 출력----
		if(!$is_admin) { 
			if($cal_3[is_secret]==1) {
				$subject="비밀글"; // 원하는 내용쓰세요
				$cal_icon="<img src=".$dir."/icon/icon_etc.gif border=0>" ;			}
		}
	//-----------------------------------------------
		//--코멘트 갯수 가져오기
		$comment = $cal_3[total_comment];
		if (!$comment==0) {
		$comment = "<font class=tah7>[".$comment."]</font>";
		}else{
		$comment ="";
		}
	    $query_a="select name from zetyx_board_category_$id where no='$cal_3[category]'"; //카테고리이름가져오기
		$result1=mysql_query($query_a, $connect);
		$cal_4=mysql_fetch_array($result1);
		$category_name = stripslashes($cal_4[0]);
?>

<?
		echo ("<A HREF='view.php?$href&no=$cal_3[no]' onfocus=blur() ><font color=$category_color>[$category_name]</font><font color=gray>$cal_icon $subject$comment </font></a><br>" );

	}


echo "</td>";

//================내용보이는곳  끝==================================


	if($count==7 && $day == $total_day ){ //마지막주의 경우
		echo"</tr>";
	}	
	elseif($count==7){ //토요일이 되면 줄바꾸기 위한 <tr>태그 삽입을 위한 식
		echo "</tr><tr>";
		$count=0;
	}

}

//선택한 월의 마지막날 이후의 빈테이블 삽입
for($day++; $total_day < $day && $count<7; ){
		echo "
	<td height='$td_height' width='$td_width' bgcolor=f6f6f6>&nbsp;</td>";
		$count++;
}

echo "<tr><td colspan=7 height=2 class='l_light'></td></tr></table>";

?>
<table width=<?=$width?> border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class='tah9' align=right><? include "$dir/life.php";?></td>
	</tr>
</table>
		</td>
	</tr>
</table>
<table width=<?=$width?> border="0" cellspacing="0" cellpadding="0" >
	<tr height=5><td></td></tr>
  <tr style="display:<?=$display[hide_1]?>;" id="hide_1">
    <td >
<?=$hide_category_start?>
<table width=100% border=0 cellspacing=0 cellpadding=0>
  <tr>
   <td><?=$a_category?></td>
   <td align=right class=tah8>
<b><font color=orangered>Total</font> : <?=$total?> </b>article&nbsp;&nbsp;/&nbsp;&nbsp;
<b><font color=orange>Here</font> : <font color=yellowgreen><?=$page?></font> of <?=$total_page?> </b>pages
	 </td>
  </tr>
</table>
<?=$hide_category_end?>
<table width=100% border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;' frame=void id=board>
<col width=30></col><col width=20></col><col width=80></col><col width=110></col><col width=30></col><col width=></col><col width=60></col>
  <tr> 
    <td colspan=7 height=3 bgcolor=silver></td>
  </tr>
  <tr height=20>
    <td class=tah7 align=center><?=$a_no?><b>no</a></td>
    <td  class=tah7 align=center><?=$a_cart?><b>v</a></td>
    <td  class=tah7 align=center><?=$a_name?><b>name</a></td>
    <td  class=tah7 align=center><b>date</b></td>
    <td  class=tah7 align=center><b>icon</b></td>
    <td  class=tah7 align=center><?=$a_subject?><b>schedule</b></a></td>
    <td  class=tah7 align=center><b>d-day</b></td>
  </tr>
  <tr> 
    <td colspan=7 height=2 bgcolor=gray></td>
  </tr>
<! --------------------폼 시작(수정하지마세요)-------------------- >
<form method=post name=list action=list_all.php>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=selected>
<input type=hidden name=exec>
<input type=hidden name=keyword value="<?=$keyword?>">
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
<! --------------------폼 끝(수정하지마세요)--------------------- >
