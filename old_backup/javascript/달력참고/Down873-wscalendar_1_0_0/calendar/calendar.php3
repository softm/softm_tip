<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   // DB ����
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   if ($session_calendar_login) {
      // ����� ������ �����´�.
      $sql = "SELECT * FROM wscalendar_info WHERE admin_id = '$session_calendar_id'";
      $result = mysql_query($sql,$dbconn);
      $bc = @mysql_fetch_array($result);

      $db = "wscalendar_" . $bc[admin_id];
   }

   @include("function_strcut.inc");
   // YYYYMMDD�������� �����..
   function str_date($i_year, $i_month, $i_day) {
      $strtmp  = $i_year;
      if (strlen($i_month) < 2) $strtmp .= "0";
      $strtmp .= $i_month;
      if (strlen($i_day)   < 2) $strtmp .= "0";
      $strtmp .= $i_day;

      return $strtmp;
   }

   //�Ѵ��� �� ��¥ ��� �Լ�
   // zzt_calendar ���� ���� ^^a
   function Month_Day($i_month,$i_year){
      $day=1;
      while(checkdate($i_month,$day,$i_year)) {
         $day++;
      }
      $day--;
      return $day;
   }

   // ���� <> ��� ��ȯ �Լ���
   function sunlunar_data() { 
      return "1212122322121-1212121221220-1121121222120-2112132122122-2112112121220-2121211212120-2212321121212-2122121121210-2122121212120-1232122121212-1212121221220-1121123221222-1121121212220-1212112121220-2121231212121-2221211212120-1221212121210-2123221212121-2121212212120-1211212232212-1211212122210-2121121212220-1212132112212-2212112112210-2212211212120-1221412121212-1212122121210-2112212122120-1231212122212-1211212122210-2121123122122-2121121122120-2212112112120-2212231212112-2122121212120-1212122121210-2132122122121-2112121222120-1211212322122-1211211221220-2121121121220-2122132112122-1221212121120-2121221212110-2122321221212-1121212212210-2112121221220-1231211221222-1211211212220-1221123121221-2221121121210-2221212112120-1221241212112-1212212212120-1121212212210-2114121212221-2112112122210-2211211412212-2211211212120-2212121121210-2212214112121-2122122121120-1212122122120-1121412122122-1121121222120-2112112122120-2231211212122-2121211212120-2212121321212-2122121121210-2122121212120-1212142121212-1211221221220-1121121221220-2114112121222-1212112121220-2121211232122-1221211212120-1221212121210-2121223212121-2121212212120-1211212212210-2121321212221-2121121212220-1212112112210-2223211211221-2212211212120-1221212321212-1212122121210-2112212122120-1211232122212-1211212122210-2121121122210-2212312112212-2212112112120-2212121232112-2122121212110-2212122121210-2112124122121-2112121221220-1211211221220-2121321122122-2121121121220-2122112112322-1221212112120-1221221212110-2122123221212-1121212212210-2112121221220-1211231212222-1211211212220-1221121121220-1223212112121-2221212112120-1221221232112-1212212122120-1121212212210-2112132212221-2112112122210-2211211212210-2221321121212-2212121121210-2212212112120-1232212122112-1212122122120-1121212322122-1121121222120-2112112122120-2211231212122-2121211212120-2122121121210-2124212112121-2122121212120-1212121223212-1211212221220-1121121221220-2112132121222-1212112121220-2121211212120-2122321121212-1221212121210-2121221212120-1232121221212-1211212212210-2121123212221-2121121212220-1212112112220-1221231211221-2212211211220-1212212121210-2123212212121-2112122122120-1211212322212-1211212122210-2121121122120-2212114112122-2212112112120-2212121211210-2212232121211-2122122121210-2112122122120-1231212122212-1211211221220-2121121321222-2121121121220-2122112112120-2122141211212-1221221212110-2121221221210-2114121221221"; 
   } 

   // �ش� �⵵�� ..�� �����Ѵ�.
   function year2yukgap($year) {
      $arrayYUKSTR  = "��-��-��-��-��-��-��-��-��-��"; 
      $arrayYUK     = explode("-",$arrayYUKSTR); 

      $arrayGAPSTR  = "��-��-��-��-��-��-��-��-��-��-��-��"; 
      $arrayGAP     = explode("-",$arrayGAPSTR); 

      $k1   = ($year + 6) % 10; 
      $syuk = $arrayYUK[$k1]; 
      $k2   = ($year + 8) % 12; 
      $sgap = $arrayGAP[$k2];

      return ($syuk . $sgap);
   }

   // �ش� �⵵�� �츦 �����Ѵ�.
   function year2ddi($year) {
      $arrayDDISTR  = "��-��-ȣ����-�䳢-��-��-��-��-������-��-��-����"; 
      $arrayDDI     = explode("-",$arrayDDISTR); 

      $k2   = ($year + 8) % 12; 
      $sddi = $arrayDDI[$k2];

      return ($sddi);
   }

   function sol2lun($year,$month,$day) {
      $getYEAR  = (int)$year; 
      $getMONTH = (int)$month; 
      $getDAY   = (int)$day; 

      $arrayDATASTR = sunlunar_data(); 
      $arrayDATA    = explode("-",$arrayDATASTR); 

      $arrayLDAYSTR = "31-0-31-30-31-30-31-31-30-31-30-31"; 
      $arrayLDAY    = explode("-",$arrayLDAYSTR); 

      $dt = $arrayDATA; 

      for ($i=0;$i<=168;$i++) { 
         $dt[$i] = 0; 
         for ($j=0;$j<12;$j++) { 
            switch (substr($arrayDATA[$i],$j,1)) { 
               case 1: 
                  $dt[$i] += 29; 
                  break; 
               case 3: 
                  $dt[$i] += 29; 
                  break; 
               case 2: 
                  $dt[$i] += 30; 
                  break; 
               case 4: 
                  $dt[$i] += 30; 
                  break; 
            } 
         } 

         switch (substr($arrayDATA[$i],12,1)) { 
            case 0: 
               break; 
            case 1: 
               $dt[$i] += 29; 
               break; 
            case 3: 
               $dt[$i] += 29; 
               break; 
            case 2: 
               $dt[$i] += 30; 
               break; 
            case 4: 
               $dt[$i] += 30; 
               break; 
         } 
      } 

      $td1 = 1880 * 365 + (int)(1880/4) - (int)(1880/100) + (int)(1880/400) + 30; 
      $k11 = $getYEAR - 1; 

      $td2 = $k11 * 365 + (int)($k11/4) - (int)($k11/100) + (int)($k11/400); 
     
      if ($getYEAR % 400 == 0 || $getYEAR % 100 != 0 && $getYEAR % 4 == 0) { 
         $arrayLDAY[1] = 29; 
      } else { 
         $arrayLDAY[1] = 28; 
      } 

      if ($getMONTH > 13) { 
         $gf_sol2lun = 0; 
      } 

      if ($getDAY > $arrayLDAY[$getMONTH-1]) { 
         $gf_sol2lun = 0; 
      } 
     
      for ($i=0;$i<=$getMONTH-2;$i++) { 
         $td2 += $arrayLDAY[$i]; 
      } 

      $td2 += $getDAY; 
      $td   = $td2 - $td1 + 1; 
      $td0  = $dt[0]; 

      for ($i = 0; $i <= 168; $i++) { 
         if ($td <= $td0) break;

         $td0 += $dt[$i+1]; 
      } 
     
      $ryear = $i + 1881; 
      $td0 -= $dt[$i]; 
      $td  -= $td0; 
     
      if (substr($arrayDATA[$i], 12, 1) == 0) { 
         $jcount = 11; 
      } else { 
         $jcount = 12; 
      } 
      $m2 = 0; 
     
      for ($j=0;$j<=$jcount;$j++) { // �޼� check, ���� > 2 (by harcoon) 
         if (substr($arrayDATA[$i],$j,1) <= 2) { 
            $m2++; 
            $m1 = substr($arrayDATA[$i],$j,1) + 28; 
            $gf_yun = 0; 
         } else { 
            $m1 = substr($arrayDATA[$i],$j,1) + 26; 
            $gf_yun = 1; 
         } 
         if ($td <= $m1) { 
            break; 
         } 
         $td = $td - $m1; 
      } 

      return ($m2.".".$td);
   } 

   // -------------------------------------------------------------------- //

   // �ش� ��,�� ���ϱ�
   if (!$year ) $year  = date("Y");
   if (!$month) $month = date("m");
   if (strcmp(substr($session_calendar_viewday, 0, 6), substr(str_date($year, $month, date("d")), 0 ,6)) )
      $session_calendar_viewday = str_date($year, $month, date("d"));

   $days = Month_Day($month, $year);

   //������ ���� 1���� ������ ����. �Ͽ����� 0.
   $first = @date(w,mktime(0,0,0,$month,1,$year));

   //���� Ȯ�� --> ���� 2000������ ���� �ڵ� ����.., Linux ������ �ڵ� ���ǳ� --a
   /*
   if($month==2){
      if(!($year %   4)) $days++;
      if(!($year % 100)) $days--;
      if(!($year % 400)) $days++;
   }
   */

   // -- ��ũ ��� -- ���� -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>�޷� - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language='javascript'><!--\n");
   echo("      function send_it(v) {\n");
   echo("         if (v == 'yearprev') {\n");
   echo("            if (document.calform.year.value > 1970)\n");
   echo("               document.calform.year.value --;\n");
   echo("            else {\n");
   echo("               alert ('1970�� ���� �޷��� ���� �� �����ϴ�.');\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         } else if (v == 'yearnext') {\n");
   echo("            if (document.calform.year.value < 2037)\n");
   echo("               document.calform.year.value ++;\n");
   echo("            else {\n");
   echo("               alert ('2038�� ���� �޷��� ���� �� �����ϴ�.');\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         } else if (v == 'monthprev') {\n");
   echo("            if (document.calform.month.value > 1 || document.calform.year.value > 1970) {\n");
   echo("               if (document.calform.month.value > 1) document.calform.month.value --;\n");
   echo("               else { \n");
   echo("                  document.calform.year.value --;\n");
   echo("                  document.calform.month.value = 12;\n");
   echo("               }\n");
   echo("            } else {\n");
   echo("               alert ('1970�� ���� �޷��� ���� �� �����ϴ�.');\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         } else if (v == 'monthnext') {\n");
   echo("            if (document.calform.month.value < 12 || document.calform.year.value < 2037) {\n");
   echo("               if (document.calform.month.value < 12) document.calform.month.value ++;\n");
   echo("               else {\n");
   echo("                  document.calform.year.value ++;\n");
   echo("                  document.calform.month.value = 1;\n");
   echo("               }\n");
   echo("            } else {\n");
   echo("               alert ('2038�� ���� �޷��� ���� �� �����ϴ�.');\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         } else if (v == 'today') {\n");
   echo("            document.calform.month.value = " . date("m") . ";\n");
   echo("            document.calform.year.value = " . date("Y") . ";\n");
   echo("         }\n");
   echo("\n");
   echo("         document.calform.action = '$PHP_SELF';\n");
   echo("         document.calform.submit ();\n");
   echo("      }\n");
   echo("\n");
   echo("      function window_open(day) {\n");
   echo("         window.open('schedule_write.php3?db=$db&d='+day, 'calendar', 'width=470, height=400, marginwidth=0, marginheight=0, resizable=0, scrollbars=1, status=1');\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");
   // -- �޷� ��� -- //
   echo("   <Table Cellpadding='0' Cellspacing='0' Border='0' Bgcolor='#ffffff'>\n");

   if (!strcmp($session_calendar_login, $bc[bcheck]) && $session_calendar_login) {
      // ��ϵ� ��ü ���� �� ���ϱ�
      $sql = "SELECT COUNT(*) FROM wscalendar_$bc[admin_id]";
	  $result = mysql_query($sql,$dbconn);
	  $schedule[max] = @mysql_result($result, 0, "COUNT(*)");

	  // ��ϵ� ��ü �߿����� �� ���ϱ�
      $sql  = "SELECT COUNT(*) FROM wscalendar_$bc[admin_id] WHERE hot = '1'";
	  $result = mysql_query($sql,$dbconn);
	  $schedule[hot] = @mysql_result($result, 0, "COUNT(*)");

	  // ��ϵ� ���� �� �ش���� ���� �� ���ϱ�
      $sql  = "SELECT COUNT(*) FROM wscalendar_$bc[admin_id] ";
	  $sql .= "WHERE wdate Like '" . substr($session_calendar_viewday, 0, 6) . "%'";
	  $result = mysql_query($sql,$dbconn);
	  $schedule[maxmonth] = @mysql_result($result, 0, "COUNT(*)");

	  // ��ϵ� �߿����� �� ���ϱ�
      $sql  = "SELECT COUNT(*) FROM wscalendar_$bc[admin_id] WHERE hot = '1' AND ";
	  $sql .= "wdate Like '" . substr($session_calendar_viewday, 0, 6) . "%'";
	  $result = mysql_query($sql,$dbconn);
	  $schedule[hotmonth] = @mysql_result($result, 0, "COUNT(*)");

      echo("      <Tr><Td Width='270' Align='left' Valign='bottom' Style='padding-top: 41'>\n");
      echo("\n");
      echo("         <Table Width='265' Height='100%' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 2px solid #555555'>\n");
      echo("            <Tr><Td Width='100%' Height='100%' Align='center' Valign='bottom' Style='padding-top: 7; padding-left: 5; padding-right: 5; padding-bottom: 7;'>\n");
      echo("\n");
	  echo("               <Table Width='100%' Cellpadding='5' Cellspacing='0' Border='0' Style='border: 2px solid #cccccc'>\n");
      echo("                  <Tr><Td Wdith='100%' Align='center' Valign='center'>\n");
      echo("                     <Span Style='Font-Size: 5'><BR></Span>\n");
	  echo("                     <B>$bc[name]($bc[admin_id])</B>���� ��������<BR>\n");
      echo("                     <Span Style='Font-Size: 5'><BR></Span>\n");
	  echo("                     <Table Width=100% Cellpadding=1 Cellspacing=1 Border=0 Bgcolor=#aaaaaa>\n");
	  echo("                        <Tr><Td Width=20% Align=center Valign=center Bgcolor=#dddddd>\n");
	  echo("                           ����\n");
	  echo("                        </Td><Td Width=27% Align=center Valign=center Bgcolor=#dddddd>\n");
	  echo("                           ��ü\n");
	  echo("                        </Td><Td Width=27% ALign=center Valign=center Bgcolor=#dddddd>\n");
	  echo("                           �߿�\n");
	  echo("                        </Td><Td Width=26% ALign=center Valign=center Bgcolor=#dddddd>\n");
	  echo("                           �Ϲ�\n");
	  echo("                        </Td></Tr>\n");
	  echo("                        <Tr><Td Align=center Valign=center Bgcolor=#ffffff>\n");
	  echo("                           �� ü\n");
	  echo("                        </Td><Td Align=right Valign=center Bgcolor=#ffffff>\n");
	  echo("                           $schedule[max] ��\n");
	  echo("                        </Td><Td Align=right Valign=center Bgcolor=#ffffff>\n");
	  echo("                           $schedule[hot] ��\n");
	  echo("                        </Td><Td Align=right Valign=center Bgcolor=#ffffff>\n");
	  echo("                           " . ($schedule[max]-$schedule[hot]) . " ��\n");
	  echo("                        </Td></Tr>\n");
	  echo("                        <Tr><Td Align=center Valign=center Bgcolor=#ffffff>\n");
	  echo("                           �̹���\n");
	  echo("                        </Td><Td Align=right Valign=center Bgcolor=#ffffff>\n");
	  echo("                           $schedule[maxmonth] ��\n");
	  echo("                        </Td><Td Align=right Valign=center Bgcolor=#ffffff>\n");
	  echo("                           $schedule[hotmonth] ��\n");
	  echo("                        </Td><Td Align=right Valign=center Bgcolor=#ffffff>\n");
	  echo("                           " . ($schedule[maxmonth]-$schedule[hotmonth]) . " ��\n");
	  echo("                        </Td></Tr>\n");
	  echo("                     </Table>\n");
	  echo("                  </Td></Tr>\n");
	  echo("               </Table>\n");
	  echo("\n");
      echo("               <Span Style='Font-Size: 8'><BR></Span>\n");
	  echo("\n");
      echo("               <Table Width='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
      echo("                  <Tr><Td Width='100%' Height='20' ColSpan='2' Align='center' Valign='center'>\n");
      echo("                     <Span Style='Font-Size: 10pt'><B>���� ���</B></Span>\n");
      echo("                  </Td></Tr>\n");
      echo("                  <Tr><Td Height='160' ColSpan='2' Align='left' Valign='top' Style='border: 1px solid #555555; padding-top: 3; padding-left: 3; padding-right: 3; padding-bottom: 3;'>\n");
      echo("                     <Iframe Name='schedule' Frameborder='0' Width='100%' Height='100%' Leftmargin='0' Marginheight='0 Marginwidth='0' Scrolling='yes' Src='schedule.php3?db=$db&d=$session_calendar_viewday' Topmargin='0'>\n");
      echo("                     </Iframe>\n");
      echo("                  </Td></Tr>\n");
      echo("               </Table>\n");
      echo("\n");
      echo("               <Span Style='Font-Size: 5'><BR></Span>\n");
      echo("\n");
      echo("               <Table Width='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
      echo("                  <Tr><Td Width='25%' Height='20' Align='center' Valign='center'>\n");
      echo("                  </Td><Td Width='50%' Align='center' Valign='center'>\n");
      echo("                     <Span Style='Font-Size: 10pt'><B>���� ����</B></Span>\n");
      echo("                  </Td><Td Width='25%' Align='right' Valign='center'>\n");
      echo("                  </Td></Tr>\n");
      echo("                  <Tr><Td Height='200' ColSpan='3' Align='left' Valign='top' Style='border: 1px solid #555555; padding-top: 3; padding-left: 3; padding-right: 3; padding-bottom: 3;'>\n");
      echo("                     <Iframe Name='schedule_view' Frameborder='0' Width='100%' Height='100%' Leftmargin='0' Marginheight='0 Marginwidth='0' Scrolling='yes' Src='schedule_view.php3?db=$db&d=$session_calendar_viewday' Topmargin='0'>\n");
      echo("                     </Iframe>\n");
      echo("                  </Td></Tr>\n");
      echo("               </Table>\n");
      echo("\n");
      echo("            </Td></Tr>\n");
      echo("         </Table>\n");
      echo("\n");
      echo("      </Td><Td Width='630' Align='center' Valign='bottom'>\n");
   } else {
	  echo("      <Tr><Td Width='630' Align='center' Valign='bottom'>\n");
   }
   echo("\n");
   echo("         <Table Width='630' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("\n");
   echo("            <Form Name=calform Method=POST>\n");
   echo("               <Input Type=hidden Name=db Value='$db'>\n");
   echo("               <Input Type=hidden Name=year  Value=$year>\n");
   echo("               <Input Type=hidden Name=month Value=$month>\n");
   echo("            <Tr><Td Width='27%' Height='40' Align='left' Valign='bottom' Bgcolor='#ffffff' Style='padding-left: 5'>\n");
   if (strcmp($session_calendar_login, $bc[bcheck]) || !$session_calendar_login) {
      echo("               <A Href='login.php3' OnMouseOver=\"window.status='�α���'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("               <Img Src='image/mem_login.gif' Width='30' Height='18' Border='0' Alt='�α���'>\n");
      echo("               </A>&nbsp;\n");
      echo("               <A Href='joins.php3' OnMouseOver=\"window.status='����ڵ��'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("               <Img Src='image/mem_joins.gif' Width='30' Height='18' Border='0' Alt='����ڵ��'>\n");
      echo("               </A>&nbsp;\n");
      echo("               <A Href='admin/admin.php3' OnMouseOver=\"window.status='������ �α���'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("               <Img Src='image/icon_admin.gif' Width='30' Height='18' Border='0' Alt='������'><BR>\n");
      echo("               </A>\n");
   } else {
      echo("               <A Href='logout.php3' OnMouseOver=\"window.status='�α׾ƿ�'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("               <Img Src='image/mem_logout.gif' Width=30 Height=18 Border=0 Alt='�α׾ƿ�'>\n");
      echo("               </A>&nbsp;\n");
      echo("               <A Href='joins_edit.php3'OnMouseOver=\"window.status='����ڼ���'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("               <Img Src='image/mem_modify.gif' Width='30' Height='18' Border='0' Alt='����ڼ���'>\n");
      echo("               </A>&nbsp;\n");
      echo("               <A Href='joins_delete.php3' OnMouseOver=\"window.status='�����Ż��'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("               <Img Src='image/mem_delete.gif' Width='30' Height='18' Border='0' Alt='�����Ż��'>\n");
      echo("               </A>&nbsp;\n");
      echo("               <A Href='admin/admin.php3' OnMouseOver=\"window.status='������ �α���'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
      echo("               <Img Src='image/icon_admin.gif' Width='30' Height='18' Border='0' Alt='������'><BR>\n");
      echo("               </A>\n");
   }
   echo("            </Td><Td Width='11%' Align='right' Valign='center' Bgcolor='#ffffff'>\n");
   echo("               <A Href=\"javascript:send_it('yearprev');\" OnMouseOver=\"window.status='�ϳ���'; return true;\" OnMouseOut=\"window.status=''; return true;\">");
   echo("               <Img Src='image/icon_sunleft.gif' Width=26 Height=18 Border=0 Alt='�ϳ���'></A>\n");
   echo("               <A Href=\"javascript:send_it('monthprev')\" OnMouseOver=\"window.status='�Ѵ���'; return true;\" OnMouseOut=\"window.status=''; return true;\">");
   echo("               <Img Src='image/icon_moonleft.gif' Width=26 Height=18 Border=0 Alt='�Ѵ���'></A>\n");
   echo("            </Td><Td Width='24%' Align='center' Valign='center' Bgcolor='#ffffff' Style='padding-top: 3; padding-bottom: 3;'>\n");
   echo("               <Span Style='Font-Size: 13pt'><Font Color='#111111'>\n");
   printf("               <B>%04s�� %02s��</B><BR>\n", $year, $month);
   echo("               </Font></Span>\n");
   echo("               <Span Style='Font-Size: 9pt'><Font Color='#555555'>\n");
   echo("                 �ܱ�" . (2333 + $year) . " " . year2yukgap($year) . "�� " . year2ddi($year) . "��\n");
   echo("               </Span>\n");
   echo("            </Td><Td Width='11%' Align='left' Valign='center' Bgcolor='#ffffff'>\n");
   echo("               <A Href=\"javascript:send_it('monthnext')\" OnMouseOver=\"window.status='�Ѵ���'; return true;\" OnMouseOut=\"window.status=''; return true;\">");
   echo("               <Img Src='image/icon_moonright.gif' Width=26 Height=18 Border=0 Alt='�Ѵ���'></A>\n");
   echo("               <A Href=\"javascript:send_it('yearnext');\" OnMOuseOver=\"window.status='�ϳ���'; return true;\" OnMouseOut=\"window.status=''; return true;\">");
   echo("               <Img Src='image/icon_sunright.gif' Width=26 Height=18 Border=0 Alt='�ϳ���'><BR></A>\n");
   echo("            </Td><Td Widht='27%' Align='right' Valign='bottom' Bgcolor='#ffffff'>\n");
   echo("               <Span Style='Font-Size: 9pt'>\n");
   echo("               <Input Type=checkbox Name=sun2lun Value='1' OnClick=\"javascript:send_it('');\"");
   if ($sun2lun) echo(" Checked");
   echo(">&nbsp;����ǥ��&nbsp;\n");
   echo("               �� <A Href=\"javascript:send_it('today');\" OnMouseOver=\"window.status='���÷�'; return true;\" OnMouseOut=\"window.status=''; return true;\">���÷�</A> ��\n");
   echo("               </Span>\n");
   echo("            </Td></Tr>\n");
   echo("            </Form>\n");
   echo("         </Table>\n");
   echo("\n");
   echo("   <Table Width='630' Cellpadding='0' Cellspacing='1' Border='0' Bgcolor='#aaaaaa' Style='border: 2px solid #555555'>\n");
   echo("      <Tr><Td Width='90' Height='26' Align='center' Valign='center' Bgcolor='#dddddd'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#ff3333'>��</Font></Span>\n");
   echo("      </Td><Td Width='90' Align='center' Valign='center' Bgcolor='#dddddd'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>��</Font></Span>\n");
   echo("      </Td><Td Width='90' Align='center' Valign='center' Bgcolor='#dddddd'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>ȭ</Font></Span>\n");
   echo("      </Td><Td Width='90' Align='center' Valign='center' Bgcolor='#dddddd'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>��</Font></Span>\n");
   echo("      </Td><Td Width='90' Align='center' Valign='center' Bgcolor='#dddddd'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>��</Font></Span>\n");
   echo("      </Td><Td Width='90' Align='center' Valign='center' Bgcolor='#dddddd'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>��</Font></Span>\n");
   echo("      </Td><Td Width='90' Align='center' Valign='center' Bgcolor='#dddddd'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#3377cc'>��</Font></Span>\n");
   echo("      </Td></Tr>\n");

   // echo("<A Href='tttt' target='schedule'>target</A>");

   for ($i = 0; $i < 6; $i++) {
      echo("      <Tr>\n");
      for ($j = 1; $j <= 7; $j++) {
         $nn = ($i * 7) + $j;
         $today = $nn - $first;

         echo("      <Td Height='82' Align='left' Valign='top' Bgcolor='");
         if (!strcmp(str_date($year, $month, $today), date("Ymd"))) 
            echo("#aaff77"); 
         else if ($nn > $first && $today <= $days)
            echo("#ffffff");
         else 
            echo("#eeeeee");
         echo("' Style='padding-left: 2; padding-top: 3; padding-right: 1; padding-bottom: 1'>\n");
         echo("         <Span Style='Font-Size: 10pt'>\n");
         if ($nn > $first && $today <= $days) {
            // �α��� ���¶��.. ���� ������ ����Ѵ�.
            if (!strcmp($session_calendar_login, $bc[bcheck]) && $session_calendar_login) {
               echo("         <A Href='schedule.php3?db=$db&d=" . str_date($year,$month,$today) . "' Target='schedule' OnClick=\"parent.schedule_view.location.href='schedule_view.php3?db=$db&d=" . str_date($year,$month,$today) . "'\" OnMouseOver=\"window.status='��ϵ� ������ ���ϴ�'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
               echo("         <Font Color='");
               switch ($j) {
                  case 1 :
                     echo("#ff3333"); break;
                  case 7 :
                     echo("#3377cc"); break;
                  default :
                     echo("#000000");
               }
               echo("'> $today</A>\n");
               if ($sun2lun) // ���º��� üũ�� �Ǿ���������...
                  echo("         <Span Style='Font-Size: 8pt'>(".sol2lun($year,$month,$today).")</Span>\n");

               echo("         <A Href=\"javascript:window_open('" . str_date($year, $month, $today) . "');\" OnMouseOver=\"window.status='������ �߰��մϴ�'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
               echo("         <Img Src='image/icon_write.gif' Width='16' Height='16' Border='0' Alt='�����߰�'><BR>\n");
               echo("         </A></Font>\n");

               // �������� ��������
               $sql  = "SELECT * FROM $db WHERE wdate = '".str_date($year,$month,$today)."'";
               $sql .= " ORDER BY stime, id";

               $result = mysql_query($sql,$dbconn);
               $row = @mysql_num_rows($result);

               if ($row) {
                  echo("         <Table Width='99%' Height='58' Cellpadding='2' Cellspacing='0' Border='0'>\n");
                  echo("            <Tr><Td Wdith='100%' Height='100%' Align='left' Valign='top' Bgcolor='#ffff77' Style='border: 0px solid #555555;' Background='image/postit.gif'>\n");

                  // ���� ���� ǥ��
                  for ($k = 0; $k < $row && $k < 3; $k++) {
                     $data = mysql_fetch_array($result);
                     echo("               <Font Color='");
                     if ($data[hot]) echo("#ff0000"); else echo("#333333");
                     echo("'>\n");
                     echo("               <Span Style='Font-Size: 8pt'>" . strcut($data[title], 12, "...") . "</Span></Font><BR>\n");
                  }
                  if ($row > 3) {
                     echo("               <Span Style='Font-Size: 7pt'>&nbsp;&nbsp;&nbsp;&nbsp;:</Span><BR>\n");
                  }

                  echo("            </Td></Tr>\n");
                  echo("         </Table>\n");
               }
            } else { // �α��� ���°� �ƴϴ�.
               echo("         <Font Color='");
               switch ($j) {
                  case 1 :
                     echo("#ff3333"); break;
                  case 7 :
                     echo("#3377cc"); break;
                  default :
                     echo("#000000");
               }
               echo("'>$today");
               if ($sun2lun) // ���º��� üũ�� �Ǿ���������...
                  echo("         <Span Style='Font-Size: 8pt'>(".sol2lun($year,$month,$today).")</Span>\n");
               echo("</Font>\n");
            }
         }
         echo("         </Span>\n");
         echo("      </Td>\n");
      }
      echo("      </Tr>\n");
   }

   echo("\n");
   echo("         </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");

   mysql_close($dbconn);
?>