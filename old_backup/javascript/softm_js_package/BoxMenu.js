    var menuCindex = 0;
    var panelName = "";
    var panel     = "";
    var MENU = new HashTable();

    var menuWin = null;

    var colorFGPop = null;
    var colorBGPop = null;

    function BoxMenu(obj, Name, tier) {
        if ( is.ie ) {
            obj.oncontextmenu  = ShowMenu;
        } else if (is.ns) {
            obj.ondblclick     = ShowMenu;
        }
        /* Menu panel 생성 */
        obj.body.innerHTML += "<div id=\"" + Name + "\" style=\"position:absolute;visibility:hidden;top:0;left:0;z-index:1000;\"></div>";
        panelName = Name;

        obj.onclick  = HideMenu;

        menuWin = tier;
        panel   = getObject(Name, menuWin); 

        panel.innerHTML = "";
    }

    function newMenu() {
        var m = new HashTable();
        return m;
    }

    function MENU_ITEM(name, command, level, objDepend, child){
/*        this.menu_id= id     ; */
        this.name       = name   ;
        this.command    = command;
        this.level      = level  ;
        this.objDepend  = objDepend;
        this.child      = child  ;
    }

    function setMenu(key, obj) {
        MENU.putValue("menu" + menuCindex, obj);
    }

    function getMenu(key) {
        return MENU.getValue("menu" + key);
    }

    function createMenu(panel,menu) {
        setMenu(menuCindex, menu);

        var menuStr = "";
        var size = menu.getSize();
/*        alert ( " menuCindex : " + menuCindex + " / " + size ); */
        menuStr += "<div id=\"menu" + menuCindex + "\" style=\"position:absolute;visibility:hidden;top:0;left:0;width:100;z-index:1000;\">";
        menuStr += "    <table cellpadding=0 cellspacing=0 border=0 width=80>";
        menuStr += "        <tr>";
        menuStr += "            <td height=3 bgcolor=E9E9E9></td>";
        menuStr += "        </tr>";
        menuStr += "        <tr>";
        menuStr += "            <td height=1></td>";
        menuStr += "        </tr>";
        menuStr += "        <tr>";
        menuStr += "            <td height=19 bgcolor=669999 align=center><FONT style='font-size:12px; color:ffffff;'><b>상세설정</b></FONT></td>";
        menuStr += "        </tr>";
        menuStr += "        <tr>";
        menuStr += "            <td height=1 bgcolor=8BB1B1></td>";
        menuStr += "        </tr>";
//      menuStr += "    <table border=\"1\" bordercolor=\"#000000\" cellspacing=\"0\" cellpadding=\"0\">\n";
        for ( i=0;i<size;i++ ) {
            var item = menu.getValue(i);
            if ( item.level == 0 ) {
                var command ='';
                if ( item.command != '' ) {
                    command = " onclick=\"parent.ExecCommand('" + item.command + "');return false;\"\n";
                }

                var id = "sub" + menuCindex + "_" + item.child;

                if ( typeof(item.child) == 'string' && item.child != '' ) {
                    menuStr += "    <tr class='ff' height=20 align=center style=\"font-size:9pt;cursor:hand;top:0;left:0\" onmouseover=\"parent.objectBackColor( this, '#E4E4E4' );\" onmouseout=\"parent.objectBackColor( this, '#FFFFFF' );\"" + command + "><td>\n";
                } else {
                    menuStr += "    <tr class='ff' height=20 align=center style=\"font-size:9pt;cursor:hand;top:0;left:0\" onmouseover=\"parent.objectBackColor( this, '#E4E4E4' );parent.HideSubMenu(" + menuCindex + ", " + item.level + ");\" onmouseout=\"parent.objectBackColor( this, '#FFFFFF' );\"" + command + "><td>\n";
                }
                menuStr += item.name + "\n";

                if ( typeof(item.child) == 'string' && item.child != '' ) {
                    menuStr += "    <img height=\"10\" src=\"/Lecture/image/dhtml/dhtml01.gif\" onmouseover=\"parent.ShowSubMenu( '" + id + "', event );\">\n";
                }

                menuStr += "    </td></tr>\n";
                menuStr += "    <tr> <td height=1 background='/zzook/image/newadmin/dot_3.gif'></td> </tr>\n";
                if ( typeof(item.child) == 'string' ) {
/*                    alert ( menu + "/" + item.child ); */
                    subCreateMenu(panel,menu, item.child)
                }
            }
        }
        menuStr += "    </table>\n";
        menuStr += "</div>\n"
        menuStr = panel.innerHTML + menuStr;

        panel.innerHTML = menuStr;
/*      panel.innerText = menuStr; */
        menuCindex++;   /* Menu Group */
/*        alert ( menuStr ); */

    }

    function subCreateMenu(panel, menu, child) {

        var sub = menu.getValues(child);
        var item   = null;
        var menuStr = "";
        var id = "sub" + menuCindex + "_" + child;
        for ( var k=0;k<sub.length;k++ ){
            item = sub[k];
            if ( k == 0 ) {
                menuStr += "<div id=\"" + id + "\" style=\"position:absolute;visibility:hidden;top:0;left:0;width:100;z-index:100" + menuCindex + item.level + ";\">\n";
                menuStr += "    <table border=\"1\" bordercolor=\"#000000\" cellspacing=\"0\" cellpadding=\"0\" onmouseover=\"\">\n";
            }

                var command ='';
                if ( item.command != '' ) {
                    command = " onclick=parent.ExecCommand('" + item.command + "');return false;\n";
                }

                if ( typeof(item.child) == 'string' && item.child != '' ) {
                    menuStr += "    <tr bgcolor='#FFFFFF' style=\"font-size:9pt;cursor:hand;top:0;left:0\" onmouseover=\"parent.objectBackColor( this, '#646464' );\" onmouseout=\"parent.objectBackColor( this, '#FFFFFF' );\"" + command + "><td>\n";
                } else {
                    menuStr += "    <tr bgcolor='#FFFFFF' style=\"font-size:9pt;cursor:hand;top:0;left:0\" onmouseover=\"parent.objectBackColor( this, '#646464' );parent.HideSubMenu(" + menuCindex + ", " + item.level + ");\" onmouseout=\"parent.objectBackColor( this, '#FFFFFF' );\"" + command + "><td>\n";
                }

                menuStr += item.name + "\n";
                if ( typeof(item.child) == 'string' && item.child != '' ) {
                    menuStr += "<img height=\"10\" src=\"/Lecture/image/dhtml/dhtml01.gif\" onmouseover=\"parent.ShowSubMenu( '" + id + "', event )\">\n";
                }
                menuStr += "    </td></tr>\n";
/*                alert ( menuStr ); */
            if ( (k + 1) == sub.length ) {
                menuStr += "    </table>\n";
                menuStr += "</div>\n";
                panel.innerHTML = panel.innerHTML + menuStr;
/*                alert ( "sub : " + child + " / " + menuStr ); */
            }
            subCreateMenu(panel, menu, item.child);
        }
    }
    var xPos=yPos=0;

    function ShowMenu(e) {
        // 수정 모드일 경우에만 메뉴가 동작하게.
//      if ( typeof(designMode) != "undefined" && designMode == 0  ) {
//        if ( currentObj != null ) {
            HideMenu();
            var obj = null;
            for ( var i=0;i<MENU.getSize();i++){
                obj = getObject("menu" + i,menuWin);
                objectShow( obj );
                if ( is.ie ) {
                    var windowObj = eval(menuWin);
                    xPos=windowObj.event.clientX;
                    yPos=windowObj.event.clientY;
                } else if( is.ns ) {
                    xPos=e.pageX;
                    yPos=e.pageY;
                }
                objectMoveTo(obj, xPos, yPos);
            }
//        }
/*        objectShow( "menu_panel" ); */
//      }
        FrameResize( 100, 100, 'designPannel' );
    	return false;
    }

    function ShowSubMenu(objStr,e) {
        if ( currentObj != null ) {
            var obj = getObject(objStr, menuWin);
            objectShow( obj );
            if ( is.ie ) {
                var windowObj = eval(menuWin);
                objectMoveTo(obj, windowObj.event.clientX, windowObj.event.clientY)
            } else if( is.ns ) {
                objectMoveTo(obj,e.pageX, e.pageY)
            }
        }
        return false;
    }

    function HideMenu() {
        var obj = null;
        for ( var i=0;i<MENU.getSize();i++){
            var menu = getMenu(i);
            objectHide("menu" + i, menuWin);
            var allValue = menu.getValueALL();
            var allKey   = menu.getKeyALL();
            for ( var j=0; j<allKey.length;j++) {
                var item = allValue[j];
                if  ( item.level >= 1 ) {
                   objectHide("sub" + i + "_" + allKey[j], menuWin);
                }
            }
        }
//      document.Panel_MainForm.p_tpl.value += "HideMenu\n";
    }

    function HideSubMenu(menuID, level) {
        var menu = getMenu(menuID);
        var allValue = menu.getValueALL();
        var allKey   = menu.getKeyALL();
        for ( var i=0; i<allKey.length;i++) {
            var item = allValue[i];
            if  ( item.level > level ) {
                objectHide("sub" + menuID + "_" + allKey[i], menuWin);
            }
        }
    }

    function ExecCommand(key, val){
/*        alert ( key ); */
        var obj = null;
        if ( objectGB == "1" ) {
            obj = currentObj;
        } else if ( objectGB == "2" ) {
            obj = selectObj;
        }

        switch(key) {
            case "DELETE":
                if ( currentObj != null && currentObj.id.indexOf("p_") != 0 ) {
//                  alert ( currentObj.innerHTML );
                    eval ( menuWin ).document.body.innerHTML = removeTagStrById(currentObj.id, menuWin);
                    if ( currentFocusObj != null && currentObj.id == currentFocusObj.id ) {
                        currentFocusObj = null;
                    }
                    currentObj = null;
                }
                break;
            case "TOP":
                if ( currentObj != null || selectObj != null  ) {
                    for (var i=1;i<=itemCnt;i++){ 
                        eval("item" + i + ".style.zIndex = " + "item" + i + ".style.zIndex - 1")
                        if (eval("item" + i + ".style.zIndex") < 1) eval("item" + i + ".style.zIndex = 1") 
                    }
                    currentObj.style.zIndex = itemCnt;
                }
                break;
            case "BOTTOM":
                if ( currentObj != null || selectObj != null  ) {
                    for (var i=1;i<=itemCnt;i++){ 
                        eval("item" + i + ".style.zIndex = " + "item" + i + ".style.zIndex + 1")
                        if (eval("item" + i + ".style.zIndex") <= 2) eval("item" + i + ".style.zIndex = 1") 
                    }
                    currentObj.style.zIndex = 1;
                }
                break;
            case "PRESTEP":
                if ( currentObj != null || selectObj != null  ) {
                    if (currentObj.style.zIndex < itemCnt) { 
                        currentObj.style.zIndex = currentObj.style.zIndex + 1;
                    }
                }
                break;
            case "AFTSTEP":
                if ( currentObj != null || selectObj != null  ) {
                    if (currentObj.style.zIndex > 2 ) { 
                        currentObj.style.zIndex = currentObj.style.zIndex - 1;
                    }
                }
                break;
            case "FGCOLOR":
                if ( obj ) {
                    var width  = 465;height = 350;
//                    var left = ( screen.width - width  ) / 2;
//                    var top  = ( screen.height- height ) / 2;
                    var left = ( screen.width - ( width  * 2 ) );
                    var top  = 0;
                    var myObject = new Object();
                    myObject.Window         = window            ;
                    myObject.designDocument = designDocument    ;
                    myObject.attribute      = "color"           ;

                    if ( colorFGPop != null ) {
                        if ( typeof( colorFGPop.dialogHeight) == "unknown" ) {
                            colorFGPop = window.showModelessDialog("/zzook/jsp/common/Color.html",myObject,"dialogHeight: " + height + "px; dialogWidth: " +  width + "px; dialogTop: " + top + "px; dialogLeft: " + left + "px; edge: Raised; center: Yes; help: Yes; resizable: Yes; status: Yes;");
                        } else {
                            colorFGPop.focus();
                        }
                    } else {
                        colorFGPop = window.showModelessDialog("/zzook/jsp/common/Color.html",myObject,"dialogHeight: " + height + "px; dialogWidth: " +  width + "px; dialogTop: " + top + "px; dialogLeft: " + left + "px; edge: Raised; center: Yes; help: Yes; resizable: Yes; status: Yes;");
                    }
//                  var colorPop = window.open("/zzook/jsp/common/Color.html","color",'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',status=no, menubar=no, resizable=yes');
                }
                break;
            case "BGCOLOR":
                if ( obj != null ) {
                    var width  = 465;height = 350;
                    var left = ( screen.width - width  ) / 2;
                        left += 465;
//                    var top  = ( screen.height- height ) / 2;
                    var top  = 0;
                    var myObject = new Object();
                    myObject.Window         = window            ;
                    myObject.designDocument = designDocument    ;
                    myObject.attribute      = "backgroundColor" ;
                    if ( colorBGPop != null ) {
                        if ( typeof( colorBGPop.dialogHeight) == "unknown" ) {
                            colorBGPop = window.showModelessDialog("/zzook/jsp/common/Color.html",myObject,"dialogHeight: " + height + "px; dialogWidth: " +  width + "px; dialogTop: " + top + "px; dialogLeft: " + left + "px; edge: Raised; center: Yes; help: Yes; resizable: Yes; status: Yes;");
                        } else {
                            colorBGPop.focus();
                        }
                    } else {
                        colorBGPop = window.showModelessDialog("/zzook/jsp/common/Color.html",myObject,"dialogHeight: " + height + "px; dialogWidth: " +  width + "px; dialogTop: " + top + "px; dialogLeft: " + left + "px; edge: Raised; center: Yes; help: Yes; resizable: Yes; status: Yes;");
                    }
//                  var colorPop = window.open("/zzook/jsp/common/Color.html","backgroundColor",'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',status=no, menubar=no, resizable=yes');
                }
                break;
            case "FONT":
                if ( obj ) {
                    var width  = 400;height = 1;
                    var left = ( screen.width - width  ) / 2;
//                    var top  = ( screen.height- height ) / 2;
                    var top  = 188;
                    var fontPop  = window.open("/zzook/jsp/common/Font.html","10",'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top + ',status=no, menubar=no, resizable=yes');
                    fontPop.focus();
                }
                break;

            case "WIDTHUP":
                if ( currentObj != null ) {
//                  alert ( "style width : " + typeof( obj.style.width ) + " / " + obj.style.width );
//                  alert ( "width : " + typeof( obj.width ) + " / " + obj.width );
                    var width = 0;
                    if ( typeof( currentObj.height ) == "number" && currentObj.tagName.toUpperCase() != 'INPUT' ) {
                        width = parseInt ( currentObj.width );
                    } else {
                        if ( typeof ( obj.style.width ) == "string" && currentObj.style.width != '' ) {
                            width = currentObj.style.width;
                            if ( width == '100%' ) {
                                width = 100;
                            } else {
                                width = parseInt ( width );
                            }
                        } else {
                            width = 0;
                        }
                    }
                    currentObj.style.width = width + val;
                }
                break;
            case "WIDTHDOWN":
                if ( currentObj != null ) {
//                  alert ( "style width : " + typeof( obj.style.width ) + " / " + obj.style.width );
                    //alert ( "width : " + typeof( obj.width ) + " / " + obj.width );
                    var width = 0;
                    if ( typeof( currentObj.height ) == "number" && currentObj.tagName.toUpperCase() != 'INPUT' ) {
                        width = parseInt ( currentObj.width );
                    } else {
                        if ( typeof ( currentObj.style.width ) == "string" && currentObj.style.width != '' ) {
                            width = currentObj.style.width;
                            if ( width == '100%' ) {
                                width = 100;
                            } else {
                                width = parseInt ( width );
                            }
                        } else {
                            width = 0;
                        }
                    }
                    if ( width > val) {
                        currentObj.style.width = width - val;
                    }
                }
                break;
            case "HEIGHTUP":
                if ( currentObj != null ) {
//                  alert ( "style height : " + typeof( obj.style.height ) + " / " + obj.style.height );
//                  alert ( "height : " + typeof( obj.height ) + " / " + obj.height );

                    var height = 0;
                    if ( typeof( currentObj.height ) == "number" && currentObj.tagName.toUpperCase() != 'INPUT' ) {
                        height = parseInt ( currentObj.height );

                    } else {
                        if ( typeof ( currentObj.style.height ) == "string" && currentObj.style.height != '' ) {
                            height = currentObj.style.height;
                            if ( height == '100%' ) {
                                height = 25;
                            } else {
                                height = parseInt ( height );
                            }
                        } else {
                            height = 1;
                        }
                    }
                    currentObj.style.height = height + val;
                }
                break;
            case "HEIGHTDOWN":
                if ( currentObj != null ) {
//                  alert ( "style height : " + typeof( obj.style.height ) + " / " + obj.style.height );
//                  alert ( "height : " + typeof( obj.height ) + " / " + obj.height );
                    var height = 0;
                    if ( typeof( currentObj.height ) == "number" && currentObj.tagName.toUpperCase() != 'INPUT' ) {
                        height = parseInt ( currentObj.height );
                    } else {
                        if ( typeof ( currentObj.style.height ) == "string" && currentObj.style.height != '' ) {
                            height = currentObj.style.height;
                            if ( height == '100%' ) {
                                height = 25;
                            } else {
                                height = parseInt ( height );
                            }
                        } else {
                            height = 1;
                        }
                    }
                    if ( height > val) {
                        currentObj.style.height = height - val;
                    }
                }
                break;
            case "TARGET":
                if ( currentObj != null || selectObj != null  ) {

                    var textPop  = window.open("/zzook/jsp/newadmin/html/HtmlInput_1.jsp","10",'width=700, height=500, left=0, top=0 ,status=no, menubar=no, resizable=yes');
                    textPop.focus();
                }
                break;

            case "INSERTTEXT":
                var insertInput = "<DIV type='text'>2222222222222222</DIV>";
                append(insertInput, 'div');
                objectShow  ("CONTENTINSERT", designtier );
                objectMoveTo("CONTENTINSERT", xPos, yPos, designtier );
                break;

            default:break;
        }
        HideMenu();
        return false;
    }