
<SCRIPT LANGUAGE="JavaScript">
<!--
var doubleTrans = false; // 두번 폼이 전송되지 않도록 처리.
function askPassword (myForm) {
	if ( doubleTrans ) { return false; }
	if ( typeof ( myForm.password ) == 'object' && myForm.password.value == '' ) {
		alert ("비밀 번호 입력을 확인해 주세요.");
		myForm.password.focus();
		return false;
	}
	if ( exec == 'view' ) exec += '_check';
	var url = getOnlyURL(document.location.href) + '?id=' + id + '&no=' + no + "&exec=" + exec + '_exec&npop=' + npop;
	myForm.action = url;
	return true;
}
//-->
</SCRIPT>
