<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   
   if (!$session_calendar_login)
      error_message("접근 오류","정상적인 접근이 아닙니다.");
      
   // DB 연결
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // 기존 사용자 조회
   $sql = "SELECT bcheck, admin_id, admin_pwd FROM wscalendar_info WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);
   if (!$data = @mysql_fetch_array($result))
      error_message("수정 오류","신청하신 ID는 존재하지 않습니다.<BR>관리자에게 문의하십시오.");

   // 사용자 로그인 상태인가?
   if (strcmp($session_calendar_login, $data[bcheck]))
      error_message("접근 오류","정상적인 접근이 아닙니다.");

   if (strcmp($pwd, $data[admin_pwd]))
      error_message("접근 오류","비밀번호가 틀립니다.<BR>확인하신 후에 다시 시도해 주십시오.");

   // 사용자 탈퇴, 자료 삭제
   $sql = "DELETE FROM wscalendar_info WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);
   if (!$result)
      error_message("DB 오류","Calendar 사용자 탈퇴 처리를 하지 못했습니다.<BR>관리자에게 문의하십시오.");

   // 사용자 일정 DB Table 삭제
   $sql = "DROP TABLE wscalendar_$session_calendar_id";
   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB 오류","Calendar 일정 Data Table 을 삭제하지 못했습니다.<BR>관리자에게 문의하십시오.");

   echo("<meta http-equiv='refresh' content='0; url=joins_delete_ok.php3'>");

   mysql_close($dbconn);
?>