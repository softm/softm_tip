<?
/*
 Filename        : /index.php
 Fuction         : 인덱스
 Comment         :
 시작 일자       : 2009-12-26,
 수정 일자       : 2010-01-26, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
require_once '../service/lib/common.lib.inc';
require_once SERVICE_DIR . '/classes/common/Session.php';
$memInfor = Session::getSession();
$paramArray = array();
$params = "";
foreach ($HTTP_GET_VARS as $key => $value) {
    //echo "Key: $key; Value: $value<br>\n";
    if ( $key != "p_prg" ) {
        $paramArray[] = $key . "=" . $value;
    }
}
$params = implode("&", $paramArray);
//echo 'login_yn : ' . $memInfor['login_yn'];
$backurl = $_GET['backurl'];
if ( $backurl ) Session::setSession('backurl',$backurl);

$backurl = Session::getSession('backurl');
require_once HOME_DIR . '/inc/header.inc'   ; // header
?>
<script language="JavaScript" type="text/JavaScript">
<!--
    var fileUpload = {
        callBack:null,
        url:null,
        readyState:0,
        iframe:null,
        form:null,           
        init:function(){
            var ifr = document.getElementsByName('_up_frame')[0];
            if (ifr) document.body.removeChild(ifr);

            if ( document.all ) {
                //alert('ie');
                ifr = document.createElement('<iframe name=' + '_up_frame>');
                ifr.id = '_up_frame';
            } else {
                //alert('ns');
                ifr = document.createElement('iframe');
                ifr.id = '_up_frame';
                ifr.setAttribute('name', ifr.id);
            }

            document.body.appendChild(ifr);
            fileUpload.iframe = ifr;
            fileUpload.iframe.style.display = 'inline';
            fileUpload.iframe.style.width = '500px';
            fileUpload.iframe.style.height = '500px';
            if ( document.all ) {
                fileUpload.iframe.onreadystatechange = function() {
                    if (fileUpload.iframe.readyState == 'complete') {
                        if (fileUpload.callBack) fileUpload.callBack();
                    }
                }
            } else {
                fileUpload.iframe.onload = function() {
                    if ( fileUpload.readyState == 1 ) {
                        if (fileUpload.callBack) fileUpload.callBack();
                    } else {
                        fileUpload.readyState++;
                    }
                }
            }
        }
        ,setForm:function(f,url,cb){
            fileUpload.callBack = cb;
            fileUpload.url = url;
            f.target = '_up_frame';
            f.enctype="multipart/form-data";
            f.method="POST";
            f.action = url;
            fileUpload.form = f;
        }
        ,submit:function(f){
            fileUpload.form.submit();
        }
    };

    function 파일업로드() {
        loading.show();        
        fileUpload.submit();
    }
    window.onload = function() {
        fileUpload.init();
        fileUpload.setForm($S('wForm'),'fUptest_exec.php', function () {
        	loading.hide();
            //var rtn = fileUpload.iframe.contentWindow.document.body.innerHTML;        	
            alert('등록 되었습니다.');
        });     
    }
//-->
</script>
 </head>

 <body>
<form id=wForm name=wForm enctype="multipart/form-data" method="post" onsubmit="파일업로드();">
	<input name="MAX_FILE_SIZE1" type="hidden" value="3" /> 
    <input type="submit" value='전송'><BR>
    <input name="test1" type="text" value='test1'><BR>
    <input name="test2" type="text" value='test2'><BR>
    <input type="file" name="test_file" id="test_file" style="width:450px"/><BR>
    <!-- <input type="file" name="test_file1" id="test_file1" style="width:450px"/><BR> -->

</form>

<SCRIPT LANGUAGE="JavaScript">
<!--
var loading = new UI.Loading.display('/service/js/ajax-loader.gif','image');
//loading.show(document.body);
loading.setTarget(document.body);
//loading.setSize('80px','10px');
//-->
</SCRIPT>
 </body>
</html>
