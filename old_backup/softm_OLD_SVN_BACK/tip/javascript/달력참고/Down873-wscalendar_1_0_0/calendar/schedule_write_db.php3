<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   // ���� ó�� ��� �ε�
   @include("function_error.inc");
   @include("function_strcut.inc");

   if (!$db) 
      error_message("���� ����","�������� ������ �ƴմϴ�.<BR>��Ȯ�� ������ �����Ͻ��Ŀ� �ٽ� �̿��Ͻñ� �ٶ��ϴ�.");

   // HTML �ڵ带 ������� ���ϰ� �ϰ�,
   // ���ڿ� ���̸� �����Ѵ�.
   $name  = strcut(htmlspecialchars($title), 50, "");

   if (!$taguse) $taguse = '0';
   if (!$hot) $hot = '0';

   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   $sql  = "INSERT INTO $db VALUES (";
   $sql .= "'',";
   $sql .= "'$title',";
   $sql .= "'$content',";
   $sql .= "'$d',";
   $sql .= "'$t_min:$t_sec',";
   $sql .= "'$hot',";
   $sql .= "'$taguse')";
   $result = mysql_query($sql,$dbconn);

   if (!$result) // ������ �߰� ���� ?
      error_message("DB ����","������ �߰��� �����߽��ϴ�.<BR>����Ŀ� �ٽ� �õ��� �ֽʽÿ�.");

   // ���� ���õ� ��¥�� ������ �߰��� ���� �����Ѵ�.
   $session_calendar_viewday = $d;

   echo("<meta http-equiv='refresh' content='0; url=schedule_write_ok.php3?db=$db'>");

   mysql_close($dbconn);
?>