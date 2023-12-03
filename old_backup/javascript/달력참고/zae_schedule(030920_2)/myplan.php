<?
$id=$_POST[id];
$mem_no=$_POST[mem_no];
$plan_no=$_POST[album_no];
if(!$id || !$mem_no || !$plan_no){
$id=$_GET[id];
$mem_no=$_GET[mem_no];
$plan_no=$_GET[plan_no];
}
$guest_no=$_GET[guest_no];
$arrange=$_GET[arrange];
$order=$_GET[order];
$board_name=$_GET[board_name];

if(!$plan_no) $plan_no=1;
if(!$guest_no) $guest_no=$_POST[guest_no];
if(!$guest_no) $guest_no=$mem_no;
$mem_no2= $guest_no ? $guest_no : $mem_no;

if($mem_no=="-1") echo "<script>alert('나의 일정은 회원만 이용 가능합니다.'); window.close(); </script>";
if(!$id || !$mem_no) echo "<script>alert('정상적인 경로로 다시 입장해 주세요.'); window.close();</script>";

require "db_conn.php";
$connect = mysql_connect($host_name, $user_name,$db_password);
mysql_select_db($db_name, $connect);
$result=mysql_query("select name from zetyx_member_table where no='$mem_no'", $connect);
$temp = mysql_fetch_array($result);
?>

<HTML><HEAD><TITLE> <?=$temp[0]?> 님의 일정 </TITLE>
<script language="javascript">
<!--
function openWin(no) {
opener.location.href = "<?=$homepage?>/<?=$zb_dir?>/view.php?id=<?=$id?>&no="+no;
}
//-->
</script> 
<META HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=euc-kr'>
<link rel=StyleSheet href=style.css type=text/css>
<style>
body, table, td, tr, div, span{	font-family:verdana,tahoma;	font-size:8pt;	color:black;	line-height:-1;}
</style>
<img src='./images/myplan.gif' align=absmiddle>
<?

require "./script/cal.php";
$categoryhotday=2;    // 중요일정 입력 된 카테고리 입력 (*수정 요망*)
	
//-------------------------------------함수-------


// 제목 자르기 함수. 추가 함

Function text_cut($sub){

	$max = 24;

	$sub = stripslashes($sub);

	$s_length = strlen($sub);

	if($s_length > $max) {

		for ($pos=$max;$pos>0 && ord($sub[$pos-1])>=127;$pos--);

			if(($max-$pos)%2 == 0) {$sub = substr($sub, 0, $max);}

			else {$sub = substr($sub, 0, $max+1);}

			$sub=$sub."..";

			return $sub;

	}else {

		return $sub;

	}

}



//------------------------------------------------


//그레고리안으로 오늘을 계산(중요일정에서 오늘이후의 일정만 추출하기 위해서임)

$date=date("Ymd");

$t_year=substr($date,0,4);

$t_month=substr($date,4,2);

$t_day=substr($date,6,2);

$total_today=Day_Count($t_year,$t_month,$t_day);

$weekly_day=$total_today+7;
//

	//총 사용일정수 알아내기

	$query_user="SELECT * FROM zetyx_board_$id WHERE ismember = $mem_no";

	$result_user=mysql_query($query_user, $connect);

	$total=mysql_num_rows($result_user);


if(!$want_day)$want_day=(int)$t_day;
$want_month=date("n");
$view_date = "$year/$want_month/$want_day";

	$query_t="select * from zetyx_board_$id where sitelink1='$view_date'";
	$result_t=mysql_query($query_t, $connect);

	if (mysql_num_rows($result_t)) { //오늘일정 있으면..........

		echo "
	<table width=100%  border=0 cellspacing=0 cellpadding=0 id=today>
	  <tr>
			<td valign=top align=center>
			  <fieldset>
  	      <legend><b><img src=./icon/17.gif border=0 align=absmiddle><font style='color:orangered;font-family:tahoma;font-size:8pt;font-weight:bold;'> $t_year 년 $want_month 월 $want_day 일 오늘의 일정</font><br></b></legend>
		<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
		  <tr>
			<td bgcolor=#ffffe9>
 ";

		while($today=mysql_fetch_array($result_t))
		{
		
			$memo=nl2br(stripslashes($today[memo])); // br적용


			$list_subject=$today[subject];
			$list_text=$memo;

		$file_name1=$today[file_name1]=stripslashes($today[file_name1]);
		if ($today[file_name1]) { $cal_icon="<img src=./icon/".$today[file_name1].".gif border=0>" ;}
		else { $cal_icon = ""; }

	    $query="select name from zetyx_board_category_$id where no='$today[category]'"; //카테고리이름가져오기
		$result1=mysql_query($query, $connect);
		$today_2=mysql_fetch_array($result1);
		$category_name = stripslashes($today_2[0]);

			// $list_subject 제목값  $list_text 내용값

			echo "<?}?><font style='font-family:tahoma;font-size:8pt;font-weight:bold;' class=gray><font color=orange>[$category_name]</font>&nbsp;&nbsp;$cal_icon<font style='font-family:tahoma;font-size:8pt;'>&nbsp; 
<A HREF=# onclick=openWin('$today[no]')>$list_subject</a> <br>$list_text <br> <br></font>";

		}
			echo "		
</td>
</tr>
</table></fieldset>
</td>
</tr>
</table><br>
";

	}
	
	else { //이번 달 일기 없으면 아무것도 출력하지 않음....
		echo "
<table width=100%  border=0 cellspacing=0 cellpadding=0 id=today>
  <tr>
		<td valign=top align=center>
		  <fieldset>
 	      <legend><b><img src=./icon/17.gif border=0 align=absmiddle><font style='color:orangered;font-family:tahoma;font-size:8pt;font-weight:bold;'> $t_year 년 $want_month 월 $want_day 일 오늘의 일정</font><br></b></legend>
		<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
		  <tr>
				<td bgcolor=#ffffe9>
					오늘 일정이 없네요.^^
				</td>
			</tr>
		</table>
			</fieldset>
		</td>
	</tr>
</table>
<br>
";

	}

	//중요일정 뽑아오기

	$query_y="SELECT * FROM zetyx_board_$id  WHERE ismember = $mem_no AND category='$categoryhotday'AND sitelink2 >='$total_today' ORDER BY sitelink2";

	$result_y=mysql_query($query_y, $connect);

	$hot_total=mysql_num_rows($result_y);

	if($hot_total==0){$hot_no="<font class=ver9 color=navy>중요일정이 없습니다.</font>";}

	

echo "
	<table width=100%  border=0 cellspacing=0 cellpadding=0 id=hot>
	  <tr>
		<td valign=top align=center>
			<fieldset>
                <legend><div align=left><img src='./icon/13.gif' align=absmiddle> 
		<font style='font-family:tahoma;font-size:8pt;font-weight:bold;' class=royalblue> 
		<font color=orange>$temp[0]'s</font> 중요일정</font></div></legend>
		<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
		  <tr>
			<td bgcolor=f6f6f6>
				<font style='font-family:tahoma;font-size:8pt;font-weight:bold;'>Total&nbsp;&nbsp;:<font color=9d9d9d> $total </font></font><br>
				<font style='font-family:tahoma;font-size:8pt;font-weight:bold;'>Hot&nbsp;&nbsp;:<font color=9d9d9d> $hot_total</font></font><br><br>
			";

	//중요일정이 없을경우

	if($hot_total==0){echo $hot_no;}

	echo "

								<table width=100% border=0>

		";

	//중요일정을 $scale개수만큼 출력

	if($h_first){

		$h_first=0;

	}

	for($i=$h_first; $i<$h_first+$scale; $i++){

		if($i<$hot_total){

			mysql_data_seek($result_y, $i);

			$hot=mysql_fetch_array($result_y);

			$hot_title=text_cut($hot[subject]);

                  $hot_day=$hot[sitelink1];

			$d_day=$hot[sitelink2]-$total_today;

                  $no=$hot[no];

			echo "

									<tr>

										<td>

											<a href=# onclick=openWin('$no') title='$hot[title]'><font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=red>$hot_title</font></a> ($hot_day)

										</td>

										<td width=40>

											<font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=navy>D-$d_day</font>

										</td>

									</tr>



					";

		}

	}

	echo "

								</table>
		</td></tr></table>
	</td></tr></table><br>
		";

//---------------------------------------------------------------------------
	//중요일정 뽑아오기

	$result_z=mysql_query("SELECT * FROM zetyx_board_$id  WHERE sitelink2 >='$total_today' AND sitelink2<'$weekly_day' ORDER BY sitelink2");

	$week_total=mysql_num_rows($result_z);

	if($week_total==0){$hot_no="<font class=ver9 color=navy>중요일정이 없습니다.</font>";}

	

echo "
	<table width=100% border=0 cellspacing=0 cellpadding=0 id=weekly>
	  <tr>
		<td valign=top align=center>
			<fieldset>
                <legend><div align=left><img src='./icon/15.gif' align=absmiddle> <font class=ver9> <b class=royalblue><font color=orange> $temp[0]</font>님의 7일 이내의 일정입니다.</b></font></div></legend>
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

			$week_title=text_cut($week[subject]);

                  $week_day=$week[sitelink1];

			$d_day=$week[sitelink2]-$total_today;

                  $no=$week[no];

			$hot=$week[category];

			if($hot==$categoryhotday){
			
			echo "
									<tr>
										<td>
											<a href=# onclick=openWin('$no') title='$week[title]'><font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=orange>$week_title</font></a> ($week_day)</font>
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
											<a href=# onclick=openWin('$no') title='$week[title]'><font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=orange>$week_title</a></font> ($week_day)</font>
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

?>



