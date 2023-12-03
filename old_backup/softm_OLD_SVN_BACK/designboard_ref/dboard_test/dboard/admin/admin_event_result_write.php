<?
if ( function_exists('head') ) {
    if ( $branch == 'result_write' && preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && preg_match( "/(admin_event.php)/", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
    //  logs ( '$user_id : ' . $user_id, true );
    //echo "select * from $tb_event_result_master where no = '$event_id' and user_id = '$user_id'";
        $row = singleRowSQLQuery("select * from $tb_event_result_master where no = '$event_id' and user_id = '$user_id'");
        $user_id    = $row['user_id'    ];
        $prize_yn   = $row['prize_yn'   ];
        $prize_point= $row['prize_point'];
        $join_date  = $row['join_date'  ];

        $row = singleRowSQLQuery("select * from $tb_member where user_id = '$user_id'");
        $name   = $row['name'   ];
        $tel    = $row['tel'    ];
        $post_cd = explode('-', $row['post_no']);
        $post_cd1 = $post_cd[0];
        $post_cd2 = $post_cd[1];
        $addr = explode('$$', $row['address']);
        $address        = $addr[0];
        $detail_address = $addr[1];
        $e_mail         = $row['e_mail' ];
        $home           = $row['home'   ];

        if ( !preg_match( '/http:\/\//i', $home ) ) $home = 'http://' . $home;
    ?>
    <script type='text/javascript'>
    <!--
        var pre_prize_point = '<?=$prize_point?>';
        function writeData() {
            var prizePoint = document.eventResultWriteForm.prize_point.value;
            var message = '';
                message = '현재회원을 당첨하시겠습니다. 회원 포인트가 ' + prizePoint + ' 포인트 추가됩니다.';
            var transfer = false;
            if ( pre_prize_point == 'N' && isChecked(document.eventResultWriteForm.prize_yn) ) {
                if ( confirm(message) ) { transfer = true; }
                else { transfer = false; }
            } else {
                transfer = true;
            }
            if ( transfer ) {
                objectDisabled ( document.eventResultWriteForm.prize_point ,'N'     );
            }
            return transfer;
        }

        function passwordEnabled() {
            if ( isChecked(document.eventResultWriteForm.prize_yn) ) {
                objectBackColor( document.eventResultWriteForm.prize_point, 'white'  );
                objectDisabled ( document.eventResultWriteForm.prize_point ,'N'     );
                document.eventResultWriteForm.prize_point.focus();
            } else {
                objectBackColor( document.eventResultWriteForm.prize_point, '#E1E1E1'  );
                objectDisabled ( document.eventResultWriteForm.prize_point ,'Y'     );
            }
        }

        var sign = 1; // 1 : 양수, 0 : 음수
        function signChange() {
            var obj = getObject('_d_sign');
                sign = sign * -1;
            if ( sign < 0 ) {
                obj.innerHTML = '<strong><font size="1">{-}</font></strong>';
            } else {
                obj.innerHTML = '<strong><font size="1">{+}</font></strong>';
            }
        }

        function mailSender(gubun) {
            var mailWin = window.open('about:blank','mailWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=500,height=465');
            mailWin.focus();
            document.eventCommForm.send.value = gubun;
            document.eventCommForm.target = 'mailWin';
            document.eventCommForm.action = 'admin/admin_member_nl_write.php';
            document.eventCommForm.submit();
        }
    //-->
    </SCRIPT>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name='dupChkForm' method='post' target='_dup_check' action='member_register_exec.php'>
        <input type='hidden' name='user_id'   value=''>
        <input type='hidden' name='gubun'     value='dup_check'>
    </form>

    <form name='eventCommForm' method='post' action='admin_event.php'>
        <input type='hidden' name='send'                value='2'            >
        <input type='hidden' name='user_id'             value='<?=$user_id?>'>
    </form>

    <form name='eventResultWriteForm' method='post' action='admin_event.php' onSubmit='return writeData();' enctype='multipart/form-data'>
        <input type='hidden' name='event_id'            value='<?=$event_id?>'              >
        <input type='hidden' name='user_id'             value='<?=$user_id?>'               >

        <input type='hidden' name='search_member_level' value='<?=$search_member_level?>'   >
        <input type='hidden' name='search_gb'           value='<?=$search_gb?>'             >
        <input type='hidden' name='search'              value='<?=$search?>'                >

        <input type='hidden' name='g_no[]'        value=''>
        <input type='hidden' name='key_seq[]'     value=''>
        <input type="hidden" name="choice_data[]" value=''>

        <input type='hidden' name='branch'  value='exec'           >
        <input type='hidden' name='gubun'   value='result_write'   >
                   <tr>
                    <td width="808">
                      <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC" class="text_01">
                        <tr bgcolor="#FFFFFF">
                          <td colspan="2" height="45" bgcolor="#FFFFFF" align="center" background="images/top_19.gif">&nbsp;</td>
                        </tr>
                        <tr>
                          <td bgcolor="FFFFFF" align="right" width="200" class="text_01"><font color="#333333">이벤트 당첨&nbsp;</font></td>
                          <td bgcolor="FFFFFF" class="text_01">&nbsp;
    <?
    $checked = ( $prize_yn == 'Y' ) ? "checked" : ''; // 공개
    ?>
                            <input type="checkbox" name="prize_yn"  value='Y' <?=$checked?> onClick='passwordEnabled()'> 당첨
                            <input type="text" name="prize_point"   value='<?=$prize_point?>' size='9' maxlength="10" onChange='if(!isNumber(this.value)){alert ("숫자를 입력해주세요."); this.value=0; return false;}' style='text-align:right;background:#E1E1E1' disabled> 포인트
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="FFFFFF" align="right" width="200" class="text_01"><font color="#333333">이름 / 연락처&nbsp;</font></td>
                          <td bgcolor="FFFFFF" class="text_01">&nbsp;&nbsp;
    <?=$name?> / <?=$tel?>

                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="FFFFFF" align="right" width="200" class="text_01"><font color="#333333">주소 / 우편번호&nbsp;</font></td>
                          <td bgcolor="FFFFFF" class="text_01">&nbsp;&nbsp;
    <?=$post_cd1?> - <?=$post_cd2?> / <?=$address?> <?=$detail_address?>
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="FFFFFF" align="right" width="200" class="text_01"><font color="#333333">이메일 / 홈페이지&nbsp;</font></td>
                          <td bgcolor="FFFFFF" class="text_01">&nbsp;&nbsp;
    <a href='#' onClick='mailSender("2");return false;' onFocus='this.blur()'><?=$e_mail?></a> / 
    <a href='<?=$home?>' onFocus='this.blur()' target='_new'><?=$home?></a>
                          </td>
                        </tr>

    <?
        $sql  = "select g_no, key_seq, choice_data from $tb_event_result_detail ";
        $where  = " where no      = '$event_id'";
        $where .= " and   user_id = '$user_id'" ;
        $sql .= $where;
        $sql .= ' order by g_no asc';
        $stmt_data = multiRowSQLQuery($sql);
        $detailCnt = 0;
        while ( $row_data = multiRowFetch  ($stmt_data) ) {
            $detailCnt++;
            $g_no       = $row_data['g_no'         ];
            $key_seq    = $row_data['key_seq'      ];
            $choice_data= $row_data['choice_data'  ];
            $value      = '';

            $sql  = "select item from $tb_event_item";
            $where  = " where no   = '$event_id'";
            $where .= " and   g_no = '$g_no'";
            $where .= " and   seq  = '0'";
            $sql .= $where;
    // echo $sql;
            $item = (int) simpleSQLQuery($sql);
            echo "<input type='hidden' name='g_no[]'    value='$g_no'>";
            echo "<input type='hidden' name='key_seq[]' value='$key_seq'>";
    // echo 'item : ' . $item;
    ?>
                        <tr>
                          <td bgcolor="FFFFFF" align="right" width="200" class="text_01"><font color="#333333">입력 항목 <?=$detailCnt?>&nbsp;</font></td>
                          <td bgcolor="FFFFFF" class="text_01">&nbsp;&nbsp;
    <?
            if ( $item < 5 ) {
                $sql  = "select no, g_no, seq, o_seq, item, item_name from $tb_event_item";
                $where  = " where no   = '$event_id'";
                $where .= " and   g_no  = '$g_no'";
                $sql .= $where;
                $sql .= ' order by g_no, o_seq asc';
                $stmt_detail = multiRowSQLQuery($sql);

                echo '<select name="choice_data[]">' . "\n";

                while ( $row_detail = multiRowFetch  ($stmt_detail) ) {
                    $no         = $row_detail['no'         ];
                    $g_no       = $row_detail['g_no'       ];
                    $seq        = $row_detail['seq'        ];
                    $o_seq      = $row_detail['o_seq'      ];
                    $item_name  = $row_detail['item_name'  ];
                    if ( $choice_data == $seq ) {
                        echo '<option value="' . $seq . '" selected>'. $item_name .'</option>'. "\n";
                    } else {
                        echo '<option value="' . $seq . '" >'. $item_name .'</option>'. "\n";
                    }
                }
                echo '</select >';
            } else {
               echo '<textarea type="text" name="choice_data[]" style="width:80%;height:50">' . $choice_data . '</textarea>'. "\n";
            }
    ?>
                          </td>
                        </tr>
    <?
        }
    ?>

                        <tr bgcolor="#FFFFFF">
                          <td colspan="3" height="30" align='right'>
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="right" height="5"></td>
                              </tr>
                              <tr>
                                <td align="right">
                                  <input type="image" border="0" name="imageField" src="images/button_ok3.gif" width="66" height="30" align='absmiddle'>
    <!--                               <a href='#' onClick='document.eventResultWriteForm.reset();return false;'><img border="0" name="imageField" src="images/cancel.gif" width="66" height="30"></a>&nbsp;&nbsp; -->
                                  <a href='admin_event.php?branch=result&event_id=<?=$event_id?>'><img border="0" name="imageField" src="images/cancel.gif" width="66" height="30" align='absmiddle'></a>&nbsp;&nbsp;
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>

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
    </form>
                </table>
    <?
    } // if END
    else {
        redirectPage("admin_event.php"); // 게시판 관리 (조회) 이동
    }
}
?>