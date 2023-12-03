<?
// 멤버 정보 구해오기;;; 멤버가 있을때
  $member=member_info();
    if($member[no]) {
       $member[name] = stripslashes($member[name]);
       $member[birth] = stripslashes($member[birth]);

	   $d_birth=date("Y/n/j",$member[birth]);
	   $birth_year=date("Y",$member[birth]);
	   $birth_month=date("n",$member[birth]);
	   $birth_day=date("j",$member[birth]);
//-------------------------------------함수-------

//그레고리안으로 오늘을 계산(중요일정에서 오늘이후의 일정만 추출하기 위해서임)

$total_today=Day_Count($t_year,$t_month,$t_day);
$total_lifeday=Day_Count($birth_year,$birth_month,$birth_day);

$life_count=$total_today-$total_lifeday;		//남은 날짜 계산
	if($mode=="modify"){}
else{
echo "<font class=gray>오늘은 <b class=orange>$member[name]</b>님이 <b class=orangered>빛</b>을 보신지 <b class=royalblue>$life_count</b>일째되는 날입니다.</font>";
}
//
}
else {
echo "";
}
?>

