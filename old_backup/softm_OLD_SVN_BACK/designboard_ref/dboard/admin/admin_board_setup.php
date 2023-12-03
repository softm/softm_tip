<?
if ( function_exists('_head') ) {
    if ( $branch == 'setup' && ereg($HTTP_HOST,$HTTP_REFERER) ) {
        include ( 'common/file.inc'         ); // 파일
        $row = singleRowSQLQuery("select * from $tb_bbs_infor where no = '$no'");
?>
<?
    $doc_root = $DOCUMENT_ROOT;
    if ( substr($doc_root,strlen( $doc_root )-1) == '/' ) $doc_root = substr($doc_root,0,strlen( $doc_root )-1);
    echo "   <SCRIPT LANGUAGE='JavaScript'>\n";
    echo "   <!--\n";
    echo 'var setup_dir = "'  .$sysInfor['setup_dir'] . '";'. "\n";
    echo 'var doc_root  = "'  .$doc_root              . '";'. "\n";
    echo 'var bbs_id    = "'  .$row['bbs_id']         . '";'. "\n";
    echo "   //-->\n";
    echo "   </SCRIPT>\n";
?>
    <SCRIPT LANGUAGE='javascript'>
    <!--
        function updateData () {
    //      alert ( document.boardSetupForm.target );
    //      alert ( document.boardSetupForm.action );

            document.boardSetupForm.branch.value   = 'exec'     ;
            document.boardSetupForm.gubun.value    = 'update'   ;

            if ( document.boardSetupForm.skin_name.selectedIndex == 0 ) {
                document.boardSetupForm.skin_name.focus();
                alert ( '게시판 스킨을 선택해 주세요.' );
                return false;
            }

            if ( document.boardSetupForm.login_skin_name.selectedIndex == 0 && !isChecked ( document.boardSetupForm.use_default_login ) ) {
                document.boardSetupForm.login_skin_name.focus();
                alert ( '로그인 스킨을 선택해 주세요.' );
                return false;
            }

            var dispListNo        = ( isChecked ( document.boardSetupForm.disp_list_no        ) ) ? '1' : '0';
            var dispListName      = ( isChecked ( document.boardSetupForm.disp_list_name      ) ) ? '1' : '0';
            var dispListFile      = ( isChecked ( document.boardSetupForm.disp_list_file      ) ) ? '1' : '0';
            var dispListHit       = ( isChecked ( document.boardSetupForm.disp_list_hit       ) ) ? '1' : '0';
            var dispListDownHit   = ( isChecked ( document.boardSetupForm.disp_list_down_hit  ) ) ? '1' : '0';
            var dispListReg_date  = ( isChecked ( document.boardSetupForm.disp_list_reg_date  ) ) ? '1' : '0';
            var dispListSearch    = ( isChecked ( document.boardSetupForm.disp_list_search    ) ) ? '1' : '0';
            var dispListNew       = ( isChecked ( document.boardSetupForm.disp_list_new       ) ) ? '1' : '0';
            var dispListComment   = ( isChecked ( document.boardSetupForm.disp_list_comment   ) ) ? '1' : '0';
            var dispListCharacter = ( isChecked ( document.boardSetupForm.disp_list_character ) ) ? '1' : '0';

            document.boardSetupForm.display_list.value = dispListNo + dispListName + dispListFile + dispListHit + dispListDownHit + dispListReg_date + dispListSearch + dispListNew + dispListComment + dispListCharacter;

            var dispWriteE_mail     = ( isChecked ( document.boardSetupForm.disp_write_e_mail     ) ) ? '1' : '0';
            var dispWriteHome       = ( isChecked ( document.boardSetupForm.disp_write_home       ) ) ? '1' : '0';
            var dispWriteFile       = ( isChecked ( document.boardSetupForm.disp_write_file       ) ) ? '1' : '0';
            var dispWriteHtml       = ( isChecked ( document.boardSetupForm.disp_write_html       ) ) ? '1' : '0';
            var dispWriteOpen       = ( isChecked ( document.boardSetupForm.disp_write_open       ) ) ? '1' : '0';
            var dispWriteAnswer_mail= ( isChecked ( document.boardSetupForm.disp_write_answer_mail) ) ? '1' : '0';
            var dispWriteLink       = ( isChecked ( document.boardSetupForm.disp_write_link       ) ) ? '1' : '0';
            document.boardSetupForm.display_write.value = dispWriteE_mail + dispWriteHome + dispWriteFile + dispWriteHtml + dispWriteOpen + dispWriteAnswer_mail + dispWriteLink;

            var dispViewList        = ( isChecked ( document.boardSetupForm.disp_view_list     ) ) ? '1' : '0';
            var dispViewNext        = ( isChecked ( document.boardSetupForm.disp_view_next     ) ) ? '1' : '0';
            var dispReadComment     = ( isChecked ( document.boardSetupForm.disp_view_comment  ) ) ? '1' : '0';

            document.boardSetupForm.display_view.value = dispViewList + dispViewNext + dispReadComment;
    /*
            document.boardSetupForm.base_path.value = explorerDocument.explorerForm.path_infor.value;
            var obj = getObject ( explorerWindow.selectID , 'explorerWindow' );
            if (  explorerWindow.selectID == '' || obj.innerText == '..' ) {
                alert ( '디렉토리를 선택해 주세요.' ) ;
                return false;
            }

            abstractSource();
    */
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT
    //      document.boardSetupForm.header.value = headerDocument.body.innerHTML;
    //      document.boardSetupForm.footer.value = footerDocument.body.innerHTML;

            document.boardSetupForm.header.value = headerDocument.dataForm.header.value;
            document.boardSetupForm.footer.value = footerDocument.dataForm.footer.value;
            document.boardSetupForm.include_php.value = document.readTempageForm.include_php.value;
    //      return false;
            return true;
        }

        function readTempage(gubun) {
    //        document.readTempageForm.enctype="multipart/form-data";
            document.readTempageForm.gubun.value  = gubun;
            document.readTempageForm.target = gubun + 'Pannel';
    //        document.readTempageForm.action='admin/admin_pannel.php';
    //        return true;
            document.readTempageForm.submit();
        }

        function abstractSource() { }

        var operatorWin = null;
        function operatorSearch() {
            if ( document.boardSetupForm.search.value != '' ) {
                document.operatorForm.search.value    = document.boardSetupForm.search.value    ;
                document.operatorForm.search_gb.value = document.boardSetupForm.search_gb.value ;
                if ( operatorWin != null ) { operatorWin.close(); }
                operatorWin = window.open('about:blank','operatorWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=650,height=200');
                document.operatorForm.target = 'operatorWin';
                document.operatorForm.action = 'admin/admin_member_popup_list.php';
                document.operatorForm.submit();
                operatorWin.focus();
            } else {
                document.boardSetupForm.search.focus();
                alert ( '검색어를 입력해주세요.' );
            }
        }

        function categoryPopup() {
            operatorWin = window.open("admin/admin_board_category_popup_list.php?bbs_id=" + bbs_id,'operatorWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=416,height=400');
            operatorWin.focus();
        }

        function operatorRemove(removeID) {
            var operatorID = document.operatorForm.operator_id.value;
            var removeID = "'" + removeID + "'";
            var ID = operatorID.split(",");
            var setOpID = '';
            for ( var i=0;i<ID.length;i++ ) {
                if ( ID[i] != removeID ) {
                    setOpID += ID[i];
                    setOpID += ',';
                }
            }

            setOpID = setOpID.substring( 0, setOpID.length - 1 );

            document.operatorForm.operator_id.value = setOpID;
            document.operatorForm.target = '';
            document.operatorForm.action = 'admin_board.php';
            document.operatorForm.submit();
        }

        function moveAbstractPage (no) {
            document.boardSetupForm.target       = '';
            document.boardSetupForm.action       = 'admin_board.php';
            document.boardSetupForm.branch.value = 'abstract';
            document.boardSetupForm.no.value     = no     ;
            document.boardSetupForm.submit();
        }

        function moveGrantPage (no) {
            document.boardSetupForm.target       = '';
            document.boardSetupForm.action       = 'admin_board.php';
            document.boardSetupForm.branch.value = 'grant';
            document.boardSetupForm.no.value     = no     ;
            document.boardSetupForm.submit();
        }

        function loginSkinEnabled() {
            if ( isChecked(document.boardSetupForm.use_default_login) ) {
    //            objectBackColor( document.boardSetupForm.login_skin_name, 'E1E1E1'  );
                objectDisabled ( document.boardSetupForm.login_skin_name, 'Y'       );
            } else {
    //          objectBackColor( document.boardSetupForm.login_skin_name, 'white'  );
                objectDisabled ( document.boardSetupForm.login_skin_name,'N'     );
            }
        }

        function returnPage() {
            document.boardSetupForm.branch.value   = 'list'    ;
            document.boardSetupForm.gubun.value    = ''        ;
            document.boardSetupForm.submit();
        }
    //-->
    </SCRIPT>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="808">
                      <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" height="100%" class="text_01">
    <form name='boardSetupForm' action='admin_board.php' method='post' onSubmit='return updateData();'>
        <input type='hidden' name='branch' value='exec'           >
        <input type='hidden' name='gubun'  value='update'         >
        <input name='s'         type='hidden' value='<?=$s?>'         >
        <input name='tot'       type='hidden' value='<?=$tot?>'       >
        <input name='sort'      type='hidden' value='<?=$sort?>'      >
        <input name='desc'      type='hidden' value='<?=$desc?>'      >
        <input type='hidden' name='no'     value='<?=$row['no']?>'>
        <input type='hidden' name='bbs_id' value='<?=$row['bbs_id']?>'>
        <input type='hidden' name='operator_id' value="<?=$row['operator_id']?>">
                        <tr bgcolor="#FFFFFF" align="right"> 
                          <td colspan="2" height="45" class="text_01" background="images/top_02.gif">
                            <a href='#' onClick='moveAbstractPage (<?=$row['no']?>);return false;'><img border="0" name="imageField4222" src="images/button_poll_03.gif" width="66" height="30" align="middle"></a>
                            <a href='#' onClick='moveGrantPage    (<?=$row['no']?>);return false;'><img border="0" name="imageField422" src="images/button_poll_02.gif" width="66" height="30" align="middle"></a>
                            <a href='#' onClick='if ( updateData () ) { document.boardSetupForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30" align="middle"></a>
                            <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30" align="middle"></a>
                            &nbsp;&nbsp; </td>
                        </tr>
                        <tr> 
                            <td height="30" align="center" bgcolor="eeeeee" class="text_01"><b>디자인방식 선택 </b></td>
                            <td bgcolor="f7f7f7" class="text_01"> 
<?
        $designMethod = $row[design_method]; // 기본 로그인 사용
        if ( $designMethod == '2' ) {
            echo "<input type='radio' name='design_method' value='1' onClick='designMethod(this.value);'> 헤더푸터 형식 <input type='radio' name='design_method' value='2' onClick='designMethod(this.value);' checked> 인클루드 형식 (작업한 파일에 게시판을 직접 삽입 합니다.)";
        } else {
            echo "<input type='radio' name='design_method' value='1' onClick='designMethod(this.value);' checked> 헤더푸터 형식 <input type='radio' name='design_method' value='2' onClick='designMethod(this.value);'> 인클루드 형식 (작업한 파일에 게시판을 직접 삽입 합니다.)";
        }
?>
    <SCRIPT LANGUAGE="JavaScript">
    <!--
    function designMethod(val) {
        var dboardURL1 = getObject('_dboard_url_1');
        var dboardURL2 = getObject('_dboard_url_2');
        if ( val == 1 ) {
            dboardURL1.style.visibility = 'visible';
            dboardURL1.style.position   = 'relative';
            dboardURL2.style.visibility = 'hidden';
            dboardURL2.style.position   = 'absolute';
            for ( var i=1; i<=5; i++ ) {
                var obj = getObject ( '_dboard_include_1_' + i );
                obj.style.display = '';
            }
            for ( var i=1; i<=2; i++ ) {
                var obj = getObject ( '_dboard_include_2_' + i );
                obj.style.display = 'none';
            }
        } else {
            dboardURL1.style.visibility = 'hidden';
            dboardURL1.style.position   = 'absolute';
            dboardURL2.style.visibility = 'visible';
            dboardURL2.style.position   = 'relative';
            for ( var i=1; i<=5; i++ ) {
                var obj = getObject ( '_dboard_include_1_' + i );
                obj.style.display = 'none';
            }
            for ( var i=1; i<=2; i++ ) {
                var obj = getObject ( '_dboard_include_2_' + i );
                obj.style.display = '';
            }
        }
    }
    //-->
    </SCRIPT>
                                </td>
                        </tr>
                        <tr> 
                          <td height="30" class="text_01" align="center" bgcolor="eeeeee" width='200'><B>게시판 정보 및 스킨설정</B></td>
                          <td height="30" class="text_01" align="center" bgcolor='#f7f7f7'>&nbsp;</td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">게시판이름&nbsp</td>
                          <td bgcolor="#FFFFFF"><b class="text_03">&nbsp;&nbsp;&nbsp;&nbsp;<a href="dboard.php?id=<?=$row['bbs_id']?>" target='_dboard<?=$row['bbs_id']?>'><?=$row['bbs_id']?></a></td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">게시판 URL&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_04"><font color="BF0909">&nbsp;&nbsp;</font>
                          <span id='_dboard_url_1'>
                          <a href="dboard.php?id=<?=$row['bbs_id']?>" target='_dboard<?=$row['bbs_id']?>'><font color="BF0909">http://<?=$HTTP_HOST.$sysInfor["base_dir"]?>dboard.php?id=<?=$row['bbs_id']?></font></a>
                          </span>
                          <span id='_dboard_url_2'>
                          <a href="files/<?=$row['bbs_id']?>.php" target='_dboard<?=$row['bbs_id']?>'><font color="BF0909">http://<?=$HTTP_HOST.$sysInfor["base_dir"]?>files/<?=$row['bbs_id']?>.php</font></a>
                          </span>
                          </td>
                        </tr>
    <!--                     <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">게시판 
                            추출소스&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF">
    &nbsp;&nbsp;&nbsp;
    <span class="text_05">
    &lt;? 
<?
    echo "<BR>&nbsp;&nbsp;&nbsp;&nbsp;\$id = '" . $row['bbs_id'] . "';<BR>";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;include ( '" . $sysInfor['base_dir'] ."dboard.php');<BR>";
?>                        
    &nbsp;&nbsp;&nbsp;
    ?&gt;
                            </span></td>
                        </tr> -->
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">스킨설정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
    <select name='skin_name' class='jm_01' onChange='abstractSource();'>
<?
        echo"<option value=''>-----스킨지정-----</option>";
     // /skin 디렉토리에서 디렉토리를 구함
        $skin_dir="skin/board";
        $handle = opendir($skin_dir);
        while ( $skin_info = readdir($handle) )
        {
            if(!eregi("\.",$skin_info)) {
                if($skin_info==$row[skin_name]) $select="selected"; else $select="";
                echo"<option value=$skin_info $select>$skin_info</option>";
            }
        }
        closedir($handle);
?>
    </select>
                          </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">로그인 스킨설정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
    <select name='login_skin_name' class='jm_01' onChange='abstractSource();'>
<?
        echo"<option value=''>-----스킨지정-----</option>";
     // /skin 디렉토리에서 디렉토리를 구함
        $skin_dir="skin/login";
        $handle = opendir($skin_dir);
        while ( $skin_info = readdir($handle) )
        {
            if(!eregi("\.",$skin_info)) {
                if($skin_info==$row[login_skin_name]) $select="selected"; else $select="";
                echo"<option value=$skin_info $select>$skin_info</option>";
            }
        }
        closedir($handle);
?>
    </select>
<?
    $useCategory = $row[use_default_login]; // 기본 로그인 사용
    $checked = ( $useCategory == 'Y' ) ? "checked " : ' '; // 번호
    echo "<input type='checkbox' name='use_default_login' value='Y' $checked onClick='loginSkinEnabled();'> 기본 로그인 사용";
?>
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF">
                          <td align="right" bgcolor="#FFFFFF" class="text_01">카테고리설정&nbsp;</td>
                          <td class="text_01"> &nbsp; 
<?
    $useCategory = $row[use_category]; // 리스트 화면 설정
    $checked = ( $useCategory == 'Y' ) ? "checked " : ' '; // 번호
    echo "<input type='checkbox' name='use_category' value='Y' $checked>";
?>

                            카테고리출력&nbsp; <a href='#' onClick='categoryPopup();return false;'><img src="images/button_ca.gif" width="69" height="20" align="absmiddle" border="0"></a></td>
                        </tr>

                        <tr> 
                          <td height="30" class="text_01" align="center" bgcolor="eeeeee"><B>부운영자 설정</B></td>
                          <td height="30" class="text_01" align="center" bgcolor='#f7f7f7'>&nbsp;</td>
                        </tr>

    <!--                     <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">관리자만 쓰기 가능&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;  -->
<?
    //        echo "<input type='checkbox' name='admin_only_write'  value='Y' onClick='abstractSource();' checked> 목록";
?>
    <!--                       </td>
                        </tr> -->
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">부운영자 검색&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;
                                              <select name="search_gb" class="jm_01">
                                                  <option value='user_id' >아이디</option>
                                                  <option value='name'    >이름</option>
                                                  <option value='e_mail'  >이메일</option>
                                              </select>
                                              <input type="text" name="search" value=''>
                                              <b> 
                                              <a href='#' onClick='operatorSearch();return false;'><img border="0" name="imageField3222" src="images/button_search.gif" width="43" height="20" align="top"></a>
                          </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">부운영자&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;
<?
    echo "<span id='operator_ids'>";
        if ( $row['operator_id'] ) {
            $sql  = "select count(user_id) from $tb_member ";
            $sql .= " where user_id in ( " . $row['operator_id'] . " )";
            $tot = simpleSQLQuery($sql);

            $sql  = "select user_id, name from $tb_member ";
            $sql .= " where user_id in ( " . $row['operator_id'] . " )";
    //      logs ( '$sql : '. $sql . '<BR>' , true);
            $stmt = multiRowSQLQuery($sql);
            $cnt = 0;
            while ( $operator = multiRowFetch  ($stmt) ) {
                $cnt++;
                if ( ( $cnt % 3 == 0 ) && $tot > 3 ) {
                    echo ' &nbsp;';
                }
                echo $operator['name'] . ' <span class="text_03">[ <B>' . $operator['user_id'] . '</B> ]</span> ';
                echo "<a href='#' onClick=\"operatorRemove('" . $operator['user_id'] . "');\"><img src='images/x4.gif' border=0></a> ";
                if ( $tot > $cnt ) echo ", ";
                if ( ( $cnt % 3 == 0 ) && $tot > $cnt ) {
                    echo '<BR> &nbsp;&nbsp;';
                }
            }
        }
    echo "</span>";
?>
                          </td>
                        </tr>

                        <tr> 
                          <td height="30" class="text_01" align="center" bgcolor="eeeeee"><B>제한 설정</B></td>
                          <td height="30" class="text_01" align="center" bgcolor='#f7f7f7'>&nbsp;</td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">게시판 넓이&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="text" name="table_width" size="5" maxlength="4" value="<?=$row['table_width']?>" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };'>
                            <select name="table_width_unit" class="jm_01" onChange='abstractSource();'>
<?
                                if ( $row['table_width_unit'] == '1' ) {
                                    echo "<option value ='1' selected>%      </option><option value ='2'>pixels </option>";
                                } else {
                                    echo "<option value ='1'>%      </option><option value ='2' selected>pixels </option>";
                                }
?>
                            </select>
                          </td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">리스트(목록) 글수&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            첫 페이지 출력 글수 
                            <input type="text" name="how_many"  value="<?=$row['how_many']?>"  size="5" maxlength="3" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();'> 개
                            &nbsp; &nbsp;<font color="999999">|</font>&nbsp;&nbsp;
                            두번째 페이지 이후 출력 글수 
                            <input type="text" name="more_many" value="<?=$row['more_many']?>" size="5" maxlength="3" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();'> 개
                          </td>
                          </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">페이지 표시 수&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="text" name="page_many" value="<?=$row['page_many']?>" size="5" maxlength="3" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();'>
                            &nbsp;&nbsp;목록의 아래부분에 표시될 페이지의 갯수 (1~999) </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">제목글자제한&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="text" name="title_limit" value="<?=$row['title_limit']?>" size="5" maxlength="3" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();'>
                            자</td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">첨부용량제한&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="text" name="max_capacity" value="<?=$row['max_capacity']?>" size="5" maxlength="5" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();'>
                            M (첨부 용량이 <?=$row['max_capacity']?>M로 제한 되었습니다.)</td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">이메일 발송형식&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
<?
    $mailSendMethod = $row[mail_send_method]; // 폼메일(웹메일)
    if ( $mailSendMethod == '2' ) {
        echo "<input type='radio' name='mail_send_method' value='1' onChange='abstractSource();'> 폼메일(웹메일)&nbsp;&nbsp;<input type='radio' name='mail_send_method' value='2' onChange='abstractSource();' checked> 아웃룩(mailto)";
    } else {
        echo "<input type='radio' name='mail_send_method' value='1' onChange='abstractSource();' checked> 폼메일(웹메일)&nbsp;&nbsp;<input type='radio' name='mail_send_method' value='2' onChange='abstractSource();'> 아웃룩(mailto)";
    }
?>
                          </td>

                        </tr>
<?
    //$checked = ( $displayView[2] ) ? "checked" : ''; // 폼메일
    //echo "<input type='checkbox' name='disp_view_form_mail'   value='1' $checked> 폼메일 형식 출력 (비체크시 OUTLOOK 출력)";
?>

                        <tr> 
                          <td height="30" class="text_01" align="center" bgcolor="eeeeee"><B>메뉴표시 및 기능선택 설정</B></td>
                          <td height="30" class="text_01" align="center" bgcolor='#f7f7f7'>&nbsp;</td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">메뉴표시 선택(리스트)&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01">&nbsp; 
    <input type='hidden' name='display_list' value=''>
<?
    $displayList = $row[display_list]; // 리스트 화면 설정
    $checked = ( $displayList[0] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 번호
    echo "<input type='checkbox' name='disp_list_no'        value='1' $checked> 번호 ";
    $checked = ( $displayList[1] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 이름
    echo "<input type='checkbox' name='disp_list_name'      value='1' $checked> 이름  ";
    $checked = ( $displayList[2] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 파일
    echo "<input type='checkbox' name='disp_list_file'      value='1' $checked> 파일 ";
    $checked = ( $displayList[3] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 조회
    echo "<input type='checkbox' name='disp_list_hit'       value='1' $checked> 조회 ";
    $checked = ( $displayList[4] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 다운수
    echo "<input type='checkbox' name='disp_list_down_hit'  value='1' $checked> 다운수";
    $checked = ( $displayList[5] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 날짜
    echo "<input type='checkbox' name='disp_list_reg_date'  value='1' $checked> 날짜 ";
    $checked = ( $displayList[6] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 검색
    echo "<input type='checkbox' name='disp_list_search'    value='1' $checked> 검색 ";
    $checked = ( $displayList[7] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 새글
    echo "<input type='checkbox' name='disp_list_new'       value='1' $checked> New Icon ";
    $checked = ( $displayList[8] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 당일 의견글
    echo "<input type='checkbox' name='disp_list_comment'    value='1' $checked>당일 의견글<font color='#FF0000'> +</font> 표시";
    $checked = ( $displayList[9] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 새글
    echo "<input type='checkbox' name='disp_list_character'  value='1' $checked> 회원 아이콘";
?>
    </td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">메뉴표시 선택(글쓰기)&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01">&nbsp; 
    <input type='hidden' name='display_write' value=''>
<?
    $displayWrite = $row[display_write]; // 글쓰기 화면 설정
    $checked = ( $displayWrite[0] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 이메일
    echo "<input type='checkbox' name='disp_write_e_mail'      value='1' $checked> 이메일 ";
    $checked = ( $displayWrite[1] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 홈페이지
    echo "<input type='checkbox' name='disp_write_home'        value='1' $checked> 홈페이지 ";
    $checked = ( $displayWrite[2] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 파일
    echo "<input type='checkbox' name='disp_write_file'        value='1' $checked> 파일 업로드 ";
    $checked = ( $displayWrite[3] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // HTML
    echo "<input type='checkbox' name='disp_write_html'        value='1' $checked> HTML사용 ";
    $checked = ( $displayWrite[4] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 비공개
    echo "<input type='checkbox' name='disp_write_open'        value='1' $checked> 비공개 ";
    $checked = ( $displayWrite[5] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 답변시에 메일받음
    echo "<input type='checkbox' name='disp_write_answer_mail' value='1' $checked> 답변시에 메일받음 ";
    $checked = ( $displayWrite[6] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 링크
    echo "<input type='checkbox' name='disp_write_link' value='1' $checked> 링크 ";
?>
                          </td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">메뉴표시 선택(글읽기)&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01">&nbsp; 
    <input type='hidden' name='display_view' value=''>
<?
    $displayView = $row[display_view]; // 글쓰기 화면 설정
    $checked = ( $displayView[0] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 리스트 출력
    echo "<input type='checkbox' name='disp_view_list'        value='1' $checked> 리스트 출력 ";
    $checked = ( $displayView[1] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 이전/다음 글출력
    echo "<input type='checkbox' name='disp_view_next'        value='1' $checked> 이전/다음글 출력 ";
    $checked = ( $displayView[2] ) ? "checked onClick='abstractSource();'" : ' onClick="abstractSource();"'; // 의견달기
    echo "<input type='checkbox' name='disp_view_comment'     value='1' $checked> 의견글 출력";
?>
    <textarea name="header" style='width:0;height:1'><?=htmlspecialchars ( f_readFile($baseDir . "data/html/_dboard_header_" . $row['bbs_id'] . ".php"), ENT_QUOTES)?></textarea>
    <textarea name="footer" style='width:0;height:1'><?=htmlspecialchars ( f_readFile($baseDir . "data/html/_dboard_footer_" . $row['bbs_id'] . ".php"), ENT_QUOTES)?></textarea>
    <textarea name="include_php" style='width:0;height:1'><?=htmlspecialchars ( f_readFile("files/" . $row['bbs_id'] . ".php"), ENT_QUOTES)?></textarea>

                            </td>
                        </tr>

    <input type="submit" border="0" value ='' name="imageField2" src="images/cancel.gif" width="66" height="21" style='position:absolute;top:800;left:0;'>
    <div style='position:absolute;top:800;left:0;width:100;height:50;background-color:f7f7f7;z-index:1'></div>

    <!--                     <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">추출소스를 삽입 할&nbsp;<br>파일이 들어있는 폴더 지정&nbsp;</td>
                          <td> 
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr> 
                                <td width="12" rowspan="3"></td>
                                <td>&nbsp; </td>
                                <td width="14" rowspan="3"></td>
                              </tr> -->
    <SCRIPT LANGUAGE="JavaScript">
    <!--
    var explorerWindow   ; // WINDOW   OBJECT
    var explorerDocument ; // DOCUMENT OBJECT
    function exploerInitial () {
        var explorerObj      = getObject("explorer")      ; // IFRAME   OBJECT
            explorerWindow   = explorerObj.contentWindow  ; // WINDOW   OBJECT
            explorerDocument = explorerWindow.document    ; // DOCUMENT OBJECT

        if ( explorerWindow.reselect_yn == 'Y' ) {
            var id = '';
            for ( var i=1; i<=explorerWindow.itemCnt; i++ ) {
                id = 'f' + paddingChar(i, 5, '0');
                var obj = explorerWindow.getObject( id );
                var dirNm = obj.innerText;
                if ( explorerWindow.reselect_dir == '' ) { explorerWindow.reselect_dir = '.'; }
                if ( dirNm == explorerWindow.reselect_dir ) {
                    explorerWindow.selectID = id;
                    explorerWindow.selectedItemColor (id);
    //              obj.focus();
                    var pathObj = getObject("path_infor", 'explorerWindow');
                    if ( typeof(pathObj) == 'object' ) {
                        pathObj.value = pathObj.value + '/' + obj.innerText;
                    }
                }
            }
        }
    }

    function menuInitial () {
        BoxMenu   (explorerDocument, "menu_panel", 'explorerWindow')      ; // 메뉴 초기화
        Menu ();
    }

    function Menu() {
        var menu0 = newMenu();// Menu Group 1
        menu0.appendValue( "delete"     , new MENU_ITEM( '삭제'  , 'DELETE'      , 0, "required"));
        createMenu(panel, menu0);
    }

    function BoxMenuCommand(key, val){
        switch(key) {
            case "DELETE":
                if ( confirm("정말 삭제 하시겠습니까.") ) {
                    explorerWindow.deleteFolder()
                }
                break;
            default:break;
        }
        HideMenu();
        return false;
    }
    //-->
    </SCRIPT>
    <!--                           <tr> 
                                <td> -->
    <input type='hidden' name='base_path' value='<?=$row['base_path']?>'>

<?
    $base_path = $row['base_path'];
    //echo ('<span class="text_04"> ※추출소스를 삽입하실 파일이 들어있는 폴더를 선택하시면 자동 입력됩니다.</span><BR>');
    function makeExplorer ($width=400,$height=300) {
        global $no,$base_path;
        echo "<iframe marginHeight='0' marginWidth='0' frameborder='0' width='$width' height='$height' name='explorer' id='explorer' src='admin/admin_board_explorer_iframe.php?base_path=". urlencode($base_path) ."'></iframe>";
    }
    //makeExplorer ('556', '250');
?>
    <!--                             </td>
                              </tr>
                              <tr> 
                                <td>&nbsp;</td>
                              </tr>
                            </table>
                          </td>
                        </tr> -->

    <!--                     <tr bgcolor="#FFFFFF"> 
                          <td align="center" bgcolor="eeeeee" class="text_01" height="30"><b>인클루드 삽입 소스</b></td>
                          <td class="text_01" bgcolor="f7f7f7">&nbsp;&nbsp;&nbsp;아래 
                            소스를 삽입하실 HTML 파일 안 해당 위치에 넣어주시면 됍니다</td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                          <td align="right" bgcolor="#FFFFFF" class="text_01"><br>
                          </td>
                          <td class="text_01" height="190">&nbsp;&nbsp; 
                            <textarea name="abstract_source" cols="89" rows="12"></textarea>
                          </td>
                        </tr> -->
    </form>
                        <tr id='_dboard_include_1_1'> 
                          <td height="30" class="text_01" align="center" bgcolor="eeeeee"><B>게시판 상/하단 파일 삽입</B></td>
                          <td height="30" class="text_01" align="center" bgcolor='#f7f7f7'>&nbsp;</td>
                        </tr>

    <form name='readTempageForm' action='admin/admin_pannel.php' method='post' enctype="multipart/form-data">
                        <tr id='_dboard_include_1_2'> 
                          <td bgcolor="ffffff" align="right" class="text_01">상단파일 지정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="file" name="header_file" class="textarea_01" onChange="readTempage('header');">   
                            &nbsp;&nbsp;(파일을 불러오면 소스가 자동삽입 됩니다.)</td>
                        </tr>

        <input type='hidden' name='gubun'  value=''               >
        <input type='hidden' name='no'     value='<?=$row['no']?>'>
                        <tr id='_dboard_include_1_3'> 
                          <td bgcolor="ffffff" align="right" class="text_01">상단 부분 직접 작성&nbsp;</td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01" align='right'>
    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='headerPannel' id='headerPannel' scrolling='no' src='admin/admin_pannel.php?no=<?=$no?>&gubun=header'></iframe>
    </iframe>
                          </td>
                        </tr>
                        <tr id='_dboard_include_1_4'> 
                          <td bgcolor="ffffff" align="right" class="text_01">하단파일 지정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="file" name="footer_file" class="textarea_01" onChange="readTempage('footer');">
                            &nbsp;&nbsp;(파일을 불러오면 소스가 자동삽입 됩니다.)</td>
                        </tr>
                        <tr id='_dboard_include_1_5'> 
                          <td bgcolor="ffffff" align="right" class="text_01">하단 부분 직접 작성&nbsp;</td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01" align='right'>
    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='footerPannel' id='footerPannel' scrolling='no' src='admin/admin_pannel.php?no=<?=$no?>&gubun=footer'></iframe>
    </iframe>
                          </td>
                        </tr>

                        <tr id='_dboard_include_2_1'> 
                            <td height="30" align="center" bgcolor="eeeeee" class="text_01"><strong>인클루드 삽입소스&nbsp;</strong></td>
                            <td bgcolor="f7f7f7">&nbsp;&nbsp;&nbsp;작업한 
                                문서 게시판을 삽입할 부분에 하단 소스를 넣어주시면 됩니다.<br>
                                &nbsp;&nbsp;&nbsp;작업한 문서는 dboard/files 
                                폴더안에 넣어주셔야 합니다. </td>
                        </tr>
                        <tr id='_dboard_include_2_2'> 
                            <td align="right" bgcolor="#FFFFFF" class="text_01">&nbsp;</td>
                            <td height="190" bgcolor="#FFFFFF"> 
                                &nbsp;&nbsp; 
<?
            if(file_exists('files/' . $row['bbs_id'] . '.php') ) {
                $f = fopen('files/' . $row['bbs_id'] . '.php',"r");
                $file1_str = fread($f, filesize('files/' . $row['bbs_id'] . '.php'));
                fclose($f);
            }
            echo "<textarea name='include_php' cols='91' rows='12'>". htmlspecialchars ( $file1_str, ENT_QUOTES ) . "</textarea>";
?>
                            </td>
                        </tr>
    </form>
    <SCRIPT LANGUAGE="JavaScript">
    <!--
    designMethod('<?=$designMethod?>');
    //-->
    </SCRIPT>
                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01" colspan="2"> 
                            <a href='#' onClick='moveAbstractPage (<?=$row['no']?>);return false;'><img border="0" name="imageField4222" src="images/button_poll_03.gif" width="66" height="30" align="middle"></a>
                            <a href='#' onClick='moveGrantPage    (<?=$row['no']?>);return false;'><img border="0" name="imageField422" src="images/button_poll_02.gif" width="66" height="30" align="middle"></a>
                            <a href='#' onClick='if ( updateData () ) { document.boardSetupForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30" align="middle"></a>
                            <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30" align="middle"></a>
                          </td>
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
    <form name='operatorForm' action='' method='post'>
        <input type='hidden' name='branch' value='exec'           >
        <input type='hidden' name='gubun'  value='operator_update'>
        <input type='hidden' name='no'     value='<?=$row['no']?>'>
        <input type='hidden' name='bbs_id' value='<?=$row['bbs_id']?>'>
        <input type='hidden' name='search'       value=''   >
        <input type='hidden' name='search_gb'    value=''   >
        <input type='hidden' name='operator_id' value="<?=$row['operator_id']?>">
        <input type='hidden' name='form_name'	value="boardSetupForm">
        <input type='hidden' name='how_many'     value='<?=$how_many?>'   >
    </form>

    <SCRIPT LANGUAGE="JavaScript">
    <!--
        // admin_member_popup_list_main.php 참조할 변수
        var operator_del_image = "<img src='" + baseDir + "images/x4.gif' border=0>";
    //-->
    </SCRIPT>
<?
    } // if END
}
?>