<?PHP #programmed by WindHunter '97 ?> 
<?
   // -- ��ũ ��� -- ���� -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>�޷� ����ڵ�� - WorkSpace</Title>\n");
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

   // -- ȸ�� ���� �� -- ���� -- //
   echo("   <Table Width=600 Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#ffffff>\n");
   echo("      <Tr><Td Width=30% Align=left Valign=bottom Style='padding-left: 6; padding-bottom: 2;'>\n");
   echo("         <Img Src='image/mem_joins.gif' Width=60 Height=36 Border=0><BR>\n");
   echo("      </Td><Td Width=40% Align=center Valign=center Style='padding-top: 10; padding-bottom: 5'>\n");
   echo("         <Span Style='Font-Size: 15pt'><B>����� ���</B></Span>\n");
   echo("      </Td><Td Width=30% Align=center Valign=center>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align=center Valign=top Bgcolor=#444444>\n");
   echo("\n");
   echo("      <Form Name=joinsform Method=POST Action='javascript:send_joins();'>\n");
   echo("\n");
   echo("   <Table Width=100% Cellpadding=0 Cellspacing=1 Border=0 Style='border: 2px solid #888888'>\n");
   echo("      <Tr><Td Width=17% Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>����� ID</B>\n");
   echo("      </Td><Td Width=83% ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=id Size=20 Maxlength=10 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("         <Input Type=button Value=' ID ��ȸ ' OnClick='javascript:check_id();' Class=joinsbutton>\n");
   echo("         &nbsp;���� & ���ڷ� 5~10�� ���̷� �ۼ�\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Width=17% Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>��й�ȣ</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=pwd Size=20 Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("      </Td><Td Width=17% Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>��й�ȣ Ȯ��</B>\n");
   echo("      </Td><Td Width=33% Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=password Name=pwd2 Size=20 Maxlength=8 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�̸�</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=name Size=20 Maxlength=20 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("         &nbsp;�ѱ۽Ǹ����� �Է�\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�̸����ּ�</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=email Size=40 Maxlength=50 OnKeypress='onlyNoSpace()' Class='joinsinput'>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�ֹε�Ϲ�ȣ</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=ssn1 Size=6 Maxlength=6 OnKeypress='javascript:onlyNumber()' Class='joinsinput'> -\n");
   echo("         <Input Type=text Name=ssn2 Size=7 Maxlength=7 OnKeypress='javascript:onlyNumber()' Class='joinsinput'>\n");
   echo("         &nbsp;���� �ֹι�ȣ �Է½� ������� �Դ�~\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�����ȣ</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=zip1 Size=3 Maxlength=3 OnKeypress='javascript:onlyNumber()' Class='joinsinput'> -\n");
   echo("         <Input Type=text Name=zip2 Size=3 Maxlength=3 OnKeypress='javascript:onlyNumber()' Class='joinsinput'>\n");
   echo("         <Input Type=button Name=zipbutton Value=' �ּ��Է� ' OnClick='javascript:check_zip();' Class=joinsbutton>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>�����ּ�</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=address Size=70 Maxlength=100 Class='joinsinput'>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=30 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("         <B>��ȭ��ȣ</B>\n");
   echo("      </Td><Td ColSpan=3 Align=left Valign=center Bgcolor=#eeeeee Style='padding-left: 10;'>\n");
   echo("         <Input Type=text Name=phone Size=13 Maxlength=13 Class='joinsinput'>\n");
   echo("         &nbsp;�׻� ���� ������ �� �ִ� ��ȭ��ȣ\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align='center' Valign='center' Style='padding-top: 10; padding-bottom: 10;'>\n");
   echo("         <Input Type=submit Value='�����մϴ�' Class='joinsbutton'>&nbsp;\n");
   echo("         <Input Type=reset  Value=' �ٽ��ۼ� ' Class='joinsbutton'>\n");
   echo("      </Td></Tr>\n");
   echo("\n");
   echo("      </Form>\n");
   echo("\n");
   echo("   </Table>\n");
   // ȸ�� ���� �� -- �� -- //

   echo("\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");
?>