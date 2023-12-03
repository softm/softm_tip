<SCRIPT LANGUAGE="JavaScript">
<!--
<?if ( $branch == 'setup' ) {?>
function paddingChar(num,limit,chr) {
	var val = "" + num;
	if ( val.length < limit ) {
		var to = limit - val.length;
	}
	for ( var t=0; t<to; t++) { val = (chr + val); }
	return val;
}
// from_path에대한 to_path의 상대 경로
function relativeDir(from_path, to_path) {
    from_path = from_path.toLowerCase();
    to_path   = to_path.toLowerCase  ();
    var frm_su = inStrCounter( from_path, '/' );
    var to_su  = inStrCounter( to_path  , '/' );

    var max_su = 0;
    if      ( frm_su > to_su  ) max_su = frm_su;
    else if ( to_su  > frm_su ) max_su = to_su ;
    else max_su = to_su;
    var depth  = to_su - frm_su;
    var relDir ='';

    var f_pos=0;
    var t_pos=0;
    var pre_f_pos=0;
    var pre_t_pos=0;

    for ( var i=0; i<=max_su; i++) {
        f_pos = from_path.indexOf ( '/', f_pos );
        t_pos = to_path.indexOf   ( '/', t_pos );
        if  ( from_path.substring ( 0, f_pos ) != to_path.substring ( 0, t_pos ) )  break;
        frm_su--;
        to_su--;
        f_pos = f_pos + 1;
        t_pos = t_pos + 1;
        pre_f_pos = f_pos;
        pre_t_pos = t_pos;
    }

    from_path = from_path.substring ( pre_f_pos );
    to_path   = to_path.substring   ( pre_t_pos );

    if ( from_path != to_path ) {
        for ( var i=0;i<to_su;i++ ) {
            relDir += '../';
        }
        relDir += from_path;
    } else {
            relDir += '';
    }
    return relDir;
}
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

function objectDisabled ( Obj, bool ) {
	if ( bool == "Y" ) {
		Obj.disabled = true;
	} else if ( bool == "N" ) {
		Obj.disabled = false;
	}
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

// val을 넘겨 받아 문자열에 포함된 val의 갯수를 구합니다.
function inStrCounter ( str, val ) {
	var len = str.length;
	var cnt = 0;
	for(var i=0;i<len; i++ ) {
		if ( str.indexOf(val,i) >= 0) {
			i = str.indexOf(val,i);
			cnt++;
		}
	}
	return cnt;
}
<?}?>

<?if ( $branch == 'result_write' ) {?>
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
//////////////////////////////////////////////////////////
function eventPageTab ( start, totcount, action ) {
	document.PageForm.s.value = start;
	document.PageForm.tot.value = totcount;
	document.PageForm.submit();
}
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
/////////////////////////////////////////////////////////
//-->
</SCRIPT>