<?
if( defined("_dboard_poll_js_included") ) return;
	define ("_dboard_poll_js_included", true);
?>

<?if(!$_dboard_poll_included) {?>

<script type="text/javascript">
<!--

function inStrAllBlankCheck (argu) {
	if ( typeof ( argu ) == "object" ) argu = argu.value;
	var ch1="";
	for (var i=0;i<argu.length;i++) ch1 += " ";
	if ( argu == ch1 ) return true;
	else return false;
}

function pollExec ( myForm, displayMode, poll_id, width, height ) {

	var obj = eval ( "myForm.d_poll_item" );

	if ( typeof( obj ) == 'undefined' ) {
		alert ( '��ǥ �ϽǼ� �����ϴ�.' );
		return false;
	}
	var chk = checkedIndex ( obj );

	if ( chk < 0 ) {
		alert ( '�׸��� ������ �ּ���.' );
		return false;
	} else {
		poll_no = parseInt ( chk );
		if ( displayMode == '1' ) { // ����â
			document.PollForm.poll_exec.value           = 'poll_exec';
			document.PollForm.poll_id.value             = poll_id    ;
			document.PollForm.poll_no.value             = poll_no + 1;
			document.PollForm.submit()                               ;
		} else if ( displayMode == '2' ) { // ��â
			var pollWin = window.open('about:blank','pollWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,top=0,left=0,width=' + width + ',height=' + height );
			pollWin.focus();
			document.PollForm.target ='pollWin';
			document.PollForm.poll_exec.value           = 'poll_exec';
			document.PollForm.poll_id.value             = poll_id    ;
			document.PollForm.poll_no.value             = poll_no + 1;
			document.PollForm.submit()                               ;
		}
	}
}

function pollResult ( displayMode, baseDir, poll_id, width, height  ) {
	var pollPop;
	var url  = '';
	if ( displayMode == '1' ) { // ���� â
		url = baseDir + 'dpoll.php';
		document.PollForm.target                 = ''               ;
		document.PollForm.poll_id.value          = poll_id          ;
		document.PollForm.poll_exec.value        = 'poll_result'    ;
		document.PollForm.poll_no.value          = ''               ;
		document.PollForm.action                 = url              ;
		document.PollForm.submit();
	} else { // ��â
		url  = baseDir + 'dpoll.php?poll_id=' + poll_id;
		url += '&poll_id='           + poll_id         ;
		url += '&poll_exec='         + 'poll_result'   ;
		var pollWin = window.open(url,'pollWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,top=0,left=0,width=' + width + ',height=' + height );
		pollWin.focus();
		return false;
	}
}

function pollWriteCommentData(myForm) {
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
	if ( typeof ( myForm.poll_id ) == 'undefined' ) {
		alert ( '�ǰ߱� ��Ų ������ ������ �ֽ��ϴ�.\n�����ڿ��� �����ϼ���.' );
		return;
	}

	var url = '';
		url += getOnlyURL(document.location.href) + '?poll_exec=insert_comment_exec';
		if ( typeof(id) != 'undefined' ) { url += '&id=' + id; } // �Խ��� ���̵�
		url += '&exec_gubun=poll'; // ���� �ǰ߱� �Է�
	myForm.action = url;
}

function checkedIndex ( obj ) {
	var rtn = -1;
	var exist = false;
	var chkCnt = 0;
	if ( typeof( obj.length ) == "undefined" ) {
		var idx = -1;
		if ( obj.checked ) {
			exist = true;
			idx = 0  ;
		}
	} else {
		var idx = new Array();
		for ( var i=0; i<obj.length; i++){
			if ( obj[i].checked ) {
				exist = true;
				rtn = i;
				idx[chkCnt] = rtn;
				chkCnt++;
//                  break;
			}
		}
	}

	if ( exist ) rtn = idx;
	return rtn;
}
<?
if ( $poll_exec == 'poll_result' ) { // ���� ���� ���
	echo ( "    var poll_skin_name   = \"$poll_skin_name\";\n");
	echo ( "    var poll_start_date  = \"$poll_start_date\";\n");
	echo ( "    var poll_end_date    = \"$poll_end_date\";\n");
	echo ( "    var poll_title_limit = \"$poll_title_limit\";\n");
	echo ( "    var poll_opiniony_yn = \"$poll_opiniony_yn\";\n");
	echo ( "    var poll_display_mode= \"$display_mode\";\n");
	echo ( "    var url = '';\n");
}
?>
//-->
</SCRIPT>
<?}?>