<!--

var iframeWidth  = 0;
var iframeHeight = 0;
var fobj = null;    // Frame Object

function getFrame( objStr ) {
    var docStr = "";
    var obj    = null;

    var ie = ( document.all     ) ? 1 : 0;
    var ns6 = document.getElementById && !document.all ? 1 : 0

    if ( ie  ) {
        /* IE */
        obj = eval( "document.all['" + objStr + "']");
    }
    if ( ns6 ) {
        /* NS */
        obj = eval( "document.getElementById('" + objStr + "');");
    }
    obj = obj.contentWindow  ; // WINDOW   OBJECT

    return obj;
}

function WindowResize ( initWidth, initHeight, frame_str , timeOut ) {
        var ie = ( document.all     ) ? 1 : 0;
        var ns6 = document.getElementById && !document.all ? 1 : 0

        if ( typeof ( frame_str ) == "object") {
            fobj = frame_str;
        } else {
            fobj = window;
        }
        if ( typeof(timeOut) == "undefined" || timeOut == "0"  || timeOut == "" ) { timeOut = "YES"; }
        if ( ie )
        {
            // 초기 프레임 크기로 설정
            fobj.width  = initWidth ;   // 초기 프레임 넓이
            fobj.height = initHeight;   // 초기 프레임 높이
            fobj.resizeTo(initWidth, initHeight);
            // NetScape 처리시 문제점으로 대두됨..
            // 잠깐 동안의 실행 이격을 두어야만 무한 루프에 빠지지 않음~~
            if ( typeof(frame_str) == "undefined" ) {
                if (timeOut.toUpperCase() =="YES") {
                    self.setTimeout ("FrameResizeExcute();", 1000);
                } else {
                    FrameResizeExcute();
                }
            } else {
                if (timeOut.toUpperCase() =="YES") {
                    self.setTimeout ("FrameResizeExcute('" + frame_str + "');", 1000);
                } else {
                     FrameResizeExcute(frame_str);
                }
            }
        }
}

function FrameResize ( initWidth, initHeight, frame_str , timeOut ) {
        var ie = ( document.all     ) ? 1 : 0;
        var ns6 = document.getElementById && !document.all ? 1 : 0

        if ( typeof(frame_str) == "undefined" || frame_str == "" ) {
            if ( ie  ) { fobj = this; }
            if ( ns6 ) { fobj = this.self; }
        } else {
            fobj = getFrame(frame_str);
        }

        if ( typeof(timeOut) == "undefined" || timeOut == "0"  || timeOut == "" ) { timeOut = "YES"; }
        if ( ie )
        {
            // 초기 프레임 크기로 설정
            fobj.width  = initWidth ;   // 초기 프레임 넓이
            fobj.height = initHeight;   // 초기 프레임 높이
            fobj.resizeTo(initWidth, initHeight);
            // NetScape 처리시 문제점으로 대두됨..
            // 잠깐 동안의 실행 이격을 두어야만 무한 루프에 빠지지 않음~~
            if ( typeof(frame_str) == "undefined" ) {
                if (timeOut.toUpperCase() =="YES") {
                    self.setTimeout ("FrameResizeExcute();", 1);
                } else {
                    FrameResizeExcute();
                }
            } else {
                if (timeOut.toUpperCase() =="YES") {
                    self.setTimeout ("FrameResizeExcute('" + frame_str + "');", 1);
                } else {
                    FrameResizeExcute(frame_str);
                }
            }
        }
}

function FrameResizeExcute ( frame_str ) {
        var ie = ( document.all     ) ? 1 : 0;
        var ns6 = document.getElementById && !document.all ? 1 : 0

        /* ----- Start -- if -- Frame Object에대한 스크롤을 통해 프레임 크기를 계산합니다. */
//            alert ( '오브젝트 : ' + fobj.name );
        var scrollT_S = 0;
        var scrollL_S = 0;
        var scrollT_E = 0;
        var scrollL_E = 0;

        var w_obj = null;   // Window Object ( scrollBy Method를 참조하기 위해 이용)
        var p_obj = null;   // Position 을 얻어내기 위해 이용
                            // IE    : Scroll X,Y좌표 값이 body   에 존재 ( scrollLeft, scrollTop ) .
                            // NE6.X : Scroll X,Y좌표 값이 window 에 존재 ( scrollX   , scrollY   ) .
        if ( ie ) { // IE
            w_obj = fobj;                 // 윈도우 객체 얻기
            p_obj = fobj.document.body;
        } else {    // NetScape 6.X
//                w_obj = fobj.contentDocument.defaultView;   // 윈도우 객체 얻기
//                p_obj = fobj.contentDocument.defaultView;
            w_obj = fobj.self;                 // 윈도우 객체 얻기
            p_obj = fobj.self;
         }
        var w = 0;  // scroll width
        var h = 0;  // scroll height
        this_point:
        while ( true ) { // 무한 Loop 실행
//        for ( i=0; i<=10;i++) {
            if ( ie ) { // IE
                scrollT_S = p_obj.scrollTop;
                scrollL_S = p_obj.scrollLeft;
            } else {    // NetScape 6.X
                scrollT_S = p_obj.scrollY;
                scrollL_S = p_obj.scrollX;
            }
            w = w + 100;
            h = h + 100;
//                w_obj.scrollTo(w,h);
               
            w_obj.scrollBy (w,h);

            if ( ie ) { // IE
//                    alert ( "X: " + scrollL_E + " / Y : " + scrollT_E );
                scrollT_E = p_obj.scrollTop;
                scrollL_E = p_obj.scrollLeft;
            } else {    // NetScape 6.X
//                alert ( "X: " + scrollL_E + " / Y : " + scrollT_E );
                scrollT_E = p_obj.scrollY;
                scrollL_E = p_obj.scrollX;
            }
//          alert ( 'scrollL_E : '  + scrollL_E + "\n" + "scrollT_E : " + scrollT_E );
            if ( ( scrollT_S == scrollT_E ) && ( scrollL_S == scrollL_E ) ) {
//                    alert ( "scrollL_S: " + scrollL_S + " / scrollL_E : " + scrollL_E );
//                    alert ( "scrollT_S: " + scrollT_S + " / scrollT_E : " + scrollT_E );
                iframeWidth  += scrollL_E;
                iframeHeight += scrollT_E;
                fobj.height = scrollT_E + 100;
                fobj.width  = scrollL_E + 100;

//                    fobj.resizeTo(scrollL_E, scrollT_E);
//                    self.innerWidth  = scrollL_E;
//                    self.innerHeight = scrollT_E;
                fobj.resizeBy(scrollL_E, scrollT_E);
//                    alert ( "break;" );
//              alert ( ' Ending ::::::> scrollL_E : '  + scrollL_E + "\n" + "scrollT_E : " + scrollT_E );
                break this_point;
            }
        }
//        fobj.scrollTo(0,0);
        /* ----- End   -- if -- Frame Object에대한 스크롤을 통해 프레임 크기를 계산합니다. */
}
//-->