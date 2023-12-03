<?
if ( function_exists('head') ) {
?>
<script type='text/javascript'>
<!--
    function checkedAll () {
        var chkNo                   = document.boardGrantForm ["chk_no[]"               ];
        var updateYn                = document.boardGrantForm ["update_yn[]"            ];
        var grant_list              = document.boardGrantForm ["grant_list[]"           ];
        var grant_view              = document.boardGrantForm ["grant_view[]"           ];
        var grant_write             = document.boardGrantForm ["grant_write[]"          ];
        var grant_answer            = document.boardGrantForm ["grant_answer[]"         ];
        var grant_comment           = document.boardGrantForm ["grant_comment[]"        ];
        var grant_down              = document.boardGrantForm ["grant_down[]"           ];
        var grant_character_image   = document.boardGrantForm ["grant_character_image[]"];

        var grant         = document.boardGrantForm ["grant[]"        ];

        for ( var i=1;i<chkNo.length; i++ ) {
            if ( chkNo[i].checked ) { 
                if ( !chkNo[i].disabled ) {
                    chkNo[i].checked = false;
                    checkedToggle(i);
                }
            } else {
                if ( !chkNo[i].disabled ) {
                    chkNo[i].checked = true;
                    checkedToggle(i);
                }
            }

            updateYn[i].value = 'Y';
            grant[i].value    = '' ;

            if ( grant_list             [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_view             [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_write            [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_answer           [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_comment          [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_down             [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_character_image  [i].checked ) { grant[i].value += '1$'; } else { grant[i].value += '0$'; }
        }
    }

    function allCheckedToggle(idx) {
        var chkNo                   = document.boardGrantForm ["chk_no[]"               ];
        var updateYn                = document.boardGrantForm ["update_yn[]"            ];
        var grant_list              = document.boardGrantForm ["grant_list[]"           ];
        var grant_view              = document.boardGrantForm ["grant_view[]"           ];
        var grant_write             = document.boardGrantForm ["grant_write[]"          ];
        var grant_answer            = document.boardGrantForm ["grant_answer[]"         ];
        var grant_comment           = document.boardGrantForm ["grant_comment[]"        ];
        var grant_down              = document.boardGrantForm ["grant_down[]"           ];
        var grant_character_image   = document.boardGrantForm ["grant_character_image[]"];
        var member_level            = document.boardGrantForm ["member_level[]"         ];

        var grant         = document.boardGrantForm ["grant[]"        ];

        if ( grant_list [idx].checked && grant_view [idx].checked && grant_write[idx].checked && grant_answer[idx].checked && grant_comment[idx].checked && grant_down[idx].checked ) {
            if ( member_level [idx].value == 0 ) {
                chkNo[idx].checked = true;
            } else {
                if ( grant_character_image[idx].checked ) { 
                    chkNo[idx].checked = true;
                } else {
                    chkNo[idx].checked = true;
                }
            }
        } else {
            chkNo[idx].checked = false;
        }

        updateYn[idx].value = 'Y';
        grant[idx].value    = '' ;

        if ( grant_list             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_view             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_write            [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_answer           [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_comment          [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_down             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_character_image  [idx].checked ) { grant[idx].value += '1$'; } else { grant[idx].value += '0$'; }
    }

    function checkedToggle(idx) {
        var chkNo                   = document.boardGrantForm ["chk_no[]"               ];
        var updateYn                = document.boardGrantForm ["update_yn[]"            ];
        var grant_list              = document.boardGrantForm ["grant_list[]"           ];
        var grant_view              = document.boardGrantForm ["grant_view[]"           ];
        var grant_write             = document.boardGrantForm ["grant_write[]"          ];
        var grant_answer            = document.boardGrantForm ["grant_answer[]"         ];
        var grant_comment           = document.boardGrantForm ["grant_comment[]"        ];
        var grant_down              = document.boardGrantForm ["grant_down[]"           ];
        var grant_character_image   = document.boardGrantForm ["grant_character_image[]"];
        var member_level            = document.boardGrantForm ["member_level[]"         ];

        var grant         = document.boardGrantForm ["grant[]"        ];

        if ( chkNo[idx].checked ) { 
            grant_list           [idx].checked = true;
            grant_view           [idx].checked = true;
            grant_write          [idx].checked = true;
            grant_answer         [idx].checked = true;
            grant_comment        [idx].checked = true;
            grant_down           [idx].checked = true;
            if ( member_level [idx].value != 0 ) {
                grant_character_image[idx].checked = true;
            }
        } else {
            grant_list           [idx].checked = false;
            grant_view           [idx].checked = false;
            grant_write          [idx].checked = false;
            grant_answer         [idx].checked = false;
            grant_comment        [idx].checked = false;
            grant_down           [idx].checked = false;
            grant_character_image[idx].checked = false;
        }

        updateYn[idx].value = 'Y';
        grant[idx].value = '';

        if ( grant_list             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_view             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_write            [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_answer           [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_comment          [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_down             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_character_image  [idx].checked ) { grant[idx].value += '1$'; } else { grant[idx].value += '0$'; }
    }

    function updateData() {
        document.boardGrantForm.target = '';
        document.boardGrantForm.branch.value = 'exec'  ;
        document.boardGrantForm.gubun.value  = 'grant_update';
        document.boardGrantForm.action = 'admin_board.php';
        document.boardGrantForm.submit();
    }

    function moveSetupPage (no) {
        document.boardGrantForm.target       = '';
        document.boardGrantForm.method       = 'get';
        document.boardGrantForm.action       = 'admin_board.php';
        document.boardGrantForm.branch.value = 'setup';
        document.boardGrantForm.no.value     = no     ;
        document.boardGrantForm.submit();
    }

    function moveAbstractPage (no) {
        document.boardGrantForm.target       = '';
        document.boardGrantForm.action       = 'admin_board.php';
        document.boardGrantForm.branch.value = 'abstract';
        document.boardGrantForm.no.value     = no        ;
        document.boardGrantForm.submit();
    }

    function returnPage() {
        document.boardGrantForm.branch.value   = 'list'    ;
        document.boardGrantForm.gubun.value    = ''        ;
        document.boardGrantForm.submit();
    }
//-->
</SCRIPT>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="808">
                  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC">
                    <tr bgcolor="#FFFFFF"> 
                      <td colspan="20" height="45" class="text_01" background="images/top_10.gif" align="right"> 
                          <a href='#' onClick='moveSetupPage    (<?=$no?>);return false;'><img border="0" name="imageField4222" src="images/button_poll_01.gif" width="66" height="30" align="absmiddle"></a>
                          <a href='#' onClick='moveAbstractPage (<?=$no?>);return false;'><img border="0" name="imageField42222" src="images/button_poll_03.gif" width="66" height="30" align="absmiddle"></a>
                          <a href='#' onClick='updateData();return false;'><img src="images/confirm.gif" width="66" height="30" align="absmiddle" border='0'></a>
                          <a href='#' onClick='returnPage();return false;'><img src="images/cancel.gif" width="66" height="30" align="absmiddle" border='0'></a>&nbsp;&nbsp;
                      </td>
                    </tr>
<?
    $bbs_data = singleRowSQLQuery("select bbs_id, grant_character_image from $tb_bbs_infor where no = '$no';");
    $bbs_id         = $bbs_data['bbs_id'               ];
    $grantCharStr   = $bbs_data['grant_character_image'];
?>
                    <tr bgcolor="#FFFFFF"> 
                      <td height="30" colspan="2" align="center" class="text_01">게시판이름</td>
                      <td colspan="18" class="text_01">
                      <strong>&nbsp;
                      <font face="TAHOMA"><a href="dboard.php?id=<?=$bbs_id?>" target='_dboard<?=$bbs_id?>'><span class="text_04"><?=$bbs_id?></span></a></font>
                      </strong>
                      </td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td width="40" height="30" align="center" class="text_01"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td width="40" align="center" class="text_01"><b>번호</b></td>
                      <td class="text_01" align="center"><b>회원종류</b></td>

                      <td width="70" align="center" class="text_01"><b>포인트</b></td>
                      <td width="70" align="center" class="text_01"><b>목록</b></td>
                      <td width="70" align="center" class="text_01"><b>읽기</b></td>
                      <td width="70" align="center" class="text_01"><b>쓰기</b></td>
                      <td width="70" align="center" class="text_01"><b>답글</b></td>
                      <td width="70" align="center" class="text_01"><b>의견글</b></td>
                      <td width="70" align="center" class="text_01"><b>다운</b></td>
                      <td width="70" align="center" class="text_01"><b>회원아이콘</b></td>
                    </tr>

<form name='boardGrantForm' method='post'>
    <input type='hidden' name='no'      value='<?=$no?>'   >
    <input type='hidden' name='branch'  value=''   >
    <input type='hidden' name='gubun'   value=''   >
    <input name='s'         type='hidden' value='<?=$s?>'         >
    <input name='tot'       type='hidden' value='<?=$tot?>'       >
    <input name='sort'      type='hidden' value='<?=$sort?>'      >
    <input name='desc'      type='hidden' value='<?=$desc?>'      >
    <input type='hidden' name='update_yn[]'             value=""   >
    <input type="hidden" name="chk_no[]"                value=""  >
    <input type="hidden" name="member_level[]"          value=""  >
    <input type="hidden" name="grant[]"                 value=""  >
    <input type="hidden" name="grant_list[]"            value=""  >
    <input type="hidden" name="grant_view[]"            value=""  >
    <input type="hidden" name="grant_write[]"           value=""  >
    <input type="hidden" name="grant_answer[]"          value=""  >
    <input type="hidden" name="grant_comment[]"         value=""  >
    <input type="hidden" name="grant_down[]"            value=""  >
    <input type="hidden" name="grant_character_image[]" value=""  >

<?
$libDir = "admin/lib/" . $sysInfor['driver'] . '/';

//  if ( $s >= $how_many + 1 ) { $cur_many = $more_many; } else { $cur_many = $how_many; }

    $sql  = "select count(member_level) from $tb_bbs_grant";
    $sql .= " where no           = '$no'";
    $sql .= ' and   member_level != 99 and member_level != 0 ';

    $tot = simpleSQLQuery($sql);

    include $libDir . "admin_board_grant_main.php";
?>
                                <tr bgcolor="FDFDFD"> 
                                  <td colspan="20" height="40" class="text_01">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
                                      <td colspan="3" height="40" class="text_01" align='left'>
&nbsp;<a href="#" onClick="var win = window.open('admin/admin_board_popup_point_grant_list.php?bbs_id=<?=$bbs_id?>&member_level=all','point_win','scrollbars=yes,top=40,left=95,width=420,height=325');win.focus();return false;"><img src='images/all_point_setup.gif' border='0'></a>
                                      </td>
                                      <td height="49" bgcolor="#FFFFFF" class="text_01" align="right"> 
                                      &nbsp;&nbsp;
                          <a href='#' onClick='moveSetupPage    (<?=$no?>);return false;'><img border="0" name="imageField4222" src="images/button_poll_01.gif" width="66" height="30" align="absmiddle"></a>
                          <a href='#' onClick='moveAbstractPage (<?=$no?>);return false;'><img border="0" name="imageField42222" src="images/button_poll_03.gif" width="66" height="30" align="absmiddle"></a>
                          <a href='#' onClick='updateData();return false;'><img src="images/confirm.gif" width="66" height="30" align="absmiddle" border='0'></a>
                          <a href='#' onClick='returnPage();return false;'><img src="images/cancel.gif" width="66" height="30" align="absmiddle" border='0'></a>&nbsp;&nbsp;
                                      </td>
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