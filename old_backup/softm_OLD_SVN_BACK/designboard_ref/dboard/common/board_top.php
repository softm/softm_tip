<?
if ( function_exists('_head') ) {
    $chk_no = $no; // ���� �а� �ִ� �ڷ� �˻縦
    if ( strpos($exec, '_exec') == false ) {
        include 'js/common_js.php'; // ���� javascript
        include 'js/board_common_js.php'; // ���� javascript
        if ( $npop == 'Y' ) { // ���� ǲ��
            include ( $baseDir . 'data/html/_dnotice_header_' . $id . '.php' );
        } else {
            if ( $bbsInfor['design_method'] == '1' ) {
                include ( $baseDir . 'data/html/_dboard_header_' . $id . '.php' );
            }
        }
    }

    if ( $exec == 'insert' ) { $title   =""; $content =""; }

    $package = 'board'; // ��Ű������ ���� ( ���� )
    $no = $chk_no; // ��� �������� ������ ���ԵǾ����� ��� ������ �������� ����ϴ� ���� �ذ�

    $title_limit = $bbsInfor['title_limit']; // ����������� (��)
    if ( $bbsInfor['table_width_unit'] == 1 ) $table_unit = "%"; else $table_unit = ''; // ���̺� ����
    $table_width = $bbsInfor['table_width'] . $table_unit; // �Խ��� ����
    $mailSendMethod = $bbsInfor['mail_send_method']; // �̸��� �߼����� ( ������ : '1' , e_mail : '2' )

    $_skinName = $bbsInfor['skin_name']; // ��Ų��
    $skinDir   = $baseDir . 'skin/board/' . $_skinName . '/'   ;
    $libDir    = $baseDir . "common/lib/" . $sysInfor["driver"] . '/';
    _css ($skinDir); // css ����

    // �Խ��� ����
    $login_yn = $memInfor['login_yn']; // �α��� ����
    $admin_yn = $memInfor['admin_yn']; // ���� ����
    $user_id  = $memInfor['user_id' ]; // ���̵�

    // ���� ����
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

    if ( strpos($bbsInfor['operator_id'], $user_id . '\'') ) { // �ο�� ���� ����
        $grant    = 'Y'; // �⺻ ������ ���� ( ���, ���� ���� )
        $admin_yn = 'Y';
        $bbsGrant['grant_list'   ] = 'Y';  // ���   ����
        $bbsGrant['grant_view'   ] = 'Y';  // ����   ����
        $bbsGrant['grant_write'  ] = 'Y';  // ����   ����
        $bbsGrant['grant_answer' ] = 'Y';  // �亯   ����
        $bbsGrant['grant_comment'] = 'Y';  // �ǰ߱� ����
        $bbsGrant['grant_down'   ] = 'Y';  // �ٿ�   ����
    }

    $hide_category_s = "<!--"; $hide_category_e = "-->";
    $a_cat_search="<a href='#' style='display:none'>";
    if ( $bbsInfor['use_category'] == 'Y' && strpos($exec, "_exec") == false ) {
        $hide_category_s = ""; $hide_category_e = "";
        $category = getCategory ($id); // ī�װ�
        $a_cat_search='';
        $a_cat_search_tmp="<a href='#' onClick=\"categoryLinkSearch('";
    }

    // �Խù� ���� ��ȸ
    if ( $no && ( $exec == 'view' || $exec == 'view_exec' || $exec == 'view_check_exec' || $exec == 'update' || $exec == 'answer' ) ) {
        $chk_password = $password; // ��й�ȣ �˻�
        include $libDir . 'bbs_one_row_retrive.php'; // �Խù� �Ѱ� ��ȸ
    }

    // ��ũ ����
    appendParam ($a_params,'id'  ,$id   );
    appendParam ($a_params,'s'   ,$s    );
    appendParam ($a_params,'npop',$npop );
    if ( $exec != 'list' && $no ) appendParam ($a_params,'no',$no); // �Խù� ��ȣ

    if ( $desc == 'desc' ) $desc = 'asc' ; else $desc = 'desc';

    $cur_page = getReqPageName (); // ���� ������
    $a_check_box     ="<a href='#' onClick='checkedAll ();return false;'>"                       ;  // üũ ����
    $a_sort_no       ="<a href='#' onClick='sortPage(\"no\",\"$desc\");return false;' onFocus='this.blur()'>";  // ��ȣ
    $a_sort_cat_no   ="<a href='#' onClick='sortPage(\"cat_no\",\"$desc\");return false;' onFocus='this.blur()'>";  // ī�װ� ��ȣ
    $a_sort_name     ="<a href='#' onClick='sortPage(\"name\",\"$desc\");return false;' onFocus='this.blur()'>";  // �̸�
    $a_sort_title    ="<a href='#' onClick='sortPage(\"title\",\"$desc\");return false;' onFocus='this.blur()'>";  // ����
    $a_sort_hit      ="<a href='#' onClick='sortPage(\"hit\",\"$desc\");return false;' onFocus='this.blur()'>";  // ��ȸ
    $a_sort_down_hit1="<a href='#' onClick='sortPage(\"down_hit1\",\"$desc\");return false;' onFocus='this.blur()'>";  // �����1
    $a_sort_down_hit2="<a href='#' onClick='sortPage(\"down_hit2\",\"$desc\");return false;' onFocus='this.blur()'>";  // �����2
    $a_sort_reg_date ="<a href='#' onClick='sortPage(\"reg_date\",\"$desc\");return false;' onFocus='this.blur()'>";  // ��¥
    $a_sort_file1    ="<a href='#' onClick='sortPage(\"file1\",\"$desc\");return false;' onFocus='this.blur()'>";  // ����1
    $a_sort_file2    ="<a href='#' onClick='sortPage(\"file2\",\"$desc\");return false;' onFocus='this.blur()'>";  // ����2

    if ( $bbsGrant['grant_list'] == 'Y' ) {
        $a_list  ="<a href='#' onClick=\"listPage();return false;\">";  // ����Ʈ
    } else {
        $a_list = "<a href='#' style='display:none'>";
    }

    $a_file  =''; // ���� ��ũ

    if ( $bbsGrant['grant_write'] == 'Y' ) {     // ����
        $a_insert ="<a href='" . $cur_page . "$a_params&exec=insert'>";
    } else {
        $a_insert ="<a href='#'  style='display:none'>";
    }

    $a_update = '';
    $a_answer = '';
    $a_delete = '';

    $a_view = ''; // �б�
    $a_view_tmp ="<a href='#' onClick=\"viewPage('";

    $a_delete_comment = ''; // view_comment.php ���� �̿�

    $a_cancle = "<a href='javascript:history.back();'>";

    $a_pre_list  = "<a href='#' style='display:none'>"; // ���� ������
    $a_next_list = "<a href='#' style='display:none'>"; // ���� ������

    $a_pre_view  = "<a >"; // ���� ��
    $a_next_view = "<a >"; // ���� ��
    $a_download  = "<a href='download.php?id=$id&no=";

    $use_default_login = $bbsInfor['use_default_login'];
    $login_skin_name   = '';
    if ( $use_default_login == 'Y' ) {
        $login_skin_name   = $sysInfor['login_skin'];
    } else {
        $login_skin_name   = $bbsInfor['login_skin_name'];
    }
    $loginSkinDir= $baseDir . 'skin/login/' . $login_skin_name . '/';

    include 'login_setup_default.inc'; // �⺻ ����

    if ( file_exists($loginSkinDir .'setup.php' ) ) {
        include $loginSkinDir .'setup.php'       ; // ��Ų ���� ����
    }

    if ( $login_yn == 'Y' ) {
        $a_login ="<a href='#' style='display:none'>"; // �α� ��
        $a_logout="<a href='" . $baseDir . "logout_ok.php$a_params'>"; // �α� �ƿ�
        $a_member_register      ="<a href='#' style='display:none'>"; // ȸ�� ����
        $_scroll = ( $member_update_scroll_yn == 'Y' ) ? "yes" : "no";
        $a_member_update        ="<a href='#' onClick=\"window.open('" . $baseDir ."member_register.php?mexec=update','_dboard_m_update','width=$member_update_popup_width,height=$member_update_popup_height,toolbar=no,scrollbars=$_scroll');return false;\">"; // ȸ�� ����
        $_scroll = ( $member_secession_scroll_yn == 'Y' ) ? "yes" : "no";
        $a_member_secession     ="<a href='#' onClick=\"window.open('" . $baseDir ."member_secession.php','_dboard_m_secession','width=$member_secession_popup_width,height=$member_secession_popup_height,toolbar=no,scrollbars=$_scroll');return false;\">"; // ȸ�� Ż��
        $a_member_infor_search  ="<a href='#' style='display:none'>"; // ȸ�� ���� ã��
    } else {
        $a_login ="<a href='" . $cur_page . "$a_params&lg=Y'>"; // �α� ��
        $a_logout="<a href='#' style='display:none'>"; // �α� �ƿ�
        $_scroll = ( $member_register_scroll_yn == 'Y' ) ? "yes" : "no";
        $a_member_register     ="<a href='#' onClick=\"window.open('" . $baseDir ."member_register.php?mexec=insert','_dboard_m_register','width=$member_register_popup_width,height=$member_register_popup_height,toolbar=no,scrollbars=$_scroll');return false;\">";
        $a_member_update       ="<a href='#' style='display:none'>"; // ȸ�� ����
        $a_member_secession    ="<a href='#' style='display:none'>"; // ȸ�� Ż��
        $_scroll = ( $member_infor_search_scroll_yn == 'Y' ) ? "yes" : "no";
        $a_member_infor_search ="<a href='#' onClick=\"window.open('" . $baseDir ."member_infor_search.php','_dboard_m_infor_search','width=$member_infor_search_popup_width,height=$member_infor_search_popup_height,toolbar=no,scrollbars=$_scroll');return false;\">"; // ȸ�� ���� ã��
    }

    if ( $admin_yn == 'Y' && $exec == 'list' ) {
        $admin_header          = "\n<form name='adminForm' method='post'><input name='id' type='hidden' value='".$id . "'><input name='s' type='hidden' value='". $s . "'><input name='tot' type='hidden' value='" . $tot . "'><input name='search'        type='hidden' value='" . $search . "'><input name='search_cond'   type='hidden' value='" . $search_cond . "'><input name='no' type='hidden' value='" . $no . "'><input name='p_exec' type='hidden' value='" . $exec . "'><input name='exec' type='hidden' value=''><input name='a_no' type='hidden' value=''><input name='a_gno' type='hidden' value=''><input name='a_id' type='hidden' value=''>\n";
        echo $admin_header; // ���� ��� ���
        $admin_bbs_list_box    = _admin_bbsListBox ($id);
        $a_bbs_data_move   = '<a href="#" onClick="adminDataMove();return false;"   >';
        $a_bbs_data_delete = '<a href="#" onClick="adminDataDelete();return false;" >';
        $a_bbs_data_copy   = '<a href="#" onClick="adminDataCopy();return false;"   >';

        $admin_footer      = "</form>";
        echo $admin_footer; // ���� ǲ�� ���
    } else {
        $a_bbs_data_move   = "<a href='#' style='display:none'>";
        $a_bbs_data_delete = "<a href='#' style='display:none'>";
        $a_bbs_data_copy   = "<a href='#' style='display:none'>";
    }

    $hide_area_s = "<!--";$hide_area_e = "-->"; // ���� ����
    if ( $admin_yn != 'Y' ) { $show_admin_yn_s = "<!--"; $show_admin_yn_e = "-->";} // ������ ����
    if ( $admin_yn == 'Y' ) { $hide_admin_yn_s = "<!--"; $hide_admin_yn_e = "-->";} // ������ ����

    if ( $login_yn != 'Y' ) { $show_login_s    = "<!--"; $show_login_e = "-->";} // �α��� ����
    if ( $login_yn == 'Y' ) { $hide_login_s    = "<!--"; $hide_login_e = "-->";} // �α��� ����

    include 'board_setup_default.inc'  ; // �⺻ ����
    if ( file_exists($skinDir .'setup.php' ) ) {
        include $skinDir .'setup.php'                   ; // ��Ų ���� ����
        $skin_copy_right = ' / skin ' . $skin_copy_right;
    }
}
?>