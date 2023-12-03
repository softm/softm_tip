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
// 날짜 툴팁 윈도우 스크립트 GUIDE
// 테마 선택 윈도우 스크립트 GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(2003. 12. 05. 수정관련 설명)
		테마 선택 윈도우 스크립트와 날짜 툴팁 윈도우 기능이
		모두 같기 때문에 같이 위치시켰습니다.
		마우스 이벤트 캡쳐 부분은 공통으로 사용하고 있습니다.
		바로 이 이유 때문에 짝지어 놓은 것입니다.
		다른 설명은 필요가 없을 것 같습니다.
(설명)
		날짜 툴팁 윈도우 스크립트입니다.
		<DIV> 객체를 이용하였으며 해당일의 정보들을 받아서
		출력하여 주는 일을 합니다. 이벤트에 반응하여
		툴팁 윈도우를 보여주고 숨겨주는 역할들을
		지니고 있습니다. 여기서 이벤트라 함은 마우스
		이벤트로 본문의 <TD> 태그 속성에서 마우스 이벤트를
		생성시킵니다. 바로 이 이벤트에 반응하게 되는
		것입니다.
(변수)
		ToolTipWindowID : 툴팁 윈도우 객체
		ToolTipVar_SkinWindow : 툴팁 윈도우 객체 (= ToolTipWindowID 와 동일)
(함수)
		function ToolTipFunc_ShowPopUp(ToolTipVar_MsgHTML);

		<기능>
			매개변수로 들어온 문자열을 특정 HTML 형식으로
			포맷하여 툴팁 윈도우에 뿌려주고 있습니다.
			그 다음에 툴팁 윈도우를 Visible 상태로 전환하여 줍니다.
		<매개변수>
			ToolTipVar_MsgHTML 는 해당일이 문서에 뿌려질 때
			이미 결정된 문자열로 이 문자열이 의미하는 바는
			국경일, 공휴일, 절기, 기념일 관련 정보입니다.
			자세한 설명은 후에 뒤에서 설명하도록 하겠습니다.

		function ToolTipFunc_HidePopUp();

		<기능>
			<TD> 태그의 onmouseover 이벤트에 반응하여 수행된
			ToolTipFunc_ShowPopUp() 함수에 의해 보여진
			툴팁 윈도우를 <TD> 태그의 onmouseout 이벤트에
			반응한 본 함수가 감추어 주는 역할을 수행하게 됩니다.

		function ToolTipFunc_GrapMouse(e);

		<기능>
			마우스 이벤트가 발생되어진 시점의 좌표를
			기준으로 툴팁 윈도우의 위치를 결정합니다.
			이를 위해 문서의 onmousemove 이벤트 객체에
			미리 등록되어 있습니다.
(용법)
		제 경우는 본문의 테이블 중 <TD> 태그 안에서
		onmouseover, onmouseout 이벤트에서 사용하고 있습니다.

		onmouseover="ToolTipFunc_ShowPopUp('출력 문자열');"
		onmouseover="ToolTipFunc_HidePopUp('출력 문자열');"

		형식으로 이용을 하시면 됩니다.
(수정)
		수정 가능한 정보로는 다음과 같은 것들이 있습니다.

		ToolTipVar_FrameHTML

		이것은 툴팁 윈도우에 뿌려지는 HTML 테이블입니다.
		이 부분을 적절히 수정하시면 됩니다.

		ToolTipVar_SkinWindow.left = PopupWindowVar_XPos - 3;
		ToolTipVar_SkinWindow.top  = PopupWindowVar_YPos + 8;

		이는 툴팁 윈도우가 나타나는 위치를 결정하는 부분으로
		수평값(3), 수직값(8) 을 적절히 변경하시길 바랍니다.

		또 다른 것은 마우스 커서를 수정하실 수 있습니다.
		저는 <TD> 태그의 마우스 이벤트에 사용하였으므로
		<TD> 태그의 style 속성에서 cursor:crosshair; 이 부분을
		바꾸시면 원하는 마우스 커서를 결정하실 수 있습니다.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// 날짜 툴팁 윈도우 스크립트 CODE START
// 테마 선택 윈도우 스크립트 CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	날짜 툴팁 전역변수 선언부
*/
var ToolTipVar_NAV		= (document.layers);
var ToolTipVar_IEX		= (document.all);
var ToolTipVar_SkinWindow = 
	(ToolTipVar_NAV) ? document.ToolTipWindowID : ToolTipWindowID.style;
/*
	테마 선택 전역변수 선언부
*/
var ThemaSelVar_NAV		= (document.layers);
var ThemaSelVar_IEX		= (document.all);
var ThemaSelVar_SkinWindow = 
	(ThemaSelVar_NAV) ? document.ThemaSelWindowID : ThemaSelWindowID.style;
/*
	공통 초기 수행부
*/
if (ToolTipVar_NAV) document.captureEvents(Event.MOUSEMOVE);

document.onmousemove = PopupWindowFunc_GrapMouse;
/*
	날짜 툴팁 함수 선언부
*/
function ToolTipFunc_ShowPopUp(ToolTipVar_MsgHTML)
{
	var ToolTipVar_FrameHTML;
	
	ToolTipVar_FrameHTML  = "<TABLE WIDTH=150 BORDER=0 CELLPADDING=2 ";
	ToolTipVar_FrameHTML += "CELLSPACING=0 BGCOLOR=" + 
		USERCONFIG_TW_FrameBorderColor + "><TR><TD>";
	ToolTipVar_FrameHTML += "<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 ";
	ToolTipVar_FrameHTML += "CELLSPACING=0 BGCOLOR=" + 
		USERCONFIG_TW_FrameBkgrdColor + "><TR><TD>";
	ToolTipVar_FrameHTML += "<CENTER><FONT style='FONT: 9pt, cutyfont, ";
	ToolTipVar_FrameHTML += "VT100, Arial, Helvetica' SIZE=1 COLOR=" + 
		USERCONFIG_TW_TextFontColor + ">";
	ToolTipVar_FrameHTML += ToolTipVar_MsgHTML + "</FONT></CENTER>";
	ToolTipVar_FrameHTML += "</TD></TR></TABLE></TD></TR></TABLE>";

	if(ToolTipVar_NAV)
	{
		ToolTipVar_SkinWindow.document.write(ToolTipVar_FrameHTML);
		ToolTipVar_SkinWindow.document.close();
		ToolTipVar_SkinWindow.visibility = "visible";
	}
	else if(ToolTipVar_IEX)
	{
		document.all("ToolTipWindowID").innerHTML = ToolTipVar_FrameHTML;
		ToolTipVar_SkinWindow.visibility = "visible";
	}
}

function ToolTipFunc_HidePopUp()
{
	ToolTipVar_SkinWindow.visibility = "hidden";
}
/*
	테마 선택 함수 선언부
*/
function ThemaSelFunc_ShowPopUp()
{
	var ThemaSelVar_FrameHTML;

	if(ThemaSelVar_SkinWindow.visibility == "visible")
	{
		ThemaSelVar_SkinWindow.visibility = "hidden";
		return;
	}
	
	ThemaSelVar_FrameHTML  = "<TABLE WIDTH=150 BORDER=0 CELLPADDING=2 ";
	ThemaSelVar_FrameHTML += "CELLSPACING=0 BGCOLOR=" + 
		USERCONFIG_TSW_FrameBorderColor + "><TR><TD>";

	ThemaSelVar_FrameHTML += "<TABLE WIDTH=100% BORDER=0 CELLPADDING=5 ";
	ThemaSelVar_FrameHTML += "CELLSPACING=0 BGCOLOR=" + 
		USERCONFIG_TSW_FrameBkgrdColor + "><TR><TD>";

	ThemaSelVar_FrameHTML += "<CENTER><FONT style='FONT: 9pt, cutyfont, ";
	ThemaSelVar_FrameHTML += "VT100, Arial, Helvetica' SIZE=1 COLOR=" + 
		USERCONFIG_TSW_TextFontColor + ">";

	ThemaSelVar_FrameHTML += CalImageFunc_GetThemaSelWMsgHTML() + "</FONT></CENTER>";
	ThemaSelVar_FrameHTML += "</TD></TR></TABLE></TD></TR></TABLE>";

	if(ThemaSelVar_NAV)
	{
		ThemaSelVar_SkinWindow.document.write(ThemaSelVar_FrameHTML);
		ThemaSelVar_SkinWindow.document.close();
		ThemaSelVar_SkinWindow.visibility = "visible";
	}
	else if(ThemaSelVar_IEX)
	{
		document.all("ThemaSelWindowID").innerHTML = ThemaSelVar_FrameHTML;
		ThemaSelVar_SkinWindow.visibility = "visible";
	}
}
// 사용하지 않는 함수로 그냥 남겨 놓음
function ThemaSelFunc_HidePopUp()
{
	ThemaSelVar_SkinWindow.visibility = "hidden";
}
/*
	공통 함수 선언부
*/
function PopupWindowFunc_GrapMouse(e)
{
	var PopupWindowVar_XPos = (ToolTipVar_NAV) ? e.pageX : event.x + 
							document.body.scrollLeft;
	var PopupWindowVar_YPos = (ToolTipVar_NAV) ? e.pageY : event.y + 
							document.body.scrollTop;

	// 소스 수정일(2003.12.01)
	// A. 일반 문서 자체로 달력을 사용하는 경우의 툴팁위치 조정 코드
	// ToolTipVar_SkinWindow.left = PopupWindowVar_XPos - 3;
	// ToolTipVar_SkinWindow.top  = PopupWindowVar_YPos + 8;
	// B. 달력을 iframe 안에 넣어서 사용을 하는 경우의 툴팁위치 조정 코드
	// 툴팁 윈도우 넓이 = 150, 높이 = 28
	ToolTipVar_SkinWindow.left = 17;
	if(PopupWindowVar_YPos + 8 + 28 > 314)
		ToolTipVar_SkinWindow.top  = PopupWindowVar_YPos - 8 - 28;
	else
		ToolTipVar_SkinWindow.top  = PopupWindowVar_YPos + 8;
	// 이 부분이 테마 선택 윈도우 부분으로 마우스 이벤트를
	// 같이 사용하여 윈도우의 창을 결정 짓습니다.
	// 조건은 윈도우 창이 숨어 있을 때만 위치를
	// 변경함으로써 열리고 난 후 이동이 없도록 합니다.
	if(ThemaSelVar_SkinWindow.visibility == "hidden")
	{
		ThemaSelVar_SkinWindow.left = PopupWindowVar_XPos - 150;
		ThemaSelVar_SkinWindow.top = PopupWindowVar_YPos;
	}
}
/*
///////////////////////////////////////////////////////////////////////////////
// 날짜 툴팁 윈도우 스크립트 CODE END
// 테마 선택 윈도우 스크립트 CODE END
///////////////////////////////////////////////////////////////////////////////
*/