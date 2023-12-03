#TITLE=php_tkek
#INFO
New Cliptext library
#SORT=n

#T=HTML_테스트템플릿
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<SCRIPT src='http://localhost/service/common/js/softm.js.php'></SCRIPT>
</HEAD>

<BODY onmousemove='fTooltip(event);' onmouseout='fTooltip(event);'>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<BR>
<SCRIPT LANGUAGE="JavaScript">
<!--
function fTooltip(e) {
    var eO = window.event?window.event:e;
    var o = document.getElementById('tool_tip');
    o.style.left = parseInt(eO.clientX,10);
    o.style.top  = parseInt(eO.clientY,10);
    o.innerHTML +=  '1';
}
//-->
</SCRIPT>
<span id=tool_tip style='position:absolute;width:100px;height:100px;border:1px solid red'>

</span>
</BODY>
</HTML>

#T======== Javascript =======
======= Javascript =======
#T=$JS["exec"][] = "
    $JS["exec"][] = "
        alert('exec');
    ";
#T=$JS["onload"][] = "
    $JS["onload"][] = "
        alert('');
        showTab(1);
        ";
#T======== PHP TEMPLATE =========
======= PHP TEMPLATE =========
#T=기본_레이아웃
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

<SCRIPT LANGUAGE="JavaScript">
<!--
    var _url = '<?print $_SERVER['PHP_SELF']?>';
    var editData = false;

    window.onload = function() {
        Util.Load.script({src:"calko_write.css",type:'css'});
        try {

        } catch (e){}
        Util.Load.script({src:'calko_write.js',type:'js',callback:function(){
        }});

    }

    window.onunload = function() {
        if ( editData ) {
            //
        }
    }

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
            <col width='180'/>
            <col width='40'/>
            <col width='80'/>
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
            <td style='text-align:center'><?php print html_xlate("Esti No"); ?></td>
            <td>&nbsp;<?php print "<input type=text name=s_esti_no id=s_esti_no style='width:90%;ime-mode:active' maxlength=15 autocomplete=off value='" . substr($default_esti_no,0,6) . '-' . substr($default_esti_no,6,5) . '-' . substr($default_esti_no,11) . "'>";?></td>
            <td align=center><?php print html_xlate("Seq"); ?></td>
            <td width='100'>&nbsp;<?php print "<input type=text name=s_seq id=s_seq style='width:70%;ime-mode:active;text-align:center' maxlength=15 size='3' autocomplete=off value='1'>";?></td>
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
else if ( $op == "search") { // 조회

    $db->release();
} // end if [op=="get_option_list"]
} // end grant
} // end login
?>

#T=tkek_수정기본 템플릿
else if ( $op == "모드") {
    $p_esti_no = trim($_GET["p_esti_no"]); // 견적번호
    $errors = array();
    if ( $p_esti_no ) {
        $db->getConnect();

/*
        $sql = "SELECT 'a' ";
        $r = $db->get($sql);
        $country_code= $r->COUNTRY_CODE ;
*/
        if ( $db->starttransaction() ) {
            $sql = " UPDATE"
                    . " tbl "
                    . " SET "
                    . " f1 = '" . ."'"
                    . " WHERE 1 = 0 "
            ;

            if ( !$db->exec($sql) ) {
                $errors[] = xlate('tbl TABLE 0 row data update failure') . $db->getErrMsg() . ' / ' . $db->getLastSql();
            }


            if ( !empty($errors) ) {
                $errors[] = xlate('Transaction Rollback.');
                $db->rollback();
            } else {
                if ( $db->commit() ) {
                } else {
                    $errors[] = xlate('Data Not Valid!');
                }
            }
        } else {
            $errors[] = xlate('Start Transaction Error');
        }
        $db->release();
    }

    if (!empty($errors)) print ('ERROR|'   . $m . '|' . $p_esti_no  . '|' . implode($errors, "<BR>"));
    else                 print ('SUCCESS|' . $m . '|' . $p_esti_no  . '|' . '');
} // 모드
#T========== Form ==========
========= Form ==========
#T=html_xlate("Coordinates");
html_xlate("^!");
#T=dropbox("frm_timezone", $timezone_options)
dropbox("frm_timezone", $timezone_options)
#T=textbox("frm_city", "size:=25, class:=ml","")
textbox("frm_city", "size:=25, class:=ml","")
#T=<?php print submitbutton("op", "onclick:=return restrictions.report();", "Save"); ?>
<?php print submitbutton("op", "onclick:=return restrictions.report();", "Save"); ?>
#T=<?php print button("", "onclick='fGetList(1);'", xlate("SEARCH"))?>
<?php print button("", "onclick='fGetList(1);'", xlate("SEARCH"))?>
#T=<?php print button("", "onclick='fGetWrite();'", xlate("New"))?>
<?php print button("", "onclick='fGetWrite();'", xlate("New"))?>
#T=<?php print dateChooser("frm_f6","disabled=\"disabled\", size:=8"); ?>
<?php print dateChooser("frm_f6","disabled=\"disabled\", size:=8"); ?>
#T=<?php print button("test", "onclick='alert();' style='background-color:red'", "test!!")?>
<?php print button("test", "onclick='alert();' style='background-color:red'", "test!!")?>
#T=<?php print listbox("frm_f3", array("1" => "v1","2" => "v2","3" => "v3"), "", $f3); ?>
<?php print listbox("frm_f3", array("1" => "v1","2" => "v2","3" => "v3"), "", $f3); ?>
#T=<?php print dateChooser("s_quotation_date","disabled=\"disabled\" class='date', size:=5 value='" . date('y-m-d') . "'"); ?>
<?php print dateChooser("s_quotation_date","disabled=\"disabled\" class='date', size:=5 value='" . date('y-m-d') . "'"); ?>
#T========= databse ==========
======== databse ==========
#T=$db = new DB (); // db instance
$db = new DB (); // db instance

#T=print createGory ('SELECT', $code_of_fireman_liftgory);
<?
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 'cc_tv';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " set='" . getXValue('cc_tv',$x) . "' class='select_basic'"  ; // 스크립트
$cc_tvgory['setup'] = $creategory_setup;
print createGory ('SELECT', $cc_tvgory);
?>
#T=    $db->getConnect();
    $db->getConnect();
#T=    $db->release();
    $db->release();
#T=    $db->getLastSql()
$db->getLastSql()
#T=    $db->getErrMsg()
$db->getErrMsg()
#T=$db->count("user", "Username = {$savedata['username']}")
$db->count("user", "Username = {$savedata['username']}")
#T=&$db->get($sql)
$max_esti_seq =&$db->get($sql)->ESTI_SEQ
#T=$db->quote(^!)
$db->quote(^!)
#T=$db->exec("UPDATE " . MY_TABLE . " SET USE_YN = 'N'","조건절");
        $sRtn = $db->exec("UPDATE " . MY_TABLE . " SET USE_YN = 'N'","조건절");

#T======== etc =========
======= etc =========
#T=$_COOKIE["saveusername"]
$_COOKIE["saveusername"]
#T=$_SESSION["currentuserid"]
$_SESSION["currentuserid"]
#T=$currentuser->id
$currentuser->id
#T=$currentuser->Type
$currentuser->Type
#T=---------- deined--------------- 
define("PAGE_TITLE"             , "Login"   );  // 페이지 제목
define('NO_USER_REQUIRED'       , true      );  // 로그인 검사 여부
define('NO_CLOSE_SESSION'       , TRUE      );  // 세션?
define('NO_PERMISSION_REQUIRED' , true      );  // 권한 검사 여부
#T=define('NO_PERMISSION_REQUIRED' , true      );  // 권한 검사 여부
define('NO_PERMISSION_REQUIRED' , true      );  // 권한 검사 여부
#T=define('NO_USER_REQUIRED'       , true      );  // 로그인 검사 여부
define('NO_USER_REQUIRED'       , true      );  // 로그인 검사 여부
#T====================================
===================================
#T=localurl($txt, $href="#", $onclick="")
localurl($txt, $href="#", $onclick="")
#T= $JS["onload"  ][] = "window.top.showError(".toJavascript
                $JS["onload"  ][] = "window.top.showError(".toJavascript(xlate("The following errors occured")).", '" . implode($errors, "', '") . "');";
                $JS["onunload"][] = "window.top.hideError();\n";

#T====================================
===================================
#T=echo 'test :' . $test . '<BR>';
echo 'test :' . $test . '<BR>';
#T=echo 'sql :' . $sql . '<BR>';
echo 'sql :' . $sql . '<BR>';
#T= value='<?print $x->lift_nos?>'
 value='<?print $x->lift_nos?>'
#T========================
================
#T=<?print xlate('^!')?>
<?print xlate('^!')?>
#T=<span class=title>^!</span>
<span class=title>^!</span>
#T=<SELECT NAME="">
            <SELECT NAME="">
                <OPTION VALUE="EleXess I" SELECTED>EleXess I
            </SELECT>
#T=<INPUT TYPE="text" NAME="" class='input_t'>
            <INPUT TYPE="text" NAME="" class='input_t'>

#T=<div style='width:250px;overflow:hidden' class='textOf'><nobr></nobr></div>
<div style='width:250px;overflow:hidden' class='textOf'><nobr></nobr></div>
#T=로우
        <tr>
            <td class='l_item_1'>Quotation No.& Country: </td>
            <td class='d_item_1'>
            <SELECT NAME="">
                <OPTION VALUE="AO080900001-Angola" SELECTED>AO080900001-Angola
                <OPTION VALUE="BG080900001-Bulgaria">BG080900001-Bulgaria
            </SELECT>
            </td>
            <td class='d_item_1'>&nbsp;</td>
            <td class='l_item_1'>City: </td>
            <td class='d_item_1'>
            <SELECT NAME="">
                <OPTION VALUE="HOCHIMINH" SELECTED>HOCHIMINH
                <OPTION VALUE="Irkutsk">Irkutsk
            </SELECT>
            </td>
            <td class='d_item_1'>&nbsp;</td>
        </tr>
#T=test.html
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<!-- saved from url=(0062)https://krdev.fos.tkeasia.com/safety/tkek_fos/sample_list.php? -->
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD><TITLE>Thyssenkrupp</TITLE>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<LINK href="/favicon.ico" rel="shortcut icon">
<LINK href="./style.css" type=text/css rel=stylesheet>
<LINK href="lib_inc/style.css" type=text/css rel=stylesheet>
<LINK media=print href="lib_inc/style_print.css" type=text/css rel=stylesheet>
<STYLE type=text/css>
BODY {
    FONT-SIZE: 0.68em
}
</STYLE>

<STYLE type=text/css>
.mainnav TH {
    FONT-WEIGHT: bold; BACKGROUND-COLOR: red! important
}
.mainnav TD {
    FONT-WEIGHT: bold; BACKGROUND-COLOR: red! important
}
TD.mainnavon {
    BACKGROUND-COLOR: #ffcc33! important
}
TD.dev-server {
    TEXT-ALIGN: center
}
</STYLE>
<!--[if lte IE 6]>
<STYLE type=text/css>.sysnotif {

}
</STYLE>
<![endif]--><!--[if IE]>
<STYLE type=text/css>DIV.popupchooser {
    FILTER: alpha(opacity = 95)
}
</STYLE>
<![endif]-->

<SCRIPT language=Javascript1.2 src="lib_inc/js/tke.js" type=text/javascript></SCRIPT>
<SCRIPT language=Javascript1.2 src="lib_inc/js/json2.js" type=text/javascript></SCRIPT>
<SCRIPT language=Javascript1.2 src="lib_inc/js/asyncConnector.js" type=text/javascript></SCRIPT>
<SCRIPT language=Javascript1.2 src="lib_inc/js/loadingDisplay.js" type=text/javascript></SCRIPT>

<SCRIPT language=Javascript1.2 src="lib_inc/js/ngcore.js" type=text/javascript></SCRIPT>
<SCRIPT language=Javascript1.2 src="lib_inc/js/ngevent.js" type=text/javascript></SCRIPT>
<SCRIPT language=Javascript1.2 src="lib_inc/js/general.js" type=text/javascript></SCRIPT>
<SCRIPT language=Javascript1.2 src="lib_inc/js/misc.php" type=text/javascript></SCRIPT>
<SCRIPT language=Javascript1.2 src="lib_inc/js/nogginmenus.js" type=text/javascript></SCRIPT>
<SCRIPT language=Javascript1.2 src="lib_inc/js/ngcalendar.js" type=text/javascript></SCRIPT>

<META content="MSHTML 6.00.2900.5848" name=GENERATOR></HEAD>
<BODY onload='showTab(1);'>
<TABLE class=logomast cellSpacing=0 cellPadding=0 width="100%" align=center
border=0>
<TBODY>
<TR>
<TD vAlign=top width="39%"><IMG height=30
alt="Thyssenkrupp Elevator Korea" hspace=4
src="lib/thyssenkrupp_korea.gif" width=325 vspace=4>
</TD>
<TD align=right width="50%">
<TABLE class=stateselect cellSpacing=0 cellPadding=0 border=0>
<TBODY></TBODY></TABLE></TD>
<TD align=right width="11%"><IMG height=50 alt="ThyssenKrupp Logo"
hspace=7 src="lib/thyssenkrpp_logo.jpg" width=51
vspace=4></TD></TR></TBODY></TABLE><!-- end logo mast --><!-- begin mainnav -->
<TABLE class=mainnav cellSpacing=0 cellPadding=0 width="100%" align=center
border=0>
<TBODY>
<TR>
<TH width="3%"><A
href="https://krdev.fos.tkeasia.com/safety/tkek_fos/">H</A></TH>
<TD width="67%">
<TABLE cellSpacing=0 cellPadding=0 width="100%" border=0>
<TBODY>
<TR>
<TD width="1%">
<TABLE id=mynav cellSpacing=0 cellPadding=0 border=0>
<TBODY>
<TR></TR></TBODY></TABLE></TD>
<TD class=dev-server>TKE Devel Server, Last Import 09/08/25 04:01
HKT (+0800)</TD></TR></TBODY></TABLE></TD>
<TD width="20%">
<TABLE id=mainnav cellSpacing=0 cellPadding=0 border=0>
<TBODY>
<TR></TR></TBODY></TABLE></TD>
<TD width="10%"><A onclick=logout();
href="https://krdev.fos.tkeasia.com/logout.php">로그
아웃</A></TD></TR></TBODY></TABLE><!-- begin mainnav --><!-- begin subnav -->
<TABLE class=subnav cellSpacing=0 cellPadding=0 width="100%" align=center
border=0>
<TBODY>
<TR>
<TD noWrap width="10%">&nbsp;</TD>
<TD width="80%">
<TABLE id=subnav cellSpacing=0 cellPadding=0 border=0>
<TBODY>
<TR></TR></TBODY></TABLE></TD>
<TD style="TEXT-ALIGN: left" width="10%"><A style="CURSOR: help"
onclick="NG.popup('https://onlinedocsdev.fos.tkeasia.com/?permissionid=&amp;currentlanguage=ko&amp;currentuserid=&amp;returnurl=http://krdev.fos.tkeasia.com/safety/tkek_fos/sample_list.php', 1024, 690);"
href="https://krdev.fos.tkeasia.com/safety/tkek_fos/sample_list.php?#">Help
</A></TD></TR></TBODY></TABLE><!-- end subnav --><!-- begin location indicator -->
<TABLE cellSpacing=0 cellPadding=0 width="100%"
background=lib/bkg_steel5.jpg border=0>
<TBODY>
<TR>
<TD style="BORDER-TOP: 1px inset; VERTICAL-ALIGN: top" width="65%"
background='lib/bkg_steel4.jpg'>
<TABLE class=langsel cellSpacing=0 cellPadding=0>
<TBODY>
<TR>
<TH><IMG height=18 alt=""
src="lib/langsel_cap.png" width=22></TH>
<TD><IMG height=18 alt="" src="lib/1px.gif"
width=10></TD>
<TD><A class=sel onclick="return changeLanguage('en');"
href="https://krdev.fos.tkeasia.com/safety/tkek_fos/sample_list.php?#">English</A></TD>
<TD><IMG height=4 alt=""
src="lib/langsel_sep.png" width=16></TD>
<TD class=sel>한국어</TD>
<TD><IMG height=18 alt="" src="lib/1px.gif"
width=20></TD></TR></TBODY></TABLE></TD>
<TD class=locationtab noWrap width="20%">| </TD>
<TD style="BORDER-TOP: 1px inset" width="15%"
background=lib/bkg_steel4.jpg>&nbsp;</TD></TR></TBODY></TABLE><!-- end location indicator --><!-- begin confirm cell -->

<STYLE type=text/css>
    /* list table */
    .tbl          { border:0px solid gray;width:600px;margin:10px 0px 10px 10px;padding:1px 1px 1px 1px }
    .tbl *        { font-size:8pt;font-family:'맑은 고딕';}

    .tbl td       { height:20px;padding-left:3px;}
    .tbl td.L1    { color:#000000; font-weight:bold; padding-left:3px; }
    .tbl td.D1    { color:#000000; }

    .tbl td input     { color:#000000;background-color:#FFFFFF;width:94%;height:13px;border:0;}
    .tbl td select    { color:#000000;background-color:#FFFFFF;width:98%;height:20px }

    .tbl th { border-bottom:1px solid #999999;border-left:1px solid #999999;border-top:1px solid #999999;text-align:left;padding-left:3px;
              height:23px;}
    .tbl td { border-bottom:1px solid #999999;border-left:1px solid #999999;}

    .tbl .even_row td {background-color: #c0c0c0    } /* 짝수 */
    .tbl .odd_row  td {background-color: transparent} /* 홀수 */
</STYLE>
<SCRIPT LANGUAGE="JavaScript">
<!--
    function  fOpenSpecWrite() {
        var w = openWindow("calko_get_class.html", 900, 700,'winSpecInterface');
    }
//-->
</SCRIPT>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class=tbl>
    <colgroup>
        <col width='20%'/>
        <col width='20%'/>
        <col width='20%'/>
        <col width='20%'/>
        <col width='20%'/>
    </colgroup>
    <thead>
    <tr>
    <th style='border-left :0;'>Class Name</th>
    <th>111111111111</th>
    <th>111111111111</th>
    <th>111111111111</th>
    <th>111111111111</th>
    </tr>
    </thead>
    <tbody>
    <tr class=odd_row>
    <td style='border-left :0;'>111111111111</td>
    <td>111111111111</td>
    <td>111111111111</td>
    <td>111111111111</td>
    <td>111111111111</td>
    </tr>
    <tr class=even_row>
    <td style='border-left :0;'>111111111111</td>
    <td>111111111111</td>
    <td>111111111111</td>
    <td>111111111111</td>
    <td>111111111111</td>
    </tr>
    </tbody>
</table>

</BODY>
</HTML>

#T========================
=======================
#T=tabcontent
<script language="Javascript1.2" type="text/javascript" src="lib_inc/js/tabcontent/tabcontent.js">
/***********************************************
* Tab Content script v2.2- ⓒ Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code

* http://www.dynamicdrive.com/dynamicindex17/tabcontent.htm
***********************************************/
</script>
<link rel=stylesheet href='lib_inc/js/tabcontent/tabcontent.css' type='text/css'>
#T=function caller
        var callerFunc = arguments.callee.caller.toString();
        callerFuncName = (callerFunc.substring(callerFunc.indexOf("function") + 8, callerFunc.indexOf("(")) || "anoynmous")

        return callerFuncName;
#T=input mask
<script language="Javascript1.2" type="text/javascript" src="lib_inc/js/masks.js"></script>
#T========================
=======================
#T=Ajax Coding[Javascript]
            var url  = _url;
            ajaxR.openCallBack= function (str) {
//                alert( ajaxR.responseText() );
                var info = ajaxR.responseText().split('|');
                var s = info[0];
                var m = info[1];
                var k = info[2];
                var msg = info[3];
                //alert( s +'\n' + m+'\n' + k  );
                if (s == 'SUCCESS') { // success
                    alert(pMsgStr);
                    if      ( m == 'I' ) {
                        fSetActiveRow(1,k);
                        fGetList(1);
                    }
                    else if ( m == 'U' ) fGetList(_s);//fGetWrite('U',k);
                } else if (s == 'ERROR') {
                    alert(info[3]); // error
                }
            }
            ajaxR.form = $('wForm');
            lm = (lm?lm:'I');
            var params = 'op=save_exec'
                       + '&m=' + lm
                       + ($('wForm').k1.value?'&k=' + $('wForm').k1.value:'')
                       + '&' + ajaxR.getQueryString();
            //alert( params );
            ajaxR.httpOpen('POST', url, true,params, null);
#T=        <tr><td class='i1 bs'>1</td><td class='i2 ld bs' >2</td><td class='i3 ld rs bs'>3&nbsp;</td><td class='i4 rd bs'>4&nbsp;</td><td class='i5 bs'>5&nbsp;</td><td class='i6 ld bs'>6&nbsp;</td></tr>
        <tr><td class='i1 bs'>1</td><td class='i2 ld bs' >2</td><td class='i3 ld rs bs'>3&nbsp;</td><td class='i4 rd bs'>4&nbsp;</td><td class='i5 bs'>5&nbsp;</td><td class='i6 ld bs'>6&nbsp;</td></tr>

#T=$('msg').value += condStr;
$('msg').value += rT + ' / ' + rL;
#T= set='<?print $x->E5006?>'
 set='<?print $x->E5006?>'
#T=Util.Load.script({src:'calko_write.php?op=gen_clc_data&p_esti_no=' + k + '&p_seq=' + s,type:'js'});
Util.Load.script({src:'calko_write.php?op=gen_clc_data&p_esti_no=' + k + '&p_seq=' + s,type:'js'});

#T=-- Filrebug console API ----------------------------------------------------
-- Filrebug console API ----------------------------------------------------
#T=try .. catch.. console.debug
            try {
^!
            }catch(e){
                console.debug(e);
            }
#T=console.debug(object[, object, ...])
console.debug(^!);
#T=console.info(object[, object, ...])
console.info(^!)
#T=console.trace();
console.trace();
#T=console.warn(object[, object, ...])
console.warn(^!)
#T=console.error(object[, object, ...])
console.error(^!)
#T=console.assert(expression[, object, ...])
console.assert(expression[, object, ...])
#T=console.dir(object)
console.dir(object)
#T=console.dirxml(node)
console.dirxml(node)
#T=console.trace()
console.trace()
#T=console.group(object[, object, ...])
console.group(^!)
#T=console.groupCollapsed(object[, object, ...])
console.groupCollapsed(^!)
#T=console.groupEnd()
console.groupEnd()
#T=console.time(name)
console.time(name)
#T=console.timeEnd(name)
console.timeEnd(name)
#T=console.profile([title])
console.profile([title])
#T=console.profileEnd()
console.profileEnd()

#T=-- Filrebug commandline API ----------------------------------------------------
-- Filrebug commandline API ----------------------------------------------------
#T=$(id)
$(id)
#T=$$(selector)
$$(selector)
#T=$x(xpath)
$x(xpath)
#T=dir(object)
dir(object)
#T=dirxml(node)
dirxml(node)
#T=cd(window)
cd(window)
#T=clear()
clear()
#T=inspect(object[, tabName])
inspect(object[, tabName])
#T=keys(object)
keys(object)
#T=values(object)
values(object)
#T=debug(fn)
debug(fn)
#T=undebug(fn)
undebug(fn)
#T=monitor(fn)
monitor(fn)
#T=unmonitor(fn)
unmonitor(fn)
#T=monitorEvents(object[, types])
monitorEvents(object[, types])
#T=unmonitorEvents(object[, types])
unmonitorEvents(object[, types])
#T=profile([title])
profile([title])
#T=profileEnd()
profileEnd()





#