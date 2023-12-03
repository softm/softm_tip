<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   @include("admin_information.php3");
   
   if (strcmp($session_calendar_admin_login, $admin_name))
      error_message("접근 오류","정상적인 접근이 아닙니다.");
      
   // DB 연결
   @include("../dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // 기존 사용자 조회
   $sql = "SELECT admin_id FROM wscalendar_info WHERE id = '$idx'";
   $result = mysql_query($sql,$dbconn);
   if (!$user_id = @mysql_result($result, 0, "admin_id"))
      error_message("DB 오류","신청하신 ID는 존재하지 않습니다.<BR>관리자에게 문의하십시오.");

   // 사용자 탈퇴, 자료 삭제
   $sql = "DELETE FROM wscalendar_info WHERE id = '$idx'";
   $result = mysql_query($sql,$dbconn);
   if (!$result)
      error_message("DB 오류","Calendar 사용자 삭제 처리를 하지 못했습니다.<BR>DB를 점검하시기 바랍니다.");

   // 사용자 일정 DB Table 삭제
   $sql = "DROP TABLE wscalendar_$user_id";
   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB 오류","Calendar 일정 Data Table 을 삭제하지 못했습니다.<BR>DB를 점검하시기 바랍니다.");

   echo("<meta http-equiv='refresh' content='0; url=admin.php3'>");

   mysql_close($dbconn);
?>