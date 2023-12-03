<SCRIPT LANGUAGE="JavaScript">
<!--
function sendMail(myForm) {
	if ( myForm.from_mail.value != '' && !isEmail(myForm.from_mail) ) {
		alert ( '메일을 올바르게 입력해주세요.' );
		myForm.from_mail.focus();
		return false;
	}

	if ( myForm.from_name.value == '' || inStrAllBlankCheck(myForm.from_name) ) {
		alert ( '이름을 입력해주세요.' );
		myForm.from_name.focus();
		return false;
	}

	if ( myForm.title.value == '' || inStrAllBlankCheck(myForm.title) ) {
		alert ( '제목을 올바르게 입력해주세요.' );
		myForm.title.focus();
		return false;
	}

	if ( myForm.content.value == '' || inStrAllBlankCheck(myForm.content) ) {
		alert ( '내용을 올바르게 입력해주세요.' );
		myForm.content.focus();
		return false;
	}

	document.MailForm.from_mail.value = myForm.from_mail.value;
	document.MailForm.from_name.value = myForm.from_name.value;
	document.MailForm.title.value     = myForm.title.value    ;
	document.MailForm.content.value   = myForm.content.value  ;
<?
	if ( $gubun == 'board' ) {
?>
<?
	} else if ( $gubun == 'poll' ) {
?>
	document.MailForm.action='form_mail.php?send_mail_method=' + document.MailForm.send_mail_method.value;
<?
	}
?>
	document.MailForm.submit();
	return false; // myForm의 서브밋 실행 중지
}

/* 이메일 체크 함수 */
/* 정상적인 이메일인지 체크 후 결과값을 반환한다. */
function isEmail (email){
    if ( typeof ( email ) == "object" ) { email = email.value; }

    myRe=/^[\w-]+@[\w-]+([.][\w-]+){1,3}$/;
    myArray = myRe.exec(email);
    if(myArray){
        return true;
    }else{
        return false;
    }
}

function inStrAllBlankCheck (argu)
{
	if ( typeof ( argu ) == "object" ) { argu = argu.value; }
	var ch1="";
	for (var i=0;i<argu.length;i++) ch1 += " ";
	if ( argu == ch1 ) return true;
	else return false;
}
//-->
</SCRIPT>