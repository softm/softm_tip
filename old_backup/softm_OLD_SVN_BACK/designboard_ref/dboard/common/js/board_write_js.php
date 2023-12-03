
<SCRIPT LANGUAGE="JavaScript">
<!--
function checkedValue ( obj ) {
	var rtn = "";
	if ( typeof( obj.length ) == "undefined" ) {
		if ( obj.checked ) {
			rtn = obj.value;
		} else {
			rtn = "";
		}
	} else {
		for ( var i=0; i<obj.length; i++){
			if ( obj[i].checked ) {
				rtn = obj[i].value;
				break;
			}
		}
	}
	return rtn;
}

var doubleTrans = false; // 두번 폼이 전송되지 않도록 처리.
function writeData(myForm) {
	if ( doubleTrans ) { return false; }
	if ( typeof ( myForm.cat_no ) == 'object' ) {
		if ( typeof( myForm.cat_no.selectedIndex ) == 'undefined' ) { // 체크 및 라디오 상자
			if ( checkedValue ( myForm.cat_no ) == '' ) {
				if ( typeof( myForm.cat_no.length ) == 'undefined' ) {
					if ( myForm.cat_no.type != 'hidden' ) {
						myForm.cat_no.focus();
						alert ( "카테고리를 선택해주세요." );
						return false;
					}
				} else {
					myForm.cat_no[0].focus();
					alert ( "카테고리를 선택해주세요." );
					return false;
				}
			}
		} else {
			if ( myForm.cat_no.value == '' ) {
				myForm.cat_no.focus();
				alert ( "카테고리를 선택해주세요." );
				return false;
			}
		}
	}

	if ( typeof ( myForm.name ) == 'object' && ( myForm.name.value == '' || inStrAllBlankCheck ( myForm.name ) ) ) {
		alert ("이름 입력을 확인해 주세요.");
		myForm.name.focus();
		return false;
	}

	if ( typeof ( myForm.e_mail ) == 'object' && myForm.e_mail.value !='' && ( inStrBlankCheck (myForm.e_mail) || !isEmail (myForm.e_mail) ) ) {
		alert ("이메일 입력을 확인해 주세요.");
		myForm.e_mail.focus();
		return false;
	}

	if ( typeof ( myForm.home ) == 'object' && myForm.home.value !='' && inStrBlankCheck (myForm.home) ) {
		alert ("홈페이지 입력을 확인해 주세요.");
		myForm.home.focus();
		return false;
	}

	if ( typeof ( myForm.title ) == 'object' && ( myForm.title.value == '' || inStrAllBlankCheck ( myForm.title ) ) ) {
		alert ("제목 입력을 확인해 주세요.");
		myForm.title.focus();
		return false;
	}

	if ( typeof ( myForm.content ) == 'object' && myForm.content.value == '' ) {
		alert ("내용 입력을 확인해 주세요.");
		myForm.content.focus();
		return false;
	}

	if ( typeof ( myForm.password ) == 'object' && myForm.password.value == '' ) {
		alert ("비밀 번호 입력을 확인해 주세요.");
		myForm.password.focus();
		return false;
	}
	var url = getOnlyURL(document.location.href) + '?id=' + id;
	if ( exec == 'update' || exec == 'answer' ) {
		url += '&no=' + no;
	} else {
		exec = 'insert';
	}

	url += "&exec=" + exec + '_exec&npop=' + npop;

	myForm.action = url;
	doubleTrans = true;
	return true;
}

// html 모드 지정
function htmlMode (obj) {
	if ( obj.checked ) {
		if ( confirm ( '게시물 내용에 줄바꿈을 위해 <BR>을 삽입하시겠습니까?' ) ) {
			obj.value = 'B';
		} else {
			obj.value = 'Y';
		}
	}
}

function objectHide( id, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) {
		obj.style.visibility="hidden"
	}
}
function inStrBlankCheck(argu)
{
	if ( typeof ( argu ) == "object" ) { argu = argu.value; }
	var ii = 0;
	var ch1="";
	for (var i=0;i<argu.length;i++)
	{
		var ch1 = argu.charAt(i);
		if ( ch1 != ' ' ) ii=10;
		else ii = 0; break;
	}

	if ( ii == 0 ){ return true;} else { return false; }
}

/* 이메일 체크 함수 */
/* 정상적인 이메일인지 체크 후 결과값을 반환한다. */
function isEmail (email){
	if ( typeof ( email ) == "object" ) email = email.value;
	myRe=/^[\w-]+@[\w-]+([.][\w-]+){1,3}$/;
	myArray = myRe.exec(email);
	if(myArray) return true;
	else return false;
}

function hideFileInfor(name) {
    var obj = getObject(name);
//    obj.style = 'display:none';
    if ( obj != null && typeof(obj) != 'undefined' ) {
        obj.style.display = 'none';
    }
}

//-->
</SCRIPT>
