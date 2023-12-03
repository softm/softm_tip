<HTML><HEAD><META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=euc-kr">
<style>
body, div, TABLE, TR, TD{font-family:golum, dotum; font-size:9pt; color:#444444;}
input{border=1 solid #444444; background-color:#000000; color: white; font-weight:bold; height:20px;font-size:9pt; width:80;}
#section{color:black;padding:30px;width:400; line-height:180%;}
.text {border=1 solid #444444; background-color:#ffffff; color:black;height:20px; font-size:9pt; width:150;}
</style>
<SCRIPT LANGUAGE="JavaScript"><!--
function load(no){
	if(no==4){
		var board_id=document.getElementById("board_id");
		if(!board_id.value)	alert("기존에 사용하시던 게시판의 아이디를 입력해주세요.");
		else		location.href="<?=$PHP_SELF?>?mode="+no+"&id="+board_id.value;
	}else{location.href="<?=$PHP_SELF?>?mode="+no;}
}
//--></SCRIPT>
</head>
<body><center>
<SCRIPT LANGUAGE="JavaScript"><!--
function check(){
	var host_name = document.all.host_name.value;
	var db_name = document.all.db_name.value;
	var user_name = document.all.user_name.value;
	var db_password = document.all.db_password.value;
	var homepage=document.all.homepage.value;
	var zb_dir=document.all.zb_dir.value;
	if( !host_name || !db_name || !user_name || !db_password || !homepage || !zb_dir){	alert("모든 정보를 기입하셔야 합니다."); return false;}
	else document.form.submit();
}
//--></SCRIPT>
<div id=section align=center>
<?
$mode=$_POST[mode];
if(!$mode) $mode=$_GET[mode];
if(!$mode) $mode=-3;

switch($mode){

	case -3:	 //초기화면
		echo("<font size=3><b>[zae : Schedule Lv. 4b ]</b></font><BR><BR>zae : Schedule Lv. 4b 을 사용하기 위한 셋팅을 시작합니다.<BR>한~개도 어렵지 않답니다. 우리 초보분들 긴장하지 마시고, <BR>그냥 저만 따라오세요. ^^*<br><br><BR><BR><b><다음으로></b> 버튼을 누르세요.<br><br><br><input type=button value='다음으로' onclick='load(-2)'>");
	break;

	case -2: //사용자 정보 입력받기
		$file = file("../../config.php");		$i=0; 
		while($str=each($file) ){
			$con_info[$i] = $str[1];
			if($i==4) break;
			$i++;
		}

		echo ("<form name=form method=post onsubmit='return check()' action='$PHP_SELF' ><table CELLPADDING=0 CELLSPACING=0>
			<tr><td colspan=2 HEIGHT=30 ALIGN=TOP><b>다음은 DB에 접속하기 위해 필요한 정보입니다.<br>맨 아래 HOMEPAGE에 <font color=red>자신의 홈페이지</font>를 입력하신 후 다음으로 버튼을 누르세요.</b><BR></tr>
			<tr><td>HOSTNAME</TD><TD><input type=text name=host_name class=text value=$con_info[1]></TD></TR>
			<tr><td>USER NAME</TD><TD><input type=text name=user_name class=text value=$con_info[2]></TD></TR>
			<tr><td>DB PASSWORD</TD><TD><input type=text name=db_password class=text value=$con_info[3]></TD></TR>
			<tr><td>DB NAME</TD><TD><input type=text name=db_name class=text value=$con_info[4]></TD></TR>
			<tr><td></td><td>ex) 자신의 DB명</td></tr>
			<tr><td>HOMEPAGE</TD><TD><input type=text name=homepage class=text></TD></TR>
			<tr><td></TD><TD>자신의 홈페이지 주소<br>ex) http://ingc.new21.net</TD></TR>
			<tr><td>ZERO BOARD DIR</TD><TD><input type=text name=zb_dir class=text></TD></TR>
			<tr><td></td><td>ex) zboard, bbs, zero 등등<br> => 제로보드의 디렉토리명.</td></tr>
			<TR><TD COLSPAN=2 height=40 align=right valign=bottom><input type=submit value='다음으로'><input type=hidden name=mode value=-1></TD></TR></table></form>");
	break;

	case -1:
//	if(!$host_name || !$db_name || !$user_name || !$db_password ){
		$host_name=$_POST[host_name];
		$db_name=$_POST[db_name];
		$user_name=$_POST[user_name];
		$db_password=$_POST[db_password];
		$homepage=$_POST[homepage];
		$zb_dir=$_POST[zb_dir];
//	}
				 $ok=true;	 //break;
// 파일로 DB 정보 저장
		$file_str="./db_conn.php";
		$file = fopen($file_str, "w") or Error("./db_conn.php 파일 생성 실패<br><br>디렉토리의 퍼미션을 707로 주십시요","");
		fwrite($file, "<?\n");
		fwrite($file, "\$host_name=\"$host_name\";\n");
		fwrite($file, "\$user_name=\"$user_name\";\n");
		fwrite($file, "\$db_password=\"$db_password\";\n");
		fwrite($file, "\$db_name=\"$db_name\";\n");
		fwrite($file, "\$homepage=\"$homepage\";\n");
		fwrite($file, "\$zb_dir=\"$zb_dir\";\n");
		fwrite($file, "?>"); //<?
		fclose($file);

		if($result || $ok)		echo ("데이터베이스 접속에 성공했습니다.<br>다음으로 버튼을 누르세요.<br><br><input type=button value='다음으로' onclick='load(1)'>");
		else echo ("<BR><BR><font color=red>만약 에러메시지와 함께 이 글이 보인다면,<br>앞에서 기입하신 정보가 틀렸다는 뜻입니다.<br>이전화면 버튼을 눌러 다시 기입해주세요.<br><br><br><input type=button value=' 이전화면 ' onclick='history.back(-2)'>");
	break;

	case 1://버전 가리기
		echo("<div align=left>이전버전 (<b>zae_Schedule v 2.5 와 zae_Schedule 3.x up</b>) 의 스킨이 적용된 게시판을 새 형식에 맞게 변환하시려면 <변환하기>버튼을 누르세요.<BR><BR>위의 경우에 해당되지 않으면, 기존에 게시판을 사용하셨더라도 변환이 불가능하니, 페이지를 닫아주세요.</div><br><br><br><input type=button value='변환하기' onclick='load(3)'>&nbsp;&nbsp;<input type=button value='완료' onclick='load(5)'>");
	break;

	
	case 3://컨버팅 알림
		echo ("기존 게시판을 새로운 버전에 맞춰 컨버팅(변환)합니다. <BR><b><u>기존 게시판 아이디</u></b>를 입력하신 후, 확인 버튼을 누르세요.<br><br><br><input type=text id=board_id class=text><input type=button value='확인' onclick='load(4)'>");
	break;

	case 4://테이블, 컬럼생성 및 기존 자료 컨버팅

		require "./db_conn.php";
		$connect = mysql_connect($host_name, $user_name,$db_password);
		mysql_select_db($db_name, $connect );

		$result2 = mysql_query("select no, subject, sitelink1, y from zetyx_board_$id", $connect);
		if($result2){
			while( $data = mysql_fetch_array($result2) ){
				echo mysql_error();
				if(@ereg("/", $data[subject]) ){
				 $info = explode("/", stripslashes($data[subject]) );

				 if( $info[0] && $info[1] ) { 
					 $temp = "$info[0]/$info[1]/$info[2]";
					 $temp2 = $data[sitelink1];
					 $result = mysql_query("update zetyx_board_$id set y='$temp' where no='$data[no]'", $connect) or die("업데이트 실패1 : ".mysql_error());
					 $result = mysql_query("update zetyx_board_$id set subject='$temp2' where no='$data[no]'", $connect) or die("업데이트 실패1 : ".mysql_error());
				 }
				}
			 }//end of loop
		}
		$result3 = mysql_query("select no, subject, sitelink1, y, s_file_name1 from zetyx_board_$id", $connect);
		if($result3){
			while( $data = mysql_fetch_array($result3) ){
				echo mysql_error();
				if(@ereg("/", $data[y]) ){
				 $info = explode("/", stripslashes($data[y]) );

				 if( $info[0] && $info[1] ) { 
					 $temp1 = $data[y];
					 $temp3 = $data[s_file_name1];
					 $result = mysql_query("update zetyx_board_$id set sitelink1='$temp1' where no='$data[no]'", $connect) or die("업데이트 실패1 : ".mysql_error());
					 $result = mysql_query("update zetyx_board_$id set y='$temp3' where no='$data[no]'", $connect) or die("업데이트 실패1 : ".mysql_error());
				 }
				}
			 }//end of loop
		}
		if($result || (!$result && $connect) ){
			echo("$id 게시판의 데이터 컨버팅이 끝났습니다. 변환해야 할 또 다른 게시판이 있다면, <변환하기> 버튼을, 그렇지 않고 작업을 마치려면 <완료> 버튼을 누르세요.<br><br><br><input type=button value='변환하기' onclick='load(3)'>&nbsp;&nbsp;<input type=button value='완료' onclick='load(5)'>");
		}
		mysql_close($connect);
	break;


	case 5:
		 echo ("짝짝짝~ 정말 수고하셨습니다~ <br>모든 작업이 성공적으로 완료되었습니다. <br>지금 이 글을 보고 있는 당신이, <br>정말로 열심으로 일기를 쓰셨으면 좋겠습니다.^-^ <br><br><div align=right>- zae  -</div><br><input type=button value='닫기' onclick='window.close()'>");
	break;
	
}?>
</div>
