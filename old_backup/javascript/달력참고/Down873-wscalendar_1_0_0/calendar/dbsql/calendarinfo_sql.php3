<?PHP #programmed by WindHunter '97 ?>
<?
   @include("../function_error.inc");
      
   // DB 연결
   @include("../dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // category Table 생성
   $sql  = "CREATE TABLE wscalendar_info (";
   $sql .= "id int(6) NOT NULL auto_increment,";
   $sql .= "bcheck char(9) NOT NULL,";
   $sql .= "admin_id varchar(10) NOT NULL,";
   $sql .= "admin_pwd varchar(13) NOT NULL,";
   $sql .= "name varchar(20) NOT NULL,";
   $sql .= "email varchar(50) NOT NULL,";
   $sql .= "ssn1 char(6) NOT NULL,";
   $sql .= "ssn2 char(7) NOT NULL,";
   $sql .= "phone varchar(13),";
   $sql .= "zip char(6),";
   $sql .= "address varchar(100),";
   $sql .= "jdate varchar(9) NOT NULL,";
   $sql .= "lastdate varchar(9) NOT NULL,";
   $sql .= "UNIQUE id (id, admin_id))";

   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB 오류","Calendar 정보 Table 을 생성하지 못했습니다.");

   echo("<BR>\ncalendar 정보 Table 생성");

   mysql_close($dbconn);
?>