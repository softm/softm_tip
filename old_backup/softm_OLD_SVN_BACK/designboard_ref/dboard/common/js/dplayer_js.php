<SCRIPT LANGUAGE="JavaScript">
<!--

var musicFrameObj = null;

// 파일 선택시 제목 자동 입력
function titleAutoInsert() {
	document.writeForm.title.value = getFileNameOnly(document.writeForm.file1.value);
}

function DP_WholePlay (id, no) {
	DP_W_playPopup = window.open( baseDir + "dplayer.php?id=" + id + "&gubun=BBS_ONE_PLAY" ,'_dplayer','scrollbars=no,status=no,width=317,height=149');
	DP_W_playPopup.focus();
}

function DP_singleMediaPlay (id, no) {
	var cartObj      = getObject("_dboard_iframe")  ; // IFRAME   OBJECT
	var cartWindow   = cartObj.contentWindow        ; // WINDOW   OBJECT
	var cartDocument = cartWindow.document          ; // DOCUMENT OBJECT

	var url  = baseDir + 'dplayer_cart.php' + '?gubun=SINGLE_PLAY' + '&id=' + id;
		url += '&add_no=' + no;
		cartDocument.location.replace(url);
}

function DP_cartMediaPlay(id) {
	var cartObj      = getObject("_dboard_iframe")  ; // IFRAME   OBJECT
	var cartWindow   = cartObj.contentWindow        ; // WINDOW   OBJECT
	var cartDocument = cartWindow.document          ; // DOCUMENT OBJECT

	if ( DP_W_playPopup != null && typeof (DP_W_playPopup.document) == 'object' ) {
		DP_W_playPopup.focus();
		return false;
	} else {
	var url = baseDir + 'dplayer_cart.php' + '?gubun=CART_PLAY' + '&id=' + id;
		cartDocument.location.replace(url);
	}
}

function DP_allMediaPlay(id) {
	var cartObj      = getObject("_dboard_iframe")  ; // IFRAME   OBJECT
	var cartWindow   = cartObj.contentWindow        ; // WINDOW   OBJECT
	var cartDocument = cartWindow.document          ; // DOCUMENT OBJECT
	var url = baseDir + 'dplayer_cart.php' + '?gubun=ALL_PLAY&id=' + id;
	DP_checkedAll ();
	var chk   = getObject("chk");
	url += '&add_no=' + DP_mediaCheckedID(chk);
	cartDocument.location.replace(url);
	if ( DP_W_playPopup != null && typeof (DP_W_playPopup.document) == 'object' ) {
		DP_W_playPopup.focus();
	}
}

function DP_randomMediaPlay(id) {
	var cartObj      = getObject("_dboard_iframe")  ; // IFRAME   OBJECT
	var cartWindow   = cartObj.contentWindow        ; // WINDOW   OBJECT
	var cartDocument = cartWindow.document          ; // DOCUMENT OBJECT
	var url = baseDir + 'dplayer_cart.php' + '?gubun=RANDOM_PLAY&id=' + id;
	DP_checkedAll ();
	var chk   = getObject("chk");
	url += '&add_no=' + DP_mediaCheckedID(chk);
	cartDocument.location.replace(url);
	if ( DP_W_playPopup != null && typeof (DP_W_playPopup.document) == 'object' ) {
		DP_W_playPopup.focus();
	}
}

function DP_addMediaCart(gubun,id, no) {

	var cartObj      = getObject("_dboard_iframe")  ; // IFRAME   OBJECT
	var cartWindow   = cartObj.contentWindow        ; // WINDOW   OBJECT
	var cartDocument = cartWindow.document          ; // DOCUMENT OBJECT
	var url = baseDir + 'dplayer_cart.php' + '?gubun=' + gubun + '&id=' + id;
	if ( gubun == 'SA' ) {
		url += '&add_no=' + no;
		cartDocument.location.replace(url);
	} else if ( gubun == 'MA' ) {
		var chk   = getObject("chk");
		url += '&add_no=' + DP_mediaCheckedID(chk);
		cartDocument.location.replace(url);
	}
	if ( DP_W_playPopup != null && typeof (DP_W_playPopup.document) == 'object' ) {
		DP_W_playPopup.focus();
	}
}

function DP_delMediaCart(gubun,id, no) {
	var cartObj      = getObject("_dboard_iframe")  ; // IFRAME   OBJECT
	var cartWindow   = cartObj.contentWindow        ; // WINDOW   OBJECT
	var cartDocument = cartWindow.document          ; // DOCUMENT OBJECT
	var url = baseDir + 'dplayer_cart.php' + '?gubun=' + gubun + '&id=' + id;
	if ( gubun == 'SD' ) {
		url += '&add_no=' + no;
		cartDocument.location.replace(url);
	} else if ( gubun == 'MD' ) {
		var chk   = getObject("chk");
		url += '&add_no=' + DP_mediaCheckedID(chk);
		cartDocument.location.replace(url);
	}
}

function DP_mediaCheckedID(obj) {
	var _rtn ='';
	var addCnt= 0 ;

	if ( typeof( obj.length ) == "undefined" ) {
		if ( obj.checked ) { _rtn = obj.value; }
	} else {
		for ( var i=0;i<obj.length;i++) {
			if ( obj[i].checked ) {
				if ( addCnt > 0 ) _rtn += ",";
				_rtn += obj[i].value;
				addCnt++;
			}
		}
	}
	return _rtn;
}

function DP_checkedAll () {
	if ( exec != 'list' ) {
		return false;
	}
	var chk   = getObject("chk");
	if ( typeof( chk.length ) == "undefined" ) {
		chk.checked = true;
	} else {
		for ( var i=0;i<chk.length; i++ ) {
			chk[i].checked = true;
		}
	}
}

function DP_clearAll () {
	if ( exec != 'list' ) {
		return false;
	}
	var chk   = getObject("chk");
	if ( typeof( chk.length ) == "undefined" ) {
		chk.checked = false;
	} else {
		for ( var i=0;i<chk.length; i++ ) {
			chk[i].checked = false;
		}
	}
}

//** Function Name  : getFileNameOnly
//** Argument1      : 파일 경로명
//** Description    : 파일 경로명에서 파일 이름만을 반환
function getFileNameOnly(val)
{
	var rtnStr = val;
	var s1 = 0, s2 = 0;
	var s  = 0;
	s1 = rtnStr.lastIndexOf("\\") + 1 ;
	s2 = rtnStr.lastIndexOf("/")  + 1 ;
	if ( s1 > 0 ) { s = s1; }
	if ( s2 > 0 ) { s = s2; }
	if ( s > 0 ) {
		var e  = 0;
		e = rtnStr.lastIndexOf(".");
		if ( e > 0 ) {
			rtnStr = rtnStr.substring( s, e );
		} else {
			rtnStr = rtnStr.substring( s );
		}
	} else {
		rtnStr = "";
	}
	return rtnStr;
}

function objectCheckedClear ( obj ) {
	if ( typeof( obj) != 'undefined' ) {
		if ( typeof( obj.length ) == "undefined" ) {
			obj.checked = false;
		} else {
			for (i=0 ; i<obj.length; i++) {
				obj[i].checked = false;
			}
		}
	}
}
function objectMutiChecked ( obj, selectedVal ) {
	if ( typeof( obj) != 'undefined' ) {
        if ( typeof( obj.length ) == "undefined" ) {
            if ( obj.value == selectedVal ) {
                obj.checked = true;
            }
        } else {
            for (var i=0 ; i<obj.length; i++) {
                if ( obj[i].value == selectedVal ){
                    obj[i].checked = true;
                    break;
                }
            }
        }
    }
}
//-->
</SCRIPT>