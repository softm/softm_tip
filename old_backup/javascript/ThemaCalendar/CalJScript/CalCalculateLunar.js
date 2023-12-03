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
// ���� ��� ��ũ��Ʈ GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(����)
		������ ���ϴ� ��ũ��Ʈ�Դϴ�.
		�� �ҽ��� C �ڵ�� �Ǿ� �ִ� ����
		���� �ڹ� ��ũ��Ʈ�� ��ȯ�� �� ���Դϴ�.
		������ ������� �����ϸ� ���� ���Ͽ����Ƿ�
		�� �ҽ��� �̻��� ���� �� ������ ���� ���Դϴ�.
		�� ��ũ��Ʈ�� ���ؼ��� �ڼ��� ������
		����� �� �����ϴ�. -_-.

		���º�ȯ ���̺��� 170�Ⱓ�� ������ ���ϰ� �ֽ��ϴ�.
		���� �����ϸ� �ش� �⵵�� �� ���� �ϼ���
		��ȣ ǥ������� ������ ���� �� �մϴ�.
		�ؿ��� ��ü�ϼ��� ���ϴ� ���� ���� ���Դϴ�.
(����)
		LunarTranTable : ���� ��ȯ ���̺�(1881�� ~ 2050��)
		LunarYUKSIPTable, LunarGAPJATable : ���ʰ��� ���̺�
		LunarDDITable, LunarDDIETable: �� ���̺�
		LunarDaysOfMonthTable : �� ���� �ϼ� ���̺�
		LunarWeekNamesTable : ���� ���̺�
		LunarYear, LunarMonth, LunarDay : ��ȯ�� ���� ����
		LVar_DaysOfYearTable : �� ���� �� ���ڼ� ���̺�
		ResultLunarTEXT : ��ȯ�� ���� ���� ���ڿ�
		ResultDDITEXT : ��ȯ�� �� ���� ���ڿ�
(�Լ�)
		function LFunc_CalculateLunarCal(SolarYear, SolarMonth, SolarDay);

		<���>
			��� ������ �Է¹޾� �ش� ������ ������ ����Ͽ�
			������ �������� �� ���� ��ȯ�մϴ�.
		<�Ű�����>
			SolarYear, SolarMonth, SolarDay : ��� �����
		<��ȯ��>
			���� �Լ� ��ü���� ������ return ���� ����
			�Ѱ����� ���� �����ϴ�. ���� ��ȯ ���ڿ���
			���� ������ �����Ͽ� �Ʒ��� ��ƾ�鿡��
			���� ����� �ϰ� �ֱ� �����Դϴ�.
			�Ʒ��� ResultLunarTEXT �� ���۵Ǵ� ��ġ����
			��� ������ �������� ������ ������ �����ϴ�.
			�� �����Ͻø� ���ϴ� ������ ����� �� �ֽ��ϴ�.
			
			LunarYUKSIPTable[LVar_iCount1]	// �ش�⵵(����)
			LunarGAPJATable[LVar_jCount1]	// �ش�⵵(����)
			LunarDDITable[LVar_jCount1]		// �ش�⵵(��)
			LunarYUKSIPTable[LVar_iCount]	// �ش糯¥(����)
			LunarGAPJATable[LVar_jCount]	// �ش糯¥(����)
			LunarYear, LunarMonth, LunarDay	// ���� ���� �����
(���)
		���� ������ ���ϴ� ��ġ���� LFunc_CalculateLunarCal() �Լ���
		ȣ���Ͻø� �˴ϴ�. ���� ��ȯ���� ������ ó���ϼž� �մϴ�.
(����)
		������ ���ϴ� ��ũ��Ʈ���� Ư���� �����Ͽ��� �� �κ���
		��ȯ���� �����ϴ� �κ� �ۿ� �����ϴ�.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// ���� ��� ��ũ��Ʈ CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	�������� �����
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
	new Array("��", "��", "��", "��", "��",
	"��", "��", "��", "��", "��");
var LunarGAPJATable = 
	new Array("��", "��", "��", "��", "��", "��",
	"��", "��", "��", "��", "��", "��");
var LunarDDITable = 
	new Array("��", "��", "��", "�䳢","��", "��",
	"��", "��", "������", "��", "��", "����");
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
	�ʱ� �����
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
	�Լ� �����
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
	ResultLunarTEXT += "(��) " + "</B></FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=#278A05 size=1>";
	ResultLunarTEXT += LunarYUKSIPTable[LVar_iCount1] + 
					   LunarGAPJATable[LVar_jCount1] +
					   "�� " + "</FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=red size=1>";
	ResultLunarTEXT += LunarStrMonth + "</FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=#278A05 size=1>";
	ResultLunarTEXT += "�� " + "</FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=red size=1>";
	ResultLunarTEXT += LunarStrDay + "</FONT>";
	ResultLunarTEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultLunarTEXT += "Helvetica' color=#278A05 size=1>";
	ResultLunarTEXT += "��" + "</FONT>";
	
	ResultDDITEXT = "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultDDITEXT += "Helvetica' color=#278A05 size=1><B>";
	ResultDDITEXT += LunarDDITable[LVar_jCount1] + 
					 "</B>" + "(" + "</FONT>";
	ResultDDITEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultDDITEXT += "Helvetica' color=red size=1>";
	ResultDDITEXT += LunarDDIETable[LVar_jCount1] + "</FONT>";
	ResultDDITEXT += "<FONT style='FONT: 9pt, cutyfont, VT100, Arial, ";
	ResultDDITEXT += "Helvetica' color=#278A05 size=1>";
	ResultDDITEXT += ")" + "�� ��" + "</FONT>";

	return;
}
/*
///////////////////////////////////////////////////////////////////////////////
// ���� ��� ��ũ��Ʈ CODE END
///////////////////////////////////////////////////////////////////////////////
*/