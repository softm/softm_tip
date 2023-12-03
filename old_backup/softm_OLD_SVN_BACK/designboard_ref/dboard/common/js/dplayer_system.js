<!--
/* 변경 불가능한 초기 Settting 부분     */
var S_point = 0                             ; // 현재 음악 위치 ( 0 이면 첫번째 곡 )
var S_key   = ''                            ; // Current Play Key 지정
var S_index = 0                             ; // 내부 Key

/* 객체 정보            */
var O_player            = null              ; // Player        객체
var O_playList          = new DP_HashTable ();// 재생 목록     객체

var P_playBtn           = null              ; // 재생     버튼 객체
var P_stopBtn           = null              ; // 정지     버튼 객체
var P_pauseBtn          = null              ; // 일시정지 버튼 객체
var P_prevBtn           = null              ; // 이전     버튼 객체
var P_nextBtn           = null              ; // 다음     버튼 객체

var P_volumeBar         = null              ; // 볼륨   조절   객체
var P_playBar           = null              ; // 재생바 조절   객체
var P_balanceBar        = null              ; // 볼륨 밸런스바 객체

var P_sound             = null              ; // 뮤트        객체

/* 프린트 객체 정보     */
var P_playState  = null ; // 재생 상태  표시 객체
var P_totTime    = null ; // 재생 시간  표시 객체
var P_remindTime = null ; // 남은 시간  표시 객체
var P_title      = null ; // 제목       표시 객체
var P_playMode   = null ; // 재생 모드  표시 객체
var P_repeatMode = null ; // 반복 모드  표시 객체

var P_buffering     = null ; // 버퍼링    표시 객체
var P_download      = null ; // 다운로드  표시 객체

var P_volumePercent = null; // 볼륨값          표시 객체
var P_playBarPercent= null; // 재생 비율값     표시 객체
var P_playTime      = null; // 재생바   시간값 표시 객체
var P_balancePercent= null; // 밸런스값        표시 객체

var P_equalizer1    = null; // 이퀄라이져1 표시 객체
var P_equalizer2    = null; // 이퀄라이져2 표시 객체

var P_playListBtn     = null;   // 재생 목록 표시 객체
var P_playLyricsBtn   = null;   // 재생 가사 표시 버튼
var P_listClose       = null;   // 목록 가사 닫기 표시 객체
var P_close           = null;   // 닫기 표시 객체
var P_copyRight       = null;   // 카피라이트표시 객체

var P_listFrame       = null;   // 재생 목록 영역 객체
var P_lyricsFrame     = null;   // 재생 가사 영역 객체
var P_listHeader      = null;   // 재생 목록 스킨 [헤더]
var P_listMain        = null;   // 재생 목록 스킨 [메인]
var P_listFooter      = null;   // 재생 목록 스킨 [풋터]

var P_lyricsHeader    = null;   // 재생 가사 스킨 [헤더]
var P_lyricsMain      = null;   // 재생 가사 스킨 [메인]
var P_lyricsFooter    = null;   // 재생 가사 스킨 [풋터]
var P_FullScrBtn      = null;   // 풀 스크린 객체

var O_lyricsJS        = null;   // 재생 가사 데이터 JS

/* 내부 타이머 객체     */
var T_playerTime    = null; // 재생     타이머
var T_bufferingTime = null; // 버퍼링   타이머
var T_downloadTime  = null; // 다운로드 타이머
var T_lyricsSet     = null; // 가사 페이지 로드 타이머

/* 내부 사용 변수 정보  */
var skinDir      = ''   ; // 스킨 경로
var V_playTime   = 0    ; // 재생 시간 ( 초 )
var V_playState  = false; // 재생 상태

var V_volumeBarState = false; // 볼륨바         [조절시작:true,조절멈춤:false]
var V_playBarState   = false; // 재생 상태바    [조절시작:true,조절멈춤:false]
var V_balanceBarState= false; // 볼륨 밸런스바  [조절시작:true,조절멈춤:false]

var V_playBarPos   = 0  ; // 상태 바 위치
var V_playedKey = '' ; // 재생된 파일정보

var V_viewState  = false; // 보기      상태
var V_listView   = false; // 재생 목록 상태
var V_lyricsView = false; // 가사 보기 상태

var V_playListLoad = false; // 재생 목록 로드 여부 ( 한번만 로드하면 됨 )

var V_MediaWidth   = 0; // 영상 넓이
var V_MediaHeight  = 0; // 영상 높이

var DP_lyricsData  = ''   ; // 가사

var W_playList   = null; // 재생 목록 팝업
var W_playLyrics = null; // 가사      팝업

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

function DP_DBOARD_PLAY_CB (callProc) { // 재생 콜백 함수

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

function DP_PLAY_CB (callProc) { // 재생 콜백 함수
    if ( S_display == 'Y') { 
        DISPLAY_PREV_BUTTON     (); // 이전     버튼 [초기화]
        DISPLAY_NEXT_BUTTON     (); // 다음     버튼 [초기화]
        DISPLAY_STOP_BUTTON     (); // 정지     버튼 [초기화]
        DISPLAY_PAUSE_BUTTON    (); // 일시정지 버튼 [초기화]
        DISPLAY_PLAY_BUTTON_END (); // 재생     버튼 [완료  ]
    }
    if ( O_playList.DP_getSize() > 0 ) {
        if ( S_point == null ) S_point = 0;
        var playItem = O_playList.DP_getVal( S_point );
        var key = playItem.getId () + '-' + playItem.getNo ();

        // 1초마다 시간 타이머 발생
        if ( T_playerTime != null ) window.clearInterval(T_playerTime); // 타이머 해제
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
        if ( T_lyricsSet != null ) window.clearInterval(T_lyricsSet)  ; // 타이머 해제
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
//      alert ( '가사 얻기 성공' ); 
        if ( T_lyricsSet != null ) window.clearInterval(T_lyricsSet)  ; // 타이머 해제
    } else if ( lryricsUrl == null ) {
        DP_PLAY_LYRICS_MAKE ();
//      alert ( '가사 경로가 없음' ); 
        if ( T_lyricsSet != null ) window.clearInterval(T_lyricsSet)  ; // 타이머 해제
    } else {
    }
}

function DP_PLAY () { // 재생
    if ( dboardEmbed == 'N' ) {
        DP_PLAY_CB ('DP_PLAY');
    } else {
        DP_DBOARD_PLAY_CB  ('DP_PLAY');
    }
}

function DP_PAUSE() { // 일시정지
    if ( V_playState == 3 ) {
        V_playState = 2;
        if ( S_display == 'Y') { 
            DISPLAY_PAUSE_BUTTON_END(); // 일시정지 버튼 [완료  ]
            DISPLAY_PLAY_BUTTON     (); // 재생     버튼 [초기화]
            DISPLAY_STOP_BUTTON     (); // 정지     버튼 [초기화]
            DISPLAY_PREV_BUTTON     (); // 이전     버튼 [초기화]
            DISPLAY_NEXT_BUTTON     (); // 다음     버튼 [초기화]
        }
    }
    V_playState = 2;
    DP_CLEAR_TIMER(); // 타이머 전체 해제
    O_player.controls.pause ();
}

function DP_CLEAR_TIMER() {
    if ( T_playerTime    != null ) window.clearInterval(T_playerTime    ); // 타이머 해제
    if ( T_bufferingTime != null ) window.clearInterval(T_bufferingTime ); // 타이머 해제
    if ( T_downloadTime  != null ) window.clearInterval(T_downloadTime  ); // 타이머 해제
    if ( T_lyricsSet     != null ) window.clearInterval(T_lyricsSet     ); // 타이머 해제
}

function DP_STOP () { // 정지
    V_playState = 13    ; // 사용자 셋팅값 내부 state값과는 연관성없음.
    DP_CLEAR_TIMER()    ; // 타이머 전체 해제
    DP_PLAY_BAR_INIT()  ; // 재생바 초기화
    S_key       = ''    ; // 키초기화
    O_player.controls.stop ();
    if ( S_display == 'Y') {
        DISPLAY_STOP_BUTTON_END (); // 정지     버튼 [완료  ]
        DISPLAY_PLAY_BUTTON     (); // 재생     버튼 [초기화]
        DISPLAY_PAUSE_BUTTON    (); // 일시정지 버튼 [초기화]
        DISPLAY_PREV_BUTTON     (); // 이전     버튼 [초기화]
        DISPLAY_NEXT_BUTTON     (); // 다음     버튼 [초기화]

        DISPLAY_VOLUME_PERCENT_END     (); // 볼륨값 완료
        DISPLAY_PLAY_BAR_PERCENT_END   (); // 재생바 완료
        DISPLAY_PLAY_TIME_END          (); // 재생시간 완료
        DISPLAY_BALANCE_PERCENT_END    (); // 밸런스바 완료

        DISPLAY_BUFFERING_END          (); // 버퍼링 완료
        DISPLAY_DOWNLOAD_END           (); // 다운로드 COMPLETE

        DISPLAY_TOT_TIME_END           (); /* 총 재생 시간 완료    */
        DISPLAY_REMIND_TIME_END        (); /* 남은 시간 완료       */
        DISPLAY_PLAY_TITLE_END         (); /* 재생 음악 제목 완료  */
    }

}

function DP_SET_PLAY (point) { // 재생리스트에서 선택된 음악
    S_point = point;
    if ( dboardEmbed == 'N' ) {
        DP_PLAY_CB('SET');
    } else {
        DP_DBOARD_PLAY_CB('SET');
    }
}

function DP_NEXT () { // 다음
    if ( V_playState > 0 && V_playState < 4 ) {
        V_playState = 55; // 다음 버튼을 눌렀을때 상태 코드 임의의 값으로 할당.
                          // 이유:> 재생 버튼이나 다른 버튼을 누르지 못하도록.
        if (S_point==null) {
            S_point = 0;
        } else {
            if ( S_playMode == 'R' ) { // 랜덤 재생
                S_point = DP_randPlayNumber (S_key);
            } else {
                S_point++;
            }
            if ( O_playList.DP_getSize() <= S_point ) { S_point = 0; }
        }
        if ( S_display == 'Y') {
            DISPLAY_PLAY_BUTTON     (); // 재생     버튼 [초기화]
            DISPLAY_PREV_BUTTON     (); // 이전     버튼 [초기화]
            DISPLAY_NEXT_BUTTON_END (); // 다음     버튼 [완료  ]
        }
        if ( dboardEmbed == 'N' ) {
            DP_PLAY_CB ('DP_NEXT');
        } else {
            DP_DBOARD_PLAY_CB ('DP_NEXT');
        }
    }
}

function DP_PREV () { // 이전
    if ( V_playState > 0 && V_playState < 4 ) {
        V_playState = 55; // 다음 버튼을 눌렀을때 상태 코드 임의의 값으로 할당.
                          // 이유:> 재생 버튼이나 다른 버튼을 누르지 못하도록.
        if (S_point==null) {
            S_point = 0;
        } else {
            if ( S_playMode == 'R' ) { // 랜덤 재생
                S_point = DP_randPlayNumber (S_key);
            } else {
                S_point--;
            }
            if ( S_point < 0 ) { S_point = O_playList.DP_getSize() - 1; }
        }
        if ( S_display == 'Y') {
            DISPLAY_PLAY_BUTTON     (); // 재생     버튼 [초기화]
            DISPLAY_NEXT_BUTTON     (); // 다음     버튼 [초기화]
            DISPLAY_PREV_BUTTON_END (); // 이전     버튼 [완료  ]
        }

        if ( dboardEmbed == 'N' ) {
            DP_PLAY_CB ('DP_PREV');
        } else {
            DP_DBOARD_PLAY_CB ('DP_PREV');
        }
    }
}

function DP_SOUND (mode) { // 소리 켜기 / 끄기
//        alert ( mode );
    // 초기화인 경우
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

function DP_VOLUME_BAR_START() { /* 볼륨 조절 시작 */
    V_volumeBarState=true;
    DP_SOUND  ('ON'); // 소리 켜기
    document.onmousemove = DP_VOLUME_MOVE   ; // 마우스를 누른 상태에서 이동시
    document.onmouseup   = DP_VOLUME_BAR_END; // 마우스를 업
}

function DP_VOLUME_MOVE() { /* 볼륨 조절 이동 */
    if ( V_volumeBarState == true ) {
        var fullSize = null; // 볼륨 조절 객체 크기
        var halfSize = null; // 볼륨 조절 객체 크기 1/2 값
        var position = null; // 현재 마우스의 위치
        var S_volume = null; // 볼륨 조절 객체의 초기 위치
        if ( S_volumeAlign == 'H' ) { // 수평 조절
            fullSize = parseFloat(P_volumeBar.style.width);
            halfSize = parseFloat(fullSize / 2);
            position = window.event.clientX + document.body.scrollLeft - halfSize;
            S_volume = S_volumeX;
        } else { // 수직 조절
            fullSize = parseFloat(P_volumeBar.style.height);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientY + document.body.scrollTop - halfSize;
            S_volume = S_volumeY;
        }
        position = parseInt(position);

        var areaProp     = ( ( position - S_volume ) / ( S_volumeLength - fullSize ) ) * 100; // 영역의 비율
            areaProp     = Math.round(areaProp,-1);

        var volumeLength = S_maxVolume - S_minVolume;
        var curVolume    = 0;

        if ( areaProp >= 0 && areaProp <= 100 ) {
            if ( S_volumeAlign == 'H' ) { // 수평 조절
                P_volumeBar.style.left = position;
            } else { // 수직 조절
                P_volumeBar.style.top  = position;
            }
            curVolume    = volumeLength * ( areaProp / 100 ); // 볼륨
            O_player.settings.volume = curVolume; // 볼륨 설정
            DP_VOLUME_PERCENT (areaProp); // 볼륨 비율
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

function DP_VOLUME_BAR_END() { /* 볼륨 조절 끝 */
    V_volumeBarState=false;
    if ( S_display == 'Y') { DISPLAY_VOLUME_PERCENT_END (); }
    document.onmousemove = null; // 마우스를 누른 상태에서 이벤트 해제
    document.onmouseup   = null; // 마우스를 업 이벤트 해제
}

function DP_VOLUME_PERCENT (percent) { /* 볼륨 수치 */
    if ( S_display == 'Y') { DISPLAY_VOLUME_PERCENT (percent); }
}

function DP_PLAY_BAR_START() { /* 재생바 조절 시작 */
    if ( V_playState > 1 && V_playState < 4 ) {
        V_playBarState=true;
        document.onmousemove = DP_PLAY_BAR_MOVE; // 마우스를 누른 상태에서 이동시
        document.onmouseup   = DP_PLAY_BAR_END ; // 마우스를 업
    }
}

function DP_PLAY_BAR_MOVE() { /* 재생바 조절 이동 */
    if ( V_playBarState ) {

        var fullSize = null; // 재생바 조절 객체 크기
        var halfSize = null; // 재생바 조절 객체 크기 1/2 값
        var position = null; // 현재 마우스의 위치
        var S_playBar= null; // 재생바 조절 객체의 초기 위치
        if ( S_playBarAlign == 'H' ) { // 수평 조절
            fullSize = parseFloat(P_playBar.style.width);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientX + document.body.scrollLeft - halfSize;
            S_playBar= S_playBarX;
        } else { // 수직 조절
            fullSize = parseFloat(P_playBar.style.height);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientY + document.body.scrollTop - halfSize;
            S_playBar= S_playBarY;
        }

        position = parseInt(position);

        var areaProp  = ( ( position - S_playBar ) / ( S_playBarLength - fullSize ) ) * 100; // 영역의 비율
            areaProp  = Math.round(areaProp,-1);
        if ( areaProp >= 0 && areaProp <= 100 ) {
            if ( S_playBarAlign == 'H' ) { // 수평 조절
                P_playBar.style.left = position;
            } else { // 수직 조절
                P_playBar.style.top  = position;
            }
            var curPosition = parseFloat( V_playTime * ( areaProp / 100 )); // 재생바 위치
            V_playBarPos    = curPosition;
            var secArray = DP_secToMinSec(curPosition);
            DP_PLAY_BAR_PERCENT (areaProp               ); // 재생바 비율
            DP_PLAY_BAR_TIME    (secArray[0],secArray[1]); // 재생 시간
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

function DP_PLAY_BAR_END() { /* 재생바 조절 끝 */
    V_playBarState=false;
    document.onmousemove = null; // 마우스를 누른 상태에서 이벤트 해제
    document.onmouseup   = null; // 마우스를 업 이벤트 해제
    O_player.controls.currentPosition = V_playBarPos;
    if ( T_playerTime != null ) window.clearInterval(T_playerTime); // 타이머 해제
    T_playerTime = window.setInterval("DP_inforUpdate()",500);
}

function DP_PLAY_BAR_UPDATE () { /* 재생바 상태 갱신 */
    if ( V_playState == 3 && V_playBarState == false ) {
        var fullSize = null; // 재생바 조절 객체 크기
        var halfSize = null; // 재생바 조절 객체 크기 1/2 값
        var S_playBar= null;
        if ( S_playBarAlign == 'H' ) { // 수평 조절
            fullSize = parseFloat(P_playBar.style.width);
            halfSize = parseFloat(fullSize / 2);
            S_playBar= S_playBarX;
        } else { // 수직 조절
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
        if ( !V_balanceBarState && !V_volumeBarState ) { // 볼륨바, 밸런스바 조정중이 아닐경우에만 갱신
            DP_PLAY_BAR_PERCENT (areaProp               ); // 재생바 비율
        }
        DP_PLAY_BAR_TIME    (secArray[0],secArray[1]); // 재생 시간
        if ( S_playBarAlign == 'H' ) { // 수평 조절
            position += document.body.scrollLeft;
            DP_objectMoveTo(P_playBar,position,S_playBarY); // 재생바 [위치 조정]
        } else { // 수직 조절
            position += document.body.scrollTop;
            DP_objectMoveTo(P_playBar,S_playBarX,position); // 재생바 [위치 조정]
        }
    }
}

function DP_BALANCE_BAR_START() { /* 볼륨 밸런스바 조절 시작 */
    V_balanceBarState=true;
//    DP_SOUND_ON  (); // 소리 켜기
    document.onmousemove = DP_BALANCE_BAR_MOVE  ; // 마우스를 누른 상태에서 이동시
    document.onmouseup   = DP_BALANCE_BAR_END   ; // 마우스를 업
}

function DP_BALANCE_BAR_MOVE() { /* 볼륨 밸런스바 조절 이동 */
    if ( V_balanceBarState == true ) {
        var fullSize  = null; // 볼륨 밸런스 조절 객체 크기
        var halfSize  = null; // 볼륨 밸런스 조절 객체 크기 1/2 값
        var position  = null; // 현재 마우스의 위치
        var S_balance = null; // 볼륨 조절 객체의 초기 위치
        if ( S_balanceAlign == 'H' ) { // 수평 조절
            fullSize = parseFloat(P_balanceBar.style.width);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientX + document.body.scrollLeft - halfSize;
            S_balance = S_balanceX;
        } else { // 수직 조절
            fullSize = parseFloat(P_balanceBar.style.height);
            halfSize = parseFloat(fullSize / 2);
            position  = window.event.clientY + document.body.scrollTop - halfSize;
            S_balance = S_balanceY;
        }
        position = parseInt(position);
        var areaProp      = ( ( position - S_balance ) / ( S_balanceLength - fullSize ) ) * 100; // 영역의 비율
            areaProp      = Math.round(areaProp,-1);

        if ( areaProp >= 0 && areaProp <= 100 ) {
            if ( S_balanceAlign == 'H' ) { // 수평 조절
                P_balanceBar.style.left = position;
            } else { // 수직 조절
                P_balanceBar.style.top  = position;
            }
            var balanceLength = S_maxBalance - S_minBalance;
            var curBalance    = balanceLength * ( areaProp / 100 ); // 볼륨
            var balance       = parseInt(S_minBalance + curBalance);
                O_player.settings.balance = balance; // 볼륨 설정

            DP_BALANCE_BAR_PERCENT (balance); // 재생바 비율
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

function DP_BALANCE_BAR_END() { /* 볼륨 밸런스바 조절 끝 */
    V_balanceBarState=false;
    document.onmousemove = null; // 마우스를 누른 상태에서 이벤트 해제
    document.onmouseup   = null; // 마우스를 업 이벤트 해제
    if ( S_display == 'Y') { DISPLAY_BALANCE_PERCENT_END(); }
}

/* 초기화 관련 */
function DP_VOLUME_BAR_INIT() { /* 볼륨 조절 초기화 */
    if ( S_initVolume > 100 || S_initVolume < 0 ) { S_initVolume = 50 ; }
    if ( S_maxVolume  > 100 || S_maxVolume  < 0 ) { S_maxVolume  = 100; }
    if ( S_minVolume  > 100 || S_minVolume  < 0 ) { S_minVolume  = 0  ; }

    var fullSize = null; // 볼륨 조절 객체 크기
    var halfSize = null; // 볼륨 조절 객체 크기 1/2 값
    var S_playBar= null;

    if ( S_volumeAlign == 'H' ) { // 수평 조절
        fullSize = parseFloat(P_volumeBar.style.width);
        halfSize = parseFloat(fullSize / 2);
        S_volume = S_volumeX;
    } else { // 수직 조절
        fullSize = parseFloat(P_volumeBar.style.height);
        halfSize = parseFloat(fullSize / 2);
        S_volume = S_volumeY;
    }

    var volumeLength = S_maxVolume - S_minVolume;
    var areaProp     = S_initVolume / volumeLength * 100; // 볼륨크기에대한 비율 계산

    var position = ( ( areaProp / 100  ) * ( S_volumeLength - fullSize ) ) + ( S_volume ); // 볼륨 X좌표 계산
        position = parseInt(position);
    if ( S_volumeAlign == 'H' ) { // 수평 조절
        position += document.body.scrollLeft;
        DP_objectMoveTo(P_volumeBar,position,S_volumeY); // 볼륨 조절 [위치 조정]
    } else { // 수직 조절
        position += document.body.scrollTop;
        DP_objectMoveTo(P_volumeBar,S_volumeX,position); // 볼륨 조절 [위치 조정]
    }

    O_player.settings.volume = parseInt(S_initVolume); // 볼륨 초기치 설정

}

function DP_PLAY_BAR_INIT() { /* 재생바 초기화 */
    DP_objectMoveTo(P_playBar,S_playBarX,S_playBarY); // 볼륨 조절 [위치 조정]
}

function DP_PLAY_BALANCE_INIT() { /* 볼륨 밸런스바 초기화 */
    if ( S_initBalance > 100 || S_initBalance < -100 ) { S_initBalance = 0   ; }
    if ( S_maxBalance  > 100 || S_maxBalance  < -100 ) { S_maxBalance  = 100 ; }
    if ( S_minBalance  > 100 || S_minBalance  < -100 ) { S_minBalance  =-100 ; }

    if ( S_minBalance > S_maxBalance  ) { S_minBalance = -100; }
    if ( S_initBalance < S_minBalance ) { S_minBalance = -100; }
    if ( S_initBalance > S_maxBalance ) { S_maxBalance =  100; }

    var fullSize  = null; // 볼륨 밸런스 조절 객체 크기
    var halfSize  = null; // 볼륨 밸런스 조절 객체 크기 1/2 값
    var S_balance= null;
    if ( S_balanceAlign == 'H' ) { // 수평 조절
        fullSize = parseFloat(P_balanceBar.style.width);
        halfSize = parseFloat(fullSize / 2);
        S_balance = S_balanceX;
    } else { // 수직 조절
        fullSize = parseFloat(P_balanceBar.style.height);
        halfSize = parseFloat(fullSize / 2);
        S_balance = S_balanceY;
    }

    var balanceLength   = S_maxBalance - S_minBalance ;

    var relativeBalance = Math.abs( S_minBalance - S_initBalance );

    var areaProp        = relativeBalance / balanceLength * 100; // 볼륨크기에대한 비율 계산

    var position = ( ( areaProp / 100  ) * ( S_balanceLength - fullSize ) ) + S_balance; // 볼륨 X좌표 계산

    if ( S_balanceAlign == 'H' ) { // 수평 조절
        position += document.body.scrollLeft;
        DP_objectMoveTo(P_balanceBar,position,S_balanceY); // 볼륨 조절 [위치 조정]
    } else { // 수직 조절
        position += document.body.scrollTop;
        DP_objectMoveTo(P_balanceBar,S_balanceX,position); // 볼륨 조절 [위치 조정]
    }

    O_player.settings.balance = parseInt(S_initBalance); // 볼륨 초기치 설정
}

function DP_PLAYER_INIT () { /* 각종 메시지 영역 초기화 */

    if ( S_display == 'Y') {
        DISPLAY_SCREEN          (); // 스크린 위치
        DISPLAY_BACKGROUND      (); // 배경 설정
        DISPLAY_PLAY_BUTTON     (); // 재생     버튼 객체
        DISPLAY_STOP_BUTTON     (); // 정지     버튼 객체
        DISPLAY_PAUSE_BUTTON    (); // 일시정지 버튼 객체
        DISPLAY_PREV_BUTTON     (); // 이전     버튼 객체
        DISPLAY_NEXT_BUTTON     (); // 다음     버튼 객체
        DISPLAY_VOLUME_BAR      (); /* 볼륨 조절 초기화 */
        DISPLAY_PLAY_BAR        (); /* 재생바 초기화    */
        DISPLAY_BALANCE_BAR     (); /* 볼륨 밸런스바 초기화 */
        DISPLAY_EQUALIZER1_OFF  (); // 이퀄라이져1 표시 객체
        DISPLAY_EQUALIZER2_OFF  (); // 이퀄라이져2 표시 객체
        DISPLAY_PLAY_LIST_BUTTON  (); // 재생 목록 표시 객체
        DISPLAY_PLAY_LYRICS_BUTTON(); // 재생 가사 표시 버튼
        DISPLAY_LIST_CLOSE        (); // 목록 가사 닫기 표시 객체
        DISPLAY_CLOSE             (); // 닫기 표시 객체
        DISPLAY_COPYRIGHT         (); // 카피라이트표시 객체
        DISPLAY_FULLSCR_BUTTON  (); // 풀스크린 객체

        if ( S_listMode == '1' ) { // 현재 페이지
            DISPLAY_LIST_FRAME        (); // 재생 목록 영역 객체
            DISPLAY_LYRICS_FRAME      (); // 재생 가사 영역 객체
        }

        DP_objectMoveTo(O_player     , S_screenX       ,S_screenY      ); // 스크린   객체 [위치 조정]
        DP_objectMoveTo(P_playBtn    , S_playBtnX      ,S_playBtnY     ); // 재생     버튼 객체 [위치 조정]
        DP_objectMoveTo(P_stopBtn    , S_stopBtnX      ,S_stopBtnY     ); // 정지     버튼 객체 [위치 조정]
        DP_objectMoveTo(P_pauseBtn   , S_pauseBtnX     ,S_pauseBtnY    ); // 일시정지 버튼 객체 [위치 조정]
        DP_objectMoveTo(P_prevBtn    , S_prevBtnX      ,S_prevBtnY     ); // 이전     버튼 객체 [위치 조정]
        DP_objectMoveTo(P_nextBtn    , S_nextBtnX      ,S_nextBtnY     ); // 다음     버튼 객체 [위치 조정]
        DP_objectMoveTo(P_sound      , S_soundX        ,S_soundY       ); // 뮤트          객체 [위치 조정]

        DP_objectMoveTo(P_title      , S_titleX        ,S_titleY       ); // 제목      표시 객체 [위치 조정]
        DP_objectMoveTo(P_playState  , S_stateX        ,S_stateY       ); // 재생 상태 표시 객체 [위치 조정]
        DP_objectMoveTo(P_totTime    , S_totTimeX      ,S_totTimeY     ); // 재생 시간 표시 객체 [위치 조정]
        DP_objectMoveTo(P_playTime   , S_playTimeX     ,S_playTimeY    ); // 재생 시간 표시 객체 [위치 조정]
        DP_objectMoveTo(P_remindTime , S_remindTimeX   ,S_remindTimeY  ); // 남은 시간 표시 객체 [위치 조정]

        DP_objectMoveTo(P_buffering     , S_bufferingX      ,S_bufferingY       ); // 버퍼링      표시 객체 [위치 조정]
        DP_objectMoveTo(P_download      , S_downloadX       ,S_downloadY        ); // 다운로드    표시 객체 [위치 조정]
        DP_objectMoveTo(P_volumePercent , S_volumePercentX  ,S_volumePercentY   ); // 볼륨값      표시 객체 [위치 조정]
        DP_objectMoveTo(P_playBarPercent, S_playBarPercentX ,S_playBarPercentY  ); // 재생 비율값 표시 객체 [위치 조정]

        DP_objectMoveTo(P_balancePercent, S_balancePercentX ,S_balancePercentY  ); // 밸런스 값   표시 객체 [위치 조정]

        DP_objectMoveTo(P_equalizer1    , S_equalizer1X     ,S_equalizer1Y      ); // 이퀄라이져1 표시 객체[위치 조정]
        DP_objectMoveTo(P_equalizer2    , S_equalizer2X     ,S_equalizer2Y      ); // 이퀄라이져2 표시 객체[위치 조정]

        DP_objectMoveTo(P_playMode      , S_playModeX       ,S_playModeY        ); // 재생 모드 표시 객체 [위치 조정]
        DP_objectMoveTo(P_repeatMode    , S_repeatModeX     ,S_repeatModeY      ); // 반복 모드 표시 객체 [위치 조정]

        DP_objectMoveTo(P_playListBtn   , S_playListBtnX    ,S_playListBtnY     ); // 재생 목록 표시 객체 [위치 조정]
        DP_objectMoveTo(P_playLyricsBtn , S_playLyricsBtnX  ,S_playLyricsBtnY   ); // 재생 가사 표시 버튼 [위치 조정]
        DP_objectMoveTo(P_listClose     , S_listCloseX      ,S_listCloseY       ); // 목록 가사 닫기 표시 객체 [위치 조정]
        DP_objectMoveTo(P_close         , S_closeX          ,S_closeY           ); // 닫기 표시 객체      [위치 조정]
        DP_objectMoveTo(P_copyRight     , S_copyRightX      ,S_copyRightY       ); // 카피라이트표시 객체 [위치 조정]
        DP_objectMoveTo(P_FullScrBtn    , S_fullScrBtnX     ,S_fullScrBtnY      ); // 풀스크린 객체 [위치 조정]

        if ( S_type != 'C' ) {
            DP_objectMoveTo(P_listFrame     , S_listFrameX      ,S_listFrameY       ); // 재생 목록 영역 객체 [위치 조정]
            DP_objectMoveTo(P_lyricsFrame   , S_lyricsFrameX    ,S_lyricsFrameY     ); // 재생 가사 영역 객체 [위치 조정]
        }
    }
}

function DP_PLAY_MODE_CHANGE (mode)    { // 재생모드
    // 초기화인 경우
    if ( typeof( mode ) != 'undefined' ) {
        if ( S_display == 'Y') {
            if ( mode == 'S' ) {
                DISPLAY_PLAY_MODE_ALL_SEQUENCE ();  // 전체 랜덤
            } else if ( mode == 'R' ) {
                DISPLAY_PLAY_MODE_ALL_RANDOM   ();  // 현재곡
            } else if ( mode == 'O' ) {
                DISPLAY_PLAY_MODE_ONLY         ();  // 전체 순서
            }
        }
        S_playMode=mode;
    }
    else   if ( S_playMode == 'S' ) {
        if ( S_display == 'Y') {
            DISPLAY_PLAY_MODE_ALL_RANDOM   ();  // 전체 랜덤
        }
        S_playMode='R';
    } else if ( S_playMode == 'R' ) {
        if ( S_display == 'Y') {
            DISPLAY_PLAY_MODE_ONLY         ();  // 현재곡
        }
        S_playMode='O';
    } else if ( S_playMode == 'O' ) {
        if ( S_display == 'Y') {
            DISPLAY_PLAY_MODE_ALL_SEQUENCE ();  // 전체 순서
        }
        S_playMode='S';
    }
    V_playedKey = '';
}

function DP_REPEAT_MODE_CHANGE (mode) { // 반복모드
    // 초기화인 경우
    if ( typeof( mode ) != 'undefined' ) {
        if ( S_display == 'Y') {
            if ( mode == '0' ) {
                DISPLAY_SINGLE_MODE  ();  // 반복없음
            } else if ( mode == '1' ) {
                DISPLAY_REPEAT_MODE ();  // 반복
            }
        }
        S_repeatMode=mode;
    }
    else   if ( S_repeatMode == '0' ) {
        if ( S_display == 'Y') {
            DISPLAY_REPEAT_MODE ();  // 반복
        }
        S_repeatMode='1';
    } else if ( S_repeatMode == '1' ) {
        if ( S_display == 'Y') {
            DISPLAY_SINGLE_MODE  ();  // 반복없음
        }
        S_repeatMode='0';
    }
}

function DP_BUFFERING ()    { // 버퍼링
    if ( S_display == 'Y') { 
        var buffering = O_player.network.bufferingProgress;

        if ( buffering < 100 ) {
            DISPLAY_BUFFERING (buffering);
        } else {
            DISPLAY_BUFFERING_END (); // 버퍼링 COMPLETE
        }
    }
}

function DP_DOWNLOAD ()     { // 다운로드
    if ( S_display == 'Y') { 
        var download = O_player.network.downloadProgress;
        if ( download < 100 ) {
            DISPLAY_DOWNLOAD (download);
        } else {
            DISPLAY_DOWNLOAD_END  (); // 다운로드 COMPLETE
        }
    }
}

function DP_inforUpdate() { /* 재생 정보 갱신 */
    if ( S_display == 'Y') { 
        var timeNow = O_player.controls.currentPosition;
            tmp     = Math.floor(V_playTime - timeNow);
        var secArray = DP_secToMinSec(tmp);
        DISPLAY_REMIND_TIME(secArray[0],secArray[1]); // 남은 시간 출력
    }
    DP_PLAY_BAR_UPDATE (); // 재생바 갱신
    DP_playingThread   ();
}

function DP_secToMinSec(seconds) {
    var secArray =  new Array();
    secArray[0] = parseInt(seconds / 60); if ( secArray[0] < 10 ) { secArray[0] = '0' + secArray[0]; }
    secArray[1] = parseInt(seconds % 60); if ( secArray[1] < 10 ) { secArray[1] = '0' + secArray[1]; }
    return secArray;
}

var O_dpDboardInforFrame = null; // 디보드와 연동될경우 재생정보 얻어오기
var O_dpDboardInforWin   = null; // 디보드와 연동될경우 재생정보 Window

function DP_onLoad() {
    if ( S_type == 'P' || typeof(self.opener) == 'object' ) {
        S_type = 'P';
        window.resizeTo(S_width+6, S_height+25);
    } else if ( S_type == 'F' && typeof(self.opener) != 'object' ) { // 프레임
        window.resizeTo(S_width, S_height);
    }

    if ( dboardEmbed == 'N' ) {
        skinDir         = 'skin/'       + S_skinName + '/'; // 스킨 디렉토리 설정
    } else {
        skinDir         = baseDir + 'skin/board/' + S_skinName + '/'; // 스킨 디렉토리 설정
    }

    O_player          = DP_getObject('DP_PLAYER'         ); // Player        객체

    P_playBtn         = DP_getObject('DP_PLAY_BUTTON'    ); // 재생     버튼 객체
    P_stopBtn         = DP_getObject('DP_STOP_BUTTON'    ); // 정지     버튼 객체
    P_pauseBtn        = DP_getObject('DP_PAUSE_BUTTON'   ); // 일시정지 버튼 객체
    P_prevBtn         = DP_getObject('DP_PREV_BUTTON'    ); // 이전     버튼 객체
    P_nextBtn         = DP_getObject('DP_NEXT_BUTTON'    ); // 다음     버튼 객체

    P_volumeBar       = DP_getObject('DP_VOLUME_BAR'   ); // 볼륨   조절   객체
    P_playBar         = DP_getObject('DP_PLAY_BAR'     ); // 재생바 조절   객체
    P_balanceBar      = DP_getObject('DP_BALANCE_BAR'  ); // 볼륨 밸런스바 객체
    P_sound           = DP_getObject('DP_SOUND'         ); // 뮤트          객체

    P_title           = DP_getObject('DP_TITLE'        ); // 제목      표시 객체
    P_playState       = DP_getObject('DP_PLAY_STATE'   ); // 재생 상태 표시 객체
    P_totTime         = DP_getObject('DP_TOT_TIME'     ); // 총   시간 표시 객체
    P_playTime        = DP_getObject('DP_PLAY_BAR_TIME'); // 재생 시간 표시 객체
    P_remindTime      = DP_getObject('DP_REMIND_TIME'  ); // 남은 시간 표시 객체

    P_buffering       = DP_getObject('DP_BUFFERING'         ); // 버퍼링    표시 객체
    P_download        = DP_getObject('DP_DOWNLOAD'          ); // 다운로드  표시 객체

    P_volumePercent   = DP_getObject('DP_VOLUME_PERCENT'    ); // 볼륨     비율 표시 객체
    P_playBarPercent  = DP_getObject('DP_PLAY_BAR_PERCENT'  ); // 재생바   비율 표시 객체

    P_balancePercent  = DP_getObject('DP_BALANCE_PERCENT'   ); // 밸런스바 비율 표시 객체

    P_equalizer1      = DP_getObject('DP_EQUALIZER1'        ); // 이퀄라이져1 객체
    P_equalizer2      = DP_getObject('DP_EQUALIZER2'        ); // 이퀄라이져2 객체

    P_playMode        = DP_getObject('DP_PLAY_MODE'         ); // 재생 모드 표시 객체
    P_repeatMode      = DP_getObject('DP_REPEAT_MODE'       ); // 반복 모드 표시 객체

    P_playListBtn     = DP_getObject('DP_PLAY_LIST_BUTTON'  ); // 재생 목록 표시 객체
    P_playLyricsBtn   = DP_getObject('DP_PLAY_LYRICS_BUTTON'); // 재생 가사 표시 버튼
    P_listClose       = DP_getObject('DP_LIST_CLOSE'        ); // 목록 가사 닫기 표시 객체
    P_close           = DP_getObject('DP_CLOSE'             ); // 닫기 표시 객체

    P_copyRight       = DP_getObject('DP_COPYRIGHT'         ); // 카피라이트표시 객체

    P_listFrame       = DP_getObject('DP_LIST_FRAME'        ); // 재생 목록 영역 객체
    P_lyricsFrame     = DP_getObject('DP_LYRICS_FRAME'      ); // 재생 가사 영역 객체
    P_FullScrBtn      = DP_getObject('DP_FULL_SCR_BUTTON'   ); // 풀 스크린 객체

    if ( dboardEmbed == 'Y' ) {
        O_dpDboardInforFrame = DP_getObject('DP_DBOARD_INFOR'   ); // 디보드와 연동될경우 재생정보 얻어오기
        O_dpDboardInforWin   = document.frames("DP_DBOARD_INFOR"); // 디보드와 연동될경우 재생정보 Window
    }
//    if ( dboardEmbed == 'N' ) {
        P_listHeader      = document.frames("DP_LIST_HEADER"    ).document.body; // 재생 목록 스킨 [헤더]
        P_listMain        = document.frames("DP_LIST_MAIN"      ).document.body; // 재생 목록 스킨 [메인]
        P_listFooter      = document.frames("DP_LIST_FOOTER"    ).document.body; // 재생 목록 스킨 [풋터]

        P_lyricsHeader    = document.frames("DP_LYRICS_HEADER"  ).document.body; // 재생 가사 스킨 [헤더]
        P_lyricsMain      = document.frames("DP_LYRICS_MAIN"    ).document.body; // 재생 가사 스킨 [메인]
        P_lyricsFooter    = document.frames("DP_LYRICS_FOOTER"  ).document.body; // 재생 가사 스킨 [풋터]
//    }

    O_lyricsJS        = DP_getObject("SCRIPT_DP_LYRICS");   // 재생 가사 데이터 JS
    DP_PLAYER_INIT        (); // 메시지 영역 초기화 [ 위치 지정 ]
    DP_VOLUME_BAR_INIT    (); // 볼륨바 초기화
    DP_PLAY_BAR_INIT      (); // 재생바 초기화
    DP_PLAY_BALANCE_INIT  (); // 볼륨 밸런스바 초기화

    DP_PLAY_MODE_CHANGE   (S_playMode   );
    DP_REPEAT_MODE_CHANGE (S_repeatMode );
    DP_SOUND              (S_sound); // mute 상태 초기화

    if ( S_autoplay == 'Y' ) { // 자동 재생
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
            alert ( '발견' );
            tmp += '\\\\';
        } else {
            tmp += val.charAt(cnt);
        }
        cnt++;
    }
    return tmp;
}

function DP_DBOARD_Add_PlayInfor() { // 재생 정보 추가
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

    O_playList.DP_putValue(playItem.getId () + '-' + playItem.getNo (), playItem    ); // id + no를 키로 재생 정보 보관

}

function DP_Add_PlayInfor() { // 재생 정보 추가
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
    O_playList.DP_putValue(playItem.getId () + '-' + playItem.getNo (), playItem    ); // id + no를 키로 재생 정보 보관
    S_index++;
//  alert ( args[3]  );
//  alert ( DP_getFileNameOnly(args[0 ]) );
//  alert ( playItem.getUrl() + ' / ' + playItem.getTitle() );
//  alert ( O_playList.DP_getSize() );
}

//** Function Name  : getFileName
//** Argument1      : 파일 경로명
//** Description    : 파일 경로명에서 파일 이름을 반환
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
    // Key String 생성
    var keyStr = '';
    for ( var i=0;i<size;i++) {
        var playItem = O_playList.DP_getVal(i);
        keyStr += ',' + playItem.getId () + '-' + playItem.getNo (); // KEY String
    }

    while ( true ) {
        var tmpIdx = Math.floor(Math.random() * size );
        var tmpItem = O_playList.DP_getVal(tmpIdx);
        if ( tmpItem != null ) {
            tmpKey = tmpItem.getId () + '-' + tmpItem.getNo (); // KEY 생성
            if ( V_playedKey.indexOf(',' + tmpKey) < 0 && expKey != tmpKey ) {
                V_playedKey = V_playedKey + ',' + tmpKey;
//              alert ( '재생 키 : ' + tmpKey + ' / ' + tmpIdx + ' 제목 : ' + tmpItem.getTitle () );
                _rtn = tmpIdx;
                break;
            } else {
//              alert ( '된넘 : ' + tmpKey + ' / ' + tmpIdx + ' 제목 : ' + tmpItem.getTitle () );
                keyStr = keyStr.replace( ',' + tmpKey,'');
                if ( keyStr == '' ) { // 랜덤 재생 루프 반복이 끝난 상태
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
/* 재생 모드 */
// var S_playMode      = 'S';   // 재생 모드 ::> 전곡순서  : 'S', 전곡랜덤 : 'R', 현재곡   : 'O'
// var S_repeatMode   = '0';   // 반복 모드 ::> 반복없음  : '0', 반복     : '1'
    if ( V_playState == 1 ) {
//      rwText.value  =  '재생 모드 : ' + S_playMode    + '\n';
//      rwText.value +=  '반복 모드 : ' + S_repeatMode + '\n';
        if ( S_playMode == 'S' ) { // 전곡순서
            // 반복
            if ( S_repeatMode == '1' ) {
                DP_NEXT ();
            }
            // 반복 없음
            else if ( S_repeatMode == '0' && O_playList.DP_getSize() - 1 > S_point ) {
                DP_NEXT ();
            } else {
                DP_STOP ();
                DISPLAY_PLAYER_STATE ( 99 ); // 종료
            }
        } else if ( S_playMode == 'R' ) { // 전곡랜덤
            // 반복
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
            // 반복 없음
            else if ( S_repeatMode == '0' ) {
//              alert ( '반복 없음 랜덤 재생.' );
                S_point = DP_randPlayNumber ();
                if ( S_point != null ) {
                    if ( dboardEmbed == 'N' ) {
                        DP_PLAY_CB        ('NOT_REPEAT');
                    } else {
                        DP_DBOARD_PLAY_CB ('NOT_REPEAT');
                    }
                } else {
                    DP_STOP ();
                    DISPLAY_PLAYER_STATE ( 99 ); // 종료
                }
            } else {
                DP_STOP ();
                DISPLAY_PLAYER_STATE ( 99 ); // 종료
            }
        } else if ( S_playMode == 'O' ) { // 현재곡
            // 반복
            if ( S_repeatMode == '1' ) {
                if ( dboardEmbed == 'N' ) {
                    DP_PLAY_CB        ('ONLY');
                } else {
                    DP_DBOARD_PLAY_CB ('ONLY');
                }
            } else {
                DP_STOP ();
                DISPLAY_PLAYER_STATE ( 99 ); // 종료
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
    if ( S_listMode == '1' ) { // 현재 페이지
        if ( !V_listView ) {
            V_listView = true;
            V_lyricsView = false;
            DISPLAY_LIST_FRAME      (); // 재생 목록 프레임 생성
            if ( S_type == 'P' ) {
                window.resizeTo(6+S_listWidth, 25+S_listHeight);
            } else if ( S_type == 'F' ) { // 프레임
                window.resizeTo(S_listWidth, S_listHeight);
            } else { // 현재창
            }

        } else {
            V_listView = false;
            DISPLAY_LIST_FRAME_END  (); // 재생 목록 프레임 소멸
            if ( S_type == 'P' ) {
                window.resizeTo(S_width+6, S_height+25);
            } else if ( S_type == 'F' ) { // 프레임
                window.resizeTo(S_width, S_height);
            } else { // 현재창
            }
        }

        DISPLAY_LYRICS_FRAME_END(); // 재생 가사 프레임 소멸
        if ( !V_playListLoad ) {
            DP_PLAY_LIST_MAKE       (); // 재생 리스트 생성
            V_playListLoad = true;
        }

    } else { // 팝업일 경우
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
        DP_PLAY_LIST_MAKE       (); // 재생 리스트 생성
    }
}

function DP_PLAY_LIST_MAKE (point) {
    var listHeader = P_listHeader.outerText ; // 재생 목록 스킨 [헤더]
    var listMain   = P_listMain.outerText   ; // 재생 목록 스킨 [메인]
    var listFooter = P_listFooter.outerText ; // 재생 목록 스킨 [풋터]

    var tmplitMain = '';
    var newListMain= '';
    var listFrame    = null;
    var objStr       = '';

    if ( S_listMode == '1' ) { // 현재 페이지
        listFrame    = document.frames("DP_LIST_FRAME"     ); // 재생 목록 영역
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
    if ( T_lyricsSet != null ) window.clearInterval(T_lyricsSet)  ; // 타이머 해제
    S_point = O_playList.DP_getKeyIdx(S_key);
    var playItem = O_playList.DP_getVal( S_point );

    if ( S_lyricsMode == '1' ) { // 현재 페이지
        if ( !V_lyricsView ) {
            V_listView = false;
            V_lyricsView = true;
            DISPLAY_LYRICS_FRAME    (); // 재생 가사 프레임 생성
            if ( S_type == 'P' ) {
                window.resizeTo(6+S_lyricsWidth, 25+S_lyricsHeight);
            } else if ( S_type == 'F' ) { // 프레임
                window.resizeTo(S_lyricsWidth, S_lyricsHeight);
            } else { // 현재창

            }
        } else {
            V_lyricsView = false;
            DISPLAY_LYRICS_FRAME_END(); // 재생 가사 프레임 소멸
            if ( S_type == 'P' ) {
                window.resizeTo(S_width+6, S_height+25);
            } else if ( S_type == 'F' ) { // 프레임
                window.resizeTo(S_width, S_height);
            } else { // 현재창

            }
        }

        DISPLAY_LIST_FRAME_END  (); // 재생 목록 프레임 소멸
    } else { // 팝업일 경우
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
            T_lyricsSet  = window.setInterval("DP_LYRICS_CONNECT ( '" + playItem.getLyricsUrl () + "');", 10); // 가사 리스트 생성
        } else {
            T_lyricsSet  = window.setInterval("DP_LYRICS_CONNECT ( null );", 10                               ); // 가사 리스트 생성
        }
    } else {
        DP_PLAY_LYRICS_MAKE ();
    }
}

function DP_PLAY_LYRICS_MAKE () {
    var lyricsHeader = P_lyricsHeader.outerText ; // 재생 목록 스킨 [헤더]
    var lyricsMain   = P_lyricsMain.outerText   ; // 재생 목록 스킨 [메인]
    var lyricsFooter = P_lyricsFooter.outerText ; // 재생 목록 스킨 [풋터]
    var lyricsData   = lyricsHeader + lyricsMain + lyricsFooter;

    var lyricsFrame  = null;
    var objStr       = '';
    if ( S_lyricsMode == '1' ) { // 현재 페이지
        lyricsFrame  = document.frames("DP_LYRICS_FRAME"); // 재생 가사 영역 객체
        objStr       = 'parent';
    } else { // 팝업
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
            playItem.setTitle('재생중인 노래가 없습니다.');
            DP_lyricsData = '모든 저작권은 디자인보드에 있으며<BR> 수정은 가능하나 수정 배포는 불가합니다.';
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
    } else if ( S_type == 'F' ) { // 프레임
        window.resizeTo(S_width, S_height);
    } else { // 현재창

    }
    V_listView  = false;
    V_lyricsView= false;
    DISPLAY_LIST_FRAME_END  (); // 재생 목록 프레임 소멸
    DISPLAY_LYRICS_FRAME_END(); // 재생 가사 프레임 소멸
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
    event.returnValue  = false; // 이벤트 발생 취소
}
//-->