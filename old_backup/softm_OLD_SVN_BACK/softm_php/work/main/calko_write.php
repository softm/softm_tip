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
$op = strtolower(trim($_GET["op"])) ;
$op = !$op?'default':$op                ;   // Process parameter [display, save]
$db = new DB (); // db instance

if ( $op == 'default' ) $backurl = $_GET['backurl']?$_GET['backurl']:$REQUEST_URI ;
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
    $p_esti_no  = trim($_GET["p_esti_no"])  ;
    $p_seq      = (int) $_GET["p_seq"]; // p_seq
    $p_seq      = $p_seq?$p_seq:1;
    $p_mode     = $_GET["p_mode"]?$_GET["p_mode"]:'';

    $db->getConnect();
    // 최근 견적번호를 조회 기본값으로 설정
    $sql = "SELECT \n"
         . "  ESTI_NO\n"
         . " FROM tbl_calko_header\n"
         . " WHERE " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . ($p_esti_no?" AND ESTI_NO = '" .$p_esti_no . "'" :'')
         . " ORDER BY REG_DATE DESC \n"
         . " \n"
    ;
    //echo 'sql :' . $sql . '<BR>';
    $default_esti_no = $db->get($sql)->ESTI_NO;
    $db->release();
    if ( $p_mode == 'preview' ) require_once '../inc/inner_header.php'   ; // header
    else                        require_once '../inc/header.php'   ; // header
?>
<link rel=stylesheet href='<?=SERVICE_DIR?>/common/js/progressbar/progressbar.css' type='text/css'>

<link rel=stylesheet href='<?=SERVICE_DIR?>/common/js/tabcontent/tabcontent.css' type='text/css'>
<!--[if IE]>
<style type="text/css">
    .textOf {overflow:hidden;text-overflow:ellipsis;}
</style>
<![endif]-->

<script type="text/javascript" src="<?=SERVICE_DIR?>/common/js/json2007.js"></script>
<script type="text/javascript" src="<?=SERVICE_DIR?>/common/js/rsh.js"></script>

<script language="Javascript1.2" type="text/javascript" src="<?=SERVICE_DIR?>/common/js/tabcontent/tabcontent.js">
/***********************************************
* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code

* http://www.dynamicdrive.com/dynamicindex17/tabcontent.htm
***********************************************/
</script>
<script language="Javascript1.2" src="<?=SERVICE_DIR?>/common/js/xml2json.js"></script>

<script language="Javascript1.2" src="<?=SERVICE_DIR?>/common/js/masks.js"></script>
<script language="Javascript1.2" src="calko_write.js"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var _url = '<?print $_SERVER['PHP_SELF']?>';
    var hSeq = 0 ;
    var sIndex = -1;

    window.dhtmlHistory.create();

    var fAddHistory = function(newLocation, historyData) {
        //do something;
        hSeq++;
        //alert( newLocation + ' / ' + historyData );
        dhtmlHistory.add('#' + hSeq, hSeq)
    }


    window.onload = function() {
        Util.Load.script({src:"calko_write.css",type:'css'});
        try {
            $('sForm').s_esti_no.focus();
            $('sForm').reset();
        } catch (e){}
/**/
        var om1 = new Mask('AA####-#####-###');
        om1.attach($('sForm').s_esti_no );
        var om2 = new Mask('###');
        om2.attach($('sForm').s_seq     );
        //$('sForm').s_esti_no.attachEvent( 'onfocus', fQuickQuotationSearch);
        //Util.Load.script({src:'calko_write.js',type:'js',callback:function(){
            if ($('sForm')) {
                $('sForm').s_esti_no.attachEvent( 'onkeyup'   , function(e) { fQuickQuotationSearch(e,'E')});
                $('sForm').s_esti_no.attachEvent( 'ondblclick', function(e) { tmpSearchValue=''; fQuickQuotationSearch(e,'E')});
                $('sForm').s_esti_no.attachEvent( 'onblur'    , fQuickQuotationClear);
                $('sForm').s_project_name.attachEvent( 'onkeyup'   , function(e) { fQuickQuotationSearch(e,'P')});
                $('sForm').s_project_name.attachEvent( 'ondblclick', function(e) { tmpSearchValue=''; fQuickQuotationSearch(e,'P')});
                $('sForm').s_project_name.attachEvent( 'onblur'    , fQuickQuotationClear);
            }
        //}});
        if ($('sForm')) {
            if ($('sForm').s_esti_no.value.trim() == '--') {
                $('sForm').s_esti_no.value = '';
                $('sForm').s_seq.value = '';
            }
        }
        dhtmlHistory.initialize();
        dhtmlHistory.addListener(fAddHistory);
<?
    if ( $memInfor['user_level'] >= 2 ) {
        print("LOGGER_OPTION.display = 'inline';");
    }
    if ( $p_esti_no && $default_esti_no ) {
        print ("fGetWrite({esti_no:'" . $p_esti_no . "',seq:'" . $p_seq . "'});");
    }

?>
        document.title = 'Write Quotation';
    }

    window.onunload = function() {
        if ( editData ) {
            if ( state < 8 ) {
                if ( confirm( 'The contents has been changed.\n\n Do you want to save the data?' ) ) {
                    fSaveExec(false,false);
                }
            }
        }

    }
var COMMON_ARRAY = {};
    COMMON_ARRAY.cop_button = new Array();
    COMMON_ARRAY.control_system = new Array();
    COMMON_ARRAY.door_ground = new Array();
    COMMON_ARRAY.door_typical = new Array();
    COMMON_ARRAY.jamb_ground  = new Array();
    COMMON_ARRAY.jamb_typical = new Array();
<?
    foreach( $cop_buttongory as $k => $v) {
        print ( 'COMMON_ARRAY.cop_button.push(new ARRAYITEM("' . $k. '","' . $v. '"));' . "\n" );
    }

    foreach( $control_systemgory as $k => $v) {
        print ( 'COMMON_ARRAY.control_system.push(new ARRAYITEM("' . $k. '","' . $v. '"));' . "\n" );
    }

    foreach( $door_groundgory as $k => $v) {
        print ( 'COMMON_ARRAY.door_ground.push(new ARRAYITEM("' . $k. '","' . $v. '"));' . "\n" );
    }
    foreach( $jamb_groundgory as $k => $v) {
        print ( 'COMMON_ARRAY.jamb_ground.push(new ARRAYITEM("' . $k. '","' . $v. '"));' . "\n" );
    }
?>
    COMMON_ARRAY.door_typical = COMMON_ARRAY.door_ground;
    COMMON_ARRAY.jamb_typical = COMMON_ARRAY.jamb_ground;
//-->
</SCRIPT>
<?
if ( $p_mode == 'preview' ) {
    print "<form id=sForm method=POST onsubmit=\"return fGetWrite();\">";
    print "<input type=hidden name=s_esti_no id=s_esti_no style='width:90%;ime-mode:active' maxlength=15 autocomplete=off value='" . substr($default_esti_no,0,6) . '-' . substr($default_esti_no,6,5) . '-' . substr($default_esti_no,11) . "'>";
    print "<input type=hidden name=s_seq id=s_seq style='width:85%;ime-mode:active;text-align:center' maxlength=15 autocomplete=off value='{$p_seq}'>";
    print "</form>";
} else {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="100%" valign="top">

        <form id="sForm" method="POST" onsubmit="return fGetWrite();">
            <input type=submit style='position:absolute;left:-1000px;top:-1000px'/>

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody" style='table-layout:fixed'>
        <colgroup>
            <col width='130'/>
            <col width='180'/>
            <col width='40'/>
            <col width='80'/>
            <col width='85'/>
            <col width='140'/>
            <col width=''/>
        </colgroup>
        <thead>
            <tr>
            <th colspan="5"><?php print html_xlate("Quotation"); ?>
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
            <td style='text-align:center'><?php print html_xlate("Calko Quotation No."); ?></td>
            <td>&nbsp;<?php print "<input type=text name=s_esti_no id=s_esti_no style='width:90%;ime-mode:active' maxlength=15 autocomplete=off value='" . substr($default_esti_no,0,6) . '-' . substr($default_esti_no,6,5) . '-' . substr($default_esti_no,11) . "'>";?></td>
            <td align=center><?php print html_xlate("Seq"); ?></td>
            <td width='100'>&nbsp;<?php print "<input type=text name=s_seq id=s_seq style='width:70%;ime-mode:active;text-align:center' maxlength=15 size='3' autocomplete=off value='1'>";?></td>

            <td align=center><?php print html_xlate("Project Name"); ?></td>
            <td width='100'>&nbsp;<?php print "<input type=text name=s_project_name id=s_project_name style='width:90%;ime-mode:active;text-align:left' maxlength=15 size='3' autocomplete=off value=''>";?></td>
            <td>
            <!-- <input type=button onclick='fOpenSpecWrite();' value='<?=xlate("Spec Interface")?>' class='button1'/> -->
            <input type=button id=s_button onclick='fGetWrite();' value='<?=xlate("Search")?>' class='button1'/>
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
<?
}
?>
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
<span id=log_progress class=alert_box style='position:absolute;top:100px;left:100px;width:250px;height:75px;display:none;text-align:center'>
<div id='log_progress.msg1'></div>
<script>
    ProgressBar.display ('log_progress.bar',0,1);
</script>
<span id='log_progress.msg2'></span>
</span>
<?
    require("../inc/footer.php"); // footer
} // end if [op=="default"]
else if ( $op == "search") { // 조회
?>
<?php
} // end if [op=="display"]
else if ( $op == "gen_crc_data") {
    $db->getConnect();
//var crcInfo = {a:'aaa11111111값',b:'bbb1111111값'};
?>
<?
    $p_esti_no  = trim($_GET["p_esti_no"]);
    $p_seq      = trim($_GET["p_seq"    ]);
    $sql = "SELECT \n"
         . "  ESTI_NO       , \n"
         . "  SEQ           , \n"
         . "  VALUE         , \n"
         . "  PRE_CRC_CODE  , \n"
         . "  CRC_XML_DATA  , \n"
         . "  SAVE_XML_DATA , \n"
         . "  STATE           \n" // '사용상태 : 0:초기, 1:CRC요청, 2:CRC수신, 3:저장, 8:TP전송, 9:TP완료'
         . " FROM tbl_calko_result \n"
         . " WHERE ESTI_NO = '{$p_esti_no}'\n"
         . " AND   SEQ     = '{$p_seq}'\n"
       //. " AND " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
    ;
    //echo 'sql :' . $sql . '<BR>';
    $r = $db->get($sql);
    $CLASS_NAME     = $r->VALUE         ;
    $PRE_CRC_CODE   = $r->PRE_CRC_CODE  ;
    $xml_data       = $r->CRC_XML_DATA  ;
    $save_xml_data  = $r->SAVE_XML_DATA ;
    $state          = $r->STATE         ;
    $reg_user_id    = $r->REG_USER_ID   ;

    if ( $xml_data ) {
        //echo 'xml_data :' . $xml_data . '<BR>';
        $xml = simplexml_load_string('<xml>'.$xml_data.'</xml>');
        //echo '<textarea>' . var_dump($xml_data) . '</textarea>';
        //echo '<textarea>' . $xml_data . '</textarea>';
        //echo '' . $xml_data . '';
        $esti_no = '';
        $seq     = '';
        $tmpStr  = '';
        //echo '길이 :' . sizeof($xml->ZKSSD0002N) . '<BR>';
        $success = TRUE;
    /*
    var crcInfo = {
                    DSA5001:[
                                {ATBEZ:'DSA5001:생산기종',ATWRT:'1',ATSTD:'TK-50G',ATSTD:'Y'}
                            ],
                    DSA5002:[
                                {ATBEZ:'DSA5002:TM종류(국산/수입)',ATWRT:'1',ATSTD:'국산',ATSTD:'' },
                                {ATBEZ:'DSA5002:TM종류(국산/수입)',ATWRT:'2',ATSTD:'수입',ATSTD:'Y'}
                            ]
                  };
    //crcInfo.DSA5001[0].ATBEZ
    */
    //var_dump($xml->ZKSSD0002N);
        $json = array();
        $crc_code = '';
        $iIdx = 0;
        $tmpStr = '';
        foreach( $xml->ZKSSD0002N as $x ) {
            if ( $tmpStr && $crc_code != $x->ATNAM ) {
                //echo '탙다.';
                $tmpStr .= ']' . "\n";
                $json[] = $tmpStr;
                $tmpStr  = '';
                $iIdx = 0;
            }
            //echo 'x->ATNAM :' . $x->ATNAM . '<BR>';
            if ( $crc_code != $x->ATNAM ) {
                $tmpStr = $x->ATNAM . ':[';
            }

            $esti_no = $x->BSTKD;
            $seq     = $x->BSTZD;
            $crc_code= $x->ATNAM; // crc code
            // 운영일경우
            //$tmpStr .= ($iIdx>0?',':'') . '{' . 'ATWTB:"' . $x->ATWTB . '",ATWRT:"' . $x->ATWRT . '",ATSTD:"' . $x->ATSTD . '"}';
            // 개발일경우 : 디버깅을위해 : ATBEZ : Characteristic description
            $tmpStr .= ($iIdx>0?',':'') . '{' . 'ATWTB:"' . $x->ATWTB . '",ATWRT:"' . $x->ATWRT . '",ATSTD:"' . $x->ATSTD . '",ATBEZ:"' . $x->ATBEZ . '"}';
            //echo '<textarea>' . ($x->asXML()) . '</textarea>';
            $iIdx++;
        }
        //print ('<textarea style="width:100%;height:300px;">' . (implode ( ',', $json)) . '</textarea>');
        if ( $tmpStr ) {
            $tmpStr .= ']' . "\n";
            $json[] = $tmpStr;
        }
        print ( 'crcInfo  = {' . implode ( ',', $json) . '};' );
        print ( 'state    = "' . $state .'";' );
        print ( 'CLASS_NAME= "' . $CLASS_NAME .'";' );
        print ( 'PRE_CRC_CODE= "' . $PRE_CRC_CODE .'";' );

        //print ( '{' . implode ( ',', $json) . '}' );
    } else {
        print ( 'crcInfo = null;' );
        print ( 'state    = "' . $state .'";' );
        print ( 'CLASS_NAME= "' . $CLASS_NAME .'";' );
        print ( 'PRE_CRC_CODE= "' . $PRE_CRC_CODE .'";' );
    }

    $sql = "SELECT \n"
         . "  COUNT(*) CNT\n"
         . " FROM tbl_calko_result \n"
         . " WHERE ESTI_NO = '{$p_esti_no}'\n"
         . " AND " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
    ;
    //echo 'sql :' . $sql . '<BR>';
    $quotCount = $db->get($sql)->CNT;
    print ( 'QUOTCOUNT = ' . $quotCount . ';' );

/**/
    $db->release();
}
else if ( $op == "write_area") {
    $db->getConnect();
//AA1111-11111-11
    $p_esti_no  = trim($_GET["p_esti_no"]);
    $p_seq      = trim($_GET["p_seq"    ]);
    //$p_seq      = $p_seq?$p_seq:1;
    //echo 'p_seq :' . $p_seq . '<BR>';

    print "<form id='wForm' name='wForm' method='POST' onsubmit='return fSaveExec(false);'>";
    print "<input type=hidden name='p_esti_no' value='{$p_esti_no}'>";
    print "<input type=hidden name='p_seq' value='{$p_seq}'>";
    print "<input type=submit value='Save' style='position:absolute;left:-1000px;top:-1000px'/>";

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
         . "  b.VALUE                    CLASS_NAME            , \n"
         . "  b.SEQ                      SEQ                   , \n"
         . "  b.QTY                      QTY                   , \n"
         . "  b.OPT_AMT                  OPT_AMT               , \n"
         . "  b.TP_AMT                   TP_AMT                , \n"
         . "  b.SAVE_XML_DATA            SAVE_XML_DATA         , \n"
         . "  b.CRC_XML_DATA             CRC_XML_DATA          , \n"
         . "  b.SAP_ESTI_NO              SAP_ESTI_NO           , \n"
         . "  b.MARGIN_RATE              MARGIN_RATE           , \n"
         . "  b.MARKUP_RATE              MARKUP_RATE           , \n"
         . "  b.SGNA_RATE                SGNA_RATE             , \n"
         . "  b.EXCHANGE_RATE            EXCHANGE_RATE         , \n"
         . "  b.STATE                    STATE                   \n"
         . " FROM tbl_calko_header a, tbl_calko_result b \n"
         . " WHERE a.ESTI_NO    = b.ESTI_NO\n"
         . " AND " . ( $memInfor['user_level'] >= 2 ?" a.REG_USER_ID <> ''":" a.REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . " AND   a.ESTI_NO    = '{$p_esti_no}'\n"
         . " AND   b.SEQ        = '{$p_seq}'\n"
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
    $class_name             = $r->CLASS_NAME            ;
    $seq                    = $r->SEQ                   ;
    $total_unit             = $r->QTY                   ;
    $opt_amt                = $r->OPT_AMT               ;
    $tp_amt                 = $r->TP_AMT                ;
    $crc_xml_data           = $r->CRC_XML_DATA          ;
    $save_xml_data          = $r->SAVE_XML_DATA         ;
    $sap_esti_no            = $r->SAP_ESTI_NO           ;
    $margin_rate            = $r->MARGIN_RATE           ;
    $markup_rate            = $r->MARKUP_RATE           ;
    $sgna_rate              = $r->SGNA_RATE             ;
    $exchange_rate          = $r->EXCHANGE_RATE         ;
    $state                  = $r->STATE                 ;

    $sql = "SELECT \n"
         . " OPT_AMT TOTAL_OPT_AMT,\n"
         . " TP_AMT  TOTAL_TP_AMT  \n"
         . " FROM tbl_calko_result\n"
         . " WHERE ESTI_NO    = '{$p_esti_no}'\n"
         . " AND   SEQ        = '{$p_seq}'\n"
         . " AND " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
    ;
    //echo 'sql :' . $sql . '<BR>';
    $amt = $db->get($sql);

    $total_opt_amt = $amt->TOTAL_OPT_AMT;
    $total_tp_amt  = $amt->TOTAL_TP_AMT ;

    $x = array();
    if ( $state >= '3' ) {
        $x = simplexml_load_string('<xml>'.$save_xml_data.'</xml>');
        $quotation_date         = getXValue('quotation_date'        ,$x);
        $expected_delivery_date = getXValue('expected_delivery_date',$x);
        $sales_in_charge        = getXValue('sales_in_charge'       ,$x);
        $name_of_client         = getXValue('name_of_client'        ,$x);
        $project_name           = getXValue('project_name'          ,$x);
        $country_code           = getXValue('country_code'          ,$x);
        $destination            = getXValue('destination'           ,$x);
        $sold_to_party          = getXValue('sold_to_party'         ,$x);
        $total_unit             = getXValue('total_unit'            ,$x);
    } else {
    }
    print "<input type=hidden id='expected_delivery_date' name='expected_delivery_date' value='{$expected_delivery_date}'>";
?>
<TABLE>
<TR>
    <TD>
<div id="countrytabs" class="indentmenu">
<ul>
<li><a href="#" rel="tab1" class="selected" style='width:50px;text-align:center;height:35px'>Page 1</a></li>
<li><a href="#" rel="tab2" style='width:50px;text-align:center;height:35px'>Page 2</a></li>
</ul>
<br style="clear: left" />
</div>
    </TD>
    <TD>
    <TABLE class='a_tbl3' cellpadding=0 cellspacing=0 border=0 style='height:40px;z-index:1;'><!--  position:absolute;left:140px;top:167px;-->
        <tr align=center style='height:20px'>
        <td style='width:90px;text-align:center;background-color:#336699;color:white'>
    Quotation No
        </td>

        <td style='width:110px;text-align:center;background-color:#ffffff'>
    <?php print substr($esti_no,0,6) . '-' . substr($esti_no,6,5) . '-' . substr($esti_no,11) ?>
    <!-- ( <?php print $sap_esti_no?> ) -->
        </td>
        <td style='width:30px;text-align:center;background-color:#336699;color:white'>
    Seq
        </td>

        <td style='width:20px;text-align:center;background-color:#ffffff'>
    <?php print $seq?>
        </td>

        <td style='width:40px;text-align:center;background-color:#336699;color:white'>
    Status
        </td>

        <td style='width:65px;text-align:center;;background-color:#ffffff' nowrap>
        <div style='width:65px;overflow:hidden' class='textOf'><nobr id=quotation_state >
    <?php
        //echo $state;
        if ($state == 'S') {
            //print ( number_format($tp_amt,2) );
            print($calko_stategory[$state]);
        } else if ($state == 'E') {
            print ( 'TP Error' );
        } else if ($state == '8') {
            print ( 'TP Request' );
        } else {
            print ( '-' );
        }
    ?>
        </nobr>
        </div>
        </td>
        <td style='width:60px;text-align:center;background-color:#ffffff'>
    <A HREF="#" onclick='fViewLog();return false;' style='font-size:7pt;font-family:tahoma'><U>View Log</U></A>
        </td>

        <td rowspan=2 style='padding-left:3px;background-color:#ffffff'>
    <?
    $sendTPAble = sendTPAble($p_esti_no);
    $state      = getSpecState($p_esti_no,$p_seq);
    //echo 'state :' . $state . '<BR>';
    ?>
    <input type=button id=btn_save      onclick='fSaveExec(false);' value='<?=xlate("Save")?>' <?=($state <= '3'?' style="width:35px;cursor:pointer;display:inline;"':' disabled style="width:35px;cursor:pointer;display:inline;border:0px solid red;color:gray"')?> class='button1'/>&nbsp;
    <!-- <input type=button id=btn_print     onclick='fPrint();' value='<?=xlate("Print")?>' <?=($state == 'S'?' style="width:35px;color:yellow;cursor:pointer;display:inline;" ':' disabled style="width:35px;cursor:pointer;display:inline;border:0px solid black;color:gray"')?> class='button1'/> -->
    <input type=button id=btn_copy      onclick='fCopy();'  value='<?=xlate("Copy")?>' class='button1' style='width:35px;'/>
    <input type=button id=btn_c_copy    onclick='fCreateCopy();'  value='<?=xlate("Copy in seq")?>' <?=($state <= '3'?' style="width:75px;cursor:pointer;display:inline;" ':' disabled style="width:70px;cursor:pointer;display:inline;border:0px solid black;color:gray"')?> class='button1'/>
    <input type=button id=btn_delete    onclick='fDelete();'  value='<?=xlate("Delete")?>' <?=($state <= '3'?' style="width:40px;cursor:pointer;display:inline;"':' disabled style="width:40px;cursor:pointer;display:inline;border:0px solid red;color:gray"')?> class='button1'/>
    <input type=button id=btn_print     onclick='fPrint();' value='<?=xlate("Print")?>' style="width:35px;color:yellow;cursor:pointer;display:inline;" class='button1'/>
    <input type=button id=btn_spec_send onclick='fSaveExec(true );' value='<?=xlate("Send Spec")?>' <?=($sendTPAble->state?' style="width:70px;color:yellow;cursor:pointer;display:inline;" ':' disabled style="width:70px;cursor:pointer;display:inline;border:0px solid black;color:gray"')?> class='button1'/>
        </td>
        </tr>

        <tr align=center style='height:20px'>
        <td style='width:90px;text-align:center;background-color:#336699;color:white'>
    Price
        </td>

        <td style='text-align:left;background-color:#ffffff' colspan=6 nowrap>
    <?php
        //echo '$total_tp_amt : ' . $total_tp_amt;
        //echo '$exchange_rate : ' . $exchange_rate;

        // 원화일경우.
        $amount = ( $exchange_rate?(($total_tp_amt*TP_MULTIPLE) / $exchange_rate) + ($total_opt_amt / $exchange_rate ):0);
        //$amount = ( $exchange_rate?($total_tp_amt) + ($total_opt_amt / $exchange_rate ):0);

        //echo '$amount : ' . $amount;
        //$amount = $amount * (1+($margin_rate/100)) / 0.9;
        //echo 'ACCOUNTING_YEAR : ' . ACCOUNTING_YEAR. '<BR>';
        //echo '$amount : ' . $amount . '<BR>';
        //echo '$margin_rate : ' . $margin_rate. '<BR>';
        $amount = $amount / (1-($margin_rate/100));

        if ( $memInfor['user_level'] >= 2 ) {
            //echo (1+($margin_rate/100));
    /*
    28900 * 1.1 = 31790
    31790 / 0.9 = 35322.222222222222222222222222222
    28900 + 35322.222222222222222222222222222 = 출력금액
    */
            //₩ $ ￥
            // 원화일겨우
            // print ( '&nbsp;$'   . ( $exchange_rate?number_format(round(($total_tp_amt*TP_MULTIPLE) / $exchange_rate,0)):'0' ) . ' (<font color=#3366FF><A HREF="#" onclick="fViewTP();return false;"><U>TP</U></A></font>) +' );

            print ( '&nbsp;$'   . number_format(round(( $exchange_rate?(($total_tp_amt*TP_MULTIPLE) / $exchange_rate):0 ),0)) . ' (<font color=#3366FF><A HREF="#" onclick="fViewTP();return false;"><U>TP</U></A></font>) +' );

            print ( '&nbsp;$'   . ( $exchange_rate?number_format($total_opt_amt / $exchange_rate ):'0' ). ' (<font color=#3366FF><U><A HREF="#" onclick="fViewOPTION();return false;">OPTION</A></U></font>)' );
          //print ( '&nbsp;=$'  . ( $exchange_rate?number_format(round($total_tp_amt + ($total_opt_amt / $exchange_rate ),0)):'-') . '' );
            print ( '&nbsp;= USD'  . number_format(round($amount,0)) . '' . ' (EX-WORKS)' );


            print ( '&nbsp;[ <a href="#" onclick="fDownLoadXML(\'send\');return false;" >send xml</a> / ');
            print ( '<a href="#" onclick="fDownLoadXML(\'tp\');return false;" >tp xml</a> ]');

        } else {
          //print ( '&nbsp;<font style="font-weight:bold;font-size:11pt;color:#990000">$' . ( $exchange_rate?number_format(round($total_tp_amt + ($total_opt_amt / $exchange_rate ),0)):'-') . '' ) . '</font>';
            print ( $state=='S'?'&nbsp;<font style="font-weight:bold;font-size:11pt;color:#990000">USD' . number_format(round($amount,0)) . ''. ' (EX-WORKS)':'&nbsp;-' ) . '</font>';
        }


    ?>


        </td>
        </tr>
    </TABLE>
    </TD>
</TR>
</TABLE>
<div id='save_state_box' style='position:absolute;top:208px;left:901px;display:inline;vertical-align:middle;background-color:transparent' onmouseover='fChangeZIndex(event,"save_state_box")' onmouseover='fChangeZIndex(event,"save_state_box")'>
</div>

<div id="tab1" class="tabcontent" style='border:1px solid gray; margin-bottom: 1em; padding: 10px;height:1000px;width:900px'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="a_tbl" id='tbl1' style='padding:0px;margin:0px' align=left>
        <colgroup>
            <col width='15%'/>
            <col width='20%'/>
            <col width='10%'/>
            <col width='25%'/>
            <col width='15%'/>
            <col width='15%'/>
        </colgroup>
<!--
    <tr>
        <th>Sales in Charge:</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
        <th>Name of Client: </th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
    </tr>
-->
        <tr><td class='i1 bs' >Sales in Charge           </td><td class='i2 ld bs' ><INPUT TYPE="text" id="sales_in_charge" class='input_basic' set='<?print $sales_in_charge?>' maxlength=10 attr='readonly:"true"'>    </td><td class='i3 ld rs bs' >&nbsp;</td><td class='i4 rd bs' >Name of Client   </td><td class='i5 bs'><INPUT TYPE="text" id="name_of_client" class='input_basic' set='<?print $name_of_client?>' readonly></td><td class='i6 ld bs'>&nbsp;</td></tr>
        <tr><td class='i1 bs' >Project Name              </td><td class='i2 ld bs' ><INPUT TYPE="text" id="project_name" class='input_basic' set='<?print $project_name?>' readonly>       </td><td class='i3 ld rs bs' >&nbsp;</td><td class='i4 rd bs' >APPLIED CODE     </td>
        <?$E5007 = getXValue('E5007',$x);?>
        <td class='i5 bs' ><span id=E5007 set='<?print $E5007?>'></span> </td><td class='i6 ld bs' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>Country                   </td><td class='i2 ld bs2'><?
$sql = "SELECT \n"
     . "  COUNTRY_CODE   , \n"
     . "  COUNTRY_EN_NAME, \n"
     . "  COUNTRY_KR_NAME  \n"
     . " FROM tbl_calko_country \n"
     . " ORDER BY COUNTRY_EN_NAME "
;
$country_codegory = array();

$stmt = $db->multiRowSQLQuery($sql);
while ($r = $db->multiRowFetch($stmt)) {
    $country_codegory[$r->COUNTRY_CODE] = $r->COUNTRY_EN_NAME;
}

$creategory_setup['select'          ] = $country_code;
$creategory_setup['prop_name'       ] = 'country_code';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " id=country_code set='" . $country_code . "' disabled "  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$country_codegory['setup'] = $creategory_setup;
//print createGory ('SELECT', $country_codegory);
print $country_codegory[$country_code];

//print listbox("country_code",$country_codegory, " id=country_code set='" . $country_code . "' disabled", $country_code);
?>
<INPUT TYPE="hidden" id="country_code" class='input_basic' value='<?print $country_code?>'>
        </td><td class='i3 ld rs bs2'>&nbsp;</td><td class='i4 rd bs2'>Destination      </td><td class='i5 bs2'><INPUT TYPE="text" id="destination" class='input_basic' value='<?print $destination?>' readonly></td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr>
        <td class='i1 bs2'>1. Lift Nos</td>
        <td class='i2 ld bs2' ><INPUT TYPE="text" id="lift_nos" class='input_basic' value='<?print getXValue('lift_nos',$x)?>' maxlength=20 style='ime-mode:disabled' onkeydown='this.value=this.value.toUpperCase();' onchange='this.value=this.value.toUpperCase();'></td>
        <td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2'>&nbsp;</td>
        <td class='i5 bs2'>&nbsp;</td>
        <td class='i6 ld bs2'>&nbsp;</td>
        </tr>

        <tr>
        <td class='i1 bs2'>2. Building Type</td>
        <td class='i2 ld bs2' ><?
        $creategory_setup['select'          ] = '';
        $creategory_setup['prop_name'       ] = 'building_type';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('building_type',$x) . "' class='select_basic'"  ; // 스크립트
      //$building_typegory = array();
        $building_typegory['setup'] = $creategory_setup;
        print createGory ('SELECT', $building_typegory);
        ?>
        </td>
        <td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2'>DATE</td>
        <td class='i5 bs2'><INPUT TYPE="text" id="quotation_date" class='input_basic' set='<?print $quotation_date?>' readonly> </td>
        <td class='i6 ld bs2'>&nbsp;</td>
        </tr>

        <tr><td class='i1'    >3. General Data  </td><td class='i2 ld bd' >Specification    </td><td class='i3 ld rs bd'>&nbsp;</td><td class='i4 rd bd'><INPUT TYPE="text" id="specification"   class='input_basic' set='<?print getXValue('specification',$x)?>' readonly>   </td><td class='i5 bd'><span id=E5000 set='<?print getXValue('E5000',$x)?>' attr='disabled:"true"'></span>
        </td><td class='i6 ld bd'>&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Total Unit(s)    </td><td class='i3 ld rs bd'>&nbsp;</td><td class='i4 rd bd'><INPUT TYPE="text" id="total_unit"      class='input_basic' set='<?print $total_unit?>' readonly>                       </td><td class='i5 bd'>&nbsp;                                     </td><td class='i6 ld bd'>&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Use              </td><td class='i3 ld rs bd'>&nbsp;</td><td class='i4 rd bd'><SELECT id="use" set='<?print getXValue('use',$x)?>' class='select_basic'><option value='Passenger'>Passenger</option></SELECT>         </td><td class='i5 bd'>&nbsp;                                     </td><td class='i6 ld bd'>&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Code of fireman lift if applicable</td><td class='i3 ld rs bd' >&nbsp; </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '';
        $creategory_setup['prop_name'       ] = 'code_of_fireman_lift';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('code_of_fireman_lift',$x) . "' class='select_basic'"  ; // 스크립트
        $code_of_fireman_liftgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $code_of_fireman_liftgory);
        ?>
        <!-- 방화도어 정리 이후 결정 -->
        </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Capacity                         </td><td class='i3 ld rs bd' >[kg]   </td><td class='i4 rd bd' ><span id=E5005 set='<?print getXValue('E5005',$x)?>'></span> </td><td class='i5 bd' ><INPUT TYPE="text" id="passengers" class='input_basic' set='<?print getXValue('passengers',$x)?>' readonly></td><td class='i6 ld bd' >Passengers</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Speed / Velocity                 </td><td class='i3 ld rs bd' >[m/min]</td><td class='i4 rd bd' ><span id=E5006 set='<?print getXValue('E5006',$x)?>'></span> </td><td class='i5 bd' ><INPUT TYPE="text" id="velocity" class='input_basic' set='<?print getXValue('velocity',$x)?>' readonly></td><td class='i6 ld bd' >m/s</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Type of Openings                 </td><td class='i3 ld rs bd' >&nbsp; </td><td class='i4 rd bd' ><span id=E5020 set='<?print getXValue('E5020',$x)?>'></span>                     </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Fire resistance application      </td><td class='i3 ld rs bd' >&nbsp; </td><td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '';
        $creategory_setup['prop_name'       ] = 'fire_resistance_application';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('fire_resistance_application',$x) . "' class='select_basic'"  ; // 스크립트
        $fire_resistance_applicationgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $fire_resistance_applicationgory);
        ?>
<!-- 미결정 , 추후 결정
방화도어
30,60,120분
PUBEL은 120준 적용 없음
PUBEL WITTUR 도어만 적용
기타 방화도어 TKEK 표준으로 진행 -->
        </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Openings / Floors                </td><td class='i3 ld rs bd' >&nbsp; </td><td class='i4 rd bd' ><span id=E5009 set='<?print getXValue('E5009',$x)?>' attr='numberonly:"true",maxlength:2'></span>                     </td><td class='i5 bd' ><span id=E5008 set='<?print getXValue('E5008',$x)?>' attr='numberonly:"true",maxlength:2'></span></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Control System                   </td><td class='i3 ld rs bd' >&nbsp; </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '';
        $creategory_setup['prop_name'       ] = 'control_system';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('control_system',$x) . "' class='select_basic'"  ; // 스크립트
      //$control_systemgory = array();
        $control_systemgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $control_systemgory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Operation                        </td><td class='i3 ld rs bd' >&nbsp; </td><td class='i4 rd bd' ><span id=E5015 set='<?print getXValue('E5015',$x)?>'></span>                     </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Travel                           </td><td class='i3 ld rs bd' >[mm]   </td><td class='i4 rd bd' ><span id=E5012 set='<?print getXValue('E5012',$x)?>' attr='numberonly:"true",min:0,max:50000'></span>                     </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Overhead                         </td><td class='i3 ld rs bd' >[mm]   </td><td class='i4 rd bd' ><span id=E5010 set='<?print getXValue('E5010',$x)?>' readonly=true></span>                     </td><td class='i5 bd' >&nbsp;<!-- car height 2300, if less - reduce DTA5010 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;           </td><td class='i2 ld bs2'>Pit                              </td><td class='i3 ld rs bs2'>[mm]   </td><td class='i4 rd bs2'><span id=E5011 set='<?print getXValue('E5011',$x)?>' readonly=true></span>                     </td><td class='i5 bs2'>&nbsp;                </td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >4. Other Data    </td><td class='i2 ld bd'           >Hoistway width                        </td><td class='i3 ld rs bd' >[mm]     </td><td class='i4 rd bd' ><input id='hoistway_width' class='input_basic' set='<?print getXValue('hoistway_width',$x)?>' attr='numberonly:"true"' readonly></td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'           >Hoistway depth                        </td><td class='i3 ld rs bd' >[mm]     </td><td class='i4 rd bd' ><input id='hoistway_depth' class='input_basic' set='<?print getXValue('hoistway_depth',$x)?>' attr='numberonly:"true"' readonly></td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <!-- 해영 요청으로 적용 2010년 8월 31일 화요일  -->
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'           >Machine Room Location                 </td><td class='i3 ld rs bd' >&nbsp;   </td><td class='i4 rd bd' ><B><?if( in_array($class_name, array('OS_EVOLUTION_II','OS_SYNERGY_S','OS_EVOLUTION_III','OS_EVOLUTION_2K'), true) ){ echo 'Machine Roomless(MRL)';} else {echo 'Directly above the shaft';}?></B>            </td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'           >MR Width x Depth x Height             </td><td class='i3 ld rs bd' >[mm]     </td><td class='i4 rd bd' ><?if( in_array($class_name, array('OS_EVOLUTION_II','OS_SYNERGY_S','OS_EVOLUTION_III','OS_EVOLUTION_2K'), true) ){ echo '<B>Machine Roomless(MRL)</B>';?><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                <?} else {?><input id='mr_width'       class='input_basic' set='<?print getXValue('mr_width',$x)?>' attr='numberonly:"true",maxlength:5'></td><td class='i5 bd' ><input id='mr_depth' class='input_basic' set='<?print getXValue('mr_depth',$x)?>' attr='numberonly:"true",maxlength:5'></td><td class='i6 ld bd' ><input id='mr_height' class='input_basic' set='<?print getXValue('mr_height',$x)?>' attr='numberonly:"true",maxlength:5'><?}?></td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'  rowspan=2>Power Supply                          </td><td class='i3 ld rs bd' >Main     </td><td class='i4 rd bd' ><span id=E5133 set='<?print getXValue('E5133',$x)?>'></span>                             </td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                                           <td class='i3 ld rs bd' >Lighting </td><td class='i4 rd bd' ><span id=E5147 set='<?print getXValue('E5147',$x)?>'></span>                             </td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'           >Buffer                                </td><td class='i3 ld rs bd' >&nbsp;   </td><td class='i4 rd bd' ><input type=text style='border:0px;background-color:transparent;' id=buffer set='<?print getXValue('buffer',$x)?>' class='input_basic' readonly></td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 bs2 ld' rowspan=2>Guide Rail                            </td><td class='i3 ld rs bd' >Car Side </td><td class='i4 rd bd' >TKEK STANDARD                                      </td><td class='i5 bd' ><select id='car_side' set='<?print getXValue('car_side',$x)?>' class='select_basic'><option value=2500>pitch=2500mm</option><option value=1500>pitch=1500mm</option></select></td><td class='i6 ld bd' ><span id=E5095 set='<?print getXValue('E5095',$x)?>'></span></td></tr>
        <tr><td class='i1 bs2'>&nbsp;           </td>                                                                           <td class='i3 ld rs bs2'>CWT Side </td><td class='i4 rd bs2'>TKEK STANDARD                                      </td><td class='i5 bs2'><select id='cwt_side' set='<?print getXValue('cwt_side',$x)?>' class='select_basic'><option value=2500>pitch=2500mm</option><option value=1500>pitch=1500mm</option></select></td><td class='i6 ld bs2'><span id=E5101 set='<?print getXValue('E5101',$x)?>'></span></td></tr>

        <tr><td class='i1'    >5 Standard       </td><td class='i2 ld bd' rowspan=3>Higher Efficiency </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Nuisance Call Cancellation                                   </B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >Features         </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Arrival Car Chime                                            </B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Automatic Cut-off of Lighting and Ventilation during Stand-by</B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 bs2 ld' rowspan=7>Increased Safety </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Automatic Landing Function at the nearest floor              </B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Communication System : Intercom - 3 points                   </B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Door Nudging                                                 </B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Door Repetitive Reversal                                     </B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Emergency Light in the event of System Failure               </B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' colspan=2><B>Inspection Operation (at Car Top)                            </B></td><td class='i6 bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;           </td>                                                      <td class='i3 ld rs bs2'>&nbsp;</td><td class='i4 rd bs2'colspan=2><B>Overload Detector                                            </B></td><td class='i6 bs2'>&nbsp;</td></tr>

        <tr>
        <td class='i1'    >6 Car            </td>
        <td class='i2 ld bd'>Cage Panel / Car Wall</td>
        <td class='i3 ld rs bd'>&nbsp;</td>
        <td class='i4 rd bd'><?
        $creategory_setup['select'          ] = '4';
        $creategory_setup['prop_name'       ] = 'cage_panel_n_wall';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('cage_panel_n_wall',$x) . "' class='select_basic'"  ; // 스크립트
        $cage_panel_n_wallgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $cage_panel_n_wallgory);
        ?>
        </td>
        <td class='i5 bd'>&nbsp;</td>
        <td class='i6 ld bd'>&nbsp;</td>
        </tr>

        <tr>
        <td class='i1'    >Specifications</td>
        <td class='i2 ld bd'>Car Door</td>
        <td class='i3 ld rs bd'>&nbsp;</td>
        <td class='i4 rd bd'><?
        $creategory_setup['select'          ] = '4';
        $creategory_setup['prop_name'       ] = 'car_door';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('car_door',$x) . "' class='select_basic'"  ; // 스크립트
        $car_doorgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $car_doorgory);
        ?>
        </td>
        <td class='i5 bd'>&nbsp;</td>
        <td class='i6 ld bd'>&nbsp;</td>
        </tr>

        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Car width           </td><td class='i3 ld rs bd' >[mm]  </td><td class='i4 rd bd' ><INPUT TYPE="text" id="car_width"            class='input_basic' set='<?print getXValue('car_width',$x)?>' readonly></td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Car depth           </td><td class='i3 ld rs bd' >[mm]  </td><td class='i4 rd bd' ><INPUT TYPE="text" id="car_depth"            class='input_basic' set='<?print getXValue('car_depth',$x)?>' readonly></td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td>
        <td class='i2 ld bd' >Car height          </td><td class='i3 ld rs bd' >[mm]  </td>
        <td class='i4 rd bd' ><select id='car_height' set='<?print getXValue('car_height',$x)?>' class='select_basic'>
    <option value='2100'>2100</option>
    <option value='2200'>2200</option>
    <option value='2300' selected>2300</option>
    <option value='2400'>2400</option>
    <option value='2500'>2500</option>
</select>
        <!-- <INPUT TYPE="text" id="car_height"           class='input_basic' set='<?print getXValue('car_height',$x)?>'> -->
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Open through car    </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><select id='open_through_car' set='<?print getXValue('open_through_car',$x)?>' class='select_basic'>
    <option value='Yes'>Yes</option>
    <option value='No' selected>No</option>
</select>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Entrance Door width </td><td class='i3 ld rs bd' >[mm]  </td>
        <td class='i4 rd bd' ><select id='entrance_door_width'  set='<?print getXValue('entrance_door_width',$x)?>' class='select_basic'>
    <option value='800'>800</option>
    <option value='900'>900</option>
    <option value='1000'>1000</option>
    <option value='1100'>1100</option>
</select>
        <!-- <INPUT TYPE="text" id="entrance_door_width"  class='input_basic' set='<?print getXValue('entrance_door_width',$x)?>' readonly></td><td class='i5 bd' >&nbsp; -->
        </td>
        <td class='i5 bd'>&nbsp;</td>
        <td class='i6 ld bd'>&nbsp;</td>
        </tr>

        <tr><td class='i1 bs2'>&nbsp;</td><td class='i2 ld bs2'>Entrance Door height</td><td class='i3 ld rs bs2'>[mm]  </td>
        <td class='i4 rd bs2'><select id='entrance_door_height' set='<?print getXValue('entrance_door_height',$x)?>' class='select_basic'>
    <option value='2000'>2000</option>
    <option value='2100' selected>2100</option>
    <option value='2200'>2200</option>
    <option value='2300'>2300</option>
<!--2010년 9월 3일 금요일 해영 삭제<option value='2400'>2400</option>
    <option value='2500'>2500</option> -->
</select>
        <!-- <INPUT TYPE="text" id="entrance_door_height" class='input_basic' set='<?print getXValue('entrance_door_height',$x)?>' readonly></td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp; -->
        </td>
        <td class='i5 bs2'>&nbsp;</td>
        <td class='i6 ld bs2'>&nbsp;</td>
        </tr>
    </table>
</div>
<div id="tab2" class="tabcontent" style='border:1px solid gray; margin-bottom: 1em; padding: 10px;height:1000px;width:900px'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="a_tbl" id='tbl2' style='padding:0px;margin:0px' align=left>
        <colgroup>
            <col width='15%'/>
            <col width='20%'/>
            <col width='10%'/>
            <col width='25%'/>
            <col width='15%'/>
            <col width='15%'/>
        </colgroup>

        <tr><td class='i1'    >6. Car               </td><td class='i2 ld bd' >Kick Plate (Skirting Board)</td><td class='i3 ld rs bd'>&nbsp;</td><td class='i4 bd' colspan=2>TKEK Standard (No Kick Plate in front panel upto 1000kg)</td><td class='i6 ld bd'>&nbsp;</td></tr>
        <tr><td class='i1'    >     Specifications  </td><td class='i2 ld bd' >Floor                      </td><td class='i3 ld rs bd'>&nbsp;</td>
        <td class='i4 rd bd'><?
        $creategory_setup['select'          ] = '2';
        $creategory_setup['prop_name'       ] = 'specifications_floor';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('specifications_floor',$x) . "' class='select_basic'"  ; // 스크립트
        $specifications_floorgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $specifications_floorgory);
        ?>
        </td>
        <td class='i5 bd'>&nbsp; </td><td class='i6 ld bd'>&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Hand Rail                    </td><td class='i3 ld rs bd' >&nbsp;      </td><td class='i4 rd bd' ><span id=E5046 set='<?print getXValue('E5046',$x)?>'></span>                      </td><td class='i5 bd' ><span id=E5047 set='<?print getXValue('E5047',$x)?>'></span></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' rowspan=3>Ceiling             </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5050 set='<?print getXValue('E5050',$x)?>'></span>                      </td>
        <td class='i5 bd' ><?
        $creategory_setup['select'          ] = '';
        $creategory_setup['prop_name'       ] = 'ceiling_type';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('ceiling_type',$x) . "' class='select_basic'"  ; // 스크립트
        $ceiling_typegory['setup'] = $creategory_setup;
        print createGory ('SELECT', $ceiling_typegory);
        ?>
        </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td>                                                        <td class='i3 ld rs bd' > Ventilation</td><td class='i4 rd bd' >Sirocco Fan (TKEK Standard)                 </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td>                                                        <td class='i3 ld rs bd' > Lighting   </td><td class='i4 rd bd' >Fluorescent Lamp (Only for 220V)            </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' rowspan=2>COP                 </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5055 set='<?print getXValue('E5055',$x)?>'></span>                      </td><td class='i5 bd' >Sub COP&nbsp;</td><td class='i6 ld bd' ><span id=E5062 set='<?print getXValue('E5062',$x)?>'></span></td></tr>
        <tr><td class='i1'    >&nbsp;</td>                                                        <td class='i3 ld rs bd' > Finish     </td><td class='i4 rd bd' ><span id=E5061 set='<?print getXValue('E5061',$x)?>'></span>                      </td><td class='i5 bd' >&nbsp;<!-- 1,2항목만 보임 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Prority card key in the COP  </td><td class='i3 ld rs bd' >&nbsp;      </td><td class='i4 rd bd' ><span id=E5066 set='<?print getXValue('E5066',$x)?>'></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >COP for Disabled             </td><td class='i3 ld rs bd' >&nbsp;      </td><td class='i4 rd bd' ><span id=E5063 set='<?print getXValue('E5063',$x)?>'></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >CPI                          </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5067 set='<?print getXValue('E5067',$x)?>'></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;</td><td class='i2 bs2 ld'>Mirror in the car            </td><td class='i3 ld rs bs2'>&nbsp;      </td><td class='i4 rd bs2'><span id=E5049 set='<?print getXValue('E5049',$x)?>'></span>                      </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >7. Landing / Hall</td><td class='i2 ld bd' rowspan=2>Door                       </td><td class='i3 ld rs bd' > Ground     </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '4';
        $creategory_setup['prop_name'       ] = 'door_ground';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('door_ground',$x) . "' class='select_basic'"  ; // 스크립트
        $door_groundgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $door_groundgory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >   Specifications</td>                                                               <td class='i3 ld rs bd' > Typical    </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '4';
        $creategory_setup['prop_name'       ] = 'door_typical';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('door_typical',$x) . "' class='select_basic'"  ; // 스크립트
        $door_typicalgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $door_typicalgory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' rowspan=2>Jamb<?if( in_array($class_name, array('OS_EVOLUTION_II','OS_SYNERGY_S','OS_EVOLUTION_III','OS_EVOLUTION_2K'), true) ){ echo '<BR>(TOP Floor Jamb Should be WIDE)'; }?></td><td class='i3 ld rs bd' > Ground     </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '4';
        $creategory_setup['prop_name'       ] = 'jamb_ground';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('jamb_ground',$x) . "' class='select_basic'"  ; // 스크립트
        $jamb_groundgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $jamb_groundgory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;</td>
        <td class='i6 ld bd' ><?
        $creategory_setup['select'          ] = '';
        $creategory_setup['prop_name'       ] = 'jamb_ground_option';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('jamb_ground_option',$x) . "' class='select_basic'"  ; // 스크립트
        $jamb_ground_optiongory['setup'] = $creategory_setup;
        print createGory ('SELECT', $jamb_ground_optiongory);
        ?>
        </td></tr>

        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > Typical    </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '4';
        $creategory_setup['prop_name'       ] = 'jamb_typical';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('jamb_typical',$x) . "' class='select_basic'"  ; // 스크립트
        $jamb_typicalgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $jamb_typicalgory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;</td>
        <td class='i6 ld bd' ><?
        $creategory_setup['select'          ] = 'N';
        $creategory_setup['prop_name'       ] = 'jamb_typical_option';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('jamb_typical_option',$x) . "' class='select_basic'"  ; // 스크립트
        $jamb_typical_optiongory['setup'] = $creategory_setup;
        print createGory ('SELECT', $jamb_typical_optiongory);
        ?>
        </td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' rowspan=2>Transom                    </td><td class='i3 ld rs bd' > Ground     </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'transom_ground';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('transom_ground',$x) . "' class='select_basic'"  ; // 스크립트
        $transom_groundgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $transom_groundgory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > Typical    </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'transom_typical';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('transom_typical',$x) . "' class='select_basic'"  ; // 스크립트
        $transom_typicalgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $transom_typicalgory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' rowspan=2>Hall Button (Main floor)   </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5072_CLONE set='<?print getXValue('E5072_CLONE',$x)?>'></span></td><td class='i5 bd' >&nbsp;<!-- 로직 안걸고 화면만 보인다(선택가능) --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > Finish     </td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '1';
        $creategory_setup['prop_name'       ] = 'hall_button_main_floor';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('hall_button_main_floor',$x) . "' class='select_basic'"  ; // 스크립트
        $hall_button_main_floorgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $hall_button_main_floorgory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;<!-- 로직 안걸고 화면만 보인다(선택가능) --></td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' rowspan=3>Hall Button (Other floor)</td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5072 set='<?print getXValue('E5072',$x)?>'></span>                  </td><td class='i5 bd' >&nbsp;<!-- 삭제항목2,5,8,12,17,19,22,25 안보임 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > Finish     </td><td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '1';
        $creategory_setup['prop_name'       ] = 'hall_button_other_floor';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('hall_button_other_floor',$x) . "' class='select_basic'"  ; // 스크립트
        $hall_button_other_floorgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $hall_button_other_floorgory);
        ?>
        </td><td class='i5 bd' >&nbsp;<!-- 1,2항목만 보임 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > BUTTON     </td><td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = '';
        $creategory_setup['prop_name'       ] = 'cop_button';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('cop_button',$x) . "' class='select_basic'"  ; // 스크립트
        $cop_buttongory['setup'] = $creategory_setup;
        print createGory ('SELECT', $cop_buttongory);
        ?>
        </td>
        <td class='i5 bd' >&nbsp;<!-- E61 COPY 수정불가 --></td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'          >HPI                        </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5071 set='<?print getXValue('E5071',$x)?>'></span>                  </td><td class='i5 bd' >&nbsp;<!-- 홀수 인수만 적용(1,3,5,7,9…) --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;           </td><td class='i2 bs2 ld'         >Hall Lanterns              </td><td class='i3 ld rs bs2'>&nbsp;      </td><td class='i4 rd bs2'><span id=E5082 set='<?print getXValue('E5082',$x)?>'></span>                  </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >8. Accessories             </td><td class='i2 bs ld' >Door protection                           </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5043 set='<?print getXValue('E5043',$x)?>'></span>        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;                     </td><td class='i2 bs ld' >Voice Synthesizer                         </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5052 set='<?print getXValue('E5052',$x)?>'></span>        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;                     </td><td class='i2 bs ld' >BGM Speaker                               </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5051 set='<?print getXValue('E5051',$x)?>'></span>        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'    >&nbsp;                     </td><td class='i2 bs2 ld' >Hall Chime (Ding Dong Sound)              </td><td class='i3 ld rs bs2' >&nbsp;</td><td class='i4 rd bs2' ><span id=E5016 set='<?print getXValue('E5016',$x)?>'></span>        </td><td class='i5 bs2' >&nbsp;</td><td class='i6 ld bs2' >&nbsp;</td></tr>
<!--2010년 9월 3일 금요일 해영삭제 요청
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld'>CC TV                                     </td><td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2'><?
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 'cc_tv';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " set='" . getXValue('cc_tv',$x) . "' class='select_basic'"  ; // 스크립트
$cc_tvgory['setup'] = $creategory_setup;
print createGory ('SELECT', $cc_tvgory);
?>
        </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>
 -->
        <tr><td class='i1'    >9. Fire functions:         </td><td class='i2 bs ld' >Fireman Emergency Return                  </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'fireman_emergency_return';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('fireman_emergency_return',$x) . "' class='select_basic'"  ; // 스크립트
        $fireman_emergency_returngory['setup'] = $creategory_setup;
        print createGory ('SELECT', $fireman_emergency_returngory);
        ?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld'>Fireman Switch Operation                  </td><td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2'><span id=E5081 set='<?print getXValue('E5081',$x)?>'></span>                      </td>
        <td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >10. Emergency              </td><td class='i2 bs ld' >Emergency Power Operation                 </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'emergency_power_operation';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('emergency_power_operation',$x) . "' class='select_basic'"  ; // 스크립트
        $emergency_power_operationgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $emergency_power_operationgory);
        ?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >    functions              </td><td class='i2 bs ld' >Automatic Rescue Device                   </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5113 set='<?print getXValue('E5113',$x)?>'></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld'>Earthquake/Seismic Operation              </td><td class='i3 ld rs bs2'>&nbsp;</td><td class='i4 rd bs2'><span id=E5109 set='<?print getXValue('E5109',$x)?>'></span>                      </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1 bs2'>11. Supervision              </td><td class='i2 bs2 ld'>Supervisory panel for the project         </td><td class='i3 ld rs bs2'>&nbsp;</td><td class='i4 rd bs2'><span id=E5122 set='<?print getXValue('E5122',$x)?>'></span>                      </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >12. Control                </td><td class='i2 bs ld' >Homing (home landing)                     </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5144 set='<?print getXValue('E5144',$x)?>'></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >    function               </td><td class='i2 bs ld' >By-Pass operation                         </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'by_pass_operation';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('by_pass_operation',$x) . "' class='select_basic'"  ; // 스크립트
        $by_pass_operationgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $by_pass_operationgory);
        ?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'    >&nbsp;                     </td><td class='i2 bs2 ld' >Night time operation                      </td><td class='i3 ld rs bs2' >&nbsp;</td>
        <td class='i4 rd bs2' ><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'night_time_operation';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('night_time_operation',$x) . "' class='select_basic'"  ; // 스크립트
        $night_time_operationgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $night_time_operationgory);
        ?>
        </td><td class='i5 bs2' >&nbsp; <!-- 로직 구성 없음(화면만) 적용Price 해영 --></td><td class='i6 ld bs2' >&nbsp;</td></tr>
<!--    2010년 9월 3일 금요일 해영요청 삭제
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld'>Isolated simplex operation from the group </td><td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2'><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'isolated_simplex_operation';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('isolated_simplex_operation',$x) . "' class='select_basic'"  ; // 스크립트
        $isolated_simplex_operationgory['setup'] = $creategory_setup;
        print createGory ('SELECT', $isolated_simplex_operationgory);
        ?>
        </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr> -->

        <tr><td class='i1 bs2'    >13. Special requests functions</td><td class='i2 bs2 ld' >SABBATH                                   </td><td class='i3 ld rs bs2' >&nbsp;</td><td class='i4 rd bs2' ><span id=E5130 set='<?print getXValue('E5130',$x)?>'></span>                      </td><td class='i5 bs2' >&nbsp;</td><td class='i6 ld bs2' >&nbsp;</td></tr>
<!--         <tr><td class='i1 bs2'>functions                  </td><td class='i2 bs2 ld'>Counter Weight Safety                     </td><td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2'><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'counter_weight_safety';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('counter_weight_safety',$x) . "' class='select_basic'"  ; // 스크립트
        $counter_weight_safetygory['setup'] = $creategory_setup;
        print createGory ('SELECT', $counter_weight_safetygory);
        ?>
        </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>
 -->
        <tr><td class='i1'    >OTHERS                     </td><td class='i2 bs ld' >Rope brake (Gripper)                      </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5017 set='<?print getXValue('E5017',$x)?>'></span>                     </td><td class='i5 bd' >&nbsp;<!-- CSA 인증제품 적용1,(2),5만 표시 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;                     </td><td class='i2 bs ld' >BMS Interface                             </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'bms_interface';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('bms_interface',$x) . "' class='select_basic'"  ; // 스크립트
        $bms_interfacegory['setup'] = $creategory_setup;
        print createGory ('SELECT', $bms_interfacegory);
        ?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr id='tr_spare_parts_set' style='display:<?print($E5007>=3?'""':'"none"');?>'><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld'>Spare parts set for 2 years               </td><td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2'><span id=E5192 set='<?print getXValue('E5192',$x)?>'></span><?
        $creategory_setup['select'          ] = 'E';
        $creategory_setup['prop_name'       ] = 'spare_parts_set';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = " set='" . getXValue('spare_parts_set',$x) . "' class='select_basic'"  ; // 스크립트
        $spare_parts_setgory['setup'] = $creategory_setup;
        //print createGory ('SELECT', $spare_parts_setgory);
        // 설계팀 요청에의해 변경됨.
        ?>
        </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>
    </table>
</div>
<div id='hidden_item' style='position:absolute;width:358px;top:413px;left:725px;background-color:white;border:1px solid #888888;padding:3px'  onmouseover='fChangeZIndex(event,"hidden_item")' onmouseover='fChangeZIndex(event,"hidden_item")'>
    <div style='border:1px solid black;border-bottom:0px;width:508px;vertical-align:top;'>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=0 align=center style='width:508px;height:23px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
            <col width='40'/>
            <col width='220'/>
            <col width=''/>
            <col width='20'/>
        </colgroup>
        <thead>

        <tr>
        <th>Seq</th>
        <th>ElmentID</th>
        <th>Value</th>
        <th>&nbsp;</th>
        </tr>
        </thead>
    </table>
    </div>

    <div style='border:1px solid black;border-bottom:1px solid black;overflow-x:hidden;overflow-y:scroll;width:508px;height:235px;'>
    <table id=hidden_area class="a_tbl2" align=center cellpadding=0 cellspacing=0 border=0 style='width:508px;height:200px;border-collapse:collapse;vertical-align:top;;'>
        <colgroup>
            <col width='40'/>
            <col width='220'/>
            <col width=''/>
            <col width='20'/>
        </colgroup>

        <tbody>

<?
    /* 제외시킬 Element */
    getXValue('p_esti_no'       ,$x);
    getXValue('p_seq'           ,$x);
    getXValue('btn_save'        ,$x);
    getXValue('btn_spec_send'   ,$x);
    $std_entrance_door_width = getXValue('std_entrance_door_width',$x);
    $hIdx = 0;
    foreach ( $x as $k => $v ) {
        $hIdx++;
        echo '<tr style="background-color:#FFFFFF">';
        echo '<td style="text-align:center">' . $hIdx . '</td>';
        echo '<td style="padding-left:3px">';
        echo $k . '';
        echo '</td>';
        echo '<td style="padding-left:3px">';
        if ( eregi ( '^E([0-9]{4})$', $k) ) {
            print '<span id=' . $k . ' set=\'' . $v .'\' class=\'crc_hidden\'>' . $v . '</span>';
        } else {
            print '<input type=text id=' . $k . ' value=\'' . $v .'\' class=\'crc_hidden\'>';
        }
        echo '</td>';
        echo '</tr>';
    }
    $hIdx++;
        echo '<tr style="background-color:#FFFFFF">';
        echo '<td style="text-align:center">' . $hIdx . '</td>';
        echo '<td style="padding-left:3px">';
        echo 'std_entrance_door_width';
        echo '</td>';
        echo '<td style="padding-left:3px">';
        echo '<input type=text id=std_entrance_door_width value=' . $std_entrance_door_width . '>';
        echo '</td>';
        echo '</tr>';
?>
        </tbody>
    </table>
    </div>
</div>
</form>
<div id='item_search_area' style="position:absolute;top:3px;left:725px;width:400px">
    <input type=text id='find_id' value='<?=$_COOKIE['find_id']?>'>
    <button onclick='fFindElement();'>항목찾기</button>
</div>

<div id=display_logic_box style='position:absolute;width:358px;top:27px;left:725px;background-color:white;border:1px solid #888888;padding:3px' onmouseover='fChangeZIndex(event,"display_logic_box")' onmouseover='fChangeZIndex(event,"display_logic_box")'>

    <div style='border:1px solid black;border-bottom:1px solid black;width:358px;height:20px;margin-bottom:2px;vertical-align:top'>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=0 align=center style='width:358px;height:23px;border-collapse:collapse'>
        <colgroup>
            <col width='10%'/>
            <col width='30%'/>
            <col width=''/>
            <!--<col width='30%'/>-->
        </colgroup>
        <tbody>

        <tr>
        <td style='border-top:0px;font-weight:bold;text-align:center'><A HREF="#" onclick='return false;' id=s_rel_logic>ID</A></td>
        <td style='border-top:0px;font-weight:bold;padding-left:5px' align=left>
        <span id=s_id></span>
        </td>
        <td style='border-top:0px;font-weight:bold;padding-left:5px' align=left id=s_value></td>
<!--         <td style='border-top:0px;font-weight:bold;padding-left:5px' align=left id=s_logic_name></td>
 -->        </tr>
        </tbody>
    </table>
    </div>

    <div style='border:1px solid black;border-bottom:0px;width:358px;vertical-align:top;'>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=0 align=center style='width:358px;height:23px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
            <col width='40'/>
            <col width='80'/>
            <col width='90'/>
            <col width=''/>

            <col width='20'/>
        </colgroup>
        <thead>

        <tr>
        <th>Seq</th>
        <th>Description</th>
        <th>ElmentID</th>
        <th>Value</th>
        <th>&nbsp;</th>
        </tr>
        </thead>
    </table>
    </div>

    <div style='border:1px solid black;border-bottom:1px solid black;overflow-x:hidden;overflow-y:scroll;width:358px;height:165px;display:none'>
    <table id=logic_area class="a_tbl2" align=center cellpadding=0 cellspacing=0 border=0 style='width:358px;height:200px;border-collapse:collapse;'>
        <colgroup>
            <col width='40'/>
            <col width='80'/>
            <col width='90'/>
            <col width=''/>

            <col width='20'/>
        </colgroup>

        <tbody>
        </tbody>
    </table>
    </div>
</div>

<textarea WRAP=OFF id=msg style='font-size:9pt;position:absolute;top:253px;left:725px;width:388px;height:150px;display:inline;overflow-x:scroll;' ondblclick='this.value="";'
onmouseover='fChangeZIndex(event,"msg")' onmouseover='fChangeZIndex(event,"msg")'
>
</textarea>

<textarea WRAP=OFF id=xml_data style='font-size:9pt;position:absolute;top:413px;left:825px;width:388px;height:150px;display:inline;overflow-x:scroll;'
>
</textarea>

<?
    $db->release();
} // end if [op=="write"]
else if ( $op == "save_xml_exec") {
    $db->getConnect();
    $xml_data  = urldecode($_POST["x"]);
    $p_esti_no = $_GET["p_esti_no"];
    $p_seq     = $_GET["p_seq"];
    //echo 'xml_data :' . $xml_data . '<BR>';
    //echo 'p_esti_no :' . $p_esti_no . '<BR>';
    //echo 'p_seq :' . $p_seq . '<BR>';
    $xml = simplexml_load_string('<xml>'.$xml_data.'</xml>');
    if (!$xml_data ) $errors[] = xlate('The XML Data is empty');
    $sRtn = 0;
//
    $opt_amt = 0;
    $specification= $xml->specification;
    foreach ( $xml as $k => $v ) {
        if ( eregi ( '^opt_amt_', $k) ) {
            $opt_amt += (int) $v;
        }
        if ( $k == 'specification') {
        }
    }

    if (empty($errors)) {
        $xmlStr  = '';
        $success = TRUE;
        $state = getSpecState($p_esti_no,$p_seq);

        $sql = "SELECT "
             . " a.COUNTRY_CODE COUNTRY_CODE, "
             . " b.VALUE        CLASS_NAME    "
             . " FROM tbl_calko_header a, tbl_calko_result b \n"
             . " WHERE a.ESTI_NO    = b.ESTI_NO\n"
             . " AND " . ( $memInfor['user_level'] >= 2 ?" a.REG_USER_ID <> ''":" a.REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
             . " AND   a.ESTI_NO    = '{$p_esti_no}'\n"
             . " AND   b.SEQ        = '1'\n"
        ;
        $r = $db->get($sql);
        $country_code= $r->COUNTRY_CODE;
        $class_name  = $r->CLASS_NAME  ;

        if ( $state <= '3' ) {
            if ( $db->starttransaction() ) {
                if ( sizeof($xml) > 0 ) {
                    $sql = "SELECT \n"
                         . "  a.ACCOUNTING_NO   ACCOUNTING_NO  ,\n"
                         . "  a.ACCOUNTING_YEAR ACCOUNTING_YEAR,\n"
                         . "  a.MARGIN_RATE     MARGIN_RATE    ,\n"
                         . "  a.MARKUP_RATE     MARKUP_RATE    ,\n"
                         . "  a.SGNA_RATE       SGNA_RATE      ,\n"
                         . "  a.EXCHANGE_RATE   EXCHANGE_RATE   \n"
                         . " FROM tbl_accounting_exchange_rate a, tbl_calko_class_name cn\n"
                         . " WHERE a.USE_YN = 'Y'\n"
                         . " AND   a.COUNTRY_CODE = '" . $country_code . "'\n"
                         . " AND   a.CLASS_NAME   = '" . $class_name   . "'\n"
                         . " AND   a.ACCOUNTING_YEAR = '" . ACCOUNTING_YEAR . "'\n"
                         . " AND   a.CLASS_NAME   = cn.CLASS_NAME\n"
                         . " AND   cn.USE_YN = 'Y'\n"
                         ;
                    $exchangeInfo = $db->get($sql);
                    if ( !empty($exchangeInfo) ) {
                        $margin_rate   = $exchangeInfo->MARGIN_RATE     ;
                        $markup_rate   = $exchangeInfo->MARKUP_RATE     ;
                        $sgna_rate     = $exchangeInfo->SGNA_RATE       ;
                        $exchange_rate = $exchangeInfo->EXCHANGE_RATE   ;

                        $savedata = array();
                        $savedata['ESTI_NO'         ] = "'" . $p_esti_no        . "'";
                        $savedata['SEQ'             ] = "'" . $p_seq            . "'";
                        $savedata['SPECIFICATION'   ] = "'" . $specification    . "'";
                        $savedata['SAVE_XML_DATA'   ] = "'" . addslashes ( $xml_data )  . "'";
                        $savedata['SAVE_DATE'       ] = "now()";
                        $savedata['OPT_AMT'         ] = "'" . $opt_amt    . "'";
                        $savedata['STATE'           ] = "'3'"; // 저장
                        $savedata['MARGIN_RATE'     ] = "'" . $margin_rate          . "'";
                        $savedata['MARKUP_RATE'     ] = "'" . $markup_rate          . "'";
                        $savedata['SGNA_RATE'       ] = "'" . $sgna_rate            . "'";
                        $savedata['EXCHANGE_RATE'   ] = "'" . $exchange_rate        . "'";

                        $success=specSave('U',$savedata);

                        if ( $success ) {
                            $savedata = array();
                            $savedata['ESTI_NO'                ] = "'" . $p_esti_no . "'";
                            $savedata['STATE'                  ] = "3"; // 저장
                            $success = specHeaderSave('U',$savedata);
                            if ( !$success ) $errors[] = xlate('tbl_calko_header update error!!!') . ' / ' . $db->lastSql();
                        } else {
                            if ( !$success ) $errors[] = xlate('tbl_calko_result update error!!!') . ' / ' . $db->lastSql;
                        }

                        if ( $success && $db->commit() ) {
                        } else {
                            $errors[] = xlate('A problem has been occured while updating data. Please try again');
                            $errors[] = $db->getErrMsg(). 'yyyyyyyyyyyy';
                        }
                    } else {
                        $margin_rate   = 0;
                        $markup_rate   = 0;
                        $sgna_rate     = 0;
                        $exchange_rate = 0;
                        $errors[] = xlate('Exchange of information does not exist.( \'' . ACCOUNTING_YEAR . '\' - \'' . $country_code . '\' - \'' . $class_name . '\')');
                    }
                } else {
                    $errors[] = xlate('XML Data Not Exist');
                }
            } else {
                $errors[] = xlate('A problem has been occured while updating data. Please try again');
                        $errors[] = $db->getErrMsg(). 'xxxxxx';
            }
            if ( !empty($errors) || !$success ) {
                $db->rollback();
                $success = FALSE;
            }
        } else {
            $errors[] = xlate('Data can not be saved.');
        }
    }

    if (!empty($errors)) print ('ERROR|'   . $m . '|' . $sRtn  . '|' . implode($errors, "', '"));
    else                 print ('SUCCESS|' . $m . '|' . $sRtn  . '|' . '');
    $db->release();
} // end if [op=="save_xml_exec"]
else if ( $op == "delete_spec_exec") {
    $db->getConnect();
    $p_esti_no = $_POST["p_esti_no"  ];
    $p_seq     = $_POST["p_seq"      ];

    if (!$p_esti_no     ) $errors[] = xlate('Quotation Number is Empty!');
    if (!$p_seq         ) $errors[] = xlate('Quotation Seq is Empty!');

    $QUOTCOUNT = 0;

    if (empty($errors)) {
        if ( $db->starttransaction() ) {

            $sql = " DELETE FROM tbl_calko_result"
                 . " WHERE ESTI_NO = '" . $p_esti_no . "'"
                 . " AND   SEQ     = '" . $p_seq     . "'"
                 . " AND   STATE <= '3'"
            ;
            //echo '<textarea>' . ($sql) . '</textarea>';
    /**/
            if ( !$db->exec($sql) ) {
                $errors[] = xlate('Delete failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
            }

            $sql = " UPDATE"
                    . " tbl_calko_result a INNER JOIN"
                    . " ("
                    . "     SELECT"
                    . "     ESTI_NO,"
                    . "     SEQ,"
                    . "     IF ( CONVERT(ESTI_NO USING utf8) COLLATE utf8_general_ci <> @tmp_esti_no ,@rownum:=1,@rownum:=@rownum+1) NEW_SEQ, "
                    . "     @tmp_esti_no:=esti_no TMP_ESTI_NO"
                    . "     FROM tbl_calko_result a, (SELECT @rownum:=1,@tmp_esti_no:='') t"
                    . "     WHERE ESTI_NO = '" . $p_esti_no . "'"
                    . "     ORDER BY ESTI_NO, SEQ"
                    . " ) b"
                    . " ON  a.ESTI_NO = b.ESTI_NO"
                    . " AND a.SEQ     = b.SEQ"
                    . " AND a.STATE <= '3'"
                    . " SET a.SEQ = b.NEW_SEQ,"
                    . "     a.O_SEQ = b.NEW_SEQ"
            ;
            if ( !$db->exec($sql) ) {
                $errors[] = xlate('Update Seq failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
            }

            $sql = " DELETE a "
                 . " FROM tbl_calko_header a INNER JOIN" . "\n"
                 . " (" . "\n"
                 . " SELECT a.ESTI_NO ESTI_NO FROM tbl_calko_header a" . "\n"
                 . " LEFT OUTER JOIN tbl_calko_result b" . "\n"
                 . " ON   a.ESTI_NO = b.ESTI_NO" . "\n"
                 . " WHERE a.ESTI_NO = '" . $p_esti_no . "'"
                 . " GROUP BY a.ESTI_NO" . "\n"
                 . " HAVING COUNT(b.ESTI_NO) = 0" . "\n"
                 . " ORDER BY b.SEQ ASC" . "\n"
                 . " ) t" . "\n"
                 . " ON a.ESTI_NO = t.ESTI_NO" . "\n"
                 . " WHERE STATE <= '3'\n"
            ;
            if ( !$db->exec($sql) ) {
                $errors[] = xlate('tbl_calko_header TABLE 0 row data delete failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
            }

            if ( empty($errors) && $db->commit() ) {
            } else {
                $errors[] = xlate('Data Not Valid!');
            }

            $sql = "SELECT "
                 . " COUNT(*) CNT"
                 . " FROM tbl_calko_result "
                 . " WHERE ESTI_NO    = '$p_esti_no'"
               //. " ORDER BY STATE asc"
            ;

            $QUOTCOUNT = $db->get($sql )->CNT; // 견적갯수


        } else {
            $errors[] = xlate('Start Transaction Error');
        }

        if ( !empty($errors) ) {
            $errors[] = xlate('Transaction Rollback.');
            $db->rollback();
        }
    } else {
        $errors[] = xlate('Delete Information is Empty!');
    }

    if (!empty($errors)) print ('ERROR|'   . $QUOTCOUNT . '|' . $p_esti_no  . '|' . implode($errors, "<BR>"));
    else                 print ('SUCCESS|' . $QUOTCOUNT . '|' . $p_esti_no  . '|' . '');

    $db->release();
} // end if [op=="delete_spec_exec"]
else if ( $op == "send_spec_exec") {
    $db->getConnect();
    $p_esti_no      = trim($_GET["p_esti_no"]);
    $p_pre_crc_code = trim($_GET["p_pre_crc_code"]);
    $reqXml = '';
    $sRtn = '';
    $m = 'S';
    if ( $p_esti_no ) {

        $success = TRUE;
        $sendTPAble = sendTPAble($p_esti_no);
        if ( $sendTPAble->state ) {
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
                 . "  b.STANDARD                 STANDARD              , \n"
                 . "  b.CATEGORY                 CATEGORY              , \n"
                 . "  b.MAT_NO                   MAT_NO                , \n"
                 . "  b.PRE_CRC_CODE             PRE_CRC_CODE          , \n"
                 . "  b.QTY                      QTY                   , \n"
                 . "  b.SAVE_XML_DATA            SAVE_XML_DATA         , \n"
                 . "  b.CRC_XML_DATA             CRC_XML_DATA          , \n"
                 . "  b.STATE                    STATE                   \n"
                 . " FROM tbl_calko_header a, tbl_calko_result b \n"
                 . " WHERE a.ESTI_NO    = b.ESTI_NO\n"
                 . " AND   a.ESTI_NO    = '{$p_esti_no}'\n"
                 . " AND " . ( $memInfor['user_level'] >= 2 ?" a.REG_USER_ID <> ''":" a.REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
                 //. " AND   b.SEQ        = '{$p_seq}'\n"
            ;
            $loopCnt = 0;

            $stmt = $db->multiRowSQLQuery($sql);
            while ($r = $db->multiRowFetch($stmt)) {
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
                $standard               = $r->STANDARD              ;
                $category               = $r->CATEGORY              ;
                $mat_no                 = $r->MAT_NO                ;
                $pre_crc_code           = $r->PRE_CRC_CODE          ;
                $crc_xml_data           = $r->CRC_XML_DATA          ;
                $save_xml_data          = $r->SAVE_XML_DATA         ;
                $state                  = $r->STATE                 ;
                $xml = simplexml_load_string('<xml>'.$save_xml_data.'</xml>');
                if ( $loopCnt == 0 ) {
                    $reqXml.= "<ZKSSD0003>"
                           .  "<BSTKD>"   . $p_esti_no                          . "</BSTKD>"  // 견적번호
                           .  "<BSTDK>"   . str_replace('-','',$xml->quotation_date        ) . "</BSTDK>"  // 예상 견적일
                           .  "<KETDAT>"  . str_replace('-','',$xml->expected_delivery_date) . "</KETDAT>" // 예상 납기일
                         //.  "<KETDAT>20100101</KETDAT>" // 예상 납기일
                           .  "<SNIND>"   . $standard                           . "</SNIND>"  // 표준:1, 비표준:2
                           .  "<BSTKD_E>" . $xml->project_name                  . "</BSTKD_E>"// 현장명 (Project Name)
                           .  "<IHREZ>"   . $xml->sales_in_charge               . "</IHREZ>"  // 영업담당자 (sales in charge)
                           .  "<KUNNR>"   . $sold_to_party                      . "</KUNNR>"  // Branch(현장브랜치:우편번호기준, TIS에 Mapping table을 이용하여 Sap 코드로 전송 (ex) 01->50000001)) (Sold-to-party)
                           .  "<VBELN></VBELN>"  // 참조견적번호(SAP)
                         //.  "<VDATU>20100101</VDATU>"  // DATE    Delivery Date
                         //.  "<VDATU>"  . str_replace('-','',$xml->expected_delivery_date) . "</VDATU>"  // DATE   Delivery Date
                           .  "<BNAME>"   . $xml->name_of_client    . "</BNAME>"  // 발주처
                           .  "<DATA_FLAG>I</DATA_FLAG>"  // 전송 상태 관리 Flag
                           .  "</ZKSSD0003>\n";
                }

                $reqXml.= "<ZKSSD0004>"
                       .  "<BSTKD>"   . $p_esti_no                      . "</BSTKD>"  // 견적번호
                       .  "<BSTZD>"   . $seq                            . "</BSTZD>"  // 견적순번
                       .  "<PSTYV>"   . $category                       . "</PSTYV>"  // Item Category <-- "AGC"로 고정
                       .  "<MATNR>"   . $mat_no                         . "</MATNR>"  // Material No. <-- CRC에서 받은 MATNR
                       .  "<KWMENG>"  . $total_unit                     . "</KWMENG>" // Quantity <-- CRC요청시 입력 수량
                       .  "<SNIND>"   . $standard                       . "</SNIND>"  // 1:Standard, 2:Non-standard, 3:Mod <-- "1"고정
                       .  "</ZKSSD0004>";
/**/
                foreach( $xml as $key => $value ) {
                    if ( eregi ( '^E([0-9]{4})$', $key) ) {
                        //echo '' . $key . ' : ' . $value . "\n";
                        $reqXml.= "<ZKSSD0005>"
                                .  "<BSTKD>"  . $p_esti_no  . "</BSTKD>"  // 견적번호
                                .  "<BSTZD>"  . $seq        . "</BSTZD>"  // 견적순번
                                .  "<ATNAM>"  . str_replace('E',$pre_crc_code,$key  ). "</ATNAM>"  // ICharacteristic Code <-- CRC에서 받은 CRC코드(DSA5006)
                                .  "<ATWRT>"  . str_replace(',',''   ,$value). "</ATWRT>"  // MCharacteristic Value <-- CRC에서 받은 CRC Code Value
                                . "</ZKSSD0005>";
                    }
                }
/* ---------- 주석 열어서 실행 구현되어야함..*/

                $savedata = array();
                $savedata['ESTI_NO'         ] = "'" . $esti_no    . "'";
                $savedata['SEQ'             ] = "'" . $seq        . "'";
                $savedata['SEND_XML_DATA'   ] = "'" . addslashes($reqXml) . "'";
                //echo 'seq :' . $seq . "\n";
                if ( !($success=specSave('U',$savedata)) ) {
                    $errors[] = xlate('tbl_calko_result Update Error.' );
                }

                $loopCnt++;
            }
            //echo '$reqXml : ' . $reqXml;

            $sendTPXML = '<?xml version="1.0" encoding="UTF-8"?>'. "\n"
                       .  "<ns0:MT_CALKO_QUOT_CRE xmlns:ns0='http://lm-erp.tkeasia.com/SD/CALKO_QUOT_CRE'>\n"
                       .  $reqXml
                       .  "\n</ns0:MT_CALKO_QUOT_CRE>\n";
            $XI_MESSAGE = ( get_url_fsockopen( "http://".XI_SERVER_IP.":8000/sap/xi/adapter_plain?namespace=http%3A//lm-erp.tkeasia.com/SD/CALKO_QUOT_CRE&interface=MI_CALKO_QUOT_CRE&service=" . XI_SERVICE_ID . "&party=&agency=&scheme=&QOS=EO&sap-user=pisuper&sap-password=tkd12345&sap-client=001&sap-language=EN",$sendTPXML,"text/xml; charset=UTF-8") ); // POST
            if ( !$XI_MESSAGE ) {
                $savedata = array();
                $savedata['ESTI_NO'         ] = "'" . $esti_no    . "'";
              //$savedata['SEQ'             ] = "'" . $seq        . "'";
                $savedata['TP_SEND_DATE'    ] = "now()";
                $savedata['STATE'           ] = "'8'"  ; // TP전송
                //echo 'seq :' . $seq . "\n";
                $success=specSave('U',$savedata);

                if ( $success ) {
                    $savedata = array();
                    $savedata['ESTI_NO'                ] = "'" . $p_esti_no . "'";
                    $savedata['STATE'                  ] = "8"; // TP전송
                    $success = specHeaderSave('U',$savedata);
                    if ( !$success ) $errors[] = xlate('tbl_calko_header update error!!!');
                } else {
                    if ( !$success ) $errors[] = xlate('tbl_calko_result update error!!!');
                }
            }
            $db->commit();

        } else {
            $errors[] = xlate('The transmission  has been already done.');
        }
        if ( !empty($errors) || !$success ) {
            $success = FALSE;
        }
    } else {
        $errors[] = xlate('Parameter Error!');
    }
    if ( !empty($errors) || !$success ) {
        $success = FALSE;
    }
    if (!empty($errors)) print ('ERROR|'   . $m . '|' . $p_esti_no  . '|' . implode($errors, "', '"));
    else                 print ('SUCCESS|' . $m . '|' . $p_esti_no  . '|' . $XI_MESSAGE . '|' . $sendTPXML);
    $db->release();
} // end if [op=="save_exec"]
else if ( $op == "get_quick_quotation_list") {
?>
<span id=tool_tip style='background-color:#ffffff;position:absolute;border:1px solid black;top:0px;left:0px;z-index:100'></span>

<div>
    <div style='border:1px solid black;border-bottom:0px;width:705px;vertical-align:top'>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=0 align=center style='width:705px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        print "<col width='100'/>";
    }
?>
        <col width='100'/>
        <col width='130'/>
        <col width='150'/>
        <col width='110'/>
        <col width='100'/>
        <col width=''/>
        </colgroup>

        <tr style='height:25px'>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        print "<th>" . xlate("User Name / ID") . "</th>";
    }
?>
        <th><?php print xlate("ESTI_NO"); ?></th>
        <th><?php print xlate("NAME_OF_CLIENT"); ?></th>
        <th><?php print xlate("PROJECT_NAME"); ?></th>
        <th><?php print html_xlate("REG_DATE"); ?></th>
        <th><?php print html_xlate("STATE"); ?></th>
        <th style='cursor:pointer'>X</th><?//모양만있음 실행은 blur이벤트에서 동작함.?>
        </tr>
    </table>
    </div>

    <div style='border:1px solid black;border-bottom:1px solid black;width:705px;height:<?print $memInfor['user_level'] >= 2?'225px':'125px'?>;overflow:scroll;overflow-x:hidden;background-color:#FFFFFF;vertical-align:top'>
    <table class="a_tbl2" align=center cellpadding=0 cellspacing=0 border=0 style='width:705px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        print "<col width='100'/>";
    }
?>
        <col width='100'/>
        <col width='130'/>
        <col width='150'/>
        <col width='110'/>
        <col width='100'/>
        <col width=''/>
        </colgroup>
        <tbody>
<?php
    require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
    $cur_many = 0;
    $db->getConnect();
    //$s_esti_no = $db->quote("%" . $_GET["s_esti_no"] . "%");
    $s_mode = $_GET["s_mode"];
    $s_esti_no = $_GET["s_esti_no"];
    $s_project_name = $_GET["s_project_name"];

    $where = " WHERE " . ($memInfor['user_level'] >= 2? " a.REG_USER_ID<>''" :" a.REG_USER_ID= '" . $memInfor[user_no] . "'") . "\n";
    if ( $s_mode == 'E' ) {
        $where .= ($s_esti_no?" AND a.ESTI_NO LIKE '$s_esti_no%'":'');
    } else {
        $where .= ($s_project_name?" AND a.PROJECT_NAME LIKE '%$s_project_name%'":'');
    }
    //echo 'where : ' . $where . '<BR>';
    $tot = $db->get("SELECT COUNT(*) cnt FROM tbl_calko_header a " . $where)->cnt; // row count

    // pagetab
    $page_tab['js_function' ] = 'fQuickQuotationList';
    $page_tab['s'        ] = !$_GET[s]?1:(int)$_GET[s];
    $page_tab['tot'      ] = $tot;
    $page_tab['how_many' ] = 10;
    $page_tab['more_many'] = 10;
    $page_tab['page_many'] = 10;
    if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    //$sRtn = $db->exec("set names utf8");
    //echo 'tot :' . $tot . '<BR>';
    $sql = "SELECT \n"
         . "  a.ESTI_NO               , \n"
         . "  a.QUOTATION_DATE        , \n"
         . "  a.EXPECTED_DELIVERY_DATE, \n"
         . "  a.SALES_IN_CHARGE       , \n"
         . "  a.NAME_OF_CLIENT        , \n"
         . "  a.PROJECT_NAME          , \n"
         . "  a.COUNTRY_CODE          , \n"
         . "  a.DESTINATION           , \n"
         . "  a.SOLD_TO_PARTY         , \n"
         . "  a.REG_DATE              , \n"
         . "  a.REG_USER_ID           , \n"
         . "  a.REG_USER_EMAIL        , \n"
         . "  a.STATE                 , \n"
         . "  c.USER_NO               , \n"
         . "  c.USER_NAME             , \n"
         . "  c.USER_ID                 \n"
         . " FROM tbl_calko_header a \n"
/*
         . " FROM tbl_calko_header a LEFT OUTER JOIN  \n"
         . "  (\n"
         . "      SELECT                                                           \n"
         . "        ESTI_NO                                                    ,   \n"
         . "        IF ( STATE_2_ESTI_COUNT > 0 OR STATE_3_ESTI_COUNT > 0, 'Save',                           \n"
         . "             IF ( STATE_8_ESTI_COUNT > 0 , 'SPEC Sending', \n"
         . "                  IF ( STATE_9_ESTI_COUNT = TOTAL_ESTI_COUNT , 'Complete','TP Receiving')\n"
         . "             )                                                         \n"
         . "        ) STATE_NAME                                                   \n"
         . "      FROM                                                             \n"
         . "      (                                                                \n"
         . "      SELECT                                                           \n"
         . "        ESTI_NO                                    ,                   \n"
         . "        SUM(if(STATE=2,1,0))   STATE_2_ESTI_COUNT  ,                   \n"
         . "        SUM(if(STATE=3,1,0))   STATE_3_ESTI_COUNT  ,                   \n"
         . "        SUM(if(STATE=8,1,0))   STATE_8_ESTI_COUNT  ,                   \n"
         . "        SUM(if(STATE='S',1,0)) STATE_9_ESTI_COUNT  ,                   \n"
         . "        COUNT(STATE)           TOTAL_ESTI_COUNT                        \n"
         . "      FROM tbl_calko_result                                            \n"
         . str_replace('a.','',$where)
         . "      GROUP BY ESTI_NO                                                 \n"
         . "      ) tmp                                                            \n"
         . "  ) b\n"
         . " ON a.ESTI_NO = b.ESTI_NO "
*/
         . " ,tbl_member c"
         . $where
         . " AND a.REG_USER_ID = c.USER_NO"
         . " ORDER BY a.REG_DATE desc "
       //. " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many
    ;

    $stmt = $db->multiRowSQLQuery($sql);
    while ($r = $db->multiRowFetch($stmt)) {
        $esti_no               = $r->ESTI_NO               ;
        $quotation_date        = $r->QUOTATION_DATE        ;
        $expected_delivery_date= $r->EXPECTED_DELIVERY_DATE;
        $sales_in_charge       = $r->SALES_IN_CHARGE       ;
        $name_of_client        = $r->NAME_OF_CLIENT        ;
        $project_name          = $r->PROJECT_NAME          ;
        $country_code          = $r->COUNTRY_CODE          ;
        $destination           = $r->DESTINATION           ;
        $sold_to_party         = $r->SOLD_TO_PARTY         ;
        $reg_date              = $r->REG_DATE              ;
        $reg_user_id           = $r->REG_USER_ID           ;
        $reg_user_email        = $r->REG_USER_EMAIL        ;
        $state_name            = $r->STATE_NAME            ;
        $state                 = $r->STATE                 ;
        $user_no               = $r->USER_NO               ;
        $user_name             = $r->USER_NAME             ;
        $user_id               = $r->USER_ID               ;

        print "<tr onmouseover='tableUtil.row.activate(this,\"{$esti_no}\");' style='text-align:left'>";
        if ( $memInfor['user_level'] >= 2 ) {
            print "<td style='text-align:center' nowrap title=\"" . $user_name . ' / ' . $user_id . "\"><div style='width:100px;overflow:hidden' class='textOf'><nobr>". $user_name . ' / ' . $user_id . "</nobr></div></td>";
        }
        print "<td style='cursor:pointer;text-align:center' nowrap onmousedown=\"fGetWrite({esti_no:'{$esti_no}',seq:1});return false;\" onmouseover='fQuickQuotationToolTip(event,\"{$esti_no}\");' onmouseout='fQuickQuotationToolTip(event);'><U>". substr($esti_no,0,6) . '-' . substr($esti_no,6,5) . '-' . substr($esti_no,11) . "</U></td>";

        print "<td nowrap><div style='width:130px;overflow:hidden' class='textOf'><nobr>" . ($name_of_client?"". $name_of_client . "":'No Data') . "</nobr></div></td>";
        print "<td nowrap><div style='width:150px;overflow:hidden' class='textOf'><nobr>" . ($project_name?"". $project_name . "":'No Data') . "</nobr></div></td>";
        print "<td nowrap>" . $reg_date . "</td>";
        print "<td style='text-align:center' nowrap>" . ( $state > '1'?$calko_stategory[$state]:'CRC Receiving Error' ) . "</td>";
        print "<td style='text-align:center' align=center >&nbsp;</td>";
        print "</tr>";
    }
    print "<tr>";
    print "<td colspan=6 align=center style='text-align:center;font-weight:bold;'>";
    print "<form id='pForm' name='pForm' method='POST' style='display:inline'>";
    if (!$tot) {
        print "<table cellpadding=0 cellspacing=0 border=0 style='width:100%;height:125px;'><td style='text-align:center'>data is not found</td></table>";
    } else {
        print "<input type=hidden name='s' value='{$s}'>";
        print "<input type=hidden name='tot' value='{$tot}'>";
        //print pageTab ($page_tab);
    }
    print '</form>';
    print "</td>";
    print "</tr>";
?>
        </tbody>
    </table>
    </div>

</div>
<?
    $db->release();
} // end if [op=="get_quick_quotation_list"]
else if ( $op == "get_quick_quotation_detail_list") {
    $s_esti_no = $_GET["s_esti_no"];
    //echo $s_esti_no;
?>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=0 align=center style='width:620px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
        <col width='30' />
        <col width='90' />
        <col width='90' />
        <col width='80' />
        <col width='110'/>
        <col width='110'/>
        <col width='110'/>
        <col width='' />
        </colgroup>
        <thead class=source>
        <tr style='height:25px'>
        <th><?php print xlate("Seq"); ?></th>
        <th><?php print xlate("Name Of Client"); ?></th>
        <th><?php print xlate("Project Name"); ?></th>
        <th><?php print xlate("Country"); ?></th>
        <th><?php print xlate("Destination"); ?></th>
        <th><?php print xlate("Specificaion"); ?></th>
        <th><?php print xlate("Class"); ?></th>
        <th>&nbsp;</th>
        </tr>
        </thead>

        <tbody>
<?php
    $db->getConnect();
    $country_codegory = getCountry();

    $where  = ($s_esti_no?" WHERE a.ESTI_NO = '$s_esti_no'":" WHERE a.ESTI_NO = ''");
    $where .= " AND " . ($memInfor['user_level'] >= 2? " a.REG_USER_ID<>''" :" a.REG_USER_ID= '" . $memInfor[user_no] . "'") . "\n";

    $sql = "SELECT \n"
         . "  a.ESTI_NO               , \n"
         . "  b.SEQ                   , \n"
         . "  a.QUOTATION_DATE        , \n"
         . "  a.EXPECTED_DELIVERY_DATE, \n"
         . "  a.SALES_IN_CHARGE       , \n"
         . "  a.NAME_OF_CLIENT        , \n"
         . "  a.PROJECT_NAME          , \n"
         . "  a.COUNTRY_CODE          , \n"
         . "  a.DESTINATION           , \n"
         . "  a.SOLD_TO_PARTY         , \n"
         . "  a.REG_DATE              , \n"
         . "  a.REG_USER_ID           , \n"
         . "  a.REG_USER_EMAIL        , \n"
         . "  b.SPECIFICATION         , \n"
         . "  b.VALUE                 , \n"
         . "  b.STATE                 , \n"
         . "  c.USER_NO               , \n"
         . "  c.USER_NAME             , \n"
         . "  c.USER_ID                 \n"
         . " FROM tbl_calko_header a \n"
         . " JOIN tbl_calko_result b \n"
         . " ON a.ESTI_NO = b.ESTI_NO "
         . " JOIN tbl_member c"
         . " ON a.REG_USER_ID = c.USER_NO"
         . $where
         . " ORDER BY a.REG_DATE desc "
       //. " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many
    ;
    //echo '<textarea>' . ($sql) . '</textarea>';
    $idx = 0;
    $stmt = $db->multiRowSQLQuery($sql);
    while ($r = $db->multiRowFetch($stmt)) {
        $esti_no               = $r->ESTI_NO               ;
        $seq                   = $r->SEQ                   ;
        $quotation_date        = $r->QUOTATION_DATE        ;
        $expected_delivery_date= $r->EXPECTED_DELIVERY_DATE;
        $sales_in_charge       = $r->SALES_IN_CHARGE       ;
        $name_of_client        = $r->NAME_OF_CLIENT        ;
        $project_name          = $r->PROJECT_NAME          ;
        $country_code          = $r->COUNTRY_CODE          ;
        $country_en_name       = $country_codegory[$r->COUNTRY_CODE];
        $destination           = $r->DESTINATION           ;
        $sold_to_party         = $r->SOLD_TO_PARTY         ;
        $reg_date              = $r->REG_DATE              ;
        $reg_user_id           = $r->REG_USER_ID           ;
        $reg_user_email        = $r->REG_USER_EMAIL        ;
        $specification         = $r->SPECIFICATION         ;
        $class                 = $r->VALUE                 ;
        $state                 = $r->STATE                 ;
        $user_no               = $r->USER_NO               ;
        $user_name             = $r->USER_NAME             ;
        $user_id               = $r->USER_ID               ;

        $addStyle = ($idx==0?"border-top:0px;":"");

        print "<tr onmouseover='tableUtil.row.activate(this);' onmousedown=\"fGetWrite({esti_no:'{$esti_no}',seq:'{$seq}'});return false;\" style='cursor:pointer;text-align:left'>";
        print "<td style='" . $addStyle . "text-align:center' nowrap>". $seq . "</td>";

        print "<td style='" . $addStyle . "' nowrap><div style='width:90px;overflow:hidden' class='textOf'><nobr>" . ($name_of_client?"". $name_of_client . "":'No Data') . "</nobr></div></td>";
        print "<td style='" . $addStyle . "' nowrap><div style='width:100px;overflow:hidden' class='textOf'><nobr>" . ($project_name?"". $project_name . "":'No Data') . "</nobr></div></td>";

        print "<td style='" . $addStyle . "' nowrap><div style='width:70px;overflow:hidden' class='textOf'><nobr>" . $country_en_name . "</nobr></div></td>";

        print "<td style='" . $addStyle . "' nowrap><div style='width:100px;overflow:hidden' class='textOf'><nobr>" . $destination . "</nobr></div></td>";

        print "<td style='" . $addStyle . "' nowrap><div style='width:110px;overflow:hidden' class='textOf'><nobr>" . $specification . "</nobr></div></td>";
        print "<td style='" . $addStyle . "' nowrap><div style='width:110px;overflow:hidden' class='textOf'><nobr>" . $class         . "</nobr></div></td>";
      //print "<td style='" . $addStyle . ";text-align:center' nowrap>" . $quotation_date . "</td>";

        print "<td style='" . $addStyle . ";border-right:0px;text-align:center' align=center >&nbsp;</td>";
        print "</tr>";
        $idx++;
    }
?>
        </tbody>
        <tfoot>
        </tfoot>
    </table>
<?
    $db->release();
} // end if [op=="get_quick_quotation_detail_list"]
else if ( $op == "get_save_state_box_list") {
    $s_esti_no = str_replace('-', '', trim($_GET["s_esti_no"  ])); // s_esti_no
    $s_seq     = trim($_GET["s_seq"]                            ); // s_seq
    $db->getConnect();
?>
<TABLE class='a_tbl3' cellpadding=0 cellspacing=0 border=0 align=left style='width:215px;background-color:#FFFFFF'>
<colgroup>
    <col width='30'/>
    <col width='60'/>
    <col width='125'/>
    <col width=''/>
</colgroup>

<TR align=center style='height:18px'>
    <th>Seq</th>
    <th>State</th>
    <th>Class</th>
    <th>&nbsp;</th>
</TR>
<?
    $sql = "SELECT \n"
         . "  SEQ  ,\n"
         . "  O_SEQ,\n"
         . "  STATE,\n"
         . "  VALUE \n"
         . " FROM tbl_calko_result\n"
         . " WHERE ESTI_NO    = '{$s_esti_no}'\n"
         . " ORDER BY O_SEQ\n"
    ;
    //echo 'sql :' . $sql . '<BR>';
    $stategory[''] = '';

    $stmt = $db->multiRowSQLQuery($sql);
    while ($r = $db->multiRowFetch($stmt)) {
        $state = $r->STATE;
        $seq   = $r->SEQ  ;
        $o_seq = $r->O_SEQ;
        $value = $r->VALUE;
?>
<TR <?print ( $seq==$s_seq?'style="font-weight:bold;"':'')?>>
    <TD style='text-align:center'><A HREF="#" onclick='fGetWrite({esti_no:"<?print $s_esti_no?>",seq:<?print $seq?>});return false;'><U style='<?print ( $seq==$p_seq?';font-weight:bold;color:#000000;font-size:10pt':'color:#000000')?>'><?print $seq?></U></A></TD>
    <TD style='text-align:center;font-size:8pt'><?print($calko_stategory[$state])?></TD>
    <TD style='text-align:center;font-size:8pt'><?print($value)?></TD>
    <TD style='text-align:center;font-size:8pt'><a href=# onclick='fChangeSeq("<?=$s_esti_no?>","<?=$seq?>","<?=$o_seq?>","UP");return false;'><font style='color:black'>▲</font></a><a href=# onclick='fChangeSeq("<?=$s_esti_no?>","<?=$seq?>","<?=$o_seq?>","DN");return false;'><font style='color:black'>▼</font></a></TD>
    </TR>
<?
    }
?>
</TABLE>
<?php
    $db->release();

} // end if [op=="get_save_state_box_list"]
else if ( $op == "tp_log") {
    set_time_limit ( 0 );
  //sleep  ( 10);
    $p_esti_no = trim($_GET["p_esti_no"]); // mode [I/U]
    if ( $p_esti_no ) {
        $db->getConnect();
        $sql = "SELECT "
           //. " DISTINCT STATE "
             . " STATE "
             . " FROM tbl_calko_result "
             . " WHERE ESTI_NO    = '$p_esti_no'"
             . " AND   SEQ        = '1'"
             . " AND " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
           //. " ORDER BY STATE asc"
        ;
        $state = $db->get($sql)->STATE; // STATE
        //echo $state;
        if ( $state == 8 || $state == 'P' ) {
                header("content-type: application/xml; charset=UTF-8");
                //$p_esti_no = 'AO09100005101'; //test fixed tp log
                //$p_esti_no = 'X0809006201'; //test fixed tp price
                $logXML = '<?xml version="1.0" encoding="UTF-8"?>'. "\n"
                        .  "<ns0:MT_CALKO_QUOT_LOG_REQUEST xmlns:ns0='http://lm-erp.tkeasia.com/SD/CALKO_QUOT_LOG'>\n"
                        .  "<ZKSSD0001>\n"
                        .  "<BSTKD>" . $p_esti_no . "</BSTKD>\n"
                        .  "</ZKSSD0001>\n"
                        .  "\n</ns0:MT_CALKO_QUOT_LOG_REQUEST>\n";

                //echo $logXML;
                $XI_MESSAGE = ( get_url_fsockopen( "http://".XI_SERVER_IP.":8000/sap/xi/adapter_plain?namespace=http%3A//lm-erp.tkeasia.com/SD/CALKO_QUOT_LOG&interface=MI_CALKO_QUOT_LOG_REQUEST&service=" . XI_SERVICE_ID . "&party=&agency=&scheme=&QOS=BE&sap-user=pisuper&sap-password=tkd12345&sap-client=001&sap-language=EN",$logXML,"text/xml; charset=UTF-8") ); // POST

                $xml_data = str_replace(array('<?xml version="1.0"?>',
                                              '<?xml version="1.0" encoding="UTF-8"?>',
                                              'xmlns:ns1="http://lm-erp.tkeasia.com/SD/CALKO_QUOT_LOG"',
                                              '<ns1:MT_CALKO_QUOT_LOG_RETURN >',
                                              '</ns1:MT_CALKO_QUOT_LOG_RETURN>'
                                              ), '', $XI_MESSAGE);
                if (!$xml_data ) $errors[] = xlate('The XML Data is empty');
                try {
                    $xml = @simplexml_load_string('<xml>'.$xml_data.'</xml>');
                    //echo '길이 :' . sizeof($xml->T_ZKTXI0002) . '<BR>';

                    if (empty($errors)) {
                        $lCnt = sizeof($xml->T_ZKTXI0002);
                        if ( $lCnt > 0 ) {
                            $sCnt = 0;
                            $fCnt = 0;
                            foreach( $xml->T_ZKTXI0002 as $x ) {
                                if ( $x->MSGTYP == 'S' &&
                                     strpos(strtoupper($x->MESSAGE), 'COMPLETED') !== false ) {
                                    $sCnt++;
                                }
                                if ( $x->MSGTYP == 'E' &&
                                     strpos(strtoupper($x->MESSAGE), 'FAILURE') !== false ) {
                                    $fCnt++;
                                }
                            }
                            $sql = "SELECT "
                                 . " COUNT(*) CNT"
                                 . " FROM tbl_calko_result "
                                 . " WHERE ESTI_NO    = '$p_esti_no'"
                               //. " ORDER BY STATE asc"
                            ;

                            $QUOTCOUNT = $db->get($sql )->CNT; // 견적갯수

                            $savedata = array();
                            $tp_state = '';
                            if ( $sCnt >= $QUOTCOUNT ) { // 성공
                                $tp_state = 'S';
                            } else if ( $fCnt > 0 ) { // 실패
                                $tp_state = 'E';
                            } else { // 대기
                                $tp_state = 'P';
                            }

                            //echo $tp_state ;
                            // 에러일경우에만 state를 'E'로 업데이트함
                            // 성공일경우에는 tp 수신후 'S'상태로
                            $savedata['ESTI_NO' ] = "'" . $p_esti_no . "'";
                            $savedata['STATE'   ] = "'" . ($tp_state == 'S'?'P':$tp_state) . "'"; // P : Processing,S : Complete,E : Failure
                            if ( !($success=specSave('U',$savedata,"STATE !='S'")) ) {
                                $errors[] = xlate('tbl_calko_result TP_LOG Update (STATE) Error.' );
                            }
/*
*/
                            // 첫번째견적만(Seq==1) 로그 기록
                            $savedata = array();
                            $savedata['ESTI_NO'         ] = "'" . $p_esti_no    . "'";
                            $savedata['SEQ'             ] = "'1'"   ;
                            $savedata['LOG_XML_DATA'    ] = "'" . addslashes($xml_data) . "'";
                            if ( !($success=specSave('U',$savedata,"STATE !='S'")) ) {
                                $errors[] = xlate('tbl_calko_result TP_LOG Update (LOG_XML_DATA) Error.' );
                            }

                            if ( $success ) {
                                $savedata = array();
                                $savedata['ESTI_NO'                ] = "'" . $p_esti_no . "'";
                                $savedata['STATE'                  ] = "'" . ($tp_state == 'S'?'P':$tp_state) . "'"; // P : Processing,S : Complete,E : Failure
                                $success = specHeaderSave('U',$savedata,"STATE !='S'");
                                if ( !$success ) $errors[] = xlate('tbl_calko_header update error!!!');
                            }

                        } else {
                            $errors[] = xlate('T_ZKTXI0002 node size zero!!');
                        }
                    }

                    if ( empty($errors) ) {
                        print (
                              '<xml>' .
                              $xml_data .
                              '<TP_LOG_STATE>'      . $tp_state     . '</TP_LOG_STATE>'     .
                              '<QUOTATION_COUNT>'   . $QUOTCOUNT    . '</QUOTATION_COUNT>'  .
                              '<SUCCESS_COUNT>'     . $sCnt         . '</SUCCESS_COUNT>'    .
                              '<FAIL_COUNT>'        . $fCnt         . '</FAIL_COUNT>'       .
                              '<LOG_COUNT>'         . $lCnt         . '</LOG_COUNT>'        .
                              '</xml>'
                        );
                        //echo '<xml>' .  '<TP_ERROR>에러 발생.</TP_ERROR>' . '<TP_LOG_STATE>E</TP_LOG_STATE>' . '</xml>';
                    } else {
                      //echo '<ns1:MT_CALKO_QUOT_LOG_RETURN xmlns:ns1="http://lm-erp.tkeasia.com/SD/CALKO_QUOT_LOG">' . join($errors,',') . '</ns1:MT_CALKO_QUOT_LOG_RETURN>';
                        print (
                              '<xml>' .
                              '<TP_ERROR>' . join($errors,',') . '</TP_ERROR>' .
                              '<TP_LOG_STATE>' . $tp_state . '</TP_LOG_STATE>' .
                              '</xml>'
                        );
                    }

                } catch (Exception $e) {
                    print ('<xml>' . '<TP_ERROR>' . $e->getMessage() . '</TP_ERROR>' . '</xml>');
                }
        } else {
            print xlate('<xml><TP_ERROR>Transfer price has been already requested.</TP_ERROR></xml>');
        }
        $db->release();
    } else {
        print xlate('<xml>The quotation number is non-existence.</xml>');
    }
}
else if ( $op == "tp_price") {
    $p_esti_no = trim($_GET["p_esti_no"]); // 견적번호
    $p_msgtyp  = trim($_GET["p_msgtyp" ]); // p_msgtyp [S/E]
    if ( $p_esti_no ) { // && ( $p_msgtyp == 'S' || $p_msgtyp == 'E'
        $db->getConnect();
        //echo 'where : ' . $where . '<BR>';
        $sql = "SELECT "
           //. " DISTINCT STATE "
             . " a.COUNTRY_CODE COUNTRY_CODE,"
             . " a.PROJECT_NAME PROJECT_NAME,"
             . " b.VALUE        CLASS_NAME  ,"
             . " a.STATE        STATE       ,"
             . " b.TP_XML_DATA  TP_XML_DATA ,"
             . " b.TP_SEND_DATE TP_SEND_DATE ,"
             . " c.USER_NAME    USER_NAME   ,"
             . " c.E_MAIL       E_MAIL       "
             . " FROM tbl_calko_header a LEFT OUTER JOIN tbl_member c"
             . " ON a.REG_USER_ID = c.USER_NO,"
             . " tbl_calko_result b\n"
             . " WHERE a.ESTI_NO    = b.ESTI_NO\n"
             . " AND " . ( $memInfor['user_level'] >= 2 ?" a.REG_USER_ID <> ''":" a.REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
             . " AND   a.ESTI_NO    = '{$p_esti_no}'\n"
             . " AND   b.SEQ        = '1'\n"
           //. " ORDER BY STATE asc"
        ;

        $r = $db->get($sql);
        $country_code= $r->COUNTRY_CODE ;
        $class_name  = $r->CLASS_NAME   ;
        $project_name= $r->PROJECT_NAME ;
        $state       = $r->STATE        ;
        $tp_xml_data = $r->TP_XML_DATA  ;
        $tp_send_date= $r->TP_SEND_DATE ;
        $user_name   = $r->USER_NAME    ;
        $e_mail      = $r->E_MAIL       ;

        if ( $state == 'P' ) {
            $logXML = '<?xml version="1.0" encoding="UTF-8"?>'. "\n"
                    .  "<ns0:MT_CALKO_TRANSFER_PRICE_REQUEST xmlns:ns0='http://lm-erp.tkeasia.com/SD/CALKO_TRANSFER_PRICE'>\n"
                    .  "<ZKSSD0001>\n"
                    .  "<BSTKD>" . $p_esti_no . "</BSTKD>\n"
                    .  "</ZKSSD0001>\n"
                    .  "\n</ns0:MT_CALKO_TRANSFER_PRICE_REQUEST>\n";
            $XI_MESSAGE = ( get_url_fsockopen( "http://".XI_SERVER_IP.":8000/sap/xi/adapter_plain?namespace=http%3A//lm-erp.tkeasia.com/SD/CALKO_TRANSFER_PRICE&interface=MI_CALKO_TRANSFER_PRICE_REQUEST&service=" . XI_SERVICE_ID . "&party=&agency=&scheme=&QOS=BE&sap-user=pisuper&sap-password=tkd12345&sap-client=001&sap-language=EN",$logXML,"text/xml; charset=UTF-8") ); // POST

            if ( $XI_MESSAGE ) {
                $xml_data = str_replace(array('<?xml version="1.0"?>',
                                              '<?xml version="1.0" encoding="UTF-8"?>',
                                              'xmlns:ns1="http://lm-erp.tkeasia.com/SD/CALKO_TRANSFER_PRICE"',
                                              '<ns1:MT_CALKO_TRANSFER_PRICE_RETURN >',
                                              '</ns1:MT_CALKO_TRANSFER_PRICE_RETURN>'
                                              ), '', $XI_MESSAGE);

                if (!$xml_data ) $errors[] = xlate('The XML Data is empty');

                try {
                    //$xml_data = htmlspecialchars($xml_data);
                    $xml = @simplexml_load_string('<xml>'.addslashes($xml_data).'</xml>');
                    //echo '길이 :' . sizeof($xml->ZKSDT0003) . '<BR>';
                    if (empty($errors)) {
                        if ( sizeof($xml->ZKSDT0003) > 0 ) {
/*
                            $sql = "SELECT "
                                 . " COUNT(*) CNT"
                                 . " FROM tbl_calko_result "
                                 . " WHERE REG_USER_ID= '" . $memInfor[user_no] . "'\n"
                                 . " AND   ESTI_NO    = '$p_esti_no'"
                               //. " ORDER BY STATE asc"
                            ;
                            $QUOTCOUNT = $db->get($sql )->CNT; // 견적갯수
*/
                            $sql = "SELECT \n"
                                 . "  a.ACCOUNTING_NO   ACCOUNTING_NO  ,\n"
                                 . "  a.ACCOUNTING_YEAR ACCOUNTING_YEAR,\n"
                                 . "  a.MARGIN_RATE     MARGIN_RATE    ,\n"
                                 . "  a.MARKUP_RATE     MARKUP_RATE    ,\n"
                                 . "  a.SGNA_RATE       SGNA_RATE      ,\n"
                                 . "  a.EXCHANGE_RATE   EXCHANGE_RATE   \n"
                                 . " FROM tbl_accounting_exchange_rate a, tbl_calko_class_name cn\n"
                                 . " WHERE a.USE_YN = 'Y'\n"
                                 . " AND   a.COUNTRY_CODE = '" . $country_code . "'\n"
                                 . " AND   a.CLASS_NAME   = '" . $class_name   . "'\n"
                                 . " AND   a.ACCOUNTING_YEAR = '" . ACCOUNTING_YEAR . "'\n"
                                 . " AND   a.CLASS_NAME   = cn.CLASS_NAME\n"
                                 . " AND   cn.USE_YN = 'Y'\n"
                                 ;

                            $exchangeInfo = $db->get($sql);
                            if ( !empty($exchangeInfo) ) {
                                $margin_rate   = $exchangeInfo->MARGIN_RATE     ;
                                $markup_rate   = $exchangeInfo->MARKUP_RATE     ;
                                $sgna_rate     = $exchangeInfo->SGNA_RATE       ;
                                $exchange_rate = $exchangeInfo->EXCHANGE_RATE   ;

                                $tp_amt_arrs = array();
                                $tp_xml_arrs = array();
                                $sap_esti_no = ''; // sap 견적번호

                                foreach( $xml->ZKSDT0003 as $x ) {
                                    $sap_esti_no    = $x->VBELN;
                                    $posnr          = $x->POSNR;
                                    $kursk          = (float) $x->KURSK;
                                    $tp_amt_arrs[$posnr/10] += (float) $x->TP_NETWR * ($kursk?$kursk:1);
                                    $tp_xml_arrs[$posnr/10][] = $x->asXML();
                                    //echo 'kursk : ' . $kursk . '<BR>';
                                }

                                //echo '길이 :' . sizeof($tp_xml_arrs) . '<BR>';
                                foreach ($tp_xml_arrs as $k => $v) {
                                    $savedata = array();
                                    $savedata['ESTI_NO'         ] = "'" . $p_esti_no    . "'";
                                    $savedata['SEQ'             ] = "'" . $k            . "'";
                                    $savedata['TP_RECV_DATE'    ] = "now()";
                                    $savedata['TP_XML_DATA'     ] = "'" . addslashes(join($v))  . "'";
                                    $savedata['TP_AMT'          ] = "'" . $tp_amt_arrs[$k]      . "'";
                                    $savedata['SAP_ESTI_NO'     ] = "'" . $sap_esti_no          . "'";
                                    $savedata['STATE'           ] = "'S'"; // P : Processing,S : Complete,E : Failure
                                    $savedata['MARGIN_RATE'     ] = "'" . $margin_rate          . "'";
                                    $savedata['MARKUP_RATE'     ] = "'" . $markup_rate          . "'";
                                    $savedata['SGNA_RATE'       ] = "'" . $sgna_rate            . "'";
                                    $savedata['EXCHANGE_RATE'   ] = "'" . $exchange_rate        . "'";

                                    if ( !($success=specSave('U',$savedata)) ) {
                                        $errors[] = xlate('tbl_calko_result TP_PRICE Update Error.\n p_msgtyp : "S"' );
                                        $errors[] = $db->getLastSql();
                                        break;
                                    }
                                }

                                if ( $success ) {
                                    $savedata = array();
                                    $savedata['ESTI_NO'                ] = "'" . $p_esti_no . "'";
                                    $savedata['STATE'                  ] = "'S'"; // P : Processing,S : Complete,E : Failure
                                    $success = specHeaderSave('U',$savedata);
                                    if ( !$success ) $errors[] = xlate('tbl_calko_header update error!!!');
                                }
                            } else {
                                $margin_rate   = 0;
                                $markup_rate   = 0;
                                $sgna_rate     = 0;
                                $exchange_rate = 0;
                                $errors[] = xlate('Exchange of information does not exist.( \'' . ACCOUNTING_YEAR . '\' - \'' . $country_code . '\' - \'' . $class_name . '\')');
                            }
                        } else {
                            $errors[] = xlate('ZKSDT0003 node size zero!!');
                        }
                    }
                } catch (Exception $e) {
                    $errors[] = $e->getMessage();
                }
            }
        } else {
            $errors[] = xlate('The quotation number is non-existence or Processing has been already requested.');
        }
    } else {
        $errors[] = xlate('The quotation number is non-existence.');
    }
    if (!empty($errors)) {
        echo 'ERROR|'   . $op . '|' . $p_msgtyp  . '|' . implode($errors, "', '");
    } else {
        echo 'SUCCESS|' . $op . '|' . $p_msgtyp  . '|' . '';

        // 로그레벨 설정 상수가 Log.php에 들어 있기 때문에
        // 로그 레벨 설정과 logger.php보다 Log.php를 먼저 require 해줘야 한다.
        require_once 'Log.php';
        /*
         * PEAR_LOG_EMERG   emerg() 시스템이 사용 불가 상태에 빠졌다.
         * PEAR_LOG_ALERT   alert() 즉시 처리가 필요하다.
         * PEAR_LOG_CRIT    crit() 심각한 상태이다.
         * PEAR_LOG_ERR     err() 오류
         * PEAR_LOG_WARNING warning() 경고
         * PEAR_LOG_NOTICE  notice() 주의
         * PEAR_LOG_INFO    info() 정보
         * PEAR_LOG_DEBUG   debug() 디버그 메시지
        */
        //echo 'SERVER_GUBUN : ' . SERVER_GUBUN . '<BR>';
/**/
        if ( SERVER_GUBUN == '1' ) {
            define('LOG_FILENAME'   , 'C:/WEB_APP/logs/calko_tp_receive_n_sendmail.log');
        } else {
            define('LOG_FILENAME'   , '/work/logs/calko_tp_receive_n_sendmail.log');
        }

        define('LOG_LEVEL'      , PEAR_LOG_DEBUG    );
        define('PHP_LOG_LEVEL'  , PEAR_LOG_WARNING  );
        //echo 'LOG_FILENAME : ' . LOG_FILENAME;
        $today_date = date('Ymd', mktime()); // 오늘날짜 yyyymmdd 형태

        $conf = array(
            'buffering' => false,
            'lineFormat' => '',
            'timeFormat' => '%Y-%m-%d %H:%M:%S'
        );
        $logger = &Log::singleton('file', LOG_FILENAME . "." . $today_date, 'tp', $conf);
        //$logger = &Log::singleton('display', '', 'tp', $conf);
        //$logger = &Log::singleton('console', '', 'tp', $conf);

        //$mask = Log::UPTO(^PEAR_LOG_WARNING | PEAR_LOG_WARNING);
        $mask = PEAR_LOG_ALL ^ Log::MASK(PEAR_LOG_NOTICE);
        $logger->setMask($mask);

        require_once SERVICE_DIR . '/common/lib/logger.inc';
        //$e_mail = 'jihun.kim@tkek.co.kr';
        //$user_name = 'test';

        if ( $e_mail ) {
            //echo $e_mail;
            require_once SERVICE_DIR . '/common/lib/file.inc';
            require_once SERVICE_DIR . '/common/lib/mail.inc';

             $message = '<html>' . "\n"
                      . '<body>' ."\n"
                      . 'Dear Sir or Madam,' . "<br>" ."<br>" ."<br>" ."\n"
                      . 'Thanks for using Calko, TKEK Quotation System.' . "<br>" ."<br>" . "\n"
                      . 'Attached please find the quotation link for your review.' . "<br>" ."<br>" . "\n"
                      . 'Please don\'t hesitate to contact TKEK Oversea team if you have any queries.' . "<br><br>" . "\n"

                      . "<TABLE style='padding:10px;border-collapse:collapse;border:1px solid black' border=1>" . "\n"
                      . "    <TR>" . "\n"
                      . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Quotation Number</TD>". "\n"
                      . "    <TD style='padding:0px 4px 0px 4px'>" . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . "</TD>". "\n"
                      . "    </TR>". "\n"
                      . "    <TR>". "\n"
                      . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Requesting Date</TD>". "\n"
                      . "    <TD style='padding:0px 4px 0px 4px'>" . $tp_send_date . "</TD>". "\n"
                      . "    </TR>". "\n"
                      . "    <TR>". "\n"
                      . "    <TD style='padding:0px 4px 0px 4px;background-color:#7B7B7B;color:white;height:30px;font-weight:bold'>Quotation Link</TD>". "\n"
                      . "    <TD style='padding:0px 4px 0px 4px'>" . "<b><a href=\"http://" . SERVER_DOMAIN . "/?backurl=". urlencode("/calko/calko_write.php?p_esti_no=") . $p_esti_no . "\">" . "http://" . SERVER_DOMAIN . "/?backurl=/calko/calko_write.php?p_esti_no=" . $p_esti_no . "</a></b>" . "</TD>". "\n"
                      . "    </TR>". "\n"
                      . "</TABLE>". "\n"
                      . "<BR>". "\n"
                    //. 'CENE Team : 82-2-2610-7764' ."<br>" . "<br>" . "\n"
                    //. 'AMS Team  : ...' . "<br>" . "\n"
                      . 'Best Regards, TKEK oversea team.' . "<br>" . "\n"
                      . '</body>' . "\n"
                      . '</html>' . "\n";
            ;
//echo 'http://'.SERVER_DOMAIN.'/calko/calko_tp_print_data_create.php?p_esti_no=' . $p_esti_no . '&p_seq=' . $p_seq;
            $data = file_wget_contents('http://'.SERVER_DOMAIN.'/calko/calko_tp_print_data_create.php?p_esti_no=' . $p_esti_no . '&p_seq=' . $p_seq, 30, '');
            //echo $data ;
            f_writeFile(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html', $data );

            $fInfo = array();
            $p_file_cnt = 1;
            for ( $i=0;$i<$p_file_cnt;$i++) {
                if ( @file_exists(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html') ) {
                    $tmpFinfo[dir      ] = SERVER_TMP;
                    $tmpFinfo[real_name] = iconv("UTF-8", "EUC-KR",'Quotation_'.$p_esti_no.'.html');
                    $tmpFinfo[size     ] = @filesize(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html');
                    $tmpFinfo[name     ] = '';
                    //echo 'size : ' . $tmpFinfo[size     ]. "\n";
                    $fInfo[] = $tmpFinfo;
                }
            }

            $sql = "SELECT \n"
                 . "  USER_NAME,\n"
                 . "  E_MAIL    \n"
                 . " FROM tbl_member\n"
                 . " WHERE USER_ID = 'admin'\n"
               //. " WHERE USER_LEVEL = 9\n"
                 ;
            $adminInfo = $db->get($sql);

            //echo SERVER_TMP.'/Quotation_'.$p_esti_no.'.html';
            //$e_mail = 'jihun.kim@tkek.co.kr';
            //$user_name = '관뤼자';
            $sendMailItem = new sendMailItem("mail.tkek.co.kr",25,
                                             $e_mail, $user_name,
                                             $adminInfo->E_MAIL ,$adminInfo->USER_NAME,
                                             "[TKEK] Quotation Completed - " . $project_name . '(' . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . ') / ' . date('Y/m/d h:i:s A') ,"text/html",
                                           //$message
                                             $message,$fInfo
                                            );

            $sendmail_flag = sendMail($sendMailItem);
            //exec("rm " . SERVER_TMP.'/Quotation_'.$p_esti_no.'.html');
            f_unlink(SERVER_TMP.'/Quotation_'.$p_esti_no.'.html');

            //echo '$sendmail_flag : ' . $sendmail_flag;
            if ($sendmail_flag) {
                $logger->log(iconv("UTF-8", "EUC-KR","## Send Mail Success : " . $p_esti_no . $NL));
            } else {
                $logger->log(iconv("UTF-8", "EUC-KR","## Send Mail Fail : " . $p_esti_no . $NL));
            }

            $savedata = array();
            $savedata['ESTI_NO'         ] = "'" . $p_esti_no    . "'";
            $savedata['SEND_MAIL'       ] = "'" . ($sendmail_flag?'S':'F'). "'";
            $savedata['SEND_MAIL_DATE'  ] = "now()";

            if ( !($success=specSave('U',$savedata)) ) {
                $logger->log(iconv("UTF-8", "EUC-KR","## tbl_calko_result SEND_MAIL Update Error : " . $p_esti_no . $NL));
            }

        } else {
            $logger->log(iconv("UTF-8", "EUC-KR","## invalid Mail (PHP) : " . $p_esti_no . $NL));
        }

    }
    $db->release();


} // end if [op=="tp_price"]
else if ( $op == "get_tp_log_list") {
    $p_esti_no  = trim($_GET["p_esti_no"]);
    //echo 'p_esti_no :' . $p_esti_no . '<BR>';
    require_once '../inc/inner_header.php'; // header
?>
<link rel=stylesheet href='calko_write.css' type='text/css'>
<div id='get_tp_log_list'>
    <div style='border:1px solid black;border-bottom:0px;width:658px;vertical-align:top'>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=0 align=center style='width:658px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
        <col width='60'/>
        <col width='45'/>
        <col width='40'/>
        <col width='85'/>
        <col width='50'/>
        <col width='130'/>
        <col width='230'/>
        <col width=''/>
        </colgroup>
        <thead>
        <tr style='height:25px'>
        <th><?php print xlate("DATE"); ?></th>
        <th><?php print xlate("TIME"); ?></th>
        <th><?php print xlate("TYPE"); ?></th>
        <th><?php print html_xlate("Quotation No"); ?></th>
        <th><?php print html_xlate("Item No"); ?></th>
        <th><?php print html_xlate("HEADER"); ?></th>
        <th><?php print html_xlate("MESSAGE"); ?></th>
        <th><input type=button value='X' style='font-weight:bold;font-size:7pt;border:0px solid black;cursor:pointer;background-color:transparent;width:100%;height:24px;' onclick='parent.$("view_iframe_log").style.display="none"' title='Close'></th>
        </tr>
        </thead>
    </table>
    </div>

    <div style='border:1px solid black;border-bottom:1px solid black;width:658px;height:375px;overflow:scroll;overflow-x:hidden;background-color:#FFFFFF;vertical-align:top'>
    <table class="a_tbl2" align=center cellpadding=0 cellspacing=0 border=0 style='width:658px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
        <col width='60'/>
        <col width='45'/>
        <col width='40'/>
        <col width='85'/>
        <col width='50'/>
        <col width='130'/>
        <col width='230'/>
        <col width=''/>
        </colgroup>
        <tbody>
<?php
    $db->getConnect();
    $sql = "SELECT "
         . " LOG_XML_DATA "
         . " FROM tbl_calko_result "
         . " WHERE " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . " AND   ESTI_NO    = '$p_esti_no'"
         . " AND   SEQ        = '1'"
    ;
    $xml_data = $db->get($sql)->LOG_XML_DATA; // row count
    $xml_data = str_replace(array('<?xml version="1.0"?>','<?xml version="1.0" encoding="UTF-8"?>','xmlns:ns1="http://lm-erp.tkeasia.com/SD/CALKO_QUOT_LOG"'), '', $xml_data);
    $xml_data = str_replace(array('<ns1:MT_CALKO_QUOT_LOG_RETURN >','</ns1:MT_CALKO_QUOT_LOG_RETURN>'), '', $xml_data);
    $xml = simplexml_load_string('<xml>'.$xml_data.'</xml>');

    if (!$xml_data ) $errors[] = xlate('The XML Data is empty');
    $tot = sizeof($xml->T_ZKTXI0002);
    foreach( $xml->T_ZKTXI0002 as $x ) {
        $LOG_DATE = $x->LOG_DATE;
        $LOG_TIME = $x->LOG_TIME;
        $MSGTYP   = $x->MSGTYP  ;
        $TISNUM   = $x->TISNUM  ;
        $HEADER   = $x->HEADER  ;
        $MESSAGE  = $x->MESSAGE ;
        $VBELN    = $x->VBELN   ;
        $POSNR2   = $x->POSNR2  ;
        $TISNUM   = $x->TISNUM  ;

        if (
             $MSGTYP == 'E'                     ||
             $HEADER == 'Quotation'             ||
             $HEADER == 'Quotation BDC Running' ||
             $HEADER == 'Quotation Line Item'   ||
             $HEADER == 'TRANSFER PRICE' ||
             true
        ) {
            print "<tr style='cursor:pointer' onmousedown='tableUtil.row.activate(this);'>";
            print "<td style='text-align:center' nowrap>". $LOG_DATE . "</td>";
            print "<td style='text-align:center' nowrap>" . $LOG_TIME . "</td>";
            print "<td style='text-align:center' nowrap>" . $MSGTYP . "</td>";
            print "<td style='text-align:center' nowrap>" . $TISNUM . "</td>";
            print "<td style='text-align:center' nowrap>" . $POSNR2 . "</td>";

            print "<td nowrap><div style='overflow:hidden' class='textOf'><nobr><input type=text value='" . $HEADER . "' style='border:1px solid black;width:100%;background-color:transparent' onfocus='this.select()'></nobr></div></td>";
            print "<td nowrap><div style='overflow:hidden' class='textOf'><nobr><input type=text value='" . $MESSAGE . "' style='border:1px solid black;width:100%;background-color:transparent' onfocus='this.select()'></nobr></div></td>";
            print "<td style='text-align:center' align=center >&nbsp;</td>";
            print "</tr>";
        }
    }
    print "<tr>";
    print "<td colspan=7 align=center style='text-align:center;font-weight:bold;'>";
    if (!$tot) {
        print "<table cellpadding=0 cellspacing=0 border=0 style='width:100%;height:374px;'><td style='text-align:center'>data is not found</td></table>";
    } else {
    }
    print "</td>";
    print "</tr>";
?>
        </tbody>
    </table>
    </div>

</div>
<?
    require_once '../inc/footer.php'; // footer
    $db->release();
} // end if [op=="get_tp_log_list"]
else if ( $op == "get_tp_list") {
    $p_mode     = $_GET["p_mode"]?$_GET["p_mode"]:'list'; // list / excel
    $p_esti_no  = trim($_GET["p_esti_no"]);
    $p_seq      = trim($_GET["p_seq"    ]);

    if ( $p_mode == 'excel' ) {
        header("Content-type: file/unknown; charset=utf-8");
        header("Content-Disposition: attachment; filename=tp_" . $p_esti_no . '_' . date("Ymdhis") . '.xls' );
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
    if ( $p_mode == 'list' ) {
        require_once '../inc/inner_header.php'; // header
?>
<link rel=stylesheet href='calko_write.css' type='text/css'>
<div id='get_tp_list'>
    <div style='border:1px solid black;border-bottom:0px;width:608px;vertical-align:top'>
<?
    } else {
?>
<html>
<body>
<style>
    * { font-size:8pt }
</style>
<?
    }
    if ( $p_mode == 'list' ) {
?>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=0 align=center style='width:608px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
        <col width='30'/>
        <col width='40'/>
        <col width='85'/>
        <col width='65'/>
        <col width='170'/>
        <col width='50'/>
        <col width='80'/>
        <col width='70'/>
        <col width=''/>
<?
    } else {
?>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=1 bordercolor=black align=center style='width:100%;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
        <col width='30'/>
        <col width='60'/>
        <col width='100'/>
        <col width='100'/>
        <col width='170'/>
        <col width='100'/>
        <col width='100'/>
        <col width='70'/>
        <col width=''/>
<?
    }
?>
        </colgroup>

        <thead>
<?
    $db->getConnect();
    $sql = "SELECT "
         . " MARGIN_RATE   ,"
         . " MARKUP_RATE   ,"
         . " SGNA_RATE     ,"
         . " EXCHANGE_RATE ,"
         . " SAVE_XML_DATA ,"
         . " TP_XML_DATA   ,"
         . " TP_AMT         "
         . " FROM tbl_calko_result "
         . " WHERE " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . " AND   ESTI_NO  = '$p_esti_no'"
         . " AND   SEQ      = '{$p_seq}'\n"
    ;
    $stmt = $db->multiRowSQLQuery($sql);
    $r = $db->multiRowFetch($stmt);
    $margin_rate   = $r->MARGIN_RATE  ;
    $markup_rate   = $r->MARKUP_RATE  ;
    $sgna_rate     = $r->SGNA_RATE    ;
    $exchange_rate = $r->EXCHANGE_RATE;
    $save_xml_data  = $r->SAVE_XML_DATA;
    $xml_data       = $r->TP_XML_DATA;
  //$tp_amt         = $r->TP_AMT     ;
    $tp_amt         = 0;

    $x = simplexml_load_string('<xml>'.$save_xml_data.'</xml>');

    $country_codegory = getCountry();

    //echo ;
    if ( $p_mode == 'excel' ) {
?>
        <tr style='height:10px;'>
        <th colspan=9>&nbsp;</th>
        </tr>

        <tr style='height:25px;background-color:gray;color:white'>
        <th colspan=2><?php print xlate("Country"); ?></th>
        <td><?php print $country_codegory[getXValue('country_code',$x)]; ?></td>
        <th><?php print xlate("Destination"); ?></th>
        <td><?php print getXValue('destination',$x); ?></td>

        <th><?php print xlate("Specification"); ?></th>
        <td colspan=2><?php print getXValue('specification',$x); ?></td>
        </tr>

<?
   }
?>
        <tr style='height:25px;background-color:gray;color:white'>
        <th><?php print xlate("Seq"); ?></th>
        <th><?php print xlate("Comp code"); ?></th>
        <th><?php print xlate("Group name"); ?></th>
        <th><?php print xlate("Code"); ?></th>
        <th><?php print xlate("Code name"); ?></th>
        <th><?php print xlate("Quantity"); ?></th>
        <th><?php print html_xlate("Transfer Price"); ?></th>
        <th><?php print html_xlate("SAP No"); ?></th>
        <th>
        <input type=button value='X' style='font-weight:bold;font-size:7pt;border:0px solid black;cursor:pointer;background-color:transparent;width:100%;height:24px;' onclick='parent.$("view_iframe").style.display="none"' title='Close'>
        </th>
        </tr>
        </thead>
<?
    if ( $p_mode == 'list' ) {
?>
    </table>
    </div>

    <div style='border:1px solid black;border-bottom:1px solid black;width:608px;height:340px;overflow:scroll;overflow-x:hidden;background-color:#FFFFFF;vertical-align:top'>

    <table class="a_tbl2" align=center cellpadding=0 cellspacing=0 border=0 style='width:608px;border-collapse:collapse;table-layout:fixed'>

        <colgroup>
        <col width='30'/>
        <col width='40'/>
        <col width='85'/>
        <col width='65'/>
        <col width='170'/>
        <col width='50'/>
        <col width='80'/>
        <col width='70'/>
        <col width=''/>
        </colgroup>
<?
    }
?>
        <tbody>
<?php
    $xml = simplexml_load_string('<xml>'.$xml_data.'</xml>');
    if (!$xml_data ) $errors[] = xlate('The XML Data is empty');
    $tot = sizeof($xml->ZKSDT0003);

    foreach( $xml->ZKSDT0003 as $x ) {
        $BSTKD        = $x->BSTKD       ;
        $POSNR        = $x->POSNR   / 10;
        $COMP_GP      = $x->COMP_GP     ;
        $MATNR        = $x->MATNR       ;
        $COMP_GP_NAME = $x->COMP_GP_NAME;
        $MAKTX        = $x->MAKTX       ;
        $KWMENG       = $x->KWMENG      ;
        $TP_NETWR     = $x->TP_NETWR    ;
        $VBELN        = $x->VBELN       ;

        $kursk        = (float) $x->KURSK;
        $tp_amt += (float) $x->TP_NETWR * ($kursk?$kursk:1);

        if ( $p_mode == 'list' ) {
    // onmouseover='tableUtil.row.activate(this);'
            print "<tr style='cursor:pointer' onmousedown='tableUtil.row.activate(this);' tabIndex=1>";
          //print "<td style='text-align:center' nowrap>". $BSTKD        . "</td>";
            print "<td style='text-align:center' nowrap>". $POSNR        . "</td>";
            print "<td style='text-align:center' nowrap>". $COMP_GP      . "</td>";
            print "<td nowrap><div style='overflow:hidden' class='textOf'><nobr><input type=text value='" . $COMP_GP_NAME . "' style='border:1px solid gray;width:100%;background-color:transparent' onfocus='this.select()'></nobr></div></td>";
            print "<td style='text-align:center' nowrap title=$COMP_GP>". $MATNR        . "</td>";
            print "<td nowrap><div style='overflow:hidden' class='textOf'><nobr><input type=text value='" . $MAKTX . "' style='border:1px solid gray;width:100%;background-color:transparent' onfocus='this.select()'></nobr></div></td>";
            print "<td style='text-align:center' nowrap>". number_format($KWMENG    )  . "</td>";
            print "<td style='text-align:right' nowrap>". number_format($TP_NETWR,2)  . "</td>";
            print "<td style='text-align:center' nowrap>". $VBELN        . "</td>";

            print "<td style='text-align:center' align=center >&nbsp;</td>";
            print "</tr>";
        } else {
            print "<tr style='cursor:pointer'>";
          //print "<td style='text-align:center' nowrap>". $BSTKD        . "</td>";
            print "<td style='text-align:center' nowrap>". $POSNR        . "</td>";
            print "<td style='text-align:center' nowrap>". $COMP_GP      . "</td>";
            print "<td nowrap><div style='overflow:hidden' class='textOf'><nobr>". $COMP_GP_NAME . "</nobr></div></td>";
            print "<td style='text-align:center' nowrap title=$COMP_GP>". $MATNR        . "</td>";
            print "<td nowrap><div style='overflow:hidden' class='textOf'><nobr>" . $MAKTX . "</nobr></div></td>";
            print "<td style='text-align:center' nowrap>". number_format($KWMENG    )  . "</td>";
            print "<td style='text-align:right' nowrap>". number_format($TP_NETWR,2)  . "</td>";
            print "<td style='text-align:center' nowrap>". $VBELN        . "</td>";

            print "<td style='text-align:center' align=center >&nbsp;</td>";
            print "</tr>";
/*
            print (  $POSNR         . ','
                   . $COMP_GP       . ','
                   . $COMP_GP_NAME  . ','
                   . $MATNR         . ','
                   . $MAKTX         . ','
                   . $KWMENG        . ','
                   . $TP_NETWR      . ','
                   . $VBELN         . "\n");
*/
        }
    }
        print "<tr>";
        print "<td colspan=9 align=center style='text-align:center;font-weight:bold;'>";
        if (!$tot) {
            print "<table cellpadding=0 cellspacing=0 border=0 style='width:100%;height:340px;'><td style='text-align:center'>data is not found</td></table>";
        } else {
        }
        print "</td>";
        print "</tr>";

?>
        </tbody>
<?
    if ( $p_mode == 'list' ) {
?>
    </table>

    </div>

    <table class="a_tbl2" align=left cellpadding=0 cellspacing=0 border=1 bordercolor=black style='background-color:white;width:610px;border-collapse:collapse;table-layout:fixed;vertical-align:top'>
        <colgroup>
        <col width=''/>
        <col width='110'/>
        <col width='150'/>
        </colgroup>
        <tbody>
<?
    }
?>
        <tfoot>
        <tr style='height:25px'>
        <td>&nbsp;</td>
        <th><?php print xlate("Total TP"); ?></th>
        <!-- <td style='padding-left:3px;font-size:10pt'>$<?print number_format(round(($tp_amt*TP_MULTIPLE) / $exchange_rate,0));?> -->
        <td style='padding-left:3px;font-size:10pt'>$<?print number_format(round(( $exchange_rate?(($tp_amt*TP_MULTIPLE) / $exchange_rate):0 ),0));?>
<?
$savedata = array();
$savedata['ESTI_NO'         ] = "'" . $p_esti_no        . "'";
$savedata['SEQ'             ] = "'" . $p_seq            . "'";
$savedata['TP_AMT'          ] = "'" . $tp_amt           . "'";
//$savedata['EXCHANGE_RATE'   ] = "'" . $exchange_rate    . "'";
specSave('U',$savedata);
?>
<?
    if ( $p_mode == 'list' ) {
?>
        &nbsp;<img src='../img/but_excel.gif' onclick='parent.fDownLoadExcelTP();' title='Excel' style='cursor:pointer;padding-right:3px' align=absmiddle>
<?
    }
?>
        </td>
        </tr>
        </tfoot>
    </table>

</div>
<?
        require_once '../inc/inner_footer.php'; // footer
    $db->release();
} // end if [op=="get_tp_list"]
else if ( $op == "get_option_list") {
    $p_mode     = $_GET["p_mode"]?$_GET["p_mode"]:'list';
    $p_esti_no  = trim($_GET["p_esti_no"]);
    $p_seq      = trim($_GET["p_seq"    ]);

    if ( $p_mode == 'excel' ) {
        header("Content-type: file/unknown; charset=utf-8");
        header("Content-Disposition: attachment; filename=option_" . $p_esti_no . '_' . date("Ymdhis") . '.xls' );
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");
    }
    //echo 'p_esti_no :' . $p_esti_no . '<BR>';
    if ( $p_mode == 'list' ) {
        require_once '../inc/inner_header.php'; // header
?>
<link rel=stylesheet href='calko_write.css' type='text/css'>
<div id='get_tp_list'>
    <div style='border:1px solid black;border-bottom:0px;width:392px'>
<?
    } else {
?>
<html>
<body>
<style>
    * { font-size:8pt }
</style>
<?
    }
    if ( $p_mode == 'list' ) {
?>
    <table class="a_tbl2" cellpadding=0 cellspacing=0 border=0 align=center style='width:412px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
        <col width='182'/>
        <col width='214'/>
        <col width=''/>
<?
    } else {
?>
<table class="a_tbl2" cellpadding=0 cellspacing=0 border=1 bordercolor=black align=center style='width:100%;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
        <col width='300'/>
        <col width='294'/>
        <col width=''/>
<?
    }
?>
        </colgroup>

        <thead>
<?
    $db->getConnect();
    $country_code = $db->get("SELECT COUNTRY_CODE FROM tbl_calko_header")->COUNTRY_CODE;
    $total_opt_amt = 0;
    $sql = "SELECT "
         . " SAVE_XML_DATA, "
         . " OPT_AMT      , "
         . " MARGIN_RATE  , "
         . " MARKUP_RATE  , "
         . " SGNA_RATE    , "
         . " EXCHANGE_RATE  "
         . " FROM tbl_calko_result "
         . " WHERE " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . " AND   ESTI_NO    = '$p_esti_no'"
         . " AND   SEQ      = '{$p_seq}'\n"
    ;
    $stmt = $db->multiRowSQLQuery($sql);
    $r = $db->multiRowFetch($stmt);
    $xml_data      = $r->SAVE_XML_DATA;
    $total_opt_amt = (int)$r->OPT_AMT     ;
    $margin_rate   = $r->MARGIN_RATE  ;
    $markup_rate   = $r->MARKUP_RATE  ;
    $sgna_rate     = $r->SGNA_RATE    ;
    $exchange_rate = $r->EXCHANGE_RATE;

    $country_codegory = getCountry();
    $x = simplexml_load_string('<xml>'.$xml_data.'</xml>');

    if ( $p_mode == 'excel' ) {
?>
        <tr style='height:10px;'>
        <th colspan=3>&nbsp;</th>
        </tr>

        <tr style='height:25px'>
        <th colspan=3><?php print $country_codegory[getXValue('country_code',$x)] . ' / ' . getXValue('destination',$x) . ' / ' . getXValue('specification',$x) ;?></th>
        </tr>

        <tr style='height:25px;background-color:gray;color:white'>
        <th><?php print xlate("Name"); ?></th>
        <th><?php print xlate("Option Amount"); ?></th>
        <th>&nbsp;</th>
        </tr>
<?
   } else {
?>
        <tr style='height:25px'>
        <th><?php print xlate("Name"); ?></th>
        <th><?php print xlate("Option Amount"); ?></th>
        <th>
        <input type=button value='X' style='font-weight:bold;font-size:7pt;border:0px solid black;cursor:pointer;background-color:transparent;width:100%;height:24px;' onclick='parent.$("view_iframe").style.display="none"' title='Close'>
        </th>
        </tr>
<?
    }
?>
        </thead>
<?
    if ( $p_mode == 'list' ) {
?>
    </table>
    </div>

    <div style='border:1px solid black;border-bottom:1px solid black;width:412px;height:219px;overflow:scroll;overflow-x:hidden;background-color:#FFFFFF;vertical-align:top'>
    <table class="a_tbl2" align=center cellpadding=0 cellspacing=0 border=0 style='width:392px;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
        <col width='182'/>
        <col width='214'/>
        <col width=''/>
        </colgroup>
<?
    }
?>
        <tbody>
<?php
    $tot = 0;
    foreach ( $x as $k => $v ) {
        if ( eregi ( '^opt_amt_', $k) ) {
            // onmouseover='tableUtil.row.activate(this);'
            //$total_opt_amt += (int) $v;
            print "<tr style='cursor:pointer' onmousedown='tableUtil.row.activate(this);'>";
          //print "<td style='text-align:right' nowrap><a href=# onclick='parent.Effect.twinkle(parent.$(this.parentNode.innerText));parent.$(this.parentNode.innerText).focus();'>". $k  . "</a></td>";
            print "<td style='text-align:right' nowrap>". $k  . "</td>";
            print "<td style='text-align:right' nowrap>". number_format($v)  . "</td>";
            print "<td style='text-align:center' align=center >&nbsp;</td>";
            print "</tr>";
            $tot++;
        }
    }
    print "<tr>";
    print "<td colspan=3 align=center style='text-align:center;font-weight:bold;'>";
    if (!$tot) {
        print "<table cellpadding=0 cellspacing=0 border=0 style='width:100%;height:119px'><td style='text-align:center'>data is not found</td></table>";
    } else {
    }
    print "</td>";
    print "</tr>";
?>
        </tbody>
<?
    if ( $p_mode == 'list' ) {
?>
    </table>


    </div>

    <table class="a_tbl2" align=left cellpadding=0 cellspacing=0 border=1 bordercolor=black style='background-color:white;width:414px;border-collapse:collapse;table-layout:fixed;vertical-align:top'>
        <colgroup>
        <col width='183'/>
        <col width='214'/>
        <col width=''/>
        </colgroup>
        <tbody>
<?
    }
?>
        <tfoot>
        <tr style='height:25px'>
        <th><?php print xlate("Total Option Price"); ?></th>
        <td style='text-align:right;padding-left:0px;padding-right:0px' colspan=3 align=left><?
if ( $exchange_rate ) {
    echo number_format($total_opt_amt) . ' / ' . number_format($exchange_rate,2) . ' = ' ;
} else {
    echo '-';
}
if ( $exchange_rate ) {
    echo '<B style="font-size:9pt">$' . number_format(round($total_opt_amt / $exchange_rate,0) ).'</B>';
} else {
    echo '-';
}
?><?
    if ( $p_mode == 'list' ) {
?>&nbsp;<img src='../img/but_excel.gif' onclick='parent.fDownLoadExcelOPTION();' title='Excel' style='cursor:pointer;padding-right:3px;display:inline' align=absmiddle><?
    }
?>
        </td>
        </tr>
        </tfoot>
    </table>

</div>
<?
    require_once '../inc/inner_footer.php'; // footer

    $db->release();
} // end if [op=="get_option_list"]

else if ( $op == "get_xml") {
    $p_mode     = $_GET["p_mode"]?$_GET["p_mode"]:'send'; // send, tp
    $p_esti_no  = trim($_GET["p_esti_no"]);
    $p_seq      = trim($_GET["p_seq"    ]);

    header("Content-type: file/unknown; charset=utf-8");
    if ( $p_mode == 'send' ) {
        header("Content-Disposition: attachment; filename=" . $p_esti_no . '_' . $p_seq . '_send_'  . date("Ymdhis") . '.xls' );
    } else {
        header("Content-Disposition: attachment; filename=" . $p_esti_no . '_' . $p_seq . '_tp_'    . date("Ymdhis") . '.xls' );
    }

    header("Content-Transfer-Encoding: binary");
    header("Pragma: no-cache");
    header("Expires: 0");

    $db->getConnect();
    $country_code = $db->get("SELECT COUNTRY_CODE FROM tbl_calko_header")->COUNTRY_CODE;
    $total_opt_amt = 0;
    $sql = "SELECT "
         . " SEND_XML_DATA , "
         . " TP_XML_DATA   , "
         . " OPT_AMT      , "
         . " MARGIN_RATE  , "
         . " MARKUP_RATE  , "
         . " SGNA_RATE    , "
         . " EXCHANGE_RATE  "
         . " FROM tbl_calko_result "
         . " WHERE " . ( $memInfor['user_level'] >= 2 ?" REG_USER_ID <> ''":" REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . " AND   ESTI_NO    = '$p_esti_no'"
         . " AND   SEQ      = '{$p_seq}'\n"
    ;
//echo 'sql :' . $sql . '<BR>';
    $stmt = $db->multiRowSQLQuery($sql);
    $r = $db->multiRowFetch($stmt);
    $send_xml_data = $r->SEND_XML_DATA;
    $tp_xml_data   = $r->TP_XML_DATA  ;
    $total_opt_amt = (int)$r->OPT_AMT     ;
    $margin_rate   = $r->MARGIN_RATE  ;
    $markup_rate   = $r->MARKUP_RATE  ;
    $sgna_rate     = $r->SGNA_RATE    ;
    $exchange_rate = $r->EXCHANGE_RATE;

    $country_codegory = getCountry();
    if ( $p_mode == 'send' ) {
        echo '<xml>'.$send_xml_data.'</xml>';
    } else {
        echo '<xml>'.$tp_xml_data.'</xml>';
    }

    $db->release();
} // end if [op=="get_xml"]
else if ( $op == "create_copy_exec") {
    $db->getConnect();
    //var_dump($_POST);
    $p_mode = $_GET["p_mode"];

    $p_esti_no  = str_replace('-', '', trim($_POST["p_esti_no"  ])); // p_esti_no
    $p_seq      = str_replace('-', '', trim($_POST["p_seq"      ])); // p_seq

    if (!$p_esti_no     ) $errors[] = xlate('Quotation Number is Empty!');
    if (!$p_seq         ) $errors[] = xlate('Quotation Seq is Empty!');
    if (empty($errors)) {
        if ( $db->starttransaction() ) {
            $whereCopy[] = " ESTI_NO = '" . $_POST['p_esti_no'] . "' AND SEQ = '" . $_POST['p_seq'] . "' ";
            $sSeq = 0;
            $sql = "SELECT \n"
                 . "  MAX(SEQ) SEQ\n"
                 . " FROM tbl_calko_result \n"
                 . " WHERE ESTI_NO = '" .$p_esti_no . "'"
            ;
            $sSeq = $db->get($sql)->SEQ;
            $sSeq = $sSeq?$sSeq:1;

            if ( empty($errors) ) {
                $sql = "INSERT INTO tbl_calko_result " . "\n"
                     . " (". "\n"
                     . " ESTI_NO          ,". "\n"
                     . " SEQ              ,". "\n"
                     . " QTY              ,". "\n"
                     . " CODE             ,". "\n"
                     . " VALUE            ,". "\n"
                     . " SPECIFICATION    ,". "\n"
                     . " STANDARD         ,". "\n"
                     . " PRE_CRC_CODE     ,". "\n"

                     . " CATEGORY         ,". "\n"
                     . " MAT_NO           ,". "\n"
                     . " CRC_XML_DATA     ,". "\n"
                     . " SAVE_XML_DATA    ,". "\n"
                     . " SEND_XML_DATA    ,". "\n"
                     . " LOG_XML_DATA     ,". "\n"
                     . " TP_XML_DATA      ,". "\n"

                     . " OPT_AMT          ,". "\n"
                     . " TP_AMT           ,". "\n"

                     . " CRC_SEND_DATE    ,". "\n"
                     . " CRC_RECV_DATE    ,". "\n"
                     . " TP_SEND_DATE     ,". "\n"
                     . " TP_RECV_DATE     ,". "\n"
                     . " SAVE_DATE        ,". "\n"

                     . " SAP_ESTI_NO      ,". "\n"

                     . " STATE            ,". "\n"

                     . " MARKUP_RATE      ,". "\n"
                     . " SGNA_RATE        ,". "\n"
                     . " EXCHANGE_RATE    ,". "\n"

                     . " COPY_ESTI_NO     ,". "\n"
                     . " COPY_SEQ         ,". "\n"

                     . " REG_DATE         ,". "\n"
                     . " REG_USER_ID      ,". "\n"
                     . " REG_USER_EMAIL   ,". "\n"
                     . " O_SEQ             ". "\n"

                     . " ) ". "\n"
                     . " SELECT ". "\n"
                     . "  '" . $p_esti_no . "',". "\n"
                     . "  (@rownum:=@rownum+1),". "\n"
                     . "  QTY           ,". "\n"
                     . "  CODE          ,". "\n"
                     . "  VALUE         ,". "\n"
                     . "  SPECIFICATION ,". "\n"
                     . "  STANDARD      ,". "\n"
                     . "  PRE_CRC_CODE  ,". "\n"

                     . "  CATEGORY      ,". "\n"
                     . "  MAT_NO        ,". "\n"
                     . "  CRC_XML_DATA  ,". "\n"
                     . "  SAVE_XML_DATA ,". "\n"
                     . "  NULL          ,". "\n"
                     . "  NULL          ,". "\n"
                     . "  NULL          ,". "\n"

                     . "  0             ,". "\n"
                     . "  0             ,". "\n"

                     . "  now()         ,". "\n"
                     . "  now()         ,". "\n"
                     . "  '0000-00-00 00:00:00',". "\n"
                     . "  '0000-00-00 00:00:00',". "\n"
                     . "  '0000-00-00 00:00:00',". "\n"

                     . "  ''            ,". "\n"
                     . "  STATE         ,". "\n"

                     . "  MARKUP_RATE   ,". "\n"
                     . "  SGNA_RATE     ,". "\n"
                     . "  EXCHANGE_RATE ,". "\n"

                     . "  ESTI_NO       ,". "\n"
                     . "  SEQ           ,". "\n"

                     . "  now(),". "\n"
                     . "  '" . $memInfor[user_no] . "',". "\n"
                     . "  '" . $memInfor[user_id] . "',". "\n"
                     . "  (@rownum)      ". "\n"
                     . " FROM tbl_calko_result, (SELECT @rownum:=$sSeq) r ". "\n"
                     . " WHERE " . join(' OR ',$whereCopy) . "". "\n"
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
            $errors[] = xlate('Start Transaction Error');
        }

        if ( !empty($errors) ) {
            $errors[] = xlate('Transaction Rollback.');
            $db->rollback();
        }
    }
    if (!empty($errors)) print ('ERROR|'   . $p_esti_no . '|' . ($sSeq+1) . '|' . implode($errors, "<BR>"));
    else                 print ('SUCCESS|' . $p_esti_no . '|' . ($sSeq+1) . '|' . '');
    $db->release();
} // end if [op=="create_copy_exec"]
else if ( $op == "change_o_seq") {
    $db->getConnect();
    $p_mode = $_POST["p_mode"];

    $p_esti_no  = str_replace('-', '', trim($_POST["p_esti_no"  ])); // p_esti_no
    $p_seq      = str_replace('-', '', trim($_POST["p_seq"      ])); // p_seq
    $p_o_seq    = str_replace('-', '', trim($_POST["p_o_seq"    ])); // p_o_seq

    if (!$p_esti_no     ) $errors[] = xlate('Quotation Number is Empty!');
    if (!$p_o_seq       ) $errors[] = xlate('Quotation Order Seq is Empty!');
    $str = '';
    if ( $db->starttransaction() ) {
        if ( empty($errors) ) {
            $p_o_seq = ( int ) $p_o_seq;
            $limitOrder = $db->get("SELECT MAX(O_SEQ) maxOseq FROM tbl_calko_result WHERE ESTI_NO = '" .$p_esti_no . "'" )->maxOseq;
            if ( $p_mode == 'UP' && $p_o_seq > 1 ) {
                $p_o_seq = $p_o_seq - 1;
                $sql  = "UPDATE tbl_calko_result SET "
                      . " O_SEQ = O_SEQ + 1     "
                      . " WHERE ESTI_NO = '" .$p_esti_no . "'"
                      . " AND   O_SEQ  = '$p_o_seq'"  ;
                if ( !$db->exec($sql) ) $errors[] = xlate('Order Update failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
                $sql  = "UPDATE tbl_calko_result SET "
                      . " O_SEQ = O_SEQ - 1     "
                      . " WHERE ESTI_NO = '" .$p_esti_no . "'"
                      . " AND   SEQ  = '$p_seq'"  ;
                if ( !$db->exec($sql) ) $errors[] = xlate('Order Update failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
            } else if ( $p_mode == 'DN' && $limitOrder > $p_o_seq ) {
                $p_o_seq = $p_o_seq + 1;

                $sql  = "UPDATE tbl_calko_result SET "
                      . " O_SEQ = O_SEQ - 1     "
                      . " WHERE ESTI_NO = '" .$p_esti_no . "'"
                      . " AND   O_SEQ  = '$p_o_seq'"  ;
                if ( !$db->exec($sql) ) $errors[] = xlate('Order Update failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();

                $sql  = "UPDATE tbl_calko_result SET "
                      . " O_SEQ = O_SEQ + 1     "
                      . " WHERE ESTI_NO = '" .$p_esti_no . "'"
                      . " AND   SEQ  = '$p_seq'"  ;
                if ( !$db->exec($sql) ) $errors[] = xlate('Order Update failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
            }

            if ( empty($errors) && $db->commit() ) {
            } else {
                $errors[] = xlate('Data Not Valid!');
            }
        }
    } else {
        $errors[] = xlate('Start Transaction Error');
    }

    if ( !empty($errors) ) {
        $errors[] = xlate('Transaction Rollback.');
        $db->rollback();
    }
    echo $str;
    if (!empty($errors)) print ('ERROR|'   . $p_esti_no . '|' . ($p_seq) . '|' . implode($errors, "<BR>"));
    else                 print ('SUCCESS|' . $p_esti_no . '|' . ($p_seq) . '|' . '');

    $db->release();
} // end if [op=="change_seq"]
} // end grant
} // end login
?>