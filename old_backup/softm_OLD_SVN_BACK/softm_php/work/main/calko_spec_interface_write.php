<?
/*
 Filename       : /calko/calko_spec_interface_write.php
 Fuction        : Characteristic Code 조회
 Comment        :
 Make   Date    : 2009-08-21,
 Update Date    : 2009-11-27, v1.0 first
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
require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form

require_once SERVICE_DIR . '/common/Session.php';
$memInfor = Session::getSession();
$op = strtolower(trim($_REQUEST["op"])) ;
$op = !$op?'default':$op                ;   // Process parameter [display, save]
$db = new DB (); // db instance

if ( $op == 'default' ) $backurl = $_GET['backurl']?$_GET['backurl']:$REQUEST_URI ;
if ( $backurl ) Session::setSession('backurl',$backurl);
$backurl = Session::getSession('backurl');

$backurl = Session::getSession('backurl');
if ( $memInfor['login_yn'] != 'Y' ) {
    redirectPage( "/" );
} else {
if ( Session::getSession('agreement') == 'N' ) {
    redirectPage( "calko_terms_n_conditions.php" );
} else if ( !$grant[$_SERVER['PHP_SELF']][$memInfor[user_level]] ) {
    require_once '../inc/inner_header.php'; // header
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
?>
<link type="text/css" rel="stylesheet" href="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="<?=BASE_DIR?>/inc/calko.js.php"></script>
<SCRIPT type="text/javascript" src="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<SCRIPT type="text/javascript" src="<?=SERVICE_DIR?>/common/js/masks.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!--
    var _info = {};
    var _url = '<?print $_SERVER['PHP_SELF']?>';
    var destGory = {};

    function fGetDefaultUI(s) {
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = _url;
        var params = 'op=get_default_ui';
        Util.Load.script({src:'calko_common.php?op=get_country_json',type:'js',callback:function(){
            ajaxR.httpOpen('POST', url, false,params, $("area_list"));
            ajaxR.dataArea.innerHTML = ajaxR.responseText();
            loading.hide();
            $('area_list' ).style.display = 'inline' ;
            $('area_write').style.display = 'none'   ;
            if ( document.all ) {
                Util.Load.script({src:"calko_spec_interface_write.js",type:'js',callback:setTimeout(function(){
                    fSetCountryToCombo($('country_code'));
                    $('country_code').value = $('country_code').getAttribute('set') + '';
                    fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
                    fAddRow();
                    },1000)});
            } else {
                Util.Load.script({src:"calko_spec_interface_write.js",type:'js',callback:function(){
                    fSetCountryToCombo($('country_code'));
                    $('country_code').value = $('country_code').getAttribute('set') + '';
                    fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
                    fAddRow();
                    }});
            }
        }});
        _s = s;
        loading.show(document.documentElement);
        loading.setPos(0,'100px');
    }
    function fLoadCountry() {
        var prototype = destGory.constructor.prototype;
        for ( var cCode in destGory) {
            if (cCode in prototype) continue;
            if (destGory instanceof Array && isNaN(cCode)) continue;
            $('country_code').options[$('country_code').length] = new Option(destGory[cCode][0].country_en_code,destGory[cCode][0].country_code);
        }
    }

    var accounting_year = '<?=ACCOUNTING_YEAR?>';

    window.onload = function() {
        document.title = 'Spec Interface';
        fGetDefaultUI();
    }


var class_name_gory = new Array();
<?
    $db->getConnect();
    $class_name_gory = getClassName();
    foreach( $class_name_gory as $k => $v) {
        print ( 'class_name_gory.push(new ARRAYITEM("' . $k. '","' . $v. '"));' . "\n" );
    }
    $db->release();
?>
//-->
</SCRIPT>
<span id='area_list'></span>
<span id='area_write'></span>
<SCRIPT LANGUAGE="JavaScript">
<!--
var loading = new loadingDisplay('<?=SERVICE_DIR?>/common/js/ajax-loader.gif','image');
    loading.show();
    loading.setTarget(document.documentElement);
    loading.setSize('80px','10px');
    Util.Load.script({src:"calko_spec_interface_write.css",type:'css'});
//-->
</SCRIPT>
<?
    require("../inc/footer.php"); // footer
} // end if [op=="default"]
else if ( $op == "get_default_ui") { //
?>
<textarea id=xml_data style='width:95%;height:50px;display:none;z-index:10000'></textarea>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style='padding:3px 3px 3px 3px'>
    <tr>
    <td width="100%" valign="top">
<form id="sForm" method="POST" target="" onsubmit="return fGetList(1);" action="/safety/tkek_fos/calko_write.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='80'/>
            <col width='100'/>
            <col width='40'/>
            <col width='80'/>
            <col width=''/>
        </colgroup>
        <thead>
            <tr><th colspan="5">Spec Interface</th></tr>
        </thead>
    </table>
</form>
    </td>
    </tr>
</table>
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
            value='<?=date('Y-m-d')?>'> <!-- <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('wForm').quotation_date,'yyyy-mm-dd',this)"> -->
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
            <td class=D1 colspan=3>&nbsp;
            <?php print "<input type=text name=sales_in_charge style='width:300px;' maxlength=30 autocomplete=auto value='" . $memInfor['user_name']. "' class='input_basic' style='ime-mode:disabled'>";?>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Name of Client')?></td>
            <td class=D1 colspan=3>&nbsp;
            <?php print "<input type=text name=name_of_client style='width:300px;' maxlength=30 value='' style='ime-mode:disabled'>";?>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Project Name')?></td>
            <td class=D1 colspan=3>&nbsp;
            <?php print "<input type=text name=project_name style='width:300px;' maxlength=30 value='' style='ime-mode:disabled'>";?>
            </td>
            </tr>
            <tr>
            <td class=L1><?print xlate('Sold-to-party')?></td>
            <td class=D1 colspan=3>&nbsp;
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
$creategory_setup['script'          ] = ($memInfor[user_id]!='test'?" onchange='fChangeCountry($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"),fChangeCountryCB);'":'onchange="return fTest(this.value);"') . " set='" . ($memInfor[user_id]=='test'?'XX':'') .  "' style='width:75%;'"; // 스크립트

/* 국가 적용 2010년 7월 8일 목요일*/
$creategory_setup['select'          ] = ($memInfor[user_id]=='test'?'XX':$memInfor['country_code']);
$creategory_setup['prop_name'       ] = 'country_code';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = ($memInfor[user_id]!='test'?" onchange='fChangeCountry($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"),fChangeCountryCB);'":'onchange="return fTest(this.value);"') . " set='" . ($memInfor[user_id]=='test'?'XX':$memInfor['country_code']) .  "' style='width:75%;'"; // 스크립트

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
$creategory_setup['script'          ] = ($memInfor[user_id]!='test'?" onchange='fChangeDestination($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"));'":'onchange="return fTest(this.value);"') . " style='width:75%;'"; // 스크립트
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
    <td width="100%" valign="top" align=left>
    <div style='border:1px solid #828282;overflow-x:hidden;overflow-y:scroll;width:664px;height:268px;text-align:left'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class=tbl2 id=tbl2 style='margin:0px;text-align:left''>
        <colgroup>
            <col width='80'/>  <!-- Quotation No -->
            <col width='100'/>
            <col width='50'/>   <!-- Item No -->
            <col width='40'/>
            <col width='25' />  <!-- Qty -->
            <col width='40'/>
            <col width='70'/>  <!-- Elevator Class Name -->
            <col width='150'/>
            <col width='25'/>
            <col width='15'/>
            <col width=''/>
        </colgroup>

         <tbody>
        </tbody>
    </table>
    </div>
    <div style='border:1px solid #828282;width:659px;vertical-align:middle;padding-top:5px;padding-bottom:5px'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style='margin-left:5px;'>
        <tr>
        <td colspan=11 align=left>
        <button onclick='fAddRow();' class=button1>Add</button>&nbsp;
        <button onclick='fDeleteRow(tableUtil.row.sRow);' class=button1>Delete</button>&nbsp;
        <button onclick='fGetCRC();' class=button1>Spec Interface</button>
        &nbsp;
        </td>
        </tr>
    </table>
    </div>
    </td>
    </tr>
</table>
</form>
<?
    require("../inc/message_box.php");
?>
<?php

} // end if [op=="display"]
else if ( $op == "get_country_json") { // 조회
$db->getConnect();

$sql = "SELECT \n"
     . "  COUNTRY_CODE      , \n"
     . "  COUNTRY_EN_NAME   , \n"
     . "  COUNTRY_KR_NAME   , \n"
     . "  DESTINATION       , \n"
     . "  SOLD_TO_PARTY       \n"
     . " FROM tbl_calko_country \n"
     . " WHERE SOLD_TO_PARTY <> '' \n"
     . " ORDER BY COUNTRY_EN_NAME, DESTINATION"
;
$country = array();
$destination = array();
$stmt = $db->multiRowSQLQuery($sql);

$tmpStr = '';
$pre_country_code = '';
$json = array();
$iIdx = 0;
while ($r = $db->multiRowFetch($stmt)) {
    $country_code    = $r->COUNTRY_CODE   ;
    $country_en_code = $r->COUNTRY_EN_NAME;
    $country_kr_code = $r->COUNTRY_KR_NAME;
    $destination     = $r->DESTINATION;
    $sold_to_party   = $r->SOLD_TO_PARTY;
    $countrys[$country_code] = $country_en_code;
    $destinations[$country_code . '-' . $destination .'-' . $sold_to_party] = $destination;

    if ( $tmpStr && $pre_country_code != $r->COUNTRY_CODE ) {
        //echo '탙다.';
        $tmpStr .= ']' . "\n";
        $json[] = $tmpStr;
        $tmpStr  = '';
        $iIdx = 0;
    }
    //echo 'x->ATNAM :' . $x->ATNAM . '<BR>';
    if ( $pre_country_code != $r->COUNTRY_CODE ) {
        $tmpStr = $r->COUNTRY_CODE . ':[';
    }
    $pre_country_code    = $r->COUNTRY_CODE   ;

    $tmpStr .= ($iIdx>0?',':'') . '{' . 'country_code:"' . $country_code . '",country_en_code:"' . $country_en_code . '",country_kr_code:"' . $country_kr_code . '",destination:"' . $destination . '",sold_to_party:"' . $sold_to_party . '"}';
    $iIdx++;
}

if ( $tmpStr ) {
    $tmpStr .= ']' . "\n";
    $json[] = $tmpStr;
}
print ( 'destGory  = {' . implode ( ',', $json) . '};' );
$db->release();
} // end if [op=="get_country_json"]
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
    $max_esti_seq = $max_esti_seq?str_pad($max_esti_seq, 5, "0", STR_PAD_LEFT):'00001';
    echo '_info.max_esti_seq = "' . $max_esti_seq . '"';
    $db->release();
?>
<?php
} // end if [op=="display"]
else if ( $op == "write") {
?>
<?
} // end if [op=="write"]
else if ( $op == "crc_xml_save_check") {
    $db->getConnect();
    $p_esti_no  = str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no

    if (!$p_esti_no ) $errors[] = xlate('Quotation Number is Empty!');
    $m = 'crc_xml_save_check';
    if (empty($errors)) {
        if ( $db->starttransaction() ) {
            if ( $db->count("tbl_calko_header", "ESTI_NO='{$p_esti_no}'") == 0 ) {
                $savedata = array();
                if      ( !trim($_POST['quotation_date'        ])) $errors[] = xlate('quotation_date is error.');
                else if ( !trim($_POST['expected_delivery_date'])) $errors[] = xlate('expected_delivery_date is error.');
                else if ( !trim($_POST['sales_in_charge'       ])) $errors[] = xlate('sales_in_charge is error.');
                else if ( !trim($_POST['name_of_client'        ])) $errors[] = xlate('name_of_client is error.');
                else if ( !trim($_POST['project_name'          ])) $errors[] = xlate('project_name is error.');
                else if ( !trim($_POST['country_code'          ])) $errors[] = xlate('country_code is error.');
                else if ( !trim($_POST['destination'           ])) $errors[] = xlate('destination is error.');
                else if ( !trim($_POST['sold_to_party'         ])) $errors[] = xlate('sold_to_party is error.');

                if (empty($errors)) {
                    $savedata['ESTI_NO'                ] = "'" . $p_esti_no                         . "'";
                    $savedata['QUOTATION_DATE'         ] = "'" . $_POST['quotation_date'        ] . "'";
                    $savedata['EXPECTED_DELIVERY_DATE' ] = "'" . $_POST['expected_delivery_date'] . "'";
                    $savedata['SALES_IN_CHARGE'        ] = "'" . $_POST['sales_in_charge'       ] . "'";
                    $savedata['NAME_OF_CLIENT'         ] = "'" . $_POST['name_of_client'        ] . "'";
                    $savedata['PROJECT_NAME'           ] = "'" . $_POST['project_name'          ] . "'";
                    $savedata['COUNTRY_CODE'           ] = "'" . $_POST['country_code'          ] . "'";
                    $savedata['DESTINATION'            ] = "'" . $_POST['destination'           ] . "'";
                    $savedata['SOLD_TO_PARTY'          ] = "'" . $_POST['sold_to_party'         ] . "'";
                    $savedata['STATE'                  ] = "1"; // CRC요청
                    $savedata['REG_DATE'               ] = "now()";
                    $savedata['REG_USER_ID'            ] = "'" . $memInfor[user_no] . "'";
                    $savedata['REG_USER_EMAIL'         ] = "'" . $memInfor[user_id] . "'";
                    //$errors[] = print_r($_POST,true);
                    if ( !(specHeaderSave('I',$savedata) ) )  $errors[] = xlate('tbl_calko_header insert error!!!');
                }

                if ( empty($errors) ) {
                    $l = sizeof( $_POST['item_no'] );
                    for ($i=0;$i<$l;$i++) {
                        $savedata = array();
                        if      ( (int)$_POST['item_no'][$i] == 0 ) { $errors[] = xlate('Seq is incorrect!'   ); break;}
                        else if ( !trim($_POST['class_name'][$i]) ) { $errors[] = xlate('Model is incorrect!'        ); break;}
                        else if ( (int)$_POST['qty'][$i] == 0     ) { $errors[] = xlate('qty is incorrect!'   ); break;}
                        else if ( !trim($_POST['code'][$i])       ) { $errors[] = xlate('CRC_GUBUN_CODE is non-existence!' ); break;}
                        else if ( !trim($_POST['standard'][$i])   ) { $errors[] = xlate('STANDARD is non-existence!'       ); break;}
                        else if ( !trim($_POST['category'][$i])   ) { $errors[] = xlate('CATEGORY is non-existence!'       ); break;}

                        $savedata['ESTI_NO'     ] = "'" . $p_esti_no                    . "'";
                        $savedata['SEQ'         ] = "'" . $_POST['item_no'   ][$i]   . "'";
                        $savedata['QTY'         ] = "'" . $_POST['qty'       ][$i]   . "'";
                        $savedata['CODE'        ] = "'" . $_POST['code'      ][$i]   . "'";
                        $savedata['VALUE'       ] = "'" . $_POST['class_name'][$i]   . "'";
                        $savedata['STANDARD'    ] = "'" . $_POST['standard'  ][$i]   . "'";
                        $savedata['CATEGORY'    ] = "'" . $_POST['category'  ][$i]   . "'";
                        $savedata['CRC_SEND_DATE'] = "now()";
                        $savedata['SAVE_DATE'   ] = "now()";
                        $savedata['STATE'       ] = "1"; // CRC요청

                        $savedata['REG_DATE'               ] = "now()";
                        $savedata['REG_USER_ID'            ] = "'" . $memInfor[user_no] . "'";
                        $savedata['REG_USER_EMAIL'         ] = "'" . $memInfor[user_id] . "'";
                        $savedata['O_SEQ'                  ] = "'" . $_POST['item_no'   ][$i] . "'";

                        if ( $_POST['item_no'   ][$i] &&
                             $_POST['qty'       ][$i] &&
                             $_POST['code'      ][$i] &&
                             $_POST['class_name'][$i] ) {
                            if ( !(specSave('I',$savedata) ) ) $errors[] = xlate('tbl_calko_result table save error(insert)') . "<BR><BR>". xlate('Please check and retry.') . $db->getErrMsg();
                        } else {
                            $errors[] = xlate('The specific quotation information can not be created.') . "<BR><BR>". xlate('Please check and retry.');
                        }
                    }
                }

                if ( empty($errors) && $db->commit() ) {
                } else {
                    $errors[] = xlate('Data Not Valid!');
                }
            } else {
                $errors[] = xlate('The quotation number has been already created.') . "<BR><BR>". xlate('Please check and retry.');
            }
        } else {
            $errors[] = xlate('Start Transaction Error');
        }

        if ( !empty($errors) ) {
            $errors[] = xlate('Transaction Rollback.');
            $db->rollback();
        }
    }
    if (!empty($errors)) print ('ERROR|'   . $m . '|' . $p_esti_no  . '|' . implode($errors, "<BR>"));
    else                 print ('SUCCESS|' . $m . '|' . $p_esti_no  . '|' . '');
    $db->release();
} // end if [op=="save_exec"]
else if ( $op == "crc_xml_save_exec") {
    $db->getConnect();
    $m          = trim($_REQUEST["m"]); // mode [I/U]
    $k          = trim($_REQUEST["k"]); // key
    $m = 'I';

    $xml_data = urldecode($_REQUEST["x"]);
    $xml_data = str_replace(array('<?xml version=\"1.0\"?>','<?xml version=\"1.0\" encoding=\"UTF-8\"?>','xmlns:ns1=\"http://lm-erp.tkeasia.com/SD/CALKO_CLSC_SRCH_OBJ\"'), '', $xml_data);

    if (!$xml_data ) $errors[] = xlate('The XML Data is empty');
    $sRtn = 0;
    if (empty($errors)) {
        $xml = @simplexml_load_string($xml_data);
        $esti_no = '';
        $seq     = '';
        $mat_no  = '';
        $pre_crc_code = '';
        $xmlStr  = '';
        $success = TRUE;
        $chkDup  = FALSE;
        //echo '길이 :' . sizeof($xml->ZKSSD0002N) . '<BR>';
        if ( $db->starttransaction() ) {
            foreach( $xml->ZKSSD0002N as $x ) {
                if ( $esti_no != $x->BSTKD && $x->BSTKD) {
                    //if ( !($success=specHeaderSave(str_replace('-', '', $x->BSTKD))) ) break;
                }

                if ( $xmlStr && $seq != $x->BSTZD ) {
                    $savedata = array();
                    $savedata['ESTI_NO'         ] = "'" . $esti_no  . "'";
                    $savedata['SEQ'             ] = "'" . $seq      . "'";
                    $savedata['MAT_NO'          ] = "'" . $mat_no   . "'";
                    $savedata['PRE_CRC_CODE'    ] = "'" . $pre_crc_code   . "'";
                    $savedata['CRC_XML_DATA'    ] = "'" . $xmlStr   . "'";
                    $savedata['CRC_RECV_DATE'   ] = "now()";
                    $savedata['STATE'           ] = "2"; // CRC수신

                    if ( !($success=specSave('U',$savedata)) ) break;
                    //echo '<textarea>' . ($xmlStr) . '</textarea>';

                    $xmlStr = '';
                }

                //echo 'test :' . $x->BSTKD . ' / ' . $x->BSTZD . '<BR>';
                $esti_no = $x->BSTKD;
                $seq     = $x->BSTZD;
                $mat_no  = $x->MATNR;
                $pre_crc_code = substr($x->ATNAM,0,3);
                $xmlStr .= $x->asXML();
            }
            if ( $success && $esti_no ) {
                $savedata = array();
                $savedata['ESTI_NO'         ] = "'" . $esti_no  . "'";
                $savedata['SEQ'             ] = "'" . $seq      . "'";
                $savedata['MAT_NO'          ] = "'" . $mat_no   . "'";
                $savedata['PRE_CRC_CODE'    ] = "'" . $pre_crc_code   . "'";
                $savedata['CRC_XML_DATA'    ] = "'" . $xmlStr   . "'";
                $savedata['CRC_RECV_DATE'   ] = "now()";
                $savedata['STATE'           ] = "2"; // CRC수신

                $success = specSave('U',$savedata);
                if ( $success ) {
                    $savedata = array();
                    $savedata['ESTI_NO'                ] = "'" . $esti_no . "'";
                    $savedata['STATE'                  ] = "2"; // CRC수신
                    $success = specHeaderSave('U',$savedata);
                    if ( !$success ) $errors[] = xlate('tbl_calko_header update error!!!');
                } else {
                    if ( !$success ) $errors[] = xlate('tbl_calko_result update error!!!');
                }
            }
            if ( $success && $db->commit() ) {
            } else {
                if ( $chkDup ) {
                    $errors[] = xlate('The quotation number has been already created.') . "\n". xlate('Please check and retry.');
                } else {
                    $errors[] = xlate('A problem occured while trying to create Spec Interface Data. Please try again later.');
                }
            }
        } else {
            $errors[] = xlate('A problem has been occured while updating data. Please try again');
        }
        if ( !empty($errors) || !$success ) {
            $db->rollback();
            $success = FALSE;
        }
    }

    if (!empty($errors)) print ('ERROR|'   . $m . '|' . $sRtn  . '|' . implode($errors, "', '"));
    else                 print ('SUCCESS|' . $m . '|' . $sRtn  . '|' . '');
    $db->release();
} // end if [op=="crc_xml_save_exec"]
else if ( $op == "crc_request") {
    $v = urldecode($GLOBALS['HTTP_RAW_POST_DATA']);
    if ( $v ) {
        header("content-type: application/xml; charset=UTF-8");
        print ( get_url_fsockopen( "http://" . XI_SERVER_IP . ":8000/sap/xi/adapter_plain?namespace=http%3A//lm-erp.tkeasia.com/SD/CALKO_CLSC_SRCH_OBJ&interface=MI_CALKO_CLSC_SRCH_OBJ&service=" . XI_SERVICE_ID . "&party=&agency=&scheme=&QOS=BE&sap-user=pisuper&sap-password=tkd12345&sap-client=001&sap-language=EN",$v,"text/xml; charset=UTF-8") ); // POST
    }
} // end if [op=="crc_request"]
else if ( $op == "crc_fail_del_exec") {
    $db->getConnect();
    $p_esti_no  = str_replace('-', '', trim($_REQUEST["p_esti_no"])); // p_esti_no

    if (!$p_esti_no ) $errors[] = xlate('Quotation Number is Empty!');

    $m = trim($_REQUEST["m"]); // mode [I/U]
    $k = trim($_REQUEST["k"]); // key

    $sRtn = 0;
    if (empty($errors)) {
        $cnt = $db->count('tbl_calko_header', "ESTI_NO='{$p_esti_no}'"); // row count
        if ( $cnt == 0 ) $errors[] = xlate('data is not found ( SQL-Delete )');

        if ( $db->starttransaction() ) {
            $sRtn = $db->delete('tbl_calko_header',"ESTI_NO='{$p_esti_no}'");
            $sRtn = $db->delete('tbl_calko_result',"ESTI_NO='{$p_esti_no}'");
            $success = $sRtn !== FALSE;
            if ( $success && $db->commit() ) {
            } else {
                $errors[] = xlate('A problem occured while trying to crate Client User. Please try again later.');
            }
        } else {
            $errors[] = xlate('A problem occured while preparing to crate Client User. Please try again later.');
        }
        if ( !empty($errors) || !$success ) {
            $db->rollback();
            $success = FALSE;
        }
    }

    if (!empty($errors)) print ('ERROR|'   . $m . '|' . $p_esti_no  . '|' . implode($errors, "', '"));
    else                 print ('SUCCESS|' . $m . '|' . $p_esti_no  . '|' . '');
    $db->release();

} // end if [op=="del_exec"]
} // end grant
} // end login
?>