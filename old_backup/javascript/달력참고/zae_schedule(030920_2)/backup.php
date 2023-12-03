<? 
$id=$_POST[id];
$year=$_POST[year];
$month=$_POST[month];
if(!$id || !$year || !$month){
$id=$_GET[id];
$year=$_GET[year];
$month=$_GET[month];
}
if(!$id || !$year || !$month) echo "<script>alert('정상적인 경로로 다시 입장해 주세요.'); window.close();</script>";
require "../../lib.php";
include "./script/cal.php";
?>
<?
header("Content-type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=cal.xls"); 
header("Content-Description: PHP4 Generated Data"); 
?>
<table cellspacing=0 cellpadding=0 width='700' border=1 bordercolor=E6E6E6 style='border-collapse:collapse;' frame=void id=main>
	<tr>
		<td colspan=7 align=center ><font color=blue><?=$year?>년 <?=$month?>월의 일정</font></td>
	</tr>
	<tr>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' bgcolor=ivory><font color=red>Sun</font></td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' bgcolor=ivory>Mon</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' bgcolor=ivory>Tue</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' bgcolor=ivory>Wed</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' bgcolor=ivory>Thu</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' bgcolor=ivory>Fri</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' bgcolor=ivory><font color=blue>Sat</font></td>
	</tr>
	<tr>
<?

dbconn();

//count는 <tr>태그를 넘기기위한 변수. 변수값이 7이되면 <tr>태그를 삽입한다.

$count=0;

//첫번째 주에서 빈칸을 1일전까지 빈칸을 삽입
for($i=0; $i<$first; $i++){
	echo "
	<td height='$td_height' width='$td_width' bgcolor=gainsboro>&nbsp;</td>";
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

<td valign=top bgcolor='lightyellow' height='$td_height' width='$td_width' onMouseOut=this.style.backgroundColor='' onMouseOver=this.style.backgroundColor='#FBFBFB' style='word-break:break-all;padding:0px;'>";

	$view_date = "$year/$month/$day";
  $d_day = Day_Count($year,$month,$day);

echo "<div align=left><font color='$day_color' style='font-family:tahoma;font-size:8pt;font-weight:bold'>$day</font></div>";



$query_c="select * from zetyx_board_$id where sitelink1='$view_date'";
$result_c=mysql_query($query_c, $connect);

	while($cal=mysql_fetch_array($result_c))
	{


		$file_name1=$cal[file_name1]=stripslashes($cal[file_name1]);
		if ($cal[file_name1]) { $cal_icon="<img src=".$dir."/icon/".$cal[file_name1].".gif border=0>" ;}
		else { $cal_icon = ""; }

		$subject=str_replace("\r\n","&lt;br&gt;",$cal[subject]);
		$subject=str_replace("'","",$subject);

		//--코멘트 갯수 가져오기
		$comment = $cal[total_comment];
		if (!$comment==0) {
		$comment = "<font class=tah7>[".$comment."]</font>";
		}else{
		$comment ="";
		}
	    $query_c="select name from zetyx_board_category_$id where no='$cal[category]'"; //카테고리이름가져오기
		$result1=mysql_query($query_c, $connect);
		$cal_2=mysql_fetch_array($result1);
		$category_name = stripslashes($cal_2[0]);
?>

<?
		echo ("<font color=$category_color>[$category_name]</font><font color=gray>$subject $comment </font><br>" );

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
	<td height='$td_height' width='$td_width' bgcolor=gainsboro>&nbsp;</td>";
		$count++;
}

echo "<tr><td colspan=7 height=2 class='l_light'></td></tr></table>";

?>

