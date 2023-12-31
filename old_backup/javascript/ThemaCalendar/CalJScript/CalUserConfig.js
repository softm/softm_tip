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
// 테마 달력 환경설정 START
///////////////////////////////////////////////////////////////////////////////
*/
// (참고)
//		꼭 변경을 하고 싶은 분이나 자세한 수정을 원하시는 분은
//		스크립트 소스파일의 설명을 읽으시고 직접 수정하시길 바랍니다.
/*
+-------------------------------------+
+ 음력 계산 스크립트 환경설정
+-------------------------------------+
*/
// 설정할 사항 없음
/*
+-------------------------------------+
+ 달력 타이틀 스크립트 환경설정
+-------------------------------------+
*/
// 타이틀 변경 시간 간격 조절 (1/1000 초단위) 예) 1000 = 1 초
// 너무 짧은 시간을 주지 마시길 바랍니다.
// 애니메이션 효과에 무리가 없는 넉넉한 시간을 주시길 바랍니다.
var USERCONFIG_CT_TimeInterval = 7000;

// 타이틀을 변경하는 애니메이션 효과를 선택 (0 - 23)
// (값)
//		0  = Box in.
//		1  = Box out.
//		2  = Circle in.
//		3  = Circle out.
//		4  = Wipe up.
//		5  = Wipe down.
//		6  = Wipe right.
//		7  = Wipe left.
//		8  = Vertical blinds.
//		9  = Horizontal blinds.
//		10 = Checkerboard across.
//		11 = Checkerboard down.
//		12 = Random dissolve.
//		13 = Split vertical in.
//		14 = Split vertical out.
//		15 = Split horizontal in.
//		16 = Split horizontal out.
//		17 = Strips left down.
//		18 = Strips left up.
//		19 = Strips right down.
//		20 = Strips right up.
//		21 = Random bars horizontal.
//		22 = Random bars vertical.
//		23 = Random transition from above possible values.
var USERCONFIG_CT_TransitionVal = 6;

// 애니메이션 효과 적용이 끝나기 까지의 시간 (초단위) 예) 3.178 초
var USERCONFIG_CT_DurationVal = 3.0;
/*
+-------------------------------------+
+ 달력 이미지 교체 스크립트 환경설정
+-------------------------------------+
*/
// 이미지 변경 시간 간격 조절 (1/1000 초단위) 예) 1000 = 1 초
// 너무 짧은 시간을 주지 마시길 바랍니다.
// 애니메이션 효과에 무리가 없는 넉넉한 시간을 주시길 바랍니다.
var USERCONFIG_IC_TimeInterval = 10000;

// (조건)
//		1. 테마 종류의 개수와 각 테마당 이미지수 배열의 개수와 일치해야 한다.
//		2. 상대 경로를 사용할 경우는 소스(CalendarSrc.html)파일을 기준으로 한다.
//		3. 절대 경로를 사용할 경우는 http:// 으로 시작하는 전체 URL을 사용한다.
//		4. 각 테마내 이미지 파일명의 숫자는 01 - 09, 10 - ... 이런 식으로 지정한다.
//		   예) Image_01.jpg ... Image_02.jpg, Image_10.jpg ...
//		5. 테마는 적어도 한 개 이상이어야 한다.
//		6. 큰 테마 분류의 이름과 각 개수를 지정한다.
//		7. 큰 테마는 연속성이 있어야 한다.
//		   자연테마 No.1 다음에는 반드시 자연테마 No.2 가 와야한다.
//		   자연테마 No.1 부터 No.5 까지는 연속성이 있어야 한다.
//		8. 아래의 예처럼 순서를 서로 매칭되도록 작성한다.

// 테마에 사용될 이미지들의 경로 접두어를 설정합니다.
var USERCONFIG_IC_ThemaImagePrefix = 
		new Array(
			"Image/CalPreviewA_",			// 테마 A 경로 + 접두어	// 자연테마 No.1 (순서 = 1)
			"Image/CalPreviewB_",			// 테마 B 경로 + 접두어	// 자연테마 No.2
			"Image/CalPreviewC_",			// 테마 C 경로 + 접두어	// 사람테마 No.1 (순서 = 2)
			"Image/CalPreviewD_"			// 테마 D 경로 + 접두어	// 사람테마 No.2
		);
// 테마내 이미지들의 개수를 설정합니다.
var USERCONFIG_IC_ThemaImageNums = 
		new Array(
			3,								// 테마 A 이미지의 갯수	// 자연테마 No.1 (순서 = 1)
			3,								// 테마 B 이미지의 갯수	// 자연테마 No.2
			3,								// 테마 C 이미지의 갯수	// 사람테마 No.1 (순서 = 2)
			3								// 테마 D 이미지의 갯수	// 사람테마 No.2
		);
// 큰 테마의 분류 이름을 설정합니다.
var USERCONFIG_IC_ThemaKindNames = 
		new Array(
			"자연",							// 자연테마 이름 (순서 = 1)
			"사람"							// 사람테마 이름 (순서 = 2)
		);
// 큰 테마 분류의 개수를 설정합니다.
var USERCONFIG_IC_ThemaKindNums = 
		new Array(
			2,								// 자연테마 개수 (순서 = 1)
			2								// 사람테마 개수 (순서 = 2)
		);
// 테마에 사용되는 모든 이미지들의 확장자를 설정합니다.
var USERCONFIG_IC_ThemaImageSuffix = ".jpg";
/*
+-------------------------------------+
+ 달력 MAIN HEADER 스크립트 환경설정
+-------------------------------------+
*/
// 날짜 상황에 따른 아이콘에 대한 설명
//		테마 달력에서는 국경일, 절기, 기념일의 조합에 따라
//		각기 다른 아이콘을 표시하고 있습니다.
//		3 가지의 조합에 따른 8 가지 아이콘에
//		오늘일 경우와 아닐 경우의 가지수 2 를
//		곱한 총 16 개의 아이콘이 사용되고 있습니다.
//		어떤 날이 국경일(A색)이면서 절기(B색)이라면
//		A색과 B색이 번갈아 일정 간격으로 변화하는
//		움직이는 아이콘이 선택 표시됩니다.
//		제가 쓴 아이콘이 맘에 안 드실 수도 있어서
//		환경설정에 넣기는 하지만
//		웬만하면 그냥 사용하셔도 좋을 듯 싶습니다.

// 아이콘 이미지의 경로
//		상대경로 : CalendarSrc.html 기준
//		절대경로 : http:// 으로 시작하는 전체 URL
var USERCONFIG_MH_IconImagePath = "./Image/";
// 날짜 정보와 오늘이 겹칠 경우에 사용되는 아이콘 파일명의 접두어
var USERCONFIG_MH_IconImagePrefix = "Today_";
// 아이콘 파일명 (총 8개 = 개수는 고정)
var USERCONFIG_MH_IconImageFile = 
		new Array(						// 국경일, 절기, 기념일 (0=무, 1=유)
			"CalEllipseGIFIcon_00.gif",	//   0     0     0
			"CalEllipseGIFIcon_01.gif",	//   0     0     1
			"CalEllipseGIFIcon_02.gif",	//   0     1     0
			"CalEllipseGIFIcon_03.gif",	//   0     1     1
			"CalEllipseGIFIcon_04.gif",	//   1     0     0
			"CalEllipseGIFIcon_05.gif",	//   1     0     1
			"CalEllipseGIFIcon_06.gif",	//   1     1     0
			"CalEllipseGIFIcon_07.gif"	//   1     1     1
		);
/*
+-------------------------------------+
+ 날짜 툴팁 윈도우 스크립트 환경설정
+-------------------------------------+
*/
// 툴팁 윈도우 외곽선 색상을 지정합니다.
var USERCONFIG_TW_FrameBorderColor = "#DEDFDE";
// 툴팁 윈도우 바탕색 색상을 지정합니다.
var USERCONFIG_TW_FrameBkgrdColor = "white";
// 툴팁 윈도우 텍스트 색상을 지정합니다.
var USERCONFIG_TW_TextFontColor = "black";
/*
+-------------------------------------+
+ 테마 선택 윈도우 스크립트 환경설정
+-------------------------------------+
*/
// 테마 선택 윈도우 외곽선 색상을 지정합니다.
var USERCONFIG_TSW_FrameBorderColor = "#ff9900";
// 테마 선택 윈도우 바탕색 색상을 지정합니다.
var USERCONFIG_TSW_FrameBkgrdColor = "white";
// 테마 선택 윈도우 텍스트 색상을 지정합니다.
var USERCONFIG_TSW_TextFontColor = "black";
/*
+-------------------------------------+
+ 달력 타이틀 PRINT 스크립트 환경설정
+-------------------------------------+
*/
//	설정할 사항 없음
/*
+-------------------------------------+
+ 달력 MAIN PRINT 스크립트 환경설정
+-------------------------------------+
*/
//	설정할 사항 없음
/*
///////////////////////////////////////////////////////////////////////////////
// 테마 달력 환경설정 END
///////////////////////////////////////////////////////////////////////////////
*/