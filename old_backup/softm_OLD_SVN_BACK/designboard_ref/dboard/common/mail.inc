<?
function mail_sender( $from_mail, $to_mail, $subject, $message ) {
	$headers  = "From: $from_mail \r\n";
	$headers .= "Content-type: text/html; charset=euc-kr\r\n";

//  $headers .= "X-Mailer: PHP WebMail\r\n";		

	/* additional headers */
//  echo $headers;
//  $headers .= "Cc: birthdayarchive@example.com\r\n"; // ����
//  $headers .= "Bcc: birthdaycheck@example.com\r\n" ; // 

	/* and now mail it */
	mail($to_mail, $subject, $message, $headers);
}

function check_email($email) {
	//���� �ּҰ� ���Ŀ� �´��� üũ..
	if (!eregi("^[^@ ]+@[a-zA-Z0-9\.\-]+\.[a-zA-Z]+", $email)) {
		return false;
	}
	
	// �ѱ��� ���ԵǾ����� üũ 
	for($i = 1; $i <= strlen($email); $i++) {
		if ((Ord(substr("$email", $i - 1, $i)) & 0x80)) {
			return;
		}
	}
	return true;
}
?>