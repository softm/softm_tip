<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   
   if (!$session_calendar_id)
      error_message("���� ����","�������� ������ �ƴմϴ�.");
      
   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // ���� ����� ��ȸ
   $sql = "SELECT bcheck, admin_id, admin_pwd FROM wscalendar_info WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);
   if (!$data = @mysql_fetch_array($result))
      error_message("���� ����","��û�Ͻ� ID�� �������� �ʽ��ϴ�.<BR>�����ڿ��� �����Ͻʽÿ�.");

   // ����� �α��� �����ΰ�?
   if (strcmp($session_calendar_login, $data[bcheck]))
      error_message("���� ����","�������� ������ �ƴմϴ�.");

   if (strcmp($pwd, $data[admin_pwd]))
      error_message("���� ����","��й�ȣ�� Ʋ���ϴ�.<BR>Ȯ���Ͻ� �Ŀ� �ٽ� �õ��� �ֽʽÿ�.");

   // ����� ��й�ȣ�� �ְ�, ��й�ȣ Ȯ�ΰ��� ��ġ�Ѵٸ�..
   if ($cpwd1 && !strcmp($cpwd1, $cpwd2))
      $pwd = $cpwd1;

   // email �ּҰ� �ùٸ��� �ԷµǾ����� �˻��Ѵ�. ���� $email �Է� ���� ��������...
   if ((!eregi("^[_0-9a-z]+(\.[_0-9a-z]+)*@[0-9a-z]+(\.[0-9a-z]+)+$",$email)) && $email)
      error_message("�Է¿���","�Է��Ͻ� <B>'$email'</B> �̸��� �ּҰ� ���Ŀ� ���� �ʽ��ϴ�.<BR>Ȯ���Ͻ� �Ŀ� ��Ȯ�ϰ� �Է��� �ֽʽÿ�.");

   // ����� ���� ����
   $sql  = "UPDATE wscalendar_info SET ";
   $sql .= "admin_pwd = '$pwd',";
   $sql .= "email = '$email',";
   $sql .= "phone = '$phone',";
   $sql .= "zip = '$zip1$zip2',";
   $sql .= "address = '$address' ";
   $sql .= "WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);
   if (!$result)
      error_message("DB ����","Calendar ����� ������ �������� ���߽��ϴ�.<BR>�����ڿ��� �����Ͻʽÿ�.");

   echo("<meta http-equiv='refresh' content='0; url=joins_edit_ok.php3'>");

   mysql_close($dbconn);
?>