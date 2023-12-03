<?
if ( function_exists('_head') ) {
   include $baseDir ."common/search.inc"; // 검색 관련 공통
   include $baseDir ."common/anchor_reference.inc"; // 앵커 관련 공통 ( 전부다 이 파일에 적용된것은 아님 )

// Sequence 번호를 사용할 경우
    $print_no = $tot - $s + 2; // 현재 보여지는 번호.
    $inner_print_no = $print_no;

    $sql  = "select * from $tb_bbs_data" . "_" . $id ;
//  $sql  = "select no, cat_no, g_no, depth, pre_no, next_no, user_id, member_level, name, title, content, e_mail, home, f_path1, f_name1, f_ext1, f_size1, f_date1, f_path2, f_name2, f_ext2, f_size2, f_date2, reg_date, use_st, html_yn, mail_yn, hit, down_hit1, down_hit2, total_comment, comment_date from $tb_bbs_data" . "_" . $id ;
    $sql .= $where;

    if ( $sort == 'no' || $sort == 'cat_no' || $sort == 'name' || $sort == 'title' || $sort == 'hit' || $sort == 'down_hit1' || $sort == 'down_hit2' || $sort == 'reg_date' || $sort == 'file1' || $sort == 'file2' ) {
        if ( $sort == 'file1' ) $sort = 'f_name1';
        if ( $sort == 'file2' ) $sort = 'f_name2';
        if ( $desc == 'desc' ) {
            $sql .= " order by $sort desc";
        } else {
            $sql .= " order by $sort";
        }
    } else {
        if ( !$search ) {
            $sql .= " order by g_no, o_seq";
        } else {
            $sql .= " order by g_no, o_seq";
        }
    }

    $sql .= " limit " . ( $s - 1 ) . ", " . $cur_many;
//	echo $sql;
/*
    $stmt = @mysql_query      ($sql);
    while ( $data = mysql_fetch_array($stmt, MYSQL_ASSOC ) ) {
*/

    $stmt = multiRowSQLQuery ($sql);
    while ( $data = multiRowFetch  ($stmt) ) {
        $no         = $data['no'       ];   /* 게시물 번호 */

// Sequence 번호를 사용할 경우
        $inner_print_no--;
        $print_no = $inner_print_no;
        $a_view   = $a_view_tmp . $no . "','" . $inner_print_no . "');return false;\">";

/* 내부 번호를 사용할 경우 */
//      $print_no = $no;
//      $a_view    .= $a_view_tmp . $no . "','" . $no . "');return false;\">";

    /* ----- 값 설정 ------------------------------------ */
        $cat_no     = $data['cat_no'   ]; /* 카테고리 번호    */
        $cat_name   = $category ['name'][$cat_no];   /* 카테고리 명 */
        if ( $bbsInfor['use_category'] == 'Y' ) {
            $a_cat_search = $a_cat_search_tmp . $cat_no . "');return false;\">";
        }
        $g_no       = $data['g_no'     ]; /* 그룹아이디       */
        $admin_no   = $g_no . '_' . $no ; /* 어드민 게시물 번호 */

        $a_single_add_cart = $a_single_add_cart_tmp . "'SA','" . $id . "','" . $admin_no . "');return false;\" target='_dboard_iframe'>";
        $a_single_del_cart = $a_single_del_cart_tmp . "'SD','" . $id . "','" . $admin_no . "');return false;\" target='_dboard_iframe'>";
        $a_single_play     = $a_single_play_tmp     . "'" . $id . "','" . $admin_no . "');return false;\" target='_dboard_iframe'>";

        $depth      = $data['depth'    ]; /* 답변레벨         */
        $pre_no     = $data['pre_no'   ]; /* 이전 게시물 번호 */
        $next_no    = $data['next_no'  ]; /* 이후 게시물 번호 */
//      $o_seq      = $data['o_seq'    ]; /* 정렬 순서        */
        $w_member_level = $data['member_level']; /* 회원 레벨   */
        $w_user_id  = $data['user_id'  ];   /* 사용자 ID        */
        if ( $bbsGrant['grant_write'] == 'Y' && ( ($w_user_id && $memInfor['user_id' ] == $w_user_id) || (!$w_user_id && $admin_yn == 'N') || ($admin_yn == 'Y' && $use_st < 8) ) ) {          // 수정
            $a_update ="<a href='" . getReqPageName () . "$a_params&exec=update&no=$no'>";
        } else { $a_update = "<a href='#' onClick='return false;' style='display:none'>"; }

        if ( $bbsGrant['grant_answer'] == 'Y' && $use_st != 0 && $use_st < 8 ) { // 답변
            $a_answer ="<a href='" . getReqPageName () . "$a_params&exec=answer&no=$no'>";
        } else { $a_answer = "<a href='#' onClick='return false;' style='display:none'>"; }

        if ( $bbsGrant['grant_write'] == 'Y' && ( ($w_user_id && $memInfor['user_id' ] == $w_user_id) || (!$w_user_id && $admin_yn == 'N') || ($admin_yn == 'Y' && $use_st < 8) ) ) {          // 삭제
                $a_delete ="<a href='" . getReqPageName () . "$a_params&exec=delete&no=$no'>";
        } else { $a_delete = "<a href='#' onClick='return false;' style='display:none'>"; }
        $user_id    = $w_user_id;

        $name       = $data['name'  ];
        if ( $name_limit > 0 ) {
            $name = curString($name, $name_limit  , $name_cut_tag); // 이름 타이틀 길이 맞추기
        }

        $title      = $data['title'  ];
        if ( $title_limit > 0 ) {
            $title = curString($title, $title_limit  , $title_cut_tag); // 타이틀 길이 맞추기
        }

        $content    = $data['content'];
        $e_mail     = $data['e_mail' ];
        $home       = $data['home'   ];
        $f_path1    = $data['f_path1'];
        $f_name1    = $data['f_name1'];
        $f_ext1     = $data['f_ext1' ];
        $f_size1    = $data['f_size1'];
        $f_date1    = $data['f_date1'];

        $f_path2    = $data['f_path2'];
        $f_name2    = $data['f_name2'];
        $f_ext2     = $data['f_ext2' ];
        $f_size2    = $data['f_size2'];
        $f_date2    = $data['f_date2'];

        $file_preview1 = '';
        $file_preview2 = '';

        $reg_date   = substr($data['reg_date' ], 0,14);
        $reg_year   = substr($data['reg_date' ], 0 ,4);
        $reg_month  = substr($data['reg_date' ], 4 ,2);
        $reg_day    = substr($data['reg_date' ], 6 ,2);
        $reg_hour   = substr($data['reg_date' ], 8 ,2);
        $reg_min    = substr($data['reg_date' ], 10,2);
        $reg_sec    = substr($data['reg_date' ], 12,2);
        $html_yn    = $data['html_yn'   ];
        $mail_yn    = $data['mail_yn'   ];
        $use_st     = $data['use_st'    ];
//      $recom_hit  = $data['recom_hit' ];
        $hit        = $data['hit'       ];
        $down_hit1  = $data['down_hit1' ];
        $down_hit2  = $data['down_hit2' ];
        $link1      = $data['link1'    ];   /* 링크1 */
        $link2      = $data['link2'    ];   /* 링크2 */

        $total_comment = $data['total_comment'];
        $comment_date  = $data['comment_date' ];
        $current_time  = getYearToSecond();

        if ( $total_comment > 0 ) {
            $comment_icon_date = getDateAdd($current_time,'DAY', -1);
            // 당일 의견글 + 표시
            $hide_comment_icon_s = ""; $hide_comment_icon_e = "";
            if ( !$displayList[8] || $comment_icon_date > $comment_date ) {
                $hide_comment_icon_s = "<!--"; $hide_comment_icon_e = "-->";
            }
            $total_comment = $tot_comment_start_tag . $total_comment . $tot_comment_end_tag;
        } else {
            $total_comment = '';
            $hide_comment_icon_s = "<!--"; $hide_comment_icon_e = "-->";
        }

        if ( $html_yn == 'B' ) {    // HTML <BR> 지원
            $content = nl2br ( $content );   /* 내용 */
        } else if ( $html_yn != 'Y' ) {     // HTML 지원 안함
            $content = str_replace("  ", "&nbsp;&nbsp;", $content );
            $content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$content );
            $content = str_replace("<","&lt;",$content);
            $content = nl2br ( $content );   /* 내용 */
        }

        $tmp_name = $name;

        searchWord(); // 검색단어 활성화

        $new_icon_date = getDateAdd($current_time,'DAY', -1);

        // 새글
        $hide_new_s = ""; $hide_new_e = "";
        if ( !$displayList[7] || $new_icon_date > substr($reg_date,0,14) ) {
            $hide_new_s = "<!--"; $hide_new_e = "-->";
        }

        $hide_open_s = '<!--'; $hide_open_e = '-->';
        if ( $use_st == 1 ) { // 비공개글
            $hide_open_s = ''; $hide_open_e = '';
        }

        $character = '';    // 회원 아이콘
        $character = printMemberIcon($w_member_level          , $w_user_id, $displayList[9] ); // 회원 아이콘

        $a_e_mail = emailAncrhor($w_user_id, $w_member_level, $e_mail, $name, $mailSendMethod, $mail_popup_width, $mail_popup_height);
        $a_home   = homeAncrhor($home);
        $a_member_view = memberAncrhor($w_user_id, $member_view_mode, $member_view_succ_url, $member_view_popup_width, $member_view_popup_height, $member_view_scroll_yn);
        $a_member_layer_box = memberLayerAncrhor($w_user_id, $name, $w_member_level);

        $a_file1_popup = '<a href=# style="display:none">';
        $a_file2_popup = '<a href=# style="display:none">';
        $a_file1       = '<a href=# style="display:none">';
        $a_file2       = '<a href=# style="display:none">';

        if ( $f_name1 ) {
            $f_size1  = f_size($f_size1);
            $f_name1  = $f_name1 . '.' . $f_ext1;
            $f_infor1 = $baseDir . "data/file/" . $id. "/$f_date1.$f_ext1"; // 파일 실제 경로
            $file_preview1 = makeImageLink     ($f_infor1, $f_ext1, $list_image_display_mode, $list_image_width, $list_image_height, $image_auto_load_yn);
            if ( !$file_preview1 ) {
                $file_preview1 = makeMultiMediaLink($f_infor1, $f_ext1, $list_image_width, $list_image_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                if ( $file_preview1 ) $a_file1_popup = "<a href='" . $baseDir . "file_view.php?id=$id&no=$no&gubun=1&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
            } else {
                $a_file1_popup = "<a href='" . $baseDir . "file_view.php?id=$id&no=$no&gubun=1&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
            }
            $a_file1 = "<a href='" . $baseDir . "download.php?id=$id&no=$no&gubun=1' target='_dboard_iframe'>";
        } else {
            $f_size1  = '';
            $f_name1  = '';
            $f_infor1 = '';
            $file_preview1 = '';
        }

        if ( $f_name2 ) {
            $f_size2  = f_size($f_size2);
            $f_name2  = $f_name2 . '.' . $f_ext2;
            $f_infor2 = $baseDir . "data/file/" . $id. "/$f_date2.$f_ext2"; // 파일 실제 경로
            $file_preview2 = makeImageLink     ($f_infor2, $f_ext2, $list_image_display_mode, $list_image_width, $list_image_height, $image_auto_load_yn);
            if ( !$file_preview2 ) {
                $file_preview2 = makeMultiMediaLink($f_infor2, $f_ext2, $list_image_width, $list_image_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                if ( $file_preview2 ) $a_file2_popup = "<a href='" . $baseDir . "file_view.php?id=$id&no=$no&gubun=2&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
            } else {
                $a_file2_popup = "<a href='" . $baseDir . "file_view.php?id=$id&no=$no&gubun=2&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
            }
            $a_file2 = "<a href='" . $baseDir . "download.php?id=$id&no=$no&gubun=2' target='_dboard_iframe'>";
        } else {
            $f_size2  = '';
            $f_name2  = '';
            $f_infor2 = '';
            $file_preview2 = '';
        }

        $a_link1_popup = '<a href=# style="display:none">';
        $a_link2_popup = '<a href=# style="display:none">';
        $a_link1       = '<a href=# style="display:none">';
        $a_link2       = '<a href=# style="display:none">';
        if ( $link1 ) {
            $ext1 = getFileExtraName($link1);
            $link_preview1 = makeImageLink     ($link1, $ext1, $list_image_display_mode, $list_image_width, $list_image_height, $image_auto_load_yn);
            if ( !$link_preview1 ) {
                $link_preview1 = makeMultiMediaLink($link1, $ext1, $list_image_width, $list_image_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                if ( $link_preview1 ) $a_link1_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$no&gubun=1&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
            } else {
                $a_link1_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$no&gubun=1&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
            }
            $a_link1 = ( ereg( 'http://', $link1 ) ) ? '<a href="' . $link1 . '" target="_blank">' : '<a href="http://' . $link1 . '" target="_blank">';
        } else {
            $link1 = '';
            $link_preview1 = '';
        }

        if ( $link2 ) {
            $ext2 = getFileExtraName($link2);
            $link_preview2 = makeImageLink     ($link2, $ext2, $list_image_display_mode, $list_image_width, $list_image_height, $image_auto_load_yn);
            if ( !$link_preview2 ) {
                $link_preview2 = makeMultiMediaLink($link2, $ext2, $list_image_width, $list_image_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                if ( $link_preview2 ) $a_link2_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$no&gubun=2&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
            } else {
                $a_link2_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$no&gubun=2&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
            }
            $a_link2 = ( ereg( 'http://', $link2 ) ) ? '<a href="' . $link2 . '" target="_blank">' : '<a href="http://' . $link2 . '" target="_blank">';
        } else {
            $link2 = '';
            $link_preview2 = '';
        }
        if      ( $use_st == 8 ) { $title = '사용자에 의해 삭제'; }
        else if ( $use_st == 9 ) { $title = '관리자에 의해 삭제'; }

        $answer_space = $depth * 8;
        if ( $depth > 0 ) {
            $title = "<img src='".$baseDir."images/timg.gif' height='0' width='".$answer_space."' border='0'><img src='".$skinDir."images/icon_reply.gif' border='0'>" . $title;
        }

        if ( $chk_no == $no ) { $print_no = $list_cursor_tag; }
        if ( $use_st == 0 ) {
            include $skinDir ."list_ann.php" ;
        } else {
            include $skinDir ."list_main.php";
        }
    }
    $character = '';
}
?>