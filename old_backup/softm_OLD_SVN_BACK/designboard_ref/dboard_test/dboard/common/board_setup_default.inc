<?
// �Է� ó���� �̵� ������
// '1' : list
// '2' : view
// '3' : insert
$write_move_page = "2";

$search_start_tag = '<font color="#BF0909">'; // �˻��� Ȱ��ȭ �±� [����]
$search_end_tag   = '</font>'; // �˻��� Ȱ��ȭ �±� [��]
$tot_comment_start_tag = ' <font face="tahoma" size="1"> ['; // �ǰ߱� �� �±�
$tot_comment_end_tag   = ']</font>';
$new_comment_tag       = ' <font color="#FF0000">+</font>'; // �ֱٿ� �ö�� �ǰ߱ۿ����� ǥ��

// ������ �˾� â ũ��
$mail_popup_width       = 515; // �� ���� �˾� ���� ����
$mail_popup_height      = 638; // �� ���� �˾� ���� ����

// ���� ����Ʈ ���� ��Ÿ��
$admin_list_box_script = 'style="font-face:����;font-size:12px;background:#F7F7F7"';

// �ؽ�Ʈ ���� ����
$name_limit            = 12   ; // �̸� Ÿ��Ʋ ���� ���߱�
$name_cut_tag          = ' ..'; // �̸� ���� ���� ǥ�� ���� [����Ʈ ȭ�鸸 ����]
$title_cut_tag         = '...'; // ���� ���� ���� ǥ�� ����
$content_cut_tag       = '...'; // ���� ���� ���� ǥ�� ����
$list_cursor_tag       = '<img src="' . $skinDir . 'images/arrow.gif">'; // ���� �а� �ִ� �ڷ��� ��ġ

// �̹��� ���� ����
$image_auto_load_yn      = 'Y';  // ���� ������ �̹��� �ڵ� ǥ�� ���� ( 'Y' / 'N' )

// _image_display_mode
// 1 : ȭ�鿡 �̹��� ũ�� �ڵ� ����
// 2 : _image_width, _image_height ������ �̹��� ũ�� ����
$list_image_display_mode = '2'     ;  // ���
$view_image_display_mode = '1'     ;  // ����

$list_width_many         = 2       ;  // ���� ����

$list_image_width        = '100'   ;  // ��� ������ �̹��� ����
$list_image_height       = '100'      ;  // ��� ������ �̹��� ����
$view_image_width        = '500'      ;  // ���� ������ �̹��� ����
$view_image_height       = '200'      ;  // ���� ������ �̹��� ����

// _image_display_mode
// 1 : ȭ�鿡 �̹��� ũ�� �ڵ� ����
// 2 : _image_width, _image_height ���� ���� ũ�� ����
// 3 : popup_width, popup_height�� â�� ���� popup_image_width, popup_image_height �̹��� ũ�� ����
$popup_image_display_mode = '1'     ;  // �˾�
$popup_image_width        = '500'   ;  // �˾� ������ �̹��� ����
$popup_image_height       = '400'   ;  // �˾� ������ �̹��� ����

$popup_width              = '700'   ;  // �˾� ����
$popup_height             = '500'   ;  // �˾� ����

// �̹��� �˾��� �⺻������ �̹��� ũ�⿡ ���߾� �˾��� ���� �˴ϴ�.
// ��Ų�� �����Ͽ������ �ٸ� ���������� ��ҵ��� �ݿ��Ǿ������.
// ���̳� ���̰� �� �þ����츦 �����Ͽ� �̺κп� �ȼ� ������ ũ�⸦ �����ϸ� �˴ϴ�.
$image_popup_plus_width  = '0'     ; // �̹��� �˾��� �̹��� ũ�� �������� �߰��� ����
$image_popup_plus_height = '0'     ; // �̹��� �˾��� �̹��� ���� �������� �߰��� ����

// ��Ƽ �̵�� ���� ����
$mutimedia_auto_play_yn         = 'Y'     ; // ���� ��Ƽ�̵�� �ڵ� ǥ�� ���� ( 'Y' / 'N' )

$mutimedia_player_show         = 'Y'     ; // Player ǥ�� ����
$mutimedia_player_autostart    = 'Y'     ; // Player �ڵ� ��� ����
$mutimedia_player_loop         = 'Y'     ; // Player ��ȯ ����
$mutimedia_player_width        = ''      ; // Player ���������� ����
$mutimedia_player_height       = ''      ; // Player ���������� ����

$mutimedia_popup_width         = '400'   ; // �˾� ����
$mutimedia_popup_height        = '400'   ; // �˾� ����

$mutimedia_popup_player_width  = ''      ; // �˾� Player ���������� ����
$mutimedia_popup_player_height = ''      ; // �˾� Player ���������� ����

$member_layer_box_use          = 'N'     ;  // ��� ���� : 'N', ��� : 'Y'
$member_layer_box_event        = 'click' ;  // Ŭ�� : 'click', ���� : 'mouseover'

$character_icon_width         = '28'   ; // ĳ���� ����
$character_icon_height        = '0'    ; // ĳ���� ����
?>