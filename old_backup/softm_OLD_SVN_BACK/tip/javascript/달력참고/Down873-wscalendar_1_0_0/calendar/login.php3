<?PHP #programmed by WindHunter '97 ?> 
<?
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>�޷� - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script language='javascript'><!--\n");
   echo("      function send_login() { \n");
   echo("         if (document.loginform.id.value == '') { \n");
   echo("            alert ('���̵� �����ּ���');\n");
   echo("            document.loginform.id.focus();\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         if (document.loginform.pwd.value == '') { \n");
   echo("            alert ('��й�ȣ�� �����ּ���');\n");
   echo("            document.loginform.pwd.focus();\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         document.loginform.action = 'login_check.php3';\n");
   echo("         document.loginform.submit();\n");
   echo("      } \n");
   echo("\n");
   echo("      // �����̽� �Է� üũ.\n");
   echo("      function onlyNoSpace () {\n");
   echo("         if ( (event.keyCode == 32) )\n");
   echo("            event.returnValue = false;\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='$#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0' OnLoad='document.loginform.id.focus();'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");
   echo("   <Table Width='250' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 2px solid #336699'>\n");
   echo("      <Tr><Td Width='25' Height='20' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("         <Img Src='image/icon_logo.gif' Width='18' Height='18' Border='0' Alt=''><BR>\n");
   echo("      </Td><Td Width='200' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("         <Span Style='Font-Size: 10pt'>\n");
   echo("         <Font Color='#ffffff'><B>�� �� ��</B></Font>\n");
   echo("         </Span>\n");
   echo("      </Td><Td Width='25' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("         <Img Src='image/icon_target.gif' Width='18' Height='18' Border='0'><BR>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Width='100%' Height='10' ColSpan='3' Align='center' Valign='bottom' Bgcolor='#dfdfdf'  Style='padding-left: 2; padding-right: 0; padding-top: 3; padding-bottom: 0'>\n");

   echo("         �α��� ������ �Է��� �ֽʽÿ�.\n");

   echo("      </Td></Tr>\n");
   echo("         <Form Name='loginform' Method='POST' Action='javascript:send_login();'>\n");
   echo("         <Input Type='hidden' Name='db' Value='$db'>\n");
   echo("      <Tr><Td Width='100%' Height='10' ColSpan='3' Align='center' Valign='bottom' Bgcolor='#dfdfdf'  Style='padding-left: 3; padding-right: 3; padding-top: 3; padding-bottom: 3'>\n");

   echo("         <Table Width='100%' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 1px solid #000000'>\n");
   echo("            <Tr><Td Height='30' Width='50%' Align='right' Valign='center' Bgcolor='' Style='padding-right: 10'>\n");
   echo("               <B>���̵�</B>\n");
   echo("            </Td><Td Width='50%' Align='left' Valign='center' Bgcolor='' Style='padding-left: 10'>\n");
   echo("               <Input Type='text' Name='id' Size='10' Maxlength='10' Style='border: 1px solid' OnKeypress='onlyNoSpace()'>\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Height='30' Width='50%' Align='right' Valign='center' Bgcolor='' Style='padding-right: 10'>\n");
   echo("               <B>��й�ȣ</B>\n");
   echo("            </Td><Td Width='50%' Align='left' Valign='center' Bgcolor='' Style='padding-left: 10'>\n");
   echo("               <Input Type='password' Name='pwd' Size='10' Maxlength='8' Style='border: 1px solid' OnKeypress='onlyNoSpace()'>\n");
   echo("            </Td></Tr>\n");
   echo("         </Table>\n");

   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Width='100%' Height='10' ColSpan='3' Align='center' Valign='bottom' Bgcolor='#dfdfdf'  Style='padding-left: 3; padding-right: 3; padding-top: 3; padding-bottom: 3'>\n");
   echo("         <Input Type='submit' Value=' �α��� ' Class='writebutton'>\n");
   echo("         <Input Type='button' Value='  �ڷ�  ' Class='writebutton' OnClick='javascript:history.back();'>\n");
   echo("      </Td></Tr>\n");
   echo("         </Form>\n");
   echo("   </Table>\n");
   echo("\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");
   echo("   </Body>\n");
   echo("<Html>\n");
?>