/****************************************************************************/
/*
/* �׸� �޷� �ҽ�
/*
/* ������ : õ����
/* ������ : 2003. 11. 30
/* ������ : 2003. 12. 05
/* Ȩ��� : http://myhome.naver.com/hullangi
/* �̸��� : hullangi@naver.com
/* ���۱� : ������ �ҽ�
/*		   �� �ҽ��� ���� �� ������� �����ӽ��ϴ�.
/*         ��, �� ���� ���� ������ ������ �ʴ´ٴ� �����Դϴ�.
/*		   �� �ҽ��� ����� �������� �뵵�μ� �����̸�,
/*		   ���� ���ÿ� �߻��Ǵ� � ������
/*		   ����� �ڽſ��� å���� ������ �����ϴ�.
/*
/****************************************************************************/
/*
///////////////////////////////////////////////////////////////////////////////
// ��¥ ���� ������ ��ũ��Ʈ GUIDE
// �׸� ���� ������ ��ũ��Ʈ GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(2003. 12. 05. �������� ����)
		�׸� ���� ������ ��ũ��Ʈ�� ��¥ ���� ������ �����
		��� ���� ������ ���� ��ġ���׽��ϴ�.
		���콺 �̺�Ʈ ĸ�� �κ��� �������� ����ϰ� �ֽ��ϴ�.
		�ٷ� �� ���� ������ ¦���� ���� ���Դϴ�.
		�ٸ� ������ �ʿ䰡 ���� �� �����ϴ�.
(����)
		��¥ ���� ������ ��ũ��Ʈ�Դϴ�.
		<DIV> ��ü�� �̿��Ͽ����� �ش����� �������� �޾Ƽ�
		����Ͽ� �ִ� ���� �մϴ�. �̺�Ʈ�� �����Ͽ�
		���� �����츦 �����ְ� �����ִ� ���ҵ���
		���ϰ� �ֽ��ϴ�. ���⼭ �̺�Ʈ�� ���� ���콺
		�̺�Ʈ�� ������ <TD> �±� �Ӽ����� ���콺 �̺�Ʈ��
		������ŵ�ϴ�. �ٷ� �� �̺�Ʈ�� �����ϰ� �Ǵ�
		���Դϴ�.
(����)
		ToolTipWindowID : ���� ������ ��ü
		ToolTipVar_SkinWindow : ���� ������ ��ü (= ToolTipWindowID �� ����)
(�Լ�)
		function ToolTipFunc_ShowPopUp(ToolTipVar_MsgHTML);

		<���>
			�Ű������� ���� ���ڿ��� Ư�� HTML ��������
			�����Ͽ� ���� �����쿡 �ѷ��ְ� �ֽ��ϴ�.
			�� ������ ���� �����츦 Visible ���·� ��ȯ�Ͽ� �ݴϴ�.
		<�Ű�����>
			ToolTipVar_MsgHTML �� �ش����� ������ �ѷ��� ��
			�̹� ������ ���ڿ��� �� ���ڿ��� �ǹ��ϴ� �ٴ�
			������, ������, ����, ����� ���� �����Դϴ�.
			�ڼ��� ������ �Ŀ� �ڿ��� �����ϵ��� �ϰڽ��ϴ�.

		function ToolTipFunc_HidePopUp();

		<���>
			<TD> �±��� onmouseover �̺�Ʈ�� �����Ͽ� �����
			ToolTipFunc_ShowPopUp() �Լ��� ���� ������
			���� �����츦 <TD> �±��� onmouseout �̺�Ʈ��
			������ �� �Լ��� ���߾� �ִ� ������ �����ϰ� �˴ϴ�.

		function ToolTipFunc_GrapMouse(e);

		<���>
			���콺 �̺�Ʈ�� �߻��Ǿ��� ������ ��ǥ��
			�������� ���� �������� ��ġ�� �����մϴ�.
			�̸� ���� ������ onmousemove �̺�Ʈ ��ü��
			�̸� ��ϵǾ� �ֽ��ϴ�.
(���)
		�� ���� ������ ���̺� �� <TD> �±� �ȿ���
		onmouseover, onmouseout �̺�Ʈ���� ����ϰ� �ֽ��ϴ�.

		onmouseover="ToolTipFunc_ShowPopUp('��� ���ڿ�');"
		onmouseover="ToolTipFunc_HidePopUp('��� ���ڿ�');"

		�������� �̿��� �Ͻø� �˴ϴ�.
(����)
		���� ������ �����δ� ������ ���� �͵��� �ֽ��ϴ�.

		ToolTipVar_FrameHTML

		�̰��� ���� �����쿡 �ѷ����� HTML ���̺��Դϴ�.
		�� �κ��� ������ �����Ͻø� �˴ϴ�.

		ToolTipVar_SkinWindow.left = PopupWindowVar_XPos - 3;
		ToolTipVar_SkinWindow.top  = PopupWindowVar_YPos + 8;

		�̴� ���� �����찡 ��Ÿ���� ��ġ�� �����ϴ� �κ�����
		����(3), ������(8) �� ������ �����Ͻñ� �ٶ��ϴ�.

		�� �ٸ� ���� ���콺 Ŀ���� �����Ͻ� �� �ֽ��ϴ�.
		���� <TD> �±��� ���콺 �̺�Ʈ�� ����Ͽ����Ƿ�
		<TD> �±��� style �Ӽ����� cursor:crosshair; �� �κ���
		�ٲٽø� ���ϴ� ���콺 Ŀ���� �����Ͻ� �� �ֽ��ϴ�.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// ��¥ ���� ������ ��ũ��Ʈ CODE START
// �׸� ���� ������ ��ũ��Ʈ CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	��¥ ���� �������� �����
*/
var ToolTipVar_NAV		= (document.layers);
var ToolTipVar_IEX		= (document.all);
var ToolTipVar_SkinWindow = 
	(ToolTipVar_NAV) ? document.ToolTipWindowID : ToolTipWindowID.style;
/*
	�׸� ���� �������� �����
*/
var ThemaSelVar_NAV		= (document.layers);
var ThemaSelVar_IEX		= (document.all);
var ThemaSelVar_SkinWindow = 
	(ThemaSelVar_NAV) ? document.ThemaSelWindowID : ThemaSelWindowID.style;
/*
	���� �ʱ� �����
*/
if (ToolTipVar_NAV) document.captureEvents(Event.MOUSEMOVE);

document.onmousemove = PopupWindowFunc_GrapMouse;
/*
	��¥ ���� �Լ� �����
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
	�׸� ���� �Լ� �����
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
// ������� �ʴ� �Լ��� �׳� ���� ����
function ThemaSelFunc_HidePopUp()
{
	ThemaSelVar_SkinWindow.visibility = "hidden";
}
/*
	���� �Լ� �����
*/
function PopupWindowFunc_GrapMouse(e)
{
	var PopupWindowVar_XPos = (ToolTipVar_NAV) ? e.pageX : event.x + 
							document.body.scrollLeft;
	var PopupWindowVar_YPos = (ToolTipVar_NAV) ? e.pageY : event.y + 
							document.body.scrollTop;

	// �ҽ� ������(2003.12.01)
	// A. �Ϲ� ���� ��ü�� �޷��� ����ϴ� ����� ������ġ ���� �ڵ�
	// ToolTipVar_SkinWindow.left = PopupWindowVar_XPos - 3;
	// ToolTipVar_SkinWindow.top  = PopupWindowVar_YPos + 8;
	// B. �޷��� iframe �ȿ� �־ ����� �ϴ� ����� ������ġ ���� �ڵ�
	// ���� ������ ���� = 150, ���� = 28
	ToolTipVar_SkinWindow.left = 17;
	if(PopupWindowVar_YPos + 8 + 28 > 314)
		ToolTipVar_SkinWindow.top  = PopupWindowVar_YPos - 8 - 28;
	else
		ToolTipVar_SkinWindow.top  = PopupWindowVar_YPos + 8;
	// �� �κ��� �׸� ���� ������ �κ����� ���콺 �̺�Ʈ��
	// ���� ����Ͽ� �������� â�� ���� �����ϴ�.
	// ������ ������ â�� ���� ���� ���� ��ġ��
	// ���������ν� ������ �� �� �̵��� ������ �մϴ�.
	if(ThemaSelVar_SkinWindow.visibility == "hidden")
	{
		ThemaSelVar_SkinWindow.left = PopupWindowVar_XPos - 150;
		ThemaSelVar_SkinWindow.top = PopupWindowVar_YPos;
	}
}
/*
///////////////////////////////////////////////////////////////////////////////
// ��¥ ���� ������ ��ũ��Ʈ CODE END
// �׸� ���� ������ ��ũ��Ʈ CODE END
///////////////////////////////////////////////////////////////////////////////
*/