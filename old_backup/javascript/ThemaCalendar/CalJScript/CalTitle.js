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
// �޷� Ÿ��Ʋ ��ũ��Ʈ GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(����)
		�޷� Ÿ��Ʋ ��ũ��Ʈ�Դϴ�.
		Ÿ��Ʋ�� �������δ� �ش��� ������ �ش����� ����������
		�ش�⵵�� �ܱ���� ǥ��� �ش�⵵�� ������ ���Դϴ�.
		��� ȿ���δ� <DIV> ��ü�� ���͸� ȿ���� �����߽��ϴ�.
		��� ���ڿ��� �ܼ� �ؽ�Ʈ �Ӹ� �ƴ϶�
		HTML ���ĵ� �����մϴ�.
(����)
		CalTitleVar_TitleText : ��� ���ڿ� �迭
		CalTitleVar_MonthNames : ���� ���� �̸� ���̺�
		CalTitleVar_TodayDate : JavaScript ���� Date ��ü ����
		CalTitleVar_ThisYear, CalTitleVar_ThisMonth,
		CalTitleVar_ThisDate : ���� �����
		CalTitleVar_DanGiYear : �ܱ���� �⵵
(�Լ�)
		function CalTitleFunc_Main();

		<���>
			Ÿ��Ʋ ����� �Ѱ��ϴ� ���� �Լ��Դϴ�.
			������ ������� ���ڿ��� ����� �Լ����� ȣ���Ͽ�
			�̸� �����ϴ� ��ɰ� ���յ� ���ڿ� ��� ȿ���� ����
			�ִϸ��̼� �Լ��� ȣ���մϴ�.

		function CalTitleFunc_AnimateText();

		<���>
			���յ� ���ڿ��� �̿��Ͽ� �ִϸ��̼� ȿ���� �ִ�
			�Լ��Դϴ�. <BODY> ���� �ȿ� �ִ� <DIV> ��ü��
			���͸� ȿ���� �����ν� �ִϸ��̼� ȿ���� �ο��մϴ�.
			��ü�� �̸��� CalTitleWindow �Դϴ�.
			�׸��� �ֱ����� ��ȭ�� ���Ͽ� Ÿ�̸Ӹ� �۵���Ű�� �ֽ��ϴ�.

		function CalTitleFunc_MakeMYText();

		<���>
			�ش� �⵵�� �� ���� ���ڿ��� ����� �ָ�
			���յ� ���ڿ��� ��ȯ�Ͽ� �ִ� �Լ��Դϴ�.

		function CalTitleFunc_MakeLCText();

		<���>
			�ش� ����Ͽ� ���� ���� ������ ���Ѿ� �ָ�
			���յ� ���ڿ��� ��ȯ�Ͽ� �ִ� �Լ��Դϴ�.
			���� �����ؾ� �� ���� ���¿� ���� ���Դϴ�.
			������ ���ϴ� ��ũ��Ʈ �Լ��� ���� ���ǵǾ�
			�ִµ� �̸� ȣ���� ���� ���� ������
			�� �Լ��� ȣ���ϱ� ���� ������ ���ϴ� �Լ���
			ȣ���Ͽ� ���ڿ��� ������ �־�� �Ѵٴ� ���Դϴ�.
			�̿� ���⼭�� CalTitleFunc_Main() �Լ�����
			LFunc_CalculateLunarCal() �Լ��� ���� ȣ���ϰ�
			������ �� �Ŀ� �� CalTitleFunc_MakeLCText() ��
			ȣ���Ͽ� ���յ� �������� ���ڿ��� ��� �ֽ��ϴ�.

		function CalTitleFunc_MakeDDIText();

		<���>
			�ش�⵵�� �� ������ ����� �ָ�
			���յ� ���ڿ��� ��ȯ�Ͽ� �ִ� �Լ��Դϴ�.
			���� CalTitleFunc_MakeLCText() �Լ�����
			ó�� ���� ��� �Լ����� ���ڿ��� �̹�
			��������� ������ ȣ�� ��Ģ�� ����
			�Լ��� �����մϴ�.

		function CalTitleFunc_MakeDanGiText();

		<���>
			�ش�⵵�� �ܱ� ��� �⵵�� ����Ͽ� �ָ�
			���յ� ���ڿ��� ��ȯ�Ͽ� �ִ� �Լ��Դϴ�.
(���)
		HTML ������ <BODY> �±��� onload �̺�Ʈ��
		CalTitleFunc_Main() �Լ��� ȣ��ǵ��� �ϴ�
		�ڵ带 �־� �ֽø� �˴ϴ�.
(����)
		�����Ͽ� ����Ͻ� ���� CalTitleFunc_Make �迭 �Լ�����
		���ڸ� �����ϴ� ����� �ٲٽø� �˴ϴ�.
		�߰��� ������� �þ�ٸ� �迭�� ������ �÷� �ֽð�
		���ϴ� ���ڿ��� �����ϴ� �Լ��� ����� �ֽø� �˴ϴ�.
		����, �ִϸ��̼� ȿ���� �����ϰ� �����ôٸ�
		Ÿ�̸� �����̶���� ����� 7��(7000)�� �Ǿ� �ֽ��ϴ�.
		�ƴϸ� ���͸� ȿ���� �����ϴ� ���ε�
		�װ��� CalTitleWindow DIV ��ü �κп� ���ø�
		revealTrans(Transition=6, Duration=3); �ڵ尡 �ֽ��ϴ�.
		���⼭ Transition=6 �� ���� �����Ͻø� �ٸ� ȿ���� �ֽ�
		�� �ֽ��ϴ�. ���� ������ 0 - 23 ������ �˰� �ֽ��ϴ�.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// ���� ��� ��ũ��Ʈ CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	�������� �����
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
	�Լ� �����
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
	CalTitleVar_TmpString += "�ܱ� " + "</B></FONT>";
	CalTitleVar_TmpString += "<FONT style='FONT: 9pt, cutyfont, VT100, ";
	CalTitleVar_TmpString += "Arial, Helvetica' color=red size=1>";
	CalTitleVar_TmpString += CalTitleVar_DanGiYear + "</FONT>";
	CalTitleVar_TmpString += "<FONT style='FONT: 9pt, cutyfont, VT100, ";
	CalTitleVar_TmpString += "Arial, Helvetica' color=#278A05 size=1>";
	CalTitleVar_TmpString += " ��" + "</FONT>";

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
// ���� ��� ��ũ��Ʈ CODE END
///////////////////////////////////////////////////////////////////////////////
*/