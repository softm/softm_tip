<?
if ( function_exists('_head') ) {
?>
<SCRIPT LANGUAGE='javascript'>
<!--
    function moveGrantPage (no) {
        document.boardListForm.target       = '';
        document.boardListForm.action       = 'admin_board.php';
        document.boardListForm.branch.value = 'grant';
        document.boardListForm.no.value     = no     ;
        document.boardListForm.submit();
    }

    function moveSetupPage (no) {
        document.boardListForm.target       = '';
        document.boardListForm.method       = 'post';
        document.boardListForm.action       = 'admin_board.php';
        document.boardListForm.branch.value = 'setup';
        document.boardListForm.no.value     = no     ;
        document.boardListForm.submit();
    }

    function moveAbstractPage (no) {
        document.boardListForm.target       = '';
        document.boardListForm.action       = 'admin_board.php';
        document.boardListForm.branch.value = 'abstract';
        document.boardListForm.no.value     = no     ;
        document.boardListForm.submit();
    }

    function moveBackUpPage (no) {
        document.boardListForm.target       = '_dbbackup';
        document.boardListForm.action       = 'admin/lib/' + driver + '/admin_db_back_up.php';
        document.boardListForm.branch.value = 'exec';
        document.boardListForm.gubun.value  = 'bbs_back_up';
        document.boardListForm.no.value     = no     ;
        document.boardListForm.submit();
    }

    function checkedAll () {
        var chkNo  = document.boardListForm["chk_no[]"];
		var cnt = chkNo.length;
        for ( var i=1;i<cnt; i++ ) {
			chkNo[i].checked = !chkNo[i].checked;
        }
    }

    function deleteData(no,bbsId) {
        var chkNo  = document.boardListForm["chk_no[]"];
        setCheckedAll ( chkNo, false ) ;
        objectChecked ( chkNo, no  + '$$' + bbsId );
        if ( confirm ('\n\n현재 선택된 자료와 연관된 \n\n등록 자료가 전부 삭제됩니다.\n\n한번 삭제된 자료는 복원할 수 없습니다.\n\n정말 삭제하시겟습니까?') ) {
            document.boardListForm.target       = ''      ;
            document.boardListForm.action       = ''      ;
            document.boardListForm.branch.value = 'exec'  ;
            document.boardListForm.gubun.value  = 'delete';

            document.boardListForm.submit();
        }
    }

    function deleteChkData() {
        var chkNo  = document.boardListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // 체크박스가 선택 안되었을경우.
            alert ( '삭제를 위해 선택된 항목이 존재 하지 않습니다.' );
            return;
        }

        if ( confirm ('\n\n선택된 자료와 연관된 \n\n등록 자료가 전부 삭제됩니다.\n\n한번 삭제된 자료는 복원할 수 없습니다.\n\n정말 삭제하시겟습니까?') ) {
            document.boardListForm.target       = ''      ;
            document.boardListForm.action       = ''      ;
            document.boardListForm.branch.value = 'exec'  ;
            document.boardListForm.gubun.value  = 'delete';
            document.boardListForm.submit();
        }
    }

    function copyChkData() {
        var chkNo    = document.boardListForm["chk_no[]"];
        var sourceId = document.boardListForm._dboard_s_id.value;
        if ( !isChecked ( chkNo ) ) { // 체크박스가 선택 안되었을경우.
            alert ( '복사할 게시판을 선택해주세요.' );
            return;
        }
        if ( sourceId == '' ) { // 스킨이 선택되지 않은 경우
            alert ( '원본 스킨을 지정해주세요.' );
            return;
        }

        if ( confirm ('\n' + '선택된 게시판의 속성을 ' + sourceId + '게시판의 속성으로 변경하시겠습니까?') ) {
//      if ( confirm ('\n'  + sourceId + '게시판으로 선택된 게시판의 속성을 변경하시겠습니까?') ) {
            document.boardListForm.target       = ''      ;
            document.boardListForm.action       = ''      ;
            document.boardListForm.branch.value = 'exec'  ;
            document.boardListForm.gubun.value  = 'copy_prop';
            document.boardListForm.submit();
        }
    }

    function insertData() {
        var bbsId = document.boardForm.bbs_id.value;

        if ( bbsId == '' ) { document.boardForm.bbs_id.focus(); return false;}

        if ( inStrBlankCheck (bbsId) ) {
            alert ("공백 문자를 사용할 수 없습니다.");
            document.boardForm.bbs_id.focus();
            return false;
        }

        if ( !isAlphaNum (bbsId) ) {
            alert ("'영문', '숫자', '_'를 조합해서 게시판 명을 입력해 주세요.");
            document.boardForm.bbs_id.focus();
            return false;
        }

        if ( bbsId.length > 40 ) {
            alert ("40자이내로 입력해 주세요.");
            document.boardForm.bbs_id.focus();
            return false;
        }
        document.boardForm.branch.value = 'exec'  ;
        document.boardForm.gubun.value  = 'insert';
        return true;
    }

    function boardSort( sort, desc ) {
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

<form name='boardForm' method='post' onSubmit='return insertData();'>
    <input type='hidden' name='branch' value=''   >
    <input type='hidden' name='gubun'  value=''   >
                    <tr bgcolor="#FFFFFF" align="right"> 
                      <td colspan="8" height="45" class="text_01" background="images/top_01.gif"> 
                        게시판 추가&nbsp;&nbsp; 
                        <input type="text" name="bbs_id" value='<?=$bbs_id?>'>
                        <b> 
                        <input type='image' border="0" name="imageField32" src="images/button_bplus.gif" width="43" height="20" align="top">
                        &nbsp;&nbsp;</b></td>
                    </tr>
</form>
<?
        if ( $sort_exec == 'Y' ) { if ( $desc == 'desc' ) { $desc = 'asc' ; } else { $desc = 'desc'; } }
        $a_sort_no     ="<a href='#' onClick='boardSort(\"no\"     , \"$desc\");' onFocus='this.blur()'>";  // 번호
        $a_sort_bbs_id ="<a href='#' onClick='boardSort(\"bbs_id\" , \"$desc\");' onFocus='this.blur()'>";  // 번호
?>
<form name='boardListForm' method='post'>
    <input type='hidden' name='branch' value=''   >
    <input type='hidden' name='gubun'  value=''   >
    <input type='hidden' name='no'     value=''   >
    <input type="hidden" name="chk_no[]" value="">

                    <tr align="center" bgcolor="#FFFFFF"> 
                      <td width="40" height="30" align="center"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td width="40" align="center"><b><?=$a_sort_no?>번호</a></b></td>
                      <td align="center"><b><?=$a_sort_bbs_id?>게시판이름</a></b></td>
                      <td width="100" align="center"><b>세부설정</b></td>
                      <td width="100" align="center"><b>권한설정</b></td>
                      <td width="100" align="center"><b>게시물추출</b></td>
                      <td width="100" align="center"><b>백업</b></td>
                      <td width="100" align="center"><b>삭제</b></td>
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

    $sql = "select count(no) from $tb_bbs_infor;";

    if ( !$tot ) { $tot = simpleSQLQuery($sql); }
    if ( $s > $tot ) {
        if ( $p_exec == "delete" ) { $s = $s - $how_many; if ( $s < 0 ) $s = 1; }
        else                       { $s = 1; }
    }
    include $libDir . "admin_board_list_main.php";
?>
                    <tr bgcolor="FDFDFD"> 
                      <td colspan="8" class="text_01" height="40">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td>&nbsp;&nbsp;&nbsp;<a href='#' onClick='deleteChkData();'><img src="images/x.gif" width="177" height="17" align="absmiddle" border='0'></a></td>
                            <td align="right" class="text_01"> <img src="images/xg1.gif" align="absmiddle"> 
                              <select name="detail_pro" class="jm_01">
                                <option value='' >&nbsp;&nbsp;&nbsp;속성선택&nbsp;&nbsp;&nbsp;</option>
                                <option value='1'>전체설정</option>
                                <option value='2'>세부설정</option>
                                <option value='3'>상/하단 파일</option>
                                <option value='4'>권한설정</option>
                              </select>

                              <img src="images/xg1_2.gif" width="16" height="17" align="absmiddle">
<?
    $sql = "select no, bbs_id from $tb_bbs_infor order by no desc;";
    $stmt = multiRowSQLQuery($sql);
    $_rtn  = "\n<select name='_dboard_s_id' class='jm_01'>";
    $_rtn .= "<option value=''>&nbsp;&nbsp;게시판선택&nbsp;&nbsp;</option>";
    while ( $row = multiRowFetch  ($stmt) ) {
            if($bbsId==$row['bbs_id']) $select="selected"; else $select="";
            $_rtn .= "<option value=" . $row['bbs_id'] . " $select>". $row['bbs_id'] . "</option>";
    }
    $_rtn .= "</select>\n";
    echo $_rtn;
?>
                              <img src="images/xg1_3.gif" align="absmiddle"> 
                              <a href='#' onClick='copyChkData();return false;'><img src="images/button_m.gif" width="43" height="20" border='0' align="absmiddle"></a>&nbsp;&nbsp;</td>
                          </tr>
                        </table>
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
<?
}
?>