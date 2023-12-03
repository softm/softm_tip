<?
require_once 'lib/common.lib.inc'; // 공통인클루드.
require_once SERVICE_DIR . '/classes/common/Session.php';
require_once SERVICE_DIR . '/classes/common/Util.php';
//echo 'HOME_DIR : ' . HOME_DIR;
$sub  = !$_GET["sub" ]?""       :$_GET["sub" ]; // ui_dir
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
if ( !LOGIN ) {
    $mode="login";
    $sub="member";
    $ui_dir =   'front/' .$sub;
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

require_once SERVICE_DIR . '/inc/header.inc'   ; // header
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
    document.title = "test-program";
    window.name = "test-program";
});
// 스킨변경
function fChgSkin(v) {
    Util.Load.script({src:"<?=SERVICE_BASE?>/ui/sample/css/test"+v.padLeft(0,2)+".css",type:'css'});
}
</script>
<style>
#_logger { position:fixed; _position:absolute; left:1000px; top:200px; width:700px; height:200px; background:#CCC;}
</style>

	<!-- content -->
	<div class="content" id="content">
		<div class="content_inner">
<form method=get target="test-program" action="">

<?php
$uiPath = SERVICE_DIR.DIR_SEP."ui".DIR_SEP."test";
echo 'test ui path : ' . $uiPath . '<BR/>';
$d = dir(SERVICE_DIR.DIR_SEP."ui".DIR_SEP."test") or die("getFileList: Failed opening directory $dir for reading");
?>
<?php
print Util::listBoxElement ("SELECT","skin_id", 0, 15, 'onchange="fChgSkin(this.value)"',1,'','-스킨-');
?>
<select name="sub" onchange='this.form.submit();'>
    <option value=''>-프로그램선택-</option>
<?php
$i=0;
while(false !== ($entry = $d->read())) { //
    if($entry[0] == ".") continue;
    if(is_dir($uiPath.DIR_SEP.$entry)) {
        echo "<option value='test/" . $entry . "'" . ("test/".$entry==$sub?"selected":"") . ">" .$entry. "</option>" . PHP_EOL;
    }
    $i++;
}
?>
</select>
<select name="mode" onchange='this.form.submit();'>
    <option value='list'  <?=$_GET['mode']=='list'?'selected':''?>>list-조회</option>
    <option value='write' <?=$_GET['mode']=='write'?'selected':''?>>write-작성</option>
</select>
<?php
echo "<a href='".LOGOUT_URL."'>" . (LOGIN?" / 로그아웃":" / 로그인해야 테스트가능하다.") . "</a>";
?>
</form>
			<div class="notice" id="contents">

			</div>
		</div>
		<p class="bottom_txt">본 프로그램은 국토해양부 재원으로 건설교통기술평가원에서 시행하는 "첨단도시개발사업" (10첨단도시B01)에 의해 수행되었음. </p>
	</div>
<!--  <DIV id="_info" style="position:absolute;bottom:-1px;right:0px"></DIV> -->
<div id="_logger">
	<button style="position:relative;bottom:10px;left:0px;" onclick="deleteLog();">로그지우기</button>
    <DIV id="_info"></DIV>
</div>
	<!-- footer -->
	<div id="footer">
		<div class="footer_inner">
			<p>copyright</p>
		</div>
	</div>
	<!-- //footer -->
////////////////////////////////
<?
require(SERVICE_DIR . "/inc/footer.inc"); // footer
?>
</body>
</html>