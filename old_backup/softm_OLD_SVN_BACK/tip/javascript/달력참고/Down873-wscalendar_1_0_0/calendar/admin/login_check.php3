<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");

   // DB ����
   @include("admin_information.php3");

   // ������ ID�� Ʋ���ٸ�
   if (strcmp($id, $admin_name))
      error_message("���� ����","������ ID�� Ʋ���ϴ�.<BR>Ȯ���Ͻ� �Ŀ� �ٽ� �õ��Ͻñ� �ٶ��ϴ�.");

   // ������ ��ȣ�� Ʋ���ٸ�
   if (strcmp(str_replace("$", "_", crypt($pwd,"1")), $admin_pwd))
      error_message("���� ����","������ ��й�ȣ�� Ʋ���ϴ�.<BR>Ȯ���Ͻ� �Ŀ� �ٽ� �õ��Ͻñ� �ٶ��ϴ�.");

   $session_calendar_admin_login = $admin_name;
   session_register("session_calendar_admin_login");

   echo("<meta http-equiv='refresh' content='0; url=admin.php3'>");
?>