/****************************************************************************/
/*
/* �׸� �޷� �ҽ�
/*
/* ������ : õ����
/* ������ : 2003. 11. 30
/* ������ : 2004. 07. 22
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
// �޷� MAIN PRINT ��ũ��Ʈ GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(����)
		�޷� MAIN PRINT ��ũ��Ʈ�Դϴ�. �� �״�� �޷� ���̺��� �����
		���� �κ��Դϴ�. Ÿ��Ʋ �� ��¥ ���̺� ���õ� ��� ��ũ��Ʈ����
		ȣ��ǰ� �ֱ� ������ �߿��� �κ��̶�� �ϰڽ��ϴ�.
		���⿡���� �ҽ� ��ü�� �ڼ��� ������ ����̵��� �ϰڽ��ϴ�.
(����)
		����
(�Լ�)
		����
(���)
		����
(����)
		������ �뵵�� ���� ������ �����ϵ��� �Ͻñ� �ٶ��ϴ�.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// �޷� MAIN PRINT ��ũ��Ʈ CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	�޷� ���̺� ����
*/
document.write("<TABLE cellSpacing=0 cellPadding=0 width=154 border=0>");
document.write("<TBODY>");
// ���� �̸��� ��µǴ� �κ��Դϴ�.
document.write("<TR>");
document.write("<TD vAlign=center align=middle width='22' ");
document.write("bgColor=#ffffff>");
document.write("<font face='Tahoma, Geneva, sans-serif' ");
document.write("color=red size='1'><b>Su</b></font></TD>");
document.write("<TD vAlign=center align=middle width='22' ");
document.write("bgColor=#ffffff>");
document.write("<font face='Tahoma, Geneva, sans-serif' ");
document.write("size='1'><b>Mo</b></font></TD>");
document.write("<TD vAlign=center align=middle width='22' ");
document.write("bgColor=#ffffff>");
document.write("<font face='Tahoma, Geneva, sans-serif' ");
document.write("size='1'><b>Tu</b></font></TD>");
document.write("<TD vAlign=center align=middle width='22' ");
document.write("bgColor=#ffffff>");
document.write("<font face='Tahoma, Geneva, sans-serif' ");
document.write("size='1'><b>We</b></font></TD>");
document.write("<TD vAlign=center align=middle width='22' ");
document.write("bgColor=#ffffff>");
document.write("<font face='Tahoma, Geneva, sans-serif' ");
document.write("size='1'><b>Th</b></font></TD>");
document.write("<TD vAlign=center align=middle width='22' ");
document.write("bgColor=#ffffff>");
document.write("<font face='Tahoma, Geneva, sans-serif' ");
document.write("size='1'><b>Fr</b></font></TD>");
document.write("<TD vAlign=center align=middle width='22' ");
document.write("bgColor=#ffffff>");
document.write("<font face='Tahoma, Geneva, sans-serif' ");
document.write("color=blue size='1'><b>Sa</b></font></TD>");
document.write("</TR>");
document.write("<TR>");
// �̴��� 1���� ���۵Ǵ� ��ġ(CalVar_BlankDatePos)�� �̿��ؼ�
// 1�� ���� �κ��� �� �������� ���� ó���մϴ�.
for (CalVar_iCount = 0; CalVar_iCount < CalVar_BlankDatePos ;
	 CalVar_iCount++)
{
	document.write("<TD vAlign=center align=middle>");
	document.write("<FONT face='Tahoma, Geneva, sans-serif' ");
	document.write("size=1>&nbsp;</FONT></TD>");
}
// �̴��� ���ڸ� ��Ÿ���� �����Դϴ�.
// 1�Ϻ��� ǥ�ø� �ؾ� �Ǳ� ������ 1�� ���� �����ϴ�.
CalVar_iDateCount = 1;
// while �������� ó�� ���������� �Ǻ��մϴ�.
CalVar_firstOK = false;
// 1�Ϻ��� ���ϱ��� ������ �����ϸ鼭 ���̺��� �׸���� ����� ���ϴ�.
while (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth])
{
	// ó�� �����ϴ� ���̶�� <TR> �±׸� ǥ������ �ʴ´�.
	if(CalVar_firstOK == false)
		CalVar_firstOK = true;
	else
		document.write("<TR>");
	// ���� �� ���� �������� ���ڸ� ǥ���մϴ�.
	// ���� 7ĭ�� ��� ä�����ٸ� for ������ ���������ϴ�.
	// �Ʒ��� for ������ �� �� ������ ǥ���ϴ� �κ��Դϴ�.
	// for ���� while ������ ���� �������� ���
	// �Ѿ���� �����ϴ� �κ��Դϴ�.
	// ��¥�� ���� �ٲ� ������� ǥ�� �� ������
	// 1��ŭ�� �����ϵ��� �Ǿ� �ֽ��ϴ�.
	for (CalVar_iWeekLineCount = CalVar_BlankDatePos;
		 CalVar_iWeekLineCount < 7; CalVar_iWeekLineCount++)
	{
		/*
			<TD> �±��� �Ӽ� ����
			��¥�� <FONT style=> �Ӽ� ����
		*/
		if (CalVar_iDateCount == CalVar_ThisDate)
		{// ��¥�� ������ ���
			document.write("<TD ");
			// ��¥�� �̴��� �������� ������ ��쿡 ���ؼ�
			// �˻縦 �����Ѵ�.
			if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth]){
				// ���� ǥ���� �ڷᰡ �ִٸ� ���� ���ڿ��� ǥ���Ѵ�.
				if(DIFunc_IsExistDateInfo(CalVar_iDateCount) == true){
				// �̰��� ���� �����찡 ��ġ�ϴ� ���Դϴ�.
				// <TD> �±��� onmouseover, onmouseout �̺�Ʈ��
				// �����Ͽ� ���� �����츦 �����ְ� ���߾� �ֵ���
				// �ڵ带 �����մϴ�.
				// ���� �����ؼ��� ��¥ ���� ������ ��ũ��Ʈ �κ��� �����ϼ���.
				// ���� ���ڿ��� DIFunc_GetInfoHTML() �Լ��� �̿��Ͽ�
				// ���յ� ���� ���ڿ��� ������ �ֽ��ϴ�.
				// DIFunc_GetInfoHTML() �Լ��� ���� �ڼ��� ������
				// �޷� MAIN HEADER ��ũ��Ʈ �κ��� �����ϼ���.
				document.write(" onmouseover='ToolTipFunc_ShowPopUp(");
				document.write("\"" + 
					DIFunc_GetInfoHTML(CalVar_iDateCount) + "\"");
				document.write(");' onmouseout='ToolTipFunc_HidePopUp();' ");
				// <TD> �±��� style �Ӽ� �� cursor �� ���� �������� ����
				document.write(" style=' cursor:crosshair; ");
				// <TD> �±��� style �Ӽ� �� ��� �̹����� �ݺ����� �ʰ� ����
				document.write("background-repeat:no-repeat; ");
				}
				// ǥ���� ���� ���ڿ��� ���ٸ�
				else document.write(" style='");
			}
			// ���� ������ �� �����̶��
			else document.write(" style='");
			// <TD> �±��� style �Ӽ� �� cell�� �簢���� �׵θ��� ǥ��
			document.write(" BORDER-RIGHT: #FFCAFA 1px solid; ");
			document.write("BORDER-TOP: #FFCAFA 1px solid; ");
			document.write("BORDER-LEFT: #FFCAFA 1px solid;");
			document.write(" BORDER-BOTTOM: #FFCAFA 1px solid' ");
			document.write("vAlign=center align=middle ");
			// �̰��� cell�� ��� �������� �����ϴ� �κ��Դϴ�.
			// �������� ���������� ��¥�� ���� ���Ἲ�� �˻��� ��
			// ǥ���� ������ �ִٸ� ������ ���տ� ���� ���� �ٸ�
			// ��� �������� �����ϰ� �˴ϴ�.
			// DIFunc_GetIconImageName() �Լ��� ��¥�� ���������� ���ΰ�
			// �� �����ϰ� �̹��� ��ü��� ���ڿ��� ��ȯ�մϴ�.
			// true �� ��¥�� �������� ���մϴ�.
			// DIFunc_GetIconImageName() �Լ��� ���� �ڼ��� ������
			// �޷� MAIN HEADER ��ũ��Ʈ �κ��� �����ϼ���.
			if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth]){
				if(DIFunc_IsExistDateInfo(CalVar_iDateCount) == true){
					document.write("background=" + 
						DIFunc_GetIconImageName(CalVar_iDateCount, true));
				}
			}
			// ��� �̹����� ǥ�ÿ� ������� cell�� ������ ����
			document.write(" bgColor=#FFE5FE>");
			// ��¥�� ������ ��Ʈ �±� ����
			document.write("<FONT face='Tahoma, Geneva, sans-serif'");
		}
		else
		{// ��¥�� ������ �ƴ� ���
			// ��¥�� �̴��� �������� ������ ��쿡 ���ؼ�
			// �˻縦 �����Ѵ�.
			if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth]){
				// ���� ǥ���� �ڷᰡ �ִٸ� ���� ���ڿ��� ǥ���Ѵ�.
				if(DIFunc_IsExistDateInfo(CalVar_iDateCount) == true){
				document.write("<TD ");
				// �̰��� ���� �����찡 ��ġ�ϴ� ���Դϴ�.
				// <TD> �±��� onmouseover, onmouseout �̺�Ʈ��
				// �����Ͽ� ���� �����츦 �����ְ� ���߾� �ֵ���
				// �ڵ带 �����մϴ�.
				// ���� �����ؼ��� ��¥ ���� ������ ��ũ��Ʈ �κ��� �����ϼ���.
				// ���� ���ڿ��� DIFunc_GetInfoHTML() �Լ��� �̿��Ͽ�
				// ���յ� ���� ���ڿ��� ������ �ֽ��ϴ�.
				// DIFunc_GetInfoHTML() �Լ��� ���� �ڼ��� ������
				// �޷� MAIN HEADER ��ũ��Ʈ �κ��� �����ϼ���.
				document.write(" onmouseover='ToolTipFunc_ShowPopUp(");
				document.write("\"" + 
					DIFunc_GetInfoHTML(CalVar_iDateCount) + "\"");
				document.write(");' onmouseout='ToolTipFunc_HidePopUp();' ");
				// <TD> �±��� style �Ӽ� �� cursor �� ���� �������� ����
				document.write(" style=' cursor:crosshair; ");
				// <TD> �±��� style �Ӽ� �� ��� �̹����� �ݺ����� �ʰ� ����
				document.write("background-repeat:no-repeat; '");
				// �̰��� cell�� ��� �������� �����ϴ� �κ��Դϴ�.
				// �������� ���������� ��¥�� ���� ���Ἲ�� �˻��� ��
				// ǥ���� ������ �ִٸ� ������ ���տ� ���� ���� �ٸ�
				// ��� �������� �����ϰ� �˴ϴ�.
				// DIFunc_GetIconImageName() �Լ��� ��¥�� ���������� ���ΰ�
				// �� �����ϰ� �̹��� ��ü��� ���ڿ��� ��ȯ�մϴ�.
				// false �� ��¥�� ������ �ƴ��� ���մϴ�.
				// DIFunc_GetIconImageName() �Լ��� ���� �ڼ��� ������
				// �޷� MAIN HEADER ��ũ��Ʈ �κ��� �����ϼ���.
				document.write(" vAlign=center align=middle background=");
				document.write(
					DIFunc_GetIconImageName(CalVar_iDateCount, false));
				// ��¥�� ������ ��Ʈ �±� ����
				document.write("><FONT face='Tahoma, Geneva, sans-serif'");
				}
				else {// ǥ���� ���� ����Ÿ�� ���ٸ�
				document.write("<TD vAlign=center align=middle>");
				document.write("<FONT face='Tahoma, Geneva, sans-serif'");
				}
			}
			else {// ���� ������ �� �����̶��
			document.write("<TD vAlign=center align=middle>");
			document.write("<FONT face='Tahoma, Geneva, sans-serif'");
			}
		}
		/*
			��¥�� <FONT color=> �Ӽ� ����
		*/
		// ���� ���������� �Ǻ��Ͽ� ��¥�� ������ �����Ѵ�.
		// 0 = �Ͽ����� �ǹ��ϹǷ� �������� ����
		// �������̶�� ������ �������� ����
		// �������� �ƴϰ� ������� ��쿡�� �Ķ����� ����
		// �� �� ������ ���� ����Ʈ���� ��� (������)
		if(CalVar_iWeekLineCount == 0)
		document.write(" color=red");
		else {// ���� �Ͽ���(0)�� �ƴ϶�� ������(1) - �ݿ���(7)�� �ش�
			// ��¥�� ���� ������ ��쿡�� ����
			if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth]){
				if(DIVar_ThisMonthStateTable[
				   CalVar_iDateCount - 1].DIVar_pLH == true){
				   // ���� ��¥�� �������̶�� ������ �������� ����
					document.write(" color=red");
				} else {// ���� �������� �ƴ϶��
					if(CalVar_iWeekLineCount == 6)
					// ������� ��쿡�� �Ķ����� ����
					document.write(" color=blue");
				}
			}
			else {// ���� ������ �� �����̶�� (��� ����)
				if(CalVar_iWeekLineCount == 6)
				document.write(" color=blue");
			}
		}
		// ��Ʈ ���� �±׸� ����
		document.write(" size=1>");
		/*
			��¥ ǥ��
		*/
		if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth])
		{// ��¥�� �����̶�� ���� ǥ���ϰ� �׷��� ������ �������� ǥ��
			if (CalVar_iDateCount == CalVar_ThisDate)
				document.write("<B>" + CalVar_iDateCount + "</B>");
			else
				document.write(CalVar_iDateCount);
		}
		else// ���� ������ �����̶�� �� ���� ���� ǥ��
			document.write("&nbsp");
		// ��Ʈ �� cell �±׸� ����
		document.write("</FONT></TD>");
		// ���� ��¥ ǥ�� ������ ���� ���ڸ� ������Ų��.
		CalVar_iDateCount++;
	}// for ��
	// </TR> �±׷� ���� ������ �������Ѵ�.
	document.write("</TR>");
	// ���� ���� ǥ�ø� ���� ���� ��ġ�� ù��° ĭ���� �����Ѵ�.
	CalVar_BlankDatePos = 0;
}// while ��

document.write("</TBODY>");
document.write("</TABLE>");
/*
	�޷� ���̺� ��
*/
/*
///////////////////////////////////////////////////////////////////////////////
// �޷� MAIN PRINT ��ũ��Ʈ CODE END
///////////////////////////////////////////////////////////////////////////////
*/