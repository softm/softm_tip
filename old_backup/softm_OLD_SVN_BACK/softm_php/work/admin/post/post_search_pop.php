<?
/*
 Filename        : /common/post_search_pop.php
 Fuction         : 우편번호
 Comment         :
 시작 일자       : 2009-03-30,
 수정 일자       : 2009-04-03, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
define ("HOME_DIR" , realpath(dirname(dirname(__FILE__))) );
define ('SERVICE'  , 'COMMON' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', '../service');

require_once HOME_DIR . '/inc/var.inc'      ; // 변수
require_once HOME_DIR . '/inc/session.inc'  ; // 세션

require_once HOME_DIR . '/inc/lib.inc';
require_once HOME_DIR . '/inc/service_common.inc';
require_once "../service/common/Util.php";

//$memInfor = getMemInfor();
//if ( $memInfor['admin_yn'] == "Y" ) {
html_head('홈다이렉트 :: 중개수수료 없는 부동산 직거래','loose');
?>
<link href="<?=BASE_DIR?>/css/hd01.css" rel="stylesheet" type="text/css"/>
<link href="<?=BASE_DIR?>/css/softm.css" rel="stylesheet" type="text/css"/>

<SCRIPT LANGUAGE="JavaScript" src='<?=BASE_DIR?>/inc/js/common_js.php'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="<?=BASE_DIR?>/inc/js/util_js.php"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=BASE_DIR?>/inc/js/asyncConnector.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=BASE_DIR?>/inc/js/loadJsCss.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=BASE_DIR?>/inc/js/loadingSwf.js'></SCRIPT>

<script src="<?=BASE_DIR?>/inc/js/json2.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
var lds = new loadJsCss('head');

function 조회() {
    if ( $('s_search').value.trim() ) {
        //lds.addJs ('mod2','<?=BASE_DIR?>/inc/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118' );
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = '<?=SERVICE_DIR?>/gateway.php';
            url += '?p_hash=' + p_hash;

        ajaxR.openCallBack= function (str) {
            var xmlDoc=ajaxR.responseXml();
            var pL =xmlDoc.getElementsByTagName("item");
            var str= "<ul>";
            var l = pL.length;

            if (l == 0 ) {
                str += "<li><span class='add' style='overflow:hidden'>조회된 내용이 없습니다.</span></li>";
            } else {
                for (var i=0;i<l;i++ ){
                    var pItem =pL.item(i);
                    var a = pItem.getElementsByTagName("address").item(0).firstChild.nodeValue;
                    var p =pItem.getElementsByTagName("postcd").item(0).firstChild.nodeValue;
                    str += "<li><a href='#' onclick='설정(this);return false;'><span class='add' style='border:0 solid red;height:18;overflow:hidden;cursor:hand' title='" + a + "'>" + a + "</span><span class='num' style='border:0 solid red;width:45;cursor:hand'>" + p + "</span> </a></li>";
                }
            }
            str+= " </ul>";
            loadSwf.hideSwf();
            ajaxR.dataArea.innerHTML = str;
        }

        var bData = {service    : '<?=SERVICE?>',
                     className  : 'common.Util' ,
                     method     : 'getPost'     ,
                   //method     : 'getPostOpenAPI',
                     argus      : {s_search:$('s_search').value}
                                    };
        loadSwf.showSwf();
        ajaxR.httpOpen('POST', url, true,encodeURIComponent(JSON.stringify(bData)), $("area01"));
    } else {
        alert('동을 입력해 주세요.');
        $('s_search').focus();
    }
    return false;
}
function 설정(o) {
    var argus = {post_no:o.childNodes[1].innerText,address:o.childNodes[0].innerText}
    //alert ( o.childNodes[0].innerText );
    //alert ( o.childNodes[1].innerText );
    //alert( typeof(opener.setPost) );
    if (typeof(opener.setPost) == 'object' ) opener.setPost(argus);
    self.close();
}

function 시작() {
    $('s_search').value = '공덕3';
    self.focus();
    $('s_search').focus();
    조회();
}
//-->
</SCRIPT>
<style>
</style>
<body onload='시작();' scroll=yes>
<div id="pop">
 <p><img src="../member/img/post_01.gif" width="300" height="50"></p>
 <p><form id='sForm' name='sForm' style='position:absolute;top:12;left:10px' onsubmit='return 조회();'>
    <input type='text' id='s_search' style='width:70;margin-right:3;vertical-align:top' class='korean'>&nbsp;<button class='btn-g' onclick='조회();'>조회</button>
    </form>
 </p>
    <span id='area01' class='main_area' style='border:0 solid blue;width:182;height:200;overflow-y:hidden;'>
<ul><li><span class="add" style='overflow:hidden'>동입력후 조회해주세요.</span></li></ul>
    </span>
<p><img src="../member/img/post_03.gif" width="300" height="20"></p>
</div>
<SCRIPT LANGUAGE="JavaScript">
<!--
var loadSwf = new loadingSwf('100','100',false);
//loadSwf.setSwfSize (355,355);
loadSwf.setSwfPos  (100,50);
loadSwf.setSwfType ('C'); // 'b','B': bar, 'c','C' : circle(default)
loadSwf.print();
//-->
</SCRIPT>
<?
html_foot();
//} else {
//    redirectPage("../login.html");
//}
?>