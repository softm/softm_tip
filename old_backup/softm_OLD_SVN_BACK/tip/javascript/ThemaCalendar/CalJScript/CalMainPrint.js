/****************************************************************************/
/*
/* 테마 달력 소스
/*
/* 제작자 : 천고마비
/* 제작일 : 2003. 11. 30
/* 수정일 : 2004. 07. 22
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
// 달력 MAIN PRINT 스크립트 GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(설명)
		달력 MAIN PRINT 스크립트입니다. 말 그대로 달력 데이블을 만들어
		내는 부분입니다. 타이틀 및 날짜 테이블에 관련된 모든 스크립트들이
		호출되고 있기 때문에 중요한 부분이라고 하겠습니다.
		여기에서는 소스 자체에 자세한 설명을 곁들이도록 하겠습니다.
(변수)
		없음
(함수)
		없음
(용법)
		없음
(수정)
		개인의 용도에 따라 적절히 변경하도록 하시길 바랍니다.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 MAIN PRINT 스크립트 CODE START
///////////////////////////////////////////////////////////////////////////////
*/
/*
	달력 테이블 시작
*/
document.write("<TABLE cellSpacing=0 cellPadding=0 width=154 border=0>");
document.write("<TBODY>");
// 요일 이름이 출력되는 부분입니다.
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
// 이달의 1일이 시작되는 위치(CalVar_BlankDatePos)를 이용해서
// 1일 앞의 부분을 빈 여백으로 먼저 처리합니다.
for (CalVar_iCount = 0; CalVar_iCount < CalVar_BlankDatePos ;
	 CalVar_iCount++)
{
	document.write("<TD vAlign=center align=middle>");
	document.write("<FONT face='Tahoma, Geneva, sans-serif' ");
	document.write("size=1>&nbsp;</FONT></TD>");
}
// 이달의 일자를 나타내는 변수입니다.
// 1일부터 표시를 해야 되기 때문에 1을 먼저 갖습니다.
CalVar_iDateCount = 1;
// while 루프에서 처음 수행인지를 판별합니다.
CalVar_firstOK = false;
// 1일부터 말일까지 루프를 수행하면서 테이블의 항목들을 만들어 냅니다.
while (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth])
{
	// 처음 수행하는 것이라면 <TR> 태그를 표시하지 않는다.
	if(CalVar_firstOK == false)
		CalVar_firstOK = true;
	else
		document.write("<TR>");
	// 이제 빈 공백 다음부터 숫자를 표시합니다.
	// 만일 7칸이 모두 채워졌다면 for 루프를 빠져나갑니다.
	// 아래의 for 루프는 곧 한 라인을 표시하는 부분입니다.
	// for 밖의 while 루프는 다음 라인으로 계속
	// 넘어가도록 제어하는 부분입니다.
	// 날짜는 라인 바뀜에 관계없이 표시 될 때마다
	// 1만큼씩 증가하도록 되어 있습니다.
	for (CalVar_iWeekLineCount = CalVar_BlankDatePos;
		 CalVar_iWeekLineCount < 7; CalVar_iWeekLineCount++)
	{
		/*
			<TD> 태그의 속성 결정
			날짜의 <FONT style=> 속성 결정
		*/
		if (CalVar_iDateCount == CalVar_ThisDate)
		{// 날짜가 오늘인 경우
			document.write("<TD ");
			// 날짜가 이달의 마지막날 이전인 경우에 한해서
			// 검사를 수행한다.
			if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth]){
				// 만약 표시할 자료가 있다면 정보 문자열을 표시한다.
				if(DIFunc_IsExistDateInfo(CalVar_iDateCount) == true){
				// 이곳이 툴팁 윈도우가 위치하는 곳입니다.
				// <TD> 태그의 onmouseover, onmouseout 이벤트에
				// 반응하여 툴팁 윈도우를 보여주고 감추어 주도록
				// 코드를 삽입합니다.
				// 툴팁 관련해서는 날짜 툴팁 윈도우 스크립트 부분을 참고하세요.
				// 정보 문자열은 DIFunc_GetInfoHTML() 함수를 이용하여
				// 조합된 정보 문자열을 얻어오고 있습니다.
				// DIFunc_GetInfoHTML() 함수에 대한 자세한 사항은
				// 달력 MAIN HEADER 스크립트 부분을 참고하세요.
				document.write(" onmouseover='ToolTipFunc_ShowPopUp(");
				document.write("\"" + 
					DIFunc_GetInfoHTML(CalVar_iDateCount) + "\"");
				document.write(");' onmouseout='ToolTipFunc_HidePopUp();' ");
				// <TD> 태그의 style 속성 중 cursor 를 십자 모형으로 지정
				document.write(" style=' cursor:crosshair; ");
				// <TD> 태그의 style 속성 중 배경 이미지를 반복되지 않게 지정
				document.write("background-repeat:no-repeat; ");
				}
				// 표시할 정보 문자열이 없다면
				else document.write(" style='");
			}
			// 말일 이후의 빈 여백이라면
			else document.write(" style='");
			// <TD> 태그의 style 속성 중 cell에 사각형의 테두리를 표시
			document.write(" BORDER-RIGHT: #FFCAFA 1px solid; ");
			document.write("BORDER-TOP: #FFCAFA 1px solid; ");
			document.write("BORDER-LEFT: #FFCAFA 1px solid;");
			document.write(" BORDER-BOTTOM: #FFCAFA 1px solid' ");
			document.write("vAlign=center align=middle ");
			// 이곳이 cell에 배경 아이콘을 삽입하는 부분입니다.
			// 위에서와 마찬가지로 날짜에 대한 무결성을 검사한 후
			// 표시할 정보가 있다면 정보의 조합에 따라 각기 다른
			// 배경 아이콘을 설정하게 됩니다.
			// DIFunc_GetIconImageName() 함수는 날짜와 오늘인지의 여부값
			// 을 전달하고 이미지 전체경로 문자열을 반환합니다.
			// true 는 날짜가 오늘임을 뜻합니다.
			// DIFunc_GetIconImageName() 함수에 대한 자세한 사항은
			// 달력 MAIN HEADER 스크립트 부분을 참고하세요.
			if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth]){
				if(DIFunc_IsExistDateInfo(CalVar_iDateCount) == true){
					document.write("background=" + 
						DIFunc_GetIconImageName(CalVar_iDateCount, true));
				}
			}
			// 배경 이미지의 표시에 관계없이 cell의 배경색을 지정
			document.write(" bgColor=#FFE5FE>");
			// 날짜에 적용할 폰트 태그 시작
			document.write("<FONT face='Tahoma, Geneva, sans-serif'");
		}
		else
		{// 날짜가 오늘이 아닌 경우
			// 날짜가 이달의 마지막날 이전인 경우에 한해서
			// 검사를 수행한다.
			if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth]){
				// 만약 표시할 자료가 있다면 정보 문자열을 표시한다.
				if(DIFunc_IsExistDateInfo(CalVar_iDateCount) == true){
				document.write("<TD ");
				// 이곳이 툴팁 윈도우가 위치하는 곳입니다.
				// <TD> 태그의 onmouseover, onmouseout 이벤트에
				// 반응하여 툴팁 윈도우를 보여주고 감추어 주도록
				// 코드를 삽입합니다.
				// 툴팁 관련해서는 날짜 툴팁 윈도우 스크립트 부분을 참고하세요.
				// 정보 문자열은 DIFunc_GetInfoHTML() 함수를 이용하여
				// 조합된 정보 문자열을 얻어오고 있습니다.
				// DIFunc_GetInfoHTML() 함수에 대한 자세한 사항은
				// 달력 MAIN HEADER 스크립트 부분을 참고하세요.
				document.write(" onmouseover='ToolTipFunc_ShowPopUp(");
				document.write("\"" + 
					DIFunc_GetInfoHTML(CalVar_iDateCount) + "\"");
				document.write(");' onmouseout='ToolTipFunc_HidePopUp();' ");
				// <TD> 태그의 style 속성 중 cursor 를 십자 모형으로 지정
				document.write(" style=' cursor:crosshair; ");
				// <TD> 태그의 style 속성 중 배경 이미지를 반복되지 않게 지정
				document.write("background-repeat:no-repeat; '");
				// 이곳이 cell에 배경 아이콘을 삽입하는 부분입니다.
				// 위에서와 마찬가지로 날짜에 대한 무결성을 검사한 후
				// 표시할 정보가 있다면 정보의 조합에 따라 각기 다른
				// 배경 아이콘을 설정하게 됩니다.
				// DIFunc_GetIconImageName() 함수는 날짜와 오늘인지의 여부값
				// 을 전달하고 이미지 전체경로 문자열을 반환합니다.
				// false 는 날짜가 오늘이 아님을 뜻합니다.
				// DIFunc_GetIconImageName() 함수에 대한 자세한 사항은
				// 달력 MAIN HEADER 스크립트 부분을 참고하세요.
				document.write(" vAlign=center align=middle background=");
				document.write(
					DIFunc_GetIconImageName(CalVar_iDateCount, false));
				// 날짜에 적용할 폰트 태그 시작
				document.write("><FONT face='Tahoma, Geneva, sans-serif'");
				}
				else {// 표시할 정보 데이타가 없다면
				document.write("<TD vAlign=center align=middle>");
				document.write("<FONT face='Tahoma, Geneva, sans-serif'");
				}
			}
			else {// 말일 이후의 빈 여백이라면
			document.write("<TD vAlign=center align=middle>");
			document.write("<FONT face='Tahoma, Geneva, sans-serif'");
			}
		}
		/*
			날짜의 <FONT color=> 속성 결정
		*/
		// 무슨 요일인지를 판별하여 날짜의 색상을 결정한다.
		// 0 = 일요일을 의미하므로 붉은색을 지정
		// 국경일이라면 무조건 붉은색을 지정
		// 국경일이 아니고 토요일인 경우에는 파란색을 지정
		// 그 외 평일인 경우는 디폴트값을 사용 (미지정)
		if(CalVar_iWeekLineCount == 0)
		document.write(" color=red");
		else {// 만일 일요일(0)이 아니라면 월요일(1) - 금요일(7)에 해당
			// 날짜가 말일 이전인 경우에만 수행
			if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth]){
				if(DIVar_ThisMonthStateTable[
				   CalVar_iDateCount - 1].DIVar_pLH == true){
				   // 만일 날짜가 국경일이라면 무조건 붉은색을 지정
					document.write(" color=red");
				} else {// 만일 국경일이 아니라면
					if(CalVar_iWeekLineCount == 6)
					// 토요일인 경우에는 파란색을 지정
					document.write(" color=blue");
				}
			}
			else {// 말일 이후의 빈 여백이라면 (없어도 무방)
				if(CalVar_iWeekLineCount == 6)
				document.write(" color=blue");
			}
		}
		// 폰트 시작 태그를 닫음
		document.write(" size=1>");
		/*
			날짜 표시
		*/
		if (CalVar_iDateCount <= CalVar_MonthDays[CalVar_ThisMonth])
		{// 날짜가 오늘이라면 굵게 표시하고 그렇지 않으면 보통으로 표시
			if (CalVar_iDateCount == CalVar_ThisDate)
				document.write("<B>" + CalVar_iDateCount + "</B>");
			else
				document.write(CalVar_iDateCount);
		}
		else// 말일 이후의 여백이라면 빈 공백 문자 표시
			document.write("&nbsp");
		// 폰트 및 cell 태그를 닫음
		document.write("</FONT></TD>");
		// 다음 날짜 표시 과정을 위해 숫자를 증가시킨다.
		CalVar_iDateCount++;
	}// for 문
	// </TR> 태그로 현재 라인을 마무리한다.
	document.write("</TR>");
	// 다음 라인 표시를 위해 시작 위치를 첫번째 칸으로 지정한다.
	CalVar_BlankDatePos = 0;
}// while 문

document.write("</TBODY>");
document.write("</TABLE>");
/*
	달력 테이블 끝
*/
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 MAIN PRINT 스크립트 CODE END
///////////////////////////////////////////////////////////////////////////////
*/