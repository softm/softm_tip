<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");

   // DB 연결
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   $sql = "SELECT bcheck, admin_id, admin_pwd, name FROM wscalendar_info WHERE admin_id='$id' LIMIT 1";
   $result = @mysql_query($sql,$dbconn);
   $bc = mysql_fetch_array($result);
   if (!$bc)
      error_message("접근 오류","아이디가 존재하지 않습니다.");

   if (!strcmp($pwd, $bc[admin_pwd])) {

      // 마지막 접속 날짜 업데이트..
      $sql = "UPDATE wscalendar_info SET lastdate='" . time() . "' WHERE admin_id = '$id'";
      $result = @mysql_query($sql,$dbconn);

      $session_calendar_viewday = date("Ymd");

      $session_calendar_login = $bc[bcheck];
      $session_calendar_id = $bc[admin_id];
      $session_calendar_name = $bc[name];

      session_register("session_calendar_viewday");
      session_register("session_calendar_login");
      session_register("session_calendar_id");
      session_register("session_calendar_name");

      echo("<meta http-equiv='refresh' content='0; url=calendar.php3'>");
   } else {
      error_message("접근 오류","비밀번호가 틀립니다.");
   }

   mysql_close($dbconn);
?>