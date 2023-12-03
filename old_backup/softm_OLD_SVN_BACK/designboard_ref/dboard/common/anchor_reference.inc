<?
if( defined("_dboard_anchor_ref_included") ) return;
	define ("_dboard_anchor_ref_included", true);

function emailAncrhor($user_id, $member_level, $e_mail, $name, $sendMethod, $popup_width, $popup_height) {
	global $package, $id;
    
	// 메일 설정
	if ( $sendMethod == '1' ) {// 폼메일
		if ( $e_mail ) {
			if ( !$popup_width  ) { $popup_width  = 533; }
			if ( !$popup_height ) { $popup_height = 500; }
			$a_e_mail = "<a href='#' onClick='openFormMail(\"$package\",\"$id\",\"$member_level\",\"$user_id\",\"". base64_encode($name) . "\", \"" . base64_encode($e_mail) . "\",$popup_width, $popup_height);return false;'>";
		} else {
			$a_e_mail = '<a>';
		}
	} else {// 아웃룩
		if ( $e_mail ) {
//		  $name = "<a href='mailto:$e_mail'>$name</a>";
			$a_e_mail = "<a href='#' onClick='openOutLookMail(\"$package\",\"$id\",\"" . base64_encode($e_mail) . "\");return false;'>";
		} else {
			$a_e_mail = '<a>';
		}
	}
    return $a_e_mail;
}

function homeAncrhor($home) {
	global $hide_home_s, $hide_home_e;
    $a_home='';
	// 홈페이지 설정
	// ^http://(([a-zA-Z0-9])+(\.)?){2,}
	if ( $home ) {
		$a_home = ( ereg( 'http://', $home ) ) ? '<a href="' . $home . '" target="_blank">' : '<a href="http://' . $home . '" target="_blank">';
	} else { $hide_home_s		= "<!--"; $hide_home_e		= "-->"; }
    return $a_home;
}

function memberAncrhor($user_id, $mode, $succ_url, $popup_width, $popup_height, $scroll_yn) {
    global $baseDir;
    $a_member_view='';
    $_scroll = ( $scroll_yn == 'Y' ) ? "yes" : "no";
    if ( $mode == '1' ) $a_member_view ="<a href='#' onClick=\"window.open ('" . $baseDir . "member_view.php?user_id=$user_id', '_d_m_view','width=$popup_width,height=$popup_height,toolbar=no,scrollbars=$_scroll');return false;\">";
    else if ( $mode == '2' ) $a_member_view ="<a href='" . $baseDir . "member_view.php?user_id=$user_id'>";
    return $a_member_view;
}

function memberLayerAncrhor($user_id, $name, $member_level) {
	global $package, $id, $e_mail, $home, $mailSendMethod,
            $member_layer_box_use, $member_layer_box_event, $mail_popup_width, $mail_popup_height,
			$member_view_mode, $member_view_succ_url, $member_view_popup_width, $member_view_popup_height, $member_view_scroll_yn;

    $a_member_layer_box='';
	// 클릭 : 'click', 오버 : 'over'
	if ( $member_layer_box_use == 'Y' ) {
		if ( $member_layer_box_event )  {
			$a_member_layer_box  ="<a href='#' on" . $member_layer_box_event . "='memberLayerBox (\"$package\", \"$id\",";
			$a_member_layer_box .="\"$user_id\"	, ";
			$a_member_layer_box .="\"$mailSendMethod\",\"" . base64_encode($e_mail) . "\", \"". base64_encode($name) . "\", \"$member_level\", \"$mail_popup_width\", \"$mail_popup_height\", \"$home\", \"$member_view_mode\", \"$member_view_succ_url\", \"$member_view_popup_width\", \"$member_view_popup_height\", \"$member_view_scroll_yn\" );return false;'";
			$a_member_layer_box .= " onClick='return false;'>"	; // 회원 정보 레이어
		} else {
			$a_member_layer_box = '<a>';
		}
	}
    return $a_member_layer_box;
}

function makeImageLink($path_infor, $ext, $mode, $width, $height, $auto_load_yn) {
    $inforStr='';
	if ( $ext && strpos("[bmp, gif, jpg, jpeg, png, pcx, wbmp]", strtolower ($ext) ) > 0 ) {
		if ( $auto_load_yn == 'Y' ) {
			$inforStr = '<img name="_d_display_obj" src="' . $path_infor . '"';
			if ( $mode == '2' ) {
				$inforStr .= ( $width  ) ? " width='"  . $width  . "'" : ' ';
				$inforStr .= ( $height ) ? " height='" . $height . "'" : ' ';
			}
			$inforStr .= ' border=0>';
		}
	}
    return $inforStr;
}

function makeMultiMediaLink($path_infor, $ext, $width, $height,$player_show, $player_autostart, $player_loop, $auto_load_yn) {
    $inforStr = '';
	if ( $ext && strpos('[aiff, asf, asx, au, avi, mid, midi, mp3, mp2, mpg, mpga, mpeg, ra, ram, snd, swf, wav, wmv, wmf, wmv, wma]', strtolower ($ext) ) > 0 ) {
		if ( $auto_load_yn == 'Y' ) {
			$inforStr  = '<embed name="_dboard_display_obj" src="' . $path_infor . '"';
			$inforStr .= ( $player_show      == 'Y' ) ? " hidden=false"	: ' hidden=true'	;
			$inforStr .= ( $player_autostart == 'Y' ) ? " autostart=true" : ' autostart=false';

			if ( $player_loop == 'Y' ) { // 무한 루프
				$inforStr .= " loop=-1" ;
			} else if ( $player_loop == 'N' ) { // 한번 재생
				$inforStr .= " loop";
			} else {// 순환 횟수 지정
				$inforStr .= " loop=" . $player_loop;
			}

			if ( strtolower ($ext) == 'swf' ) { // 플래쉬 파일
				$size = @GetImageSize($path_infor);
				if($size[0] == 0 ) $size[0]=1;
				if($size[1] == 0 ) $size[1]=1;
                $inforStr .= ( !$width  ) ? " width="   . $size[0] : " width="   . $width ;
                $inforStr .= ( !$height ) ? " height="  . $size[1] : " height="  . $height;
			} else {
				$inforStr .= ( $width ) ? " width="  . $width : ' ';
				if ( strpos("[wav, mp3, mp2]", strtolower ($ext) ) == false ) { // 음악 파일은 높이 조정안함
					$inforStr .= ( $height ) ? " height=" . $height: ' ';
				}
			}
			$inforStr .= '></embed>';
		}
	}
    return $inforStr;
}
?>