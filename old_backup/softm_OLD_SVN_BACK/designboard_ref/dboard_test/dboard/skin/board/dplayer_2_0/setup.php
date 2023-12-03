<?
/* ------- 스킨 설정 ------------------------------------ */
$skin_copy_right = "<a href='http://www.designboard.net' target='_blank'>designboard</a>";

// 입력 처리후 이동 페이지
// '1' : list
// '2' : view
// '3' : insert
$write_move_page = "1";

// 검색어 색상
$search_start_tag = '<font color="#BF0909">';
$search_end_tag   = '</font>';

// 의견글 수 태그
$tot_comment_start_tag = ' <font face="tahoma" size="1"> [';
$tot_comment_end_tag   = ']</font>';

// 최근에 올라온 의견글에대한 표시
$new_comment_tag       = ' <font color="#FF0000">+</font>';

// 폼메일 팝업 창 크기
$mail_popup_width       = 515; // 폼 메일 팝업 가로 길이
$mail_popup_height      = 638; // 폼 메일 팝업 세로 높이

// 회원 가입 팝업 창 크기
$member_register_popup_width     = 616; // 가로 길이
$member_register_popup_height    = 550; // 세로 높이

// 회원 수정 팝업 창 크기
$member_update_popup_width       = 616; // 가로 길이
$member_update_popup_height      = 550; // 세로 높이

// 회원 비밀번호 아이디 찾기 팝업 창 크기
$member_infor_search_popup_width = 500; // 가로 길이
$member_infor_search_popup_height= 193; // 세로 높이

// 회원 탈퇴 팝업 창 크기
$member_secession_popup_width    = 400; // 가로 길이
$member_secession_popup_height   = 205; // 세로 높이

// 어드민 리스트 상자 스타일
$admin_list_box_script = 'style="font-face:굴림;font-size:12px;background:#F7F7F7"';

// 텍스트 길이 제한
$name_limit            = 12   ; // 이름 타이틀 길이 맞추기
$name_cut_tag          = ' ..'; // 이름 줄임 이후 표시 문자 [리스트 화면만 적용]

$title_cut_tag         = '...'; // 제목 줄임 이후 표시 문자
$content_cut_tag       = '...'; // 내용 줄임 이후 표시 문자

$list_cursor_tag       = '<img src="' . $skinDir . 'images/arrow.gif">'; // 현재 읽고 있는 자료의 위치

/* -------------------- 이미지 관련 설정 -------------------- */
$image_auto_load_yn      = 'Y';  // 보기 페이지 이미지 자동 표시 여부 ( 'Y' / 'N' )

// _image_display_mode
// 1 : 화면에 이미지 크기 자동 조절
// 2 : _image_width, _image_height 값으로 이미지 크기 조절
$list_image_display_mode        = '2'     ;  // 목록
$view_image_display_mode        = '1'     ;  // 보기

$list_width_many                = 2       ;  // 가로 갯수

$list_image_width               = '100'   ;  // 목록 페이지 이미지 넓이
$list_image_height              = '100'      ;  // 목록 페이지 이미지 높이
$view_image_width               = '500'      ;  // 보기 페이지 이미지 넓이
$view_image_height              = '200'      ;  // 보기 페이지 이미지 높이

// _image_display_mode
// 1 : 화면에 이미지 크기 자동 조절
// 2 : _image_width, _image_height 값에 의한 크기 조절
// 3 : popup_width, popup_height로 창을 열고 popup_image_width, popup_image_height 이미지 크기 조절
$popup_image_display_mode       = '1'     ;  // 팝업
$popup_image_width              = '500'   ;  // 팝업 페이지 이미지 넓이
$popup_image_height             = '400'   ;  // 팝업 페이지 이미지 높이

$popup_width                    = '700'   ;  // 팝업 넓이
$popup_height                   = '500'   ;  // 팝업 높이

// 이미지 팝업시 기본적으로 이미지 크기에 맞추어 팝업을 띄우게 됩니다.
// 스킨을 변경하였을경우 다른 디자인적인 요소들이 반영되었을경우.
// 넓이나 높이가 더 늘어났을경우를 가만하여 이부분에 픽셀 단위의 크기를 지정하면 됩니다.
$image_popup_plus_width         = '0'     ; // 이미지 팝업시 이미지 크기 기준으로 추가될 넓이
$image_popup_plus_height        = '0'     ; // 이미지 팝업시 이미지 높이 기준으로 추가될 높이

/* -------------------- 멀티 미디어 관련 설정 -------------------- */
$mutimedia_auto_play_yn         = 'Y'     ; // 보기 멀티미디어 자동 재생 여부 ( 'Y' / 'N' )

$mutimedia_player_show          = 'Y'     ; // Player 표시 여부
$mutimedia_player_autostart     = 'Y'     ; // Player 자동 재생 여부
$mutimedia_player_loop          = 'Y'     ; // Player 순환 여부
$mutimedia_player_width         = ''      ; // Player 음악조절판 넓이
$mutimedia_player_height        = ''      ; // Player 음악조절판 높이

$mutimedia_popup_width          = '400'   ; // 팝업 넓이
$mutimedia_popup_height         = '400'   ; // 팝업 높이

$mutimedia_popup_player_width   = ''      ; // 팝업 Player 음악조절판 넓이
$mutimedia_popup_player_height  = ''      ; // 팝업 Player 음악조절판 높이

$multimedia_player = 'Y';
/* 페이지 탭 설정 */
// $page_tab['pre'              ] = "[이전 $page_many]";
// $page_tab['next'             ] = "[이후 $page_many]";
$page_tab['pre'              ] = '<img src="' . $skinDir . 'images/icon_prev.gif" width="17" height="16" align="absmiddle" border="0">&nbsp;'; // 이전
$page_tab['next'             ] = '&nbsp;<img src="' . $skinDir . 'images/icon_next.gif" width="17" height="16" align="absmiddle" border="0">'; // 이후
$page_tab['pre_1'            ] = ""      ; // 이전
$page_tab['next_1'           ] = ""      ; // 이후

$page_tab['page_sep'         ] = ""      ; // 페이지구분 기호
$page_tab['page_start'       ] = " ["    ; // 페이지 표시 시작 [1] <<-- [
$page_tab['page_end'         ] = "] "    ; // 페이지 표시 끝   [1] <<-- ]
$page_tab['page_pre'         ] = ""      ; // 페이지 앞 [*여기* 1]
$page_tab['page_next'        ] = ""      ; // 페이지 뒤 [1 *여기*]
$page_tab['page_start_active'] = "<b>"   ; // 선택 페이지 앞쪽 태그
$page_tab['page_end_active'  ] = "</b>"  ; // 선택 페이지 뒷쪽 태그

// $a_play     = "<a href='#' onClick=\"window.open('dplayer.php?id=" . $id . "','','scrollbars=no');\">"; // 플레이어
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
    /* 카테고리 설정 */
    $category_setup['title'             ]   = "카테고리";
    $category_setup['item_align'        ]   = ""        ; // 카테고리 항목 정렬 방식 ( left(기본) / right )
    $category_setup['script'            ]   = "onChange='searchFormSubmit(this.form);this.form.submit();'"  ; // 스크립트
    $category_setup['properties'        ]   = "class=admin_listbox"        ; // 카테고리 html 속성
    $category_setup['start_tag'         ]   = ""        ; // 카테고리 맨 처음 태그
    $category_setup['loop_start_tag'    ]   = ""        ; // 카테고리 항목 처음   태그
    $category_setup['loop_end_tag'      ]   = ""        ; // 카테고리 항목 마지막 태그
    $category_setup['end_tag'           ]   = ""        ; // 카테고리 맨 마지막 태그
    $category_setup['active_start_tag'  ]   = "<B>"     ; // 카테고리 선택 항목 처음   태그
    $category_setup['active_end_tag'    ]   = "</B>"    ; // 카테고리 선택 항목 마지막 태그
/* A 태그를 이용한 클릭시 검색  */
//  $category_setup['script'            ]   = "onClick='document.PageForm.search_cat_no.value=this.value;document.PageForm.submit();'"  ; // 스크립트
//  $category_setup['properties'        ]   = "href='#' "; // 카테고리 html 속성

/* 체크   상자 검색             */
//  $category_setup['script'            ]   = "onMouseUp='searchFormSubmit(this.form);this.form.submit();'"  ; // 스크립트

/* 라디오 상자 검색             */
//  $category_setup['script'            ]   = "onClick='searchFormSubmit(this.form);this.form.submit();'"  ; // 스크립트

/* 리스트 상자 검색             */
//  $category_setup['script'            ]   = "onChange='searchFormSubmit(this.form);this.form.submit();'"  ; // 스크립트
?>
    <?=createCategory ('S','SELECT')?>
</td>
</form>
<td width=5></td>
<?=$hide_category_e     ?>

<?=$show_admin_yn_s?>
<td>
<? /* 관리자 게시물 관리 설정 */ ?>
            <?=$admin_bbs_list_box   ?> <?// 게시판 정보 리스트 상자?>
            <?=$a_bbs_data_copy  ?><img src="<?=$skinDir?>images/admin_copy.gif"   border='0' align='absmiddle'></a> <?// 게시물 복사 버튼       ?>
            <?=$a_bbs_data_delete?><img src="<?=$skinDir?>images/admin_delete.gif" border='0' align='absmiddle'></a> <?// 게시물 삭제 버튼       ?>
<? /* ------------------------------------------------------------ */ ?>
</td>
<?=$show_admin_yn_e?>
</tr>
</table>

<?=$hide_area_s?>
<?=$a_bbs_data_move  ?><img src="<?=$skinDir?>images/admin_move.gif"   border='0' align='absmiddle'></a>
<?// 게시물 이동 버튼       ?>
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