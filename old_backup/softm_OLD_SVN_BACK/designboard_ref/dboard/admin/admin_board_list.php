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
        if ( confirm ('\n\n���� ���õ� �ڷ�� ������ \n\n��� �ڷᰡ ���� �����˴ϴ�.\n\n�ѹ� ������ �ڷ�� ������ �� �����ϴ�.\n\n���� �����Ͻðٽ��ϱ�?') ) {
            document.boardListForm.target       = ''      ;
            document.boardListForm.action       = ''      ;
            document.boardListForm.branch.value = 'exec'  ;
            document.boardListForm.gubun.value  = 'delete';

            document.boardListForm.submit();
        }
    }

    function deleteChkData() {
        var chkNo  = document.boardListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // üũ�ڽ��� ���� �ȵǾ������.
            alert ( '������ ���� ���õ� �׸��� ���� ���� �ʽ��ϴ�.' );
            return;
        }

        if ( confirm ('\n\n���õ� �ڷ�� ������ \n\n��� �ڷᰡ ���� �����˴ϴ�.\n\n�ѹ� ������ �ڷ�� ������ �� �����ϴ�.\n\n���� �����Ͻðٽ��ϱ�?') ) {
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
        if ( !isChecked ( chkNo ) ) { // üũ�ڽ��� ���� �ȵǾ������.
            alert ( '������ �Խ����� �������ּ���.' );
            return;
        }
        if ( sourceId == '' ) { // ��Ų�� ���õ��� ���� ���
            alert ( '���� ��Ų�� �������ּ���.' );
            return;
        }

        if ( confirm ('\n' + '���õ� �Խ����� �Ӽ��� ' + sourceId + '�Խ����� �Ӽ����� �����Ͻðڽ��ϱ�?') ) {
//      if ( confirm ('\n'  + sourceId + '�Խ������� ���õ� �Խ����� �Ӽ��� �����Ͻðڽ��ϱ�?') ) {
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
            alert ("���� ���ڸ� ����� �� �����ϴ�.");
            document.boardForm.bbs_id.focus();
            return false;
        }

        if ( !isAlphaNum (bbsId) ) {
            alert ("'����', '����', '_'�� �����ؼ� �Խ��� ���� �Է��� �ּ���.");
            document.boardForm.bbs_id.focus();
            return false;
        }

        if ( bbsId.length > 40 ) {
            alert ("40���̳��� �Է��� �ּ���.");
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
                        �Խ��� �߰�&nbsp;&nbsp; 
                        <input type="text" name="bbs_id" value='<?=$bbs_id?>'>
                        <b> 
                        <input type='image' border="0" name="imageField32" src="images/button_bplus.gif" width="43" height="20" align="top">
                        &nbsp;&nbsp;</b></td>
                    </tr>
</form>
<?
        if ( $sort_exec == 'Y' ) { if ( $desc == 'desc' ) { $desc = 'asc' ; } else { $desc = 'desc'; } }
        $a_sort_no     ="<a href='#' onClick='boardSort(\"no\"     , \"$desc\");' onFocus='this.blur()'>";  // ��ȣ
        $a_sort_bbs_id ="<a href='#' onClick='boardSort(\"bbs_id\" , \"$desc\");' onFocus='this.blur()'>";  // ��ȣ
?>
<form name='boardListForm' method='post'>
    <input type='hidden' name='branch' value=''   >
    <input type='hidden' name='gubun'  value=''   >
    <input type='hidden' name='no'     value=''   >
    <input type="hidden" name="chk_no[]" value="">

                    <tr align="center" bgcolor="#FFFFFF"> 
                      <td width="40" height="30" align="center"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td width="40" align="center"><b><?=$a_sort_no?>��ȣ</a></b></td>
                      <td align="center"><b><?=$a_sort_bbs_id?>�Խ����̸�</a></b></td>
                      <td width="100" align="center"><b>���μ���</b></td>
                      <td width="100" align="center"><b>���Ѽ���</b></td>
                      <td width="100" align="center"><b>�Խù�����</b></td>
                      <td width="100" align="center"><b>���</b></td>
                      <td width="100" align="center"><b>����</b></td>
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
                                <option value='' >&nbsp;&nbsp;&nbsp;�Ӽ�����&nbsp;&nbsp;&nbsp;</option>
                                <option value='1'>��ü����</option>
                                <option value='2'>���μ���</option>
                                <option value='3'>��/�ϴ� ����</option>
                                <option value='4'>���Ѽ���</option>
                              </select>

                              <img src="images/xg1_2.gif" width="16" height="17" align="absmiddle">
<?
    $sql = "select no, bbs_id from $tb_bbs_infor order by no desc;";
    $stmt = multiRowSQLQuery($sql);
    $_rtn  = "\n<select name='_dboard_s_id' class='jm_01'>";
    $_rtn .= "<option value=''>&nbsp;&nbsp;�Խ��Ǽ���&nbsp;&nbsp;</option>";
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
include ( 'common/page_tab.inc' ); // ������ ��
// ������ �� ����
// $page_tab['pre'      ] = "<font color='red' size='2'>[���� $page_many]</font>";
// $page_tab['next'     ] = "<font color='red' size='2'>[���� $page_many]</font>";
   $page_tab['pre'      ] = '����';
   $page_tab['next'     ] = '����';
   $page_tab['pre_1'    ] = "" ; // ����
   $page_tab['next_1'   ] = "" ; // ����
   $page_tab['page_sep' ] = "" ; // ���������� ��ȣ
   $page_tab['page_start']= "["; // ������ ǥ�� ���� [1] <<-- [
   $page_tab['page_end' ] = "]"; // ������ ǥ�� ��   [1] <<-- ]
   $page_tab['page_pre' ] = "" ; // ������ �� [*����* 1]
   $page_tab['page_next' ]= "" ; // ������ �� [1 *����*]
   $page_tab['page_start_active'] = "<font color='BF0909'>"; // ���� ������ ���� �±�
   $page_tab['page_end_active'  ] = "</font>";             // ���� ������ ���� �±�

// $page_tab['page_start_first' ]= " ["; // ���� ������ ���� �±�
// $page_tab['page_end_first'   ]= "] ... "; // ���� ������ ���� �±�

// $page_tab['page_start_last'  ]= " ... ["; // ������ ������ ���� �±�
// $page_tab['page_end_last'    ]= "] "; // ������ ������ ���� �±�
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