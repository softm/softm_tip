<?
if ( function_exists('head') ) {
	include 'js/member_infor_js.php'; // 회원 정보 보기 관련
?>
    <script type="text/javascript">
    <!--

    if ( typeof (exec) != 'undefined' && ( exec == 'insert' || exec == 'update' || exec == 'answer' ) && typeof( document.writeForm ) == 'object' ) {
        if ( typeof ( document.writeForm.html_yn   ) == 'object' && ( html_yn == 'Y' || html_yn == 'B' ) ) { document.writeForm.html_yn.value = html_yn; document.writeForm.html_yn.checked = true; }
        if ( typeof ( document.writeForm.open_yn   ) == 'object' && use_st	== '1' ) { document.writeForm.open_yn.checked = true; }
        if ( typeof ( document.writeForm.mail_yn   ) == 'object' && mail_yn   == 'Y' && exec != 'answer' ) { document.writeForm.mail_yn.checked = true; }
        if ( typeof ( document.writeForm.ann_yn	) == 'object' && use_st	== '0' ) { document.writeForm.ann_yn.checked  = true; }
    }
    <?
    if ( ($exec == 'list' && $list_image_display_mode == '1') || ($exec == 'view' && $view_image_display_mode == '1') ) {
        echo "window.onload = imageAutoResize;\n";
    }
    ?>
    //-->
    </SCRIPT>
    <?
    $package=$skinDir=$skin_name =''; // 초기화
    if ( strpos($exec, '_exec') == false ) {
        if ( $npop == 'Y' ) { // 공지 풋터
            include ( $baseDir . 'data/html/_dnotice_footer_' . $id . '.php' );
        } else {
            if ( $bbsInfor['design_method'] == '1' ) {
                include ( $baseDir . 'data/html/_dboard_footer_' . $id . '.php' );
            }
        }
        if ( $multimedia_player == 'Y' ) {
            include 'js/dplayer_js.php'; // player javascript
            include ( $baseDir . 'dplayer_cart.php' );
        }
    }
}
?>