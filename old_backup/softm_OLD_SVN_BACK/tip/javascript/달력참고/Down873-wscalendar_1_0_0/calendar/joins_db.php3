<?PHP #programmed by WindHunter '97 ?> 
<?
   @include("function_error.inc");
   @include("function_strcut.inc");
      
   // DB 연결
   @include("dbconn_information.php3");
   $dbconn = @mysql_connect($sql_hostname,$sql_userid,$sql_userpwd);
   @mysql_select_db($sql_database,$dbconn);

   // 기존 사용자 조회
   $sql = "SELECT admin_id FROM wscalendar_info WHERE admin_id = '$id'";
   $result = mysql_query($sql,$dbconn);
   if (@mysql_fetch_array($result))
      error_message("가입 오류","신청하신 ID는 이미 다른 사용자가 사용중입니다.<BR>다른 ID로 다시 신청하시기 바랍니다.");

   $sql = "SELECT id FROM wscalendar_info WHERE ssn1 = '$ssn1' AND ssn2 = '$ssn2'";
   $result = mysql_query($sql,$dbconn);
   if (@mysql_fetch_array($result))
      error_message("가입 오류","신청하신 주민등록번호는 이미 등록된 번호입니다.<BR>관리자에게 문의하시기 바랍니다.");

   // 사용자 ID 가 영문과 숫자로만 구성되었는지 검사..
   if (!eregi("^[a-z0-9]+$", $id))
      error_message("입력 오류","입력하신 ID : <B>'$id'</B> 는 형식에 맞지 않습니다.<BR>ID는 영문 & 숫자로만 신청이 가능합니다.");

   // email 주소가 올바르게 입력되었는지 검사한다. 조건 $email 입력 값이 있을때만...
   if ((!eregi("^[_0-9a-z]+(\.[_0-9a-z]+)*@[0-9a-z]+(\.[0-9a-z]+)+$",$email)) && $email) 
      error_message("입력 오류","입력하신 <B>'$email'</B> 이메일 주소가 형식에 맞지 않습니다.<BR>확인하신 후에 정확하게 입력해 주십시오.");

   //
   $name    = strcut(htmlspecialchars($name), 20, "");
   $address = strcut(htmlspecialchars($address), 100, "");

   $sql  = "INSERT INTO wscalendar_info VALUES (";
   $sql .= "'',";
   $sql .= "'".time()."',";
   $sql .= "'$id',";
   $sql .= "'$pwd',";
   $sql .= "'$name',";
   $sql .= "'$email',";
   $sql .= "'$ssn1',";
   $sql .= "'$ssn2',";
   $sql .= "'$phone',";
   $sql .= "'$zip1$zip2',";
   $sql .= "'$address',";
   $sql .= "'".time()."',";
   $sql .= "'".time()."')";
   $result = mysql_query($sql,$dbconn);
   if (!$result)
      error_message("DB 오류","Calendar 사용자 정보를 추가하지 못했습니다.");

   // 개인 일정 저장용 Table 생성
   $sql  = "CREATE TABLE wscalendar_$id (";
   $sql .= "id int(6) NOT NULL auto_increment,";
   $sql .= "title varchar(50) NOT NULL,";
   $sql .= "memo text NOT NULL,";
   $sql .= "wdate varchar(11) NOT NULL,";
   $sql .= "stime char(5) NOT NULL,";
   $sql .= "hot enum('0','1') DEFAULT 0 NOT NULL,";
   $sql .= "taguse enum('0','1') DEFAULT 0 NOT NULL,";
   $sql .= "UNIQUE id (id))";

   $result = mysql_db_query($sql_database,$sql);
   if (!$result)
      error_message("DB 오류","Calendar 일정 Data Table 을 생성하지 못했습니다.");


   echo("<meta http-equiv='refresh' content='0; url=joins_ok.php3'>");

   mysql_close($dbconn);
?>