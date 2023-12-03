<?
require_once 'lib/common.lib.inc'; // 공통인클루드.
require_once SERVICE_DIR . '/classes/common/Session.php';
require_once SERVICE_DIR . '/classes/common/Util.php';
//echo 'HOME_DIR : ' . HOME_DIR;
$sub  = !$_GET["sub" ]?"admin/member" :$_GET["sub" ]; // ui_dir
$mode = !$_GET["mode"]?"list"   :$_GET["mode"]; // ui_name

$paramArray = array();
$params = "";
foreach ($_GET as $key => $value) {
    //echo "Key: $key; Value: $value<br>\n";
    if ( $key != "mode" ) {
        $paramArray[] = $key . "=" . $value;
    }
}
$params = implode("&", $paramArray);

$loadjs      = true ;
$loadcss     = true ;
$lib_include = true ;
if ( !ADMIN ) {
    $mode="login";
    $sub="member";
    $ui_dir =   'admin/' .$sub;
    //  die("로그인해야함.");
    Session::setSession("backurl", $_SERVER[PHP_SELF]);
} else {
    $ui_dir = $sub;
}
$ui_name = $mode;

if ( !$sub ) $loadjs      = false;
//  echo '$mode    : ' . $mode    . '<BR>';
//  echo '$ui_dir  : ' . $ui_dir  . '<BR>';
//  echo '$ui_name : ' . $ui_name . '<BR>';
// phpinfo();

require_once SERVICE_DIR . '/inc/admin/header.inc'   ; // header
?>
<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_URL?>/js/session.js"></script>
<script language="JavaScript" type="text/JavaScript">
$(document).ready(function() {
    getUI("<?=$ui_dir?>","<?=$ui_name?>",{
        params:"<?=$params?>",
        method:'POST',
        target:"#contents",
        lib_include:<?=$lib_include?"true":"false"?>,
        loadjs:<?=$loadjs?"true":"false"?>,
        loadcss:<?=$loadcss?"true":"false"?>,
        cb:function() {
        },
        test:true
    });
    document.title = "관리자";
    window.name = "mj_admin";
});
</script>
<style>
#_logger { display:none;position:fixed; _position:absolute; left:1000px; top:200px; width:700px; height:200px; background:#CCC;}
</style>


	<!-- content -->
	<div class="content" id="content">
		<div class="content_inner">
			<div class="notice" id="contents">

			</div>
		</div>
		<p class="bottom_txt">본 프로그램은 국토해양부 재원으로 건설교통기술평가원에서 시행하는 "첨단도시개발사업" (10첨단도시B01)에 의해 수행되었음. </p>
	</div>
<?
require(SERVICE_DIR . "/inc/admin/footer.inc"); // footer
?>