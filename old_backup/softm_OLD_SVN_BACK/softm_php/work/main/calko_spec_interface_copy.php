<?
/*
 Filename       : /calko/calko_spec_interface_copy.php
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
        Alert.show({id:'message_box',message:'This identification is not authorized..'});
    }
//-->
</SCRIPT>
<?
    require_once '../inc/footer.php'; // footer
} else {
if ( $op == 'default' ) {
    $p_esti_no  = str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no
    $p_seq      = (int) $_GET["p_seq"]                          ; // p_seq

    require_once '../inc/inner_header.php'   ; // header
?>
<SCRIPT type="text/javascript" src="<?=BASE_DIR?>/inc/calko.js.php"></script>
<link type="text/css" rel="stylesheet" href="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<SCRIPT type="text/javascript" src="<?=SERVICE_DIR?>/common/js/masks.js"></script>

<SCRIPT LANGUAGE="JavaScript">
<!--
    var _info = {};
    var _url = '<?print $_SERVER['PHP_SELF']?>';
    var p_esti_no = '<?print $p_esti_no;?>';
    var p_seq     = '<?print $p_seq;?>';

    function fGetDefaultUI(s) {
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = _url;
        var params = 'op=get_default_ui'
                   + '&p_esti_no=' + p_esti_no
                   + '&p_seq='     + p_seq
        ;
        Util.Load.script({src:'calko_common.php?op=get_country_json',type:'js',callback:function(){
            ajaxR.httpOpen('POST', url, false,params, $("area_list"));
            ajaxR.dataArea.innerHTML = ajaxR.responseText();
            loading.hide();
            $('area_list' ).style.display = 'inline' ;
            $('area_write').style.display = 'none'   ;
            if ( document.all ) {
                Util.Load.script({src:"calko_spec_interface_copy.js",type:'js',callback:setTimeout(function(){
                    fSetCountryToCombo($('country_code'));
                    $('country_code').value = $('country_code').getAttribute('set');
                    fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
                    $('copy_button').disabled = false;
                    $("new_esti_no").value = fGetQuotationNo();
                    },1000)});
            } else {
                Util.Load.script({src:"calko_spec_interface_copy.js",type:'js',callback:function(){
                    fSetCountryToCombo($('country_code'));
                    $('country_code').value = $('country_code').getAttribute('set');
                    fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
                    $('copy_button').disabled = false;
                    $("new_esti_no").value = fGetQuotationNo();
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
/*
country_code
country_en_code
destination
sold_to_party
*/
            $('country_code').options[$('country_code').length] = new Option(destGory[cCode][0].country_en_code,destGory[cCode][0].country_code);
        }

        if (destGory) {
            $('copy_button').disabled = false;
        }
    }

    var accounting_year = '<?=ACCOUNTING_YEAR?>';
    window.onload = function() {
        document.title = 'Spec Copy';
        fGetDefaultUI();
    }

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
    Util.Load.script({src:"calko_spec_interface_copy.css",type:'css'});
//-->
</SCRIPT>
<?
    require("../inc/footer.php"); // footer
} // end if [op=="default"]
else if ( $op == "get_default_ui") { //
    $db->getConnect();
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
            <tr><th colspan="5">Spec Copy</th></tr>
        </thead>
    </table>
</form>
    </td>
    </tr>
</table>
<form id="wForm" name="wForm" method="POST" onsubmit="return false;">
<?
    $p_esti_no  = trim($_POST["p_esti_no"]);
    $p_seq      = trim($_POST["p_seq"    ]);

    $sql = "SELECT \n"
         . "  a.ESTI_NO                  ESTI_NO               , \n"
         . "  a.QUOTATION_DATE           QUOTATION_DATE        , \n"
         . "  a.EXPECTED_DELIVERY_DATE   EXPECTED_DELIVERY_DATE, \n"
         . "  a.SALES_IN_CHARGE          SALES_IN_CHARGE       , \n"
         . "  a.NAME_OF_CLIENT           NAME_OF_CLIENT        , \n"
         . "  a.PROJECT_NAME             PROJECT_NAME          , \n"
         . "  a.COUNTRY_CODE             COUNTRY_CODE          , \n"
         . "  a.DESTINATION              DESTINATION           , \n"
         . "  a.SOLD_TO_PARTY            SOLD_TO_PARTY         , \n"
         . "  a.REG_DATE                 REG_DATE              , \n"
         . "  a.REG_USER_ID              REG_USER_ID           , \n"
         . "  a.REG_USER_EMAIL           REG_USER_EMAIL        , \n"
         . "  b.SEQ                      SEQ                   , \n"
         . "  b.QTY                      QTY                   , \n"
         . "  b.OPT_AMT                  OPT_AMT               , \n"
         . "  b.TP_AMT                   TP_AMT                , \n"
         . "  b.SAVE_XML_DATA            SAVE_XML_DATA         , \n"
         . "  b.CRC_XML_DATA             CRC_XML_DATA          , \n"
         . "  b.SAP_ESTI_NO              SAP_ESTI_NO           , \n"
         . "  b.STATE                    STATE                   \n"
         . " FROM tbl_calko_header a, tbl_calko_result b \n"
         . " WHERE a.ESTI_NO    = b.ESTI_NO\n"
         . " AND " . ( $memInfor['user_level'] >= 2 ?" a.REG_USER_ID <> ''":" a.REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . " AND   a.ESTI_NO    = '{$p_esti_no}'\n"
         . " AND   b.SEQ        = '1'\n"
    ;
    //echo 'sql :' . $sql . '<BR>';
    $r = $db->get($sql);
    $esti_no                = $r->ESTI_NO               ;
    $quotation_date         = $r->QUOTATION_DATE        ;
    $expected_delivery_date = $r->EXPECTED_DELIVERY_DATE;
    $sales_in_charge        = $r->SALES_IN_CHARGE       ;
    $name_of_client         = $r->NAME_OF_CLIENT        ;
    $project_name           = $r->PROJECT_NAME          ;
    $country_code           = $r->COUNTRY_CODE          ;
    $destination            = $r->DESTINATION           ;
    $sold_to_party          = $r->SOLD_TO_PARTY         ;
    $reg_date               = $r->REG_DATE              ;
    $reg_user_id            = $r->REG_USER_ID           ;
    $reg_user_email         = $r->REG_USER_EMAIL        ;
    $seq                    = $r->SEQ                   ;
    $total_unit             = $r->QTY                   ;
    $opt_amt                = $r->OPT_AMT               ;
    $tp_amt                 = $r->TP_AMT                ;
    $crc_xml_data           = $r->CRC_XML_DATA          ;
    $save_xml_data          = $r->SAVE_XML_DATA         ;
    $sap_esti_no            = $r->SAP_ESTI_NO           ;
    $state                  = $r->STATE                 ;

?>
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
            <?php print "<input type=text name=sales_in_charge style='width:85%;' maxlength=20 autocomplete=off value='" . $sales_in_charge ."'>";?>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Name of Client')?></td>
            <td class=D1 colspan=3>&nbsp;
            <?php print "<input type=text id=name_of_client name=name_of_client style='width:85%;' maxlength=20 value='" . $name_of_client. "'>";?>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Project Name')?></td>
            <td class=D1 colspan=3>&nbsp;
            <?php print "<input type=text name=project_name style='width:85%;' maxlength=20 value='" . $project_name. "'>";?>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Sold-to-party')?></td>
            <td class=D1 colspan=3>&nbsp;
            <?php print "<input type=text id=sold_to_party name=sold_to_party style='width:85%;border:0px solid #FFFFFF;background-color:transparent' value='" . $r->SOLD_TO_PARTY . "' readonly>";?>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Country')?></td>
            <td class=D1>&nbsp;
<?
$creategory_setup['select'          ] = $r->COUNTRY_CODE;
$creategory_setup['prop_name'       ] = 'country_code';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = ($memInfor[user_id]!='test'?" onchange='fChangeCountry($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"));$(\"new_esti_no\").value = fGetQuotationNo();'":'onchange="return fTest(this.value);"') . " set='" . $r->COUNTRY_CODE .  "' style='width:75%;'"; // 스크립트
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
$creategory_setup['select'          ] = $r->DESTINATION;
$creategory_setup['prop_name'       ] = 'destination';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = ($memInfor[user_id]!='test'?" onchange='fChangeDestination($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"));$(\"new_esti_no\").value = fGetQuotationNo();'":'onchange="return fTest(this.value);"') . " set='" . $r->DESTINATION .  "' style='width:75%;'"; // 스크립트
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
    <div style='border:1px solid #828282;width:670px;vertical-align:middle;padding-top:5px;padding-bottom:5px'>
    <table border="0" cellspacing="0" cellpadding="0" style='margin-left:5px;'>
        <tr>
        <th align=left width=60>
        Source :
        </th>
        <td align=left width=100>

        <?php print "<input type=text name=esti_no style='width:120px' class='bgtransparent border0' autocomplete=off value='" . substr($esti_no,0,6) . '-' . substr($esti_no,6,5) . '-' . substr($esti_no,11) ."' readonly>";?>
        </td>
        <td align=left width=50>
        ▶▶▶▶
        </td>
        <th align=left width=50>
        Copy :
        </th>
        <td align=left width=100>
        <?php print "<input type=text name=new_esti_no id=new_esti_no style='width:120px' class='bgtransparent border0' autocomplete=off value='" . substr($esti_no,0,6) . '-' . substr($esti_no,6,5) . '-' . substr($esti_no,11) ."' readonly>";?>
        </td>
        <td align=left width=100>
        <button onclick='fCopy();' class=button1 id=copy_button disabled>Copy</button>&nbsp;
        </td>
        </tr>
    </table>
    </div>
    </td>
    </tr>
</table>
</form>
<?
    $db->release();
    require("../inc/message_box.php");
?>
<?php
} // end if [op=="get_default_ui"]
else if ( $op == "get_max_esti_seq") { // 조회
    $p_country_code = $_GET['p_country_code'];
    $p_esti_no  = str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no
    //if ( sizeof($p_esti_no) ==  ) {
    if ( strlen($p_esti_no) == 13 ) {
        $db->getConnect();
        $sql = "SELECT\n"
             . "    COUNTRY_CODE\n"
             . "FROM tbl_calko_header\n"
             . "WHERE ESTI_NO = '" . $p_esti_no . "'\n"
        ;
        $country_code =$db->get($sql)->COUNTRY_CODE;
        if ( $p_country_code != $country_code ) {
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
            echo '_info.esti_no = "' . $p_country_code . ACCOUNTING_YEAR . $max_esti_seq . '01"';
        } else {
            //XX09100001601
            $sql = "SELECT\n"
                 . " CAST(MAX(SUBSTR(ESTI_NO,12,2)) + 1 AS UNSIGNED) ESTI_SUB_SEQ\n"
                 . " FROM tbl_calko_header\n"
                 . " WHERE SUBSTR(ESTI_NO,1,11 ) = '" . substr($p_esti_no,0,11) . "'\n"
            ;
            //echo '<textarea>' . ($sql) . '</textarea><BR>';
            $max_esti_sub_seq =$db->get($sql)->ESTI_SUB_SEQ;
            $max_esti_sub_seq = $max_esti_sub_seq?str_pad($max_esti_sub_seq, 2, "0", STR_PAD_LEFT):'01';
            echo '_info.esti_no = "' . substr($p_esti_no,0,11) . $max_esti_sub_seq . '"';
        }
        //echo 'max_esti_seq :' . $max_esti_seq . '<BR>';
        $db->release();
    }
?>
<?php
} // end if [op=="get_max_esti_seq"]
else if ( $op == "copy_exec") {
    $db->getConnect();
    $p_esti_no      = str_replace('-', '', trim($_GET["p_esti_no"       ])); // p_esti_no
    $p_new_esti_no  = str_replace('-', '', trim($_GET["p_new_esti_no"   ])); // p_new_esti_no

    if (!$p_esti_no     ) $errors[] = xlate('Old Quotation Number is Empty!');
    if (!$p_new_esti_no ) $errors[] = xlate('New Quotation Number is Empty!');
    $m = 'copy_exec';
    if (empty($errors)) {
        if ( $db->starttransaction() ) {
            if ( $db->count("tbl_calko_header", "ESTI_NO='{$p_new_esti_no}'") == 0 ) {
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
                    $savedata['ESTI_NO'                ] = "'" . $p_new_esti_no                      . "'";
                    $savedata['QUOTATION_DATE'         ] = "'" . $_POST['quotation_date'        ] . "'";
                    $savedata['EXPECTED_DELIVERY_DATE' ] = "'" . $_POST['expected_delivery_date'] . "'";
                    $savedata['SALES_IN_CHARGE'        ] = "'" . $_POST['sales_in_charge'       ] . "'";
                    $savedata['NAME_OF_CLIENT'         ] = "'" . $_POST['name_of_client'        ] . "'";
                    $savedata['PROJECT_NAME'           ] = "'" . $_POST['project_name'          ] . "'";
                    $savedata['COUNTRY_CODE'           ] = "'" . $_POST['country_code'          ] . "'";
                    $savedata['DESTINATION'            ] = "'" . $_POST['destination'           ] . "'";
                    $savedata['SOLD_TO_PARTY'          ] = "'" . $_POST['sold_to_party'         ] . "'";
                    $savedata['STATE'                  ] = "3"; // CRC 수신
                    $savedata['REG_DATE'               ] = "now()";
                    $savedata['REG_USER_ID'            ] = "'" . $memInfor[user_no] . "'";
                    $savedata['REG_USER_EMAIL'         ] = "'" . $memInfor[user_id] . "'";
                    if ( !(specHeaderSave('I',$savedata) ) )  $errors[] = xlate('tbl_calko_header insert error!!!') . $db->getErrMsg() . $db->getLastSql();
                }

                if ( empty($errors) ) {
                    $sql = "INSERT INTO tbl_calko_result "
                         . " ("
                         . " ESTI_NO          ,"
                         . " SEQ              ,"
                         . " QTY              ,"
                         . " CODE             ,"
                         . " VALUE            ,"
                         . " SPECIFICATION    ,"
                         . " STANDARD         ,"
                         . " PRE_CRC_CODE     ,"

                         . " CATEGORY         ,"
                         . " MAT_NO           ,"
                         . " CRC_XML_DATA     ,"
                         . " SAVE_XML_DATA    ,"
                         . " SEND_XML_DATA    ,"
                         . " LOG_XML_DATA     ,"
                         . " TP_XML_DATA      ,"

                         . " OPT_AMT          ,"
                         . " TP_AMT           ,"

                         . " CRC_SEND_DATE    ,"
                         . " CRC_RECV_DATE    ,"
                         . " TP_SEND_DATE     ,"
                         . " TP_RECV_DATE     ,"
                         . " SAVE_DATE        ,"

                         . " SAP_ESTI_NO      ,"

                         . " STATE            ,"

                         . " MARKUP_RATE      ,"
                         . " SGNA_RATE        ,"
                         . " EXCHANGE_RATE    ,"

                         . " REG_DATE         ,"
                         . " REG_USER_ID      ,"
                         . " REG_USER_EMAIL   ,"
                         . " O_SEQ             "

                         . " ) "
                         . " SELECT "
                         . "  '" . $p_new_esti_no . "',"
                         . "  SEQ           ,"
                         . "  QTY           ,"
                         . "  CODE          ,"
                         . "  VALUE         ,"
                         . "  SPECIFICATION ,"
                         . "  STANDARD      ,"
                         . "  PRE_CRC_CODE  ,"

                         . "  CATEGORY      ,"
                         . "  MAT_NO        ,"
                         . "  CRC_XML_DATA  ,"
                         . "  SAVE_XML_DATA ,"
                         . "  ''            ,"
                         . "  ''            ,"
                         . "  ''            ,"

                         . "  0             ,"
                         . "  0             ,"

                         . "  now()         ,"
                         . "  now()         ,"
                         . "  '0000-00-00 00:00:00',"
                         . "  '0000-00-00 00:00:00',"
                         . "  '0000-00-00 00:00:00',"

                         . "  ''            ,"
                         . "  '3'           ," // CRC 수신
                         . "  0.0           ,"
                         . "  0.0           ,"
                         . "  0.0           ,"

                         . "  now(),"
                         . "  '" . $memInfor[user_no] . "',"
                         . "  '" . $memInfor[user_id] . "',"
                         . "  O_SEQ          "
                         . " FROM tbl_calko_result "
                         . " WHERE ESTI_NO ='" . $p_esti_no . "'"
                    ;

                    if ( !$db->exec($sql) ) {
                        $errors[] = xlate('Copy failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
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
    //echo '|' . $_REQUEST['frm_5'];
} // end if [op=="copy_exec"]
} // end grant
} // end login
?>