<?


//�� �κи� �����ϼ���^^
      // �߿����� ��°���
	$scale=5;

	//���̺� �׵θ� Į��
	$bordercolordark="#FFFFFF";
	$bordercolorlight="#999999";

	//���̺� ũ��
      $td_width ="14%";
	$td_height_top="25";
	$td_height="80";


	//���ó�¥ ��
	$today_color="00CC00";
	$today_out_color="#ffffe9";
	$today_over_color="#ffffe9";

	//�Ͽ��� ��
	$sun_color="orangered";
	$sun_bgcolor="#FFFFFF";
	$sun_out_color="#FFFFFF";
	$sun_over_color="#FFFFFF";

	//����� ��
	$sat_color="royalblue";
	$sat_bgcolor="#FFFFFF";
	$sat_out_color="#FFFFFF";
	$sat_over_color="#FFFFFF";

	//������ ��¥ ��
	$else_color="gray";
	$else_bgcolor="#FFFFFF";
	$else_out_color="#FFFFFF";
	$else_over_color="#FFFFFF";

	//ī�װ� ��
	$category_color="olive";

	// ������� ���� �۱���
	$max = 20;



//�Ѵ��� �� ��¥ ��� �Լ�
function Month_Day($i_month,$i_year){
	$day=1;
	while(checkdate($i_month,$day,$i_year)){
		$day++;
	}
		$day--;
		return $day;
}



//���� ��¥�� ����Ϻ��� ���ϱ�
$today=date("Ymd");
$t_year=substr($today,0,4);
$t_month=substr($today,4,2);
$t_day=substr($today,6,2);

//month�� year�� �������� �����Ǿ����� ������ ���÷� ����.
if(!$month)$month=(int)$t_month;
if(!$year)$year=$t_year;
$day=$t_day;

//������ ���� �� �ϼ��� ����.
$total_day=Month_Day($month,$year);

//������ ���� 1���� ������ ����. �Ͽ����� 0.
$first=date(w,mktime(0,0,0,$month,1,$year));

//���� Ȯ��
//if($month==2){
//	if(!($year%4))$total_day++;
//	if(!($year%100))$total_day--;
//	if(!($year%400))$total_day++;
//}

//�����ؿ� �����ظ� ���� ��ƾ
	$year_prev=$year-1;
	$year_next=$year+1;

///////��¥��� �Լ�///////////////////////////

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
