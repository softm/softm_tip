<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   @include("admin_information.php3");

   if (strcmp($session_calendar_admin_login, $admin_name))
      error_message("���� ����","�������� ������ �ƴմϴ�.");
      
   if ( !strcmp($admin_pwd, str_replace("$", "_", crypt($pwd, "1"))) ) {
      // ������ �̸�(���̵�)�� ��й�ȣ�� �����Ѵ�.
      if ($cpwd1 && !strcmp($cpwd1, $cpwd2)) $pwd = $cpwd1;

      $fp = fopen("admin_information.php3", "w");
      if ($fp) {
         $str  = "<?php\n";
		 $str .= "   $" . "admin_name=\"$name\";\n;";
		 $str .= "   $" . "admin_pwd =\"" . str_replace("$", "_", crypt($pwd, "1")) . "\";\n";
		 $str .= "?" . ">";

         fputs ($fp, $str);

         // ���� ������ ���� �����Ѵ�.
         $session_calendar_admin_login = $name;
         session_register("session_calendar_admin_login");

         echo("<meta http-equiv='refresh' content='0; url=admin.php3'>");
      } else
         error_message("DB ����","���� ���濡 �����߽��ϴ�.<BR><BR>���������� ���� ���߽��ϴ�.");

      fclose ($fp);
   } else 
      error_message("���� ����","��й�ȣ�� Ʋ���ϴ�.<BR>Ȯ���Ͻ� �Ŀ� �ٽ� �õ��Ͻñ� �ٶ��ϴ�.");
?>