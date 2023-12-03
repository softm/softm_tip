    /* �±� ���ڿ� ���� ��ҷ� include�� �±��� �Ӽ��� ��ȯ*/
    function getTagStr( str, delim1) {
        var tagContent = "";
        if ( str.toUpperCase().indexOf ( delim1.toUpperCase() ) >= 0 ) {
            if ( typeof (str) == "string" && typeof (delim1) == "string" ) {
                tagEnd = str.indexOf( ">",str.toUpperCase().indexOf( delim1.toUpperCase() ) )
                var tagContent = str.substring( str.toUpperCase().indexOf( delim1.toUpperCase() ) + delim1.length, tagEnd );
            }
        }
        return tagContent
    }

    /* �±� ���ڿ����� �±׸��� ���� �մϴ�. */
    function getTagName( tagStr ) {
        var tagName = "";
        var tagAttr = tagStr.split( " " );
        for ( var i=0;i<tagAttr.length; i++){
            if ( tagAttr[i].indexOf("<") >= 0 ) {
                tagName = tagAttr[i];
                break;
            }
        }
        if ( tagName != "") {
            tagName = tagName.substring(1);
        }
        return tagName;
    }

    function getPointer(id,str) {
        var tagStr = "";
        var pointer = "";
        if ( typeof(str) != "string" ) {
            str = document.body.innerHTML;
        }
        var id1 = 'id="' + id + '"';
        var id2 = "id='" + id + "'";
        var id3 = "id="  + id      ;
        var delim = "";
        var id_str = "";
        if ( str.toUpperCase().indexOf(id1.toUpperCase()) > 0 ) {
            delim = '"';
            id_str = id1;
            
        } else if ( str.toUpperCase().indexOf(id2.toUpperCase()) > 0 ) {
            delim = "'";
            id_str = id2;
        } else if ( str.toUpperCase().indexOf(id3.toUpperCase()) > 0 ) {
            delim = "";
            id_str = id3;
        }

        if ( id_str != "" ) {
//            var pre = str.indexOf(id_str);
//            var aft = str.lastIndexOf(id_str);
            var pre = str.toUpperCase().search(id_str.toUpperCase() + "( |>)");
//                var aft = str.search(id_str + "item( |>)")
//            var preStr = str.substring(0         , aft);
            var preStr = str.substring(0         , pre );

            var aftStr = str.substring(pre, str.length);

            pre = preStr.lastIndexOf("<");
            preStr = preStr.substring(pre);

            var TAG = getTagName( preStr );
//            alert ( preStr );
//            alert ( aftStr );
            var s = 0;
            var e = 0;
            var tmpStr = "";

            var endTagPosition = 2 + TAG.length + 1;

//            var endTagPosition = 2 + TAG.length;

            s = aftStr.indexOf(">") + 1;    // �±� ���� �κ��� ������ ��) "<div ~~~ >"
            preStr += ( aftStr.substring( 0, s ) );
            aftStr = aftStr.substring(s); // �±� ���� ������ ���ڿ� .......
            e = aftStr.toUpperCase().indexOf ( "</" + TAG.toUpperCase() );
            e = e + endTagPosition;
            tmpStr = aftStr.substring(0, e);

            var includeTagCount = InStrCounter ( tmpStr.toUpperCase(), "<" + TAG.toUpperCase() ) + 1;
//          alert ( "���Ե� �±� ���� : " + includeTagCount );

//          alert ( "���Ե� �±� ���� : " + includeTagCount );
            var end_p = 0;
            for ( var i=0; i<includeTagCount;i++) {
                end_p = aftStr.toUpperCase().indexOf("</" + TAG.toUpperCase(), end_p);
                if (i != includeTagCount - 1) {
                    end_p++;
                }
//            i = e;
//            alert("end pointer : " + end_p);
            }
            // NetScape�� ��� �±� ������ ���� <img> ~~ </img>�� html�ڵ带 ��� �ϴ���
            // innerHTML������ �ٽ� �о� �帱��쿡�� <img>���� �����ϴ� ������ �ذ��� ����
            if (TAG.toUpperCase() == "IMG" || TAG.toUpperCase() == "INPUT" ) {
                aft = pre + preStr.length;
            } else {
                // ���� for���� �������� �±��� ���������� ���� ������ Ʋ���� ������ ��ȯ
                if ( end_p < 0 ) {
                    return preStr;
                } else {
                    aftStr = aftStr.substring(0,end_p);
                }
                aft = pre + preStr.length + end_p + endTagPosition;
            }

//            alert ("preStr :" + preStr );
//            alert ("aftStr :" + aftStr );
//            alert ("tmpStr :" + tmpStr + " / " + e + " / " + endTagPosition );
//           tagStr = preStr + aftStr;
            if (TAG.toUpperCase() == "IMG" || TAG.toUpperCase() == "INPUT" ) {
                aft = pre + preStr.length;
            } else {
                aft = pre + preStr.length + end_p + endTagPosition;
            }

//          alert ( pre + preStr.length + " / " + end_p + " / " + endTagPosition );
//          alert ( "str :start : " + str.substring(pre,aft) );
            pointer = pre + "," + aft;
//          alert ( pointer + " / " + aft);

        } else {
            pointer = "0,0";
        }
        return pointer;
    }

    function getTagStrById(id, tier, allHtml ) {

        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            if ( tier == "" || tier == null ) {
                tier = "window";
            }
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        obj = eval( docStr );
        var str = "";
        if ( typeof ( allHtml ) == "undefined" ) {
            str = obj.body.innerHTML;
        } else {
            str = allHtml;
        }
        var Pointer = getPointer(id,str)
        Pointer = Pointer.split(",");
        var s = parseInt( Pointer[0] );
        var e = parseInt( Pointer[1] );

        var attr = str.substring(s,e);
        return attr;
    }

    function getInnerStrById(id, tier, allHtml ) {
        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            if ( tier == "" || tier == null ) {
                tier = "window";
            }
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        obj = eval( docStr );
        var str = "";
        if ( typeof ( allHtml ) == "undefined") {
            str = obj.body.innerHTML;
        } else {
            str = allHtml;
        }

        var Pointer = getPointer(id,str)
        Pointer = Pointer.split(",");
        var s = parseInt( Pointer[0] );
        var e = parseInt( Pointer[1] );

        var outerValue = str.substring(s,e);

        var tagNm = getTagName( outerValue );
        s = outerValue.indexOf(">");
        e = outerValue.lastIndexOf("<");

        var attr = "";
        if ( s + 1 == e ) {
            attr = "";
        } else {
            attr = outerValue.substring( s + 1, e );
        }
//      alert ( ( s ) + " / " + ( e ) + "\n" + outerValue + "\n" + attr );
        return attr;
    }

    function removeTagStrById(id, tier, allHtml ) {

        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            if ( tier == "" || tier == null ) {
                tier = "window";
            }
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        obj = eval( docStr );
        var str = "";
        if ( typeof ( allHtml ) == "undefined") {
            str = obj.body.innerHTML;
        } else {
            str = allHtml;
        }

        var Pointer = getPointer(id,str)
        Pointer = Pointer.split(",");
        var s = parseInt( Pointer[0] );
        var e = parseInt( Pointer[1] );
        var attr = str.substring(0, s) + str.substring(e);
        return attr;
    }

    function setTagStrById(id, val, tier) {
        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        obj = eval( docStr );
        var str = obj.body.innerHTML;
        var Pointer = getPointer(id,str)
        Pointer = Pointer.split(",");
        var s = parseInt( Pointer[0] );
        var e = parseInt( Pointer[1] );

        var outerValue = str.substring(s,e);

        var tagNm = getTagName( outerValue );
        var sStr = outerValue.substring( 0, outerValue.indexOf(">") + 1);
//      var eStr = outerValue.substring( outerValue.indexOf("<",1) );
        var eStr = "";
            if  ( outerValue.lastIndexOf("<") > 0 ) {
                eStr  = outerValue.substring( outerValue.lastIndexOf("<") );
            }
//        alert ( "sStr : " + sStr ) ;
//        alert ( "eStr : " + eStr ) ;

        val = sStr + val + eStr;
        var attr = str.substring(0, s) + val + str.substring(e);
        obj.body.innerHTML = attr;
//      alert ( obj.body.innerHTML );

    }

    function replaceTagStrWriteById(id, tagStr, tier) {

        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        obj = eval( docStr );

        var str = obj.body.innerHTML;
        var Pointer = getPointer(id,str)
        Pointer = Pointer.split(",");
        var s = parseInt( Pointer[0] );
        var e = parseInt( Pointer[1] );
        var attr = str.substring(0, s) + tagStr + str.substring(e);
        obj.body.innerHTML = attr;
    }


    function replaceTagStrById(id, tagStr, tier, allHtml) {

        var docStr = "";
        var obj    = null;
        if ( typeof(tier) == "string" ) {
            if ( tier == "" || tier == null ) {
                tier = "window";
            }
            docStr = tier + "." + "document";
        } else {
            docStr = "document";
        }

        obj = eval( docStr );
        var str = "";
        if ( typeof ( allHtml ) == "undefined") {
            str = obj.body.innerHTML;
        } else {
            str = allHtml;
        }

        var Pointer = getPointer(id,str)
        Pointer = Pointer.split(",");
        var s = parseInt( Pointer[0] );
        var e = parseInt( Pointer[1] );
        var attr = str.substring(0, s) + tagStr + str.substring(e);
        return attr;
    }

    /* html delim1���� ������ �±׸��� �ٿ��� ��ȯ */
    function getTagStrs( allStr, delim1) {
        var attr   = "";
        var preStr = "";
        var aftStr = "";

        var pre = 0;
        var aft = 0;
        var upperStr = allStr.toUpperCase();
        var tagStr   = upperStr;
        if ( typeof (allStr) == "string" && typeof (delim1) == "string" ) {
            for(var i=0;i<allStr.length;i++) {
                pre = upperStr.indexOf( "<"  + delim1.toUpperCase() , pre);
                aft = upperStr.indexOf( "</" + delim1.toUpperCase() , aft) + delim1.length + 3;
                if ( pre < 0 || aft < 0 ) { break; }
                attr += allStr.substring( pre, aft );
//                alert ( "start:"+allStr.substring( pre, aft ) +":end / pre : " + pre + " / " + aft );
                pre++;
                aft++;                
            }
        }
        return attr;
    }

    /* html ��ü ���ڿ��߿��� delim1���� ������ �±׸� ���ش�*/
    function removeTagStrs( allStr, delim1) {
        var attr   = "";
        var preStr = "";
        var aftStr = "";

        var pre = 0;
        var aft = 0;
        var upperStr = allStr.toUpperCase();
        var pointer;
        var tmpStr = allStr;
        var tmp    = "";
        if ( typeof (allStr) == "string" && typeof (delim1) == "string" ) {
            for(var i=0;i<allStr.length;i++) {
                pre = tmpStr.toUpperCase().indexOf( "<"  + delim1.toUpperCase() , 0);
                aft = tmpStr.toUpperCase().indexOf( "</" + delim1.toUpperCase()    ) + delim1.length + 3;
                if ( pre < 0 || aft < 0 ) { break; }
                tmp  = tmpStr.substring (0, pre);
                tmp += tmpStr.substring (aft   );

                tmpStr = tmp;
//                alert ( "start:"+ tmpStr +":end / pre : " + pre + " / " + aft );
                pre++;
                aft++;                
            }
        }
        return tmpStr;
    }

    /* �±� ���ڿ����� �����ϴ� ��� �Ӽ��� �����Ѱ��� ��ȯ */
    function removeALLAttr( tagStr ) {
        var attr = "";
        var tagName = tagStr.substring ( 1, tagStr.toUpperCase().indexOf(" ") );
        attr = tagStr.substring ( tagStr.toUpperCase().indexOf(">") + 1, tagStr.toUpperCase().indexOf("/" + tagName) - 1);
        attr = "<" + tagName + ">" + attr + "</" + tagName + ">";
        return attr;
    }

    /* �±� ���ڿ����� �����ϴ� prop �Ӽ��� �����Ѱ��� ��ȯ */
    function removeAttr( tagStr, prop, tier ) {
        var prop1 = prop + '="';
        var prop2 = prop + "='";
        var prop3 = prop + "=" ;

        var delim = "";

        var upperStr = tagStr.toUpperCase();

        if ( upperStr.indexOf(prop1.toUpperCase()) > 0 ) {
            delim = '"';
            prop  = prop1;
        } else if ( upperStr.indexOf(prop2.toUpperCase()) > 0 ) {
            delim = "'";
            prop  = prop2;
        } else if ( upperStr.indexOf(prop3.toUpperCase()) > 0 ) {
            delim = "";
            prop  = prop3;
        } else { // ã������ ������Ƽ�� ���� ���.
            prop = "";
        }

        var obj = null;
        if ( typeof(tier) != "string" ) {
            tier = "document";
        }

        if ( typeof(tagStr) == 'object' ) {
            tagStr = getTagStrById(tagStr.id, tier);
//            alert ( "removeAttr Object "  + tagStr );
        }

        /* ã������ �Ӽ����� �빮�� */
        var upperProp = prop.toUpperCase();

        var attr = "";

        var tagName = tagStr.substring ( 1, tagStr.indexOf(" ") );

        var startProp = upperStr.indexOf ( upperProp    );
        var preStr    = tagStr.substring ( 0, startProp );

//      alert ( "tagStr : " + tagStr + "startProp : " +  startProp);

        if ( startProp > 0 ) {
            if ( delim == "'" || delim == '"' ) {
                startProp = tagStr.indexOf("=",startProp) + 2;
            } else {
                startProp = tagStr.indexOf("=",startProp) + 1;
                delim = " ";
            }
            attr = preStr + tagStr.substring ( tagStr.indexOf(delim, startProp) + 1 );
        } else {
            attr = tagStr;
        }
        return attr;
    }

    function removeAttrWrite( id, prop, tier ) {
        var removeObj = getObject(id, tier);
        var attr = removeAttr(removeObj,prop, tier);
//        alert ( "prop" + prop + " : " + attr );
        replaceTagStrWriteById(id, attr, tier);
    }

    /* �±� ���ڿ����� prop���ڿ��� �߰��Ѱ��� ��ȯ */
    function addAttr( tagStr, propName, prop  ) {
        var attr = "";
        var TAG  =  getTagName(tagStr).toUpperCase();
        var endProp = tagStr.indexOf ( ">" );
        if ( endProp>= 0 ) {
            attr = tagStr.substring(0, endProp) + " " + propName + "=\"" + prop + "\" " + tagStr.substring(endProp)
//            alert ( "Add Pointer :" + tagStr.indexOf ( ">" ) );
//            alert ( "tagStr :" + tagStr  + "\nAdd Pointer :" + attr );
        }
        return attr;
    }

    /* �±� ���ڿ����� prop���ڿ��� �߰��Ѱ��� ��ȯ */
    function addString( tagStr, str ) {
        var attr = "";
        var TAG  =  getTagName(tagStr).toUpperCase();
        var endProp = tagStr.indexOf ( ">" );
        if ( endProp>= 0 ) {
            attr = tagStr.substring(0, endProp) + " " + str + " " + tagStr.substring(endProp)
        }
        return attr;
    }

    /* style�Ӽ��� ���� �մϴ�.*/
    function getStyle ( styleStr ) {
        var style = "";
        if ( typeof(styleStr) == 'object' ) {
            var obj = getObject(obj);
            style = getAttr( obj.innerHTML, "style" );
        } else {
            style = getAttr( styleStr, "style" );
        }
        return style;
    }

    function removeStyleAttr ( style, properties ) {
        var styleAttr = style.split( ";" );
        var attr = "";
        for ( i=0;i<styleAttr.length; i++) {
            var attrArray = styleAttr[i].split( ":" );
//            alert (  attrArray[0] + " / " + attrArray[1] + " / " + properties );
//            alert (  attrArray[0].length + " / " + properties.length );
            if ( attrArray[0] != "" && Trim(attrArray[0].toUpperCase()) != properties.toUpperCase() ) {
                attr += styleAttr[i] + ";";
            } else {
//                alert (  "Removing ~~ " + styleAttr[i] );
            }
        }
        return attr;
    }

    /* style���� �����ϴ� �Ӽ��� ���� �մϴ�.
       gubun : 1 ::> str : �±� ��ü ���ڿ�
       gubun : 2 ::> str : style�Ӽ� ��
    */
    function getStyleAttr ( str, prop, gubun ) {
        var style = "";
        var attr  = "";
        if ( gubun == 1 ) {
            style = getStyle(str);
        } else if ( gubun == 2 ) {
            style = str;
        }
        var styleArray = style.split( ";" );
        for ( var i=0;i<styleArray.length; i++){
            if ( styleArray[i].toUpperCase().indexOf ( prop.toUpperCase() ) >= 0 ) {
                attr = styleArray[i];
                break;
            }
        }
        attr = attr.substring(attr.indexOf(":")+1);
        return attr;
    }

    function setAttr ( tagStr, prop, val ) {
        tagStr = removeAttr (tagStr, prop            );
        tagStr = addAttr    (tagStr, prop , val      );
        return tagStr;
    }

    /* sep   : �Ӽ���� ���� ������ 
       delim : �Ӽ��� ���� �� ���� �����ϴ� ������
       �ּ�ó�������� ���� ����... �̰� ������ �츮�� ����.
       tagStr�� ������ ��� �±׿� �����ϴ� �Ӽ� ���ڿ����� ��ȯ�մϴ�.
    */
    function getAttr( tagStr, prop, sep, delim ) {
        var upperStr   = tagStr.toUpperCase();
        var TAG   = getTagName(tagStr).toUpperCase();

        /* ��ü �Ӽ� */
        var attr = tagStr.substring(upperStr.indexOf(TAG) + TAG.length, tagStr.indexOf(">") );

        /* �±׿� ���Ե� ��� �Ӽ��� ã�� �ɴϴ�. */
        if ( typeof(prop) == "string" ) {
            /* ��ü �Ӽ� �빮�� */
            var upperAttr = attr.toUpperCase();

            /* ã������ �Ӽ����� �빮�� */
            var upperProp = prop.toUpperCase();

            /* �Ӽ���� ���� ������  */
            if ( typeof(sep) != 'string') sep = "=";

            /* ã������ �Ӽ����� ���� ��ġ */
            var startProp = upperAttr.indexOf(upperProp);
            /* ã������ �Ӽ����� ������� */
            if ( startProp < 0 ) {
                return "";
            }
            /* ã������ �Ӽ��� ���� �� ������ ��ü ���ڿ� ��ȯ */
            attr      = attr.substring ( startProp );
            /* ��ü �Ӽ� �빮�� */
            upperAttr = attr.toUpperCase();

            /* ã������ �Ӽ����� ���� ��ġ */
            var ss = upperAttr.indexOf(upperProp + sep);

            /* ã������ �Ӽ����� ������� */
            if ( ss < 0 ) {
                return "";
            }
/*          attr      = attr.substring ( ss ); ã������ �Ӽ��� ���� �� ������ ��ü ���ڿ� ��ȯ
            alert('�Ӽ��� ���� : ' + attr );
*/
            var s = 0;
            var e = 0;
            var delim = upperAttr.substring ( upperAttr.indexOf(sep)+1,upperAttr.indexOf(sep) + 2);
            if ( delim != " " ) {
                s = attr.indexOf(sep) + 2;
            } else {
                s = attr.indexOf(sep) + 1;
                delim = " ";
            }
            e = attr.indexOf(delim, s);

            attr = attr.substring ( s,  e);
        } else {
//            alert("�Ӽ����� �������� �ʾҽ��ϴ�.");
        }

        return attr;
    }

    function tableBorderSet (docObj, chgBorder) {
        var tableObjs = docObj.all.tags("TABLE");
        for ( var i=0; i<tableObjs.length; i++ ) {
            var border = tableObjs[i].border;
            if  ( border != "NaN" ) {
                tableObjs[i].border = chgBorder;
            }
        }
    }
