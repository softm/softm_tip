<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   // ���� ó�� ��� �ε�
   @include("function_error.inc");

   if (!$db) 
      error_message("���� ����","�������� ������ �ƴմϴ�.<BR>��Ȯ�� ������ �����Ͻ��Ŀ� �ٽ� �̿��Ͻñ� �ٶ��ϴ�.");

   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   $sql  = "DELETE FROM $db WHERE id = '$idx'";
   $result = mysql_query($sql,$dbconn);

   if (!$result) // ������ �߰� ���� ?
      error_message("DB ����","������ ������ �����߽��ϴ�.<BR>����Ŀ� �ٽ� �õ��� �ֽʽÿ�.");

   // ���� ���õ� ��¥�� ������ ������ ���� �����Ѵ�.
   $session_calendar_viewday = $d;

   echo("<meta http-equiv='refresh' content='0; url=schedule_delete_ok.php3?db=$db'>");

   mysql_close($dbconn);
?>