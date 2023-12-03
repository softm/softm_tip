<script type="text/javascript">
<!--
<?if ( $mexec == 'update' ) {?>
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
function openMemberSecession(mode, successURL, width, height, scroll) {
	if ( typeof(mode) == 'undefined' || mode == '' ) mode = '1';
	if ( mode == '1' ) {
		if ( typeof(width ) == 'undefined' || width  == '' ) width  = member_secession_popup_width;
		if ( typeof(height) == 'undefined' || height == '' ) height = member_secession_popup_height;
		if ( typeof(scroll) == 'undefined' || scroll == '' ) scroll = 'Y';
	}
	openMemberCB ('secession',mode, successURL, width, height, scroll);
}
<?}?>
<?if ( $mexec == 'insert' || $mexec == 'update' ) {?>
function inStrAllBlankCheck (argu) {
	if ( typeof ( argu ) == "object" ) argu = argu.value;
	var ch1="";
	for (var i=0;i<argu.length;i++) ch1 += " ";
	if ( argu == ch1 ) return true;
	else return false;
}

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

function isEmail (email){
	if ( typeof ( email ) == "object" ) email = email.value;
	//myRe=/^[\w-]+@[\w-]+([.][\w-]+){1,3}$/;
    myRe=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	
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
function objectDisabled ( Obj, bool ) {
	if ( bool == "Y" ) {
		Obj.disabled = true;
	} else if ( bool == "N" ) {
		Obj.disabled = false;
	}
}

function objectBackColor( id, color, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) obj = id;
	else obj = getObject(id, tier);
	if ( obj != null && typeof(obj) == 'object' ) obj.style.backgroundColor = color;
}
<?}?>
var dboardPreViewImg   = null;
var dboardTmpImg1      = null;
var dboardPreViewWidth = 200 ;

function imagePreView(fileInfor,areaNum) {
	var src = null;
	if ( typeof(fileInfor) == 'object' ) { src = fileInfor.value; }
	else                                 { src = fileInfor      ; }

	dboardTmpImg1           = getObject("_dboard_tmp_img" );
	dboardPreViewImg        = getObject("_dboard_preview_img" + areaNum);

	dboardTmpImg1.src       = src;
	dboardPreViewImg.src    = src;
	setTimeout('imagePreViewResize()',1000);
}

function imagePreViewResize() {
	var width  = dboardTmpImg1.width ;
	var height = dboardTmpImg1.height;

	dboardPreViewImg.realWidth  = width ; // 실제 넓이 보관
	dboardPreViewImg.realHeight = height; // 실제 높이 보관

	if ( width > dboardPreViewWidth ) {
		dboardPreViewImg.width = dboardPreViewWidth;
	} else {
		dboardPreViewImg.width = width;
	}
/*
	var dd='';
	for (var i in dboardPreViewImg) {
		dd += i + ' ' + dboardPreViewImg[i] + '<bR>';
	}
	document.write(dd);
*/
}
var dboardPopWin = null;

function imagePopup(obj) {
	var src = null;
	dboardTmpImg1 = getObject("_dboard_tmp_img" );
	if ( typeof(obj) != "object" ) { obj = getObject(obj); }
	dboardTmpImg1.src   = obj.src;
	setTimeout('imagePopupOpen()',1000);
	return false;
}
function imagePopupOpen() {
	if ( dboardTmpImg1 != null ) {
		var width  = dboardTmpImg1.width ;
		var height = dboardTmpImg1.height;

		if ( dboardPopWin == null ) {
			dboardPopWin = window.open("about:blank","_dboard_preview_img_window","width=" + width +",height=" + height + ",toolbar=no,menubar=no,resizable=yes,scrollbars=auto");
		} else {
			dboardPopWin.close();
			dboardPopWin = window.open("about:blank","_dboard_preview_img_window","width=" + width +",height=" + height + ",toolbar=no,menubar=no,resizable=yes,scrollbars=auto");
		}
		dboardPopWin.document.open();
		dboardPopWin.document.write("<html>");
		dboardPopWin.document.write("<title>미리보기</title>");
		dboardPopWin.document.write("<body onUnLoad='opener.dboardPopWin=null;' onClick='window.close();'>");
		dboardPopWin.document.write("<img id='_dboard_popup_img' src='" + dboardTmpImg1.src + "'>");
		dboardPopWin.document.write("</body>");
		dboardPopWin.document.write("</html>");
		dboardPopWin.document.close();
		dboardPopWin.focus();
	}
	dboardTmpImg1 = null;
}

////////////////////////////////////////////
// 주민번호의 정확한 형식인지를 체크합니다.
// strDT : 주민번호1, 주민번호2
// return : true, false
///////////////////////////////////////////
function juminCheck( ls_jumin1, ls_jumin2 ) {
	var chk =0;
	var ii = 0;
	var ch1 ="";
	var ls_jumin, ls_jumin1, ls_jumin2;

	ls_jumin = ls_jumin1 + ls_jumin2;

	if (ls_jumin1.length != 6){ return false; }

	if (ls_jumin2.length != 7){ return false; }

	for(var i = 0; i <=5 ; i++)
	chk = chk + ((i%8+2) * parseInt(ls_jumin1.substring(i,i+1)));

	for(var i = 6; i <=11 ; i++)
	chk = chk + ((i%8+2) * parseInt(ls_jumin2.substring(i-6,i-5)));

	chk = 11 - (chk %11);
	chk = chk % 10;

	if (chk != ls_jumin2.substring(6,7)){ return false; }

	return true;
}
//-->
</SCRIPT>