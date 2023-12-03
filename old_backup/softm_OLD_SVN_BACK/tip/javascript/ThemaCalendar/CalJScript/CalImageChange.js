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
// 달력 이미지 교체 스크립트 GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(2003-12-05 수정관련 설명)
		이번에 새로 업데이트를 하면서 이부분이 제일 많이
		수정이 되었습니다.
		사용자가 설정할 수 있는 값들은 환경설정 부분에
		제공되며 여기서는 그 값들을 바탕으로 수행됩니다.
		그리고 이미지 교체 알고리즘도 조금 바뀌었습니다.
		간단히 설명을 드리겠습니다.

		우선, 테마를 2 단계로 세분화를 시켰습니다.
		큰 테마를 기준으로 작은 테마들이 있도록 하였습니다.
		예를들면, 자연테마를 큰 테마로 분류한다면
		그 아래로 산테마, 강테마, 숲테마 등등
		표현될 수 있습니다. 이러한 정보는
		이용자가 환경설정 스크립트에서 작성할 수 있습니다.

		알고리즘을 설명 드리겠습니다.
		달력 로드시 우선 자동으로 큰 테마가 선택됩니다.
		이후에 타이머 시간마다 선택된 큰 테마내에
		있는 작은 테마들 중 하나를 무작위로 선택합니다.
		선택된 작은 테마내에 있는 이미지들이 모두
		적어도 한 번 보여질 때까지 타임루프를 수행합니다.
		만약 다 보여졌다면 다시 큰 테마내에 있는
		작은 테마들 중 또 무작위로 테마를 선정합니다.
		이하 작은 테마내의 이미지들에 대해서는 위의
		경우처럼 반복합니다.
		큰 테마내에 있는 작은 테마들 모두가
		적어도 한 번은 보여졌다면 모든 상태 정보를
		초기화하고 처음 로드시와 같은 환경에서
		똑같은 과정을 반복 수행합니다.
		결국은 선택된 큰 테마내의 모든 이미지들이
		다 보여지게 되는 과정을 무한 반복하게 됩니다.

		여기에, 사용자가 큰 테마를 선택해서 볼 수 있도록
		아이콘 메뉴를 제공했습니다. 다른 큰 테마를 선택하면
		자동으로 이미지 교체 수행을 사용자가 선택한
		큰 테마내의 이미지에 적용을 하게 됩니다.

		알고리즘을 말로라도 설명을 드리는 건
		혹 소스를 분석하는 분에게는 큰 가이드라인이
		될 수 있기 때문입니다.

		이 알고리즘 때문에 소스가 상당히 커지게 되었습니다.
		에러는 제가 생각한 것보다 빨리 잡을 수 있었습니다.
		하지만 모든 가능성을 체크하지 못하였으므로
		에러가 생긴다면 자체 해결을 하시던지
		저한테 메일 또는 홈게시판에 남겨 주시면 답변 드리겠습니다.

		수정 코드에 대한 설명은 코드내 주석으로 대치하도록
		하겠습니다.
(설명)
		달력 이미지 교체 스크립트입니다.
		특징이라면 페이지가 로드될 때마다 테마가 결정되며
		또한 일정 시간마다 테마내의 이미지들이
		자동 교체되어 보인다는 것입니다.
		사용된 효과로는 <IMG> 객체의 필터링 효과를
		이용하였습니다. 사용되는 이미지는 사용 전
		모두 메모리로 로딩되어 매번 변화되는 부하를
		줄이고 있으며 각 이미지의 사이즈는
		160 * 150 으로 동일합니다.
(변수)
		CalImageVar_RanValue : 테마내의 이미지를 결정하는 랜덤 변수
		//CalImageVar_SelectedTheme : 테마를 결정하는 랜덤 변수
		CalImageVar_ThemePath : 각 테마별 이미지 경로의 접두어 배열
		CalImageVar_ThemeImageNums : 각 테마별 이미지의 갯수 배열
		CalImageVar_PreloadedImages : 선택된 테마의 이미지들을 담고 있는 배열
		CalImageVar_blendObj : <IMG> 객체의 이름
(함수)
		function CalImageFunc_Changer();

		<기능>
			미리 결정된 테마 변수를 이용하여 해당 테마내의 이미지들을
			자동으로 일정 시간마다 교체하여 주는 함수입니다.
			타이머를 이용하였고 이미지의 필터링 효과를 이용하였습니다.
(용법)
		위의 CalImageFunc_Changer() 이미지 교체 함수를
		HTML 문서의 <BODY> 태그의 onload 이벤트에서
		호출되도록 코드를 넣어 주시면 됩니다.
(수정)
		수정 가능한 정보로는 다음과 같은 것들이 있습니다.

		CalImageVar_ThemePath : 각 테마별 이미지 경로 접두어
		CalImageVar_ThemeImageNums : 각 테마별 이미지 갯수

		이 두 배열의 값을 서로 매칭되도록 수정해야 합니다.

		setTimeout("CalImageFunc_Changer()", 10000);

		타이머를 현재 10초(10000)에서 적절히 변경합니다.

		이미지 교체 필터링 효과에 대해서는
		blendTrans(duration=3); 함수 대신
		revealTrans(Transition=6, Duration=3);
		함수로 교체하여 사용하셔도 됩니다.
		Transition 값을 변경하시면 다른 효과를 보실 수 있습니다.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 이미지 교체 스크립트 CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	전역변수 선언부 및 초기 수행부
*/
var CalImageVar_RanValue = 0;
// 사용자가 외부 인터페이스로부터 큰 테마를 선택하였는지의 여부
var CalImageVar_bUserSelectBigThema = false;
// 사용자가 외부 인터페이스로부터 선택한 큰 테마 번호
var CalImageVar_iUserSelectBigThema = -1;

// 테마 이미지들의 경로 + 접두어 정보를 로딩
var CalImageVar_ThemePath = new Array(USERCONFIG_IC_ThemaImagePrefix.length);

for(CalImageVar_iiCount = 0;
	CalImageVar_iiCount < USERCONFIG_IC_ThemaImagePrefix.length;
	CalImageVar_iiCount++)
	CalImageVar_ThemePath[CalImageVar_iiCount] = 
		USERCONFIG_IC_ThemaImagePrefix[CalImageVar_iiCount];
// 테마 이미지들의 개수 정보를 로딩
var CalImageVar_ThemeImageNums = new Array(USERCONFIG_IC_ThemaImagePrefix.length);

for(CalImageVar_iiCount = 0;
	CalImageVar_iiCount < USERCONFIG_IC_ThemaImagePrefix.length;
	CalImageVar_iiCount++)
	CalImageVar_ThemeImageNums[CalImageVar_iiCount] = 
		USERCONFIG_IC_ThemaImageNums[CalImageVar_iiCount];
// 큰 테마 분류 이름 정보들을 로딩
var CalImageVar_ThemaKindNames = new Array(USERCONFIG_IC_ThemaKindNames.length);

for(CalImageVar_iiCount = 0;
	CalImageVar_iiCount < USERCONFIG_IC_ThemaKindNames.length;
	CalImageVar_iiCount++)
	CalImageVar_ThemaKindNames[CalImageVar_iiCount] = 
		USERCONFIG_IC_ThemaKindNames[CalImageVar_iiCount];
// 큰 테마 분류의 개수 정보들을 로딩
var CalImageVar_ThemaKindNums = new Array(USERCONFIG_IC_ThemaKindNames.length);

for(CalImageVar_iiCount = 0;
	CalImageVar_iiCount < USERCONFIG_IC_ThemaKindNames.length;
	CalImageVar_iiCount++)
	CalImageVar_ThemaKindNums[CalImageVar_iiCount] = 
		USERCONFIG_IC_ThemaKindNums[CalImageVar_iiCount];
// 처음 시작될 디폴트 큰 테마 분류를 선택 지정
var CalImageVar_SelectedThemaValue = 0;

CalImageVar_SelectedThemaValue = Math.round(Math.floor(
	CalImageVar_ThemaKindNames.length * Math.random()));

// 각종 상태 테이블 생성 및 초기화

// 큰 분류내 작은 테마들의 가지수 최대값을 이용하여
// 현재 테마가 사용되고 있는지 여부의 상태값을 유지한다.
var CalImageVar_istMaxValue = 0;

for(CalImageVar_iiCount = 0;
	CalImageVar_iiCount < CalImageVar_ThemaKindNums.length;
	CalImageVar_iiCount++)
	if(CalImageVar_ThemaKindNums[CalImageVar_iiCount] > CalImageVar_istMaxValue)
		CalImageVar_istMaxValue = CalImageVar_ThemaKindNums[CalImageVar_iiCount];

var CalImageVar_STableOfSmallThema = new Array(CalImageVar_istMaxValue);

for(CalImageVar_iiCount = 0;
	CalImageVar_iiCount < CalImageVar_STableOfSmallThema.length;
	CalImageVar_iiCount++)
	CalImageVar_STableOfSmallThema[CalImageVar_iiCount] = false;
// 작은 테마내 이미지들의 개수 최대값을 이용하여
// 현재 이미지가 사용되었는지의 여부의 상태값을 유지한다.
var CalImageVar_itmMaxValue = 0;

for(CalImageVar_iiCount = 0;
	CalImageVar_iiCount < CalImageVar_ThemeImageNums.length;
	CalImageVar_iiCount++)
	if(CalImageVar_ThemeImageNums[CalImageVar_iiCount] > CalImageVar_itmMaxValue)
		CalImageVar_itmMaxValue = CalImageVar_ThemeImageNums[CalImageVar_iiCount];

var CalImageVar_STableOfAlreadyViewed = new Array(CalImageVar_itmMaxValue);

for(CalImageVar_iiCount = 0;
	CalImageVar_iiCount < CalImageVar_STableOfAlreadyViewed.length;
	CalImageVar_iiCount++)
	CalImageVar_STableOfAlreadyViewed[CalImageVar_iiCount] = false;
// 작은 테마내의 이미지들 중 개수 최대값을 이용하여
// 미리 이미지 프리로딩을 위한 충분한 메모리 공간을 확보해 놓는다.
var CalImageVar_PreloadedImages = new Array(CalImageVar_itmMaxValue);

for (CalImageVar_iCount = 0; CalImageVar_iCount < CalImageVar_itmMaxValue;
	 CalImageVar_iCount++)
	CalImageVar_PreloadedImages[CalImageVar_iCount] = new Image();
// 각종 상태값 변수들
var CalImageVar_bsIsSelectedSmallThema = false;
var CalImageVar_bsIsLockedSmallThema = false;
var CalImageVar_isSelThemaNumber = -1;
/*
	함수 선언부
*/
// 테마 선택 윈도우에 뿌려질 문자열을 만드는 함수
function CalImageFunc_MakeThemaSelWMsgHTML()
{
	var CalImageVar_tmpString = "";

	CalImageVar_tmpString += "같은 것을 계속 보려니<br>";
	CalImageVar_tmpString += "-.- 지겹, 지루, 짜증 -.-<br>";
	CalImageVar_tmpString += "다른 테마를 선택하세요<br><br>";
	
	for(CalImageVar_iiCount = 0;
		CalImageVar_iiCount < CalImageVar_ThemaKindNames.length;
		CalImageVar_iiCount++)
	{
		if(CalImageVar_iiCount == CalImageVar_SelectedThemaValue)
		{
			CalImageVar_tmpString += "☞ ";
			CalImageVar_tmpString += "<a href='javascript:CalImageFunc_UserChangeBigThema(";
			CalImageVar_tmpString += CalImageVar_iiCount + ");ThemaSelFunc_ShowPopUp();'>";
			CalImageVar_tmpString += "<font color=red><b>";
			CalImageVar_tmpString += CalImageVar_ThemaKindNames[CalImageVar_iiCount] + "";
			CalImageVar_tmpString += "</b></font></a><br>";
		}
		else
		{
			CalImageVar_tmpString += "<a href='javascript:CalImageFunc_UserChangeBigThema(";
			CalImageVar_tmpString += CalImageVar_iiCount + ");ThemaSelFunc_ShowPopUp();'>";
			CalImageVar_tmpString += CalImageVar_ThemaKindNames[CalImageVar_iiCount] + "";
			CalImageVar_tmpString += "</a><br>";
		}
	}
	
	return CalImageVar_tmpString;
}
// 테마 선택 윈도우에 뿌려질 문자열을 얻는 함수
function CalImageFunc_GetThemaSelWMsgHTML()
{
	return CalImageFunc_MakeThemaSelWMsgHTML();
}
// 작은 테마 사용 여부 판별 테이블을 초기화 하는 함수
function CalImageFunc_InitializeStatusTT()
{
	// 작은 테마들이 선택된 적이 있는지의 여부를 판별하는 테이블 초기화
	for(CalImageVar_iiCount = 0;
		CalImageVar_iiCount < CalImageVar_STableOfSmallThema.length;
		CalImageVar_iiCount++)
		CalImageVar_STableOfSmallThema[CalImageVar_iiCount] = false;
}
// 이미지 사용 여부 판별 테이블을 초기화 하는 함수
function CalImageFunc_InitializeStatusIT()
{
	// 테마내 이미지들이 보여진 적이 있는지의 여부를 판별하는 테이블 초기화
	for(CalImageVar_iiCount = 0;
		CalImageVar_iiCount < CalImageVar_STableOfAlreadyViewed.length;
		CalImageVar_iiCount++)
		CalImageVar_STableOfAlreadyViewed[CalImageVar_iiCount] = false;
}
// 상태값 초기화 함수
function CalImageFunc_InitializeStatus()
{
	// 작은 테마들이 선택된 적이 있는지의 여부를 판별하는 테이블 초기화
	CalImageFunc_InitializeStatusTT();
	// 테마내 이미지들이 보여진 적이 있는지의 여부를 판별하는 테이블 초기화
	CalImageFunc_InitializeStatusIT();
	// 선택된 작은 테마 번호를 저장하는 상태 변수
	CalImageVar_isSelThemaNumber = -1;
	// 작은 테마 잠금 정보를 디폴트(false)로 설정
	CalImageVar_bsIsLockedSmallThema = false;
	// 큰 테마에 대한 처음 수행임을 표시
	//CalImageVar_bsIsSelectedSmallThema == false;
}

// 작은 테마내 이미지들에 대한 선택 여부 판별 테이블 접근 함수 : Get_()
// CalImageVar_iPosValue : 테마내 이미지 위치값
function CalImageFunc_GetSmallThemaImageStatus(CalImageVar_iPosValue)
{
	return CalImageVar_STableOfAlreadyViewed[CalImageVar_iPosValue];
}
// 작은 테마내 이미지들에 대한 선택 여부 판별 테이블 접근 함수 : Set_()
// CalImageVar_iPosValue : 테마내 이미지 위치값
// CalImageVar_bValue : 부울린 값
function CalImageFunc_SetSmallThemaImageStatus(CalImageVar_iPosValue, CalImageVar_bValue)
{
	CalImageVar_STableOfAlreadyViewed[CalImageVar_iPosValue] = CalImageVar_bValue;
}

// 작은 테마들에 대한 선택 여부 판별 테이블 접근 함수 : Get_()
// CalImageVar_iPosValue : 큰 테마내 가상 위치값
function CalImageFunc_GetSmallThemaStatus(CalImageVar_iPosValue)
{
	return CalImageVar_STableOfSmallThema[CalImageVar_iPosValue];
}
// 작은 테마들에 대한 선택 여부 판별 테이블 접근 함수 : Set_()
// CalImageVar_iPosValue : 큰 테마내 가상 위치값
// CalImageVar_bValue : 부울린 값
function CalImageFunc_SetSmallThemaStatus(CalImageVar_iPosValue, CalImageVar_bValue)
{
	CalImageVar_STableOfSmallThema[CalImageVar_iPosValue] = CalImageVar_bValue;
}
// 작은 테마 선택 함수
function CalImageFunc_DecideSmallThema()
{
	var CalImageVar_tmpValue = 0;
	var CalImageVar_tmpTotalValue = 0;
	
	// 큰 테마를 기준으로 랜덤수를 발생시킨다.
	// 만일 큰 테마내에 5 개의 작은 테마들이 있다면
	// 0 - 4 값을 갖는 랜덤수를 발생시킨다.
	CalImageVar_tmpValue = Math.round(Math.floor(
		CalImageVar_ThemaKindNums[CalImageVar_SelectedThemaValue] *
		Math.random()));
	// 이 랜덤수는 큰 테마내의 가상의 순서이기 때문에
	// 이를 작은 테마 테이블의 절대적인 순서값으로 변환을
	// 수행한다.
	for(CalImageVar_iiCount = 0; 
		CalImageVar_iiCount < CalImageVar_SelectedThemaValue;
		CalImageVar_iiCount++)
			CalImageVar_tmpTotalValue += CalImageVar_ThemaKindNums[CalImageVar_iiCount];
	// 위에서 구한 두가지 가상 순서값과 앞에 배열된 테마들의 개수값을
	// 더해 실제 테마의 절대적인 배열 위치값을 산출한다.
	CalImageVar_isSelThemaNumber = CalImageVar_tmpValue + 
		CalImageVar_tmpTotalValue;
	// 실제로 출력될 테마가 결정되었으므로 상태 테이블에 이를 표시한다.
	CalImageFunc_SetSmallThemaStatus(CalImageVar_tmpValue, true);
}
// 사용될 이미지지들을 미리 메모리로 로드하는 함수
function CalImageFunc_PreloadUsingImages()
{
	for (CalImageVar_iCount = 0; 
		 CalImageVar_iCount < 
		 CalImageVar_ThemeImageNums[CalImageVar_isSelThemaNumber];
		 CalImageVar_iCount++)
	{
		CalImageVar_TmpSrcNum = CalImageVar_iCount + 1;

		if(CalImageVar_TmpSrcNum < 10)
			CalImageVar_TmpSrcName = 
				CalImageVar_ThemePath[CalImageVar_isSelThemaNumber] + "0" +
				CalImageVar_TmpSrcNum + USERCONFIG_IC_ThemaImageSuffix;
		else
			CalImageVar_TmpSrcName = 
				CalImageVar_ThemePath[CalImageVar_isSelThemaNumber] + 
				CalImageVar_TmpSrcNum + USERCONFIG_IC_ThemaImageSuffix;

		CalImageVar_PreloadedImages[CalImageVar_iCount].src = 
			CalImageVar_TmpSrcName;
	}
}
// 작은 테마내 모든 이미지들이 사용되었는지를 판별하는 함수
function CalImageFunc_CheckIsAllImageUsed()
{
	var CalImageVar_bAllUsed = true;

	for(CalImageVar_iiCount = 0; 
		CalImageVar_iiCount < CalImageVar_ThemeImageNums[CalImageVar_isSelThemaNumber];
		CalImageVar_iiCount++)
		if(CalImageFunc_GetSmallThemaImageStatus(CalImageVar_iiCount) == false)
		{
			CalImageVar_bAllUsed = false;
			break;
		}

	return CalImageVar_bAllUsed;
}
// 작은 테마내 모든 이미지들이 사용되었는지를 판별하는 함수
function CalImageFunc_CheckIsAllSmallThemaUsed()
{
	var CalImageVar_bAllUsed = true;

	for(CalImageVar_iiCount = 0; 
		CalImageVar_iiCount < CalImageVar_ThemaKindNums[CalImageVar_SelectedThemaValue];
		CalImageVar_iiCount++)
		if(CalImageFunc_GetSmallThemaStatus(CalImageVar_iiCount) == false)
		{
			CalImageVar_bAllUsed = false;
			break;
		}

	return CalImageVar_bAllUsed;
}
// 이용자가 큰 테마 분류에 대한 선택을 수행한 경우의 처리 함수
function CalImageFunc_UserChangeBigThema(CalImageVar_iUserSelThema)
{
	// 사용자가 선택한 큰 테마와 현재 보여지고 있는 큰 테마를 비교한다.
	// 만일 같다면 아무일도 수행하지 않는다.
	if(CalImageVar_iUserSelThema == CalImageVar_SelectedThemaValue)
		return;

	// 사용자가 새로운 큰 분류의 테마를 선택한 것이라면
	// 기존 이미지 갱신 과정과의 충돌을 방지하기 위해
	// 일시적으로 정보를 저장한다.
	CalImageVar_iUserSelectBigThema = CalImageVar_iUserSelThema;
	// 그리고 새로운 테마가 선정되었음을 표시한다.
	CalImageVar_bUserSelectBigThema = true;
}
// 메인 콘트롤 함수
function CalImageFunc_Changer()
{
	if(!document.all) return;

	// 사용자 외부 인터페이스로부터 선택된 새로운 테마가 있는지를 검사한다.
	if(CalImageVar_bUserSelectBigThema == true)
	{
		// 사용자가 선택한 큰 분류의 테마값을 반영한다.
		CalImageVar_SelectedThemaValue = CalImageVar_iUserSelectBigThema;
		// 이미지 교체 작업관련 모든 상태 변수들을 일괄 초기화한다.
		CalImageVar_bsIsSelectedSmallThema = false;

		// 다시 사용자 외부 인터페이스 감지 변수들을 초기화한다.
		CalImageVar_iUserSelectBigThema = -1;
		CalImageVar_bUserSelectBigThema = false;
	}

	// 처음 수행 상태로 어떤 테마도 선택되지 않은 경우라면
	// 필요한 초기화 과정을 수행한다.
	if(CalImageVar_bsIsSelectedSmallThema == false)
	{
		// 상태값(변수, 테이블)을 초기화한다.
		CalImageFunc_InitializeStatus();
		// 처음 수행인 초기화 과정을 마쳤음을 표시한다.
		CalImageVar_bsIsSelectedSmallThema = true;
	}

	// 이제 실제로 테마를 선택해야 할지를 결정한다.
	if(CalImageVar_bsIsLockedSmallThema == false)
	{
		// 작은 테마 사용 여부 점검 루틴이 들어간다.
		if(CalImageFunc_CheckIsAllSmallThemaUsed() == true)
		{
			// 작은 테마 사용 여부 판별 테이블 초기화
			CalImageFunc_InitializeStatusTT();
		}

		// 작은 테마를 선택한다.
		CalImageFunc_DecideSmallThema();
		// 테마가 선택되면 사용될 이미지들을 미리 로드한다.
		CalImageFunc_PreloadUsingImages();
		// 선택된 작은 테마에 대해 하위 이미지들을 지속적으로
		// 표시하기 위해 다른 작은 테마를 선택 못하도록
		// 일시적으로 잠근다.
		CalImageVar_bsIsLockedSmallThema = true;
	}

	// 이미지 사용 여부 상태 점검 루틴이 들어간다.
	if(CalImageFunc_CheckIsAllImageUsed() == true)
	{
		// 이미지 사용 여부 판별 테이블 초기화
		CalImageFunc_InitializeStatusIT();
		// 잠겨있는 작은 테마에 대한 락을 해제
		CalImageVar_bsIsLockedSmallThema = false;
	}

	// 이제 테마내의 표시할 실제 이미지를 결정한다.
	CalImageVar_RanValue = 
		Math.round(Math.floor(
			CalImageVar_ThemeImageNums[CalImageVar_isSelThemaNumber] *
			Math.random()));

	// 표시하기로 결정된 이미지에 대한 상태값을 설정한다.
	CalImageFunc_SetSmallThemaImageStatus(CalImageVar_RanValue, true);

	CalImageVar_blendObj.filters.blendTrans.apply();
	document.images.CalImageVar_blendObj.src = 
		CalImageVar_PreloadedImages[CalImageVar_RanValue].src;
	CalImageVar_blendObj.filters.blendTrans.play();

	setTimeout("CalImageFunc_Changer()", USERCONFIG_IC_TimeInterval);
}
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 이미지 교체 스크립트 CODE END
///////////////////////////////////////////////////////////////////////////////
*/