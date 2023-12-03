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
if ( strpos(strtoupper($_ENV['TERM']), 'XTERM') === false ) {
    //echo 'window';
    require_once 'C:/WEB_APP/doc/inc/calko.lib'   ; // calko.lib
} else {
    //echo 'unix';
    require_once '/usr/local/apache/htdocs/inc/calko.lib'   ; // calko.lib
}
//print phpinfo();
//print $_SERVER['HTTP_USER_AGENT'];
if (
    ( strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), 'WGET' ) === false )
&& false
) {
    header("HTTP/4.0 404 Not Found");
//    print $_SERVER[HTTP_USER_AGENT];
} else {
//echo var_dump($argv) . "\n";
$p_esti_no  = $argv[1]?$argv[1]:str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no
$p_seq      = $argv[2]?$argv[2]:(int) $_GET["p_seq"]                          ; // p_seq

if ( $p_esti_no ) {

if ( SERVER_GUBUN == '1' ) {
    define ("HOME_DIR" , 'C:/WEB_APP/doc/' );
    define ('SERVICE'  , 'CALKO' );
    define ('BASE_DIR' , '..' );
    define ('SERVICE_DIR', 'C:/WEB_APP/doc/service');
} else {
    define ("HOME_DIR" , '/usr/local/apache/htdocs' );
    define ('SERVICE'  , 'CALKO' );
    define ('BASE_DIR' , '..' );
    define ('SERVICE_DIR', '/usr/local/apache/htdocs/service');
}

require_once SERVICE_DIR . '/common/lib/lib.inc'                      ; // standard lib
require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form

require_once SERVICE_DIR . '/common/Session.php';
$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$op = strtolower(trim($_REQUEST["op"])) ;
$op = !$op?'default':$op                ;   // Process parameter [display, save]
$db = new DB (); // db instance
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE> <?=$p_esti_no?> </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--[if IE]>
<style type="text/css">
.textOf {overflow:hidden;text-overflow:ellipsis;}
</style>
<![endif]-->
<style>
<!--
.breakBefore{page-break-before:always;}
form{display:none}
body {
    width: auto;
    border:0px;
    margin:0px;
    padding:0px;
    float: none !important;
    font-size: 2em;
}
THEAD         { display: table-header-group }

.a_tbl          { border-collapse:collapse;border:1px solid black;margin-left:0px;table-layout:fixed} /**/

.a_tbl *        { font-size:9pt;font-family:'Arial';}

.a_tbl td       { height:20px;}
.a_tbl td.L1    { color:#000000; font-weight:normal; padding-left:3px; }
.a_tbl td.D1    { color:#000000;background-color:black }

.a_tbl td.i1    { color:#000000;background-color:;font-weight:bold;padding-left:3px;}
.a_tbl td.i2    { color:#000000;background-color:;padding-left:3px;}
.a_tbl td.i3    { color:#000000;background-color:;padding-left:3px;}
.a_tbl td.i4    { color:#000000;background-color:;padding-left:3px;}
.a_tbl td.i5    { color:#000000;background-color:;padding-left:3px;}
.a_tbl td.i6    { color:#000000;background-color:;padding-left:3px;}

.a_tbl td.bs2{ border-bottom:2px solid black; }
.a_tbl td.bs { border-bottom:1px solid black; }
.a_tbl td.rs { border-right :1px solid black; }
.a_tbl td.ls { border-left  :1px solid black; }

.a_tbl td.ld { border-left  :1px dotted black;}
.a_tbl td.bd { border-bottom:1px dotted black;}
.a_tbl td.rd { border-right :1px dotted black;}

.a_tbl td span            { color:#000000;background-color:#FFFFFF;width:98%;height:20px;}
-->
</style>
</head>
<body SCROLL=yes>
<script type="text/php">
if ( isset($pdf) ) {

  $font = Font_Metrics::get_font("verdana");;
  $size = 6;
  $color = array(0,0,0);
  $text_height = Font_Metrics::get_font_height($font, $size);

  $foot = $pdf->open_object();

  $w = $pdf->get_width();
  $h = $pdf->get_height();

  // Draw a line along the bottom
  $y = $h - $text_height - 24;
  //$pdf->line(16, $y, $w - 16, $y, $color, 0.5);

  $pdf->close_object();
  $pdf->add_object($foot, "all");

  $text = "Page {PAGE_NUM} of {PAGE_COUNT}";

  // Center the text
  $width = Font_Metrics::get_text_width("Page 1 of 2", $font, $size);
  $pdf->page_text($w / 2 - $width / 2, $y, $text, $font, $size, $color);
}

</script>
<TABLE id=print_main style='width:100%'>
<thead>
    <TR>
    <TD>
<span style='font-weight:bold;font-size:14pt;padding:10px'>Technical Specification of ThyssenKrupp Elevator (Korea) ltd.</span>
<img src='../img/thyssenkrpp_logo.jpg' align=absmiddle>
    </TD>
    </TR>
</thead>

<tbody>
<?
    $db->getConnect();

    $mSql = "SELECT \n"
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
         . "  b.PRE_CRC_CODE             PRE_CRC_CODE          , \n"
         . "  b.QTY                      QTY                   , \n"
         . "  b.OPT_AMT                  OPT_AMT               , \n"
         . "  b.TP_AMT                   TP_AMT                , \n"
         . "  b.SAVE_XML_DATA            SAVE_XML_DATA         , \n"
         . "  b.CRC_XML_DATA             CRC_XML_DATA          , \n"
         . "  b.MARGIN_RATE              MARGIN_RATE           , \n"
         . "  b.MARKUP_RATE              MARKUP_RATE           , \n"
         . "  b.SGNA_RATE                SGNA_RATE             , \n"
         . "  b.EXCHANGE_RATE            EXCHANGE_RATE         , \n"

         . "  b.STATE                    STATE                   \n"
         . " FROM tbl_calko_header a, tbl_calko_result b \n"
         . " WHERE a.ESTI_NO    = b.ESTI_NO\n"
       //. " AND " . ( $memInfor['user_level'] >= 2 ?" a.REG_USER_ID <> ''":" a.REG_USER_ID= '" . $memInfor[user_no] . "'\n" )
         . " AND   a.ESTI_NO    = '{$p_esti_no}'\n"
         . ($p_seq?" AND   b.SEQ        = '{$p_seq}'\n":'')
    ;
    //echo 'sql :' . $mSql . '<BR>';
    //var_dump($db);
    $mStmt = $db->multiRowSQLQuery($mSql);
    //$mR = $db->get($mSql);
    $idx = 0;
    while ($mR = $db->multiRowFetch($mStmt)) {
        $idx++;
        $esti_no                = $mR->ESTI_NO               ;
        $seq                    = $mR->SEQ                   ;
        $quotation_date         = $mR->QUOTATION_DATE        ;
        $expected_delivery_date = $mR->EXPECTED_DELIVERY_DATE;
        $sales_in_charge        = $mR->SALES_IN_CHARGE       ;
        $name_of_client         = $mR->NAME_OF_CLIENT        ;
        $project_name           = $mR->PROJECT_NAME          ;
        $country_code           = $mR->COUNTRY_CODE          ;
        $destination            = $mR->DESTINATION           ;
        $sold_to_party          = $mR->SOLD_TO_PARTY         ;
        $reg_date               = $mR->REG_DATE              ;
        $reg_user_id            = $mR->REG_USER_ID           ;
        $reg_user_email         = $mR->REG_USER_EMAIL        ;
        $class_name             = $mR->CLASS_NAME            ;
        $seq                    = $mR->SEQ                   ;
        $pre_crc_code           = $mR->PRE_CRC_CODE          ;
        $total_unit             = $mR->QTY                   ;
        $opt_amt                = $mR->OPT_AMT               ;
        $tp_amt                 = $mR->TP_AMT                ;
        $crc_xml_data           = $mR->CRC_XML_DATA          ;
        $save_xml_data          = $mR->SAVE_XML_DATA         ;
        $margin_rate            = $mR->MARGIN_RATE            ;
        $markup_rate            = $mR->MARKUP_RATE            ;
        $sgna_rate              = $mR->SGNA_RATE              ;
        $exchange_rate          = $mR->EXCHANGE_RATE          ;
        $state                  = $mR->STATE                 ;

        require_once HOME_DIR . '/inc/calko_array.lib'   ; // calko_array.lib
        $control_systemgory  = array();
        //echo 'control_system : ' . getXValue('control_system',$x);
        //if      ( $class_name == 'OS_ELEXESS_P17_BL' ) $control_systemgory['1'] = 'AC-VVVF/Geared'   ;
        //else if ( $class_name == 'OS_ELEXESS_P20_OV' ) $control_systemgory['1'] = 'AC-VVVF/Geared'   ;
        //else if ( $class_name == 'OS_ELEJET_S'       ) $control_systemgory['1'] = 'AC-VVVF/Gearless' ;
        //else if ( $class_name == 'OS_ELEJET_II'      ) $control_systemgory['1'] = 'AC-VVVF/Gearless' ;
        //else if ( $class_name == 'OS_EVOLUTION_II'   ) $control_systemgory['1'] = 'AC-VVVF/MRL'      ;
        //else if ( $class_name == 'OS_SYNERGY_S'      ) $control_systemgory['1'] = 'AC-VVVF/MRL'      ;

        $xml = simplexml_load_string('<xml>'.$crc_xml_data.'</xml>');
        $esti_no = '';
        $seq     = '';
        $tmpStr  = '';
        //echo '길이 :' . sizeof($xml->ZKSSD0002N) . '<BR>';
        $success = TRUE;
        $json = (object)array();
        $crc_code = '';
        $iIdx = 0;
        $tmpStr = array ();

        foreach( $xml->ZKSSD0002N as $x ) {
            if ( $tmpStr && $crc_code != $x->ATNAM ) {
                //echo '탙다.';
                $json->$crc_code = $tmpStr;
                $tmpStr = array ();
                $iIdx = 0;
            }
            //echo 'x->ATNAM :' . $x->ATNAM . '<BR>';
            if ( $crc_code != $x->ATNAM ) {
               // $tmpStr = $x->ATNAM . ':[';
            }

            $esti_no = $x->BSTKD;
            $seq     = $x->BSTZD;
            $crc_code= $x->ATNAM; // crc code
            $t = new crcItem();

            $t->ATWTB = $x->ATWTB;
            $t->ATWRT = $x->ATWRT;
            $t->ATSTD = $x->ATSTD;
            $t->ATBEZ = $x->ATBEZ;
            $tmpStr[] = $t;

            $iIdx++;
        }
        if ( $tmpStr ) {
            $json->$crc_code = $tmpStr;
        }
        //var_dump(  $json->DTA5007[0] );
        //var_dump(  $json->{'DTA5007'}[0] );

        $x = simplexml_load_string('<xml>'.$save_xml_data.'</xml>');
        //echo '<textarea>' . ($save_xml_data) . '</textarea>';
        //var_dump( getJValue($json->{$pre_crc_code . '5007'},getXValue('E5007',$x)));
        //echo '<textarea>' . (var_dump($json)) . '</textarea>';
?>

<tr id="page<?print $idx?>1">
<td>
<div class='<?=($idx>1?"breakBefore":"")?>'>
    <table width="100%" cellspacing="0" cellpadding="0" class="a_tbl" id='tbl1' style='padding:0px;margin:0px' align=left>
        <colgroup>
            <col width='14%'/>
            <col width='24%'/>
            <col width='9%'/>
            <col width='25%'/>
            <col width='15%'/>
            <col width='13%'/>
        </colgroup>

        <tr><td class='i1 bs' >Sales in Charge           </td><td class='i2 ld rs bs'  colspan=2><?print $sales_in_charge?></td><td class='i4 rd bs' style='font-weight:bold'>Name of Client   </td><td class='i5 bs' colspan=2><?print $name_of_client?></td></tr>
        <tr><td class='i1 bs' >Project Name              </td><td class='i2 ld rs bs'  colspan=2><?print $project_name?></td><td class='i4 rd bs'   style='font-weight:bold'>APPLIED CODE     </td><td class='i5 bs' colspan=2><span id=E5007 ><?$E5007=getXValue('E5007',$x);print getJValue($json->{$pre_crc_code . '5007'},$E5007)?></span> </td></tr>
        <tr><td class='i1 bs2'>Country                   </td><td class='i2 ld rs bs2' colspan=2><?
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
$creategory_setup['script'          ] = " id=country_code value='" . $country_code . "' disabled "  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$country_codegory['setup'] = $creategory_setup;
//print createGory ('SELECT', $country_codegory);
print $country_codegory[$country_code];

//print listbox("country_code",$country_codegory, " id=country_code value='" . $country_code . "' disabled", $country_code);
?>

        </td><td class='i4 rd bs2' style='font-weight:bold'>Destination:      </td><td class='i5 bs2' colspan=2><?print $destination?></td></tr>

        <tr>
        <td class='i1 bs2'>1. Lift Nos</td>
        <td class='i2 ld bs2' ><?print getXValue('lift_nos',$x)?>&nbsp;</td>
        <td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2' style='font-size:8pt;font-weight:bold;background-color:#E7E7E7'>Quotation Price(FOB BUSAN)</td>
<?
//echo '$exchange_rate : ' . $exchange_rate;
$amount = ( $exchange_rate?(($tp_amt*TP_MULTIPLE) / $exchange_rate) + ($opt_amt / $exchange_rate ):0);
//echo '$amount : ' . $amount;
$amount = $amount * (1+($margin_rate/100)) / 0.9;
?>
        <td class='i5 bs2' style='background-color:#E7E7E7'><B style='font-size:10pt;font-weight:bold;color:#990000;'>$<?print (number_format(round($amount,0)))?></B></td>
        <td class='i6 ld bs2'>&nbsp;</td>
        </tr>

        <tr>
        <td class='i1 bs2'>2. Building Type</td>
        <td class='i2 ld bs2' ><?print $building_typegory[getXValue('building_type',$x)]?></td>
        <td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2' style='font-weight:bold'>DATE</td>
        <td class='i5 bs2'><?print $quotation_date?></td>
        <td class='i6 ld bs2'>&nbsp;</td>
        </tr>

        <tr><td class='i1'    >3. General Data  </td><td class='i2 ld bd' >Specification    </td><td class='i3 ld rs bd'>&nbsp;</td><td class='i4 rd bd'><?print getXValue('specification',$x)?></td><td class='i5 bd'><span id=E5000 ><?print getJValue($json->{$pre_crc_code . '5000'},getXValue('E5000',$x))?></span></td><td class='i6 ld bd'>&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Total Unit(s)    </td><td class='i3 ld rs bd'>&nbsp;</td><td class='i4 rd bd'><?print $total_unit?></td><td class='i5 bd'>&nbsp;                                     </td><td class='i6 ld bd'>&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Use              </td><td class='i3 ld rs bd'>&nbsp;</td><td class='i4 rd bd'><?print getXValue('use',$x)?></td><td class='i5 bd'>&nbsp;                                     </td><td class='i6 ld bd'>&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd rs' colspan=2>Code of fireman lift if appicable</td>
        <td class='i4 rd bd' ><?print $code_of_fireman_liftgory[getXValue('code_of_fireman_lift',$x)]?>

        </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Capacity                         </td><td class='i3 ld rs bd' >[kg]   </td><td class='i4 rd bd' ><?print getJValue($json->{$pre_crc_code . '5005'},getXValue('E5005',$x))?></span> </td><td class='i5 bd' ><?print getXValue('passengers',$x)?></td><td class='i6 ld bd' >Passengers</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Speed / Velocity                 </td><td class='i3 ld rs bd' >[m/min]</td><td class='i4 rd bd' ><span id=E5006 ><?print getJValue($json->{$pre_crc_code . '5006'},getXValue('E5006',$x))?></span> </td><td class='i5 bd' ><?print getXValue('velocity',$x)?></td><td class='i6 ld bd' >m/s</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Type of Openings                 </td><td class='i3 ld rs bd' >&nbsp; </td><td class='i4 rd bd' ><span id=E5020 ><?print getJValue($json->{$pre_crc_code . '5020'},getXValue('E5020',$x))?></span> </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Fire resistance application      </td><td class='i3 ld rs bd' >&nbsp; </td><td class='i4 rd bd' ><?print $fire_resistance_applicationgory[getXValue('fire_resistance_application',$x)]?>
        </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Openings / Floors                </td><td class='i3 ld rs bd' >&nbsp; </td><td class='i4 rd bd' ><span id=E5009 ><?print getXValue('E5009',$x)?></span>                     </td><td class='i5 bd' ><span id=E5008 ><?print  getXValue('E5008',$x)?></span></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Control System                   </td><td class='i3 ld rs bd' >&nbsp; </td>
        <td class='i4 rd bd' ><?print $control_systemgory[getXValue('control_system',$x)]?>
        </td>
        <td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Operation                        </td><td class='i3 ld rs bd' >&nbsp; </td><td class='i4 rd bd' ><span id=E5015 ><?print getJValue($json->{$pre_crc_code . '5015'},getXValue('E5015',$x))?></span>                     </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Travel                           </td><td class='i3 ld rs bd' >[mm]   </td><td class='i4 rd bd' ><span id=E5012 ><?print getXValue('E5012',$x)?></span>                     </td><td class='i5 bd' >&nbsp;                </td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' >Overhead                         </td><td class='i3 ld rs bd' >[mm]   </td><td class='i4 rd bd' ><span id=E5010 ><?print getXValue('E5010',$x)?></span>                     </td><td class='i5 bd' >&nbsp;<!-- car height 2300, if less - reduce DTA5010 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;           </td><td class='i2 ld bs2'>Pit                              </td><td class='i3 ld rs bs2'>[mm]   </td><td class='i4 rd bs2'><span id=E5011 ><?print getXValue('E5011',$x)?></span>                     </td><td class='i5 bs2'>&nbsp;                </td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >4. Other Data    </td><td class='i2 ld bd'           >Hoistway width                        </td><td class='i3 ld rs bd' >[mm]     </td><td class='i4 rd bd' ><?print getXValue('hoistway_width',$x)?></td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'           >Hoistway depth                        </td><td class='i3 ld rs bd' >[mm]     </td><td class='i4 rd bd' ><?print getXValue('hoistway_depth',$x)?></td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'           >Machine Room Location                 </td><td class='i3 ld rs bd' >&nbsp;   </td><td class='i4 rd bd' ><B>Directly above the shaft</B>            </td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'           >MR Width x Depth x Height             </td><td class='i3 ld rs bd' >[mm]     </td><td class='i4 rd bd' ><?print getXValue('mr_width',$x)?>&nbsp;</td><td class='i5 bd' ><?print getXValue('mr_depth',$x)?>&nbsp;</td><td class='i6 ld bd' ><?print getXValue('mr_height',$x)?>&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'  rowspan=2>Power Supply                          </td><td class='i3 ld rs bd' >Main     </td><td class='i4 rd bd' ><span id=E5133 ><?print getJValue($json->{$pre_crc_code . '5133'},getXValue('E5133',$x))?></span>                             </td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                                           <td class='i3 ld rs bd' >Lighting </td><td class='i4 rd bd' ><span id=E5147 ><?print getJValue($json->{$pre_crc_code . '5147'},getXValue('E5147',$x))?></span>                             </td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'           >Buffer                                </td><td class='i3 ld rs bd' >&nbsp;   </td><td class='i4 rd bd' ><?print getXValue('buffer',$x)?></td><td class='i5 bd' >&nbsp;                                                                                           </td><td class='i6 ld bd' >&nbsp;                </td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 bs2 ld' rowspan=2>Guide Rail                            </td><td class='i3 ld rs bd' >Car Side </td><td class='i4 rd bd' >T-Guide rail                                       </td><td class='i5 bd' ><?print "pitch=" . getXValue('car_side',$x) . "mm"?></td><td class='i6 ld bd' ><span id=E5095 ><?print getJValue($json->{$pre_crc_code . '5095'},getXValue('E5095',$x))?></span></td></tr>
        <tr><td class='i1 bs2'>&nbsp;           </td>                                                                           <td class='i3 ld rs bs2'>CWT Side </td><td class='i4 rd bs2'>T-Guide rail                                       </td><td class='i5 bs2'><?print "pitch=" . getXValue('cwt_side',$x) . "mm"?></td><td class='i6 ld bs2'><span id=E5101 ><?print getJValue($json->{$pre_crc_code . '5101'},getXValue('E5101',$x))?></span></td></tr>

        <tr><td class='i1'    >5 Standard       </td><td class='i2 ld bd' rowspan=3>Higher Efficiency </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Nuisance Call Cancellation                                   </B></td></tr>
        <tr><td class='i1'    >Features         </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Arrival Car Chime                                            </B></td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Automatic Cut-off of Lighting and Ventilation during Stand-by</B></td></tr>
        <tr><td class='i1'    >&nbsp;           </td><td class='i2 bs2 ld' rowspan=7>Increased Safety </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Automatic Landing Function at the nearest floor              </B></td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Communication System : Intercom - 3 points                   </B></td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Door Nudging                                                 </B></td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Door Repetitive Reversal                                     </B></td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Emergency Light in the event of System Failure               </B></td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                      <td class='i3 ld rs bd' >&nbsp;</td><td class='i4 bd'  colspan=3><B>Inspection Operation (at Car Top)                            </B></td></tr>
        <tr><td class='i1 bs2'>&nbsp;           </td>                                                      <td class='i3 ld rs bs2'>&nbsp;</td><td class='i4 bs2' colspan=3><B>Overload Detector                                            </B></td></tr>

        <tr>
        <td class='i1'    >6 Car            </td>
        <td class='i2 ld bd'>Cage Panel / Car Wall</td>
        <td class='i3 ld rs bd'>&nbsp;</td>
        <td class='i4 rd bd'><?print $cage_panel_n_wallgory[getXValue('cage_panel_n_wall',$x)]?>
        </td>
        <td class='i5 bd'>&nbsp;</td>
        <td class='i6 ld bd'>&nbsp;</td>
        </tr>

        <tr>
        <td class='i1'    >Specifications</td>
        <td class='i2 ld bd'>Car Door</td>
        <td class='i3 ld rs bd'>&nbsp;</td>
        <td class='i4 rd bd'><?print $car_doorgory[getXValue('car_door',$x)]?></td>
        <td class='i5 bd'>&nbsp;</td>
        <td class='i6 ld bd'>&nbsp;</td>
        </tr>

        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Car width           </td><td class='i3 ld rs bd' >[mm]  </td><td class='i4 rd bd' ><?print getXValue('car_width',$x)?></td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Car depth           </td><td class='i3 ld rs bd' >[mm]  </td><td class='i4 rd bd' ><?print getXValue('car_depth',$x)?></td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td>
        <td class='i2 ld bd' >Car height          </td><td class='i3 ld rs bd' >[mm]  </td>
        <td class='i4 rd bd' ><?print number_format(getXValue('car_height',$x))?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Open through car    </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><?print getXValue('open_through_car',$x)?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Entrance Door width </td><td class='i3 ld rs bd' >[mm]  </td>
        <td class='i4 rd bd' ><?print number_format(getXValue('entrance_door_width',$x))?>
        </td>
        <td class='i5 bd'>&nbsp;</td>
        <td class='i6 ld bd'>&nbsp;</td>
        </tr>

        <tr><td class='i1 bs2'>&nbsp;</td><td class='i2 ld bs2'>Entrance Door height</td><td class='i3 ld rs bs2'>[mm]  </td>
        <td class='i4 rd bs2'><?print number_format(getXValue('entrance_door_height',$x))?>
        </td>
        <td class='i5 bs2'>&nbsp;</td>
        <td class='i6 ld bs2'>&nbsp;</td>
        </tr>
    </table>
</div>
</td>
</tr>

<tr id="page<?print $idx?>2">
<td>
<div class='breakBefore'>
<!-- <span id="title_page<?print $idx?>2"> page<?print $idx?>1</span> -->
    <table width="100%" cellspacing="0" cellpadding="0" class="a_tbl" id='tbl2' style='padding:0px;margin:0px' align=left>
        <colgroup>
            <col width='14%'/>
            <col width='24%'/>
            <col width='9%'/>
            <col width='25%'/>
            <col width='15%'/>
            <col width='13%'/>
        </colgroup>

        <tr><td class='i1'    >6. Car               </td><td class='i2 ld rs bd' colspan=2>Kick Plate (Skirting Board)</td><td class='i4 bd' colspan=3>TKEK Standard (No Kick Plate in front panel upto 1000kg)</td></tr>
        <tr><td class='i1'    >     Specifications  </td><td class='i2 ld bd' >Floor                      </td><td class='i3 ld rs bd'>&nbsp;</td>
        <td class='i4 bd' colspan=2><?print $specifications_floorgory[getXValue('specifications_floor',$x)]?></td>
        <td class='i6 ld bd'>&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >Hand Rail                    </td><td class='i3 ld rs bd' >&nbsp;      </td><td class='i4 rd bd' ><span id=E5046 ><?print getJValue($json->{$pre_crc_code . '5046'},getXValue('E5046',$x))?></span></td><td class='i5 bd' ><span id=E5047 ><?print getJValue($json->{$pre_crc_code . '5047'},getXValue('E5047',$x))?></span></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' rowspan=3>Ceiling             </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5050 ><?print getJValue($json->{$pre_crc_code . '5050'},getXValue('E5050',$x))?></span></td>
        <td class='i5 bd' colspan=2><?print $ceiling_typegory[getXValue('ceiling_type',$x)]?></td>
        </tr>

        <tr><td class='i1'    >&nbsp;</td>                                                        <td class='i3 ld rs bd' > Ventilation</td><td class='i4 rd bd' >Sirocco Fan (TKEK Standard)                 </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td>                                                        <td class='i3 ld rs bd' > Lighting   </td><td class='i4 rd bd' >Fluorescent Lamp                            </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' rowspan=2>COP                 </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5055 ><?print getJValue($json->{$pre_crc_code . '5055'},getXValue('E5055',$x))?></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td>                                                        <td class='i3 ld rs bd' > Finish     </td><td class='i4 rd bd' ><span id=E5061 ><?print getJValue($json->{$pre_crc_code . '5061'},getXValue('E5061',$x))?></span>                      </td><td class='i5 bd' >&nbsp;<!-- 1,2항목만 보임 --></td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld rs bd' colspan=2>Prority card key in the COP  </td><td class='i4 rd bd' ><span id=E5066 ><?print getJValue($json->{$pre_crc_code . '5066'},getXValue('E5066',$x))?></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >COP for Disabled             </td><td class='i3 ld rs bd' >&nbsp;      </td><td class='i4 rd bd' ><span id=E5063 ><?print getJValue($json->{$pre_crc_code . '5063'},getXValue('E5063',$x))?></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;</td><td class='i2 ld bd' >CPI                          </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5067 ><?print getJValue($json->{$pre_crc_code . '5067'},getXValue('E5067',$x))?></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;</td><td class='i2 bs2 ld'>Mirror in the car            </td><td class='i3 ld rs bs2'>&nbsp;      </td><td class='i4 rd bs2'><span id=E5049 ><?print getJValue($json->{$pre_crc_code . '5049'},getXValue('E5049',$x))?></span>                      </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >7. Landing / Hall</td><td class='i2 ld bd' rowspan=2>Door                       </td><td class='i3 ld rs bd' > Ground     </td>
        <td class='i4 rd bd' ><?print $door_groundgory[getXValue('door_ground',$x)]?>
        </td>
        <td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >   Specifications</td>                                                               <td class='i3 ld rs bd' > Typical    </td>
        <td class='i4 rd bd' ><?print $door_groundgory[getXValue('door_typical',$x)]?>
        </td>
        <td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' rowspan=2>Jamb                       </td><td class='i3 ld rs bd' > Ground     </td>
        <td class='i4 rd bd' ><?print $jamb_groundgory[getXValue('jamb_ground',$x)]?>
        </td>
        <td class='i5 bd' >&nbsp;</td>
        <td class='i6 ld bd' ><?print $jamb_ground_optiongory[getXValue('jamb_ground_option',$x)]?>
        </td></tr>

        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > Typical    </td>
        <td class='i4 rd bd' ><?print $jamb_typicalgory[getXValue('jamb_typical',$x)]?>
        </td>
        <td class='i5 bd' >&nbsp;</td>
        <td class='i6 ld bd' ><?print $jamb_typical_optiongory[getXValue('jamb_typical_option',$x)]?>
        </td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' rowspan=2>Transom                    </td><td class='i3 ld rs bd' > Ground     </td>
        <td class='i4 rd bd' ><?print $transom_groundgory[getXValue('transom_ground',$x)]?>
        </td>
        <td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > Typical    </td>
        <td class='i4 rd bd' ><?print $transom_typicalgory[getXValue('transom_typical',$x)]?>
        </td>
        <td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' rowspan=2>Hall Button (Main floor)   </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5072_CLONE><?print getJValue($json->{$pre_crc_code . '5072'},getXValue('E5072_CLONE',$x))?></span></td><td class='i5 bd' >&nbsp;<!-- 로직 안걸고 화면만 보인다(선택가능) --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > Finish     </td>
        <td class='i4 rd bd'  ><?print getXValue('hall_button_main_floor',$x)?>
        </td>
        <td class='i5 bd' >&nbsp;<!-- 로직 안걸고 화면만 보인다(선택가능) --></td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd' rowspan=3>Hall Button (Other floor) </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5072 ><?print getJValue($json->{$pre_crc_code . '5072'},getXValue('E5072',$x))?></span></td><td class='i5 bd' >&nbsp;<!-- 삭제항목2,5,8,12,17,19,22,25 안보임 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > Finish     </td><td class='i4 rd bd' ><span id=E5075 ><?print getJValue($json->{$pre_crc_code . '5075'},getXValue('E5075',$x))?></span></td><td class='i5 bd' >&nbsp;<!-- 1,2항목만 보임 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;           </td>                                                               <td class='i3 ld rs bd' > BUTTON     </td><td class='i4 rd bd' ><?print $cop_buttongory[getXValue('cop_button',$x)]?>                                       </td><td class='i5 bd' >&nbsp;<!-- E61 COPY 수정불가 --></td><td class='i6 ld bd' >&nbsp;</td></tr>

        <tr><td class='i1'    >&nbsp;           </td><td class='i2 ld bd'          >HPI                        </td><td class='i3 ld rs bd' > Type       </td><td class='i4 rd bd' ><span id=E5071 ><?print getJValue($json->{$pre_crc_code . '5071'},getXValue('E5071',$x))?></span></td><td class='i5 bd' >&nbsp;<!-- 홀수 인수만 적용(1,3,5,7,9…) --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;           </td><td class='i2 bs2 ld'         >Hall Lanterns              </td><td class='i3 ld rs bs2'>&nbsp;      </td><td class='i4 rd bs2'><span id=E5082 ><?print getJValue($json->{$pre_crc_code . '5082'},getXValue('E5082',$x))?></span></td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >8. Accessories             </td><td class='i2 bd ld' >Door protection                           </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5043 ><?print getJValue($json->{$pre_crc_code . '5043'},getXValue('E5043',$x))?></span>        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;                     </td><td class='i2 bd ld' >Voice Synthesizer                         </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5052 ><?print getJValue($json->{$pre_crc_code . '5052'},getXValue('E5052',$x))?></span>        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;                     </td><td class='i2 bd ld' >BGM Speaker                               </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5051 ><?print getJValue($json->{$pre_crc_code . '5051'},getXValue('E5051',$x))?></span>        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;                     </td><td class='i2 bd ld rs bd' colspan=2>Hall Chime (Ding Dong Sound)</td><td class='i3 rd bd' ><span id=E5016 ><?print getJValue($json->{$pre_crc_code . '5016'},getXValue('E5016',$x))?></span>        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld'>CC TV                                     </td><td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 bs2' colspan=2><?print $cc_tvgory[getXValue('cc_tv',$x)]?>
        </td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >9. Fire functions         </td><td class='i2 bd ld rs' colspan=2>Fireman Emergency Return                  </td>
        <td class='i4 rd bd' ><?print $fireman_emergency_returngory[getXValue('fireman_emergency_return',$x)]?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld rs' colspan=2>Fireman Switch Operation                  </td>
        <td class='i4 rd bs2'><span id=E5081 ><?print getJValue($json->{$pre_crc_code . '5081'},getXValue('E5081',$x))?></span>
        </td>
        <td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >10. Emergency              </td><td class='i2 bd ld rs ' colspan=2>Emergency Power Operation                 </td>
        <td class='i4 rd bd' ><?print $emergency_power_operationgory[getXValue('emergency_power_operation',$x)]?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >    functions              </td><td class='i2 bd ld' >Automatic Rescue Device                   </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5113 ><?print getJValue($json->{$pre_crc_code . '5113'},getXValue('E5113',$x))?></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld rs' colspan=2>Earthquake/Seismic Operation    </td><td class='i4 rd bs2'><span id=E5109 ><?print getJValue($json->{$pre_crc_code . '5109'},getXValue('E5109',$x))?></span>                      </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1 bs2'>11. Supervision              </td><td class='i2 bs2 ld rs' colspan=2>Supervisory panel for the project</td><td class='i4 bs2' colspan=2><span id=E5122 ><?print getJValue($json->{$pre_crc_code . '5122'},getXValue('E5122',$x))?></span>                      </td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >12. Control                </td><td class='i2 bd ld' >Homing (home landing)                     </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5144 ><?print getJValue($json->{$pre_crc_code . '5144'},getXValue('E5144',$x))?></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >    function               </td><td class='i2 bd ld' >By-Pass operation                         </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><?print $by_pass_operationgory[getXValue('by_pass_operation',$x)]?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;                     </td><td class='i2 bd ld' >Night time operation                      </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><?print $night_time_operationgory[getXValue('night_time_operation',$x)]?>
        </td><td class='i5 bd' >&nbsp; <!-- 로직 구성 없음(화면만) 적용Price 해영 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld rs' colspan=2>Isolated simplex operation from the group </td>
        <td class='i4 rd bs2'><?print $isolated_simplex_operationgory[getXValue('isolated_simplex_operation',$x)]?>
        </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >13. Special requests       </td><td class='i2 bd ld' >SABBATH                                   </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5130 ><?print getJValue($json->{$pre_crc_code . '5130'},getXValue('E5130',$x))?></span>                      </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1 bs2'>functions                  </td><td class='i2 bs2 ld'>Counter Weight Safety                     </td><td class='i3 ld rs bs2'>&nbsp;</td>
        <td class='i4 rd bs2'><?print $counter_weight_safetygory[getXValue('counter_weight_safety',$x)]?>
        </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>

        <tr><td class='i1'    >OTHERS                     </td><td class='i2 bd ld' >Rope brake (Gripper)                      </td><td class='i3 ld rs bd' >&nbsp;</td><td class='i4 rd bd' ><span id=E5017 ><?print getJValue($json->{$pre_crc_code . '5017'},getXValue('E5017',$x))?></span>                     </td><td class='i5 bd' >&nbsp;<!-- CSA 인증제품 적용1,(2),5만 표시 --></td><td class='i6 ld bd' >&nbsp;</td></tr>
        <tr><td class='i1'    >&nbsp;                     </td><td class='i2 bd ld' >BMS Interface                             </td><td class='i3 ld rs bd' >&nbsp;</td>
        <td class='i4 rd bd' ><?print $bms_interfacegory[getXValue('bms_interface',$x)]?>
        </td><td class='i5 bd' >&nbsp;</td><td class='i6 ld bd' >&nbsp;</td></tr>
<?
    if ( $E5007>=3 ) {
?>
        <tr><td class='i1 bs2'>&nbsp;                     </td><td class='i2 bs2 ld rs' colspan=2>Spare parts set for 2 years</td>
        <td class='i4 rd bs2'><?print $spare_parts_setgory[getXValue('spare_parts_set',$x)]?>
        </td><td class='i5 bs2'>&nbsp;</td><td class='i6 ld bs2'>&nbsp;</td></tr>
<?
    }
?>
    </table>
</div>
</td>
</tr>
<?php
    }
?>
</tbody>
</TABLE>
</body>
</html>
<?
    $db->release();
} // $p_esti_no
}
?>