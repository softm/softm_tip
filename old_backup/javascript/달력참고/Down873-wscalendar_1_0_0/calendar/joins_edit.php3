<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");

   if (!$session_calendar_id)
      error_message("���� ����","�������� ������ �ƴմϴ�.");

   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   $sql = "SELECT * FROM wscalendar_info WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);

   $member = @mysql_fetch_array($result);

   // ����� �α��� �����ΰ�?
   if (strcmp($session_calendar_login, $member[bcheck]))
      error_message("���� ����","�������� ������ �ƴմϴ�.");

   // -- ��ũ ��� -- ���� -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>�޷� ����ڼ��� - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language='JScript' Src='joins_edit.js'></Script>\n");
   echo("   <Script Language='JavaScript'><!--\n");
   echo("      function check_zip() {\n");
   echo("         window.open('zipcode.php3', 'check_zip', 'width=400, height=300, marginwidth=0, marginheight=0, resizable=0, scrollbars=1, status=1');\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");

   // -- ȸ�� ���� �� -- ���� -- //
   echo("   <Table Width=600 Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#ffffff>\n");
   echo("      <Tr><Td Width=30% Align=left Valign=bottom Style='padding-left: 6; padding-bottom: 2;'>\n");
   echo("         <Img Src='image/mem_modify.gif' Width=60 Height=36 Border=0><BR>\n");
   echo("      </Td><Td Width=40% Align=center Valign=center Style='padding-top: 10; padding-bottom: 5'>\n");
   echo("         <Span Style='Font-Size: 15pt'><B>����� ����</B></Span>\n");
   echo("      </Td><Td Width=30% Align=center Valign=center>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align=center Valign=top Bgcolor=#444444>\n");
   echo("\n");
   echo("      <Form Name=joinsform Method=POST Action='javascript:send_joins();'>\n");
   echo("         <Input Type=hidden Name=id Value='$id'>\n");
   echo("\n");
   echo("   <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0 Style='border: 2px solid #888888'>\n");
   echo("      <Tr><Td Width=17% Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>����� ID</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Span Style='Font-Size: 10pt'><B>$member[admin_id]</B></Span>\n");
   echo("      </Td><Td Width=17% Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>��й�ȣ</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=pwd Size=20 Maxlength=8 Class='joinsinput'>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Width=17% Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>��й�ȣ ����</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=cpwd1 Size=20 Maxlength=8 Class='joinsinput'>\n");
   echo("      </Td><Td Width=17% Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>��й�ȣ Ȯ��</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=cpwd2 Size=20 Maxlength=8 Class='joinsinput'>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�̸�</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Span Style='Font-Size: 10pt'><B>$member[name]</B></Span>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�̸����ּ�</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=email Size=40 Maxlength=50 Value='$member[email]' Class='joinsinput'>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�ֹε�Ϲ�ȣ</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Span Style='Font-Size: 10pt'><B>$member[ssn1] - $member[ssn2]</B></Span>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�����ȣ</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=zip1 Size=3 Maxlength=3 Value='".substr($member[zip], 0, 3)."' Class='joinsinput'> -\n");
   echo("         <Input Type=text Name=zip2 Size=3 Maxlength=3 Value='".substr($member[zip], 3, 3)."' Class='joinsinput'>\n");
   echo("         <Input Type=button Value=' �ּ��Է� ' OnClick='javascript:check_zip();' Class=joinsbutton>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�����ּ�</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=address Size=70 Maxlength=100 Value='$member[address]' Class='joinsinput'>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>��ȭ��ȣ</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=phone Size=13 Maxlength=13 Value='$member[phone]' Class='joinsinput'>\n");
   echo("         &nbsp;�׻� ���� ������ �� �ִ� ��ȭ��ȣ\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align='center' Valign='center' Style='padding-top: 10; padding-bottom: 10;'>\n");
   echo("         <Input Type=submit Value='�����մϴ�' Class='joinsbutton'>&nbsp;\n");
   echo("         <Input Type=reset  Value=' �ٽ��ۼ� ' Class='joinsbutton'>\n");
   echo("      </Td></Tr>\n");
   echo("\n");
   echo("      </Form>\n");
   echo("\n");
   echo("   </Table>\n");
   // ȸ�� ���� �� -- �� -- //

   echo("\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");
?>