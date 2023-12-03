<?
if ( function_exists('head') ) {
    if ( $exec == 'view' && $grant == 'Y' && !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(view.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
        if ( file_exists($skinDir ."view_main.php" ) ) {

            include "common/search.inc"; // 검색 관련 공통
            include "common/anchor_reference.inc"; // 앵커 관련 공통 ( 전부다 이 파일에 적용된것은 아님 )

    //      if(!preg_match("/${HTTP_HOST}/i",$HTTP_REFERER)) MessageExit('S', '0003',"", $skinDir); // 접근 거부

            $displayView = $bbsInfor['display_view']; // 읽기 표시 항목

            if ( $no ) {
                $print_no = $no;

                if ( $bbsGrant['grant_write'] == 'Y' && ( ($w_user_id && $user_id == $w_user_id) || (!$w_user_id && $admin_yn == 'N') || ($admin_yn == 'Y' && $use_st < 8) ) ) {          // 수정
                    $a_update ="<a href='" . getReqPageName () . "$a_params&exec=update&no=$no'>";
                } else { $a_update = "<a href='#' onClick='return false;' style='display:none'>"; }

                if ( $bbsGrant['grant_answer'] == 'Y' && $use_st != 0 && $use_st < 8 ) {     // 답변
                    $a_answer ="<a href='" . getReqPageName () . "$a_params&exec=answer&no=$no'>";
                } else { $a_answer = "<a href='#' onClick='return false;' style='display:none'>"; }

                if ( $bbsGrant['grant_write'] == 'Y' && ( ($w_user_id && $user_id == $w_user_id) || (!$w_user_id && $admin_yn == 'N') || ($admin_yn == 'Y' && $use_st < 8) ) ) {          // 삭제
                    if ( $exec == 'update' || $exec == 'view' ) {
                        $a_delete ="<a href='" . getReqPageName () . "$a_params&exec=delete&no=$no'>";
                    } else {
                        $a_delete = "<a href='#' onClick='return false;' style='display:none'>";
                    }
                } else { $a_delete = "<a href='#' onClick='return false;' style='display:none'>"; }

                if ( $pre_no  != 0 ) $a_pre_view  = $a_view_tmp . $pre_no  . "');return false;\">";
                if ( $next_no != 0 ) $a_next_view = $a_view_tmp . $next_no . "');return false;\">";

    //////////////////////////////////////////////////////////////////////////////////////////////
                if ( !$sercurity_stats ) {
                    //MessageExitInner('S', '0039',"", $skinDir)   ; // 비공개글
                }

                $hit_cotent_chk       = $_SESSION['hit_cotent_chk'];
                $hit_cotent_stats = preg_match("/%${id}_${no}/", $hit_cotent_chk );

                if ( !$hit_cotent_stats ) {
                    include $libDir . "bbs_one_row_update_exec.php"         ; // 조회수 증가
                    $hit_cotent_chk = '%' . $id .'_' . $no . $hit_cotent_chk;
                    if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0이하
                        @session_register('hit_cotent_chk');
                    } else {
                        $_SESSION['hit_cotent_chk'] = $hit_cotent_chk;  // 4.10 세션 처리.
                    }
                }
    //////////////////////////////////////////////////////////////////////////////////////////////

                if ( ( $use_st != 8 && $use_st != 9 ) || $admin_yn == 'Y' ) {

                    $displayWrite = $bbsInfor['display_write']; // 쓰기 표시 항목
                    $displayList  = $bbsInfor['display_list' ]; // 리스트 표시 항목

                    if ( !$displayWrite[0] ) { $hide_e_mail_s      = "<!--"; $hide_e_mail_e      = "-->";} else { $hide_e_mail_s      = ""; $hide_e_mail_e      = ""; } // 이메일
                    if ( !$displayWrite[1] ) { $hide_home_s        = "<!--"; $hide_home_e        = "-->";} else { $hide_home_s        = ""; $hide_home_e        = ""; } // 홈페이지
                    if ( $displayWrite[2] && $f_name1 ) { // 파일1
                        $hide_file1_s = ""; $hide_file1_e = "";
                    } else {
                        $hide_file1_s = "<!--"; $hide_file1_e       = "-->";
                    }

                    if ( $displayWrite[2] && $f_name2 ) { // 파일2
                        $hide_file2_s = ""; $hide_file2_e = "";
                    } else {
                        $hide_file2_s = "<!--"; $hide_file2_e       = "-->";
                    }

                    if ( $displayWrite[6] && $link1 ) { // 링크1
                        $hide_link1_s = ""; $hide_link1_e = "";
                    } else {
                        $hide_link1_s = "<!--"; $hide_link1_e       = "-->";
                    }

                    if ( $displayWrite[6] && $link2 ) { // 링크2
                        $hide_link2_s = ""; $hide_link2_e = "";
                    } else {
                        $hide_link2_s = "<!--"; $hide_link2_e       = "-->";
                    }

                    if ( !$displayList [4] ) { $hide_down_hit1_s   = "<!--"; $hide_down_hit1_e   = "-->";} else { $hide_down_hit1_s   = ""; $hide_down_hit1_e   = ""; } // 다운수1
                    if ( !$displayList [4] ) { $hide_down_hit2_s   = "<!--"; $hide_down_hit2_e   = "-->";} else { $hide_down_hit2_s   = ""; $hide_down_hit2_e   = ""; } // 다운수2
                    if ( !$displayList [9] ) { $hide_character_s   = "<!--"; $hide_character_e   = "-->";} else {  $hide_character_s  = ""; $hide_character_e   = ""; } // 회원 아이콘

                    $grantCharStr = $bbsInfor['grant_character_image']; // 회원 아이콘 권한
                    $name   = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$name  ); //＜＞
                    $email  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$email ); //＜＞
                    $home   = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$home  ); //＜＞
                    $title  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$title ); //＜＞
                    $link1  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$link1 ); //＜＞
                    $link2  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'＜$2$3',$link2 ); //＜＞
                    if ( $html_yn == 'B' ) { // HTML <BR>  [B]
//                    	$content = autoLink ($content); // 자동 링크
                    	$content = nl2br ( $content );   /* 내용 */
                    } else if ( $html_yn == 'Y' ) { // HTML [Y]
//                    	$content = autoLink ($content); // 자동 링크
                    } else { // PLAN TEXT [N]
                    	$content = autoLink ($content); // 자동 링크
                    }
                    $content = str_replace("<!--?", "<?", $content);
                    if ( $html_yn != 'N' ) { // html
	                    $content = str_replace( '<?', '&lt;?', $content);
	                    $content = str_replace( '?>', '?&gt;', $content);
                    }
                    $content = str_replace("?-->" , "?>", $content);
                    if ( $html_yn == 'N' ) {  // PLAN TEXT [N]
                    	$content = "<pre class='wb'>".$content."</pre>";
                    } else { // HTML <BR>  [B/Y]
                    	$content = "<span class='wb'>".$content."</span>";
                    }

                    $title = curString($title, 150, '...'); // 타이틀 길이 맞추기

                    $character = printMemberIcon($w_member_level          , $w_user_id, $displayList[9] ); // 회원 아이콘

                    searchWord(); // 검색단어 활성화

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
                        $file_preview1 = makeImageLink     ($f_infor1, $f_ext1, $view_image_display_mode, $view_image_width, $view_image_height, $image_auto_load_yn);
                        if ( !$file_preview1 ) {
                            $file_preview1 = makeMultiMediaLink($f_infor1, $f_ext1, $mutimedia_player_width, $mutimedia_popup_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
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
                        $file_preview2 = makeImageLink     ($f_infor2, $f_ext2, $view_image_display_mode, $view_image_width, $view_image_height, $image_auto_load_yn);
                        if ( !$file_preview2 ) {
                            $file_preview2 = makeMultiMediaLink($f_infor2, $f_ext2, $mutimedia_player_width, $mutimedia_popup_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
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
                        $link_preview1 = makeImageLink     ($link1, $ext1, $view_image_display_mode, $view_image_width, $view_image_height, $image_auto_load_yn);
                        if ( !$link_preview1 ) {
                            $link_preview1 = makeMultiMediaLink($link1, $ext1, $mutimedia_player_width, $mutimedia_popup_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                            if ( $link_preview1 ) $a_link1_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$no&gubun=1&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
                        } else {
                            $a_link1_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$no&gubun=1&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
                        }
                        $a_link1 = ( preg_match( '/http:\/\//i', $link1 ) ) ? '<a href="' . $link1 . '" target="_blank">' : '<a href="http://' . $link1 . '" target="_blank">';
                    } else {
                        $link1 = '';
                        $link_preview1 = '';
                    }

                    if ( $link2 ) {
                        $ext2 = getFileExtraName($link2);
                        $link_preview2 = makeImageLink     ($link2, $ext2, $view_image_display_mode, $view_image_width, $view_image_height, $image_auto_load_yn);
                        if ( !$link_preview2 ) {
                            $link_preview2 = makeMultiMediaLink($link2, $ext2, $mutimedia_player_width, $mutimedia_popup_height,$mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_auto_play_yn);
                            if ( $link_preview2 ) $a_link2_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$no&gubun=2&page_gubun=$exec&mode=media&auto_start=$mutimedia_player_autostart&show=$mutimedia_player_show&loop=$mutimedia_player_loop&media_w=$mutimedia_popup_width&media_h=$mutimedia_popup_height&media_player_w=$mutimedia_popup_player_width&media_player_h=$mutimedia_popup_player_height' target='_dboard_iframe'>";
                        } else {
                            $a_link2_popup = "<a href='" . $baseDir . "link_view.php?id=$id&no=$no&gubun=2&page_gubun=$exec&mode=img&display_mode=$popup_image_display_mode&img_w=$popup_image_width&img_h=$popup_image_height&popup_w=$popup_width&popup_h=$popup_height&plus_w=$image_popup_plus_width&plus_h=$image_popup_plus_height' target='_dboard_iframe'>";
                        }
                        $a_link2 = ( preg_match( '/http:\/\//i', $link2 ) ) ? '<a href="' . $link2 . '" target="_blank">' : '<a href="http://' . $link2 . '" target="_blank">';
                    } else {
                        $link2 = '';
                        $link_preview2 = '';
                    }

                    if ( file_exists($skinDir ."view_header.php" ) ) {
                        include $skinDir . "view_header.php"                                       ; // 읽기 헤더
                    }

                    include $skinDir . "view_main.php"                                              ; // 읽기 메인

        //          echo '$displayView[1] : ' . $displayView[1];

                    if ( $displayView[1] ) {   // 이전/다음 글출력
                        if ( file_exists($skinDir ."view_simple_list.php" ) ) {
                            include $libDir  . "view_simple_list.php"; // 이전글 이후글
                            include $skinDir . "view_simple_list.php"; // 읽기 풋터
                        }
                    }

                    $character = '';    // 초기화 [회원 아이콘]

                    if ( $displayView[2] ) {   // 의견달기 ( 보이게하는 옵션 )
                        include $libDir . "view_comment.php"; // 의견 달기 여러건 조회

                        // name 변수가 동일한 이름으로 사용되므로 재 설정 [로그인 이름]
                        $name       = $memInfor['name'    ];
                        if ( $bbsGrant['grant_comment'] ) {
                            include $libDir . "view_write_comment.php"                                  ; // 의견 달기 쓰기
                        }
                    }

                    if ( file_exists($skinDir ."view_footer.php" ) ) {
                        include $skinDir . "view_footer.php"                                            ; // 읽기 풋터
                    }

                    if ( $displayView[0] ) {   // 아래루 쫙 리스트 출력
                        $exec = 'list';
                        include "list.php"; // 리스트
                        $exec = 'view';
                    }

                    if ( $view_image_display_mode == '1' ) {
                        echo ( "\n<script type='text/javascript'>\n var view_image_display_mode= '$view_image_display_mode';\n</SCRIPT>\n" );
                    }
                } else {
                    if (  $use_st == 8 ) { $msgNo = '0031'; } else { $msgNo = '0032'; }
                    Message('S', $msgNo,"", $skinDir);
                }
            } // END if
            else {
                Message('S', '0030',"", $skinDir); // 게시물 없음
            }
        } else {
            Message('S', '0012',"", $skinDir); // 게시물 없음
        }
    //  include $skinDir ."view_footer.php"  ; // 읽기 Footer
    } else {
        // 페이지 접근이 거부 되었습니다.
        Message('S', '0003',"MOVE:" . getReqPageName () . "$a_params&exec=list:이동 ..");
    }
}
?>