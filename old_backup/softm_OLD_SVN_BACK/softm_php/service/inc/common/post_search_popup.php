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
function 우편번호조회() {
	var search = document.sForm.s_search.value.trim();
	if ( search.length < 2 ) {
		alert("동이름을 입력해주세요.");
		document.sForm.s_search.focus();
	} else 
    callJSONSyncToJson('common.Common','getZipCodeSearch',
    	{
    		s_search:document.sForm.s_search.value
    	},
    	function (json) {
    	    var data = eval("(" + json+ ")");
//    	    console.debug("data ", data);
			var l = data.length;
			var strHtml = "<table>";
			for(var i=0;i<l;i++) {
				var address = data[i].AREA1 + "&nbsp;" + data[i].AREA2 + "&nbsp;" + data[i].AREA3 + "&nbsp;" + data[i].AREA4;
				strHtml += "<tr style='cursor:pointer'><td><a href='#' onclick='우편번호선택(this.parentNode.parentNode);'>" + data[i].ZIPCODE + "</a></td>"
				        + "<td><a href='#' onclick='우편번호선택(this.parentNode.parentNode);'>" + address + "</a></td></tr>"
			}
			strHtml += "</table>";
			document.getElementById("area_post_search").innerHTML = strHtml;
    	}
    );
    return false;	
}

function 우편번호선택(tr) {
	var zipcode = tr.childNodes[0].innerText;
	var address = tr.childNodes[1].innerText;
	//console.debug(zipcode,address);
	if ( opener ) {
		opener.setZipCodeData({zipcode:zipcode,address:address});
		self.close();
	} else {
		//alert("");
		self.close();
	}
	return false;
}

function 우편번호팝업(tr) {
	var win = UI.openWindow('/service/inc/common/post_search_popup.php?callbackfunction=setZipCodeData', 350, 300,'w_zipcode_search',{scrollbars:'no'}).focus();
	return false;
}

function setZipCodeData(data) {
	document.wForm.zipcode.value = data.zipcode;
	document.wForm.address.value = data.address.trim();
	//console.debug(data);
}
//-->
</script>
<?
//require(SERVICE_DIR . "/inc/top.inc"); // footer
?>
<form name="wForm" method="post">
<input type=text name="zipcode"/>
<input type=text name="address"/>
<a href=# onclick="return 우편번호팝업();">우편번호조회</a>
</form>

<form name="sForm" method="post" onsubmit="return 우편번호조회();">
<table border="0" cellpadding="0" cellspacing="0" width="400" align='center'>
  <tr> 
    <td align=center><img src='/images/title_zipcode.jpg'></td>
  </tr>
  <tr>
    <td align="center" valign='top'>
      <table border="0" cellpadding="0" cellspacing="0" width="100%" align='center' height="340">
        <tr>
          <td height='30' align='center' background="/images/realcheck_04.jpg" style="background-repeat:no-repeat">
            
      <table border='0' cellpadding='0' cellspacing='0' width='90%'>
        <tr><td align='left'>&nbsp;&nbsp;검색하실 주소를 동이름으로 검색합니다.</td></tr>
      </table>
             </td>
        </tr>
        <tr>
          <td height='285' align='center' valign='top' background="/images/realcheck_05.jpg" style="background-repeat:repeat-y">
            
            <table border='0' cellpadding='0' cellspacing='0' width='90%'>
              <tr><td align='left' height='30' align='center'>&nbsp;&nbsp;<input type=text name=s_search size=40><input type=hidden name=gubun value=></td></tr>
              <tr><td align='left'>&nbsp;&nbsp;<font color=#666699>예) 군자, 혜화, 신사</font></td></tr>
            </table>
               <br>
<div style="width:332px;height:200px;overflow-x:hidden;overflow-y:scroll;">
<table border=1 style="width:332px;border-collapse:collapse">
<colgroup>
<col width=80/>
<col width=252/>
</colgroup>
<thead>
</thead>
<tbody id="area_post_search" >
</tbody>
</table>
</div>
            <table border='0' cellpadding='0' cellspacing='0' width='90%'>
              <tr><td align='center'><input type=image src='/images/button_search5.jpg' border=0>&nbsp;<a href='javascript:self.close()'><img src='/images/button_close6.jpg' border=0></a></td></tr>
            </table>
             </td>
        </tr>
        <tr><td height="25" background="/images/realcheck_01.jpg" style="background-repeat:no-repeat"></td></tr>
      </table>
    </td>
  </tr>
</table>
</form>
<?
require(SERVICE_DIR . "/inc/footer.inc"); // footer
?>