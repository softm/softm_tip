<?PHP #programmed by WindHunter '97 ?> 
<? // 일정 추가

   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>일정추가 - WorkSpace</Title>\n");
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
   echo("         document.writeform.action = 'schedule_write_db.php3';\n");
   echo("         document.writeform.submit();\n");
   echo("      } \n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='$#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0' OnLoad='window.focus(); document.writeform.title.focus();'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='top'>\n");
   echo("\n");
   echo("         <Form Name='writeform' Method='POST' Action='javascript:send_it()'>\n");
   echo("            <Input Type='hidden' Name='db' Value='$db'>\n");
   echo("            <INput Type='hidden' Name='d' Value='$d'>\n");
   echo("   <Table Width='450' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 2px solid #336699'>\n");
   echo("      <Tr><Td Width='25' Height='20' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("         <Img Src='image/icon_calendar.gif' Width='18' Height='18' Border='0' Alt=''><BR>\n");
   echo("      </Td><Td Width='400' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("         <Span Style='Font-Size: 10pt'>\n");
   echo("         <Font Color='#ffffff'><B>일정 추가</B></Font>\n");
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
   echo(substr($d, 0, 4) . "년 " . substr($d, 4, 2) . "월 " . substr($d, 6, 2) . "일");
   echo("' Disabled Class='writeinput' OnKeypress='onlyNoSpace();'>\n");
   echo("            </Td><Td Width='10%' Align='center' Valign='center'>\n");
   echo("               <B>시간</B>\n");
   echo("            </Td><Td Width='47%' Align='left' Valign='center'>\n");
   echo("               <Select Name='t_min' Size=1 Class='writeinput'>\n");
   for ($i = 0; $i < 24; $i++) {
      printf("               <Option Value='%02s'", $i);
      if (date("H") == $i) echo(" Selected");
      printf(">&nbsp;%02s&nbsp;</Option>\n", $i);
   }
   echo("               </Select>&nbsp;<B>:</B>\n");
   echo("               <Select Name='t_sec' Size=1 Class='writeinput'>\n");
   for ($i = 0; $i < 60; $i+=5) {
      printf("               <Option Value='%02s'", $i);
      if (intval(date("i")/5) * 5 == $i) echo(" Selected");
      printf(">&nbsp;%02s&nbsp;</Option>\n", $i);
   }
   echo("               </Select>&nbsp;&nbsp;\n");
   echo("               <Input Type=checkbox Name='taguse' Value='1'>&nbsp;HTML\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Height='20' Align='center' Valign='center'>\n");
   echo("               <B>일정 제목</B>\n");
   echo("            </Td><Td ColSpan='3' Align='left' Valign='center' Style='padding-left: 0'>\n");
   echo("               <Input Type='text' Name='title' Size='40' Maxlength='50' Value='' Class='writeinput'>&nbsp;&nbsp;\n");
   echo("               <Input Type='checkbox' Name='hot' Value='1'>&nbsp;중요일정\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Height='20' ColSpan='4' Align='left' Valign='center' Style='padding-left: 5; padding-right-5; padding-top: 5; padding-bottom: 0'>\n");
   echo("               <Textarea Wrap='physical' Rows='12' Name='content' Cols='68' Class='writetext'></Textarea>\n");
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