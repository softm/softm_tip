<?
// ��� ���� ���ؿ���;;; ����� ������
  $member=member_info();
    if($member[no]) {
       $member[name] = stripslashes($member[name]);
       $member[birth] = stripslashes($member[birth]);

	   $d_birth=date("Y/n/j",$member[birth]);
	   $birth_year=date("Y",$member[birth]);
	   $birth_month=date("n",$member[birth]);
	   $birth_day=date("j",$member[birth]);
//-------------------------------------�Լ�-------

//�׷��������� ������ ���(�߿��������� ���������� ������ �����ϱ� ���ؼ���)

$total_today=Day_Count($t_year,$t_month,$t_day);
$total_lifeday=Day_Count($birth_year,$birth_month,$birth_day);

$life_count=$total_today-$total_lifeday;		//���� ��¥ ���
	if($mode=="modify"){}
else{
echo "<font class=gray>������ <b class=orange>$member[name]</b>���� <b class=orangered>��</b>�� ������ <b class=royalblue>$life_count</b>��°�Ǵ� ���Դϴ�.</font>";
}
//
}
else {
echo "";
}
?>

