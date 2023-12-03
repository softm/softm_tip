<?
// 입력 처리후 이동 페이지
// '1' : list
// '2' : view
// '3' : insert
$write_move_page = "2";

$search_start_tag = '<font color="#BF0909">'; // 검색어 활성화 태그 [시작]
$search_end_tag   = '</font>'; // 검색어 활성화 태그 [끝]
$tot_comment_start_tag = ' <font face="tahoma" size="1"> ['; // 의견글 수 태그
$tot_comment_end_tag   = ']</font>';
$new_comment_tag       = ' <font color="#FF0000">+</font>'; // 최근에 올라온 의견글에대한 표시

// 폼메일 팝업 창 크기
$mail_popup_width       = 515; // 폼 메일 팝업 가로 길이
$mail_popup_height      = 638; // 폼 메일 팝업 세로 높이

// 어드민 리스트 상자 스타일
$admin_list_box_script = 'style="font-face:굴림;font-size:12px;background:#F7F7F7"';

// 텍스트 길이 제한
$name_limit            = 12   ; // 이름 타이틀 길이 맞추기
$name_cut_tag          = ' ..'; // 이름 줄임 이후 표시 문자 [리스트 화면만 적용]
$title_cut_tag         = '...'; // 제목 줄임 이후 표시 문자
$content_cut_tag       = '...'; // 내용 줄임 이후 표시 문자
$list_cursor_tag       = '<img src="' . $skinDir . 'images/arrow.gif">'; // 현재 읽고 있는 자료의 위치

// 이미지 관련 설정
$image_auto_load_yn      = 'Y';  // 보기 페이지 이미지 자동 표시 여부 ( 'Y' / 'N' )

// _image_display_mode
// 1 : 화면에 이미지 크기 자동 조절
// 2 : _image_width, _image_height 값으로 이미지 크기 조절
$list_image_display_mode = '2'     ;  // 목록
$view_image_display_mode = '1'     ;  // 보기

$list_width_many         = 2       ;  // 가로 갯수

$list_image_width        = '100'   ;  // 목록 페이지 이미지 넓이
$list_image_height       = '100'      ;  // 목록 페이지 이미지 높이
$view_image_width        = '500'      ;  // 보기 페이지 이미지 넓이
$view_image_height       = '200'      ;  // 보기 페이지 이미지 높이

// _image_display_mode
// 1 : 화면에 이미지 크기 자동 조절
// 2 : _image_width, _image_height 값에 의한 크기 조절
// 3 : popup_width, popup_height로 창을 열고 popup_image_width, popup_image_height 이미지 크기 조절
$popup_image_display_mode = '1'     ;  // 팝업
$popup_image_width        = '500'   ;  // 팝업 페이지 이미지 넓이
$popup_image_height       = '400'   ;  // 팝업 페이지 이미지 높이

$popup_width              = '700'   ;  // 팝업 넓이
$popup_height             = '500'   ;  // 팝업 높이

// 이미지 팝업시 기본적으로 이미지 크기에 맞추어 팝업을 띄우게 됩니다.
// 스킨을 변경하였을경우 다른 디자인적인 요소들이 반영되었을경우.
// 넓이나 높이가 더 늘어났을경우를 가만하여 이부분에 픽셀 단위의 크기를 지정하면 됩니다.
$image_popup_plus_width  = '0'     ; // 이미지 팝업시 이미지 크기 기준으로 추가될 넓이
$image_popup_plus_height = '0'     ; // 이미지 팝업시 이미지 높이 기준으로 추가될 높이

// 멀티 미디어 관련 설정
$mutimedia_auto_play_yn         = 'Y'     ; // 보기 멀티미디어 자동 표시 여부 ( 'Y' / 'N' )

$mutimedia_player_show         = 'Y'     ; // Player 표시 여부
$mutimedia_player_autostart    = 'Y'     ; // Player 자동 재생 여부
$mutimedia_player_loop         = 'Y'     ; // Player 순환 여부
$mutimedia_player_width        = ''      ; // Player 음악조절판 넓이
$mutimedia_player_height       = ''      ; // Player 음악조절판 높이

$mutimedia_popup_width         = '400'   ; // 팝업 넓이
$mutimedia_popup_height        = '400'   ; // 팝업 높이

$mutimedia_popup_player_width  = ''      ; // 팝업 Player 음악조절판 넓이
$mutimedia_popup_player_height = ''      ; // 팝업 Player 음악조절판 높이

$member_layer_box_use          = 'N'     ;  // 사용 안함 : 'N', 사용 : 'Y'
$member_layer_box_event        = 'click' ;  // 클릭 : 'click', 오버 : 'mouseover'

$character_icon_width         = '28'   ; // 캐릭터 넓이
$character_icon_height        = '0'    ; // 캐릭터 높이
?>