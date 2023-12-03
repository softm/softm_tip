<?
/*
 Filename        : /service/inc/common/company_infor_popup.php
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
require_once '../../lib/common.lib.inc';
require_once SERVICE_DIR . '/classes/common/Session.php';
$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$mode = !$_GET["mode"]?"login":$_GET["mode"];
// echo "mode : " .$mode;
require_once SERVICE_DIR . '/inc/header.inc'   ; // header
?>
<script language="Javascript1.2" type="text/javascript" src="<?=HTTP_URL?>/service/js/session.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function fileDownloadCompany(fNo,fNm) {
//    alert(fNo + " / " + fNm);
    call('FORM','common.Common','fileDownload',
        {
    		p_file_no:fNo,
    		p_file_nm:fNm,
    		p_sub_dir:"company"
    	}
    );
}
//-->
</script>
<body>
    <a href=# onclick="UI.openWindow('/service/inc/common/company_infor_popup.php', 750, '768','w_company_infor',{scrollbars:'yes'}).focus();">팝업</a>
<?
require(SERVICE_DIR . "/inc/common/company_infor.inc"); // 기업정보조회폼.
?>

<?
require(SERVICE_DIR . "/inc/footer.inc"); // footer
?>