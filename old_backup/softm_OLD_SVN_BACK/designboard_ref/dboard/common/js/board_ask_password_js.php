
<SCRIPT LANGUAGE="JavaScript">
<!--
var doubleTrans = false; // �ι� ���� ���۵��� �ʵ��� ó��.
function askPassword (myForm) {
	if ( doubleTrans ) { return false; }
	if ( typeof ( myForm.password ) == 'object' && myForm.password.value == '' ) {
		alert ("��� ��ȣ �Է��� Ȯ���� �ּ���.");
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
