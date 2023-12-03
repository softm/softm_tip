<?
if ( function_exists('head') ) {
    if ( $lg != 'Y' && $login_yn == 'N' && $grant == 'N' ) { // 권한 없음 (로그인 페이지 요구)
        Message('S', $msgNo,"MOVE:" . getReqPageName () . "$a_params&lg=Y&exec=$exec:로그인 ..",$loginSkinDir);
    } else { // 권한 없음 (이전 페이지)
        if ( $login_yn == 'Y' && $grant == 'N' ) {
            Message('S', $msgNo,"", $skinDir);
        } else if ( $lg == 'Y' ) { // 로그인
            include 'js/login_js.php'; // 로그인 javascript

            echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'><FORM METHOD=POST onSubmit=\"return loginFormSubmit(this);\"><input name='suc_mode' type='hidden' value='$suc_mode'><input name='message' type='hidden' value='$message'><input name='succ_url' type='hidden' value='$succ_url'><input name='login_skin_name' type='hidden' value='$login_skin_name'></TABLE>\n";
            $save_id  = $_COOKIE["_d_save_id"]; // 자동 로그인 여부
            if ( $save_id == 'Y' ) {
                $user_id = $_COOKIE["_d_user_id"   ]; // 사용자 아이디
            } else {
                $user_id = ''; // 사용자 아이디
            }
            include $loginSkinDir .'login.php'; // 로그인 스킨
            echo "<TABLE border='0' cellspacing='0' cellpadding='0' align='center'></FORM></TABLE>";
            if ( $save_id == 'Y' ) {
    ?>
            <script type="text/javascript">
            <!--
                if ( typeof(getObject ('save_id')) == 'object' ) getObject ('save_id').checked=true;
            //-->
            </script>
    <?
            }
        } else {
            if ( $exec == 'list' ) { // 리스트
                if ( $admin_yn == 'Y' ) include 'js/admin_js.php'; // 어드민 javascript
                include 'js/board_list_js.php'; // 리스트 javascript
                include $baseDir.'list.php'; // 리스트 페이지
            } else if ( $exec == 'view_check_exec' ) { // 읽기
                $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                $sercurity_stats = preg_match("/%${id}_${no}/", $sercurity_cotent_chk);
                include $libDir . 'view_exec.php'; // 조회수 증가 실행
            } else if ( $exec == 'view' ) { // 읽기
                include 'js/board_view_js.php'; // 글 보기 javascript
                include 'js/board_list_js.php'; // 리스트  javascript
    //			include $baseDir.'common/js/board_write_js.php'; // 글 쓰기 javascript
                $sercurity_stats = false; // 비밀글 인증 상태
                if ( $use_st == 1 ) { // 비공개글 이고  ..
                    // 비공개글일 경우 인증 상태 읽어오기.
                    $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                    $sercurity_stats = preg_match("/%${id}_${no}/", $sercurity_cotent_chk);
                    if ( !$sercurity_stats ) { // 비밀글 인증이 안된 글이
                        if ( $admin_yn == 'Y' ) { // 관리자이면
                            $sercurity_stats = true;
                            include $baseDir . 'view.php'; // 읽기 페이지
                        } else {
                            if ( !$w_user_id ) { // 비회원이 작성한 글일경우
                                $exec = 'view_check'; // 인증 체크를 위해.
                                $title = '비밀번호를 입력해주세요.';
                                include $baseDir . 'js/board_ask_password_js.php'; // 글 삭제 javascript
                                include $baseDir . 'ask_password.php'; // 비밀번호 입력 요구
                            } else { // 회원이 작성한 글은
                                if ( $login_yn == 'Y' ) {
                                    if ( $w_user_id == $user_id || $user_id == firstWriteUserId($id, $g_no) ) {
                                        $sercurity_cotent_chk = '%' . $id .'_' . $no . $sercurity_cotent_chk;
                                        if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                                            @session_register('sercurity_cotent_chk');
                                        } else {
                                            $_SESSION['sercurity_cotent_chk'] = $sercurity_cotent_chk;  // 4.10 세션 처리.
                                        }
                                        $sercurity_stats = true;
                                        include $baseDir . 'view.php'; // 읽기 페이지
                                    } else {
                                        Message('S', '0039','', $skinDir); // 비공개글
                                    }
                                } else {
                                    Message('S', '0039','', $skinDir); // 비공개글
                                }
                            }
                        }
                    } else { // 비밀글 인증된글
                        include $baseDir . 'view.php'; // 읽기 페이지
                    }
                } else {
                    $sercurity_stats = true;
                    include $baseDir . 'view.php'; // 읽기 페이지
                }
            } else if ( $exec == 'insert' || $exec == 'update' || $exec == 'answer' ) { // 입력, 수정 , 답변화면
                include 'js/board_write_js.php'; // 글 쓰기 javascript
                include $baseDir .'write.php'; // 리스트 페이지
            } else if ( $exec == 'delete' ) { // 삭제 [비밀번호 요구]
                include 'js/board_ask_password_js.php'; // 글 삭제 javascript
                $title = '삭제 하시겠습니까?';
                include $baseDir .'ask_password.php'; // 패스워드 요구
            } else if ( $exec == 'delete_exec' ) {  // 삭제 실행
                include $libDir . 'delete_exec.php'; // 삭제 실행
            } else if ( $exec == 'insert_exec' || $exec == 'update_exec' || $exec == 'answer_exec') { // 입력, 수정, 답변 실행
                $sercurity_cotent_chk = $_SESSION['sercurity_cotent_chk'];
                include $libDir . 'write_exec.php'; // 입력 실행
            } else if ( $exec_gubun == 'board' && $exec == 'insert_comment_exec' ) { // 의견 달기 입력 실행
                include $libDir . 'write_comment_exec.php'; // 입력 실행
            } else if ( $exec == 'delete_comment' ) { // 의견 달기 삭제 [비밀번호 요구]
                include 'js/board_ask_password_js.php'; // 글 삭제 javascript
                $title = '삭제 하시겠습니까?';
                include $baseDir .'ask_password.php'; // 패스워드 요구
            } else if ( $exec == 'delete_comment_exec' ) { // 의견 달기 삭제 실행
                include $libDir . 'write_comment_exec.php'; // 입력 실행
            } else if ( $exec == 'admin_data_copy' || $exec == 'admin_data_move' || $exec == 'admin_data_delete' ) {
                if ( $admin_yn == 'Y' ) {
                    include $libDir . 'admin_exec.php'; // 자료 이동, 삭제
                }
            }
            if ( strpos($exec, '_exec') == false ) {
                include $baseDir . 'exterior_copyright.txt'; // 외부 카피라이터 삽입 부분
            }
        }
    }
}
?>