//******************************************************/
//** Function Name    : imagePopUp
//** Description      : 이미지 팝업 윈도우를 출력하기 위한 생성자
//******************************************************/
<!--
    var imageWin = null; // 팝업

    function imagePopUp() {
        document.body.innerHTML += "<div id='imageURL' style='color:white'></div>";
    }

    function getImgTemp( objStr, tier ) {
        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        var ie  = ( document.all     ) ? 1 : 0;
        var ns  = document.getElementById && !document.all ? 1 : 0;

        if (ie) {
            /* IE */
            obj = eval( docStr + ".all['" + objStr + "']");
        } else if ( ns ) {
            /* NS */
            obj = eval( docStr + ".getElementById('" + objStr + "');");
        }
        return obj;
    }

    function imageWindowResize(width, height) {

        if ( imageWin != null  && typeof( imageWin.name ) == 'string' ) {
            imageWin.resizeTo(width, height);
        }
    }
//******************************************************/
//** Function Name    : imageOpenWindow
//** Description      : 이미지 팝업 윈도우를 출력하기 위한 생성자
//** Argument1        : val     : 이미지 경로
//******************************************************/
    function imageOpenWindow(val) {
        if ( typeof (val) == "string" && val != "" )
        {
            var imgObj = getImgTemp("imageURL");
            imgObj.innerText = val;
            imageWin = window.open("/zzook/jsp/common/ImagePopUp.html","imageViewWin",'width=1, height=1,status=no, menubar=no, resizable=yes');
            imageWin.focus();
        }
	}

    /*----------------------------------------------------
    / Function Name   : imageList1_OpenWindow
    / Description     : 이미지 조회 ( ImageList1.jsp )
    /-----------------------------------------------------
    / Arguments
    /-----------------------------------------------------
    /   gubun           : '*' : 전체, 'A' : 관리자 이미지 , 'B' : 사용자 이미지
    /   imgCd           : '*' : 전체, Code 테이블 Major_Cd = '03'
    /   inGubun         : '1' :  '<IMG' , '2' : <INPUT type='image', 
    /                     '3' : <IMG attribute = name필드 , 
    /                     '4' : BBs관련 기능 버튼 삽입 ( DesignRef.js 의 appendFunction() 함수를 호출하게됨
    /                     '5' : 쭉 관련 함수들
    /   name            : Add될 Element의 이름
    /   window_width    : 윈도우 크기
    /   window_height   : 윈도우 높기
    /   window_left     : 윈도우 출력될 X좌표
    /   window_top      : 윈도우 출력될 Y좌표
    -----------------------------------------------------*/
    function imageList1_OpenWindow (gubun, imgCd, inGubun, name, window_width, window_height, window_left, window_top) {
        var args = imageList1_OpenWindow.arguments;
        var window_width      = args[4];
        var window_height     = args[5];
        var window_left       = args[6];
        var window_top        = args[7];
        if ( typeof( window_width ) == "undefined" || window_width  == "" ) { window_width  = 700; }
        if ( typeof( window_height) == "undefined" || window_height == "" ) { window_height = 465; }
        if ( typeof( window_left  ) == "undefined" || window_left   == "" ) { window_left = ( screen.width - window_width  ) / 2; }
        if ( typeof( window_top   ) == "undefined" || window_top    == "" ) { window_top  = ( screen.height- window_height ) / 2; }
        imageWindowResize(window_width, window_height);
        imageWin = window.open("/zzook/jsp/common/ImageList1.jsp?p_s_gubun=" + gubun + "&p_img_cd=" + imgCd + "&p_in_gubun=" + inGubun , "imageWin",'width=' + window_width + ', height=' + window_height + ',left=' + window_left + ',top=' + window_top + ',status=no, menubar=no, resizable=yes, scrollbars=yes');
        imageWin.focus();
    }

    /*----------------------------------------------------
    / Function Name   : imageList2_OpenWindow
    / Description     : 이미지 조회 ( ImageList2.jsp )
    /-----------------------------------------------------
    / Arguments
    /-----------------------------------------------------
    /   gubun           : '*' : 전체, 'A' : 관리자 이미지 , 'B' : 사용자 이미지
    /   imgCd           : '*' : 전체, Code 테이블 Major_Cd = '03'
    /   inGubun         : '1' :  '<IMG' , '2' : <INPUT type='image', 
    /                     '3' : <IMG attribute = name필드 , 
    /                     '4' : BBs관련 기능 버튼 삽입 ( DesignRef.js 의 appendFunction() 함수를 호출하게됨
    /                     '5' : 쭉 관련 함수들
    /                     '6' : 페이지내의 특정 ID값에 이미지 삽입
    /   name            : Add될 Element의 이름
    /   itemCnt         : 한 열에 배치될 이미지 수
    /   window_width    : 윈도우 크기
    /   window_height   : 윈도우 높기
    /   window_left     : 윈도우 출력될 X좌표
    /   window_top      : 윈도우 출력될 Y좌표
    /   itemCnt         : 한열에 출력될 이미지의 갯수
    -----------------------------------------------------*/
    function imageList2_OpenWindow (gubun, imgCd, inGubun, name, itemCnt, window_width, window_height, window_left, window_top) {
        var args = imageList2_OpenWindow.arguments;

        var table_itemCnt     = args[4];
        var window_width      = args[5];
        var window_height     = args[6];
        var window_left       = args[7];
        var window_top        = args[8];

        if ( typeof( table_itemCnt) == "undefined" || table_itemCnt == "" ) { table_itemCnt = 1  ; }
        if ( typeof( window_width ) == "undefined" || window_width  == "" ) { window_width  = 700; }
        if ( typeof( window_height) == "undefined" || window_height == "" ) { window_height = 300; }
        if ( typeof( window_left  ) == "undefined" || window_left   == "" ) { window_left   = ( screen.width - window_width  ) / 2; }
        if ( typeof( window_top   ) == "undefined" || window_top    == "" ) { window_top    = ( screen.height- window_height ) / 2; }

        imageWindowResize(window_width, window_height);
        imageWin = window.open("/zzook/jsp/common/ImageList2.jsp?p_s_gubun=" + gubun + "&p_img_cd=" + imgCd + "&p_in_gubun=" + inGubun + "&p_name=" + name + "&p_item_cnt=" + table_itemCnt, "imageWin",'width=' + window_width + ', height=' + window_height + ',left=' + window_left + ',top=' + window_top + ',status=no, menubar=no, resizable=yes, scrollbars=yes');
//      imageWin = window.open("/zzook/jsp/common/ImageList2.jsp?p_s_gubun=" + gubun + "&p_img_cd=" + imgCd + "&p_in_gubun=" + inGubun + "&p_name=" + name + "&p_item_cnt=" + table_itemCnt, "imageWin");
                          
        imageWin.focus();
    }

    function hyperLink(link) {
        window.open(link);
        return;
    }

//-->