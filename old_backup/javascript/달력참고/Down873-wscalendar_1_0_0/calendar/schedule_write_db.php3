<?PHP session_start(); #programmed by WindHunter '97 ?> 
<?
   // 에러 처리 펑션 로드
   @include("function_error.inc");
   @include("function_strcut.inc");

   if (!$db) 
      error_message("접근 오류","정상적인 접근이 아닙니다.<BR>정확한 사용법을 숙지하신후에 다시 이용하시기 바랍니다.");

   // HTML 코드를 사용하지 못하게 하고,
   // 문자열 길이를 제한한다.
   $name  = strcut(htmlspecialchars($title), 50, "");

   if (!$taguse) $taguse = '0';
   if (!$hot) $hot = '0';

   // DB 연결
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   $sql  = "INSERT INTO $db VALUES (";
   $sql .= "'',";
   $sql .= "'$title',";
   $sql .= "'$content',";
   $sql .= "'$d',";
   $sql .= "'$t_min:$t_sec',";
   $sql .= "'$hot',";
   $sql .= "'$taguse')";
   $result = mysql_query($sql,$dbconn);

   if (!$result) // 데이터 추가 실패 ?
      error_message("DB 오류","데이터 추가에 실패했습니다.<BR>잠시후에 다시 시도해 주십시오.");

   // 현재 선택된 날짜를 일정이 추가된 날로 셋팅한다.
   $session_calendar_viewday = $d;

   echo("<meta http-equiv='refresh' content='0; url=schedule_write_ok.php3?db=$db'>");

   mysql_close($dbconn);
?>