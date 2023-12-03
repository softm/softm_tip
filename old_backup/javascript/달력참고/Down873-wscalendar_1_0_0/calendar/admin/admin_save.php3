<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   @include("admin_information.php3");

   if (strcmp($session_calendar_admin_login, $admin_name))
      error_message("접근 오류","정상적인 접근이 아닙니다.");
      
   if ( !strcmp($admin_pwd, str_replace("$", "_", crypt($pwd, "1"))) ) {
      // 관리자 이름(아이디)과 비밀번호를 변경한다.
      if ($cpwd1 && !strcmp($cpwd1, $cpwd2)) $pwd = $cpwd1;

      $fp = fopen("admin_information.php3", "w");
      if ($fp) {
         $str  = "<?php\n";
		 $str .= "   $" . "admin_name=\"$name\";\n;";
		 $str .= "   $" . "admin_pwd =\"" . str_replace("$", "_", crypt($pwd, "1")) . "\";\n";
		 $str .= "?" . ">";

         fputs ($fp, $str);

         // 세션 내용을 변경 저장한다.
         $session_calendar_admin_login = $name;
         session_register("session_calendar_admin_login");

         echo("<meta http-equiv='refresh' content='0; url=admin.php3'>");
      } else
         error_message("DB 오류","설정 변경에 실패했습니다.<BR><BR>설정파일을 열지 못했습니다.");

      fclose ($fp);
   } else 
      error_message("접근 오류","비밀번호가 틀립니다.<BR>확인하신 후에 다시 시도하시기 바랍니다.");
?>