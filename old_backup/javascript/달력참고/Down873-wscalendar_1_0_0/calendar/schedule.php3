<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   // 날자 셋팅
   $session_calendar_viewday = $d;

   // DB 연결
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>스케쥴 보기 - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   @include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");

   echo("   <Body Bgcolor='#ffffff' Text='$#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0'>\n");
   echo("\n");
   echo("\n");
   echo("   <Table Width='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Align='center' Valign='top'>\n");
   echo("\n");
   echo("         <Table Width='100%' Cellpadding='0' Cellspacing='1' Border='0'>\n");
   echo("\n");

   echo("         <Tr><Td Height='20' ColSpan='2' Align='center' Valign='top' Bgcolor='#555555' Style='padding-left: 3; padding-top: 3; padding-right: 3; padding-bottom: 3;'>\n");
   echo("            <Font Color='#ffffff'>\n");
   echo("            <B>".substr($d, 0, 4)."년 ".substr($d, 4, 2)."월 ".substr($d, 6, 2)."일</B>\n");
   echo("            </Font>\n");
   echo("         </Td></Tr>\n");

   // 선택 날짜의 일정 가져오기
   $sql = "SELECT * FROM $db WHERE wdate = '$d' ORDER BY stime, id";
   $result = mysql_query($sql,$dbconn);
   $row = @mysql_num_rows($result);

   if (!$row) {
      echo("         <Tr><Td Height='100' Align='center' Valign='top' Bgcolor='#ffffff'>\n");
      echo("            <BR>\n");
      echo("            일정이 없습니다.\n");
      echo("         </Td></Tr>\n");
   } else {
	  for ($i=0; $i<$row; $i++) {
         $data = mysql_fetch_array($result);
         echo("         <Tr><Td Width='20%' Height='20' Align='center' Valign='top' Bgcolor='");
         if ($i % 2) echo("#eebbdd"); else echo("#ddbbdd");
         echo("' Style='padding-left: 3; padding-top: 3; padding-right: 3; padding-bottom: 3;'>\n");
         echo("            $data[stime]\n");
         echo("         </Td><Td Width='80%' Align='left' Valign='top' Bgcolor='");
         if ($i % 2) echo("#ddeebb"); else echo("#ddeeaa");
         echo("' Style='padding-left: 3; padding-right: 3; padding-top: 3; padding-bottom: 3;'>\n");
         echo("            <A Href='schedule_view.php3?db=$db&idx=$data[id]&d=$d' Target='schedule_view' OnMouseOver=\"window.status='선택된 일정의 상세 내용을 봅니다'; return true;\" OnMouseOut=\"window.status=''; return true;\">\n");
         echo("            <Font Color='");
         if ($data[hot]) echo("#ff0000"); else echo("#333333");
         echo("'>\n");
         echo("            $data[title]\n");
         echo("            </Font></A>\n");
         echo("         </Td></Tr>\n");
	  }
   }

   echo("         </Table>\n");
   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");
   echo("   </Body>\n");
   echo("<Html>\n");

   mysql_close($dbconn);
?>