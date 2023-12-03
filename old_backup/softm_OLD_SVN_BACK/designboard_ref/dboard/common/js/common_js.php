<?
if( defined("_dcommon_js_included") ) return;
	define ("_dcommon_js_included", true);
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
var driver  = '<?=$sysInfor['driver']?>';
var baseDir = '<?=$baseDir?>';
var fpWin   = null;

// browser Check
var is = null;
function BrowserCheck() {
	this.ie  = ( document.all ) ? 1 : 0;
	this.ns  = document.getElementById && !document.all ? 1 : 0;
}
is = new BrowserCheck();

function getObject( objStr, tier ) {
	var docStr = "";
	var obj	= null;
	if ( typeof(tier) == "string" ) docStr = tier + "." + "document";
	else docStr = "document";
	if (is.ie) obj = eval( docStr + ".all['" + objStr + "']"); // IE
	else if ( is.ns ) obj = eval( docStr + ".getElementById('" + objStr + "');"); // NS
	return obj;
}

function getOnlyURL(_url) {
	var url = _url;
	var e = url.indexOf ( '?' );
	if ( e > 0 ) url = url.substring(0,e);
	return url;
}
//-->
</SCRIPT>
