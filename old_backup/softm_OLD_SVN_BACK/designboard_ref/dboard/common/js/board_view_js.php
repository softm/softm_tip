
<SCRIPT LANGUAGE="JavaScript">
<!--
function writeCommentData(myForm) {
	if ( typeof ( myForm.name ) == 'object' && ( myForm.name.value == '' || inStrAllBlankCheck ( myForm.name ) ) ) {
		alert ("�̸� �Է��� Ȯ���� �ּ���.");
		myForm.name.focus();
		return false;
	}

	if ( typeof ( myForm.password ) == 'object' && myForm.password.value == '' ) {
		alert ("��� ��ȣ �Է��� Ȯ���� �ּ���.");
		myForm.password.focus();
		return false;
	}

	if ( typeof ( myForm.memo ) == 'object' && ( myForm.memo.value == '' || inStrAllBlankCheck ( myForm.memo ) ) ) {
		alert ("���� �Է��� Ȯ���� �ּ���.");
		myForm.memo.focus();
		return false;
	}
	//      alert ( getOnlyURL(document.location.href) + '?id=' + id + '&s=' + s + 'exec=insert_comment_exec&npop=' + npop );
	var url = '';
	url += getOnlyURL(document.location.href) + '?id=' + id + '&s=' + s + '&exec=insert_comment_exec&npop=' + npop;
	url += '&exec_gubun=board'; // �Խ��� �ǰ߱� �Է�

	myForm.action = url;
}
//-->
</SCRIPT>
