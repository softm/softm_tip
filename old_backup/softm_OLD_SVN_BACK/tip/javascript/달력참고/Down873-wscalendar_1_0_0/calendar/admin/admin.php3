<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   // admin_information.php3 ������ ���ٸ� ���� �����.
   $fp = @fopen("admin_information.php3", "r");
   if (!$fp) { 
      $fp = @fopen("admin_information.php3", "w");
      // ���� ���⿡ �����ߴٸ�
      if ($fp) {
         // admin_name, admin_pwd ���� �ʱⰪ���� �����Ѵ�.
         // admin_pwd �� crypt() �Լ��� ��ȣȭ �ؼ� ����
         $str  = "<?php\n";
		 $str .= "   $" . "admin_name=\"master\";\n;";
		 $str .= "   $" . "admin_pwd =\"" . str_replace("$", "_", crypt("0000", "1")) . "\";\n";
		 $str .= "?" . ">";

         fputs ($fp, $str);
      }
   }
   @fclose($fp);

   // ������ ���� ���� �ε�
   @include("admin_information.php3");

   // ������ �α��� ���°� �ƴ϶��.. �α��� �������� �ѱ��..
   if (strcmp($session_calendar_admin_login, $admin_name)) {
      echo("<meta http-equiv='refresh' content='0; url=login.php3'>");
      exit;
   }

   // DB ����
   @include("../dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // -- ��ũ ��� -- ���� -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>�޷� ������ �޴� - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "../define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language=javascript><!--\n");
   echo("      function send_admin() { \n");
   echo("         if (document.adminform.name.value.length < 4) {\n");
   echo("            alert ('������ �̸�(���̵�)�� �ּ� 4�� �̻��Դϴ�.');\n");
   echo("            document.adminform.name.focus();\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         if (document.adminform.cpwd1.value != '') {\n");
   echo("            if (document.adminform.cpwd1.value.length < 4) { \n");
   echo("               alert ('�� ��й�ȣ�� �ּ� 4�� �̻��Դϴ�.');\n");
   echo("               document.adminform.cpwd1.focus();\n");
   echo("               return;\n");
   echo("            }\n");
   echo("            if (document.adminform.cpwd1.value != document.adminform.cpwd2.value) { \n");
   echo("               alert ('�� ��й�ȣ�� Ʋ���ϴ�.');\n");
   echo("               document.adminform.cpwd2.focus();\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         }\n");
   echo("\n");
   echo("         if (document.adminform.pwd.value == '') { \n");
   echo("            alert ('��й�ȣ�� �����ּ���');\n");
   echo("            document.adminform.pwd.focus();\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         document.adminform.action = 'admin_save.php3';\n");
   echo("         document.adminform.submit();\n");
   echo("      } \n");
   echo("\n");
   echo("      // �����̽� �Է� üũ.\n");
   echo("      function onlyNoSpace () {\n");
   echo("         if ( (event.keyCode == 32) )\n");
   echo("            event.returnValue = false;\n");
   echo("      }\n");
   echo("\n");
   echo("      function delete_user(idx) {\n");
   echo("         if (confirm('������ �����ұ��?\\n\\n������ ����������� ������ �� �����ϴ�.')) {\n");
   echo("            location = 'delete_user.php3?idx=' + idx;\n");
   echo("         }\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");

   // -- ������ �� -- ���� -- //
   echo("   <Table Width=600 Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#ffffff>\n");
   echo("      <Tr><Td Width=30% Align=left Valign=bottom Style='padding-left: 6; padding-bottom: 2;'>\n");
   echo("         <Img Src='../image/icon_admin.gif' Width=60 Height=36 Border=0><BR>\n");
   echo("      </Td><Td Width=40% Align=center Valign=center Style='padding-top: 10; padding-bottom: 5'>\n");
   echo("         <Span Style='Font-Size: 15pt'><B>������ �޴�</B></Span>\n");
   echo("      </Td><Td Width=30% Align=right Valign=bottom>\n");
   echo("         ��<A Href='logout.php3' OnMouseOver=\"window.status='������ �α׾ƿ�'; return true;\" OnMouseOut=\"window.status=''; return true;\"> �α׾ƿ� </A>��\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align=center Valign=top Bgcolor=#666666 Style='padding-left: 3; padding-top: 3; padding-right: 3; padding-bottom: 3;'>\n");
   echo("\n");
   echo("         <Form Name=adminform Method=POST Action='javascript:send_admin();'>\n");
   echo("\n");
   echo("         <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0>\n");
   echo("            <Tr><Td Wdith=20% Height=25 Align=center Valign=center Bgcolor=#eeeeee>\n");
   echo("               �̸�(���̵�)\n");
   echo("            </Td><Td Width=30% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
   echo("               <Input Type=text Name=name Maxlength=20 Value='$admin_name' OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("            </Td><Td Width=20% Align=center Valign=center Bgcolor=#eeeeee>\n");
   echo("               ��й�ȣ\n");
   echo("            </Td><Td Width=30% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
   echo("               <Input Type=password Name=pwd Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Wdith=20% Height=25 Align=center Valign=center Bgcolor=#eeeeee>\n");
   echo("               ��й�ȣ ����\n");
   echo("            </Td><Td Width=30% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
   echo("               <Input Type=password Name=cpwd1 Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("            </Td><Td Width=20% Align=center Valign=center Bgcolor=#eeeeee>\n");
   echo("               ��й�ȣ Ȯ��\n");
   echo("            </Td><Td Width=30% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
   echo("               <Input Type=password Name=cpwd2 Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("            </Td></Tr>\n");
   echo("         </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("\n");
   echo("      <Tr><Td ColSpan=3 Align=center Valign=center Style='padding-top: 5; padding-bottom: 5'>\n");
   echo("            <Input Type=submit Value=' ������ ���� ����' Class='joinsbutton'>\n");
   echo("      </Td></Tr>\n");
   echo("         </Form>\n");
   echo("\n");

   // ��ü ����� �� ���..
   $sql = "SELECT id, admin_id, email, jdate, lastdate FROM wscalendar_info ORDER BY admin_id ASC";
   $result = mysql_query($sql,$dbconn);
   $row = @mysql_num_rows($result);

   echo("      <Tr><Td ColSpan=3 Align=center Valign=top Bgcolor=#666666 Style='padding-left: 3; padding-top: 3; padding-right: 3; padding-bottom: 3;'>\n");
   echo("\n");

   if ($row) {
      echo("         <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0>\n");
      echo("            <Tr><Td Wdith=20% Height=25 Align=center Valign=center Bgcolor=#eeeeee>\n");
      echo("               ��ϵ� �����\n");
      echo("            </Td><Td Width=80% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
      echo("               <B>$row</B> ��\n");
      echo("            </Td></Tr>\n");
      echo("            <Tr><Td Height=25 ColSpan=2 Align=center Valign=center Bgcolor=#eeeeee Style='padding-top: 5; padding-bottom: 5;'>\n");
      echo("\n");
      echo("               <Table Width=95% Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#cccccc>\n");
      echo("                  <Tr><Td Width=20% Height=20 Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B>ID</B>\n");
      echo("                  </Td><Td Width=5% Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B> �� </B>\n");
      echo("                  </Td><Td Width=20% Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B> �� �� �� </B>\n");
      echo("                  </Td><Td Width=20% Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B> �������� </B>\n");
      echo("                  </Td><Td Width=35% Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B> �� �� �� </B>\n");
      echo("                  </Td></Tr>\n");
      for ($i=0; $i<$row; $i++) {
         $user = mysql_fetch_array($result);
         echo("                  <Tr><Td Height=20 Align=center Valign=center Bgcolor=#ffffff>\n");
         echo("                     <B>$user[admin_id]</B>\n");
         echo("                  </Td><Td Align=center Valign=center Bgcolor=#ffffff>\n");
         if ($user[email]) {
//            wsmail �� ����Ѵٸ� .. ^^
//            echo("                     <A Href='../../mail/mail.php3?to=$user[email]' 
            echo("                     <A Href='mailto:$user[email]' OnMouseOver=\"window.status='$user[admin_id]�Բ� ���� �߼�'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
            echo("                     <Img Src='../image/icon_email.gif' Width=18 Height=18 Border=0 Alt='$user[email]'><BR>\n");
            echo("                     </A>\n");
         } else {
            echo("                     <Img Src='../image/icon_email2.gif' Width=18 Height=18 Border=0><BR>\n");
         }
         echo("                  </Td><Td Align=center Valign=center Bgcolor=#ffffff>\n");
         echo("                     ".date("Y�� m�� d��", $user[jdate])."\n");
         echo("                  </Td><Td Align=center Valign=center Bgcolor=#ffffff>\n");
         echo("                     ".date("Y�� m�� d��", $user[lastdate])."\n");
         echo("                  </Td><Td Align=left Valign=center Bgcolor=#ffffff>\n");
         echo("                     ��<A Href='javascript:delete_user($user[id])' OnMouseOver=\"window.status='����� ������ ������ �����մϴ�'; return true;\" OnMouseOut=\"window.status=''; return true;\"> ����� ���� </A>��<BR>\n");
         echo("                  </Td></Tr>\n");
      }
      echo("               </Table>\n");
      echo("\n");
      echo("            </Td></Tr>\n");
      echo("         </Table>\n");
   } else {
      echo("         <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0>\n");
      echo("            <Tr><Td Wdith=20% Height=25 Align=center Valign=center Bgcolor=#eeeeee>\n");
      echo("               ��ϵ� �����\n");
      echo("            </Td><Td Width=80% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
      echo("               <B>����ڰ� �����ϴ�.</B>\n");
      echo("            </Td></Tr>\n");
      echo("         </Table>\n");
   }

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   @include("../madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");

   mysql_close($dbconn);

?>