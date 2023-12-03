    function appendInputLogBox( colNm, displayVal, width, height, gubun ) {
        displayVal = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width   = ( typeof ( width  ) == "undefined" ) ? "0" : width ;
        height  = ( typeof ( height ) == "undefined" ) ? "0" : height;
        var  sItemID = "";
        if ( itemCnt + 1 < 10 ) {
            sItemID = "0" + ( itemCnt + 1 );
        } else {
            sItemID = ( itemCnt + 1 );
        }

        var insertInput = "";
        if(gubun == "input") {
            insertInput = "<INPUT type=text name='" + colNm + "' value='" + displayVal + "' style='width:" + width + ";height:" + height + "' copytype=none>";
        } else if(gubun == "passwd") {
            insertInput = "<INPUT type=password name='" + colNm + "' value='" + displayVal + "' style='width:" + width + ";height:" + height + "' copytype=none>";
        }
        append(insertInput, 'child');
    }

    var twinklingNum = 0   ;
    var timeOutId    = null;
    var twinlingObj  = null;
    var twinlingBackCss = null;

    function Add_Element4(parentObj, name, displayVal, width, height, gubun ) {
        Object_TwinklingClear ();
        twinlingObj = eval(parentObj + "." + name);
        var focusGubun = "1"; // 1 : > focus 메소드 있는 객체, 2 :> focus 메소드가 없는 객체
        if ( typeof ( twinlingObj ) == 'undefined' && typeof ( getObject(name, designtier) ) == 'object' ) {
            twinlingObj = getObject(name, designtier);
            focusGubun = "2";
        }
        if ( timeOutId == null ) {
            if ( typeof ( twinlingObj ) != "object" ) {
                if ( gubun == "input" ) {
                    appendInputLogBox(name, displayVal, width, height, gubun);
                } else if ( gubun == "passwd" ) {
                    appendInputLogBox(name, displayVal, width, height, gubun);
                } else if ( gubun == "input_submit" ) {
                    appendInputSubmit(name, displayVal, width, height, gubun);
                } else if ( gubun == "input_img" ) {
                    imageList2_OpenWindow ("*", "10", "2", name, "2");
                }
            } else {
                alert ( "템플릿에 이미 존재 합니다.");
                if ( focusGubun == "1" ) {
                    twinlingObj.focus();
                }
                twinlingBackCss = twinlingObj.style.cssText;
                timeOutId = window.setInterval ( Object_Twinkling, 300 );
            }
            FrameResize( 1, 1, 'designPannel' );
        }
    }

    function Object_TwinklingClear1 () {
        if ( timeOutId != null ) {
            window.clearInterval (timeOutId);
        }
        if ( twinlingBackCss != null && twinlingBackCss != "" ) {
            twinlingObj.style.cssText = twinlingBackCss;
        }
        twinlingBackCss = null;
        timeOutId = null;
        twinklingNum = 0;
    }

    function Object_Twinkling1 (name) {

        if ( twinklingNum % 2 == 0 ) {
            twinlingObj.style.borderStyle ="dashed";
            twinlingObj.style.borderWidth ="2"     ;
            twinlingObj.style.borderColor ="red"   ;
            twinlingObj.style.cursor      ="hand"  ;
            twinlingObj.focus();
        } else {
            twinlingObj.style.cssText = twinlingBackCss;
            this.focus();
        }

        if ( twinklingNum > 7 ) {
            Object_TwinklingClear1 ();
            this.focus();
        }
        twinklingNum++;
    }