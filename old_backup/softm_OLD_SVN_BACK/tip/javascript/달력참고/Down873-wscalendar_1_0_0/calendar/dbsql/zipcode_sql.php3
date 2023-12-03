<?PHP #programmed by WindHunter '97 ?>
<?
   @include("../function_error.inc");
      
   // DB 연결
   @include("../dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // category Table 생성
   $sql  = "CREATE TABLE zipcode (";
   $sql .= "code char(7) NOT NULL,";
   $sql .= "city varchar(20) NOT NULL,";
   $sql .= "dong varchar(60) NOT NULL)";

   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB 오류","우편번호 zipcode Table 을 생성하지 못했습니다.");

   echo("<BR>\n우편번호 zipcode Table 생성");

   mysql_close($dbconn);
?>