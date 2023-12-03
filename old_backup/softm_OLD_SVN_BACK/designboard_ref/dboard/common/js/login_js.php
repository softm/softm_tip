<?
if( defined("_dboard_login_js_included") ) return;
	define ("_dboard_login_js_included", true);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
<?
// 팝업 폴 결과 화면 일경우에만 이용
echo ( "var poll_id = '".$poll_id ."';\n" );
echo ( "var poll_exec = '".$poll_exec   ."';\n" );
?>

// sucMode : '1' : 로그인 성공 메시지 출력
//			 '2' : 로그인후 윈도우 닫기
//			 '3' : 로그 아웃 스킨 표시 ( 기본 값 )
function loginPopup ( skinName, width, height, left, top, scroll_yn, sucMode, successURL, message ) {
	var url = '';
	var bDir = '';
	if ( typeof(baseDir   ) != 'undefined' ) bDir = baseDir;
	if ( typeof(skinName  ) == 'undefined' ) skinName = '';
	if ( typeof(sucMode   ) == 'undefined' ) sucMode = '1';
	if ( typeof(successURL) == 'undefined' ) successURL = '';
	if ( typeof(message   ) == 'undefined' ) message = '';

	url = bDir + 'dlogin.php?login_skin_name=' + skinName + '&suc_mode=' + sucMode;
	if ( typeof(id      ) != 'undefined' ) url += '&id=' + id;
	if ( typeof(poll_id ) != 'undefined' ) url += '&poll_id=' + poll_id;

	if ( successURL != '') url += '&succ_url='+ encodeURI (successURL);
	if ( message	!= '') url += '&message=' + encodeURI (message   );
	url += '&lg=Y';
	var loginWin = window.open(url,'loginWin','toolbar=no,menubar=no,resizable=no,scrollbars=' + scroll_yn + ',left=' + left + ',top=' + top + ',width=' + width + ',height=' + height );
	loginWin.focus();
}
// skinName : 스킨명
// successURL : 성공시 이동할 경로명
function loginPage ( skinName, successURL ) {
	var url = '';
	var bDir = '';
	if ( typeof(baseDir   ) != 'undefined' ) bDir = baseDir;
	if ( typeof(skinName  ) == 'undefined' ) skinName = '';
	if ( typeof(successURL) == 'undefined' ) successURL= '';
	url = bDir + 'dlogin.php?login_skin_name=' + skinName +  '&suc_mode=4'  + '&succ_url='  + escape (successURL);
	var loginWin = document.location.href = url;
	loginWin.focus();
}

function loginFormSubmit(myForm) {
	var url ='';
	if ( typeof(baseDir) != 'undefined' ) url = baseDir + 'login_ok.php';
	else url = 'login_ok.php';

	var first = true;
	var suc_mode = '';
	if ( typeof ( myForm.suc_mode ) != 'undefined' ) {
		suc_mode = myForm.suc_mode.value;
		if ( suc_mode != '' ) { url += '?suc_mode=' + suc_mode; first = false; }
	}

	url += getLoginUrl (first);
	if ( typeof ( myForm.message  ) != 'undefined' ) myForm.message.value  = decodeURI ( myForm.message.value );
	if ( typeof ( myForm.succ_url ) != 'undefined' ) myForm.succ_url.value = decodeURI ( myForm.succ_url.value);

	myForm.action = url;

	if ( myForm.user_id.value  == '' ) { alert ("ID를 입력해주세요."); myForm.user_id.focus(); return false; }
	if ( myForm.password.value == '' ) { alert ("Password를 입력해주세요."); myForm.password.focus(); return false; }
	return true;
}

function logout(myForm) {
	var formMode = 1;
	if ( typeof(myForm) == 'undefined' ) {
		myForm = document.logoutForm;
		formMode = 2;
	}
	var url ='';
	if ( typeof(baseDir) != 'undefined' ) url = baseDir + 'logout_ok.php';
	else url = 'logout_ok.php';
	url += getLoginUrl (true);
	if ( typeof ( myForm.message  ) != 'undefined' ) myForm.message.value  = encodeURI ( myForm.message.value  );
	if ( typeof ( myForm.succ_url ) != 'undefined' ) myForm.succ_url.value = encodeURI ( myForm.succ_url.value );

	myForm.action = url;

	if ( formMode == 1 ) return true;
	else myForm.submit();
}

function getLoginUrl (first) {
	var url = '';
	if ( typeof(id   ) != 'undefined' && id   != '' ) if ( first ) { url += '?id='   + id  ; first = false;} else { url += '&id='   + id  ; }
	if ( typeof(npop ) != 'undefined' && npop != '' ) if ( first ) { url += '?npop=' + npop; first = false;} else { url += '&npop=' + npop; }
	if ( typeof(exec ) != 'undefined' && exec != '' ) if ( first ) { url += '?exec=' + exec; first = false;} else { url += '&exec=' + exec; }
	if ( typeof(no   ) != 'undefined' && no	  != '' ) if ( first ) { url += '?no='   + no  ; first = false;} else { url += '&no='   + no  ; }
	if ( typeof(s    ) != 'undefined' && s    != '' ) if ( first ) { url += '?s='    + s   ; first = false;} else { url += '&s='    + s   ; }

	if ( typeof(poll_id  ) != 'undefined' && poll_id  != '' ) if ( first ) { url += '?poll_id='  + poll_id  ; first = false; } else { url += '&poll_id='  + poll_id  ; }
	if ( typeof(poll_exec) != 'undefined' && poll_exec!= '' ) if ( first ) { url += '?poll_exec='+ poll_exec; first = false; } else { url += '&poll_exec='+ poll_exec; }
	return url;
}

function comfirmClick(argu1) {
	if ( typeof(opener	 ) != 'undefined' && typeof(opener.document) == 'object' ) {
		if ( argu1 == '' ) {
			opener.focus();
			self.close();
		} else {
			document.location.replace(argu1);
		}
	} else {
		if ( argu1 == '' ) document.location.replace('/');
		else document.location.replace(argu1);
	}
}
var memberWin = null;
// mode : '1' : 팝업에서   회원 가입 페이지 열기
//        '2' : 현재창에서 회원 가입 페이지 열기
// successURL : 가입 성공시 이동 페이지
// width      : 팝업 윈도우 가로 크기
// height     : 팝업 윈도우 세로 크기
// scroll     : 팝업 윈도우 스크롤바 생성 여부 ( 'Y', 'N' )
function openMemberCB (gubun, mode, successURL, width, height, scroll, user_id) {
	if ( typeof(successURL) == 'undefined' ) successURL = '' ;
	if ( memberWin != null ) memberWin.close();
	var url = '';
	if ( typeof(baseDir) != 'undefined' ) url = baseDir;

	if      ( gubun == 'insert'      ) url += 'member_register.php';
	else if ( gubun == 'update'      ) url += 'member_register.php';
	else if ( gubun == 'secession'   ) url += 'member_secession.php';
	else if ( gubun == 'infor_search') url += 'member_infor_search.php';
	else if ( gubun == 'view'        ) url += 'member_view.php';

	if ( typeof(id) == 'undefined' ) {
		if ( successURL != '' ) {
			url += '?succ_url=' + escape (successURL);
			if      ( gubun == 'update'      ) url += '&mexec=update';
			else if ( gubun == 'secession'   ) url += '&mode=' + mode;
			else if ( gubun == 'infor_search') url += '&mode=' + mode;
			else if ( gubun == 'view'        ) url += '&user_id=' + user_id;
		} else {
			if      ( gubun == 'update'      ) url += '?mexec=update';
			else if ( gubun == 'secession'   ) url += '?mode=' + mode;
			else if ( gubun == 'infor_search') url += '?mode=' + mode;
			else if ( gubun == 'view'        ) url += '?user_id=' + user_id;
		}
	} else {
		if ( successURL != '' ) {
			url += '?id=' + id + '&succ_url=' + escape (successURL);
		} else {
			url += '?id=' + id;
		}
		if      ( gubun == 'update'      ) url += '&mexec=update';
		else if ( gubun == 'secession'   ) url += '&mode=' + mode;
		else if ( gubun == 'infor_search') url += '&mode=' + mode;
		else if ( gubun == 'view'        ) url += '&user_id=' + user_id;
	}

	if ( mode == '1' ) {
        scroll = ( scroll == 'Y' ) ? "yes" : "no";
		var target = '';
		if      ( gubun == 'insert'      ) target += 'memberWin';
		else if ( gubun == 'update'      ) target += 'memberWin';
		else if ( gubun == 'secession'   ) target += 'secessWin';
		else if ( gubun == 'infor_search') target += 'inforsWin';
		memberWin = window.open(url, target,'toolbar=no,menubar=no,resizable=no,scrollbars=' + scroll + ',width=' + width + ',height=' + height );
		memberWin.focus();
	} else if ( mode == '2' ) {
		document.location.href = url;
	}
}

function openMemberRegister (mode, successURL, width, height, scroll) {
	if ( typeof(mode) == 'undefined' || mode == '' ) mode = '1';
	if ( mode == '1' ) {
		if ( typeof(width ) == 'undefined' || width  == '' ) width  = member_register_popup_width;
		if ( typeof(height) == 'undefined' || height == '' ) height = member_register_popup_height;
		if ( typeof(scroll) == 'undefined' || scroll == '' ) scroll = 'Y';
	}
	openMemberCB ('insert',mode, successURL, width, height, scroll);
}

function openMemberUpdate (mode, successURL, width, height, scroll ) {
	if ( typeof(mode) == 'undefined' || mode == '' ) mode = '1';
	if ( mode == '1' ) {
		if ( typeof(width ) == 'undefined' || width  == '' ) width  = member_update_popup_width;
		if ( typeof(height) == 'undefined' || height == '' ) height = member_update_popup_height;
		if ( typeof(scroll) == 'undefined' || scroll == '' ) scroll = 'Y';
	}
	openMemberCB ('update',mode, successURL, width, height, scroll);
}

function openMemberSecession(mode, successURL, width, height, scroll) {
	if ( typeof(mode) == 'undefined' || mode == '' ) mode = '1';
	if ( mode == '1' ) {
		if ( typeof(width ) == 'undefined' || width  == '' ) width  = member_secession_popup_width;
		if ( typeof(height) == 'undefined' || height == '' ) height = member_secession_popup_height;
		if ( typeof(scroll) == 'undefined' || scroll == '' ) scroll = 'Y';
	}
	openMemberCB ('secession',mode, successURL, width, height, scroll);
}

function openMemberInforSearch(mode, successURL, width, height, scroll) {
	if ( typeof(mode) == 'undefined' || mode == '' ) mode = '1';
	if ( mode == '1' ) {
		if ( typeof(width ) == 'undefined' || width  == '' ) width  = member_infor_search_popup_width;
		if ( typeof(height) == 'undefined' || height == '' ) height = member_infor_search_popup_height;
		if ( typeof(scroll) == 'undefined' || scroll == '' ) scroll = 'Y';
	}
	openMemberCB ('infor_search',mode, successURL, width, height, scroll);
}

function openMemberView (user_id, mode, successURL, width, height, scroll ) {
	if ( typeof(mode) == 'undefined' || mode == '' ) mode = '1';
	if ( mode == '1' ) {
		if ( typeof(width ) == 'undefined' || width  == '' ) width  = member_view_popup_width;
		if ( typeof(height) == 'undefined' || height == '' ) height = member_view_popup_height;
		if ( typeof(scroll) == 'undefined' || scroll == '' ) scroll = 'Y';
	}
	openMemberCB ('view',mode, successURL, width, height, scroll, user_id);
}
//-->
</SCRIPT>
