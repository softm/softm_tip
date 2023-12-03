<?PHP #programmed by WindHunter '97 ?> 
<?
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>일정 추가 성공 - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");

   echo("   <Body Bgcolor='#ffffff' Text='$#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0'>\n");
   echo("\n");
   echo("   <!-- 부모 윈도우 리로드 -->\n");
   echo("   <Script>opener.top.location.reload(true);</Script>\n");
   echo("\n");
   echo("   <Table Width='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Align='center' Valign='top'>\n");
   echo("\n");
   echo("         <Table Width='450' Height='340' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 2px solid #336699'>\n");
   echo("            <Tr><Td Width='25' Height='20' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Img Src='image/icon_calendar.gif' Width='18' Height='18' Border='0' Alt=''><BR>\n");
   echo("            </Td><Td Width='400' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Span Style='Font-Size: 10pt'>\n");
   echo("               <Font Color='#ffffff'><B>일정 추가 성공</B></Font>\n");
   echo("               </Span>\n");
   echo("            </Td><Td Width='25' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
   echo("               <Img Src='image/icon_arrow2.gif' Width='18' Height='18' Border='0'><BR>\n");
   echo("            </Td></Tr>\n");
   echo("            <Tr><Td Width='100%' Height='320' ColSpan='3' Align='center' Valign='center' Bgcolor='#dfdfdf'  Style='padding-left: 3; padding-right: 3; padding-top: 3; padding-bottom: 3'>\n");
   echo("               <Span Style='Font-Size: 9pt'>\n");
   echo("               일정이 저장 되었습니다.<BR>\n");
   echo("               <BR><BR><BR><BR><BR>\n");
   echo("               <Input Type=button Value=' 닫기 ' Class='writebutton' OnClick='javascript:self.close();'>\n");
   echo("               </Span>\n");
   echo("            </Td></Tr>\n");
   echo("         </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("      <Tr><Td Align='center' Valign='top'>\n");
   echo("\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");
   echo("   </Body>\n");
   echo("<Html>\n");
?>