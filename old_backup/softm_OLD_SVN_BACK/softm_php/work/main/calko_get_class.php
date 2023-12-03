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

require_once SERVICE_DIR . '/common/lib/lib.inc'                      ; // standard lib
require_once SERVICE_DIR . '/common/lib/DB.php'                       ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'  ; // 필터
require_once SERVICE_DIR . '/common/lib/form.inc'                     ; // form
require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // pageTab

require_once SERVICE_DIR . '/common/Session.php';
$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$op = strtolower(trim($_REQUEST["op"])) ;
$op = !$op?'default':$op                ;   // Process parameter [display, save]
$db = new DB (); // db instance

if ( $memInfor['login_yn'] != 'Y' ) {
    redirectPage( "/" );
} else {
if ( $op == 'default' ) {
    require_once '../inc/inner_header.php'   ; // header
?>
<!--[if IE]>
<style type="text/css">
.textOf {overflow:hidden;text-overflow:ellipsis;}
</style>
<![endif]-->
<SCRIPT LANGUAGE="JavaScript">
<!--
    var _s  =  1 ; // pagetab Number
    var m   = 'S';
    var pm  = '' ;
    var _rI = null;
    var _pRowIndex = -1;
    var _url = '<?print $_SERVER['PHP_SELF']?>';

    function fGetList(s) {
        pm = m;
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = _url;
        ajaxR.openCallBack= function (str) {
            ajaxR.dataArea.innerHTML = ajaxR.responseText();
            loading.hide();
            //_rI = null;
            $('area_list' ).style.display = 'inline' ;
            $('area_write').style.display = 'none'   ;
        }
        ajaxR.form = $('sForm');
        var params = 'op=search'
                   + '&s=' + (s?s:1)
                   + '&' + ajaxR.getQueryString();
        //alert( params );
        ajaxR.httpOpen('POST', url, true,params, $("area_list"));
        m = 'S';
        _s = s;
        loading.show();
        return false;
    }

    function fReturn(o) {
        var rI = o.parentNode.rows[o.rowIndex-1];
        var rtn = o.cells[0].innerText;
        //alert(rtn + ' / ' + window.opener );
        if (window.opener.fSetClassName) window.opener.fSetClassName(rtn);
        self.close();
        return rtn;
    }
    window.onload = function () { fGetList(1);}
//-->
</SCRIPT>
<STYLE type=text/css>
    .line_st { border-top   :1px solid #999999; }
    .line_sr { border-right :1px solid #999999; }
    .line_sl { border-left  :1px solid #999999; }
    .line_sb { border-bottom:1px solid #999999; }

    .line_dt { border-top   :1px dotted #999999;}
    .line_dr { border-right :1px dotted #999999;}
    .line_dl { border-left  :1px dotted #999999;}
    .line_db { border-bottom:1px dotted #999999;}

    /* list table */
    .tbl          { border:0px solid gray;width:600px;margin:10px 0px 10px 10px;padding:1px 1px 1px 1px }
    .tbl *        { font-size:8pt;font-family:'Arial';}

    .tbl td       { height:20px;padding-left:3px;}
    .tbl td.L1    { color:#000000; font-weight:bold; padding-left:3px; }
    .tbl td.D1    { color:#000000; }

    .tbl td input     { color:#000000;background-color:#FFFFFF;width:94%;height:13px;border:0;}
    .tbl td select    { color:#000000;background-color:#FFFFFF;width:98%;height:20px }

    .tbl th { border-bottom:1px solid #999999;border-left:1px solid #999999;border-top:1px solid #999999;text-align:center;padding-left:3px;
              height:23px;}
    .tbl td { border-bottom:1px solid #999999;border-left:1px solid #999999; cursor:pointer;}

    .tbl .even_row td {background-color: #c0c0c0    } /* 짝수 */
    .tbl .odd_row  td {background-color: transparent} /* 홀수 */
</STYLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="100%" valign="top">
<form id=sForm method="POST" target="" onsubmit="return fGetList(1);">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='80'/>
            <col width='100'/>
            <col width='40'/>
            <col width='80'/>
            <col width=''/>
        </colgroup>
        <thead>
            <tr><th colspan="5"><?php print html_xlate("Select"); ?></th></tr>
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
<SCRIPT LANGUAGE="JavaScript">
<!--
var loading = new loadingDisplay('./lib_inc/js/ajax-loader.gif','image');
loading.setTarget(document.body);
loading.setSize ('80px','10px');
//loading.show();
//-->
</SCRIPT>
<?
    require("../inc/footer.php"); // footer
} // end if [op=="default"]
else if ( $op == "search") { // 조회
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class=tbl id='tbl_list'>
    <colgroup>
        <col width='20%'/>
        <col width='10%'/>
        <col width='10%'/>
        <col width='20%'/>
        <col width='10%'/>
        <col width='10%'/>
    </colgroup>
    <thead>
    <tr>
    <th style='border-left :0;' colspan=6><?php print xlate("Elevetor Class Name")?></th>
    </tr>

    <tr>
    <th style='border-left :0;' rowspan=2><?php print xlate("Class Name")?></th>
    <th colspan=5><?php print xlate("Class Options")?></th>
    </tr>
    <tr>
    <th><?php print xlate("Model Type")?></th>
    <th><?php print xlate("Passenger")?></th>
    <th><?php print xlate("Velocity")?></th>
    <th><?php print xlate("Use")?></th>
    <th><?php print xlate("Class")?></th>
    </tr>
    </thead>
    <tbody>

<?php
    $db->getConnect();
    $cur_many = 0;

    //$keyword = $db->quote("%" . implode("%", split(" +", $_REQUEST["keyword"])) . "%");
    //$where = ($_REQUEST["keyword"]?" WHERE f1 LIKE {$keyword} \n":'');\
  //$tot = $db->get("SELECT COUNT(*) AS cnt FROM " . MY_TABLE . $where)->cnt; // row count
    $tot = 6; // row count
    // pagetab
    $page_tab['js_function' ] = 'fGetList';
    $page_tab['s'        ] = !$_REQUEST[s]?1:(int)$_REQUEST[s];
    $page_tab['tot'      ] = $tot;
    $page_tab['how_many' ] = 10 ;
    $page_tab['more_many'] = 10 ;
    $page_tab['page_many'] = 10 ;
    if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    //$sRtn = $db->exec("set names utf8");
/*
ELEXESS	               OS_ELEXESS_P17_BL     P6~P17           60~105m/min               승객용      TK50G

ELEXESS_P17_BL         Elexess               P6~P17           60~105m/min               승객용      TK50G      
ELEXESS_P20_OV         Elexess               P20~P24          60~105m/min               승객용      TK50G/TK55G
ELEXESS_HS             Elexess               P13~P24          120,150m/min(High Speed)  승객용      TK50G/TK55G
ELEVIEW_TK50M          EVOLUTION II          P6~P24           60~105m/min               전망용      TK50M      
ELEVIEW_TK50M1         EVOLUTION III         P10~P17          60~105m/min               전망용      TK50M1     
ELEJET_II              ELEJET II             P13~P24          120~180m/min              승객용      TK55L      
ELEVIEW_TK50S          SYNERGY               P6~P15           60~105m/min               전망용      TK50S      
ELEJET_S               ELEJET                                                                       TK50L      
ELEVIEW_TK55G                                                                           전망용      TK55G      
SYNERGY_S              SYNERGY               P6~P15           60~105m/min               승객용      TK50S      
EVOLUTION_III          EVOLUTION III         P10~P17          60~105m/min               승객용      TK50M3     
ELEXESS_II             ELEXESS II            P6~P17           60~120m/min               승객용      TK50P      
ELEXESS_III            Elexess III           P6~P17           60~105m/min               승객용      TK50P3     
EVOLUTION_II           EVOLUTION II          P17~P24          60~105m/min               승객용      TK50M      
ELEPOTER_S             ELEPOTER                                                         화물용      TK55G      
*/
    $sql = "SELECT 'OS_ELEXESS_P17_BL'  CLASS_NAME  ,'ELEXESS'          F1, 'P6~P17'     F2, '60~105m/min'   F3, 'Passenger' F4, 'TK50G'       F5 , 1 SEQ UNION ALL \n"
         . "SELECT 'OS_ELEXESS_P20_OV'  CLASS_NAME  ,'ELEXESS'          F1, 'P20~P24'    F2, '60~105m/min'   F3, 'Passenger' F4, 'TK50G/TK55G' F5 , 2 SEQ UNION ALL \n"
         . "SELECT 'OS_ELEXESS_HS'      CLASS_NAME  ,'ELEXESS'          F1, 'P13~P24'    F2, '120~150m/min'  F3, 'Passenger' F4, 'TK50G/TK55G' F5 , 3 SEQ UNION ALL \n"
         . "SELECT 'OS_ELEJET_S'        CLASS_NAME  ,'ELEJET'           F1, 'P20~P24'    F2, '120~210m/min'  F3, 'Passenger' F4, 'TK50L'       F5 , 4 SEQ UNION ALL \n"
         . "SELECT 'OS_ELEJET_II'       CLASS_NAME  ,'ELEJET II'        F1, 'P13~P24'    F2, '120~180m/min'  F3, 'Passenger' F4, 'TK55L'       F5 , 5 SEQ UNION ALL \n"
         . "SELECT 'OS_EVOLUTION_II'    CLASS_NAME  ,'EVOLUTION II'     F1, 'P17~P24'    F2, '60~105m/min'   F3, 'Passenger' F4, 'TK50M'       F5 , 6 SEQ UNION ALL \n"
         . "SELECT 'OS_SYNERGY_S'       CLASS_NAME  ,'SYNERGY'          F1, 'P8~P15'     F2, '60~105m/min'   F3, 'Passenger' F4, 'TK50S'       F5 , 7 SEQ           \n"
    ;
/*
         . "SELECT 'ELEXESS_P17_BL'     CLASS_NAME  ,'Elexess'          F1, 'P6-P17'    F2, '60~105m/min             '  F3, '승객용' F4, 'TK50G'          F5 , 2 SEQ UNION ALL \n"
         . "SELECT 'ELEXESS_P20_OV'                 ,'Elexess      '      , 'P20~P24'     , '60~105m/min             '    , '승객용'   , 'TK50G/TK55G'       , 3     UNION ALL \n"
         . "SELECT 'ELEXESS_HS    '                 ,'Elexess      '      , 'P13~P24'     , '120,150m/min(High Speed)'    , '승객용'   , 'TK50G/TK55G'       , 4     UNION ALL \n"
         . "SELECT 'ELEVIEW_TK50M '                 ,'EVOLUTION II '      , 'P6~P24 '     , '60~105m/min             '    , '전망용'   , 'TK50M      '       , 5     UNION ALL \n"
         . "SELECT 'ELEVIEW_TK50M1'                 ,'EVOLUTION III'      , 'P10~P17'     , '60~105m/min             '    , '전망용'   , 'TK50M1     '       , 6     UNION ALL \n"
         . "SELECT 'ELEJET_II     '                 ,'ELEJET II    '      , 'P13~P24'     , '120~180m/min            '    , '승객용'   , 'TK55L      '       , 7     UNION ALL \n"
         . "SELECT 'ELEVIEW_TK50S '                 ,'SYNERGY      '      , 'P6~P15 '     , '60~105m/min             '    , '전망용'   , 'TK50S      '       , 8     UNION ALL \n"
         . "SELECT 'ELEJET_S      '                 ,'ELEJET       '      , '       '     , '                        '    , '      '   , 'TK50L      '       , 9     UNION ALL \n"
         . "SELECT 'ELEVIEW_TK55G '                 ,'             '      , '       '     , '                        '    , '전망용'   , 'TK55G      '       , 10    UNION ALL \n"
         . "SELECT 'SYNERGY_S     '                 ,'SYNERGY      '      , 'P6~P15 '     , '60~105m/min             '    , '승객용'   , 'TK50S      '       , 11    UNION ALL \n"
         . "SELECT 'EVOLUTION_III '                 ,'EVOLUTION III'      , 'P10~P17'     , '60~105m/min             '    , '승객용'   , 'TK50M3     '       , 12    UNION ALL \n"
         . "SELECT 'ELEXESS_II    '                 ,'ELEXESS II   '      , 'P6~P17 '     , '60~120m/min             '    , '승객용'   , 'TK50P      '       , 13    UNION ALL \n"
         . "SELECT 'ELEXESS_III   '                 ,'Elexess III  '      , 'P6~P17 '     , '60~105m/min             '    , '승객용'   , 'TK50P3     '       , 14    UNION ALL \n"
         . "SELECT 'EVOLUTION_II  '                 ,'EVOLUTION II '      , 'P17~P24'     , '60~105m/min             '    , '승객용'   , 'TK50M      '       , 15    UNION ALL \n"
         . "SELECT 'ELEPOTER_S    '                 ,'ELEPOTER     '      , '       '     , '                        '    , '화물용'   , 'TK55G      '       , 16        \n"
*/
//       . " FROM " . MY_TABLE . " \n"
//         . $where

    $sql = " SELECT \n"
         . " CLASS_NAME,\n"
         . " MODEL_TYPE,\n"
         . " PASSENGER ,\n"
         . " VELOCITY  ,\n"
         . " USE_TYPE  ,\n"
         . " CLASS     ,\n"
         . " SEQ       ,\n"
         . " USE_YN     \n"
         . " FROM tbl_calko_class_name\n"
         . " WHERE USE_YN = 'Y'\n"
         . " ORDER BY SEQ "
         . " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many
    ;
// Elexess      P6-P17 60~105m/min 승객용 TK50G
// ElexessIII   P6-P17 60~105m/min 승객용 TK50P3

    //echo 'tot :' . $tot . '<BR>';
    //echo 'sql :' . $sql . '<BR>';
    $seq = 0;
    $stmt = $db->multiRowSQLQuery($sql);
    while ($r = $db->multiRowFetch($stmt)) {
        $class_name = $r->CLASS_NAME;
        $f1         = $r->MODEL_TYPE;
        $f2         = $r->PASSENGER ;
        $f3         = $r->VELOCITY  ;
        $f4         = $r->USE_TYPE  ;
        $f5         = $r->CLASS     ;
        $f6         = $r->SEQ       ;
        $f7         = $r->USE_YN    ;
        //$f1   = ereg_replace(implode("%", split(" +", $_REQUEST["keyword"])),'<B>\\0</B>', $f1);
        //$f2   = ereg_replace(implode("%", split(" +", $_REQUEST["keyword"])),'<B>\\0</B>', $f2);
?>
    <tr class=<?print($seq%2==0?'even_row':'odd_row')?> ondblclick='fReturn(this);' onmouseover='tableUtil.row.activate(this);'>
    <td nowrap style='border-left :0;'><?print($class_name)?></td>
    <td nowrap><?print($f1)?></td>
    <td nowrap><?print($f2)?></td>
    <td nowrap><?print($f3)?></td>
    <td nowrap><?print($f4)?></td>
    <td nowrap><?print($f5)?></td>
    </tr>
<?
        $seq++;
    }
    print "<tr>";
    print "<td colspan=6 align=center style='border-left :0;text-align:center;font-weight:bold'>";

    print "<form id='pForm' name='pForm' method='POST' style='display:inline'>";
    if (!$tot) {
        print "data is not found";
    } else {
        print "<input type=hidden name='s' value='{$s}'>";
        print "<input type=hidden name='tot' value='{$tot}'>";
        print pageTab ($page_tab);
    }
    print '</form>';
    print "</td>";
    print "</tr>";
?>
    </tbody>

    <tfoot>
    <tr>
    <td colspan=4 style='border-left:0;'>
    Please double click the Class Name
    </td>
    <td colspan=2 align=right>
    <button onclick='self.close();' class=button1>Close</button>
    </td>
    </tr>
    </tfoot>
</table>
<?php
    $db->release();
} // end if [op=="display"]
} // end login
?>