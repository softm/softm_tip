<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   @include("admin_information.php3");
   
   if (strcmp($session_calendar_admin_login, $admin_name))
      error_message("���� ����","�������� ������ �ƴմϴ�.");
      
   // DB ����
   @include("../dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // ���� ����� ��ȸ
   $sql = "SELECT admin_id FROM wscalendar_info WHERE id = '$idx'";
   $result = mysql_query($sql,$dbconn);
   if (!$user_id = @mysql_result($result, 0, "admin_id"))
      error_message("DB ����","��û�Ͻ� ID�� �������� �ʽ��ϴ�.<BR>�����ڿ��� �����Ͻʽÿ�.");

   // ����� Ż��, �ڷ� ����
   $sql = "DELETE FROM wscalendar_info WHERE id = '$idx'";
   $result = mysql_query($sql,$dbconn);
   if (!$result)
      error_message("DB ����","Calendar ����� ���� ó���� ���� ���߽��ϴ�.<BR>DB�� �����Ͻñ� �ٶ��ϴ�.");

   // ����� ���� DB Table ����
   $sql = "DROP TABLE wscalendar_$user_id";
   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB ����","Calendar ���� Data Table �� �������� ���߽��ϴ�.<BR>DB�� �����Ͻñ� �ٶ��ϴ�.");

   echo("<meta http-equiv='refresh' content='0; url=admin.php3'>");

   mysql_close($dbconn);
?>