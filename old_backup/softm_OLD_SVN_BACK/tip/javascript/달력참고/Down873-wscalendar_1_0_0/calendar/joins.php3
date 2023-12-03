<?PHP #programmed by WindHunter '97 ?> 
<?
   // -- 태크 출력 -- 시작 -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>달력 사용자등록 - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language='JScript' Src='joins.js'></Script>\n");
   echo("   <Script Language='JavaScript'><!--\n");
   echo("      function check_id() {\n");
   echo("         window.open('check_id.php3?id=' + document.joinsform.id.value, 'check_id', 'width=400, height=200, marginwidth=0, marginheight=0, resizable=0, scrollbars=0, status=1');\n");
   echo("      }\n");
   echo("\n");
   echo("      function check_zip() {\n");
   echo("         window.open('zipcode.php3', 'check_zip', 'width=400, height=300, marginwidth=0, marginheight=0, resizable=0, scrollbars=1, status=1');\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0' OnLoad='document.joinsform.id.focus();'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");

   // -- 회원 가입 폼 -- 시작 -- //
   echo("   <Table Width=600 Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#ffffff>\n");
   echo("      <Tr><Td Width=30% Align=left Valign=bottom Style='padding-left: 6; padding-bottom: 2;'>\n");
   echo("         <Img Src='image/mem_joins.gif' Width=60 Height=36 Border=0><BR>\n");
   echo("      </Td><Td Width=40% Align=center Valign=center Style='padding-top: 10; padding-bottom: 5'>\n");
   echo("         <Span Style='Font-Size: 15pt'><B>사용자 등록</B></Span>\n");
   echo("      </Td><Td Width=30% Align=center Valign=center>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align=center Valign=top Bgcolor=#444444>\n");
   echo("\n");
   echo("      <Form Name=joinsform Method=POST Action='javascript:send_joins();'>\n");
   echo("\n");
   echo("   <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0 Style='border: 2px solid #888888'>\n");
   echo("      <Tr><Td Width=17% Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>사용자 ID</B>\n");
   echo("      </Td><Td Width=83% ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=id Size=20 Maxlength=10 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("         <Input Type=button Value=' ID 조회 ' OnClick='javascript:check_id();' Class=joinsbutton>\n");
   echo("         &nbsp;영문 & 숫자로 5~10자 사이로 작성\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Width=17% Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>비밀번호</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=pwd Size=20 Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("      </Td><Td Width=17% Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>비밀번호 확인</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=pwd2 Size=20 Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>이름</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=name Size=20 Maxlength=20 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("         &nbsp;한글실명으로 입력\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>이메일주소</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=email Size=40 Maxlength=50 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>주민등록번호</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=ssn1 Size=6 Maxlength=6 OnKeypress='javascript:onlyNumber()' Class='joinsinput'> -\n");
   echo("         <Input Type=text Name=ssn2 Size=7 Maxlength=7 OnKeypress='javascript:onlyNumber()' Class='joinsinput'>\n");
   echo("         &nbsp;허위 주민번호 입력시 가입취소 함다~\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>우편번호</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=zip1 Size=3 Maxlength=3 OnKeypress='javascript:onlyNumber()' Class='joinsinput'> -\n");
   echo("         <Input Type=text Name=zip2 Size=3 Maxlength=3 OnKeypress='javascript:onlyNumber()' Class='joinsinput'>\n");
   echo("         <Input Type=button Name=zipbutton Value=' 주소입력 ' OnClick='javascript:check_zip();' Class=joinsbutton>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>연락주소</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=address Size=70 Maxlength=100 Class='joinsinput'>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>전화번호</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=phone Size=13 Maxlength=13 Class='joinsinput'>\n");
   echo("         &nbsp;항상 연락 받으실 수 있는 전화번호\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align='center' Valign='center' Style='padding-top: 10; padding-bottom: 10;'>\n");
   echo("         <Input Type=submit Value='가입합니다' Class='joinsbutton'>&nbsp;\n");
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