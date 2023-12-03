<?
/*
 Filename       : /main/main_user.php
 Fuction        : 사용자관리
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
define('MY_TABLE', 'tbl_member');  // session

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
<!--[if IE]>
<style type="text/css">
.textOf {overflow:hidden;text-overflow:ellipsis;}
</style>
<![endif]-->
<script language="Javascript1.2" src="<?=SERVICE_DIR?>/common/js/xml2json.js"></script>
<script language="Javascript1.2" src="<?=SERVICE_DIR?>/common/js/session.js"></script>
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
            try {
            loading.hide();
            var xmlDoc=ajaxR.responseXML();
            var xml  = Util.xml2json(xmlDoc);
            var userLevels = GRID.codeXmlToJson(xmlDoc.getElementsByTagName("userlevel"));
            var userStates = GRID.codeXmlToJson(xmlDoc.getElementsByTagName("userstate"));
            //console.debug(userLevels);
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
                r.style.height='24px';
                var rIdx = r.rowIndex;
                var userNo      = items[i].USER_NO   ;
                var userId      = items[i].USER_ID   ;
                var userName    = items[i].USER_NAME ;
                var userLevel   = items[i].USER_LEVEL;
                var accDate     = items[i].ACC_DATE  ;
                var state       = items[i].STATE     ;
                var c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  userNo +"',event);return false;\" style='" + (state=='S'?'color:red':'color:black') + "'>" + userNo + "</a><input type=hidden name=keys value='" + userNo+ "'>");
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  userNo +"',event);return false;\" style='" + (state=='S'?'color:red':'color:black') + "'>" + userId + "</a>");c.style.textAlign = 'left';c.style.paddingLeft = '4px';
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  userNo +"',event);return false;\" style='" + (state=='S'?'color:red':'color:black') + "'>" + userName + "</a>");c.style.textAlign = 'left';c.style.paddingLeft = '4px';
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  userNo +"',event);return false;\" style='" + (state=='S'?'color:red':'color:black') + "'>" + userLevels[userLevel] + "</a>");
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  userNo +"',event);return false;\" style='" + (state=='S'?'color:red':'color:black') + "'>" + accDate + "</a>");
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fGetWrite('U','" +  userNo +"',event);return false;\" style='" + (state=='S'?'color:red':'color:black') + "'>" + userStates[state] + "</a>");
                    c = GRID.row.addCellByTag(r,"<a href=# onclick=\"fExecDelete('D','" +  userNo +"',event);return false;\" style='" + (state=='S'?'color:red':'color:black') + "'>DELETE</a>");
                    c = GRID.row.addCellByTag(r,'&nbsp;');
            }
            r=tb.insertRow(-1);
            c = GRID.row.addCellByTag(r,(l>0?xml.pagenavi.html:'Data not Found'));
            c.colSpan = th.rows[0].cells.length;
            fActiveRow();
            $('area_list' ).style.display = 'inline' ;
            $('area_write').style.display = 'none'   ;
            }catch(e){
                alert(e);
            }
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
    function changeInput(lm,k,e) {
        var eO = e?document.all?e.srcElement:e.target:null;
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
            try
            {
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
    function fDupCheck() {
        var checkInfo = 아이디검사($('user_id'));
        Alert.show({id:'message_box',message:checkInfo.message,ok:function(){$('user_id').focus();}});
        setTimeout(function(){Alert.hide({id:'message_box'});$('user_id').focus();},1000);
        Effect.twinkle($('user_id'));
    }
    function fExec(lm) {
        var ajaxR = new asyncConnector('xmlhttp');
        var checkInfo = {check:true,message:''};
        var msgStr = '' ;
        var pMsgStr = '' ;

        if (lm == 'I' ) checkInfo = 아이디검사($('user_id'));
        if ( checkInfo.check ) {
            if ( !$('user_name').value.trim() ) {
                checkInfo.check = false;
                checkInfo.message = '이름을 입력하세요.';
                checkInfo.object = $('user_name');
            } else if ( !$('passwd').value.trim() ) {
                checkInfo.check = false;
                checkInfo.message = '비밀번호를 입력하세요.';
                checkInfo.object = $('passwd');
            } else {

            }
        }

        msgStr = '저장하시겠습니까?';
        pMsgStr= '저장되었습니다';

        if ( checkInfo.check ) {
            if ( confirm(msgStr) ) {
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
                           + '&' + ajaxR.getQueryString();
                //alert( url + ' / ' + params );
                ajaxR.httpOpen('POST', url, true,params, null);
            }
        } else {
            Alert.show({id:'message_box',message:checkInfo.message,ok:function(){checkInfo.object.focus();}});
            setTimeout(function(){Alert.hide({id:'message_box'});checkInfo.object.focus();},1000);
            Effect.twinkle(checkInfo.object);
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
            //ajaxR.form = $('wForm');
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
            $('area_list' ).style.display = 'inline'    ;
            $('area_write').style.display = 'none'      ;
        }
    }

    window.onload = function() {
        fGetList(1);
        document.title = "User";
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
            <col width='30' />
            <col width='65' />
            <col width='30' />
            <col width='40' />
            <col width='30' />
            <col width='100'/>
            <col width='70' />
            <col width='70' />
            <col width=''   />
        </colgroup>
        <thead>
            <tr>
            <th colspan="9"><?php print html_xlate("사용자관리"); ?></th>
            </tr>
            <tr>
            <td><?php print html_xlate("분류"); ?></td>
            <td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 's_user_level';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = " id=s_user_level"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $userlevelegory['setup'] = $creategory_setup;
    echo createGory ('SELECT',$userlevelegory);
?>
            </td>

            <td><?php print html_xlate("상태"); ?></td>
            <td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 's_state';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = " id=s_state"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $userstategroy['setup'] = $creategory_setup;

    echo createGory ('SELECT',$userstategroy);
?>
            </td>
            <td><?php print html_xlate("이름"); ?></td>
            <td>
        <INPUT TYPE="text" id="s_user_name" name="s_user_name" style='width:90px'>
            </td>
            <td style="text-align:right">
            <input type=button onclick='fGetList(1);' value='<?=xlate("SEARCH")?>' class='button1'>
            </td>
            <td>
            <input type=button onclick='fGetWrite();' value='<?=xlate("New")?>' class='button1'>
            </td>
            <td>&nbsp;</td>
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
    <col width='50'/>
    <col width='100'/>
    <col width='200'/>
    <col width='70'/>
    <col width='145'/>
    <col width='50'/>
    <col width='50'/>
    <col width=''/>
</colgroup>
<thead>
    <tr style='cursor:pointer;'>
    <th onClick='GRID.setSort({event:event,fieldName:"USER_NO"   ,arrowDraw:true});'><?php print xlate("번호"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"USER_ID"   ,arrowDraw:true});' style='text-align:left'><?php print xlate("아이디"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"USER_NAME" ,arrowDraw:true});' style='text-align:left'><?php print xlate("이름"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"USER_LEVEL",arrowDraw:true});'><?php print html_xlate("회원구분"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"ACC_DATE"  ,arrowDraw:true});'><?php print html_xlate("최근접속일"); ?></th>
    <th onClick='GRID.setSort({event:event,fieldName:"STATE"     ,arrowDraw:true});'><?php print html_xlate("상태"); ?></th>
    <th><?php print html_xlate("-"); ?></th>
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
    loading.setTarget($('area_list'));
    loading.setSize('80px','10px');
//-->
</SCRIPT>
<?
    require("../inc/footer.php"); // footer
} // end if [op=="default"]
else if ( $op == "search") { // 조회
?>
<?php
    header("content-type: application/xml; charset=UTF-8");
    print '<?xml version="1.0" encoding="UTF-8"?>'. "\n";

    require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
    $db->getConnect();
    $db->exec("set names utf8;");
    $cur_many = 0;
    $where  = ($_POST[s_user_level]?                  " USER_LEVEL =   '" . $_POST[s_user_level] . "' ":'');
    $where .= ($_POST[s_state     ]?($where?'AND':'')." STATE      =   '" . $_POST[s_state     ] . "' ":'');
    $where .= ($_POST[s_user_name ]?($where?'AND':'')." ( USER_NAME LIKE '" . $_POST[s_user_name ] . "%' OR USER_ID LIKE '" . $_POST[s_user_name ] . "%')":'');

    $tot = $db->count(MY_TABLE , $where); // row count
    // pagetab
    $page_tab['js_function' ] = 'fGetList';
    $page_tab['s'        ] = !$_POST[s]?1:(int)$_POST[s];
    $page_tab['tot'      ] = $tot;
    $page_tab['how_many' ] = 15 ;
    $page_tab['more_many'] = 20 ;
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
         . "  USER_NO     , \n"
         . "  USER_ID     , \n"
         . "  USER_LEVEL  , \n"
         . "  PASSWD      , \n"
         . "  USER_NAME   , \n"
         . "  NICK_NAME   , \n"
         . "  COMPANY_NAME, \n"
       //. "  COUNTRY_CODE, \n"
         . "  SEX         , \n"
         . "  E_MAIL      , \n"
         . "  JUMIN_NO    , \n"
         . "  COMPANY_NO  , \n"
         . "  TEL1        , \n"
         . "  TEL2        , \n"
         . "  TEL3        , \n"
         . "  TEL4        , \n"
         . "  ADDRESS1    , \n"
         . "  ADDRESS2    , \n"
         . "  POST_NO     , \n"
         . "  EMAIL_YN    , \n"
         . "  ACCESS      , \n"
         . "  REG_DATE    , \n"
         . "  ACC_DATE    , \n"
         . "  STATE         \n"
         . " FROM " . MY_TABLE . " \n"
         . ( $where?' WHERE ' . $where:'' )
         . ( sizeof($orderStr)>0?" ORDER BY ".join($orderStr,','):'' )
         . " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many
    ;
    $seq = 0;
    print '<results>';
    print '<programid>main_user.php</programid>';
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
        foreach ($userlevelegory as $n => $v) {
            printf("<userlevel id='%s'>%s</userlevel>\n",$n,$v,$n);
        }
        foreach ($userstategroy as $n => $v) {
            printf("<userstate id='%s'>%s</userstate>\n",$n,$v,$n);
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
             . "  USER_NO     , \n"
             . "  USER_ID     , \n"
             . "  USER_LEVEL  , \n"
             . "  PASSWD      , \n"
             . "  USER_NAME   , \n"
             . "  NICK_NAME   , \n"
             . "  COMPANY_NAME, \n"
           //. "  COUNTRY_CODE, \n"
             . "  SEX         , \n"
             . "  E_MAIL      , \n"
             . "  JUMIN_NO    , \n"
             . "  COMPANY_NO  , \n"
             . "  TEL1        , \n"
             . "  TEL2        , \n"
             . "  TEL3        , \n"
             . "  TEL4        , \n"
             . "  ADDRESS1    , \n"
             . "  ADDRESS2    , \n"
             . "  POST_NO     , \n"
             . "  EMAIL_YN    , \n"
             . "  ACCESS      , \n"
             . "  REG_DATE    , \n"
             . "  ACC_DATE    , \n"
             . "  STATE         \n"
           //. "  AGREEMENT      , \n"
           //. "  AGREEMENT_DATE   \n"
         . " FROM " . MY_TABLE . " \n"
             . " WHERE USER_NO = '{$k}'\n"
        ;
        $r = $db->get($sql);

        $user_no     = $r->USER_NO     ;
        $user_id     = $r->USER_ID     ;
        $user_level  = $r->USER_LEVEL  ;
        $passwd      = $r->PASSWD      ;
        $user_name   = $r->USER_NAME   ;
        $nick_name   = $r->NICK_NAME   ;
        $company_name= $r->COMPANY_NAME;
        $country_code= $r->COUNTRY_CODE;
        $sex         = $r->SEX         ;
        $e_mail      = $r->E_MAIL      ;
        $jumin_no    = $r->JUMIN_NO    ;
        $company_no  = $r->COMPANY_NO  ;
        $tel1        = $r->TEL1        ;
        $tel2        = $r->TEL2        ;
        $tel3        = $r->TEL3        ;
        $tel4        = $r->TEL4        ;
        $address1    = $r->ADDRESS1    ;
        $address2    = $r->ADDRESS2    ;
        $post_no     = $r->POST_NO     ;
        $email_yn    = $r->EMAIL_YN    ;
        $access      = $r->ACCESS      ;
        $reg_date    = $r->REG_DATE    ;
        $acc_date    = $r->ACC_DATE    ;
        $state       = $r->STATE       ;

        $agreement     = $r->AGREEMENT     ;
        $agreement_date= $r->AGREEMENT_DATE;
    } else {
        $user_id    = '';
        $user_level = 1;
    }
        print "<form id='wForm' name='wForm' method='POST' onsubmit='return fExec(\"$m\");'>";
        print "<input type=hidden id='user_no' name='user_no' value='{$user_no}'>";
?>
        <!-- <div class="formcell"> -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='140'/>
            <col width='330'/>
            <col width=''/>
        </colgroup>
        <tr>
            <th colspan="3"><?php print html_xlate("Save"); ?></th>
        </tr>
        <tr><td><strong><?php print html_xlate("아이디") .'/' . html_xlate("상태");?></strong></td>
            <td>

        <INPUT TYPE="text" id="user_id" name="user_id" value='<?print $user_id?>'
        <?print ($m=='U'?' style="background-color:white;width:180px" readonly':' style="width:180px" class="ml"')?>>
<?if ( $m=='I' ) {?>
    <input type=button onclick='fDupCheck();' value='<?=xlate("중복확인")?>' class='button1'/>
<?}?>
/
<?
$creategory_setup['select'          ] = $state;
$creategory_setup['prop_name'       ] = 'state';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " id=state"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$userstategroy['setup'] = $creategory_setup;
echo createGory ('SELECT',$userstategroy);
?>

        </td><td></td></tr>

        <tr><td><strong><?php print html_xlate("이름") .'/' . html_xlate("그룹");  ?></strong></td>
        <td>
<INPUT TYPE="text" id="user_name" name="user_name" style='width:208px' value='<?print $user_name?>'> /
<?
$creategory_setup['select'          ] = $user_level;
$creategory_setup['prop_name'       ] = 'user_level';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " id=user_level"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$userlevelegory['setup'] = $creategory_setup;
echo createGory ('SELECT',$userlevelegory);
?>
        </td><td></td></tr>

        <tr><td><strong><?php print html_xlate("비밀번호"   )        ;  ?></strong></td>
        <td>
        <INPUT TYPE="text" id="passwd" name="passwd" style='width:<?print ($m=='U'?'80%':'100%')?>' value='<?print $passwd?>'  <?print ($m=='U'?'disabled':'')?>>
<?if ( $m=='U' ) {?>
        <INPUT TYPE="checkbox" id="chg_passwd" name="chg_passwd" value='Y' onchange='$("passwd").disabled=!this.checked;if(this.checked) { $("passwd").focus(); $("passwd").select();}' onclick='this.blur();'> 변경
<?}?>
        </td><td></td></tr>

        <tr><td><strong><?php print html_xlate("E-mail") . ' / ' . html_xlate("접속횟수");  ?></strong></td>
        <td>
        <INPUT TYPE="text" id="e_mail" name="e_mail" style='width:<?print ($m=='U'?'70%':'100%')?>' value='<?print $e_mail;?>'>
        <?print ($m=='U'?' / ' . number_format($access) . '회':'')?>
        </td><td></td></tr>

<!-- 국가 적용 2010년 7월 8일 목요일 //-->
        <!-- <tr><td><strong><?php print html_xlate("국가");?></strong></td>
        <td>
<?
//print '$country_code : ' . $country_code;
/// $country_codegory = getCountry();
$creategory_setup['select'          ] = $country_code;
$creategory_setup['prop_name'       ] = 'country_code';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " id=country_code"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$country_codegory['setup'] = $creategory_setup;
print createGory ('SELECT', $country_codegory);
?>
        </td><td></td></tr> -->

        <tr><td><strong><?php print html_xlate("전화번호");  ?></strong></td>
        <td>
        <INPUT TYPE="text" id="tel1" name="tel1" style='width:46%' value='<?print $tel1;?>'> /
        <INPUT TYPE="text" id="tel2" name="tel2" style='width:46%' value='<?print $tel2;?>'>
        </td><td></td></tr>

<?if ( $m=='U' ) {?>
        <tr><td><strong><?php print html_xlate("가입일자") . ' / ' . html_xlate("최근접속") ;  ?></strong></td>
        <td>
        <?print $reg_date;?> /
        <?print $acc_date;?>
        </td><td></td></tr>
<?}?>

        <!-- <tr><td><strong><?php print html_xlate("약관동의") . ' / ' . html_xlate("일자") ;  ?></strong></td>
        <td>
<?
$creategory_setup['select'          ] = $agreement;
$creategory_setup['prop_name'       ] = 'agreement';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = " id=agreement"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$ynegroy['setup'] = $creategory_setup;
echo createGory ('SELECT',$ynegroy);
?> /
        <?print $agreement_date;?>
        </td><td></td></tr>
 -->
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
    $m = trim($_POST["m"]); // mode [I/U]
    $user_no = trim($_POST["user_no"]); // mode [I/U]
    $savefields = array();
    $savefields[] = "user_id"   ;
    $savefields[] = "user_name" ;
    $savefields[] = "passwd"    ;
    $savefields[] = "user_level";
    $savefields[] = "e_mail"    ;
  //$savefields[] = "country_code";
    $savefields[] = "tel1"      ;
    $savefields[] = "tel2"      ;
    $savefields[] = "state"     ;
  //$savefields[] = "agreement" ;
/*
    $sql = "SELECT "
         . " AGREEMENT "
         . " FROM tbl_member "
         . " WHERE USER_NO='{$user_no}'"
    ;
    $r = $db->get($sql);
    $agreement= $r->AGREEMENT ;
    if ( $agreement != $_POST['agreement'] ) {
        if ( $_POST['agreement'] == 'Y' ) {
            $savefields[] = "agreement_date" ;
            $_POST['agreement_date'] = "now()" ;
        } else {
            $savefields[] = "agreement_date" ;
            $_POST['agreement_date'] = "NULL" ;
        }
    }
*/
    $savedata = array();
    while (list($key, $val) = each($_POST)) {
        if (array_search($key, $savefields) > -1 )
        {
            if ( $key == 'agreement_date' ) {
                $savedata[$key] = "{$val}";
            } else {
                $savedata[$key] = "'{$val}'";
            }
        }
    }

    $chg_passwd = $_POST['chg_passwd']=="Y"?"Y":"N";
    if (!$savedata['user_id'    ]) $errors[] = xlate('아이디가 입력되지 않았습니다.'    );
    if (!$savedata['user_name'  ]) $errors[] = xlate('이름이 입력되지 않았습니다.'      );
    if (!$savedata['passwd'     ]) $errors[] = xlate('비밀번호가 입력되지 않았습니다.'  );
    if (!$savedata['user_level' ]) $errors[] = xlate('사용자그룹이 입력되지 않았습니다.');
    if ( $chg_passwd == 'Y' && !Session::validatePassword($_POST['passwd']) ) $errors[] = xlate('비밀번호는 영숫자만 이용가능합니다.');

    $savefields[] = "use_yn"         ;
    $savedata['state'] = $savedata['state']=="'U'"?"'U'":"'S'";

    $sRtn = 0;
    if (empty($errors)) {
        if (!empty($savedata)) {
            if ( $db->starttransaction() ) {
                unset($savedata['chg_passwd']);
                if ( $m == 'I' ) {
                    $savedata['user_id'] = strtolower($savedata['user_id']);
                    $savedata['reg_date'] = "now()";
                    $sRtn = $db->insert(MY_TABLE, $savedata);
                } else if ( $m == 'U' ) {
                    if ( $user_no ) {
                        unset($savedata['user_id']);
                        unset($savedata['user_no']);
                        if ( $chg_passwd == 'N' ) unset($savedata['passwd' ]);
                        $sRtn = $db->update(MY_TABLE, $savedata,"USER_NO='{$user_no}'");
                    } else {
                        $errors[] = xlate('사용자번호가 입력되지 않았습니다.');
                    }
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
    if (!empty($errors)) {
        $errors[] = $db->getErrMsg();
        echo 'ERROR|'   . $m . '|' . $sRtn  . '|' . implode($errors, "\n");
    } else {
        echo 'SUCCESS|' . $m . '|' . $db->getInsertId()  . '|' . $db->getLastSql();
    }
    $db->release();
} // end if [op=="save_exec"]
else if ( $op == "del_exec") {
    $db->getConnect();
    $m = trim($_POST["m"]); // mode [I/U]
    $k = trim($_POST["k"]); // key
    $cnt = $db->count(MY_TABLE, "USER_NO='{$k}'"); // row count
    if ( $cnt == 0 ) $errors[] = xlate('data is not found ( SQL-Delete )');
    $sRtn = 0;
    if (empty($errors)) {
        if ( $db->starttransaction() ) {
            if ( $m == 'D' ) {
                $sRtn = $db->delete(MY_TABLE,"USER_NO='{$k}'");
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