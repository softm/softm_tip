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

define ('MY_TABLE'       , 'eun_ju_study_master'); // edit table
define ('PROGRAM_TITLE'  , '학습정보'            ); // PROGRAM_TITLE
define ('FIELD_WIDTH_AUTO_FIXED' , true          ); // field 넓이 자동 계산
define ('FIELD_WIDTH'            , 50            ); // field 넓이 자동 계산
define ('FIELD_MAX_WIDTH'        , 130           ); // field 최대 넓이
define ('DB_KIND','MYSQL'); // db kind

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
    if ( $fieldInfo['S_ID'     ] ) $fieldInfo['S_ID'     ]->title = 'STUDY ID'   ;
    if ( $fieldInfo['YYYY'     ] ) $fieldInfo['YYYY'     ]->title = '년도'       ;
    if ( $fieldInfo['TERM'     ] ) $fieldInfo['TERM'     ]->title = '학기'       ;
    if ( $fieldInfo['GUBUN'    ] ) $fieldInfo['GUBUN'    ]->title = '구분'       ;
    if ( $fieldInfo['HAK'      ] ) $fieldInfo['HAK'      ]->title = '학년'       ;
    if ( $fieldInfo['BAN'      ] ) $fieldInfo['BAN'      ]->title = '반'         ;
    if ( $fieldInfo['NUM'      ] ) $fieldInfo['NUM'      ]->title = '번호'       ;
    if ( $fieldInfo['MEM_NAME' ] ) $fieldInfo['MEM_NAME' ]->title = '학생명'     ;
    if ( $fieldInfo['SEX'      ] ) $fieldInfo['SEX'      ]->title = '성별'       ;
    if ( $fieldInfo['RESULT_1' ] ) $fieldInfo['RESULT_1' ]->title = '국어점수'   ;
    if ( $fieldInfo['RESULT_2' ] ) $fieldInfo['RESULT_2' ]->title = '수학점수'   ;
    if ( $fieldInfo['REG_DATE' ] ) $fieldInfo['REG_DATE' ]->title = '작성일자'   ;
    if ( $fieldInfo['CONTENT'  ] ) $fieldInfo['CONTENT'  ]->title = '가정통신'   ;

                                   $fieldInfo['TERM'    ]->type  = 'SELECT'     ;
                                   $fieldInfo['GUBUN'   ]->type  = 'SELECT'     ;
                                   $fieldInfo['SEX'     ]->type  = 'SELECT'     ;
                                   $fieldInfo['S_ID'    ]->updatable = false    ; // Update시 수정 가능상태
                                   $fieldInfo['USER_NO' ]->updatable = false    ; // Update시 수정 가능상태

/*

                                     $fieldInfo['USE_YN'     ]->type  = 'SELECT'     ;
                                     $fieldInfo['CLASS_NAME' ]->updatable = false    ; // Update시 수정 가능상태
*/
                                     $fieldInfo['YYYY'      ]->cssText= 'text-align:center';
                                     $fieldInfo['TERM'      ]->cssText= 'text-align:center';
                                     $fieldInfo['GUBUN'     ]->cssText= 'text-align:center';
                                     $fieldInfo['HAK'       ]->cssText= 'text-align:center';
                                     $fieldInfo['BAN'       ]->cssText= 'text-align:center';
                                     $fieldInfo['NUM'       ]->cssText= 'text-align:center';
                                     $fieldInfo['MEM_NAME'  ]->cssText= 'text-align:center';
                                     $fieldInfo['SEX'       ]->cssText= 'text-align:center';
                                     $fieldInfo['RESULT_1'  ]->cssText= 'text-align:center';
                                     $fieldInfo['RESULT_2'  ]->cssText= 'text-align:center';

    if ( !FIELD_WIDTH_AUTO_FIXED ) {
        //$fieldInfo['CLASS_NAME' ]->width = 130;
        //$fieldInfo['USE_YN'     ]->width = 60;
    }
    $fieldInfo['CONTENT' ]->width = 230;
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
    require_once '../inc/header.php'; // header
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
    #tbl_list thead .col0  {display:none;} /**/
    #tbl_list tbody .col0  {display:none;} /**/
    #tbl_list thead .col13 {display:none;}
    #tbl_list tbody .col13 {display:none;}
    #tbl_list {table-layout:fixed}
    #tbl_list thead .col12 {width:200px;}
    #tbl_list tbody .col12 {width:200px;}
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
                code['GUBUN'] = GRID.codeXmlToJson(xmlDoc.getElementsByTagName("code")[0].getElementsByTagName("GUBUN"));
                code['TERM' ] = GRID.codeXmlToJson(xmlDoc.getElementsByTagName("code")[0].getElementsByTagName("TERM" ));
                code['SEX'  ] = GRID.codeXmlToJson(xmlDoc.getElementsByTagName("code")[0].getElementsByTagName("SEX" ));

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

                GRID.infor[tId].fields['GUBUN'].onchange = function() {
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
                //alert( xml.pagenavi.html );
                var c = GRID.row.addCell({row:r,value:l>0?xml.pagenavi.html:'Data not Found',updatable:false,html:true,status:'R'});
                    c.colSpan = th.rows[0].cells.length -1;
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
        r.cells[1].focus();
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

    function fPrint() {
        var f = $('sForm');
        var s_yyyy = $("s_yyyy" ).value;
        var s_term = $("s_term" ).value;
        var s_gubun= $("s_gubun").value;
/*
        if ( !s_yyyy ) {
            alert('프린트할 년도를 선택해주세요.');$("s_yyyy" ).focus();
        } else if ( !s_term ) {
            alert('프린트할 학기를 선택해주세요.');$("s_term" ).focus();
        } else if ( !s_gubun ) {
            alert('프린트할 과정를 선택해주세요.');$("s_gubun").focus();
        } else {
*/
            var params = Util.Form.queryString(f);
            //var estiNo = f.p_esti_no.value.replace(/\-/g,'');
            //var seq    = f.p_seq.value.replace(/\-/g,'');
            var print_option = f.print_option.value;
            var w = openWindow("study_master_print" + print_option + ".php?" + params, 705, 500,'winPrint',{scrollbars:'yes',resizable:'no'});
            w.focus();
//      }
    }

    function fDelete() {
        var s_yyyy = $("s_yyyy" ).value;
        var s_term = $("s_term" ).value;
        var s_gubun= $("s_gubun").value;
        if ( !s_yyyy ) {
            alert('삭제할 년도를 선택해주세요.');$("s_yyyy" ).focus();
        } else if ( !s_term ) {
            alert('삭제할 학기를 선택해주세요.');$("s_term" ).focus();
        } else if ( !s_gubun ) {
            alert('삭제할 과정를 선택해주세요.');$("s_gubun").focus();
        } else {
            if ( confirm('"'+ $("s_yyyy" ).value +"년도 " + $("s_term").value + "학기 "+ ( $("s_gubun").value=="1"?"중간":"기말")+'"'+" 자료를 모두 삭제하시겠습니까?" ) ) {
                var ajaxR = new asyncConnector('xmlhttp');
                var url  = _url;

                ajaxR.openCallBack= function (str) {
                    loading.hide();
                  //ajaxR.dataArea.innerHTML = ajaxR.responseText();
                    try{
                        fGetList(1);
                    }
                    catch (e) {
                        //alert( 'e' + e.toString() );
                        if (console) console.debug(e);
                    }
                }

                ajaxR.form = $('sForm');
                var params = 'p_mode=D_ALL';
                params += '&' + ajaxR.getQueryString();
                ajaxR.httpOpen('POST', url, true,params);
            }
        }
    }
    function fBatchExec() {
        if ( document.bForm.upload_data.value ) {
            document.bForm.action = "study_master_list.php";
            return true;
        } else {
            alert("업로드할 파일을 선택해주세요");
            return false;
        }
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

    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='30' />
            <col width='60' />
            <col width='60' />
            <col width='150'/>
            <col width=''   />
            <col width=''   />
        </colgroup>
        <thead>
            <tr>
            <th colspan="9"><?php print html_xlate(PROGRAM_TITLE); ?></th>
            </tr>
            <tr>
<?print "<form id='sForm' name='sForm' method='POST' onsubmit='return fGetList(1);'>";?>
            <td>
<?
    $fInfo = array();
    $stmt = $db->multiRowSQLQuery(" SELECT DISTINCT YYYY AS YYYY FROM " . MY_TABLE . " WHERE USER_NO = " . $memInfor[user_no]);
    while ($r = $db->multiRowFetch($stmt)) {
        $fInfo[$r->YYYY] = $r->YYYY;
    }
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 's_yyyy';
    $creategory_setup['title'           ] = '-년도-'  ;
    $creategory_setup['script'          ] = " id=s_yyyy onchange='fGetList(1)'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $fInfo['setup'] = $creategory_setup;
    echo createGory ('SELECT',$fInfo);
?>
            </td>
            <td>
<?
/*
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
*/
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 's_term';
    $creategory_setup['title'           ] = '-학기-'  ;
    $creategory_setup['script'          ] = " id=s_term onchange='fGetList(1)'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $termegroy['setup'] = $creategory_setup;

    echo createGory ('SELECT',$termegroy);
?>
            </td>
            <td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 's_gubun';
    $creategory_setup['title'           ] = '-과정-'  ;
    $creategory_setup['script'          ] = " id=s_gubun onchange='fGetList(1)'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $study_gubunegroy['setup'] = $creategory_setup;

    echo createGory ('SELECT',$study_gubunegroy);
?>
            </td>
            <td>
        학생명<INPUT TYPE="text" id="s_mem_name" name="s_mem_name" style='width:90px'>
            </td>
            <td style="text-align:right">
            <input type=button onclick='fGetList(1);' value='<?=xlate("SEARCH")?>' class='button1'>
            </td>
            <td>
            <input type=button onclick='fNewRow();' value='<?=xlate("New")?>' class='button1'>
<select name='print_option'>
    <option value='1'>평과결과표-학생별</option>
    <option value='2'>봉투표지</option>
    <option value='3'>평과결과표-전체</option>
</select>
            <input type=button onclick='fPrint();'  value='<?=xlate("Print")?>' class='button1'>
            <input type=button onclick='fDelete();' value='<?=xlate("DELETE")?>' class='button1' style='background-color:red'>
            </td>
</form>
            <td>
<form id='bForm' name='bForm' method='POST' enctype="multipart/form-data" onsubmit='return fBatchExec();'>
            <input type=file name="upload_data" class='button1' style='width:150px'>
            <input type=hidden name="p_mode" value='upload'>
            <input type=submit value='<?=xlate("일괄업로드")?>' class='button1'>
            <A HREF="../study_upload.txt">샘플파일 다운로드</a>
</form>
            </td>

            </tr>
        </thead>
    </table>
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
    /*
    if ( !$_POST[s_condition ] && $_POST[s_search] ) {
        foreach ($fieldInfo as $k => $v) { 
            if ( $v->updateType == 'M' ) $wheres[] = $k . " LIKE '" . $_POST[s_search] . "%'";
        }
    } else {
        if ( $_POST[s_condition ] ) {
            $wheres[] = $_POST[s_condition ] . " LIKE '" . $_POST[s_search] . "%'";
        }
    }*/
    if ( $_POST[s_yyyy ] ) $wheres[] = " YYYY  = '" . $_POST[s_yyyy  ] . "'";
    if ( $_POST[s_term ] ) $wheres[] = " TERM  = '" . $_POST[s_term  ] . "'";
    if ( $_POST[s_gubun] ) $wheres[] = " GUBUN = '" . $_POST[s_gubun ] . "'";
    if ( $_POST[s_mem_name] ) $wheres[] = " MEM_NAME LIKE '%" . $_POST[s_mem_name] . "%'";

    //$sRtn = $db->exec("set names utf8");
    $orderStr = array();
    for( $i=0;$i<sizeof($_POST['sort_f']);$i++) {
        if      ($_POST['sort_d'][$i]=='▲') $dir = 'ASC' ;
        else if ($_POST['sort_d'][$i]=='▼') $dir = 'DESC';
        if ( $dir ) $orderStr[] = $_POST['sort_f'][$i] . ' ' . $dir;
    }
    $where = join(' AND ',$wheres);
    //$where = join(' OR ',$wheres);
    $tot = $db->count(MY_TABLE , " USER_NO= '" . $memInfor[user_no] . "' " . ( $where?" AND " . $where:"" ) ); // row count
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
         . " WHERE USER_NO= '" . $memInfor[user_no] . "'\n"
         . ( $where?' AND ' . $where:'' )
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
        foreach ($study_gubunegroy as $n => $v) {
            printf("<GUBUN id='%s'>%s</GUBUN>\n",$n,$v,$n);
        }
        foreach ($termegroy as $n => $v) {
            printf("<TERM id='%s'>%s</TERM>\n",$n,$v,$n);
        }
        foreach ($sexegroy as $n => $v) {
            printf("<SEX id='%s'>%s</SEX>\n",$n,$v,$n);
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
        if ( $n ) printf("<%s %s/>\n",$n,$attrStr);

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
/*
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
*/
            } else if ( $p_mode == "U" ) {
/*
                $sql2 = "UPDATE tbl_accounting_exchange_rate SET " . "\n"
                     . " USE_YN = '" . $_POST[USE_YN] . "' ". "\n"
                     . " WHERE CLASS_NAME = '" . $_POST[CLASS_NAME] . "'". "\n"
                     . " AND   ACCOUNTING_YEAR = '" . ACCOUNTING_YEAR . "'". "\n"
                ;
*/
            } else if ( $p_mode == "D" ) {
/*
                $sql2 = "DELETE FROM tbl_accounting_exchange_rate " . "\n"
                     . " WHERE CLASS_NAME = '" . $_POST[CLASS_NAME] . "'". "\n"
                     . " AND   ACCOUNTING_YEAR = '" . ACCOUNTING_YEAR . "'". "\n"
                ;
*/
            }
/*
            if (!$db->exec($sql2)) {
                $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
            } else {
            }
*/
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
else if ( $p_mode == "D_ALL" ) {
    $errors = array();
    $sql = "DELETE FROM eun_ju_study_master ";
    $sql .= " WHERE YYYY  = '" . $_POST[s_yyyy  ] . "'";
    $sql .= " AND   TERM  = '" . $_POST[s_term  ] . "'";
    $sql .= " AND   GUBUN = '" . $_POST[s_gubun ] . "'";
    if ( $_POST[s_mem_name] ) $sql .= " AND   MEM_NAME LIKE '%" . $_POST[s_mem_name] . "%'";

    //echo  $sql;
    if (!$db->exec($sql)) {
        $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
?>
<?=implode($errors, "', '")?>
<?
    } else {
    }
} // end if [$p_mode=="D_ALL"]
else if ( $p_mode == "upload" ) {
    if ( $HTTP_POST_FILES['upload_data'] ) {
        $file1           = $HTTP_POST_FILES['upload_data'][tmp_name ];
        $full_file1_name = $HTTP_POST_FILES['upload_data'][name     ];
        $file1_size      = $HTTP_POST_FILES['upload_data'][size     ];
        $file1_type      = $HTTP_POST_FILES['upload_data'][type     ];

        $file_infor = explode(".","$full_file1_name");
        $file_name = $file_infor[0];                    // 파일 명
        $file_ext  = $file_infor[sizeof($file_infor)-1];// 확장 명
        $file_ext  = strtolower( $file_ext );
        if($file1 && file_exists($file1) ) {
//      if($file1 && file_exists($file1) && ( $file_ext == 'txt' || $file_ext == 'html' || $file_ext == 'htm' ) ) {
            $f = fopen($file1,"r");
            $file1_str = fread($f, filesize($file1));
            fclose($f);
        }
        $isql = "";
        $data = split("\r\n",$file1_str);
        for($i=0;$i< sizeof($data);$i++){
            //echo $data[$i]."<br>\n";
            $d = split(",",$data[$i]);
            if ( sizeof($d) == 10 ) {
                $isql .= ($isql?",":"");
                $isql .= "('" . trim($d[0]) . "',";
                $isql .= "'" . trim($d[1]) . "',";
                $isql .= "'" . trim($d[2]) . "',";
                $isql .= "'" . trim($d[3]) . "',";
                $isql .= "'" . trim($d[4]) . "',";
                $isql .= "'" . trim($d[5]) . "',";
                $isql .= "'" . trim($d[6]) . "',";
                $isql .= "'" . trim($d[7]) . "',";
                $isql .= "'" . trim($d[8]) . "',";
                $isql .= "'" . trim($d[9]) . "',";
                $isql .= "'" . $memInfor[user_no] . "')";
            }
        }
        $errors = array();
        $sql = "INSERT INTO eun_ju_study_master (YYYY,TERM,GUBUN,HAK,BAN,NUM,MEM_NAME,SEX,RESULT_1,RESULT_2,USER_NO) VALUES ";
        $sql .= $isql;
        //echo  $sql;
        if (!$db->exec($sql)) {
            $errors[] = $db->getErrMsg() . ' / ' . $db->getLastSql();
?>
<script type="text/javascript">
<!--
    alert("<?=implode($errors, "', '")?>");
//-->
</script>
<?
        } else {
?>
<script type="text/javascript">
<!--
    document.location.replace("study_master_list.php");
//-->
</script>
<?
        }
    } else {
        echo "<form name='dataForm'><textarea name='header' cols='90' rows='12'></textarea></form>";
    }
} // end if [$p_mode=="UPLOAD"]
} // end grant
} // end login
?>