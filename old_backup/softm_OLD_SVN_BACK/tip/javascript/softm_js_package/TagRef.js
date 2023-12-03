    /* 태그 문자열 하위 요소로 include된 태그의 속성을 반환*/
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

    /* 태그 문자열에서 태그명을 추출 합니다. */
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

            s = aftStr.indexOf(">") + 1;    // 태그 시작 부분의 종료점 예) "<div ~~~ >"
            preStr += ( aftStr.substring( 0, s ) );
            aftStr = aftStr.substring(s); // 태그 시작 이후의 문자열 .......
            e = aftStr.toUpperCase().indexOf ( "</" + TAG.toUpperCase() );
            e = e + endTagPosition;
            tmpStr = aftStr.substring(0, e);

            var includeTagCount = InStrCounter ( tmpStr.toUpperCase(), "<" + TAG.toUpperCase() ) + 1;
//          alert ( "포함된 태그 갯수 : " + includeTagCount );

//          alert ( "포함된 태그 갯수 : " + includeTagCount );
            var end_p = 0;
            for ( var i=0; i<includeTagCount;i++) {
                end_p = aftStr.toUpperCase().indexOf("</" + TAG.toUpperCase(), end_p);
                if (i != includeTagCount - 1) {
                    end_p++;
                }
//            i = e;
//            alert("end pointer : " + end_p);
            }
            // NetScape의 경우 태그 조작을 통해 <img> ~~ </img>로 html코드를 출력 하더라도
            // innerHTML값으로 다시 읽어 드릴경우에는 <img>만이 존재하는 문제점 해결을 위해
            if (TAG.toUpperCase() == "IMG" || TAG.toUpperCase() == "INPUT" ) {
                aft = pre + preStr.length;
            } else {
                // 위의 for문을 실행한후 태그의 열린갯수와 닫힌 갯수가 틀리면 음수를 반환
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

    /* html delim1에서 지정한 태그만을 붙여서 반환 */
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

    /* html 전체 문자열중에서 delim1에서 지정한 태그를 없앤다*/
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

    /* 태그 문자열내에 존재하는 모든 속성을 제거한값을 반환 */
    function removeALLAttr( tagStr ) {
        var attr = "";
        var tagName = tagStr.substring ( 1, tagStr.toUpperCase().indexOf(" ") );
        attr = tagStr.substring ( tagStr.toUpperCase().indexOf(">") + 1, tagStr.toUpperCase().indexOf("/" + tagName) - 1);
        attr = "<" + tagName + ">" + attr + "</" + tagName + ">";
        return attr;
    }

    /* 태그 문자열내에 존재하는 prop 속성을 제거한값을 반환 */
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
        } else { // 찾으려는 프로퍼티가 없을 경우.
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

        /* 찾으려는 속성명의 대문자 */
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

    /* 태그 문자열내에 prop문자열을 추가한값을 반환 */
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

    /* 태그 문자열내에 prop문자열을 추가한값을 반환 */
    function addString( tagStr, str ) {
        var attr = "";
        var TAG  =  getTagName(tagStr).toUpperCase();
        var endProp = tagStr.indexOf ( ">" );
        if ( endProp>= 0 ) {
            attr = tagStr.substring(0, endProp) + " " + str + " " + tagStr.substring(endProp)
        }
        return attr;
    }

    /* style속성을 추출 합니다.*/
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

    /* style내에 존재하는 속성을 추출 합니다.
       gubun : 1 ::> str : 태그 전체 문자열
       gubun : 2 ::> str : style속성 값
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

    /* sep   : 속성명과 값의 구분자 
       delim : 속성의 시작 과 끝을 지정하는 구분자
       주석처리때문에 에러 난다... 이거 한줄이 살리는 구나.
       tagStr만 지정한 경우 태그에 존재하는 속성 문자열만을 반환합니다.
    */
    function getAttr( tagStr, prop, sep, delim ) {
        var upperStr   = tagStr.toUpperCase();
        var TAG   = getTagName(tagStr).toUpperCase();

        /* 전체 속성 */
        var attr = tagStr.substring(upperStr.indexOf(TAG) + TAG.length, tagStr.indexOf(">") );

        /* 태그에 포함된 모든 속성을 찾아 옵니다. */
        if ( typeof(prop) == "string" ) {
            /* 전체 속성 대문자 */
            var upperAttr = attr.toUpperCase();

            /* 찾으려는 속성명의 대문자 */
            var upperProp = prop.toUpperCase();

            /* 속성명과 값의 구분자  */
            if ( typeof(sep) != 'string') sep = "=";

            /* 찾으려는 속성명의 시작 위치 */
            var startProp = upperAttr.indexOf(upperProp);
            /* 찾으려는 속성명이 없을경우 */
            if ( startProp < 0 ) {
                return "";
            }
            /* 찾으려는 속성명 부터 끝 까지의 전체 문자열 반환 */
            attr      = attr.substring ( startProp );
            /* 전체 속성 대문자 */
            upperAttr = attr.toUpperCase();

            /* 찾으려는 속성값의 시작 위치 */
            var ss = upperAttr.indexOf(upperProp + sep);

            /* 찾으려는 속성값이 없을경우 */
            if ( ss < 0 ) {
                return "";
            }
/*          attr      = attr.substring ( ss ); 찾으려는 속성값 부터 끝 까지의 전체 문자열 반환
            alert('속성값 이후 : ' + attr );
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
//            alert("속성명이 지정되지 않았습니다.");
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
