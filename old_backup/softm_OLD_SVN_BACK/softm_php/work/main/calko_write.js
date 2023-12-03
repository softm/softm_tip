window.name = 'calko';

var crcInfo  = null;
var CLASS_NAME = null;
var PRE_CRC_CODE = null;
var state    = null;
var logicJson= null;
var adjustItemJson = null;
var optionAmountJson = null;
var QUOTCOUNT = null; // op=gen_crc_data 시 구해옴.
var doubleTrans = false;
var saveHandle = null; // 자동저장 핸들
var editData = false;
var validJson = null;
var LOGICCOLOR = {source:'#FFA2A2',target:'#C9B7F2',both:'#FFCC99',apply:'#F0F0FF',readonly:'transparent',opt_amt_target:'#FFFF99'};
var LOGGER_OPTION = { left:'1025px', logic_print:true,list_print:true,  display:'none' };

function fGetWrite(j) {
    if ( !doubleTrans ) {
        clearInterval(saveHandle);
        saveHandle = null;

        if ($('s_button')) $('s_button').disabled = true;

        doubleTrans = true;
        crcInfo=null;
        if (j && j.esti_no ) $('sForm').s_esti_no.value   = j.esti_no;
        if (j && j.seq     ) $('sForm').s_seq.value       = j.seq    ;
        var estiNo = $('sForm').s_esti_no.value.replace(/\-/g,'');
        var seq    = $('sForm').s_seq.value.replace(/\-/g,'');
        seq = seq?seq:1;
        var sent = 0;
        if ( estiNo.length == 13 ) {
            loading.setPos('500px','300px');
            loading.show();
            $('sForm').s_esti_no.value = estiNo.substr(0,6) + '-' + estiNo.substr(6,5) + '-' + estiNo.substr(11)
            try { $('sForm').s_esti_no.focus(); } catch (e){}

            $('view_iframe_log').style.display  = 'none';
            $('view_iframe').style.display      = 'none';
            $('log_progress').style.display     = 'none';

            $('area_write').innerHTML = '';
            $('area_write').style.display = 'none'  ;
            Util.Load.script({src:'calko_write.php?op=gen_crc_data&p_esti_no=' + estiNo + '&p_seq=' + seq,type:'js',callback:function(){
				if (CLASS_NAME) {
					Util.Load.script({src:'logic_' + CLASS_NAME + '.js.php',type:'js',callback:function(){
							Util.Load.script({src:'calko_write_form.js',type:'js',callback:function(){
								if ( sent == 0 ) { sent++;fGetWriteExec(estiNo,seq); }
							}});
					}});
				} else {
					Alert.show({id:'message_box',message:'CRC Receiving Error!',ok:function(){$('sForm').s_esti_no.focus();}});
					$('s_button').disabled = false;
					doubleTrans = false;
					setTimeout(function(){loading.hide()},100);

				}
            }});
        } else {
            Alert.show({id:'message_box',message:'Please input correct quotation number again.',ok:function(){$('sForm').s_esti_no.focus();}});
            $('s_button').disabled = false;
            doubleTrans = false;
        }
    }
    doubleTrans = false;

    return false;
}

function fGetWriteExec(estiNo,seq) {
    fAddHistory();
    var ajaxR = new asyncConnector('xmlhttp');
    var url  = _url;
    url += '?op=write_area'
        +  '&p_esti_no=' + estiNo
        +  '&p_seq=' + seq
    ;
    ajaxR.httpOpen('GET', url, false,'', $("area_write"));
        ajaxR.dataArea.innerHTML = ajaxR.responseText();

        setTimeout(function(){loading.hide()},100);
        if (typeof console == 'object') console.debug(crcInfo);

        if (crcInfo) {
            if ( state < 3 ) {
                Util.Alert.show({id:'wait_box',message:'The default settings are applied.</font><BR><BR><font color=#FF0000>being processed.</font>',keydowncancel:false});
            }
            setTimeout(function() {
                //LOGGER_OPTION.logic_print = false;
                fInit(state); // '사용상태 : 0:초기, 1:CRC요청, 2:CRC수신, 3:저장, 8:TP전송, 9:TP완료'
                //alert('fInit');
                if ( state < 3 ) {
                    Util.Alert.hide({id:'wait_box'});
                }
                $('area_write').style.display = 'inline'  ;
                $('area_list' ).style.display = 'none'    ;
                fQuotationBoxList(estiNo,seq);
            },100);

        } else {
            $('area_write').style.display = 'none';
            $('area_write').innerHTML = '';
            if ( state == 1 ) {
				Alert.show({id:'message_box',message:'CRC Receiving Error!',ok:function(){$('sForm').s_esti_no.focus();}});
            } else {
				Alert.show({id:'message_box',message:'Quotation number is not exist!',ok:function(){$('sForm').s_esti_no.focus();}});
            }
        }
        doubleTrans = false;
        if ($('s_button')) $('s_button').disabled = false;

    return false;
}

function fSaveExec(sendTPAble,reload) {
    reload = typeof reload == 'boolean'?reload:true;
    if ( !$('btn_save').disabled ) {
        if ( sendTPAble ) { // Spec 전송
            if ( confirm('Do you want to transmit specification?') ) {
                fSaveSpecExec(fSendSpecExec); // Spec 저장 --> TP전송
            }
        } else { // Save
            fSaveSpecExec(null,reload);
        }
    }
    return false;
}

function fSaveSpecExec(callback,reload) {
    callback = typeof callback === 'function'?callback:null;
    reload = typeof reload == 'boolean'?reload:true;

    var f = $('wForm');
    var fe = f.elements;
    var saveXML = new Array();
    var vaild = true;
    for (var i=0,l=fe.length;i<l;i++ ) {
        if ( fe[i].id && fe[i].id != 'msg' && fe[i].type.toUpperCase() != 'BUTTON' ) {
            var tagName = fe[i].id;
            if ( /^E\d{4}/.test(fe[i].id) && !fe[i].value ) {
                alert( PRE_CRC_CODE + fe[i].id.substr(1) + ' value is incorrect.' );
                Util.Alert.hide({id:'wait_box'});
                fFindElement(fe[i].id);
                vaild = false;
                break;
            }
            saveXML.push('<' + tagName + '><![CDATA[' + fe[i].value + ']]></' + tagName + '>');
        }
    }
    if ( !vaild ) return;

    Util.Alert.show({id:'wait_box',message:'Data <font color=#FF0000>saving...</font><BR><BR><font color=#FF0000>being processed.</font>',keydowncancel:false});
    $('wait_box').style.backgroudColor = '#FF0000';

    var estiNo = f.p_esti_no.value.replace(/\-/g,'');
    var seq    = f.p_seq.value.replace(/\-/g,'');

    var ajaxS = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=save_xml_exec'
            + '&p_esti_no=' + estiNo
            + '&p_seq=' + seq;

    var params  ='x=' + encodeURIComponent(saveXML.join('\n'));
    ajaxS.httpOpen('POST', url, true,params, null,
        function() {
            $('area_write').style.display = 'inline'   ;
            var info = ajaxS.responseText().split('|');
            var s = info[0];
            var m = info[1];
            var k = info[2];
            var msg = info[3];
            Util.Alert.hide({id:'wait_box'});
            if (s == 'SUCCESS') { // success
                editData = false;
                if ( !callback ) {
                    if (reload) fGetWrite({esti_no:estiNo,seq:seq});
                }
                else             callback();

            } else if (s == 'ERROR') {
                alert(info[3]); // error
            }
        }
    );
}

function fSendSpecExec() {
/*
    Util.Alert.show({id:'alert_box',message:'데이터를 <font color=#FF0000>TP 저장중입니다.</font><BR><BR><font color=#FF0000>being processed.</font>',
                     ok:function() {
                     }
                    });
*/
    var f = $('wForm');
    Util.Alert.show({id:'wait_box',message:'<font color=#FF0000>Send Spec </font><BR><BR><font color=#FF0000>Wait!.</font>',keydowncancel:false});
    var ajaxS = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=send_spec_exec'
            + '&p_esti_no=' + f.p_esti_no.value
            + '&p_seq=' + f.p_seq.value
            + '&p_pre_crc_code=' + PRE_CRC_CODE
                ;
    var params  = null;
    ajaxS.httpOpen('POST', url, true,params, null,
        function() {
            $('area_write').style.display = 'inline'   ;
            var info = ajaxS.responseText().split('|');
            var s = info[0];
            var m = info[1];
            var k = info[2];
            var msg = info[3];
            var xData = info[4];
            Util.Alert.hide({id:'wait_box'});
            if (s == 'SUCCESS') { // success
                $('msg').value = info[3] + '\n\n xml:' + info[4];
                if ( msg ) alert(msg);
                alert('Your request has been completed successfully.\n\n'
                    + 'Quotation document will be delivered in a minute to your email address.\n\n'
                    + 'Please check your email account.');

                fGetWrite({esti_no:f.p_esti_no.value,seq:f.p_seq.value});
            } else if (s == 'ERROR') {
                alert(info[3]); // error
            }
        }
    );
}

var tmpSearchValue = null;
function fQuickQuotationClear(e){
    var o = window.event?e.srcElement:e.target;
    $('area_quick_list').innerHTML = '';
    $('area_quick_list').style.display = 'none';
}

function fQuickQuotationSearch(e,gubun){
    if ( ( e.which != 229 && ( e.keyCode >= 48 && e.keyCode <= 90 || e.keyCode == 8 ) ) || e.type == 'dblclick' ) {
        var v = $N('s_esti_no')[0].value.replace(/\-/g,'').trim();
          fQuickQuotationList(1,gubun);
          tmpSearchValue = v;
    }
}

var qToolTipEstiNo = null;
function fQuickQuotationToolTip(e,v) {
    var toolTip = $('tool_tip');
        toolTip.style.display = '';

    if (e.type == 'mouseover') {
        if ( qToolTipEstiNo != v || toolTip.innerHTML == '') {
            var ajaxS = new asyncConnector('xmlhttp');
            var url = _url
                    + '?op=get_quick_quotation_detail_list'
                    + '&s_esti_no=' + v
            ;

            var params  = null;
            ajaxS.httpOpen('GET', url, false,null, null);
            toolTip.innerHTML = ajaxS.responseText();
        }
        var eO = window.event?window.event:e;
        toolTip.style.left = '200px';
        toolTip.style.top  = parseInt(eO.clientY-toolTip.parentNode.offsetTop+document.documentElement.scrollTop,10) + 'px';
        qToolTipEstiNo = v;
    } else {
    }
}

function fQuickQuotationList(s,m){
    var v = $N('s_esti_no')[0].value.replace(/\-/g,'').trim();
    var ajaxS = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=get_quick_quotation_list'
            + '&s_mode=' + m
            + '&s_esti_no=' + v
            + '&s_project_name=' + $N('s_project_name')[0].value
            + '&s=' + (s?s:1);
    var params  = null;
    ajaxS.httpOpen('GET', url, true,params, null,
        function() {
            $('area_quick_list').style.position = 'absolute'   ;
            $('area_quick_list').style.left = '5px'   ;
            $('area_quick_list').style.top = '160px'   ;
            $('area_quick_list').style.zIndex = 10;

            $('area_quick_list').style.display = 'inline'   ;
            $('area_quick_list').innerHTML = ajaxS.responseText();
            loading.hide();
            //alert('loading.hide');
            //$('msg').value += 'loading.hide';

            //$('area_tip').attachEvent('onmouseover' ,fQuickQuotationToolTip);
            //$('area_tip').attachEvent('onmouseout'  ,fQuickQuotationToolTip);
        }
    );
    try {
        loading.setPos('88px', '190px');
        loading.show();
    }
    catch (e)
    {
    }
}
function fSetCenterLogProgress() {
    UI.setCenter($({element:$('log_progress'),baseElement:document.documentElement}));
}

function fTPLog() {
    var f = $('wForm');
    var estiNo = f.p_esti_no.value;
    var ajaxR = new asyncConnector('xmlhttp');
    var LOG_DATE= '';
    var LOG_TIME= '';
    var MSGTYP  = '';
    var MESSAGE = '';
    var HEADER  = '';
    try
    {
        ajaxR.openCallBack= function (str) {
            Effect.twinkle($('quotation_state'),{cssText:'background-color:red;color:#FFFFFF;border:1px dotted #CC0000',during:800,callback:null});
            var xmlDoc=ajaxR.responseXML();
            var tpLogState  = (xmlDoc.getElementsByTagName("TP_LOG_STATE").length > 0 && xmlDoc.getElementsByTagName("TP_LOG_STATE").item(0).firstChild ? xmlDoc.getElementsByTagName("TP_LOG_STATE").item(0).firstChild.nodeValue:'' );
            var errMsg      = (xmlDoc.getElementsByTagName("TP_ERROR").length > 0 && xmlDoc.getElementsByTagName("TP_ERROR").item(0).firstChild ? xmlDoc.getElementsByTagName("TP_ERROR").item(0).firstChild.nodeValue:'' );

            if ( errMsg ) {
                alert( 'The error has been occured while receiving log data. Please try again later.\n\n [ ' + errMsg + ' ] ' + 'tpLogState / errMsg : ' + tpLogState + ' / ' + errMsg);
                $('quotation_state').innerHTML= '<a href=# onclick="fTPLog();return false;"><U><B>Retry Log</B></U></a>';
                $('log_progress').style.display= 'none';
                return false;
            }

            var xmlLog =xmlDoc.getElementsByTagName("T_ZKTXI0002");
            var recvL = xmlLog.length;
            if ( recvL > 0 ) {
                var xmlStr = '';
                try { xmlStr = ajaxR.xmlHttp.responseXML.xml ? ajaxR.xmlHttp.responseXML.xml : (new XMLSerializer()).serializeToString(ajaxR.xmlHttp.responseXML); } catch (e) { }
                $('xml_data').value  = 'tpLogState / errMsg : ' + tpLogState + ' / ' + errMsg + '\n';
                $('xml_data').value += 'xmlStr : ' + xmlStr;
                var jsonStr = xml2json(xmlDoc,false,false);
                $('xml_data').value += 'jsonStr : ' + jsonStr;
                var jsonObj = eval("("+ jsonStr +")");
                var json    = jsonObj["xml"].T_ZKTXI0002;

                if ( json ) {
                    function sortFn (x,y) {
                        return x.LOG_DATE + x.LOG_TIME > y.LOG_DATE + y.LOG_TIME?1:(x.LOG_DATE + x.LOG_TIME==y.LOG_DATE + y.LOG_TIME?0:-1);
                    }
                    var ll = json.length?json.length:1;
                    if ( ll == 1) json = Array(json);
                    json.sort(sortFn);
                    var tmp = '';
/*
                    var cCnt = 0; // 성공 숫자
                    var fCnt = 0; // Error 숫자
                    for (var i=0; i<ll; i++ ) {
                        //alert( i + ' / ' + json[i].LOG_DATE );
                        tmp += '' + json[i].LOG_DATE +"/";
                        tmp += '' + json[i].LOG_TIME +"/";
                        tmp += '' + json[i].MSGTYP   +"/";
                        tmp += '' + json[i].TISNUM   +"/";
                        tmp += '' + json[i].HEADER   +"/";
                        tmp += '' + json[i].MESSAGE  +"\n";
                        if ( json[i].MSGTYP == 'S' &&
                             json[i].MESSAGE.toUpperCase().indexOf('COMPLETED') > 0 ) {
                            cCnt++;
                        }
                        if ( json[i].MSGTYP == 'E' &&
                             json[i].MESSAGE.toUpperCase().indexOf('FAILURE') > 0 ) {
                            fCnt++;
                        }
                    }
                    $('xml_data').value = cCnt + '\n' + fCnt + '\n' + tmp;
*/
                    MSGTYP  = json[ll-1].MSGTYP ;
                    MESSAGE = json[ll-1].MESSAGE;
                    HEADER  = json[ll-1].HEADER ;

                    LOG_DATE= json[ll-1].LOG_DATE ;
                    LOG_TIME= json[ll-1].LOG_TIME ;
                }
            }
            var QUOTATION_COUNT = jsonObj["xml"].QUOTATION_COUNT;
            var SUCCESS_COUNT   = jsonObj["xml"].SUCCESS_COUNT;
            var FAIL_COUNT      = jsonObj["xml"].FAIL_COUNT;
            var LOG_COUNT       = jsonObj["xml"].LOG_COUNT;

            //&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
/*
            alert( QUOTATION_COUNT + '\n' +
                   SUCCESS_COUNT   + '\n' +
                   FAIL_COUNT      + '\n' +
                   LOG_COUNT       + '\n'
                 );
*/
            var qutPerLog = 14;
            var qutPerMinute = 10;

            var execRate = Math.round((LOG_COUNT * 100 )/ (QUOTATION_COUNT * qutPerLog));
            ProgressBar.setProgress ('log_progress.bar',execRate);
            fSetCenterLogProgress();
            $('quotation_state').innerText = HEADER + ' / ' + MESSAGE;
            $('quotation_state').title = HEADER + ' / ' + MESSAGE;
            if ( tpLogState == 'S' ) { // 성공
                $('log_progress').style.display= 'none';
                if ( window.addEventListener ) {
                    window.removeEventListener('resize',fSetCenterLogProgress,true);
                    window.removeEventListener('scroll',fSetCenterLogProgress,true);
                } else {
                    window.detachEvent('onresize',fSetCenterLogProgress);
                    window.detachEvent('onscroll',fSetCenterLogProgress);
                }
                fTPPrice('S');
            } else if ( tpLogState == 'E' ) { // 실패
                $('log_progress').style.display= 'none';
                if ( window.addEventListener ) {
                    window.removeEventListener('resize',fSetCenterLogProgress,true);
                    window.removeEventListener('scroll',fSetCenterLogProgress,true);
                } else {
                    window.detachEvent('onresize',fSetCenterLogProgress);
                    window.detachEvent('onscroll',fSetCenterLogProgress);
                }
                fTPPrice('E');
            } else if ( tpLogState == 'P' ) { // 진행중
                setTimeout(fTPLog,3000);
            }
            if ( $('view_iframe_log').style.display != 'none' ) fViewLog();
        }

        var url = _url
                + '?op=tp_log'
                + '&p_esti_no=' + estiNo;
        ajaxR.httpOpen('GET', url, true,null, null);
/*
tp log 에러 MSGTYP
    I : Information
    W: Warning
    E : Error
    S : Success
*/

    /* xmlDoc을 그대로 이용시
                var sIdx = recvL-1;
                var tmpDateStr = '';
                var maxDateStr = 0;
                //alert( recvL );
                if ( recvL > 0 ) {
                    try
                    {
                        //$('xml_data').value = 'xmlStr : ' + xmlStr;
                        for (var i=0; i<recvL; i++ ) {
                            var pItem =pL.item(i);
                            //$('xml_data').value = '/' + (pItem.getElementsByTagName("MESSAGE").length > 0 && pItem.getElementsByTagName("MESSAGE").item(0).firstChild ? pItem.getElementsByTagName("MESSAGE").item(0).firstChild.nodeValue:'' )
                            //$('quotation_state').innerText = (pItem.getElementsByTagName("MESSAGE").length > 0 && pItem.getElementsByTagName("MESSAGE").item(0).firstChild ? pItem.getElementsByTagName("MESSAGE").item(0).firstChild.nodeValue:'' )
                            var DATUM = '' + (pItem.getElementsByTagName("DATUM").length > 0 && pItem.getElementsByTagName("DATUM").item(0).firstChild ? pItem.getElementsByTagName("DATUM").item(0).firstChild.nodeValue.replace(/\-/g,''):0 );
                            var UZEIT = '' + (pItem.getElementsByTagName("UZEIT").length > 0 && pItem.getElementsByTagName("UZEIT").item(0).firstChild ? pItem.getElementsByTagName("UZEIT").item(0).firstChild.nodeValue.replace(/\:/g,''):0 );
                            //$('quotation_state').innerText += '/' + Math.max ( DATUM + UZEIT, maxDateStr ) ;
                            maxDateStr = Math.max ( DATUM + UZEIT, maxDateStr );
                            if ( DATUM + UZEIT <= maxDateStr ) {
                                sIdx = i;
                            }
                        }
                    }
                    catch (e)
                    {
                        alert( e.toString() );
                    }
                }
                //alert ( recvL + ' / ' + maxDateStr + ' / ' + sIdx );
                var xmlStr = '';
                //alert( xmlStr );

                var sItem =pL.item(sIdx);
                var MSGTYP  = (sItem.getElementsByTagName("MSGTYP").length > 0 && sItem.getElementsByTagName("MSGTYP").item(0).firstChild ? sItem.getElementsByTagName("MSGTYP").item(0).firstChild.nodeValue:'' );
                var MESSAGE = (sItem.getElementsByTagName("MESSAGE").length > 0 && sItem.getElementsByTagName("MESSAGE").item(0).firstChild ? sItem.getElementsByTagName("MESSAGE").item(0).firstChild.nodeValue:'' );
                var HEADER  = (sItem.getElementsByTagName("HEADER" ).length > 0 && sItem.getElementsByTagName("HEADER" ).item(0).firstChild ? sItem.getElementsByTagName("HEADER" ).item(0).firstChild.nodeValue:'' );
    */
            //alert( MSGTYP + ' / ' + MESSAGE + ' / ' + HEADER );
    }
    catch (e)
    {
        alert ( 'ERROR : ' + e.toString() );
        $('xml_data').value = ajaxR.responseText();
        Util.Alert.show({id:'wait_box',message:'<font color=#FF0000>The error has been occured while receiving log data</font><BR><BR> [ ' + ajaxR.responseText() + ' / ' + ' ]</font>',keydowncancel:false});
    }

    return false;
}

function fTPPrice(MSGTYP) {
    var f = $('wForm');
    var estiNo = f.p_esti_no.value;
    var seq    = f.p_seq.value;
    var ajaxR = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=tp_price'
            + '&p_esti_no=' + estiNo
            + '&p_msgtyp=' + MSGTYP;
    ajaxR.openCallBack= function (str) {
        Effect.twinkle($('quotation_state'));
        var info = ajaxR.responseText().split('|');
        var s = info[0];
        var m = info[1];
        var k = info[2];
        var msg = info[3];
        Util.Alert.hide({id:'wait_box'});
        if (s == 'SUCCESS') { // success
            if ( MSGTYP == 'S' ) {
                alert( 'TP has been successfully received.' );
            } else {
                alert( 'The TP receiving has been failed.' );
            }
        } else if (s == 'ERROR') {
            alert('Error : ' + info[3]); // error
        }
        fGetWrite({esti_no:estiNo,seq:seq});
    }
    if (MSGTYP == 'S') {
        Util.Alert.show({id:'wait_box',message:'<font color=#FF0000>TP Receiving... [Success]</font>',keydowncancel:false});
    } else if (MSGTYP == 'E') {
        Util.Alert.show({id:'wait_box',message:'<font color=#FF0000>TP Receiving... [Error].</font>',keydowncancel:false});
    }
    ajaxR.httpOpen('GET', url, true,null, null);
}

function fViewLog() {
    var f = $('wForm');
    var v = f.p_esti_no.value.replace(/\-/g,'');
    if ( v ) {
        loading.setPos('88px', '190px');
        loading.show();

        var url = _url
                + '?op=get_tp_log_list'
                + '&p_esti_no=' + v
        ;
        $('view_iframe_log').style.position = 'absolute'   ;
        $('view_iframe_log').style.overflow = 'hidden'   ;
        $('view_iframe_log').width  = '660px'   ;
        $('view_iframe_log').height = '405px'   ;

        $('view_iframe_log').style.left = '0px'   ;
        $('view_iframe_log').style.top = document.getElementById("tab" + ($('tab1').style.display == 'block'?1:2) ).offsetTop + 'px';
        $('view_iframe_log').style.zIndex = 10000;

        $('view_iframe_log').src = url;

        loading.hide();
        $("view_iframe").style.display="none";
        $("view_iframe_log").style.display="inline";


    } else {
        $("view_iframe_log").style.display="none";
    }
}


function fViewTP() {
    var f = $('wForm');
    var v = f.p_esti_no.value.replace(/\-/g,'');
    var seq = f.p_seq.value;

    if ( v ) {

        loading.setPos('88px', '190px');
        loading.show();
        var url = _url
                + '?op=get_tp_list'
                + '&p_esti_no=' + v
                + '&p_seq=' + seq
        ;
        $('view_iframe').style.position = 'absolute'   ;
        $('view_iframe').style.overflow = 'hidden'   ;
        $('view_iframe').width  = '610px'   ;
        $('view_iframe').height = '395px'   ;

        $('view_iframe').style.left = '0px'   ;
        $('view_iframe').style.top = document.getElementById("tab" + ($('tab1').style.display == 'block'?1:2) ).offsetTop + 'px';
        $('view_iframe').style.zIndex = 10000;

        $('view_iframe').src = url;

        loading.hide();
        var params  = null;
        $("view_iframe_log").style.display="none";
        $("view_iframe").style.display="inline";


    } else {
        $("view_iframe").style.display="none";
    }
}


function fDownLoadExcelTP() {
    var f = $('wForm');
    var v = f.p_esti_no.value.replace(/\-/g,'');
    var seq = f.p_seq.value;
    if ( v ) {
        $("view_iframe_log").style.display="none";
        $("view_iframe").style.display="inline";

        loading.setPos('88px', '190px');
        loading.show();

        var url = _url
                + '?op=get_tp_list'
                + '&p_esti_no=' + v
                + '&p_seq=' + seq
                + '&p_mode=excel'
        ;

        $('download_iframe').src = url;
        loading.hide();
        var params  = null;

    } else {
        $("view_iframe").style.display="none";
    }
}

function fDownLoadXML(mode) {
    var f = $('wForm');
    var v = f.p_esti_no.value.replace(/\-/g,'');
    var seq = f.p_seq.value;
    if ( v ) {
        loading.setPos('88px', '190px');
        loading.show();

        var url = _url
                + '?op=get_xml'
                + '&p_esti_no=' + v
                + '&p_seq=' + seq
                + '&p_mode=' + mode
        ;

        $('download_iframe').src = url;
        loading.hide();
        var params  = null;
    }
}

function fViewOPTION() {
    var f = $('wForm');
    var v   = f.p_esti_no.value.replace(/\-/g,'');
    var seq = f.p_seq.value;

    if ( v ) {

        loading.setPos('88px', '190px');
        loading.show();
        var url = _url
                + '?op=get_option_list'
                + '&p_esti_no=' + v
                + '&p_seq=' + seq
        ;
        $('view_iframe').style.position = 'absolute'   ;
        $('view_iframe').style.overflow = 'hidden'   ;
        $('view_iframe').width  = '414px'   ;
        $('view_iframe').height = '275px'   ;

        $('view_iframe').style.left = '149px'   ;
        $('view_iframe').style.top = document.getElementById("tab" + ($('tab1').style.display == 'block'?1:2) ).offsetTop + 'px';
        $('view_iframe').style.zIndex = 10000;

        $('view_iframe').src = url;

        loading.hide();
        var params  = null;

        $("view_iframe_log").style.display="none";
        $("view_iframe").style.display="inline";

    } else {
        $("view_iframe").style.display="none";
    }
}

function fDownLoadExcelOPTION() {
    var f = $('wForm');
    var v = f.p_esti_no.value.replace(/\-/g,'');
    var seq = f.p_seq.value;
    if ( v ) {
        loading.setPos('88px', '190px');
        loading.show();

        var url = _url
                + '?op=get_option_list'
                + '&p_esti_no=' + v
                + '&p_seq=' + seq
                + '&p_mode=excel'
        ;

        $('download_iframe').src = url;
        loading.hide();
        var params  = null;

    } else {
        $("view_iframe").style.display="none";
    }
}

function fOpenSpecWrite() {
    var w = openWindow("calko_spec_interface_write.php", 775, 490,'calko'); // 현재화면
    w.focus();
}

function fPrint() {
    var f = $('wForm');
    var estiNo = f.p_esti_no.value.replace(/\-/g,'');
    var seq    = f.p_seq.value.replace(/\-/g,'');
    var w = openWindow("calko_print.php?p_esti_no=" + estiNo + '&p_seq=' + seq, 705, 500,'winPrint',{scrollbars:'yes',resizable:'no'});
    w.focus();
}

function fCopy() {
    var f = $('wForm');
    var estiNo = f.p_esti_no.value.replace(/\-/g,'');
    var seq    = f.p_seq.value.replace(/\-/g,'');
    var w = openWindow("calko_spec_interface_copy.php?p_esti_no=" + estiNo + '&p_seq=' + seq, 690, 250,'winCopy',{scrollbars:'yes'});
    w.focus();
}

function fCreateCopy() {
    if ( confirm ('Do you want to copy specification?') ) {
        var ajaxR = new asyncConnector('xmlhttp');
        var url = _url
                + '?op=create_copy_exec'
        ;
        var f = $('wForm');
        var estiNo = f.p_esti_no.value.replace(/\-/g,'');
        var seq    = f.p_seq.value.replace(/\-/g,'');

        var params = new Array();
        params.push(
                     '&p_esti_no=' + estiNo +
                     '&p_seq=' + seq
        );

        var exec = true;
        if (exec) {
            ajaxR.httpOpen('POST', url, false,params.join('\n'), null);
            var info = ajaxR.responseText().split('|');
            var s = info[0];
            var p_esti_no = info[1];
            var p_seq = info[2];
            var msg = info[3];
            if (s == 'SUCCESS') { // success
                alert( 'Copy Complete!');
                fGetWrite({esti_no:p_esti_no,seq:p_seq});
            } else if (s == 'ERROR') {
                Util.Alert.show({id:'message_box',message:info[3]});
            }
        }
    }
}

function fDelete() {
    if ( confirm('Do you want to delete specification?') ) {

        var ajaxR = new asyncConnector('xmlhttp');
        var url = _url
                + '?op=delete_spec_exec'
        ;
        var f = $('wForm');
        var estiNo = f.p_esti_no.value.replace(/\-/g,'');
        var seq    = f.p_seq.value.replace(/\-/g,'');

        var params = new Array();
        params.push(
                     '&p_esti_no=' + estiNo +
                     '&p_seq=' + seq
        );

        var exec = true;
        if (exec) {
            ajaxR.httpOpen('POST', url, false,params.join('\n'), null);
            var info = ajaxR.responseText().split('|');
            var s    = info[0];
            var qCnt = info[1];
            var k    = info[2];
            var msg = info[3];
            if (s == 'SUCCESS') { // success
                if ( qCnt == 0 ) {
                    alert( 'All Quotation Deleted!');
                    document.location.href = _url;
                } else {
                    alert( 'Quotation Deleted!');
                    fGetWrite({esti_no:estiNo,seq:(seq-1)});
                }
            } else if (s == 'ERROR') {
                Util.Alert.show({id:'message_box',message:info[3],ok:function(){alert('Retry Again!');fChangeOption();}});
            }
        }
    }
}

function fChangeSeq(estiNo,seq,oSeq,m) {

    var ajaxR = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=change_o_seq'
    ;
    var f = $('wForm');
    estiNo = estiNo.replace(/\-/g,'');
    oSeq    = oSeq.replace(/\-/g,'');

    var params = new Array();
    params.push(
                 '&p_esti_no='  + estiNo    +
                 '&p_seq='      + seq       +
                 '&p_o_seq='    + oSeq      +
                 '&p_mode='     + m
    );
    var exec = true;
    if (exec) {
        ajaxR.httpOpen('POST', url, false,params.join('\n'), null);
        var info = ajaxR.responseText().split('|');
        var s = info[0];
        var p_esti_no = info[1];
        var p_seq = info[2];
        var msg = info[3];
        if (s == 'SUCCESS') { // success
            fQuotationBoxList(p_esti_no,p_seq);
        } else if (s == 'ERROR') {
            Util.Alert.show({id:'message_box',message:info[3]});
        }
    }
}

function fQuotationBoxList(estiNo,seq){
    var v = $N('s_esti_no')[0].value.replace(/\-/g,'').trim();
    var ajaxS = new asyncConnector('xmlhttp');
    var url = _url
            + '?op=get_save_state_box_list'
            + '&s_esti_no=' + estiNo
            + '&s_seq=' + seq
    ;
    var params  = null;
    ajaxS.httpOpen('POST', url, true,params, null,
        function() {
            $('save_state_box').innerHTML = ajaxS.responseText();
            loading.hide();
        }
    );
    try {
        loading.setPos('88px', '190px');
        loading.show();
    }
    catch (e)
    {
    }
}