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
            alert ("'����', '����', '_'�� �����ؼ� �Խ��� ���� �Է��� �ּ���.");
            document.pollForm.poll_id.focus();
            return;
        }
*/
        if ( strLength(title) > 255 ) {
            alert ("255���̳��� �Է��� �ּ���.");
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
        if ( confirm ('\n\n���� ���õ� �ڷ�� ������ \n\n���� ���� �׸��� ���� �����˴ϴ�.\n\n�ѹ� ������ �ڷ�� ������ �� �����ϴ�.\n\n���� �����Ͻðٽ��ϱ�?') ) {
            document.pollListForm.branch.value = 'exec'  ;
            document.pollListForm.gubun.value  = 'delete';

            document.pollListForm.submit();
        }
    }

    function deleteChkData() {
        var chkNo  = document.pollListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // üũ�ڽ��� ���� �ȵǾ������.
            alert ( '������ ���� ���õ� ���� ���簡 ���� ���� �ʽ��ϴ�.' );
            return;
        }

        if ( confirm ('\n\n���õ� �ڷ�� ������ \n\n���� ���� �׸��� ���� �����˴ϴ�.\n\n�ѹ� ������ �ڷ�� ������ �� �����ϴ�.\n\n���� �����Ͻðٽ��ϱ�?') ) {
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
                      <td colspan="7" height="45" class="text_01" background="images/top_04.gif">�� �������� �߰�&nbsp; 
                  <input type="text" name="title" value='<?=$title?>'  name="textfield22" size="50">
                        <b> 
                        <input type="image" border="0" name="imageField32" src="images/button_bplus.gif" width="43" height="20" align="top">
                        &nbsp; </b>
                        </td>
                    </tr>
</form>
<?
        if ( $sort_exec == 'Y' ) { if ( $desc == 'desc' ) { $desc = 'asc' ; } else { $desc = 'desc'; } }
        $a_sort_no     ="<a href='#' onClick='pollSort(\"no\"     , \"$desc\");' onFocus='this.blur()'>";  // ��ȣ
        $a_sort_title ="<a href='#' onClick='pollSort(\"title\"  , \"$desc\");' onFocus='this.blur()'>";  // ��ȣ
?>
<form name='pollListForm' method='post'>
    <input type='hidden' name='branch'   value=''   >
    <input type='hidden' name='gubun'    value=''   >
    <input type='hidden' name='poll_id'  value=''   >
    <input type="hidden" name="chk_no[]" value="">
                    <tr bgcolor="#FFFFFF"> 
                      <td width="50" height="30" align="center"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td width="50" align="center"><b><?=$a_sort_no?>��ȣ</a></b></td>
                      <td align="center" width="400"><b><?=$a_sort_title?>�������� ����</a></b></td>
                      <td width="100" align="center"><b>���μ���</b></td>
                      <td width="100" align="center"><b>���Ѽ���</b></td>
                      <td width="50" align="center"><b>����</b></td>
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
   $page_tab['page_start_active'] = "<font color='BF0909'><B>"; // ���� ������ ���� �±�
   $page_tab['page_end_active'  ] = "</B></font>";             // ���� ������ ���� �±�

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