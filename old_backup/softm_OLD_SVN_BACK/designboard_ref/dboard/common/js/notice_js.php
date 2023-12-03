<?
if( defined("_dboard_notice_js_included") ) return;
	define ("_dboard_notice_js_included", true);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function viewNoticePage(gubun, no,id) {
    var url = '';
	if ( gubun == '1' ) url = baseDir + 'dboard.php';
	else url = baseDir + 'files/' + id + '.php';

    document.boardPageForm.id.value   = id    ;
    document.boardPageForm.exec.value = 'view';
    document.boardPageForm.no.value   = no    ;
    document.boardPageForm.action     = url   ;
    document.boardPageForm.tot.value  = ''    ; // 총 조회수 클리어
    document.boardPageForm.submit();
}

function viewNoticeOpen(gubun, baseDir, id, width, height, no ) {
    var url = '';
	if ( gubun == '1' ) url = baseDir + 'dboard.php?id=' + id + '&npop=Y&exec=view&no=' + no;
	else url = baseDir + 'files/' + id + '.php?id=' + id + '&npop=Y&exec=view&no=' + no;

//      alert (url);
    var npop = window.open(url,'notice_pop','toolbar=no,menubar=no,resizable=no,scrollbars=yes,top=0,left=0,width=' + width + ',height=' + height );
    npop.focus();
}
//-->
</SCRIPT>
