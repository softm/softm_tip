<?
if( defined("_dboard_message_T_inc") ) return;
	define ("_dboard_message_T_inc", true);
/* Argus : errType    : U : 사용자 정의 메시지 ,
					P : 사용자 정의 데이터 베이스,
					D : 데이터 베이스
					S : 시스템 정보
					M : 지정 메시지*/

// 사용자 정의 메시지 출력
$errMsgTable['U0001'] = "이미 <B>config.php</B>가 생성되어 있습니다.<BR>재설치하려면 해당 파일을 지우세요.";
$errMsgTable['U0002'] = "설치가 완료 되지 않았습니다.";
$errMsgTable['U0003'] = "로그인후 사용하여 주십시요.";
$errMsgTable['U0004'] = "로그인 계정이 사용 정지 상태 입니다.";
$errMsgTable['U0005'] = "권한이 없는 사용자 입니다.";
$errMsgTable['U0006'] = "config 읽기 오류가 발생하였습니다.<BR><BR>관리자에게 문의하세요.";
$errMsgTable['U0007'] = "data 디렉토리의 쓰기 권한이 없습니다<br><B><font color='red'>707</font></B>로 설정해 주세요.(디보드설치루트/data)";
$errMsgTable['U0008'] = "file 디렉토리의 쓰기 권한이 없습니다<br><B><font color='red'>707</font></B>로 설정해 주세요.(디보드설치루트/data/file)";
$errMsgTable['U0009'] = "poll 디렉토리의 쓰기 권한이 없습니다<br><B><font color='red'>707</font></B>로 설정해 주세요.(디보드설치루트/data/poll)";
$errMsgTable['U0010'] = "세션 디렉토리의 쓰기 권한이 없습니다<br><B><font color='red'>707</font></B>로 설정해 주세요.(디보드설치루트/data/session)";
$errMsgTable['U0011'] = "html 디렉토리의 쓰기 권한이 없습니다<br><B><font color='red'>707</font></B>로 설정해 주세요.(디보드설치루트/data/html)";
$errMsgTable['U0012'] = "디지인보드 설치 되지 않았습니다.";
$errMsgTable['U0013'] = "디지인보드가 삭제 되었습니다.";
$errMsgTable['U0014'] = "<B>$id</B> 아이디가 존재 합니다.<BR>다른 관리자 아이디를 입력해주세요.";
$errMsgTable['U0015'] = "회원 디렉토리의 쓰기 권한이 없습니다<br><B><font color='red'>707</font></B>로 설정해 주세요.<BR>( 디보드설치루트/member, member/character, member/picture )";
$errMsgTable['U0016'] = "files 디렉토리의 쓰기 권한이 없습니다<br><B><font color='red'>707</font></B>로 설정해 주세요.(디보드설치루트/files)";

// 사용자 데이터 베이스 관련 메시지 출력
$errMsgTable['P0001'] = "데이터 베이스 드라이버를 찾을 수 없습니다.";
$errMsgTable['P0002'] = "config.php파일이 없습니다.<BR>( DB설정을 먼저 하십시요. )";
$errMsgTable['P0003'] = "아이디/비밀번호를 확인하세요.";
$errMsgTable['P0004'] = "<B>$bbs_id</B> 게시판명이 이미 존재합니다.";
$errMsgTable['P0005'] = "<B>$user_id</B> 이미 존재합니다.";
$errMsgTable['P0006'] = "<B>$user_id</B> 사용할 수 있습니다.";
$errMsgTable['P0007'] = "<B>$jumin_1 - $jumin_2 </B>는 이미 가입된 주민번호 입니다.";
$errMsgTable['P0008'] = "<B>$user_id</B> 로 회원 가입이 완료 되었습니다.";
$errMsgTable['P0009'] = "회원 정보가 메일로 발송 되었습니다.";
$errMsgTable['P0010'] = "회원 가입시 메일 입력 되지 않았습니다.<BR>사이트 관리자에게 직접 문의하세요.";
$errMsgTable['P0011'] = "메일 발송을 위한 회원 정보가 존재하지 않습니다.";
$errMsgTable['P0012'] = "회원 정보가 존재하지 않습니다.";
$errMsgTable['P0013'] = "회원 정보가 수정 되었습니다.";
$errMsgTable['P0014'] = "로그인에 성공하였습니다.";
$errMsgTable['P0015'] = "이미 로그인 되어 있습니다.";
$errMsgTable['P0016'] = "탈퇴 처리가 완료 되었습니다.";
$errMsgTable['P0017'] = "공개된 회원 정보가 없습니다.";
$errMsgTable['P0018'] = "<B>$e_mail</B>는 중복된 이메일 입니다.";
$errMsgTable['P0019'] = "본 사이트에서는 비밀번호 찾기 기능을 제공하기 않습니다.";

// 데이터 베이스 관련 메시지 출력
$errMsgTable['D1045'] = "접근 권한이 없거나, 데이터베이스 접속정보가 올바르지 않습니다.";
$errMsgTable['D1049'] = "데이터 베이스가 존재 하지 않습니다.";
$errMsgTable['D2005'] = "Host명이 존재하지 않습니다.";

// 시스템 정보
$errMsgTable['S0001'] = "";
$errMsgTable['S0002'] = "정상적인 방법으로 업로드 해주세요";
$errMsgTable['S0003'] = "페이지 접근이 거부 되었습니다.";
$errMsgTable['S0004'] = "게시판이 존재하지 않습니다.";
$errMsgTable['S0005'] = "목록 보기 권한이 없습니다.";
$errMsgTable['S0006'] = "읽기 권한이 없습니다.";
$errMsgTable['S0007'] = "쓰기 권한이 없습니다.";
$errMsgTable['S0008'] = "수정 권한이 없습니다.";
$errMsgTable['S0009'] = "답변 권한이 없습니다.";
$errMsgTable['S0010'] = "삭제 권한이 없습니다.";
$errMsgTable['S0011'] = "올바른 경로를 통해서 작성해주세요.";
$errMsgTable['S0012'] = "게시판 조회   스킨 구성에 문제가 있습니다. <BR>사이트 관리자에게 문의해주세요.";
$errMsgTable['S0013'] = "게시판 입력   스킨 구성에 문제가 있습니다. <BR>사이트 관리자에게 문의해주세요.";
$errMsgTable['S0014'] = "게시판 의견글 스킨 구성에 문제가 있습니다. <BR>사이트 관리자에게 문의해주세요.";

$errMsgTable['S0015'] = "게시물 수정을 위한 정보가 올바르지 않습니다.";
$errMsgTable['S0016'] = "게시물 작성자만 수정 할 수 있습니다.";

$errMsgTable['S0017'] = "게시물 삭제를 위한 정보가 올바르지 않습니다.";
$errMsgTable['S0018'] = "게시물 작성자만 삭제 할 수 있습니다.";

$errMsgTable['S0019'] = "의견글 삭제를 위한 정보가 올바르지 않습니다.";

$errMsgTable['S0020'] = "답변글 작성중 오류가 발생하였습니다..";

$errMsgTable['S0021'] = "서버 파일 최대 크기를 초과 하였거나.<BR>업로드 설정에 문제가 발생하였습니다.<BR>( 서버 관리자에게 문의하세요. )";

$errMsgTable['S0022'] = "업로드 Temporary 파일 삭제중 에러가 발생하였습니다.";

$errMsgTable['S0023'] = "파일 삭제중 에러가 발생하였습니다.";
$errMsgTable['S0024'] = "정상적인 방법으로 작성해주세요.";
$errMsgTable['S0025'] = "정상적인 방법으로 수정해주세요.";
$errMsgTable['S0026'] = "정상적인 방법으로 삭제해주세요.";
$errMsgTable['S0027'] = "정상적인 방법으로 답변을 작성해주세요.";
$errMsgTable['S0028'] = "정상적인 방법으로 의견글을 작성해 주세요.";
$errMsgTable['S0029'] = "정상적인 방법으로 의견글을 삭제해 주세요.";

$errMsgTable['S0030'] = "게시물이 존재 하지 않습니다.";
$errMsgTable['S0031'] = "사용자에의해 삭제되었습니다.";
$errMsgTable['S0032'] = "관리자에의해 삭제되었습니다.";

$errMsgTable['S0034'] = "메일 발송 실패";
$errMsgTable['S0035'] = "정상적인 방법으로 폼메일을 발송해주세요.";
$errMsgTable['S0036'] = "폼메일을 발송이 제한 되었습니다.";
$errMsgTable['S0037'] = "공지글 정보가 존재 하지 않습니다.";
$errMsgTable['S0038'] = "공지 스킨 구성에 문제가 있습니다. <BR>사이트 관리자에게 문의해주세요."; // 추출 부분에서 skin_name이 지정안되거나 잘못 된경우

$errMsgTable['S0039'] = "비공개글 입니다.";
$errMsgTable['S0040'] = "관리자 게시물 삭제를 위한 정보가 올바르지 않습니다.--;";

$errMsgTable['S0041'] = "설문 조사가 존재 하지 않습니다.";
$errMsgTable['S0042'] = "설문 항목이 설정되지 않았습니다.";
$errMsgTable['S0043'] = "설문 조사 스킨 구성에 문제가 있습니다. <BR>사이트 관리자에게 문의해주세요.";
$errMsgTable['S0044'] = "설문 결과 스킨 구성에 문제가 있습니다. <BR>사이트 관리자에게 문의해주세요.";

$errMsgTable['S0045'] = "투표 페이지 접근 권한이 없습니다.";
$errMsgTable['S0046'] = "투표 결과 페이지 접근 권한이 없습니다.";
$errMsgTable['S0047'] = "투표 권한이 없습니다.";
$errMsgTable['S0048'] = "이미 투표 하셨습니다.";
$errMsgTable['S0049'] = "투표 기간이 종료 되었습니다.";

$errMsgTable['S0050'] = "관리자에의해 파일 크기가 제한 되었습니다.";
$errMsgTable['S0051'] = "다운로드 권한이 없습니다.\\n로그인 후에 다운받으실 수 있습니다."; // Javascript Alert Message
$errMsgTable['S0052'] = "업로드 금지된 파일 입니다.";

$errMsgTable['S0053'] = "이름 입력이 올바르지 않습니다.";
$errMsgTable['S0054'] = "제목 입력이 올바르지 않습니다.";
$errMsgTable['S0055'] = "홈페이지 입력이 올바르지 않습니다.";
$errMsgTable['S0056'] = "이메일 입력이 올바르지 않습니다.";
$errMsgTable['S0060'] = "다운로드 권한이 없습니다.\\n비밀글 입니다."; // Javascript Alert Message

$errMsgTable['S0061'] = "파일 접근 권한이 없습니다.\\n"; // Javascript Alert Message
$errMsgTable['S0062'] = "목록 권한이 없음으로 파일에 접근할 수 없습니다.\\n"; // Javascript Alert Message
$errMsgTable['S0063'] = "읽기 권한이 없음으로 파일에 접근할 수 없습니다.\\n"; // Javascript Alert Message

$errMsgTable['S0064'] = "내용 입력이 올바르지 않습니다.";
$errMsgTable['S0065'] = "";
$errMsgTable['S0066'] = "파일이 존재하지 않습니다.\\n"; // Javascript Alert Message

$errMsgTable['S0067'] = "선택된 음악이 없습니다.\\n"; // Javascript Alert Message
$errMsgTable['S0070'] = "날짜가 변조되었습니다..\\n";

$errMsgTable['S0071'] = "이벤트가 존재하지 않습니다.";
$errMsgTable['S0072'] = "이벤트가 종료 되었습니다.";
$errMsgTable['S0073'] = "이벤트 참가 권한이 없습니다."; // Javascript Alert Message
$errMsgTable['S0074'] = "로그인후 참가해주세요.\\n비회원은 이벤트에 참가할수 없습니다."; // Javascript Alert Message
$errMsgTable['S0075'] = "이벤트에 참가되었습니다."; // Javascript Alert Message
$errMsgTable['S0076'] = "이벤트에 이미 참가하셨습니다."; // Javascript Alert Message
$errMsgTable['S0077'] = "이벤트에 참가하시겠습니까?"; // Javascript Alert Message
$errMsgTable['S0078'] = "";
$errMsgTable['S0079'] = "";
$errMsgTable['S0080'] = "메일이 발송 되었습니다.";

$errMsgTable['S1001'] = "스킨 구성에 문제가 있습니다. <BR>사이트 관리자에게 문의해주세요.";
?>