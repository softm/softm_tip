<?
if ( function_exists('head') ) {
    if ( $exec == 'view' && $grant == 'Y' && !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(view.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
        if ( file_exists($skinDir ."view_main.php" ) ) {

            include "common/search.inc"; // �˻� ���� ����
            include "common/anchor_reference.inc"; // ��Ŀ ���� ���� ( ���δ� �� ���Ͽ� ����Ȱ��� �ƴ� )

    //      if(!preg_match("/${HTTP_HOST}/i",$HTTP_REFERER)) MessageExit('S', '0003',"", $skinDir); // ���� �ź�

            $displayView = $bbsInfor['display_view']; // �б� ǥ�� �׸�

            if ( $no ) {
                $print_no = $no;

                if ( $bbsGrant['grant_write'] == 'Y' && ( ($w_user_id && $user_id == $w_user_id) || (!$w_user_id && $admin_yn == 'N') || ($admin_yn == 'Y' && $use_st < 8) ) ) {          // ����
                    $a_update ="<a href='" . getReqPageName () . "$a_params&exec=update&no=$no'>";
                } else { $a_update = "<a href='#' onClick='return false;' style='display:none'>"; }

                if ( $bbsGrant['grant_answer'] == 'Y' && $use_st != 0 && $use_st < 8 ) {     // �亯
                    $a_answer ="<a href='" . getReqPageName () . "$a_params&exec=answer&no=$no'>";
                } else { $a_answer = "<a href='#' onClick='return false;' style='display:none'>"; }

                if ( $bbsGrant['grant_write'] == 'Y' && ( ($w_user_id && $user_id == $w_user_id) || (!$w_user_id && $admin_yn == 'N') || ($admin_yn == 'Y' && $use_st < 8) ) ) {          // ����
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
                    //MessageExitInner('S', '0039',"", $skinDir)   ; // �������
                }

                $hit_cotent_chk       = $_SESSION['hit_cotent_chk'];
                $hit_cotent_stats = preg_match("/%${id}_${no}/", $hit_cotent_chk );

                if ( !$hit_cotent_stats ) {
                    include $libDir . "bbs_one_row_update_exec.php"         ; // ��ȸ�� ����
                    $hit_cotent_chk = '%' . $id .'_' . $no . $hit_cotent_chk;
                    if (version_compare(PHP_VERSION, '5.3.0', '<=')) { // 5.3.0����
                        @session_register('hit_cotent_chk');
                    } else {
                        $_SESSION['hit_cotent_chk'] = $hit_cotent_chk;  // 4.10 ���� ó��.
                    }
                }
    //////////////////////////////////////////////////////////////////////////////////////////////

                if ( ( $use_st != 8 && $use_st != 9 ) || $admin_yn == 'Y' ) {

                    $displayWrite = $bbsInfor['display_write']; // ���� ǥ�� �׸�
                    $displayList  = $bbsInfor['display_list' ]; // ����Ʈ ǥ�� �׸�

                    if ( !$displayWrite[0] ) { $hide_e_mail_s      = "<!--"; $hide_e_mail_e      = "-->";} else { $hide_e_mail_s      = ""; $hide_e_mail_e      = ""; } // �̸���
                    if ( !$displayWrite[1] ) { $hide_home_s        = "<!--"; $hide_home_e        = "-->";} else { $hide_home_s        = ""; $hide_home_e        = ""; } // Ȩ������
                    if ( $displayWrite[2] && $f_name1 ) { // ����1
                        $hide_file1_s = ""; $hide_file1_e = "";
                    } else {
                        $hide_file1_s = "<!--"; $hide_file1_e       = "-->";
                    }

                    if ( $displayWrite[2] && $f_name2 ) { // ����2
                        $hide_file2_s = ""; $hide_file2_e = "";
                    } else {
                        $hide_file2_s = "<!--"; $hide_file2_e       = "-->";
                    }

                    if ( $displayWrite[6] && $link1 ) { // ��ũ1
                        $hide_link1_s = ""; $hide_link1_e = "";
                    } else {
                        $hide_link1_s = "<!--"; $hide_link1_e       = "-->";
                    }

                    if ( $displayWrite[6] && $link2 ) { // ��ũ2
                        $hide_link2_s = ""; $hide_link2_e = "";
                    } else {
                        $hide_link2_s = "<!--"; $hide_link2_e       = "-->";
                    }

                    if ( !$displayList [4] ) { $hide_down_hit1_s   = "<!--"; $hide_down_hit1_e   = "-->";} else { $hide_down_hit1_s   = ""; $hide_down_hit1_e   = ""; } // �ٿ��1
                    if ( !$displayList [4] ) { $hide_down_hit2_s   = "<!--"; $hide_down_hit2_e   = "-->";} else { $hide_down_hit2_s   = ""; $hide_down_hit2_e   = ""; } // �ٿ��2
                    if ( !$displayList [9] ) { $hide_character_s   = "<!--"; $hide_character_e   = "-->";} else {  $hide_character_s  = ""; $hide_character_e   = ""; } // ȸ�� ������

                    $grantCharStr = $bbsInfor['grant_character_image']; // ȸ�� ������ ����
                    $name   = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'��$2$3',$name  ); //����
                    $email  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'��$2$3',$email ); //����
                    $home   = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'��$2$3',$home  ); //����
                    $title  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'��$2$3',$title ); //����
                    $link1  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'��$2$3',$link1 ); //����
                    $link2  = preg_replace("/(<\/?)(".TAG_FILTER_TYPE1.")([^>]*>)/i",'��$2$3',$link2 ); //����
                    if ( $html_yn == 'B' ) { // HTML <BR>  [B]
//                    	$content = autoLink ($content); // �ڵ� ��ũ
                    	$content = nl2br ( $content );   /* ���� */
                    } else if ( $html_yn == 'Y' ) { // HTML [Y]
//                    	$content = autoLink ($content); // �ڵ� ��ũ
                    } else { // PLAN TEXT [N]
                    	$content = autoLink ($content); // �ڵ� ��ũ
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

                    $title = curString($title, 150, '...'); // Ÿ��Ʋ ���� ���߱�

                    $character = printMemberIcon($w_member_level          , $w_user_id, $displayList[9] ); // ȸ�� ������

                    searchWord(); // �˻��ܾ� Ȱ��ȭ

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
                        $f_infor1 = $baseDir . "data/file/" . $id. "/$f_date1.$f_ext1"; // ���� ���� ���
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
                        $f_infor2 = $baseDir . "data/file/" . $id. "/$f_date2.$f_ext2"; // ���� ���� ���
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
                        include $skinDir . "view_header.php"                                       ; // �б� ���
                    }

                    include $skinDir . "view_main.php"                                              ; // �б� ����

        //          echo '$displayView[1] : ' . $displayView[1];

                    if ( $displayView[1] ) {   // ����/���� �����
                        if ( file_exists($skinDir ."view_simple_list.php" ) ) {
                            include $libDir  . "view_simple_list.php"; // ������ ���ı�
                            include $skinDir . "view_simple_list.php"; // �б� ǲ��
                        }
                    }

                    $character = '';    // �ʱ�ȭ [ȸ�� ������]

                    if ( $displayView[2] ) {   // �ǰߴޱ� ( ���̰��ϴ� �ɼ� )
                        include $libDir . "view_comment.php"; // �ǰ� �ޱ� ������ ��ȸ

                        // name ������ ������ �̸����� ���ǹǷ� �� ���� [�α��� �̸�]
                        $name       = $memInfor['name'    ];
                        if ( $bbsGrant['grant_comment'] ) {
                            include $libDir . "view_write_comment.php"                                  ; // �ǰ� �ޱ� ����
                        }
                    }

                    if ( file_exists($skinDir ."view_footer.php" ) ) {
                        include $skinDir . "view_footer.php"                                            ; // �б� ǲ��
                    }

                    if ( $displayView[0] ) {   // �Ʒ��� �� ����Ʈ ���
                        $exec = 'list';
                        include "list.php"; // ����Ʈ
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
                Message('S', '0030',"", $skinDir); // �Խù� ����
            }
        } else {
            Message('S', '0012',"", $skinDir); // �Խù� ����
        }
    //  include $skinDir ."view_footer.php"  ; // �б� Footer
    } else {
        // ������ ������ �ź� �Ǿ����ϴ�.
        Message('S', '0003',"MOVE:" . getReqPageName () . "$a_params&exec=list:�̵� ..");
    }
}
?>