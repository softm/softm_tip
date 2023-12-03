<?
error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice는 제외한 모든에러를 리포팅해라~ )
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
$IJTSEC = ( $_GET["baseDir"] || $_POST["baseDir"] || $_GET["libDir"] || $_POST["libDir"] ) ? false : true;

if ( $IJTSEC ) {
	// dpoll.php가 다른페이지에 include되었는지 여부
	if (!defined("DPOLL_INCLUDE") ) {
		if ( preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(dpoll.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
			define("DPOLL_INCLUDE","OFF");
			define("DBOARD_INCLUDE","OFF");
		} else {
			define("DPOLL_INCLUDE","ON");
		}
	}

    include_once $baseDir.'common/poll_lib.inc'  ; // 설문 라이브러리
    include_once $baseDir.'common/member_lib.inc'; // 멤버 라이브러리
    include_once $baseDir.'common/lib.inc'       ; // 공통 라이브러리
    include_once $baseDir.'common/message.inc'   ; // 에러 페이지 처리
    include_once $baseDir.'common/db_connect.inc'; // Data Base 연결 클래스
    include_once $baseDir.'common/_service.inc'  ; // 서비스 화면 관련
    $package = 'poll';   // 설문
    $memInfor = getMemInfor (); // 회원  정보

    $_dboard_poll_result_alert = false;

    if(!$_dboard_poll_included) { // 한번만 인클루드 되게 처리

        $a_params = '';
        // 설문 조사를 생성 합니다.
        // $gubun : '1' ::> 직접 createPoll호출
        //        : '2' ::> 직접 createPoll호출
        function createPoll($poll_id, $poll_exec='poll', $gubun='1') {

    $_sessionStart = getMicroSecond(); // 실행 시작 시간
            global $package, $db, $sysInfor, $baseDir, $user_id, $tb_poll_master, $tb_poll_item, $tb_poll_comment, $tb_member, $tb_bbs_data, $tb_bbs_comment, $_dboard_form_included, $_dpoll_form_included;
            global $s, $tot, $how_many, $more_many, $page_many, $page_tab;
            global $memInfor, $_dboard_ver_str, $a_params, $_dboard_poll_result_alert, $grantCharStr;
            global $_ENV, $_GET, $_POST, $_SERVER;

            $package = 'poll'; // 설문
            if ( !$db ) $db = initDBConnection (); // 데이터베이스 접속

            // 주의 해라 너 분명 까먹을꺼야
            $user_id        = $memInfor['user_id'     ]; // 아이디
            $login_yn       = $memInfor['login_yn'    ]; // 로그인 여부
            $admin_yn       = $memInfor['admin_yn'    ]; // 어드민 여부
            $memberlevel    = $memInfor['member_level']; // 회원 등급

            // 정보 읽기
            $pollInfor = getPollInfor($poll_id               ); // 설문  정보
            $pollGrant = getPollGrant($poll_id, $memberlevel ); // 권한  정보

            $tmp_poll_id    = $poll_id  ;
            $tmp_poll_exec  = $poll_exec;
            @extract($_ENV   ); // 환경 변수
            @extract($_GET   ); // Get  방식의 Parameter 값
            @extract($_POST  ); // Post 방식의 Parameter 값
            @extract($_SERVER); // Server 변수
            $poll_id    = $tmp_poll_id  ;
            $poll_exec  = $tmp_poll_exec;

            global $notice_popup_width, $notice_popup_height;
            global $_dboard_ver;

            if ( $p_poll_exec == 'poll_result' && $p_poll_id == $poll_id ) $poll_exec = 'poll_result';
			// 새창일 경우만 발생
            if ( $p_poll_exec == 'poll_result_alert_change' ) $poll_exec = 'poll_result';
            if ( $pollInfor )  { // 게시판 정보 존재

                $poll_exec = ( !$poll_exec ) ? "poll" : $poll_exec;   // 회면 처리 변수 설정

                /* ----- 화면 타이틀 설정 --------------------------- */
                if      ( $poll_exec == 'poll'          ) $_title = '설문 조사 - ' . $_dboard_ver; $msgNo = '0045';
                if      ( $poll_exec == 'poll_result'   ) $_title = '설문 결과 - ' . $_dboard_ver; $msgNo = '0046';

				head ($_title);

                $_pSkinName = ''; // 스킨명

                if ( !$poll_skin_name ) {
                    $_pSkinName = $pollInfor['skin_name'];
                } else {
                    $_pSkinName = $poll_skin_name;
                }

                $poll_skin_name = $pollInfor['skin_name'];
                $skinDir = $baseDir . 'skin/poll/' . $poll_skin_name . '/';
                $libDir  = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';

				$mailSendMethod = '1'; // 폼메일
				$start_date   = $pollInfor['start_date'  ]; // 설문 시작일
				$end_date     = $pollInfor['end_date'    ]; // 설문 종료일
				$compare_date = (int) $end_date;
				$sysDate      = getYearToSecond();
				$sysDate      = substr($sysDate, 0 ,10);
				$sysDate      = (int) $sysDate;

                if ( ( $compare_date - $sysDate ) < 0 && $admin_yn == 'N' ) {
                    Message('S', '0049',"", $skinDir);
                } else {

                    $total_hit = $pollInfor['total_hit'   ]; // 총 설문조사 참여인원수
                    $reg_date  = $pollInfor['reg_date'    ]; // 설문 생성 일자

                    // 권한 설정
                    if ( $poll_exec == 'poll'               ) $grant = $pollGrant['grant_poll'       ];
                    if ( $poll_exec == 'poll_exec'          ) $grant = $pollGrant['grant_poll'       ];
                    if ( $poll_exec == 'poll_result'        ) $grant = $pollGrant['grant_poll_result'];
                    if ( $poll_exec == 'insert_comment_exec') $grant = $pollGrant['grant_write'];
                    if ( $poll_exec == 'delete_comment'     ) $grant = $pollGrant['grant_write'];
                    if ( $poll_exec == 'delete_comment_exec') $grant = $pollGrant['grant_write'];

                    if ( $admin_yn == 'Y' ) $grant = 'Y';

                    appendParam ($a_params,'poll_id',$poll_id);
                    appendParam ($a_params,'poll_exec',$poll_exec);
                    appendParam ($a_params,'s',$s);

                    if ( $lg != 'Y' && $login_yn == 'N' && $grant == 'N' ) {
                        Message('S', $msgNo,"",$skinDir);
                    } else {
                        // 권한 없음 (이전 페이지)
                        if ( $login_yn == 'Y' && $grant == 'N' ) {
                            Message('S', $msgNo,"", $skinDir);
                        } else {

							css ($skinDir ); // css 설정

							pollFormCreate(); // 폼 생성

							include $baseDir .'common/poll_setup_default.inc'; // 기본 설정
							include $baseDir .'common/login_setup_default.inc'; // 로그인 기본 절성

							if ( file_exists($skinDir ."setup.php" ) ) {
								include $skinDir ."setup.php"       ; // 스킨 관련 설정
							}

							include_once $baseDir.'common/js/common_js.php'; // 공통 javascript
							include_once $baseDir.'common/js/poll_js.php'; // 설문조사 javascript
							include_once $baseDir.'common/js/member_infor_js.php'; // 회원 정보 보기 관련

							$title_limit  = $pollInfor['title_limit' ]; // 설문 제목 (자)
							$title        = $pollInfor['title'       ]; // 설문 제목

							if ( $title_limit != 0 ) {
								$title = curString($title, $title_limit, $title_cut_tag); // 타이틀 길이 맞추기
							}

							$start_year   = substr($start_date, 0 ,4);
							$start_month  = substr($start_date, 4 ,2);
							$start_day    = substr($start_date, 6 ,2);
							$start_hour   = substr($start_date, 8 ,2);

							$end_year     = substr($end_date  , 0 ,4);
							$end_month    = substr($end_date  , 4 ,2);
							$end_day      = substr($end_date  , 6 ,2);
							$end_hour     = substr($end_date  , 8 ,2);

							$opiniony_yn  = $pollInfor['opinion_yn'  ]; // 의견 출력
							$display_mode = $pollInfor['display_mode']; // 결과화면 출력형식 ( 현재창 : 1 , 새창 : 2 )

                            if ( $admin_yn != 'Y' ) { $show_admin_yn_s = "<!--"; $show_admin_yn_e = "-->";} // 관리자 여부
                            if ( $admin_yn == 'Y' ) { $hide_admin_yn_s = "<!--"; $hide_admin_yn_e = "-->";} // 관리자 여부

                            if ( $admin_yn != 'Y' && $login_yn == 'Y' ) { $hide_name_s     = "<!--"; $hide_name_e     = "-->";} // 로그인시 이름
                                                                                                                                // 입력창 디스 에이블
                            if ( $login_yn == 'Y'                     ) { $hide_password_s = "<!--"; $hide_password_e = "-->";} // 로그인시 패스워드

                            $grantCharStr = $pollInfor['grant_character_image']; // 회원 아이콘 권한
                            $cur_page = getReqPageName ();
// 링크 설정
                            $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>"        ;  // 로그 아웃
                            $a_login ="<a href='" . $cur_page . "$a_params&lg=Y'>"       ;  // 로그 인
                            $a_logout="<a href='" . $cur_page . "$a_params&exec=logout'>";  // 로그 아웃
                            $a_login ="<a href='" . $cur_page . "$a_params&lg=Y'>"       ;  // 로그 인
                            $a_poll  ="<a href='" . $cur_page . "$a_params'>"            ;  // 설문 조사

                            if ( $pollGrant['grant_poll_result'] == 'Y' ) {
                                $a_poll_result  ="<a href='#' onClick=\"pollResult('$display_mode', '$baseDir', '$poll_id', $poll_result_popup_width, $poll_result_popup_height);return false;\">";      // 설문 결과
                            } else {
                                $a_poll_result = "<a href='#' style='display:none'>";
                            }

                            $a_delete_comment = ''; // view_comment.php 에서 이용

                            $a_cancle = "<a href='javascript:history.back();'>";

                            if ( $poll_exec == 'poll' ) { // 설문 조사

                                echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST ACTION='' onSubmit=\"pollExec(this, '$display_mode','$poll_id', $poll_result_popup_width, $poll_result_popup_height);return false;\"></TABLE>\n";
                                include $baseDir."poll.php"; // 리스트 페이지
                                echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";

                            } else if ( $poll_exec == 'poll_exec' ) { // 설문 조사
                                include $baseDir."common/lib/" . $sysInfor["driver"] . '/' . "poll_exec.php"; // 설문 조사 실행
                                if ( $_GET[error] == 1 ) {
                                    Message('S', '0048',"javascript:self.close();:확인", $skinDir);   // 이미 투표 하셨습니다.
                                }
                            }
                            else if ( $poll_exec == 'poll_result' ) { // 설문 조사 결과

                                // name 변수가 동일한 이름으로 사용되므로 재 설정 [로그인 이름]
                                $name = $memInfor['name'];
                                if ( strpos($poll_exec, '_exec') == false && preg_match( '/('.$_SERVER['HTTP_HOST'].')((.)*(\/)+)+(dpoll.php)/', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] )) {
                                    include $baseDir.'data/html/_dpoll_header_' . $poll_id . '.php';
                                }

                                $package = 'poll'; // 설문

                                $skinDir = $baseDir . 'skin/poll/' . $poll_skin_name . '/';
                                include $baseDir .'poll_result.php'; // 읽기 페이지

                                if ( strpos($poll_exec, '_exec') == false && preg_match( '/('.$_SERVER['HTTP_HOST'].')((.)*(\/)+)+(dpoll.php)/', $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] )) {
                                    include $baseDir . 'data/html/_dpoll_footer_' . $poll_id . '.php';
                                }
                            }
                            else if ( $poll_exec == 'insert_comment_exec' ) { // 의견 달기 입력 실행
                                include $baseDir."common/lib/" . $sysInfor["driver"] . '/' . 'write_comment_exec.php'; // 입력 실행
                            }
                            else if ( $poll_exec == 'delete_comment' ) {       // 의견 달기 삭제 [비밀번호 요구]
                                $title = '삭제 하시겠습니까?';
                                include $baseDir .'ask_password.php'; // 패스워드 요구
                            }
                            else if ( $poll_exec == 'delete_comment_exec' ) {  // 의견 달기 삭제 실행
                               include $baseDir."common/lib/" . $sysInfor["driver"] . '/' . 'write_comment_exec.php'; // 입력 실행
                            }

                            if ( !$_dboard_poll_result_alert && ( $p_poll_exec == 'poll_result_alert_only' || $p_poll_exec == 'poll_result_alert_change' ) ) { // 투표 처리후 알림상자
                                $_dboard_poll_result_alert = true;
                                echo ( "\n<script type='text/javascript'>\n" );
                                echo ( "    window.document.body.onload = aa;\n");
                                echo ( "    function aa() {\n");
                                echo ( "        alert('투표완료.');\n");
                                echo ( "    }\n");
                                echo ( "\n</SCRIPT>\n" );
                            }
                        }
                    }
                }
    $_sessionEnd = getMicroSecond();
			footer ();
            } // if END
            else { // 설문 조사 정보 없음
                if ( DPOLL_INCLUDE == DBOARD_INCLUDE_OFF ) {
				    head ($_title);
                    css (); // css 설정
                }
                Message('S', '0041'); // 설문 조사가 존재 하지 않습니다.
                if ( DPOLL_INCLUDE == DBOARD_INCLUDE_OFF ) {
			        footer ();
                }
            } // else END
        }

        // 설문 조사를 생성 합니다.
        function createRecentPoll ( $poll_exec='poll' ) {
            global $db;
            $db = initDBConnection (); // 데이터베이스 접속

            $poll_id  = getRecentPollNo ();
            $poll_day = getYearToDay();
            createPoll($poll_id, $poll_exec,'' , $poll_day . '00', $poll_day . '24' );
        }
        $_dboard_poll_included = true;
    }

    if ( DPOLL_INCLUDE == DBOARD_INCLUDE_OFF ) {
        createPoll($poll_id, $poll_exec);
    }
}
?>