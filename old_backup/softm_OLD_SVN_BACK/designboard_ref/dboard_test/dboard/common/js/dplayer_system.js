<!--
/* ���� �Ұ����� �ʱ� Settting �κ�     */
var S_point = 0                             ; // ���� ���� ��ġ ( 0 �̸� ù��° �� )
var S_key   = ''                            ; // Current Play Key ����
var S_index = 0                             ; // ���� Key

/* ��ü ����            */
var O_player            = null              ; // Player        ��ü
var O_playList          = new DP_HashTable ();// ��� ���     ��ü

var P_playBtn           = null              ; // ���     ��ư ��ü
var P_stopBtn           = null              ; // ����     ��ư ��ü
var P_pauseBtn          = null              ; // �Ͻ����� ��ư ��ü
var P_prevBtn           = null              ; // ����     ��ư ��ü
var P_nextBtn           = null              ; // ����     ��ư ��ü

var P_volumeBar         = null              ; // ����   ����   ��ü
var P_playBar           = null              ; // ����� ����   ��ü
var P_balanceBar        = null              ; // ���� �뷱���� ��ü

var P_sound             = null              ; // ��Ʈ        ��ü

/* ����Ʈ ��ü ����     */
var P_playState  = null ; // ��� ����  ǥ�� ��ü
var P_totTime    = null ; // ��� �ð�  ǥ�� ��ü
var P_remindTime = null ; // ���� �ð�  ǥ�� ��ü
var P_title      = null ; // ����       ǥ�� ��ü
var P_playMode   = null ; // ��� ���  ǥ�� ��ü
var P_repeatMode = null ; // �ݺ� ���  ǥ�� ��ü

var P_buffering     = null ; // ���۸�    ǥ�� ��ü
var P_download      = null ; // �ٿ�ε�  ǥ�� ��ü

var P_volumePercent = null; // ������          ǥ�� ��ü
var P_playBarPercent= null; // ��� ������     ǥ�� ��ü
var P_playTime      = null; // �����   �ð��� ǥ�� ��ü
var P_balancePercent= null; // �뷱����        ǥ�� ��ü

var P_equalizer1    = null; // ����������1 ǥ�� ��ü
var P_equalizer2    = null; // ����������2 ǥ�� ��ü

var P_playListBtn     = null;   // ��� ��� ǥ�� ��ü
var P_playLyricsBtn   = null;   // ��� ���� ǥ�� ��ư
var P_listClose       = null;   // ��� ���� �ݱ� ǥ�� ��ü
var P_close           = null;   // �ݱ� ǥ�� ��ü
var P_copyRight       = null;   // ī�Ƕ���Ʈǥ�� ��ü

var P_listFrame       = null;   // ��� ��� ���� ��ü
var P_lyricsFrame     = null;   // ��� ���� ���� ��ü
var P_listHeader      = null;   // ��� ��� ��Ų [���]
var P_listMain        = null;   // ��� ��� ��Ų [����]
var P_listFooter      = null;   // ��� ��� ��Ų [ǲ��]

var P_lyricsHeader    = null;   // ��� ���� ��Ų [���]
var P_lyricsMain      = null;   // ��� ���� ��Ų [����]
var P_lyricsFooter    = null;   // ��� ���� ��Ų [ǲ��]
var P_FullScrBtn      = null;   // Ǯ ��ũ�� ��ü

var O_lyricsJS        = null;   // ��� ���� ������ JS

/* ���� Ÿ�̸� ��ü     */
var T_playerTime    = null; // ���     Ÿ�̸�
var T_bufferingTime = null; // ���۸�   Ÿ�̸�
var T_downloadTime  = null; // �ٿ�ε� Ÿ�̸�
var T_lyricsSet     = null; // ���� ������ �ε� Ÿ�̸�

/* ���� ��� ���� ����  */
var skinDir      = ''   ; // ��Ų ���
var V_playTime   = 0    ; // ��� �ð� ( �� )
var V_playState  = false; // ��� ����

var V_volumeBarState = false; // ������         [��������:true,��������:false]
var V_playBarState   = false; // ��� ���¹�    [��������:true,��������:false]
var V_balanceBarState= false; // ���� �뷱����  [��������:true,��������:false]

var V_playBarPos   = 0  ; // ���� �� ��ġ
var V_playedKey = '' ; // ����� ��������

var V_viewState  = false; // ����      ����
var V_listView   = false; // ��� ��� ����
var V_lyricsView = false; // ���� ���� ����

var V_playListLoad = false; // ��� ��� �ε� ���� ( �ѹ��� �ε��ϸ� �� )

var V_MediaWidth   = 0; // ���� ����
var V_MediaHeight  = 0; // ���� ����

var DP_lyricsData  = ''   ; // ����

var W_playList   = null; // ��� ��� �˾�
var W_playLyrics = null; // ����      �˾�

function DP_getObject( objStr, tier ) {
    var docStr = "";
    var obj    = null;
    if ( typeof(tier) == "string" ) {
        docStr = tier + "." + "document";
    } else {
        docStr = "document";
    }

    if (DP_is.ie) {
        /* IE */
        obj = eval( docStr + ".all['" + objStr + "']");
    } else if ( DP_is.ns ) {
        /* NS */
        obj = eval( docStr + ".getElementById('" + objStr + "');");
    }
    return obj;
}

function DP_objectMoveTo(id,X,Y, tier) {
    var obj = null;
    if ( typeof(id) == 'object' ) {
        obj = id;
    } else {
        obj = DP_getObject(id, tier);
    }
    if ( obj != null && typeof(obj) == 'object' ) {
        if ( typeof ( obj.style.left ) != 'undefined' ) obj.style.left = X;
        if ( typeof ( obj.style.top  ) != 'undefined' ) obj.style.top  = Y;
    }
}

function DP_DBOARD_PLAY_CB (callProc) { // ��� �ݹ� �Լ�

    if ( O_playList.DP_getSize() > 0 ) {
        if ( S_point == null ) S_point = 0;
        var playItem = O_playList.DP_getVal( S_point );
        var key = playItem.getId () + '-' + playItem.getNo ();
//        alert ( key + ' - ' + S_key );
        if ( key == S_key && S_key != '' ) {
            DP_PLAY_CB (callProc);
        } else {
            var playItem = O_playList.DP_getVal( S_point );
            if ( playItem.getId  () == '' ) {
                DP_PLAY_CB (callProc);
            } else {
                O_dpDboardInforFrame.src = baseDir + "dplayer.php?exec=get_item&call_proc=" + callProc + "&id=" + playItem.getId  () + "&no=" +  playItem.getNo  () + "&base_path=" + baseDir;
            }
        }
    }
}

function DP_PLAY_CB (callProc) { // ��� �ݹ� �Լ�
    if ( S_display == 'Y') { 
        DISPLAY_PREV_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
        DISPLAY_NEXT_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
        DISPLAY_STOP_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
        DISPLAY_PAUSE_BUTTON    (); // �Ͻ����� ��ư [�ʱ�ȭ]
        DISPLAY_PLAY_BUTTON_END (); // ���     ��ư [�Ϸ�  ]
    }
    if ( O_playList.DP_getSize() > 0 ) {
        if ( S_point == null ) S_point = 0;
        var playItem = O_playList.DP_getVal( S_point );
        var key = playItem.getId () + '-' + playItem.getNo ();

        // 1�ʸ��� �ð� Ÿ�̸� �߻�
        if ( T_playerTime != null ) window.clearInterval(T_playerTime); // Ÿ�̸� ����
        T_playerTime = window.setInterval("DP_inforUpdate()",500);

        if (  playItem != null &&  key != S_key ) {
            DP_PLAY_EXEC (callProc);
        }

        V_playState = 3;
        O_player.controls.play ();
    }
}

function DP_PLAY_EXEC (callProc) {
    var playItem = O_playList.DP_getVal( S_point );
    if ( playItem.getId() == '' ) {
        DP_lyricsData   = "";
        O_lyricsJS.src  = 'data/lyrics/' + playItem.getLyricsUrl () + '.js';
        if ( T_lyricsSet != null ) window.clearInterval(T_lyricsSet)  ; // Ÿ�̸� ����
        T_lyricsSet  = window.setInterval("DP_LYRICS_CONNECT ( '" + playItem.getLyricsUrl () + "');", 10);

        O_player.URL    = playItem.getUrl  ();
        if ( S_display == 'Y') {
            DISPLAY_PLAY_TITLE(playItem.getArtist(),playItem.getTitle());
        }

    } else {
        DP_PLAY_LYRICS_MAKE ();
        playItem.setUrl  (O_dpDboardInforWin.url);

        O_player.URL    = O_dpDboardInforWin.url;

        if ( S_display == 'Y') {
            DISPLAY_PLAY_TITLE(playItem.getArtist(),playItem.getTitle());
        }
    }
    S_key = playItem.getId () + '-' + playItem.getNo (); // Current Play KEY
}

function DP_LYRICS_CONNECT(lryricsUrl) {
    if ( lryricsUrl != null && DP_lyricsData != '' ) {
        DP_PLAY_LYRICS_MAKE ();
//      alert ( '���� ��� ����' ); 
        if ( T_lyricsSet != null ) window.clearInterval(T_lyricsSet)  ; // Ÿ�̸� ����
    } else if ( lryricsUrl == null ) {
        DP_PLAY_LYRICS_MAKE ();
//      alert ( '���� ��ΰ� ����' ); 
        if ( T_lyricsSet != null ) window.clearInterval(T_lyricsSet)  ; // Ÿ�̸� ����
    } else {
    }
}

function DP_PLAY () { // ���
    if ( dboardEmbed == 'N' ) {
        DP_PLAY_CB ('DP_PLAY');
    } else {
        DP_DBOARD_PLAY_CB  ('DP_PLAY');
    }
}

function DP_PAUSE() { // �Ͻ�����
    if ( V_playState == 3 ) {
        V_playState = 2;
        if ( S_display == 'Y') { 
            DISPLAY_PAUSE_BUTTON_END(); // �Ͻ����� ��ư [�Ϸ�  ]
            DISPLAY_PLAY_BUTTON     (); // ���     ��ư [�ʱ�ȭ]
            DISPLAY_STOP_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
            DISPLAY_PREV_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
            DISPLAY_NEXT_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
        }
    }
    V_playState = 2;
    DP_CLEAR_TIMER(); // Ÿ�̸� ��ü ����
    O_player.controls.pause ();
}

function DP_CLEAR_TIMER() {
    if ( T_playerTime    != null ) window.clearInterval(T_playerTime    ); // Ÿ�̸� ����
    if ( T_bufferingTime != null ) window.clearInterval(T_bufferingTime ); // Ÿ�̸� ����
    if ( T_downloadTime  != null ) window.clearInterval(T_downloadTime  ); // Ÿ�̸� ����
    if ( T_lyricsSet     != null ) window.clearInterval(T_lyricsSet     ); // Ÿ�̸� ����
}

function DP_STOP () { // ����
    V_playState = 13    ; // ����� ���ð� ���� state������ ����������.
    DP_CLEAR_TIMER()    ; // Ÿ�̸� ��ü ����
    DP_PLAY_BAR_INIT()  ; // ����� �ʱ�ȭ
    S_key       = ''    ; // Ű�ʱ�ȭ
    O_player.controls.stop ();
    if ( S_display == 'Y') {
        DISPLAY_STOP_BUTTON_END (); // ����     ��ư [�Ϸ�  ]
        DISPLAY_PLAY_BUTTON     (); // ���     ��ư [�ʱ�ȭ]
        DISPLAY_PAUSE_BUTTON    (); // �Ͻ����� ��ư [�ʱ�ȭ]
        DISPLAY_PREV_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
        DISPLAY_NEXT_BUTTON     (); // ����     ��ư [�ʱ�ȭ]

        DISPLAY_VOLUME_PERCENT_END     (); // ������ �Ϸ�
        DISPLAY_PLAY_BAR_PERCENT_END   (); // ����� �Ϸ�
        DISPLAY_PLAY_TIME_END          (); // ����ð� �Ϸ�
        DISPLAY_BALANCE_PERCENT_END    (); // �뷱���� �Ϸ�

        DISPLAY_BUFFERING_END          (); // ���۸� �Ϸ�
        DISPLAY_DOWNLOAD_END           (); // �ٿ�ε� COMPLETE

        DISPLAY_TOT_TIME_END           (); /* �� ��� �ð� �Ϸ�    */
        DISPLAY_REMIND_TIME_END        (); /* ���� �ð� �Ϸ�       */
        DISPLAY_PLAY_TITLE_END         (); /* ��� ���� ���� �Ϸ�  */
    }

}

function DP_SET_PLAY (point) { // �������Ʈ���� ���õ� ����
    S_point = point;
    if ( dboardEmbed == 'N' ) {
        DP_PLAY_CB('SET');
    } else {
        DP_DBOARD_PLAY_CB('SET');
    }
}

function DP_NEXT () { // ����
    if ( V_playState > 0 && V_playState < 4 ) {
        V_playState = 55; // ���� ��ư�� �������� ���� �ڵ� ������ ������ �Ҵ�.
                          // ����:> ��� ��ư�̳� �ٸ� ��ư�� ������ ���ϵ���.
        if (S_point==null) {
            S_point = 0;
        } else {
            if ( S_playMode == 'R' ) { // ���� ���
                S_point = DP_randPlayNumber (S_key);
            } else {
                S_point++;
            }
            if ( O_playList.DP_getSize() <= S_point ) { S_point = 0; }
        }
        if ( S_display == 'Y') {
            DISPLAY_PLAY_BUTTON     (); // ���     ��ư [�ʱ�ȭ]
            DISPLAY_PREV_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
            DISPLAY_NEXT_BUTTON_END (); // ����     ��ư [�Ϸ�  ]
        }
        if ( dboardEmbed == 'N' ) {
            DP_PLAY_CB ('DP_NEXT');
        } else {
            DP_DBOARD_PLAY_CB ('DP_NEXT');
        }
    }
}

function DP_PREV () { // ����
    if ( V_playState > 0 && V_playState < 4 ) {
        V_playState = 55; // ���� ��ư�� �������� ���� �ڵ� ������ ������ �Ҵ�.
                          // ����:> ��� ��ư�̳� �ٸ� ��ư�� ������ ���ϵ���.
        if (S_point==null) {
            S_point = 0;
        } else {
            if ( S_playMode == 'R' ) { // ���� ���
                S_point = DP_randPlayNumber (S_key);
            } else {
                S_point--;
            }
            if ( S_point < 0 ) { S_point = O_playList.DP_getSize() - 1; }
        }
        if ( S_display == 'Y') {
            DISPLAY_PLAY_BUTTON     (); // ���     ��ư [�ʱ�ȭ]
            DISPLAY_NEXT_BUTTON     (); // ����     ��ư [�ʱ�ȭ]
            DISPLAY_PREV_BUTTON_END (); // ����     ��ư [�Ϸ�  ]
        }

        if ( dboardEmbed == 'N' ) {
            DP_PLAY_CB ('DP_PREV');
        } else {
            DP_DBOARD_PLAY_CB ('DP_PREV');
        }
    }
}

function DP_SOUND (mode) { // �Ҹ� �ѱ� / ����
//        alert ( mode );
    // �ʱ�ȭ�� ���
    if ( typeof( mode ) != 'undefined' ) {

        if ( mode == 'ON' ) {
            O_player.settings.mute = false;
            if ( S_display == 'Y') { DISPLAY_DP_SOUND_ON (); }
        } else if ( mode == 'OFF' ) {
            O_player.settings.mute = true ;
            if ( S_display == 'Y') { DISPLAY_DP_SOUND_OFF(); }
        }
        S_sound = mode;
    } else if ( S_sound == 'OFF' ) {
        O_player.settings.mute = false;
        if ( S_display == 'Y') { DISPLAY_DP_SOUND_ON (); }
        S_sound = 'ON'  ;
    } else if ( S_sound == 'ON'  ) {
        O_player.settings.mute = true ;
        if ( S_display == 'Y') { DISPLAY_DP_SOUND_OFF(); }
        S_sound = 'OFF' ;
    }
}

function DP_VOLUME_BAR_START() { /* ���� ���� ���� */
    V_volumeBarState=true;
    DP_SOUND  ('ON'); // �Ҹ� �ѱ�
    document.onmousemove = DP_VOLUME_MOVE   ; // ���콺�� ���� ���¿��� �̵���
    document.onmouseup   = DP_VOLUME_BAR_END; // ���콺�� ��
}

function DP_VOLUME_MOVE() { /* ���� ���� �̵� */
    if ( V_volumeBarState == true ) {
        var fullSize = null; // ���� ���� ��ü ũ��
        var halfSize = null; // ���� ���� ��ü ũ�� 1/2 ��
        var position = null; // ���� ���콺�� ��ġ
        var S_volume = null; // ���� ���� ��ü�� �ʱ� ��ġ
        if ( S_volumeAlign == 'H' ) { // ���� ����
            fullSize = parseFloat(P_volumeBar.style.width);
            halfSize = parseFloat(fullSize / 2);
            position = window.event.clientX + document.body.scrollLeft - halfSize;
            S_volume = S_volumeX;
        } else { // ���� ����
            fullSize = parseFloat(P_volumeBar.style.height);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientY + document.body.scrollTop - halfSize;
            S_volume = S_volumeY;
        }
        position = parseInt(position);

        var areaProp     = ( ( position - S_volume ) / ( S_volumeLength - fullSize ) ) * 100; // ������ ����
            areaProp     = Math.round(areaProp,-1);

        var volumeLength = S_maxVolume - S_minVolume;
        var curVolume    = 0;

        if ( areaProp >= 0 && areaProp <= 100 ) {
            if ( S_volumeAlign == 'H' ) { // ���� ����
                P_volumeBar.style.left = position;
            } else { // ���� ����
                P_volumeBar.style.top  = position;
            }
            curVolume    = volumeLength * ( areaProp / 100 ); // ����
            O_player.settings.volume = curVolume; // ���� ����
            DP_VOLUME_PERCENT (areaProp); // ���� ����
/**-/
        rwText.value  = 'position : ' + position  + '\n';
        rwText.value += 'S_volumeLength : ' + S_volumeLength  + '\n';
        rwText.value += 'P_volumeBar.style.left : ' + parseInt(P_volumeBar.style.left)  + '\n';
        rwText.value += 'P_volumeBar.style.top : '  + parseInt(P_volumeBar.style.top)  + '\n';
        rwText.value += 'areaProp : ' + areaProp  + '\n';
        rwText.value += 'volumeLength : ' + volumeLength + '\n';
        rwText.value += 'curVolume : ' + curVolume + '\n';
/**/
        }

		return false;
    }
}

function DP_VOLUME_BAR_END() { /* ���� ���� �� */
    V_volumeBarState=false;
    if ( S_display == 'Y') { DISPLAY_VOLUME_PERCENT_END (); }
    document.onmousemove = null; // ���콺�� ���� ���¿��� �̺�Ʈ ����
    document.onmouseup   = null; // ���콺�� �� �̺�Ʈ ����
}

function DP_VOLUME_PERCENT (percent) { /* ���� ��ġ */
    if ( S_display == 'Y') { DISPLAY_VOLUME_PERCENT (percent); }
}

function DP_PLAY_BAR_START() { /* ����� ���� ���� */
    if ( V_playState > 1 && V_playState < 4 ) {
        V_playBarState=true;
        document.onmousemove = DP_PLAY_BAR_MOVE; // ���콺�� ���� ���¿��� �̵���
        document.onmouseup   = DP_PLAY_BAR_END ; // ���콺�� ��
    }
}

function DP_PLAY_BAR_MOVE() { /* ����� ���� �̵� */
    if ( V_playBarState ) {

        var fullSize = null; // ����� ���� ��ü ũ��
        var halfSize = null; // ����� ���� ��ü ũ�� 1/2 ��
        var position = null; // ���� ���콺�� ��ġ
        var S_playBar= null; // ����� ���� ��ü�� �ʱ� ��ġ
        if ( S_playBarAlign == 'H' ) { // ���� ����
            fullSize = parseFloat(P_playBar.style.width);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientX + document.body.scrollLeft - halfSize;
            S_playBar= S_playBarX;
        } else { // ���� ����
            fullSize = parseFloat(P_playBar.style.height);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientY + document.body.scrollTop - halfSize;
            S_playBar= S_playBarY;
        }

        position = parseInt(position);

        var areaProp  = ( ( position - S_playBar ) / ( S_playBarLength - fullSize ) ) * 100; // ������ ����
            areaProp  = Math.round(areaProp,-1);
        if ( areaProp >= 0 && areaProp <= 100 ) {
            if ( S_playBarAlign == 'H' ) { // ���� ����
                P_playBar.style.left = position;
            } else { // ���� ����
                P_playBar.style.top  = position;
            }
            var curPosition = parseFloat( V_playTime * ( areaProp / 100 )); // ����� ��ġ
            V_playBarPos    = curPosition;
            var secArray = DP_secToMinSec(curPosition);
            DP_PLAY_BAR_PERCENT (areaProp               ); // ����� ����
            DP_PLAY_BAR_TIME    (secArray[0],secArray[1]); // ��� �ð�
            /**-/
                    rwText.value  = 'position : ' + position  + '\n';
                    rwText.value  = 'halfSize : ' + halfSize  + '\n';
                    rwText.value += 'S_playBar : ' + S_playBar  + '\n';
                    rwText.value += 'areaProp : ' + areaProp  + '\n';
                    rwText.value += 'curPosition : ' + curPosition  + '\n';
                    rwText.value += 'V_playTime : ' + V_playTime  + '\n';
            /**/

        }
		return false;
    }
}

function DP_PLAY_BAR_PERCENT (areaProp) {
    if ( S_display == 'Y') { DISPLAY_PLAY_BAR_PERCENT (areaProp); }
}

function DP_PLAY_BAR_TIME (min, sec) {
    if ( S_display == 'Y') { DISPLAY_PLAY_TIME (min, sec); }
}

function DP_PLAY_BAR_END() { /* ����� ���� �� */
    V_playBarState=false;
    document.onmousemove = null; // ���콺�� ���� ���¿��� �̺�Ʈ ����
    document.onmouseup   = null; // ���콺�� �� �̺�Ʈ ����
    O_player.controls.currentPosition = V_playBarPos;
    if ( T_playerTime != null ) window.clearInterval(T_playerTime); // Ÿ�̸� ����
    T_playerTime = window.setInterval("DP_inforUpdate()",500);
}

function DP_PLAY_BAR_UPDATE () { /* ����� ���� ���� */
    if ( V_playState == 3 && V_playBarState == false ) {
        var fullSize = null; // ����� ���� ��ü ũ��
        var halfSize = null; // ����� ���� ��ü ũ�� 1/2 ��
        var S_playBar= null;
        if ( S_playBarAlign == 'H' ) { // ���� ����
            fullSize = parseFloat(P_playBar.style.width);
            halfSize = parseFloat(fullSize / 2);
            S_playBar= S_playBarX;
        } else { // ���� ����
            fullSize = parseFloat(P_playBar.style.height);
            halfSize = parseFloat(fullSize / 2);
            S_playBar= S_playBarY;
        }
        var curPosition = O_player.controls.currentPosition;
//        alert ( curPosition + ' / ' +  V_playTime);
        var areaProp = ( V_playTime == 0 ) ? 0 : ( curPosition / V_playTime ) * 100;
            areaProp  = Math.round(areaProp,-1);

        var position  = parseFloat( ( ( areaProp / 100 ) * ( S_playBarLength - fullSize ) ) ) + ( S_playBar );

        var secArray = DP_secToMinSec(curPosition);
        if ( !V_balanceBarState && !V_volumeBarState ) { // ������, �뷱���� �������� �ƴҰ�쿡�� ����
            DP_PLAY_BAR_PERCENT (areaProp               ); // ����� ����
        }
        DP_PLAY_BAR_TIME    (secArray[0],secArray[1]); // ��� �ð�
        if ( S_playBarAlign == 'H' ) { // ���� ����
            position += document.body.scrollLeft;
            DP_objectMoveTo(P_playBar,position,S_playBarY); // ����� [��ġ ����]
        } else { // ���� ����
            position += document.body.scrollTop;
            DP_objectMoveTo(P_playBar,S_playBarX,position); // ����� [��ġ ����]
        }
    }
}

function DP_BALANCE_BAR_START() { /* ���� �뷱���� ���� ���� */
    V_balanceBarState=true;
//    DP_SOUND_ON  (); // �Ҹ� �ѱ�
    document.onmousemove = DP_BALANCE_BAR_MOVE  ; // ���콺�� ���� ���¿��� �̵���
    document.onmouseup   = DP_BALANCE_BAR_END   ; // ���콺�� ��
}

function DP_BALANCE_BAR_MOVE() { /* ���� �뷱���� ���� �̵� */
    if ( V_balanceBarState == true ) {
        var fullSize  = null; // ���� �뷱�� ���� ��ü ũ��
        var halfSize  = null; // ���� �뷱�� ���� ��ü ũ�� 1/2 ��
        var position  = null; // ���� ���콺�� ��ġ
        var S_balance = null; // ���� ���� ��ü�� �ʱ� ��ġ
        if ( S_balanceAlign == 'H' ) { // ���� ����
            fullSize = parseFloat(P_balanceBar.style.width);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientX + document.body.scrollLeft - halfSize;
            S_balance = S_balanceX;
        } else { // ���� ����
            fullSize = parseFloat(P_balanceBar.style.height);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientY + document.body.scrollTop - halfSize;
            S_balance = S_balanceY;
        }
        position = parseInt(position);
        var areaProp      = ( ( position - S_balance ) / ( S_balanceLength - fullSize ) ) * 100; // ������ ����
            areaProp      = Math.round(areaProp,-1);

        if ( areaProp >= 0 && areaProp <= 100 ) {
            if ( S_balanceAlign == 'H' ) { // ���� ����
                P_balanceBar.style.left = position;
            } else { // ���� ����
                P_balanceBar.style.top  = position;
            }
            var balanceLength = S_maxBalance - S_minBalance;
            var curBalance    = balanceLength * ( areaProp / 100 ); // ����
            var balance       = parseInt(S_minBalance + curBalance);
                O_player.settings.balance = balance; // ���� ����

            DP_BALANCE_BAR_PERCENT (balance); // ����� ����
/**-/
        rwText.value  = 'halfSize : ' + halfSize  + '\n';
        rwText.value += 'position : ' + position  + '\n';
        rwText.value += 'balance  : ' + balance   + '\n';
        rwText.value += 'S_balanceLength : ' + S_balanceLength  + '\n';
        rwText.value += 'P_balanceBar.style.left : ' + parseInt(P_balanceBar.style.left)  + '\n';
        rwText.value += 'P_balanceBar.style.top : '  + parseInt(P_balanceBar.style.top)  + '\n';
        rwText.value += 'areaProp : ' + areaProp  + '\n';
        rwText.value += 'balanceLength : ' + balanceLength + '\n';
        rwText.value += 'curBalance : ' + curBalance + '\n';
/**/
        }


		return false;

//        var leftPerc      = ( S_minBalance / balanceLength ) * 100;
//            leftPerc      = Math.abs(Math.round(leftPerc,-1));
//        var rightPerc     = ( S_maxBalance / balanceLength ) * 100;
//            rightPerc     = Math.round(rightPerc,-1);
//        var percent       = 0;
//        var balance = S_minBalance + curBalance;
    }
}
function DP_BALANCE_BAR_PERCENT(balance) {
    if ( S_display == 'Y') { DISPLAY_BALANCE_PERCENT(balance); }
}

function DP_BALANCE_BAR_END() { /* ���� �뷱���� ���� �� */
    V_balanceBarState=false;
    document.onmousemove = null; // ���콺�� ���� ���¿��� �̺�Ʈ ����
    document.onmouseup   = null; // ���콺�� �� �̺�Ʈ ����
    if ( S_display == 'Y') { DISPLAY_BALANCE_PERCENT_END(); }
}

/* �ʱ�ȭ ���� */
function DP_VOLUME_BAR_INIT() { /* ���� ���� �ʱ�ȭ */
    if ( S_initVolume > 100 || S_initVolume < 0 ) { S_initVolume = 50 ; }
    if ( S_maxVolume  > 100 || S_maxVolume  < 0 ) { S_maxVolume  = 100; }
    if ( S_minVolume  > 100 || S_minVolume  < 0 ) { S_minVolume  = 0  ; }

    var fullSize = null; // ���� ���� ��ü ũ��
    var halfSize = null; // ���� ���� ��ü ũ�� 1/2 ��
    var S_playBar= null;

    if ( S_volumeAlign == 'H' ) { // ���� ����
        fullSize = parseFloat(P_volumeBar.style.width);
        halfSize = parseFloat(fullSize / 2);
        S_volume = S_volumeX;
    } else { // ���� ����
        fullSize = parseFloat(P_volumeBar.style.height);
        halfSize = parseFloat(fullSize / 2);
        S_volume = S_volumeY;
    }

    var volumeLength = S_maxVolume - S_minVolume;
    var areaProp     = S_initVolume / volumeLength * 100; // ����ũ�⿡���� ���� ���

    var position = ( ( areaProp / 100  ) * ( S_volumeLength - fullSize ) ) + ( S_volume ); // ���� X��ǥ ���
        position = parseInt(position);
    if ( S_volumeAlign == 'H' ) { // ���� ����
        position += document.body.scrollLeft;
        DP_objectMoveTo(P_volumeBar,position,S_volumeY); // ���� ���� [��ġ ����]
    } else { // ���� ����
        position += document.body.scrollTop;
        DP_objectMoveTo(P_volumeBar,S_volumeX,position); // ���� ���� [��ġ ����]
    }

    O_player.settings.volume = parseInt(S_initVolume); // ���� �ʱ�ġ ����

}

function DP_PLAY_BAR_INIT() { /* ����� �ʱ�ȭ */
    DP_objectMoveTo(P_playBar,S_playBarX,S_playBarY); // ���� ���� [��ġ ����]
}

function DP_PLAY_BALANCE_INIT() { /* ���� �뷱���� �ʱ�ȭ */
    if ( S_initBalance > 100 || S_initBalance < -100 ) { S_initBalance = 0   ; }
    if ( S_maxBalance  > 100 || S_maxBalance  < -100 ) { S_maxBalance  = 100 ; }
    if ( S_minBalance  > 100 || S_minBalance  < -100 ) { S_minBalance  =-100 ; }

    if ( S_minBalance > S_maxBalance  ) { S_minBalance = -100; }
    if ( S_initBalance < S_minBalance ) { S_minBalance = -100; }
    if ( S_initBalance > S_maxBalance ) { S_maxBalance =  100; }

    var fullSize  = null; // ���� �뷱�� ���� ��ü ũ��
    var halfSize  = null; // ���� �뷱�� ���� ��ü ũ�� 1/2 ��
    var S_balance= null;
    if ( S_balanceAlign == 'H' ) { // ���� ����
        fullSize = parseFloat(P_balanceBar.style.width);
        halfSize = parseFloat(fullSize / 2);
        S_balance = S_balanceX;
    } else { // ���� ����
        fullSize = parseFloat(P_balanceBar.style.height);
        halfSize = parseFloat(fullSize / 2);
        S_balance = S_balanceY;
    }

    var balanceLength   = S_maxBalance - S_minBalance ;

    var relativeBalance = Math.abs( S_minBalance - S_initBalance );

    var areaProp        = relativeBalance / balanceLength * 100; // ����ũ�⿡���� ���� ���

    var position = ( ( areaProp / 100  ) * ( S_balanceLength - fullSize ) ) + S_balance; // ���� X��ǥ ���

    if ( S_balanceAlign == 'H' ) { // ���� ����
        position += document.body.scrollLeft;
        DP_objectMoveTo(P_balanceBar,position,S_balanceY); // ���� ���� [��ġ ����]
    } else { // ���� ����
        position += document.body.scrollTop;
        DP_objectMoveTo(P_balanceBar,S_balanceX,position); // ���� ���� [��ġ ����]
    }

    O_player.settings.balance = parseInt(S_initBalance); // ���� �ʱ�ġ ����
}

function DP_PLAYER_INIT () { /* ���� �޽��� ���� �ʱ�ȭ */

    if ( S_display == 'Y') {
        DISPLAY_SCREEN          (); // ��ũ�� ��ġ
        DISPLAY_BACKGROUND      (); // ��� ����
        DISPLAY_PLAY_BUTTON     (); // ���     ��ư ��ü
        DISPLAY_STOP_BUTTON     (); // ����     ��ư ��ü
        DISPLAY_PAUSE_BUTTON    (); // �Ͻ����� ��ư ��ü
        DISPLAY_PREV_BUTTON     (); // ����     ��ư ��ü
        DISPLAY_NEXT_BUTTON     (); // ����     ��ư ��ü
        DISPLAY_VOLUME_BAR      (); /* ���� ���� �ʱ�ȭ */
        DISPLAY_PLAY_BAR        (); /* ����� �ʱ�ȭ    */
        DISPLAY_BALANCE_BAR     (); /* ���� �뷱���� �ʱ�ȭ */
        DISPLAY_EQUALIZER1_OFF  (); // ����������1 ǥ�� ��ü
        DISPLAY_EQUALIZER2_OFF  (); // ����������2 ǥ�� ��ü
        DISPLAY_PLAY_LIST_BUTTON  (); // ��� ��� ǥ�� ��ü
        DISPLAY_PLAY_LYRICS_BUTTON(); // ��� ���� ǥ�� ��ư
        DISPLAY_LIST_CLOSE        (); // ��� ���� �ݱ� ǥ�� ��ü
        DISPLAY_CLOSE             (); // �ݱ� ǥ�� ��ü
        DISPLAY_COPYRIGHT         (); // ī�Ƕ���Ʈǥ�� ��ü
        DISPLAY_FULLSCR_BUTTON  (); // Ǯ��ũ�� ��ü

        if ( S_listMode == '1' ) { // ���� ������
            DISPLAY_LIST_FRAME        (); // ��� ��� ���� ��ü
            DISPLAY_LYRICS_FRAME      (); // ��� ���� ���� ��ü
        }

        DP_objectMoveTo(O_player     , S_screenX       ,S_screenY      ); // ��ũ��   ��ü [��ġ ����]
        DP_objectMoveTo(P_playBtn    , S_playBtnX      ,S_playBtnY     ); // ���     ��ư ��ü [��ġ ����]
        DP_objectMoveTo(P_stopBtn    , S_stopBtnX      ,S_stopBtnY     ); // ����     ��ư ��ü [��ġ ����]
        DP_objectMoveTo(P_pauseBtn   , S_pauseBtnX     ,S_pauseBtnY    ); // �Ͻ����� ��ư ��ü [��ġ ����]
        DP_objectMoveTo(P_prevBtn    , S_prevBtnX      ,S_prevBtnY     ); // ����     ��ư ��ü [��ġ ����]
        DP_objectMoveTo(P_nextBtn    , S_nextBtnX      ,S_nextBtnY     ); // ����     ��ư ��ü [��ġ ����]
        DP_objectMoveTo(P_sound      , S_soundX        ,S_soundY       ); // ��Ʈ          ��ü [��ġ ����]

        DP_objectMoveTo(P_title      , S_titleX        ,S_titleY       ); // ����      ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_playState  , S_stateX        ,S_stateY       ); // ��� ���� ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_totTime    , S_totTimeX      ,S_totTimeY     ); // ��� �ð� ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_playTime   , S_playTimeX     ,S_playTimeY    ); // ��� �ð� ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_remindTime , S_remindTimeX   ,S_remindTimeY  ); // ���� �ð� ǥ�� ��ü [��ġ ����]

        DP_objectMoveTo(P_buffering     , S_bufferingX      ,S_bufferingY       ); // ���۸�      ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_download      , S_downloadX       ,S_downloadY        ); // �ٿ�ε�    ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_volumePercent , S_volumePercentX  ,S_volumePercentY   ); // ������      ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_playBarPercent, S_playBarPercentX ,S_playBarPercentY  ); // ��� ������ ǥ�� ��ü [��ġ ����]

        DP_objectMoveTo(P_balancePercent, S_balancePercentX ,S_balancePercentY  ); // �뷱�� ��   ǥ�� ��ü [��ġ ����]

        DP_objectMoveTo(P_equalizer1    , S_equalizer1X     ,S_equalizer1Y      ); // ����������1 ǥ�� ��ü[��ġ ����]
        DP_objectMoveTo(P_equalizer2    , S_equalizer2X     ,S_equalizer2Y      ); // ����������2 ǥ�� ��ü[��ġ ����]

        DP_objectMoveTo(P_playMode      , S_playModeX       ,S_playModeY        ); // ��� ��� ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_repeatMode    , S_repeatModeX     ,S_repeatModeY      ); // �ݺ� ��� ǥ�� ��ü [��ġ ����]

        DP_objectMoveTo(P_playListBtn   , S_playListBtnX    ,S_playListBtnY     ); // ��� ��� ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_playLyricsBtn , S_playLyricsBtnX  ,S_playLyricsBtnY   ); // ��� ���� ǥ�� ��ư [��ġ ����]
        DP_objectMoveTo(P_listClose     , S_listCloseX      ,S_listCloseY       ); // ��� ���� �ݱ� ǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_close         , S_closeX          ,S_closeY           ); // �ݱ� ǥ�� ��ü      [��ġ ����]
        DP_objectMoveTo(P_copyRight     , S_copyRightX      ,S_copyRightY       ); // ī�Ƕ���Ʈǥ�� ��ü [��ġ ����]
        DP_objectMoveTo(P_FullScrBtn    , S_fullScrBtnX     ,S_fullScrBtnY      ); // Ǯ��ũ�� ��ü [��ġ ����]

        if ( S_type != 'C' ) {
            DP_objectMoveTo(P_listFrame     , S_listFrameX      ,S_listFrameY       ); // ��� ��� ���� ��ü [��ġ ����]
            DP_objectMoveTo(P_lyricsFrame   , S_lyricsFrameX    ,S_lyricsFrameY     ); // ��� ���� ���� ��ü [��ġ ����]
        }
    }
}

function DP_PLAY_MODE_CHANGE (mode)    { // ������
    // �ʱ�ȭ�� ���
    if ( typeof( mode ) != 'undefined' ) {
        if ( S_display == 'Y') {
            if ( mode == 'S' ) {
                DISPLAY_PLAY_MODE_ALL_SEQUENCE ();  // ��ü ����
            } else if ( mode == 'R' ) {
                DISPLAY_PLAY_MODE_ALL_RANDOM   ();  // �����
            } else if ( mode == 'O' ) {
                DISPLAY_PLAY_MODE_ONLY         ();  // ��ü ����
            }
        }
        S_playMode=mode;
    }
    else   if ( S_playMode == 'S' ) {
        if ( S_display == 'Y') {
            DISPLAY_PLAY_MODE_ALL_RANDOM   ();  // ��ü ����
        }
        S_playMode='R';
    } else if ( S_playMode == 'R' ) {
        if ( S_display == 'Y') {
            DISPLAY_PLAY_MODE_ONLY         ();  // �����
        }
        S_playMode='O';
    } else if ( S_playMode == 'O' ) {
        if ( S_display == 'Y') {
            DISPLAY_PLAY_MODE_ALL_SEQUENCE ();  // ��ü ����
        }
        S_playMode='S';
    }
    V_playedKey = '';
}

function DP_REPEAT_MODE_CHANGE (mode) { // �ݺ����
    // �ʱ�ȭ�� ���
    if ( typeof( mode ) != 'undefined' ) {
        if ( S_display == 'Y') {
            if ( mode == '0' ) {
                DISPLAY_SINGLE_MODE  ();  // �ݺ�����
            } else if ( mode == '1' ) {
                DISPLAY_REPEAT_MODE ();  // �ݺ�
            }
        }
        S_repeatMode=mode;
    }
    else   if ( S_repeatMode == '0' ) {
        if ( S_display == 'Y') {
            DISPLAY_REPEAT_MODE ();  // �ݺ�
        }
        S_repeatMode='1';
    } else if ( S_repeatMode == '1' ) {
        if ( S_display == 'Y') {
            DISPLAY_SINGLE_MODE  ();  // �ݺ�����
        }
        S_repeatMode='0';
    }
}

function DP_BUFFERING ()    { // ���۸�
    if ( S_display == 'Y') { 
        var buffering = O_player.network.bufferingProgress;

        if ( buffering < 100 ) {
            DISPLAY_BUFFERING (buffering);
        } else {
            DISPLAY_BUFFERING_END (); // ���۸� COMPLETE
        }
    }
}

function DP_DOWNLOAD ()     { // �ٿ�ε�
    if ( S_display == 'Y') { 
        var download = O_player.network.downloadProgress;
        if ( download < 100 ) {
            DISPLAY_DOWNLOAD (download);
        } else {
            DISPLAY_DOWNLOAD_END  (); // �ٿ�ε� COMPLETE
        }
    }
}

function DP_inforUpdate() { /* ��� ���� ���� */
    if ( S_display == 'Y') { 
        var timeNow = O_player.controls.currentPosition;
            tmp     = Math.floor(V_playTime - timeNow);
        var secArray = DP_secToMinSec(tmp);
        DISPLAY_REMIND_TIME(secArray[0],secArray[1]); // ���� �ð� ���
    }
    DP_PLAY_BAR_UPDATE (); // ����� ����
    DP_playingThread   ();
}

function DP_secToMinSec(seconds) {
    var secArray =  new Array();
    secArray[0] = parseInt(seconds / 60); if ( secArray[0] < 10 ) { secArray[0] = '0' + secArray[0]; }
    secArray[1] = parseInt(seconds % 60); if ( secArray[1] < 10 ) { secArray[1] = '0' + secArray[1]; }
    return secArray;
}

var O_dpDboardInforFrame = null; // �𺸵�� �����ɰ�� ������� ������
var O_dpDboardInforWin   = null; // �𺸵�� �����ɰ�� ������� Window

function DP_onLoad() {
    if ( S_type == 'P' || typeof(self.opener) == 'object' ) {
        S_type = 'P';
        window.resizeTo(S_width+6, S_height+25);
    } else if ( S_type == 'F' && typeof(self.opener) != 'object' ) { // ������
        window.resizeTo(S_width, S_height);
    }

    if ( dboardEmbed == 'N' ) {
        skinDir         = 'skin/'       + S_skinName + '/'; // ��Ų ���丮 ����
    } else {
        skinDir         = baseDir + 'skin/board/' + S_skinName + '/'; // ��Ų ���丮 ����
    }

    O_player          = DP_getObject('DP_PLAYER'         ); // Player        ��ü

    P_playBtn         = DP_getObject('DP_PLAY_BUTTON'    ); // ���     ��ư ��ü
    P_stopBtn         = DP_getObject('DP_STOP_BUTTON'    ); // ����     ��ư ��ü
    P_pauseBtn        = DP_getObject('DP_PAUSE_BUTTON'   ); // �Ͻ����� ��ư ��ü
    P_prevBtn         = DP_getObject('DP_PREV_BUTTON'    ); // ����     ��ư ��ü
    P_nextBtn         = DP_getObject('DP_NEXT_BUTTON'    ); // ����     ��ư ��ü

    P_volumeBar       = DP_getObject('DP_VOLUME_BAR'   ); // ����   ����   ��ü
    P_playBar         = DP_getObject('DP_PLAY_BAR'     ); // ����� ����   ��ü
    P_balanceBar      = DP_getObject('DP_BALANCE_BAR'  ); // ���� �뷱���� ��ü
    P_sound           = DP_getObject('DP_SOUND'         ); // ��Ʈ          ��ü

    P_title           = DP_getObject('DP_TITLE'        ); // ����      ǥ�� ��ü
    P_playState       = DP_getObject('DP_PLAY_STATE'   ); // ��� ���� ǥ�� ��ü
    P_totTime         = DP_getObject('DP_TOT_TIME'     ); // ��   �ð� ǥ�� ��ü
    P_playTime        = DP_getObject('DP_PLAY_BAR_TIME'); // ��� �ð� ǥ�� ��ü
    P_remindTime      = DP_getObject('DP_REMIND_TIME'  ); // ���� �ð� ǥ�� ��ü

    P_buffering       = DP_getObject('DP_BUFFERING'         ); // ���۸�    ǥ�� ��ü
    P_download        = DP_getObject('DP_DOWNLOAD'          ); // �ٿ�ε�  ǥ�� ��ü

    P_volumePercent   = DP_getObject('DP_VOLUME_PERCENT'    ); // ����     ���� ǥ�� ��ü
    P_playBarPercent  = DP_getObject('DP_PLAY_BAR_PERCENT'  ); // �����   ���� ǥ�� ��ü

    P_balancePercent  = DP_getObject('DP_BALANCE_PERCENT'   ); // �뷱���� ���� ǥ�� ��ü

    P_equalizer1      = DP_getObject('DP_EQUALIZER1'        ); // ����������1 ��ü
    P_equalizer2      = DP_getObject('DP_EQUALIZER2'        ); // ����������2 ��ü

    P_playMode        = DP_getObject('DP_PLAY_MODE'         ); // ��� ��� ǥ�� ��ü
    P_repeatMode      = DP_getObject('DP_REPEAT_MODE'       ); // �ݺ� ��� ǥ�� ��ü

    P_playListBtn     = DP_getObject('DP_PLAY_LIST_BUTTON'  ); // ��� ��� ǥ�� ��ü
    P_playLyricsBtn   = DP_getObject('DP_PLAY_LYRICS_BUTTON'); // ��� ���� ǥ�� ��ư
    P_listClose       = DP_getObject('DP_LIST_CLOSE'        ); // ��� ���� �ݱ� ǥ�� ��ü
    P_close           = DP_getObject('DP_CLOSE'             ); // �ݱ� ǥ�� ��ü

    P_copyRight       = DP_getObject('DP_COPYRIGHT'         ); // ī�Ƕ���Ʈǥ�� ��ü

    P_listFrame       = DP_getObject('DP_LIST_FRAME'        ); // ��� ��� ���� ��ü
    P_lyricsFrame     = DP_getObject('DP_LYRICS_FRAME'      ); // ��� ���� ���� ��ü
    P_FullScrBtn      = DP_getObject('DP_FULL_SCR_BUTTON'   ); // Ǯ ��ũ�� ��ü

    if ( dboardEmbed == 'Y' ) {
        O_dpDboardInforFrame = DP_getObject('DP_DBOARD_INFOR'   ); // �𺸵�� �����ɰ�� ������� ������
        O_dpDboardInforWin   = document.frames("DP_DBOARD_INFOR"); // �𺸵�� �����ɰ�� ������� Window
    }
//    if ( dboardEmbed == 'N' ) {
        P_listHeader      = document.frames("DP_LIST_HEADER"    ).document.body; // ��� ��� ��Ų [���]
        P_listMain        = document.frames("DP_LIST_MAIN"      ).document.body; // ��� ��� ��Ų [����]
        P_listFooter      = document.frames("DP_LIST_FOOTER"    ).document.body; // ��� ��� ��Ų [ǲ��]

        P_lyricsHeader    = document.frames("DP_LYRICS_HEADER"  ).document.body; // ��� ���� ��Ų [���]
        P_lyricsMain      = document.frames("DP_LYRICS_MAIN"    ).document.body; // ��� ���� ��Ų [����]
        P_lyricsFooter    = document.frames("DP_LYRICS_FOOTER"  ).document.body; // ��� ���� ��Ų [ǲ��]
//    }

    O_lyricsJS        = DP_getObject("SCRIPT_DP_LYRICS");   // ��� ���� ������ JS
    DP_PLAYER_INIT        (); // �޽��� ���� �ʱ�ȭ [ ��ġ ���� ]
    DP_VOLUME_BAR_INIT    (); // ������ �ʱ�ȭ
    DP_PLAY_BAR_INIT      (); // ����� �ʱ�ȭ
    DP_PLAY_BALANCE_INIT  (); // ���� �뷱���� �ʱ�ȭ

    DP_PLAY_MODE_CHANGE   (S_playMode   );
    DP_REPEAT_MODE_CHANGE (S_repeatMode );
    DP_SOUND              (S_sound); // mute ���� �ʱ�ȭ

    if ( S_autoplay == 'Y' ) { // �ڵ� ���
        if ( dboardEmbed == 'N' ) {
            DP_PLAY_CB        ('AUTO_PLAY');
        } else {
            DP_DBOARD_PLAY_CB ('AUTO_PLAY');
        }
    }
}

function addslashes(val) {
    var len = val.length;
    var cnt = 0;
    var tmp = '';
    while( cnt <= len ) {
        alert ( val.substr(cnt,1) );
        if ( val.substr(cnt,1) == "\\" ) {
            alert ( '�߰�' );
            tmp += '\\\\';
        } else {
            tmp += val.charAt(cnt);
        }
        cnt++;
    }
    return tmp;
}

function DP_DBOARD_Add_PlayInfor() { // ��� ���� �߰�
    var args = DP_DBOARD_Add_PlayInfor.arguments;
    var playItem = new dplayer_item ();
    if ( typeof( args[0 ] ) != 'undefined' && args[0 ] != '') { playItem.setId       ( args[0 ] ); }
    if ( typeof( args[1 ] ) != 'undefined' && args[1 ] != '') { playItem.setNo       ( args[1 ] ); }
    if ( typeof( args[2 ] ) != 'undefined' && args[2 ] != '') { playItem.setTitle    ( args[2 ] ); }
    if ( typeof( args[3 ] ) != 'undefined'                  ) { playItem.setArtist   ( args[3 ] ); }
    if ( typeof( args[4 ] ) != 'undefined' && args[4 ] != '') { playItem.setAlbumNo  ( args[4 ] ); }
    if ( typeof( args[5 ] ) != 'undefined' && args[5 ] != '') { playItem.setAlbum    ( args[5 ] ); }
    if ( typeof( args[6 ] ) != 'undefined' && args[6 ] != '') { playItem.setComposer ( args[6 ] ); }
    if ( typeof( args[7 ] ) != 'undefined' && args[7 ] != '') { playItem.setGenre    ( args[7 ] ); }
    if ( typeof( args[8 ] ) != 'undefined' && args[8 ] != '') { playItem.setLength   ( args[8 ] ); }
    if ( typeof( args[9 ] ) != 'undefined' && args[9 ] != '') { playItem.setSize     ( args[9 ] ); }
    if ( typeof( args[10] ) != 'undefined' && args[10] != '') { playItem.setKind     ( args[10] ); }
    if ( typeof( args[11] ) != 'undefined' && args[11] != '') { playItem.setMakeDate ( args[11] ); }
    if ( typeof( args[12] ) != 'undefined' && args[12] != '') { playItem.setBitPerSec( args[12] ); }
    if ( typeof( args[13] ) != 'undefined' && args[13] != '') { playItem.setPlayCnt  ( args[13] ); }
    if ( typeof( args[14] ) != 'undefined' && args[14] != '') { playItem.setFileName ( args[14] ); }
    if ( typeof( args[15] ) != 'undefined' && args[15] != '') { playItem.setProtect  ( args[15] ); }
    if ( typeof( args[16] ) != 'undefined' && args[16] != '') { playItem.setLicense  ( args[16] ); }
    if ( typeof( args[17] ) != 'undefined' && args[17] != '') { playItem.setUrl      ( args[17] ); }
    if ( typeof( args[18] ) != 'undefined' && args[18] != '') { playItem.setLyricsUrl( args[18] ); }

    O_playList.DP_putValue(playItem.getId () + '-' + playItem.getNo (), playItem    ); // id + no�� Ű�� ��� ���� ����

}

function DP_Add_PlayInfor() { // ��� ���� �߰�
    var args = DP_Add_PlayInfor.arguments;
    var playItem = new dplayer_item ();
        playItem.setId       ( ''      );
        playItem.setNo       ( S_index );
    if ( typeof( args[0 ] ) != 'undefined' && args[0 ] != '') { playItem.setUrl      ( args[0 ] ); }
    if ( typeof( args[1 ] ) != 'undefined' && args[1 ] != '') { playItem.setTitle    ( args[1 ] ); }
    if ( typeof( args[2 ] ) != 'undefined'                  ) { playItem.setArtist   ( args[2 ] ); }
    if ( typeof( args[3 ] ) != 'undefined' && args[3 ] != '') { playItem.setLyricsUrl( args[3 ] ); }
    if ( typeof( args[4 ] ) != 'undefined' && args[4 ] != '') { playItem.setAlbum    ( args[4 ] ); }
    if ( typeof( args[5 ] ) != 'undefined' && args[5 ] != '') { playItem.setComposer ( args[5 ] ); }
    if ( typeof( args[6 ] ) != 'undefined' && args[6 ] != '') { playItem.setGenre    ( args[6 ] ); }
    if ( typeof( args[7 ] ) != 'undefined' && args[7 ] != '') { playItem.setLength   ( args[7 ] ); }
    if ( typeof( args[8 ] ) != 'undefined' && args[8 ] != '') { playItem.setSize     ( args[8 ] ); }
    if ( typeof( args[9 ] ) != 'undefined' && args[9 ] != '') { playItem.setKind     ( args[9 ] ); }
    if ( typeof( args[10] ) != 'undefined' && args[10] != '') { playItem.setMakeDate ( args[10] ); }
    if ( typeof( args[11] ) != 'undefined' && args[11] != '') { playItem.setBitPerSec( args[11] ); }
    if ( typeof( args[12] ) != 'undefined' && args[12] != '') { playItem.setPlayCnt  ( args[12] ); }
    if ( typeof( args[13] ) != 'undefined' && args[13] != '') { playItem.setFileName ( args[13] ); }
    if ( typeof( args[14] ) != 'undefined' && args[14] != '') { playItem.setProtect  ( args[14] ); }
    if ( typeof( args[15] ) != 'undefined' && args[15] != '') { playItem.setLicense  ( args[15] ); }
    O_playList.DP_putValue(playItem.getId () + '-' + playItem.getNo (), playItem    ); // id + no�� Ű�� ��� ���� ����
    S_index++;
//  alert ( args[3]  );
//  alert ( DP_getFileNameOnly(args[0 ]) );
//  alert ( playItem.getUrl() + ' / ' + playItem.getTitle() );
//  alert ( O_playList.DP_getSize() );
}

//** Function Name  : getFileName
//** Argument1      : ���� ��θ�
//** Description    : ���� ��θ��� ���� �̸��� ��ȯ
function DP_getFileName(val)
{
    var rtnStr = val;
    var s1 = 0, s2 = 0;
    var s  = 0;
    s1 = rtnStr.lastIndexOf("\\") + 1 ;
    s2 = rtnStr.lastIndexOf("/")  + 1 ;
    if ( s1 > 0 ) { s = s1; }
    if ( s2 > 0 ) { s = s2; }
    if ( s > 0 ) {
        rtnStr = rtnStr.substring( s );
    } else {
        rtnStr = "";
    }
    return rtnStr;
}


function DP_getFileNameOnly(val)
{
    var rtnStr = val;
    var s1 = 0, s2 = 0;
    var s  = 0;
    s1 = rtnStr.lastIndexOf("\\") + 1 ;
    s2 = rtnStr.lastIndexOf("/")  + 1 ;
    if ( s1 > 0 ) { s = s1; }
    if ( s2 > 0 ) { s = s2; }
    if ( s > 0 ) {
        var e  = 0;
        e = rtnStr.lastIndexOf(".");
        if ( e > 0 ) {
            rtnStr = rtnStr.substring( s, e );
        } else {
            rtnStr = rtnStr.substring( s );
        }
    } else {
        rtnStr = "";
    }
    return rtnStr;
}

function DP_randPlayNumber (exceptKey) {
    var _rtn = null;
    var size = O_playList.DP_getSize();
    var expKey = '';
    if ( typeof(exceptKey) != 'undefined' ) { expKey = exceptKey; }
    // Key String ����
    var keyStr = '';
    for ( var i=0;i<size;i++) {
        var playItem = O_playList.DP_getVal(i);
        keyStr += ',' + playItem.getId () + '-' + playItem.getNo (); // KEY String
    }

    while ( true ) {
        var tmpIdx = Math.floor(Math.random() * size );
        var tmpItem = O_playList.DP_getVal(tmpIdx);
        if ( tmpItem != null ) {
            tmpKey = tmpItem.getId () + '-' + tmpItem.getNo (); // KEY ����
            if ( V_playedKey.indexOf(',' + tmpKey) < 0 && expKey != tmpKey ) {
                V_playedKey = V_playedKey + ',' + tmpKey;
//              alert ( '��� Ű : ' + tmpKey + ' / ' + tmpIdx + ' ���� : ' + tmpItem.getTitle () );
                _rtn = tmpIdx;
                break;
            } else {
//              alert ( '�ȳ� : ' + tmpKey + ' / ' + tmpIdx + ' ���� : ' + tmpItem.getTitle () );
                keyStr = keyStr.replace( ',' + tmpKey,'');
                if ( keyStr == '' ) { // ���� ��� ���� �ݺ��� ���� ����
                    V_playedKey = '';
                    DP_randPlayNumber ();
                    break;
                }
            }
        }
    }

    return _rtn;
}

function DP_playingThread () {
//      rwText.value  = 'V_playState    : ' + V_playState  + '\n';
//      rwText.value += 'V_playedKey : ' + V_playedKey  + '\n';
/* ��� ��� */
// var S_playMode      = 'S';   // ��� ��� ::> �������  : 'S', ����� : 'R', �����   : 'O'
// var S_repeatMode   = '0';   // �ݺ� ��� ::> �ݺ�����  : '0', �ݺ�     : '1'
    if ( V_playState == 1 ) {
//      rwText.value  =  '��� ��� : ' + S_playMode    + '\n';
//      rwText.value +=  '�ݺ� ��� : ' + S_repeatMode + '\n';
        if ( S_playMode == 'S' ) { // �������
            // �ݺ�
            if ( S_repeatMode == '1' ) {
                DP_NEXT ();
            }
            // �ݺ� ����
            else if ( S_repeatMode == '0' && O_playList.DP_getSize() - 1 > S_point ) {
                DP_NEXT ();
            } else {
                DP_STOP ();
                DISPLAY_PLAYER_STATE ( 99 ); // ����
            }
        } else if ( S_playMode == 'R' ) { // �����
            // �ݺ�
            if ( S_repeatMode == '1' ) {
                S_point = DP_randPlayNumber ();
                if ( S_point == null ) {
                    S_point = DP_randPlayNumber ();
                }
                if ( dboardEmbed == 'N' ) {
                    DP_PLAY_CB        ('REPEAT');
                } else {
                    DP_DBOARD_PLAY_CB ('REPEAT');
                }
            }
            // �ݺ� ����
            else if ( S_repeatMode == '0' ) {
//              alert ( '�ݺ� ���� ���� ���.' );
                S_point = DP_randPlayNumber ();
                if ( S_point != null ) {
                    if ( dboardEmbed == 'N' ) {
                        DP_PLAY_CB        ('NOT_REPEAT');
                    } else {
                        DP_DBOARD_PLAY_CB ('NOT_REPEAT');
                    }
                } else {
                    DP_STOP ();
                    DISPLAY_PLAYER_STATE ( 99 ); // ����
                }
            } else {
                DP_STOP ();
                DISPLAY_PLAYER_STATE ( 99 ); // ����
            }
        } else if ( S_playMode == 'O' ) { // �����
            // �ݺ�
            if ( S_repeatMode == '1' ) {
                if ( dboardEmbed == 'N' ) {
                    DP_PLAY_CB        ('ONLY');
                } else {
                    DP_DBOARD_PLAY_CB ('ONLY');
                }
            } else {
                DP_STOP ();
                DISPLAY_PLAYER_STATE ( 99 ); // ����
            }
        }
    }
}

function DP_SORT_UP     (point) {
    point = O_playList.DP_idxUp(point);
    DP_PLAY_LIST_MAKE (point);
}

function DP_SORT_DOWN   (point) {
    point = O_playList.DP_idxDown(point);
    DP_PLAY_LIST_MAKE   (point);
}

function DP_SORT_DELETE (key) {
    point = O_playList.DP_getKeyIdx(key)
//    alert ( point + ' - ' + key );
    if ( point != null ) {
        O_playList.DP_removeKey(point);
        DP_PLAY_LIST_MAKE   ();
    }
//  DP_PLAY_LYRICS_MAKE ();
}

function DP_PLAY_LIST () {
    if ( S_listMode == '1' ) { // ���� ������
        if ( !V_listView ) {
            V_listView = true;
            V_lyricsView = false;
            DISPLAY_LIST_FRAME      (); // ��� ��� ������ ����
            if ( S_type == 'P' ) {
                window.resizeTo(6+S_listWidth, 25+S_listHeight);
            } else if ( S_type == 'F' ) { // ������
                window.resizeTo(S_listWidth, S_listHeight);
            } else { // ����â
            }

        } else {
            V_listView = false;
            DISPLAY_LIST_FRAME_END  (); // ��� ��� ������ �Ҹ�
            if ( S_type == 'P' ) {
                window.resizeTo(S_width+6, S_height+25);
            } else if ( S_type == 'F' ) { // ������
                window.resizeTo(S_width, S_height);
            } else { // ����â
            }
        }

        DISPLAY_LYRICS_FRAME_END(); // ��� ���� ������ �Ҹ�
        if ( !V_playListLoad ) {
            DP_PLAY_LIST_MAKE       (); // ��� ����Ʈ ����
            V_playListLoad = true;
        }

    } else { // �˾��� ���
        if ( W_playList == null || typeof(W_playList.document) != 'object' ) {
            W_playList = window.open('about:blank','w_dp_play_list','scrollbars=yes,width=' + (S_listWidth) + ',height=' + (S_listHeight) + ',left=' + (self.screenLeft - 3) + ',top=' + (S_height + self.screenTop + 3) );
            W_playList.resizeTo ( S_listWidth+6 ,S_listHeight+25 );
            if ( S_type == 'P' ) {
                W_playList.moveTo ( self.screenLeft - 3, S_height + self.screenTop + 3 );
            } else if ( S_type == 'C' ) {
                W_playList.moveTo ( self.screenLeft / 2, S_height + self.screenTop / 2 );
            }
        } else {
            if ( S_type == 'P' ) {
                //W_playList.moveTo ( self.screenLeft - 3, S_height + self.screenTop + 3 );
            } else if ( S_type == 'C' ) {
                //W_playList.moveTo ( self.screenLeft / 2, S_height + self.screenTop / 2 );
            }
            W_playList.focus();
        }
        DP_PLAY_LIST_MAKE       (); // ��� ����Ʈ ����
    }
}

function DP_PLAY_LIST_MAKE (point) {
    var listHeader = P_listHeader.outerText ; // ��� ��� ��Ų [���]
    var listMain   = P_listMain.outerText   ; // ��� ��� ��Ų [����]
    var listFooter = P_listFooter.outerText ; // ��� ��� ��Ų [ǲ��]

    var tmplitMain = '';
    var newListMain= '';
    var listFrame    = null;
    var objStr       = '';

    if ( S_listMode == '1' ) { // ���� ������
        listFrame    = document.frames("DP_LIST_FRAME"     ); // ��� ��� ����
        objStr       = 'parent';
    } else {
        if ( typeof(W_playList.document) == 'object' ) { 
            V_listView = true;
            listFrame  = W_playList;
            objStr     = 'opener';
            W_playList.focus();
        } else {
            V_listView = false;
        }
    }

    if ( V_listView ) {
        for (var i=0; i<O_playList.DP_getSize(); i++ ) {
            var playItem = O_playList.DP_getVal( i );
            tmplitMain = listMain;

            tmplitMain = tmplitMain.replace(/\[#no#\]/g      ,i + 1                 );
            tmplitMain = tmplitMain.replace(/\[#a_play#\]/g  ,"<a id='_dp_num" + i + "' href='#' onClick='" + objStr + ".DP_SET_PLAY (" + i + ");return false;'>"   );
            tmplitMain = tmplitMain.replace(/\[#title#\]/g   ,playItem.getTitle  () );
            tmplitMain = tmplitMain.replace(/\[#name#\]/g    ,playItem.getArtist () );
            tmplitMain = tmplitMain.replace(/\[#skinDir#\]/g ,skinDir               );

            tmplitMain = tmplitMain.replace(/\[#a_up#\]/g      ,"<a href='#' onClick='" + objStr + ".DP_SORT_UP     (" + i + ");return false;'>" );
            tmplitMain = tmplitMain.replace(/\[#a_down#\]/g    ,"<a href='#' onClick='" + objStr + ".DP_SORT_DOWN   (" + i + ");return false;'>" );
            tmplitMain = tmplitMain.replace(/\[#a_delete#\]/g  ,"<a href='#' onClick='" + objStr + ".DP_SORT_DELETE (\"" + playItem.getId() + '-' + playItem.getNo() + "\");return false;'>" );
            newListMain += tmplitMain;
        }
        newListMain += "<div align='right'><font color='white' size='1'>Designboard.net</font></div>";
        if ( typeof ( point ) == 'number') {
            listFooter += "\n<script>\n _dp_num" + point + ".focus(); \n</script>\n";
        }

        listFrame.document.open ();
        listFrame.document.write( listHeader + newListMain + listFooter );
        listFrame.document.close();
    }
}

function DP_PLAY_LYRICS () {
    if ( T_lyricsSet != null ) window.clearInterval(T_lyricsSet)  ; // Ÿ�̸� ����
    S_point = O_playList.DP_getKeyIdx(S_key);
    var playItem = O_playList.DP_getVal( S_point );

    if ( S_lyricsMode == '1' ) { // ���� ������
        if ( !V_lyricsView ) {
            V_listView = false;
            V_lyricsView = true;
            DISPLAY_LYRICS_FRAME    (); // ��� ���� ������ ����
            if ( S_type == 'P' ) {
                window.resizeTo(6+S_lyricsWidth, 25+S_lyricsHeight);
            } else if ( S_type == 'F' ) { // ������
                window.resizeTo(S_lyricsWidth, S_lyricsHeight);
            } else { // ����â

            }
        } else {
            V_lyricsView = false;
            DISPLAY_LYRICS_FRAME_END(); // ��� ���� ������ �Ҹ�
            if ( S_type == 'P' ) {
                window.resizeTo(S_width+6, S_height+25);
            } else if ( S_type == 'F' ) { // ������
                window.resizeTo(S_width, S_height);
            } else { // ����â

            }
        }

        DISPLAY_LIST_FRAME_END  (); // ��� ��� ������ �Ҹ�
    } else { // �˾��� ���
        if ( W_playLyrics == null || typeof(W_playLyrics.document) != 'object' ) { 
            W_playLyrics = window.open('about:blank','w_dp_play_lyrics','scrollbars=yes,width=' + (S_lyricsWidth) + ',height=' + (S_lyricsHeight) + ',left=' + ( S_width + self.screenLeft ) + ',top=' + (self.screenTop) );
            W_playLyrics.resizeTo ( S_lyricsWidth+6 ,S_lyricsHeight+25 );
            if ( S_type == 'P' ) {
                W_playLyrics.moveTo ( S_width + self.screenLeft+3, self.screenTop - 22);
            } else if ( S_type == 'C' ) {
                W_playLyrics.moveTo ( self.screenLeft / 2, S_height + self.screenTop / 2 );
            }
        } else {
            if ( S_type == 'P' ) {
                //W_playLyrics.moveTo ( S_width + self.screenLeft+3, self.screenTop - 22);
            } else if ( S_type == 'C' ) {
                //W_playLyrics.moveTo ( self.screenLeft / 2, S_height + self.screenTop / 2 );
            }
        }
    }

    if ( dboardEmbed == 'N' ) {
        if ( playItem != null ) {
            T_lyricsSet  = window.setInterval("DP_LYRICS_CONNECT ( '" + playItem.getLyricsUrl () + "');", 10); // ���� ����Ʈ ����
        } else {
            T_lyricsSet  = window.setInterval("DP_LYRICS_CONNECT ( null );", 10                               ); // ���� ����Ʈ ����
        }
    } else {
        DP_PLAY_LYRICS_MAKE ();
    }
}

function DP_PLAY_LYRICS_MAKE () {
    var lyricsHeader = P_lyricsHeader.outerText ; // ��� ��� ��Ų [���]
    var lyricsMain   = P_lyricsMain.outerText   ; // ��� ��� ��Ų [����]
    var lyricsFooter = P_lyricsFooter.outerText ; // ��� ��� ��Ų [ǲ��]
    var lyricsData   = lyricsHeader + lyricsMain + lyricsFooter;

    var lyricsFrame  = null;
    var objStr       = '';
    if ( S_lyricsMode == '1' ) { // ���� ������
        lyricsFrame  = document.frames("DP_LYRICS_FRAME"); // ��� ���� ���� ��ü
        objStr       = 'parent';
    } else { // �˾�
        if ( W_playLyrics != null && typeof(W_playLyrics.document) == 'object' ) { 
            V_lyricsView = true;
            lyricsFrame  = W_playLyrics;
            objStr     = 'opener';
            W_playLyrics.focus();
        } else {
            V_lyricsView = false;
        }
    }

    if ( lyricsFrame != null ) {
        var playItem = O_playList.DP_getVal( S_point );
        if ( playItem == null ) {
            playItem = new dplayer_item ();
            playItem.setTitle('������� �뷡�� �����ϴ�.');
            DP_lyricsData = '��� ���۱��� �����κ��忡 ������<BR> ������ �����ϳ� ���� ������ �Ұ��մϴ�.';
        }

        lyricsData = lyricsData.replace(/\[#no#\]/g      ,S_point + 1       );
        lyricsData = lyricsData.replace(/\[#a_play#\]/g  ,"<a id='_dp_num" + S_point + "' href='#' onClick='" + objStr + ".DP_SET_PLAY (" + S_point + ");return false;'>"   );
        lyricsData = lyricsData.replace(/\[#title#\]/g   ,playItem.getTitle  () );
        lyricsData = lyricsData.replace(/\[#name#\]/g    ,playItem.getArtist () );
        lyricsData = lyricsData.replace(/\[#skinDir#\]/g ,skinDir               );
        lyricsData = lyricsData.replace(/\[#lyrics#\]/g ,DP_lyricsData);

        lyricsFrame.document.open ();
        lyricsFrame.document.write( lyricsData );
        lyricsFrame.document.close();
    }

}

function DP_LIST_CLOSE   () {
    if ( S_type == 'P' ) {
        window.resizeTo(S_width+6, S_height+25);
    } else if ( S_type == 'F' ) { // ������
        window.resizeTo(S_width, S_height);
    } else { // ����â

    }
    V_listView  = false;
    V_lyricsView= false;
    DISPLAY_LIST_FRAME_END  (); // ��� ��� ������ �Ҹ�
    DISPLAY_LYRICS_FRAME_END(); // ��� ���� ������ �Ҹ�
}

function DP_CLOSE        () {
    window.close();
}


function DP_FULL_SCR     () {
    if (V_playState == 3 ) {
        O_player.fullScreen = 'true';
        O_player.uiMode = 'full';
    }
}

function DP_CLEAR_ERROR(){
	return true;
}

function DP_KEY_KILL() {
    event.keyCode      = 0    ;
    event.cancelBubble = true ; // 
    event.returnValue  = false; // �̺�Ʈ �߻� ���
}
//-->