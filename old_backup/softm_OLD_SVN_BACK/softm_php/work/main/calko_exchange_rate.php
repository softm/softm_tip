<?
/*
 Filename       : /calko/calko_exchange_rate.php
 Fuction        : 환율관리
 Comment        :
 Make   Date    : 2009-08-21,
 Update Date    : 2010-03-04, v1.0 first
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

require_once SERVICE_DIR . '/common/Session.php';
$memInfor = Session::getSession();
$op = strtolower(trim($_POST["op"])) ;
$op = !$op?'default':$op                ;   // Process parameter [display, save]
$db = new DB (); // db instance
define('MY_TABLE', 'tbl_accounting_exchange_rate');  // session

if ( $op == 'default' ) $backurl = $_GET['backurl']?$_GET['backurl']:$REQUEST_URI ;
if ( $backurl ) Session::setSession('backurl',$backurl);
$backurl = Session::getSession('backurl');

if ( $memInfor['login_yn'] != 'Y' ) {
    redirectPage( "/" );
} else {
if ( !$grant[$_SERVER['PHP_SELF']][$memInfor[user_level]] ) {
    require_once '../inc/header.php'; // header
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
    require_once '../inc/header.php'   ; // header
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
    function rowInfo (r,k){
        this.rowIndex = r;
        this.key = k;
    }
    function fSetActiveRow(r,k) {
        if (_rI) _pRowIndex = _rI.rowIndex;
        _rI = new rowInfo(r,k);
    }

    function fGetList(s) {
        pm = m;
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = _url;
        var tbl = $('tbl_list');
        var th = tbl.tHead     ;
        var tb = tbl.tBodies[0];
        var tf = tbl.tFoot     ;

        ajaxR.openCallBack= function (str) {
            loading.hide();
            var xmlDoc=ajaxR.responseXML();
            var xml  = Util.xml2json(xmlDoc);
            var countryCodes = GRID.codeXmlToJson(xmlDoc.getElementsByTagName("country_code"));
            var items = typeof xml.items.length == 'undefined'? new Array(xml.items):xml.items;
            var l = items.length;
            var _rtn = GRID.init(
                {
                    table:tbl,
                    callback:{
                        'sort'  :fGetList
                    }
                }
            ); // create init

            GRID.clearBody({table:tbl}); // clear table body
            for (var i=0; i<l;i++ ) {
                var r=tb.insertRow(-1);
                r.style.cursor='pointer';
                r.style.height='23px';
                var rIdx = r.rowIndex;

                var accountingNo  = items[i].ACCOUNTING_NO    ;
                var countryCode   = items[i].COUNTRY_CODE     ;
                var className     = items[i].CLASS_NAME       ;
                var accountingYear= items[i].ACCOUNTING_YEAR  ;
                var marginRate    = parseFloat(items[i].MARGIN_RATE     );
                var markupRate    = parseFloat(items[i].MARKUP_RATE     );
                var sgnaRate      = parseFloat(items[i].SGNA_RATE       );
                var exchangeRate  = parseFloat(items[i].EXCHANGE_RATE   );
                var useYn         = items[i].USE_YN           ;

                var c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  accountingNo +"',event);return false;\" style='" + (useYn=='N'?'color:gray':'color:black') + "'>" + accountingYear +"</a><input type=hidden name=keys value='" + accountingNo+ "'>");
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  accountingNo +"',event);return false;\" style='" + (useYn=='N'?'color:gray':'color:black') + "'>" + countryCodes[countryCode] + "</a>");c.style.textAlign = 'left';c.style.paddingLeft = '4px';
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  accountingNo +"',event);return false;\" style='" + (useYn=='N'?'color:gray':'color:black') + "'>" + className                 + "</a>");c.style.textAlign = 'left';c.style.paddingLeft = '4px';
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  accountingNo +"',event);return false;\" style='" + (useYn=='N'?'color:gray':'color:black') + "'>" + marginRate.format()       + "</a>");
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  accountingNo +"',event);return false;\" style='" + (useYn=='N'?'color:gray':'color:black') + "'>" + sgnaRate.format()         + "</a>");
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  accountingNo +"',event);return false;\" style='" + (useYn=='N'?'color:gray':'color:black') + "'>" + exchangeRate.format()     + "</a>");
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  accountingNo +"',event);return false;\" style='" + (useYn=='N'?'color:gray':'color:black') + "'>" + (useYn=='Y'?'사용':'미사용')     + "</a>");

                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fExecDelete('D','" +  accountingNo +"',event);return false;\" style='" + (useYn=='N'?'color:gray':'color:black') + "'>DELETE</a>");
                    c = GRID.row.addCellByTag(r,'&nbsp;');
            }
            r=tb.insertRow(-1);
            c = GRID.row.addCellByTag(r,(l>0?xml.pagenavi.html:'Data not Found'));
            c.colSpan = th.rows[0].cells.length;
            fActiveRow();
            $('area_list' ).style.display = 'inline' ;
            $('area_write').style.display = 'none'   ;
        }
        ajaxR.form = $('sForm');
        var params = 'op=search'
                   + '&s=' + (s?s:1);
        params += GRID.getSortString(('tbl_list')); // SORT
        params += '&' + ajaxR.getQueryString();
        ajaxR.httpOpen('POST', url, true,params, $("data_list"));
        m = 'S';
        _s = s;
        loading.setTarget(document.documentElement);
        loading.show();
        return false;
    }

    function fGetWrite(lm,k,e) {
        var eO = e?document.all?e.srcElement:e.target:null;
        if (eO) {
            var r = document.all?eO.parentElement.parentElement.rowIndex:eO.parentNode.parentNode.rowIndex;
            fSetActiveRow(r,k);
            fActiveRow();
        } else {
            _rI = null;
        }
        pm = m;
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = _url;
        ajaxR.openCallBack= function (str) {
            ajaxR.dataArea.innerHTML = ajaxR.responseText();
            loading.hide();
            $('area_list' ).style.display = 'none'    ;
            $('area_write').style.display = 'inline'  ;
        }
        lm = (lm?lm:'I');
        k = (k?k:'' );
        var params = 'op=write'
                   + '&m=' + lm
                   + (k?'&k=' + k:'');
        ajaxR.httpOpen('POST', url, true,params, $("area_write"));
        m = lm;
        loading.setTarget(document.documentElement);
        loading.show();
        return false;
    }

    function fActiveRow() {
        if (_rI) {
            try {
                var tmpKey = document.getElementsByName('keys')[_rI.rowIndex-1].value;
                if ( tmpKey == _rI.key ) {
                    var l = $('tbl_list').rows[0].cells.length;
                    if ( _pRowIndex > -1 ) {
                        for (var i=0; i<l-1; i++) {
                            $('tbl_list').rows[_pRowIndex].cells[i].firstChild.style.fontWeight = 'normal';
                        }
                    }
                    for (var i=0; i<l-1; i++) {
                        $('tbl_list').rows[_rI.rowIndex].cells[i].firstChild.style.fontWeight = 'bold';
                    }
                }
            }
            catch (e) {}
        }
    }

    function fExec(lm) {
        var ajaxR = new asyncConnector('xmlhttp');
        var error = false;
        var msgStr = '' ;
        var pMsgStr = '' ;
        if ( lm == 'I' || lm == 'U' ) {
            if ( !$('frm_accounting_year').value.trim() ) {
                Alert.show({id:'message_box',message:'회계년도는 필수 입력입니다.',ok:function(){$('frm_accounting_year').focus();}});
                setTimeout(function(){Alert.hide({id:'message_box'});$('frm_accounting_year').focus();},1000);

                Effect.twinkle($('frm_accounting_year'));
                error = true;
            }
            msgStr = '저장하시겠습니까?';
            pMsgStr= '저장되었습니다';
        }

        if ( !error && confirm(msgStr) ) {
            var url  = _url;
            ajaxR.openCallBack= function (str) {
                var info = ajaxR.responseText().split('|');
                var s = info[0];
                var m = info[1];
                var k = info[2];
                var msg = info[3];
                if (s == 'SUCCESS') { // success
                    alert(pMsgStr);
                    if ( m == 'I' ) {
                        fSetActiveRow(1,k);
                        fGetList(1);
                    }
                    else if ( m == 'U' ) fGetList(_s);//fGetWrite('U',k);
                } else if (s == 'ERROR') {
                    alert(info[3]); // error
                }
                /**/
            }
            ajaxR.form = $('wForm');
            lm = (lm?lm:'I');
            var params = 'op=save_exec'
                       + '&m=' + lm
                       + ($('wForm').k1.value?'&k=' + $('wForm').k1.value:'')
                       + '&' + ajaxR.getQueryString();
            //alert( params );
            ajaxR.httpOpen('POST', url, true,params, null);
        }
        return false;
    }

    function fExecDelete(lm,k1) {
        var ajaxR = new asyncConnector('xmlhttp');
        var error = true;
        var msgStr = '' ;
        var pMsgStr = '' ;
        msgStr = k1 + '번 자료를 삭제하시겠습니까?';
        pMsgStr= '삭제되었습니다';

        if ( error && confirm(msgStr) ) {
            var url  = _url;
            ajaxR.openCallBack= function (str) {
                var info = ajaxR.responseText().split('|');
                var s = info[0];
                var m = info[1];
                var k = info[2];
                var msg = info[3];
                if (s == 'SUCCESS') { // success
                    alert(pMsgStr);
                    fGetList(1);
                } else if (s == 'ERROR') {
                    alert(info[3]); // error
                }
            }
            var params = 'op=del_exec'
                       + '&m=' + lm
                       + (k1?'&k=' + k1:'');
                       //+ '&' + ajaxR.getQueryString();
            ajaxR.httpOpen('POST', url, true,params, null);
        }
        return false;
    }

    function fGoBack() {
        if ( m == 'I' || m == 'U' ) {
            //alert(m);
            $('area_list' ).style.display = 'inline'    ;
            $('area_write').style.display = 'none'      ;
        }
    }
    window.onload = function() {
        fGetList(1);
        document.title = "Exchange Rate";
    }
//-->
</SCRIPT>
<STYLE type=text/css>
    #tbl_list th       { text-align:center }
    #tbl_list td       { text-align:center }
</STYLE>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="100%" valign="top">

<?print "<form id='sForm' name='sForm' method='POST' onsubmit='return fGetList(1);'>";?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='60'/>
            <col width='65'/>
            <col width='30'/>
            <col width='150'/>
            <col width='60'/>
            <col width='150'/>
            <col width='60'/>
            <col width=''/>
        </colgroup>
        <thead>
            <tr>
            <th colspan="9"><?php print html_xlate("회계년도별 환율등록"); ?></th>
            </tr>
            <tr>
            <td><?php print html_xlate("회계년도"); ?></td>
            <td>
<?
    $db->getConnect();
    $sql = "SELECT \n"
         . "  distinct ACCOUNTING_YEAR \n"
         . " FROM " . MY_TABLE . " \n"
    ;
    //echo 'sql :' . $sql . '<BR>';
    $stmt = $db->multiRowSQLQuery($sql);
    while ($r = $db->multiRowFetch($stmt)) {
        $accounting_years[$r->ACCOUNTING_YEAR] = $r->ACCOUNTING_YEAR;
    }
    $creategory_setup['select'          ] = $s_current_accounting_year;
    $creategory_setup['prop_name'       ] = 's_current_accounting_year';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = " id=s_current_accounting_year"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $accounting_years['setup'] = $creategory_setup;
    echo createGory ('SELECT', $accounting_years);
?>
            </td>

            <td><?php print html_xlate("국가"); ?></td>
            <td>
<?
$country_codegory = getCountry();
$creategory_setup['select'          ] = $s_country_code;
$creategory_setup['prop_name'       ] = 's_country_code';
$creategory_setup['title'           ] = '-전체-'  ;
$creategory_setup['script'          ] = " id=s_country_code"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$country_codegory['setup'] = $creategory_setup;
print createGory ('SELECT', $country_codegory);
?>

            </td>

            <td><?php print html_xlate("model"); ?></td>
            <td>
<?
$class_name_gory = getClassName('');
$creategory_setup['select'          ] = $s_class_name;
$creategory_setup['prop_name'       ] = 's_class_name';
$creategory_setup['title'           ] = '-전체-'  ;
$creategory_setup['script'          ] = " id=s_class_name"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$class_name_gory['setup'] = $creategory_setup;
print createGory ('SELECT', $class_name_gory);
?>
            </td>

            <td style="text-align:right">
            <input type=button onclick='fGetList(1);' value='<?=xlate("SEARCH")?>' class='button1'>
            </td>
            <td>
            <input type=button onclick='fGetWrite();' value='<?=xlate("New")?>' class='button1'>
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

<span id='area_list'>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbodyline" style='table-layout:fixed' id='tbl_list'>
<colgroup>
    <col width='6%'/>
    <col width='13%'/>
    <col width='15%'/>
    <col width='6%'/>
    <col width='6%'/>
    <col width='6%'/>
    <col width='8%'/>
    <col width='8%'/>
    <col width=''/>
</colgroup>
<thead>
    <tr style='cursor:pointer;'>
    <th onClick='GRID.setSort({event:event,fieldName:"ACCOUNTING_YEAR",arrowDraw:true});'><?php print xlate("회계년도"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"COUNTRY_CODE"   ,arrowDraw:true});' style='text-align:left'><?php print xlate("국가"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"CLASS_NAME"     ,arrowDraw:true});' style='text-align:left'><?php print xlate("MODEL"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"MARGIN_RATE"    ,arrowDraw:true});'><?php print xlate("GM"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"SGNA_RATE"      ,arrowDraw:true});'><?php print html_xlate("SG&A"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"EXCHANGE_RATE"  ,arrowDraw:true});'><?php print html_xlate("환율"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"USE_YN"         ,arrowDraw:true});'><?php print html_xlate("사용유무"); ?></th>
    <th                                                         ><?php print html_xlate("-"); ?></th>
    <th>&nbsp;</th>
    </tr>
</thead>
<tbody id='data_list'></tbody>
</table>
</span>
<span id='area_write'></span>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var loading = new UI.Loading.display('<?=SERVICE_DIR?>/common/js/ajax-loader.gif','image');
    //loading.show();
    loading.setTarget($('area_list'));
  //loading.setTarget(document.documentElement);
    loading.setSize('80px','10px');
//-->
</SCRIPT>
<?
    $db->release();
    require("../inc/footer.php"); // footer
} // end if [op=="default"]
else if ( $op == "search") { // 조회
?>
<?php
    header("content-type: application/xml; charset=UTF-8");
    //$p_esti_no = 'AO09100005101'; //test fixed tp log
    //$p_esti_no = 'X0809006201'; //test fixed tp price
    print '<?xml version="1.0" encoding="UTF-8"?>'. "\n";

    require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
    $db->getConnect();
    $cur_many = 0;

    $s_current_accounting_year = $_POST["s_current_accounting_year"];
    $s_country_code            = $_POST["s_country_code"           ];
    $s_class_name            = $_POST["s_class_name"           ];
    $where  = ($s_current_accounting_year?" a.ACCOUNTING_YEAR = '{$s_current_accounting_year}' \n":'');
    $where .= ($s_country_code           ?($where?' AND ':'')." a.COUNTRY_CODE = '{$s_country_code }' \n":'');
    $where .= ($s_class_name             ?($where?' AND ':'')." a.CLASS_NAME   = '{$s_class_name   }' \n":'');
  //$where .= ($where?' AND ':'')." cn.USE_YN = 'Y'\n";
    $where .= ($where?' AND ':'')." a.CLASS_NAME = cn.CLASS_NAME\n";
    //echo ' where : ' . $where;
    $tot = $db->get("SELECT COUNT(*) CNT FROM " . MY_TABLE . " a, tbl_calko_class_name cn " . ( $where?' WHERE ' . $where:'' ))->CNT;// row count

    // pagetab
    $page_tab['js_function' ] = 'fGetList';
    $page_tab['s'        ] = !$_POST[s]?1:(int)$_POST[s];
    $page_tab['tot'      ] = $tot;
    $page_tab['how_many' ] = 15 ;
    $page_tab['more_many'] = 15 ;
    $page_tab['page_many'] = 10 ;
    if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    //$sRtn = $db->exec("set names utf8");
    $orderStr = array();

    for( $i=0;$i<sizeof($_POST['sort_f']);$i++) {
        if      ($_POST['sort_d'][$i]=='▲') $dir = 'ASC' ;
        else if ($_POST['sort_d'][$i]=='▼') $dir = 'DESC';
        if ( $dir ) $orderStr[] = $_POST['sort_f'][$i] . ' ' . $dir;
    }

    $sql = "SELECT \n"
         . "  a.ACCOUNTING_NO   ACCOUNTING_NO  , \n"
         . "  a.CLASS_NAME      CLASS_NAME     , \n"
         . "  a.COUNTRY_CODE    COUNTRY_CODE   , \n"
         . "  a.ACCOUNTING_YEAR ACCOUNTING_YEAR, \n"
         . "  a.MARKUP_RATE     MARKUP_RATE    , \n"
         . "  a.MARGIN_RATE     MARGIN_RATE    , \n"
         . "  a.SGNA_RATE       SGNA_RATE      , \n"
         . "  a.EXCHANGE_RATE   EXCHANGE_RATE  , \n"
         . "  a.USE_YN          USE_YN           \n"
         . " FROM " . MY_TABLE . " a,tbl_calko_class_name cn \n"
         . ( $where?' WHERE ' . $where:'' )
         . ( sizeof($orderStr)>0?" ORDER BY ".join($orderStr,','):'' )
       //. " ORDER BY USE_YN desc, ACCOUNTING_YEAR, COUNTRY_CODE "
         . " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many
    ;
    $country_codegory = getCountry();

    $seq = 0;
    print '<results>';
    print '<programid>calko_user.php</programid>';
    print '<sql><![CDATA['.$sql.']]></sql>';
    print '<date>' . date('Y/m/d h:i:s A') . '</date>';
    $stmt = $db->multiRowSQLQuery($sql);
    while ($r = $db->multiRowFetch($stmt)) {
        print '<items>';
        foreach ($r as $n => $v) {
            printf("<%s><![CDATA[%s]]></%s>\n",$n,$v,$n);
        }
        print '</items>';
    }
    print "\n";
    print '<code>';
        foreach ($country_codegory as $n => $v) {
            printf("<country_code id='%s'><![CDATA[%s]]></country_code>\n",$n,$v,$n);
        }
    print '</code>';
    print "\n";
    print '<pagenavi>';
        print '<html><![CDATA[' . pageTab ($page_tab) . ']]></html>';
        print '<how_many><![CDATA[' . $how_many . ']]></how_many>';
        print '<more_many><![CDATA[' . $more_many . ']]></more_many>';
        print '<page_many><![CDATA[' . $more_many . ']]></page_many>';
        print '<total><![CDATA[' . $tot . ']]></total>';
        print '<position><![CDATA[' . $s . ']]></position>';
    print '</pagenavi>';
    print '</results>';
?>
<?php
    $db->release();
} // end if [op=="display"]
else if ( $op == "write") {
    $db->getConnect();
    $m = trim($_POST["m"]); // mode [I/U]
    $k = trim($_POST["k"]); // key
    if ( $k ) {
        $sql = "SELECT \n"
             . "  ACCOUNTING_NO  , \n"
             . "  COUNTRY_CODE   , \n"
             . "  CLASS_NAME     , \n"
             . "  ACCOUNTING_YEAR, \n"
             . "  MARGIN_RATE    , \n"
             . "  MARKUP_RATE    , \n"
             . "  SGNA_RATE      , \n"
             . "  EXCHANGE_RATE  , \n"
             . "  USE_YN           \n"
             . " FROM " . MY_TABLE . " \n"
             . " WHERE ACCOUNTING_NO = '{$k}'\n"
        ;
        $r = $db->get($sql);

        $k1 = $r->ACCOUNTING_NO;
        $frm_country_code   = $r->COUNTRY_CODE      ;
        $frm_class_name     = $r->CLASS_NAME        ;
        $frm_accounting_year= $r->ACCOUNTING_YEAR   ;
        $frm_margin_rate    = $r->MARGIN_RATE       ;
        $frm_markup_rate    = $r->MARKUP_RATE       ;
        $frm_sgna_rate      = $r->SGNA_RATE         ;
        $frm_exchange_rate  = $r->EXCHANGE_RATE     ;
        $frm_use_yn         = $r->USE_YN            ;
        $useYnInfo = split(',',$frm_use_yn); // checkbox
    } else {
        $frm_accounting_year= ACCOUNTING_YEAR;
        $frm_country_code   = 'AO' ;
        $frm_class_name     = '-';
        $frm_margin_rate    = '10.0';
        $frm_markup_rate    = '10.0';
        $frm_sgna_rate      = '10.0';
        $frm_exchange_rate  = '1000.0';
        $frm_use_yn         = 'Y';
        $useYnInfo = split(',',$frm_use_yn); // checkbox

    }
        print "<form id='wForm' name='wForm' method='POST' onsubmit='return fExec(\"$m\");'>";
        print "<input type=hidden name='k1' value='{$k1}'>";
?>
        <!-- <div class="formcell"> -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='20%'/>
            <col width='30%'/>
            <col width=''/>
        </colgroup>

        <tr>
            <th colspan="3"><?php print html_xlate("Save"); ?></th>
        </tr>
        <tr><td>
        <strong><?php print html_xlate("회계년도"       )        ;  ?></strong></td>
        <td>
        <INPUT TYPE="text" id="frm_accounting_year" name="frm_accounting_year" value='<?print $frm_accounting_year?>'
        <?print ($m=='U'?' style="border:0;background-color:transparent;width:100%" readonly':'class="ml"')?>>
        </td><td></td></tr>

        <tr><td><strong><?php print html_xlate("국가"       )        ;  ?></strong></td>
        <td>

<?
$country_codegory = getCountry();
if ( $m=='I' ) {
    $creategory_setup['select'          ] = $frm_country_code;
    $creategory_setup['prop_name'       ] = 'frm_country_code';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = " id=frm_country_code"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $country_codegory['setup'] = $creategory_setup;
    print createGory ('SELECT', $country_codegory);
} else {
    print $country_codegory[$frm_country_code];
    print '&nbsp;';
    print '(' . $frm_country_code . ')';
    print "<input type=hidden name='frm_country_code' value='{$frm_country_code}'>";
}
?>

        </td><td></td></tr>

        <tr><td><strong><?php print html_xlate("model"       )        ;  ?></strong></td>
        <td>

<?
$class_name_gory = getClassName('');
if ( $m=='I' ) {
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 'frm_all_model';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = " value='Y' checked id=frm_all_model onclick='$(\"frm_class_name\").disabled= this.checked;if ( !this.checked ) { $(\"frm_class_name\").focus();Effect.twinkle($(\"frm_class_name\")) } '"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $frm_use_ynegory['Y'] = '모델전체';
    $frm_use_ynegory['setup'] = $creategory_setup;
    print createGory ('CHECKBOX', $frm_use_ynegory);
    print '&nbsp;';

    $creategory_setup['select'          ] = $frm_class_name;
    $creategory_setup['prop_name'       ] = 'frm_class_name';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = " id=frm_class_name disabled=true"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $class_name_gory['setup'] = $creategory_setup;
    print createGory ('SELECT', $class_name_gory);

} else {
    print $class_name_gory[$frm_class_name];
    print "<input type=hidden name='frm_class_name' value='{$frm_class_name}'>";
}
?>

        </td><td></td></tr>

<!--         <tr><td><strong><?php print html_xlate("Markup"         ) . '(%)';  ?></strong></td>
        <td>
        <INPUT TYPE="text" id="frm_markup_rate" name="frm_markup_rate" style='width:100%' value='<?print $frm_markup_rate?>'>
        </td><td></td></tr> -->
        <tr><td><strong><?php print html_xlate("GM"         ) . '(%)';  ?></strong></td>
        <td>
        <INPUT TYPE="text" id="frm_margin_rate" name="frm_margin_rate" style='width:100%' value='<?print $frm_margin_rate?>'>
        </td><td></td></tr>
        <tr><td><strong><?php print html_xlate("SG&A"           ) . '(%)';  ?></strong></td>
        <td>
        <INPUT TYPE="text" id="frm_sgna_rate" name="frm_sgna_rate" style='width:100%' value='<?print $frm_sgna_rate?>'>
        </td><td></td></tr>
        <tr><td><strong><?php print html_xlate("환율"           ) . '원' ;  ?></strong></td>
        <td>
        <INPUT TYPE="text" id="frm_exchange_rate" name="frm_exchange_rate" style='width:100%' value='<?print $frm_exchange_rate?>'>
        </td><td></td></tr>
        <tr><td><strong><?php print html_xlate("사용유무"       )        ;  ?></strong></td>
        <td>
<?
$creategory_setup['select'          ] = $frm_use_yn;
$creategory_setup['prop_name'       ] = 'frm_use_yn';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " id=frm_use_yn"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$frm_use_ynegory['Y'] = '사용';
$frm_use_ynegory['setup'] = $creategory_setup;
echo createGory ('CHECKBOX', $frm_use_ynegory);
?>
        </td><td></td></tr>

        <tr>
            <td colspan="3"><hr /></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:right">
            <input type=button onclick='fExec("<?print $m?>");' value='<?=xlate("Save")?>' class='button1'/>
            <input type=submit style='position:absolute;left:-1000px;top:-1000px'/>
            <input type=button onclick='fGoBack();' value='<?=xlate("Close")?>' class='button1'/>
            </td>
            <td></td>
        </tr>
        </table>
        <!-- </div> -->
        </form>
<?
    $db->release();
} // end if [op=="write"]
else if ( $op == "save_exec") {
    $db->getConnect();
    $errors = array();
    $m = trim($_POST["m"]); // mode [I/U]
    $k = trim($_POST["k"]); // key

    // Save Field
    $savefields = array();
  //$savefields[] = "ACCOUNTING_NO"  ;
    $savefields[] = "country_code"   ;
    $savefields[] = "class_name"     ;
    $savefields[] = "accounting_year";
    $savefields[] = "margin_rate"    ;
    $savefields[] = "markup_rate"    ;
    $savefields[] = "sgna_rate"      ;
    $savefields[] = "exchange_rate"  ;

    $savedata = array();
    while (list($key, $val) = each($_POST)) {
        if (substr($key, 0, 4) == "frm_" && array_search(substr($key, 4), $savefields) > -1
            && substr($key, 4) != 'use_yn' )
        {
            $savedata[substr($key, 4)] = "'{$val}'";
        }
    }
    if (!$savedata['accounting_year'] ) {
        $errors[] = xlate('회계년도가 입력되지 않았습니다.');
    }

    $savefields[] = "use_yn"         ;
    $savedata['use_yn'] = $_POST['frm_use_yn']=='Y'?"'Y'":"'N'";
    if ( $savedata['use_yn']  == "'Y'" ) {
        $sRtn = $db->exec("UPDATE " . MY_TABLE . " SET USE_YN = 'N' "
                        . " WHERE ACCOUNTING_YEAR = " . $savedata['accounting_year' ]
                        . " AND COUNTRY_CODE      = " . $savedata['country_code'    ]
                        . ($_POST[frm_all_model] != 'Y'?" AND CLASS_NAME = " . $savedata['class_name']:"")
                        . " AND USE_YN = 'Y'"
                );
    } else {
        $yCnt = $db->count(MY_TABLE, " ACCOUNTING_YEAR  = " . $savedata['accounting_year'   ]
                                   . " AND COUNTRY_CODE = " . $savedata['country_code'      ]
                                   . " AND CLASS_NAME   = " . $savedata['class_name'        ]
                                   . " AND USE_YN = 'Y'"
                );
        if ( $yCnt == 1 ) $errors[] = xlate('사용상태가 모두해제될 수 없습니다.');
    }

    $sRtn = 0;
    if (empty($errors)) {
        if (!empty($savedata)) {
            if ( $db->starttransaction() ) {
                if ( $m == 'I' ) {
                    $savefields[] = "reg_date"      ; $savedata['reg_date'   ] = "now()";
                    $savefields[] = "reg_user_id"   ; $savedata['reg_user_id'] = "'" . $memInfor[user_no] . "'";
                    if ( $_POST[frm_all_model] == 'Y' ) {
                        $class_name_gory = getClassName('');
                        foreach( $class_name_gory as $k => $v) {
                            $savedata[class_name] = $db->quote($k);
                            $db->insert(MY_TABLE, $savedata);
                        }
                    } else {
                        $db->insert(MY_TABLE, $savedata);
                    }
                } else if ( $m == 'U' ) {
                    $savefields[] = "mod_date"      ; $savedata['mod_date'   ] = "now()";
                    $savefields[] = "mod_user_id"   ; $savedata['mod_user_id'] = "'" . $memInfor[user_no] . "'";
                    $sRtn = $db->update(MY_TABLE, $savedata,"ACCOUNTING_NO='{$k}'");
                }
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
        } else {
        }
    }

    // Validation & error display javascript
    if (!empty($errors)) {
        if ( $db->getErrMsg() ) $errors[] = $db->getErrMsg();
        echo 'ERROR|'   . $m . '|' . $sRtn  . '|' . implode($errors, "', '");
    } else {
        echo 'SUCCESS|' . $m . '|' . $sRtn  . '|';
    }
    $db->release();
} // end if [op=="save_exec"]
else if ( $op == "del_exec") {
    $db->getConnect();
    $m = trim($_POST["m"]); // mode [I/U]
    $k = trim($_POST["k"]); // key
    $cnt = $db->count(MY_TABLE, "ACCOUNTING_NO='{$k}'"); // row count
    if ( $cnt == 0 ) $errors[] = xlate('data is not found ( SQL-Delete )');

    $sql = "SELECT \n"
         . "  COUNTRY_CODE   ,\n"
         . "  CLASS_NAME     ,\n"
         . "  ACCOUNTING_YEAR \n"
         . " FROM " . MY_TABLE . " \n"
         . " WHERE ACCOUNTING_NO='{$k}'\n"
    ;
    $r = $db->get($sql);
    $country_code   = $r->COUNTRY_CODE      ;
    $accounting_year= $r->ACCOUNTING_YEAR   ;
    $class_name     = $r->CLASS_NAME        ;

    $cnt = $db->count(MY_TABLE, "country_code='{$country_code}' AND accounting_year='{$accounting_year}' AND class_name='{$class_name}'"); // row count
    if ( $cnt <= 1 ) $errors[] = xlate('기본자료는 삭제할 수 없습니다.');

    $sRtn = 0;
    if (empty($errors)) {
        if ( $db->starttransaction() ) {
            if ( $m == 'D' ) {
                $sRtn = $db->delete(MY_TABLE,"ACCOUNTING_NO='{$k}'");
            }
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
    // Validation & error display javascript
    if (!empty($errors)) {
        echo 'ERROR|'   . $m . '|' . $sRtn  . '|' . implode($errors, "', '");
    } else {
        echo 'SUCCESS|' . $m . '|' . $k     . '|' . '';
    }
    $db->release();
} // end if [op=="del_exec"]
} // end grant
} // end login
?>