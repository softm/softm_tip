<?

$categoryhotday=2;    // 중요일정 입력 된 카테고리 입력 (*수정 요망*)
	
// 멤버 정보 구해오기;;; 멤버가 있을때
        $member=member_info();

        if($member[no]) {

        $member[name] = stripslashes($member[name]);


//그레고리안으로 오늘을 계산(중요일정에서 오늘이후의 일정만 추출하기 위해서임)

$date=date("Ymd");

$t_year=substr($date,0,4);

$t_month=substr($date,4,2);

$t_day=substr($date,6,2);

$total_today=Day_Count($t_year,$t_month,$t_day);

$weekly_day=$total_today+7;
//

	//총 사용일정수 알아내기

	$query_user="SELECT * FROM zetyx_board_$id WHERE ismember = $member[no]";

	$result_user=mysql_query($query_user, $connect);

	$total=mysql_num_rows($result_user);

	//일정 뽑아오기

	$result_z=mysql_query("SELECT * FROM zetyx_board_$id  WHERE ismember = $member[no] AND sitelink2 >='$total_today' AND sitelink2<'$weekly_day' ORDER BY sitelink2");

	$week_total=mysql_num_rows($result_z);

	if($week_total==0){$week_no="<font class=ver9 color=navy>기간 내에 일정이 없습니다.</font>";}

	

echo "
	<table width=$width  border=0 cellspacing=0 cellpadding=0 id=weekly>
	  <tr>
		<td valign=top align=center>
			<fieldset>
                <legend><div align=left><img src='$dir/icon/icon_general_schedule.gif' align=absmiddle> <font class=ver9> <b class=royalblue><font color=orange> $member[name]</font>님의 7일 이내의 일정입니다.</b></font></div></legend>
		<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
		  <tr>
			<td bgcolor=f6f6f6>
				<b class=tah8>Total :<font color=9d9d9d> $week_total </font></b><br><br>
			";

	//중요일정이 없을경우

	if($week_total==0){echo $week_no;}

	echo "

								<table width=100% border=0 cellspacing=0 cellpadding=0>

		";

	//중요일정을 $scale개수만큼 출력

	if($w_first){

		$w_first=0;

	}

	for($i=$w_first; $i<$w_first+$scale; $i++){

		if($i<$week_total){

			mysql_data_seek($result_z, $i);

			$week=mysql_fetch_array($result_z);

			$week_title=$week[subject];

                  $week_day=$week[sitelink1];

			$d_day=$week[sitelink2]-$total_today;

                  $no=$week[no];

			$hot=$week[category];

			if($hot==$categoryhotday){
			
			echo "
									<tr>
										<td>
											<a href='./view.php?$href&no=$no' title='$week[title]'><font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=orange>$week_title</font></a> ($week_day)</font>
										</td>
										<td width=40>
											<font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=navy>D-$d_day<font color=red>*<font></font>
										</td>
									</tr>
					";
			}else{
			echo "
									<tr>
										<td>
											<a href='./view.php?$href&no=$no' title='$week[title]'><font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=orange>$week_title</a></font> ($week_day)</font>
										</td>
										<td width=40>
											<font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=navy>D-$d_day</font>
										</td>
									</tr>
					";

			}

		}

	}

	echo "
       <tr><td height=20 class=gray1 align=right><font color=red>*</font>&nbsp;: 중요일정</td></tr></table>
		</td></tr></table>
	</td></tr></table>
		";

//---------------------------------------------------------------------------
}
else {
echo "";
}
?>
