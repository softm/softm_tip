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
// 달력 MAIN HEADER 스크립트 GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(설명)
		달력 MAIN HEADER 스크립트입니다. 헤더라 함은 아래의 문서
		본문 작성 스크립트를 위한 준비단계를 말합니다.
		위의 각종 스크립트를 포함하여 여기의 내용들이 모두
		본문 스크립트에서 사용을 하기에 중요하기도 하고
		그래서 자세한 설명을 소스 자체에도 덧붙이도록 하겠습니다.

		달력의 해당 월의 날짜를 결정하기 위한 초기 작업을 수행하며
		각종 행사일(국경일, 공휴일, 절기, 기념일) 자료를 구성하고
		이를 접근하는 기능 함수들이 위치하고 있다.
		또한 깜빡이는 작은 동그라미 아이콘 관련 기능들이
		포함되어 있습니다.

		여담이지만 코드의 완벽한 무결성은 보장되지 않습니다.
		일일히 무결성 검사 부분을 첨가하지 않은 것은
		특정 상황에 맞게 최적화 되어 있기 때문입니다.
		예를 들어, 각종 행사일 데이타는 적어도 1개는 있어야 합니다.
		없는 경우는 체크를 하지 않기 때문입니다.
		그리고, 검색 알고리즘을 단순 순차 검색을 사용한 것은
		대용량 데이타가 있는 것도 아니고
		요즘의 CPU 수행능력에 비추어 볼 때 옥의 티도 되지를 않습니다.
		단순히 같은 형태의 코드가 반복되는 점이 보기에
		안 좋을 수도 있다는 점이 있기는 합니다.
		그 점은 알아서들 고쳐서 사용하시길 바랍니다.
(변수)
		CalVar_MonthNames : 월 이름 배열
		CalVar_MonthDays : 월별 날짜 수 배열
		DIVar_InfoTableLH : 국경일(a legal holiday) 정보 데이타
		DIVar_InfoTableST : 절기(a solar terms) 정보 데이타
		DIVar_InfoTableMD : 기념일(a memorial day) 정보 데이타
							모든 정보 데이타는 구조체 배열로 구성
							[][4 (=년,월,일,행사정보내용)]
		DIVar_ThisMonthStateTable : 이달의 행사 정보 상황 테이블
									2차원 배열로 구성
									[이달의 날짜수][3 (=국경일,절기,기념일)]
		CalVar_TodayDate : 시스템의 현재 년월일 정보
		CalVar_ThisYear : 현재 년도
		CalVar_ThisMonth : 현재 월 (0 - 11)
		CalVar_ThisDate : 현재 일 ( 1 ~ [28,29,30,31])
		CalVar_ThisDay : 현재 요일 (0 - 6)
(함수)
		function DIFunc_StateCreate(DIVar_pLH, DIVar_pST, DIVar_pMD);

		<기능>
			이달의 상황 테이블을 위한 객체 요소 생성 함수입니다.
			이 함수 자체로는 같은 종류의 값(false, true)을 같는
			일차원 배열을 생성하는 것과 동일합니다.
			한 번 호출될 때마다 동적으로 요소가 [3] 인 배열을
			생성합니다.
		<매개변수>
			DIVar_pLH : 해당일이 국경일인지의 여부(false, true)
			DIVar_pST : 해당일이 절기인지의 여부(false, true)
			DIVar_pMD : 해당일이 기념일인지의 여부(false, true)
		
		function DIFunc_InfoCreate(DIVar_pYear, DIVar_pMonth, DIVar_pDay,
						   DIVar_pTxtHTML);

		<기능>
			각 행사(국경일, 절기, 기념일) 정보를 생성하는 함수입니다.
			행사의 형식은 년도, 월, 일, 내용으로 구성됩니다.
			내용은 문자열로 다른 숫자값과 다르기 때문에
			구조체 배열이라고 표현을 한 것입니다.
			상위 배열에 대하여 하위의 요소들을 생성한다는 점은
			위의 함수와 동일합니다.
		<매개변수>
			DIVar_pYear, DIVar_pMonth, DIVar_pDay : 년월일 정보
			DIVar_pTxtHTML : 내용 (TXT, HTML 형식 가능)

		function DIFunc_IsExistDateInfo(DIVar_pDay);

		<기능>
			해당 일에 관한 행사 정보가 있는지를 알아내는 함수입니다.
			3가지 행사 정보중 어느 하나라도 있다면 결과는 OK입니다.
		<매개변수>
			DIVar_pDay : 알아보고자 하는 일

		function DIFunc_FindInfoString(DIVar_fsKindOfDate, DIVar_fsDay);

		<기능>
			해당하는 행사의 날짜에 관한 내용을 알아내는 함수입니다.
			각 행사 종류별로 다른 테이블을 사용하고 있으므로
			구별을 해 주기 위해 종류구별 매개변수가 하나 더 사용됩니다.
		<매개변수>
			DIVar_fsKindOfDate : 행사 종류 (1=국경일, 2=절기, 3=기념일)
			DIVar_fsDay : 알아보고자 하는 행사일

		function DIFunc_GetInfoHTML(DIVar_pDay);

		<기능>
			해당 날짜에 포함된 모든 행사들의 내용을 조합하는 함수입니다.
			각각의 내용들을 합해서 하나의 HTML 형식의 문자열을 생성합니다.
		<매개변수>
			DIVar_fsDay : 알아보고자 하는 행사일

		function DIFunc_GetIconImageName(DIVar_pDay, DIVar_bToday);

		<기능>
			해당일에 포함된 행사들의 조합에 따라 날짜 바탕에 표시하기 위한
			아이콘을 알아내는 함수입니다.
			3가지 종류의 조합인 2 * 2 * 2 = 8 개의 아이콘이 사용됩니다.
			어떤 행사도 없는 날은 아이콘이 표시가 되지를
			않지만 형식상 첨가해 놓았습니다.
			행사일과 그 행사일이 오늘인지의 여부를 판별하는 이유는
			바탕의 이미는 <TD> 태그의 백그라운드 이미지로
			표현이 되는데 오늘인 경우는 사각 테두리에
			바탕색이 지정되어 있기 때문입니다.
			중복이 일어날 경우 바탕색이 사라지고 아이콘만
			보이기 때문에 아이콘에 바탕색을 첨가한 아이콘을
			따로 8 장을 만들어 놓았습니다.
		<매개변수>
			DIVar_pDay : 알아보고자 하는 행사일
			DIVar_bToday : 알아보고자 하는 행사일이
						   현재의 오늘과 겹치는지의 여부
(용법)
		각각의 함수들을 본문의 필요한 위치에서 호출한다.
(수정)
		수정 가능한 정보로는 다음과 같은 것들이 있습니다.

		DIVar_InfoTableLH : 국경일(a legal holiday) 정보 데이타
		DIVar_InfoTableST : 절기(a solar terms) 정보 데이타
		DIVar_InfoTableMD : 기념일(a memorial day) 정보 데이타

		해당 년도의 데이타들로 업데이트를 해 주셔야 합니다.

		기타 행사 문자열 조합 방식이라든지
		사용되는 아이콘의 경로 및 이름이라든지 적절히 변경하시면 됩니다.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 MAIN HEADER 스크립트 CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	전역변수 선언부
*/
var CalVar_MonthNames	= 
	new Array("January", "Februrary", "March", "April", "May",
			  "June", "July", "August", "September",
			  "October", "November", "Decemeber");
var CalVar_MonthDays	= 
	new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
var CalVar_TodayDate	= new Date();

var DIVar_InfoTableLH = new Array();
var DIVar_InfoTableST = new Array();
var DIVar_InfoTableMD = new Array();

var DIVar_ThisMonthStateTable = new Array();
var DIVar_iCount, DIVar_jCount;
/*
	달력 날짜 관련 초기 수행부
*/
// 시스템 현재의 년도, 월, 일, 요일을 구한다.
CalVar_ThisYear		= CalVar_TodayDate.getYear();
CalVar_ThisMonth	= CalVar_TodayDate.getMonth();
CalVar_ThisDay		= CalVar_TodayDate.getDay();
CalVar_ThisDate		= CalVar_TodayDate.getDate();
// 현재의 년도를 100으로 나눈 나머지를 구한다.
CalVar_ThisYear		= CalVar_ThisYear % 100;
// 이 코드는 예전의 Y2K 문제가 있던 시절 사용되었던
// 년도 보정 코드로 현재는 별 의미가 없다.
CalVar_ThisYear = ((CalVar_ThisYear < 50) ? (2000 + CalVar_ThisYear) :
				  (1900 + CalVar_ThisYear));
// 올해에 윤달이 있는지를 검사하여 2월달의 날짜수를 보정한다.
if (((CalVar_ThisYear % 4 == 0) && !(CalVar_ThisYear % 100 == 0)) || 
	(CalVar_ThisYear % 400 == 0))
	CalVar_MonthDays[1]++;
// 코드블럭 A 의 시작부터 끝까지의 코드가 수행하는 일은
// 현재의 날짜(일)를 이용하여 이번달 1일이
// 어느 요일부터 시작되는지를 파악하는 것입니다.
// 현재일이 7 보다 크다면 7 이하의 값(K)으로 낮추어 줍니다.
// 그 다음 (현재요일 - K + 1) 로 보정을 수행합니다.
// 마지막으로 보정한 값이 음수인 경우 여기에 다시
// 7 을 더해 양수로 다시 보정하여 줍니다.
// 이렇게 하면 이번달의 1일의 위치가 결정됩니다.
// 제가 이런 알고리즘을 만들지는 않았지만
// 조금만 생각하면 그 원리를 알 수 있습니다.
// 덧붙이자면 달력의 칸은 7칸이고
// 여기서 1일이 그 7칸 중 어디에서 시작이 되든지
// 숫자의 배열은 일관성이 있다는 것입니다.
// 예를 들어 1 다음줄에는 반드시 8이라는 숫자가
// 나옵니다. 그리고 3 다음줄에는 반드시 10이라는 숫자가
// 나옵니다. 자, 그럼 예를 들어 보겠습니다.
// 1일이 토요일로 시작되는 달이 있다고 하겠습니다.
// 이 경우 a-2까지 수행을 하고 나면
// 오늘이 몇일이든지 요일별로 2 3 4 5 6 7 1 값으로
// 변환됩니다. 여기서 a-3까지 수행을 하면
// -1 -1 -1 -1 -1 -1 6 으로 변환이 됩니다.
// 우리가 찾고자 하는 것은 1일이 무슨 요일인지를
// 알아내는 것입니다. 1일이 토요일(6)이라고 가정을
// 했으니 맨끝 토요일에 6이라는 값이 나왔네요.
// 문제는 나머지 요일의 값들이 모두 -1 이라는 것입니다.
// 나머지 값들도 모두 6으로 표현이 된다면
// 이달의 시작 위치가 6의 자리인 토요일이라는 것을
// 말하여 줄 수 있을 것입니다. 그래서 음수에 7을
// 더해 모두 6 6 6 6 6 6 6 으로 되도록 만들어 준 것입니다.
// 하나 더 예를 들겠습니다. 1일이 금요일부터
// 시작되는 달이 있다고 가정하겠습니다.
// 이럴 경우 a-3 까지 수행하고 나면
// 값들은 -2 -2 -2 -2 5 5 의 형태를 갖습니다.
// 여기에 a-4까지 수행을 하고 나면 값들이 모두
// 5인 5 5 5 5 5 5 5 배열이 이루어집니다.
// 한 눈에 봐도 1일의 시작위치가 금요일(5)이라는
// 것을 알 수 있습니다. 표로 구성해 보았으니
// 한 눈에 들어오실 것입니다.
//
//   a-2 수행후             a-3 수행후               a-4 수행후
// 2 3 4 5 6 7 1 ===⇒ -1 -1 -1 -1 -1 -1  6 ===⇒ 6 6 6 6 6 6 6
// 3 4 5 6 7 1 2 ===⇒ -2 -2 -2 -2 -2  5  5 ===⇒ 5 5 5 5 5 5 5
// 4 5 6 7 1 2 3 ===⇒ -3 -3 -3 -3  4  4  4 ===⇒ 4 4 4 4 4 4 4
// 5 6 7 1 2 3 4 ===⇒ -4 -4 -4  3  3  3  3 ===⇒ 3 3 3 3 3 3 3
// 6 7 1 2 3 4 5 ===⇒ -5 -5  2  2  2  2  2 ===⇒ 2 2 2 2 2 2 2
// 7 1 2 3 4 5 6 ===⇒ -6  1  1  1  1  1  1 ===⇒ 1 1 1 1 1 1 1
// 1 2 3 4 5 6 7 ===⇒  0  0  0  0  0  0  0 ===⇒ 0 0 0 0 0 0 0
//
// 결국 a-4 까지 수행후 오늘이 몇일이든지 모두 동일한 형태를 띄게
// 되고 이것으로 그 달의 시작위치는 동일하게 나오게 되는 것입니다.
// 숫자 0 ~ 6 이 의미하는 바가 바로 일요일 ~ 토요일이기 때문입니다.
//
// 왜 이렇게 자세하게 설명을 하느냐고 하시는 독자분도 계실 것입니다.
// 그건 이 코드를 분석하는 일이 중요한 것이 아니라 맨 처음에
// 이 알고리즘을 생각해 낸 사람의 노력이 어땠을까 하는 궁금증에서
// 출발한 것이며 또 그 사람의 노력에 경의를 표하고 싶기 때문입니다.
//
// 코드블럭 A 시작
// a-1
CalVar_BlankDatePos = CalVar_ThisDate;
// a-2
while (CalVar_BlankDatePos > 7)
{
	CalVar_BlankDatePos -= 7;
}
// a-3
CalVar_BlankDatePos = CalVar_ThisDay - CalVar_BlankDatePos + 1;
// a-4
if (CalVar_BlankDatePos < 0) CalVar_BlankDatePos += 7;
// 코드블럭 A 끝
/*
	행사 정보 관련 초기 수행부
*/
// 이달의 상황 테이블을 위한 객체 요소를 생성한다.
function DIFunc_StateCreate(DIVar_pLH, DIVar_pST, DIVar_pMD)
{// 매개변수로는 부울린 값(false, true)들이 넘어 온다.
	// 이 코드 만으로 변수가 생성되는 효과를 가져온다.
	// 배열 요소가 3개인 1차원 배열처럼
	// 3개의 변수를 하나의 객체로 관리합니다.
	// 모두 값들의 형태가 부울린 형태로 같기 때문에
	// 1차원 배열로 생각하셔도 됩니다.
	this.DIVar_pLH = DIVar_pLH;
    this.DIVar_pST = DIVar_pST;
    this.DIVar_pMD = DIVar_pMD;
}
// 이달의 총 날짜수를 구한다.
DIVar_jCount = CalVar_MonthDays[CalVar_TodayDate.getMonth()];
// 이달의 상황 테이블을 날짜수 만큼 요소를 생성하여 초기값을 부여한다.
for(DIVar_iCount = 0; DIVar_iCount < DIVar_jCount; DIVar_iCount++)
	DIVar_ThisMonthStateTable[DIVar_iCount] = 
		new DIFunc_StateCreate(false, false, false);
// 정보 테이블 구조체를 생성한다.
function DIFunc_InfoCreate(DIVar_pYear, DIVar_pMonth, DIVar_pDay,
						   DIVar_pTxtHTML)
{
	// 여기서 구조체는 년,월,일,내용 의 요소로 구성됩니다.
	// 각 정보(국경일, 절기, 기념일) 데이타는 모두
	// 동일한 구조를 지니고 있으므로 이 생성자 함수를
	// 모두 이용하여 각각의 자기들 요소를 만들어 냅니다.
	// 각 요소들이 모두 같은 형태의 값들이 아니기
	// 때문에 구조체로 표현을 하였을 뿐
	// 단순히 배열로 생각하셔도 됩니다.
	this.DIVar_pYear = DIVar_pYear;
	this.DIVar_pMonth = DIVar_pMonth;
	this.DIVar_pDay = DIVar_pDay;
	this.DIVar_pTxtHTML = DIVar_pTxtHTML;
}
// 국경일, 공휴일 정보 데이블을 생성한다.
// DIVar_InfoTableLH.length 는 요소가 하나 생길 때마다
// 자동으로 증가하는 내부 포인터를 접근합니다.
// 없을 때는 0값을 돌려주겠지요. 하나가 생성되면
// 1을 반환하여 주고요. 그러니 배열 첨자에
// 써 주기만 하면 자동으로 다음 들어갈 위치를
// 가리키는 효과를 가지게 됩니다.
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2003, 12, 25, "성탄절");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 1, 1, "신정");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 1, 21, "설날 연휴");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 1, 22, "설날 연휴");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 1, 23, "설날 연휴");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 3, 1, "3.1 절");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 4, 5, "식목일");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 5, 5, "어린이날");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 5, 26, "석가탄신일");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 6, 6, "현충일");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 7, 17, "제헌절");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 8, 15, "광복절");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 9, 27, "추석 연휴");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 9, 28, "추석 연휴");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 9, 29, "추석 연휴");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 10, 3, "개천절");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 12, 25, "성탄절");
// 절기(세시풍속 포함) 정보 테이블을 생성한다.
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2003, 11, 8, "입동");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2003, 11, 23, "소설");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2003, 12, 7, "대설");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2003, 12, 22, "동지");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 1, 6, "소한");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 1, 21, "대한");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 2, 4, "입춘");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 2, 5, "정월 대보름");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 2, 19, "우수");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 3, 5, "경칩");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 3, 20, "춘분");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 4, 4, "청명");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 4, 5, "한식");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 4, 20, "곡우");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 5, 5, "입하");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 5, 21, "소만");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 6, 5, "망종");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 6, 21, "하지");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 6, 22, "단오");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 7, "소서");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 20, "초복");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 22, "대서");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 30, "중복");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 31, "유두");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 8, 7, "입추");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 8, 9, "말복");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 8, 22, "칠월칠석");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 8, 23, "처서");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 9, 7, "백로");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 9, 23, "추분");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 10, 8, "한로");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 10, 22, "중앙절");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 10, 23, "상강");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 11, 7, "입동");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 11, 22, "소설");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 12, 7, "대설");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 12, 21, "동지");
// 기념일 정보 테이블을 생성한다.
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 11, 3, "학생의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 11, 9, "소방의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 11, 17, "순국선열의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 11, 30, "무역의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 12, 3, "소비자보호의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 12, 5, "국민교육헌장선포 기념일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 12, 10, "세계인권선언 기념일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 3, 3, "납세자의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 3, 17, "상공의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 3, 22, "물의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 3, 23, "기상의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 3, "향토예비군의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 7, "보건의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 13, "임시정부수립 기념일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 19, "4.19 혁명 기념일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 20, "장애인의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 21, "과학의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 22, "정보통신의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 25, "법의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 28, "충무공 탄신일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 1, "근로자의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 8, "어버이날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 15, "스승의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 17, "성년의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 18, "5.18 민주화운동 기념일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 19, "발명의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 25, "방재의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 31, "바다의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 6, 5, "환경의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 6, 25, "6.25 사변일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 9, 7, "사회복지의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 9, 18, "철도의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 9, 27, "관광의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 1, "국군의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 2, "노인의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 8, "재향군인의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 9, "한글날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 15, "체육의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 20, "문화의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 21, "경찰의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 24, "국제연합일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 26, "저축의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 27, "대한적십자사창립 기념일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 28, "교정의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 30, "항공의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 3, "학생의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 9, "소방의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 11, "농업인의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 17, "순국선열의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 30, "무역의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 12, 3, "소비자의 날");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 12, 5, "국민교육헌장선포 기념일");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 12, 10, "세계인권선언 기념일");
// 국경일 정보 테이블로부터 이달의 정보가 있는지를 파악하여
// 이달 상황 테이블에 유무(true, false)를 표시하여 준다.
for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableLH.length; 
	DIVar_iCount++)
{
	if((DIVar_InfoTableLH[DIVar_iCount].DIVar_pYear == 
		CalVar_TodayDate.getYear()) &&
	   (DIVar_InfoTableLH[DIVar_iCount].DIVar_pMonth == 
	    (CalVar_TodayDate.getMonth() + 1)))
	{// 이번 달에 정보가 있다면 표시한다.
		DIVar_ThisMonthStateTable[
		DIVar_InfoTableLH[DIVar_iCount].DIVar_pDay - 1].DIVar_pLH = true;
	}
}
// 절기 정보 테이블로부터 이달의 정보가 있는지를 파악하여
// 이달 상황 테이블에 유무(true, false)를 표시하여 준다.
for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableST.length; 
	DIVar_iCount++)
{
	if((DIVar_InfoTableST[DIVar_iCount].DIVar_pYear == 
		CalVar_TodayDate.getYear()) &&
	   (DIVar_InfoTableST[DIVar_iCount].DIVar_pMonth == 
		(CalVar_TodayDate.getMonth() + 1)))
	{// 이번 달에 정보가 있다면 표시한다.
		DIVar_ThisMonthStateTable[
		DIVar_InfoTableST[DIVar_iCount].DIVar_pDay - 1].DIVar_pST = true;
	}
}
// 기념일 정보 테이블로부터 이달의 정보가 있는지를 파악하여
// 이달 상황 테이블에 유무(true, false)를 표시하여 준다.
for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableMD.length; 
	DIVar_iCount++)
{
	if((DIVar_InfoTableMD[DIVar_iCount].DIVar_pYear == 
		CalVar_TodayDate.getYear()) &&
	   (DIVar_InfoTableMD[DIVar_iCount].DIVar_pMonth == 
	    (CalVar_TodayDate.getMonth() + 1)))
	{// 이번 달에 정보가 있다면 표시한다.
		DIVar_ThisMonthStateTable[
		DIVar_InfoTableMD[DIVar_iCount].DIVar_pDay - 1].DIVar_pMD = true;
	}
}
/*
	함수 선언부
*/
// 해당일에 해당하는 정보 데이타가 있는지를 판별한다.
// 3가지 종류 중 하나라도 있기만 하면 있는 것으로 간주한다.
// 결과는 반환값으로 돌려준다.
function DIFunc_IsExistDateInfo(DIVar_pDay)
{
	DIVar_bExist = false;

	if((DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pLH == true) ||
	   (DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pST == true) ||
	   (DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pMD == true))
		DIVar_bExist = true;

	return 	DIVar_bExist;
}
// 해당일의 해당 행사의 내용을 얻어내는 기능을 수행한다.
function DIFunc_FindInfoString(DIVar_fsKindOfDate, DIVar_fsDay)
{
	var DIVar_FindString = "";

	if(DIVar_fsKindOfDate == 1)
	{// 국경일인경우 국경일 정보 테이블을 검색한다.
		for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableLH.length; 
			DIVar_iCount++)
		{
			if((DIVar_InfoTableLH[DIVar_iCount].DIVar_pYear == 
				CalVar_TodayDate.getYear()) &&
			   (DIVar_InfoTableLH[DIVar_iCount].DIVar_pMonth == 
			    (CalVar_TodayDate.getMonth() + 1)) &&
			   (DIVar_InfoTableLH[DIVar_iCount].DIVar_pDay == 
			    DIVar_fsDay))
				DIVar_FindString = 
					DIVar_InfoTableLH[DIVar_iCount].DIVar_pTxtHTML;
		}		
	}
	else if(DIVar_fsKindOfDate == 2)
	{// 절기인경우 절기 정보 테이블을 검색한다.
		for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableST.length; 
			DIVar_iCount++)
		{
			if((DIVar_InfoTableST[DIVar_iCount].DIVar_pYear == 
				CalVar_TodayDate.getYear()) &&
			   (DIVar_InfoTableST[DIVar_iCount].DIVar_pMonth == 
				(CalVar_TodayDate.getMonth() + 1)) &&
			   (DIVar_InfoTableST[DIVar_iCount].DIVar_pDay == 
				DIVar_fsDay))
				DIVar_FindString = 
					DIVar_InfoTableST[DIVar_iCount].DIVar_pTxtHTML;
		}		
	}
	else if(DIVar_fsKindOfDate == 3)
	{// 기념일인경우 기념일 정보 테이블을 검색한다.
		for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableMD.length; 
			DIVar_iCount++)
		{
			if((DIVar_InfoTableMD[DIVar_iCount].DIVar_pYear == 
				CalVar_TodayDate.getYear()) &&
			   (DIVar_InfoTableMD[DIVar_iCount].DIVar_pMonth == 
				(CalVar_TodayDate.getMonth() + 1)) &&
			   (DIVar_InfoTableMD[DIVar_iCount].DIVar_pDay == 
				DIVar_fsDay))
				DIVar_FindString = 
				DIVar_InfoTableMD[DIVar_iCount].DIVar_pTxtHTML;
		}		
	}
	// 얻어진 내용을 반환한다.
	return DIVar_FindString;
}
// 해당일에 있는 행사의 내용을 모두 읽어 조합 문자열을 생성한다.
function DIFunc_GetInfoHTML(DIVar_pDay)
{
	var DIVar_ResultHTML = "";
	var DIVar_WhatInserted = 0;

	if(DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pLH == true)
	{// 국경일 정보가 있다면 검색하여 문자열을 덧붙인다.
		DIVar_ResultHTML += DIFunc_FindInfoString(1, DIVar_pDay);
		// 국경일 정보 문자열이 첨가되었음을 표시한다.
		DIVar_WhatInserted = 1;
	}
	if(DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pST == true)
	{// 절기 정보가 있다면 검색하여 문자열을 덧붙인다.
		// 국경일 정보 문자열이 첨가되었다면 구분자를 덧붙인다.
		if(DIVar_WhatInserted == 1)
			DIVar_ResultHTML += "<br>";

		DIVar_ResultHTML += DIFunc_FindInfoString(2, DIVar_pDay);
		DIVar_WhatInserted = 2;
	}
	if(DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pMD == true)
	{// 기념일 정보가 있다면 검색하여 문자열을 덧붙인다.
		// 국경일 또는 절기 정보 문자열이 첨가되었다면 구분자를 덧붙인다.
		if((DIVar_WhatInserted == 1) || (DIVar_WhatInserted == 2))
			DIVar_ResultHTML += "<br>";

		DIVar_ResultHTML += DIFunc_FindInfoString(3, DIVar_pDay);
	}
	// 조합된 문자열을 반환한다.
	return 	DIVar_ResultHTML;
}
// 해당일에 표시될 아이콘을 찾아 그 경로와 이름을 반환한다.
function DIFunc_GetIconImageName(DIVar_pDay, DIVar_bToday)
{
	// 이달 상황 테이블에서 해당일에 관련된 정보가 있는지를 얻어낸다.
	DIVar_bLH = DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pLH;
	DIVar_bST = DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pST;
	DIVar_bMD = DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pMD;
	// 모든 아이콘 이미지의 경로
	DIVar_ImagePath = USERCONFIG_MH_IconImagePath;
	// 오늘일 경우 사용될 이미지의 접두어
	DIVar_TodayPrefix = USERCONFIG_MH_IconImagePrefix;
	DIVar_ImageSrc = "";

	if(DIVar_bLH == false)
	{// 0 - 국경일 정보가 없는 경우를 말한다.
		if(DIVar_bST == false)
		{// 0 - 절기 정보가 없는 경우를 말한다.
			if(DIVar_bMD == false)
			{// 0 - 기념일 정보가 없는 경우를 말한다.
				// 0 0 0
				// 이 경우의 이미지는 사용되지 않는다.
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[0];
			}
			else
			{// 1 - 기념일 정보가 있는 경우를 말한다.
				// 0 0 1
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[1];
			}
		}
		else
		{// 1 0 - 절기 정보가 있는 경우를 말한다.
			if(DIVar_bMD == false)
			{// 0 - 기념일 정보가 없는 경우를 말한다.
				// 0 1 0
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[2];
			}
			else
			{// 1 - 기념일 정보가 있는 경우를 말한다.
				// 0 1 1
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[3];
			}
		}
	}
	else
	{// 1  - 국경일 정보가 있는 경우를 말한다.
		if(DIVar_bST == false)
		{// 0 0 - 절기 정보가 없는 경우를 말한다.
			if(DIVar_bMD == false)
			{// 0 - 기념일 정보가 없는 경우를 말한다.
				// 1 0 0
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[4];
			}
			else
			{// 1 - 기념일 정보가 있는 경우를 말한다.
				// 1 0 1
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[5];
			}
		}
		else
		{// 1 0 - 절기 정보가 있는 경우를 말한다.
			if(DIVar_bMD == false)
			{// 0 - 기념일 정보가 없는 경우를 말한다.
				// 1 1 0
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[6];
			}
			else
			{// 1 - 기념일 정보가 있는 경우를 말한다.
				// 1 1 1
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[7];
			}
		}
	}
	// 만약 찾고자 하는 날짜가 바로 오늘이라면 다른 이미지를
	// 사용하여야 하므로 경로와 이름 사이에 구분 접두어를 첨가한다.
	// 여기서 이미지들의 위치는 다음과 같다.
	//		./Image/CalEllipseGIFIcon_xx.gif		(오늘이 아닐 경우)
	//		./Image/Today_CalEllipseGIFIcon_xx.gif	(오늘이 맞을 경우)
	if(DIVar_bToday == true)	
		DIVar_ImageSrc = DIVar_ImagePath + DIVar_TodayPrefix +
						 DIVar_ImageSrc;
	else
		DIVar_ImageSrc = DIVar_ImagePath + DIVar_ImageSrc;
	// 이미지 소스 결과값을 반환한다.
	return DIVar_ImageSrc;
}
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 MAIN HEADER 스크립트 CODE END
///////////////////////////////////////////////////////////////////////////////
*/