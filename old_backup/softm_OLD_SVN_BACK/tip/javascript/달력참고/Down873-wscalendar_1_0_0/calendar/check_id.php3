<?PHP #programmed by WindHunter '97 ?> 
<?
   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);
   if ($id) {
      // ���� ������ ID �˻�
      $sql = "SELECT admin_id FROM wscalendar_info WHERE admin_id = '$id'";
      $result = mysql_query($sql,$dbconn);

      $m_id = @mysql_result($result, 0, "admin_id");
   }

   // -- ��ũ ��� -- ���� -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>�޷� ����� ID �ߺ��˻� - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language='javascript'><!--\n");
   echo("      function use_id() {\n");
   echo("         var f = opener.document.forms[0];\n");
   echo("\n");
   echo("         f.id.value = document.check_id.id.value;\n");
   echo("         f.id.focus();\n");
   echo("\n");
   echo("         this.close ();\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0' OnLoad='window.focus();'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");
   echo("         <Table Width='400' Height='160' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 2px solid #336699'>\n");
   echo("            <Tr><Td Width='25' Height='20' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Img Src='image/icon_calendar.gif' Width='18' Height='18' Border='0' Alt=''><BR>\n");
   echo("            </Td><Td Width='400' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Span Style='Font-Size: 10pt'>\n");
   echo("               <Font Color='#ffffff'><B>����� ID �ߺ��˻�</B></Font>\n");
   echo("               </Span>\n");
   echo("            </Td><Td Width='25' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Img Src='image/icon_arrow2.gif' Width='18' Height='18' Border='0'><BR>\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Width='100%' Height='140' ColSpan='3' Align='center' Valign='center' Bgcolor='#dfdfdf'  Style='padding-left: 3; padding-right: 3; padding-top: 3; padding-bottom: 3'>\n");
   echo("               <Span Style='Font-Size: 9pt'>\n");
   if ($id && !strcmp($id, $m_id)) {
      echo("               ��û�Ͻ� <B>'$m_id'</B> ID�� �̹� ����ڰ� �ֽ��ϴ�.<BR><BR>\n");
      echo("               �ٸ� ID�� ��û�Ͻñ� �ٶ��ϴ�.<BR>\n");
   } else if ($id) {
      echo("               ��û�Ͻ� <B>'$id'</B> ID�� ����Ͻ� �� �ֽ��ϴ�.<BR><BR>\n");
      echo("               �Ʒ��� '���' ��ư�� �����ñ� �ٶ��ϴ�.<BR>\n");
   } else {
      echo("               <BR>��û�Ͻ� ID�� �Ʒ��� �Է��ϰ� �˻��Ͻʽÿ�<BR>\n");
      echo("               &nbsp;<BR>\n");
   }
   echo("               <BR>\n");
   echo("               <Form Name=check_id Method=POST Action='$PHP_SELF'>\n");
   echo("                  <Input Type=button Value=' ��� ' Class='writebutton' OnClick='javascript:use_id();'>\n");
   echo("                  <Input Type=text Name=id Size=20 Maxlength=10 Value='$id' Class='joinsinput'>\n");
   echo("                  <Input Type=submit Value=' ��ȸ ' Class='writebutton'>\n");
   echo("               </Span>\n");
   echo("            </Td></Tr>\n");
   echo("               </Form>\n");
   echo("         </Table>\n");
   echo("\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");
?>