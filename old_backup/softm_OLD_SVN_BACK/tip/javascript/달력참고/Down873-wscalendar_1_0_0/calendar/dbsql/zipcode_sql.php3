<?PHP #programmed by WindHunter '97 ?>
<?
   @include("../function_error.inc");
      
   // DB ����
   @include("../dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // category Table ����
   $sql  = "CREATE TABLE zipcode (";
   $sql .= "code char(7) NOT NULL,";
   $sql .= "city varchar(20) NOT NULL,";
   $sql .= "dong varchar(60) NOT NULL)";

   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB ����","�����ȣ zipcode Table �� �������� ���߽��ϴ�.");

   echo("<BR>\n�����ȣ zipcode Table ����");

   mysql_close($dbconn);
?>