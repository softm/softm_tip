<!--
/* =============== =============== =============== ============= */
/* ������ ���� ����                                              */
/* ���� �����ϳ� ������ �����Ͻø� �÷��̾� ������ �Ұ����մϴ�. */
/* 1. BGM �������
    var S_type          = 'C'   ;   // �÷��̾� Ÿ��  ::> �˾� : 'P', ���� ������ : 'C'
    var S_display       = 'N'   ;   // �÷��̾� ���� : 'Y', ���� : 'N'
    var S_autoplay      = 'Y'   ;   // �ڵ� ��� ��� ::> �ڵ� ��� : 'Y', �ڵ� ��� ���� : 'N'
*/

/* ���� �����ϳ� ������ �����Ͻø� �÷��̾� ������ �Ұ����մϴ�. */
/* �ʱ� Settting �κ� ============================== */
var S_type          = 'P'       ; // �÷��̾� �˾� : 'P', ������ : 'F', ���� ������ : 'C'

var S_sound         = 'ON'      ; // �÷��̾� �Ҹ� �ѱ� / ���� ( 'ON' / 'OFF' )

/* ��� ��� */
var S_autoplay      = 'Y'       ; // �ڵ� ��� : 'Y', �ڵ� ��� ���� : 'N'
var S_playMode      = 'S'       ; // �������  : 'S', ����� : 'R', �����   : 'O'
var S_repeatMode    = '0'       ; // �ݺ�����  : '0', �ݺ�     : '1'

/* ���� ���� */
var S_initVolume    =  50   ;   // ���� �ʱⰪ   ( 0 ~ 100 )
var S_minVolume     =   0   ;   // ���� �ּ�ũ�� ( 0 ~ 100 )
var S_maxVolume     = 100   ;   // ���� �ִ�ũ�� ( 0 ~ 100 )

/* ���� �뷱�� ���� */
var S_initBalance   =    0  ;   // ���� �ʱⰪ           ( -100 ~ 100 )
var S_minBalance    = -100  ;   // ���� �뷱�� �ּ� ũ�� ( -100 ~ 100 )
var S_maxBalance    =  100  ;   // ���� �뷱�� �ִ� ũ�� ( -100 ~ 100 )

var S_display       = 'Y'   ;   // �÷��̾� ���� : 'Y', ����   : 'N'

var S_listMode      =  '1'  ;   // ��� ��� ���� ������ ��� : '1', �˾� ��� : '2'
var S_lyricsMode    =  '1'  ;   // ����      ���� ������ ��� : '1'. �˾� ��� : '2'

var S_width         = 500   ;   // �˾� ������ ���� ũ��
var S_height        = 170   ;   // �˾� ������ ���� ũ��

var S_listWidth     = 500   ;   // �˾� ��� ���� ���� ũ��
var S_listHeight    = 526   ;   // �˾� ��� ���� ���� ũ��

var S_lyricsWidth   = 500   ;   // �˾� ���� ���� ���� ũ��
var S_lyricsHeight  = 526   ;   // �˾� ���� ���� ���� ũ��

/* ���� ���� ���� */
var S_volumeAlign   = 'H'   ;   // ���� ���� ���� ( H [����] / V [����] )
var S_volumeLength  =  94   ;   // ���� ���� ũ�� ( ���� : px )

/* ����� ���� ���� */
var S_playBarAlign  = 'H'   ;   // ����� ���� ���� ( H [����] / V [����] )
var S_playBarLength = 279   ;   // ����� ���� ũ�� ( ���� : px )

/* ���� �뷱�� ���� ���� */
var S_balanceAlign  = 'H'   ;   // ���� �뷱�� ���� ���� ( H [����] / V [����] )
var S_balanceLength =  41   ;   // ���� �뷱�� ���� ũ�� ( ���� : px )

/* �÷��̾� ��� ���� */
function DISPLAY_BACKGROUND () {
    document.body.background                = "" + skinDir + "/images/background.gif";
    document.body.style.backgroundRepeat    = "no-repeat";
    document.body.style.backgroundPositionX = 0;
    document.body.style.backgroundPositionY = 0;
}

/* ȭ�� */
var S_screenX = 322; // ���� ��ġ
var S_screenY = 5  ; // ���� ��ġ
function DISPLAY_SCREEN () { // ��ũ�� ��ü
    O_player.style.left   = S_screenX;
    O_player.style.top    = S_screenY;
    O_player.style.width  = 170;  // ���� ����
    O_player.style.height = 140;  // ���� ����
}

function DISPLAY_SCREEN_END () { // ��ũ�� ��ü
    O_player.style.width  = 0;  // ���� ����
    O_player.style.height = 0;  // ���� ����
    // �����
    O_player.style.left = '-2000px';
    O_player.style.top = '-2000px';
}

/* ��� ��ư */
var S_playBtnX          = 42    ; // ���     ��ư left ��ġ
var S_playBtnY          = 89    ; // ���     ��ư top  ��ġ
function DISPLAY_PLAY_BUTTON () { // ���     ��ư ��ü
    P_playBtn.style.width  = 22;
    P_playBtn.style.height = 17;
    P_playBtn.innerHTML = "<img src='" + skinDir + "/images/play_play.gif' alt='�������'>";
}

function DISPLAY_PLAY_BUTTON_END () { // ���     ��ư ��ü
    P_playBtn.style.width  = 22;
    P_playBtn.style.height = 17;
    P_playBtn.innerHTML = "<img src='" + skinDir + "/images/play_play_r.gif' alt='�����'>";
}

/* ���� ��ư */
var S_stopBtnX          = 88   ; // ����     ��ư left ��ġ
var S_stopBtnY          = 89   ; // ����     ��ư top  ��ġ
function DISPLAY_STOP_BUTTON () { // ����     ��ư ��ü
    P_stopBtn.style.width  = 22;
    P_stopBtn.style.height = 17;
    P_stopBtn.innerHTML  = "<img src='" + skinDir + "/images/play_stop.gif' alt='����'>";
}

function DISPLAY_STOP_BUTTON_END () { // ����     ��ư ��ü
    P_stopBtn.style.width  = 22;
    P_stopBtn.style.height = 17;
    P_stopBtn.innerHTML  = "<img src='" + skinDir + "/images/play_stop_r.gif' alt='������'>";
}

/* �Ͻ����� ��ư */
var S_pauseBtnX         = 65    ; // �Ͻ����� ��ư left ��ġ
var S_pauseBtnY         = 89    ; // �Ͻ����� ��ư top  ��ġ
function DISPLAY_PAUSE_BUTTON () { // �Ͻ����� ��ư ��ü
    P_pauseBtn.style.width  = 22;
    P_pauseBtn.style.height = 17;
    P_pauseBtn.innerHTML = "<img src='" + skinDir + "/images/play_pause.gif' alt='�Ͻ�����'>";
}

function DISPLAY_PAUSE_BUTTON_END () { // �Ͻ����� ��ư ��ü
    P_pauseBtn.style.width  = 22;
    P_pauseBtn.style.height = 17;
    P_pauseBtn.innerHTML = "<img src='" + skinDir + "/images/play_pause_r.gif' alt='�Ͻ�������'>";
}

/* ���� ��ư */
var S_prevBtnX          = 19   ; // ����     ��ư left ��ġ
var S_prevBtnY          = 89   ; // ����     ��ư top  ��ġ
function DISPLAY_PREV_BUTTON () { // ����     ��ư ��ü
    P_prevBtn.style.width  = 22;
    P_prevBtn.style.height = 17;
    P_prevBtn.innerHTML = "<img src='" + skinDir + "/images/play_prev.gif' alt='������'>";
}

function DISPLAY_PREV_BUTTON_END () { // ����     ��ư ��ü
    P_prevBtn.style.width  = 22;
    P_prevBtn.style.height = 17;
    P_prevBtn.innerHTML = "<img src='" + skinDir + "/images/play_prev_r.gif' alt='������'>";
}

/* ���� ��ư */
var S_nextBtnX          = 111   ; // ����     ��ư left ��ġ
var S_nextBtnY          = 89    ; // ����     ��ư top  ��ġ
function DISPLAY_NEXT_BUTTON () { // ����     ��ư ��ü
    P_nextBtn.style.width  = 22;
    P_nextBtn.style.height = 17;
    P_nextBtn.innerHTML = "<img src='" + skinDir + "/images/play_next.gif' alt='������'>";
}

function DISPLAY_NEXT_BUTTON_END () { // ����     ��ư ��ü
    P_nextBtn.style.width  = 22;
    P_nextBtn.style.height = 17;
    P_nextBtn.innerHTML = "<img src='" + skinDir + "/images/play_next_r.gif' alt='������'>";
}

/* ���Ұ� ��ư */
var S_soundX            = 258   ; // ��Ʈ left ��ġ
var S_soundY            = 55    ; // ��Ʈ top  ��ġ
function DISPLAY_DP_SOUND_ON () { /* �Ҹ� �ѱ� ȭ�� ǥ�� */
    P_sound.style.width  = 41;
    P_sound.style.height = 13;
    P_sound.innerHTML = "<img src='" + skinDir + "/images/sound_on.gif' alt='�Ҹ��ѱ�'>";

}

function DISPLAY_DP_SOUND_OFF() { /* �Ҹ� ���� ȭ�� ǥ�� */
    P_sound.style.width  = 41;
    P_sound.style.height = 13;
    P_sound.innerHTML = "<img src='" + skinDir + "/images/sound_off.gif' alt='�Ҹ�����'>";
}

/* ���� */
var S_titleX            = 118  ; // ��� ���� left ��ġ
var S_titleY            = 28   ; // ��� ���� top  ��ġ
function DISPLAY_PLAY_TITLE(artist, title) { /* ��� ���� ���� */
    P_title.style.width  = 113;
    P_title.style.height = 13;
    P_title.style.color  = 'FFFFFF';
    P_title.innerHTML    = "<marquee scrollamount=10 scrolldelay=200 class='text_01' onmouseover='this.stop()'  onmouseout='this.start()'>" + artist + ' / ' + title +  '</marquee>';
}
function DISPLAY_PLAY_TITLE_END () { /* ��� ���� ���� �Ϸ� */
    P_title.innerHTML = '';
}

/* ��� ���� */
var S_stateX            = 25    ; // ��� ���� left ��ġ
var S_stateY            = 25    ; // ��� ���� top  ��ġ
function DISPLAY_PLAYER_STATE ( state ) { /* ��� ���� */
    P_playState.style.width  = 50;
    P_playState.style.height = 15;
    switch ( state ){
        case 1: // ����
            P_playState.innerHTML = "<span class='text_01'>����</span>"         ; break;
        case 2: // �Ͻ�����
            P_playState.innerHTML = "<span class='text_01'>�Ͻ�����</span>"     ; break;
        case 3: // ���
            P_playState.innerHTML = "<span class='text_01'>�����</span>"       ; break;
        case 4:
            P_playState.innerHTML = "<span class='text_01'>ScanForward</span>"  ; break;
        case 5:
            P_playState.innerHTML = "<span class='text_01'>ScanReverse</span>"  ; break;
        case 6: // ���۸�
            P_playState.innerHTML = "<span class='text_01'>���۸�</span>"       ; break;
        case 7:
            P_playState.innerHTML = "<span class='text_01'>�����</span>"       ; break;
        case 8:
            P_playState.innerHTML = "<span class='text_01'>MediaEnded</span>"   ; break;
        case 9:
            P_playState.innerHTML = "<span class='text_01'>������</span>"       ; break;
        case 10:
            P_playState.innerHTML = "<span class='text_01'>�غ���</span>"       ; break;
        case 11:
            P_playState.innerHTML = "<span class='text_01'>������</span>"       ; break;
        case 99:
            P_playState.innerHTML = "<span class='text_01'>�����</span>"       ; break;
        default:
            P_playState.innerHTML = "";
    }
}

/* ��� �ѽð� */
var S_totTimeX          = 50   ; // �� ��� �ð� left ��ġ
var S_totTimeY          = 46   ; // �� ��� �ð� top  ��ġ
function DISPLAY_TOT_TIME(min,sec) { /* �� ��� �ð� */
    P_totTime.style.textAlign ='center';
    P_totTime.style.width  = 50;
    P_totTime.style.height = 15;
    P_totTime.innerHTML = "<span class='text_03'> / " + min + ":" + sec + "</span>";
}

function DISPLAY_TOT_TIME_END  () { /* �� ��� �ð� �Ϸ� */
    P_totTime.innerHTML = '';
}

/* ���� ��� �ð� */
var S_playTimeX      = 15      ; // ��� �ð� left ��ġ
var S_playTimeY      = 46      ; // ��� �ð� top  ��ġ
function DISPLAY_PLAY_TIME (min,sec) { // ��� �ð�
    P_playTime.style.textAlign ='center';
    P_playTime.style.width  = 50;
    P_playTime.style.height = 15;
    P_playTime.innerHTML = "<span class='text_03'>" + min + ":" + sec + "</span>";
}
function DISPLAY_PLAY_TIME_END () { // ����ð� �Ϸ�
    P_playTime.innerHTML  = '';
}

/* ���� ���� �ð� */
var S_remindTimeX       = -100  ; // ���� ��� �ð� left ��ġ
var S_remindTimeY       = -100  ; // ���� ��� �ð� top  ��ġ
function DISPLAY_REMIND_TIME(min,sec) { /* ���� �ð� ǥ�� */
    P_remindTime.style.textAlign ='center';
    P_remindTime.style.width  = 50;
    P_remindTime.style.height = 15;
    P_remindTime.innerHTML = min + ':' + sec;
}

function DISPLAY_REMIND_TIME_END() { /* ���� �ð� �Ϸ� */
    P_remindTime.innerHTML = '';
}

/* ���۸� */
var S_bufferingX        = -100  ; // ���۸� left ��ġ
var S_bufferingY        = -100  ; // ���۸� top  ��ġ
function DISPLAY_BUFFERING (buffering) { // ���۸�
    P_buffering.style.width  = 50;
    P_buffering.style.height = 15;
    P_buffering.innerHTML  = "<span class='text_03'>" + buffering + "%" + "</span>";
}
function DISPLAY_BUFFERING_END () { // ���۸� �Ϸ�
    P_buffering.innerHTML  = "";
}

/* �ٿ�ε� */
var S_downloadX         = -100   ; // �ٿ�ε� left ��ġ
var S_downloadY         = -100   ; // �ٿ�ε� top  ��ġ
function DISPLAY_DOWNLOAD  (download) { // �ٿ�ε�
    P_download.style.width  = 50;
    P_download.style.height = 15;
    P_download.innerHTML  = "<span class='text_03'>" + download + "%" + "</span>";
}
function DISPLAY_DOWNLOAD_END  () { // �ٿ�ε� COMPLETE
    P_download.innerHTML  = "";
}

/* ������ */
var S_volumePercentX    = 241  ; // ��� ���� left ��ġ
var S_volumePercentY    = 25   ; // ��� ���� top  ��ġ
function DISPLAY_VOLUME_PERCENT (percent) { // ��
    P_volumePercent.style.width  = 50;
    P_volumePercent.style.height = 15;
    P_balancePercent.innerHTML = '';
    P_playBarPercent.innerHTML = '';
    P_volumePercent.innerHTML  = "<span class='text_03'><font color='DECC00' size='1'>Vol : " + percent + "%" + "</font></span>";
}
function DISPLAY_VOLUME_PERCENT_END () { // ������ �Ϸ�
//    P_volumePercent.innerHTML  = '';
}

/* �뷱�� ������ */
var S_balancePercentX   = 241    ; // �뷱�� �� left ��ġ
var S_balancePercentY   = 25     ; // �뷱�� �� top  ��ġ
function DISPLAY_BALANCE_PERCENT (percent) { // �뷱���� �ð�
    P_balancePercent.style.width  = 55;
    P_balancePercent.style.height = 15;
    P_volumePercent.innerHTML  = '';
    P_playBarPercent.innerHTML = '';
    P_balancePercent.innerHTML = "<span class='text_03'><font color='DECC00' size='1'>Bal : " + percent + "%" + "</font></span>";
}

function DISPLAY_BALANCE_PERCENT_END () { // �뷱���� �Ϸ�
//    P_balancePercent.innerHTML  = '';
}

/* ��� ������ */
var S_playBarPercentX   = 241 ; // ��� ������ left ��ġ
var S_playBarPercentY   = 25  ; // ��� ������ top  ��ġ
function DISPLAY_PLAY_BAR_PERCENT (percent) { // ����� ����
    P_playBarPercent.style.width  = 55;
    P_playBarPercent.style.height = 15;
    P_volumePercent.innerHTML  = '';
    P_balancePercent.innerHTML = '';
    P_playBarPercent.innerHTML = "<span class='text_03'><font color='DECC00' size='1'>Play : " + percent + "%" + "</font></span>";
}
function DISPLAY_PLAY_BAR_PERCENT_END () {  // ����� �Ϸ�
    P_playBarPercent.innerHTML  = '';
}

/* ���� ���� ��Ʈ�� */
var S_volumeX           = 113   ; // ���� ���� left ��ġ
var S_volumeY           =  58   ; // ���� ���� top  ��ġ
function DISPLAY_VOLUME_BAR () {
    P_volumeBar.style.width  = 15;
    P_volumeBar.style.height = 8 ;
    P_volumeBar.innerHTML = "<img src='" + skinDir + "/images/bar_volume.gif' alt='��������'>";
//    P_volumeBar.innerHTML = "<BUTTON></BUTTON>";
}

/* ����� ���� ��Ʈ�� */
var S_playBarX          = 20    ; // ����� ���� left ��ġ
var S_playBarY          = 73    ; // ����� ���� top  ��ġ
function DISPLAY_PLAY_BAR () {
    P_playBar.style.width       = 21 ;
    P_playBar.style.height      = 10 ;
    P_playBar.innerHTML = "<img src='" + skinDir + "/images/bar_play.gif' alt='�����ġ����'>";
}

/* ���� �뷱�� ���� ��Ʈ�� */
var S_balanceX          = 212   ; // ���� �뷱�� ���� left ��ġ
var S_balanceY          = 58    ; // ���� �뷱�� ���� top  ��ġ
function DISPLAY_BALANCE_BAR () {
    P_balanceBar.style.width       = 15;
    P_balanceBar.style.height      = 8 ;
    P_balanceBar.innerHTML = "<img src='" + skinDir + "/images/bar_balance.gif' alt='�����뷱������'>";
}

/* ����������1 ǥ�� ��ü */
var S_equalizer1X          = 76   ; // ����������1 left ��ġ
var S_equalizer1Y          = 23    ; // ����������1 top  ��ġ
function DISPLAY_EQUALIZER1_ON () {
    P_equalizer1.style.width       = 15;
    P_equalizer1.style.height      = 8 ;
    P_equalizer1.innerHTML  = "<img src='" + skinDir + "/images/equalizer1_on.gif' alt='����������'>";
}
function DISPLAY_EQUALIZER1_OFF () {
    P_equalizer1.style.width       = 15;
    P_equalizer1.style.height      = 8 ;
    P_equalizer1.innerHTML  = "<img src='" + skinDir + "/images/equalizer1_off.gif' alt='����������'>";
}

/* ����������2 ǥ�� ��ü */
var S_equalizer2X          = -100  ; // ����������2 left ��ġ
var S_equalizer2Y          = -100  ; // ����������2 top  ��ġ
function DISPLAY_EQUALIZER2_ON () {
    P_equalizer2.style.width       = 15;
    P_equalizer2.style.height      = 8 ;
    P_equalizer2.innerHTML = "<img src='" + skinDir + "/images/equalizer2_on.gif'>";
}
function DISPLAY_EQUALIZER2_OFF () {
    P_equalizer2.style.width       = 15;
    P_equalizer2.style.height      = 8 ;
    P_equalizer2.innerHTML = "<img src='" + skinDir + "/images/equalizer2_off.gif'>";
}

/* ��� ��� */
var S_playModeX         = 214   ; // ��� ��� left ��ġ
var S_playModeY         = 89    ; // ��� ��� top  ��ġ
function DISPLAY_PLAY_MODE_ALL_SEQUENCE () { // �������
    P_playMode.style.width       = 41;
    P_playMode.style.height      = 17;
    P_playMode.innerHTML = "<img src='" + skinDir + "/images/play_all.gif' alt='���'>";
}

function DISPLAY_PLAY_MODE_ALL_RANDOM   () { // �����
    P_playMode.style.width       = 41;
    P_playMode.style.height      = 17;
    P_playMode.innerHTML = "<img src='" + skinDir + "/images/play_random.gif' alt='����'>";

}

function DISPLAY_PLAY_MODE_ONLY         () { // �����
    P_playMode.style.width       = 41;
    P_playMode.style.height      = 17;
    P_playMode.innerHTML = "<img src='" + skinDir + "/images/play_one.gif' alt='�Ѱ�'>";
}

/* �ݺ� ��� */
var S_repeatModeX      = 257  ; // �ݺ� ��� left ��ġ
var S_repeatModeY      = 89   ; // �ݺ� ��� top  ��ġ
function DISPLAY_REPEAT_MODE () { // �ݺ�
    P_repeatMode.style.width       = 41;
    P_repeatMode.style.height      = 17;
    P_repeatMode.innerHTML = "<img src='" + skinDir + "/images/play_repeat.gif' alt='�ݺ�'>";
}

function DISPLAY_SINGLE_MODE  () { // �ݺ�����
    P_repeatMode.style.width       = 41;
    P_repeatMode.style.height      = 17;
    P_repeatMode.innerHTML = "<img src='" + skinDir + "/images/play_only.gif' alt='�ѹ���'>";
}

/* ��� ��� ǥ�� ��ư */
var S_playListBtnX     = 19   ; // ��� ��� ǥ�� ��ư left ��ġ
var S_playListBtnY     = 118  ; // ��� ��� ǥ�� ��ư top  ��ġ
function DISPLAY_PLAY_LIST_BUTTON  () {
    P_playListBtn.style.width       = 41;
    P_playListBtn.style.height      = 17;
    P_playListBtn.innerHTML = "<img src='" + skinDir + "/images/play_list.gif' alt='����Ʈ����'>";
}

/* ��� ���� ǥ�� ��ư */
var S_playLyricsBtnX     = 250 ; // ��� ���� ǥ�� ��ư left ��ġ
var S_playLyricsBtnY     = 118 ; // ��� ���� ǥ�� ��ư top  ��ġ
function DISPLAY_PLAY_LYRICS_BUTTON() { //
    P_playLyricsBtn.style.width       = 41;
    P_playLyricsBtn.style.height      = 17;
    P_playLyricsBtn.innerHTML = "<img src='" + skinDir + "/images/play_lyrics.gif' alt='���纸��'>";
}

/* ����Ʈ, ���� ��� ���� �ݱ� ǥ�� */
var S_listCloseX  = 247  ; // ��� ���� �ݱ� ǥ�� left ��ġ
var S_listCloseY  = 181  ; // ��� ���� �ݱ� ǥ�� top  ��ġ
function DISPLAY_LIST_CLOSE  () { //    ��� ���� �ݱ� ǥ��
    P_listClose.style.width       = 41;
    P_listClose.style.height      = 17;
    P_listClose.innerHTML  = "<img src='" + skinDir + "/images/close.gif' alt='�ݱ�'>";
}

/* �ݱ� ǥ�� */
var S_closeX  = -100  ; // ��� ���� �ݱ� ǥ�� left ��ġ
var S_closeY  = -100  ; // ��� ���� �ݱ� ǥ�� top  ��ġ
function DISPLAY_CLOSE  () { //    �ݱ� ǥ�� ��ü
    P_close.style.width       = 41;
    P_close.style.height      = 17;
    P_close.innerHTML = "�ݱ�";
}

/* ī�Ƕ���Ʈ ǥ�� */
var S_copyRightX  = 100  ; // ī�Ƕ���Ʈ ǥ�� left ��ġ
var S_copyRightY  = 149  ; // ī�Ƕ���Ʈ ǥ�� top  ��ġ
function DISPLAY_COPYRIGHT         () {
    P_copyRight.style.width       = 200;
    P_copyRight.style.height      = 17 ;
//  P_copyRight.innerHTML = "copyright by <a href='http://www.designboard.net' target='_new'>designboard.net</a>";
    P_copyRight.innerHTML  = "<a href='http://www.designboard.net' target='_new' onFocus='this.blur();'><img src='" + skinDir + "/images/copy.gif' border='0'></a>";
}

/* ��� ��� ���� */
var S_listFrameX  = 17   ; // ��� ��� ���� left ��ġ
var S_listFrameY  = 199  ; // ��� ��� ���� top  ��ġ
function DISPLAY_LIST_FRAME     () {
    P_listFrame.style.width     = 287;
    P_listFrame.style.height    = 294;
}

function DISPLAY_LIST_FRAME_END () {
    P_listFrame.style.width     = 0;
    P_listFrame.style.height    = 0;
}

/* ��� ���� ���� */
var S_lyricsFrameX  = 17   ; // ��� ���� ���� left ��ġ
var S_lyricsFrameY  = 199  ; // ��� ���� ���� top  ��ġ
function DISPLAY_LYRICS_FRAME   () {
    P_lyricsFrame.style.width   = 287;
    P_lyricsFrame.style.height  = 294;
}

function DISPLAY_LYRICS_FRAME_END () {
    P_lyricsFrame.style.width   = 0;
    P_lyricsFrame.style.height  = 0;
}

/* Ǯ��ũ�� ��ư */
var S_fullScrBtnX   = 285   ; // Ǯ��ũ�� ��ư left ��ġ
var S_fullScrBtnY   = 3    ; // Ǯ��ũ�� ��ư top  ��ġ
function DISPLAY_FULLSCR_BUTTON () { // Ǯ��ũ�� ��ư ��ü
    P_FullScrBtn.style.width  = 28;
    P_FullScrBtn.style.height = 15;
    P_FullScrBtn.innerHTML = "<button style='font-face:Times New Roman;color:white;font-size:8;background-color:black;'>FULL</button>";
}

function DISPLAY_FULLSCR_BUTTON_END () { // Ǯ��ũ�� ��ư ��ü
    P_FullScrBtn.style.width  = 200;
    P_FullScrBtn.style.height = 200;
    P_FullScrBtn.innerHTML = "<button style='font-face:Times New Roman;color:white;font-size:8;background-color:black;'>FULL</button>";
}

/* =============== =============== =============== ============= */
//->