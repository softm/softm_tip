
<SCRIPT LANGUAGE="JavaScript">
<!--
function checkedID(obj) {
    // alert ( obj );
	var _rtn ='';
	var addCnt= 0;
	if ( typeof( obj.length ) == "undefined" ) {
		if ( obj.checked ) { _rtn = obj.value.split("_")[1]; }
	} else {
		for ( var i=0;i<obj.length;i++) {
			if ( obj[i].checked ) {
				if ( addCnt > 0 ) _rtn += ",";
				_rtn += obj[i].value.split("_")[1];
				addCnt++;
			}
		}
	}
	return _rtn;
}

function checkedGroupID(obj) {
	var _rtn ='';
	var addCnt= 0;
	if ( typeof( obj.length ) == "undefined" ) {
		if ( obj.checked ) _rtn = obj.value.split("_")[0];
	} else {
		for ( var i=0;i<obj.length;i++) {
			if ( obj[i].checked ) {
				var groupID = obj[i].value.split("_")[0];
				if ( addCnt > 0 && _rtn.indexOf ( groupID ) < 0 ) _rtn += ",";
				if ( _rtn.indexOf ( groupID ) < 0 ) {
					_rtn += groupID;
				}
				addCnt++;
			}
		}
	}
	return _rtn;
}

function adminDataDelete () {
	var chk   = document.getElementsByName("chk");
	var noStr = '';
	if ( typeof (chk) == 'undefined' ) {
		alert ('���õ� �ڷᰡ �����ϴ�.');
		return;
	}
	noStr = checkedID(chk);
	if ( noStr == '' ) {
		alert ('���õ� �ڷᰡ �����ϴ�.');
		return;
	}
	if ( confirm ( '���õ� �ڷḦ �����Ͻðڽ��ϱ�?' ) ) {
		document.adminForm.a_no.value = noStr;
		document.adminForm.exec.value = 'admin_data_delete';
		document.adminForm.submit();
	}
}

function adminDataCopy () {
	var chk   = document.getElementsByName("chk");
//	var s_id  = document.getElementsByName("_dboard_s_id");
	var s_id  = getObject("_dboard_s_id");
	var noStr = '';
	if ( s_id.selectedIndex == 0 ) {
		alert ('�Խ����� ������ �ּ���.');
		s_id.focus();
		return;
	}
	noStr = checkedID(chk);
	if ( noStr == '' ) {
		alert ('���õ� �ڷᰡ �����ϴ�.');
		return;
	}
	if ( confirm ( '���õ� �ڷḦ �����Ͻðڽ��ϱ�?' ) ) {
		document.adminForm.a_no.value = noStr;
		document.adminForm.a_id.value = s_id.value;
		document.adminForm.exec.value = 'admin_data_copy';
		document.adminForm.submit();
	}
}

function adminDataMove () {
	var chk   = getObject("chk"		 );
	var s_id  = getObject("_dboard_s_id");
	var noStr = '';

	if ( s_id.selectedIndex == 0 ) {
		alert ('�Խ����� ������ �ּ���.');
		s_id.focus();
		return;
	}
	noStr = checkedGroupID(chk);
	if ( noStr == '' ) {
		alert ('���õ� �ڷᰡ �����ϴ�.');
		return;
	}
	if ( confirm ( '���õ� �ڷḦ �����Ͻðڽ��ϱ�?' ) ) {
		document.adminForm.a_no.value = noStr;
		document.adminForm.a_id.value = s_id.value;
		document.adminForm.exec.value = 'admin_data_move';
		document.adminForm.submit();
	}
}
//-->
</SCRIPT>
