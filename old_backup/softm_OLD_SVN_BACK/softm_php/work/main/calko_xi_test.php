<?
/*
 Filename       : /calko/calko_write.php
 Fuction        : 견적작성
 Comment        :
 Make   Date    : 2009-08-21,
 Update Date    : 2009-08-21, v1.0 first
 Writer         : 김지훈
 Updater        :
 @version       : 1.0
*/
?>
<?php
define ("HOME_DIR" , realpath(dirname(dirname(__FILE__))) );
define ('SERVICE'  , 'CALKO' );
define ('BASE_DIR' , '..' );
define ('SERVICE_DIR', '../service');

require_once '../inc/calko.lib'   ; // calko.lib
require_once '../inc/calko_array.lib'   ; // calko_array.lib

require_once SERVICE_DIR . '/common/lib/lib.inc'                      ; // standard lib
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form

require_once SERVICE_DIR . '/common/Session.php';
$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$op = strtolower(trim($_POST["op"])) ;
$op = !$op?(trim($_GET["op"])?trim($_GET["op"]):'default'):$op;   // Process parameter [display, save]
$db = new DB (); // db instance

$backurl = $_GET['backurl']?$_GET['backurl']:$REQUEST_URI ;
if ( $backurl ) Session::setSession('backurl',$backurl);
$backurl = Session::getSession('backurl');

if ( $memInfor['login_yn'] != 'Y' ) {
    redirectPage( "/" );
} else {
if ( Session::getSession('agreement') == 'N' ) {
    redirectPage( "calko_terms_n_conditions.php" );
} else if ( !$grant[$_SERVER['PHP_SELF']][$memInfor[user_level]] ) {
    require_once '../inc/header.php'; // header
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
    window.onload = function() {
        Alert.show({id:'message_box',message:'This identification is not authorized.'});
    }
//-->
</SCRIPT>
<?
    require_once '../inc/footer.php'; // footer
} else {
if ( $op == 'default' ) {
    require_once '../inc/header.php'   ; // header

    $p_esti_no  = trim($_GET["p_esti_no"])  ;
    $p_seq      = (int) $_GET["p_seq"]; // p_seq
    $db->getConnect();
    // 최근 견적번호를 조회 기본값으로 설정
    $sql = "SELECT \n"
         . "  ESTI_NO\n"
         . " FROM tbl_calko_result \n"
         . " WHERE " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . ($p_esti_no?" AND ESTI_NO = '" .$p_esti_no . "'" :'')
         . " ORDER BY REG_DATE DESC \n"
         . " \n"
    ;
    //echo 'sql :' . $sql . '<BR>';
    $default_esti_no = $db->get($sql)->ESTI_NO;
?>
<link type="text/css" rel="stylesheet" href="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<SCRIPT type="text/javascript" src="<?=BASE_DIR?>/inc/calko.js.php"></script>

<SCRIPT LANGUAGE="JavaScript">
<!--
    var _url = '<?print $_SERVER['PHP_SELF']?>';
    var editData = false;

    window.onload = function() {
/*
        Util.Load.script({src:"calko_write.css",type:'css'});
        try {

        } catch (e){}
        Util.Load.script({src:'calko_write.js',type:'js',callback:function(){
        }});
*/
        fSearch();

    }

    window.onunload = function() {
        if ( editData ) {
            //
        }
    }

    function fSearch() {
        Util.Load.script({src:"calko_spec_interface_write.css",type:'css'});

        var ajaxR = new asyncConnector('xmlhttp');
        var url  = _url;
        //alert( $N('s_option')[0].checked );
        if ($N('s_option')[0].checked) {

        }
        //ajaxR.form = $('sForm');
        var params = 'op=get_spec_interface';
        loading.show(document.documentElement);
        loading.setPos(0,'100px');

        Util.Load.script({src:'calko_common.php?op=get_country_json',type:'js',callback:function(){
            ajaxR.httpOpen('POST', url, true,params, $("area_list"), function() {
                //alert('');
                ajaxR.dataArea.innerHTML = ajaxR.responseText();
                //alert(ajaxR.responseText());
                loading.hide();
                //_rI = null;
                $('area_list' ).style.display = 'inline' ;
                $('area_write').style.display = 'none'   ;

                if ( document.all ) {
                } else {
                }
                try
                {
                    fSetCountryToCombo($('country_code'));
                    //$('country_code').value = $('country_code').getAttribute('set') + '';
                    //$('country_code').value = '';
                    fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
                    fSetCountryToCombo($('country_code'));
                    $('country_code').value = $('country_code').getAttribute('set');
                    fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
                }
                catch (e)
                {
                    alert(e);
                }

            });
        }});
    }

    function fGetCRC() {
        var f = $N('wForm')[0];
        //alert ( typeof(f['quotation_no[]'  ].length) + ' /' + f['quotation_no[]'  ].length );
        if ( f['quotation_no[]'  ].length > 1 ) {
            var estiNo = f['quotation_no[]'  ][1].value.replace(/\-/g,'');
            var twinkleInfo = {cssText:'background-color:#BFE2FF;border:1px dotted #CC0000',during:1300,callback:function(){Alert.hide({id:'message_box'});$('message_box.ok').onclick();}};
            if (!estiNo || estiNo.length != 13 ) {
                Effect.twinkle(f['quotation_no[]'][1],twinkleInfo);
                Alert.show({id:'message_box',message:'Please input correct quotation number again.',ok:function(){f['quotation_no[]'][1].focus()}});
                //setTimeout(function(){Alert.hide({id:'message_box'});f['quotation_no[]'][1].focus();},1000);
            } else if ( !f.sales_in_charge.value.trim() ) {
                Effect.twinkle(f.sales_in_charge,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input correct Sales in Charge',ok:function(){f.sales_in_charge.focus()}});
                //setTimeout(function(){Alert.hide({id:'message_box'});f.sales_in_charge.focus();},1000);
            } else if ( !f.name_of_client.value.trim() ) {
                Effect.twinkle(f.name_of_client,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input Name of Client',ok:function(){f.name_of_client.focus()}});
                //setTimeout(function(){Alert.hide({id:'message_box'});f.name_of_client.focus();},1000);
            } else if ( !f.project_name.value.trim() ) {
                Effect.twinkle(f.project_name,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input Project Name',ok:function(){f.project_name.focus()}});
                //setTimeout(function(){Alert.hide({id:'message_box'});f.project_name.focus();},1000);
            } else if ( !f.destination.value.trim() ) {
                Effect.twinkle(f.destination,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input Destination',ok:function(){f.destination.focus()}});
                //setTimeout(function(){Alert.hide({id:'message_box'});f.destination.focus();},1000);
            } else if ( !f.sold_to_party.value.trim() ) {
                Effect.twinkle(f.sold_to_party,twinkleInfo);
                Alert.show({id:'message_box',message:'Please input Sold-to-party',ok:function(){f.sold_to_party.focus()}});
                //setTimeout(function(){Alert.hide({id:'message_box'});f.sold_to_party.focus();},1000);
            } else {
    /**/
                var quotation_date = $('quotation_date').value;
                var expected_delivery_date = $('expected_delivery_date').value;

                var date1 = new Date(parseInt(quotation_date.substr(0,4),10), (parseInt(quotation_date.substr(5,2),10) - 1), parseInt(quotation_date.substr(8,2),10));
                var date2 = new Date(parseInt(expected_delivery_date.substr(0,4),10), (parseInt(expected_delivery_date.substr(5,2),10) - 1), parseInt(expected_delivery_date.substr(8,2),10));
                //alert( dateObj1 );
                //alert( dateObj1 - dateObj2 );
                var btDay = ( date2 - date1 ) / (60 * 60 * 24 * 1000);
                if (btDay < 30 ) {
                    Effect.twinkle(f.quotation_date,twinkleInfo);
                    Effect.twinkle(f.expected_delivery_date,twinkleInfo);
                    Alert.show({id:'message_box',message:'expected_delivery_date >= delivery_date + 30 ',ok:function(){f.sold_to_party.focus()}});
                } else {
                    var l = f['quotation_no[]'].length;
                    //alert( l );
                    if ( l > 0 && l ) {
                        $('alert_box_progress').style.display = "none";
                        //Util.Alert.show({id:'alert_box',message:'Do you want to progress Spec Interface?',ok:fRequestCRC});
                        fRequestCRC();
                    } else {
                        alert('Spec Interface Data is non-exist!');
                    }
                }
            }
        }
    }

    function fRequestCRC() {
        //alert('fRequestCRC');
        var f = $N('wForm')[0];
/*
<ns0:MT_CALKO_CLSC_SRCH_OBJ xmlns:ns0="http://lm-erp.tkeasia.com/SD/CALKO_CLSC_SRCH_OBJ">
   <ZKSSD0001>
      <BSTKD>X0809006201</BSTKD>
      <BSTZD>1</BSTZD>
      <ATNAM>DSA0000</ATNAM>
      <ATWRT>ELEXESS_P17_BL</ATWRT>
   </ZKSSD0001>
</ns0:MT_CALKO_CLSC_SRCH_OBJ>
*/
        var estiNo = f['quotation_no[]'  ][1].value.replace(/\-/g,'');
        var reqXml = '<ns0:MT_CALKO_CLSC_SRCH_OBJ xmlns:ns0="http://lm-erp.tkeasia.com/SD/CALKO_CLSC_SRCH_OBJ">\n';
        var sendL = f['quotation_no[]'].length;
        for (var i=1; i<sendL; i++) {
            reqXml +="   <ZKSSD0001>\n"
                   + "       <BSTKD>" + estiNo                          + "</BSTKD>\n"
                   + "       <BSTZD>" + f['item_no[]'       ][i].value  + "</BSTZD>\n"
                   + "       <ATNAM>" + CRC_GUBUN_CODE                  + "</ATNAM>\n"
                   + "       <ATWRT>" + f['class_name[]'    ][i].value  + "</ATWRT>\n"
                   + "   </ZKSSD0001>\n";
        }
        reqXml += "</ns0:MT_CALKO_CLSC_SRCH_OBJ>\n";
        //alert( reqXml );

        $('area_list' ).style.display = 'inline' ;

        var ajaxR = new asyncConnector('xmlhttp');
        ajaxR.openCallBack= function (str) {
            var xmlDoc=ajaxR.responseXML();
            var pL =xmlDoc.getElementsByTagName("ZKSSD0002N");
            var recvL = pL.length;
            var xmlStr = '';
            try { xmlStr = ajaxR.xmlHttp.responseXML.xml ? ajaxR.xmlHttp.responseXML.xml : (new XMLSerializer()).serializeToString(ajaxR.xmlHttp.responseXML); } catch (e) { }
            //alert(ajaxR.responseXML());
            //alert(xmlStr);
            //alert( recvL  + ' / ' + xmlStr);
            //$('xml_data').value = recvL  + ' / ' + xmlStr;\
            $('xml_data').value = '';

            if ( recvL > 0 ) {
                $('xml_data').value = xmlStr;
                /*
                for (var i=0; i<recvL; i++ ) {
                    var pItem =pL.item(i);
                    xmlStr +=     (pItem.getElementsByTagName("BSTKD").length > 0 && pItem.getElementsByTagName("BSTKD").item(0).firstChild ? pItem.getElementsByTagName("BSTKD").item(0).firstChild.nodeValue:'' )
                           + '/' +(pItem.getElementsByTagName("BSTZD").length > 0 && pItem.getElementsByTagName("BSTZD").item(0).firstChild ? pItem.getElementsByTagName("BSTZD").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("KIND" ).length > 0 && pItem.getElementsByTagName("KIND" ).item(0).firstChild ? pItem.getElementsByTagName("KIND" ).item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("MATNR").length > 0 && pItem.getElementsByTagName("MATNR").item(0).firstChild ? pItem.getElementsByTagName("MATNR").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("SEQNO").length > 0 && pItem.getElementsByTagName("SEQNO").item(0).firstChild ? pItem.getElementsByTagName("SEQNO").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATCNT").length > 0 && pItem.getElementsByTagName("ATCNT").item(0).firstChild ? pItem.getElementsByTagName("ATCNT").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATKLA").length > 0 && pItem.getElementsByTagName("ATKLA").item(0).firstChild ? pItem.getElementsByTagName("ATKLA").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATNAM").length > 0 && pItem.getElementsByTagName("ATNAM").item(0).firstChild ? pItem.getElementsByTagName("ATNAM").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATBEZ").length > 0 && pItem.getElementsByTagName("ATBEZ").item(0).firstChild ? decodeURIComponent(pItem.getElementsByTagName("ATBEZ").item(0).firstChild.nodeValue): '')
                           + '/' +(pItem.getElementsByTagName("ATWRT").length > 0 && pItem.getElementsByTagName("ATWRT").item(0).firstChild ? pItem.getElementsByTagName("ATWRT").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("ATWTB").length > 0 && pItem.getElementsByTagName("ATWTB").item(0).firstChild ? decodeURIComponent(pItem.getElementsByTagName("ATWTB").item(0).firstChild.nodeValue): '')
                           + '/' +(pItem.getElementsByTagName("ATSTD").length > 0 && pItem.getElementsByTagName("ATSTD").item(0).firstChild ? pItem.getElementsByTagName("ATSTD").item(0).firstChild.nodeValue: '')
                           + '/' +(pItem.getElementsByTagName("SNIND").length > 0 && pItem.getElementsByTagName("SNIND").item(0).firstChild ? pItem.getElementsByTagName("SNIND").item(0).firstChild.nodeValue: '') + '\n';
                    //alert ( pItem.getElementsByTagName("BSTKD").item(0).firstChild.nodeValue );
                }
                */
                Util.Alert.hide({id:'wait_box'});

            } else {
                Util.Alert.hide({id:'wait_box'});
                alert('The characteristic code is not receivable from the XI server.\n\nPlease, retry after check name of model.');
                // 구현은했지만 이 루틴으로 넘어올 가능성이 없어보임..
            }
        }

      //var url = 'calko_crc_request.php'; // old
        var url = _url
                + '?op=crc_request'
                + '&p_esti_no=' + estiNo;
        ajaxR.contentType = "application/xml; charset=UTF-8";
        ajaxR.httpOpen('POST', url, true,encodeURIComponent(reqXml), $("area_list"));
        $('wait_box_progress').style.display = "";
        Util.Alert.show({id:'wait_box',message:'Spec Interface <font color=#FF0000>Receiving..</font><BR><BR><font color=#FF0000>Please do not terminate browser.</font>',keydowncancel:false});
        return false;
    }

    function fWrapChange() {
        //alert( $('xml_data').HARD );
        //$('xml_data').wrap = 'hard';
    }
    var _info = {};
    function fGetQuotationNo() {
        var countryCode = $('country_code').value;

        var url  = _url;
        var ajaxR = new asyncConnector('xmlhttp');
        url += '?op=get_max_esti_seq'
            + '&p_country_code=' + countryCode;
        //alert( url );
        ajaxR.httpOpen('GET', url, false);
        //alert( info );
        var info = ajaxR.responseText();
        eval(info);
        //alert(info);
        setTimeout(function() {
            //alert( countryCode + accounting_year + '-' + _info.max_esti_seq + '-01' );
            $('wForm')['quotation_no[]'][1].value = countryCode + accounting_year + '-' + _info.max_esti_seq + '-01';
        },0);
        //fSyncQuotationNo();
    }


    var CRC_GUBUN_CODE  = 'DSA0000';
    var CRC_STANDARD = '1'; // 표준:1, 비표준:2
    var CRC_ITEM_CATEGORY = 'AGC'; // Item Category
//-->
</SCRIPT>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="100%" valign="top">

        <form id="sForm" method="POST" onsubmit="return fGetWrite();">
            <input type=submit style='position:absolute;left:-1000px;top:-1000px'/>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody" style='table-layout:fixed'>
        <colgroup>
            <col width='80'/>
            <col width='250'/>
            <col width='40'/>
            <col width='80'/>
            <col width=''/>
        </colgroup>
        <thead>
            <tr>
            <th colspan="5"><?php print html_xlate("XI Tester"); ?>
<!--
<A HREF="#" onClick="Util.Load.script({src:'lib_inc/js/tke.js.php',type:'js'});return false;">tke.js.php</A> /
<A HREF="#" onClick="Util.Load.script({src:'logic_OS_ELEXESS_P17_BL.js.php',type:'js'});return false;">logic_OS_ELEXESS_P17_BL.js.php</A> /
<A HREF="#" onClick="Util.Load.script({src:'calko_write.js',type:'js'});return false;">calko_write.js</A> /
<A HREF="#" onClick="Util.Load.script({src:'calko_write_form.js',type:'js'});return false;">calko_write_form.js</A> /
<A HREF="#" onClick="Util.Load.script({src:'calko_write.css',type:'css'});return false;">calko_write.css</A> /

-->
            </th>
            </tr>
            <tr>
            <td style='text-align:center'><?php print html_xlate("Esti No"); ?></td>
            <td>&nbsp;
<?
$option = array();
$option ['1'] = 'Spec InterFace';
$option ['2'] = 'Spec InterFace1';

$creategory_setup['select'          ] = '1';
$creategory_setup['prop_name'       ] = 's_option';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " id=s_option onchange='fSearch();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$option['setup'] = $creategory_setup;
print createGory ('RADIO', $option);
?>
            </td>

            <!-- <td>&nbsp;<?php print "<input type=text name=s_esti_no id=s_esti_no style='width:90%;ime-mode:active' maxlength=15 autocomplete=off value='" . substr($default_esti_no,0,6) . '-' . substr($default_esti_no,6,5) . '-' . substr($default_esti_no,11) . "'>";?></td> -->
            <!-- <td align=center><?php print html_xlate("Seq"); ?></td>
            <td width='100'>&nbsp;<?php print "<input type=text name=s_seq id=s_seq style='width:70%;ime-mode:active;text-align:center' maxlength=15 size='3' autocomplete=off value='1'>";?></td> -->
            <td>
            <!-- <input type=button onclick='fOpenSpecWrite();' value='<?=xlate("Spec Interface")?>' class='button1'/> -->
            <input type=button id=s_button onclick='fSearch();' value='<?=xlate("Search")?>' class='button1'/>
            </td>
            </tr>
        </thead>
    </table>
</form>
    </td>
    </tr>
    <tr>
    <td colspan="2"><hr /></td>
    </tr>
</table>
<span id='area_list'></span>
<span id='area_write'></span>
<span id='area_quick_list'></span>

<iframe id='download_iframe' frameborder=0 scrolling=no style='z-index:100;position:absolute;display:none'></iframe>
<iframe id='view_iframe_log' frameborder=0 scrolling=no style='z-index:100;position:absolute;display:none'></iframe>
<iframe id='view_iframe' frameborder=0 scrolling=no style='z-index:100;position:absolute;display:none'></iframe>
<?
    require("../inc/message_box.php");
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var loading = new loadingDisplay('<?=SERVICE_DIR?>/common/js/ajax-loader.gif','image');
//loading.show();
loading.setTarget(document.documentElement);
loading.setSize('80px','10px');
//-->
</SCRIPT>
<?
    $db->release();
    require("../inc/footer.php"); // footer

} // end if [op=="default"]
else if ( $op == "get_spec_interface") { // 조회
?>
<form id="wForm" name="wForm" method="POST" onsubmit="return false;">
<input name="quotation_no[]"    type="hidden" value="">
<input name="item_no[]"         type="hidden" value="">
<input name="qty[]"             type="hidden" value="">
<input name="class_name[]"      type="hidden" value="">
<input name="standard[]"        type="hidden" value="">
<input name="category[]"        type="hidden" value="">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style='padding:3px 3px 3px 3px;vertical-align:top'>
    <tr>
    <td width="100%" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class=tbl id=tbl style='width:655px'>
        <colgroup>
            <col width='100' />
            <col width='180'/>
            <col width='130'/>
            <col width='180'/>
            <col width=''/>
        </colgroup>
        <thead>
            <tr>
            <td class=L1><?print xlate('Quotation Date')?></td>
            <td class=D1>&nbsp;
            <input type="text" readonly class='date' size=5 id="quotation_date" name="quotation_date"
            value='<?=date('Y-m-d')?>'> <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('wForm').quotation_date,'yyyy-mm-dd',this)">
            </td>
            <td class=L1><?print xlate('Expected Delivery Date')?></td>
            <td class=D1>&nbsp;

            <input type="text" readonly class='date' size=5 id="expected_delivery_date" name="expected_delivery_date"
            value='<?=substr(getDateAdd (date('Y-m-d'), 'DAY', 30 ),0,10)?>'> <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('wForm').expected_delivery_date,'yyyy-mm-dd',this)">
            </td>
            <td>&nbsp;</td>
            </tr>

            <tr>

            <td class=L1><?print xlate('Sales in Charge')?></td>
            <td class=D1>&nbsp;
            <?php print "<input type=text name=sales_in_charge style='width:85%;' maxlength=10 autocomplete=auto value='" . $memInfor['user_name']. "' class='input_basic' style='ime-mode:disabled'>";?>
            </td>
            <td class=L1><?print xlate('Name of Client')?></td>
            <td class=D1>&nbsp;
            <?php print "<input type=text name=name_of_client style='width:85%;' maxlength=10 value='test' style='ime-mode:disabled'>";?>
            </td>

            <td>&nbsp;</td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Project Name')?></td>
            <td class=D1>&nbsp;
            <?php print "<input type=text name=project_name style='width:85%;' maxlength=10 value='test' style='ime-mode:disabled'>";?>
            </td>
            <td class=L1><?print xlate('Sold-to-party')?></td>
            <td class=D1>&nbsp;
            <?php print "<input type=text id=sold_to_party name=sold_to_party style='width:85%;border:0px solid #FFFFFF;background-color:transparent' value='' readonly>";?>
            </td>

            <td>&nbsp;</td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Country')?></td>
            <td class=D1>&nbsp;
<?
$creategory_setup['select'          ] = ($memInfor[user_id]=='test'?'XX':'');
$creategory_setup['prop_name'       ] = 'country_code';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " style='width:154px' onchange='fChangeCountry($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"),fGetQuotationNo);'". " set='" . $r->COUNTRY_CODE .  "'"; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$countrys['setup'] = $creategory_setup;
echo createGory ('SELECT', $countrys);
?>
            </td>
            <td class=L1><?print xlate('Destination')?></td>
            <td class=D1>&nbsp;
<?
$creategory_setup['select'          ] = ($memInfor[user_id]=='test'?'TEST DESTINATION':'');
$creategory_setup['prop_name'       ] = 'destination';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " style='width:154px' onchange='fChangeDestination($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"));'". " set='" . $r->DESTINATION .  "'"; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$destinations['setup'] = $creategory_setup;
echo createGory ('SELECT', $destinations);
?>
            </td>

            <td>&nbsp;</td>
            </tr>
        </thead>
    </table>

    </td>
    </tr>

    <tr>
    <td colspan="2"><hr /></td>
    </tr>

    <tr>
    <td width="100%" valign="top" align=left style='padding-left:9px'>
    <div style='border:1px solid #828282;overflow-x:hidden;overflow-y:hidden;width:659px;height:35px;text-align:left'>
    <table xmlns="http://www.w3.org/1999/xhtml" width="100%" cellspacing="0" cellpadding="0" border="0" style="margin: 0px; text-align: left;" id="tbl2" class="tbl2">
        <colgroup>
            <col width="80" />  <!-- Quotation No -->
            <col width="100" />
            <col width="50" />   <!-- Item No -->
            <col width="40" />
            <col width="25" />  <!-- Qty -->
            <col width="40" />
            <col width="70" />  <!-- Elevator Class Name -->
            <col width="150" />
            <col width="" />
        </colgroup>

         <tbody>
        <tr style="cursor: pointer; height: 24px;" class="odd_row"><td class="L1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);">Quotation No</td><td class="D1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);"><input type="text" style="ime-mode: disabled;" autocomplete="off" onfocus="tableUtil.row.activate(this.parentNode.parentNode)" value="XX0910-00001-01" maxlength="15" name="quotation_no[]" /><input type="hidden" value="1" name="standard[]" /><input type="hidden" value="AGC" name="category[]" /></td><td class="L1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);">Item No</td><td class="D1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);"><input type="text" style="text-align: center; background-color: transparent; border: 0pt none;" autocomplete="off" onfocus="tableUtil.row.activate(this.parentNode.parentNode)" maxlength="2" value="" name="item_no[]" readonly="readonly" /></td><td class="L1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);">Qty</td><td class="D1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);"><input type="text" style="text-align: center;" autocomplete="off" onfocus="tableUtil.row.activate(this.parentNode.parentNode)" maxlength="4" value="1" name="qty[]" /></td><td class="L1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);">Class Name</td><td class="D1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);"><select autocomplete="off" onfocus="tableUtil.row.activate(this.parentNode.parentNode)" value="OS_ELEXESS_P17_BL" type="text" name="class_name[]" style=""><option value="OS_ELEXESS_P17_BL">OS_ELEXESS_P17_BL</option><option value="OS_ELEXESS_P20_OV">OS_ELEXESS_P20_OV</option><option value="OS_ELEXESS_HS">OS_ELEXESS_HS</option><option value="OS_ELEJET_S">OS_ELEJET_S</option><option value="OS_ELEJET_II">OS_ELEJET_II</option><option value="OS_EVOLUTION_II">OS_EVOLUTION_II</option><option value="OS_SYNERGY_S">OS_SYNERGY_S</option></select></td><td class="D1 bd" style="background-color: LightSteelBlue; color: rgb(0, 0, 0);"> </td></tr></tbody>
    </table>
    </div>
    <div style='border:1px solid #828282;width:659px;vertical-align:middle;padding-top:5px;padding-bottom:5px'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style='margin-left:5px;'>
        <tr>
        <td colspan=11 align=left>
        <button onclick='fGetCRC();' class=button1>Spec Interface</button>
        <!-- <button onclick='fWrapChange();' class=button1>WRAP OFF</button> -->
        &nbsp;
        </td>
        </tr>
    </table>
    </div>
    </td>
    </tr>
</table>
</form>
<textarea WRAP=HARD id=xml_data rows="4" style='font-size:9pt;margin-left:10px;width:659px;height:150px;display:inline;overflow-x:scroll;'
>
</textarea>
<?
} // end if [op=="get_option_list"]
else if ( $op == "crc_request") {
    $v = urldecode($GLOBALS['HTTP_RAW_POST_DATA']);
    if ( $v ) {
        header("content-type: application/xml; charset=UTF-8");
        //echo $v;

        //print ( get_url_fsockopen( "http://172.17.160.175/sapclasses/calko_clc_return.php",$GLOBALS['HTTP_RAW_POST_DATA'],"text/xml; charset=UTF-8") ); // POST
        print ( get_url_fsockopen( "http://" . XI_SERVER_IP . ":8000/sap/xi/adapter_plain?namespace=http%3A//lm-erp.tkeasia.com/SD/CALKO_CLSC_SRCH_OBJ&interface=MI_CALKO_CLSC_SRCH_OBJ&service=" . XI_SERVICE_ID . "&party=&agency=&scheme=&QOS=BE&sap-user=pisuper&sap-password=tkd12345&sap-client=001&sap-language=EN",$v,"text/xml; charset=UTF-8") ); // POST
    }
} // end if [op=="crc_request"]
else if ( $op == "get_max_esti_seq") { // 조회
    $db->getConnect();
    $p_country_code = $_REQUEST['p_country_code'];
    if ( $p_country_code ) {
        $sql = "SELECT                                        \n"
             . "CAST(MAX(ESTI_SEQ) + 1 AS UNSIGNED)  ESTI_SEQ \n"
             . "FROM                                          \n"
             . "(                                             \n"
             . "    SELECT                                    \n"
             . "        ESTI_NO,                              \n"
             . "        SUBSTR(ESTI_NO,1,2 ) COUNTRY_CODE   , \n"
             . "        SUBSTR(ESTI_NO,3,4 ) ACCOUNTING_YEAR, \n"
             . "        SUBSTR(ESTI_NO,7,5 ) ESTI_SEQ       , \n"
             . "        SUBSTR(ESTI_NO,12,2) ESTI_SUB_SEQ     \n"
             . "    FROM tbl_calko_header                     \n"
             . "    WHERE SUBSTR(ESTI_NO,1,2 ) = '" . $p_country_code . "'         \n"
             . "    AND   SUBSTR(ESTI_NO,3,4 ) = '" . ACCOUNTING_YEAR . "'\n"
             . ") a                                           \n"
           //. "WHERE a.COUNTRY_CODE = 'AA'                   \n"
        ;
        $max_esti_seq =$db->get($sql)->ESTI_SEQ;
    }
    //echo 'max_esti_seq :' . $max_esti_seq . '<BR>';
    $max_esti_seq = $max_esti_seq?str_pad($max_esti_seq, 5, "0", STR_PAD_LEFT):'00001';
    echo '_info.max_esti_seq = "' . $max_esti_seq . '"';
    $db->release();
?>
<?php
} // end if [op=="display"]
} // end grant
} // end login
?>
