<?PHP #programmed by WindHunter '97 ?> 
<? // 일정 추가

   // DB 연결
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   $sql = "SELECT * FROM $db WHERE id = '$idx' LIMIT 1";
   $result = mysql_query($sql,$dbconn);
   $data = @mysql_fetch_array($result);
   if (!$data)
      exit;

   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>일정수정 - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script language='javascript'><!--\n");
   echo("      function send_it() { \n");
   echo("         if (document.writeform.title.value == '') { \n");
   echo("            alert ('일정 제목을 적어주세요');\n");
   echo("            document.writeform.title.focus();\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         if (document.writeform.content.value == '') { \n");
   echo("            alert ('일정 내용을 적어주세요');\n");
   echo("            document.writeform.content.focus();\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         document.writeform.action = 'schedule_edit_db.php3';\n");
   echo("         document.writeform.submit();\n");
   echo("      } \n");
   echo("\n");
   echo("      // 스페이스 입력 체크.\n");
   echo("      function onlyNoSpace () {\n");
   echo("         if ( (event.keyCode == 32) )\n");
   echo("            event.returnValue = false;\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='$#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0' OnLoad='window.focus();'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='top'>\n");
   echo("\n");
   echo("         <Form Name='writeform' Method='POST' Action='javascript:send_it()'>\n");
   echo("            <Input Type='hidden' Name='db' Value='$db'>\n");
   echo("            <Input Type='hidden' Name='idx' Value='$idx'>\n");
   echo("            <Input Type='hidden' Name='d' Value='$data[wdate]'>\n");
   echo("   <Table Width='450' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 2px solid #336699'>\n");
   echo("      <Tr><Td Width='25' Height='20' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("         <Img Src='image/icon_calendar.gif' Width='18' Height='18' Border='0' Alt=''><BR>\n");
   echo("      </Td><Td Width='400' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("         <Span Style='Font-Size: 10pt'>\n");
   echo("         <Font Color='#ffffff'><B>일정 수정</B></Font>\n");
   echo("         </Span>\n");
   echo("      </Td><Td Width='25' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("         <Img Src='image/icon_target.gif' Width='18' Height='18' Border='0'><BR>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Width='100%' ColSpan='3' Align='right' Valign='bottom' Bgcolor='#dfdfdf'  Style='padding-left: 3; padding-right: 3; padding-top: 3; padding-bottom: 3'>\n");
   echo("         <Table Width='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("            <Tr><Td Width='20%' Height='20' Align='center' Valign='center'>\n");
   echo("               <B>날짜</B>\n");
   echo("            </Td><Td Width='23%' Align='left' Valign='center' Style='padding-left: 0'>\n");
   echo("               <Input Type='text' Size='15' Value='");
   echo(substr($data[wdate], 0, 4) . "년 " . substr($data[wdate], 4, 2) . "월 " . substr($data[wdate], 6, 2) . "일");
   echo("' Disabled Class='writeinput' OnKeypress='onlyNoSpace();'>\n");
   echo("            </Td><Td Width='10%' Align='center' Valign='center'>\n");
   echo("               <B>시간</B>\n");
   echo("            </Td><Td Width='47%' Align='left' Valign='center'>\n");
   echo("               <Select Name='t_min' Size=1 Class='writeinput'>\n");
   for ($i = 0; $i < 24; $i++) {
      printf("               <Option Value='%02s'", $i);
      if (substr($data[stime], 0, 2) == $i) echo(" Selected");
      printf(">&nbsp;%02s&nbsp;</Option>\n", $i);
   }
   echo("               </Select>&nbsp;<B>:</B>\n");
   echo("               <Select Name='t_sec' Size=1 Class='writeinput'>\n");
   for ($i = 0; $i < 60; $i+=5) {
      printf("               <Option Value='%02s'", $i);
      if (intval(substr($data[stime], 3, 2)/5) * 5 == $i) echo(" Selected");
      printf(">&nbsp;%02s&nbsp;</Option>\n", $i);
   }
   echo("               </Select>&nbsp;&nbsp;\n");
   echo("               <Input Type=checkbox Name=taguse Value='1'");
   if ($data[taguse]) echo(" Checked");
   echo(">&nbsp;HTML\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Height='20' Align='center' Valign='center'>\n");
   echo("               <B>일정 제목</B>\n");
   echo("            </Td><Td ColSpan='3' Align='left' Valign='center' Style='padding-left: 0'>\n");
   echo("               <Input Type='text' Name='title' Size='40' Maxlength='50' Value='$data[title]' Class='writeinput' OnKeypress='onlyNoSpace();'>&nbsp;&nbsp;\n");
   echo("               <Input Type='checkbox' Name='hot' Value='1'");
   if ($data[hot]) echo(" Checked");
   echo(">&nbsp;중요일정\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Height='20' ColSpan='4' Align='left' Valign='center' Style='padding-left: 5; padding-right-5; padding-top: 5; padding-bottom: 0'>\n");
   echo("               <Textarea Wrap='physical' Rows='12' Name='content' Cols='68' Class='writetext'>$data[memo]</Textarea>\n");
   echo("            </Td></Tr>\n");
   echo("         </Table>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Width='100%' Height='10' ColSpan='3' Align='center' Valign='bottom' Bgcolor='#dfdfdf'  Style='padding-left: 3; padding-right: 3; padding-top: 3; padding-bottom: 6'>\n");
   echo("               <Input Type='submit' Value=' 저장하기 ' Class='writebutton'>\n");
   echo("               <Input Type='reset' Value=' 다시작성 ' Class='writebutton'>\n");
   echo("      </Td></Tr>\n");
   echo("            </Form>\n");
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