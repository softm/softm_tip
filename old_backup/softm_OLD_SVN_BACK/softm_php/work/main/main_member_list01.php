<?
/*
 Filename       : /calko/calko_class.php
 Fuction        : Class 관리
 Comment        :
 Make   Date    : 2010-08-23,
 Update Date    : 2010-08-23, v1.0 first
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

define ('MY_TABLE'       , 'tbl_calko_class_name'); // edit table
define ('PROGRAM_TITLE'  , 'Class'               ); // PROGRAM_TITLE
define ('FIELD_WIDTH_AUTO_FIXED' , true          ); // field 넓이 자동 계산
define ('FIELD_WIDTH'            , 50            ); // field 넓이 자동 계산
define ('FIELD_MAX_WIDTH'        , 130           ); // field 최대 넓이

require_once SERVICE_DIR . '/common/lib/lib.inc'                        ; // standard lib
require_once SERVICE_DIR . '/common/lib/DB.php'                         ; // DB
require_once SERVICE_DIR . '/common/lib/class.inputfilter_clean.php'    ; // string filter
require_once SERVICE_DIR . '/common/lib/form.inc'                       ; // form
require_once SERVICE_DIR . '/common/lib/grid.inc'                       ; // grid
require_once SERVICE_DIR . '/common/Session.php'                        ; // session

$db = new DB (); // db instance
$memInfor = Session::getSession();
$p_mode = !trim($_POST["p_mode"])?'default':trim($_POST["p_mode"]);   // Process parameter [display, S,U,I,D]
$fieldInfo = array();
$backurl = $_GET['backurl']?$_GET['backurl']:$_SERVER[REQUEST_URI];
if ( $backurl ) Session::setSession('backurl',$backurl);
     $backurl = Session::getSession('backurl');
if ( $p_mode ) {
    $db->getConnect();
    $stmt = $db->multiRowSQLQuery(" desc " . MY_TABLE);
    while ($r = $db->multiRowFetch($stmt)) {
        if ( FIELD_WIDTH_AUTO_FIXED ) {
            $fieldInfo[$r->Field] = new fieldInfo('TEXT',$r->Field,$r->Field,true,'M',FIELD_WIDTH);
        } else {
            $fieldInfo[$r->Field] = new fieldInfo('TEXT',$r->Field,$r->Field,true,'M',FIELD_WIDTH);
        }
    }

    //* do modify --------------------------------------------------
    if ( $fieldInfo['CLASS_NAME' ] ) $fieldInfo['CLASS_NAME' ]->title = '클래스명'   ;
    if ( $fieldInfo['MODEL_TYPE' ] ) $fieldInfo['MODEL_TYPE' ]->title = '모델명'     ;
    if ( $fieldInfo['PASSENGER'  ] ) $fieldInfo['PASSENGER'  ]->title = '인승'       ;
    if ( $fieldInfo['VELOCITY'   ] ) $fieldInfo['VELOCITY'   ]->title = '속도'       ;
    if ( $fieldInfo['USE_TYPE'   ] ) $fieldInfo['USE_TYPE'   ]->title = '타입'       ;
    if ( $fieldInfo['CLASS'      ] ) $fieldInfo['CLASS'      ]->title = '클래스'     ;
    if ( $fieldInfo['SEQ'        ] ) $fieldInfo['SEQ'        ]->title = '순서'       ;
    if ( $fieldInfo['USE_YN'     ] ) $fieldInfo['USE_YN'     ]->title = '사용여부'   ;
                                     $fieldInfo['USE_YN'     ]->type  = 'SELECT'     ;
                                     $fieldInfo['CLASS_NAME' ]->updatable = false    ; // Update시 수정 가능상태
                                     $fieldInfo['SEQ'        ]->cssText= 'text-align:center';
                                     $fieldInfo['USE_YN'     ]->cssText= 'text-align:center';

    if ( !FIELD_WIDTH_AUTO_FIXED ) {
        $fieldInfo['CLASS_NAME' ]->width = 130;
        $fieldInfo['USE_YN'     ]->width = 60;
    }
    // -------------------------------------------------- do modify */
  //$db->release();
}

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
if ( $p_mode == 'default' ) {
    require_once '../inc/header.php'   ; // header
?>
<!--[if IE]>
<style type="text/css">
.textOf {overflow:hidden;text-overflow:ellipsis;}
</style>
<![endif]-->
<script language="Javascript1.2" src="<?=SERVICE_DIR?>/common/js/session.js"></script>
<Style>
    #tbl_list button {border:1px solid #000066;background-color:#336699;color:white;font-weight:bold;font-size:9pt;font-family:'Arial';cursor:pointer}
    #tbl_list tbody td {text-align:left}
/*
    #tbl_list tbody td select {background-color:transparent}
    #tbl_list tbody td input  {background-color:transparent}
    #tbl_list tbody td.col0 {background-color:red}
    #tbl_list tbody td.col1 {background-color:orange}
*/
</Style>
<SCRIPT LANGUAGE="JavaScript">
<!--
    var _s  =  1 ; // pagetab Number
    var m   = 'S';
    var _url = '<?print $_SERVER['PHP_SELF']?>';
    function fGetList(s) {
        var ajaxR = new asyncConnector('xmlhttp');
        var url  = _url;
        var tbl = $('tbl_list');
        var tId = tbl.id;
        var th = tbl.tHead     ;
        var tb = tbl.tBodies[0];
        var tf = tbl.tFoot     ;

        ajaxR.openCallBack= function (str) {
            loading.hide();
          //ajaxR.dataArea.innerHTML = ajaxR.responseText();
            var xmlDoc=ajaxR.responseXML();
            var xml  = Util.xml2json(xmlDoc);
            var items = typeof xml.items == 'undefined'? new Array():xml.items;
                items = typeof items.length == 'undefined'? new Array(items):items;

            var l = items.length;
            var code = {};
            try{
                code['USE_YN'] = GRID.codeXmlToJson(xmlDoc.getElementsByTagName("code")[0].getElementsByTagName("USE_YN"));

                var _rtn = GRID.init(
                    {
                        table:tbl,
                        fields:xml.fieldinfo,
                        code:code,
                      //onedit:'ondblclick',
                      //onedit:'onclick',
                        onedit:'onfocus',
                        message:{
                            'insert':'입력하시겠습니까?',
                            'update':'수정하시겠습니까?',
                            'delete':"환율정보가 함께 삭제됩니다!" + "\n" + '삭제하시겠습니까?'
                        },
                        callback:{
                            'sort'  :fGetList,
                            'delete':fGetList,
                            'update':fGetList,
                            'insert':fGetList
                        },
                        row:{
                            'active':{cssText:'background-color:LightSteelBlue;color:#000000'}
                        },
                        cell:{
                            'active':{cssText:'background-color:#E8E8FF;color:#000099'},
                            color:{
                                'save'  :'#CCCCFF'
                            }
                        }
                    }
                ); // create init

                GRID.infor[tId].fields['USE_YN'].onchange = function() {
                    return confirm('사용상태 변경은 환율정보의 사용상태와 동기화 됩니다.\n수정하시겠습니까?');
                }
/*
                GRID.infor[tId].onsubmit = function(o) {
                    var td = GRID.cell.getTd(o.td);
                    var tId = o.tId;
                    var tr = td.parentNode;
                    var rIdx = tr.rowIndex;
                    return true;
                }

                GRID.infor[tId].fields['COUNTRY_CODE'].onblur = function(e) {
                    var o = window.event?event.srcElement:e.target;
                        td = GRID.cell.getTd(o);
                    var tBody = td.parentNode.parentNode;
                    var tId = tBody.parentNode.id;
                    var tr = td.parentNode;
                    var rIdx = tr.rowIndex;
                    GRID.cell.setData(tId,rIdx,'COUNTRY_CODE',o.value.toUpperCase());
                    return false;
                }

                GRID.infor[tId].fields['SOLD_TO_PARTY'].onchange = function(o) {
                    var td = GRID.cell.getTd(o.td);
                    var tr = td.parentNode;
                    return confirm('SOLD_TO_PARTY 변경은 시스템에 영향을 줍니다.\n그래도 수정하시겠습니까?');
                }
*/
                var r = GRID.createHead({table:tbl}); // create head
                var rows = GRID.bind({table:'tbl_list',data:items,code:code,start:s});

                var r=tb.insertRow(-1);
                var c = GRID.row.addCell({row:r,value:'',updatable:false,html:true,status:'R'});
                    c.colSpan = th.rows[0].cells.length;

                // create navi
                var r=tf.insertRow(-1);
                var c = GRID.row.addCell({row:r,value:l>0?xml.pagenavi.html:'Data not Found',updatable:false,html:true,status:'R'});
                    c.colSpan = th.rows[0].cells.length;
            }
            catch (e) {
                //alert( 'e' + e.toString() );
                if (console) console.debug(e);
            }

            $('area_list' ).style.display = 'inline' ;
            $('area_write').style.display = 'none'   ;

        }
        ajaxR.form = $('sForm');
        var params = 'p_mode=S'
                   + '&s=' + (s?s:1)
                   + '&p_navi_function=fGetList';
        params += GRID.getSortString(('tbl_list')); // SORT
        params += '&' + ajaxR.getQueryString();
        ajaxR.httpOpen('POST', url, true,params, tb);
        //console.debug(params );
        m = 'S';
        //_s = s;
        loading.setTarget(document.documentElement);
        loading.show();
        return false;
    }

    function fNewRow() {
        var r = GRID.insertRow({table:'tbl_list'});
    }

    function fActiveRow() {
        if (_rI) {
            try {
                var tmpKey = document.getElementsByName('keys')[_rI.rowIndex-1].value;
                //alert( tmpKey + ' / ' + _rI.key + ' / ' + _rI.rowIndex);
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

    window.onload = function() {
        fGetList(1);
        //document.title = "<?=PROGRAM_TITLE?>";
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
            <col width='100'/>
            <col width='100'/>
            <col width='100'/>
            <col width=''   />
        </colgroup>
        <thead>
            <tr>
            <th colspan="9"><?php print html_xlate(PROGRAM_TITLE); ?></th>
            </tr>
            <tr>
            <td><?php print html_xlate("검색"); ?></td>
            <td>
<?
    $fInfo = array();
    foreach ($fieldInfo as $k => $v) { 
        if ( $v->updateType == 'M' ) $fInfo[$k] = $v->title;
    }
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 's_condition';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = " id=s_condition"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $fInfo['setup'] = $creategory_setup;

    echo createGory ('SELECT',array_merge (array(''=>'- All -'),$fInfo));
?>
            </td>
            <td>
        <INPUT TYPE="text" id="s_search" name="s_search" style='width:90px'>
            </td>
            <td style="text-align:right">
            <input type=button onclick='fGetList(1);' value='<?=xlate("SEARCH")?>' class='button1'>
            </td>
            <td>
            <input type=button onclick='fNewRow();' value='<?=xlate("New")?>' class='button1'>
            </td>
            <td><FONT SIZE="" COLOR="red"><B><!-- 해외영업팀에서는 사용하시마세요. --></B></FONT>&nbsp;</td>
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
<table border="0" cellspacing="0" cellpadding="0" class="formbodyline" style='table-layout:fixed;width:100%' id='tbl_list'>
<thead></thead>
<!-- <tbody id='data_list' style='overflow:hidden;overflow-y:auto;height:400px;width:1200px'></tbody> -->
<tbody id='data_list'></tbody>
<tfoot></tfoot>
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
    require("../inc/footer.php"); // footer
} // end if [$p_mode=="default"]
else if ( $p_mode == "S") { // 조회
?>
<?php
    header("content-type: application/xml; charset=UTF-8");
    print '<?xml version="1.0" encoding="UTF-8"?>'. "\n";

    require_once SERVICE_DIR . '/common/lib/page_tab.lib'                 ; // page navigation
    //$db->getConnect();
    $db->exec("set names utf8;");
    $cur_many = 0;
    $wheres  = array();
    if ( !$_POST[s_condition ] && $_POST[s_search] ) {
        foreach ($fieldInfo as $k => $v) { 
            if ( $v->updateType == 'M' ) $wheres[] = $k . " LIKE '" . $_POST[s_search] . "%'";
        }
    } else {
        if ( $_POST[s_condition ] ) {
            $wheres[] = $_POST[s_condition ] . " LIKE '" . $_POST[s_search] . "%'";
        }
    }

    //$sRtn = $db->exec("set names utf8");
    $orderStr = array();
    for( $i=0;$i<sizeof($_POST['sort_f']);$i++) {
        if      ($_POST['sort_d'][$i]=='▲') $dir = 'ASC' ;
        else if ($_POST['sort_d'][$i]=='▼') $dir = 'DESC';
        if ( $dir ) $orderStr[] = $_POST['sort_f'][$i] . ' ' . $dir;
    }
    $where = join(' OR ',$wheres);
    $tot = $db->count(MY_TABLE , $where); // row count
    // pagetab
    $page_tab['js_function' ] = $_POST["p_navi_function"];
    $page_tab['s'        ] = !$_POST[s]?1:(int)$_POST[s];
    $page_tab['tot'      ] = $tot;
    $page_tab['how_many' ] = 20 ;
    $page_tab['more_many'] = 20 ;
    $page_tab['page_many'] = 10 ;
    if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

    $sql = "SELECT \n"
         . "  * \n"
         . " FROM " . MY_TABLE . " \n"
         . ( $where?' WHERE ' . $where:'' )
         . ( sizeof($orderStr)>0?" ORDER BY ".join($orderStr,','):'' )
         . " LIMIT " . ( $page_tab['s'] - 1 ) . ", " . $cur_many
    ;
    $seq = 0;
    print '<results>';
    print '<programid><![CDATA['. $_SERVER[PHP_SELF] . ']]></programid>';
    print '<sql><![CDATA['.$sql. ' / ' . var_dump($_POST['sort_f']) . ' / ' . var_dump($_POST['sort_d']) . ']]></sql>';
    print '<date>' . date('Y/m/d h:i:s A') . '</date>';

    $stmt = $db->multiRowSQLQuery($sql);
    while ($r = $db->multiRowFetch($stmt)) {
        print '<items>';
        foreach ($r as $n => $v) {
            printf("<%s isnull='" . (is_null($v)?'1':'0') . "'><value><![CDATA[%s]]></value></%s>\n",$n,$v,$n);
            if ( FIELD_WIDTH_AUTO_FIXED ) {
                $fieldInfo[$n]->width = max($fieldInfo[$n]->width,strlen_pixels($fieldInfo[$n]->title), strlen_pixels ($v)); // 자동길이 계산
            }
        }
        print '</items>';
    }

    print "\n";
    print '<code>';
        foreach ($ynegroy as $n => $v) {
            printf("<USE_YN id='%s'>%s</USE_YN>\n",$n,$v,$n);
        }
    print '</code>';
    print "\n";

    printf("<fieldinfo>");
    foreach ($fieldInfo as $n => $v) {
        $attrStr = '';
        foreach ($v as $k => $vv) {
            if ( $k == 'width' ) {
                $w = (int)$v->width;
                $attrStr .= $k."='".( ($w>FIELD_MAX_WIDTH?FIELD_MAX_WIDTH:$w) + 15 )."' ";
            } else {
                $attrStr .= $k."='".$vv."' ";
            }
        }
        printf("<%s %s/>\n",$n,$attrStr);

    }
    printf("</fieldinfo>");

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
} // end if [$p_mode=="S"]
else if ( $p_mode == "U" || $p_mode == "I" || $p_mode == "D" ) {
    header("content-type: application/xml; charset=UTF-8");
    print '<?xml version="1.0" encoding="UTF-8"?>'. "\n";
    //$db->getConnect();
    $db->exec("set names utf8;");

    $p_field_name   = urldecode(trim($_POST["p_field_names"])); // field Information
    $p_mode         = $_POST["p_mode"];
    $errors = array();

    //echo '$p_field_names : ' . $p_field_name;
    $sRtn = false;
    if ( $p_mode == "U" ) {
        $set   = '';
        $where = '';
        foreach ($fieldInfo as $k => $v) {
            if ( $v->updateType == 'M' ) {
                if ( !is_null($_POST[$k.'_org'])  ) {
                    $set .= ($set?",":"") . $k . " " . ($_POST[$k.'_isnull']=='1'?'= Null':"= '".$_POST[$k]."'" );
                }
                $where .= ( !$where?' WHERE ':' AND ' ) . $k . " " . ( !is_null($_POST[$k.'_org'])?($_POST[$k.'_org_isnull' ] == '1'?'is Null':"= '".$_POST[$k.'_org']."'" ):
                                                                                                   ($_POST[$k.'_isnull'     ] == '1'?'is Null':"= '".$_POST[$k       ]."'" ));
            }
        }
        $sql = ($set?'UPDATE ' . MY_TABLE . ' SET ' . $set . ' ' . $where . ' LIMIT 1':'');
    } else if ( $p_mode == "I" ) {
        $insertFields= array();
        $insertValues= array();
        foreach ($fieldInfo as $k => $v) {
            if ( $v->updateType == 'M' ) {
                $insertFields[] = $k;
                $insertValues[] = ($_POST[$k.'_isnull']=='1'?'Null':"'".$_POST[$k]."'" );
            }
        }
        $sql = (!empty($insertFields)?'INSERT INTO ' . MY_TABLE . '( ' . join(',',$insertFields) . ') VALUES ( ' . join(',',$insertValues) . ' )':'');
    } else if ( $p_mode == "D" ) {
        $where = '';
        foreach ($fieldInfo as $k => $v) {
            if ( $v->updateType == 'M' ) {
                $where .= ( !$where?' WHERE ':' AND ' ) . $k . " " . ( !is_null($_POST[$k.'_org'])?($_POST[$k.'_org_isnull' ] == '1'?'is Null':"= '".$_POST[$k.'_org']."'" ):
                                                                                                   ($_POST[$k.'_isnull'     ] == '1'?'is Null':"= '".$_POST[$k       ]."'" ));
            }
        }
        $sql = ($where?'DELETE FROM ' . MY_TABLE . ' ' . $where . ' LIMIT 1':'');
    }
    //echo $sql;
    print '<results>';
    print '<programid><![CDATA['. $_SERVER[PHP_SELF] . ']]></programid>';
    print '<sql><![CDATA['.$sql. ']]></sql>';
    print '<date>' . date('Y/m/d h:i:s A') . '</date>';
    print '<status>';
    if ( $db->starttransaction() ) {
        if ($sql && !$db->exec($sql)) {
            if ( $p_mode == "U" ) {
                $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
            } else if ( $p_mode == "I" ) {
                $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
            } else if ( $p_mode == "D" ) {
                $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
            }
        }
        //* do modify --------------------------------------------------
        if ( empty($errors) ) {
            $sql2 = '';
            if ( $p_mode == "I" ) {
                $sql2 = "INSERT INTO tbl_accounting_exchange_rate " . "\n"
                     . " (". "\n"
                     . " COUNTRY_CODE   ,". "\n"
                     . " CLASS_NAME     ,". "\n"
                     . " ACCOUNTING_YEAR,". "\n"
                     . " MARGIN_RATE    ,". "\n"
                     . " MARKUP_RATE    ,". "\n"
                     . " SGNA_RATE      ,". "\n"
                     . " EXCHANGE_RATE  ,". "\n"
                     . " USE_YN         ,". "\n"
                     . " REG_DATE       ,". "\n"
                     . " MOD_DATE       ,". "\n"
                     . " REG_USER_ID    ,". "\n"
                     . " MOD_USER_ID     ". "\n"
                     . " ) ". "\n"
                     . " SELECT                         ". "\n"
                     . "     c.COUNTRY_CODE ,           ". "\n"
                     . "     cn.CLASS_NAME  ,           ". "\n"
                     . "     '" . ACCOUNTING_YEAR ."',  ". "\n"
                     . "     10,                        ". "\n"
                     . "     10,                        ". "\n"
                     . "     10,                        ". "\n"
                     . "     1000,                      ". "\n"
                     . "     '" . $_POST[USE_YN] . "',  ". "\n"
                     . "     now(),                     ". "\n"
                     . "     now(),                     ". "\n"
                     . "     '" . $memInfor[user_no] . "',  ". "\n"
                     . "     '" . $memInfor[user_no] . "'   ". "\n"
                     . " FROM tbl_calko_country c, tbl_calko_class_name cn ". "\n"
                     . " WHERE cn.CLASS_NAME IN('" . $_POST[CLASS_NAME] . "')". "\n"
                     . " GROUP BY c.COUNTRY_CODE,cn.CLASS_NAME ". "\n"
                     . " ORDER BY c.COUNTRY_CODE, cn.SEQ ". "\n"
                ;
            } else if ( $p_mode == "U" ) {
                $sql2 = "UPDATE tbl_accounting_exchange_rate SET " . "\n"
                     . " USE_YN = '" . $_POST[USE_YN] . "' ". "\n"
                     . " WHERE CLASS_NAME = '" . $_POST[CLASS_NAME] . "'". "\n"
                     . " AND   ACCOUNTING_YEAR = '" . ACCOUNTING_YEAR . "'". "\n"
                ;
            } else if ( $p_mode == "D" ) {
                $sql2 = "DELETE FROM tbl_accounting_exchange_rate " . "\n"
                     . " WHERE CLASS_NAME = '" . $_POST[CLASS_NAME] . "'". "\n"
                     . " AND   ACCOUNTING_YEAR = '" . ACCOUNTING_YEAR . "'". "\n"
                ;
            }
            if (!$db->exec($sql2)) {
                $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
            } else {
            }
        }
        // -------------------------------------------------- do modify */

        if ( empty($errors) && $db->commit() ) {
            print("<code>SUCCESS</code>\n");
            print("<mode>".$p_mode."</mode>\n");
            print("<message><![CDATA["."Saved!"."]]></message>\n");
        } else {
            print("<code>ERROR</code>\n");
            print("<mode>".$p_mode."</mode>\n");
            print("<message><![CDATA[".implode($errors, "', '")."]]></message>\n");
        }
    }
    print '</status>';
    print '</results>';
    $db->release();

} // end if [$p_mode=="U,I,S"]
} // end grant
} // end login
?>