
<SCRIPT LANGUAGE="JavaScript">
<!--
<?if ( $branch == 'list' || $branch == 'kind' ) {?>
function objectChecked ( obj, selectedVal ) {

	if ( isNaN ( obj.length ) ) {
		if ( obj.value == selectedVal ) {
			obj.checked = true;
		} else {
			obj.checked = false;
		}
	} else {
		for (i=0 ; i<obj.length; i++) {
			if ( obj[i].value == selectedVal ){
				obj[i].checked = true;
				break;
			} else {
				obj[0].checked = false;
			}
		}
	}
}

function setCheckedAll ( obj, boolVal ) {
	var oppVal = !boolVal;
//      alert ( oppVal );
	if ( isNaN ( obj.length ) ) {
		obj.checked = boolVal;
	} else {
		for (i=0 ; i<obj.length; i++) {
			obj[i].checked = boolVal;
		}
	}
}
//******************************************************//
//** Function Name    : strLength      *****************//
//** Argument1        : str ( 입력된 문자열 )       ****//
//** 한글을 포함한 문자열의 길이 계산               ****//
//******************************************************//
function strLength (str) {
	var char_cnt = 0;
	for(var i = 0; i < str.length; i++) {
		var chr = str.substr(i,1);
		chr = escape(chr);
		var key_eg = chr.charAt(1);
	// key_eg 가 u 이면 한글 , 공백이면 영문 , 숫자면 특수문자
		switch (key_eg) {
			case "u":
	//        alert ( '여기' );
				key_num = chr.substr(2,(chr.length-1));
				if((key_num < "AC00") || (key_num > "D7A3")) {
	//                alert("잘못된 입력입니다");
					return false;
				} else {
					char_cnt = char_cnt + 2;
				}
			break;
			case "B":
				char_cnt = char_cnt + 2;
				break;
			case "A":
	//            alert("잘못된 입력입니다");
				return false;
				break;
				default:
				char_cnt = char_cnt + 1;
		}
	}
	return char_cnt;
}

function memberPageTab ( start, totcount, action ) {
	document.PageForm.s.value = start;
	document.PageForm.tot.value = totcount;
	document.PageForm.submit();
}
<?}?>
<?if ( $branch == 'write' ) {?>
function inStrBlankCheck(argu)
{
	if ( typeof ( argu ) == "object" ) argu = argu.value;
	var ii = 0;
	var ch1="";
	for (var i=0;i<argu.length;i++)
	{
		var ch1 = argu.charAt(i);
		if ( ch1 != ' ' ) ii=10;
		else ii = 0; break;
	}
	if ( ii == 0 ) return true; else return false;
}
function isAlphaNum (argu)
{
	var AlphaNum = "1234567890_ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var ch1 = '';
	var ii=0;
	var L = argu.length;
	argu = argu.toUpperCase();
	for (var i=0; i < L; i++) {
		ch1 = argu.charAt(i);
		if ( AlphaNum.indexOf(ch1) < 0 ) { ii = 0; break; }
		else { ii=10; }
	}
	if ( ii == 10 ) { return true; } else { return false; }
}

function paddingChar(num,limit,chr) {
	var val = "" + num;
	if ( val.length < limit ) {
		var to = limit - val.length;
	}
	for ( var t=0; t<to; t++) { val = (chr + val); }
	return val;
}

function age ( Byyyymmdd, Syyyymmdd ) {

	var birthyear   = parseInt( Byyyymmdd.substring(0,4), 10 );
	var birthmonth  = parseInt( Byyyymmdd.substring(4,6), 10 );
	var birthday    = parseInt( Byyyymmdd.substring(6,8), 10 );

	var systemyear  = parseInt( Syyyymmdd.substring(0,4), 10 );
	var systemmonth = parseInt( Syyyymmdd.substring(4,6), 10 );
	var systemday   = parseInt( Syyyymmdd.substring(6,8), 10 );

	var age =0;

	age = ( systemyear - birthyear ) - 1;
	if ( birthmonth < systemmonth  ) { // 태어난 달이 지나갔을 경우에는 한살 더 먹었쥐..
	//     10           9
		age += 1;
	} else if ( birthmonth = systemmonth ) { //  태어난 달이랑 시스템 달이랑 같으면 날짜를 비교해보는거쥐.
		if ( birthday <= systemday ) {
			age += 1;
		}
	}
	return parseInt(age);
}

///////////////////////////////////////////
// 날짜 스트링이 정말 날짜일까?
// strDT : 검증할 날짜("YYYYMMDD")
// return : true, false
///////////////////////////////////////////
function isDate(strDT)
{
	if(strDT.length < 8) return false;
	
	var d = new Date(strDT.substring(0, 4),
					strDT.substring(4, 6) - 1,
					strDT.substring(6, 8),
					0, 0, 0);
	
	if(isNaN(d) == true) return false;
	
	var s = d.getFullYear().toString();
	var n = d.getMonth() + 1;
	s += (n < 10 ? "0" : "") + n;
	n = d.getDate();
	s += (n < 10 ? "0" : "") + n;
	
	if(strDT != s) return false;
	
	return true;
}

function objectBackColor( id, color, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) obj = id;
	else obj = getObject(id, tier);
	if ( obj != null && typeof(obj) == 'object' ) obj.style.backgroundColor = color;
}

var dboardPreViewImg   = null;
var dboardPreViewWidth = 200 ;
var dboardPreImgPath   = null;

function imagePreView(fileInfor,viewAreaId) {
	var src = null;
	if ( typeof(fileInfor) == 'object' ) { dboardPreImgPath = fileInfor.value; }
	else                                 { dboardPreImgPath = fileInfor      ; }
    dboardPreViewImg = getObject(viewAreaId);
    imagePreViewResize();
//	setTimeout('imagePreViewResize()',1000);
}

function imagePreViewResize() {
    var imgarr=new Image();
        imgarr.src=dboardPreImgPath;
        var width=imgarr.width;

        if ( width > dboardPreViewWidth ) dboardPreViewImg.width = dboardPreViewWidth;
        else                              dboardPreViewImg.width = width;

        dboardPreViewImg.style.display="";
        dboardPreViewImg.src=imgarr.src;
/*
	var dd='';
	for (var i in dboardPreViewImg) {
		dd += i + ' ' + dboardPreViewImg[i] + '<bR>';
	}
	document.write(dd);
*/
}

var dboardPopWin = null;
var dboardPopImg = null;
function imagePopup(id) {
    dboardPopImg =new Image();
    dboardPopImg.src=getObject(id).src;

    setTimeout('imagePopupOpen()',1000);

	return false;
}
function imagePopupOpen() {
	if ( dboardPopImg != null ) {
		var width  = dboardPopImg.width ;
		var height = dboardPopImg.height;

		if ( dboardPopWin == null ) {
			dboardPopWin = window.open("about:blank","_dboard_preview_img_window","width=" + width +",height=" + height + ",toolbar=no,menubar=no,resizable=yes,scrollbars=auto");
		} else {
			dboardPopWin.close();
			dboardPopWin = window.open("about:blank","_dboard_preview_img_window","width=" + width +",height=" + height + ",toolbar=no,menubar=no,resizable=yes,scrollbars=auto");
		}
		dboardPopWin.document.open();
		dboardPopWin.document.write("<html>");
		dboardPopWin.document.write("<title>미리보기</title>");
		dboardPopWin.document.write("<body bgcolor='#FFFFFF' text='#000000' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' onUnLoad='opener.dboardPopWin=null;' onClick='window.close();'>");
		dboardPopWin.document.write("<img id='_dboard_popup_img' src='" + dboardPopImg.src + "'>");
		dboardPopWin.document.write("</body>");
		dboardPopWin.document.write("</html>");
		dboardPopWin.document.close();
		dboardPopWin.focus();
	}
	dboardPopImg = null;
}
<?}?>
function objectSelected( obj, selectedVal ) {
	if ( typeof ( obj ) == "object" ) {
		for (i=0; i<obj.length; i++) {
			if ( obj[i].value == selectedVal ) { obj.selectedIndex = i; break;}
			else { obj.selectedIndex = 0; }
		}
	}
}

function objectDisabled ( Obj, bool ) {
	if ( bool == "Y" ) {
		Obj.disabled = true;
	} else if ( bool == "N" ) {
		Obj.disabled = false;
	}
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

function isChecked ( obj ) {
	var rtn = false;
	if ( typeof( obj.length ) == "undefined" ) {
		if ( obj.checked ) rtn = true;
		else rtn = false;
	} else {
		for ( var i=0; i<obj.length; i++){
			if ( obj[i].checked ) {
				rtn = true;
				break;
			}
		}
	}
	return rtn;
}

//////////////////////////////////////////////////////////
//**************** 수치 첵크 ***************************//
//** Function Name  : isNumber       *******************//
//** Argument1      : argu_number ( 입력된 숫자 값 )****//
//******************************************************//
function isNumber(argu_number)
{
	var Number = "1234567890";
	var ii=0;
	var L = argu_number.length;

	for (var i=0; i < L; i++) {
		ch1 = argu_number.substring(i,i+1);
		if ( i == 0 ) {
			if ( ch1 != '-' && Number.indexOf(ch1) < 0 ) {
				ii = 0;
				break;
			} else {
				ii=10;
			}
		} else {
			if ( Number.indexOf(ch1) < 0 ) { ii = 0; break; }
			else { ii=10; }
		}
	}
	if ( ii == 10 ) return true;
	else return false;
}
/////////////////////////////////////////////////////////
//-->
</SCRIPT>
