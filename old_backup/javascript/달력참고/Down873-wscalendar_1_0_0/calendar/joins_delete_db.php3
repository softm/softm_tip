<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   
   if (!$session_calendar_login)
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

   // ����� Ż��, �ڷ� ����
   $sql = "DELETE FROM wscalendar_info WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);
   if (!$result)
      error_message("DB ����","Calendar ����� Ż�� ó���� ���� ���߽��ϴ�.<BR>�����ڿ��� �����Ͻʽÿ�.");

   // ����� ���� DB Table ����
   $sql = "DROP TABLE wscalendar_$session_calendar_id";
   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB ����","Calendar ���� Data Table �� �������� ���߽��ϴ�.<BR>�����ڿ��� �����Ͻʽÿ�.");

   echo("<meta http-equiv='refresh' content='0; url=joins_delete_ok.php3'>");

   mysql_close($dbconn);
?>