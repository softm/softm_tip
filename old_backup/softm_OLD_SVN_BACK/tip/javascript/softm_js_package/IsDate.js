<!--
//<SCRIPT LANGUAGE=JavaScript SRC="../common/IsDate.js"></SCRIPT>
////////////////////////////////////////////
// 날짜 스트링이 정말 날짜일까?
// strDT : 검증할 날짜("YYYYMMDD")
// return : true, false
///////////////////////////////////////////
function IsDate(strDT)
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
//-->