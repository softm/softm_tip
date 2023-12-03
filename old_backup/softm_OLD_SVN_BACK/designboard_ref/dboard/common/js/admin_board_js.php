<SCRIPT LANGUAGE="JavaScript">
<!--
<?if ( $branch == 'list' ) {?>
//**************** 수치 첵크 ***************************//
//** Function Name  : isAlphaNum     *******************//
//** Argument1      : argu ( 입력된 영숫자 값 )****//
//******************************************************//
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
function boardPageTab ( start, totcount, action ) {
	document.PageForm.s.value = start;
	document.PageForm.tot.value = totcount;
	document.PageForm.submit();
}
<?}?>
<?if ( $branch == 'setup' ) {?>
function objectDisabled ( Obj, bool ) {
	if ( bool == "Y" ) {
		Obj.disabled = true;
	} else if ( bool == "N" ) {
		Obj.disabled = false;
	}
}
<?}?>
<?if ( $branch == 'abstract' ) {?>
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
function objectHide( id, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) { 
		obj.style.display="none";
	}
}
function objectShow( id, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) { 
		obj.style.display="";
	}
/*        obj.style.zIndex=0;     Object들의 기본적인 zIndex 값은 0 입니다. */
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

/* sytle의 Position 값을 설정합니다.
   static , relative, absolute*/
function objectPosition(id,position, tier) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) { 
		obj.style.position=position;
	}
}

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
<?}?>

////////////////////////////////////////////////////////
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
////////////////////////////////////////////////////////

//-->
</SCRIPT>