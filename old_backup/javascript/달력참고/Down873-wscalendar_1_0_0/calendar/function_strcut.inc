<? // 문자열을 원하는 길이만큼 짜른다.
   // 문자열이 한글이라면 ^^a 잘 짤라야 겠죠?
   function strcut ($str, $num, $strleg) {
      // 문자열 길이가 잘라낼 길이보다 작거나 같다면 그냥 리턴...
      if (strlen($str) <= $num) return $str;

      $strtmp = "";
      $ishan1 = 0;
      $ishan2 = 0;

      for ($i = 0; $i < strlen($str); $i++) {
         if($ishan1 == 1) // 첫루프일때는 관계없겠죠 ^^ 
            $ishan2 = 1;  
         if(ord($str[$i]) > 127 && $ishan1 == 0) {
            $ishan2 = 0; 
            $ishan1 = 1;
         } 

         if($ishan2 == 1) 
            $ishan1 = 0; 

         if ( ($i + 1) == $num ) { 
            if ($ishan2 != 1) break; 

	    $strtmp .= $str[$i];
            break; 
         } 

         $strtmp .= $str[$i]; /// 현제 문자가 한글이나 특수 문자의 시작부분이 아니면 
      }

      return $strtmp . $strleg;
   }
?>