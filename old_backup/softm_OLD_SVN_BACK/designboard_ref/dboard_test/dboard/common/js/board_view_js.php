
<script type="text/javascript">
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
	
    var c = myForm.memo.value;
    var reg = new RegExp( '<(/?)(script)\\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>',"gim");
//    console.info(reg);
//    if(reg.test(input)){
//       alert ( 'ok' );
//    }
//    c = c.replace(reg,"<$1script$3>")
    c = c.replace(reg,"��$1$2$3>")
    c = c.replace(/ /gi, '&nbsp;');
	IframeSubmit.init();
	var ifrm = IframeSubmit.iframe;
	ifrm = (ifrm.contentWindow) ? ifrm.contentWindow : (ifrm.contentDocument.document) ? ifrm.contentDocument.document : ifrm.contentDocument;
	ifrm.document.open();
	ifrm.document.write("<pre>"+c+"</pre>"); // swing
	ifrm.document.close();
    var v = ifrm.document.body.innerHTML;
        v = v.substr(5,v.length-11);
	myForm.memo.value = v;
	
	//      alert ( getOnlyURL(document.location.href) + '?id=' + id + '&s=' + s + 'exec=insert_comment_exec&npop=' + npop );
	var url = '';
	url += getOnlyURL(document.location.href) + '?id=' + id + '&s=' + s + '&exec=insert_comment_exec&npop=' + npop;
	url += '&exec_gubun=board'; // �Խ��� �ǰ߱� �Է�

	myForm.action = url;
}
//-->
</SCRIPT>
