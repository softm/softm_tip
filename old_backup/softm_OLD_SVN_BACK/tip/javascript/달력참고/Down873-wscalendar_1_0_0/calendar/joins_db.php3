<?PHP #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   @include("function_strcut.inc");
      
   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // ���� ����� ��ȸ
   $sql = "SELECT admin_id FROM wscalendar_info WHERE admin_id = '$id'";
   $result = mysql_query($sql,$dbconn);
   if (@mysql_fetch_array($result))
      error_message("���� ����","��û�Ͻ� ID�� �̹� �ٸ� ����ڰ� ������Դϴ�.<BR>�ٸ� ID�� �ٽ� ��û�Ͻñ� �ٶ��ϴ�.");

   $sql = "SELECT id FROM wscalendar_info WHERE ssn1 = '$ssn1' AND ssn2 = '$ssn2'";
   $result = mysql_query($sql,$dbconn);
   if (@mysql_fetch_array($result))
      error_message("���� ����","��û�Ͻ� �ֹε�Ϲ�ȣ�� �̹� ��ϵ� ��ȣ�Դϴ�.<BR>�����ڿ��� �����Ͻñ� �ٶ��ϴ�.");

   // ����� ID �� ������ ���ڷθ� �����Ǿ����� �˻�..
   if (!eregi("^[a-z0-9]+$", $id))
      error_message("�Է� ����","�Է��Ͻ� ID : <B>'$id'</B> �� ���Ŀ� ���� �ʽ��ϴ�.<BR>ID�� ���� & ���ڷθ� ��û�� �����մϴ�.");

   // email �ּҰ� �ùٸ��� �ԷµǾ����� �˻��Ѵ�. ���� $email �Է� ���� ��������...
   if ((!eregi("^[_0-9a-z]+(\.[_0-9a-z]+)*@[0-9a-z]+(\.[0-9a-z]+)+$",$email)) && $email) 
      error_message("�Է� ����","�Է��Ͻ� <B>'$email'</B> �̸��� �ּҰ� ���Ŀ� ���� �ʽ��ϴ�.<BR>Ȯ���Ͻ� �Ŀ� ��Ȯ�ϰ� �Է��� �ֽʽÿ�.");

   //
   $name    = strcut(htmlspecialchars($name), 20, "");
   $address = strcut(htmlspecialchars($address), 100, "");

   $sql  = "INSERT INTO wscalendar_info VALUES (";
   $sql .= "'',";
   $sql .= "'".time()."',";
   $sql .= "'$id',";
   $sql .= "'$pwd',";
   $sql .= "'$name',";
   $sql .= "'$email',";
   $sql .= "'$ssn1',";
   $sql .= "'$ssn2',";
   $sql .= "'$phone',";
   $sql .= "'$zip1$zip2',";
   $sql .= "'$address',";
   $sql .= "'".time()."',";
   $sql .= "'".time()."')";
   $result = mysql_query($sql,$dbconn);
   if (!$result)
      error_message("DB ����","Calendar ����� ������ �߰����� ���߽��ϴ�.");

   // ���� ���� ����� Table ����
   $sql  = "CREATE TABLE wscalendar_$id (";
   $sql .= "id int(6) NOT NULL auto_increment,";
   $sql .= "title varchar(50) NOT NULL,";
   $sql .= "memo text NOT NULL,";
   $sql .= "wdate varchar(11) NOT NULL,";
   $sql .= "stime char(5) NOT NULL,";
   $sql .= "hot enum('0','1') DEFAULT 0 NOT NULL,";
   $sql .= "taguse enum('0','1') DEFAULT 0 NOT NULL,";
   $sql .= "UNIQUE id (id))";

   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB ����","Calendar ���� Data Table �� �������� ���߽��ϴ�.");


   echo("<meta http-equiv='refresh' content='0; url=joins_ok.php3'>");

   mysql_close($dbconn);
?>