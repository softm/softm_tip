<?
// 멤버 정보 구해오기;;; 멤버가 있을때
        $member=member_info();

        if($member[no]) {

        $member[name] = stripslashes($member[name]);


if(!$want_day)$want_day=(int)$t_day;
$want_month=date("n");
$view_date = "$year/$want_month/$want_day";

	$query_t="select * from zetyx_board_$id where ismember = $member[no] AND  sitelink1='$view_date'";
	$result_t=mysql_query($query_t, $connect);


		echo "
	<table width=100%  border=0 cellspacing=0 cellpadding=0>
	  <tr>
			<td valign=top align=center>
			  <fieldset>
  	      <legend><b><img src=$dir/icon/icon_diary.gif border=0>
<font style='color:orangered;font-family:tahoma;font-size:8pt;font-weight:bold;'> $t_year 년 $want_month 월 $want_day 일</font> 
<font color=orange>$member[name]'s</font> 
오늘의 일정<br></b></legend>
		<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
		  <tr>
			<td bgcolor=#ffffe9>
 ";
	if (mysql_num_rows($result_t)) { //오늘일정 있으면..........

		while($today=mysql_fetch_array($result_t))
		{
		
			$memo=nl2br(stripslashes($today[memo])); // br적용


			$list_subject=$today[subject];
			$list_text=$memo;

		$file_name1=$today[file_name1]=stripslashes($today[file_name1]);
		if ($today[file_name1]) { $cal_icon="<img src=".$dir."/icon/".$today[file_name1].".gif border=0>" ;}
		else { $cal_icon = ""; }

	    $query="select name from zetyx_board_category_$id where no='$today[category]'"; //카테고리이름가져오기
		$result1=mysql_query($query, $connect);
		$today_2=mysql_fetch_array($result1);
		$category_name = stripslashes($today_2[0]);

			// $list_subject 제목값  $list_text 내용값

			echo "<?}?><font style='font-family:tahoma;font-size:8pt;font-weight:bold;' class=gray><font color=orange>[$category_name]</font>&nbsp;&nbsp;$cal_icon<font style='font-family:tahoma;font-size:8pt;'>&nbsp; <A HREF='view.php?$href&no=$today[no]' onfocus=blur() >$list_subject</a> <br>$list_text <br> <br></font>";

		}

	}
	
	else { //오늘 일정 없으면 아무것도 출력하지 않음....
		echo "오늘 일정이 없네요.^^
";

	}
			echo "		
</td>
</tr>
</table></fieldset>
</td>
</tr>
</table>
";

}
else {
echo "로그인 해주세요.^^";
}
?>


	<!-- 본문 끝부분 -->
