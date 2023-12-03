<?PHP #programmed by WindHunter '97 ?> 
<?
   // -- 태크 출력 -- 시작 -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>달력 사용자탈퇴 - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language=Javascript><!--\n");
   echo("      function send_joins() {\n");
   echo("         if (document.joinsform.pwd.value == '') {\n");
   echo("            alert ('비밀번호를 입력해 주세요.');\n");
   echo("            document.joinsform.pwd.focus();\n");
   echo("\n");
   echo("            return;\n");
   echo("         }\n");
   echo("\n");
   echo("         document.joinsform.action = 'joins_delete_db.php3';\n");
   echo("         document.joinsform.submit ();\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0' OnLoad='document.joinsform.pwd.focus();'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");

   // -- 회원 탈퇴 폼 -- 시작 -- //
   echo("   <Table Width=600 Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#ffffff>\n");
   echo("      <Tr><Td Width=30% Align=left Valign=bottom Style='padding-left: 6; padding-bottom: 2;'>\n");
   echo("         <Img Src='image/mem_delete.gif' Width=60 Height=36 Border=0><BR>\n");
   echo("      </Td><Td Width=40% Align=center Valign=center Style='padding-top: 10; padding-bottom: 5'>\n");
   echo("         <Span Style='Font-Size: 15pt'><B>사용자 탈퇴</B></Span>\n");
   echo("      </Td><Td Width=30% Align=center Valign=center>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=100 ColSpan=3 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("\n");
   echo("      <Form Name=joinsform Method=POST Action='javascript:send_joins();'>\n");
   echo("\n");
   echo("         <Table Width=100% Height=100% Cellpadding=0 Cellspacing=0 Border=0 Style='border: 2px solid #555555'>\n");
   echo("            <Tr><Td Width=100% Height=50% Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("               사용자 비밀번호를 입력해 주십시오.\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Height=50% Align=center Valign=center Bgcolor=#ffffff>\n");
   echo("               비밀번호\n");
   echo("               <Input Type=password Name=pwd Size=20 Maxlength=8 Class='joinsinput'>\n");
   echo("            </Td></Tr>\n");
   echo("         </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align='center' Valign='center' Style='padding-top: 10; padding-bottom: 10;'>\n");
   echo("         <Input Type=submit Value='탈퇴합니다' Class='joinsbutton'>&nbsp;\n");
   echo("         <Input Type=button Value=' 돌아가기 ' OnClick='javascript:history.back();' Class='joinsbutton'>\n");
   echo("      </Td></Tr>\n");
   echo("\n");
   echo("      </Form>\n");
   echo("\n");
   echo("   </Table>\n");
   // 회원 탈퇴 폼 -- 끝 -- //

   echo("\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");
?>