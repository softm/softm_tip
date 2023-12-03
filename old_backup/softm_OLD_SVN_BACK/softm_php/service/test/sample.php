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
require_once '../lib/common.lib.inc';
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
$(document).ready(function(){
	//getUI("front/member","sample_write",{params:"test[]=1&test[]=2",method:'POST',target:"#index_content",lib_include:true,cb:function() { }});

    $("#list").click( function() {
        getUI("sample","sample_list",{
            params:"test[]=1&test[]=2",
            method:'POST',
            target:"#contents",
            lib_include:true,
            loadjs:true,
            loadcss:true,
            cb:function() {
			}
		});
    });
/*
    $("#write").click( function() {
        getUI("sample","sample_write",
            {
                params:"test[]=1&test[]=2",
                method:'POST',
                target:"#contents",
                lib_include:true,
                cb:function() { 
                    
                }
            }
        );
    });
    
    $("#upload").click( function() {
        getUI("sample","sample_upload",
            {
                params:"test[]=1&test[]=2",
                method:'POST',
                target:"#contents",
                lib_include:true,
                cb:function() { 
                    
                }
            }
        );
    });
    */
    //$('#list').trigger("click");
    $('#list').trigger("click");
});
//-->
</script>
<?
//require(SERVICE_DIR . "/inc/top.inc"); // footer
?>
<!-- CONTENTS-->
<div id="sub_wrapper">
    <div id="submenu_wrapper">
    	<!-- 좌측 서브 메뉴 -->

        <div id="submenu">

            <ul>
                <li id="list">리스트</li>
                <li id="write">입력</li>
                <li id="upload">파일업로드</li>
            </ul>

   </div>
    </div>
            <div id="contents_wrapper">
                <!-- 컨텐츠 타이틀 -->
		<div id='contents_title'>
sample
   		</div>

<!-- 컨텐츠 출력 -->
<div id="contents"><table width="670" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><p>&nbsp;</p>
    <p>&nbsp;</p></td>
  </tr>
 
</table>        </div>
    </div>
</div>

<?
require(SERVICE_DIR . "/inc/footer.inc"); // footer
?>