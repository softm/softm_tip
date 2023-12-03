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
// 음력 계산 스크립트 GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(설명)
		음력을 구하는 스크립트입니다.
		원 소스는 C 코드로 되어 있던 것을
		제가 자바 스크립트로 변환을 한 것입니다.
		일일히 디버깅을 수행하며 값을 비교하였으므로
		원 소스에 이상이 없는 한 문제가 없을 것입니다.
		이 스크립트에 대해서는 자세한 설명은
		어려울 것 같습니다. -_-.

		음력변환 테이블은 170년간의 정보를 지니고 있습니다.
		대충 짐작하면 해당 년도의 각 월의 일수를
		암호 표기법으로 정리해 놓은 듯 합니다.
		밑에서 전체일수를 구하는 것을 보면 말입니다.
(변수)
		LunarTranTable : 음력 변환 테이블(1881년 ~ 2050년)
		LunarYUKSIPTable, LunarGAPJATable : 육십갑자 테이블
		LunarDDITable, LunarDDIETable: 띠 테이블
		LunarDaysOfMonthTable : 각 달의 일수 테이블
		LunarWeekNamesTable : 요일 테이블
		LunarYear, LunarMonth, LunarDay : 변환된 음력 정보
		LVar_DaysOfYearTable : 각 해의 총 일자수 테이블
		ResultLunarTEXT : 반환될 음력 정보 문자열
		ResultDDITEXT : 반환될 띠 정보 문자열
(함수)
		function LFunc_CalculateLunarCal(SolarYear, SolarMonth, SolarDay);

		<기능>
			양력 정보를 입력받아 해당 정보의 음력을 계산하여
			정해진 포맷으로 된 값을 반환합니다.
		<매개변수>
			SolarYear, SolarMonth, SolarDay : 양력 년월일
		<반환값>
			현재 함수 자체에서 실제로 return 문에 의해
			넘겨지는 값은 없습니다. 저는 반환 문자열을
			전역 변수에 보관하여 아래의 루틴들에서
			접근 사용을 하고 있기 때문입니다.
			아래의 ResultLunarTEXT 가 시작되는 위치에서
			사용 가능한 변수들의 정보는 다음과 같습니다.
			잘 조합하시면 원하는 정보를 만드실 수 있습니다.
			
			LunarYUKSIPTable[LVar_iCount1]	// 해당년도(육십)
			LunarGAPJATable[LVar_jCount1]	// 해당년도(갑자)
			LunarDDITable[LVar_jCount1]		// 해당년도(띠)
			LunarYUKSIPTable[LVar_iCount]	// 해당날짜(육십)
			LunarGAPJATable[LVar_jCount]	// 해당날짜(갑자)
			LunarYear, LunarMonth, LunarDay	// 계산된 음력 년월일
(용법)
		음력 정보를 원하는 위치에서 LFunc_CalculateLunarCal() 함수를
		호출하시면 됩니다. 물론 반환값을 적절히 처리하셔야 합니다.
(수정)
		음력을 구하는 스크립트에서 특별히 수정하여야 할 부분은
		반환값을 조합하는 부분 밖에 없습니다.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// 음력 계산 스크립트 CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	전역변수 선언부
*/
var LunarTranTable = new Array(
	"1212122322121", "1212121221220", "1121121222120",
	"2112132122122", "2112112121220", "2121211212120",
	"2212321121212", "2122121121210", "2122121212120",
	"1232122121212", "1212121221220", "1121123221222",
	"1121121212220", "1212112121220", "2121231212121",
	"2221211212120", "1221212121210", "2123221212121",
	"2121212212120", "1211212232212", "1211212122210",
	"2121121212220", "1212132112212", "2212112112210",
	"2212211212120", "1221412121212", "1212122121210",
	"2112212122120", "1231212122212", "1211212122210",
	"2121123122122", "2121121122120", "2212112112120",
	"2212231212112", "2122121212120", "1212122121210",
	"2132122122121", "2112121222120", "1211212322122",
	"1211211221220", "2121121121220", "2122132112122",
	"1221212121120", "2121221212110", "2122321221212",
	"1121212212210", "2112121221220", "1231211221222",
	"1211211212220", "1221123121221", "2221121121210",
	"2221212112120", "1221241212112", "1212212212120",
	"1121212212210", "2114121212221", "2112112122210",
	"2211211412212", "2211211212120", "2212121121210",
	"2212214112121", "2122122121120", "1212122122120",
	"1121412122122", "1121121222120", "2112112122120",
	"2231211212122", "2121211212120", "2212121321212",
	"2122121121210", "2122121212120", "1212142121212",
	"1211221221220", "1121121221220", "2114112121222",
	"1212112121220", "2121211232122", "1221211212120",
	"1221212121210", "2121223212121", "2121212212120",
	"1211212212210", "2121321212221", "2121121212220",
	"1212112112210", "2223211211221", "2212211212120",
	"1221212321212", "1212122121210", "2112212122120",
	"1211232122212", "1211212122210", "2121121122210",
	"2212312112212", "2212112112120", "2212121232112",
	"2122121212110", "2212122121210", "2112124122121",
	"2112121221220", "1211211221220", "2121321122122",
	"2121121121220", "2122112112322", "1221212112120",
	"1221221212110", "2122123221212", "1121212212210",
	"2112121221220", "1211231212222", "1211211212220",
	"1221121121220", "1223212112121", "2221212112120",
	"1221221232112", "1212212122120", "1121212212210",
	"2112132212221", "2112112122210", "2211211212210",
	"2221321121212", "2212121121210", "2212212112120",
	"1232212122112", "1212122122120", "1121212322122",
	"1121121222120", "2112112122120", "2211231212122",
	"2121211212120", "2122121121210", "2124212112121",
	"2122121212120", "1212121223212", "1211212221220",
	"1121121221220", "2112132121222", "1212112121220",
	"2121211212120", "2122321121212", "1221212121210",
	"2121221212120", "1232121221212", "1211212212210",
	"2121123212221", "2121121212220", "1212112112220",
	"1221231211221", "2212211211220", "1212212121210",
	"2123212212121", "2112122122120", "1211212322212",
	"1211212122210", "2121121122120", "2212114112122",
	"2212112112120", "2212121211210", "2212232121211",
	"2122122121210", "2112122122120", "1231212122212",
	"1211211221220", "2121121321222", "2121121121220",
	"2122112112120", "2122141211212", "1221221212110",
	"2121221221210", "2114121221221");

var LunarYUKSIPTable = 
	new Array("갑", "을", "병", "정", "무",
	"기", "경", "신", "임", "계");
var LunarGAPJATable = 
	new Array("자", "축", "인", "묘", "진", "사",
	"오", "미", "신", "유", "술", "해");
var LunarDDITable = 
	new Array("쥐", "소", "범", "토끼","용", "뱀",
	"말", "양", "원숭이", "닭", "개", "돼지");
var LunarDDIETable = 
	new Array("MOUSE", "COW", "TIGER", "RABBIT", "DRAGON", "SNAKE",
	"HORSE", "SHEEP", "MONKEY", "COCK", "DOG", "PIG");
var LunarDaysOfMonthTable = 
	new Array(31, 0, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var LunarWeekNamesTable = 
	new Array("SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT");

var LunarYear, LunarMonth, LunarDay;

var LVar_month0, LVar_month1, LVar_month2;
var LVar_iCount, LVar_iCount1, LVar_jCount, LVar_jCount1, LVar_jCount2;
var LVar_isLeapMonth, LVar_weekValue;

var LVar_DaysOfYearTable = new Array(170);
var LVar_TotalDays, LVar_TotalDays0, LVar_TotalDays1, LVar_TotalDays2;
var LVar_K11;

var LunarStrMonth, LunarStrDay;
var ResultLunarTEXT = "";
var ResultDDITEXT = "";
/*
	초기 수행부
*/
for(LVar_iCount = 0; LVar_iCount < 170; LVar_iCount++)
{
	LVar_DaysOfYearTable[LVar_iCount] = 0;

	for(LVar_jCount = 0; LVar_jCount < 12; LVar_jCount++)
	{
		switch(Number(LunarTranTable[LVar_iCount].charAt(LVar_jCount)))
		{
		case 1:
		case 3:
			LVar_DaysOfYearTable[LVar_iCount] = 
				LVar_DaysOfYearTable[LVar_iCount] + 29;
			break;
		case 2:
		case 4:
			LVar_DaysOfYearTable[LVar_iCount] = 
				LVar_DaysOfYearTable[LVar_iCount] + 30;
		}
	}
        
	switch(Number(LunarTranTable[LVar_iCount].charAt(12)))
	{
	case 0:
		break;
	case 1:
	case 3:
		LVar_DaysOfYearTable[LVar_iCount] = 
			LVar_DaysOfYearTable[LVar_iCount] + 29;
		break;
	case 2:
	case 4:
		LVar_DaysOfYearTable[LVar_iCount] = 
			LVar_DaysOfYearTable[LVar_iCount] + 30;
		break;
	}
}

LVar_TotalDays1 = (1880 * 365) + Math.floor(1880 / 4) -
	Math.floor(1880 / 100) + Math.floor(1880 / 400) + 30;
/*
	함수 선언부
*/
function LFunc_CalculateLunarCal(SolarYear, SolarMonth, SolarDay)
{
	LVar_K11 = SolarYear - 1;

	LVar_TotalDays2 = (LVar_K11 * 365) + Math.floor(LVar_K11 / 4) - 
					  Math.floor(LVar_K11 / 100) +
					  Math.floor(LVar_K11 / 400);

	LVar_isLeapMonth = ((SolarYear % 400) == 0) || 
					   ((SolarYear % 100) != 0) &&
					   ((SolarYear % 4) == 0);

	if(LVar_isLeapMonth) LunarDaysOfMonthTable[1] = 29;
	else   LunarDaysOfMonthTable[1] = 28;
      
	if( SolarDay > LunarDaysOfMonthTable[SolarMonth - 1] )
	{
		return;
	}

	for(LVar_iCount = 0; LVar_iCount < (SolarMonth - 1); LVar_iCount++)
		LVar_TotalDays2 = LVar_TotalDays2 + 
						  LunarDaysOfMonthTable[LVar_iCount];

	LVar_TotalDays2 = LVar_TotalDays2 + SolarDay;
	LVar_TotalDays = LVar_TotalDays2 - LVar_TotalDays1 + 1;
	LVar_TotalDays0 = LVar_DaysOfYearTable[0];

	for(LVar_iCount = 0; LVar_iCount < 170; LVar_iCount++)
	{
		if( LVar_TotalDays <= LVar_TotalDays0 ) break;

		LVar_TotalDays0 = LVar_TotalDays0 + 
						  LVar_DaysOfYearTable[LVar_iCount + 1];
	}

	LunarYear = LVar_iCount + 1881;

	LVar_TotalDays0 = LVar_TotalDays0 - LVar_DaysOfYearTable[LVar_iCount];
	LVar_TotalDays = LVar_TotalDays - LVar_TotalDays0;

	if(Number(LunarTranTable[LVar_iCount].charAt(12)) != 0)
		LVar_jCount2 = 13;
	else LVar_jCount2 = 12;

	LVar_month2 = 0;

	for(LVar_jCount = 0; LVar_jCount < LVar_jCount2; LVar_jCount++)
	{
		if( Number(LunarTranTable[LVar_iCount].charAt(LVar_jCount)) <= 2 )
			LVar_month2++;
		
		if( Number(LunarTranTable[LVar_iCount].charAt(LVar_jCount)) <= 2 )
			LVar_month1 = 
			Number(LunarTranTable[LVar_iCount].charAt(LVar_jCount)) + 28;
		else
			LVar_month1 = 
			Number(LunarTranTable[LVar_iCount].charAt(LVar_jCount)) + 26;

		if( LVar_TotalDays <= LVar_month1 ) break;

		LVar_TotalDays = LVar_TotalDays - LVar_month1;
	}

	LVar_month0 = LVar_jCount;
	LunarMonth = LVar_month2;

	LunarDay = LVar_TotalDays;

	LVar_weekValue = LVar_TotalDays2 % 7;

	LVar_iCount = (LVar_TotalDays2 + 4) % 10;
	LVar_jCount = (LVar_TotalDays2 + 2) % 12;

	LVar_iCount1 = ( LunarYear + 6 ) % 10;
	LVar_jCount1 = ( LunarYear + 8 ) % 12;

	if(LunarMonth < 10) LunarStrMonth = "0" + LunarMonth;
	else LunarStrMonth = "" + LunarMonth;

	if(LunarDay < 10) LunarStrDay = "0" + LunarDay;
	else LunarStrDay = "" + LunarDay;

	ResultLunarTEXT = "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=#278A05 size=1><B>";
	ResultLunarTEXT += "(음) " + "</B></FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=#278A05 size=1>";
	ResultLunarTEXT += LunarYUKSIPTable[LVar_iCount1] + 
					   LunarGAPJATable[LVar_jCount1] +
					   "년 " + "</FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=red size=1>";
	ResultLunarTEXT += LunarStrMonth + "</FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=#278A05 size=1>";
	ResultLunarTEXT += "월 " + "</FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=red size=1>";
	ResultLunarTEXT += LunarStrDay + "</FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=#278A05 size=1>";
	ResultLunarTEXT += "일" + "</FONT>";
	
	ResultDDITEXT = "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultDDITEXT += "Helvetica' color=#278A05 size=1><B>";
	ResultDDITEXT += LunarDDITable[LVar_jCount1] + 
					 "</B>" + "(" + "</FONT>";
	ResultDDITEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultDDITEXT += "Helvetica' color=red size=1>";
	ResultDDITEXT += LunarDDIETable[LVar_jCount1] + "</FONT>";
	ResultDDITEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultDDITEXT += "Helvetica' color=#278A05 size=1>";
	ResultDDITEXT += ")" + "의 해" + "</FONT>";

	return;
}
/*
///////////////////////////////////////////////////////////////////////////////
// 음력 계산 스크립트 CODE END
///////////////////////////////////////////////////////////////////////////////
*/