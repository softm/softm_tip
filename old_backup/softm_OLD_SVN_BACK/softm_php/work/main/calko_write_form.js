var lastLogicId = {logic:'',option:'',item:''};
var TMP_VALUE = new Array();
var MIN_LOG_ROW = 10;
var SAVE_INTERVAL = 1000 * 60;
var firstLoad = false;

Effect.TWINKLE_INTERVAL = 300;
function e$(o) {
    return $(o);
}

function fInit(state) {
    /* Characteristic Code Element 생성 */
    var prototype = crcInfo.constructor.prototype;
    for ( var crcId in crcInfo ) {
        if (crcId in prototype) continue;
        if (crcInfo instanceof Array && isNaN(crcId)) continue;
        fCreateElement(crcId);
    }

    /* option Price Element 생성 */
    var prototype = crcInfo.constructor.prototype;
    for ( var optId in optionAmountJson ) {
        if (optId in prototype) continue;
        if (optionAmountJson instanceof Array && isNaN(optId)) continue;

        var po = optionAmountJson[optId];
        if ( po ) {
            var ifExec = false;
            var optionAO = null;
            if ( !$('opt_amt_' + optId) ) {
                var optionAO = $C("INPUT");
                    optionAO.id = 'opt_amt_' + optId;
                    optionAO.className = optionAO.tagName.toLowerCase() + '_option_amount';
                var iArea = $C("span");
                    iArea.appendChild(optionAO);
                    var logArea = $('hidden_area').tBodies[0];
                    var newRow   = logArea.insertRow(logArea.rows.length);newRow.title = optionAO.id;
                    var newCell  = newRow.insertCell(-1);newCell.innerHTML = logArea.rows.length;newCell.style.textAlign='center';
                    var newCell  = newRow.insertCell(-1);newCell.innerHTML = optionAO.id;newCell.style.textAlign='left';newCell.style.paddingLeft='3px';
                    var newCell  = newRow.insertCell(-1);newCell.appendChild(iArea);newCell.style.textAlign='left';newCell.style.paddingLeft='3px';
                    newRow.style.cursor = 'pointer';
                    newRow.style.backgroundColor='#FFFFFF';
            }
        }
    }

    fTableInit(); // 테이블 초기화
    fLogHeader(null);

    var prototype = adjustItemJson.map.constructor.prototype;
    for ( var eId in adjustItemJson.map ) {
        if (eId in prototype) continue;
        if (adjustItemJson.map instanceof Array && isNaN(eId)) continue;
        //alert(eId == 'open_through_car');
        if ($(eId)) {
            //$('msg').value += ',' + eId;
            //alert('eId : ' +  eId);
            fLogicExec({srcElement:$(eId)},'item');
        } else {
            alert(eId + ' item json is non-exist in file.');
        }
    }

    // 처음 로딩시 기본값적용을위해 로직루프 수행
     /* log logic -- debug */
    if ( state < 3 ) {
        firstLoad = true;
        var prototype = logicJson.map.constructor.prototype;
        for ( var eId in logicJson.map ) {
            if (eId in prototype) continue;
            if (logicJson.map instanceof Array && isNaN(eId)) continue;
            if ($(eId)) {
                //alert( eId );
                fLogicExec({srcElement:$(eId)},'logic');
            } else {
                alert(eId + ' logic json is non-exist in file.');
            }
        }

        var prototype = optionAmountJson.map.constructor.prototype;
        for ( var eId in optionAmountJson.map ) {
            if (eId in prototype) continue;
            if (optionAmountJson.map instanceof Array && isNaN(eId)) continue;
            if ($(eId)) {
                fLogicExec({srcElement:$(eId)},'option');
            } else {
                alert(eId + ' option json is non-exist in file.');
            }
        }
    }

    fLogFooter(null); /* log logic -- debug */
    fLogValueAllSet(); // log영역 Element의 선택값 설정

    if ( state < 3) {
        firstLoad = false;
    }
    // tab 초기화
    var countries=new ddtabcontent("countrytabs")
    countries.setpersist(true)
    countries.setselectedClassTarget("link") //"link" or "linkparent"
    countries.init();

    $('display_logic_box'   ).style.left = LOGGER_OPTION.left;
    $('msg'                 ).style.left = LOGGER_OPTION.left;
    $('item_search_area'    ).style.left = LOGGER_OPTION.left;
    $('xml_data'            ).style.left = LOGGER_OPTION.left;
    $('hidden_item'         ).style.left = LOGGER_OPTION.left;

    $('display_logic_box'   ).style.display = LOGGER_OPTION.display;
    $('msg'                 ).style.display = LOGGER_OPTION.display;
    $('item_search_area'    ).style.display = LOGGER_OPTION.display;

    $('hidden_item'         ).style.display = LOGGER_OPTION.display;
    $('xml_data'            ).style.display = LOGGER_OPTION.display;
    UI.scrollBanner('display_logic_box');
    UI.scrollBanner('msg');
    UI.scrollBanner('item_search_area'  );
    UI.scrollBanner('xml_data'          );
    UI.scrollBanner('save_state_box'    );
    UI.scrollBanner('hidden_item'       );

    if ( state < 8  ) {
        if (!saveHandle) {
            saveHandle = setInterval(function() { if ( editData ) { fSaveExec(false,false); } },SAVE_INTERVAL );
        }
    } else {
        clearInterval(saveHandle);
        saveHandle = null;
    }

    if ( state == 8 || state == 'P' ) {
        fTPLog();
        if ( window.addEventListener ) {
            window.addEventListener('resize',fSetCenterLogProgress,true);
            window.addEventListener('scroll',fSetCenterLogProgress,true);
        } else {
            window.attachEvent('onresize',fSetCenterLogProgress);
            window.attachEvent('onscroll',fSetCenterLogProgress);
        }
    }
}

function fCreateElement(crcId,cloneAreaID) {
    var areaId = null;
    if (cloneAreaID) {
        areaId = cloneAreaID;
    } else {
        areaId = 'E' + crcId.substring(3);
    }

    var iArea = $(areaId);

    var l = crcInfo[crcId].length;
    if ( !crcInfo[crcId][0].ATWTB ) {
        var cO = $C("INPUT");
        for (var i=0; i<l;i++ ) { // for문 의미없음?
            cO.value = crcInfo[crcId][i].ATWRT;
        }
        cO.className = 'input_crc';

    } else {
        var cO = $C("SELECT");
        for (var i=0; i<l;i++ ) {
            var optO = $C('option');
            var creatable = true;
            if (creatable) {
                try {
                    if (/^[A-Z]{3}5000/.test(crcId)) {
                        //alert('test');
                        optO.value     = crcInfo[crcId][i].ATWRT;
                        optO.innerText = crcInfo[crcId][i].ATWRT;
                    } else {
                        optO.value     = crcInfo[crcId][i].ATWRT;
                        optO.innerText = crcInfo[crcId][i].ATWTB;
                    }
                }
                catch (e)
                {
                    alert( 'crc load error --> crcId :> ' + crcId );
                }
                if ( crcInfo[crcId][i].ATSTD == 'Y' ) {
                    if (/^[A-Z]{3}5000/.test(crcId)) {
                        optO.innerText  = crcInfo[crcId][i].ATWRT;
                        optO.selected   = true;
                    } else {
                        optO.innerText  = crcInfo[crcId][i].ATWTB;
                        optO.selected   = true;
                    }
                }
                cO.appendChild(optO);
            }
        }
    }
    var _v = null;
    var _a = null;

    if ( iArea ) {
        if ( iArea.tagName == 'SPAN' ) {
            _v = iArea.getAttribute('set'   );
            _a = iArea.getAttribute('attr'  );
            cO.setAttribute('set' ,_v);
            cO.setAttribute('attr',_a);
            // hidden_item list ui로 변경후 수정 2010년 7월 7일 수요일
            if (iArea.className == 'crc_hidden') {
                cO.value = _v;
            }
        }
    }

    var infoText = $C("span");
    infoText.id             = areaId + '_title';
    infoText.innerText      = areaId;
    infoText.style.color    = '#CC0066';

    if ( iArea ) {
        cO.style.cssText = iArea.style.cssText;
        cO.className = cO.tagName.toLowerCase() + '_crc';
        if ( iArea.getAttribute( 'readonly' ) == 'true' ) cO.readOnly = true;
        if ( iArea.getAttribute( 'disabled' )           ) cO.disabled = true;

        cO.id = iArea.id;
        iArea.parentNode.replaceChild(cO,iArea);
    } else {
        var crcId = areaId.charAt(0)== 'E'&& areaId.length == 5?PRE_CRC_CODE + areaId.substring(1):'';
        iArea = $C("span");
        cO.className = cO.tagName.toLowerCase() + '_h_crc';
        cO.id = areaId;
        iArea.appendChild(cO);

        var logArea = $('hidden_area').tBodies[0];
        var newRow   = logArea.insertRow(logArea.rows.length);newRow.title = areaId;
        var newCell  = newRow.insertCell(-1);newCell.innerHTML = logArea.rows.length;newCell.style.textAlign='center';
        var newCell  = newRow.insertCell(-1);newCell.innerHTML = areaId;newCell.style.textAlign='left';newCell.style.paddingLeft='3px';
        var newCell  = newRow.insertCell(-1);newCell.appendChild(iArea);newCell.style.textAlign='left';newCell.style.paddingLeft='3px';
        var newCell  = newRow.insertCell(-1);newCell.innerHTML = '&nbsp;';

        newRow.style.cursor = 'pointer';
        newRow.style.backgroundColor='#FFFFFF';
    }

}

function fTableInit() {
    for (var a=1; a<=2; a++) {
        var tbody = $('tbl'+a).tBodies[0];
        var l =  $('tbl'+a).tBodies[0].rows.length;
        for (var i=0; i<l; i++) {
            cell = tbody.rows[i].cells;
            var ll = cell.length;
            //alert( ll);
            for (var j=0; j<ll; j++) {
                //alert('test');
                //cell[j].style.backgroundColor= 'red';
                var tIdx = parseInt ( (""+(i+1)).padLeft('0',2) + (""+j).padRight('0',2),10 )
                /**/
                cell[j].attachEvent('onfocus',function(e) {
                                                            var o = window.event?e.srcElement:e.target;
                                                            //alert( o.firstChild );
                                                            if( o.firstChild.nodeType == 1 ){
                                                                //if ( o.firstChild.tagName == 'INPUT' ) o.firstChild.focus();
                                                            }
                                                            //tableUtil.cell.activate(o); // 선택안되게하기위해 제거
                                                            //fDisplayItemLogger({srcElement:null});
                                            },false );
                var fCild = cell[j].firstChild;
                try {
                    if(fCild.nodeType == 1 ) {
                        // logic이 적용된 element 색상적용
                        if ( logicJson[fCild.id] || logicJson.map[fCild.id]) {
                            fCild.style.backgroundColor = LOGICCOLOR.apply;
                        }
                       cell[j].tabIndex = 0;
                       fCild.tabIndex = tIdx;

                        if ( fCild.id.indexOf('_CLONE') > -1 ) {
                            var idInfo = fCild.id.split('_');
                            fCreateElement(PRE_CRC_CODE+idInfo[0].substring(1),fCild.id);
                            fCild = $( fCild.id );
                        }

                        if ( fCild.id.indexOf('_COPY') > -1 ) {
                            var idInfo = fCild.id.split('_');
                            var copyObj = $(idInfo[0]);
                            var t = '';
                            if ( copyObj.tagName == 'SELECT' ) {
                                t = copyObj.selectedIndex>=0?copyObj.options[copyObj.selectedIndex].text:'';
                            } else {
                                t = ( copyObj.tagName == 'SPAN')?copyObj.innerText:copyObj.value;
                            }
                            if ( fCild.tagName == 'SPAN' ) fCild.innerText = t;
                            else                           fCild.value     = t;
                        }
                       fCild.attachEvent('onfocus',function(e) {
                                                                //alert('test');
                                                                var o = window.event?e.srcElement:e.target;
                                                                //tableUtil.cell.activate(o.parentNode);// 선택안되게하기위해 제거
                                                                $('find_id').value = o.id;
                                                                Util.Cookie.set('find_id',o.id);
                                                                $('msg').value  = '';
                                                                TMP_VALUE[o.id] = o.value;

                                                                fLogHeader(e); /* log logic -- debug */
                                                                fLogicExec(e,'logic' ); // 디버깅시에만 이용함 ( 운영시 삭제 )
                                                                fLogicExec(e,'option');

                                                                fLogFooter(e); /* log logic -- debug */
                                                                fLogValueAllSet(); // log영역 Element의 선택값 설정
                                                                fLogMarkAllItem();
                                                                } );
                       fCild.attachEvent('onchange',function(e) {
                                                                var o = window.event?e.srcElement:e.target;
                                                                $('find_id').value = o.id;
                                                                $('msg').value  = '';
                                                                fLogHeader(e); /* log logic -- debug */
                                                                fLogicExec(e,'item'   );
                                                                fLogicExec(e,'logic'  );
                                                                fLogicExec(e,'option' );

                                                                fLogFooter(e); /* log logic -- debug */
                                                                fLogValueAllSet(); // log영역 Element의 선택값 설정
                                                                fLogMarkAllItem();
                                                                editData = true;
                                                                lastLogicId = {};
                                                                } );

                        var _v = fCild.getAttribute('set');
                        if (_v) fCild.value     = _v;
                        if ( fCild.getAttribute( 'attr' ) ) {
                            eval('var attr = {'+fCild.getAttribute('attr') + '}');
                            if (attr) {
                                var prototype = attr.constructor.prototype;
                                for ( var p in attr ) {
                                    if (p in prototype) continue;
                                    if (attr instanceof Array && isNaN(p)) continue;
                                    if      ( p=='readonly'   && attr[p] == 'true' ) fCild.readOnly = true;
                                    else if ( p=='disabled'   && attr[p] == 'true' ) fCild.disabled = true;
                                    else if ( p=='maxlength'                       ) fCild.maxLength = attr[p];
                                    else if ( p=='numberonly' && attr[p] == 'true' ) {
                                        fCild.onkeydown = Form.numeberOnly;
                                        fCild.onblur    = Form.numeberOnly;
                                        fCild.attachEvent('onblur', function(e) {
                                            var o = window.event?window.event.srcElement:e.target;
                                            o.value = o.value.replace(/,/g, "").numberFormat(); });
                                    } else {
                                        fCild.setAttribute( p,attr[p]);
                                    }
                                    if (/^on/.test(p)) {
                                        var f = new Function(attr[p]);
                                        fCild.attachEvent(p, f);
                                    }
                                }
                            }
                        }

                        if ( fCild.readOnly ) {
                            fCild.style.backgroundColor = 'transparent';
                            fCild.style.border = '0px';
                        }

                        if ( fCild.disabled ) {
                            fCild.style.backgroundColor = 'transparent';
                            fCild.style.border = '0px';
                        }

                        var execValid = null;
                        if ( validJson[fCild.id] ) {
                            execValid = validJson[fCild.id].min || validJson[fCild.id].max?true:false;
                        } else if ( fCild.getAttribute('attr') ) {
                            eval('var attr = {'+fCild.getAttribute('attr') + '}');
                            execValid = attr['min'] || attr['max']?true:false;
                        }
                        if ( execValid ) {
                           fCild.attachEvent('onkeyup',function(e) {
                                var o = window.event?e.srcElement:e.target;
                                var attr    = null;
                                var attrStr = '';
                                if ( validJson[o.id] ) {
                                    attr = validJson[o.id];
                                } else if ( o.getAttribute('attr') ) {
                                    attrStr = o.getAttribute('attr');
                                    eval('attr = {'+o.getAttribute('attr') + '}');
                                }
                                var min = attr['min']?attr['min']:'';
                                var max = attr['max']?attr['max']:999999999999999999999;
                                if ( parseFloat(attr['min']) > o.value.toNumber() ||
                                     parseFloat(attr['max']) < o.value.toNumber()
                                ) {
                                    editData = false;
                                    o.value = TMP_VALUE[o.id];
                                    alert('invalid data!\n\n' + attr['min'] + ' ~ ' + attr['max'] );
                                } else {
                                    TMP_VALUE[o.id] = o.value;
                                    editData = true;
                                }
                            } );
                        }
                    } else {
                       cell[j].tabIndex = tIdx;
                    }
                }
                catch (e)
                {
                    if (console) console.debug(e);
                }
            }
        }
    }
}

var fKeyDown = function(e) {
    var code = window.event?window.event.keyCode:e.keyCode;

    if (code == 38 || code == 40 ) {
        var o = window.event?window.event.srcElement:e.target;
        if (o.offsetParent.id.indexOf('tbl')>-1 || o.parentNode.offsetParent.id.indexOf('tbl')>-1) {
            var td = ( o.tagName == 'TD' )?o:o.parentNode;
            var cIdx = td.cellIndex;
            var rIdx = td.parentNode.rowIndex;
            var newRIdx = rIdx + (code == 38?-1:1);
            var tBody = td.parentNode.parentNode;
            var hRL = !tBody.parentNode.tHead?0:tBody.parentNode.tHead.rows.length;
            var tRL = !tBody.parentNode.tFoot?0:tBody.parentNode.tFoot.rows.length;

            if ( newRIdx >= 0 && newRIdx < tBody.rows.length ) {
               tBody.rows[newRIdx].cells[cIdx].focus();
            } else {
            }
        }
        e.cancelBubble = true;
    }
}

if ( window.addEventListener ) {
    document.addEventListener('keydown',fKeyDown,false);
} else {
    document.attachEvent('onkeydown',fKeyDown,false);
}

function fChangeZIndex(e,id) {
    var o = window.event?e.srcElement:e.target;
    if (e.type=='mouseover') {
        if (id == 'display_logic_box') {
            $('display_logic_box').style.zIndex = 100;
            $('save_state_box').style.zIndex = 99;
            $('msg').style.zIndex = 99;
            $('hidden_item').style.zIndex = 99;
        } else if (id == 'save_state_box') {
            $('display_logic_box').style.zIndex = 99;
            $('save_state_box').style.zIndex = 100;
            $('msg').style.zIndex = 99;
            $('hidden_item').style.zIndex = 99;
        } else if (id == 'hidden_item') {
            $('display_logic_box').style.zIndex = 99;
            $('save_state_box').style.zIndex = 99;
            $('msg').style.zIndex = 99;
            $('hidden_item').style.zIndex = 100;
        } else if (id == 'msg') {
            $('display_logic_box').style.zIndex = 99;
            $('save_state_box').style.zIndex = 99;
            $('msg').style.zIndex = 100;
            $('hidden_item').style.zIndex = 99;
        }
    }
}

function fFindElement(id) {
    id = id?id:$('find_id').value;
    if ($(id)) {
        Effect.TWINKLE_INTERVAL = 150;
        Effect.twinkle($(id),{cssText:'background-color:#FF0000;color:#FFFFFF;border:1px dotted #CC0000',during:800,callback:null});
        try {
            if ( $(id).parentNode.tagName == 'TD' ) {
                if ($(id).parentNode.parentNode.parentNode.parentNode.id == 'hidden_area') {
                    $(id).focus();
                } else {
                    if ($(id).getClientRects().length == 0 ) {
                        alert('다른탭에 항목이 있습니다. ');
                    } else {
                        $(id).parentNode.focus();
                    }
                    //$(id).focus(); // 이거하면 안됨 포커스시 logger list 조회이벤트 활성화 되어있음
                }
            } else {
                $(id).focus();
            }
        } catch(e) {
            alert('다른탭에 항목이 있습니다.');
        }
        Util.Cookie.set('find_id',$('find_id').value);
    } else {
        alert('항목이없습니다.');
    }
}

/*---------- logic -------------- -------------- -------------- --------------*/
//var executing = false;
function fLogicExec(e,gubun) {
    var o = e.srcElement?e.srcElement:e.target;

    var execJson = null;
    if ( gubun=='logic' ) {
        execJson = logicJson;
    } else if ( gubun == 'option' ) {
        execJson = optionAmountJson;
    } else if ( gubun == 'item' ) {
        execJson = adjustItemJson;
    }

    var logics = execJson.map && execJson.map[o.id]?execJson.map[o.id]:new Array(o.id);
    if ( execJson.map && execJson.map[o.id] ) {
        logics = execJson.map[o.id];
        if (!Object.isArray(logics)) {
            logics = new Array(logics);
        }
    } else {
        logics = new Array(o.id);
    }

    for ( var i=0; i<logics.length; i++) {
        var logicId = logics[i];
        var lo = execJson[logicId];
        if (lo) {
            if ( gubun=='logic' ) {
                fLogicGen(lo,logicId,0,gubun,e);
            } else if ( gubun == 'option' ) {
                fLogicGen(lo,logicId,0,gubun,e);
            } else if ( gubun == 'item' ) {
                fLogicGen(lo,logicId,0,gubun,e);
            }
        }
    }
}

function fItemChangeAdjust(lo,pIdNm,pNm) {
    try
    {
        if ( /^E\d{4}/.test(pIdNm) ) {
            var areaId = pIdNm;
            var crcId = PRE_CRC_CODE + pIdNm.replace(/\_CLONE$/,'').substring(1);
            try
            {
                var l = crcInfo[crcId].length;
                if ( crcInfo[crcId][0].ATWTB ) {
                    var iObj = $(pIdNm);
                    var v = iObj.value;
                    while( iObj.firstChild ) {
                        iObj.removeChild(iObj.firstChild);
                    }
                    var aProp = lo;
                    for (var i=0; i<l;i++ ) {
                        var creatable = true;
                        if (aProp) {
                            if ( pNm.toLowerCase() == 'exclude' && ( ',' + aProp.join(',') + ',' ).indexOf( ',' + crcInfo[crcId][i].ATWRT + ',' ) > -1 ) {
                                creatable = false;
                            } else if ( pNm.toLowerCase() == 'include' && ( ',' + aProp.join(',') + ',' ).indexOf( ',' + crcInfo[crcId][i].ATWRT + ',' ) == -1 ) {
                                creatable = false;
                            } else if ( pNm.toLowerCase() == 'logic' && !eval(crcInfo[crcId][i].ATWRT + aProp ) ) {
                                creatable = false;
                            }
                            if (creatable) {
                                var op = new Option(crcInfo[crcId][i].ATWTB, crcInfo[crcId][i].ATWRT);
                                op.innerHTML = crcInfo[crcId][i].ATWTB;
                                op.value= crcInfo[crcId][i].ATWRT;
                                iObj.appendChild(op);
                            }
                        }
                    }
                    iObj.value = v;
                    if (!iObj.value) iObj.selectedIndex = 0;
                }
            }
            catch (e)
            {
                alert('error2 : ' + crcId );
            }
        } else {
            try
            {
                var l = COMMON_ARRAY[pIdNm].length;

                var iObj = $(pIdNm);
                var v = iObj.value;
                while( iObj.firstChild ) {
                    iObj.removeChild(iObj.firstChild);
                }
                var aProp = lo;
                for (var i=0; i<l;i++ ) {
                    var creatable = true;
                    if (aProp) {
                        if ( pNm.toLowerCase() == 'exclude' && ( ',' + aProp.join(',') + ',' ).indexOf( ',' + COMMON_ARRAY[pIdNm][i].value + ',' ) > -1 ) {
                            creatable = false;
                        } else if ( pNm.toLowerCase() == 'include' && ( ',' + aProp.join(',') + ',' ).indexOf( ',' + COMMON_ARRAY[pIdNm][i].value + ',' ) == -1 ) {
                            creatable = false;
                        } else if ( pNm.toLowerCase() == 'logic' && !eval(COMMON_ARRAY[pIdNm][i].value + aProp ) ) {
                            creatable = false;
                        }
                        if (creatable) {
                            //alert( COMMON_ARRAY[pIdNm][i].text );
                            var op = new Option(COMMON_ARRAY[pIdNm][i].text, COMMON_ARRAY[pIdNm][i].value);
                            op.innerHTML = COMMON_ARRAY[pIdNm][i].text;
                            op.value= COMMON_ARRAY[pIdNm][i].value;
                            iObj.appendChild(op);
                        }
                    }
                }
                iObj.value = v;
                if (!iObj.value) iObj.selectedIndex = 0;
            }
            catch (e)
            {
                alert( pIdNm );
                if (console) console.debug(e);
            }
        }
    }
    catch (e)
    {
        alert( 'fItemChangeAdjust : ' + e.toString() + ' / ' + pIdNm + ' / ' + pNm );
    }
}
function fLogicGen(lo,id,level,gubun,e) {
    level = level?level:0;
    var paddStr = ''.padRight(' ', 2*level) ;
    var prototype1 = lo.constructor.prototype;
    var OPTION_IF_CORRECT = (lo['OPTION_IF_CORRECT']?lo['OPTION_IF_CORRECT']:'stop');
    var ifExec = false;
    for ( var sub in lo ) {
        if (sub in prototype1) continue;
        if (lo instanceof Array && isNaN(sub)) continue;
        var cond        = false;
        var condStr     = '';
        var ifItem      = sub.substring(0,2) == 'if'?true:false;   // 조건아이템
        var setItem     = sub == 'set'?true:false;                 // set아이템
        var execItem    = sub.toLowerCase() == 'exclude' ||
                          sub.toLowerCase() == 'include' ||
                          sub.toLowerCase() == 'logic'?true:false; // 실행아이템

        var elementItem = false;
        var logicItem   = false;
        var loSet = null;
        if ( ifItem ) {
            if ( !ifExec ) {
                var so = lo.source?lo.source:id;
                    so = new Array().concat(so);
                var logics = sub.substring(2).split('_');
                var ll     = logics.length     ;
                cond = '(';
                condStr = '';
                for (var j=0; j<ll; j++ ) {
                    try {
                        cond    += (j>0?'&&':'') + "'" + $(so[j]).value + "'" + logics[j];
                        condStr += (j>0?' && ':'') + "$('" + so[j] + "').value" + logics[j]; // 디버깅용도
                    }
                    catch (e) {
                        if (console) console.debug();
                    }
                }
                cond += ')';
                loSet = lo[sub].set;
            }
        } else if ( setItem ) {
            cond = true;
            condStr = 'true';
            loSet = lo[sub];
        } else if (execItem) {
            cond = true;
            condStr = 'true';
            loSet = lo[sub];
        } else {
            elementItem = $(sub)?true:false     ; // dom.id Element와 동일한이름을 가지는 item
            logicItem   = sub.charAt(0) == 'L'?true:false; // dom.id Element와 동일한이름을 가지는 item
        }

        try {
            if ( ifItem || setItem ) {
                if ( eval(cond) ) {
                    if ( LOGGER_OPTION.logic_print ) $('msg').value += '\n' + paddStr + 'if (' + condStr + ') {\n';

                    if (loSet) { // 조건에 맞는 값설정
                        for (var k=0; k<loSet.length; k++) {
                            var prototype = loSet[k].constructor.prototype;
                            var pIdx = 0;
                            var pIdNm  = null;
                            var pObj = null;
                            var subExec = false;

                            for ( var pNm in loSet[k]) {
                                if (pNm in prototype) continue;
                                if (loSet instanceof Array && isNaN(k)) continue;
                                pIdx++;
                                if (pIdx==1) {
                                    if ( pNm.toLowerCase() == 'object') {
                                        pObj = $(loSet[k][pNm]);
                                    } else {
                                        pObj = $(loSet[k][pNm])[pNm];
                                    }
                                    pIdNm = loSet[k][pNm];
                                } else {
                                    if ( lastLogicId[gubun] != pIdNm ) {
                                        $('find_id').value = pIdNm;
                                        if ( LOGGER_OPTION.logic_print ) $('msg').value += (k==0?paddStr + '  ':";\n" +paddStr + '  ') + "$('" + pIdNm + "')." + pNm + '= "' + eval(loSet[k][pNm]) +'"';
                                        if (!firstLoad) fLogAdd(pIdNm); // itemlog 추가
                                        try {
                                            if (pNm.toLowerCase() == 'value') {
                                                if ( pObj.tagName == 'SPAN' ) pObj.innerText = eval(loSet[k][pNm]);
                                                else                          pObj.value     = eval(loSet[k][pNm]);
                                                subExec = true;
                                            } else if (pNm.toLowerCase() == 'exclude' || pNm.toLowerCase() == 'include' || pNm.toLowerCase() == 'logic' ) {
                                                fItemChangeAdjust (loSet[k][pNm],pIdNm,pNm);
                                                subExec = true;
                                            } else {
                                                pObj[pNm] = eval(loSet[k][pNm]);
                                                subExec = true;
                                            }
                                            lastLogicId[gubun] = id;
                                            //}
                                        } catch(e) {
                                            if (console) console.debug();
                                        }
                                    } else {
                                        if ( LOGGER_OPTION.logic_print ) $('msg').value += (k==0?paddStr + gubun +lastLogicId[gubun] + ' / ' + pIdNm +  ' : 중복로직으로 처리에서 제외됨 --> ':";\n" +paddStr + '  중복로직으로 처리에서 제외됨 --> ') + "$('" + pIdNm + "').value" + '= "' + eval(loSet[k][pNm]) + '"';
                                    }
                                }
                            }

                            if ( subExec ) {
                                if ( logicJson[pIdNm] ) {
                                    fLogicGen(logicJson[pIdNm],pIdNm,0,'logic');
                                }
                                if ( optionAmountJson[pIdNm] ){
                                    if ( LOGGER_OPTION.logic_print ) $('msg').value += '\n option --> ' + pIdNm + '/';
                                    fLogicExec({srcElement:$(pIdNm)},'option' );
                                }
                                if (adjustItemJson[pIdNm] ) {
                                    fLogicGen(adjustItemJson[pIdNm],pIdNm,0,'item');
                                }
                            }
                        }
                        if (k!=0) {
                            if ( LOGGER_OPTION.logic_print ) $('msg').value += ';';
                        }
                        if (setItem) {
                            if ( LOGGER_OPTION.logic_print ) $('msg').value += '\n' + paddStr + '}'; // 이로직과 쌍을
                        }
                    }

                    var prototype = lo[sub].constructor.prototype;
                    if ( ifItem ) { // 하위요소에 logicElement가 있는지 검색해 --> 재귀호출
                        for ( var ssub in lo[sub]) {
                            if (ssub in prototype) continue;
                            if (lo instanceof Array && isNaN(sub)) continue;
                            if ( $(ssub) ) { // element이면
                                fLogicGen(lo[sub][ssub],ssub,level+1,'logic');
                            }
                        }

                        if ( LOGGER_OPTION.logic_print ) $('msg').value += '\n' + paddStr + '}'; // 이로직과 쌍을이룸-->$('msg').value += '\n' + paddStr + 'if (' + id + '==' + cond + ') {\n';
                                                                                                 // 정확하게 왜 여기 놔야 되는지 확인못함.

                        if ( OPTION_IF_CORRECT == 'stop' ) {
                            break;
                        }
                        ifExec = true;  // <-- 조건에 맞는 로직을 찾아 실행했음.
                                        // if 조건처리후 맞는 조건을 찾았다면
                                        // 아래의 if문장은 실행하지 않게하기위해
                    }

                }
            } else if ( execItem ) {
                if (e || (e && !e.type) ) fItemChangeAdjust (lo[sub],id,sub);
            } else if ( elementItem ) {
                fLogicGen(lo[sub],sub,level,gubun);
                if (logicJson[sub]) {
                    fLogicGen(logicJson[sub],sub,0,gubun);
                }
            } else if ( logicItem ) {
                fLogicGen(lo[sub],sub,level+1,gubun);
            }
        }catch(e){
            if (console ) console.debug(e);
        }
    }
}

/*---------- logic -------------- -------------- -------------- --------------*/

/*---------- log -------------- -------------- -------------- --------------*/
function fLogHeader(e) {
/* log logic -- debug */
    if (e) {
        var o = e.srcElement?e.srcElement:e.target;
        var objName = o.id;
        $('s_id').style.cursor = 'pointer';
        $('s_id').onclick = function(e) {
            fFindElement($('s_id').innerText);
        };
        $('s_rel_logic').onclick = function(e) {
            Effect.twinkle($($('s_id').innerText));
            fLogTwinkleAllItem(objName);
        };
        $('s_id').innerText = objName;
        $('s_value').innerText = ( o.tagName == 'SPAN')?o.innerText:o.value;

        if ( o.tagName == 'SELECT' ) {
            $('s_value').innerText += ' / ' + (o.options.length?o.options[o.selectedIndex].text:'');
        }
        var crcId = objName.charAt(0)== 'E'&& objName.length == 5?PRE_CRC_CODE + objName.substring(1):'';

        var crcDescription = crcId && crcInfo[crcId]?crcInfo[crcId][0].ATBEZ.split(':')[1]:'';
        if (crcDescription) $('s_value').innerText += ' [' + crcDescription + ']';
        for (var i=0; i<LOGITEM_CSSTEXT.length;i++ ) {
            $(LOGITEM_CSSTEXT[i].id).style.cssText = LOGITEM_CSSTEXT[i].cssText;
        }
        LOGITEM_CSSTEXT = new Array();

        var logArea = $('logic_area').tBodies[0];
        while( logArea.firstChild ) {
            logArea.removeChild(logArea.firstChild);
        }
    }
/* log logic -- debug */
}

function fLogFooter(e) {
/* log logic -- debug */
    var logArea = $('logic_area').tBodies[0];
    if (logArea.rows.length != 0 ) {
        for (var i=logArea.rows.length; i<MIN_LOG_ROW; i++ ) {
            var newRow   = logArea.insertRow(logArea.rows.length);
            var newCell  = newRow.insertCell(-1);newCell.innerHTML = i + 1;newCell.style.textAlign='center';
            var newCell  = newRow.insertCell(-1);newCell.innerHTML = '&nbsp;';newCell.style.textAlign='center';
            var newCell  = newRow.insertCell(-1);newCell.innerHTML = '&nbsp;';newCell.style.textAlign='center';
            var newCell  = newRow.insertCell(-1);newCell.innerHTML = '&nbsp;';newCell.style.textAlign='center';
            var newCell  = newRow.insertCell(-1);newCell.innerHTML = '&nbsp;';newCell.style.textAlign='center';
        }
        $('logic_area').parentNode.style.display='';
    } else {
        $('logic_area').parentNode.style.display='none';
    }
    if (e) {
        var o = e.srcElement?e.srcElement:e.target;
        var objName = o.id;
        //alert( objName );
        if (objName) {
            LOGITEM_CSSTEXT.push({'id':objName,cssText:$(objName).style.cssText});
            if ( !$(objName).readOnly ) {
                $(objName).style.backgroundColor = LOGICCOLOR.source;
            } else {
                $(objName).style.backgroundColor = LOGICCOLOR.readonly;
            }
        }
    }
/* log logic -- debug */
}

/* log logic -- debug - 전체 깜박임 */
var LOGITEM_CSSTEXT = new Array();
function fLogMarkAllItem() {
    var logArea = $('logic_area').tBodies[0];
    try {
        var sId = $('s_id').innerText;
        for (var i=0; i<logArea.rows.length; i++ ) {
            var id = logArea.rows[i].cells[2].innerText.trim();
            if (id) {
                id = id.substring(0,3)==PRE_CRC_CODE?'E' + id.substring(3):id;
                var obj = $(id);

                if ( sId == id ) {
                    obj.style.backgroundColor = LOGICCOLOR.both;
                } else {
                    LOGITEM_CSSTEXT.push({'id':id,cssText:obj.style.cssText});
                    obj.style.backgroundColor = optionAmountJson[obj.id]?LOGICCOLOR.opt_amt_target:LOGICCOLOR.target;
                }
            }
        }
    } catch(e) {
        alert('fLogMarkAllItem : ' + e.toString());
    }
}

function fLogValueAllSet() {
    var logArea = $('logic_area').tBodies[0];
    try {
        var sId = $('s_id').innerText;
        for (var i=0; i<logArea.rows.length; i++ ) {
            var id = logArea.rows[i].cells[2].innerText.trim();
            if (id) {
                id = id.substring(0,3)==PRE_CRC_CODE?'E' + id.substring(3):id;
                var obj = $(id);
                var sIdx = -1;
                try {
                    if ( obj.tagName == 'SELECT' ) {
                        t = obj.selectedIndex>=0?obj.options[obj.selectedIndex].text:'';
                        t += ' / ' + obj.value ;
                    } else {
                        t = ( obj.tagName == 'SPAN')?obj.innerText:obj.value;
                    }
                } catch(e) {
                    t = 'invalid item';
                }
                logArea.rows[i].cells[3].innerText = t;
            }
        }
    } catch(e) {}
}

function fLogTwinkleAllItem() {
    var logArea = $('logic_area').tBodies[0];
    for (var i=0; i<logArea.rows.length; i++ ) {
        logArea.rows[i].click();
    }
}

function fLogAdd(id) {
    if ( LOGGER_OPTION.list_print  ) {
    /*
        <th>Seq</th>
        <th>Description</th>
        <th>ElmentID</th>
        <th>Value</th>
        <th>&nbsp;</th>
    */
        var logArea = $('logic_area').tBodies[0];
        $('logic_area').parentNode.style.display='';
        var crcId = id.charAt(0)== 'E'&& id.length == 5?PRE_CRC_CODE + id.substring(1):'';
        var newRow   = logArea.insertRow(logArea.rows.length);newRow.title = id;
        var l = logArea.rows.length;
        var newCell  = newRow.insertCell(-1);newCell.innerHTML = l;newCell.style.textAlign='center';
        var newCell  = newRow.insertCell(-1);newCell.innerHTML = crcId && crcInfo[crcId]?crcInfo[crcId][0].ATBEZ.split(':')[1]:(id.substr(0,4)=='opt_')?'option':'-';
        newCell.style.textAlign=crcId && crcInfo[crcId]?'center':'center';

        newRow.onclick = function() {
            try
            {
                var id = this.cells[2].innerText;
                    id = id.substring(0,3)==PRE_CRC_CODE?'E' + id.substring(3):id;
                //$($('find_id')).value=id;
                fFindElement(id);
                //Effect.twinkle($(id),{cssText:'background-color:#FFFFFF;border:1px dotted #FF0000',during:800,callback:null});
            }
            catch (e)
            {
                alert( '"' + crcId + '" Charateristic Item Not Found' );
            }
        }
        var newCell  = newRow.insertCell(-1);newCell.innerHTML = crcId?crcId:id;//newCell.appendChild(to[j]);
        //if ( objName == tmpA[i].object ) newRow.style.fontWeight = 'bold';
        newRow.style.cursor = 'pointer';

        //Effect.twinkle(obj,{cssText:'background-color:#BFE2FF;border:1px dotted #CC0000',during:800,callback:null});
        var newCell  = newRow.insertCell(-1); newCell.innerHTML = '&nbsp;';
    }
}
/*---------- log -------------- -------------- -------------- --------------*/