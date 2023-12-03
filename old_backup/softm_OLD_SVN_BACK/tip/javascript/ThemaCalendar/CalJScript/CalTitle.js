/****************************************************************************/
/*
/* 테마 달력 소스
/*
/* 제작자 : 천고마비
/* 제작일 : 2003. 11. 30
/* 수정일 : 2003. 12. 05
/* 홈경로 : http://myhome.naver.com/hullangi
/* 이메일 : hullangi@naver.com
/* 저작권 : 공개용 소스
/*		   이 소스의 수정 및 재배포는 자유롭습니다.
/*         단, 위 제작 관련 정보를 지우지 않는다는 조건입니다.
/*		   이 소스의 사용은 개인적인 용도로서 자유이며,
/*		   사용과 동시에 발생되는 어떤 문제도
/*		   사용자 자신에게 책임이 있음을 밝힙니다.
/*
/****************************************************************************/
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 타이틀 스크립트 GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(설명)
		달력 타이틀 스크립트입니다.
		타이틀의 내용으로는 해당년월 정보와 해당일의 음력정보와
		해당년도의 단군기원 표기와 해당년도의 띠정보 등입니다.
		출력 효과로는 <DIV> 객체의 필터링 효과를 적용했습니다.
		출력 문자열은 단순 텍스트 뿐만 아니라
		HTML 형식도 가능합니다.
(변수)
		CalTitleVar_TitleText : 출력 문자열 배열
		CalTitleVar_MonthNames : 월의 영문 이름 테이블
		CalTitleVar_TodayDate : JavaScript 내장 Date 객체 변수
		CalTitleVar_ThisYear, CalTitleVar_ThisMonth,
		CalTitleVar_ThisDate : 현재 년월일
		CalTitleVar_DanGiYear : 단군기원 년도
(함수)
		function CalTitleFunc_Main();

		<기능>
			타이틀 출력을 총괄하는 메인 함수입니다.
			각각의 출력정보 문자열을 만드는 함수들을 호출하여
			이를 조합하는 기능과 조합된 문자열 출력 효과를 위한
			애니메이션 함수를 호출합니다.

		function CalTitleFunc_AnimateText();

		<기능>
			조합된 문자열을 이용하여 애니메이션 효과를 주는
			함수입니다. <BODY> 영역 안에 있는 <DIV> 객체에
			필터링 효과를 줌으로써 애니메이션 효과를 부여합니다.
			객체의 이름은 CalTitleWindow 입니다.
			그리고 주기적인 변화를 위하여 타이머를 작동시키고 있습니다.

		function CalTitleFunc_MakeMYText();

		<기능>
			해당 년도와 월 정보 문자열을 만들어 주며
			조합된 문자열을 반환하여 주는 함수입니다.

		function CalTitleFunc_MakeLCText();

		<기능>
			해당 년월일에 대한 음력 정보를 만둘어 주며
			조합된 문자열을 반환하여 주는 함수입니다.
			사용시 주의해야 될 점은 음력에 관한 것입니다.
			음력을 구하는 스크립트 함수는 위에 정의되어
			있는데 이를 호출한 적이 없기 때문에
			본 함수를 호출하기 전에 음력을 구하는 함수를
			호출하여 문자열이 구해져 있어야 한다는 것입니다.
			이에 여기서는 CalTitleFunc_Main() 함수에서
			LFunc_CalculateLunarCal() 함수를 먼저 호출하고
			있으며 그 후에 본 CalTitleFunc_MakeLCText() 를
			호출하여 조합된 음력정보 문자열을 얻고 있습니다.

		function CalTitleFunc_MakeDDIText();

		<기능>
			해당년도의 띠 정보를 만들어 주며
			조합된 문자열을 반환하여 주는 함수입니다.
			위의 CalTitleFunc_MakeLCText() 함수에서
			처럼 음력 계산 함수에서 문자열이 이미
			만들어지기 때문에 호출 규칙은 위의
			함수와 동일합니다.

		function CalTitleFunc_MakeDanGiText();

		<기능>
			해당년도의 단군 기원 년도를 계산하여 주며
			조합된 문자열을 반환하여 주는 함수입니다.
(용법)
		HTML 문서의 <BODY> 태그의 onload 이벤트에
		CalTitleFunc_Main() 함수가 호출되도록 하는
		코드를 넣어 주시면 됩니다.
(수정)
		수정하여 사용하실 경우는 CalTitleFunc_Make 계열 함수에서
		문자를 조합하는 방식을 바꾸시면 됩니다.
		추가될 내용들이 늘어난다면 배열을 적절히 늘려 주시고
		원하는 문자열을 조합하는 함수를 만들어 주시면 됩니다.
		만약, 애니메이션 효과를 수정하고 싶으시다면
		타이머 간격이라든지 현재는 7초(7000)로 되어 있습니다.
		아니면 필터링 효과를 변경하는 것인데
		그것은 CalTitleWindow DIV 객체 부분에 보시면
		revealTrans(Transition=6, Duration=3); 코드가 있습니다.
		여기서 Transition=6 의 값을 변경하시면 다른 효과를 주실
		수 있습니다. 값의 범위는 0 - 23 까지로 알고 있습니다.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// 음력 계산 스크립트 CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	전역변수 선언부
*/
var CalTitleVar_TitleText = new Array(4);
var CalTitleVar_iCount = 0;
var CalTitleVar_MonthNames = 
	new Array("January", "Februrary", "March", "April", "May", "June",
		"July", "August", "September", "October", "November", "Decemeber");
var CalTitleVar_TodayDate = new Date();

var CalTitleVar_ThisYear	= CalTitleVar_TodayDate.getYear();
var CalTitleVar_ThisMonth	= CalTitleVar_TodayDate.getMonth();
var CalTitleVar_ThisDate	= CalTitleVar_TodayDate.getDate();

var CalTitleVar_DanGiYear	= CalTitleVar_ThisYear + 2333;

var CalTitleVar_TmpString = "";

var CalTitleVar_LoopCount = -1;
/*
	함수 선언부
*/
function CalTitleFunc_MakeMYText()
{
	CalTitleVar_TmpString = "<FONT style='FONT: 9px Small Fonts, VT100, ";
	CalTitleVar_TmpString += "Arial, Helvetica' color=#278A05 size=1><B>";
	CalTitleVar_TmpString += 
		CalTitleVar_MonthNames[CalTitleVar_ThisMonth] +
		", " + CalTitleVar_ThisYear;
	CalTitleVar_TmpString += "</B></FONT>";
	
	return CalTitleVar_TmpString;
}

function CalTitleFunc_MakeLCText()
{
	CalTitleVar_TmpString = ResultLunarTEXT;
	
	return CalTitleVar_TmpString;
}

function CalTitleFunc_MakeDDIText()
{
	CalTitleVar_TmpString = ResultDDITEXT;

	return CalTitleVar_TmpString;
}

function CalTitleFunc_MakeDanGiText()
{
	CalTitleVar_TmpString = "<FONT style='FONT: 9pt, cutyfont, VT100, ";
	CalTitleVar_TmpString += "Arial, Helvetica' color=#278A05 size=1><B>";
	CalTitleVar_TmpString += "단기 " + "</B></FONT>";
	CalTitleVar_TmpString += "<FONT style='FONT: 9pt, cutyfont, VT100, ";
	CalTitleVar_TmpString += "Arial, Helvetica' color=red size=1>";
	CalTitleVar_TmpString += CalTitleVar_DanGiYear + "</FONT>";
	CalTitleVar_TmpString += "<FONT style='FONT: 9pt, cutyfont, VT100, ";
	CalTitleVar_TmpString += "Arial, Helvetica' color=#278A05 size=1>";
	CalTitleVar_TmpString += " 년" + "</FONT>";

	return CalTitleVar_TmpString;
}

function CalTitleFunc_AnimateText()
{
	if(!document.all) return;
	
	if (CalTitleVar_LoopCount == (CalTitleVar_TitleText.length - 1))
		CalTitleVar_LoopCount = 0;
	else
		CalTitleVar_LoopCount++;
	
	CalTitleWindow.filters[0].apply();
	CalTitleWindow.innerHTML = CalTitleVar_TitleText[CalTitleVar_LoopCount];
	CalTitleWindow.filters[0].play();

	setTimeout("CalTitleFunc_AnimateText()", USERCONFIG_CT_TimeInterval);
}

function CalTitleFunc_Main()
{
	for(CalTitleVar_iCount = 0; 
		CalTitleVar_iCount < CalTitleVar_TitleText.length;
		CalTitleVar_iCount++)
	{
		CalTitleVar_TitleText[CalTitleVar_iCount] = "";
	}
	
	CalTitleVar_TitleText[0] = CalTitleFunc_MakeMYText();

	LFunc_CalculateLunarCal(CalTitleVar_ThisYear, 
		CalTitleVar_ThisMonth + 1, CalTitleVar_ThisDate);

	CalTitleVar_TitleText[1] = CalTitleFunc_MakeLCText();
	CalTitleVar_TitleText[2] = CalTitleFunc_MakeDDIText();
	CalTitleVar_TitleText[3] = CalTitleFunc_MakeDanGiText();
	
	CalTitleFunc_AnimateText();
}
/*
///////////////////////////////////////////////////////////////////////////////
// 음력 계산 스크립트 CODE END
///////////////////////////////////////////////////////////////////////////////
*/