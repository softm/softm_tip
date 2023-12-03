<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");

   if (!$session_calendar_id)
      error_message("접근 오류","정상적인 접근이 아닙니다.");

   // DB 연결
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   $sql = "SELECT * FROM wscalendar_info WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);

   $member = @mysql_fetch_array($result);

   // 사용자 로그인 상태인가?
   if (strcmp($session_calendar_login, $member[bcheck]))
      error_message("접근 오류","정상적인 접근이 아닙니다.");

   // -- 태크 출력 -- 시작 -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>달력 사용자수정 - WorkSpace</Title>\n");
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

   // -- 회원 가입 폼 -- 시작 -- //
   echo("   <Table Width=600 Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#ffffff>\n");
   echo("      <Tr><Td Width=30% Align=left Valign=bottom Style='padding-left: 6; padding-bottom: 2;'>\n");
   echo("         <Img Src='image/mem_modify.gif' Width=60 Height=36 Border=0><BR>\n");
   echo("      </Td><Td Width=40% Align=center Valign=center Style='padding-top: 10; padding-bottom: 5'>\n");
   echo("         <Span Style='Font-Size: 15pt'><B>사용자 수정</B></Span>\n");
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
   echo("         <B>사용자 ID</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Span Style='Font-Size: 10pt'><B>$member[admin_id]</B></Span>\n");
   echo("      </Td><Td Width=17% Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>비밀번호</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=pwd Size=20 Maxlength=8 Class='joinsinput'>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Width=17% Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>비밀번호 변경</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=cpwd1 Size=20 Maxlength=8 Class='joinsinput'>\n");
   echo("      </Td><Td Width=17% Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>비밀번호 확인</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=cpwd2 Size=20 Maxlength=8 Class='joinsinput'>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>이름</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Span Style='Font-Size: 10pt'><B>$member[name]</B></Span>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>이메일주소</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=email Size=40 Maxlength=50 Value='$member[email]' Class='joinsinput'>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>주민등록번호</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Span Style='Font-Size: 10pt'><B>$member[ssn1] - $member[ssn2]</B></Span>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>우편번호</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=zip1 Size=3 Maxlength=3 Value='".substr($member[zip], 0, 3)."' Class='joinsinput'> -\n");
   echo("         <Input Type=text Name=zip2 Size=3 Maxlength=3 Value='".substr($member[zip], 3, 3)."' Class='joinsinput'>\n");
   echo("         <Input Type=button Value=' 주소입력 ' OnClick='javascript:check_zip();' Class=joinsbutton>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>연락주소</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=address Size=70 Maxlength=100 Value='$member[address]' Class='joinsinput'>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>전화번호</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=phone Size=13 Maxlength=13 Value='$member[phone]' Class='joinsinput'>\n");
   echo("         &nbsp;항상 연락 받으실 수 있는 전화번호\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align='center' Valign='center' Style='padding-top: 10; padding-bottom: 10;'>\n");
   echo("         <Input Type=submit Value='수정합니다' Class='joinsbutton'>&nbsp;\n");
   echo("         <Input Type=reset  Value=' 다시작성 ' Class='joinsbutton'>\n");
   echo("      </Td></Tr>\n");
   echo("\n");
   echo("      </Form>\n");
   echo("\n");
   echo("   </Table>\n");
   // 회원 가입 폼 -- 끝 -- //

   echo("\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");
?>