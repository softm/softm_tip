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
		if(!board_id.value)	alert("������ ����Ͻô� �Խ����� ���̵� �Է����ּ���.");
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
	if( !host_name || !db_name || !user_name || !db_password || !homepage || !zb_dir){	alert("��� ������ �����ϼž� �մϴ�."); return false;}
	else document.form.submit();
}
//--></SCRIPT>
<div id=section align=center>
<?
$mode=$_POST[mode];
if(!$mode) $mode=$_GET[mode];
if(!$mode) $mode=-3;

switch($mode){

	case -3:	 //�ʱ�ȭ��
		echo("<font size=3><b>[zae : Schedule Lv. 4b ]</b></font><BR><BR>zae : Schedule Lv. 4b �� ����ϱ� ���� ������ �����մϴ�.<BR>��~���� ����� �ʴ�ϴ�. �츮 �ʺ��е� �������� ���ð�, <BR>�׳� ���� ���������. ^^*<br><br><BR><BR><b><��������></b> ��ư�� ��������.<br><br><br><input type=button value='��������' onclick='load(-2)'>");
	break;

	case -2: //����� ���� �Է¹ޱ�
		$file = file("../../config.php");		$i=0; 
		while($str=each($file) ){
			$con_info[$i] = $str[1];
			if($i==4) break;
			$i++;
		}

		echo ("<form name=form method=post onsubmit='return check()' action='$PHP_SELF' ><table CELLPADDING=0 CELLSPACING=0>
			<tr><td colspan=2 HEIGHT=30 ALIGN=TOP><b>������ DB�� �����ϱ� ���� �ʿ��� �����Դϴ�.<br>�� �Ʒ� HOMEPAGE�� <font color=red>�ڽ��� Ȩ������</font>�� �Է��Ͻ� �� �������� ��ư�� ��������.</b><BR></tr>
			<tr><td>HOSTNAME</TD><TD><input type=text name=host_name class=text value=$con_info[1]></TD></TR>
			<tr><td>USER NAME</TD><TD><input type=text name=user_name class=text value=$con_info[2]></TD></TR>
			<tr><td>DB PASSWORD</TD><TD><input type=text name=db_password class=text value=$con_info[3]></TD></TR>
			<tr><td>DB NAME</TD><TD><input type=text name=db_name class=text value=$con_info[4]></TD></TR>
			<tr><td></td><td>ex) �ڽ��� DB��</td></tr>
			<tr><td>HOMEPAGE</TD><TD><input type=text name=homepage class=text></TD></TR>
			<tr><td></TD><TD>�ڽ��� Ȩ������ �ּ�<br>ex) http://ingc.new21.net</TD></TR>
			<tr><td>ZERO BOARD DIR</TD><TD><input type=text name=zb_dir class=text></TD></TR>
			<tr><td></td><td>ex) zboard, bbs, zero ���<br> => ���κ����� ���丮��.</td></tr>
			<TR><TD COLSPAN=2 height=40 align=right valign=bottom><input type=submit value='��������'><input type=hidden name=mode value=-1></TD></TR></table></form>");
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
// ���Ϸ� DB ���� ����
		$file_str="./db_conn.php";
		$file = fopen($file_str, "w") or Error("./db_conn.php ���� ���� ����<br><br>���丮�� �۹̼��� 707�� �ֽʽÿ�","");
		fwrite($file, "<?\n");
		fwrite($file, "\$host_name=\"$host_name\";\n");
		fwrite($file, "\$user_name=\"$user_name\";\n");
		fwrite($file, "\$db_password=\"$db_password\";\n");
		fwrite($file, "\$db_name=\"$db_name\";\n");
		fwrite($file, "\$homepage=\"$homepage\";\n");
		fwrite($file, "\$zb_dir=\"$zb_dir\";\n");
		fwrite($file, "?>"); //<?
		fclose($file);

		if($result || $ok)		echo ("�����ͺ��̽� ���ӿ� �����߽��ϴ�.<br>�������� ��ư�� ��������.<br><br><input type=button value='��������' onclick='load(1)'>");
		else echo ("<BR><BR><font color=red>���� �����޽����� �Բ� �� ���� ���δٸ�,<br>�տ��� �����Ͻ� ������ Ʋ�ȴٴ� ���Դϴ�.<br>����ȭ�� ��ư�� ���� �ٽ� �������ּ���.<br><br><br><input type=button value=' ����ȭ�� ' onclick='history.back(-2)'>");
	break;

	case 1://���� ������
		echo("<div align=left>�������� (<b>zae_Schedule v 2.5 �� zae_Schedule 3.x up</b>) �� ��Ų�� ����� �Խ����� �� ���Ŀ� �°� ��ȯ�Ͻ÷��� <��ȯ�ϱ�>��ư�� ��������.<BR><BR>���� ��쿡 �ش���� ������, ������ �Խ����� ����ϼ̴��� ��ȯ�� �Ұ����ϴ�, �������� �ݾ��ּ���.</div><br><br><br><input type=button value='��ȯ�ϱ�' onclick='load(3)'>&nbsp;&nbsp;<input type=button value='�Ϸ�' onclick='load(5)'>");
	break;

	
	case 3://������ �˸�
		echo ("���� �Խ����� ���ο� ������ ���� ������(��ȯ)�մϴ�. <BR><b><u>���� �Խ��� ���̵�</u></b>�� �Է��Ͻ� ��, Ȯ�� ��ư�� ��������.<br><br><br><input type=text id=board_id class=text><input type=button value='Ȯ��' onclick='load(4)'>");
	break;

	case 4://���̺�, �÷����� �� ���� �ڷ� ������

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
					 $result = mysql_query("update zetyx_board_$id set y='$temp' where no='$data[no]'", $connect) or die("������Ʈ ����1 : ".mysql_error());
					 $result = mysql_query("update zetyx_board_$id set subject='$temp2' where no='$data[no]'", $connect) or die("������Ʈ ����1 : ".mysql_error());
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
					 $result = mysql_query("update zetyx_board_$id set sitelink1='$temp1' where no='$data[no]'", $connect) or die("������Ʈ ����1 : ".mysql_error());
					 $result = mysql_query("update zetyx_board_$id set y='$temp3' where no='$data[no]'", $connect) or die("������Ʈ ����1 : ".mysql_error());
				 }
				}
			 }//end of loop
		}
		if($result || (!$result && $connect) ){
			echo("$id �Խ����� ������ �������� �������ϴ�. ��ȯ�ؾ� �� �� �ٸ� �Խ����� �ִٸ�, <��ȯ�ϱ�> ��ư��, �׷��� �ʰ� �۾��� ��ġ���� <�Ϸ�> ��ư�� ��������.<br><br><br><input type=button value='��ȯ�ϱ�' onclick='load(3)'>&nbsp;&nbsp;<input type=button value='�Ϸ�' onclick='load(5)'>");
		}
		mysql_close($connect);
	break;


	case 5:
		 echo ("¦¦¦~ ���� �����ϼ̽��ϴ�~ <br>��� �۾��� ���������� �Ϸ�Ǿ����ϴ�. <br>���� �� ���� ���� �ִ� �����, <br>������ �������� �ϱ⸦ �������� ���ڽ��ϴ�.^-^ <br><br><div align=right>- zae  -</div><br><input type=button value='�ݱ�' onclick='window.close()'>");
	break;
	
}?>
</div>
