<?
if ( function_exists('head') ) {
?>
<script type='text/javascript'>
<!--
    function checkedAll () {
        var chkNo  = document.memberKindForm["chk_no[]"];

        for ( var i=1;i<chkNo.length; i++ ) {
            if ( chkNo[i].checked ) { 
                chkNo[i].checked = false;
            } else {
                if ( !chkNo[i].disabled ) chkNo[i].checked = true;
            }
        }
    }
    function updateToggle(idx) {
        var point     = document.memberKindForm["point[]"];
        if ( isNumber(point[idx].value) ) {
            var updateYn  = document.memberKindForm["update_yn[]"];
            updateYn[idx].value = 'Y';
        } else {
            point[idx].focus();
            alert ( '포인트 입력이 올바르지 않습니다.');
            point[idx].value = 0;
            return false;
        }
    }

    function updateData() {
        document.memberKindForm.target = '';
        document.memberKindForm.branch.value = 'exec'  ;
        document.memberKindForm.gubun.value  = 'kind_update';
        document.memberKindForm.action = 'admin_member.php';
        document.memberKindForm.submit();
    }

    function deleteData(member_level) {
        var chkNo  = document.memberKindForm["chk_no[]"];
        setCheckedAll ( chkNo, false ) ;
        objectChecked ( chkNo, member_level);
        if ( confirm ('한번 삭제된 자료는 복원할 수 없습니다.\n\n정말 삭제하시겟습니까?') ) {
            document.memberKindForm.target = '';
            document.memberKindForm.branch.value = 'exec'  ;
            document.memberKindForm.gubun.value  = 'kind_delete';
            document.memberKindForm.action = 'admin_member.php';
            document.memberKindForm.submit();
        }
    }

    function deleteChkData() {
        var chkNo  = document.memberKindForm["chk_no[]"];
        if ( !isChecked ( chkNo ) ) { // 체크박스가 선택 안되었을경우.
            alert ( '삭제를 위해 선택된 항목이 존재 하지 않습니다.' );
            return;
        }

        if ( confirm ('한번 삭제된 자료는 복원할 수 없습니다.\n\n정말 삭제하시겟습니까?') ) {
            document.memberKindForm.target = '';
            document.memberKindForm.branch.value = 'exec'  ;
            document.memberKindForm.gubun.value  = 'kind_delete';
            document.memberKindForm.action = 'admin_member.php';
            document.memberKindForm.submit();
        }
    }

    function insertData() {
        var member_nm = document.memberForm.member_nm.value;
        if ( member_nm  == '' ) { document.memberForm.member_nm.focus(); return false;}
        document.memberForm.branch.value = 'exec'  ;
        document.memberForm.gubun.value  = 'kind_insert';

        if ( strLength(member_nm) > 100 ) {
            alert ("40자이내로 입력해 주세요.");
            document.memberForm.member_nm.focus();
            return false;
        }
        return true;
    }
//-->
</SCRIPT>

            <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
               <tr> 
                <td width="808" valign='top'> 
                  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC">
<form name='memberForm' method='post' onSubmit='return insertData();' action='admin_member.php'>
    <input type='hidden' name='branch' value=''   >
    <input type='hidden' name='gubun'  value=''   >
                    <tr bgcolor="#FFFFFF"> 
                      <td colspan="6" height="45" class="text_01" background="images/top_11.gif" align="right"> 
                        회원종류 추가&nbsp;&nbsp; 
                        <input type="text" name="member_nm" size="20" maxlength='100'>
                        <input type="image" border="0" name="imageField32" src="images/button_bplus.gif" width="43" height="20" align="top">
                        &nbsp;&nbsp;&nbsp;</td>
                    </tr>
</form>

                    <tr bgcolor="#FFFFFF"> 
                      <td width="40" height="30" align="center" class="text_01"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td width="40" align="center" class="text_01"><b>코드</b></td>
                      <td class="text_01" align="center" width="158"><b>회원종류</b></td>
                      <td class="text_01" align="center" width="400"><b>비고</b></td>
                      <td class="text_01" align="center" width="130"><b>로그인 포인트</b></td>
                      <td width="40" align="center" class="text_01"><b>삭제</b></td>
                    </tr>

<form name='memberKindForm' method='post'>
    <input type='hidden' name='branch'  value=''   >
    <input type='hidden' name='gubun'   value=''   >
    <input type="hidden" name="chk_no[]" value=""  >
    <input type='hidden' name='member_level[]'  value=""   >
    <input type='hidden' name='update_yn[]'     value=""   >
    <input type="hidden" name="member_nm[]"     value=""   >
    <input type="hidden" name="etc[]"           value=''   >
    <input type="hidden" name="point[]"         value=''   >
<?
$libDir = "admin/lib/" . $sysInfor['driver'] . '/';

//  if ( $s >= $how_many + 1 ) { $cur_many = $more_many; } else { $cur_many = $how_many; }

    $sql  = "select count(member_level) from $tb_member_kind";
    $sql .= ' where member_level != 99 && member_level != 0 ';
    $tot = simpleSQLQuery($sql);
    include $libDir . "admin_member_kind_main.php";
?>
                                <tr bgcolor="FDFDFD"> 
                                  <td colspan="6" height="40" class="text_01">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
                                      <td colspan="3" height="40" class="text_01">
                                      &nbsp;&nbsp;<a href='#' onClick='deleteChkData();return false;'><img src="images/x5.gif" align="absmiddle" border='0'></a></td>
                                      <td height="49" bgcolor="#FFFFFF" class="text_01" align="right"> 
                                      &nbsp;&nbsp;<a href='#' onClick='updateData();return false;'><img src="images/confirm.gif" width="66" height="30" align="absmiddle" border='0'></a>&nbsp;&nbsp; </td>
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
          </td>
        </tr>
      </table>
<?
}
?>