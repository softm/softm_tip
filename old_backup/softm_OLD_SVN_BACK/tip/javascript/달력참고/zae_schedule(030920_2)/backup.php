<? 
$id=$_POST[id];
$year=$_POST[year];
$month=$_POST[month];
if(!$id || !$year || !$month){
$id=$_GET[id];
$year=$_GET[year];
$month=$_GET[month];
}
if(!$id || !$year || !$month) echo "<script>alert('�������� ��η� �ٽ� ������ �ּ���.'); window.close();</script>";
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
		<td colspan=7 align=center ><font color=blue><?=$year?>�� <?=$month?>���� ����</font></td>
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

//count�� <tr>�±׸� �ѱ������ ����. �������� 7�̵Ǹ� <tr>�±׸� �����Ѵ�.

$count=0;

//ù��° �ֿ��� ��ĭ�� 1�������� ��ĭ�� ����
for($i=0; $i<$first; $i++){
	echo "
	<td height='$td_height' width='$td_width' bgcolor=gainsboro>&nbsp;</td>";
	$count++;
}

//===========��¥�� ���̺� ǥ��=================//
for($day=1;$day<=$total_day;$day++){
	$count++;


//���� ǥ��
if($day==$t_day && $month==$t_month && $year==$t_year){
	$m_out_color=$today_out_color;
	$m_over_color=$today_over_color;
	$day_color=$today_color;
}

else {//������ �ƴϸ�...

	if ($count==1) {//�Ͽ���
		$m_out_color=$sun_out_color;
		$m_over_color=$sun_over_color;
		$day_color=$sun_color;

	}

	elseif ($count==7) {//�����
		$m_out_color=$sat_out_color;
		$m_over_color=$sat_over_color;
		$day_color=$sat_color;

	}

	else {//����
		$m_out_color=$else_out_color;
		$m_over_color=$else_over_color;
		$day_color=$else_color;
	}

}//������ �ƴϸ�...��

//===========���뺸�̴°� (�� �κи� �����ؼ� ����Ұ�)========================

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

		//--�ڸ�Ʈ ���� ��������
		$comment = $cal[total_comment];
		if (!$comment==0) {
		$comment = "<font class=tah7>[".$comment."]</font>";
		}else{
		$comment ="";
		}
	    $query_c="select name from zetyx_board_category_$id where no='$cal[category]'"; //ī�װ��̸���������
		$result1=mysql_query($query_c, $connect);
		$cal_2=mysql_fetch_array($result1);
		$category_name = stripslashes($cal_2[0]);
?>

<?
		echo ("<font color=$category_color>[$category_name]</font><font color=gray>$subject $comment </font><br>" );

	}


echo "</td>";

//================���뺸�̴°�  ��==================================


	if($count==7 && $day == $total_day ){ //���������� ���
		echo"</tr>";
	}	
	elseif($count==7){ //������� �Ǹ� �ٹٲٱ� ���� <tr>�±� ������ ���� ��
		echo "</tr><tr>";
		$count=0;
	}

}

//������ ���� �������� ������ �����̺� ����
for($day++; $total_day < $day && $count<7; ){
		echo "
	<td height='$td_height' width='$td_width' bgcolor=gainsboro>&nbsp;</td>";
		$count++;
}

echo "<tr><td colspan=7 height=2 class='l_light'></td></tr></table>";

?>

