<?
	echo "<table border=0 >
	<tr><td width=20></td>
";

//count�� <tr>�±׸� �ѱ������ ����. �������� 7�̵Ǹ� <tr>�±׸� �����Ѵ�.

$count=0;

//ù��° �ֿ��� ��ĭ�� 1�������� ��ĭ�� ����
for($i=0; $i<$first; $i++){
	echo "	";
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
//================���뺸�̴°�  ��==================================


	if($count==7 && $day == $total_day ){ //���������� ���
		echo"</tr>";
	}	
	elseif($count==7){ //������� �Ǹ� ���ٲٱ� ���� ��
		echo "";
		$count=0;
	}

}


echo "</table>";

?>
