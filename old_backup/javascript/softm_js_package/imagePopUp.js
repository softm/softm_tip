//******************************************************/
//** Function Name    : imagePopUp
//** Description      : �̹��� �˾� �����츦 ����ϱ� ���� ������
//******************************************************/
<!--
    var imageWin = null; // �˾�

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
//** Description      : �̹��� �˾� �����츦 ����ϱ� ���� ������
//** Argument1        : val     : �̹��� ���
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
    / Description     : �̹��� ��ȸ ( ImageList1.jsp )
    /-----------------------------------------------------
    / Arguments
    /-----------------------------------------------------
    /   gubun           : '*' : ��ü, 'A' : ������ �̹��� , 'B' : ����� �̹���
    /   imgCd           : '*' : ��ü, Code ���̺� Major_Cd = '03'
    /   inGubun         : '1' :  '<IMG' , '2' : <INPUT type='image', 
    /                     '3' : <IMG attribute = name�ʵ� , 
    /                     '4' : BBs���� ��� ��ư ���� ( DesignRef.js �� appendFunction() �Լ��� ȣ���ϰԵ�
    /                     '5' : �� ���� �Լ���
    /   name            : Add�� Element�� �̸�
    /   window_width    : ������ ũ��
    /   window_height   : ������ ����
    /   window_left     : ������ ��µ� X��ǥ
    /   window_top      : ������ ��µ� Y��ǥ
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
    / Description     : �̹��� ��ȸ ( ImageList2.jsp )
    /-----------------------------------------------------
    / Arguments
    /-----------------------------------------------------
    /   gubun           : '*' : ��ü, 'A' : ������ �̹��� , 'B' : ����� �̹���
    /   imgCd           : '*' : ��ü, Code ���̺� Major_Cd = '03'
    /   inGubun         : '1' :  '<IMG' , '2' : <INPUT type='image', 
    /                     '3' : <IMG attribute = name�ʵ� , 
    /                     '4' : BBs���� ��� ��ư ���� ( DesignRef.js �� appendFunction() �Լ��� ȣ���ϰԵ�
    /                     '5' : �� ���� �Լ���
    /                     '6' : ���������� Ư�� ID���� �̹��� ����
    /   name            : Add�� Element�� �̸�
    /   itemCnt         : �� ���� ��ġ�� �̹��� ��
    /   window_width    : ������ ũ��
    /   window_height   : ������ ����
    /   window_left     : ������ ��µ� X��ǥ
    /   window_top      : ������ ��µ� Y��ǥ
    /   itemCnt         : �ѿ��� ��µ� �̹����� ����
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