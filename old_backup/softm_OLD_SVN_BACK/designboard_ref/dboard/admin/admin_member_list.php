<?
if ( function_exists('_head') ) {
?>
<SCRIPT LANGUAGE='javascript'>
<!--
    function moveWritePage (userId) {
        document.memberListForm.target = '';
        document.memberListForm.action = 'admin_member.php';
        document.memberListForm.branch.value  = 'write';
        document.memberListForm.user_id.value = userId ;
        document.memberListForm.submit();
    }

    function checkedAll () {
        var chkNo  = document.memberListForm["chk_no[]"];
		var cnt = chkNo.length;
        for ( var i=1;i<cnt; i++ ) {
			chkNo[i].checked = !chkNo[i].checked;
        }
    }

    function deleteData(userId) {
        var chkNo  = document.memberListForm["chk_no[]"];
        setCheckedAll ( chkNo, false ) ;
        objectChecked ( chkNo, userId);
        if ( confirm ('���� ���õ� �ڷ�� ������ \n\n��� �ڷᰡ ���� ��� �˴ϴ�.\n\n�ѹ� ������ �ڷ�� ������ �� �����ϴ�.\n\n���� �����Ͻðٽ��ϱ�?') ) {
            document.memberListForm.target = '';
            document.memberListForm.branch.value = 'exec'  ;
            document.memberListForm.gubun.value  = 'delete';
            document.memberListForm.action = 'admin_member.php';
            document.memberListForm.submit();
        }
    }

    function deleteChkData() {
        var chkNo  = document.memberListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // üũ�ڽ��� ���� �ȵǾ������.
            alert ( '������ ���� ���õ� �׸��� ���� ���� �ʽ��ϴ�.' );
            return;
        }

        if ( confirm ('���õ� ȸ���� ���� ���� �˴ϴ�.\n\n�ѹ� ������ ȸ���� ������ �� �����ϴ�.\n\n���� �����Ͻðٽ��ϱ�?') ) {
            document.memberListForm.target = '';
            document.memberListForm.branch.value = 'exec'  ;
            document.memberListForm.gubun.value  = 'delete';
            document.memberListForm.action = 'admin_member.php';
            document.memberListForm.submit();
        }
    }

    function updateKindData() {
        var chkNo  = document.memberListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // üũ�ڽ��� ���� �ȵǾ������.
            alert ( 'ȸ�� ������ ������ ȸ���� ������ �ּ���.' );
            return;
        }

        var idx = document.memberForm.update_member_level.selectedIndex;
        if ( idx == 0 ) { alert ( '������ ȸ�� ������ ������ �ּ���.' ); document.memberForm.update_member_level.focus(); return; }
        if ( confirm ('���õ� ȸ���� ' + document.memberForm.update_member_level[idx].text + ' (��)�� ���� �˴ϴ�.\n\n�����Ͻðٽ��ϱ�?') ) {
            document.memberListForm.update_member_level.value = document.memberForm.update_member_level.value;
            document.memberListForm.target = '';
            document.memberListForm.branch.value = 'exec'  ;
            document.memberListForm.gubun.value  = 'member_kind_update';
            document.memberListForm.action = 'admin_member.php';
            document.memberListForm.submit();
        }
    }

    function mailSender(gubun) {
        if ( gubun == '0' ) { // ���� ȸ�� �߼�
            var cnt = 0;
            var chkNo  = document.memberListForm["chk_no[]"];
            for ( var i=1;i<chkNo.length; i++ ) {
                if ( chkNo[i].checked ) { cnt++; }
            }
            if ( cnt > 300 ) {
                alert ( '����ȸ�� �߼��� �ѹ��� 300�� �̻� �Ͻ� �� �����ϴ�.' );
                return false;
            }
        }
        var mailWin = window.open('about:blank','mailWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=500,height=465');
        mailWin.focus();
        document.memberListForm.send.value = gubun;
        document.memberListForm.target = 'mailWin';
        var chkNo  = document.memberListForm["chk_no[]"];
        document.memberListForm.action = 'admin/admin_member_nl_write.php';
        document.memberListForm.submit();
    }

    function memberLevelSearch(memberLevel) {
        document.memberForm.tot.value = '';
        document.memberForm.search_member_level.value = memberLevel;
        document.memberForm.submit();
    }

    function memberSort( sort, desc ) {
        document.PageForm.sort_exec.value = 'Y';
        document.PageForm.sort.value = sort;
        document.PageForm.desc.value = desc;
        document.PageForm.submit();
    }

    function searchForm() {
        document.memberForm.tot.value = '';
        document.memberForm.submit();
    }
//-->
</SCRIPT>
<?
        if ( $sort_exec == 'Y' ) { if ( $desc == 'desc' ) { $desc = 'asc' ; } else { $desc = 'desc'; } }
        $a_sort_name     ="<a href='#' onClick='memberSort(\"name\"    , \"$desc\");return false;' onFocus='this.blur()'>";  // �̸�
        $a_sort_user_id  ="<a href='#' onClick='memberSort(\"user_id\" , \"$desc\");return false;' onFocus='this.blur()'>";  // ���̵�
        $a_sort_reg_date ="<a href='#' onClick='memberSort(\"reg_date\", \"$desc\");return false;' onFocus='this.blur()'>";  // ���� ����
        $a_sort_point    ="<a href='#' onClick='memberSort(\"point\"   , \"$desc\");return false;' onFocus='this.blur()'>";  // ���� ����
?>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="808">
                  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC">
                        <tr bgcolor="#FFFFFF"> 
                          <td colspan="10" height="45" class="text_01" background="images/top_03.gif" align="right"> 
<a href='admin_member.php?branch=kind'><img border="0" src="images/button_member_add.gif" width="79" height="30" align="absmiddle"></a>
<a href='<?=$libDir?>admin_db_back_up.php?branch=exec&gubun=member_back_up' target='_dbbackup'><img border="0" src="images/button_member_backup.gif" width="79" height="30" align="absmiddle"></a>
                          </td>
                        </tr>

                        <tr>
                          <td height="30" bgcolor="#FFFFFF" class="text_01" align="center"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                          <td bgcolor="#FFFFFF" class="text_01" align="center"><b>��ȣ</b></td>
                          <td bgcolor="#FFFFFF" class="text_01" align="center"><b><?=$a_sort_name?>�̸�</a></b></td>
                          <td bgcolor="#FFFFFF" class="text_01" align="center"><b><?=$a_sort_user_id?>���̵�</a></b></td>
                          <td bgcolor="#FFFFFF" class="text_01" align="center"><b><?=$a_sort_point?>����Ʈ</a></b></td>
                          <td bgcolor="#FFFFFF" align="center" class="text_01">
                          <select name="search_member_level" onChange="memberLevelSearch(this.value);" class="jm_01">
<?
$checked = ( !$search_member_level ) ? "selected" : ''; // ȸ�� ���� ( ������ )
echo "<option value='' $checked> - ��ü - </option>\n";
$libDir = "admin/lib/" . $sysInfor['driver'] . '/';

$kind = singleRowSQLQuery("select member_level, member_nm, etc from $tb_member_kind where member_level = 99;");
$member_level = $kind['member_level' ];
$member_nm    = $kind['member_nm'    ];
$checked = ( $member_level == $search_member_level ) ? "selected" : ''; // ȸ�� ���� ( ������ )

echo "<option value='" . $member_level . "' $checked>". $member_nm ."</option>\n";
/*
$kind = singleRowSQLQuery("select member_level, member_nm, etc from $tb_member_kind where member_level = 0;");
$member_level = $kind['member_level' ];
$member_nm    = $kind['member_nm'    ];
$checked = ( $row['member_level'] == $member_level ) ? "selected" : ''; // ȸ�� ���� ( ��ȸ�� )
echo "<option value='" . $member_level . "' $checked>". $member_nm ."</option>\n";
*/
$sql  = "select member_level, member_nm, etc from $tb_member_kind ";
$sql .= ' where member_level != 99 && member_level != 0 ';
$sql .= ' order by reg_date ';
$stmt = multiRowSQLQuery($sql);

while ( $kind = multiRowFetch  ($stmt) ) {
    $member_level = $kind['member_level' ];
    $member_nm    = $kind['member_nm'    ];
    $checked = ( $member_level == $search_member_level ) ? "selected" : ''; // ȸ�� ���� ( ��ȸ�� )
    echo "<option value='" . $member_level . "' $checked>". $member_nm ."</option>\n";
}
?>
</select>
                          </td>
                          <td bgcolor="#FFFFFF" class="text_01" align="center"><b><?=$a_sort_reg_date?>������</a></b></td>
                          <td bgcolor="#FFFFFF" class="text_01" align="center"><b>����</b></td>
                          <td bgcolor="#FFFFFF" class="text_01" align="center"><b>����</b></td>
                        </tr>
<form name='memberListForm' method='post'>
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >
    <input type='hidden' name='branch'  value=''   >
    <input type='hidden' name='gubun'   value=''   >
    <input type='hidden' name='user_id' value=''   >
    <input type="hidden" name="send"     value=""  >
    <input type="hidden" name="chk_no[]" value=""  >
    <input name="search_member_level" type='hidden' value='<?=$search_member_level?>'  >
    <input name="update_member_level" type='hidden' value=''  >

    <input type='hidden' name='search_gb'           value='<?=$search_gb?>'>
    <input type='hidden' name='search'              value='<?=$search?>'   >
    <input name="search_member_level" type='hidden' value='<?=$search_member_level?>'  >
<?
    if ( !$how_many ) {
        $how_many = 10;
    } else {
        $how_many = (int)$how_many;
    }
    $page_many= 10;
    $more_many= $how_many;
    $s = ( !$s ) ? 1 : $s;
?>

<?
//  if ( $s >= $how_many + 1 ) { $cur_many = $more_many; } else { $cur_many = $how_many; }
    $sql  = "select count(a.user_id) from $tb_member a LEFT JOIN $tb_member_kind b";
    $where  = " on a.member_level = b.member_level";
    $where .= " where   a.user_id != ''";
    if ( $search_gb ) {
        if ( $search_gb == 'point' ) {
            $search = (int) $search;
            if ( $search > 0 ) {
                $where .= " and a.point >= '" . $search . "'";
            } else {
                $search = '';
            }
        } else {
            $where .= " and a." . $search_gb . " LIKE '" . $search . "%'";
        }
    } else {
        $where .= " and ( a.name LIKE '" . $search . "%' or a.user_id LIKE '" . $search . "%' )";
    }

    if ( $search_member_level ) {
        $where .= " and a.member_level = '" . $search_member_level . "'";
    }

    $sql .= $where;

    if ( !$tot ) { $tot = simpleSQLQuery($sql); }
    if ( $s > $tot ) {
        if ( $p_exec == "delete" ) { $s = $s - $how_many; if ( $s < 0 ) $s = 1; }
        else                       { $s = 1; }
    }

    include $libDir . "admin_member_list_main.php";
?>
    <input type='hidden' name='s'                   value='<?=$s?>'        >
    <input type='hidden' name='tot'                 value='<?=$tot?>'      >
</form>
                                <tr bgcolor="FDFDFD"> 
                                  <td colspan="10" class="text_01" height="40">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

<form name='memberForm' action='admin_member.php' method='post' onSubmit='searchForm(); return false;'>
    <input name='branch'    type='hidden' value=''           >
    <input name="sort_exec" type='hidden' value='N'          >
    <input name='sort'      type='hidden' value='<?=$sort?>' >
    <input name='desc'      type='hidden' value='<?=$desc?>' >
    <input name='s'         type='hidden' value='<?=$s?>'    >
    <input name='tot'       type='hidden' value='<?=$tot?>'  >
    <input name='exec'      type='hidden' value=''           >
    <input name="search_member_level" type='hidden' value='<?=$search_member_level?>'  >
    <input name='how_many'  type='hidden' value='<?=$how_many?>'   >
                                      <tr>
                                        <td>
                                        &nbsp;&nbsp;<a href='#' onClick='deleteChkData();return false;'><img src="images/x3.gif" width="177" height="17" align="absmiddle" border='0'></a>
                                        <img src="images/xm1.gif" width="130" height="17" align="absmiddle" border='0'>
<select name="update_member_level" class="jm_01">
<?
echo "<option value=''> - ���� - </option>\n";
$kind = singleRowSQLQuery("select member_level, member_nm, etc from $tb_member_kind where member_level = 99;");
$member_level = $kind['member_level' ];
$member_nm    = $kind['member_nm'    ];

echo "<option value='" . $member_level . "'>". $member_nm ."</option>\n";

$sql  = "select member_level, member_nm, etc from $tb_member_kind ";
$sql .= ' where member_level != 99 && member_level != 0 ';
$sql .= ' order by reg_date ';
$stmt = multiRowSQLQuery($sql);

while ( $kind = multiRowFetch  ($stmt) ) {
    $member_level = $kind['member_level' ];
    $member_nm    = $kind['member_nm'    ];
    echo "<option value='" . $member_level . "'>". $member_nm ."</option>\n";
}
?>
</select>
                                        <a href='#' onClick='updateKindData();return false;'><img src="images/button_m.gif" width="43" height="20" align="absmiddle" border='0'></a>
                                        </td>

                                        <td align="right">
                                          <select name="search_gb" class="jm_01">
                                              <option value=''selected> --- ���� --- </option>
                                              <option value='name'    >�̸�</option>
                                              <option value='user_id' >���̵�</option>
                                              <option value='point'   >����Ʈ (�̻�)</option>
                                          </select>
                                          <input type="text" name="search" size="11" value='<?=$search?>'>
                                          <b> 
                                          <input type="image" border="0" name="imageField3222" src="images/button_search.gif" width="43" height="20" align="top">&nbsp;</b>
                                          </td>
                                      </tr>
</form>
                                    </table>

                                  </td>
                                </tr>

<FORM  name='PageForm' METHOD=POST onSubmit="">
    <input name="sort_exec" type='hidden' value='N'          >
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >
    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >
    <input name='exec'  type='hidden' value=''           >
    <input name="search_member_level" type='hidden' value='<?=$search_member_level?>'  >
    <input name="search_gb" type='hidden' value='<?=$search_gb?>'  >
    <input name="search"    type='hidden' value='<?=$search?>'     >

                    <tr> 
                      <td bgcolor="#FFFFFF" colspan="10" height="50" align="right" class="text_01">
                        <table width='100%' border="0" cellspacing="1" cellpadding="2" bgcolor="FFFFFF">
                            <tr>
                            <td>
                            <a href='#' onClick='mailSender("0");return false;' onFocus='this.blur()'><img src='images/c_mail.gif' border='0'></a>
                            <a href='#' onClick='mailSender("1");return false;' onFocus='this.blur()'><img src='images/a_mail.gif' border='0'></a>
                            </td>
                            <td align='right'>
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
                        </table>
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