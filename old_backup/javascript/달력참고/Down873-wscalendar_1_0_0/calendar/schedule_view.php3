<?PHP #programmed by WindHunter '97 ?> 
<?
   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>������ ���� - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language=javascript><!--\n");
   echo("      function window_edit(url) {\n");
   echo("         window.open(url, 'calendar', 'width=470, height=400, marginwidth=0, marginheight=0, resizable=0, scrollbars=1, status=1');\n");
   echo("         return;\n");
   echo("      }\n");
   echo("\n");
   echo("      function delete_msg(n1,n2,day) {\n");
   echo("         if (confirm('������ �����ұ��?')) {\n");
   echo("            window.open('schedule_delete_db.php3?db=' + n1 + '&idx=' + n2 + '&d=' + day, 'calendar', 'width=470, height=400, marginwidth=0, marginheight=0, resizable=0, scrollbars=1, status=1');\n");
   echo("            return;\n");
   echo("         }\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='$#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0'>\n");
   echo("\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='top'>\n");
   echo("\n");
   echo("         <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='1' Border='0'>\n");
   echo("\n");

   // ���� ��¥�� ���� ��������
   $sql  = "SELECT id, title, memo, taguse, hot FROM $db WHERE wdate = '$d' ";
   if ($idx)
      $sql .= "AND id = '$idx' ";
   $sql .= "ORDER BY stime, id ASC LIMIT 1";
   $result = mysql_query($sql,$dbconn);
   $data = @mysql_fetch_array($result);

   if (!$data) {
      echo("         <Tr><Td Width='100%' Height='100%' Align='center' Valign='top' Bgcolor='#ffffff'>\n");
      echo("            <BR>������ �����ϴ�.\n");
      echo("         </Td></Tr>\n");
   } else {
      echo("         <Tr><Td Width='80%' Height='20' Align='left' Valign='center'>\n");
	  if ($data[hot])
         echo("            <Img Src='image/icon_!.gif' Width=10 Height=12 Border=0>\n");
      echo("            <B>$data[title]</B>\n");
      echo("         </Td><Td Width='20%' Align='right' Valign='center' Style='padding-right: 2;'>\n");
      echo("            <A Href=\"javascript:window_edit('schedule_edit.php3?db=$db&idx=$data[id]')\" OnMouseOver=\"window.status='������ �����մϴ�'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("            <Img Src='image/icon_modify.gif' Width=16 Height=16 Border=0 Alt='��������'></A>\n");
      echo("            <A Href=\"javascript:delete_msg('$db',$data[id],$d)\" OnMouseOver=\"window.status='������ �����մϴ�'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("            <Img Src='image/icon_delete2.gif' Width=16 Height=16 Border=0 Alt='��������'><BR>\n");
      echo("            </A>\n");
      echo("         </Td></Tr>\n");
      echo("         <Tr><Td Width='100%' Height='100%' ColSpan='2' Align='left' Valign='top' Bgcolor='#ddeeaa' Style='padding-left: 3; padding-top: 3; padding-right: 3; padding-bottom: 3;'>\n");

      if ($data[taguse]) {
      // HTML Tag�� ��밡���ϰ� �Ͽ��ٸ�, <? , <?php, <script , <%, <!, <xmp���� Tag���� <�� ��� &lt;�� ġȯ�Ͽ���
      // ���Ȼ� ������ �ذ��� �� �ִ�. ?.?
         $data[memo] = eregi_replace("<\\?(.*)\\?>", "&lt;?\\1?&gt;", $data[memo]);
         $data[memo] = eregi_replace("<script([^>]*)>(.*)</script>", "&lt;script\\1&gt;\\2&lt;/script&gt;", $data[memo]);
         $data[memo] = eregi_replace("<!", "&lt;!", $data[memo]);
         $data[memo] = eregi_replace("<xmp", "&lt;xmp", $data[memo]);
	  } else {
         $data[memo] = eregi_replace("<", "&lt;", $data[memo]);
         $data[memo] = eregi_replace(">", "&gt;", $data[memo]);
         $data[memo] = nl2br($data[memo]);
	  }

      echo("            $data[memo]\n");
   }

   echo("         </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");
   echo("   </Body>\n");
   echo("<Html>\n");

   mysql_close($dbconn);
?>