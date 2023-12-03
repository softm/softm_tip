<SCRIPT LANGUAGE='javascript'>
<!--
    var grantWin = null;
    function moveGrantPage (eventId) {
        if ( grantWin != null ) { grantWin.close(); }
        var url  = 'admin/admin_event_popup_grant.php?event_id=' + eventId;
		grantWin = window.open(url,'grantWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=416,height=225');
//      grantWin = window.open ("about:blank",'grantWin');
        grantWin.focus();
    }

    function moveSetupPage (eventId) {
        document.eventListForm.target           = '';
        document.eventListForm.method           = 'POST';
        document.eventListForm.action           = 'admin_event.php';
        document.eventListForm.branch.value     = 'setup';
        document.eventListForm.event_id.value   = eventId;
        document.eventListForm.submit();
    }

    function moveResultPage (eventId) {
        document.eventListForm.target           = '';
        document.eventListForm.method           = 'POST';
        document.eventListForm.action           = 'admin_event.php';
        document.eventListForm.branch.value     = 'result';
        document.eventListForm.event_id.value   = eventId;
        document.eventListForm.submit();
    }

    function checkedAll () {
        var chkNo  = document.eventListForm["chk_no[]"];
		var cnt = chkNo.length;
        for ( var i=1;i<cnt; i++ ) {
			chkNo[i].checked = !chkNo[i].checked;
        }
    }

    function deleteData(eventId) {
        var chkNo  = document.eventListForm["chk_no[]"];
        setCheckedAll ( chkNo, false ) ;
        objectChecked ( chkNo, eventId );
        if ( confirm ('\n\n현재 선택된 자료와 연관된 \n\n등록 자료가 전부 삭제됩니다.\n\n한번 삭제된 자료는 복원할 수 없습니다.\n\n정말 삭제하시겟습니까?') ) {
            document.eventListForm.target       = ''      ;
            document.eventListForm.action       = ''      ;
            document.eventListForm.branch.value = 'exec'  ;
            document.eventListForm.gubun.value  = 'delete';

            document.eventListForm.submit();
        }
    }

    function deleteChkData() {
        var chkNo  = document.eventListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // 체크박스가 선택 안되었을경우.
            alert ( '삭제를 위해 선택된 항목이 존재 하지 않습니다.' );
            return;
        }

        if ( confirm ('\n\n선택된 자료와 연관된 \n\n등록 자료가 전부 삭제됩니다.\n\n한번 삭제된 자료는 복원할 수 없습니다.\n\n정말 삭제하시겟습니까?') ) {
            document.eventListForm.target       = ''      ;
            document.eventListForm.action       = ''      ;
            document.eventListForm.branch.value = 'exec'  ;
            document.eventListForm.gubun.value  = 'delete';
            document.eventListForm.submit();
        }
    }

    function copyChkData() {
        var chkNo    = document.eventListForm["chk_no[]"];
        var sourceId = document.eventListForm._dboard_s_id.value;
        if ( !isChecked ( chkNo ) ) { // 체크박스가 선택 안되었을경우.
            alert ( '복사할 이벤트을 선택해주세요.' );
            return;
        }
        if ( sourceId == '' ) {       // 스킨이 선택되지 않은 경우
            alert ( '원본 스킨을 지정해주세요.' );
            return;
        }

        if ( confirm ('\n'  + sourceId + '이벤트으로 선택된 이벤트의 속성을 변경하시겠습니까?') ) {
            document.eventListForm.target       = ''      ;
            document.eventListForm.action       = ''      ;
            document.eventListForm.branch.value = 'exec'  ;
            document.eventListForm.gubun.value  = 'copy_prop';
            document.eventListForm.submit();
        }
    }

    function insertData() {
        var title = document.eventForm.title.value;

        if ( title == '' ) { document.eventForm.title.focus(); return false; }

        if ( strLength(title) > 255 ) {
            alert ("255자이내로 입력해 주세요.");
            document.eventForm.title.focus();
            return false;
        }

        document.eventForm.branch.value = 'exec'  ;
        document.eventForm.gubun.value  = 'insert';
        return true;
    }

    function eventSort( sort, desc ) {
        document.PageForm.sort_exec.value = 'Y';
        document.PageForm.sort.value = sort;
        document.PageForm.desc.value = desc;
        document.PageForm.submit();
    }
//-->
</SCRIPT>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="808">
                  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC">

<form name='eventForm' method='post' onSubmit='return insertData();'>
    <input type='hidden' name='branch' value=''   >
    <input type='hidden' name='gubun'  value=''   >
                    <tr bgcolor="#FFFFFF" align="right"> 
                      <td colspan="8" height="45" class="text_01" background="images/top_14.gif"> 
                        이벤트 추가&nbsp;&nbsp; 
                        <input type="text" name="title" value=''>
                        <b> 
                        <input type='image' border="0" name="imageField32" src="images/button_bplus.gif" width="43" height="20" align="top">
                        &nbsp;&nbsp;</b></td>
                    </tr>
</form>
<?
        if ( $sort_exec == 'Y' ) { if ( $desc == 'desc' ) { $desc = 'asc' ; } else { $desc = 'desc'; } }
        $a_sort_no     ="<a href='#' onClick='eventSort(\"no\"     , \"$desc\");' onFocus='this.blur()'>";  // 번호
        $a_sort_title  ="<a href='#' onClick='eventSort(\"title\"  , \"$desc\");' onFocus='this.blur()'>";  // 번호
?>
<form name='eventListForm' method='post'>
    <input type='hidden' name='branch'   value=''>
    <input type='hidden' name='gubun'    value=''>
    <input type='hidden' name='event_id' value=''>
    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >
    <input type="hidden" name="chk_no[]" value=''>
                    <tr align="center" bgcolor="#FFFFFF"> 
                      <td width="40"  height="30" align="center"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td width="40"  align="center"><b><?=$a_sort_no?>번호</a></b></td>
                      <td             align="center"><b><?=$a_sort_title?>이벤트이름</a></b></td>
                      <td width="80"  align="center"><b>세부설정</b></td>
                      <td width="135" align="center"><b>권한 및 포인트설정</b></td>
                      <td             align="center"><b>결과    </b></td>
                      <td width="50"  align="center"><b>삭제</b></td>
                    </tr>
<?
$libDir = "admin/lib/" . $sysInfor['driver'] . '/';
    if ( !$how_many ) {
        $how_many = 10;
    } else {
        $how_many = (int)$how_many;
    }
    $page_many= 10;
    $more_many= $how_many;
    $s = ( !$s ) ? 1 : $s;

//  if ( $s >= $how_many + 1 ) { $cur_many = $more_many; } else { $cur_many = $how_many; }

    $sql = "select count(no) from $tb_event;";

    if ( !$tot ) { $tot = simpleSQLQuery($sql); }
    if ( $s > $tot ) {
        if ( $p_exec == "delete" ) { $s = $s - $how_many; if ( $s < 0 ) $s = 1; }
        else                       { $s = 1; }
    }
    include $libDir . "admin_event_list_main.php";
?>

                    <tr bgcolor="FDFDFD"> 
                      <td colspan="8" class="text_01" height="40">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td>&nbsp;&nbsp;&nbsp;<a href='#' onClick='deleteChkData();'><img src="images/x6.gif" width="177" height="17" align="absmiddle" border='0'></a></td>
                            <td align="right" class="text_01">
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>

</form>
<FORM  name='PageForm' METHOD=POST onSubmit="document.PageForm.s.value=1;">
    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >
    <input name="sort_exec" type='hidden' value='N'          >
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >
    <input name='exec'  type='hidden' value=''           >
                    <tr> 
                      <td bgcolor="#FFFFFF" colspan="8" height="50" align="right" class="text_01">
<?
include ( 'common/page_tab.inc' ); // 페이지 탭
// 페이지 탭 설정
// $page_tab['pre'      ] = "<font color='red' size='2'>[이전 $page_many]</font>";
// $page_tab['next'     ] = "<font color='red' size='2'>[이후 $page_many]</font>";
   $page_tab['pre'      ] = '이전';
   $page_tab['next'     ] = '다음';
   $page_tab['pre_1'    ] = "" ; // 이전
   $page_tab['next_1'   ] = "" ; // 이후
   $page_tab['page_sep' ] = "" ; // 페이지구분 기호
   $page_tab['page_start']= "["; // 페이지 표시 시작 [1] <<-- [
   $page_tab['page_end' ] = "]"; // 페이지 표시 끝   [1] <<-- ]
   $page_tab['page_pre' ] = "" ; // 페이지 앞 [*여기* 1]
   $page_tab['page_next' ]= "" ; // 페이지 뒤 [1 *여기*]
   $page_tab['page_start_active'] = "<font color='BF0909'>"; // 선택 페이지 앞쪽 태그
   $page_tab['page_end_active'  ] = "</font>";             // 선택 페이지 뒷쪽 태그

// $page_tab['page_start_first' ]= " ["; // 시작 페이지 시작 태그
// $page_tab['page_end_first'   ]= "] ... "; // 시작 페이지 뒷쪽 태그

// $page_tab['page_start_last'  ]= " ... ["; // 마지막 페이지 시작 태그
// $page_tab['page_end_last'    ]= "] "; // 마지막 페이지 뒷쪽 태그
    echo _pageTab ();
    echo "&nbsp;&nbsp; <input type='text' name='how_many' size='4' value='$how_many' style='text-align:right'>";
    echo "              <input type='image' src='images/button_page.gif' align='absmiddle'>&nbsp;";
?>

                      </td>
                    </tr>
</form>
        
                  </table>
                  <table border="0" cellspacing="0" cellpadding="0" height="100%">
                    <tr>
                      <td bgcolor="CCCCCC" width="1"></td>
                    </tr>
                  </table>
                </td>
                <td valign="top">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
                    <tr> 
                      <td bgcolor="CCCCCC" height="1"></td>
                    </tr>
                    <tr> 
                      <td>&nbsp;</td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>