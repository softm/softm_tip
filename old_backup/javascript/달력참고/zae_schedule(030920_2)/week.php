<?

function get_monday_before ( $year, $month, $day ) { 
  $weekday = date (  "w", mktime ( 2, 0, 0, $month, $day, $year ) ); 
  if ( $weekday == 0 ) 
    return mktime ( 2, 0, 0, $month, $day - 6, $year ); 
  if ( $weekday == 1 ) 
    return mktime ( 2, 0, 0, $month, $day, $year ); 
  return mktime ( 2, 0, 0, $month, $day - ( $weekday - 1 ), $year ); 
} 

function get_sunday_before ( $year, $month, $day ) { 
  $weekday = date (  "w", mktime ( 2, 0, 0, $month, $day, $year ) ); 
  $newdate = mktime ( 2, 0, 0, $month, $day - $weekday, $year ); 
  return $newdate; 
} 

//$date="20000731"; 

if ( strlen ( $date ) > 0 ) { 
  $thisyear = $year = substr ( $date, 0, 4 ); 
  $thismonth = $mon = substr ( $date, 4, 2 ); 
  $thisday = $day = substr ( $date, 6, 2 ); 
} else { 
  if ( $mon == 0 ) 
    $thismonth = date( "m"); 
  else 
    $thismonth = $month; 
  if ( $year == 0 ) 
    $thisyear = date( "Y"); 
  else 
    $thisyear = $year; 
  if ( $day == 0 ) 
    $thisday = date( "d"); 
  else 
    $thisday = $day; 
} 
$next = mktime ( 2, 0, 0, $thismonth, $thisday + 7, $thisyear ); 
$prev = mktime ( 2, 0, 0, $thismonth, $thisday - 7, $thisyear ); 
$today = mktime ( 2, 0, 0, date (  "m" ), date (  "d" ), date (  "Y" ) ); 

if ( $WEEK_START == 1 ) 
  $wkstart = get_monday_before ( $thisyear, $thismonth, $thisday ); 
else 
  $wkstart = get_sunday_before ( $thisyear, $thismonth, $thisday ); 

$wkend = ($wkstart+518400); 
$startdate = date (  "Ymd", $wkstart ); 
$enddate = date (  "Ymd", $wkend ); 

$next1=date( "Ymd",$next); 
$next2=date( "Y",$next); 
$next3=date( "n",$next); 
$prev1=date( "Ymd",$prev); 
$prev2=date( "Y",$prev); 
$prev3=date( "n",$prev); 
echo ( "<table cellspacing=0 cellpadding=0 width='100%' border=0 bordercolor=E6E6E6 style=padding-left:20px;'border-collapse:collapse;'> 
    <tr> 
        <td height='20'  colspan='3' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=$dir/images/tablehd_bg.png> 
            <a href=$PHP_SELF?id=$id&year=$prev2&month=$prev3&date=$prev1><img src=$dir/year_prev.gif></a>
               주간일정관리 
            <a href=$PHP_SELF?id=$id&year=$next2&month=$next3&date=$next1><img src=$dir/year_next.gif></a>
        </td> 
    </tr>
  <tr> 
    <td colspan=3 height=3 bgcolor=silver></td>
  </tr>
    <tr height=20> 
    	<td class=tah7 align=center style=padding-left:0px;><b>date</b></td>
    	<td class=tah7 align=center style=padding-left:0px;></td>
			<td class=tah7 align=center style=padding-left:0px;><b>schedule</b></td>
    </tr>
  <tr> 
    <td colspan=3 height=2 bgcolor=gray></td>
  </tr>
"); 

for ( $i = 0; $i < 7; $i++ ) { 
  $days[$i] = $wkstart + ( 24 * 3600 ) * $i; 
  $day1[$i] = date ( "w",$days[$i]); 
if($day1[$i]==0){//일요일
		$m_out_color=$sun_out_color;
		$m_over_color=$sun_over_color;
		$day_color=$sun_color;
		$yoil="일요일";
	}
elseif($day1[$i]==1) {//평일
		$m_out_color=$else_out_color;
		$m_over_color=$else_over_color;
		$day_color=$else_color;
		$yoil="월요일";
	}
elseif($day1[$i]==2) $yoil="화요일";
elseif($day1[$i]==3) $yoil="수요일";
elseif($day1[$i]==4) $yoil="목요일";
elseif($day1[$i]==5) $yoil="금요일";
else {//토요일
		$m_out_color=$sat_out_color;
		$m_over_color=$sat_over_color;
		$day_color=$sat_color;
		$yoil="토요일";

	}
  $day1[$i] = date ( "Y/n/j",$days[$i]); 
  $day2[$i] = date ( "n/j",$days[$i]); 
  $day3[$i] = date ( "Y",$days[$i]); 
  $day4[$i] = date ( "n",$days[$i]); 
  $day5[$i] = date ( "j",$days[$i]); 
  $d_day = Day_Count($day3[$i],$day4[$i],$day5[$i]);
  echo ( "    <tr height=30 onMouseOut=this.style.backgroundColor='' onMouseOver=this.style.backgroundColor='#FBFBFB' style='word-break:break-all;padding:0px;'> 
        <td width='80' style=padding-left:20px;> 
	<A HREF='write.php?$href&mode=write&year=$day3[$i]&month=$day4[$i]&day=$day5[$i]&sitelink2=$d_day' onfocus=blur()>
  <font color='$day_color' style='font-family:tahoma;font-size:8pt;font-weight:bold'>$day2[$i] $yoil</font></a>
        </td>
    	<td class=tah7 align=center style=padding-left:0px;>::</td>
        <td width='' style=padding-left:10px; align=absmiddle> ");
$query_c="select * from zetyx_board_$id where sitelink1='$day1[$i]'";
$result_c=mysql_query($query_c, $connect);

	if($cal=mysql_num_rows($result_c))
	{

	while($cal=mysql_fetch_array($result_c))
	{


		$file_name1=$cal[file_name1]=stripslashes($cal[file_name1]);
		if ($cal[file_name1]) { $cal_icon="<img src=".$dir."/icon/".$cal[file_name1].".gif>" ;}
		else { $cal_icon = ""; }

		$subject=str_replace("\r\n","&lt;br&gt;",$cal[subject]);
		$subject=str_replace("'","",$subject);
		$subject=cut_str($subject,$setup[cut_length]);
		list_check(&$cal);

	//------관리자가 아닐때 비밀글 내용대신 다른거 출력----
		if(!$is_admin) { 
			if($cal[is_secret]==1) {
				$subject="비밀글"; // 원하는 내용쓰세요
				$cal_icon="<img src=".$dir."/icon/icon_etc.gif border=0>" ;			}
		}
	//-----------------------------------------------
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
		echo ("<A HREF='view.php?$href&no=$cal[no]' onfocus=blur() ><font color=$category_color>[$category_name]</font><font color=gray>$cal_icon $subject$comment </font></a>, " );

	}
} else {
		echo ("일정이 없습니다." );
	}
  echo ( " 
        </td> 
  </tr>
  <tr>
    <td colspan=3 height=1 bgcolor=#EFEFEF></td>
    </tr>"); 

} 
echo  "</table>"; 
?>

