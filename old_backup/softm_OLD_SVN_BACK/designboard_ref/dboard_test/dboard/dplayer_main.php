<TITLE> D-player </TITLE>
<META name="Title" content="Designboard Music Player">
<META name="Author" content="디자인보드">
<META name="keywords" content="D-Player">
<script type="text/javascript">
<!--
    var dboardEmbed = 'Y'       ; // 변경 불가
    var S_skinName  = "<?=$_skinName?>" ; // 스킨명 스킨 디렉토리명을 입력하세요.
//-->
</SCRIPT>
</HEAD>
<BODY onLoad='DP_onLoad();' onhelp='return false;' oncontextmenu="return false;" ondrag="return false;" onkeydown="return false;" onkeyup='return false;' onkeypress='return false;' text="#000000" leftmargin="0" topmargin="0" bottommargin='0' marginwidth="0" marginheight="0"  style='border: 0px solid black; margin: 0pt;'>
<OBJECT ID="DP_PLAYER" CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" align="middle" style="position:absolute;z-index:2;left:-100px;top:-100px;width:0;height:0">
<!--   Player.closedCaption.captioningID = "captions";
  Player.closedCaption.SAMIFileName = "E:\\러브액츄얼리[Ac3] 2Cd 요청작  2-28\\Love.Actually.2003.CD1.XVID.smi"; -->
    <PARAM name="autoStart"         value="True"        > <!-- 자동 재생                    -->
    <PARAM name="balance"           value="0"           > <!-- 음량 벨런스                  -->
    <PARAM name="captioningID"      value=""            > <!-- 캡션이 표시될 영역의 아이디  -->
    <PARAM name="currentPosition"   value="0"           > <!-- 재생 위치                    -->
    <PARAM name="defaultFrame"      value=""            >
    <PARAM name="enableContextMenu" value="false"       > <!-- 플레이어 오른쪽 버튼 클릭    -->
    <PARAM name="enabled"           value="false"       > <!-- 플레이어 제어 가능성 설정    -->
    <PARAM name="fullScreen"        value="false"       > <!-- Full 스크린 여부             -->
    <PARAM name="invokeURLs"        value="false"       >
    <PARAM name="mute"              value="false"       > <!-- 소리 제거                    -->
    <PARAM name="playCount"         value="1"           > <!-- 재생 횟수 설정               -->
    <PARAM name="rate"              value="1"           > <!-- 재생 속도 설정               -->
    <PARAM name="SAMIFileName"      value=""            > <!-- 자막파일 명                  -->
    <PARAM name="stretchToFit"      value="true"        > <!-- -->
    <PARAM name="volume"            value="100"         > <!-- 볼륨                         -->
	<PARAM name=ShowStatusBar       value=false         >

    <PARAM name="uiMode"            value="none"        > <!-- 재생 화면 형태   -->
<!--    <PARAM name="windowlessVideo"   value="true"   > <!--                              -->
<!--     <PARAM name="URL" value="http://www.softm.net/dboard/data/file/music/200311052129411035.mp3"> <!-- 재생 파일 경로 -->
</OBJECT>
<!-- <div style="Z-INDEX: 7; WIDTH: 0px;HEIGHT: 0px; POSITION: absolute; LEFT: -500px; TOP: -500px;">
</div>
 -->
<!--재생     버튼 --><span id='DP_PLAY_BUTTON'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PLAY ();'></span>
<!--정지     버튼 --><span id='DP_STOP_BUTTON'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_STOP ();'></span>
<!--일시정지 버튼 --><span id='DP_PAUSE_BUTTON'         style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PAUSE();'></span>
<!--이전     버튼 --><span id='DP_PREV_BUTTON'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PREV ();'></span>
<!--다음     버튼 --><span id='DP_NEXT_BUTTON'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_NEXT ();'></span>
<!--뮤트     버튼 --><span id='DP_SOUND'                style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_SOUND();'></span>
<!-- <hr style='background-color:red;width:200;height:5px;top:20;left:400;position:absolute'></hr> -->
<!--볼륨 바       --><span id='DP_VOLUME_BAR'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onMouseDown='DP_VOLUME_BAR_START();' ></span>
<!-- <hr style='background-color:black;width:150;height:5px;top:70;left:400;position:absolute'></hr> -->
<!--재생 바       --><span id='DP_PLAY_BAR'             style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onMouseDown='DP_PLAY_BAR_START();'   ></span>
<!-- <hr style='background-color:green;width:200;height:5px;top:90;left:400;position:absolute'></hr> -->
<!--볼륨 밸런스바 --><span id='DP_BALANCE_BAR'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onMouseDown='DP_BALANCE_BAR_START();'></span>

<!--재생 상태 :   --><span id='DP_PLAY_STATE'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--재생 시간 :   --><span id='DP_TOT_TIME'             style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--남은 시간 :   --><span id='DP_REMIND_TIME'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--제목      :   --><span id='DP_TITLE'                style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>

<!--재생 모드 :   --><span id='DP_PLAY_MODE'            style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PLAY_MODE_CHANGE  ();'></span>
<!--반복 모드 :   --><span id='DP_REPEAT_MODE'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_REPEAT_MODE_CHANGE();'></span>

<!--버퍼링    :   --><span id='DP_BUFFERING'            style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--다운로드  :   --><span id='DP_DOWNLOAD'             style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--볼륨      :   --><span id='DP_VOLUME_PERCENT'       style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--재생바    :   --><span id='DP_PLAY_BAR_PERCENT'     style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--재생 시간 :   --><span id='DP_PLAY_BAR_TIME'        style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--밸런스바  :   --><span id='DP_BALANCE_PERCENT'      style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>

<!--이퀄라이져1 : --><span id='DP_EQUALIZER1'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--이퀄라이져2 : --><span id='DP_EQUALIZER2'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>

<!--재생 목록 :   --><span id='DP_PLAY_LIST_BUTTON'     style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PLAY_LIST    ();'></span>
<!--재생 가사 :   --><span id='DP_PLAY_LYRICS_BUTTON'   style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PLAY_LYRICS  ();'></span>
<!--목록 가사 닫기--><span id='DP_LIST_CLOSE'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_LIST_CLOSE   ();'></span>
<!--닫기      :   --><span id='DP_CLOSE'                style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_CLOSE        ();'></span>

<!--카피라이트:   --><span id='DP_COPYRIGHT'            style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>

<!--풀스크린      --><span id='DP_FULL_SCR_BUTTON'      style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_FULL_SCR     ();'></span>

<!--textarea name=rwText style='visibility:show;position:absolute;top:550;left:0;width:100%;height:50%;z-index:-10'></textarea-->

<SCRIPT LANGUAGE="JavaScript" src='<?=$baseDir?>common/js/dplayer_browser_check.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=$baseDir?>common/js/dplayer_hash_table.js'   ></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=$baseDir?>common/js/dplayer_item.js'         ></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=$baseDir?>common/js/dplayer_system.js'       ></SCRIPT>

<SCRIPT LANGUAGE="JavaScript" src='' id='SCRIPT_DP_LYRICS'         ></SCRIPT>
<script type="text/javascript">
<!--
    document.onkeydown = DP_KEY_KILL    ; // 키 죽이기
    window.onerror     = DP_CLEAR_ERROR ; // 에러 죽이기
//-->
</SCRIPT>
<!-- 재생 파일을 열었을때 -->
<SCRIPT FOR='DP_PLAYER' EVENT='OpenStateChange(NewState);'>
    if (NewState == 13) {
        V_playTime = O_player.currentMedia.duration; // 총 재생 시간 얻기
        var min = parseInt(V_playTime / 60); if ( min < 10 ) { min = '0' + min; }
        var sec = parseInt(V_playTime % 60); if ( sec < 10 ) { sec = '0' + sec; }
        if ( S_display == 'Y') {
            DISPLAY_TOT_TIME(min,sec);
        }
    }
</SCRIPT>

<!-- 재생 상태 변화 -->
<SCRIPT FOR='DP_PLAYER' EVENT='PlayStateChange(NewState);' LANGUAGE="JavaScript">
    V_playState = NewState;
    switch (V_playState){
        case 0: // Undefined
            break;
        case 1: // 정지
            V_playState = 1;
            if ( S_display == 'Y') {
                DISPLAY_EQUALIZER1_OFF  (); // 이퀄라이져 끔
                DISPLAY_EQUALIZER2_OFF  (); // 이퀄라이져 끔
            }
            break;
        case 2: // 일시정지
            if ( S_display == 'Y') {
                DISPLAY_EQUALIZER1_OFF  (); // 이퀄라이져 끔
                DISPLAY_EQUALIZER2_OFF  (); // 이퀄라이져 끔
            }
            break;
        case 3: // 재생
            if ( S_display == 'Y') {
                  V_MediaWidth =  O_player.currentMedia.imageSourceWidth;
//              V_MediaHeight = O_player.currentMedia.imageSourceHeight;
                if ( V_MediaWidth == 0 ) {
                    DISPLAY_SCREEN_END ();
                } else {
                    DISPLAY_SCREEN ();
                }
                DISPLAY_EQUALIZER1_ON   (); // 이퀄라이져 켬
                DISPLAY_EQUALIZER2_ON   (); // 이퀄라이져 켬
            }
            break;
        case 4: // ScanForward
            break;
        case 5: // ScanReverse
            break;
        case 6: // Buffering
            if ( S_display == 'Y') {
                DISPLAY_EQUALIZER1_OFF  (); // 이퀄라이져 끔
                DISPLAY_EQUALIZER2_OFF  (); // 이퀄라이져 끔
            }
            break;
        case 7: // Waiting
            break;
        case 8: // MediaEnded
            break;
        case 9: // Transitioning
            if ( S_display == 'Y') {
                DISPLAY_EQUALIZER1_OFF  (); // 이퀄라이져 끔
                DISPLAY_EQUALIZER2_OFF  (); // 이퀄라이져 끔
            }
            break;
        case 10: // Ready
            break;
        case 11: // Reconnecting
            break;
        default:
    }

    if ( S_display == 'Y') {
        DISPLAY_PLAYER_STATE(NewState); // 상태 정보 출력
    }
</SCRIPT>

<!-- Create an event handler. -->
<SCRIPT FOR='DP_PLAYER' EVENT=buffering(Start)>
   if (Start){
        if ( T_bufferingTime != null ) window.clearInterval(T_bufferingTime); // 타이머 해제
        T_bufferingTime = window.setInterval("DP_BUFFERING ()", 100);
   }
   else{
        if ( S_display == 'Y') {
            DISPLAY_BUFFERING_END ();
        }
   }

   if (Start){
        if ( T_downloadTime != null ) window.clearInterval(T_downloadTime); // 타이머 해제
        T_downloadTime = window.setInterval("DP_DOWNLOAD ()", 1000);
   } else{
        if ( S_display == 'Y') {
            DISPLAY_BUFFERING_END ();
        }
   }
</SCRIPT>

<SCRIPT FOR='DP_PLAYER' EVENT='PositionChange(oldPosition, newPosition);'>
//    P_remindTime.innerHTML = Math.floor(O_player.currentMedia.duration - newPosition);
</SCRIPT>

<SCRIPT FOR='DP_PLAYER' EVENT='error();'>
    var strError = "";
    var max = O_player.error.errorCount

    for (var i = 0; i < max; i++)
    {
        strError += "Error: " + O_player.error.item(i).errorDescription + "\n";
    }

    alert( strError ); // Display the error warning.
    O_player.error.clearErrorQueue();
</SCRIPT>

<link rel='stylesheet' href='<?=$skinDir?>/play_style.css' type='text/css'>
<SCRIPT LANGUAGE='JavaScript' src='<?=$skinDir?>dplayer_design.js'       ></SCRIPT>

<IFRAME id='DP_DBOARD_INFOR'  style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:100px;top:100px;' src=''></iframe>

<IFRAME id='DP_LIST_HEADER'   style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' src='<?=$skinDir?>play_list_header.html'></iframe>
<IFRAME id='DP_LIST_MAIN'     style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' src='<?=$skinDir?>play_list_main.html'  ></iframe>
<IFRAME id='DP_LIST_FOOTER'   style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' src='<?=$skinDir?>play_list_footer.html'></iframe>

<IFRAME id='DP_LYRICS_HEADER' style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' src='<?=$skinDir?>play_lyrics_header.html'></iframe>
<IFRAME id='DP_LYRICS_MAIN'   style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' src='<?=$skinDir?>play_lyrics_main.html'  ></iframe>
<IFRAME id='DP_LYRICS_FOOTER' style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' src='<?=$skinDir?>play_lyrics_footer.html'></iframe>

<IFRAME id='DP_LIST_FRAME'    style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' src=''></iframe>
<IFRAME id='DP_LYRICS_FRAME'  style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' src=''></iframe>