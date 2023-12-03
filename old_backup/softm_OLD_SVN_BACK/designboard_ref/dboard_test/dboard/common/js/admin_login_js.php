
<script type="text/javascript">
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
//-->
</SCRIPT>
