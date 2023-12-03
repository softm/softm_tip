<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");

   // DB 연결
   @include("admin_information.php3");

   // 관리자 ID가 틀리다면
   if (strcmp($id, $admin_name))
      error_message("접근 오류","관리자 ID가 틀립니다.<BR>확인하신 후에 다시 시도하시기 바랍니다.");

   // 관리자 암호가 틀리다면
   if (strcmp(str_replace("$", "_", crypt($pwd,"1")), $admin_pwd))
      error_message("접근 오류","관리자 비밀번호가 틀립니다.<BR>확인하신 후에 다시 시도하시기 바랍니다.");

   $session_calendar_admin_login = $admin_name;
   session_register("session_calendar_admin_login");

   echo("<meta http-equiv='refresh' content='0; url=admin.php3'>");
?>