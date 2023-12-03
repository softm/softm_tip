<?
if ( function_exists('_head') ) {
    $chk_no = $no; // 현재 읽고 있는 자료 검사를
    if ( strpos($exec, '_exec') == false ) {
        include 'js/common_js.php'; // 공통 javascript
        include 'js/board_common_js.php'; // 공통 javascript
        if ( $npop == 'Y' ) { // 공지 풋터
            include ( $baseDir . 'data/html/_dnotice_header_' . $id . '.php' );
        } else {
            if ( $bbsInfor['design_method'] == '1' ) {
                include ( $baseDir . 'data/html/_dboard_header_' . $id . '.php' );
            }
        }
    }

    if ( $exec == 'insert' ) { $title   =""; $content =""; }

    $package = 'board'; // 패키지구분 설정 ( 보드 )
    $no = $chk_no; // 헤더 영역에서 공지가 포함되어있을 경우 동일한 변수명을 사용하는 문제 해결

    $title_limit = $bbsInfor['title_limit']; // 제목글자제한 (자)
    if ( $bbsInfor['table_width_unit'] == 1 ) $table_unit = "%"; else $table_unit = ''; // 테이블 단위
    $table_width = $bbsInfor['table_width'] . $table_unit; // 게시판 넓이
    $mailSendMethod = $bbsInfor['mail_send_method']; // 이메일 발송형식 ( 폼메일 : '1' , e_mail : '2' )

    $_skinName = $bbsInfor['skin_name']; // 스킨명
    $skinDir   = $baseDir . 'skin/board/' . $_skinName . '/'   ;
    $libDir    = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';
    _css ($skinDir); // css 설정

    // 게시판 정보
    $login_yn = $memInfor['login_yn']; // 로그인 여부
    $admin_yn = $memInfor['admin_yn']; // 어드민 여부
    $user_id  = $memInfor['user_id' ]; // 아이디

    // 권한 설정
    if ( $exec == 'list'               ) $grant = $bbsGrant['grant_list'    ];
    if ( $exec == 'view_check_exec'    ) $grant = $bbsGrant['grant_view'    ];
    if ( $exec == 'view_exec'          ) $grant = $bbsGrant['grant_view'    ];
    if ( $exec == 'view'               ) $grant = $bbsGrant['grant_view'    ];
    if ( $exec == 'insert'             ) $grant = $bbsGrant['grant_write'   ];
    if ( $exec == 'insert_exec'        ) $grant = $bbsGrant['grant_write'   ];
    if ( $exec == 'update'             ) $grant = $bbsGrant['grant_write'   ];
    if ( $exec == 'update_exec'        ) $grant = $bbsGrant['grant_write'   ];
    if ( $exec == 'answer'             ) $grant = $bbsGrant['grant_answer'  ];
    if ( $exec == 'answer_exec'        ) $grant = $bbsGrant['grant_answer'  ];
    if ( $exec == 'insert_comment_exec') $grant = $bbsGrant['grant_comment' ];
    if ( $exec == 'delete_comment'     ) $grant = $bbsGrant['grant_comment' ];
    if ( $exec == 'delete_comment_exec') $grant = $bbsGrant['grant_comment' ];
    if ( $exec == 'delete'             ) $grant = $bbsGrant['grant_write'   ];
    if ( $exec == 'delete_exec'        ) $grant = $bbsGrant['grant_write'   ];
    if ( $admin_yn == 'Y'              ) $grant = 'Y';

    if ( strpos($bbsInfor['operator_id'], $user_id . '\'') ) { // 부운영자 권한 설정
        $grant    = 'Y'; // 기본 페이지 권한 ( 목록, 보기 쓰기 )
        $admin_yn = 'Y';
        $bbsGrant['grant_list'   ] = 'Y';  // 목록   권한
        $bbsGrant['grant_view'   ] = 'Y';  // 보기   권한
        $bbsGrant['grant_write'  ] = 'Y';  // 쓰기   권한
        $bbsGrant['grant_answer' ] = 'Y';  // 답변   권한
        $bbsGrant['grant_comment'] = 'Y';  // 의견글 권한
        $bbsGrant['grant_down'   ] = 'Y';  // 다운   권한
    }

    $hide_category_s = "<!--"; $hide_category_e = "-->";
    $a_cat_search="<a href='#' style='display:none'>";
    if ( $bbsInfor['use_category'] == 'Y' && strpos($exec, "_exec") == false ) {
        $hide_category_s = ""; $hide_category_e = "";
        $category = getCategory ($id); // 카테고리
        $a_cat_search='';
        $a_cat_search_tmp="<a href='#' onClick=\"categoryLinkSearch('";
    }

    // 게시물 정보 조회
    if ( $no && ( $exec == 'view' || $exec == 'view_exec' || $exec == 'view_check_exec' || $exec == 'update' || $exec == 'answer' ) ) {
        $chk_password = $password; // 비밀번호 검사
        include $libDir . 'bbs_one_row_retrive.php'; // 게시물 한건 조회
    }

    // 링크 설정
    appendParam ($a_params,'id'  ,$id   );
    appendParam ($a_params,'s'   ,$s    );
    appendParam ($a_params,'npop',$npop );
    if ( $exec != 'list' && $no ) appendParam ($a_params,'no',$no); // 게시물 번호

    if ( $desc == 'desc' ) $desc = 'asc' ; else $desc = 'desc';

    $cur_page = getReqPageName (); // 현재 페이지
    $a_check_box     ="<a href='#' onClick='checkedAll ();return false;'>"                       ;  // 체크 상자
    $a_sort_no       ="<a href='#' onClick='sortPage(\"no\",\"$desc\");return false;' onFocus='this.blur()'>";  // 번호
    $a_sort_cat_no   ="<a href='#' onClick='sortPage(\"cat_no\",\"$desc\");return false;' onFocus='this.blur()'>";  // 카테고리 번호
    $a_sort_name     ="<a href='#' onClick='sortPage(\"name\",\"$desc\");return false;' onFocus='this.blur()'>";  // 이름
    $a_sort_title    ="<a href='#' onClick='sortPage(\"title\",\"$desc\");return false;' onFocus='this.blur()'>";  // 제목
    $a_sort_hit      ="<a href='#' onClick='sortPage(\"hit\",\"$desc\");return false;' onFocus='this.blur()'>";  // 조회
    $a_sort_down_hit1="<a href='#' onClick='sortPage(\"down_hit1\",\"$desc\");return false;' onFocus='this.blur()'>";  // 댜운수1
    $a_sort_down_hit2="<a href='#' onClick='sortPage(\"down_hit2\",\"$desc\");return false;' onFocus='this.blur()'>";  // 댜운수2
    $a_sort_reg_date ="<a href='#' onClick='sortPage(\"reg_date\",\"$desc\");return false;' onFocus='this.blur()'>";  // 날짜
    $a_sort_file1    ="<a href='#' onClick='sortPage(\"file1\",\"$desc\");return false;' onFocus='this.blur()'>";  // 파일1
    $a_sort_file2    ="<a href='#' onClick='sortPage(\"file2\",\"$desc\");return false;' onFocus='this.blur()'>";  // 파일2

    if ( $bbsGrant['grant_list'] == 'Y' ) {
        $a_list  ="<a href='#' onClick=\"listPage();return false;\">";  // 리스트
    } else {
        $a_list = "<a href='#' style='display:none'>";
    }

    $a_file  =''; // 파일 링크

    if ( $bbsGrant['grant_write'] == 'Y' ) {     // 쓰기
        $a_insert ="<a href='" . $cur_page . "$a_params&exec=insert'>";
    } else {
        $a_insert ="<a href='#'  style='display:none'>";
    }

    $a_update = '';
    $a_answer = '';
    $a_delete = '';

    $a_view = ''; // 읽기
    $a_view_tmp ="<a href='#' onClick=\"viewPage('";

    $a_delete_comment = ''; // view_comment.php 에서 이용

    $a_cancle = "<a href='javascript:history.back();'>";

    $a_pre_list  = "<a href='#' style='display:none'>"; // 이전 페이지
    $a_next_list = "<a href='#' style='display:none'>"; // 이후 페이지

    $a_pre_view  = "<a >"; // 이전 글
    $a_next_view = "<a >"; // 이후 글
    $a_download  = "<a href='download.php?id=$id&no=";

    $use_default_login = $bbsInfor['use_default_login'];
    $login_skin_name   = '';
    if ( $use_default_login == 'Y' ) {
        $login_skin_name   = $sysInfor['login_skin'];
    } else {
        $login_skin_name   = $bbsInfor['login_skin_name'];
    }
    $loginSkinDir= $baseDir . 'skin/login/' . $login_skin_name . '/';

    include 'login_setup_default.inc'; // 기본 설정

    if ( file_exists($loginSkinDir .'setup.php' ) ) {
        include $loginSkinDir .'setup.php'       ; // 스킨 관련 설정
    }

    if ( $login_yn == 'Y' ) {
        $a_login ="<a href='#' style='display:none'>"; // 로그 인
        $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>"; // 로그 아웃
        $a_member_register      ="<a href='#' style='display:none'>"; // 회원 가입
        $_scroll = ( $member_update_scroll_yn == 'Y' ) ? "yes" : "no";
        $a_member_update        ="<a href='#' onClick=\"window.open('" . $baseDir ."member_register.php?mexec=update','_dboard_m_update','width=$member_update_popup_width,height=$member_update_popup_height,toolbar=no,scrollbars=$_scroll');return false;\">"; // 회원 가입
        $_scroll = ( $member_secession_scroll_yn == 'Y' ) ? "yes" : "no";
        $a_member_secession     ="<a href='#' onClick=\"window.open('" . $baseDir ."member_secession.php','_dboard_m_secession','width=$member_secession_popup_width,height=$member_secession_popup_height,toolbar=no,scrollbars=$_scroll');return false;\">"; // 회원 탈퇴
        $a_member_infor_search  ="<a href='#' style='display:none'>"; // 회원 정보 찾기
    } else {
        $a_login ="<a href='" . $cur_page . "$a_params&lg=Y'>"; // 로그 인
        $a_logout="<a href='#' style='display:none'>"; // 로그 아웃
        $_scroll = ( $member_register_scroll_yn == 'Y' ) ? "yes" : "no";
        $a_member_register     ="<a href='#' onClick=\"window.open('" . $baseDir ."member_register.php?mexec=insert','_dboard_m_register','width=$member_register_popup_width,height=$member_register_popup_height,toolbar=no,scrollbars=$_scroll');return false;\">";
        $a_member_update       ="<a href='#' style='display:none'>"; // 회원 수정
        $a_member_secession    ="<a href='#' style='display:none'>"; // 회원 탈퇴
        $_scroll = ( $member_infor_search_scroll_yn == 'Y' ) ? "yes" : "no";
        $a_member_infor_search ="<a href='#' onClick=\"window.open('" . $baseDir ."member_infor_search.php','_dboard_m_infor_search','width=$member_infor_search_popup_width,height=$member_infor_search_popup_height,toolbar=no,scrollbars=$_scroll');return false;\">"; // 회원 정보 찾기
    }

    if ( $admin_yn == 'Y' && $exec == 'list' ) {
        $admin_header          = "\n<form name='adminForm' method='post'><input name='id' type='hidden' value='".$id . "'><input name='s' type='hidden' value='". $s . "'><input name='tot' type='hidden' value='" . $tot . "'><input name='search'        type='hidden' value='" . $search . "'><input name='search_cond'   type='hidden' value='" . $search_cond . "'><input name='no' type='hidden' value='" . $no . "'><input name='p_exec' type='hidden' value='" . $exec . "'><input name='exec' type='hidden' value=''><input name='a_no' type='hidden' value=''><input name='a_gno' type='hidden' value=''><input name='a_id' type='hidden' value=''>\n";
        echo $admin_header; // 어드민 헤더 출력
        $admin_bbs_list_box    = _admin_bbsListBox ($id);
        $a_bbs_data_move   = '<a href="#" onClick="adminDataMove();return false;"   >';
        $a_bbs_data_delete = '<a href="#" onClick="adminDataDelete();return false;" >';
        $a_bbs_data_copy   = '<a href="#" onClick="adminDataCopy();return false;"   >';

        $admin_footer      = "</form>";
        echo $admin_footer; // 어드민 풋터 출력
    } else {
        $a_bbs_data_move   = "<a href='#' style='display:none'>";
        $a_bbs_data_delete = "<a href='#' style='display:none'>";
        $a_bbs_data_copy   = "<a href='#' style='display:none'>";
    }

    $hide_area_s = "<!--";$hide_area_e = "-->"; // 영역 없애
    if ( $admin_yn != 'Y' ) { $show_admin_yn_s = "<!--"; $show_admin_yn_e = "-->";} // 관리자 여부
    if ( $admin_yn == 'Y' ) { $hide_admin_yn_s = "<!--"; $hide_admin_yn_e = "-->";} // 관리자 여부

    if ( $login_yn != 'Y' ) { $show_login_s    = "<!--"; $show_login_e = "-->";} // 로그인 여부
    if ( $login_yn == 'Y' ) { $hide_login_s    = "<!--"; $hide_login_e = "-->";} // 로그인 여부

    include 'board_setup_default.inc'  ; // 기본 설정
    if ( file_exists($skinDir .'setup.php' ) ) {
        include $skinDir .'setup.php'                   ; // 스킨 관련 설정
        $skin_copy_right = ' / skin ' . $skin_copy_right;
    }
}
?>