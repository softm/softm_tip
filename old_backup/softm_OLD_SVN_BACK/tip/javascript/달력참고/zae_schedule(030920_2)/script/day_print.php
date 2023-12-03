<?
	echo "<table border=0 >
	<tr><td width=20></td>
";

//count는 <tr>태그를 넘기기위한 변수. 변수값이 7이되면 <tr>태그를 삽입한다.

$count=0;

//첫번째 주에서 빈칸을 1일전까지 빈칸을 삽입
for($i=0; $i<$first; $i++){
	echo "	";
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


	$view_date = "$year/$month/$day";
  $d_day = Day_Count($year,$month,$day);
	$query_y="select * from zetyx_board_$id where sitelink1='$view_date'";
	$result_y=mysql_query($query_y, $connect);

	if (mysql_num_rows($result_y)) {

		$file=mysql_fetch_array($result_y);

echo "<td width=10>
				<div align=center>
					<A HREF='write.php?$href&mode=write&sitelink1=$view_date&sitelink2=$d_day&year=$year&month=$month&day=$day' onfocus=blur()>
						<font color='$day_color' style='font-family:tahoma;font-size:8pt;font-weight:bold'><u>$day</u></font>
					</a>
				</div>
			</td>";
	}
	else {
echo "<td width=10>
				<div align=center>
					<A HREF='write.php?$href&mode=write&sitelink1=$view_date&sitelink2=$d_day&year=$year&month=$month&day=$day' onfocus=blur()>
						<font color='$day_color' style='font-family:tahoma;font-size:8pt'>$day</font>
					</a>
				</div>
			</td>";
}
//================내용보이는곳  끝==================================


	if($count==7 && $day == $total_day ){ //마지막주의 경우
		echo"</tr>";
	}	
	elseif($count==7){ //토요일이 되면 색바꾸기 위한 식
		echo "";
		$count=0;
	}

}


echo "</table>";

?>
