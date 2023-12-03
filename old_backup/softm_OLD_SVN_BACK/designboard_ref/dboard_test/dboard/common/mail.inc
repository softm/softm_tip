<?
function mail_sender( $from_mail, $to_mail, $subject, $message ) {
	$headers  = "From: $from_mail \r\n";
	$headers .= "Content-type: text/html; charset=euc-kr\r\n";

//  $headers .= "X-Mailer: PHP WebMail\r\n";		

	/* additional headers */
//  echo $headers;
//  $headers .= "Cc: birthdayarchive@example.com\r\n"; // 참조
//  $headers .= "Bcc: birthdaycheck@example.com\r\n" ; // 

	/* and now mail it */
	return mail($to_mail, $subject, $message, $headers);
}

function check_email($email) {
	//메일 주소가 형식에 맞는지 체크..
	if (!preg_match("/^[^@ ]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]+/i", $email)) {
		return false;
	}
	
	// 한글이 포함되었는지 체크 
	for($i = 1; $i <= strlen($email); $i++) {
		if ((Ord(substr("$email", $i - 1, $i)) & 0x80)) {
			return;
		}
	}
	return true;
}
?>