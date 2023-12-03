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
// �޷� MAIN HEADER ��ũ��Ʈ GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(����)
		�޷� MAIN HEADER ��ũ��Ʈ�Դϴ�. ����� ���� �Ʒ��� ����
		���� �ۼ� ��ũ��Ʈ�� ���� �غ�ܰ踦 ���մϴ�.
		���� ���� ��ũ��Ʈ�� �����Ͽ� ������ ������� ���
		���� ��ũ��Ʈ���� ����� �ϱ⿡ �߿��ϱ⵵ �ϰ�
		�׷��� �ڼ��� ������ �ҽ� ��ü���� �����̵��� �ϰڽ��ϴ�.

		�޷��� �ش� ���� ��¥�� �����ϱ� ���� �ʱ� �۾��� �����ϸ�
		���� �����(������, ������, ����, �����) �ڷḦ �����ϰ�
		�̸� �����ϴ� ��� �Լ����� ��ġ�ϰ� �ִ�.
		���� �����̴� ���� ���׶�� ������ ���� ��ɵ���
		���ԵǾ� �ֽ��ϴ�.

		���������� �ڵ��� �Ϻ��� ���Ἲ�� ������� �ʽ��ϴ�.
		������ ���Ἲ �˻� �κ��� ÷������ ���� ����
		Ư�� ��Ȳ�� �°� ����ȭ �Ǿ� �ֱ� �����Դϴ�.
		���� ���, ���� ����� ����Ÿ�� ��� 1���� �־�� �մϴ�.
		���� ���� üũ�� ���� �ʱ� �����Դϴ�.
		�׸���, �˻� �˰����� �ܼ� ���� �˻��� ����� ����
		��뷮 ����Ÿ�� �ִ� �͵� �ƴϰ�
		������ CPU ����ɷ¿� ���߾� �� �� ���� Ƽ�� ������ �ʽ��ϴ�.
		�ܼ��� ���� ������ �ڵ尡 �ݺ��Ǵ� ���� ���⿡
		�� ���� ���� �ִٴ� ���� �ֱ�� �մϴ�.
		�� ���� �˾Ƽ��� ���ļ� ����Ͻñ� �ٶ��ϴ�.
(����)
		CalVar_MonthNames : �� �̸� �迭
		CalVar_MonthDays : ���� ��¥ �� �迭
		DIVar_InfoTableLH : ������(a legal holiday) ���� ����Ÿ
		DIVar_InfoTableST : ����(a solar terms) ���� ����Ÿ
		DIVar_InfoTableMD : �����(a memorial day) ���� ����Ÿ
							��� ���� ����Ÿ�� ����ü �迭�� ����
							[][4 (=��,��,��,�����������)]
		DIVar_ThisMonthStateTable : �̴��� ��� ���� ��Ȳ ���̺�
									2���� �迭�� ����
									[�̴��� ��¥��][3 (=������,����,�����)]
		CalVar_TodayDate : �ý����� ���� ����� ����
		CalVar_ThisYear : ���� �⵵
		CalVar_ThisMonth : ���� �� (0 - 11)
		CalVar_ThisDate : ���� �� ( 1 ~ [28,29,30,31])
		CalVar_ThisDay : ���� ���� (0 - 6)
(�Լ�)
		function DIFunc_StateCreate(DIVar_pLH, DIVar_pST, DIVar_pMD);

		<���>
			�̴��� ��Ȳ ���̺��� ���� ��ü ��� ���� �Լ��Դϴ�.
			�� �Լ� ��ü�δ� ���� ������ ��(false, true)�� ����
			������ �迭�� �����ϴ� �Ͱ� �����մϴ�.
			�� �� ȣ��� ������ �������� ��Ұ� [3] �� �迭��
			�����մϴ�.
		<�Ű�����>
			DIVar_pLH : �ش����� ������������ ����(false, true)
			DIVar_pST : �ش����� ���������� ����(false, true)
			DIVar_pMD : �ش����� ����������� ����(false, true)
		
		function DIFunc_InfoCreate(DIVar_pYear, DIVar_pMonth, DIVar_pDay,
						   DIVar_pTxtHTML);

		<���>
			�� ���(������, ����, �����) ������ �����ϴ� �Լ��Դϴ�.
			����� ������ �⵵, ��, ��, �������� �����˴ϴ�.
			������ ���ڿ��� �ٸ� ���ڰ��� �ٸ��� ������
			����ü �迭�̶�� ǥ���� �� ���Դϴ�.
			���� �迭�� ���Ͽ� ������ ��ҵ��� �����Ѵٴ� ����
			���� �Լ��� �����մϴ�.
		<�Ű�����>
			DIVar_pYear, DIVar_pMonth, DIVar_pDay : ����� ����
			DIVar_pTxtHTML : ���� (TXT, HTML ���� ����)

		function DIFunc_IsExistDateInfo(DIVar_pDay);

		<���>
			�ش� �Ͽ� ���� ��� ������ �ִ����� �˾Ƴ��� �Լ��Դϴ�.
			3���� ��� ������ ��� �ϳ��� �ִٸ� ����� OK�Դϴ�.
		<�Ű�����>
			DIVar_pDay : �˾ƺ����� �ϴ� ��

		function DIFunc_FindInfoString(DIVar_fsKindOfDate, DIVar_fsDay);

		<���>
			�ش��ϴ� ����� ��¥�� ���� ������ �˾Ƴ��� �Լ��Դϴ�.
			�� ��� �������� �ٸ� ���̺��� ����ϰ� �����Ƿ�
			������ �� �ֱ� ���� �������� �Ű������� �ϳ� �� ���˴ϴ�.
		<�Ű�����>
			DIVar_fsKindOfDate : ��� ���� (1=������, 2=����, 3=�����)
			DIVar_fsDay : �˾ƺ����� �ϴ� �����

		function DIFunc_GetInfoHTML(DIVar_pDay);

		<���>
			�ش� ��¥�� ���Ե� ��� ������ ������ �����ϴ� �Լ��Դϴ�.
			������ ������� ���ؼ� �ϳ��� HTML ������ ���ڿ��� �����մϴ�.
		<�Ű�����>
			DIVar_fsDay : �˾ƺ����� �ϴ� �����

		function DIFunc_GetIconImageName(DIVar_pDay, DIVar_bToday);

		<���>
			�ش��Ͽ� ���Ե� ������ ���տ� ���� ��¥ ������ ǥ���ϱ� ����
			�������� �˾Ƴ��� �Լ��Դϴ�.
			3���� ������ ������ 2 * 2 * 2 = 8 ���� �������� ���˴ϴ�.
			� ��絵 ���� ���� �������� ǥ�ð� ������
			������ ���Ļ� ÷���� ���ҽ��ϴ�.
			����ϰ� �� ������� ���������� ���θ� �Ǻ��ϴ� ������
			������ �̴̹� <TD> �±��� ��׶��� �̹�����
			ǥ���� �Ǵµ� ������ ���� �簢 �׵θ���
			�������� �����Ǿ� �ֱ� �����Դϴ�.
			�ߺ��� �Ͼ ��� �������� ������� �����ܸ�
			���̱� ������ �����ܿ� �������� ÷���� ��������
			���� 8 ���� ����� ���ҽ��ϴ�.
		<�Ű�����>
			DIVar_pDay : �˾ƺ����� �ϴ� �����
			DIVar_bToday : �˾ƺ����� �ϴ� �������
						   ������ ���ð� ��ġ������ ����
(���)
		������ �Լ����� ������ �ʿ��� ��ġ���� ȣ���Ѵ�.
(����)
		���� ������ �����δ� ������ ���� �͵��� �ֽ��ϴ�.

		DIVar_InfoTableLH : ������(a legal holiday) ���� ����Ÿ
		DIVar_InfoTableST : ����(a solar terms) ���� ����Ÿ
		DIVar_InfoTableMD : �����(a memorial day) ���� ����Ÿ

		�ش� �⵵�� ����Ÿ��� ������Ʈ�� �� �ּž� �մϴ�.

		��Ÿ ��� ���ڿ� ���� ����̶����
		���Ǵ� �������� ��� �� �̸��̶���� ������ �����Ͻø� �˴ϴ�.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// �޷� MAIN HEADER ��ũ��Ʈ CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	�������� �����
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
	�޷� ��¥ ���� �ʱ� �����
*/
// �ý��� ������ �⵵, ��, ��, ������ ���Ѵ�.
CalVar_ThisYear		= CalVar_TodayDate.getYear();
CalVar_ThisMonth	= CalVar_TodayDate.getMonth();
CalVar_ThisDay		= CalVar_TodayDate.getDay();
CalVar_ThisDate		= CalVar_TodayDate.getDate();
// ������ �⵵�� 100���� ���� �������� ���Ѵ�.
CalVar_ThisYear		= CalVar_ThisYear % 100;
// �� �ڵ�� ������ Y2K ������ �ִ� ���� ���Ǿ���
// �⵵ ���� �ڵ�� ����� �� �ǹ̰� ����.
CalVar_ThisYear = ((CalVar_ThisYear < 50) ? (2000 + CalVar_ThisYear) :
				  (1900 + CalVar_ThisYear));
// ���ؿ� ������ �ִ����� �˻��Ͽ� 2������ ��¥���� �����Ѵ�.
if (((CalVar_ThisYear % 4 == 0) && !(CalVar_ThisYear % 100 == 0)) || 
	(CalVar_ThisYear % 400 == 0))
	CalVar_MonthDays[1]++;
// �ڵ�� A �� ���ۺ��� �������� �ڵ尡 �����ϴ� ����
// ������ ��¥(��)�� �̿��Ͽ� �̹��� 1����
// ��� ���Ϻ��� ���۵Ǵ����� �ľ��ϴ� ���Դϴ�.
// �������� 7 ���� ũ�ٸ� 7 ������ ��(K)���� ���߾� �ݴϴ�.
// �� ���� (������� - K + 1) �� ������ �����մϴ�.
// ���������� ������ ���� ������ ��� ���⿡ �ٽ�
// 7 �� ���� ����� �ٽ� �����Ͽ� �ݴϴ�.
// �̷��� �ϸ� �̹����� 1���� ��ġ�� �����˴ϴ�.
// ���� �̷� �˰����� �������� �ʾ�����
// ���ݸ� �����ϸ� �� ������ �� �� �ֽ��ϴ�.
// �������ڸ� �޷��� ĭ�� 7ĭ�̰�
// ���⼭ 1���� �� 7ĭ �� ��𿡼� ������ �ǵ���
// ������ �迭�� �ϰ����� �ִٴ� ���Դϴ�.
// ���� ��� 1 �����ٿ��� �ݵ�� 8�̶�� ���ڰ�
// ���ɴϴ�. �׸��� 3 �����ٿ��� �ݵ�� 10�̶�� ���ڰ�
// ���ɴϴ�. ��, �׷� ���� ��� ���ڽ��ϴ�.
// 1���� ����Ϸ� ���۵Ǵ� ���� �ִٰ� �ϰڽ��ϴ�.
// �� ��� a-2���� ������ �ϰ� ����
// ������ �����̵��� ���Ϻ��� 2 3 4 5 6 7 1 ������
// ��ȯ�˴ϴ�. ���⼭ a-3���� ������ �ϸ�
// -1 -1 -1 -1 -1 -1 6 ���� ��ȯ�� �˴ϴ�.
// �츮�� ã���� �ϴ� ���� 1���� ���� ����������
// �˾Ƴ��� ���Դϴ�. 1���� �����(6)�̶�� ������
// ������ �ǳ� ����Ͽ� 6�̶�� ���� ���Գ׿�.
// ������ ������ ������ ������ ��� -1 �̶�� ���Դϴ�.
// ������ ���鵵 ��� 6���� ǥ���� �ȴٸ�
// �̴��� ���� ��ġ�� 6�� �ڸ��� ������̶�� ����
// ���Ͽ� �� �� ���� ���Դϴ�. �׷��� ������ 7��
// ���� ��� 6 6 6 6 6 6 6 ���� �ǵ��� ����� �� ���Դϴ�.
// �ϳ� �� ���� ��ڽ��ϴ�. 1���� �ݿ��Ϻ���
// ���۵Ǵ� ���� �ִٰ� �����ϰڽ��ϴ�.
// �̷� ��� a-3 ���� �����ϰ� ����
// ������ -2 -2 -2 -2 5 5 �� ���¸� �����ϴ�.
// ���⿡ a-4���� ������ �ϰ� ���� ������ ���
// 5�� 5 5 5 5 5 5 5 �迭�� �̷�����ϴ�.
// �� ���� ���� 1���� ������ġ�� �ݿ���(5)�̶��
// ���� �� �� �ֽ��ϴ�. ǥ�� ������ ��������
// �� ���� ������ ���Դϴ�.
//
//   a-2 ������             a-3 ������               a-4 ������
// 2 3 4 5 6 7 1 ===�� -1 -1 -1 -1 -1 -1  6 ===�� 6 6 6 6 6 6 6
// 3 4 5 6 7 1 2 ===�� -2 -2 -2 -2 -2  5  5 ===�� 5 5 5 5 5 5 5
// 4 5 6 7 1 2 3 ===�� -3 -3 -3 -3  4  4  4 ===�� 4 4 4 4 4 4 4
// 5 6 7 1 2 3 4 ===�� -4 -4 -4  3  3  3  3 ===�� 3 3 3 3 3 3 3
// 6 7 1 2 3 4 5 ===�� -5 -5  2  2  2  2  2 ===�� 2 2 2 2 2 2 2
// 7 1 2 3 4 5 6 ===�� -6  1  1  1  1  1  1 ===�� 1 1 1 1 1 1 1
// 1 2 3 4 5 6 7 ===��  0  0  0  0  0  0  0 ===�� 0 0 0 0 0 0 0
//
// �ᱹ a-4 ���� ������ ������ �����̵��� ��� ������ ���¸� ���
// �ǰ� �̰����� �� ���� ������ġ�� �����ϰ� ������ �Ǵ� ���Դϴ�.
// ���� 0 ~ 6 �� �ǹ��ϴ� �ٰ� �ٷ� �Ͽ��� ~ ������̱� �����Դϴ�.
//
// �� �̷��� �ڼ��ϰ� ������ �ϴ��İ� �Ͻô� ���ںе� ��� ���Դϴ�.
// �װ� �� �ڵ带 �м��ϴ� ���� �߿��� ���� �ƴ϶� �� ó����
// �� �˰����� ������ �� ����� ����� ����� �ϴ� �ñ�������
// ����� ���̸� �� �� ����� ��¿� ���Ǹ� ǥ�ϰ� �ͱ� �����Դϴ�.
//
// �ڵ�� A ����
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
// �ڵ�� A ��
/*
	��� ���� ���� �ʱ� �����
*/
// �̴��� ��Ȳ ���̺��� ���� ��ü ��Ҹ� �����Ѵ�.
function DIFunc_StateCreate(DIVar_pLH, DIVar_pST, DIVar_pMD)
{// �Ű������δ� �ο︰ ��(false, true)���� �Ѿ� �´�.
	// �� �ڵ� ������ ������ �����Ǵ� ȿ���� �����´�.
	// �迭 ��Ұ� 3���� 1���� �迭ó��
	// 3���� ������ �ϳ��� ��ü�� �����մϴ�.
	// ��� ������ ���°� �ο︰ ���·� ���� ������
	// 1���� �迭�� �����ϼŵ� �˴ϴ�.
	this.DIVar_pLH = DIVar_pLH;
    this.DIVar_pST = DIVar_pST;
    this.DIVar_pMD = DIVar_pMD;
}
// �̴��� �� ��¥���� ���Ѵ�.
DIVar_jCount = CalVar_MonthDays[CalVar_TodayDate.getMonth()];
// �̴��� ��Ȳ ���̺��� ��¥�� ��ŭ ��Ҹ� �����Ͽ� �ʱⰪ�� �ο��Ѵ�.
for(DIVar_iCount = 0; DIVar_iCount < DIVar_jCount; DIVar_iCount++)
	DIVar_ThisMonthStateTable[DIVar_iCount] = 
		new DIFunc_StateCreate(false, false, false);
// ���� ���̺� ����ü�� �����Ѵ�.
function DIFunc_InfoCreate(DIVar_pYear, DIVar_pMonth, DIVar_pDay,
						   DIVar_pTxtHTML)
{
	// ���⼭ ����ü�� ��,��,��,���� �� ��ҷ� �����˴ϴ�.
	// �� ����(������, ����, �����) ����Ÿ�� ���
	// ������ ������ ���ϰ� �����Ƿ� �� ������ �Լ���
	// ��� �̿��Ͽ� ������ �ڱ�� ��Ҹ� ����� ���ϴ�.
	// �� ��ҵ��� ��� ���� ������ ������ �ƴϱ�
	// ������ ����ü�� ǥ���� �Ͽ��� ��
	// �ܼ��� �迭�� �����ϼŵ� �˴ϴ�.
	this.DIVar_pYear = DIVar_pYear;
	this.DIVar_pMonth = DIVar_pMonth;
	this.DIVar_pDay = DIVar_pDay;
	this.DIVar_pTxtHTML = DIVar_pTxtHTML;
}
// ������, ������ ���� ���̺��� �����Ѵ�.
// DIVar_InfoTableLH.length �� ��Ұ� �ϳ� ���� ������
// �ڵ����� �����ϴ� ���� �����͸� �����մϴ�.
// ���� ���� 0���� �����ְ�����. �ϳ��� �����Ǹ�
// 1�� ��ȯ�Ͽ� �ְ��. �׷��� �迭 ÷�ڿ�
// �� �ֱ⸸ �ϸ� �ڵ����� ���� �� ��ġ��
// ����Ű�� ȿ���� ������ �˴ϴ�.
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2003, 12, 25, "��ź��");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 1, 1, "����");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 1, 21, "���� ����");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 1, 22, "���� ����");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 1, 23, "���� ����");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 3, 1, "3.1 ��");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 4, 5, "�ĸ���");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 5, 5, "��̳�");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 5, 26, "����ź����");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 6, 6, "������");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 7, 17, "������");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 8, 15, "������");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 9, 27, "�߼� ����");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 9, 28, "�߼� ����");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 9, 29, "�߼� ����");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 10, 3, "��õ��");
DIVar_InfoTableLH[DIVar_InfoTableLH.length] = new DIFunc_InfoCreate(2004, 12, 25, "��ź��");
// ����(����ǳ�� ����) ���� ���̺��� �����Ѵ�.
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2003, 11, 8, "�Ե�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2003, 11, 23, "�Ҽ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2003, 12, 7, "�뼳");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2003, 12, 22, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 1, 6, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 1, 21, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 2, 4, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 2, 5, "���� �뺸��");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 2, 19, "���");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 3, 5, "��Ĩ");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 3, 20, "���");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 4, 4, "û��");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 4, 5, "�ѽ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 4, 20, "���");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 5, 5, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 5, 21, "�Ҹ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 6, 5, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 6, 21, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 6, 22, "�ܿ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 7, "�Ҽ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 20, "�ʺ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 22, "�뼭");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 30, "�ߺ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 7, 31, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 8, 7, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 8, 9, "����");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 8, 22, "ĥ��ĥ��");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 8, 23, "ó��");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 9, 7, "���");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 9, 23, "�ߺ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 10, 8, "�ѷ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 10, 22, "�߾���");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 10, 23, "��");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 11, 7, "�Ե�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 11, 22, "�Ҽ�");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 12, 7, "�뼳");
DIVar_InfoTableST[DIVar_InfoTableST.length] = new DIFunc_InfoCreate(2004, 12, 21, "����");
// ����� ���� ���̺��� �����Ѵ�.
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 11, 3, "�л��� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 11, 9, "�ҹ��� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 11, 17, "���������� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 11, 30, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 12, 3, "�Һ��ں�ȣ�� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 12, 5, "���α������弱�� �����");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2003, 12, 10, "�����αǼ��� �����");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 3, 3, "�������� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 3, 17, "����� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 3, 22, "���� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 3, 23, "����� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 3, "���俹���� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 7, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 13, "�ӽ����μ��� �����");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 19, "4.19 ���� �����");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 20, "������� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 21, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 22, "��������� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 25, "���� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 4, 28, "�湫�� ź����");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 1, "�ٷ����� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 8, "����̳�");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 15, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 17, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 18, "5.18 ����ȭ� �����");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 19, "�߸��� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 25, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 5, 31, "�ٴ��� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 6, 5, "ȯ���� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 6, 25, "6.25 �纯��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 9, 7, "��ȸ������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 9, 18, "ö���� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 9, 27, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 1, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 2, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 8, "���ⱺ���� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 9, "�ѱ۳�");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 15, "ü���� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 20, "��ȭ�� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 21, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 24, "����������");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 26, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 27, "���������ڻ�â�� �����");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 28, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 10, 30, "�װ��� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 3, "�л��� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 9, "�ҹ��� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 11, "������� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 17, "���������� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 11, 30, "������ ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 12, 3, "�Һ����� ��");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 12, 5, "���α������弱�� �����");
DIVar_InfoTableMD[DIVar_InfoTableMD.length] = new DIFunc_InfoCreate(2004, 12, 10, "�����αǼ��� �����");
// ������ ���� ���̺�κ��� �̴��� ������ �ִ����� �ľ��Ͽ�
// �̴� ��Ȳ ���̺� ����(true, false)�� ǥ���Ͽ� �ش�.
for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableLH.length; 
	DIVar_iCount++)
{
	if((DIVar_InfoTableLH[DIVar_iCount].DIVar_pYear == 
		CalVar_TodayDate.getYear()) &&
	   (DIVar_InfoTableLH[DIVar_iCount].DIVar_pMonth == 
	    (CalVar_TodayDate.getMonth() + 1)))
	{// �̹� �޿� ������ �ִٸ� ǥ���Ѵ�.
		DIVar_ThisMonthStateTable[
		DIVar_InfoTableLH[DIVar_iCount].DIVar_pDay - 1].DIVar_pLH = true;
	}
}
// ���� ���� ���̺�κ��� �̴��� ������ �ִ����� �ľ��Ͽ�
// �̴� ��Ȳ ���̺� ����(true, false)�� ǥ���Ͽ� �ش�.
for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableST.length; 
	DIVar_iCount++)
{
	if((DIVar_InfoTableST[DIVar_iCount].DIVar_pYear == 
		CalVar_TodayDate.getYear()) &&
	   (DIVar_InfoTableST[DIVar_iCount].DIVar_pMonth == 
		(CalVar_TodayDate.getMonth() + 1)))
	{// �̹� �޿� ������ �ִٸ� ǥ���Ѵ�.
		DIVar_ThisMonthStateTable[
		DIVar_InfoTableST[DIVar_iCount].DIVar_pDay - 1].DIVar_pST = true;
	}
}
// ����� ���� ���̺�κ��� �̴��� ������ �ִ����� �ľ��Ͽ�
// �̴� ��Ȳ ���̺� ����(true, false)�� ǥ���Ͽ� �ش�.
for(DIVar_iCount = 0; DIVar_iCount < DIVar_InfoTableMD.length; 
	DIVar_iCount++)
{
	if((DIVar_InfoTableMD[DIVar_iCount].DIVar_pYear == 
		CalVar_TodayDate.getYear()) &&
	   (DIVar_InfoTableMD[DIVar_iCount].DIVar_pMonth == 
	    (CalVar_TodayDate.getMonth() + 1)))
	{// �̹� �޿� ������ �ִٸ� ǥ���Ѵ�.
		DIVar_ThisMonthStateTable[
		DIVar_InfoTableMD[DIVar_iCount].DIVar_pDay - 1].DIVar_pMD = true;
	}
}
/*
	�Լ� �����
*/
// �ش��Ͽ� �ش��ϴ� ���� ����Ÿ�� �ִ����� �Ǻ��Ѵ�.
// 3���� ���� �� �ϳ��� �ֱ⸸ �ϸ� �ִ� ������ �����Ѵ�.
// ����� ��ȯ������ �����ش�.
function DIFunc_IsExistDateInfo(DIVar_pDay)
{
	DIVar_bExist = false;

	if((DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pLH == true) ||
	   (DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pST == true) ||
	   (DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pMD == true))
		DIVar_bExist = true;

	return 	DIVar_bExist;
}
// �ش����� �ش� ����� ������ ���� ����� �����Ѵ�.
function DIFunc_FindInfoString(DIVar_fsKindOfDate, DIVar_fsDay)
{
	var DIVar_FindString = "";

	if(DIVar_fsKindOfDate == 1)
	{// �������ΰ�� ������ ���� ���̺��� �˻��Ѵ�.
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
	{// �����ΰ�� ���� ���� ���̺��� �˻��Ѵ�.
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
	{// ������ΰ�� ����� ���� ���̺��� �˻��Ѵ�.
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
	// ����� ������ ��ȯ�Ѵ�.
	return DIVar_FindString;
}
// �ش��Ͽ� �ִ� ����� ������ ��� �о� ���� ���ڿ��� �����Ѵ�.
function DIFunc_GetInfoHTML(DIVar_pDay)
{
	var DIVar_ResultHTML = "";
	var DIVar_WhatInserted = 0;

	if(DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pLH == true)
	{// ������ ������ �ִٸ� �˻��Ͽ� ���ڿ��� �����δ�.
		DIVar_ResultHTML += DIFunc_FindInfoString(1, DIVar_pDay);
		// ������ ���� ���ڿ��� ÷���Ǿ����� ǥ���Ѵ�.
		DIVar_WhatInserted = 1;
	}
	if(DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pST == true)
	{// ���� ������ �ִٸ� �˻��Ͽ� ���ڿ��� �����δ�.
		// ������ ���� ���ڿ��� ÷���Ǿ��ٸ� �����ڸ� �����δ�.
		if(DIVar_WhatInserted == 1)
			DIVar_ResultHTML += "<br>";

		DIVar_ResultHTML += DIFunc_FindInfoString(2, DIVar_pDay);
		DIVar_WhatInserted = 2;
	}
	if(DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pMD == true)
	{// ����� ������ �ִٸ� �˻��Ͽ� ���ڿ��� �����δ�.
		// ������ �Ǵ� ���� ���� ���ڿ��� ÷���Ǿ��ٸ� �����ڸ� �����δ�.
		if((DIVar_WhatInserted == 1) || (DIVar_WhatInserted == 2))
			DIVar_ResultHTML += "<br>";

		DIVar_ResultHTML += DIFunc_FindInfoString(3, DIVar_pDay);
	}
	// ���յ� ���ڿ��� ��ȯ�Ѵ�.
	return 	DIVar_ResultHTML;
}
// �ش��Ͽ� ǥ�õ� �������� ã�� �� ��ο� �̸��� ��ȯ�Ѵ�.
function DIFunc_GetIconImageName(DIVar_pDay, DIVar_bToday)
{
	// �̴� ��Ȳ ���̺��� �ش��Ͽ� ���õ� ������ �ִ����� ����.
	DIVar_bLH = DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pLH;
	DIVar_bST = DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pST;
	DIVar_bMD = DIVar_ThisMonthStateTable[DIVar_pDay - 1].DIVar_pMD;
	// ��� ������ �̹����� ���
	DIVar_ImagePath = USERCONFIG_MH_IconImagePath;
	// ������ ��� ���� �̹����� ���ξ�
	DIVar_TodayPrefix = USERCONFIG_MH_IconImagePrefix;
	DIVar_ImageSrc = "";

	if(DIVar_bLH == false)
	{// 0 - ������ ������ ���� ��츦 ���Ѵ�.
		if(DIVar_bST == false)
		{// 0 - ���� ������ ���� ��츦 ���Ѵ�.
			if(DIVar_bMD == false)
			{// 0 - ����� ������ ���� ��츦 ���Ѵ�.
				// 0 0 0
				// �� ����� �̹����� ������ �ʴ´�.
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[0];
			}
			else
			{// 1 - ����� ������ �ִ� ��츦 ���Ѵ�.
				// 0 0 1
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[1];
			}
		}
		else
		{// 1 0 - ���� ������ �ִ� ��츦 ���Ѵ�.
			if(DIVar_bMD == false)
			{// 0 - ����� ������ ���� ��츦 ���Ѵ�.
				// 0 1 0
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[2];
			}
			else
			{// 1 - ����� ������ �ִ� ��츦 ���Ѵ�.
				// 0 1 1
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[3];
			}
		}
	}
	else
	{// 1  - ������ ������ �ִ� ��츦 ���Ѵ�.
		if(DIVar_bST == false)
		{// 0 0 - ���� ������ ���� ��츦 ���Ѵ�.
			if(DIVar_bMD == false)
			{// 0 - ����� ������ ���� ��츦 ���Ѵ�.
				// 1 0 0
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[4];
			}
			else
			{// 1 - ����� ������ �ִ� ��츦 ���Ѵ�.
				// 1 0 1
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[5];
			}
		}
		else
		{// 1 0 - ���� ������ �ִ� ��츦 ���Ѵ�.
			if(DIVar_bMD == false)
			{// 0 - ����� ������ ���� ��츦 ���Ѵ�.
				// 1 1 0
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[6];
			}
			else
			{// 1 - ����� ������ �ִ� ��츦 ���Ѵ�.
				// 1 1 1
				DIVar_ImageSrc = USERCONFIG_MH_IconImageFile[7];
			}
		}
	}
	// ���� ã���� �ϴ� ��¥�� �ٷ� �����̶�� �ٸ� �̹�����
	// ����Ͽ��� �ϹǷ� ��ο� �̸� ���̿� ���� ���ξ ÷���Ѵ�.
	// ���⼭ �̹������� ��ġ�� ������ ����.
	//		./Image/CalEllipseGIFIcon_xx.gif		(������ �ƴ� ���)
	//		./Image/Today_CalEllipseGIFIcon_xx.gif	(������ ���� ���)
	if(DIVar_bToday == true)	
		DIVar_ImageSrc = DIVar_ImagePath + DIVar_TodayPrefix +
						 DIVar_ImageSrc;
	else
		DIVar_ImageSrc = DIVar_ImagePath + DIVar_ImageSrc;
	// �̹��� �ҽ� ������� ��ȯ�Ѵ�.
	return DIVar_ImageSrc;
}
/*
///////////////////////////////////////////////////////////////////////////////
// �޷� MAIN HEADER ��ũ��Ʈ CODE END
///////////////////////////////////////////////////////////////////////////////
*/