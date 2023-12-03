<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   // admin_information.php3 파일이 없다면 새로 만든다.
   $fp = @fopen("admin_information.php3", "r");
   if (!$fp) { 
      $fp = @fopen("admin_information.php3", "w");
      // 파일 열기에 성공했다면
      if ($fp) {
         // admin_name, admin_pwd 값을 초기값으로 저장한다.
         // admin_pwd 는 crypt() 함수로 암호화 해서 저장
         $str  = "<?php\n";
		 $str .= "   $" . "admin_name=\"master\";\n;";
		 $str .= "   $" . "admin_pwd =\"" . str_replace("$", "_", crypt("0000", "1")) . "\";\n";
		 $str .= "?" . ">";

         fputs ($fp, $str);
      }
   }
   @fclose($fp);

   // 관리자 정보 파일 로드
   @include("admin_information.php3");

   // 관리자 로그인 상태가 아니라면.. 로그인 페이지로 넘긴다..
   if (strcmp($session_calendar_admin_login, $admin_name)) {
      echo("<meta http-equiv='refresh' content='0; url=login.php3'>");
      exit;
   }

   // DB 연결
   @include("../dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // -- 태크 출력 -- 시작 -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>달력 관리자 메뉴 - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "../define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language=javascript><!--\n");
   echo("      function send_admin() { \n");
   echo("         if (document.adminform.name.value.length < 4) {\n");
   echo("            alert ('관리자 이름(아이디)은 최소 4자 이상입니다.');\n");
   echo("            document.adminform.name.focus();\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         if (document.adminform.cpwd1.value != '') {\n");
   echo("            if (document.adminform.cpwd1.value.length < 4) { \n");
   echo("               alert ('새 비밀번호는 최소 4자 이상입니다.');\n");
   echo("               document.adminform.cpwd1.focus();\n");
   echo("               return;\n");
   echo("            }\n");
   echo("            if (document.adminform.cpwd1.value != document.adminform.cpwd2.value) { \n");
   echo("               alert ('새 비밀번호가 틀립니다.');\n");
   echo("               document.adminform.cpwd2.focus();\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         }\n");
   echo("\n");
   echo("         if (document.adminform.pwd.value == '') { \n");
   echo("            alert ('비밀번호를 적어주세요');\n");
   echo("            document.adminform.pwd.focus();\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         document.adminform.action = 'admin_save.php3';\n");
   echo("         document.adminform.submit();\n");
   echo("      } \n");
   echo("\n");
   echo("      // 스페이스 입력 체크.\n");
   echo("      function onlyNoSpace () {\n");
   echo("         if ( (event.keyCode == 32) )\n");
   echo("            event.returnValue = false;\n");
   echo("      }\n");
   echo("\n");
   echo("      function delete_user(idx) {\n");
   echo("         if (confirm('정말로 삭제할까요?\\n\\n삭제된 사용자정보는 복구할 수 없습니다.')) {\n");
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

   // -- 관라자 폼 -- 시작 -- //
   echo("   <Table Width=600 Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#ffffff>\n");
   echo("      <Tr><Td Width=30% Align=left Valign=bottom Style='padding-left: 6; padding-bottom: 2;'>\n");
   echo("         <Img Src='../image/icon_admin.gif' Width=60 Height=36 Border=0><BR>\n");
   echo("      </Td><Td Width=40% Align=center Valign=center Style='padding-top: 10; padding-bottom: 5'>\n");
   echo("         <Span Style='Font-Size: 15pt'><B>관리자 메뉴</B></Span>\n");
   echo("      </Td><Td Width=30% Align=right Valign=bottom>\n");
   echo("         【<A Href='logout.php3' OnMouseOver=\"window.status='관리자 로그아웃'; return true;\" OnMouseOut=\"window.status=''; return true;\"> 로그아웃 </A>】\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align=center Valign=top Bgcolor=#666666 Style='padding-left: 3; padding-top: 3; padding-right: 3; padding-bottom: 3;'>\n");
   echo("\n");
   echo("         <Form Name=adminform Method=POST Action='javascript:send_admin();'>\n");
   echo("\n");
   echo("         <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0>\n");
   echo("            <Tr><Td Wdith=20% Height=25 Align=center Valign=center Bgcolor=#eeeeee>\n");
   echo("               이름(아이디)\n");
   echo("            </Td><Td Width=30% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
   echo("               <Input Type=text Name=name Maxlength=20 Value='$admin_name' OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("            </Td><Td Width=20% Align=center Valign=center Bgcolor=#eeeeee>\n");
   echo("               비밀번호\n");
   echo("            </Td><Td Width=30% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
   echo("               <Input Type=password Name=pwd Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Wdith=20% Height=25 Align=center Valign=center Bgcolor=#eeeeee>\n");
   echo("               비밀번호 변경\n");
   echo("            </Td><Td Width=30% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
   echo("               <Input Type=password Name=cpwd1 Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("            </Td><Td Width=20% Align=center Valign=center Bgcolor=#eeeeee>\n");
   echo("               비밀번호 확인\n");
   echo("            </Td><Td Width=30% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
   echo("               <Input Type=password Name=cpwd2 Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("            </Td></Tr>\n");
   echo("         </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("\n");
   echo("      <Tr><Td ColSpan=3 Align=center Valign=center Style='padding-top: 5; padding-bottom: 5'>\n");
   echo("            <Input Type=submit Value=' 관리자 설정 변경' Class='joinsbutton'>\n");
   echo("      </Td></Tr>\n");
   echo("         </Form>\n");
   echo("\n");

   // 전체 등록자 수 얻기..
   $sql = "SELECT id, admin_id, email, jdate, lastdate FROM wscalendar_info ORDER BY admin_id ASC";
   $result = mysql_query($sql,$dbconn);
   $row = @mysql_num_rows($result);

   echo("      <Tr><Td ColSpan=3 Align=center Valign=top Bgcolor=#666666 Style='padding-left: 3; padding-top: 3; padding-right: 3; padding-bottom: 3;'>\n");
   echo("\n");

   if ($row) {
      echo("         <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0>\n");
      echo("            <Tr><Td Wdith=20% Height=25 Align=center Valign=center Bgcolor=#eeeeee>\n");
      echo("               등록된 사용자\n");
      echo("            </Td><Td Width=80% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
      echo("               <B>$row</B> 명\n");
      echo("            </Td></Tr>\n");
      echo("            <Tr><Td Height=25 ColSpan=2 Align=center Valign=center Bgcolor=#eeeeee Style='padding-top: 5; padding-bottom: 5;'>\n");
      echo("\n");
      echo("               <Table Width=95% Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#cccccc>\n");
      echo("                  <Tr><Td Width=20% Height=20 Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B>ID</B>\n");
      echo("                  </Td><Td Width=5% Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B> ⓔ </B>\n");
      echo("                  </Td><Td Width=20% Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B> 가 입 일 </B>\n");
      echo("                  </Td><Td Width=20% Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B> 최종접속 </B>\n");
      echo("                  </Td><Td Width=35% Align=center Valign=center Bgcolor=#aaaaaa>\n");
      echo("                     <B> 명 령 어 </B>\n");
      echo("                  </Td></Tr>\n");
      for ($i=0; $i<$row; $i++) {
         $user = mysql_fetch_array($result);
         echo("                  <Tr><Td Height=20 Align=center Valign=center Bgcolor=#ffffff>\n");
         echo("                     <B>$user[admin_id]</B>\n");
         echo("                  </Td><Td Align=center Valign=center Bgcolor=#ffffff>\n");
         if ($user[email]) {
//            wsmail 을 사용한다면 .. ^^
//            echo("                     <A Href='../../mail/mail.php3?to=$user[email]' 
            echo("                     <A Href='mailto:$user[email]' OnMouseOver=\"window.status='$user[admin_id]님께 메일 발송'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
            echo("                     <Img Src='../image/icon_email.gif' Width=18 Height=18 Border=0 Alt='$user[email]'><BR>\n");
            echo("                     </A>\n");
         } else {
            echo("                     <Img Src='../image/icon_email2.gif' Width=18 Height=18 Border=0><BR>\n");
         }
         echo("                  </Td><Td Align=center Valign=center Bgcolor=#ffffff>\n");
         echo("                     ".date("Y년 m월 d일", $user[jdate])."\n");
         echo("                  </Td><Td Align=center Valign=center Bgcolor=#ffffff>\n");
         echo("                     ".date("Y년 m월 d일", $user[lastdate])."\n");
         echo("                  </Td><Td Align=left Valign=center Bgcolor=#ffffff>\n");
         echo("                     【<A Href='javascript:delete_user($user[id])' OnMouseOver=\"window.status='사용자 계정을 강제로 삭제합니다'; return true;\" OnMouseOut=\"window.status=''; return true;\"> 사용자 삭제 </A>】<BR>\n");
         echo("                  </Td></Tr>\n");
      }
      echo("               </Table>\n");
      echo("\n");
      echo("            </Td></Tr>\n");
      echo("         </Table>\n");
   } else {
      echo("         <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0>\n");
      echo("            <Tr><Td Wdith=20% Height=25 Align=center Valign=center Bgcolor=#eeeeee>\n");
      echo("               등록된 사용자\n");
      echo("            </Td><Td Width=80% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 5'>\n");
      echo("               <B>사용자가 없습니다.</B>\n");
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