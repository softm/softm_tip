<?
/*
 Filename       : /calko/calko_spec_interface_copy_manager.php
 Fuction        : Characteristic Code 조회
 Comment        :
 Make   Date    : 2010-02-10,
 Update Date    : 2010-02-26, v1.0 first
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

    require_once '../inc/header.php'   ; // header
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
                Util.Load.script({src:"calko_spec_interface_copy_manager.js",type:'js',callback:setTimeout(function(){
                    fSetCountryToCombo($('s_s_country_code'));
                    $('s_s_country_code').value = $('s_s_country_code').getAttribute('set') + '';
                    fChangeCountry( $('s_s_country_code'), $('s_s_destination') , $('s_s_sold_to_party') );
                    fSetCountryToCombo($('country_code'));
                    $('country_code').value = $('country_code').getAttribute('set');
                    fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
                    fSearch();
                    },1000)});
            } else {
                Util.Load.script({src:"calko_spec_interface_copy_manager.js",type:'js',callback:function(){
                    fSetCountryToCombo($('s_s_country_code'));
                    $('s_s_country_code').value = $('s_s_country_code').getAttribute('set') + '';
                    fChangeCountry( $('s_s_country_code'), $('s_s_destination'), $('s_s_sold_to_party')  );
                    fSetCountryToCombo($('country_code'));
                    $('country_code').value = $('country_code').getAttribute('set');
                    fChangeCountry( $('country_code'), $('destination') , $('sold_to_party') );
                    fSearch();
                    }});
            }

            if (destGory) {
                $('copy_button'  ).disabled = false;
            }
            $('search_button').disabled = false;
            $('del_button'   ).disabled = false;
        }});
        _s = s;
        loading.show(document.documentElement);
        loading.setPos(0,'100px');
    }

    window.onload = function() {
        document.title = 'Quotation Copy';
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
    Util.Load.script({src:"calko_spec_interface_copy_manager.css",type:'css'});
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
            <tr><th colspan="5">Quotation Copy</th></tr>
        </thead>
    </table>
</form>
    </td>
    </tr>
</table>
<form id="wForm" name="wForm" method="POST" onsubmit="return false;">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style='padding:3px 3px 3px 3px;vertical-align:top'>
    <tr>
    <td width="100%" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class=tbl style='border:1px solid #2B5580;width:700px'>
        <colgroup>
            <col width='90'  />
            <col width='130' />
            <col width='80'  />
            <col width='130' />
            <col width='90'  />
            <col width='100' />
            <col width=''/>
        </colgroup>
        <thead>
            <tr>
            <th colspan="7" class='title1'>● Source Search</td>
            </tr>

            <tr>
            <td colspan="7" style='height:0px'><hr /></td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Country')?></td>
            <td class=D1>
<?
$creategory_setup['select'          ] = $r->COUNTRY_CODE;
$creategory_setup['prop_name'       ] = 's_s_country_code';
$creategory_setup['title'           ] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-All-'  ;
$creategory_setup['script'          ] = " onchange='fChangeCountry($(\"s_s_country_code\"),$(\"s_s_destination\"),$(\"s_s_sold_to_party\"));'". " set='" . $r->COUNTRY_CODE .  "'"; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$countrys['setup'] = $creategory_setup;
echo createGory ('SELECT', $countrys);
?>
            </td>
            <td class=L1><?print xlate('Destination')?></td>
            <td class=D1>
<?
$creategory_setup['select'          ] = $r->DESTINATION;
$creategory_setup['prop_name'       ] = 's_s_destination';
$creategory_setup['title'           ] = '-All-'  ;
$creategory_setup['script'          ] = " onchange='fChangeDestination($(\"s_s_country_code\"),$(\"s_s_destination\"),$(\"s_s_sold_to_party\"));'". " set='" . $r->DESTINATION .  "'"; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$destinations['setup'] = $creategory_setup;
echo createGory ('SELECT', $destinations);
?>
            </td>

            <td class=L1><?print xlate('Sold-to-party')?></td>
            <td class=D1>
            <?php print "<input type=text id=s_s_sold_to_party style='width:85%;border:0px solid #FFFFFF;background-color:transparent' value='" . $r->SOLD_TO_PARTY . "' readonly>";?>
            </td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td class=L1><?print xlate('Sales in Charge')?></td>
            <td class=D1>
            <?php print "<input type=text id=s_s_sales_in_charge maxlength=20 autocomplete=off value='" . $sales_in_charge ."'>";?>
            </td>

            <td class=L1><?print xlate('Project Name')?></td>
            <td class=D1>
            <?php print "<input type=text id=s_s_project_name maxlength=20 value='" . $project_name. "'>";?>
            </td>

            <td class=L1><?print xlate('Name of Client')?></td>
            <td class=D1>
            <?php print "<input type=text id=s_s_name_of_client maxlength=20 value='" . $name_of_client. "'>";?>
            </td>

            <td>

            </td>

            </tr>
            <tr>
            <td class=L1><?print xlate('Quotation Date')?></td>
            <td class=D1 colspan=2>
            <input type="text" readonly class='date' id="s_s_frm_reg_date"
            value='<?=substr(getDateAdd (date('Y-m-d'), 'DAY', -7 ),0,10)?>' style='width:60px'> <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('s_s_frm_reg_date'),'yyyy-mm-dd',this)">
 ~
            <input type="text" readonly class='date' id="s_s_to_reg_date"
            value='<?=date('Y-m-d')?>' style='width:60px'> <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('s_s_to_reg_date'),'yyyy-mm-dd',this)">
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>
            <button onclick='fSearch();' class=button1 id=search_button disabled>Search</button>&nbsp;
            <button onclick='fDelete();' class=button1 id=del_button    disabled>Delete</button>&nbsp;
            </td>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td colspan="7" style='height:10px'><hr /></td>
            </tr>
            <tr>
            <td colspan="7" >
            <div id='area_list2' style='width:905px;height:108px;border:0px solid red;text-align:center;vertical-align:middle'></div>
            </td>
            </tr>
        </tbody>
    </table>
<!--     <table align=left cellpadding=0 cellspacing=0 border=0 style='border-collapse:collapse;table-layout:fixed;width:100%;border:0px'>
        <tr>
        <td align=left style='font-weight:bold;height:30px;padding-left:5px'>
        <button onclick='fTargetListRedraw();' class=button1 >▼ Add ▼</button>&nbsp;
        <button onclick='fDelToTarget();' class=button1 >▲ Del ▲</button>&nbsp;
        </td>
        </tr>
    </table> -->
    </td>
    </tr>

    <tr>
    <td colspan="2">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class=tbl style='border:1px solid #408080;width:700px'>
        <colgroup>
            <col width='90'  />
            <col width='130' />
            <col width='80'  />
            <col width='130' />
            <col width='90'  />
            <col width='100' />
            <col width=''/>
        </colgroup>
        <thead>
            <tr>
            <th colspan="7" class='title2'>● Target Copy <input type=radio name='copy_option' value='1' checked onclick='fChangeOption();'><a href=# onclick='$N("copy_option")[0].checked=true;fChangeOption();return false;' style='color:#FFFFFF'>New</a> <input type=radio name='copy_option' value='2' onclick='fChangeOption();'><a href=# onclick='$N("copy_option")[1].checked=true;fChangeOption();return false;' style='color:#FFFFFF'>Copy To Quotation</a>
            <span id='copy_label_1' style='display:none'>New</span> &nbsp;
            <input type='text' id='p_new_esti_no' style='background-color:transparent;border:0px;font-weight:bold;width:90px'>
            </td>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td colspan="7" style='height:10px'><hr /></td>
            </tr>
            <tr>
            <td colspan="7">
            <span id='area_list3'>
                <div class=header_area>
                <table class="a_tbl" cellpadding=0 cellspacing=0 border=0 align=center style='width:100%;border-collapse:collapse;table-layout:fixed'>
                    <colgroup>
                    <col width='30'/>
            <?
                if ( $memInfor['user_level'] >= 2 ) {
                    //print "<col width='100'/>";
                }
            ?>
                    <col width='105'/>
                    <col width='30' />
                    <col width='90' />
                    <col width='110'/>
                    <col width='110'/>
                    <col width='110'/>
                    <col width='110'/>
                    <col width='90'/>
                    <col width='100'/>
                    <col width='0' />
                    <col width='0' />
                    <col width='0' />
                    <col width='0' />
                    <col width=''/>
                    </colgroup>
                    <thead class=target>
                    <tr style='height:25px'>
            <?
                if ( $memInfor['user_level'] >= 2 ) {
                    //print "<th>" . xlate("User Name / ID") . "</th>";
                }
            ?>
                    <th><input type=checkbox id='target_check_all' onclick='fTargetCheckAll(this);' checked></th>
                    <th><?php print xlate("Quotation Number"); ?></th>
                    <th><?php print xlate("Seq"); ?></th>
                    <th><?php print xlate("Name Of Client"); ?></th>
                    <th><?php print xlate("Project Name"); ?></th>
                    <th><?php print xlate("Country"); ?></th>
                    <th><?php print xlate("Destination"); ?></th>
                    <th><?php print xlate("Specificaion"); ?></th>
                    <th><?php print html_xlate("Quotation Date"); ?></th>
                    <th style='border-right:0px'><?php print html_xlate("State"); ?></th>
                    <th style='border-right:0px'><?php print xlate(""); ?></th>
                    <th style='border-right:0px'><?php print xlate(""); ?></th>
                    <th style='border-right:0px'><?php print xlate(""); ?></th>
                    <th style='border-right:0px'><?php print xlate(""); ?></th>
                    <th style='border-right:0px'>&nbsp;</th>
                    </tr>
                    </thead>
                </table>
                </div>

                <div class=scroll_area>
                <table id=target_tbl class="a_tbl" align=center cellpadding=0 cellspacing=0 border=0>
                    <colgroup>
                    <col width='30'/>
            <?
                if ( $memInfor['user_level'] >= 2 ) {
                    //print "<col width='100'/>";
                }
            ?>
                    <col width='105'/>
                    <col width='30' />
                    <col width='90' />
                    <col width='110'/>
                    <col width='110'/>
                    <col width='110'/>
                    <col width='110'/>
                    <col width='90'/>
                    <col width='100'/>
                    <col width='0' />
                    <col width='0' />
                    <col width='0' />
                    <col width='0' />
                    <col width=''/>
                    </colgroup>
                    <tbody></tbody>
                    <tfoot id=target_tbl_foot><tr><td colspan=10 style='height:119px;border:0px;text-align:center;font-weight:bold'>Add a quote, please copy.</td></tr></tfoot>
                </table>
                </div>
            </span>
            </td>
            </tr>
        </tbody>
    </table>
    </td>
    </tr>

    <tr>
    <td colspan="2">
    <table border="0" cellspacing="0" cellpadding="0" class=tbl style='border:1px solid #408080;width:909px'>
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
            <input type="text" readonly class='date' size=5 id="quotation_date"
            value='<?=date('Y-m-d')?>'> <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('wForm').quotation_date,'yyyy-mm-dd',this)">
            </td>
            <td class=L1><?print xlate('Expected Delivery Date')?></td>
            <td class=D1>&nbsp;

            <input type="text" readonly class='date' size=5 id="expected_delivery_date"
            value='<?=substr(getDateAdd (date('Y-m-d'), 'DAY', 30 ),0,10)?>'> <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('wForm').expected_delivery_date,'yyyy-mm-dd',this)">
            </td>
            <td rowspan=4 class=D1 align=center>
            <button onclick='fCopy();' class=button2 id=copy_button style='width:220px;height:60px;font-size:23px'>Copy Execute</button>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Sales in Charge')?></td>
            <td class=D1>&nbsp;
            <?php print "<input type=text id=sales_in_charge style='width:85%;' maxlength=10 autocomplete=off value='" . $sales_in_charge ."'>";?>
            </td>
            <td class=L1><?print xlate('Name of Client')?></td>
            <td class=D1>&nbsp;
            <?php print "<input type=text id=name_of_client style='width:85%;' maxlength=10 value='" . $name_of_client. "'>";?>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Project Name')?></td>
            <td class=D1>&nbsp;
            <?php print "<input type=text id=project_name style='width:85%;' maxlength=10 value='" . $project_name. "'>";?>
            </td>
            <td class=L1><?print xlate('Sold-to-party')?></td>
            <td class=D1>&nbsp;
            <?php print "<input type=text id=sold_to_party style='width:85%;border:0px solid #FFFFFF;background-color:transparent' value='" . $r->SOLD_TO_PARTY . "' readonly>";?>
            </td>
            </tr>

            <tr>
            <td class=L1><?print xlate('Country')?></td>
            <td class=D1>&nbsp;<?
$creategory_setup['select'          ] = $r->COUNTRY_CODE;
$creategory_setup['prop_name'       ] = 'country_code';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " onchange='fChangeCountry($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"));$(\"p_new_esti_no\").value = fGetQuotationNo();'". " set='" . $r->COUNTRY_CODE .  "'"; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$countrys['setup'] = $creategory_setup;
echo createGory ('SELECT', $countrys);
?>
            </td>
            <td class=L1><?print xlate('Destination')?></td>
            <td class=D1>&nbsp;<?
$creategory_setup['select'          ] = $r->DESTINATION;
$creategory_setup['prop_name'       ] = 'destination';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " onchange='fChangeDestination($(\"country_code\"),$(\"destination\"),$(\"sold_to_party\"));$(\"p_new_esti_no\").value = fGetQuotationNo();'". " set='" . $r->COUNTRY_CODE .  "'"; // 스크립트




$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$destinations['setup'] = $creategory_setup;
echo createGory ('SELECT', $destinations);
?>
            </td>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td colspan="5" style='height:10px'></td>
            </tr>
        </tbody>
    </table>
    </td>
    </tr>

</table>
</form>

<span id='area_list4' style='position:absolute;width:905px;top:0px;left:0px;border:3px solid #2B5580;text-align:center;vertical-align:middle;display:none'></span>
<?
    $db->release();
    require("../inc/message_box.php");
} // end if [op=="get_default_ui"]
else if ( $op == "get_source_list") {
    $s_mode = $_GET["s_mode"];

?>
    <div class=header_area>
    <table class="a_tbl" cellpadding=0 cellspacing=0 border=0 align=center style='width:100%;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
<?
    if ( $s_mode == 'search' ) {
?>
        <col width='30'/>
<?
    }
?>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        //print "<col width='100'/>";
    }
?>
        <col width='105'/>
        <col width='30' />
        <col width='90' />
        <col width='110'/>
        <col width='110'/>
        <col width='110'/>
        <col width='110'/>
        <col width='90'/>
        <col width='100'/>
        <col width='' />
        <col width='' />
        <col width='' />
        <col width='' />
        <col width='' />
        </colgroup>
        <thead class=source>
        <tr style='height:25px'>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        //print "<th>" . xlate("User Name / ID") . "</th>";
    }
?>
<?
    if ( $s_mode == 'search' ) {
?>
        <th><input type=checkbox id='source_check_all' onclick='fSourceCheckAll(this);'></th>
<?
}
?>
        <th><?php print xlate("Quotation Number"); ?></th>
        <th><?php print xlate("Seq"); ?></th>
        <th><?php print xlate("Name Of Client"); ?></th>
        <th><?php print xlate("Project Name"); ?></th>
        <th><?php print xlate("Country"); ?></th>
        <th><?php print xlate("Destination"); ?></th>
        <th><?php print xlate("Specificaion"); ?></th>
        <th><?php print html_xlate("Quotation Date"); ?></th>
        <th style='border-right:0px'><?php print html_xlate("State"); ?></th>
        <th style='border-right:0px'><?php print xlate(""); ?></th>
        <th style='border-right:0px'><?php print xlate(""); ?></th>
        <th style='border-right:0px'><?php print xlate(""); ?></th>
        <th style='border-right:0px'><?php print xlate(""); ?></th>
        <th>&nbsp;</th>
        </tr>
        </thead>
    </table>
    </div>

    <div class=scroll_area>
    <table id=source_tbl class="a_tbl" align=center cellpadding=0 cellspacing=0 border=0 style='width:100%;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
<?
    if ( $s_mode == 'search' ) {
        print "<col width='30'/>";
    }
?>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        //print "<col width='100'/>";
    }
?>
        <col width='105'/>
        <col width='30' />
        <col width='90' />
        <col width='110'/>
        <col width='110'/>
        <col width='110'/>
        <col width='110'/>
        <col width='90'/>
        <col width='100'/>
        <col width=''/>
        <col width=''/>
        <col width=''/>
        <col width=''/>
        <col width='0'/>
        </colgroup>
        <tbody>
<input type=hidden name='source_check[]'>
<input type=hidden name='target_check[]'>
<?php
    require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
    $cur_many = 0;
    $db->getConnect();
    //$s_esti_no = $db->quote("%" . $_GET["s_esti_no"] . "%");

    if ( $s_mode == 'search' ){
        $s_s_country_code   = $_GET["s_s_country_code"   ];
        $s_s_destination    = $_GET["s_s_destination"    ];
        $s_s_sales_in_charge= $_GET["s_s_sales_in_charge"];
        $s_s_project_name   = $_GET["s_s_project_name"   ];
        $s_s_name_of_client = $_GET["s_s_name_of_client" ];
        $s_s_frm_reg_date   = $_GET["s_s_frm_reg_date"   ];
        $s_s_to_reg_date    = $_GET["s_s_to_reg_date"    ];
    } else {
        $s_s_country_code   = $_GET["s_p_country_code"   ];
        $s_s_destination    = $_GET["s_p_destination"    ];
        $s_s_sales_in_charge= $_GET["s_p_sales_in_charge"];
        $s_s_project_name   = $_GET["s_p_project_name"   ];
        $s_s_name_of_client = $_GET["s_p_name_of_client" ];
        $s_s_frm_reg_date   = $_GET["s_p_frm_reg_date"   ];
        $s_s_to_reg_date    = $_GET["s_p_to_reg_date"    ];
    }
    $where = " WHERE " . ($memInfor['user_level'] >= 2? " a.REG_USER_ID<>''" :" a.REG_USER_ID= '" . $memInfor[user_no] . "'") . "\n";
    $where .= " AND a.STATE != 'E'";
    $where .= ($s_s_country_code   ?" AND a.COUNTRY_CODE    =    '$s_s_country_code'":'');
    $where .= ($s_s_destination    ?" AND a.DESTINATION     =    '$s_s_destination'" :'');
    $where .= ($s_s_sales_in_charge?" AND a.SALES_IN_CHARGE LIKE '$s_s_sales_in_charge%'":'');
    $where .= ($s_s_project_name   ?" AND a.PROJECT_NAME    LIKE '$s_s_project_name%'   ":'');
    $where .= ($s_s_name_of_client ?" AND a.NAME_OF_CLIENT  LIKE '$s_s_name_of_client%' ":'');
    $where .= ($s_s_frm_reg_date&&$s_s_to_reg_date?" AND a.REG_DATE    BETWEEN '$s_s_frm_reg_date' AND '$s_s_to_reg_date 23:59:59'":'');

    //echo 'where : ' . $where . '<BR>';
    $sql = "SELECT COUNT(*) cnt"
         . " FROM tbl_calko_header a \n"
         . " JOIN tbl_calko_result b \n"
         . " ON a.ESTI_NO = b.ESTI_NO "
         . " JOIN tbl_member c"
         . " ON a.REG_USER_ID = c.USER_NO"
         . $where
    ;
    $tot = $db->get( $sql )->cnt; // row count

    // pagetab
    $page_tab['js_function' ] = 'fSimpleQuotationList';
    $page_tab['s'        ] = !$_GET[s]?1:(int)$_GET[s];
    $page_tab['tot'      ] = $tot;
    $page_tab['how_many' ] = 10;
    $page_tab['more_many'] = 10;
    $page_tab['page_many'] = 10;
    if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    $sql = "SELECT \n"
         . "  a.ESTI_NO               , \n"
         . "  b.SEQ                   , \n"
         . "  a.QUOTATION_DATE        , \n"
         . "  a.EXPECTED_DELIVERY_DATE, \n"
         . "  a.SALES_IN_CHARGE       , \n"
         . "  a.NAME_OF_CLIENT        , \n"
         . "  a.PROJECT_NAME          , \n"
         . "  a.COUNTRY_CODE          , \n"
         . "  d.COUNTRY_EN_NAME       , \n"
         . "  a.DESTINATION           , \n"
         . "  a.SOLD_TO_PARTY         , \n"
         . "  a.REG_DATE              , \n"
         . "  a.REG_USER_ID           , \n"
         . "  a.REG_USER_EMAIL        , \n"
         . "  b.SPECIFICATION         , \n"
         . "  b.STATE                 , \n"
         . "  c.USER_NO               , \n"
         . "  c.USER_NAME             , \n"
         . "  c.USER_ID                 \n"
         . " FROM tbl_calko_header a \n"
         . " JOIN tbl_calko_result b \n"
         . " ON a.ESTI_NO = b.ESTI_NO "
         . " JOIN tbl_member c"
         . " ON a.REG_USER_ID = c.USER_NO"
         . " LEFT OUTER JOIN ( SELECT c.COUNTRY_CODE COUNTRY_CODE, MAX(c.COUNTRY_EN_NAME) COUNTRY_EN_NAME FROM tbl_calko_country c GROUP BY c.COUNTRY_CODE ) d"
         . " ON a.COUNTRY_CODE = d.COUNTRY_CODE"
         . $where
         . " ORDER BY a.REG_DATE desc "
       //. " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many
    ;
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
        $country_en_name       = $r->COUNTRY_EN_NAME       ;
        $destination           = $r->DESTINATION           ;
        $sold_to_party         = $r->SOLD_TO_PARTY         ;
        $reg_date              = $r->REG_DATE              ;
        $reg_user_id           = $r->REG_USER_ID           ;
        $reg_user_email        = $r->REG_USER_EMAIL        ;
        $specification         = $r->SPECIFICATION         ;
        $state                 = $r->STATE                 ;
        $user_no               = $r->USER_NO               ;
        $user_name             = $r->USER_NAME             ;
        $user_id               = $r->USER_ID               ;

        $addStyle = ($idx==0?"border-top:0px;":"");

        print "<tr onclick='tableUtil.row.activate(this);' onmousedown=\";\" onclick='tableUtil.row.activate(this);' style='cursor:pointer;text-align:left'>";
        if ( $s_mode == 'search' ) {
            print "<td style='" . $addStyle . "text-align:center' nowrap><input type=checkbox name='source_check[]' onclick='fAddItem(parentNode.parentNode);'></td>";
        }

        if ( $memInfor['user_level'] >= 2 ) {
            //print "<td style='" . $addStyle . "text-align:center' nowrap>". $user_name . ' / ' . $user_id . "</td>";
        }

        print "<td style='" . $addStyle . "text-align:center' nowrap><a href=# onclick='fViewQuotation(\"$esti_no\",\"$seq\");'>". substr($esti_no,0,6) . '-' . substr($esti_no,6,5) . '-' . substr($esti_no,11) . "</a></td>";
        print "<td style='" . $addStyle . "text-align:center' nowrap><a href=# onclick='fViewQuotation(\"$esti_no\",\"$seq\");'>". $seq . "</a></td>";

        print "<td style='" . $addStyle . "' nowrap><div style='width:100px;overflow:hidden' class='textOf'><nobr>" . ($name_of_client?"". $name_of_client . "":'No Data') . "</nobr></div></td>";
        print "<td style='" . $addStyle . "' nowrap><div style='width:100px;overflow:hidden' class='textOf'><nobr>" . ($project_name?"". $project_name . "":'No Data') . "</nobr></div></td>";

        print "<td style='" . $addStyle . "' nowrap><div style='width:100px;overflow:hidden' class='textOf'><nobr>" . $country_en_name . "</nobr></div></td>";

        print "<td style='" . $addStyle . "' nowrap><div style='width:100px;overflow:hidden' class='textOf'><nobr>" . $destination . "</nobr></div></td>";

        print "<td style='" . $addStyle . "' nowrap><div style='width:100px;overflow:hidden' class='textOf'><nobr>" . $specification . "</nobr></div></td>";
        print "<td style='" . $addStyle . ";text-align:center' nowrap>" . $quotation_date . "</td>";

        print "<td style='" . $addStyle . "text-align:center' nowrap>" . $calko_stategory[$state] . "</td>";
        print "<td style='" . $addStyle . ";border-right:0px' nowrap><div style='display:none;' class='textOf'><nobr>" . ($sales_in_charge?"". $sales_in_charge . "":'No Data') . "</nobr></div></td>";
        print "<td style='" . $addStyle . ";border-right:0px' nowrap><div style='display:none;' class='textOf'><nobr>" . $country_code . "</nobr></div></td>";
        print "<td style='" . $addStyle . ";border-right:0px' nowrap><div style='display:none;' class='textOf'><nobr>" . $sold_to_party . "</nobr></div></td>";
        print "<td style='" . $addStyle . ";border-right:0px' nowrap><div style='display:none;' class='textOf'><nobr>" . $expected_delivery_date . "</nobr></div></td>";
        print "<td style='" . $addStyle . ";border-right:0px;text-align:center' align=center >&nbsp;</td>";
        print "</tr>";
        $idx++;
    }
?>
        </tbody>
        <tfoot>
<?
    print "<tr>";
    print "<td colspan=14 align=center style='text-align:center;font-weight:bold;border:0px;border-top:1px solid black'>";
    if (!$tot) {
        print "<table cellpadding=0 cellspacing=0 border=0 style='width:100%;height:84px;'><td style='text-align:center;border:0px'>data is not found</td></table>";
    } else {
        print "<input type=hidden name='s' value='{$s}'>";
        print "<input type=hidden name='tot' value='{$tot}'>";
        //print pageTab ($page_tab);
    }
    print "</td>";
    print "</tr>";
?>
        </tfoot>
    </table>
    </div>
<?
    if ( $s_mode == 'pop_search' ){
?>
    <div class=basic_panel style='width:903px'>
<TABLE class='basic_table'>
    <tr>
    <td align=left ><B style='color:red'>Please double click the row</B></td>
    <td align=right>
    <button onclick='fCloseSearchTarget();' class=button1>Select</button>
    <button onclick='fCloseSearchTarget();' class=button1>Close</button>
    </td>
    </tr>
</TABLE>
<?
    }
?>
    </div>
<?
    $db->release();
} // end if [op=="get_source_list"]
else if ( $op == "get_target_list") {
    $s_mode = $_GET["s_mode"];
?>
    <div class=header_area>
    <table class="a_tbl" cellpadding=0 cellspacing=0 border=0 align=center style='width:100%;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        //print "<col width='100'/>";
    }
?>
        <col width='105'/>
        <col width='90' />
        <col width='110'/>
        <col width='110'/>
        <col width='110'/>
        <col width='90'/>
        <col width='130'/>
        <col width='110'/>
        <col width='' />
        </colgroup>
        <thead class=source>
        <tr style='height:25px'>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        //print "<th>" . xlate("User Name / ID") . "</th>";
    }
?>
        <th><?php print xlate("Quotation Number"); ?></th>
        <th><?php print xlate("Name Of Client"); ?></th>
        <th><?php print xlate("Project Name"); ?></th>
        <th><?php print xlate("Country"); ?></th>
        <th><?php print xlate("Destination"); ?></th>
        <th><?php print html_xlate("Quotation Date"); ?></th>
        <th><?php print xlate("Expected Delivery Date"); ?></th>
        <th style='border-right:0px'><?php print html_xlate("Reg Date"); ?></th>
        <th>&nbsp;</th>
        </tr>
        </thead>
    </table>
    </div>

    <div class=scroll_area>
    <table id=target_tbl_select class="a_tbl" align=center cellpadding=0 cellspacing=0 border=0 style='width:100%;border-collapse:collapse;table-layout:fixed'>
        <colgroup>
<?
    if ( $memInfor['user_level'] >= 2 ) {
        //print "<col width='100'/>";
    }
?>
        <col width='105'/>
        <col width='90' />
        <col width='110'/>
        <col width='110'/>
        <col width='110'/>
        <col width='90'/>
        <col width='130'/>
        <col width='110'/>
        <col width='' />
        </colgroup>
        <tbody>
<input type=hidden name='source_check[]'>
<input type=hidden name='target_check[]'>
<?php
    require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
    $cur_many = 0;
    $db->getConnect();

    $s_s_country_code   = $_GET["s_p_country_code"   ];
    $s_s_destination    = $_GET["s_p_destination"    ];
    $s_s_sales_in_charge= $_GET["s_p_sales_in_charge"];
    $s_s_project_name   = $_GET["s_p_project_name"   ];
    $s_s_name_of_client = $_GET["s_p_name_of_client" ];
    $s_s_frm_reg_date   = $_GET["s_p_frm_reg_date"   ];
    $s_s_to_reg_date    = $_GET["s_p_to_reg_date"    ];

    $where = " WHERE " . ($memInfor['user_level'] >= 2? " a.REG_USER_ID<>''" :" a.REG_USER_ID= '" . $memInfor[user_no] . "'") . "\n";
    $where .= " AND a.STATE <= '3' ";
    $where .= ($s_s_country_code   ?" AND a.COUNTRY_CODE    =    '$s_s_country_code'":'');
    $where .= ($s_s_destination    ?" AND a.DESTINATION     =    '$s_s_destination'" :'');
    $where .= ($s_s_sales_in_charge?" AND a.SALES_IN_CHARGE LIKE '$s_s_sales_in_charge%'":'');
    $where .= ($s_s_project_name   ?" AND a.PROJECT_NAME    LIKE '$s_s_project_name%'   ":'');
    $where .= ($s_s_name_of_client ?" AND a.NAME_OF_CLIENT  LIKE '$s_s_name_of_client%' ":'');
    $where .= ($s_s_frm_reg_date&&$s_s_to_reg_date?" AND a.REG_DATE    BETWEEN '$s_s_frm_reg_date' AND '$s_s_to_reg_date 23:59:59'":'');
    $sql = "SELECT COUNT(*) cnt"
         . " FROM tbl_calko_header a \n"
         . " JOIN tbl_calko_result b \n"
         . " ON a.ESTI_NO = b.ESTI_NO "
         . " JOIN tbl_member c"
         . " ON a.REG_USER_ID = c.USER_NO"
         . $where
    ;
    $tot = $db->get( $sql )->cnt; // row count

    // pagetab
    $page_tab['js_function' ] = 'fSimpleQuotationList';
    $page_tab['s'        ] = !$_GET[s]?1:(int)$_GET[s];
    $page_tab['tot'      ] = $tot;
    $page_tab['how_many' ] = 10;
    $page_tab['more_many'] = 10;
    $page_tab['page_many'] = 10;
    if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];
    //$sRtn = $db->exec("set names utf8");
    $sql = "SELECT \n"
         . "  a.ESTI_NO               , \n"
         . "  a.QUOTATION_DATE        , \n"
         . "  a.EXPECTED_DELIVERY_DATE, \n"
         . "  a.SALES_IN_CHARGE       , \n"
         . "  a.NAME_OF_CLIENT        , \n"
         . "  a.PROJECT_NAME          , \n"
         . "  a.COUNTRY_CODE          , \n"
         . "  d.COUNTRY_EN_NAME       , \n"
         . "  a.DESTINATION           , \n"
         . "  a.SOLD_TO_PARTY         , \n"
         . "  a.REG_DATE              , \n"
         . "  a.REG_USER_ID           , \n"
         . "  a.REG_USER_EMAIL        , \n"
         . "  c.USER_NO               , \n"
         . "  c.USER_NAME             , \n"
         . "  c.USER_ID                 \n"
         . " FROM tbl_calko_header a \n"
       //. " JOIN tbl_calko_result b \n"
       //. " ON a.ESTI_NO = b.ESTI_NO "
         . " JOIN tbl_member c"
         . " ON a.REG_USER_ID = c.USER_NO"
         . " LEFT OUTER JOIN ( SELECT c.COUNTRY_CODE COUNTRY_CODE, MAX(c.COUNTRY_EN_NAME) COUNTRY_EN_NAME FROM tbl_calko_country c GROUP BY c.COUNTRY_CODE ) d"
         . " ON a.COUNTRY_CODE = d.COUNTRY_CODE"
         . $where
         . " ORDER BY a.REG_DATE desc "
       //. " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many
    ;
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
        $country_en_name       = $r->COUNTRY_EN_NAME       ;
        $destination           = $r->DESTINATION           ;
        $sold_to_party         = $r->SOLD_TO_PARTY         ;
        $reg_date              = $r->REG_DATE              ;
        $reg_user_id           = $r->REG_USER_ID           ;
        $reg_user_email        = $r->REG_USER_EMAIL        ;
        $specification         = $r->SPECIFICATION         ;
        $state                 = $r->STATE                 ;
        $user_no               = $r->USER_NO               ;
        $user_name             = $r->USER_NAME             ;
        $user_id               = $r->USER_ID               ;

        $addStyle = ($idx==0?"border-top:0px;":"");

        print "<tr ondblclick=\"fTargetSelect(rowIndex);\" onclick='tableUtil.row.activate(this);' onmousedown=\";\" onclick='tableUtil.row.activate(this);' style='cursor:pointer;text-align:left'>";
        if ( $memInfor['user_level'] >= 2 ) {
            //print "<td style='" . $addStyle . "text-align:center' nowrap>". $user_name . ' / ' . $user_id . "</td>";
        }

        print "<td style='" . $addStyle . "text-align:center' nowrap><input type='text' value='". substr($esti_no,0,6) . '-' . substr($esti_no,6,5) . '-' . substr($esti_no,11) . "' readonly style='background:transparent;cursor:pointer;width:100px' onfocus='this.blur();'><input type='hidden' value='". $sold_to_party . "' readonly><input type='hidden' value='". $sales_in_charge . "' readonly></td>";

        print "<td style='" . $addStyle . "' nowrap><input type='text' value='". $name_of_client    . "' onfocus='this.blur();' readonly></td>";
        print "<td style='" . $addStyle . "' nowrap><input type='text' value='". $project_name      . "' onfocus='this.blur();' readonly></td>";
        print "<td style='" . $addStyle . "' nowrap><input type='text' value='". $country_en_name   . "' onfocus='this.blur();' readonly></td>";
        print "<td style='" . $addStyle . "' nowrap><input type='text' value='". $destination       . "' onfocus='this.blur();' readonly></td>";

        print "<td style='" . $addStyle . "' nowrap><input type='text' value='". $quotation_date        . "' onfocus='this.blur();' readonly></td>";
        print "<td style='" . $addStyle . "' nowrap><input type='text' value='". $expected_delivery_date. "' onfocus='this.blur();' readonly></td>";

        print "<td style='" . $addStyle . ";text-align:center' align=center nowrap>" . $reg_date . "</td>";
        print "<td style='" . $addStyle . ";border-right:0px;text-align:center' align=center >&nbsp;</td>";
        print "</tr>";
        $idx++;
    }
?>
        </tbody>
        <tfoot>
<?
    print "<tr>";
    print "<td colspan=9 align=center style='text-align:center;font-weight:bold;border:0px;border-top:1px solid black'>";
    if (!$tot) {
        print "<table cellpadding=0 cellspacing=0 border=0 style='width:100%;height:84px;'><td style='text-align:center;border:0px'>data is not found</td></table>";
    } else {
        print "<input type=hidden name='s' value='{$s}'>";
        print "<input type=hidden name='tot' value='{$tot}'>";
        //print pageTab ($page_tab);
    }
    print "</td>";
    print "</tr>";
?>
        </tfoot>
    </table>
    </div>
    <div class=basic_panel style='width:903px'>
<TABLE class='basic_table'>
    <tr>
    <td align=left ><B style='color:red'>Please double click the row</B></td>
    <td align=right>
    <button onclick='fCloseSearchTarget();' class=button1>Select</button>
    <button onclick='fCloseSearchTarget();' class=button1>Close</button>
    </td>
    </tr>
</TABLE>
    </div>
<?
    $db->release();
} // end if [op=="get_target_list"]
else if ( $op == "get_target_item") {
    $db->getConnect();
    $p_esti_no  = str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no
    $sql = "SELECT \n"
         . "  a.ESTI_NO               , \n"
         . "  b.SEQ                   , \n"
         . "  a.QUOTATION_DATE        , \n"
         . "  a.EXPECTED_DELIVERY_DATE, \n"
         . "  a.SALES_IN_CHARGE       , \n"
         . "  a.NAME_OF_CLIENT        , \n"
         . "  a.PROJECT_NAME          , \n"
         . "  a.COUNTRY_CODE          , \n"
         . "  d.COUNTRY_EN_NAME       , \n"
         . "  a.DESTINATION           , \n"
         . "  a.SOLD_TO_PARTY         , \n"
         . "  a.REG_DATE              , \n"
         . "  a.REG_USER_ID           , \n"
         . "  a.REG_USER_EMAIL        , \n"
         . "  b.SPECIFICATION         , \n"
         . "  b.STATE                 , \n"
         . "  c.USER_NO               , \n"
         . "  c.USER_NAME             , \n"
         . "  c.USER_ID                 \n"
         . " FROM tbl_calko_header a \n"
         . " JOIN tbl_calko_result b \n"
         . " ON a.ESTI_NO = b.ESTI_NO "
         . " JOIN tbl_member c"
         . " ON a.REG_USER_ID = c.USER_NO"
         . " LEFT OUTER JOIN ( SELECT c.COUNTRY_CODE COUNTRY_CODE, MAX(c.COUNTRY_EN_NAME) COUNTRY_EN_NAME FROM tbl_calko_country c GROUP BY c.COUNTRY_CODE ) d"
         . " ON a.COUNTRY_CODE = d.COUNTRY_CODE"
         . " WHERE a.ESTI_NO = '" . $p_esti_no . "'"
         . " ORDER BY a.REG_DATE desc "
    ;
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
        $country_en_name       = $r->COUNTRY_EN_NAME       ;
        $destination           = $r->DESTINATION           ;
        $sold_to_party         = $r->SOLD_TO_PARTY         ;
        $reg_date              = $r->REG_DATE              ;
        $reg_user_id           = $r->REG_USER_ID           ;
        $reg_user_email        = $r->REG_USER_EMAIL        ;
        $specification         = $r->SPECIFICATION         ;
        $state                 = $r->STATE                 ;
        $user_no               = $r->USER_NO               ;
        $user_name             = $r->USER_NAME             ;
        $user_id               = $r->USER_ID               ;
?>
<?
        print 'targetItems["' . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) .
              '-' . $seq . '"] = new copyItem ("' . substr($p_esti_no,0,6) . '-' . substr($p_esti_no,6,5) . '-' . substr($p_esti_no,11) . '",' .
                                                   $seq                   . ' ,' .
                                             '"' . $name_of_client        . '",' .
                                             '"' . $project_name          . '",' .
                                             '"' . $country_en_name       . '",' .
                                             '"' . $destination           . '",' .
                                             '"' . $specification         . '",' .
                                             '"' . $quotation_date        . '",' .
                                             '"' . $calko_stategory[$state]. '",' .
                                             '"' . $sales_in_charge       . '",' .
                                             '"' . $country_code          . '",' .
                                             '"' . $sold_to_party         . '",' .
                                             '"' . $expected_delivery_date. '",' .
                                             '"target"' .
              ');';
    }
    $db->release();
} // end if [op=="get_target_item"]
else if ( $op == "get_target_ui") {
?>
<div style='background-image:url("/v1/img/bkg_steel4.jpg")'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class=tbl style='margin-left:0px; #2B5580;width:700px;'>
        <colgroup>
            <col width='90'  />
            <col width='130' />
            <col width='80'  />
            <col width='130' />
            <col width='90'  />
            <col width='100' />
            <col width=''/>
        </colgroup>
        <thead>
            <tr>
            <th colspan="7" class='title1'>
            ● Copy Taget Search<button style='display:inline;margin-left:770px;font-weight:bold;font-size:7pt;border:1px solid #0000AE;cursor:pointer;background-color:transparent;width:15px;height:20px;text-align:center' onclick='fCloseSearchTarget();' title='Close'>X</button></td>
            </tr>

            <tr>
            <td colspan="7" style='height:0px'><hr /></td>
            </tr>

            <tr>
            <th class=L1><?print xlate('Country')?></td>
            <td class=D1>
<?
$creategory_setup['select'          ] = $r->COUNTRY_CODE;
$creategory_setup['prop_name'       ] = 's_p_country_code';
$creategory_setup['title'           ] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-All-'  ;
$creategory_setup['script'          ] = " onchange='fChangeCountry($(\"s_p_country_code\"),$(\"s_p_destination\"));'". " set='" . $r->COUNTRY_CODE .  "'"; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$countrys['setup'] = $creategory_setup;
echo createGory ('SELECT', $countrys);
?>
            </td>
            <td class=L1><?print xlate('Destination')?></td>
            <td class=D1>
<?
$creategory_setup['select'          ] = $r->DESTINATION;
$creategory_setup['prop_name'       ] = 's_p_destination';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " onchange='fChangeCountry($(\"s_p_country_code\"),$(\"s_p_destination\"));'". " set='" . $r->DESTINATION .  "'"; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$destinations['setup'] = $creategory_setup;
echo createGory ('SELECT', $destinations);
?>
            </td>

            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
            <tr>
            <td class=L1><?print xlate('Sales in Charge')?></td>
            <td class=D1>
            <?php print "<input type=text id=s_p_sales_in_charge maxlength=10 autocomplete=off value='" . $sales_in_charge ."'>";?>
            </td>

            <td class=L1><?print xlate('Project Name')?></td>
            <td class=D1>
            <?php print "<input type=text id=s_p_project_name maxlength=10 value='" . $project_name. "'>";?>
            </td>

            <td class=L1><?print xlate('Name of Client')?></td>
            <td class=D1>
            <?php print "<input type=text id=s_p_name_of_client maxlength=10 value='" . $name_of_client. "'>";?>
            </td>

            <td>
            <?php print "<input type=hidden id=s_p_sold_to_party style='width:85%;border:0px solid #FFFFFF;background-color:transparent' value='" . $r->SOLD_TO_PARTY . "' readonly>";?>
            <button onclick='fTargetSearch();' class=button1 id=copy_button4 disabled>Search</button>&nbsp;

            </td>

            </tr>
            <tr>
            <td class=L1><?print xlate('Quotation Date')?></td>
            <td class=D1 colspan=2>
            <input type="text" readonly class='date' id="s_p_frm_reg_date"
            value='<?=substr(getDateAdd (date('Y-m-d'), 'DAY', -30 ),0,10)?>' style='width:60px'> <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('s_p_frm_reg_date'),'yyyy-mm-dd',this)">
 ~
            <input type="text" readonly class='date' id="s_p_to_reg_date"
            value='<?=date('Y-m-d')?>' style='width:60px'> <img src='../img/date.png'  align='absmiddle' onclick="displayCalendar($('s_p_to_reg_date'),'yyyy-mm-dd',this)">
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            </tr>
        </thead>
        <tbody>
            <tr>
            <td colspan="7" style='height:10px'><hr /></td>
            </tr>
            <tr>
            <td colspan="7" >
            <div id='area_list4_1' style='width:905px;border:0px solid red;text-align:center;vertical-align:middle'></div>
            </td>
            </tr>
        </tbody>
    </table>
</div>
<?
    $db->release();
} // end if [op=="get_target_ui"]
else if ( $op == "get_max_esti_seq") { // 견적번호 조회
    $p_country_code = $_GET['p_country_code'];
    $p_esti_no  = str_replace('-', '', trim($_GET["p_esti_no"])); // p_esti_no
    if ( strlen($p_esti_no) == 13 ) {
        $db->getConnect();
        $sql = "SELECT\n"
             . "    COUNTRY_CODE\n"
             . "FROM tbl_calko_header\n"
             . "WHERE ESTI_NO = '" . $p_esti_no . "'\n"
        ;
        $country_code =$db->get($sql)->COUNTRY_CODE;
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
        $db->release();
    }
?>
<?php
} // end if [op=="display"]
else if ( $op == "copy_exec") {
    $db->getConnect();
    $p_mode = $_GET["p_mode"];
    $p_esti_no      = str_replace('-', '', trim($_GET["p_esti_no"       ])); // p_esti_no
    if (!$p_mode        ) $errors[] = xlate('p_mode is Empty!');
    if (!$p_esti_no     ) $errors[] = xlate('Quotation Number is Empty!');
    $m = 'copy_exec';
    if (empty($errors)) {
        if ( $db->starttransaction() ) {
            if ( ( $p_mode == '1' && $db->count("tbl_calko_header", "ESTI_NO='{$p_new_esti_no}'") == 0 ) ||
                 ( $p_mode == '2' ) ) {
                $savedata = array();
                if      ( !trim($_POST['quotation_date'        ])) $errors[] = xlate('quotation_date is error.'          );
                else if ( !trim($_POST['expected_delivery_date'])) $errors[] = xlate('expected_delivery_date is error.'  );
                else if ( !trim($_POST['sales_in_charge'       ])) $errors[] = xlate('sales_in_charge is error.'         );
                else if ( !trim($_POST['name_of_client'        ])) $errors[] = xlate('name_of_client is error.'          );
                else if ( !trim($_POST['project_name'          ])) $errors[] = xlate('project_name is error.'            );
                else if ( !trim($_POST['country_code'          ])) $errors[] = xlate('country_code is error.'            );
                else if ( !trim($_POST['destination'           ])) $errors[] = xlate('destination is error.'             );
                else if ( !trim($_POST['sold_to_party'         ])) $errors[] = xlate('sold_to_party is error.'           );
                $l = sizeof($_POST['p_copy_esti_no']);
                $whereCopy = array();
                for ( $i=0;$i<$l; $i++) {
                    $whereCopy[] = " ( ESTI_NO = '" . $_POST['p_copy_esti_no'][$i] . "' AND SEQ = '" . $_POST['p_copy_seq'][$i] . "' )";
                }
                if ( $p_mode == '1' && empty($errors)) {
                    $savedata['ESTI_NO'                ] = "'" . $p_esti_no                       . "'";
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
                $sSeq = 0;
                if ( $p_mode == '1' ) {
                    $sSeq = 0;
                } else if ( $p_mode == '2' ) {
                    $sql = "SELECT \n"
                         . "  MAX(SEQ) SEQ\n"
                         . " FROM tbl_calko_result \n"
                         . " WHERE ESTI_NO = '" .$p_esti_no . "'"
                    ;
                    $sSeq = $db->get($sql)->SEQ;
                    $sSeq = $sSeq?$sSeq:1;
                }

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
                         . "  ''            ,". "\n"
                         . "  ''            ,". "\n"
                         . "  ''            ,". "\n"

                         . "  0             ,". "\n"
                         . "  0             ,". "\n"

                         . "  now()         ,". "\n"
                         . "  now()         ,". "\n"
                         . "  '0000-00-00 00:00:00',". "\n"
                         . "  '0000-00-00 00:00:00',". "\n"
                         . "  '0000-00-00 00:00:00',". "\n"

                         . "  ''            ,". "\n"
                         . "  '3'           ,". "\n" // CRC 수신
                         . "  0.0           ,". "\n"
                         . "  0.0           ,". "\n"
                         . "  0.0           ,". "\n"

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
else if ( $op == "del_exec") {
    $db->getConnect();
    $l = sizeof($_POST['p_del_esti_no']);
    $whereDelete = array();
    $updateEstiNo = array();
    for ( $i=0;$i<$l; $i++) {
        $whereDelete[] = " ( ESTI_NO = '" . $_POST['p_del_esti_no'][$i] . "' AND SEQ = '" . $_POST['p_del_seq'][$i] . "' )";
        $updateEstiNo[$_POST['p_del_esti_no'][$i]] = "'" . $_POST['p_del_esti_no'][$i] . "'";
    }

    if (!empty($whereDelete)) {
        if ( $db->starttransaction() ) {
            $sql = " DELETE FROM tbl_calko_result"
                 . " WHERE ( " . join(' OR ',$whereDelete) . " )"
                 . " AND   STATE <= '3'"
            ;
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
                    . "     WHERE ESTI_NO in ( " . join(",",$updateEstiNo) . " )"
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
                 . " WHERE a.ESTI_NO IN ( " . join(",",$updateEstiNo) . " )" . "\n"
                 . " GROUP BY a.ESTI_NO" . "\n"
                 . " HAVING COUNT(b.ESTI_NO) = 0" . "\n"
                 . " ORDER BY b.SEQ ASC" . "\n"
                 . " ) t" . "\n"
                 . " ON  a.ESTI_NO = t.ESTI_NO" . "\n"
                 . " AND a.STATE <= '3'\n"
            ;
            if ( !$db->exec($sql) ) {
                $errors[] = xlate('tbl_calko_header TABLE 0 row data delete failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
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
    } else {
        $errors[] = xlate('Delete Information is Empty!');
    }

    if (!empty($errors)) print ('ERROR|'   . $m . '|' . $p_esti_no  . '|' . implode($errors, "<BR>"));
    else                 print ('SUCCESS|' . $m . '|' . $p_esti_no  . '|' . '');


    $db->release();
?>
<?
} // end if [op=="del_exec"]
} // end grant
} // end login
?>