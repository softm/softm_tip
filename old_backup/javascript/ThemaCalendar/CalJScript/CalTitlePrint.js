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
// 달력 타이틀 PRINT 스크립트 GUIDE
///////////////////////////////////////////////////////////////////////////////
*/
/*
(설명)
		전에는 메인 PRINT 스크립트 안에 있던 부분을 편의상
		밖으로 빼 놓았습니다.
		왜 그랬는지는 소스를 분석해서 새로운 기능을 추가하실
		분은 알게 됩니다.
*/
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 타이틀 PRINT 스크립트 CODE START
///////////////////////////////////////////////////////////////////////////////
*/
document.write("<TABLE cellSpacing=0 cellPadding=0 width=150 border=0>");
document.write("<TBODY>");
document.write("<TR>");
document.write("<TD height=20 vAlign=center align=middle ");
document.write("bgColor=#ffffff colSpan=7>");
// 달력 타이틀 윈도우가 위치하는 곳입니다.
// 이 곳에 타이틀이 주기적으로 바뀌면서 표시됩니다.
// <BODY> 태그의 onload 이벤트에서 CalTitleFunc_Main() 함수가
// 호출되고 있습니다. 타이틀 애미메이션 효과는
// 바로 이 함수에서 관리하고 있습니다.
// 단지, 이 곳은 표시되는 창일 뿐입니다.
// 자세한 사항은 달력 타이틀 출력 스크립트 부분을
// 참고하시길 바랍니다.
document.write("<DIV id='CalTitleWindow' ");
document.write("style='text-align:center; width:150px; height:20px; ");
document.write("FILTER: revealTrans(Transition=" + USERCONFIG_CT_TransitionVal);
document.write(", Duration=" + USERCONFIG_CT_DurationVal + ");'>");
document.write("</DIV></TD></TR>");
document.write("</TBODY>");
document.write("</TABLE>");
/*
///////////////////////////////////////////////////////////////////////////////
// 달력 타이틀 PRINT 스크립트 CODE END
///////////////////////////////////////////////////////////////////////////////
*/