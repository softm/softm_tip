<?
// ��� ���� ���ؿ���;;; ����� ������
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
<font style='color:orangered;font-family:tahoma;font-size:8pt;font-weight:bold;'> $t_year �� $want_month �� $want_day ��</font> 
<font color=orange>$member[name]'s</font> 
������ ����<br></b></legend>
		<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
		  <tr>
			<td bgcolor=#ffffe9>
 ";
	if (mysql_num_rows($result_t)) { //�������� ������..........

		while($today=mysql_fetch_array($result_t))
		{
		
			$memo=nl2br(stripslashes($today[memo])); // br����


			$list_subject=$today[subject];
			$list_text=$memo;

		$file_name1=$today[file_name1]=stripslashes($today[file_name1]);
		if ($today[file_name1]) { $cal_icon="<img src=".$dir."/icon/".$today[file_name1].".gif border=0>" ;}
		else { $cal_icon = ""; }

	    $query="select name from zetyx_board_category_$id where no='$today[category]'"; //ī�װ��̸���������
		$result1=mysql_query($query, $connect);
		$today_2=mysql_fetch_array($result1);
		$category_name = stripslashes($today_2[0]);

			// $list_subject ����  $list_text ���밪

			echo "<?}?><font style='font-family:tahoma;font-size:8pt;font-weight:bold;' class=gray><font color=orange>[$category_name]</font>&nbsp;&nbsp;$cal_icon<font style='font-family:tahoma;font-size:8pt;'>&nbsp; <A HREF='view.php?$href&no=$today[no]' onfocus=blur() >$list_subject</a> <br>$list_text <br> <br></font>";

		}

	}
	
	else { //���� ���� ������ �ƹ��͵� ������� ����....
		echo "���� ������ ���׿�.^^
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
echo "�α��� ���ּ���.^^";
}
?>


	<!-- ���� ���κ� -->
