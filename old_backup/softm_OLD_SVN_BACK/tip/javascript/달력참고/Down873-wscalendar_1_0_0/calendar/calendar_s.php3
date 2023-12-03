<?PHP #programmed by WindHunter '97 ?> 
<?
   //한달의 총 날짜 계산 함수
   // zzt_calendar 에서 참조 ^^a
   function Month_Day($i_month,$i_year){
      $day=1;
      while(checkdate($i_month,$day,$i_year)) {
         $day++;
      }
      $day--;
      return $day;
   }

   // 음력 <> 양력 변환 함수들
   function sunlunar_data() { 
      return "1212122322121-1212121221220-1121121222120-2112132122122-2112112121220-2121211212120-2212321121212-2122121121210-2122121212120-1232122121212-1212121221220-1121123221222-1121121212220-1212112121220-2121231212121-2221211212120-1221212121210-2123221212121-2121212212120-1211212232212-1211212122210-2121121212220-1212132112212-2212112112210-2212211212120-1221412121212-1212122121210-2112212122120-1231212122212-1211212122210-2121123122122-2121121122120-2212112112120-2212231212112-2122121212120-1212122121210-2132122122121-2112121222120-1211212322122-1211211221220-2121121121220-2122132112122-1221212121120-2121221212110-2122321221212-1121212212210-2112121221220-1231211221222-1211211212220-1221123121221-2221121121210-2221212112120-1221241212112-1212212212120-1121212212210-2114121212221-2112112122210-2211211412212-2211211212120-2212121121210-2212214112121-2122122121120-1212122122120-1121412122122-1121121222120-2112112122120-2231211212122-2121211212120-2212121321212-2122121121210-2122121212120-1212142121212-1211221221220-1121121221220-2114112121222-1212112121220-2121211232122-1221211212120-1221212121210-2121223212121-2121212212120-1211212212210-2121321212221-2121121212220-1212112112210-2223211211221-2212211212120-1221212321212-1212122121210-2112212122120-1211232122212-1211212122210-2121121122210-2212312112212-2212112112120-2212121232112-2122121212110-2212122121210-2112124122121-2112121221220-1211211221220-2121321122122-2121121121220-2122112112322-1221212112120-1221221212110-2122123221212-1121212212210-2112121221220-1211231212222-1211211212220-1221121121220-1223212112121-2221212112120-1221221232112-1212212122120-1121212212210-2112132212221-2112112122210-2211211212210-2221321121212-2212121121210-2212212112120-1232212122112-1212122122120-1121212322122-1121121222120-2112112122120-2211231212122-2121211212120-2122121121210-2124212112121-2122121212120-1212121223212-1211212221220-1121121221220-2112132121222-1212112121220-2121211212120-2122321121212-1221212121210-2121221212120-1232121221212-1211212212210-2121123212221-2121121212220-1212112112220-1221231211221-2212211211220-1212212121210-2123212212121-2112122122120-1211212322212-1211212122210-2121121122120-2212114112122-2212112112120-2212121211210-2212232121211-2122122121210-2112122122120-1231212122212-1211211221220-2121121321222-2121121121220-2122112112120-2122141211212-1221221212110-2121221221210-2114121221221"; 
   } 

   function sol2lun($year,$month,$day) {
      $getYEAR  = (int)$year; 
      $getMONTH = (int)$month; 
      $getDAY   = (int)$day; 

      $arrayDATASTR = sunlunar_data(); 
      $arrayDATA    = explode("-",$arrayDATASTR); 

      $arrayLDAYSTR = "31-0-31-30-31-30-31-31-30-31-30-31"; 
      $arrayLDAY    = explode("-",$arrayLDAYSTR); 

      $arrayYUKSTR  = "갑-을-병-정-무-기-경-신-임-계"; 
      $arrayYUK     = explode("-",$arrayYUKSTR); 

      $arrayGAPSTR  = "자-축-인-묘-진-사-오-미-신-유-술-해"; 
      $arrayGAP     = explode("-",$arrayGAPSTR); 

      $arrayDDISTR  = "쥐-소-호랑이-토끼-용-뱀-말-양-원숭이-닭-개-돼지"; 
      $arrayDDI     = explode("-",$arrayDDISTR); 

      $arrayWEEKSTR = "일-월-화-수-목-금-토"; 
      $arrayWEEK    = explode("-",$arrayWEEKSTR); 

      $dt = $arrayDATA; 

      for ($i=0;$i<=168;$i++) { 
         $dt[$i] = 0; 
         for ($j=0;$j<12;$j++) { 
            switch (substr($arrayDATA[$i],$j,1)) { 
               case 1: 
                  $dt[$i] += 29; 
                  break; 
               case 3: 
                  $dt[$i] += 29; 
                  break; 
               case 2: 
                  $dt[$i] += 30; 
                  break; 
               case 4: 
                  $dt[$i] += 30; 
                  break; 
            } 
         } 

         switch (substr($arrayDATA[$i],12,1)) { 
            case 0: 
               break; 
            case 1: 
               $dt[$i] += 29; 
               break; 
            case 3: 
               $dt[$i] += 29; 
               break; 
            case 2: 
               $dt[$i] += 30; 
               break; 
            case 4: 
               $dt[$i] += 30; 
               break; 
         } 
      } 

      $td1 = 1880 * 365 + (int)(1880/4) - (int)(1880/100) + (int)(1880/400) + 30; 
      $k11 = $getYEAR - 1; 

      $td2 = $k11 * 365 + (int)($k11/4) - (int)($k11/100) + (int)($k11/400); 
     
      if ($getYEAR % 400 == 0 || $getYEAR % 100 != 0 && $getYEAR % 4 == 0) { 
         $arrayLDAY[1] = 29; 
      } else { 
         $arrayLDAY[1] = 28; 
      } 

      if ($getMONTH > 13) { 
         $gf_sol2lun = 0; 
      } 

      if ($getDAY > $arrayLDAY[$getMONTH-1]) { 
         $gf_sol2lun = 0; 
      } 
     
      for ($i=0;$i<=$getMONTH-2;$i++) { 
         $td2 += $arrayLDAY[$i]; 
      } 

      $td2 += $getDAY; 
      $td   = $td2 - $td1 + 1; 
      $td0  = $dt[0]; 

      for ($i = 0; $i <= 168; $i++) { 
         if ($td <= $td0) break;

         $td0 += $dt[$i+1]; 
      } 
     
      $ryear = $i + 1881; 
      $td0 -= $dt[$i]; 
      $td -= $td0; 
     
      if (substr($arrayDATA[$i], 12, 1) == 0) { 
         $jcount = 11; 
      } else { 
         $jcount = 12; 
      } 
      $m2 = 0; 
     
      for ($j=0;$j<=$jcount;$j++) { // 달수 check, 윤달 > 2 (by harcoon) 
         if (substr($arrayDATA[$i],$j,1) <= 2) { 
            $m2++; 
            $m1 = substr($arrayDATA[$i],$j,1) + 28; 
            $gf_yun = 0; 
         } else { 
            $m1 = substr($arrayDATA[$i],$j,1) + 26; 
            $gf_yun = 1; 
         } 
         if ($td <= $m1) { 
            break; 
         } 
         $td = $td - $m1; 
      } 

      $k1=($ryear+6) % 10; 
      $syuk = $arrayYUK[$k1]; 
      $k2=($ryear+8) % 12; 
      $sgap = $arrayGAP[$k2]; 
      $sddi = $arrayDDI[$k2]; 
     
      $gf_sol2lun = 1; 

//      return ($ryear."|".$m2."|".$td."|".$syuk.$sgap."년|".$sddi."띠"); 
      return ($m2.".".$td);
   } 

   // -------------------------------------------------------------------- //

   // 해당 년,월 구하기
   if (!$year ) $year  = date("Y");
   if (!$month) $month = date("m");

   $days = Month_Day($month, $year);

   //선택한 월의 1일의 요일을 구함. 일요일은 0.
   $first = @date(w,mktime(0,0,0,$month,1,$year));

   //윤년 확인 --> 윈도 2000에서는 윤년 자동 계산됨..
   /*
   if($month==2){
      if(!($year %   4)) $days++;
      if(!($year % 100)) $days--;
      if(!($year % 400)) $days++;
   }
   */

   // -- 태크 출력 -- 시작 -- //
   echo("<Html>\n");
   echo("   <Head>\n");
   echo("      <Title>달력 - WorkSpace</Title>\n");
   echo("      <Meta HTTP-EQUIV='Content-Type' Content='text/html; charset=ks_c_5601-1987'>\n");
   echo("\n");

   include "define_style.inc";

   echo("\n");
   echo("   </Head>\n");
   echo("\n");
   echo("   <Script Language='javascript'><!--\n");
   echo("      function send_it(v) {\n");
   echo("         if (v == 'yearprev') {\n");
   echo("            if (document.calform.year.value > 1970)\n");
   echo("               document.calform.year.value --;\n");
   echo("            else {\n");
   echo("               alert ('1970년 이전 달력은 보실 수 없습니다.');\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         } else if (v == 'yearnext') {\n");
   echo("            if (document.calform.year.value < 2037)\n");
   echo("               document.calform.year.value ++;\n");
   echo("            else {\n");
   echo("               alert ('2038년 이후 달력은 보실 수 없습니다.');\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         } else if (v == 'monthprev') {\n");
   echo("            if (document.calform.month.value > 1 || document.calform.year.value > 1970) {\n");
   echo("               if (document.calform.month.value > 1) document.calform.month.value --;\n");
   echo("               else { \n");
   echo("                  document.calform.year.value --;\n");
   echo("                  document.calform.month.value = 12;\n");
   echo("               }\n");
   echo("            } else {\n");
   echo("               alert ('1970년 이전 달력은 보실 수 없습니다.');\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         } else if (v == 'monthnext') {\n");
   echo("            if (document.calform.month.value < 12 || document.calform.year.value < 2037) {\n");
   echo("               if (document.calform.month.value < 12) document.calform.month.value ++;\n");
   echo("               else {\n");
   echo("                  document.calform.year.value ++;\n");
   echo("                  document.calform.month.value = 1;\n");
   echo("               }\n");
   echo("            } else {\n");
   echo("               alert ('2038년 이후 달력은 보실 수 없습니다.');\n");
   echo("               return;\n");
   echo("            }\n");
   echo("         } else if (v == 'today') {\n");
   echo("            document.calform.month.value = " . date("m") . ";\n");
   echo("            document.calform.year.value = " . date("Y") . ";\n");
   echo("         }\n");
   echo("\n");
   echo("         document.calform.action = '$PHP_SELF';\n");
   echo("         document.calform.submit ();\n");
   echo("      }\n");
   echo("   //--></Script>\n");
   echo("\n");
   echo("   <Body Bgcolor='#ffffff' Text='$#000000' TopMargin='0' LeftMargin='0' MarginHeight='0' MarginWidth='0'>\n");
   echo("\n");
   echo("   <Table Width='100%' Height='100%' Cellpadding='0' Cellspacing='0' Border='0'>\n");
   echo("      <Tr><Td Width='100%' Height='100%' Align='center' Valign='center'>\n");
   echo("\n");
   // -- 달력 출력 -- //
   echo("   <Table Width='420' Cellpadding='0' Cellspacing='0' Border='0' Bgcolor='#ffffff'>\n");
   echo("         <Form Name=calform Method=POST>\n");
   echo("            <Input Type=hidden Name=year  Value=$year>\n");
   echo("            <Input Type=hidden Name=month Value=$month>\n");
   echo("      <Tr><Td Width='20%' Height='20' Align='left' Valign='center' Bgcolor='#ffffff'>\n");
   echo("            <Input Type=checkbox Name=sun2lun Value='1'");
   if ($sun2lun) echo(" Checked");
   echo(">&nbsp;음력표시\n");
   echo("      </Td><Td Width='60%' Align='center' Valign='center' Bgcolor='#ffffff'>\n");
   echo("         <Span Style='Font Size: 11pt'><Font Color='#111111'>\n");
   echo("         <A Href=\"javascript:send_it('yearprev');\" OnMouseOver=\"window.status='".($year-1)."년 " . $month . "월'; return true;\" OnMouseOut=\"window.status=''; return true;\">◀</A>\n");
   echo("         <A Href=\"javascript:send_it('monthprev')\" OnMouseOver=\"window.status='이전달'; return true;\" OnMouseOut=\"window.status=''; return true;\">◁</A>\n");
   printf("         <B>%04s년 %02s월</B>\n", $year, $month);
   echo("         <A Href=\"javascript:send_it('monthnext')\" OnMouseOver=\"window.status='다음달'; return true;\" OnMouseOut=\"window.status=''; return true;\">▷</A>\n");
   echo("         <A Href=\"javascript:send_it('yearnext');\" OnMOuseOver=\"window.status='".($year+1)."년 " . $month . "월'; return true;\" OnMouseOut=\"window.status=''; return true;\">▶</A>\n");
   echo("         </Font></Span>\n");
   echo("      </Td><Td Widht='20%' Align='right' Valign='center' Bgcolor='#ffffff'>\n");
   echo("         <Span Style='Font-Size: 9pt'>\n");
   echo("         【 <A Href=\"javascript:send_it('today');\" OnMouseOver=\"window.status='오늘로'; return true;\" OnMouseOut=\"window.status=''; return true;\">오늘로</A> 】\n");
   echo("         </Span>\n");
   echo("      </Td></Tr>\n");
   echo("         </Form>\n");
   echo("   </Table>\n");
   echo("   <Table Width='420' Cellpadding='0' Cellspacing='1' Border='0' Bgcolor='#aaaaaa' Style='border: 2px solid #555555'>\n");
   echo("      <Tr><Td Width='60' Height='30' Align='center' Valign='center' Bgcolor='#edeee5'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#ff3333'>일</Font></Span>\n");
   echo("      </Td><Td Width='60' Align='center' Valign='center' Bgcolor='#edeee5'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>월</Font></Span>\n");
   echo("      </Td><Td Width='60' Align='center' Valign='center' Bgcolor='#edeee5'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>화</Font></Span>\n");
   echo("      </Td><Td Width='60' Align='center' Valign='center' Bgcolor='#edeee5'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>수</Font></Span>\n");
   echo("      </Td><Td Width='60' Align='center' Valign='center' Bgcolor='#edeee5'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>목</Font></Span>\n");
   echo("      </Td><Td Width='60' Align='center' Valign='center' Bgcolor='#edeee5'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#111111'>금</Font></Span>\n");
   echo("      </Td><Td Width='60' Align='center' Valign='center' Bgcolor='#edeee5'>\n");
   echo("         <Span Style='Font-Size: 10pt'><Font Color='#3377cc'>토</Font></Span>\n");
   echo("      </Td></Tr>\n");

   for ($i = 0; $i < 6; $i++) {
	  echo("      <Tr>\n");
	  for ($j = 1; $j <= 7; $j++) {
		 $nn = ($i * 7) + $j;

		 echo("      <Td Height='47' Align='left' Valign='top' Bgcolor='");
		 if (($nn - $first) == date("d") && $year == date("Y") && $month == date("m"))
		    echo("#aaff77"); 
		 else 
			echo("#ffffff");
		 echo("' Style='padding-left: 3; padding-top: 3; padding-right: 3'>\n");
		 echo("         <Span Style='Font-Size: 10pt'>\n");
		 if ($nn > $first && ($nn - $first) <= $days) {
            echo("         <Font Color='");
			switch ($j) {
		       case 1 :
				  echo("#ff3333"); break;
			   case 7 :
				  echo("#3377cc"); break;
			   default :
                  echo("#000000");
			}
			echo("'>" . ($nn - $first) . "<BR><BR>");
			if ($sun2lun) // 음력보기 체크가 되어있을때만...
			   echo("         <Div Align=right Valign=bottom><Span Style='Font-Size: 8pt'>(".sol2lun($year,$month,($nn - $first)).")</Span></Div>");
			echo("</Font>\n");
		 } else  {
			echo("         &nbsp;\n");
		 }
		 echo("         </Span>\n");
         echo("      </Td>\n");
	  }
	  echo("      </Tr>\n");
   }

   echo("   </Table>\n");

   @include("madeby.inc");

   echo("\n");
   echo("      </Td></Tr>\n");
   echo("   </Table>\n");
   echo("\n");

   echo("   </Body>\n");
   echo("</Html>\n");
?>