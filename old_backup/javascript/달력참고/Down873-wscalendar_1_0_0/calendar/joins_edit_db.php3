<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   
   if (!$session_calendar_id)
      error_message("접근 오류","정상적인 접근이 아닙니다.");
      
   // DB 연결
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // 기존 사용자 조회
   $sql = "SELECT bcheck, admin_id, admin_pwd FROM wscalendar_info WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);
   if (!$data = @mysql_fetch_array($result))
      error_message("수정 오류","신청하신 ID는 존재하지 않습니다.<BR>관리자에게 문의하십시오.");

   // 사용자 로그인 상태인가?
   if (strcmp($session_calendar_login, $data[bcheck]))
      error_message("접근 오류","정상적인 접근이 아닙니다.");

   if (strcmp($pwd, $data[admin_pwd]))
      error_message("접근 오류","비밀번호가 틀립니다.<BR>확인하신 후에 다시 시도해 주십시오.");

   // 변경될 비밀번호가 있고, 비밀번호 확인값과 일치한다면..
   if ($cpwd1 && !strcmp($cpwd1, $cpwd2))
      $pwd = $cpwd1;

   // email 주소가 올바르게 입력되었는지 검사한다. 조건 $email 입력 값이 있을때만...
   if ((!eregi("^[_0-9a-z]+(\.[_0-9a-z]+)*@[0-9a-z]+(\.[0-9a-z]+)+$",$email)) && $email)
      error_message("입력오류","입력하신 <B>'$email'</B> 이메일 주소가 형식에 맞지 않습니다.<BR>확인하신 후에 정확하게 입력해 주십시오.");

   // 사용자 정보 수정
   $sql  = "UPDATE wscalendar_info SET ";
   $sql .= "admin_pwd = '$pwd',";
   $sql .= "email = '$email',";
   $sql .= "phone = '$phone',";
   $sql .= "zip = '$zip1$zip2',";
   $sql .= "address = '$address' ";
   $sql .= "WHERE admin_id = '$session_calendar_id'";
   $result = mysql_query($sql,$dbconn);
   if (!$result)
      error_message("DB 오류","Calendar 사용자 정보를 수정하지 못했습니다.<BR>관리자에게 문의하십시오.");

   echo("<meta http-equiv='refresh' content='0; url=joins_edit_ok.php3'>");

   mysql_close($dbconn);
?>