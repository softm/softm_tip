
<SCRIPT LANGUAGE="JavaScript">
<!--
function writeCommentData(myForm) {
	if ( typeof ( myForm.name ) == 'object' && ( myForm.name.value == '' || inStrAllBlankCheck ( myForm.name ) ) ) {
		alert ("이름 입력을 확인해 주세요.");
		myForm.name.focus();
		return false;
	}

	if ( typeof ( myForm.password ) == 'object' && myForm.password.value == '' ) {
		alert ("비밀 번호 입력을 확인해 주세요.");
		myForm.password.focus();
		return false;
	}

	if ( typeof ( myForm.memo ) == 'object' && ( myForm.memo.value == '' || inStrAllBlankCheck ( myForm.memo ) ) ) {
		alert ("내용 입력을 확인해 주세요.");
		myForm.memo.focus();
		return false;
	}
	//      alert ( getOnlyURL(document.location.href) + '?id=' + id + '&s=' + s + 'exec=insert_comment_exec&npop=' + npop );
	var url = '';
	url += getOnlyURL(document.location.href) + '?id=' + id + '&s=' + s + '&exec=insert_comment_exec&npop=' + npop;
	url += '&exec_gubun=board'; // 게시판 의견글 입력

	myForm.action = url;
}
//-->
</SCRIPT>
