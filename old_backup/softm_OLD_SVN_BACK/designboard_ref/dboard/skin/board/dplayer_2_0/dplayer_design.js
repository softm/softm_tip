<!--
/* =============== =============== =============== ============= */
/* 디자인 관련 설정                                              */
/* 변경 가능하나 설정을 삭제하시면 플레이어 동작이 불가능합니다. */
/* 1. BGM 설정방법
    var S_type          = 'C'   ;   // 플레이어 타입  ::> 팝업 : 'P', 현재 페이지 : 'C'
    var S_display       = 'N'   ;   // 플레이어 보임 : 'Y', 숨김 : 'N'
    var S_autoplay      = 'Y'   ;   // 자동 재생 모드 ::> 자동 재생 : 'Y', 자동 재생 안함 : 'N'
*/

/* 변경 가능하나 설정을 삭제하시면 플레이어 동작이 불가능합니다. */
/* 초기 Settting 부분 ============================== */
var S_type          = 'P'       ; // 플레이어 팝업 : 'P', 프레임 : 'F', 현재 페이지 : 'C'

var S_sound         = 'ON'      ; // 플레이어 소리 켜기 / 끄기 ( 'ON' / 'OFF' )

/* 재생 모드 */
var S_autoplay      = 'Y'       ; // 자동 재생 : 'Y', 자동 재생 안함 : 'N'
var S_playMode      = 'S'       ; // 전곡순서  : 'S', 전곡랜덤 : 'R', 현재곡   : 'O'
var S_repeatMode    = '0'       ; // 반복없음  : '0', 반복     : '1'

/* 볼륨 설정 */
var S_initVolume    =  50   ;   // 볼륨 초기값   ( 0 ~ 100 )
var S_minVolume     =   0   ;   // 볼륨 최소크기 ( 0 ~ 100 )
var S_maxVolume     = 100   ;   // 볼륨 최대크기 ( 0 ~ 100 )

/* 볼륨 밸런스 설정 */
var S_initBalance   =    0  ;   // 볼륨 초기값           ( -100 ~ 100 )
var S_minBalance    = -100  ;   // 볼륨 밸런스 최소 크기 ( -100 ~ 100 )
var S_maxBalance    =  100  ;   // 볼륨 밸런스 최대 크기 ( -100 ~ 100 )

var S_display       = 'Y'   ;   // 플레이어 보임 : 'Y', 숨김   : 'N'

var S_listMode      =  '1'  ;   // 재생 목록 현재 페이지 출력 : '1', 팝업 출력 : '2'
var S_lyricsMode    =  '1'  ;   // 가사      현재 페이지 출력 : '1'. 팝업 출력 : '2'

var S_width         = 500   ;   // 팝업 윈도우 가로 크기
var S_height        = 170   ;   // 팝업 윈도우 세로 크기

var S_listWidth     = 500   ;   // 팝업 목록 보기 가로 크기
var S_listHeight    = 526   ;   // 팝업 목록 보기 세로 크기

var S_lyricsWidth   = 500   ;   // 팝업 가사 보기 가로 크기
var S_lyricsHeight  = 526   ;   // 팝업 가사 보기 세로 크기

/* 볼륨 관련 설정 */
var S_volumeAlign   = 'H'   ;   // 볼륨 조절 방향 ( H [수평] / V [수직] )
var S_volumeLength  =  94   ;   // 볼륨 영역 크기 ( 단위 : px )

/* 재생바 관련 설정 */
var S_playBarAlign  = 'H'   ;   // 재생바 조절 방향 ( H [수평] / V [수직] )
var S_playBarLength = 279   ;   // 재생바 영역 크기 ( 단위 : px )

/* 볼륨 밸런스 관련 설정 */
var S_balanceAlign  = 'H'   ;   // 볼륨 밸런스 조절 방향 ( H [수평] / V [수직] )
var S_balanceLength =  41   ;   // 볼륨 밸런스 영역 크기 ( 단위 : px )

/* 플레이어 배경 설정 */
function DISPLAY_BACKGROUND () {
    document.body.background                = "" + skinDir + "/images/background.gif";
    document.body.style.backgroundRepeat    = "no-repeat";
    document.body.style.backgroundPositionX = 0;
    document.body.style.backgroundPositionY = 0;
}

/* 화면 */
var S_screenX = 322; // 영상 위치
var S_screenY = 5  ; // 영상 위치
function DISPLAY_SCREEN () { // 스크린 객체
    O_player.style.left   = S_screenX;
    O_player.style.top    = S_screenY;
    O_player.style.width  = 170;  // 영상 넓이
    O_player.style.height = 140;  // 영상 높이
}

function DISPLAY_SCREEN_END () { // 스크린 객체
    O_player.style.width  = 0;  // 영상 넓이
    O_player.style.height = 0;  // 영상 높이
    // 숨기기
    O_player.style.left = '-2000px';
    O_player.style.top = '-2000px';
}

/* 재생 버튼 */
var S_playBtnX          = 42    ; // 재생     버튼 left 위치
var S_playBtnY          = 89    ; // 재생     버튼 top  위치
function DISPLAY_PLAY_BUTTON () { // 재생     버튼 객체
    P_playBtn.style.width  = 22;
    P_playBtn.style.height = 17;
    P_playBtn.innerHTML = "<img src='" + skinDir + "/images/play_play.gif' alt='재생시작'>";
}

function DISPLAY_PLAY_BUTTON_END () { // 재생     버튼 객체
    P_playBtn.style.width  = 22;
    P_playBtn.style.height = 17;
    P_playBtn.innerHTML = "<img src='" + skinDir + "/images/play_play_r.gif' alt='재생중'>";
}

/* 정지 버튼 */
var S_stopBtnX          = 88   ; // 정지     버튼 left 위치
var S_stopBtnY          = 89   ; // 정지     버튼 top  위치
function DISPLAY_STOP_BUTTON () { // 정지     버튼 객체
    P_stopBtn.style.width  = 22;
    P_stopBtn.style.height = 17;
    P_stopBtn.innerHTML  = "<img src='" + skinDir + "/images/play_stop.gif' alt='정지'>";
}

function DISPLAY_STOP_BUTTON_END () { // 정지     버튼 객체
    P_stopBtn.style.width  = 22;
    P_stopBtn.style.height = 17;
    P_stopBtn.innerHTML  = "<img src='" + skinDir + "/images/play_stop_r.gif' alt='정지됨'>";
}

/* 일시정지 버튼 */
var S_pauseBtnX         = 65    ; // 일시정지 버튼 left 위치
var S_pauseBtnY         = 89    ; // 일시정지 버튼 top  위치
function DISPLAY_PAUSE_BUTTON () { // 일시정지 버튼 객체
    P_pauseBtn.style.width  = 22;
    P_pauseBtn.style.height = 17;
    P_pauseBtn.innerHTML = "<img src='" + skinDir + "/images/play_pause.gif' alt='일시정지'>";
}

function DISPLAY_PAUSE_BUTTON_END () { // 일시정지 버튼 객체
    P_pauseBtn.style.width  = 22;
    P_pauseBtn.style.height = 17;
    P_pauseBtn.innerHTML = "<img src='" + skinDir + "/images/play_pause_r.gif' alt='일시정지됨'>";
}

/* 이전 버튼 */
var S_prevBtnX          = 19   ; // 이전     버튼 left 위치
var S_prevBtnY          = 89   ; // 이전     버튼 top  위치
function DISPLAY_PREV_BUTTON () { // 이전     버튼 객체
    P_prevBtn.style.width  = 22;
    P_prevBtn.style.height = 17;
    P_prevBtn.innerHTML = "<img src='" + skinDir + "/images/play_prev.gif' alt='이전곡'>";
}

function DISPLAY_PREV_BUTTON_END () { // 이전     버튼 객체
    P_prevBtn.style.width  = 22;
    P_prevBtn.style.height = 17;
    P_prevBtn.innerHTML = "<img src='" + skinDir + "/images/play_prev_r.gif' alt='이전곡'>";
}

/* 다음 버튼 */
var S_nextBtnX          = 111   ; // 다음     버튼 left 위치
var S_nextBtnY          = 89    ; // 다음     버튼 top  위치
function DISPLAY_NEXT_BUTTON () { // 다음     버튼 객체
    P_nextBtn.style.width  = 22;
    P_nextBtn.style.height = 17;
    P_nextBtn.innerHTML = "<img src='" + skinDir + "/images/play_next.gif' alt='다음곡'>";
}

function DISPLAY_NEXT_BUTTON_END () { // 다음     버튼 객체
    P_nextBtn.style.width  = 22;
    P_nextBtn.style.height = 17;
    P_nextBtn.innerHTML = "<img src='" + skinDir + "/images/play_next_r.gif' alt='다음곡'>";
}

/* 음소거 버튼 */
var S_soundX            = 258   ; // 뮤트 left 위치
var S_soundY            = 55    ; // 뮤트 top  위치
function DISPLAY_DP_SOUND_ON () { /* 소리 켜기 화면 표시 */
    P_sound.style.width  = 41;
    P_sound.style.height = 13;
    P_sound.innerHTML = "<img src='" + skinDir + "/images/sound_on.gif' alt='소리켜기'>";

}

function DISPLAY_DP_SOUND_OFF() { /* 소리 끄기 화면 표시 */
    P_sound.style.width  = 41;
    P_sound.style.height = 13;
    P_sound.innerHTML = "<img src='" + skinDir + "/images/sound_off.gif' alt='소리끄기'>";
}

/* 제목 */
var S_titleX            = 118  ; // 재생 제목 left 위치
var S_titleY            = 28   ; // 재생 제목 top  위치
function DISPLAY_PLAY_TITLE(artist, title) { /* 재생 음악 제목 */
    P_title.style.width  = 113;
    P_title.style.height = 13;
    P_title.style.color  = 'FFFFFF';
    P_title.innerHTML    = "<marquee scrollamount=10 scrolldelay=200 class='text_01' onmouseover='this.stop()'  onmouseout='this.start()'>" + artist + ' / ' + title +  '</marquee>';
}
function DISPLAY_PLAY_TITLE_END () { /* 재생 음악 제목 완료 */
    P_title.innerHTML = '';
}

/* 재생 상태 */
var S_stateX            = 25    ; // 재생 상태 left 위치
var S_stateY            = 25    ; // 재생 상태 top  위치
function DISPLAY_PLAYER_STATE ( state ) { /* 재생 상태 */
    P_playState.style.width  = 50;
    P_playState.style.height = 15;
    switch ( state ){
        case 1: // 정지
            P_playState.innerHTML = "<span class='text_01'>정지</span>"         ; break;
        case 2: // 일시정지
            P_playState.innerHTML = "<span class='text_01'>일시정지</span>"     ; break;
        case 3: // 재생
            P_playState.innerHTML = "<span class='text_01'>재생중</span>"       ; break;
        case 4:
            P_playState.innerHTML = "<span class='text_01'>ScanForward</span>"  ; break;
        case 5:
            P_playState.innerHTML = "<span class='text_01'>ScanReverse</span>"  ; break;
        case 6: // 버퍼링
            P_playState.innerHTML = "<span class='text_01'>버퍼링</span>"       ; break;
        case 7:
            P_playState.innerHTML = "<span class='text_01'>대기중</span>"       ; break;
        case 8:
            P_playState.innerHTML = "<span class='text_01'>MediaEnded</span>"   ; break;
        case 9:
            P_playState.innerHTML = "<span class='text_01'>연결중</span>"       ; break;
        case 10:
            P_playState.innerHTML = "<span class='text_01'>준비중</span>"       ; break;
        case 11:
            P_playState.innerHTML = "<span class='text_01'>연결중</span>"       ; break;
        case 99:
            P_playState.innerHTML = "<span class='text_01'>종료됨</span>"       ; break;
        default:
            P_playState.innerHTML = "";
    }
}

/* 재생 총시간 */
var S_totTimeX          = 50   ; // 총 재생 시간 left 위치
var S_totTimeY          = 46   ; // 총 재생 시간 top  위치
function DISPLAY_TOT_TIME(min,sec) { /* 총 재생 시간 */
    P_totTime.style.textAlign ='center';
    P_totTime.style.width  = 50;
    P_totTime.style.height = 15;
    P_totTime.innerHTML = "<span class='text_03'> / " + min + ":" + sec + "</span>";
}

function DISPLAY_TOT_TIME_END  () { /* 총 재생 시간 완료 */
    P_totTime.innerHTML = '';
}

/* 현재 재생 시간 */
var S_playTimeX      = 15      ; // 재생 시간 left 위치
var S_playTimeY      = 46      ; // 재생 시간 top  위치
function DISPLAY_PLAY_TIME (min,sec) { // 재생 시간
    P_playTime.style.textAlign ='center';
    P_playTime.style.width  = 50;
    P_playTime.style.height = 15;
    P_playTime.innerHTML = "<span class='text_03'>" + min + ":" + sec + "</span>";
}
function DISPLAY_PLAY_TIME_END () { // 재생시간 완료
    P_playTime.innerHTML  = '';
}

/* 현재 남은 시간 */
var S_remindTimeX       = -100  ; // 남은 재생 시간 left 위치
var S_remindTimeY       = -100  ; // 남은 재생 시간 top  위치
function DISPLAY_REMIND_TIME(min,sec) { /* 남은 시간 표시 */
    P_remindTime.style.textAlign ='center';
    P_remindTime.style.width  = 50;
    P_remindTime.style.height = 15;
    P_remindTime.innerHTML = min + ':' + sec;
}

function DISPLAY_REMIND_TIME_END() { /* 남은 시간 완료 */
    P_remindTime.innerHTML = '';
}

/* 버퍼링 */
var S_bufferingX        = -100  ; // 버퍼링 left 위치
var S_bufferingY        = -100  ; // 버퍼링 top  위치
function DISPLAY_BUFFERING (buffering) { // 버퍼링
    P_buffering.style.width  = 50;
    P_buffering.style.height = 15;
    P_buffering.innerHTML  = "<span class='text_03'>" + buffering + "%" + "</span>";
}
function DISPLAY_BUFFERING_END () { // 버퍼링 완료
    P_buffering.innerHTML  = "";
}

/* 다운로드 */
var S_downloadX         = -100   ; // 다운로드 left 위치
var S_downloadY         = -100   ; // 다운로드 top  위치
function DISPLAY_DOWNLOAD  (download) { // 다운로드
    P_download.style.width  = 50;
    P_download.style.height = 15;
    P_download.innerHTML  = "<span class='text_03'>" + download + "%" + "</span>";
}
function DISPLAY_DOWNLOAD_END  () { // 다운로드 COMPLETE
    P_download.innerHTML  = "";
}

/* 볼륨값 */
var S_volumePercentX    = 241  ; // 재생 제목 left 위치
var S_volumePercentY    = 25   ; // 재생 제목 top  위치
function DISPLAY_VOLUME_PERCENT (percent) { // 볼
    P_volumePercent.style.width  = 50;
    P_volumePercent.style.height = 15;
    P_balancePercent.innerHTML = '';
    P_playBarPercent.innerHTML = '';
    P_volumePercent.innerHTML  = "<span class='text_03'><font color='DECC00' size='1'>Vol : " + percent + "%" + "</font></span>";
}
function DISPLAY_VOLUME_PERCENT_END () { // 볼륨값 완료
//    P_volumePercent.innerHTML  = '';
}

/* 밸런스 비율값 */
var S_balancePercentX   = 241    ; // 밸런스 값 left 위치
var S_balancePercentY   = 25     ; // 밸런스 값 top  위치
function DISPLAY_BALANCE_PERCENT (percent) { // 밸런스바 시간
    P_balancePercent.style.width  = 55;
    P_balancePercent.style.height = 15;
    P_volumePercent.innerHTML  = '';
    P_playBarPercent.innerHTML = '';
    P_balancePercent.innerHTML = "<span class='text_03'><font color='DECC00' size='1'>Bal : " + percent + "%" + "</font></span>";
}

function DISPLAY_BALANCE_PERCENT_END () { // 밸런스바 완료
//    P_balancePercent.innerHTML  = '';
}

/* 재생 비율값 */
var S_playBarPercentX   = 241 ; // 재생 비율값 left 위치
var S_playBarPercentY   = 25  ; // 재생 비율값 top  위치
function DISPLAY_PLAY_BAR_PERCENT (percent) { // 재생바 비율
    P_playBarPercent.style.width  = 55;
    P_playBarPercent.style.height = 15;
    P_volumePercent.innerHTML  = '';
    P_balancePercent.innerHTML = '';
    P_playBarPercent.innerHTML = "<span class='text_03'><font color='DECC00' size='1'>Play : " + percent + "%" + "</font></span>";
}
function DISPLAY_PLAY_BAR_PERCENT_END () {  // 재생바 완료
    P_playBarPercent.innerHTML  = '';
}

/* 볼륨 조절 컨트롤 */
var S_volumeX           = 113   ; // 볼륨 조절 left 위치
var S_volumeY           =  58   ; // 볼륨 조절 top  위치
function DISPLAY_VOLUME_BAR () {
    P_volumeBar.style.width  = 15;
    P_volumeBar.style.height = 8 ;
    P_volumeBar.innerHTML = "<img src='" + skinDir + "/images/bar_volume.gif' alt='볼륨조절'>";
//    P_volumeBar.innerHTML = "<BUTTON></BUTTON>";
}

/* 재생바 조절 컨트롤 */
var S_playBarX          = 20    ; // 재생바 조절 left 위치
var S_playBarY          = 73    ; // 재생바 조절 top  위치
function DISPLAY_PLAY_BAR () {
    P_playBar.style.width       = 21 ;
    P_playBar.style.height      = 10 ;
    P_playBar.innerHTML = "<img src='" + skinDir + "/images/bar_play.gif' alt='재생위치조절'>";
}

/* 볼륨 밸런스 조절 컨트롤 */
var S_balanceX          = 212   ; // 볼륨 밸런스 조절 left 위치
var S_balanceY          = 58    ; // 볼륨 밸런스 조절 top  위치
function DISPLAY_BALANCE_BAR () {
    P_balanceBar.style.width       = 15;
    P_balanceBar.style.height      = 8 ;
    P_balanceBar.innerHTML = "<img src='" + skinDir + "/images/bar_balance.gif' alt='볼륨밸런스조절'>";
}

/* 이퀄라이져1 표시 객체 */
var S_equalizer1X          = 76   ; // 이퀄라이져1 left 위치
var S_equalizer1Y          = 23    ; // 이퀄라이져1 top  위치
function DISPLAY_EQUALIZER1_ON () {
    P_equalizer1.style.width       = 15;
    P_equalizer1.style.height      = 8 ;
    P_equalizer1.innerHTML  = "<img src='" + skinDir + "/images/equalizer1_on.gif' alt='이퀄라이져'>";
}
function DISPLAY_EQUALIZER1_OFF () {
    P_equalizer1.style.width       = 15;
    P_equalizer1.style.height      = 8 ;
    P_equalizer1.innerHTML  = "<img src='" + skinDir + "/images/equalizer1_off.gif' alt='이퀄라이져'>";
}

/* 이퀄라이져2 표시 객체 */
var S_equalizer2X          = -100  ; // 이퀄라이져2 left 위치
var S_equalizer2Y          = -100  ; // 이퀄라이져2 top  위치
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

/* 재생 모드 */
var S_playModeX         = 214   ; // 재생 모드 left 위치
var S_playModeY         = 89    ; // 재생 모드 top  위치
function DISPLAY_PLAY_MODE_ALL_SEQUENCE () { // 전곡순서
    P_playMode.style.width       = 41;
    P_playMode.style.height      = 17;
    P_playMode.innerHTML = "<img src='" + skinDir + "/images/play_all.gif' alt='모두'>";
}

function DISPLAY_PLAY_MODE_ALL_RANDOM   () { // 전곡랜덤
    P_playMode.style.width       = 41;
    P_playMode.style.height      = 17;
    P_playMode.innerHTML = "<img src='" + skinDir + "/images/play_random.gif' alt='랜덤'>";

}

function DISPLAY_PLAY_MODE_ONLY         () { // 현재곡
    P_playMode.style.width       = 41;
    P_playMode.style.height      = 17;
    P_playMode.innerHTML = "<img src='" + skinDir + "/images/play_one.gif' alt='한곡'>";
}

/* 반복 모드 */
var S_repeatModeX      = 257  ; // 반복 모드 left 위치
var S_repeatModeY      = 89   ; // 반복 모드 top  위치
function DISPLAY_REPEAT_MODE () { // 반복
    P_repeatMode.style.width       = 41;
    P_repeatMode.style.height      = 17;
    P_repeatMode.innerHTML = "<img src='" + skinDir + "/images/play_repeat.gif' alt='반복'>";
}

function DISPLAY_SINGLE_MODE  () { // 반복없음
    P_repeatMode.style.width       = 41;
    P_repeatMode.style.height      = 17;
    P_repeatMode.innerHTML = "<img src='" + skinDir + "/images/play_only.gif' alt='한번만'>";
}

/* 재생 목록 표시 버튼 */
var S_playListBtnX     = 19   ; // 재생 목록 표시 버튼 left 위치
var S_playListBtnY     = 118  ; // 재생 목록 표시 버튼 top  위치
function DISPLAY_PLAY_LIST_BUTTON  () {
    P_playListBtn.style.width       = 41;
    P_playListBtn.style.height      = 17;
    P_playListBtn.innerHTML = "<img src='" + skinDir + "/images/play_list.gif' alt='리스트보기'>";
}

/* 재생 가사 표시 버튼 */
var S_playLyricsBtnX     = 250 ; // 재생 가사 표시 버튼 left 위치
var S_playLyricsBtnY     = 118 ; // 재생 가사 표시 버튼 top  위치
function DISPLAY_PLAY_LYRICS_BUTTON() { //
    P_playLyricsBtn.style.width       = 41;
    P_playLyricsBtn.style.height      = 17;
    P_playLyricsBtn.innerHTML = "<img src='" + skinDir + "/images/play_lyrics.gif' alt='가사보기'>";
}

/* 리스트, 가사 목록 가사 닫기 표시 */
var S_listCloseX  = 247  ; // 목록 가사 닫기 표시 left 위치
var S_listCloseY  = 181  ; // 목록 가사 닫기 표시 top  위치
function DISPLAY_LIST_CLOSE  () { //    목록 가사 닫기 표시
    P_listClose.style.width       = 41;
    P_listClose.style.height      = 17;
    P_listClose.innerHTML  = "<img src='" + skinDir + "/images/close.gif' alt='닫기'>";
}

/* 닫기 표시 */
var S_closeX  = -100  ; // 목록 가사 닫기 표시 left 위치
var S_closeY  = -100  ; // 목록 가사 닫기 표시 top  위치
function DISPLAY_CLOSE  () { //    닫기 표시 객체
    P_close.style.width       = 41;
    P_close.style.height      = 17;
    P_close.innerHTML = "닫기";
}

/* 카피라이트 표시 */
var S_copyRightX  = 100  ; // 카피라이트 표시 left 위치
var S_copyRightY  = 149  ; // 카피라이트 표시 top  위치
function DISPLAY_COPYRIGHT         () {
    P_copyRight.style.width       = 200;
    P_copyRight.style.height      = 17 ;
//  P_copyRight.innerHTML = "copyright by <a href='http://www.designboard.net' target='_new'>designboard.net</a>";
    P_copyRight.innerHTML  = "<a href='http://www.designboard.net' target='_new' onFocus='this.blur();'><img src='" + skinDir + "/images/copy.gif' border='0'></a>";
}

/* 재생 목록 영역 */
var S_listFrameX  = 17   ; // 재생 목록 영역 left 위치
var S_listFrameY  = 199  ; // 재생 목록 영역 top  위치
function DISPLAY_LIST_FRAME     () {
    P_listFrame.style.width     = 287;
    P_listFrame.style.height    = 294;
}

function DISPLAY_LIST_FRAME_END () {
    P_listFrame.style.width     = 0;
    P_listFrame.style.height    = 0;
}

/* 재생 가사 영역 */
var S_lyricsFrameX  = 17   ; // 재생 가사 영역 left 위치
var S_lyricsFrameY  = 199  ; // 재생 가사 영역 top  위치
function DISPLAY_LYRICS_FRAME   () {
    P_lyricsFrame.style.width   = 287;
    P_lyricsFrame.style.height  = 294;
}

function DISPLAY_LYRICS_FRAME_END () {
    P_lyricsFrame.style.width   = 0;
    P_lyricsFrame.style.height  = 0;
}

/* 풀스크린 버튼 */
var S_fullScrBtnX   = 285   ; // 풀스크린 버튼 left 위치
var S_fullScrBtnY   = 3    ; // 풀스크린 버튼 top  위치
function DISPLAY_FULLSCR_BUTTON () { // 풀스크린 버튼 객체
    P_FullScrBtn.style.width  = 28;
    P_FullScrBtn.style.height = 15;
    P_FullScrBtn.innerHTML = "<button style='font-face:Times New Roman;color:white;font-size:8;background-color:black;'>FULL</button>";
}

function DISPLAY_FULLSCR_BUTTON_END () { // 풀스크린 버튼 객체
    P_FullScrBtn.style.width  = 200;
    P_FullScrBtn.style.height = 200;
    P_FullScrBtn.innerHTML = "<button style='font-face:Times New Roman;color:white;font-size:8;background-color:black;'>FULL</button>";
}

/* =============== =============== =============== ============= */
//->