<?
if ( function_exists('_head') ) {
    if ( $branch == 'abstract' ) {
        include ( 'common/file.inc'         ); // 파일
        $row = singleRowSQLQuery("select * from $tb_bbs_abstract where no = '$no'");
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
            var explorerObj      = getObject("explorer")      ; // IFRAME   OBJECT
            explorerWindow   = explorerObj.contentWindow  ; // WINDOW   OBJECT
            explorerDocument = explorerWindow.document    ; // DOCUMENT OBJECT

            if ( document.boardAbstractForm.skin_name.selectedIndex == 0 ) {
                document.boardAbstractForm.skin_name.focus();
                alert ( '스킨을 선택해 주세요.' );
                return false;
            }

            var dispListNo       = ( isChecked ( document.boardAbstractForm.disp_list_no             ) ) ? '1' : '0';   // 번호      
            var dispListName     = ( isChecked ( document.boardAbstractForm.disp_list_name           ) ) ? '1' : '0';   // 이름      
            var dispListTitle    = ( isChecked ( document.boardAbstractForm.disp_list_title          ) ) ? '1' : '0';   // 제목      
            var dispListFile     = ( isChecked ( document.boardAbstractForm.disp_list_file           ) ) ? '1' : '0';   // 파일      
            var dispListHit      = ( isChecked ( document.boardAbstractForm.disp_list_hit            ) ) ? '1' : '0';   // 조회      
            var dispListDownHit  = ( isChecked ( document.boardAbstractForm.disp_list_down_hit       ) ) ? '1' : '0';   // 다운수    
            var dispListReg_date = ( isChecked ( document.boardAbstractForm.disp_list_reg_date       ) ) ? '1' : '0';   // 날짜      
            var dispListNew      = ( isChecked ( document.boardAbstractForm.disp_list_new            ) ) ? '1' : '0';   // 새글      
            var dispListComment  = ( isChecked ( document.boardAbstractForm.disp_list_comment        ) ) ? '1' : '0';   // 당일의견글

            document.boardAbstractForm.display_list.value = dispListNo + dispListName + dispListTitle + dispListFile + dispListHit + dispListDownHit + dispListReg_date + dispListNew + dispListComment;

            document.boardAbstractForm.base_path.value = explorerDocument.explorerForm.path_infor.value;
            var obj = getObject ( explorerWindow.selectID , 'explorerWindow' );
    //        if (  explorerWindow.selectID == '' || obj.innerText == '..' ) {
    //            alert ( '디렉토리를 선택해 주세요.' ) ;
    //            return false;
    //        }
    //      document.boardAbstractForm.base_path.value = explorerDocument.explorerForm.path_infor.value;

            abstractSource();

            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT
    //      document.boardAbstractForm.header.value = headerDocument.body.innerHTML;
    //      document.boardAbstractForm.footer.value = footerDocument.body.innerHTML;
            document.boardAbstractForm.header.value = headerDocument.dataForm.header.value;
            document.boardAbstractForm.footer.value = footerDocument.dataForm.footer.value;
            return true;
        }

        function abstractSource() {

            document.boardAbstractForm.base_path.value = explorerWindow.document.explorerForm.path_infor.value;
            var base_path = document.boardAbstractForm.base_path.value + '/';
            var obj = getObject ( explorerWindow.selectID , 'explorerWindow' );

            if ( explorerWindow.selectID == '' ) {
                baseDir = '디렉토리가 선택되지 않았습니다.';
            } else {
                baseDir = relativeDir(setup_dir.toLowerCase(), base_path.toLowerCase());
            }
            var source  = '<\?\n';
                source += "// createNotice(); 함수 전에 위치 시켜 주세요.\n";
                source += '$baseDir                 = "' + baseDir                                        + '";                // 디보드 설치 경로\n';
                source += "include ($baseDir . 'dnotice.php');\n";
                source += "\?\>\n\n";

            var useCategory      = ( isChecked ( document.boardAbstractForm.use_category			 ) ) ? 'Y' : 'N';   // 카테고리 사용 여부

            var dispListNo       = ( isChecked ( document.boardAbstractForm.disp_list_no             ) ) ? '1' : '0';   // 번호      
            var dispListName     = ( isChecked ( document.boardAbstractForm.disp_list_name           ) ) ? '1' : '0';   // 이름      
            var dispListTitle    = ( isChecked ( document.boardAbstractForm.disp_list_title          ) ) ? '1' : '0';   // 제목      
            var dispListFile     = ( isChecked ( document.boardAbstractForm.disp_list_file           ) ) ? '1' : '0';   // 파일      
            var dispListHit      = ( isChecked ( document.boardAbstractForm.disp_list_hit            ) ) ? '1' : '0';   // 조회      
            var dispListDownHit  = ( isChecked ( document.boardAbstractForm.disp_list_down_hit       ) ) ? '1' : '0';   // 다운수    
            var dispListReg_date = ( isChecked ( document.boardAbstractForm.disp_list_reg_date       ) ) ? '1' : '0';   // 날짜      
            var dispListNew      = ( isChecked ( document.boardAbstractForm.disp_list_new            ) ) ? '1' : '0';   // 새글      
            var dispListComment  = ( isChecked ( document.boardAbstractForm.disp_list_comment        ) ) ? '1' : '0';   // 당일의견글

            var display_list     = dispListNo + dispListName + dispListTitle + dispListFile + dispListHit + dispListDownHit + dispListReg_date + dispListNew + dispListComment;
            var display_mode     = checkedValue ( document.boardAbstractForm.display_mode );

            source += '<\?\n';
            source += "createNotice( ";

            source += '"' + bbs_id                                         + '",';
            source += '"' + useCategory                                    + '",';
            source += '"' + document.boardAbstractForm.cat_no.value        + '",';
            source += '"' + document.boardAbstractForm.skin_name.value     + '",';
            source += ''  + document.boardAbstractForm.start_pos.value     + ',' ;
            source += ''  + document.boardAbstractForm.end_pos.value       + ',' ;
            source += ''  + document.boardAbstractForm.title_limit.value   + ',' ;
            source += ''  + document.boardAbstractForm.content_limit.value + ',' ;
            source += '"' + display_list                                   + '",';
            source += '"' + display_mode                                   + '"' ;

            source += " );\n";
    /*
            source += '$notice_id               = "' + bbs_id                                         + '";                // 게시판 아이디\n';
            source += '$notice_skin_name        = "' + document.boardAbstractForm.skin_name.value     + '";                // 스킨명\n';
            source += '$notice_start_pos        = '  + document.boardAbstractForm.start_pos.value     + ' ;                // 게시물 추출 시작 위치\n' ;
            source += '$notice_end_pos          = '  + document.boardAbstractForm.end_pos.value       + ' ;                // 게시물 추출 끝   위치\n' ;
            source += '$notice_title_limit      = '  + document.boardAbstractForm.title_limit.value   + ' ;                // 제목 길이\n' ;
            source += '$notice_content_limit    = '  + document.boardAbstractForm.content_limit.value + ' ;                // 내용 길이\n' ;
    //      alert ( document.boardAbstractForm.display_list.value );
            source += '$notice_display_list     = "' + display_list                                   + '";                // 출력 항목 : 번호, 이름, 제목, 파일, 조회, 다운수, 날짜, 새글, 당일의견글 ( 1 이면 출력 , 0 이면 미출력)\n';

            var display_mode = checkedValue ( document.boardAbstractForm.display_mode );
            source += '$notice_display_mode     = '  + display_mode + ';           // 선택 글 표시 형식 ( 1: 현재창에서 이동, 2 :  새창으로 띄우기 )\n';
            source += "\n";
    */
            source += "\?\>";
            document.readTempageForm.abstract_source.value = source;
        }

        function displayContentInputButton() {
            var display_mode = checkedValue ( document.boardAbstractForm.display_mode );
            if ( display_mode == 2 ) {
                objectShow    ( "notice_content_0" );
            } else {
                objectHide    ( "notice_content_0" );
            }
        }

        function readTempage(gubun) {
    //        document.readTempageForm.enctype="multipart/form-data";
            document.readTempageForm.gubun.value  = gubun;
            document.readTempageForm.target = gubun + 'Pannel';
    //        document.readTempageForm.action='admin/admin_pannel.php';
    //        return true;
            document.readTempageForm.submit();
        }

        function toggleNoticeContent(gubun) {
            var display_mode = checkedValue ( document.boardAbstractForm.display_mode );

            for ( var i=1; i<=5; i++ ) {
                var obj = getObject ( "notice_content_" + i );

                if ( gubun != '' && obj.style.display == 'none' ) {
                    if ( display_mode == 2 ) {
                        objectShow    ( "notice_content_" + i );
                    }
                } else {
                    objectHide    ( "notice_content_" + i );
                }
            }
        }

        function returnPage() {
            document.returnForm.submit();
        }
    //-->
    </SCRIPT>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <form name='returnForm' method='post' action='admin_board.php'>
        <input name='branch'    type='hidden' value='list'            >
        <input name='gubun'     type='hidden' value=''                >
        <input name='s'         type='hidden' value='<?=$s?>'         >
        <input name='tot'       type='hidden' value='<?=$tot?>'       >
        <input name='sort'      type='hidden' value='<?=$sort?>'      >
        <input name='desc'      type='hidden' value='<?=$desc?>'      >
    </form>
                  <tr>
                    <td width="808">
                      <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" class="text_01">
    <form name='boardAbstractForm' action='admin_board.php' method='post' onSubmit='return updateData();'>
        <input type='hidden' name='branch' value='exec'           >
        <input type='hidden' name='gubun'  value='abstract'        >
        <input name='s'         type='hidden' value='<?=$s?>'         >
        <input name='tot'       type='hidden' value='<?=$tot?>'       >
        <input name='sort'      type='hidden' value='<?=$sort?>'      >
        <input name='desc'      type='hidden' value='<?=$desc?>'      >

        <input type='hidden' name='no'     value='<?=$row['no']?>'>
        <input type='hidden' name='bbs_id' value='<?=$row['bbs_id']?>'>
                        <tr bgcolor="#FFFFFF"> 
                          <td colspan="2" height="45" class="text_01" align="right" background="images/top_08.gif">&nbsp;</td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td width="210" height="30" align="center" bgcolor="eeeeee" class="text_01"><b> 
                            추출 세부 설정</b></td>
                          <td bgcolor="f7f7f7" align="center" class="text_01">&nbsp;</td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td bgcolor="#FFFFFF" align="right" class="text_01"><font color="#333333">추출게시판</font></td>
                          <td class="text_03"><b>&nbsp;&nbsp;&nbsp;&nbsp;<?=$row['bbs_id']?></b></td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">카테고리설정</font>&nbsp;</td>
                          <td class="text_01"> &nbsp;&nbsp;
<?
        $sql1 = "select * from $tb_bbs_category" . "_" . $row['bbs_id'] . " order by o_seq;";
        $stmt1 = multiRowSQLQuery($sql1);
        $_rtn  = "<select name='cat_no' class='jm_01' onChange='abstractSource();'>";
        $_rtn .= "<option value=''>-----카테고리선택-----</option>";
        while ( $row1 = multiRowFetch  ($stmt1) ) {
                if($row['cat_no']==$row1['no']) $select="selected"; else $select="";
                $_rtn .= "<option value=" . $row1['no'] . " $select>". $row1['name'] . "</option>";
        }
        $_rtn .= "</select>\n";
        echo $_rtn;
?>
<?
    $useCategory = $row[use_category]; // 리스트 화면 설정
    $checked = ( $useCategory == 'Y' ) ? "checked " : ' '; // 번호
    echo "<input type='checkbox' name='use_category' value='Y' $checked onClick='abstractSource();'> 카테고리출력";
?>

                          </td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">스킨설정</font>&nbsp;</td>
                          <td class="text_01"> &nbsp;&nbsp; 
                            <select name='skin_name' class='jm_01' onChange='abstractSource();'>
<?
                                echo"<option value=''>-----스킨지정-----</option>";
                             // /skin 디렉토리에서 디렉토리를 구함
                                $skin_dir="skin/notice";
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

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">게시물 추출 범위</font>&nbsp;</td>
                          <td class="text_01">&nbsp;&nbsp; 
                            <input type="text"     name="start_pos" size="5" maxlength="3" value="<?=$row['start_pos']?>" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();'> 번째 게시물 부터 ~ <input type="text" name="end_pos" size="10" maxlength="3" value="<?=$row['end_pos']?>" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();' align='absmiddle'> 번째 게시물 까지
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">추출 텍스트 길이 제한&nbsp;</td>
                          <td class="text_01"> &nbsp;&nbsp; 
                            제목: <input type="text" name="title_limit"   size="5" maxlength="3" value="<?=$row['title_limit']?>"   onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();'>자 까지 &nbsp;&nbsp; | &nbsp;&nbsp;
                            내용: <input type="text" name="content_limit" size="5" maxlength="3" value="<?=$row['content_limit']?>" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; };abstractSource();'>자 까지
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">출력옵션&nbsp;</td>
                          <td class="text_01">&nbsp; 
    <input type='hidden' name='display_list' value=''>
<?
    $displayList = $row[display_list]; // 리스트 화면 설정
    $checked = ( $displayList[0] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 번호
    echo "<input type='checkbox' name='disp_list_no'        value='1' $checked> 번호 ";
    $checked = ( $displayList[1] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 이름
    echo "<input type='checkbox' name='disp_list_name'      value='1' $checked> 이름  ";
    $checked = ( $displayList[2] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 제목
    echo "<input type='checkbox' name='disp_list_title'         value='1' $checked> 제목 ";
    $checked = ( $displayList[3] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 파일
    echo "<input type='checkbox' name='disp_list_file'      value='1' $checked> 파일 ";
    $checked = ( $displayList[4] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 조회
    echo "<input type='checkbox' name='disp_list_hit'       value='1' $checked> 조회 ";
    $checked = ( $displayList[5] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 다운수
    echo "<input type='checkbox' name='disp_list_down_hit'  value='1' $checked> 다운수";
    $checked = ( $displayList[6] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 날짜
    echo "<input type='checkbox' name='disp_list_reg_date'  value='1' $checked> 날짜 ";
    $checked = ( $displayList[7] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 새글
    echo "<input type='checkbox' name='disp_list_new'       value='1' $checked> New ";
    $checked = ( $displayList[8] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // 당일의견글
    echo "<input type='checkbox' name='disp_list_comment'    value='1' $checked> 새 의견글<font color='#FF0000'> +</font> 표시";
?>
                           </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">선택 글 표시형식&nbsp;</td>
                          <td class="text_01"> &nbsp; 
<?
    $displayMode = $row[display_mode]; // 선택 글 표시형식
    if ( $displayMode == '1' ) {
        echo "<input type='radio' name='display_mode' value='1' checked onClick='displayContentInputButton();toggleNoticeContent(\"hide\");abstractSource();'> 현재창에서 이동 <input type='radio' name='display_mode' value='2' onClick='displayContentInputButton();abstractSource();'> 새창으로 띄우기 <a id='notice_content_0' style='display:none' href='#' onClick='toggleNoticeContent();return false;'><span class='text_04'>[ ☞ 팝업창 상하단 부분 디자인 ]</span></a>";
    } else {
        echo "<input type='radio' name='display_mode' value='1' onClick='displayContentInputButton();toggleNoticeContent(\"hide\");abstractSource();'> 현재창에서 이동 <input type='radio' name='display_mode' value='2' checked onClick='displayContentInputButton();abstractSource();'> 새창으로 띄우기 <a id='notice_content_0' style='display:none' href='#' onClick='toggleNoticeContent();return false;'><span class='text_04'>[ ☞ 팝업창 상하단 부분 디자인 ]</span></a>";
    }
?>
    <textarea name="header" style='display:none'><?=htmlspecialchars ( f_readFile($baseDir . "data/html/_dnotice_header_" . $row['bbs_id'] . ".php"), ENT_QUOTES)?></textarea>
    <textarea name="footer" style='display:none'><?=htmlspecialchars ( f_readFile($baseDir . "data/html/_dnotice_footer_" . $row['bbs_id'] . ".php"), ENT_QUOTES)?></textarea>
                          </td>
                        </tr>
    <input type='hidden' name='base_path' value='<?=$row['base_path']?>'>
    <input type="submit" border="0" value ='' name="imageField2" src="images/cancel.gif" width="66" height="21" style='position:absolute;top:800;left:0;'>
    <div style='position:absolute;top:800;left:0;width:100;height:50;background-color:f7f7f7;z-index:1'></div>
    </form>

    <form name='readTempageForm' action='admin/admin_pannel.php' method='post' enctype="multipart/form-data">

                        <tr id='notice_content_1' style='display:none'> 
                          <td height="30" class="text_01" align="center" bgcolor="eeeeee"><B>게시판 상단 하단 부분 파일 삽입</B></td>
                          <td height="30" class="text_01" align="center" bgcolor='#f7f7f7'>&nbsp;</td>
                        </tr>

                        <tr id='notice_content_2' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">상단파일 지정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="file" name="header_file" class="textarea_01" onChange="readTempage('header');">   
                            &nbsp;&nbsp;(파일을 불러오면 소스가 자동삽입 됩니다.)</td>
                        </tr>

        <input type='hidden' name='gubun'  value=''               >
        <input type='hidden' name='no'     value='<?=$row['no']?>'>
                        <tr id='notice_content_3' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">상단 부분 직접 작성&nbsp;</td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01" align='right'>
    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='headerPannel' id='headerPannel' scrolling='no' src='admin/admin_pannel.php?no=<?=$no?>&gubun=header'></iframe>
    </iframe>
                          </td>
                        </tr>
                        <tr id='notice_content_4' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">하단파일 지정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="file" name="footer_file" class="textarea_01" onChange="readTempage('footer');">
                            &nbsp;&nbsp;(파일을 불러오면 소스가 자동삽입 됩니다.)</td>
                        </tr>
                        <tr id='notice_content_5' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">하단 부분 직접 작성&nbsp;</td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01" align='right'>
    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='footerPannel' id='footerPannel' scrolling='no' src='admin/admin_pannel.php?no=<?=$no?>&gubun=footer'></iframe>
    </iframe>
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">추출소스를 삽입 할&nbsp;<br>파일이 들어있는 폴더 지정&nbsp;</td>
                          <td> 
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr> 
                                <td width="12" rowspan="3"></td>
                                <td>&nbsp; </td>
                                <td width="14" rowspan="3"></td>
                              </tr>
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
                        if ( obj.innerText == '.' ) {
                            pathObj.value = pathObj.value;
                        } else {
                            pathObj.value = pathObj.value + '/' + obj.innerText;
                        }
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
                              <tr> 
                                <td>
<?
    $base_path = $row['base_path'];
    echo ('<span class="text_04"> ※추출소스를 삽입하실 파일이 들어있는 폴더를 선택하시면 자동 입력됩니다.</span><BR>');
    function makeExplorer ($width=400,$height=300) {
        global $no,$base_path;
        echo "<iframe marginHeight='0' marginWidth='0' frameborder='0' width='$width' height='$height' name='explorer' id='explorer' src='admin/admin_board_explorer_iframe.php?base_path=". urlencode($base_path) ."'></iframe></iframe>";
    }
    makeExplorer ('556', '250');
?>
                                </td>
                              </tr>
                              <tr> 
                                <td>&nbsp;</td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="center" bgcolor="eeeeee" class="text_01" height="30"><b>인클루드 삽입 소스</b></td>
                          <td class="text_01" bgcolor="f7f7f7">&nbsp;&nbsp;&nbsp;아래 
                            소스를 삽입하실 HTML 파일 안 해당 위치에 넣어주시면 됩니다</td>
                        </tr>
                        <tr bgcolor="#FFFFFF">
                          <td align="right" bgcolor="#FFFFFF" class="text_01"><br>
                          </td>
                          <td class="text_01" height="190">&nbsp;&nbsp; 
                            <textarea name="abstract_source" cols="89" rows="12"></textarea>
                          </td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01" colspan="2" height="50"> 
                            <a href='#' onClick='if ( updateData () ) { document.boardAbstractForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30"></a>
                            <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30"></a>&nbsp;&nbsp;
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
    } // if END
}
?>