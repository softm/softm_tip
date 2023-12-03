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
define('MY_TABLE', 'eun_ju_study_setup');  // session

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
        msgStr = '저장하시겠습니까?';
        pMsgStr= '저장되었습니다';

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
        return false;
    }

    window.onload = function() {
        fGetWrite("U");
        document.title = "User";
    }
//-->
</SCRIPT>
<span id='area_write'></span>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var loading = new UI.Loading.display('<?=SERVICE_DIR?>/common/js/ajax-loader.gif','image');
    loading.setTarget($('area_write'));
    loading.setSize('80px','10px');
//-->
</SCRIPT>
<?
    require("../inc/footer.php"); // footer
} // end if [op=="default"]
else if ( $op == "write") {
    $db->getConnect();
    $m = trim($_POST["m"]); // mode [I/U]
    $k = trim($_POST["k"]); // key

        $sql = "SELECT \n"
             . "  VAL1   , \n"
             . "  VAL2   , \n"
             . "  VAL3   , \n"
             . "  VAL4   , \n"
             . "  AVG1   , \n"
             . "  AVG2   , \n"
             . "  AVG3   , \n"
             . "  AVG4   , \n"
             . "  USER_NO  \n"
         . " FROM " . MY_TABLE . " \n"
             . " WHERE USER_NO = '" . $memInfor[user_no] . "'\n"
        ;
        $r = $db->get($sql);

        $val1= $r->VAL1;
        $val2= $r->VAL2;
        $val3= $r->VAL3;
        $val4= $r->VAL4;
        $avg1= $r->AVG1;
        $avg2= $r->AVG2;
        $avg3= $r->AVG3;
        $avg4= $r->AVG4;

        print "<form id='wForm' name='wForm' method='POST' onsubmit='return fExec(\"$m\");'>";
        print "<input type=hidden id='user_no' name='user_no' value='{$user_no}'>";
?>
        <!-- <div class="formcell"> -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='160'/>
            <col width='330'/>
            <col width=''/>
        </colgroup>

        <tr><td><strong><?php print html_xlate("중간고사 배부일 / 회수일");?></strong></td>
        <td>
        <INPUT TYPE="text" id="val1" name="val1" style='width:46%' value='<?print $val1;?>'> /
        <INPUT TYPE="text" id="val2" name="val2" style='width:46%' value='<?print $val2;?>'>
        </td><td></td></tr>

        <tr><td><strong><?php print html_xlate("기말고사 배부일 / 회수일");?></strong></td>
        <td>
        <INPUT TYPE="text" id="val3" name="val3" style='width:46%' value='<?print $val3;?>'> /
        <INPUT TYPE="text" id="val4" name="val4" style='width:46%' value='<?print $val4;?>'>
        </td><td></td></tr>
        <tr><td><strong><?php print html_xlate("재적인원");?></strong></td>
        <td>
        <INPUT TYPE="text" id="val5" name="val5" style='width:46%' value='<?print $val5;?>'>
        </td><td></td></tr>
        <tr><td><strong><?php print html_xlate("중간학년평균 국어 / 수학");?></strong></td>
        <td>
        <INPUT TYPE="text" id="avg1" name="avg1" style='width:46%' value='<?print $avg1;?>'> /
        <INPUT TYPE="text" id="avg2" name="avg2" style='width:46%' value='<?print $avg2;?>'>
        </td><td></td></tr>

        <tr><td><strong><?php print html_xlate("기말학년평균 국어 / 수학");?></strong></td>
        <td>
        <INPUT TYPE="text" id="avg3" name="avg3" style='width:46%' value='<?print $avg3;?>'> /
        <INPUT TYPE="text" id="avg4" name="avg4" style='width:46%' value='<?print $avg4;?>'>
        </td><td></td></tr>
        <tr>
            <td colspan="3"><hr /></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:right">
            <input type=button onclick='fExec("<?print $m?>");' value='<?=xlate("Save")?>' class='button1'/>
            <input type=submit style='position:absolute;left:-1000px;top:-1000px'/>
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

  //if (!$savedata['user_id'    ]) $errors[] = xlate('아이디가 입력되지 않았습니다.'    );
  //if ( $chg_passwd == 'Y' && !Session::validatePassword($_POST['passwd']) ) $errors[] = xlate('비밀번호는 영숫자만 이용가능합니다.');
    $sRtn = 0;
    if (empty($errors)) {
        if ( $db->starttransaction() ) {
            $sql = "REPLACE INTO " . MY_TABLE
                 . " SET "
                 . " VAL1 = '" . $_POST["val1"] . "',"
                 . " VAL2 = '" . $_POST["val2"] . "',"
                 . " VAL3 = '" . $_POST["val3"] . "',"
                 . " VAL4 = '" . $_POST["val4"] . "',"
                 . " VAL5 = '" . $_POST["val5"] . "',"
                 . " AVG1 = '" . $_POST["avg1"] . "',"
                 . " AVG2 = '" . $_POST["avg2"] . "',"
                 . " AVG3 = '" . $_POST["avg3"] . "',"
                 . " AVG4 = '" . $_POST["avg4"] . "',"
                 . " USER_NO = '" . $memInfor[user_no] . "' "
            ;
            //echo $sql;
            if ($sql && !$db->exec($sql)) {
                $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
            }

            if ( $db->commit() ) {
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
    if (!empty($errors)) {
        $errors[] = $db->getErrMsg();
        echo 'ERROR|'   . $m . '|' . $sRtn  . '|' . implode($errors, "\n");
    } else {
        echo 'SUCCESS|' . $m . '|' . $db->getInsertId()  . '|' . $db->getLastSql();
    }
    $db->release();
} // end if [op=="save_exec"]
} // end grant
} // end login
?>