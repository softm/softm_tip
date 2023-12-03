<?
// 공지 팝업 창 크기
$notice_popup_width  = 500; // 공지 팝업 가로 길이
$notice_popup_height = 550; // 공지 팝업 세로 높이

// 의견글 수 태그
$tot_comment_start_tag = ' <font face="tahoma" size="1"> [';
$tot_comment_end_tag   = ']</font>';

// 텍스트 길이 제한
$title_cut_tag         = '...'; // 제목 줄임 이후 표시 문자
$content_cut_tag       = '...'; // 내용 줄임 이후 표시 문자


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
?>