<!--
    var designtier = null;
    var objectGB   = null; // 1 : ���� ��ü, 2 : ���ø�

    var selectObj     = null; // ����     ���õ� Template ���� Object ��
    var selectOldObj  = null; // ���� ���õǾ��� Template ���� Object ��
    var selectFocusObj= null; // ���� ���콺�� �ö�� Template ���� Object ��
    var loadingEnd    = 0; /* ������ �ε尡 �Ϸ� �˻� */
    var tempBorder    = 1; /* ���ø� Border �⺻ ũ�� */
    var tempBorderYN  = null; /* ���ø� Border �⺻ ũ�� */

    function Template(tier, dDocument, tScript, tStyle, tBorderYN ){
        designtier = tier;
//      designDocument.body.innerHTML += "<TEXTAREA id=CONTENTINSERT " + editScript + " style='BORDER-RIGHT: white 0px; BORDER-TOP: white 0px; Z-INDEX: 1; LEFT: 0px; BORDER-LEFT: white 0px; CURSOR: hand; BORDER-BOTTOM: white 0px; POSITION: absolute; TOP: 0px;visibility:hidden'></TEXTAREA>";
        tempBorderYN  = tBorderYN; /* ���ø� Border ���� ���� */
        templateElementConstruction ( dDocument, tScript, tStyle );
        designDocument.execCommand("2D-Position", 0, true); // �̵� ��� Ȱ��ȭ
//      designDocument.execCommand("LiveResize",  1, false); // ũ�� ���� �̸����� Ȱ��ȭ
        EndLoading();
    }

    function EndLoading () { /* �ε��� �Ϸ���Ŀ� ���� ��ư�� ������ */
        var obj = getObject("save_bt");
        objectShow ( obj );
    }

    function templateReload   () {
        document.Panel_MainForm.action = document.location.href;
        document.Panel_MainForm.submit();
    }

    /* ���ø��� ���� �մϴ�.*/
    function templateChange (procCd) {
        if (confirm("���ø��� �����ϸ� ���� ����� ������ �ҽ� �˴ϴ�.")) {
            document.Panel_MainForm.action = homeUrl + "/jsp/common/TemplateChange.jsp";
            setValue1 ( document.Panel_MainForm.p_proc_cd  ,procCd       );
            setValue1 ( document.Panel_MainForm.p_mode     ,"temp_update");
//          alert ( curPage );
            setValue1 ( document.Panel_MainForm.p_back_url ,curPage      );
            document.Panel_MainForm.submit();
        }
    }

    /* ���ø��� ������ ǥ���ϱ� ���� Border ����            */
    /* SuperAdmin���� Border�� 0���� �����Ѱ��� �⺻���� �� */
    function templateBorderCreate() {
        var tableObjs = designDocument.all.tags("TABLE");
//      alert ("table ���� : " + tableObjs.length);
        for ( var i=0; i<tableObjs.length; i++ ) {
            var border = tableObjs[i].border;
            if  ( border != "" && border != "NaN" ) {
                tableObjs[i].border = parseInt ( border ) + tempBorder;
//              alert ( "�ε��� ���� : " + tableObjs[i].border );
            } else {
                    tableObjs[i].border = tempBorder;
            }
        }
    }

    /* ���ø��� ������ ǥ���ϱ� ���� Border ���� */
    function templateBorderRemove() {
        var tableObjs = designDocument.all.tags("TABLE");
//      alert ("table ���� : " + tableObjs.length);
        for ( var i=0; i<tableObjs.length; i++ ) {
            var border = tableObjs[i].border;
            if  ( border != "" && border != "NaN" ) {
                if ( tableObjs[i].border > 0) {
                    tableObjs[i].border = parseInt ( border ) - tempBorder;
//                  alert ( "������ ���� : " + tableObjs[i].border );
                }
            } else {
                    tableObjs[i].border = 0;
            }
        }
    }

    // ���ø� �ʱ�ȭ�� �̿�˴ϴ�.
    // ���ø� ���� �������� id���� 'p_' ������ ���۵Ǵ� DIV��ü�� �̷���� �ֽ��ϴ�.
    // �� ��ü�鿡 SCRIPT�� �߰��ϴ� ó���� ���� �մϴ�.
    var H_count = 0;    // ���   �κ��� ����
    var C_count = 0;    // ������ �κ��� ����
    var F_count = 0;    // Ǫ��   �κ��� ����

    function templateElementConstruction( docObj, templateScript, templateStyle, templateBorder ) {
        var inner = docObj.body.innerHTML;
        var id    = "p_";
        var i     = 0;
        var id1 = 'id="' + id;
        var id2 = "id='" + id;
        var id3 = "id="  + id;
        var delim  = "";
        tempBorder = ( typeof( templateBorder ) == "undefined" ) ? 1 : templateBorder;
        if ( tempBorderYN == "Y" ) { templateBorderCreate(); }
        for(var i=0;i<inner.length;i++) {
            var id_str = "";
            if ( inner.toUpperCase().indexOf(id1.toUpperCase(),i) > 0 ) {
                i = inner.toUpperCase().indexOf(id1.toUpperCase(),i);
                id_str = inner.substring( i + 4, i + 9 );
            } else if ( inner.toUpperCase().indexOf(id2.toUpperCase(),i) > 0 ) {
                i = inner.toUpperCase().indexOf(id2.toUpperCase(),i);
                id_str = inner.substring( i + 4, i + 9 );
            } else if ( inner.toUpperCase().indexOf(id3.toUpperCase(),i) > 0 ) {
                i = inner.toUpperCase().indexOf(id3.toUpperCase(),i);
                id_str = inner.substring( i + 3, i + 8 );
            }

            if ( id_str != "" ) {
//              alert ( getObject(id_str, designtier) );
                var objStr  = addString( getTagStrById( id_str, designtier, inner), templateScript + " style='" + templateStyle + "' class='DIVSELECT'" );
                inner = replaceTagStrById(id_str,objStr, designtier, inner);
                if ( id_str.indexOf ("p_H") == 0 ) { H_count++;}    // ��� �κ��� ����
                if ( id_str.indexOf ("p_C") == 0 ) { C_count++;}    // ������ �κ��� ����
                if ( id_str.indexOf ("p_F") == 0 ) { F_count++;}    // Ǫ�� �κ��� ����
            } else {
                break;
            }
            i = i + 4;
        }
        docObj.body.innerHTML = inner;
//        alert ( "changed innerHTML" + designDocument.body.innerHTML );
    }

    function templateElementAbstract(obj,script){

    }

    function appendObjectDb ( objStr, gubun, tagNm, value ) {
        var obj = null;
        if ( typeof( objStr ) == 'object' ) {
            obj = objStr;               // INSERT Object
        } else {
            obj = getObject ( objStr );  // INSERT Object
        }
        var objHTML   = obj.innerHTML;
        append( objHTML, gubun, tagNm, value );
    }
    function getItemStr () {
        var  sItemID = "";
        if ( itemCnt + 1 < 10 ) {
            sItemID = "0" + ( itemCnt + 1 );
        } else {
            sItemID = ( itemCnt + 1 );
        }
        return sItemID;
    }
    function appendStrDb ( val, colNm, gubun, align ) {
//      var sStr = "<TABLE cellpadding='0' cellspacing='0' width='100%'><TR><TD bgcolor='#D1DCE5'>";
//      var mStr = "<IMG src='" + objStr + "' border='0'>";
//      var eStr = "</TD></TR></TABLE>";
//      objStr = sStr + mStr + eStr;
//      objStr = addAttr( objStr , "value", "db" );
//      append( objStr, gubun, tagNm, value );
//      append( "<DIV CONTENTEDITABLE=false style='width:0;height:0' bgcolor='#CCDFE3'><font color=#57728C><B>" + val + "</B></font></div>", "div" );
        if ( typeof( align ) == 'undefined' ) { align = "left" };
        var insertStr  = "";
//      ReGeTemplate (designtier); /* APLi ���̵��� ���Ӱ� �����մϴ�. */
        if ( gubun == 'DIV' ) {
//            insertStr  = "<MARQUEE style='background:transparent;width:100%;height:100%;font-size: 10pt' DIRECTION=" + align + " BEHAVIOR=slide SCROLLAMOUNT=10000 SCROLLDELAY=1 loop=1>";
//            insertStr += val;
//            insertStr += "</MARQUEE >";
//              insertStr   = "<table style='width:100%' border='1'>";
//              insertStr  += "<td align='" + align + "' CONTENTEDITABLE=false>" + val + "</td>";
//              insertStr  += "</table>";
              insertStr  = "<DIV class='DB' align='" + align + "' CONTENTEDITABLE=false>" + val + "</DIV>";
        } else if ( gubun == 'INPUT' ) {
            insertStr  = "<INPUT TYPE='text' style='background:transparent;border:0 none;width:100%;height:100%;text-align:" + align +"' value='" + val + "' CONTENTEDITABLE=false>";
        }
        var  sItemID = "";
        if ( itemCnt + 1 < 10 ) {
            sItemID = "0" + ( itemCnt + 1 );
        } else {
            sItemID = ( itemCnt + 1 );
        }
        insertStr  = addAttr( insertStr , "attribute", "DB$$" + sItemID + "$$" + colNm  + "$$00"           );
        append( insertStr, "div" );
    }

    function appendSkin ( url, skinId, procCd ) {
//      ReGeTemplate (designtier); /* APLitem ���̵��� ���Ӱ� �����մϴ�. */

        var insertStr  = "<IFRAME src='" + url + "' SCROLLING=NO frameborder=0 border='0' MARGINHEIGHT=0 MARGINWIDTH=0 width='100%' height='100%' framespacing='0'></IFRAME>";
            var  sItemID = "";
            if ( itemCnt + 1 < 10 ) {
                sItemID = "0" + ( itemCnt + 1 );
            } else {
                sItemID = ( itemCnt + 1 );
            }
//          insertStr  = addAttr( insertStr , "proccd"   , procCd);
            insertStr  = addAttr( insertStr , "attribute", "SK$$" + sItemID + "$$" + skinId + "$$" + procCd);
            append( insertStr, "div" );
//          alert ( ''  );
//          var innerDocument = designWindow.getFrame( currentObj.id ).document;

//          innerDocument.body.innerHTML += "\n<link rel='stylesheet' href='/zzook/jsp/newadmin/main.css'>";
            window.setTimeout ("appendSkin_Resize('" + currentObj.id + "')", 1000);

    }

    function appendSkin_Resize(skinId) {
        designWindow.FrameResize ( 1, 0, skinId, 0);
    }

    var pageTabSelectID = "";

    function appendITEM ( gubun, attrVal, val, title ) {
        var insertStr = "";
        var sItemID = getItemStr ();
        var source = designDocument.body.innerHTML;
        if ( source.indexOf ( "$$" + attrVal + "$$") > 0 ) {
            alert ('�׸��� ���ø� ���� ���� �մϴ�.');
            return;
        }

        if ( attrVal == "pre_text"  || attrVal == "pre_img"  ) { title = "����"; }
        if ( attrVal == "aft_text"  || attrVal == "aft_img"  ) { title = "����"; }

        if ( attrVal == "tab"  ) {
           pageTabSelectID =  selectObj.id;
        }
        if ( gubun == "text" ) {
//          attribute=" + attrVal + ";
//          insertStr  = "<DIV class=ITEMDIV CONTENTEDITABLE=false title='" + title + "'>" + val + "</div>";
            insertStr  = "<DIV title='" + title + "'>" + val + "</div>";
            insertStr  = addAttr( insertStr , "attribute", "IT$$" + sItemID + "$$" + attrVal + "$$"  + val );
            append( insertStr, "div" );
        } else if ( gubun == "image" ) {
            insertStr  = "<IMG src='" + val + "' title='" + title + "'></IMG>";
            insertStr  = addAttr( insertStr , "attribute", "IT$$" + sItemID + "$$" + attrVal + "$$"  + val );
            append( insertStr, "child");
        }
    }

    function appendObject( objStr, gubun, tagNm, value ) {
        var obj = null;
        if ( typeof( objStr ) == 'object' ) {
            obj = objStr;               // INSERT Object
        } else {
            obj = getObject( objStr );  // INSERT Object
        }
        var objHTML   = obj.innerHTML;
        append( objHTML, gubun, tagNm, value );
    }

    function appendInputBox( colNm, displayVal, width, height ) {
        displayVal = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width   = ( typeof ( width  ) == "undefined" ) ? "0" : width ;
        height  = ( typeof ( height ) == "undefined" ) ? "0" : height;
        var  sItemID = "";
        if ( itemCnt + 1 < 10 ) {
            sItemID = "0" + ( itemCnt + 1 );
        } else {
            sItemID = ( itemCnt + 1 );
        }
//      var insertInput = "<div style='width:" + width + ";height;" + height + "'><INPUT type=text name='" + name + "' value='" + displayVal + "' style='border-style:window-inset;border-width:2;width:100%;height:100%'></div>";
        var insertInput = "<INPUT type=text name='" + colNm + "' value='" + displayVal + "' style='width:" + width + ";height:" + height + "' copytype=none>";
            insertInput  = addAttr( insertInput , "attribute", "DB$$" + sItemID + "$$" + colNm  + "$$00"           );
//      append(insertInput, 'div');
        append(insertInput, 'child');
    }

    function appendInputPasswd( colNm, displayVal, width, height ) {
        displayVal = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width   = ( typeof ( width  ) == "undefined" ) ? "0" : width ;
        height  = ( typeof ( height ) == "undefined" ) ? "0" : height;
        var  sItemID = "";
        if ( itemCnt + 1 < 10 ) {
            sItemID = "0" + ( itemCnt + 1 );
        } else {
            sItemID = ( itemCnt + 1 );
        }
//      var insertInput = "<div style='width:" + width + ";height;" + height + "'><INPUT type=text name='" + name + "' value='" + displayVal + "' style='border-style:window-inset;border-width:2;width:100%;height:100%'></div>";
        var insertInput = "<INPUT type=password name='" + colNm + "' value='" + displayVal + "' style='width:" + width + ";height:" + height + "' copytype=none>";
            insertInput  = addAttr( insertInput , "attribute", "DB$$" + sItemID + "$$" + colNm  + "$$00"           );
//      append(insertInput, 'div');
        append(insertInput, 'child');
    }

    function appendInputSubmit( name, displayVal, width, height ) {
        displayVal = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width   = ( typeof ( width  ) == "undefined" ) ? "0" : width ;
        height  = ( typeof ( height ) == "undefined" ) ? "0" : height;
//      var insertInput = "<div style='width:" + width + ";height;" + height + "'><INPUT type=submit name='" + name + "' value='" + displayVal + "' style='border-style:window-inset;border-width:2;width:100%;height:100%'></div>";
        var insertInput = "<INPUT type=submit name='" + name + "' value='" + displayVal + "' style='width:" + width + ";height:" + height + "' copytype=none>";
//      append(insertInput, 'div');
        append(insertInput, 'child');
    }

    function appendInputButton( name, preText, displayVal, width, height ) {
        displayVal = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width   = ( typeof ( width  ) == "undefined" ) ? "0" : width ;
        height  = ( typeof ( height ) == "undefined" ) ? "0" : height;
        var functionNm = preText + name.substring(0,1).toUpperCase() + name.substring(1) + "()";
        var insertInput = "<INPUT type=button onClick='return " + functionNm + ";' name='" + name + "' value='" + displayVal + "' style='width:" + width + ";height:" + height + "' copytype=none>";
//      append(insertInput, 'div');
        append(insertInput, 'child');
    }

    function appendTextAreaBox( colNm, displayVal, width, height ) {
        displayVal = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        var  sItemID = "";
        if ( itemCnt + 1 < 10 ) {
            sItemID = "0" + ( itemCnt + 1 );
        } else {
            sItemID = ( itemCnt + 1 );
        }
        width   = ( typeof ( width  ) == "undefined" ) ? "0" : width ;
        height  = ( typeof ( height ) == "undefined" ) ? "0" : height;
//      var insertInput = "<div style='width:" + width + ";height;" + height + "'><TEXTAREA name='" + name + "' style='border-style:window-inset;border-width:2;width:100%;height:100%' cols='" + width + "' rows='" + height + "'>" + displayVal + "</TEXTAREA></div>";
        var insertInput = "<TEXTAREA name='" + colNm + "' cols='" + width + "' rows='" + height + "' copytype=none>" + displayVal + "</TEXTAREA>";
            insertInput  = addAttr( insertInput , "attribute", "DB$$" + sItemID + "$$" + colNm  + "$$00"           );
//      append(insertInput, 'div');
        append(insertInput, 'child');
    }

    /* factor */
    // �Է�, ����, ����, �亯, ��Ϻ���
    // write , input, update, delet, answer, listview
    /* preText : �Լ��� �տ� ���� ���ڿ� */
    /* gubun : 'img' : �̹���, 'txt' : �ؽ�Ʈ , 'but' : ��ư */
    function appendFunction( factor, preText, gubun, val, width, height ) {

        displayVal  = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width       = ( typeof ( width      ) == "undefined" ) ? "0" : width ;
        height      = ( typeof ( height     ) == "undefined" ) ? "0" : height;
        var displayVal = val;
        var insertStr  = "";
        var functionNm = preText + factor.substring(0,1).toUpperCase() + factor.substring(1) + "()";

        if ( gubun == "but" ) {
            insertStr = "<BUTTON onClick='return " + functionNm + ";' style='width:" + width + ";height:" + height + "'>" + val + "</BUTTON>";
            append(insertStr, 'div');
        } else if ( gubun == "img" ) {
            insertStr = "<INPUT type=button name='" + factor + "' style='background-color:transparent;background-repeat: no-repeat;width:" + width + ";height:" + height + ";border:0;background-image:url(" + val + ");cursor:hand' onClick='return " + functionNm + ";' copytype=none>";
            append(insertStr, 'child');
        }
    }

    function appendFunction1( id, val, width, height ) {

        displayVal  = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width       = ( typeof ( width      ) == "undefined" ) ? "0" : width ;
        height      = ( typeof ( height     ) == "undefined" ) ? "0" : height;
        var title = "";
        if ( id == "new" ) { title = "����"; }
        if ( id == "asw" ) { title = "�亯"; }

        var obj = getObject(id);
        obj.style.backgroundImage      = "url(" + val + ")";
        obj.style.backgroundRepeat     = "no-repeat";
        obj.style.backgroundAttachment = 'fixed';
        obj.style.width  = ( width  > 50 ) ? "50" : width ;
        obj.style.height = ( height > 50 ) ? "50" : height;
        obj.style.alt = title;
    }

    function makeSelectListString (name, id, displayVal, width, height) {
        displayVal = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width   = ( typeof ( width  ) == "undefined" ) ? "0" : width ;
        height  = ( typeof ( height ) == "undefined" ) ? "0" : height;
//      var insertInput  = "<div style='width:" + width + ";height;" + height + "'><TEXTAREA name='" + name + "' style='border-style:window-inset;border-width:2;width:100%;height:100%' cols='" + width + "' rows='" + height + "'>" + displayVal + "</TEXTAREA></div>";

        var insertInput  = "<SELECT id='" + id + "' name='" + name + "' style='width:" + width + ";height:" + height + "' copytype=none>";
        insertInput = addString( insertInput , editScript );
        var appendVal    = "";

        for (var i=0; i<displayVal.length;i++ ) {
            if ( typeof ( displayVal[i] ) != "undefined" ) {
                var sObj = displayVal[i].split ("*");
                if ( typeof( sObj[1] ) == "undefined" ) {
                    sObj[1] = "";
                }
                appendVal  += "<OPTION value='" + sObj[1] + "'>" + sObj[0] + "</OPTION>";
            }
        }
        insertInput = insertInput + appendVal + "</SELECT>";
        return insertInput;
    }

    function appendSelectList (name, displayVal, width, height) {
        displayVal = ( typeof ( displayVal ) == "undefined" ) ? "" : displayVal;
        width   = ( typeof ( width  ) == "undefined" ) ? "0" : width ;
        height  = ( typeof ( height ) == "undefined" ) ? "0" : height;
//      var insertInput  = "<div style='width:" + width + ";height;" + height + "'><TEXTAREA name='" + name + "' style='border-style:window-inset;border-width:2;width:100%;height:100%' cols='" + width + "' rows='" + height + "'>" + displayVal + "</TEXTAREA></div>";
        var insertInput  = "<SELECT name='" + name + "' style='width:" + width + ";height:" + height + "' copytype=none>";
        var appendVal    = "";

        for (var i=0; i<displayVal.length;i++ ) {
            if ( typeof ( displayVal[i] ) != "undefined" ) {
                var sObj = displayVal[i].split ("*");
                if ( typeof( sObj[1] ) == "undefined" ) {
                    sObj[1] = "";
                }
                appendVal  += "<OPTION value='" + sObj[1] + "'>" + sObj[0] + "</OPTION>";
            }
        }
            insertInput += "</SELECT>";
        append(insertInput, 'child', "", appendVal )
    }

    function append( objStr, gubun, tagNm, value ) {
        if ( itemCnt > 99 ) {
            alert ( '������ ������ �ʹ� �����ϴ�.\n99�� �̻��� ��ü�� ���� �Ǿ����ϴ�.' );
            return;
        }
        if ( selectObj != null ) {

            ReGeTemplate (designtier); /* APLi ���̵��� ���Ӱ� �����մϴ�. */

            var innerHtml = designDocument.body.innerHTML;
            var bodyAttr  = getTagStr(innerHtml,"begin");
            var objHTML   = objStr;

    //      alert ( "All : " + objHTML );
    //      alert ( getAttr( objHTML, "style" ) );
    //      objHTML   = removeAttr   ( objHTML, "onclick" );
            objHTML   = removeAttr   ( objHTML, "ondblclick" );
            var id = "";
    //      if ( obj.id != "" ) {
    //          id = "id=\"" + obj.id + "\"";
    //      }
    //      alert ( "objHTML : " + objHTML );
            itemCnt++;

            var sItemCnt = "" + itemCnt;

            var addID    = "" + itemCnt;

            if ( sItemCnt.length < 2 ) {
                addID = "KPLi0" + sItemCnt;
            } else {
                addID = "KPLi" + sItemCnt;
            }

            id = "id=" + addID;

            if ( gubun == 'div' ) {
                if ( typeof(tagNm) != "string" || tagNm == "" ) {
                    tagNm = "div";
                } else {
                    // �ƱԸ�Ʈ�� �Ѿ�� tagNm���� �״�� �̿�
                }
            } else if ( gubun == 'child' ) {
                if ( typeof(tagNm) != "string" || tagNm == "" ) {
                    tagNm = getTagName(objHTML);
                } else {
                    // �ƱԸ�Ʈ�� �Ѿ�� tagNm���� �״�� �̿�
                }
            }

            var prop =getTagStr(objHTML,"VALUEOF");
    //      alert( prop );

            var style       = getStyle( objStr );
    //      alert ( "style in object : " + style ) ;
    //      alert ( "z-index Of style in object : " + getStyleAttr ( style, "z-index" ,2) ) ;
            var styleLeft   = ( getStyleAttr ( style, "left"    ,2) == "" ) ? "1" : getStyleAttr ( style, "left"    ,2);
            var styleTop    = ( getStyleAttr ( style, "top"     ,2) == "" ) ? "1" : getStyleAttr ( style, "top"     ,2);
            var styleZindex = ( getStyleAttr ( style, "z-index" ,2) == "" ) ? "1" : getStyleAttr ( style, "z-index" ,2);
            var dStyle  = editStyle;
            if ( dStyle.substring( dStyle.length - 1) != ";" ) {
                dStyle += ";";
            }
            dStyle += "left:"    + styleLeft    + ";";
            dStyle += "top:"     + styleTop     + ";";
            dStyle += "z-index:" + styleZindex       ;

    //      alert ( " dStyle : " +  dStyle);
    //      alert ( getAttr( objHTML) );
    //      alert ( prop );
            var insertObj  = "";
            if ( gubun == 'div' ) {
    //          insertObj  = "<" + tagNm + " " + id + " " + editScript + " style='" + dStyle + "' " + prop + " >";
                insertObj  = "<" + tagNm + " " + id + " " + editScript + " " + prop + " >";
                insertObj += objHTML;
                if ( typeof(value) == "string" ) { insertObj += value; }
                if (tagNm.toUpperCase() != "IMG" && tagNm.toUpperCase() != "INPUT" ) {
                    insertObj += "</" +  tagNm + ">";
                }
            }

            if ( gubun == 'child' ) {
    //          insertObj  = "<" + tagNm + " " + id + " " + editScript + " style='" + dStyle + "' " + prop;
                insertObj  = "<" + tagNm + " " + id + " " + editScript + " " + prop;
                if ( prop == "" ) {
                    insertObj += getAttr( objHTML );
                }

                insertObj += ">";
                if ( typeof(value) == "string" ) { insertObj += value;}

                if (tagNm.toUpperCase() != "IMG" && tagNm.toUpperCase() != "INPUT" ) {
                    insertObj += "</" +  tagNm + ">";
                }
            }

            if ( gubun == 'self' ) {
                var insertP = objHTML.indexOf (" ");
                if ( insertP > 0 ) {
                    insertObj += objHTML.substring (0, insertP) + " " + id + " " + editScript + objHTML.substring (insertP);
                }
            }
    //      alert ( " insertObj : " + insertObj );
    //      alert ( bodyAttr  );
    //      alert ( innerHtml );
             designDocument.body.innerHTML =  "<BODY " + bodyAttr + ">" + innerHtml + "" + insertObj + "</BODY>";
    //      objectMoveTo("item" + itemCnt,10,10, designtier);

            var oldId = "";
            // ���ø� ������ Add �ɰ�� ������ Object ID�� �ƴϰ� _t�� ���� ID �� Add�Ǳ⶧����
            // Id���� ����ߴٰ� AddTemplate �޼ҵ尡 ȣ��ɶ� currentOldObj ������ Object�� �Ҵ��մϴ�.
            if ( currentObj != null ) {
                oldId = currentObj.id;
//              document.Panel_MainForm.p_tpl.value += "���� currentObj Id : " + currentObj.id + "\n";
            }

            currentOldObj = currentObj;
    //      alert ( "����ň" + currentObj + " / " + itemCnt + " / " + insertObj);

            currentObj = getObject(addID, designtier);
            if ( currentObj != null ) {
//                document.Panel_MainForm.p_tpl.value += "���� currentObj Id : " + currentObj.id + "\n";
            }

            if ( selectObj != null ) {
                AddTemplate ( 1 );
            }
        } else {
            alert ( "������ �������ּ���." );
            return;
        }
    }

    var twinklingNum = 0   ;
    var timeOutId    = null;
    var twinlingObj  = null;
    var twinlingBackCss = null;

    function Add_Element1(parentObj, name, displayVal, width, height, gubun, preText ) {
        Object_TwinklingClear ();
        twinlingObj = eval(parentObj + "." + name);
        var focusGubun = "1"; // 1 : > focus �޼ҵ� �ִ� ��ü, 2 :> focus �޼ҵ尡 ���� ��ü
        if ( typeof ( twinlingObj ) == 'undefined' && typeof ( getObject(name, designtier) ) == 'object' ) {
            twinlingObj = getObject(name, designtier);
            focusGubun = "2";
        }
        if ( timeOutId == null ) {
            if ( typeof ( twinlingObj ) != "object" ) {
                if ( gubun == "input" ) {
                    appendInputBox(name, displayVal, width, height);
                } else if ( gubun == "textarea" ) {
                    appendTextAreaBox(name, displayVal, width, height);
                } else if ( gubun == "input_button" ) {
                    appendInputButton(name, preText, displayVal, width, height);
                } else if ( gubun == "input_submit" ) {
                    appendInputSubmit(name, displayVal, width, height);
                } else if ( gubun == "input_passwd" ) {
                    appendInputPasswd(name, displayVal, width, height);
                } else if ( gubun == "input_img" ) {
                    imageList2_OpenWindow ("*", "10", "4", name, "2");
                } else if ( gubun == "input_submit_img" ) {
                    imageList2_OpenWindow ("*", "10", "2", name, "2");
                } else if ( gubun == "zzook_img" ) {
                    imageList2_OpenWindow ("*", "10", "5", name, "2");
                }
                FrameResize( 1, 1, 'designPannel' );
            } else {
//              alert ( "���ø��� �̹� ���� �մϴ�.");
                if ( focusGubun == "1" ) {
                    twinlingObj.focus();
                }
                twinlingBackCss = twinlingObj.style.cssText;
                timeOutId = window.setInterval ( Object_Twinkling, 300 );
            }
        }
    }

    /* ��� ���̾� �α� ���� */
    function Add_Element2 (url, w, h, gubun, form, name, val, width, height ) {
        if ( selectObj != null ) {
            var left = ( screen.width - w ) / 1.3;
            var top  = ( screen.height- h ) / 2;
            var myObject = new Object();
            myObject.Window         = window;
            myObject.DesignForm     = form  ;
            myObject.elementName    = name  ;
            myObject.val            = val   ;
            myObject.gubun          = gubun ;
            myObject.width          = width ; // ��ü�� �⺻ ���� ����
            myObject.height         = height; // ��ü�� �⺻ ���� ����
            var searchItem = window.showModelessDialog(url, myObject, "dialogHeight: " + h + "px; dialogWidth: " +  w + "px; dialogTop: " + top + "px; dialogLeft: " + left + "px; edge: Raised; center: Yes; help: Yes; resizable: Yes; status: Yes;");
            searchItem.focus();
        } else {
            alert ( "������ �������ּ���." );
            return;
        }
    }

    function Object_TwinklingClear () {
        if ( timeOutId != null ) {
            window.clearInterval (timeOutId);
        }
        if ( twinlingBackCss != null ) {
            twinlingObj.style.cssText = twinlingBackCss;
        }
        twinlingBackCss = null;
        timeOutId = null;
        twinklingNum = 0;
    }

    function Object_Twinkling (name) {

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

        if ( twinklingNum > 8 ) {
            Object_TwinklingClear ();
            this.focus();
        }
        twinklingNum++;
    }

    function abstractSource(gubun) {
/*        if ( loadingEnd == 0 ) {
            alert ( '���ø��� �ε� ���Դϴ�. : ' + loadingEnd );
            return false;
        } else {*/
            if ( typeof ( gubun ) == "undefined" ) {
                gubun = "default";
            }
            clearALL ();                /* ��ü�� �Ҵ�Ǿ��� ���� ���� ����     */
            ReGeTemplate (designtier);  /* APLitem ���̵��� ���Ӱ� �����մϴ�.*/
            if ( tempBorderYN == "Y" ) { templateBorderRemove(); }

            var source = designDocument.body.innerHTML;
                source = clearTemplate(    source      );  /* ���ø� ������ ��ũ��Ʈ ����          */
    //          alert ( designDocument.body.innerHTML );

                source = removeTagStrs( source, 'begin' );
                source = removeTagStrs( source, 'script');
                source = source.substring ( 0, source.indexOf ( "END_TEMPLATE" ) + 16 );
                document.Panel_MainForm.p_tpl.value = source;
    //      alert ( source );
    //      alert ( save   );
//          designDocument.body.innerHTML = save;

            if ( gubun == "db" ) {
                abstractDbXML ();       /* DB���� XML ���� ���� */
            }
            return true;
//        }
    }

    function abstractDbXML () { // attribute="DB$$������ID$$�÷���$$�ڵ�$$�������̵�" ������ ���� ������
        var sStr = document.Panel_MainForm.p_tpl.value;

        var Apointer = 0;
        var Bpointer = 0;
        var attribute= null; // attribute �� ��

        var HXmlKey   = "";   // Xml Header item - ID
        var HXmlValue = "";   // Xml Header Value
        var HXmlCode  = "";   // Xml Header Code
        var HXmlLocal = "";   // Xml Header Local

        var CXmlKey   = "";   // Xml Content item - ID
        var CXmlValue = "";   // Xml Content Value
        var CXmlCode  = "";   // Xml Footer Code
        var CXmlLocal = "";   // Xml Content Local

        var FXmlKey   = "";   // Xml Footer item - ID
        var FXmlValue = "";   // Xml Footer Value
        var FXmlCode  = "";   // Xml Footer Code
        var FXmlLocal = "";   // Xml Footer Local

        var SQL       = "";   // Xml querySql

        var total    = 1 ;   // �� XML �Ӽ��� ����

        for ( var i=0; i<sStr.length; i++ ) {
            Apointer = sStr.indexOf("attribute=\"",Apointer);
            if ( Apointer > 0 ) {
                Bpointer = sStr.indexOf("\"",Apointer + 11 );
//              alert ( sStr.substring ( Apointer + 11, Bpointer ) );
                attribute = sStr.substring ( Apointer + 11, Bpointer );
                attribute = attribute.split("$$");
                if ( attribute[4].substring(2,3) == "H") {
                    HXmlKey   += "KPLi" + attribute[1] + "_t,";
                    HXmlValue += attribute[2] + ",";
                    if ( attribute[3] == "00" ) {
                        HXmlCode  += attribute[4] + ",";
                    } else {
                        HXmlCode  += attribute[3] + ",";
                    }
                }
                if ( attribute[4].substring(2,3) == "C") {
                    CXmlKey   += "KPLi" + attribute[1] + "_t,";
                    CXmlValue += attribute[2] + ",";
                    if ( attribute[3] == "00" ) {
                        CXmlCode  += attribute[4] + ",";
                    } else {
                        CXmlCode  += attribute[3] + ",";
                    }
                }
                if ( attribute[4].substring(2,3) == "F") {
                    FXmlKey   += "KPLi" + attribute[1] + "_t,";
                    FXmlValue += attribute[2] + ",";
                    FXmlCode  += attribute[3] + ",";
                    if ( attribute[3] == "00" ) {
                        FXmlCode  += attribute[4] + ",";
                    } else {
                        FXmlCode  += attribute[3] + ",";
                    }
                }
                if ( SQL.indexOf(attribute[2]) < 0 ) { SQL += ( attribute[2] + "," ); }
                total++;
            } else {
                break;
            }
            Apointer++;
        }

        HXmlKey   = HXmlKey.substring   ( 0, HXmlKey.length   - 1);
        HXmlValue = HXmlValue.substring ( 0, HXmlValue.length - 1);
        HXmlCode  = HXmlCode.substring  ( 0, HXmlCode.length  - 1);

        CXmlKey   = CXmlKey.substring   ( 0, CXmlKey.length   - 1);
        CXmlValue = CXmlValue.substring ( 0, CXmlValue.length - 1);
        CXmlCode  = CXmlCode.substring  ( 0, CXmlCode.length  - 1);

        FXmlKey   = FXmlKey.substring   ( 0, FXmlKey.length   - 1);
        FXmlValue = FXmlValue.substring ( 0, FXmlValue.length - 1);
        FXmlCode  = FXmlCode.substring  ( 0, FXmlCode.length  - 1);

        SQL       = SQL.substring ( 0, SQL.length - 1);

        setValue1 ( document.Panel_MainForm.p_h_xml_key  ,HXmlKey   );
        setValue1 ( document.Panel_MainForm.p_h_xml_value,HXmlValue );
        setValue1 ( document.Panel_MainForm.p_h_xml_code ,HXmlCode  );
        setValue1 ( document.Panel_MainForm.p_c_xml_key  ,CXmlKey   );
        setValue1 ( document.Panel_MainForm.p_c_xml_value,CXmlValue );
        setValue1 ( document.Panel_MainForm.p_c_xml_code ,CXmlCode  );
        setValue1 ( document.Panel_MainForm.p_f_xml_key  ,FXmlKey   );
        setValue1 ( document.Panel_MainForm.p_f_xml_value,FXmlValue );
        setValue1 ( document.Panel_MainForm.p_f_xml_code ,FXmlCode  );
        setValue1 ( document.Panel_MainForm.p_sql        ,SQL       );

    }

     function setValue1 (obj, value){
        if ( typeof ( obj ) == 'object' ) {
                obj.value = value;
        } else {
            alert ( "JavaScript ���� �߻�1 +" + obj );
        }
    }
    /* Form Element�� ���� ���ɴϴ�. */
    function getValue1 (obj){
        if ( typeof ( obj ) == 'object' ) {
            return obj.value;
        } else {
            alert ( "JavaScript ���� �߻�2 + " + obj );
            return '';
        }
    }

    function Source() {
        document.Panel_MainForm.p_tpl.value = designDocument.body.innerHTML;
    }

    function viewID () {
        if ( selectObj  != null ) { document.Panel_MainForm.p_tpl.value  = selectObj.id  + "\n"; }
        if ( currentObj != null ) { document.Panel_MainForm.p_tpl.value += currentObj.id + "\n"; }
    }

    /* ���ø� ������ ��ũ��Ʈ ���� */
    function clearTemplate(allSource) {
        for (var i=1;i<=H_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
//          removeAttrWrite( "p_H" + nm, "onmousedown", designtier);
//          removeAttrWrite( "p_H" + nm, "onmouseover", designtier);
//          removeAttrWrite( "p_H" + nm, "onmouseup"  , designtier);
//          var tagStr = getTagStrById  ( "p_H" + nm, designtier);
            var obj = getObject("p_H" + nm, designtier);
            var innerTagStr = obj.innerHTML;
            var tagStr = "<DIV id=p_H" + nm + ">" + innerTagStr + "</DIV>";
            allSource = replaceTagStrById("p_H" + nm, tagStr, "",allSource);
        }
        for (var i=1;i<=C_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
            var obj = getObject("p_C" + nm, designtier);
            var innerTagStr = obj.innerHTML;
            var tagStr = "<DIV id=p_C" + nm + ">" + innerTagStr + "</DIV>";
            allSource = replaceTagStrById("p_C" + nm, tagStr, "",allSource);
        }
        for (var i=1;i<=F_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
            var obj = getObject("p_F" + nm, designtier);
            var innerTagStr = obj.innerHTML;
            var tagStr = "<DIV id=p_F" + nm + ">" + innerTagStr + "</DIV>";
            allSource = replaceTagStrById("p_F" + nm, tagStr, "",allSource);
        }

        var cnt = 0;
        for (var i=1; i<=itemCnt;i++ ) {
//       alert ( 'clearTemplate - 4' );
            var addID    = "" + i;

            if ( addID.length < 2 ) {
                addID = "KPLi0" + i;
            } else {
                addID = "KPLi" + i;
            }
            addID = addID + "_t";

            var outerTagStr = getTagStrById(addID, "", allSource);
            if ( outerTagStr != "" ) {
                cnt++
                outerTagStr = removeAttr( outerTagStr, "id"         );
                outerTagStr = removeAttr( outerTagStr, "onmousedown");
                outerTagStr = removeAttr( outerTagStr, "onmouseover");
                var addID1    = "" + cnt;

                if ( addID1.length < 2 ) {
                    addID1 = "KPLi0" + cnt;
                } else {
                    addID1 = "KPLi" + cnt;
                }
                addID1 = addID1 + "_t";
                outerTagStr = addAttr   ( outerTagStr, "id", addID1 );
                allSource = replaceTagStrById(addID1, outerTagStr, "", allSource);
            }
        }
        return allSource;
    }

    /* ���ø� ������ ��ũ��Ʈ ���� */
    function clearTemplateStr (allHtml,H_count,C_count,F_count) {
//      alert ( H_count + ' ; ' + C_count + ' ; ' + F_count +"\n" + allHtml);
        var htmlStr = allHtml;
        for (var i=1;i<=H_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
            var innerTagStr = getInnerStrById  ( "p_H" + nm, "", htmlStr);
            var tagStr      = "<DIV id=p_H" + nm + ">" + innerTagStr + "</DIV>";
            htmlStr = replaceTagStrById("p_H" + nm, tagStr, "", htmlStr);
        }

        for (var i=1;i<=C_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
            var innerTagStr = getInnerStrById  ( "p_C" + nm, "", htmlStr);
            var tagStr      = "<DIV id=p_C" + nm + ">" + innerTagStr + "</DIV>";
            htmlStr = replaceTagStrById("p_C" + nm, tagStr, "", htmlStr);
        }

        for (var i=1;i<=F_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
            var innerTagStr = getInnerStrById ( "p_F" + nm, "", htmlStr);
            var tagStr      = "<DIV id=p_F" + nm + ">" + innerTagStr + "</DIV>";
            htmlStr = replaceTagStrById("p_F" + nm, tagStr, "", htmlStr);
        }
//        alert ( htmlStr );
        return htmlStr;
    }

    function ReGeTemplate (tier) {

        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        obj = eval( docStr );

        var sStr = obj.body.innerHTML;
        var pointer = 0;
        var itemNum = 0;
        var itemNumStr = "";
        var dbPointer = 0;
        var skPointer = 0;
        var itPointer = 0;
        var thPointer = 0;
//            alert ( sStr.length + " " + sStr );
        for ( var i=0; i<sStr.length; i++ ) {
            pointer = sStr.indexOf("KPLi",pointer);
            if ( pointer > 0 ) {
                itemNum++;
                var addID    = "";
                if ( itemNum < 10 ) {
                    itemNumStr = "0" + itemNum;
                } else {
                    itemNumStr = itemNum;
                }

                addID = "KPLi" + itemNumStr + "_t";
//              alert ( itemNumStr );
// KPLitem01_t :> KPLi01_t
//              alert ( "s:" + sStr.substring( pointer, pointer + 11 ) + ":e");
                var id = sStr.substring( pointer, pointer + 8 );
                var id = id.substring ( 4, 6 );
                sStr = sStr.substring(0,pointer) + addID + sStr.substring(pointer + 8)

                var addDbID    = "";
                dbPointer = sStr.indexOf("DB$$", pointer) + 4;
                skPointer = sStr.indexOf("SK$$", pointer) + 4;
                itPointer = sStr.indexOf("IT$$", pointer) + 4;

                if ( dbPointer > 4 ) { thPointer = dbPointer; }
                if ( skPointer > 4 ) { thPointer = skPointer; }
                if ( itPointer > 4 ) { thPointer = itPointer; }

                if ( thPointer > 4 ) {
                    var dbAttr = sStr.substring(thPointer,sStr.indexOf ( ">" , thPointer ) - 1);
                    dbAttr = dbAttr.split("$$"); // 01$$User_Id$$01$$p_C02

                    /* �������� ���̵� ���� ���� �մϴ�. */
                    if ( dbAttr[1] == "tab" ) { pageTabSelectID = dbAttr[3];}

                    addDbID = itemNumStr + "$$" + dbAttr[1] + "$$" + dbAttr[2] + "$$" + dbAttr[3];
                    sStr = sStr.substring(0,thPointer) + addDbID + sStr.substring(sStr.indexOf ( ">" , thPointer ) - 1 );
//                  alert ( "s:" + id + ":e / " + addID + " / " + addDbID + " / " + pointer + "\n" + sStr );
                }
                thPointer = 0; // �ʱ�ȭ.. �̰Ͷ��� ���ڰ� ��������.. �� �ʱ�ȭ�ؾ���..
//          alert ( sStr.length + " " + sStr );
            } else {
                break;
            }
            pointer++;
        }
        itemCnt = itemNum;
        setValue1 ( document.Panel_MainForm.p_item_cnt, itemCnt );
        obj.body.innerHTML = sStr;
    }


    function AddTemplate( key, AreaObj ) {
//        if ( currentObj == null ) { alert ( "������ ��Ҹ� �������ּ���." );  return; }
//        if ( selectObj  == null ) { alert ( "������ ���� ���ּ���." )      ;  return; }
        if ( ( designMode == 1 && currentObj != null && currentObj.id.indexOf("KPLi") >= 0 && currentObj.id.indexOf("_t") < 0 ) || ( key != null && key == "1" ) ) {
//          document.Panel_MainForm.p_tpl.value += "AddTemplate1\n";
//          document.Panel_MainForm.p_tpl.value += "key : " + key + "\n";
//          selectObj = getObject( selectObj.id, designtier);

            var innerValue = currentObj.innerHTML;

            var outerValue = getTagStrById(currentObj.id, designtier);

//          alert ( "innerValue Value : " + innerValue );
//          alert ( "outerValue Value : " + outerValue );
            var tagName = getTagName( innerValue );
//          alert ( obj.style.backgroundColor );

//          alert ( "innerValue Tag Name : " + innerValue );
//          alert ( "outerValue Tag Name : " + getTagName(outerValue) );

            var style = getStyle ( outerValue );
//          alert ( "Style : " + style );

            style = removeStyleAttr ( style,"left"      );
            style = removeStyleAttr ( style,"top"       );
            style = removeStyleAttr ( style,"position"  );
//          alert ( "RemoveStyle : " + style );
//          alert ( "outerValue : " + outerValue );
//          alert ( "�±��� ��ü �Ӽ� : " + getAttr(outerValue) );
//          alert ( "��Ÿ���� ������ �Ӽ� : " + removeAttr(outerValue, "style") );

            var objStr = "";
            if ( tagName != "" && getTagName(outerValue).toUpperCase() != "SELECT" ) {
                objStr = innerValue;
            } else {
                objStr = outerValue;
            }

            var innerStyle = getStyle ( innerValue );
//          alert ( "innerStyle : " + innerStyle );

            objStr = removeAttr (objStr, "style"      );
            style += innerStyle;

            if ( style != "" ) {
                if ( style.substring( style.length - 1) != ";" ) {
                    style += ";";
                }
            }

            /* style += "position:relative;left:0;top:0;z-index:1"; */

            style += "position:relative;left:0;top:0;z-index:1";

            objStr = removeAttr (objStr, "onmousedown");

            /* IFrame Add�� id=innerFrame ���ڿ��� ������� �ʰ� */
            if (objStr.indexOf ( "id=innerID" ) <= 0 ) {
                objStr = removeAttr (objStr, "id"         );
//              alert ( "There ~~" );
            }

//          alert ( "style : " + style );

            objStr = addAttr  ( objStr, "style", style  );
            objStr = addString( objStr, editScript      );
            objStr = addAttr( objStr, "id", currentObj.id + '_t'  );

            attribute = getAttr( objStr, "attribute" );

            /* �� �κ��� objStr�� �Ҵ��ϴ� ���� �Ʒ��� ��ġ�ؾ� �մϴ�. �׷��� �ʴٸ� �����߻��� */
            // DB���� �׸��� Add�� ���
            // SK���� �׸��� Add�� ���
            if ( attribute.substring(0,2) == "DB" || attribute.substring(0,2) == "SK" || attribute.substring(0,2) == "IT" ) {
//              alert ( attribute + " : " + selectObj.id ) ;
                attribute = attribute + "$$" + selectObj.id;
                objStr = setAttr ( objStr, "attribute", attribute );
            }

//          var objStr  = addString( getTagStrById( id_str, designtier), script);
//          alert ( " objStr : " + objStr );
//          replaceTagStrWriteById(id_str,objStr, designtier);

//          selectObj.innerHTML = objStr;
//          objectHide(currentObj);
            replaceTagStrWriteById(currentObj.id, "", designtier);
//          objectHide( currentObj.id, designtier )

            setTagStrById(selectObj.id, objStr, designtier);    // innerHMTL���� �̿��� ��� Error�� ���� ��ġ
//          alert ( objStr );
//          alert ( selectObj.id + "\n SS : " + selectObj.innerHTML );

            currentObj = getObject( currentObj.id + '_t', designtier);

//          FrameResize( 100,100,'designPannel' );
            FrameResize( 1,1,'designPannel' );
        } else if ( designMode == 1 && currentObj != null && currentObj.id.indexOf("KPLi") >= 0 && currentObj.id.indexOf("_t") >= 0 ) {
//          document.Panel_MainForm.p_tpl.value += "AddTemplate2\n";
//          alert ( '���� ' + selectObj.id  + " / " + selectOldObj.id );
            var selectOldID = ( selectOldObj == null ) ? "" : selectOldObj.id;
            if ( selectObj.id != selectOldID ) {

                var outerValue = getTagStrById(currentObj.id, designtier);
                var tagName = getTagName( outerValue );

                var style = getStyle ( outerValue );
                if ( style != "" ) { style += ";"; }
                style += "position:relative;left:0;top:0;z-index:1";
                outerValue = removeAttr ( outerValue, "style"       );
                outerValue = addAttr    ( outerValue, "style", style);

                replaceTagStrWriteById(currentObj.id, "", designtier);

                attribute = getAttr( outerValue, "attribute" );
                /* �� �κ��� objStr�� �Ҵ��ϴ� ���� �Ʒ��� ��ġ�ؾ� �մϴ�. �׷��� �ʴٸ� �����߻��� */
                // DB���� �׸��� Add�� ���
                // SK���� �׸��� Add�� ���
                if ( attribute.substring(0,2) == "DB" || attribute.substring(0,2) == "SK"  || attribute.substring(0,2) == "IT" ) {
                    attribute = attribute.substring ( 0, attribute.lastIndexOf ("$$") );
                    attribute = attribute + "$$" + selectObj.id;
                    outerValue = setAttr ( outerValue, "attribute", attribute );
                }

                setTagStrById(selectObj.id, outerValue, designtier);    // innerHMTL���� �̿��� ��� Error�� ���� ��ġ
                selectOldObj  = selectObj;
//              FrameResize( 100,100,'designPannel' );
                if ( currentObj != null && currentOldObj != null && currentObj.id != currentOldObj.id ) {
                    DesignMode(); // ������ ��� ���·� ���ͽ�Ŵ
                }
                // FrameResize( 1,1,'designPannel' );
            }
        }
    }


    var designMode = 0; // 1 : �̵�, 0 : ������

    function DesignMode() {

        var obj = getObject("move");
        // �̵�, �������� ��� �̸�..
        // ��ġ �� ���������� ���� �Ҵ�Ǿ� ó�� �˴ϴ�.

        if ( designMode == 0 ) {// ������ ����� ��� �̵� ����
            obj.innerHTML = "<U>�̵�</U>";
            clearSelect ( selectObj );
            HideMenu();
            designMode++;
            currentOldObj = currentObj;
        } else if ( designMode == 1 ) { // �̵� ����� ��� ������ ����
            obj.innerHTML = "<U><FONT color='red'>������</FONT></U>";
            designMode--;
        }
    }

    // gubun : display : ��ġ ���� ���̰�, clear : ��ġ ���� ����
    var displaylocation = "clear";
    function displayLocation () {
        var obj = getObject("loca");
        if ( displaylocation == "display" ) {
            displaylocation = "clear";
            obj.innerHTML = "<U>��ġ �Ⱥ���</U>";
        } else if ( displaylocation == "clear" ) {
            displaylocation = "display";
            obj.innerHTML = "<U>��ġ ����</U>";
        }
        for (var i=1;i<=H_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
            var obj = getObject("p_H" + nm , designtier);
            if ( displaylocation == "display" ) {
                obj.style.backgroundImage  = "url(/zzook/image/newadmin/header_icon.gif)";
                obj.style.backgroundRepeat = "no-repeat";
            } else if ( displaylocation == "clear" ) {
                obj.style.backgroundImage  = "";
                obj.style.backgroundRepeat = "";
            }
        }

        for (var i=1;i<=C_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
            var obj = getObject("p_C" + nm , designtier);
            if ( displaylocation == "display" ) {
                obj.style.backgroundImage  = "url(/zzook/image/newadmin/circle_icon.gif)";
                obj.style.backgroundRepeat = "no-repeat";
            } else if ( displaylocation == "clear" ) {
                obj.style.backgroundImage  = "";
                obj.style.backgroundRepeat = "";
            }
        }

        for (var i=1;i<=F_count;i++ ){
            var nm = i;
            if ( i < 10) { nm = "0" + i;  }
            var obj = getObject("p_F" + nm , designtier);
            if ( displaylocation == "display" ) {
                obj.style.backgroundImage  = "url(/zzook/image/newadmin/bottom_icon.gif)";
                obj.style.backgroundRepeat = "no-repeat";
            } else if ( displaylocation == "clear" ) {
                obj.style.backgroundImage  = "";
                obj.style.backgroundRepeat = "";
            }
        }
    }

    /* ���� �ʱ�ȭ */
    function clearSelectObj (obj) {
        if ( obj != null) {
            if (selectObj != null ) {
                selectObj = getObject(selectObj.id, designtier);
//              document.Panel_MainForm.p_tpl.value += "clearSelectObj('" + selectObj.id + "')\n";
                selectObj.style.borderStyle ="dashed";
                selectObj.style.borderWidth ="0";
                selectObj.style.borderColor ="white";
//              selectObj.style.cssText = "BORDER-RIGHT: white 0px dashed; BORDER-TOP: white 0px dashed; LEFT: 0px; BORDER-LEFT: white 0px dashed; WIDTH: 100%; BORDER-BOTTOM: white 0px dashed; POSITION: relative; TOP: 0px; HEIGHT: 100%; BACKGROUND-COLOR: transparent";
//              document.Panel_MainForm.p_tpl.value += selectObj.style.cssText;
//              alert ( selectObj.style.cssText );
            }
        }
    }

    function clearSelect (obj) {
        if ( obj != null ) {
            obj = getObject(obj.id, designtier);
//          document.Panel_MainForm.p_tpl.value += "clearSelect('" + obj.id + "')\n";
            obj.style.borderStyle ="dashed";
            obj.style.borderWidth ='0';
            obj.style.borderColor ="white";
        }
    }

    /* ���� �ʱ�ȭ */
    function clearSelectFocusObj (obj) {
        if ( obj != null) {
            if ( selectObj == null && ( selectFocusObj != null && obj.id != selectFocusObj.id ) ||
               ( selectObj != null && selectFocusObj != null && selectObj.id != selectFocusObj.id ) ) {
                selectFocusObj.style.borderStyle ="dashed";
                selectFocusObj.style.borderWidth ='0';
                selectFocusObj.style.borderColor ="white";
            }
        }
    }

    function setArea( obj, eventName, data ) {
//      document.Panel_MainForm.p_tpl.value += "setArea ('" + obj.id + "','" + eventName + "','" + data + "')\n";
        if ( eventName == "active" ) {
            if ( data != null && data == "data" )
            {
                objectGB = "2";
                clearSelectObj ( obj );
                obj.style.borderStyle ="dashed";
                obj.style.borderWidth ='2';
                obj.style.borderColor ="red";
                selectOldObj = selectObj;
                selectObj = obj;
            } else if ( data != null && data == "view" ) {
                clearSelectFocusObj ( obj );
                if ( obj != null ) {
                    if ( ( selectObj != null && selectObj.id != obj.id ) || selectObj == null ) {
                        obj.style.borderStyle ="dashed";
                        obj.style.borderWidth ='1';
                        obj.style.borderColor ="blue";
                        selectFocusObj = obj;
                    }
                }
            }
        }
//      document.Panel_MainForm.p_tpl.value += " setArea / objectGB : '" + objectGB + "')\n";
    }

    function clearALL () {
        clearSelect (selectObj     );
        clearSelect (selectOldObj  );
        clearSelect (selectFocusObj);
//        clearCurrent(dragObj        );  /* Darg     OBJECT */
//        clearCurrent(currentObj     );  /* ����     OBJECT */
//        clearCurrent(currentFocusObj);  /* ��Ŀ��   OBJECT */

        selectObj       = null;
        selectOldObj    = null;
        selectFocusObj  = null;
//        dragObj         = null;
//        currentObj      = null;
//        currentFocusObj = null;

//      clearCurrent(currentOldObj  );  /* ����     OBJECT */
    }

    /* �� �Է� �� ���������� ������ ��� */
    function contentInputPopUp(content) {
        var contentWin = window.open("/zzook/jsp/common/ContentInput.jsp","ContentWin",'width=400, height=320,status=no, menubar=no, resizable=yes');
        contentWin.focus();
    }

    /* ��Ų �̸����� */
    function skinPreViewPopUp(gubun,skinId,subSkinId) {
//      var preViewWin = window.open("/zzook/jsp/common/SkinPreView.jsp?p_gubun=" + gubun,"SkinPreViewWin",'width=400, height=320,status=no, menubar=no, resizable=yes');
//        gubun     = 'bbs';
        if ( typeof( skinId    ) == 'undefined' ) { skinId    = ""; }
        if ( typeof( subSkinId ) == 'undefined' ) { subSkinId = ""; }

        var preViewWin = window.open("/zzook/jsp/common/SkinPreView.jsp?p_gubun=" + gubun + "&p_skin_id=" + skinId + "&p_sub_skin=" + subSkinId ,"SkinPreViewWin",'width=400, height=320,status=no, menubar=no, resizable=yes');
//        var preViewWin = window.open("/zzook/jsp/common/SkinPreView.jsp?p_gubun=" + gubun + "&p_skin_id=" + skinId + "&p_sub_skin=" + subSkinId ,"SkinPreViewWin",'');
        preViewWin.focus();
    }

    function designCommander(gubun, commander, value ) {

        if ( gubun == '1' ) {
//          designWindow.focus();
            // DIRECTION=RIGHT BEHAVIOR=slide  SCROLLAMOUNT=10 SCROLLDELAY=1 loop=1
            var obj = null;
            if ( objectGB == "1" ) {
                obj = currentObj;
//                alert ( objectGB  + " / " + currentObj.id );
            } else if ( objectGB == "2" ) {
                obj = selectObj;
//                alert ( objectGB  + " / " +  selectObj.id + " / " + selectObj.id.substring(2) );
                obj = getObject( obj.id.substring(2), designtier );
            }
            if ( contentSelected == 1 ) {
                designDocument.execCommand(commander, 0, value);
            } else {
                if ( commander == 'Cut' || commander == 'Copy' ) {
                    if ( currentObj == null || typeof ( currentObj.copytype ) == "undefined" ||
                         currentObj.copytype != "none" ) {
                        designDocument.execCommand(commander, 0, value);
                    }
                } else {
                    if ( obj.tagName.toUpperCase() == "DIV" ) {
                        if ( commander == 'JustifyLeft' ) {
                            obj.align= 'left';
                        } else if ( commander == 'JustifyRight' ) {
                            obj.align= 'right';
                        } else if ( commander == 'JustifyCenter') {
                            obj.align= 'center';
                        } else {
                            designDocument.execCommand(commander, 0, value);
                        }
                    } else if ( obj.tagName.toUpperCase() == "INPUT" ) {
                        if ( commander == 'JustifyLeft' ) {
                            obj.style.textAlign = 'left';
                        } else if ( commander == 'JustifyRight' ) {
                            obj.style.textAlign = 'right';
                        } else if ( commander == 'JustifyCenter') {
                            obj.style.textAlign = 'center';
                        } else {
                            designDocument.execCommand(commander, 0, value);
                        }
                    } else {
                        designDocument.execCommand(commander, 0, value);
                    }
                }
            }
        } else if ( gubun == '2' ) {
            changeFont( commander, value );
        }

        return false; /* Ŭ�� �̺�Ʈ ���� */
    }

    /* Object ũ�� ���� */
    function resizeStart(command,size) {
        timeOutId = window.setInterval ( "ExecCommand('" + command + "'," + size + ")", 100 );
    }

    function resizeEnd () {
        window.clearInterval ( timeOutId );
        timeOutId = null;
    }

    function changeFont( attr, value ) {
        if ( contentSelected == '1' ) {
//          alert ( attr + " / "  + parseInt ( value ) ) ;
            designDocument.execCommand(attr, 0, value );
        } else if ( contentSelected == '0' ) {
            var obj = null;
            if ( objectGB == "1" ) {
                obj = currentObj;
            } else if ( objectGB == "2" ) {
                obj = selectObj;
                obj = getObject( obj.id.substring(2), designtier );
            }
            if ( attr == 'FontName' ) {
                attr = 'fontFamily';
            } else if ( attr == 'FontSize' ) {
                attr = 'fontSize';
            }
//          alert ( "obj.style." + attr + "='" + value + "'" );
            eval( "obj.style." + attr + "='" + value + "'");
        }
    }

    function bbsSkinPopUp(procCd) {
//      var contentWin = window.open("A_BbsSkinPopup.jsp?p_proc_cd=" + procCd,"BbsWin");
        var contentWin = window.open("A_BbsSkinPopup.jsp?p_proc_cd=" + procCd,"BbsWin",'width=550, height=340,left=150,top=150, scrollbar=yes, status=no, menubar=no, resizable=yes');
        contentWin.focus();
    }

    function bbsSkinBoxPopUp(procCd) {
//      var contentWin = window.open("A_BbsSkinPopup.jsp?p_proc_cd=" + procCd,"BbsWin");
        var contentWin = window.open("/zzook/jsp/newadmin/bbs/A_BbsSkinBoxPopup.jsp?p_proc_cd=" + procCd,"BbsWin",'width=550, height=320,left=150,top=150,scrollbar=yes, status=no, menubar=no, resizable=yes');
        contentWin.focus();
    }

    function bbsInforPopUp(type,procCd,mainMenuCd,subMenuCd) {
        if (typeof(type      ) == "undefined") { type       = "*"   }
        if (typeof(procCd    ) == "undefined") { procCd     = "*"   }
        if (typeof(mainMenuCd) == "undefined") { mainMenuCd = "*"   }
        if (typeof(subMenuCd ) == "undefined") { subMenuCd  = "*"   }
        var url = "/zzook/jsp/newadmin/bbsinfor/A_BbsInforPopUp.jsp";
            url+= "?p_type="        + type ;
            url+= "&p_proc_cd="     + procCd;
            url+= "&p_main_menu_cd="+ mainMenuCd;
            url+= "&p_sub_menu_cd=" + subMenuCd;
//          alert ( url );
//        var contentWin = window.open("/zzook/jsp/newadmin/bbsinfor/A_BbsInforPopUp.jsp?p_proc_cd=" + procCd,"BbsWin");
        var contentWin = window.open(url,"BbsWin",'width=600, height=450,left=150,top=150,scrollbar=yes, status=no, menubar=no, resizable=yes');
        contentWin.focus();
    }

//-->