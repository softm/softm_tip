<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   // -- ��ũ ��� -- ���� -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>�޷� �����Ż�� �Ϸ� - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");

   // -- ȸ�� Ż�� �� -- ���� -- //
   echo("   <Table Width=600 Cellpadding=0 Cellspacing=1 Border=0 Bgcolor=#ffffff>\n");
   echo("      <Tr><Td Width=30% Align=left Valign=bottom Style='padding-left: 6; padding-bottom: 2;'>\n");
   echo("         <Img Src='image/mem_delete.gif' Width=60 Height=36 Border=0><BR>\n");
   echo("      </Td><Td Width=40% Align=center Valign=center Style='padding-top: 10; padding-bottom: 5'>\n");
   echo("         <Span Style='Font-Size: 15pt'><B>����� Ż��</B></Span>\n");
   echo("      </Td><Td Width=30% Align=center Valign=center>\n");
   echo("         &nbsp;\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Height=100 ColSpan=3 Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("\n");
   echo("         <Table Width=100% Height=100% Cellpadding=0 Cellspacing=0 Border=0 Style='border: 2px solid #555555'>\n");
   echo("            <Tr><Td Width=100% Height=100% Align=center Valign=center Bgcolor=#dddddd>\n");
   echo("               <B>'$session_calendar_name'</B>�Բ��� ��û�Ͻ� <B>Ż�� ó��</B>�� �Ϸ�Ǿ����ϴ�.<BR>\n");
   echo("               <BR>\n");
   echo("               �׵��� �̿��� �ּż� ����� �����մϴ�.<BR>\n");
   echo("               �����ε� �����ϸ� �����Ͻñ� �ٶ��ϴ�.<BR>��ſ� �Ϸ� �ǽʽÿ�.<BR>\n");
   echo("            </Td></Tr>\n");
   echo("         </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td ColSpan=3 Align='center' Valign='center' Style='padding-top: 10; padding-bottom: 10;'>\n");
   echo("         <Input Type=button Value=' ó������ ' OnClick=\"javascript:location='calendar.php3'\" Class='joinsinput'>\n");
   echo("      </Td></Tr>\n");
   echo("\n");
   echo("      </Form>\n");
   echo("\n");
   echo("   </Table>\n");
   // ȸ�� Ż�� �� -- �� -- //

   echo("\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");

   // ���� �����
   session_unregister("session_calendar_viewday");
   session_unregister("session_calendar_login");
   session_unregister("session_calendar_id");
   session_unregister("session_calendar_name");
?>