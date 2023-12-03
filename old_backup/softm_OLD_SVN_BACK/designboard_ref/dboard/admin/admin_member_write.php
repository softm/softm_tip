<?
if ( function_exists('_head') ) {
    if ( $branch == 'write' && ereg($HTTP_HOST,$HTTP_REFERER) && ereg( "(admin_member.php)$", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
    //  logs ( '$user_id : ' . $user_id, true );
        $row = singleRowSQLQuery("select * from $tb_member where user_id = '$user_id'");
?>
    <SCRIPT LANGUAGE='javascript'>
    <!--
        function dupCheck() {
            var userId = document.memberWriteForm.user_id.value;
            if (  memberIdCheck(userId) ) {
                document.dupChkForm.user_id.value = userId;
                var dupWin = window.open('about:blank','dupChkWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=200,height=150');
                dupWin.focus();
                document.dupChkForm.target = 'dupChkWin';
                document.dupChkForm.submit();
            }
        }

        function memberIdCheck(userId) {
            if ( userId.length < 4 || userId.length > 20 ) {
                alert("아이디는 4자 이상, 20자 이하여야 합니다.");
                document.memberWriteForm.user_id.focus();
                return false;
            }

            if ( inStrBlankCheck (userId) ) {
                alert ("아이디가 입력되지 않았거나 공백 문자를 사용하셨습니다.");
                document.memberWriteForm.user_id.focus();
                return false;
            }

            if ( !isAlphaNum (userId) ) {
                alert ("'영문', '숫자', '_'로만 아이들 작성해 주세요.");
                document.memberWriteForm.user_id.focus();
                return false;
            }

            if ( userId.length > 40 ) {
                alert ("40자이내로 입력해 주세요.");
                document.memberWriteForm.user_id.focus();
                return false;
            }
            return true;
        }

        function writeData() {
            var userId = document.memberWriteForm.user_id.value;
            if (  document.memberWriteForm.member_st.value == '9' ) {
                if ( confirm('회원을 탈퇴 처리 하시겠습니까?') ) { return true; }
                else { return false; }
            } else {
                if (  memberIdCheck(userId) ) {
                    if ( isChecked(document.memberWriteForm.password_change) ) {
                        if ( inStrBlankCheck (document.memberWriteForm.password) ) {
                            alert ("비밀 번호 입력을 확인해 주세요.");
                            document.memberWriteForm.password.focus();
                            return false;
                        }
                        if ( document.memberWriteForm.password.value != document.memberWriteForm.confirm_password.value ) {
                            alert ("비밀 번호가 일치 하지 않습니다.");
                            document.memberWriteForm.confirm_password.focus();
                            return false;
                        }
                    }
        /*
                    if ( inStrBlankCheck (document.memberWriteForm.name) ) {
                        alert ("이름 입력을 확인해 주세요.");
                        document.memberWriteForm.name.focus();
                        return false;
                    }
                    if ( !isChecked (document.memberWriteForm.sex) ) {
                        alert ("성별을 선택해 주세요.");
                        document.memberWriteForm.sex[0].focus();
                        return false;
                    }
        */
                    if ( document.memberWriteForm.e_mail.value != '' && !isEmail(document.memberWriteForm.e_mail) ) {
                        alert ("이메일 입력을 확인해 주세요.");
                        document.memberWriteForm.e_mail.focus();
                        return false;
                    }
        /*
                    if ( !juminCheck (document.memberWriteForm.jumin_1.value, document.memberWriteForm.jumin_2.value) ) {
                        alert ("주민번호 입력을 확인해 주세요.");
                        document.memberWriteForm.jumin_1.focus();
                        return false;
                    }
        */
                    return true;
                } else {
                    return false;
                }
            }
        }

        function passwordEnabled() {
            if ( isChecked(document.memberWriteForm.password_change) ) {
                objectBackColor( document.memberWriteForm.password, 'white'  );
                objectDisabled ( document.memberWriteForm.password ,'N'     );
                objectBackColor( document.memberWriteForm.confirm_password,'white' );
                objectDisabled ( document.memberWriteForm.confirm_password,'N'     );
                document.memberWriteForm.password.focus();
            } else {
                objectBackColor( document.memberWriteForm.password, '#E1E1E1'  );
                objectDisabled ( document.memberWriteForm.password ,'Y'     );
                objectBackColor( document.memberWriteForm.confirm_password,'#E1E1E1'  );
                objectDisabled ( document.memberWriteForm.confirm_password,'Y'     );
                document.memberWriteForm.password.value = '';
                document.memberWriteForm.confirm_password.value = '';
            }
        }

        var systemDate = '<?=date ( "YmdHis" )?>';
        function birthDateCheck () {
    /*
            var birth_year  = paddingChar(document.memberWriteForm.birth_year.value   ,4,'x');
            var birth_month = paddingChar(document.memberWriteForm.birth_month.value  ,2,'x');
            var birth_day   = paddingChar(document.memberWriteForm.birth_day.value    ,2,'x');
    */
            var birth_year  = document.memberWriteForm.birth_year.value ;
            var birth_month = document.memberWriteForm.birth_month.value;
            var birth_day   = document.memberWriteForm.birth_day.value  ;
    /*
            if ( birth_year  == 'xxxx' ) birth_year  = '';
            if ( birth_month == 'xx'   ) birth_month = '';
            if ( birth_day   == 'xx'   ) birth_day   = '';
    */
            var birth_date  = birth_year + birth_month + birth_day;
            if ( birth_date.length == 8 ) {
                var _age = age ( birth_date, systemDate );
                if ( ( !isDate(birth_date) || _age < 0 ) ) { alert('생년월일이 올바르지 않습니다.1'); return false; } 
            } else {
                birth_year  = paddingChar(birth_year , 4,'0');
                birth_month = paddingChar(birth_month, 2,'0');
                birth_day   = paddingChar(birth_day  , 2,'0');
                birth_date  = birth_year + birth_month + birth_day;
                var _age = age ( birth_date, systemDate );
    //          alert ( birth_date );
    //          alert ( _age       );
                if ( _age < 0 ) { alert('생년월일이 올바르지 않습니다.2'); return false; } 
            }

            document.memberWriteForm.birth.value = birth_date;
            document.memberWriteForm.age.value   = _age;
            return true;
        }

        function returnPage() {
            document.returnForm.submit();
        }
    //-->
    </SCRIPT>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name='dupChkForm' method='post' target='_dup_check' action='member_register_exec.php'>
        <input type='hidden' name='user_id'   value=''>
        <input type='hidden' name='gubun'     value='dup_check'>
    </form>

    <form name='returnForm' method='post' action='admin_member.php'>
        <input name='branch'    type='hidden' value='list'            >
        <input name='gubun'     type='hidden' value=''                >
        <input name='s'         type='hidden' value='<?=$s?>'         >
        <input name='tot'       type='hidden' value='<?=$tot?>'       >
        <input name="sort_exec" type='hidden' value='N'               >
        <input name='sort'      type='hidden' value='<?=$sort?>'      >
        <input name='desc'      type='hidden' value='<?=$desc?>'      >
        <input name='search_gb' type='hidden' value='<?=$search_gb?>' >
        <input name="search"    type='hidden' value='<?=$search?>'    >
        <input name="search_member_level" type='hidden' value='<?=$search_member_level?>'>
    </form>
    <form name='memberWriteForm' method='post' action='admin_member.php' onSubmit='return writeData();' enctype='multipart/form-data'>
        <input type='hidden' name='branch'  value='exec'           >
        <input type='hidden' name='gubun'   value='update'         >
        <input name='s'         type='hidden' value='<?=$s?>'         >
        <input name='tot'       type='hidden' value='<?=$tot?>'       >
        <input name='sort'      type='hidden' value='<?=$sort?>'      >
        <input name='desc'      type='hidden' value='<?=$desc?>'      >
        <input name='search_gb' type='hidden' value='<?=$search_gb?>' >
        <input name="search"    type='hidden' value='<?=$search?>'    >
        <input name="search_member_level" type='hidden' value='<?=$search_member_level?>'>
                   <tr>
                    <td width="808">
                      <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC" class="text_01">
                        <tr bgcolor="#FFFFFF">
                          <td colspan="2" height="45" bgcolor="#FFFFFF" align="center" background="images/top_09.gif">&nbsp;</td>
                        </tr>
                        <tr>
                          <td bgcolor="F7F7F7" align="right" width="150"><b>아이디&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <input type="text" name="user_id" value='<?=$row['user_id']?>' maxlength="20" readonly>
                            <select name='member_st' class="jm_01">
<?
    $checked = ( $row['member_st'] == 1 ) ? "selected" : ''; // 사용
    echo "<option value='1' $checked>사용     </option>";
    $checked = ( $row['member_st'] == 0 ) ? "selected" : ''; // 사용 정지
    echo "<option value='0' $checked>사용 정지</option>";
    $checked = ( $row['member_st'] == 9 ) ? "selected" : ''; // 탈퇴
    echo "<option value='9' $checked>탈퇴     </option>";
?>
                            </select>
<?
    $checked = ( $row['user_id_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="user_id_open"   value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>


                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>회원 종류&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <select name='member_level' class="jm_01">
<?
    $sql  = "select member_level, member_nm, etc from $tb_member_kind";
    $sql .= ' where member_level != 0 ';
    $sql .= ' order by member_level ';
    $stmt = multiRowSQLQuery($sql);
    echo "<option value=''> - 선택 - </option>\n";
    while ( $kind = multiRowFetch  ($stmt) ) {
        $member_level = $kind['member_level' ];
        $member_nm    = $kind['member_nm'    ];
        $checked = ( $row['member_level'] == $member_level ) ? "selected" : ''; // 회원 레벨 ( 비회원 )
        echo "<option value='" . $member_level . "' $checked>". $member_nm ."</option>\n";
    }
?>
<?
    $checked = ( $row['member_level_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="member_level_open" value='Y'<?=$checked?>> 공개
                            </select>
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>주민번호&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <input type="text" value='' name="jumin" maxlength="20" style='background:#E1E1E1' disabled>
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>비밀번호&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <input type="password" value='' name="password" maxlength="20" style='background:#E1E1E1' disabled>
                            비밀 번호 변경 <input type="checkbox" value='Y' name="password_change" onClick='passwordEnabled()'>
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>비밀번호확인&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <input type="password" value='' name="confirm_password" maxlength="20" style='background:#E1E1E1' disabled>
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>힌트 / 답변&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <select name='hint'>
                                <option value=''  >----------- 힌트 선택 -----------</option>
                                <option value='1' >나의 보물 제1호는?             </option>
                                <option value='2' >가장 친한 친구 이름은?         </option>
                                <option value='3' >내가 제일 좋아하는 연예인은?   </option>
                                <option value='4' >내 별명은?                     </option>
                                <option value='5' >좋아하는 색은?                 </option>
                            </select>
                            <input type='text' name='answer' maxlength="100" value='<?=$row['answer']?>'>
                          </td>
                        </tr>
    <SCRIPT LANGUAGE="JavaScript">
    <!--
        objectSelected( document.memberWriteForm.hint, '<?=$row['hint']?>' );
    //-->
    </SCRIPT>
                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>이름&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01"> &nbsp;&nbsp;
                            <input type="text" name="name" value='<?=$row['name']?>' maxlength="20">
<?
    $checked = ( $row['name_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="name_open" value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>별명&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01"> &nbsp;&nbsp;
                            <input type="text" name="nick_name" value='<?=$row['nick_name']?>' maxlength="20">
<?
    $checked = ( $row['nick_name_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="nick_name_open" value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>성별&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
<?
        if ( $row['sex'] == 1 ) { $checked1 = 'checked'; }
        if ( $row['sex'] == 2 ) { $checked2 = 'checked'; }
?>
                            <input type='radio' name='sex' value='1'<?=$checked1?>> 남
                            <input type='radio' name='sex' value='2'<?=$checked2?>> 여
<?
    $checked = ( $row['sex_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="sex_open" value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"> <b>이메일&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <input type="text" name="e_mail" value='<?=$row['e_mail']?>' maxlength="100">
<?
    $checked = ( $row['e_mail_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="e_mail_open" value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"> <b>홈페이지&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <input type="text" name="home" value='<?=$row['home']?>' maxlength="100">
<?
    $checked = ( $row['home_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="home_open" value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>
<?
    //                    <tr>
    //                      <td bgcolor="F7F7F7" align="right"> <b>주민등록번호&nbsp;</b></td>
    //                      <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
    //                        <input type="text" name="jumin_1" value='$row['jumin_1']' class="textarea_01" maxlength="6"> -
    //                        <input type="text" name="jumin_2" value='$row['jumin_2']' class="textarea_01" maxlength="7">
    //                      </td>
    //                      <td bgcolor="#FFFFFF" class="text_03">&nbsp;</td>
    //                    </tr>
?>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"> <b>생년월일&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
<?
    $birth = $row['birth'];
    $birth_year  = (int)substr($birth, 0,4);if ( $birth_year  == '0000' ) $birth_year  = '';
    $birth_month = (int)substr($birth, 4,2);if ( $birth_month == '00'   ) $birth_month = '';
    $birth_day   = (int)substr($birth, 6,2);if ( $birth_day   == '00'   ) $birth_day   = '';
?>
                            <input type="text" name="birth_year"  value='<?=$birth_year ?>' size='4' maxlength="4" onChange='if(this.value != "" && !isNumber (this.value)) { alert("날짜 입력이 올바르지 않습니다.");return false; } if ( !birthDateCheck () ) { return false; }'>년
                            <input type="text" name="birth_month" value='<?=$birth_month?>' size='2' maxlength="2" onChange='if(this.value != "" && !isNumber (this.value)) { alert("날짜 입력이 올바르지 않습니다.");return false; } if ( !birthDateCheck () ) { return false; }'>월
                            <input type="text" name="birth_day"   value='<?=$birth_day  ?>' size='2' maxlength="2" onChange='if(this.value != "" && !isNumber (this.value)) { alert("날짜 입력이 올바르지 않습니다.");return false; } if ( !birthDateCheck () ) { return false; }'>일

                            <input type="hidden" name="birth"  value='<?=$birth  ?>'>
<?
    $checked = ( $row['birth_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="birth_open" value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"> <b>나이&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <input type="text" name="age" value='<?=$row['age']?>' size='4' maxlength="3" style='text-align:right'>
<?
    $checked = ( $row['age_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="age_open" value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"> <b>연락처번호&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
                            <input type="text" name="tel" value='<?=$row['tel']?>'>
<?
    $checked = ( $row['tel_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="tel_open" value='Y'<?=$checked?>> 공개

                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>우편번호&nbsp;</b></td>
<?
        $post_cd = explode('-', $row['post_no']);
        $post_cd1 = $post_cd[0];
        $post_cd2 = $post_cd[1];
        $addr = explode('$$', $row['address']);
        $address        = $addr[0];
        $detail_address = $addr[1];
?>
                          <td bgcolor="F7F7F7" class="text_01"> &nbsp;&nbsp;
                            <input type="text" name="post_cd1" id="post_cd1" value='<?=$post_cd1?>' maxlength="3" size='5'> -
                            <input type="text" name="post_cd2" id="post_cd2" value='<?=$post_cd2?>' maxlength="3" size='5' align='top'>&nbsp;
                            <b>
                            <a href='#' onClick='window.open("post.php?post_cd_field1=post_cd1&post_cd_field2=post_cd2&address_field=address&detail_address_field=detail_address","_dboad_post","toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=520,height=250");'><img src='images/button_search.gif' border='0' width="43" height="20" align='top'></a>
                            </b>
<?
    $checked = ( $row['post_no_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="post_no_open" value='Y'<?=$checked?>> 공개
                           </td>
                        </tr>
                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>주소&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01"> &nbsp;&nbsp;
                            <input type="text" name="address" id="address" value='<?=$address?>' maxlength="100">
                            <input type="text" name="detail_address" id="detail_address" value='<?=$detail_address?>' maxlength="100">
<?
    $checked = ( $row['address_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="address_open" value='Y'<?=$checked?>> 공개
                           </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><strong>사진&nbsp;</strong></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp; <input name="picture_image" type="file" class="textarea_01" onChange='imagePreView(this,"_dboard_preview_img1");' onKeyDown='return false;'>
<?
    $checked = ( $row['picture_image_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="picture_image_open" value='Y'<?=$checked?>> 공개

                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="F7F7F7" align="right"><strong>사진 미리보기&nbsp;</strong></td>
                          <td bgcolor="F7F7F7" class="text_01">
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="10">&nbsp;</td>
                                <td width="200">
                                  <table border="0" cellpadding="0" cellspacing="1" bgcolor="cccccc">
                                    <tr>
                                      <td width="200" height="50" align="center" bgcolor="#FFFFFF">
<?
    $f1         = $user_id . "_p.gif";
    $f2         = $user_id . "_c.gif";
    if ( !@is_file("data/member/picture/" . $f1 ) ) {
        echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img1\");return false;'>";
        echo "  <img src='images/timg.gif' id='_dboard_preview_img1' border='0'>";
        echo "</a>";
    } else {
        $f1Infor = "  <img src='data/member/picture/" . $f1 . "' id='_dboard_preview_img1' border='0' ";

        $size = @GetImageSize("data/member/picture/" . $f1);
        if($size[0] == 0 ) $size[0]=1;
        if($size[1] == 0 ) $size[1]=1;
        if ( $size[0] <= 200 ) {
            $f1Infor .= " width="  . $size[0];
        } else {
            $f1Infor .= " width=200";
        }
        $f1Infor .= ">";
        echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img1\");return false;'>";
        echo $f1Infor;
        echo "</a>";
    }
?>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td valign='bottom'>
                            <input type="checkbox" name="delete_picture_image" value="Y"> 삭제
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><strong>&nbsp;회원 아이콘</strong>&nbsp;
                          </td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp; <input name="character_image" type="file" class="textarea_01" onChange='imagePreView(this,"_dboard_preview_img2");' onKeyDown='return false;'>
                            (16픽셀 × 16픽셀 정도로 해주세요.)
<?
    $checked = ( $row['character_image_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="character_image_open" value='Y'<?=$checked?>> 공개
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="F7F7F7" align="right"><strong>아이콘 미리보기</strong>&nbsp;</td>
                          <td bgcolor="F7F7F7" class="text_01">
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="10">&nbsp;</td>
                                <td width="200">
                                  <table border="0" cellpadding="0" cellspacing="1" bgcolor="cccccc">
                                    <tr>
                                      <td width="200" height="50" align="center" bgcolor="#FFFFFF">
<?
    if ( $row['character_image_open'] == 'Y' ) { $f2 = $user_id . "_c.gif"; }
    else                                       { $f2 = $user_id . "_c_close.gif"; }
    if ( !@is_file("data/member/character/" . $f2 ) ) {
        echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img2\");return false;'>";
        echo "  <img src='images/timg.gif' id='_dboard_preview_img2' border='0'>";
        echo "</a>";
    } else {
        $f1Infor = "  <img src='data/member/character/" . $f2 . "' id='_dboard_preview_img2' border='0' ";

        $size = @GetImageSize("data/member/character/" . $f2);
        if($size[0] == 0 ) $size[0]=1;
        if($size[1] == 0 ) $size[1]=1;
        if ( $size[0] <= 200 ) {
            $f1Infor .= " width="  . $size[0];
        } else {
            $f1Infor .= " width=200";
        }
        $f1Infor .= ">";
        echo "<a href='#' onClick='imagePopup(\"_dboard_preview_img2\");return false;'>";
        echo $f1Infor;
        echo "</a>";
    }
?>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                                <td valign='bottom'>
                            <input type="checkbox" name="delete_character_image" value="Y"> 삭제
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><strong>포인트</strong>&nbsp;</td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp; <input type="text" name="point" maxlength="10" style='text-align:right' value='<?=$row['point']?>' onChange='if(!isNumber(this.value)){alert ("숫자를 입력해주세요."); this.value=0; return false;}'>
                            포인트
<?
    $checked = ( $row['point_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="point_open" value='Y'<?=$checked?>> 공개
                            </td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><b>뉴스레터 수신&nbsp;</b></td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;
<?
    $checked = ( $row['news_yn'] == 'Y' ) ? "checked" : ''; // 사용
    echo "<input type='checkbox' name='news_yn' value='Y' $checked>";
?>
                            뉴스레터 수신여부를 설정할 수 있습니다.</td>
                        </tr>

                        <tr>
                          <td bgcolor="F7F7F7" align="right"><strong>접속횟수</strong>&nbsp;</td>
                          <td bgcolor="F7F7F7" class="text_01">&nbsp;&nbsp;
<?
    echo $row['access'] . ' 번';
    $checked = ( $row['access_open'] == 'Y' ) ? "checked" : ''; // 공개
?>
                            <input type="checkbox" name="access_open" value='Y'<?=$checked?>> 공개
                            </td>
                        </tr>

                        <tr bgcolor="#FFFFFF">
                          <td colspan="3" height="30" align='right'>
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="right" height="5"></td>
                              </tr>
                              <tr>
                                <td align="right">
                                  <input type="image" border="0" name="imageField" src="images/confirm.gif" width="66" height="30">
    <!--                               <a href='#' onClick='document.memberWriteForm.reset();return false;'><img border="0" name="imageField" src="images/cancel.gif" width="66" height="30"></a>&nbsp;&nbsp; -->
                                  <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField" src="images/cancel.gif" width="66" height="30"></a>&nbsp;&nbsp;
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
        redirectPage("admin_member.php"); // 게시판 관리 (조회) 이동
    }
}
?>