<?
if ( function_exists('head') ) {
?>
<script type='text/javascript'>
<!--
    function checkedAll () {
        var chkNo                   = document.pollGrantForm ["chk_no[]"               ];
        var updateYn                = document.pollGrantForm ["update_yn[]"            ];
        var grant_poll              = document.pollGrantForm ["grant_poll[]"           ];
        var grant_poll_result       = document.pollGrantForm ["grant_poll_result[]"    ];
        var grant_write             = document.pollGrantForm ["grant_write[]"          ];
        var grant_character_image   = document.pollGrantForm ["grant_character_image[]"];

        var grant         = document.pollGrantForm ["grant[]"        ];

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

            if ( grant_poll             [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_poll_result      [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_write            [i].checked ) { grant[i].value += 'Y$'; } else { grant[i].value += 'N$'; }
            if ( grant_character_image  [i].checked ) { grant[i].value += '1$'; } else { grant[i].value += '0$'; }
        }
    }

    function allCheckedToggle(idx) {
        var chkNo                   = document.pollGrantForm ["chk_no[]"               ];
        var updateYn                = document.pollGrantForm ["update_yn[]"            ];
        var grant_poll              = document.pollGrantForm ["grant_poll[]"           ];
        var grant_poll_result       = document.pollGrantForm ["grant_poll_result[]"    ];
        var grant_write             = document.pollGrantForm ["grant_write[]"          ];
        var grant_character_image   = document.pollGrantForm ["grant_character_image[]"];
        var member_level            = document.pollGrantForm ["member_level[]"         ];

        var grant         = document.pollGrantForm ["grant[]"        ];

        if ( grant_poll [idx].checked && grant_poll_result [idx].checked && grant_write[idx].checked ) { 
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

        if ( grant_poll             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_poll_result      [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_write            [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_character_image  [idx].checked ) { grant[idx].value += '1$'; } else { grant[idx].value += '0$'; }
    }

    function checkedToggle(idx) {
        var chkNo                   = document.pollGrantForm ["chk_no[]"               ];
        var updateYn                = document.pollGrantForm ["update_yn[]"            ];
        var grant_poll              = document.pollGrantForm ["grant_poll[]"           ];
        var grant_poll_result       = document.pollGrantForm ["grant_poll_result[]"    ];
        var grant_write             = document.pollGrantForm ["grant_write[]"          ];
        var grant_character_image   = document.pollGrantForm ["grant_character_image[]"];
        var member_level            = document.pollGrantForm ["member_level[]"         ];

        var grant         = document.pollGrantForm ["grant[]"        ];

        if ( chkNo[idx].checked ) { 
            grant_poll           [idx].checked = true;
            grant_poll_result    [idx].checked = true;
            grant_write          [idx].checked = true;
            if ( member_level [idx].value != 0 ) {
                grant_character_image[idx].checked = true;
            }
        } else {
            grant_poll           [idx].checked = false;
            grant_poll_result    [idx].checked = false;
            grant_write          [idx].checked = false;
            grant_character_image[idx].checked = false;
        }

        updateYn[idx].value = 'Y';
        grant[idx].value = '';

        if ( grant_poll             [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_poll_result      [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_write            [idx].checked ) { grant[idx].value += 'Y$'; } else { grant[idx].value += 'N$'; }
        if ( grant_character_image  [idx].checked ) { grant[idx].value += '1$'; } else { grant[idx].value += '0$'; }
    }

    function updateData() {
        document.pollGrantForm.target = '';
        document.pollGrantForm.branch.value = 'exec'  ;
        document.pollGrantForm.gubun.value  = 'grant_update';
        document.pollGrantForm.action       = 'admin_poll.php';
        document.pollGrantForm.submit();
    }

    function moveItemSetupPage (pollId) {
        document.pollGrantForm.branch.value  = 'itemsetup';
        document.pollGrantForm.poll_id.value = pollId;
        document.pollGrantForm.submit();
    }

    function returnPage() {
        document.pollGrantForm.branch.value   = 'list'    ;
        document.pollGrantForm.gubun.value    = ''        ;
        document.pollGrantForm.submit();
    }
//-->
</SCRIPT>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="808">
                  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC">
                    <tr> 
                      <td height="45" colspan="8" align="right" background="images/top_15.gif" bgcolor="#FFFFFF" class="text_01"> 
                        <a href='#' onClick='moveItemSetupPage (<?=$poll_id?>);return false;'><img border="0" name="imageField422" src="images/button_poll_01.gif" width="66" height="30" align="middle"></a>
                        <a href='#' onClick='updateData();return false;'><img src="images/confirm.gif" width="66" height="30" align="absmiddle" border='0'></a><a href='#' onClick='returnPage();return false;'><img src="images/cancel.gif" width="66" height="30" align="absmiddle" border='0'></a>&nbsp;&nbsp; </td>
                      </td>
                    </tr>
<?
    $poll_data = singleRowSQLQuery("select title, grant_character_image from $tb_poll_master where no = '$poll_id';");

    $poll_title     = $poll_data['title'                ];
    $grantCharStr   = $poll_data['grant_character_image'];
?>
                    <tr> 
                      <td height="30" colspan="2" align="center" bgcolor="F7F7F7" class="text_01">설문제목</td>
                      <td colspan="6" bgcolor="#FFFFFF" class="text_01">
                      <strong>&nbsp;
                      <font face="TAHOMA">
                      <a href='#' onClick="popWindow ( 'dpoll.php?poll_id=<?=$poll_id?>' , '', '', -1, -1, 'poll_<?=$row['no']?>', 'toolbar=yes,menubar=yes,resizable=yes,scrollbars=yes,location=yes');return false;">
                      <span class="text_04"><?=$poll_title?></span></a></font>
                      </strong>
                      </td>
                    </tr>

                    <tr bgcolor="#FFFFFF"> 
                      <td width="40" height="30" align="center" class="text_01"><b><a href="#" onClick='checkedAll();return false;'>c</a></b></td>
                      <td width="40" align="center" class="text_01"><b>번호</b></td>
                      <td class="text_01" align="center" width="518"><b>회원종류</b></td>
                      <td width="100" align="center" class="text_01"><b>포인트</b></td>
                      <td width="100" align="center" class="text_01"><b>투표화면</b></td>
                      <td width="100" align="center" class="text_01"><b>투표결과</b></td>
                      <td width="100" align="center" class="text_01"><b>의견쓰기</b></td>
                      <td width="130" align="center" class="text_01"><b>회원아이콘</b></td>
                    </tr>

<form name='pollGrantForm' method='post'>
    <input type='hidden' name='poll_id' value='<?=$poll_id?>'   >
    <input type='hidden' name='branch'  value=''   >
    <input type='hidden' name='gubun'   value=''   >

    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >
    <input name='sort'  type='hidden' value='<?=$sort?>' >
    <input name='desc'  type='hidden' value='<?=$desc?>' >

    <input type='hidden' name='update_yn[]'             value=""   >
    <input type="hidden" name="chk_no[]"                value=""  >
    <input type="hidden" name="member_level[]"          value=""  >
    <input type="hidden" name="grant[]"                 value=""  >
    <input type="hidden" name="grant_poll[]"            value=""  >
    <input type="hidden" name="grant_poll_result[]"            value=""  >
    <input type="hidden" name="grant_write[]"           value=""  >
    <input type="hidden" name="grant_character_image[]" value=""  >

<?
$libDir = "admin/lib/" . $sysInfor['driver'] . '/';

//  if ( $s >= $how_many + 1 ) { $cur_many = $more_many; } else { $cur_many = $how_many; }

    $sql  = "select COUNT( member_level ) from $tb_poll_grant";
    $sql .= " where no           = '$poll_id'";
    $sql .= ' and   member_level != 99 and member_level != 0 ';
    $tot = simpleSQLQuery($sql);

    include $libDir . "admin_poll_grant_main.php";
?>
                                <tr bgcolor="FDFDFD"> 
                                  <td colspan="20" height="40" class="text_01">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
                                      <td colspan="3" height="40" class="text_01">
&nbsp;<a href="#" onClick="var win = window.open('admin/admin_poll_popup_point_grant_list.php?poll_id=<?=$poll_id?>&member_level=all','point_win','scrollbars=yes,top=40,left=95,width=420,height=228');win.focus();return false;"><img src='images/all_point_setup.gif' border='0'></a>
                                      </td>
                                      <td height="49" bgcolor="#FFFFFF" class="text_01" align="right"> &nbsp;&nbsp;
                                        <a href='#' onClick='moveItemSetupPage (<?=$poll_id?>);return false;'><img border="0" name="imageField422" src="images/button_poll_01.gif" width="66" height="30" align="middle"></a>
                                        <a href='#' onClick='updateData();return false;'><img src="images/confirm.gif" width="66" height="30" align="absmiddle" border='0'></a><a href='#' onClick='returnPage();return false;'><img src="images/cancel.gif" width="66" height="30" align="absmiddle" border='0'></a>&nbsp;&nbsp; </td>
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