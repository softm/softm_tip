<table cellspacing=0 cellpadding=0 width='<?=$width?>' border=0 align='center'>
	<tr style="display:<?=$display[hide_5]?>;" id="hide_5">
		<td valign=top align=center style=padding-top:5px>
<table cellspacing=0 cellpadding=0 width='100%' border=0 align='center'>
	<tr>
		<td valign=top align=center>
			<fieldset>
  	  	<legend><b><img src=<?=$dir?>/icon/icon_etc.gif><font style='color:hotpink;font-family:tahoma;font-size:8pt;font-weight:bold;'> HELP</font><br></b></legend>
			<table width=100% cellspacing=0 cellpadding=3 bordercolorlight=Gainsboro bordercolordark=white border=1>
				<tr>
					<td bgcolor=#ffffe9 class=tah9>
 �� �������� ���̽ô� ���� ������ �Խ��ǿ� ó�� �����Ͻ� ���̽ʴϴ�.<br> 
�� ������ �Խ����� �湮�ڴ��� ���Ͻô� ������� ������ �� �ֽ��ϴ�.<br> 
��ȫ���� manager ��ư ������ �þ ������ ��ư�� ������ �� ���� ������ ȭ���� �������� �˴ϴ�.<br>
�������� month�� �ش���� ������ �޷¸������ ��µ˴ϴ�.<br>
��Ȳ���� week�� �ְ� ������ �����ݴϴ�.<br>
�Ķ����� list�� �Խ��� ���·� ������ �����ݴϴ�.<br>
������� notice�� ���������� �����ִ� ���̸�, <br>
û������ myplan�� �ڽ��� �߿������� �ֱ� 7�ϳ��� ������ �����ݴϴ�.<br>
�ѹ� ���� ������ �������� ������� �ݺ��˴ϴ�. �ѹ� �����Ͻø� ����ؼ� �� ����� �������� �˴ϴ�.^^<br>
��� ������ ��ġ������ ��ȫ���� manager ��ư�� �����ֽø� �� �������� ������ϴ�.^^

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
		</td>
	</tr>
</table>
<table cellspacing=0 cellpadding=0 width='<?=$width?>' border=0 align='center'>
	<tr style="display:<?=$display[hide_4]?>;" id="hide_4">
		<td valign=top align=center style=padding-top:5px>
<? include "$dir/week.php";?>
		</td>
	</tr>
</table>
<table cellspacing=0 cellpadding=0 width='<?=$width?>' border=0 align='center'>
	<tr style="display:<?=$display[hide_3]?>;" id="hide_3">
		<td valign=top align=center style=padding-top:5px>
<? include "$dir/today.php";?>
<? include "$dir/hot_day.php";?>
<? include "$dir/share.php";?>
		</td>
	</tr>
</table>
<table cellspacing=0 cellpadding=0 width='<?=$width?>' border=0 align='center'>
	<tr style="display:<?=$display[hide_2]?>;" id="hide_2">
		<td valign=top align=center style=padding-top:5px>
<? include "$dir/notice.php";?>
		</td>
	</tr>
</table>

<table width=<?=$width?> border="0" cellspacing="0" cellpadding="0">
  <tr  style="display:<?=$display[hide_0]?>;" id="hide_0">
    <td  style=padding-top:5px>
<table cellspacing=0 cellpadding=0 width='100%' border=1 bordercolor=E6E6E6 style='border-collapse:collapse;' frame=void id=main>
	<tr>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png><font color=red>Sun</font></td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Mon</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Tue</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Wed</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Thu</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png>Fri</td>
		<td align=center height='<?=$td_height_top?>' width='<?=$td_width?>' style='border-right:0;border-left:0;font-family:tahoma;font-size:8pt;font-weight:bold;' background=<?=$dir?>/images/tablehd_bg.png><font color=blue>Sat</font></td>
	</tr>
	<tr>
<?
dbconn();

//count�� <tr>�±׸� �ѱ������ ����. �������� 7�̵Ǹ� <tr>�±׸� �����Ѵ�.

$count=0;

//ù��° �ֿ��� ��ĭ�� 1�������� ��ĭ�� ����
for($i=0; $i<$first; $i++){
	echo "
	<td height='$td_height' width='$td_width' bgcolor=f6f6f6>&nbsp;</td>";
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

<td valign=top bgcolor='$m_out_color' height='$td_height' width='$td_width' onMouseOut=this.style.backgroundColor='' onMouseOver=this.style.backgroundColor='#FBFBFB' style='word-break:break-all;padding:0px;'>";

	$view_date = "$year/$month/$day";
  $d_day = Day_Count($year,$month,$day);
  $lunday=sol2lun($year,$month,$day);

echo "
<table border=0 width=100%><tr><td>
<A HREF='write.php?$href&mode=write&year=$year&month=$month&day=$day&sitelink2=$d_day' onfocus=blur()>
<font color='$day_color' style='font-family:tahoma;font-size:8pt;font-weight:bold'>$day</font></a>
</td>";

if($day==5 || $day==15 || $day==25) 
{ 
echo "
<td align=right>
<font color='indigo' style='font-family:tahoma;font-size:7pt'>    (- $lunday[1]-$lunday[2])</font>
</td>"; 
}
echo "</tr></table>"; 



$query_a="select * from zetyx_board_$id where sitelink1='$view_date'";
$result_a=mysql_query($query_a, $connect);

	while($cal_3=mysql_fetch_array($result_a))
	{


		$file_name1=$cal_3[file_name1]=stripslashes($cal_3[file_name1]);
		if ($cal_3[file_name1]) { $cal_icon="<img src=".$dir."/icon/".$cal_3[file_name1].".gif border=0>" ;}
		else { $cal_icon = ""; }

		$subject=str_replace("\r\n","&lt;br&gt;",$cal_3[subject]);
		$subject=str_replace("'","",$subject);
		$subject=cut_str($subject,$setup[cut_length]);
		list_check(&$cal_3);

	//------�����ڰ� �ƴҶ� ��б� ������ �ٸ��� ���----
		if(!$is_admin) { 
			if($cal_3[is_secret]==1) {
				$subject="��б�"; // ���ϴ� ���뾲����
				$cal_icon="<img src=".$dir."/icon/icon_etc.gif border=0>" ;			}
		}
	//-----------------------------------------------
		//--�ڸ�Ʈ ���� ��������
		$comment = $cal_3[total_comment];
		if (!$comment==0) {
		$comment = "<font class=tah7>[".$comment."]</font>";
		}else{
		$comment ="";
		}
	    $query_a="select name from zetyx_board_category_$id where no='$cal_3[category]'"; //ī�װ��̸���������
		$result1=mysql_query($query_a, $connect);
		$cal_4=mysql_fetch_array($result1);
		$category_name = stripslashes($cal_4[0]);
?>

<?
		echo ("<A HREF='view.php?$href&no=$cal_3[no]' onfocus=blur() ><font color=$category_color>[$category_name]</font><font color=gray>$cal_icon $subject$comment </font></a><br>" );

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
	<td height='$td_height' width='$td_width' bgcolor=f6f6f6>&nbsp;</td>";
		$count++;
}

echo "<tr><td colspan=7 height=2 class='l_light'></td></tr></table>";

?>
<table width=<?=$width?> border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td class='tah9' align=right><? include "$dir/life.php";?></td>
	</tr>
</table>
		</td>
	</tr>
</table>
<table width=<?=$width?> border="0" cellspacing="0" cellpadding="0" >
	<tr height=5><td></td></tr>
  <tr style="display:<?=$display[hide_1]?>;" id="hide_1">
    <td >
<?=$hide_category_start?>
<table width=100% border=0 cellspacing=0 cellpadding=0>
  <tr>
   <td><?=$a_category?></td>
   <td align=right class=tah8>
<b><font color=orangered>Total</font> : <?=$total?> </b>article&nbsp;&nbsp;/&nbsp;&nbsp;
<b><font color=orange>Here</font> : <font color=yellowgreen><?=$page?></font> of <?=$total_page?> </b>pages
	 </td>
  </tr>
</table>
<?=$hide_category_end?>
<table width=100% border=0 cellspacing=0 cellpadding=0 style='border-collapse:collapse;' frame=void id=board>
<col width=30></col><col width=20></col><col width=80></col><col width=110></col><col width=30></col><col width=></col><col width=60></col>
  <tr> 
    <td colspan=7 height=3 bgcolor=silver></td>
  </tr>
  <tr height=20>
    <td class=tah7 align=center><?=$a_no?><b>no</a></td>
    <td  class=tah7 align=center><?=$a_cart?><b>v</a></td>
    <td  class=tah7 align=center><?=$a_name?><b>name</a></td>
    <td  class=tah7 align=center><b>date</b></td>
    <td  class=tah7 align=center><b>icon</b></td>
    <td  class=tah7 align=center><?=$a_subject?><b>schedule</b></a></td>
    <td  class=tah7 align=center><b>d-day</b></td>
  </tr>
  <tr> 
    <td colspan=7 height=2 bgcolor=gray></td>
  </tr>
<! --------------------�� ����(��������������)-------------------- >
<form method=post name=list action=list_all.php>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=selected>
<input type=hidden name=exec>
<input type=hidden name=keyword value="<?=$keyword?>">
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
<! --------------------�� ��(��������������)--------------------- >
