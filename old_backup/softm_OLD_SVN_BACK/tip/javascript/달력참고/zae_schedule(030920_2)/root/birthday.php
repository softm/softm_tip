<?
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

	// ���� ������ �ϳ��� �۷� ����� ���� SQL�� �־��ִ� ���α׷��Դϴ�.
	// ���κ����� list_head.php�� write.php�� write_ok.php�� �ҽ��� �м��ϰ� ¥����� �ۼ��� �ð��� �� ������ϴ�.
	// 2002�� 4�� 4�� ��öȯ

		include "lib.php";
		include "luncal.inc";
		$connect=dbConn();
		$member=member_info();
	
	// ��ü �׷���� ���� �׷��� ������ ����
		$tmpResult = mysql_fetch_array(mysql_query("select count(*) from $group_table"));
		$total_group_num = $tmpResult[0];
		$group_data = mysql_fetch_array(mysql_query("select * from $group_table where no='$group_no'"));
	
		$temp=mysql_fetch_array(mysql_query("select count(*) from $member_table"));
		$total_member=$temp[0];
	
	  
	// ��������� ���ؿ�
		$result=mysql_query("select * from $member_table",$connect) or Error(mysql_error(),"");
	
	// ���⼭ ���� ȸ���� ������ �޷¿� �����Ѵ�.
	  while($data=mysql_fetch_array($result))
	  {

	   $d_birth=date("Y/n/j",$data[birth]);
	   $birth_month=date("n",$data[birth]);
	   $birth_day=date("j",$data[birth]);

	   $today_year=date("Y");
	   $today_month=date("m");
	   $today_day=date("d");
	
if($data[lunar]==1){
      $birth_lunday=lun2sol($today_year,$birth_month,$birth_day);

			$view_date="$today_year/$birth_lunday[1]/$birth_lunday[2]";
			$memo=$data[name]."���� ������ �������� �����մϴ�!!<br><div align=right><font color=red>(<img src=skin/zae_schedule/icon/icon_luna.gif>���� ".$birth_month."�� ".$birth_day."��)</font></div>" ;
			$sitelink2=Day_Count($today_year,$birth_lunday[1],$birth_lunday[2]);
} else {
			$view_date="$today_year/$birth_month/$birth_day";
			$memo=$data[name]."���� ������ �������� �����մϴ�!!";
			$sitelink2=Day_Count($today_year,$birth_month,$birth_day);
}

	 
	   $query="select * from zetyx_board_$id where sitelink1='$view_date'";
	   $result2=mysql_query($query, $connect);
	 
			//���� ��¥�� �ִ� ������ ���� ���� �׿� ���� ���� sitelink2�� ����
	
			$count=mysql_num_rows($result2); 
			$zx=$count+1;
			$file_name1="icon_birth";
			
			
			//������ �Էºκ�
			$name=$member[name];
			$password=$member[password];
			$subject=$data[name]." ����";
			$sitelink1=$view_date;
			
			$query2="select * from zetyx_board_$id where memo='$memo'";
			$result3=mysql_query($query2, $connect);

	// �ߺ��� ���� ������ ��� üũ

			if (!mysql_num_rows($result3)) { 
			$cate_temp=mysql_fetch_array(mysql_query("select min(no) from $t_category"."_$id",$connect));
			$category=$cate_temp[0];
	
			//�н����带 ��ȣȭ
			if ($password) { $temp=mysql_fetch_array(mysql_query("select password('$password')")); $password=$temp[0]; }

			//������ �Է� ���
			$email=$member[email];
			$homepage-$member[homepage];
			$ip=$REMOTE_ADDR;
			$reg_date=time();
			$x=$zx;
			$y=$zy;
	
			$cate_temp=mysql_fetch_array(mysql_query("select min(no) from $t_category"."_$id",$connect));
			$category=$cate_temp[0];
	
			// ��Ű ����;;
			// 4.0x �� ���� ó��
			if($name) { $zb_writer_name = $name; session_register("zb_writer_name"); }
			if($email) { $zb_writer_email = $email; 	session_register("zb_writer_email"); }
			if($homepage) { $zb_writer_homepage = $homepage; session_register("zb_writer_homepage"); }
			// ����Ÿ ��������
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id"));
			$max_division=$temp[0];
			$temp=mysql_fetch_array(mysql_query("select max(division) from $t_division"."_$id where num>0 and division!='$max_division'"));
			if(!$temp[0]) $second_division=0; else $second_division=$temp[0];
			$max_headnum=mysql_fetch_array(mysql_query("select min(headnum) from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum>-2000000000"));
			if(!$max_headnum[0]) $max_headnum[0]=0;
			$headnum=$max_headnum[0]-1;
			$next_data=mysql_fetch_array(mysql_query("select division,headnum,arrangenum from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum>-2000000000 order by headnum limit 1"));
			if(!$next_data[0]) $next_data[0]="0";
			else {
				$next_data=mysql_fetch_array(mysql_query("select no,headnum,division from $t_board"."_$id where division='$next_data[division]' and headnum='$next_data[headnum]' and arrangenum='$next_data[arrangenum]'"));
			}
			$prev_data=mysql_fetch_array(mysql_query("select no from $t_board"."_$id where (division='$max_division' or division='$second_division') and headnum<=-2000000000 order by headnum desc limit 1"));
			if($prev_data[0]) $prev_no=$prev_data[0]; else $prev_no="0";
	
			$next_no=$next_data[no];
			$child="0";
			$depth="0";
			$arrangenum="0";
			$father="0";
			$division=add_division();
		
			mysql_query("insert into $t_board"."_$id (division,headnum,arrangenum,depth,prev_no,next_no,father,child,ismember,memo,ip,password,name,homepage,email,subject,use_html,reply_mail,category,is_secret,sitelink1,sitelink2,file_name1,file_name2,s_file_name1,s_file_name2,x,y,reg_date,islevel) values ('$division','$headnum','$arrangenum','$depth','$prev_no','$next_no','$father','$child','$member[no]','$memo','$ip','$password','$name','$homepage','$email','$subject','$use_html','$reply_mail','$category','$is_secret','$sitelink1','$sitelink2','$file_name1','$file_name2','$s_file_name1','$s_file_name2','$x','$y','$reg_date','$member[is_admin]')") or error(mysql_error());
			$no=mysql_insert_id();
	
			if($prev_no) mysql_query("update $t_board"."_$id set next_no='$no' where no='$prev_no'");
			if($next_no) mysql_query("update $t_board"."_$id set prev_no='$no' where headnum='$next_data[headnum]' and division='$next_data[division]'");
			mysql_query("update $t_category"."_$id set num=num+1 where no='$category'",$connect);
	
			// ���� ������ �ٽ� ����
			$total=mysql_fetch_array(mysql_query("select count(*) from $t_board"."_$id "));
			mysql_query("update $admin_table set total_article='$total[0]' where name='$id'");

			}

	}
	
	// MySQL �ݱ� 
		if($connect) {
			mysql_close($connect); 
			unset($connect);
		}
	
	// ������ �̵�
		$view_file = "zboard.php";
		movepage($view_file."?id=$id");

?>
