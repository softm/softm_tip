<SCRIPT LANGUAGE="JavaScript">
<!--
function sendMail(myForm) {
	if ( myForm.from_mail.value != '' && !isEmail(myForm.from_mail) ) {
		alert ( '������ �ùٸ��� �Է����ּ���.' );
		myForm.from_mail.focus();
		return false;
	}

	if ( myForm.from_name.value == '' || inStrAllBlankCheck(myForm.from_name) ) {
		alert ( '�̸��� �Է����ּ���.' );
		myForm.from_name.focus();
		return false;
	}

	if ( myForm.title.value == '' || inStrAllBlankCheck(myForm.title) ) {
		alert ( '������ �ùٸ��� �Է����ּ���.' );
		myForm.title.focus();
		return false;
	}

	if ( myForm.content.value == '' || inStrAllBlankCheck(myForm.content) ) {
		alert ( '������ �ùٸ��� �Է����ּ���.' );
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
	return false; // myForm�� ����� ���� ����
}

/* �̸��� üũ �Լ� */
/* �������� �̸������� üũ �� ������� ��ȯ�Ѵ�. */
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