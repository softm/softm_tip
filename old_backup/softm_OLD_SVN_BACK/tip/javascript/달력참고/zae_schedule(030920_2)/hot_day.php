<?

$categoryhotday=2;    // �߿����� �Է� �� ���װ� �Է� (*���� ���*)
	
// ��� ���� ���ؿ���;;; ����� ������
        $member=member_info();

        if($member[no]) {

        $member[name] = stripslashes($member[name]);

//-------------------------------------�Լ�-------



//------------------------------------------------



//�׷��������� ������ ���(�߿��������� ���������� ������ �����ϱ� ���ؼ���)

$date=date("Ymd");

$t_year=substr($date,0,4);

$t_month=substr($date,4,2);

$t_day=substr($date,6,2);

$total_today=Day_Count($t_year,$t_month,$t_day);

//

	//�� ��������� �˾Ƴ���

	$query_user="SELECT * FROM zetyx_board_$id WHERE ismember = $member[no]";

	$result_user=mysql_query($query_user, $connect);

	$total=mysql_num_rows($result_user);

	//�߿����� �̾ƿ���

	$query_y="SELECT * FROM zetyx_board_$id  WHERE ismember = $member[no] AND category='$categoryhotday'AND sitelink2 >='$total_today' ORDER BY sitelink2";

	$result_y=mysql_query($query_y, $connect);

	$hot_total=mysql_num_rows($result_y);

	if($hot_total==0){$hot_no="<font class=ver9 color=navy>�߿������� �����ϴ�.</font>";}

	

echo "
	<table width=100%  border=0 cellspacing=0 cellpadding=0>
	  <tr>
		<td valign=top align=center>
			<fieldset>
                <legend><div align=left><img src='$dir/icon/icon_special.gif' align=absmiddle> 
		<font style='font-family:tahoma;font-size:8pt;font-weight:bold;' class=royalblue> 
		<font color=orange>$member[name]'s</font> <font color=orangered>Hot</font> Schedule</font></div></legend>
		<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
		  <tr>
			<td bgcolor=f6f6f6>
				<font style='font-family:tahoma;font-size:8pt;font-weight:bold;'>Total&nbsp;&nbsp;:<font color=9d9d9d> $total </font></font><br>
				<font style='font-family:tahoma;font-size:8pt;font-weight:bold;'>Hot&nbsp;&nbsp;:<font color=9d9d9d> $hot_total</font></font><br><br>
			";

	//�߿������� �������

	if($hot_total==0){echo $hot_no;}

	echo "

								<table width=100% border=0>

		";

	//�߿������� $scale������ŭ ���

	if($h_first){

		$h_first=0;

	}

	for($i=$h_first; $i<$h_first+$scale; $i++){

		if($i<$hot_total){

			mysql_data_seek($result_y, $i);
			$hot=mysql_fetch_array($result_y);
			$hot_title=$hot[sitelink1];
      $hot_day=$hot[subject];
			$d_day=$hot[sitelink2]-$total_today;
      $no=$hot[no];

			echo "
									<tr>
										<td>
											<a href='./view.php?$href&no=$no' title='$hot[title]'><font style='font-family:tahoma;font-size:8pt;font-weight:bold;'><font color=red>$hot_title</font></a> ($hot_day)
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
	</td></tr></table>
		";
//---------------------------------------------------------------------------
}
else {
echo "";
}
?>
