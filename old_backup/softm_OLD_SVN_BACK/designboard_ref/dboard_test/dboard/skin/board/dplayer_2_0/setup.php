<?
/* ------- ��Ų ���� ------------------------------------ */
$skin_copy_right = "<a href='http://www.designboard.net' target='_blank'>designboard</a>";

// �Է� ó���� �̵� ������
// '1' : list
// '2' : view
// '3' : insert
$write_move_page = "1";

// �˻��� ����
$search_start_tag = '<font color="#BF0909">';
$search_end_tag   = '</font>';

// �ǰ߱� �� �±�
$tot_comment_start_tag = ' <font face="tahoma" size="1"> [';
$tot_comment_end_tag   = ']</font>';

// �ֱٿ� �ö�� �ǰ߱ۿ����� ǥ��
$new_comment_tag       = ' <font color="#FF0000">+</font>';

// ������ �˾� â ũ��
$mail_popup_width       = 515; // �� ���� �˾� ���� ����
$mail_popup_height      = 638; // �� ���� �˾� ���� ����

// ȸ�� ���� �˾� â ũ��
$member_register_popup_width     = 616; // ���� ����
$member_register_popup_height    = 550; // ���� ����

// ȸ�� ���� �˾� â ũ��
$member_update_popup_width       = 616; // ���� ����
$member_update_popup_height      = 550; // ���� ����

// ȸ�� ��й�ȣ ���̵� ã�� �˾� â ũ��
$member_infor_search_popup_width = 500; // ���� ����
$member_infor_search_popup_height= 193; // ���� ����

// ȸ�� Ż�� �˾� â ũ��
$member_secession_popup_width    = 400; // ���� ����
$member_secession_popup_height   = 205; // ���� ����

// ���� ����Ʈ ���� ��Ÿ��
$admin_list_box_script = 'style="font-face:����;font-size:12px;background:#F7F7F7"';

// �ؽ�Ʈ ���� ����
$name_limit            = 12   ; // �̸� Ÿ��Ʋ ���� ���߱�
$name_cut_tag          = ' ..'; // �̸� ���� ���� ǥ�� ���� [����Ʈ ȭ�鸸 ����]

$title_cut_tag         = '...'; // ���� ���� ���� ǥ�� ����
$content_cut_tag       = '...'; // ���� ���� ���� ǥ�� ����

$list_cursor_tag       = '<img src="' . $skinDir . 'images/arrow.gif">'; // ���� �а� �ִ� �ڷ��� ��ġ

/* -------------------- �̹��� ���� ���� -------------------- */
$image_auto_load_yn      = 'Y';  // ���� ������ �̹��� �ڵ� ǥ�� ���� ( 'Y' / 'N' )

// _image_display_mode
// 1 : ȭ�鿡 �̹��� ũ�� �ڵ� ����
// 2 : _image_width, _image_height ������ �̹��� ũ�� ����
$list_image_display_mode        = '2'     ;  // ���
$view_image_display_mode        = '1'     ;  // ����

$list_width_many                = 2       ;  // ���� ����

$list_image_width               = '100'   ;  // ��� ������ �̹��� ����
$list_image_height              = '100'      ;  // ��� ������ �̹��� ����
$view_image_width               = '500'      ;  // ���� ������ �̹��� ����
$view_image_height              = '200'      ;  // ���� ������ �̹��� ����

// _image_display_mode
// 1 : ȭ�鿡 �̹��� ũ�� �ڵ� ����
// 2 : _image_width, _image_height ���� ���� ũ�� ����
// 3 : popup_width, popup_height�� â�� ���� popup_image_width, popup_image_height �̹��� ũ�� ����
$popup_image_display_mode       = '1'     ;  // �˾�
$popup_image_width              = '500'   ;  // �˾� ������ �̹��� ����
$popup_image_height             = '400'   ;  // �˾� ������ �̹��� ����

$popup_width                    = '700'   ;  // �˾� ����
$popup_height                   = '500'   ;  // �˾� ����

// �̹��� �˾��� �⺻������ �̹��� ũ�⿡ ���߾� �˾��� ���� �˴ϴ�.
// ��Ų�� �����Ͽ������ �ٸ� ���������� ��ҵ��� �ݿ��Ǿ������.
// ���̳� ���̰� �� �þ����츦 �����Ͽ� �̺κп� �ȼ� ������ ũ�⸦ �����ϸ� �˴ϴ�.
$image_popup_plus_width         = '0'     ; // �̹��� �˾��� �̹��� ũ�� �������� �߰��� ����
$image_popup_plus_height        = '0'     ; // �̹��� �˾��� �̹��� ���� �������� �߰��� ����

/* -------------------- ��Ƽ �̵�� ���� ���� -------------------- */
$mutimedia_auto_play_yn         = 'Y'     ; // ���� ��Ƽ�̵�� �ڵ� ��� ���� ( 'Y' / 'N' )

$mutimedia_player_show          = 'Y'     ; // Player ǥ�� ����
$mutimedia_player_autostart     = 'Y'     ; // Player �ڵ� ��� ����
$mutimedia_player_loop          = 'Y'     ; // Player ��ȯ ����
$mutimedia_player_width         = ''      ; // Player ���������� ����
$mutimedia_player_height        = ''      ; // Player ���������� ����

$mutimedia_popup_width          = '400'   ; // �˾� ����
$mutimedia_popup_height         = '400'   ; // �˾� ����

$mutimedia_popup_player_width   = ''      ; // �˾� Player ���������� ����
$mutimedia_popup_player_height  = ''      ; // �˾� Player ���������� ����

$multimedia_player = 'Y';
/* ������ �� ���� */
// $page_tab['pre'              ] = "[���� $page_many]";
// $page_tab['next'             ] = "[���� $page_many]";
$page_tab['pre'              ] = '<img src="' . $skinDir . 'images/icon_prev.gif" width="17" height="16" align="absmiddle" border="0">&nbsp;'; // ����
$page_tab['next'             ] = '&nbsp;<img src="' . $skinDir . 'images/icon_next.gif" width="17" height="16" align="absmiddle" border="0">'; // ����
$page_tab['pre_1'            ] = ""      ; // ����
$page_tab['next_1'           ] = ""      ; // ����

$page_tab['page_sep'         ] = ""      ; // ���������� ��ȣ
$page_tab['page_start'       ] = " ["    ; // ������ ǥ�� ���� [1] <<-- [
$page_tab['page_end'         ] = "] "    ; // ������ ǥ�� ��   [1] <<-- ]
$page_tab['page_pre'         ] = ""      ; // ������ �� [*����* 1]
$page_tab['page_next'        ] = ""      ; // ������ �� [1 *����*]
$page_tab['page_start_active'] = "<b>"   ; // ���� ������ ���� �±�
$page_tab['page_end_active'  ] = "</b>"  ; // ���� ������ ���� �±�

// $a_play     = "<a href='#' onClick=\"window.open('dplayer.php?id=" . $id . "','','scrollbars=no');\">"; // �÷��̾�
$a_single_add_cart = "";
$a_single_del_cart = "";
$a_single_play     = "";

if ( $grant == 'Y' && $exec == 'list' ) {
    $a_cart_play = "<a href='#' onClick=\"DP_cartMediaPlay  ('" . $id . "');return false;\" target='_dboard_iframe'>";
    $a_all_play = "<a href='#' onClick=\"DP_allMediaPlay   ('" . $id . "');return false;\" target='_dboard_iframe'>";
    $a_whole_play = "<a href='#' onClick=\"DP_WholePlay('" . $id . "');return false;\" target='_dboard_iframe'>";
    $a_random_play = "<a href='#' onClick=\"DP_randomMediaPlay('" . $id . "');return false;\" target='_dboard_iframe'>";

    $a_all_select  = "<a href='#' onClick=\"DP_checkedAll     ();return false;\" target='_dboard_iframe'>";

    $a_multi_add_cart = "<a href='#' onClick=\"DP_addMediaCart('MA','" . $id . "');return false;\" target='_dboard_iframe'>";
    $a_multi_del_cart = "<a href='#' onClick=\"DP_delMediaCart('MD','" . $id . "');return false;\" target='_dboard_iframe'>";

    $a_single_add_cart_tmp = "<a href='#' onClick=\"DP_addMediaCart(";
    $a_single_del_cart_tmp = "<a href='#' onClick=\"DP_delMediaCart(";
    $a_single_play_tmp = "<a href='#' onClick=\"DP_singleMediaPlay(";

} else {
    $a_cart_play = "<a href='#' style='display:none'>";
    $a_all_play = "<a href='#' style='display:none'>";
    $a_random_play = "<a href='#' style='display:none'>";
    $a_all_select = "<a href='#' style='display:none'>";

    $a_multi_add_cart = "<a href='#' style='display:none'>";
    $a_multi_del_cart = "<a href='#' style='display:none'>";

    $a_single_add_cart_tmp = "<a href='#' onClick=\"DP_addMediaCart(";
    $a_single_del_cart_tmp = "<a href='#' onClick=\"DP_delMediaCart(";
    $a_single_play_tmp = "<a href='#' onClick=\"DP_singleMediaPlay(";
}
?>
<table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" align="center">
<tr><td colspan='2' height="5"></td></tr>

<td valign=top>
<table border="0" cellspacing="0" cellpadding="0">
<tr>

<?=$hide_category_s     ?>
<form method='POST' onSubmit='return searchFormSubmit(this);'>
<td>
<?
    /* ī�װ� ���� */
    $category_setup['title'             ]   = "ī�װ�";
    $category_setup['item_align'        ]   = ""        ; // ī�װ� �׸� ���� ��� ( left(�⺻) / right )
    $category_setup['script'            ]   = "onChange='searchFormSubmit(this.form);this.form.submit();'"  ; // ��ũ��Ʈ
    $category_setup['properties'        ]   = "class=admin_listbox"        ; // ī�װ� html �Ӽ�
    $category_setup['start_tag'         ]   = ""        ; // ī�װ� �� ó�� �±�
    $category_setup['loop_start_tag'    ]   = ""        ; // ī�װ� �׸� ó��   �±�
    $category_setup['loop_end_tag'      ]   = ""        ; // ī�װ� �׸� ������ �±�
    $category_setup['end_tag'           ]   = ""        ; // ī�װ� �� ������ �±�
    $category_setup['active_start_tag'  ]   = "<B>"     ; // ī�װ� ���� �׸� ó��   �±�
    $category_setup['active_end_tag'    ]   = "</B>"    ; // ī�װ� ���� �׸� ������ �±�
/* A �±׸� �̿��� Ŭ���� �˻�  */
//  $category_setup['script'            ]   = "onClick='document.PageForm.search_cat_no.value=this.value;document.PageForm.submit();'"  ; // ��ũ��Ʈ
//  $category_setup['properties'        ]   = "href='#' "; // ī�װ� html �Ӽ�

/* üũ   ���� �˻�             */
//  $category_setup['script'            ]   = "onMouseUp='searchFormSubmit(this.form);this.form.submit();'"  ; // ��ũ��Ʈ

/* ���� ���� �˻�             */
//  $category_setup['script'            ]   = "onClick='searchFormSubmit(this.form);this.form.submit();'"  ; // ��ũ��Ʈ

/* ����Ʈ ���� �˻�             */
//  $category_setup['script'            ]   = "onChange='searchFormSubmit(this.form);this.form.submit();'"  ; // ��ũ��Ʈ
?>
    <?=createCategory ('S','SELECT')?>
</td>
</form>
<td width=5></td>
<?=$hide_category_e     ?>

<?=$show_admin_yn_s?>
<td>
<? /* ������ �Խù� ���� ���� */ ?>
            <?=$admin_bbs_list_box   ?> <?// �Խ��� ���� ����Ʈ ����?>
            <?=$a_bbs_data_copy  ?><img src="<?=$skinDir?>images/admin_copy.gif"   border='0' align='absmiddle'></a> <?// �Խù� ���� ��ư       ?>
            <?=$a_bbs_data_delete?><img src="<?=$skinDir?>images/admin_delete.gif" border='0' align='absmiddle'></a> <?// �Խù� ���� ��ư       ?>
<? /* ------------------------------------------------------------ */ ?>
</td>
<?=$show_admin_yn_e?>
</tr>
</table>

<?=$hide_area_s?>
<?=$a_bbs_data_move  ?><img src="<?=$skinDir?>images/admin_move.gif"   border='0' align='absmiddle'></a>
<?// �Խù� �̵� ��ư       ?>
        </td>
<?=$hide_area_e?>

<td>&nbsp;</td>
<td align='right' class='text_01'>

<?=$a_all_play?><img src="<?=$skinDir?>images/button_all_listen.gif" border=0></a>
<?=$a_whole_play?><img src="<?=$skinDir?>images/button_all_listen.gif" border=0></a>
<?=$a_random_play?><img src="<?=$skinDir?>images/button_radom_listen.gif" border=0></a>
<?=$a_all_select?><img src="<?=$skinDir?>images/button_check_all.gif" border=0></a>
<?=$a_multi_del_cart?><img src="<?=$skinDir?>images/button_check_cancel.gif" border=0></a>
<?=$a_multi_add_cart?><img src="<?=$skinDir?>images/button_check_up.gif" border=0></a>
<?=$a_cart_play?><img src="<?=$skinDir?>images/button_check_listen.gif" border=0></a>
</td>
</tr>
</table>