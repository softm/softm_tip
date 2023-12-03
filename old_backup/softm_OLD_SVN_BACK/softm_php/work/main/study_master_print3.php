<?
/*
 Filename       : /calko/calko_print.php
 Fuction        : 견적서작성 - Print
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

require_once '../inc/calko.lib'         ; // calko.lib
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

if ( $memInfor['login_yn'] != 'Y' ) {
    redirectPage( "/" );
} else {
if ( !$grant[$_SERVER['PHP_SELF']][$memInfor[user_level]] ) {
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
    $s_yyyy = $_GET["s_yyyy"]; // s_yyyy
    $s_term  = $_GET["s_term"]    ; // s_term
    $s_gubun  = $_GET["s_gubun"]    ; // s_gubun
    $s_mem_name  = $_GET["s_mem_name"]    ; // s_mem_name

    require_once '../inc/inner_header.php'   ; // header
?>
<link type="text/css" rel="stylesheet" href="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<SCRIPT type="text/javascript" src="<?=SERVICE_DIR?>/common/js/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<SCRIPT type="text/javascript" src="<?=SERVICE_DIR?>/common/js/masks.js"></script>
<link rel=stylesheet href='calko_print.css' type='text/css'>

<SCRIPT LANGUAGE="JavaScript">
<!--
    var _info = {};
    var _url = '<?print $_SERVER['PHP_SELF']?>';
    var s_yyyy  = '<?print $s_yyyy;?>';
    var s_term  = '<?print $s_term;?>';
    var s_gubun = '<?print $s_gubun;?>';
    var s_mem_name = '<?print $s_mem_name;?>';

    function fGetDefaultUI(s) {
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = _url;
        ajaxR.openCallBack= function (str) {
            ajaxR.dataArea.innerHTML = ajaxR.responseText();
            loading.hide();
            $('area_list' ).style.display = 'inline' ;
            $('area_write').style.display = 'none'   ;

            //fPrint();
        }

        var params = 'op=get_default_ui'
                   + '&s_yyyy=' + s_yyyy
                   + '&s_term=' + s_term
                   + '&s_gubun='+ s_gubun
                   + '&s_mem_name='+ s_mem_name
        ;

        ajaxR.httpOpen('POST', url, true,params, $("area_list"));
        _s = s;
        loading.show(document.documentElement);
        loading.setPos(0,'100px');
    }

    var accounting_year = '<?=ACCOUNTING_YEAR?>';
    function fClose() {
        if (confirm('Do you want to close the window?')) {
            window.close();
        }
    }

    function fPrint() {
        var preCheckNum = 0;
        //alert( Util.Browser.msie );
        if (Util.Browser.msie) {
            if ($("factory").printing == undefined) {
                alert("웹 브라우저 상단의 컨트롤 설치창을 확인하여 주시기 바랍니다.");
                return;
            }
            $("factory").printing.header       = "";
            $("factory").printing.footer       = "";
            $("factory").printing.portrait     = true;   // true 세로출력 , false 가로출력
            $("factory").printing.leftMargin   = 6;
            $("factory").printing.topMargin    = 10;
            $("factory").printing.rightMargin  = 0;
            $("factory").printing.bottomMargin = 0;
            //factory.printing.paperSize = 'A4';   // 용지 사이즈
            //factory.printing.Print(true, window ) // 대화상자 표시여부 / 출력될 프레임명
            $("factory").printing.Preview();       // 미리보기
        } else {
            if ( confirm("출력하시겠습니까?") ) {
                window.print();
            }
        }

    }

    window.onload = function() {
        document.title = s_yyyy + "년 " + s_term + "학기" + ( s_gubun =='1'?"중간":"기말" ) + "성적표";
        fGetDefaultUI();
        self.focus();
    }

//-->
</SCRIPT>
<body SCROLL=yes>
<style>
body { background:none ;}
.a_tbl          { border:1px solid black;margin-left:0px;table-layout:fixed} /**/
</style>

<style type="text/css" media="print">
<!--
.breakBefore{page-break-before:always;}
.breakAfter{page-break-after:always;}
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
-->
</style>

<span id='area_list'></span>
<span id='area_write'></span>
<SCRIPT LANGUAGE="JavaScript">
<!--
var loading = new loadingDisplay('<?=SERVICE_DIR?>/common/js/ajax-loader.gif','image');
    loading.show();
    loading.setTarget(document.documentElement);
    loading.setSize('80px','10px');
    Util.Load.script({src:"study_master_print3.css",type:'css'});
//-->
</SCRIPT>
<?
    require("../inc/footer.php"); // footer
} // end if [op=="default"]
else if ( $op == "get_default_ui") { //
    $p_esti_no  = str_replace('-', '', trim($_POST["p_esti_no"])); // p_esti_no
    $p_seq      = (int) $_POST["p_seq"]                          ; // p_seq
?>
<object id=factory style="display:none"
classid="clsid:1663ed61-23eb-11d2-b92f-008048fdd814"
codebase="/service/common/js/smsx.cab#Version=6,5,439,50">
</object>
<form id="sForm" method="POST" target="" onsubmit="return fGetList(1);" action="/safety/tkek_fos/calko_write.php">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style='padding:3px 3px 3px 3px'>
    <tr>
    <td width="100%" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='55%'/>
            <col width='20%'/>
            <col width='25%'/>
        </colgroup>
        <thead>
            <tr>
            <th>Print</th>
            <th style='text-align:right;padding:5px 5px 5px 5px'>


            </th>
            <th style='text-align:right;padding:5px 5px 5px 5px'><button onclick='fPrint();return false;' class=button1>print</button>&nbsp;<button onclick='fClose();return false;' class=button1>close</button></th>
            </tr>
        </thead>
    </table>
    </td>
    </tr>
</table>
</form>
<TABLE width='100%' border=0 style='table-layout:fixed'>
<colgroup>
<col width=''>
<col width=52>
</colgroup>
<tbody>
<?
    $totCnt=0;

    $db->getConnect();
    $wheres  = array();
    $wheres[] = " USER_NO= '" . $memInfor[user_no] . "'";
    if ( $_POST[s_yyyy  ] ) $wheres[] = " YYYY  = '" . $_POST[s_yyyy  ] . "'";
    if ( $_POST[s_term  ] ) $wheres[] = " TERM  = '" . $_POST[s_term  ] . "'";
    if ( $_POST[s_gubun ] ) $wheres[] = " GUBUN = '" . $_POST[s_gubun ] . "'";
    $where = join(' AND ',$wheres);

    $sql = "SELECT"
         . " AVG(RESULT_1) AVG1, "
         . " AVG(RESULT_2) AVG2, "
         . " SUM(RESULT_1) SUM1, "
         . " SUM(RESULT_2) SUM2 "
         . " FROM eun_ju_study_master \n"
         . " WHERE 1 \n"
    ;
    $sql .= " AND " . $where;

    $r = $db->get($sql);
    $avg1     = round($r->AVG1,2);
    $avg2     = round($r->AVG2,2);
    $sum1     = $r->SUM1;
    $sum2     = $r->SUM2;

    $sql = "SELECT \n"
         . "  VAL5   , \n"
         . "  USER_NO  \n"
     . " FROM eun_ju_study_setup \n"
         . " WHERE USER_NO = '" . $memInfor[user_no] . "'\n"
    ;
    $r_avg = $db->get($sql);
    $val5 = $r_avg->VAL5;

    $mSql = "SELECT \n"
         . "  a.S_ID          S_ID    , \n"
         . "  a.YYYY          YYYY    , \n"
         . "  a.TERM          TERM    , \n"
         . "  a.GUBUN         GUBUN   , \n"
         . "  a.HAK           HAK     , \n"
         . "  a.BAN           BAN     , \n"
         . "  a.NUM           NUM     , \n"
         . "  a.MEM_NAME      MEM_NAME, \n"
         . "  a.RESULT_1      RESULT_1, \n"
         . "  a.RESULT_2      RESULT_2, \n"
         . "  a.REG_DATE      REG_DATE, \n"
         . "  a.CONTENT       CONTENT  \n"
         . " FROM eun_ju_study_master a \n"
         . " WHERE 1 \n"
    ;
    //echo 's : ' . sizeof($wheres) . '<BR>';
    $mSql .= " AND " . $where;
    if ( $_POST[s_mem_name] ) $mSql .= " AND MEM_NAME LIKE '%" . $_POST[s_mem_name] . "%'";
    $mR = $db->get($mSql);
    $yyyy     = $mR->YYYY    ;
    $term     = $mR->TERM    ;
    $gubun    = $mR->GUBUN   ;
    $hak      = $mR->HAK     ;
    $ban      = $mR->BAN     ;
    $num      = $mR->NUM     ;
?>
<tr>
<td colspan=2 style='padding-top:30px'>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style='padding:0px;margin:0px;' align=left>
        <colgroup>
            <col width='100%'/>
        </colgroup>
        <tr>
        <td align=center>
<div class=content style='text-align:center'>
<pre>
<div style='width:100%;font-size:12pt;text-align:left;font-weight:bold;margin-top:10px")?>'><?=$yyyy?>학년도</div>
<div style='width:100%;font-size:20pt;text-align:center;font-weight:bold;margin-top:10px")?>'><?=$term?>학기 <?=$study_gubunegroy[$gubun]?>평가 결과표</div>

<div style='width:100%;font-size:12pt;text-align:center;font-weight:bold;margin-top:10px")?>'> 제 (   <?=$hak?>  ) 학년  (  <?=$ban?>  ) 반                                    담임 : <?
    $teach_name = $memInfor[user_name];
    echo mb_substr($teach_name,0,1, 'UTF-8') . "&nbsp;";
    echo mb_substr($teach_name,1,1, 'UTF-8') . "&nbsp;";
    echo mb_substr($teach_name,2,1, 'UTF-8') . "&nbsp;";
?> (인)</div>
</pre>
<table border="0" cellspacing="0" cellpadding="0">
        <td style='vertical-align:top;padding-top:0px'>
        <table width="355" border="0" cellspacing="0" cellpadding="0" class="a_tbl" style='vertical-align:top;' align=center>
            <colgroup>
                <col width='33'/>
                <col width='52'/>
                <col width='52'/>
                <col width='52'/>
                <col width='52'/>
                <col width='52'/>
                <col width='62'/>
            </colgroup>
            <tr><td class='i1 bs' style='height:40px'>번호</td><td class='i2 ls rs bs'>이름</td><td class='i3 rs bs'>국어</td><td class='i4 rs bs'>수학</td><td class='i5 rs bs'>총점</td><td class='i6 rs bs'>평균</td><td class='i7 bs' style='border-left:0px'>학력<BR>우수교과</td>
            </tr>

<?
    $mStmt = $db->multiRowSQLQuery($mSql . " AND SEX = 'M' ");
    //$mR = $db->get($mSql);
    $cnt = 0;
    while ($mR = $db->multiRowFetch($mStmt)) {
        $s_id     = $mR->S_ID    ;
        $yyyy     = $mR->YYYY    ;
        $term     = $mR->TERM    ;
        $gubun    = $mR->GUBUN   ;
        $hak      = $mR->HAK     ;
        $ban      = $mR->BAN     ;
        $num      = $mR->NUM     ;
        $mem_name = $mR->MEM_NAME;
        $mem_name = $mR->MEM_NAME;
        $result_1 = $mR->RESULT_1;
        $result_2 = $mR->RESULT_2;
        $reg_date = $mR->REG_DATE;
        $content  = $mR->CONTENT ;
/*
        if ( $gubun == '1' ) { // 중간
            $avg1= $r_avg->AVG1;
            $avg2= $r_avg->AVG2;
        } else { // 기말
            $avg1= $r_avg->AVG3;
            $avg2= $r_avg->AVG4;
        }
*/
        $cnt++;
        $totCnt++;
?>
            <tr><td class='i1 bs'><?=$num?></td><td class='ls rs bs'><?=$mem_name?></td><td class='rs bs'><?=$result_1?></td><td class='rs bs'><?=$result_2?></td><td class='rs bs'><?=($result_1 + $result_2)?></td><td class='rs bs'><?=($result_1 + $result_2)/2?></td><td class='bs'><?
if( $result_1 >= 91 ) {
    echo "국";
} 
if( $result_2 >= 91 ) {
    echo ( $result_1 >= 91?", ":"" );
    echo "수";
}
?></td></tr>
<?php
    }
?>
<?
    for ( $i=$cnt;$i<20;$i++) {
?>
            <tr><td class='i1 bs'>&nbsp;</td><td class='i2 ls rs bs'>&nbsp;</td><td class='i3 rs bs'>&nbsp;</td><td class='i4 rs bs'>&nbsp;</td><td class='i5 rs bs'>&nbsp;</td><td class='i6 rs bs'>&nbsp;</td><td class='i7 bs'>&nbsp;</td></tr>

<?
    }
?>
        </table>
        </td>
        <td style='vertical-align:top;padding-top:0px'>
        <table width="355" border="0" cellspacing="0" cellpadding="0" class="a_tbl" style='vertical-align:top;' align=center>
            <colgroup>
                <col width='33'/>
                <col width='52'/>
                <col width='52'/>
                <col width='52'/>
                <col width='52'/>
                <col width='52'/>
                <col width='62'/>
            </colgroup>
            <tr><td class='i1 bs' style='height:40px'>번호</td><td class='i2 ls rs bs'>이름</td><td class='i3 rs bs'>국어</td><td class='i4 rs bs'>수학</td><td class='i5 rs bs'>총점</td><td class='i6 rs bs'>평균</td><td class='i7 bs'>학력<BR>우수교과</td>
            </tr>

<?
    $mStmt = $db->multiRowSQLQuery($mSql . " AND SEX = 'F' ");
    //$mR = $db->get($mSql);
    $cnt = 0;
    while ($mR = $db->multiRowFetch($mStmt)) {
        $s_id     = $mR->S_ID    ;
        $yyyy     = $mR->YYYY    ;
        $term     = $mR->TERM    ;
        $gubun    = $mR->GUBUN   ;
        $hak      = $mR->HAK     ;
        $ban      = $mR->BAN     ;
        $num      = $mR->NUM     ;
        $mem_name = $mR->MEM_NAME;
        $mem_name = $mR->MEM_NAME;
        $result_1 = $mR->RESULT_1;
        $result_2 = $mR->RESULT_2;
        $reg_date = $mR->REG_DATE;
        $content  = $mR->CONTENT ;
/*
        if ( $gubun == '1' ) { // 중간
            $avg1= $r_avg->AVG1;
            $avg2= $r_avg->AVG2;
        } else { // 기말
            $avg1= $r_avg->AVG3;
            $avg2= $r_avg->AVG4;
        }
*/
        $cnt++;
        $totCnt++;
?>
            <tr><td class='i1 bs'><?=$num?></td><td class='ls rs bs'><?=$mem_name?></td><td class='rs bs'><?=$result_1?></td><td class='rs bs'><?=$result_2?></td><td class='rs bs'><?=($result_1 + $result_2)?></td><td class='rs bs'><?=($result_1 + $result_2)/2?></td><td class='bs'><?
if( $result_1 >= 91 ) {
    echo "국";
} 
if( $result_2 >= 91 ) {
    echo ( $result_1 >= 91?", ":"" );
    echo "수";
}
?></td></tr>
<?php
    }
?>
<?
    for ( $i=$cnt;$i<20;$i++) {
?>
            <tr><td class='i1 bs'>&nbsp;</td><td class='i2 ls rs bs'>&nbsp;</td><td class='i3 rs bs'>&nbsp;</td><td class='i4 rs bs'>&nbsp;</td><td class='i5 rs bs'>&nbsp;</td><td class='i6 rs bs'>&nbsp;</td><td class='i7 bs'>&nbsp;</td></tr>

<?
    }
?>
        </table>
        </td>
    </table>
<BR>

        <table width="710" border="0" cellspacing="0" cellpadding="0" class="a_tbl" style='padding:0px;margin:0px;margin-bottom:00px' align=left>
            <colgroup>
                <col width='33'/>
                <col width='55'/>
                <col width='55'/>
            </colgroup>
            <tr><td class='i1 ts bs ls' style='height:30px'>재직</td><td class='i2 ls ts rs bs' colspan=2>(   <?=$val5?>    ) 명</td></tr>
            <tr><td class='i1 bs ls' style='height:30px'>응시인원</td><td class='i2 ls rs bs' colspan=2>(   <?=$totCnt?>    ) 명</td></tr>

            <tr><td class='i1 bs ls' style='height:30px'>과&nbsp;&nbsp;&nbsp;&nbsp;목</td><td class='i2 ls rs bs'>총&nbsp;&nbsp;&nbsp;&nbsp;점</td><td class='i3 rs bs'>평&nbsp;&nbsp;&nbsp;&nbsp;균</td></tr>
            <tr><td class='i1 bs ls' style='height:30px'>국&nbsp;&nbsp;&nbsp;&nbsp;어</td><td class='i2 ls rs bs'><?=number_format($sum1)?></td><td class='i3 rs bs'><?=$avg1?></td></tr>
            <tr><td class='i1 bs ls' style='height:30px'>수&nbsp;&nbsp;&nbsp;&nbsp;학</td><td class='i2 ls rs bs'><?=number_format($sum2)?></td><td class='i3 rs bs'><?=$avg2?></td></tr>
        </table>

</div>

        </td>
        </tr>
    </table>
<?

?>

</td>
</tr>

</tbody>
</TABLE>
<?
    $db->release();
    require("../inc/message_box.php");
} // end if [op=="display"]
} // end grant
} // end login
?>