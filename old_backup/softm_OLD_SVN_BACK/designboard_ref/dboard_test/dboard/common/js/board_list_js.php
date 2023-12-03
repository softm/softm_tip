<?if(!$_dboard_board_included ) {?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function objectSelected( obj, selectedVal ) {
	if ( typeof ( obj ) == "object" ) {
		for (i=0; i<obj.length; i++) {
			if ( obj[i].value == selectedVal ) { obj.selectedIndex = i; break;}
			else { obj.selectedIndex = 0; }
		}
	}
}

function searchFormSubmit(myForm) {
	myForm.action = getActionUrl(myForm);
	return true;
}

function boardPageTab ( start, totcount, action ) {
	document.boardPageForm.exec.value = '';
	document.boardPageForm.s.value = start;
	document.boardPageForm.tot.value = totcount;
	document.boardPageForm.submit();
}

function getActionUrl(myForm) {
	var url = getOnlyURL(document.location.href) + '?id=' + id;
	if (npop != '') url += '&npop=' + npop;
	if (no   != '') url += '&no='   + no  ;
	if ( typeof(myForm.search_cat_no) == 'undefined' ) {
		if (search_cat_no != '') url += '&search_cat_no=' + search_cat_no;
	}
	return url;
}

function sortPage(sort,order) {
	document.boardPageForm.sort.value = sort;
	document.boardPageForm.desc.value = order;
	document.boardPageForm.method = 'get';
	document.boardPageForm.target = '';
	document.boardPageForm.action = '';
	document.boardPageForm.submit();
}
function viewPage(no, print_no) {
	document.boardPageForm.exec.value = 'view';
	document.boardPageForm.no.value = no;
	document.boardPageForm.print_no.value = print_no;
	document.boardPageForm.method = 'get';
	document.boardPageForm.target = '';
	document.boardPageForm.action = '';
	document.boardPageForm.submit();
}

function insertPage() {
	document.boardPageForm.exec.value = 'insert';
	document.boardPageForm.target = '';
	document.boardPageForm.action = '';
	document.boardPageForm.submit();
}

function checkedAll () {
	if ( exec != 'list' ) return false;
	var chk   = document.getElementsByName("chk");
	if ( typeof( chk.length ) == "undefined" ) {
		if ( chk.checked ) chk.checked = false;
		else chk.checked = true;
	} else {
		for ( var i=0;i<chk.length; i++ ) chk[i].checked = !chk[i].checked;
	}
}
//-->
</SCRIPT>
<?}?>