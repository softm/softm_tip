<?
if ( function_exists('_head') ) {
?>
<SCRIPT LANGUAGE='javascript'>
<!--
    function insertData() {
        var title = document.pollForm.title.value;
        document.pollForm.branch.value = 'exec'  ;
        document.pollForm.gubun.value  = 'insert';

        if ( title == '' ) { document.pollForm.title.focus(); return false; }
/*
        if ( !isAlphaNum (bbsId) ) {
            alert ("'영문', '숫자', '_'를 조합해서 게시판 명을 입력해 주세요.");
            document.pollForm.poll_id.focus();
            return;
        }
*/
        if ( strLength(title) > 255 ) {
            alert ("255자이내로 입력해 주세요.");
            document.pollForm.title.focus();
            return false;
        }
        return true;
    }

    function moveItemGrantPage (pollId) {
        document.pollListForm.branch.value  = 'grant';
        document.pollListForm.poll_id.value = pollId;
        document.pollListForm.submit();
    }

    function moveItemSetupPage (pollId) {
        document.pollListForm.branch.value  = 'itemsetup';
        document.pollListForm.poll_id.value = pollId;
        document.pollListForm.submit();
    }

    function moveResultSetupPage (pollId) {
        document.pollListForm.branch.value  = 'resultsetup';
        document.pollListForm.poll_id.value = pollId;
        document.pollListForm.submit();
    }

    function checkedAll () {
        var chkNo  = document.pollListForm["chk_no[]"];
		var cnt = chkNo.length;
        for ( var i=1;i<cnt; i++ ) {
			chkNo[i].checked = !chkNo[i].checked;
        }
    }

    function deleteData(no) {
        var chkNo  = document.pollListForm["chk_no[]"];
        setCheckedAll ( chkNo, false ) ;
        objectChecked ( chkNo, no );
        if ( confirm ('\n\n현재 선택된 자료와 연관된 \n\n설문 조사 항목이 전부 삭제됩니다.\n\n한번 삭제된 자료는 복원할 수 없습니다.\n\n정말 삭제하시겟습니까?') ) {
            document.pollListForm.branch.value = 'exec'  ;
            document.pollListForm.gubun.value  = 'delete';

            document.pollListForm.submit();
        }
    }

    function deleteChkData() {
        var chkNo  = document.pollListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // 체크박스가 선택 안되었을경우.
            alert ( '삭제를 위해 선택된 설문 조사가 존재 하지 않습니다.' );
            return;
        }

        if ( confirm ('\n\n선택된 자료와 연관된 \n\n설문 조사 항목이 전부 삭제됩니다.\n\n한번 삭제된 자료는 복원할 수 없습니다.\n\n정말 삭제하시겟습니까?') ) {
            document.pollListForm.branch.value = 'exec'  ;
            document.pollListForm.gubun.value  = 'delete';
            document.pollListForm.submit();
        }
    }

    function pollSort( sort, desc ) {
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
<form name='pollForm' method='post' onSubmit='return insertData();'>
    <input type='hidden' name='branch' value=''   >
    <input type='hidden' name='gubun'  value=''   >
                    <tr bgcolor="#FFFFFF" align="right"> 
                      <td colspan="7" height="45" class="text_01" background="images/top_04.gif">새 설문조사 추가&nbsp; 
                  <input type="text" name="title" value='<?=$title?>'  name="textfield22" size="50">
                        <b> 
                        <input type="image" border="0" name="imageField32" src="images/button_bplus.gif" width="43" height="20" align="top">
                        &nbsp; </b>
                        </td>
                    </tr>
</form>
<?
        if ( $sort_exec == 'Y' ) { if ( $desc == 'desc' ) { $desc = 'asc' ; } else { $desc = 'desc'; } }
        $a_sort_no     ="<a href='#' onClick='pollSort(\"no\"     , \"$desc\");' onFocus='this.blur()'>";  // 번호
        $a_sort_title ="<a href='#' onClick='pollSort(\"title\"  , \"$desc\");' onFocus='this.blur()'>";  // 번호
?>
<form name='pollListForm' method='post'>
    <input type='hidden' name='branch'   value=''   >
    <input type='hidden' name='gubun'    value=''   >
    <input type='hidden' name='poll_id'  value=''   >
    <input type="hidden" name="chk_no[]" value="">
                    <tr bgcolor="#FFFFFF"> 
                      <td width="50" height="30" align="center"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td width="50" align="center"><b><?=$a_sort_no?>번호</a></b></td>
                      <td align="center" width="400"><b><?=$a_sort_title?>설문조사 제목</a></b></td>
                      <td width="100" align="center"><b>세부설정</b></td>
                      <td width="100" align="center"><b>권한설정</b></td>
                      <td width="50" align="center"><b>삭제</b></td>
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

    $sql = "select count(no) from $tb_poll_master;";

    if ( !$tot ) { $tot = simpleSQLQuery($sql); }
    if ( $s > $tot ) {
        if ( $p_exec == "delete" ) { $s = $s - $how_many; if ( $s < 0 ) $s = 1; }
        else                       { $s = 1; }
    }

    include $libDir . "admin_poll_list_main.php";
?>
                    <tr bgcolor="FDFDFD"> 
                      <td colspan="7" height="40" class="text_01">&nbsp;&nbsp;
                      <a href='#' onClick='deleteChkData();return false;'>
                      <img src="images/x2.gif" width="177" height="17" align="absmiddle" border='0'>
                      </a>
                      </td>
                    </tr>
    <input name='s'         type='hidden' value='<?=$s?>'       >
    <input name='tot'       type='hidden' value='<?=$tot?>'     >
    <input name='sort'      type='hidden' value='<?=$sort?>'    >
    <input name='desc'      type='hidden' value='<?=$desc?>'    >
</form>

<FORM  name='PageForm' METHOD=POST onSubmit="document.PageForm.s.value=1;">
    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >
    <input name="sort_exec" type='hidden' value='N'          >
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >
    <input name='exec'  type='hidden' value=''         >
                    <tr> 
                      <td bgcolor="#FFFFFF" colspan="7" height="50" align="right" class="text_01">
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
   $page_tab['page_start_active'] = "<font color='BF0909'><B>"; // 선택 페이지 앞쪽 태그
   $page_tab['page_end_active'  ] = "</B></font>";             // 선택 페이지 뒷쪽 태그

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
<?
}
?>