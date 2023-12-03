<?
if( defined("_dcommon_js_included") ) return;
	define ("_dcommon_js_included", true);
?>
<script type="text/javascript">
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
<script language="Javascript1.2" type="text/javascript" src="<?=$baseDir?>service/js/jquery-1.12.0.min.js"></script>
<script language="Javascript1.2" type="text/javascript" src="<?=$baseDir?>service/js/softm.jquery.js"></script>
<link rel="stylesheet" href="<?=$baseDir?>service/jui-master/jui.min.css" />
<!--link rel="stylesheet" href="<?=$baseDir?>service/jui-master/animate.css" /-->
<script src="<?=$baseDir?>service/jui-master/jui.min.js"></script>
<!--
<link href="<?=$baseDir?>service/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
 -->
