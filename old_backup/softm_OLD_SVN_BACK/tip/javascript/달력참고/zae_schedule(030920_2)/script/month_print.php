<?

//===========���� ���̺� ǥ��=================//
for($mon=1;$mon<=12;$mon++){


//�̹��� ǥ��
if($mon==$month){
	$m_out_color=$today_out_color;
	$m_over_color=$today_over_color;
	$day_color=$today_color;
}

else {//�̹����� �ƴϸ�...
		$m_out_color=$else_out_color;
		$m_over_color=$else_over_color;
		$day_color=$else_color;
	}


//===========�� ���̴°� (�� �κи� �����ؼ� ����Ұ�)========================

echo "<A HREF='./zboard.php?id=$id&year=$year&month=$mon' onfocus=blur()>
				<font color='$day_color' style='font-family:tahoma;font-size:8pt;font-weight:bold'>$mon ��</font>
			</a>";

//================�� ���̴°�  ��==================================


}

?>
