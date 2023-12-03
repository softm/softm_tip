<?
if ( function_exists('head') ) {
    $_sessionStart = getMicroSecond();

    $sql  = "select * from $tb_bbs_data" . "_" . $notice_id ;
    if ( !$displayList[9] ) {
        $sql .= " where use_st != 1" ;
        if ( $cat_no ) { $sql .= " and cat_no = '$cat_no'" ; }
    } else {
        if ( $cat_no ) { $sql .= " where cat_no = '$cat_no'" ; }
    }

    $sql .= " order by no desc" ;

    $start_pos = (int ) $start_pos - 1;
    $end_pos   = (int ) $end_pos   - 1;
    if ( $start_pos < 0 ) {  $start_pos = 1;  }
    if ( $end_pos   < 0 ) {  $end_pos   = 1;  }

    $sql .= ' limit ' . ( (int) $start_pos ) . ',' . ( $end_pos - $start_pos + 1 ) . ';' ;
    if ( !$notice_popup_width   ) $notice_popup_width    = 500;
    if ( !$notice_popup_height  ) $notice_popup_height   = 550;

    $stmt = multiRowSQLQuery ($sql);
    while ( $data = multiRowFetch  ($stmt) ) {
    /* ----- 값 설정 ------------------------------------ */
        $notice_no  = $data['no'       ];   /* 게시물 번호      */
        $cat_no     = $data['cat_no'   ];   /* 카테고리 번호    */
        $cat_name   = $category ['name'][$cat_no];   /* 카테고리 명 */

        if ( $display_mode == 1 ) {
            $a_view = $a_view_tmp . "$notice_no','$notice_id');return false;\">";
        } else if ( $display_mode == 2 ) {
            $a_view = $a_view_tmp . "$notice_no');return false;\">";
        } else {
            $a_view = $a_view_tmp . $notice_no . "'\">";
        }
//      $g_no       = $data['g_no'     ];
        $depth      = $data['depth'    ];
        $pre_no     = $data['pre_no'   ];
        $next_no    = $data['next_no'  ];
//      $o_seq      = $data['o_seq'    ];

        $w_member_level = $data['member_level']; /* 회원 레벨   */
        $w_user_id  = $data['user_id'  ];   /* 사용자 ID        */
        $user_id    = $w_user_id;

        $name       = $data['name'     ];
        if ( $name_limit > 0 ) {
            $name = curString($name, $name_limit  , $name_cut_tag); // 이름 타이틀 길이 맞추기
        }
//      $password   = $data['password' ];
        $title      = $data['title'    ];
        if ( $title_limit > 0 ) {
            $title      = curString($title, $title_limit  , $title_cut_tag    ); // 타이틀 길이 맞추기
        }
        $content    = $data['content'  ];   /* 내용             */
        if ( $content_limit > 0 ) {
            $content    = curString($content, $content_limit, $content_cut_tag); // 내용   길이 맞추기
        }
        $e_mail     = $data['e_mail'    ];
        $home       = $data['home'      ];
        $f_path1    = $data['f_path1'   ];
        $f_name1    = $data['f_name1'   ];
        $f_ext1     = $data['f_ext1'    ];
        $f_size1    = $data['f_size1'   ];
        $f_date1    = $data['f_date1'   ];

        $f_path2    = $data['f_path2'   ];
        $f_name2    = $data['f_name2'   ];
        $f_ext2     = $data['f_ext2'    ];
        $f_size2    = $data['f_size2'   ];
        $f_date2    = $data['f_date2'   ];

        $reg_date   = $data['reg_date'  ];   /* 작성 및 변경일자 */
        $reg_year   = substr($reg_date, 0 ,4);
        $reg_month  = substr($reg_date, 4 ,2);
        $reg_day    = substr($reg_date, 6 ,2);
        $reg_hour   = substr($reg_date, 8 ,2);
        $reg_min    = substr($reg_date, 10,2);
        $reg_sec    = substr($reg_date, 12,2);
        $html_yn    = $data['html_yn'   ];   /* Html 사용여부    */
//      $mail_yn    = $data['mail_yn'   ];   /* 답변 확인 메일   */
        $use_st     = $data['use_st'    ];   /* 글 상태          */
//      $recom_hit  = $data['recom_hit' ];   /* 추천 수          */
        $hit        = $data['hit'       ];   /* 조회수           */
        $down_hit1  = $data['down_hit1' ];   /* 다운수1          */
        $down_hit2  = $data['down_hit2' ];   /* 다운수2          */
        $link1      = $data['link1'     ];   /* 링크1 */
        $link2      = $data['link2'     ];   /* 링크2 */

        $total_comment = $data['total_comment']; /* 코멘트 수    */
        $comment_date  = $data['comment_date' ]; /* 의견글 마지막 작성일자 */

        $comment_icon_date = getDateAdd(getYearToSecond(),'DAY', -1);

        $name   = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$name  ); //＜＞
        $e_mail = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$e_mail); //＜＞
        $home   = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$home  ); //＜＞
        $title  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$title ); //＜＞
        $link1  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$link1 ); //＜＞
        $link2  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$link2 ); //＜＞

        $icon_sec   = '';

        if ( $total_comment > 0 ) {
            // 당일 의견글 + 표시
            if ( !$displayList[8] || $comment_icon_date > $comment_date ) {
                $hide_comment_icon_s     = "<!--"; $hide_comment_icon_e     = "-->";
            } else {
                $hide_comment_icon_s     = ""    ; $hide_comment_icon_e     = ""   ;
            }
            $total_comment = $tot_comment_start_tag . $total_comment . $tot_comment_end_tag;
        } else {
            $total_comment = '';
            $hide_comment_icon_s     = "<!--"; $hide_comment_icon_e     = "-->";
        }

        $tmp_name = $name;

        if ( $html_yn == 'B' ) { // HTML <BR>  [B]
        	$content = nl2br ( $content );   /* 내용 */
        } else if ( $html_yn == 'Y' ) { // HTML [Y]
        } else { // PLAN TEXT [N]
        	$content = str_replace("  ", "&nbsp;&nbsp;", $content );
        	$content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",$content );
        	$content = str_replace("<","&lt;",$content);
        	$content = nl2br ( $content );   /* 내용 */
        }

        $new_icon_date = getDateAdd(getYearToSecond(),'DAY', $new_comment_day*-1);

        // 새글
        if ( !$displayList[7] || $new_icon_date > substr($reg_date,0,14) ) {
            $hide_new_s = "<!--"; $hide_new_e = "-->";
        } else {
            $hide_new_s = ""    ; $hide_new_e = ""   ;
        }

        if ( $use_st == 1 ) {    // 비공개글
            $icon_sec = '<img src="' . $skinDir . '/images/icon_sec.gif'.'"/>';
            $hide_open_s = ""    ; $hide_open_e = ""   ;
            $hide_new_s = "<!--"; $hide_new_e = "-->";
        } else {
            $hide_open_s = "<!--"; $hide_open_e = "-->";
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
                $file_preview1 = makeMultiMediaLink($f_infor1, $f_ext1, $mutimedia_player_width, $mutimedia_popup_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                if ( $file_preview1 ) $a_file1_popup = "<a href='" . $baseDir . "file_view.php?id=$id&no=$notice_no&gubun=1&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
            } else {
                $a_file1_popup = "<a href='" . $baseDir . "file_view.php?id=$id&no=$notice_no&gubun=1&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
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
                $file_preview2 = makeMultiMediaLink($f_infor2, $f_ext2, $mutimedia_player_width, $mutimedia_popup_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                if ( $file_preview2 ) $a_file2_popup = "<a href='" . $baseDir . "file_view.php?id=$id&no=$notice_no&gubun=2&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
            } else {
                $a_file2_popup = "<a href='" . $baseDir . "file_view.php?id=$id&no=$notice_no&gubun=2&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
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
                $link_preview1 = makeMultiMediaLink($link1, $ext1, $mutimedia_player_width, $mutimedia_popup_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                if ( $link_preview1 ) $a_link1_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$notice_no&gubun=1&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
            } else {
                $a_link1_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$notice_no&gubun=1&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
            }
            $a_link1 = ( preg_match( '/http:\/\//i', $link1 ) ) ? '<a href="' . $link1 . '" target="_blank">' : '<a href="http://' . $link1 . '" target="_blank">';
        } else {
            $link1 = '';
            $link_preview1 = '';
        }

        if ( $link2 ) {
            $ext2 = getFileExtraName($link2);
            $link_preview2 = makeImageLink     ($link2, $ext2, $list_image_display_mode, $list_image_width, $list_image_height, $image_auto_load_yn);
            if ( !$link_preview2 ) {
                $link_preview2 = makeMultiMediaLink($link2, $ext2, $mutimedia_player_width, $mutimedia_popup_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                if ( $link_preview2 ) $a_link2_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$notice_no&gubun=2&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
            } else {
                $a_link2_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$notice_no&gubun=2&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
            }
            $a_link2 = ( preg_match( '/http:\/\//i', $link2 ) ) ? '<a href="' . $link2 . '" target="_blank">' : '<a href="http://' . $link2 . '" target="_blank">';
        } else {
            $link2 = '';
            $link_preview2 = '';
        }

        if ( file_exists($skinDir ."notice_list_main.php") ) {
            include $skinDir ."notice_list_main.php"; // 공지 리스트 Main  스킨 ( 순환 부분 )
        } else {
            Message('S', '0038',"");   // 추출 부분에서 skin_name이 지정안되거나 잘못 된경우
        }
    }
    $exe = $_sessionEnd - $_sessionStart;
    logs ( "<!--\n시작 시간 : " . $_sessionStart . "\n", true);
    logs ( "\n종료 시간 : " . $_sessionEnd   . "\n", true);
    logs ( "\n실행 시간 : " . sprintf("%0.3f",getMicroSecond()-$_sessionStart) . "\n-->", true);
}
?>