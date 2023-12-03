<?
$IJTSEC = ( $HTTP_GET_VARS["baseDir"] || $HTTP_POST_VARS["baseDir"] || $HTTP_GET_VARS["libDir"] || $HTTP_POST_VARS["libDir"] ) ? false : true;
if ( $IJTSEC ) {
    include 'common/lib.inc';
    include 'common/board_lib.inc';  // �Խ��� ���̺귯��
    include 'common/member_lib.inc'; // ��� ���̺귯��
    include 'common/message.inc';
    include 'common/db_connect.inc';
    include 'common/_service.inc';
    include 'common/file.inc';
    include 'common/anchor_reference.inc'; // ��Ŀ ���� ���� ( ���δ� �� ���Ͽ� ����Ȱ��� �ƴ� )

    $memInfor = getMemInfor (); // ȸ�� ����
    $user_id = $memInfor['user_id' ]; // ���̵�

    if(!$_dboard_notice_inc) {
        $_dboard_notice_inc = true;

        boardFormCreate(); // �� ����
        include 'common/js/common_js.php'; // ���� javascript
        include 'common/js/notice_js.php'; // ���� ���� javascript

        // ���� ����
        function createNotice($notice_id, $use_category, $cat_no, $skin_name, $start_pos, $end_pos, $title_limit, $content_limit, $displayList, $display_mode) {
    $_sessionStart = getMicroSecond(); // ���� ���� �ð�
            global $package, $db, $sysInfor, $exec, $baseDir, $user_id, $s, $no, $id, $tb_bbs_data;
            global $notice_popup_width, $notice_popup_height, $notice_no;

            /* ÷�� ���� ��ũ ���� */
           global $a_file1_popup, $file_preview1, $f_name1, $a_file1, $f_size1, $f_infor1, $f_path1, $f_date1, $f_ext1,
                  $a_file2_popup, $file_preview2, $f_name2, $a_file2, $f_size2, $f_infor2, $f_path2, $f_date2, $f_ext2,
                  $image_auto_load_yn, $list_image_display_mode, $view_image_display_mode, $list_width_many, $list_image_width, $list_image_height, $view_image_width, $view_image_height, $popup_image_display_mode, $popup_image_width, $popup_image_height, $popup_width, $popup_height, $image_popup_plus_width, $image_popup_plus_height, $mutimedia_auto_play_yn, $mutimedia_player_show, $mutimedia_player_autostart, $mutimedia_player_loop, $mutimedia_player_width, $mutimedia_player_height, $mutimedia_popup_width, $mutimedia_popup_height, $mutimedia_popup_player_width, $mutimedia_popup_player_height, $member_layer_box_use, $member_layer_box_event;

            $package = 'notice'; // ����

            if ( !$db ) $db = initDBConnection (); // �����ͺ��̽� ����

            $exec = ( !$exec ) ? 'list' : $exec; // ȸ�� ó�� ���� ����
            $id = $notice_id;
            if ( $notice_id )  { // �Խ��� ���� ����
                $hide_category_s = '<!--'; $hide_category_e = '-->';
                if ( $use_category == 'Y' ) {
                    $hide_category_s = ""; $hide_category_e = "";
                    $category = getCategory ($id); // ī�װ�
                }
                $skinDir   = $baseDir . 'skin/notice/' . $skin_name . '/'; // ��Ų��

                _css ($skinDir);   // css ����
			    $bbsInfor = getBbsInfor ($id); // �Խ��� ����

                $hide_no_s        = ''; $hide_no_e        = '';$hide_name_s      = ''; $hide_name_e      = '';
                $hide_title_s     = ''; $hide_title_e     = '';$hide_file1_s     = ''; $hide_file1_e     = '';
                $hide_file2_s     = ''; $hide_file2_e     = '';$hide_hit_s       = ''; $hide_hit_e       = '';
                $hide_down_hit1_s = ''; $hide_down_hit1_e = '';$hide_down_hit2_s = ''; $hide_down_hit2_e = '';
                $hide_reg_date_s  = ''; $hide_reg_date_e  = '';$hide_new_s       = ''; $hide_new_e       = '';
                $hide_comment_s   = ''; $hide_comment_e   = '';$hide_character_s = ''; $hide_character_e = '';
// ���� ����
                if ( !$displayList[0] ) $hide_no_s           = '<!--'; $hide_no_e           = '-->'; // ��ȣ
                if ( !$displayList[1] ) $hide_name_s         = '<!--'; $hide_name_e         = '-->'; // �̸�
                if ( !$displayList[2] ) $hide_title_s        = '<!--'; $hide_title_e        = '-->'; // ����
                if ( !$displayList[3] ) $hide_file1_s        = '<!--'; $hide_file1_e        = '-->'; // ����1
                if ( !$displayList[3] ) $hide_file2_s        = '<!--'; $hide_file2_e        = '-->'; // ����2
                if ( !$displayList[4] ) $hide_hit_s          = '<!--'; $hide_hit_e          = '-->'; // ��ȸ
                if ( !$displayList[5] ) $hide_down_hit1_s    = '<!--'; $hide_down_hit1_e    = '-->'; // �ٿ��1
                if ( !$displayList[5] ) $hide_down_hit2_s    = '<!--'; $hide_down_hit2_e    = '-->'; // �ٿ��2
                if ( !$displayList[6] ) $hide_reg_date_s     = '<!--'; $hide_reg_date_e     = '-->'; // ��¥
                if ( !$displayList[7] ) $hide_new_s          = '<!--'; $hide_new_e          = '-->'; // ����
                if ( !$displayList[8] ) $hide_comment_s      = '<!--'; $hide_comment_e      = '-->'; // �����ǰ߱�
                if ( !$displayList[9] ) $hide_character_s    = '<!--'; $hide_character_e    = '-->'; // ȸ�� ������
// ��ũ ����
                appendParam ($a_params,'notice_id',$id);
                appendParam ($a_params,'s',$s);
                if ( $exec != 'list' && $no ) appendParam ($a_params,'no',$no);

                $a_list  ="<a href='#' onClick=\"listPage();return false;\">"; // ����Ʈ

                $a_file  =''; // ���� ��ũ

                $a_view = ''; // �б�
                $a_view_tmp = '';
                include $baseDir .'common/notice_setup_default.inc'; // �⺻ ����
                if ( file_exists($skinDir ."setup.php") ) {
                    include $skinDir ."setup.php"       ; // ��Ų ���� ����
                }
                if ( $display_mode == 1 ) {
                    $a_view_tmp ="<a href='#' onClick=\"viewNoticePage('". $bbsInfor['design_method'] . "', '";
                } else if ( $display_mode == 2 ) {
                    $a_view_tmp ="<a href='#' onClick=\"viewNoticeOpen('". $bbsInfor['design_method'] ."', '" . $baseDir ."','". $notice_id ."'," . $notice_popup_width . ',' . $notice_popup_height . ",'";
                } else {
                    $a_view_tmp ="<a onClick='return false;' href='#";
                }

                $a_cancle = "<a href='javascript:history.back();'>";

                if ( file_exists($skinDir .'notice_list_header.php') ) {
                    include $skinDir .'notice_list_header.php'; // list Header
                }

                include "common/lib/" . $sysInfor["driver"] . "/list_notice.php"; // ���� ��ȸ

                if ( file_exists($skinDir .'notice_list_footer.php') ) {
                    include $skinDir .'notice_list_footer.php'  ; // list Footer
                }
            } // if END
            else { // ��Ų ���� ����
                head($_title);
                MessageC ('S', '0037'); // �Խñ� ������ ���� ���� �ʽ��ϴ�.
            } // else END
    $_sessionEnd = getMicroSecond();
    logs ( "<!--\n���� �ð� : " . $_sessionStart . "\n", true);
    logs ( "\n���� �ð� : " . $_sessionEnd   . "\n", true);
    logs ( "\n���� �ð� : " . sprintf("%0.3f",$_sessionEnd - $_sessionStart) . "\n-->", true);
        }
    }
}
?>