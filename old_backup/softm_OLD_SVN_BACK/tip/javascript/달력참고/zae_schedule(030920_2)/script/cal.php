<?


//이 부분만 수정하세요^^
      // 중요일정 출력개수
	$scale=5;

	//테이블 테두리 칼라
	$bordercolordark="#FFFFFF";
	$bordercolorlight="#999999";

	//테이블 크기
      $td_width ="14%";
	$td_height_top="25";
	$td_height="80";


	//오늘날짜 색
	$today_color="00CC00";
	$today_out_color="#ffffe9";
	$today_over_color="#ffffe9";

	//일요일 색
	$sun_color="orangered";
	$sun_bgcolor="#FFFFFF";
	$sun_out_color="#FFFFFF";
	$sun_over_color="#FFFFFF";

	//토요일 색
	$sat_color="royalblue";
	$sat_bgcolor="#FFFFFF";
	$sat_out_color="#FFFFFF";
	$sat_over_color="#FFFFFF";

	//나머지 날짜 색
	$else_color="gray";
	$else_bgcolor="#FFFFFF";
	$else_out_color="#FFFFFF";
	$else_over_color="#FFFFFF";

	//카테고리 색
	$category_color="olive";

	// 내용출력 생략 글길이
	$max = 20;



//한달의 총 날짜 계산 함수
function Month_Day($i_month,$i_year){
	$day=1;
	while(checkdate($i_month,$day,$i_year)){
		$day++;
	}
		$day--;
		return $day;
}



//오늘 날짜를 년월일별로 구하기
$today=date("Ymd");
$t_year=substr($today,0,4);
$t_month=substr($today,4,2);
$t_day=substr($today,6,2);

//month와 year의 변수값이 지정되어있지 않으면 오늘로 지정.
if(!$month)$month=(int)$t_month;
if(!$year)$year=$t_year;
$day=$t_day;

//선택한 월의 총 일수를 구함.
$total_day=Month_Day($month,$year);

//선택한 월의 1일의 요일을 구함. 일요일은 0.
$first=date(w,mktime(0,0,0,$month,1,$year));

//윤년 확인
//if($month==2){
//	if(!($year%4))$total_day++;
//	if(!($year%100))$total_day--;
//	if(!($year%400))$total_day++;
//}

//지난해와 다음해를 보는 루틴
	$year_prev=$year-1;
	$year_next=$year+1;

///////날짜계산 함수///////////////////////////

function Day_Count($year,$month,$day)

{

	if($month<=2)

	{

		$month+=12;

		$year--;

	}

	$a=(int)($year/100);

	$b=2-$a+(int)($a/4);

	$daycount=(int)(365.25*($year+4716))+(int)(30.6001*($month+1))+$day+$b-1524.5 ;

	return $daycount;

}


?>
