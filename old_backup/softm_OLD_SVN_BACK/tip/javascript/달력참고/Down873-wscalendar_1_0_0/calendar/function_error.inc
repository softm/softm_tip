<?
   // 에러처리 함수부분
   function error_message($msg_title,$msg_msg) {

      echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
      echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
      echo("\n");
      echo("   <Table Width='400' Cellpadding='0' Cellspacing='0' Border='0' Style='border: 2px solid #336699'>\n");
      echo("      <Tr><Td Width='25' Height='20' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
      echo("         <Img Src='image/icon_logo.gif' Width='18' Height='18' Border='0' Alt=''><BR>\n");
      echo("      </Td><Td Width='350' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
      echo("         <Span Style='Font-Size: 10pt'>\n");
      echo("         <Font Color='#ffffff'><B>$msg_title</B></Font>\n");
      echo("         </Span>\n");
      echo("      </Td><Td Width='25' Align='center' Valign='center' Bgcolor='#4477aa'>\n");
      echo("         <Img Src='image/icon_target.gif' Width='18' Height='18' Border='0'><BR>\n");
      echo("      </Td></Tr>\n");
      echo("      <Tr><Td Width='100%' ColSpan='3' Align='center' Valign='bottom' Bgcolor='#dfdfdf'  Style='padding-left: 10; padding-right: 10; padding-top: 10; padding-bottom: 10'>\n");
      echo("         <Span Style='Font-Size: 10pt'>$msg_msg</Span>\n");
      echo("      </Td></Tr>\n");
      echo("   </Table>\n");
      echo("   <BR>\n");
      echo("   <Input Type='button' Value=' 뒤로 ' OnClick='javascript:history.back();' Style='height: 22px; border-width: 2; font-size: 10pt; border-style: ridge; border-color: #d0d0d0; background-color: #dfdfdf;'>\n");
      echo("\n");
      echo("      </Td></Tr>\n");
      echo("   </Table>\n");
      echo("\n");

      exit; // 종료
   }
?>