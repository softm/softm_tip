<?PHP #programmed by WindHunter '97 ?> 
<?
   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   if ($dong) {
      // �ּҰ˻�
      $sql = "SELECT * FROM zipcode WHERE dong LIKE '%$dong%' ORDER BY code";
      $result = mysql_query($sql,$dbconn);

      $row = mysql_num_rows($result);
   }

   // -- ��ũ ��� -- ���� -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>�ּ��ڵ��Է� - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language='javascript'><!--\n");
   echo("      function click_it (zip1, zip2 ,addr) {\n");
   echo("         var f = opener.document.forms[0];\n");
   echo("\n");
   echo("         f.zip1.value = zip1;\n");
   echo("         f.zip2.value = zip2;\n");
   echo("         f.address.value = addr;\n");
   echo("         f.address.focus();\n");
   echo("\n");
   echo("         this.close ();\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0' OnLoad='window.focus(); document.zipcode.dong.focus();'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='top'>\n");
   echo("\n");
   echo("         <Table Width='380' Height='260' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 2px solid #336699'>\n");
   echo("            <Tr><Td Width='25' Height='20' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Img Src='image/icon_calendar.gif' Width='18' Height='18' Border='0' Alt=''><BR>\n");
   echo("            </Td><Td Width='400' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Span Style='Font-Size: 10pt'>\n");
   echo("               <Font Color='#ffffff'><B>�ּ� �˻�</B></Font>\n");
   echo("               </Span>\n");
   echo("            </Td><Td Width='25' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Img Src='image/icon_arrow2.gif' Width='18' Height='18' Border='0'><BR>\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Width='100%' Height='110' ColSpan='3' Align='center' Valign='top' Bgcolor='#dfdfdf'  Style='padding-left: 3; padding-right: 3; padding-top: 3; padding-bottom: 3'>\n");
   echo("               <Span Style='Font-Size: 9pt'>\n");
   echo("               <BR><BR>�˻��Ͻ� '��'�̸��� �Ʒ��� �Է��ϰ� �˻��Ͻʽÿ�<BR>\n");
   echo("               <BR>\n");
   echo("               <Form Name=zipcode Method=POST Action='$PHP_SELF'>\n");
   echo("                  <Input Type=text Name=dong Size=20 Maxlength=20 Value='$dong' Class='joinsinput'>\n");
   echo("                  <Input Type=submit Value=' �˻� ' Class='writebutton'>\n");
   echo("               </Span>\n");
   echo("            </Td></Tr>\n");
   echo("               </Form>\n");
   if ($row) {
      echo("            <Tr><Td ColSpan=3 Align=left Valign=top Style='padding-top: 10; padding-bottom: 10; padding-left: 5; padding-right: 5'>\n");
      echo("               <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0>\n");
	  while ($zipcode = mysql_fetch_array($result)) {
         echo("                  <Tr><Td Width=15% Align=center Valign=top>\n");
         echo("                     $zipcode[code]\n");
         echo("                  </Td><Td Width=85% Align=left Valign=top>\n");
         echo("                     <A Href=\"javascript:click_it('" . substr($zipcode[code], 0, 3) . "','" . substr($zipcode[code], 4, 3) . "','$zipcode[city] $zipcode[dong]')\" OnMouseOver=\"window.status='�ּҼ���'; return true;\" OnMouesOut=\"window.status=''; return true;\">\n");
         echo("                     $zipcode[city] $zipcode[dong]\n");
         echo("                     </A>\n");
         echo("                  </Td></Tr>\n");
	  }
      echo("               </Table>\n");
      echo("            </Td></Tr>\n");
   } else {
      echo("            <Tr><Td Height=130 ColSpan=3 Align=center Valign=center>\n");
      echo("               �ּ� ���\n");
      echo("            </Td></Tr>\n");
   }
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