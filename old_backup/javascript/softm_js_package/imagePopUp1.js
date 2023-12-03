//******************************************************/
//** Function Name    : imagePopUp
//** Description      : 이미지 팝업 윈도우를 출력하기 위한 생성자
//******************************************************/
<!--
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
            var pop = window.open("/zzook/jsp/common/ImagePopUp.html","images",'width=1, height=1,status=no, menubar=no, resizable=yes');
            pop.focus();
        }
	}

    function imageList1_OpenWindow (gubun, imgCd, inGubun, name, window_width, window_height, window_left, window_top) {
        var args = imageList1_OpenWindow.arguments;
        var window_width      = args[4];
        var window_height     = args[5];
        var window_left       = args[6];
        var window_top        = args[7];
    
        if ( typeof( window_left ) == "undefied" || window_left == "" ) { window_left = ( screen.width - window_width  ) / 2; }
        if ( typeof( window_top  ) == "undefied" || window_top  == "" ) { window_top  = ( screen.height- window_height ) / 2; }

        var imageList1Win = window.open("/zzook/jsp/common/ImageList1.jsp?p_s_gubun=" + gubun + "&p_s_img_cd=" + imgCd + "&p_in_gubun=" + inGubun , "imageList1Win",'width=' + window_width + ', height=' + window_height + ',left=' + window_left + ',top=' + window_top + ',status=no, menubar=no, resizable=yes, scrollbars=yes');
        imageList1Win.focus();
    }

    function imageList2_OpenWindow (gubun, imgCd, inGubun, name, window_width, window_height, window_left, window_top) {
        var args = imageList2_OpenWindow.arguments;
        var window_width      = args[4];
        var window_height     = args[5];
        var window_left       = args[6];
        var window_top        = args[7];
    
        if ( typeof( window_left ) == "undefied" || window_left == "" ) { window_left = ( screen.width - window_width  ) / 2; }
        if ( typeof( window_top  ) == "undefied" || window_top  == "" ) { window_top  = ( screen.height- window_height ) / 2; }

        var imageList2Win = window.open("/zzook/jsp/common/ImageList2.jsp?p_s_gubun=" + gubun + "&p_s_img_cd=" + imgCd + "&p_in_gubun=" + inGubun + "&p_name=" + name , "imageList2Win",'width=' + window_width + ', height=' + window_height + ',left=' + window_left + ',top=' + window_top + ',status=no, menubar=no, resizable=yes, scrollbars=yes');
                          
        imageList2Win.focus();
    }
    function imageList3_OpenWindow (gubun, imgCd, inGubun, name, window_width, window_height, window_left, window_top) {
        var args = imageList3_OpenWindow.arguments;
        var window_width      = args[4];
        var window_height     = args[5];
        var window_left       = args[6];
        var window_top        = args[7];
    
        if ( typeof( window_left ) == "undefied" || window_left == "" ) { window_left = ( screen.width - window_width  ) / 2; }
        if ( typeof( window_top  ) == "undefied" || window_top  == "" ) { window_top  = ( screen.height- window_height ) / 2; }

        var imageList3Win = window.open("/zzook/jsp/common/ImageLinkList.jsp?p_s_gubun=" + gubun + "&p_s_img_cd=" + imgCd + "&p_in_gubun=" + inGubun + "&p_name=" + name +"imageList3Win","width=550, height=500 ,left=' + window_left + ',top=' + window_top + ',status=no, menubar=no, resizable=yes, scrollbars=yes');
                          
        imageList3Win.focus();
    }
//-->