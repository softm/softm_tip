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

function WindowResize ( initWidth, initHeight, frame_str , timeOut, speed ) {
        var ie = ( document.all     ) ? 1 : 0;
        var ns6 = document.getElementById && !document.all ? 1 : 0

        if ( typeof ( frame_str ) == "object") {
            fobj = frame_str;
        } else {
            fobj = window;
        }

        if ( typeof(timeOut) == "undefined" || timeOut == "0"  || timeOut == "" ) { timeOut = 0; }
        if ( typeof(speed  ) == "undefined" || speed   == "0"  || speed   == "" ) { speed   = 100; }
        if ( ie )
        {
            // �ʱ� ������ ũ��� ����
            fobj.width  = initWidth ;   // �ʱ� ������ ����
            fobj.height = initHeight;   // �ʱ� ������ ����
            fobj.resizeTo(initWidth, initHeight);
            // NetScape ó���� ���������� ��ε�..
            // ��� ������ ���� �̰��� �ξ�߸� ���� ������ ������ ����~~

            if ( typeof(frame_str) == "undefined" ) { frame_str == ""; }

            if ( timeOut > 0 ) { self.setTimeout ("FrameResizeExcute('" + frame_str + "', " + speed + ");", timeOut); } else { FrameResizeExcute(frame_str, speed); }
        }
}

function FrameResize ( initWidth, initHeight, frame_str , timeOut, speed ) {
        var ie = ( document.all     ) ? 1 : 0;
        var ns6 = document.getElementById && !document.all ? 1 : 0

        if ( typeof(frame_str) == "undefined" || frame_str == "" ) {
            if ( ie  ) { fobj = this; }
            if ( ns6 ) { fobj = this.self; }
        } else {
            fobj = getFrame(frame_str);
        }

        if ( typeof(timeOut) == "undefined" || timeOut == "0"  || timeOut == "" ) { timeOut = 0  ; }
        if ( typeof(speed  ) == "undefined" || speed   == "0"  || speed   == "" ) { speed   = 100; }

        if ( ie )
        {
            if ( typeof ( fobj ) == "object" ) {
                // �ʱ� ������ ũ��� ����
                fobj.width  = initWidth ;   // �ʱ� ������ ����
                fobj.height = initHeight;   // �ʱ� ������ ����
                fobj.resizeTo(initWidth, initHeight);
            }

            // NetScape ó���� ���������� ��ε�..
            // ��� ������ ���� �̰��� �ξ�߸� ���� ������ ������ ����~~
            if ( typeof(frame_str) == "undefined" ) { frame_str == ""; }

            if ( timeOut > 0 ) { self.setTimeout ("FrameResizeExcute('" + frame_str + "', " + speed + ");", timeOut); } else { FrameResizeExcute(frame_str, speed); }
        }
}

function FrameResizeExcute ( frame_str, scrollSpeed ) {
        var ie = ( document.all     ) ? 1 : 0;
        var ns6 = document.getElementById && !document.all ? 1 : 0

        /* ----- Start -- if -- Frame Object������ ��ũ���� ���� ������ ũ�⸦ ����մϴ�. */
//            alert ( '������Ʈ : ' + fobj.name );
        var scrollT_S = 0;
        var scrollL_S = 0;
        var scrollT_E = 0;
        var scrollL_E = 0;

        var w_obj = null;   // Window Object ( scrollBy Method�� �����ϱ� ���� �̿�)
        var p_obj = null;   // Position �� ���� ���� �̿�
                            // IE    : Scroll X,Y��ǥ ���� body   �� ���� ( scrollLeft, scrollTop ) .
                            // NE6.X : Scroll X,Y��ǥ ���� window �� ���� ( scrollX   , scrollY   ) .
        if ( ie ) { // IE
            w_obj = fobj;                 // ������ ��ü ���
            p_obj = fobj.document.body;
        } else {    // NetScape 6.X
//                w_obj = fobj.contentDocument.defaultView;   // ������ ��ü ���
//                p_obj = fobj.contentDocument.defaultView;
            w_obj = fobj.self;                 // ������ ��ü ���
            p_obj = fobj.self;
        }

        var w = 0;  // scroll width
        var h = 0;  // scroll height
        this_point:
        while ( true ) { // ���� Loop ����
            if ( ie ) { // IE
                scrollT_S = p_obj.scrollTop;
                scrollL_S = p_obj.scrollLeft;
            } else {    // NetScape 6.X
                scrollT_S = p_obj.scrollY;
                scrollL_S = p_obj.scrollX;
            }
            w = w + scrollSpeed;
            h = h + scrollSpeed;

            w_obj.scrollBy (w,h);

            if ( ie ) { // IE
//              alert ( "X: " + scrollL_E + " / Y : " + scrollT_E );
                scrollT_E = p_obj.scrollTop;
                scrollL_E = p_obj.scrollLeft;
            } else {    // NetScape 6.X
//                alert ( "X: " + scrollL_E + " / Y : " + scrollT_E );
                scrollT_E = p_obj.scrollY;
                scrollL_E = p_obj.scrollX;
            }

//          alert ( 'scrollL_E : '  + scrollL_E + "\n" + "scrollT_E : " + scrollT_E );

            if ( ( scrollT_S == scrollT_E ) && ( scrollL_S == scrollL_E ) ) {
                iframeWidth  = scrollL_E;
                iframeHeight = scrollT_E;
                fobj.height  = scrollT_E + scrollSpeed;
                fobj.width   = scrollL_E + scrollSpeed;
                break this_point;
            }
        }
//        alert ( ' Ending ::::::> scrollL_E : '  + scrollL_E + "\n" + "scrollT_E : " + scrollT_E );
//        alert ( ' Ending ::::::> iframeWidth : '  + iframeWidth + "\n" + "iframeHeight : " + iframeHeight );
        fobj.resizeBy(scrollL_E, scrollT_E);
        fobj.scrollTo(0,0);
        /* ----- End   -- if -- Frame Object������ ��ũ���� ���� ������ ũ�⸦ ����մϴ�. */
}
//-->