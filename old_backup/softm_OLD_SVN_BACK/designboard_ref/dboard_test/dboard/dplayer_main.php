<TITLE> D-player </TITLE>
<META name="Title" content="Designboard Music Player">
<META name="Author" content="�����κ���">
<META name="keywords" content="D-Player">
<script type="text/javascript">
<!--
    var dboardEmbed = 'Y'       ; // ���� �Ұ�
    var S_skinName  = "<?=$_skinName?>" ; // ��Ų�� ��Ų ���丮���� �Է��ϼ���.
//-->
</SCRIPT>
</HEAD>
<BODY onLoad='DP_onLoad();' onhelp='return false;' oncontextmenu="return false;" ondrag="return false;" onkeydown="return false;" onkeyup='return false;' onkeypress='return false;' text="#000000" leftmargin="0" topmargin="0" bottommargin='0' marginwidth="0" marginheight="0"  style='border: 0px solid black; margin: 0pt;'>
<OBJECT ID="DP_PLAYER" CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" align="middle" style="position:absolute;z-index:2;left:-100px;top:-100px;width:0;height:0">
<!--   Player.closedCaption.captioningID = "captions";
  Player.closedCaption.SAMIFileName = "E:\\��������[Ac3] 2Cd ��û��  2-28\\Love.Actually.2003.CD1.XVID.smi"; -->
    <PARAM name="autoStart"         value="True"        > <!-- �ڵ� ���                    -->
    <PARAM name="balance"           value="0"           > <!-- ���� ������                  -->
    <PARAM name="captioningID"      value=""            > <!-- ĸ���� ǥ�õ� ������ ���̵�  -->
    <PARAM name="currentPosition"   value="0"           > <!-- ��� ��ġ                    -->
    <PARAM name="defaultFrame"      value=""            >
    <PARAM name="enableContextMenu" value="false"       > <!-- �÷��̾� ������ ��ư Ŭ��    -->
    <PARAM name="enabled"           value="false"       > <!-- �÷��̾� ���� ���ɼ� ����    -->
    <PARAM name="fullScreen"        value="false"       > <!-- Full ��ũ�� ����             -->
    <PARAM name="invokeURLs"        value="false"       >
    <PARAM name="mute"              value="false"       > <!-- �Ҹ� ����                    -->
    <PARAM name="playCount"         value="1"           > <!-- ��� Ƚ�� ����               -->
    <PARAM name="rate"              value="1"           > <!-- ��� �ӵ� ����               -->
    <PARAM name="SAMIFileName"      value=""            > <!-- �ڸ����� ��                  -->
    <PARAM name="stretchToFit"      value="true"        > <!-- -->
    <PARAM name="volume"            value="100"         > <!-- ����                         -->
	<PARAM name=ShowStatusBar       value=false         >

    <PARAM name="uiMode"            value="none"        > <!-- ��� ȭ�� ����   -->
<!--    <PARAM name="windowlessVideo"   value="true"   > <!--                              -->
<!--     <PARAM name="URL" value="http://www.softm.net/dboard/data/file/music/200311052129411035.mp3"> <!-- ��� ���� ��� -->
</OBJECT>
<!-- <div style="Z-INDEX: 7; WIDTH: 0px;HEIGHT: 0px; POSITION: absolute; LEFT: -500px; TOP: -500px;">
</div>
 -->
<!--���     ��ư --><span id='DP_PLAY_BUTTON'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PLAY ();'></span>
<!--����     ��ư --><span id='DP_STOP_BUTTON'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_STOP ();'></span>
<!--�Ͻ����� ��ư --><span id='DP_PAUSE_BUTTON'         style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PAUSE();'></span>
<!--����     ��ư --><span id='DP_PREV_BUTTON'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PREV ();'></span>
<!--����     ��ư --><span id='DP_NEXT_BUTTON'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_NEXT ();'></span>
<!--��Ʈ     ��ư --><span id='DP_SOUND'                style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_SOUND();'></span>
<!-- <hr style='background-color:red;width:200;height:5px;top:20;left:400;position:absolute'></hr> -->
<!--���� ��       --><span id='DP_VOLUME_BAR'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onMouseDown='DP_VOLUME_BAR_START();' ></span>
<!-- <hr style='background-color:black;width:150;height:5px;top:70;left:400;position:absolute'></hr> -->
<!--��� ��       --><span id='DP_PLAY_BAR'             style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onMouseDown='DP_PLAY_BAR_START();'   ></span>
<!-- <hr style='background-color:green;width:200;height:5px;top:90;left:400;position:absolute'></hr> -->
<!--���� �뷱���� --><span id='DP_BALANCE_BAR'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onMouseDown='DP_BALANCE_BAR_START();'></span>

<!--��� ���� :   --><span id='DP_PLAY_STATE'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--��� �ð� :   --><span id='DP_TOT_TIME'             style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--���� �ð� :   --><span id='DP_REMIND_TIME'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--����      :   --><span id='DP_TITLE'                style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>

<!--��� ��� :   --><span id='DP_PLAY_MODE'            style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PLAY_MODE_CHANGE  ();'></span>
<!--�ݺ� ��� :   --><span id='DP_REPEAT_MODE'          style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_REPEAT_MODE_CHANGE();'></span>

<!--���۸�    :   --><span id='DP_BUFFERING'            style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--�ٿ�ε�  :   --><span id='DP_DOWNLOAD'             style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--����      :   --><span id='DP_VOLUME_PERCENT'       style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--�����    :   --><span id='DP_PLAY_BAR_PERCENT'     style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--��� �ð� :   --><span id='DP_PLAY_BAR_TIME'        style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--�뷱����  :   --><span id='DP_BALANCE_PERCENT'      style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>

<!--����������1 : --><span id='DP_EQUALIZER1'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>
<!--����������2 : --><span id='DP_EQUALIZER2'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>

<!--��� ��� :   --><span id='DP_PLAY_LIST_BUTTON'     style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PLAY_LIST    ();'></span>
<!--��� ���� :   --><span id='DP_PLAY_LYRICS_BUTTON'   style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_PLAY_LYRICS  ();'></span>
<!--��� ���� �ݱ�--><span id='DP_LIST_CLOSE'           style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_LIST_CLOSE   ();'></span>
<!--�ݱ�      :   --><span id='DP_CLOSE'                style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_CLOSE        ();'></span>

<!--ī�Ƕ���Ʈ:   --><span id='DP_COPYRIGHT'            style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;'></span>

<!--Ǯ��ũ��      --><span id='DP_FULL_SCR_BUTTON'      style='position:absolute;width:0;height:0;z-index:2;font-size:9pt;cursor:hand;left:-100px;top:-100px;' onClick='DP_FULL_SCR     ();'></span>

<!--textarea name=rwText style='visibility:show;position:absolute;top:550;left:0;width:100%;height:50%;z-index:-10'></textarea-->

<SCRIPT LANGUAGE="JavaScript" src='<?=$baseDir?>common/js/dplayer_browser_check.js'></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=$baseDir?>common/js/dplayer_hash_table.js'   ></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=$baseDir?>common/js/dplayer_item.js'         ></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src='<?=$baseDir?>common/js/dplayer_system.js'       ></SCRIPT>

<SCRIPT LANGUAGE="JavaScript" src='' id='SCRIPT_DP_LYRICS'         ></SCRIPT>
<script type="text/javascript">
<!--
    document.onkeydown = DP_KEY_KILL    ; // Ű ���̱�
    window.onerror     = DP_CLEAR_ERROR ; // ���� ���̱�
//-->
</SCRIPT>
<!-- ��� ������ �������� -->
<SCRIPT FOR='DP_PLAYER' EVENT='OpenStateChange(NewState);'>
    if (NewState == 13) {
        V_playTime = O_player.currentMedia.duration; // �� ��� �ð� ���
        var min = parseInt(V_playTime / 60); if ( min < 10 ) { min = '0' + min; }
        var sec = parseInt(V_playTime % 60); if ( sec < 10 ) { sec = '0' + sec; }
        if ( S_display == 'Y') {
            DISPLAY_TOT_TIME(min,sec);
        }
    }
</SCRIPT>

<!-- ��� ���� ��ȭ -->
<SCRIPT FOR='DP_PLAYER' EVENT='PlayStateChange(NewState);' LANGUAGE="JavaScript">
    V_playState = NewState;
    switch (V_playState){
        case 0: // Undefined
            break;
        case 1: // ����
            V_playState = 1;
            if ( S_display == 'Y') {
                DISPLAY_EQUALIZER1_OFF  (); // ���������� ��
                DISPLAY_EQUALIZER2_OFF  (); // ���������� ��
            }
            break;
        case 2: // �Ͻ�����
            if ( S_display == 'Y') {
                DISPLAY_EQUALIZER1_OFF  (); // ���������� ��
                DISPLAY_EQUALIZER2_OFF  (); // ���������� ��
            }
            break;
        case 3: // ���
            if ( S_display == 'Y') {
                  V_MediaWidth =  O_player.currentMedia.imageSourceWidth;
//              V_MediaHeight = O_player.currentMedia.imageSourceHeight;
                if ( V_MediaWidth == 0 ) {
                    DISPLAY_SCREEN_END ();
                } else {
                    DISPLAY_SCREEN ();
                }
                DISPLAY_EQUALIZER1_ON   (); // ���������� ��
                DISPLAY_EQUALIZER2_ON   (); // ���������� ��
            }
            break;
        case 4: // ScanForward
            break;
        case 5: // ScanReverse
            break;
        case 6: // Buffering
            if ( S_display == 'Y') {
                DISPLAY_EQUALIZER1_OFF  (); // ���������� ��
                DISPLAY_EQUALIZER2_OFF  (); // ���������� ��
            }
            break;
        case 7: // Waiting
            break;
        case 8: // MediaEnded
            break;
        case 9: // Transitioning
            if ( S_display == 'Y') {
                DISPLAY_EQUALIZER1_OFF  (); // ���������� ��
                DISPLAY_EQUALIZER2_OFF  (); // ���������� ��
            }
            break;
        case 10: // Ready
            break;
        case 11: // Reconnecting
            break;
        default:
    }

    if ( S_display == 'Y') {
        DISPLAY_PLAYER_STATE(NewState); // ���� ���� ���
    }
</SCRIPT>

<!-- Create an event handler. -->
<SCRIPT FOR='DP_PLAYER' EVENT=buffering(Start)>
   if (Start){
        if ( T_bufferingTime != null ) window.clearInterval(T_bufferingTime); // Ÿ�̸� ����
        T_bufferingTime = window.setInterval("DP_BUFFERING ()", 100);
   }
   else{
        if ( S_display == 'Y') {
            DISPLAY_BUFFERING_END ();
        }
   }

   if (Start){
        if ( T_downloadTime != null ) window.clearInterval(T_downloadTime); // Ÿ�̸� ����
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