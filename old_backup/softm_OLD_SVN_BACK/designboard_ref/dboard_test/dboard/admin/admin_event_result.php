<?
if ( function_exists('head') ) {
?>
<script type='text/javascript'>
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

    function moveWritePage (eventId, userId) {
        document.eventListForm.target = '';
        document.eventListForm.action = 'admin_event.php';
        document.eventListForm.branch.value  = 'result_write';
        document.eventListForm.user_id.value  = userId;
        document.eventListForm.event_id.value = eventId;
        document.eventListForm.submit();
    }

    function checkedAll () {
        var chkNo  = document.eventListForm["chk_no[]"];

        for ( var i=1;i<chkNo.length; i++ ) {
            if ( chkNo[i].checked ) { 
                chkNo[i].checked = false;
            } else {
                chkNo[i].checked = true;
            }
        }
    }

    function deleteData(userId) {
        var chkNo  = document.eventListForm["chk_no[]"];
        setCheckedAll ( chkNo, false ) ;
        objectChecked ( chkNo, userId);
        if ( confirm ('���� ���õ� �ڷ�� ������ \n\n��� �ڷᰡ ���� ��� �˴ϴ�.\n\n�ѹ� ������ �ڷ�� ������ �� �����ϴ�.\n\n���� �����Ͻðٽ��ϱ�?') ) {
            document.eventListForm.target = '';
            document.eventListForm.branch.value = 'exec'  ;
            document.eventListForm.gubun.value  = 'result_delete';
            document.eventListForm.action = 'admin_event.php';
            document.eventListForm.submit();
        }
    }

    function deleteChkData() {
        var chkNo  = document.eventListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // üũ�ڽ��� ���� �ȵǾ������.
            alert ( '������ ���� ���õ� �׸��� ���� ���� �ʽ��ϴ�.' );
            return;
        }

        if ( confirm ('���õ� ȸ���� ���� ���� �˴ϴ�.\n\n�ѹ� ������ ȸ���� ������ �� �����ϴ�.\n\n���� �����Ͻðٽ��ϱ�?') ) {
            document.eventListForm.target = '';
            document.eventListForm.branch.value = 'exec'  ;
            document.eventListForm.gubun.value  = 'result_delete';
            document.eventListForm.action = 'admin_event.php';
            document.eventListForm.submit();
        }
    }

    function updateKindData() {
        var chkNo  = document.eventListForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // üũ�ڽ��� ���� �ȵǾ������.
            alert ( 'ȸ�� ������ ������ ȸ���� ������ �ּ���.' );
            return;
        }

        var idx = document.eventResultForm.update_member_level.selectedIndex;
        if ( idx == 0 ) { alert ( '������ ȸ�� ������ ������ �ּ���.' ); document.eventResultForm.update_member_level.focus(); return; }
        if ( confirm ('���õ� ȸ���� ' + document.eventResultForm.update_member_level[idx].text + ' (��)�� ���� �˴ϴ�.\n\n�����Ͻðٽ��ϱ�?') ) {
            document.eventListForm.update_member_level.value = document.eventResultForm.update_member_level.value;
            document.eventListForm.target = '';
            document.eventListForm.branch.value = 'exec'  ;
            document.eventListForm.gubun.value  = 'member_kind_update';
            document.eventListForm.action = 'admin_event.php';
            document.eventListForm.submit();
        }
    }

    function mailSender(gubun) {
        if ( gubun == '0' ) { // ���� ȸ�� �߼�
            var cnt = 0;
            var chkNo  = document.eventListForm["chk_no[]"];
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
        document.eventListForm.send.value = gubun;
        document.eventListForm.target = 'mailWin';
        var chkNo  = document.eventListForm["chk_no[]"];
        document.eventListForm.action = 'admin/admin_member_nl_write.php';
        document.eventListForm.submit();
    }

    function memberLevelSearch(memberLevel) {
        document.eventResultForm.search_member_level.value = memberLevel;
        document.eventResultForm.submit();
    }

    function memberSort( sort, desc ) {
        document.PageForm.sort.value = sort;
        document.PageForm.desc.value = desc;
        document.PageForm.submit();
    }

    function returnPage() {
        document.returnForm.submit();
    }
//-->
</SCRIPT>
<?
        if ( $desc == 'desc' ) { $desc = 'asc' ; } else { $desc = 'desc'; }
        $a_sort_name      ="<a href='#' onClick='memberSort(\"name\"     , \"$desc\");return false;' onFocus='this.blur()'>";  // �̸�
        $a_sort_user_id   ="<a href='#' onClick='memberSort(\"user_id\"  , \"$desc\");return false;' onFocus='this.blur()'>";  // ���̵�
        $a_sort_join_date ="<a href='#' onClick='memberSort(\"join_date\", \"$desc\");return false;' onFocus='this.blur()'>";  // ���� ����
?>

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name='returnForm' method='post' action='admin_event.php'>
    <input name='branch'    type='hidden' value='list'            >
    <input name='gubun'     type='hidden' value=''                >
    <input name='s'         type='hidden' value='<?=$s?>'         >
    <input name='tot'       type='hidden' value='<?=$tot?>'       >
    <input name='sort'      type='hidden' value='<?=$sort?>'      >
    <input name='desc'      type='hidden' value='<?=$desc?>'      >
</form>
              <tr>
                <td width="808">
                  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC">
                    <tr bgcolor="#FFFFFF"> 
                      <td height="45" colspan="9" align="right" class="text_01" background="images/top_16.gif"> 
                        <a href="#" onClick="moveSetupPage  (<?=$event_id?>);return false;"><img border="0" name="imageField422" src="images/button_poll_01.gif" width="66" height="30" align='absmiddle'></a>
                        <a href='#' onClick='moveGrantPage  (<?=$event_id?>);return false;'><img border="0" name="imageField422" src="images/button_poll_02.gif" width="66" height="30" align='absmiddle'></a>
                        <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField422" src="images/cancel.gif" width="66" height="30" align='absmiddle'></a>&nbsp;&nbsp;&nbsp;
                      </td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td height="27" align="center" class="text_01"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td align="center" class="text_01"><b>��ȣ</b></td>
                      <td class="text_01" align="center"><b><a href="#"><font color="BF0909"><?=$a_sort_name?>�̸�</a></font></a></b></td>
                      <td align="center" class="text_01"><b><?=$a_sort_user_id?>���̵�</a></b></td>
                      <td align="center" class="text_01"><strong><?=$a_sort_join_date?>������¥</a></strong></td>
                      <td align="center" class="text_01"><b>����</b></td>
                      <td align="center" class="text_01"><b>����</b></td>
                    </tr>
<form name='eventListForm' method='post'>
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >
    <input type='hidden' name='branch'   value=''  >
    <input type='hidden' name='gubun'    value=''  >
    <input type='hidden' name='event_id' value='<?=$event_id?>'  >
    <input type='hidden' name='user_id'  value=''  >
    <input type="hidden" name="send"     value=""  >
    <input type="hidden" name="chk_no[]" value=""  >
    <input name="search_member_level" type='hidden' value='<?=$search_member_level?>'  >
    <input name="update_member_level" type='hidden' value=''  >

    <input type='hidden' name='s'                   value='<?=$s?>'        >
    <input type='hidden' name='search_gb'           value='<?=$search_gb?>'>
    <input type='hidden' name='search'              value='<?=$search?>'   >
<?
$libDir = "admin/lib/" . $sysInfor['driver'] . '/';

    if ( !$how_many ) {
        $how_many = 10;
    } else {
        $how_many = (int)$how_many;
    }
    $page_many= 10;
    $s = ( !$s ) ? 1 : $s;
?>

<?
//  if ( $s >= $how_many + 1 ) { $cur_many = $more_many; } else { $cur_many = $how_many; }
    $sql  = "select count(*) from $tb_event_result_master a LEFT JOIN $tb_member b ";
    $where  = " on a.user_id = b.user_id";
    $where .= " where a.no = '$event_id'";

    if ( $search_prize_yn == 'Y' ) {
        $where .= " and a.prize_yn = 'Y'";
    }
    if ( $search ) {
        $insql  = "select a.user_id user_id from $tb_event_result_detail a, kyh_event_item b";
        $insql .= " where a.no   = '1'";
        $insql .= " and   a.no   = b.no";
        $insql .= " and   a.g_no = b.g_no";
        $insql .= " and ( a.choice_data like '". $search . "%' or ( b.item_name like '" . $search . "%' and a.choice_data = b.seq ) )";
        $insql .= " and   b.seq != 0";
        $insql .= " group by a.user_id;";
        $instmt = multiRowSQLQuery($insql);

        while ( $inrow = multiRowFetch  ($instmt) ) {
            $inUser .= " '". $inrow[user_id] ."'";
            $inUser .= " ,";
        }
        $inUser = substr ( $inUser, 0, strlen ($inUser) -1 );
        if ( $inUser ) $where .= " and a.user_id in ( $inUser )";
    }

    $sql .= $where;

    if ( !$tot ) { $tot = simpleSQLQuery($sql); }
    if ( $s > $tot ) {
        if ( $p_exec == "delete" ) { $s = $s - $how_many; if ( $s < 0 ) $s = 1; }
        else                       { $s = 1; }
    }

    include $libDir . "admin_event_result_list_main.php";
?>
</form>
                                <tr bgcolor="FDFDFD"> 
                                  <td colspan="9" class="text_01" height="40">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
<form name='eventResultForm' action='admin_event.php' method='post'>
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >
    <input type='hidden' name='branch'   value='result'  >
    <input type='hidden' name='gubun'    value=''  >
    <input type='hidden' name='event_id' value='<?=$event_id?>'  >
    <input type='hidden' name='how_many' value='<?=$how_many?>'   >
    <input name="search_member_level" type='hidden' value='<?=$search_member_level?>'  >
                                      <tr>
                                        <td>
                                        &nbsp;&nbsp;<a href='#' onClick='deleteChkData();return false;'><img src="images/xg1_4.gif" align="absmiddle" border='0'></a>
                                        </td>

                                        <td align="right">
<?
$checked = ( $search_prize_yn == 'Y' ) ? "checked" : ''; // ����
?>
                                          <input type="checkbox" name="search_prize_yn" value='Y' <?=$checked?>> ��÷�� &nbsp;
                                          <input type="text" name="search" size="11" value='<?=$search?>'>
                                          <b> 
                                          <input type="image" border="0" name="imageField3222" src="images/button_search.gif" width="43" height="20" align="top">&nbsp;</b>
                                          </td>
                                      </tr>
</form>
                                    </table>

                                  </td>
                                </tr>

<FORM  name='PageForm' METHOD=POST onSubmit="document.PageForm.s.value=1;">
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >
    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >
    <input name='exec'  type='hidden' value=''           >
    <input name="search_prize_yn" type='hidden' value='<?=$search_prize_yn?>'>
    <input name="search"    type='hidden' value='<?=$search?>'     >
    <input type='hidden' name='event_id'  value='<?=$event_id?>'   >
    <input type='hidden' name='branch'    value='result'   >
                    <tr> 
                      <td bgcolor="#FFFFFF" colspan="9" height="50" align="right" class="text_01">
                        <table width='100%' border="0" cellspacing="1" cellpadding="2" bgcolor="FFFFFF">
                            <tr>
                            <td>
                            <a href='#' onClick='mailSender("3");return false;' onFocus='this.blur()'><img src='images/c_mail.gif' border='0'></a>
                            <a href='#' onClick='mailSender("4");return false;' onFocus='this.blur()'><img src='images/a_mail2.gif' border='0'></a>
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
    echo _pageTab ( $s, $tot, $how_many, $how_many, $page_many, $_SERVER['PHP_SELF'], $page_tab );
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