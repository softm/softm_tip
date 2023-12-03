<?
if ( function_exists('_head') ) {
    if ( $branch == 'setup' ) {
        include ( 'common/file.inc'         ); // 파일
        $row = singleRowSQLQuery("select * from $tb_login_abstract");
?>

<?
    $doc_root = $DOCUMENT_ROOT;
    if ( substr($doc_root,strlen( $doc_root )-1) == '/' ) $doc_root = substr($doc_root,0,strlen( $doc_root )-1);
    echo "   <SCRIPT LANGUAGE='JavaScript'>\n";
    echo "   <!--\n";
    echo 'var setup_dir = "'  .$sysInfor['setup_dir'] . '";'. "\n";
    echo 'var doc_root  = "'  .$doc_root              . '";'. "\n";
    echo "   //-->\n";
    echo "   </SCRIPT>\n";

    $selectedIndex = (int)$row[suc_mode] - 1;
    echo "<SCRIPT LANGUAGE='JavaScript'>\n";
    echo "<!--\n";
    echo "    var sucModeSelectedIndex = " . $selectedIndex . ";\n";
    echo "//-->\n";
    echo "</SCRIPT>\n";
?>
    <SCRIPT LANGUAGE='javascript'>
    <!--

        function updateData () {
            if ( document.loginAbstractForm.skin_name.selectedIndex == 0 ) {
                document.loginAbstractForm.skin_name.focus();
                alert ( '스킨을 선택해 주세요.' );
                return false;
            }
            abstractSource();
            document.loginAbstractForm.suc_mode.value = sucModObj.value;
            return true;
        }

        function abstractSource() {

            document.loginAbstractForm.base_path.value = explorerWindow.document.explorerForm.path_infor.value;
            var base_path = document.loginAbstractForm.base_path.value + '/';

            var obj = getObject ( explorerWindow.selectID , 'explorerWindow' );

            if ( explorerWindow.selectID == '' ) {
                baseDir = '디렉토리가 선택되지 않았습니다.';
            } else {
                baseDir = relativeDir(setup_dir, base_path);
            }

            var source  = '<\?\n';
                source += "// createLogin(); 함수 전에 위치 시켜 주세요.\n";
                source += '$baseDir                 = "' + baseDir                                        + '";                // 디보드 설치 경로\n';
                source += "include ($baseDir . 'dlogin.php');\n";
                source += "\?\>\n\n";
            var skin_name       = document.loginAbstractForm.skin_name.value;
            var display_mode    = checkedValue ( document.loginAbstractForm.display_mode );
            var suc_mode        = sucModObj.value;
            var suc_url         = document.loginAbstractForm.suc_url.value;
            var message         = document.loginAbstractForm.message.value;
            var window_width    = document.loginAbstractForm.window_width.value;
            var window_height   = document.loginAbstractForm.window_height.value;
            var left_pos        = document.loginAbstractForm.left_pos.value;
            var top_pos         = document.loginAbstractForm.top_pos.value;
            var scroll_yn       = ( isChecked ( document.loginAbstractForm.scroll_yn    ) ) ? 'yes' : 'no';

            if ( suc_mode == '2' || suc_mode == '3' ) { // 지정URL로 이동
                suc_url = suc_url.replace(/"/g,'\\"');
                suc_url = suc_url.replace(/'/g,"\\'");
            } else {
                suc_url = '';
            }

            if ( suc_mode == '2' || suc_mode == '4' ) { // 메시지화면
                message = message.replace(/"/g,'\\"');
                message = message.replace(/'/g,"\\'");
            } else {
                message = '';
            }

            if ( display_mode == '1' ) { 
                source += "<a href='#' onClick='loginPopup ( \"" + skin_name + "\",\"" + window_width + "\",\"" + window_height + "\",\"" + left_pos + "\",\"" + top_pos + "\",\"" + scroll_yn + "\",\"" + suc_mode + "\",\"" + suc_url + "\",\"" + message + "\");return false;'>로그인팝업</a>";
            } else {
                source += '<\?\n';
                source += "createLoginBox( ";
                source += '"' + skin_name   + '",' ;
                source += '"' + suc_mode    + '",' ;
                source += '"' + suc_url     + '",' ;
                source += '"' + message     + '"' ;
                source += " );\n";
                source += "\?\>";
            }
            document.readTempageForm.abstract_source.value = source;
        }

        function displayContentInputButton() {
            var display_mode = checkedValue ( document.loginAbstractForm.display_mode );
            if ( display_mode == 2 ) {
                objectShow    ( "notice_content_0" );
                objectPosition( "notice_content_0", 'relative');
            } else {
                objectHide    ( "notice_content_0" );
                objectPosition( "notice_content_0", 'absolute');
            }
        }

        function readTempage(gubun) {
    //        document.readTempageForm.enctype="multipart/form-data";
            document.readTempageForm.gubun.value  = gubun;
            document.readTempageForm.target = gubun + 'Pannel';
    //      document.readTempageForm.action='admin/admin_pannel.php';
    //      return true;
            document.readTempageForm.submit();
        }

        function enabledPopUp() {
            var display_mode = checkedValue ( document.loginAbstractForm.display_mode );
            var obj1 = getObject('_dboard_popup_pro');
            if ( display_mode == '1' ) {
                obj1.style.display = '' ;
            } else {
                obj1.style.display = 'none' ;
            }
        }

        function sucModeChange() {
            var sucMode = sucModObj.value;
            var obj1 = getObject('_dboard_suc_url');
            var obj2 = getObject('_dboard_message');
            if ( sucMode == '2' ) {
                obj1.style.display = '' ;
                obj2.style.display = '' ;
            } else if ( sucMode == '3' ) {
                obj1.style.display = '' ;
                obj2.style.display = 'none' ;
            } else if ( sucMode == '4' ) {
                obj1.style.display = 'none' ;
                obj2.style.display = '' ;
            } else {
                obj1.style.display = 'none' ;
                obj2.style.display = 'none' ;
            }
            sucModeSelectedIndex = sucModObj.selectedIndex;
            abstractSource();
        }
        var sucModObj = null;
        function displayModeToggle() {
            var obj = getObject( "_id_suc_mode" );
            var displayMode = checkedValue ( document.loginAbstractForm.display_mode );

            var mNod = document.createElement("select");
                mNod.setAttribute ("class", "jm_01");
                mNod.setAttribute ("id", "_id_suc_mode");
                mNod.onchange = sucModeChange;

            if ( displayMode == '1' ) { /* 팝업 */
                var sNod = null;
                    sNod = document.createElement("option");sNod.value='1';sNod.appendChild(document.createTextNode("로그아웃화면"));mNod.appendChild(sNod);
                    sNod = document.createElement("option");sNod.value='2';sNod.appendChild(document.createTextNode("메시지화면"));mNod.appendChild(sNod);
                    sNod = document.createElement("option");sNod.value='3';sNod.appendChild(document.createTextNode("지정URL로 이동"));mNod.appendChild(sNod);
                    sNod = document.createElement("option");sNod.value='4';sNod.appendChild(document.createTextNode("팝업닫기"));mNod.appendChild(sNod);
            } else { /* 페이지 */
                    sNod = document.createElement("option");sNod.value='1';sNod.appendChild(document.createTextNode("로그아웃화면"));mNod.appendChild(sNod);
                    sNod = document.createElement("option");sNod.value='2';sNod.appendChild(document.createTextNode("메시지화면"));mNod.appendChild(sNod);
                    sNod = document.createElement("option");sNod.value='3';sNod.appendChild(document.createTextNode("지정URL로 이동"));mNod.appendChild(sNod);
                    sNod = document.createElement("option");sNod.value='4';sNod.appendChild(document.createTextNode("윈도우닫기"));mNod.appendChild(sNod);
            }
            obj.parentNode.replaceChild(mNod, obj);
            //obj.appendChild(mNod);
            sucModObj = mNod;
            sucModObj.selectedIndex = sucModeSelectedIndex;
        }
    //-->
    </SCRIPT>

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="808">
                      <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" class="text_01">
    <form name='loginAbstractForm' action='admin_login.php' method='post' onSubmit='return updateData();'>
        <input type='hidden' name='branch' value='exec'           >
        <input type='hidden' name='gubun'  value='loginsetup'     >
        <input type='hidden' name='suc_mode'  value=''            >
                        <tr bgcolor="#FFFFFF"> 
                          <td colspan="2" height="45" class="text_01" align="right" background="images/top_17.gif"> 
                            <b>&nbsp;</b>
                            <a href='admin_member.php?branch=formsetup'><img src='images/button_join_modify.gif' border='0' align='absmiddle'></a>
                            <a href='#' onClick='if ( updateData () ) { document.loginAbstractForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30" align='absmiddle'></a>
                            <a href='admin_login.php'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30" align='absmiddle'></a>&nbsp;&nbsp;
                            </td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td width="200" height="30" align="center" bgcolor="eeeeee" class="text_01"><b> 기본 로그인 스킨 선택</b></td>
                          <td bgcolor="f7f7f7" align="" class="text_01">&nbsp;&nbsp;&nbsp;선택한 스킨이 디자인보드 전체 로그인 화면에 반영됩니다.</td>
    <!-- 내부 로그인 스킨이란?
    기존 게시판에 존재하던 로그인 화면을 별도로 로그인 스킨화 시킨것을 말합니다. -->
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">스킨설정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
    <select name='login_skin' class='jm_01' onChange='abstractSource();'>
<?
        echo"<option value=''>-----스킨지정-----</option>";
     // /skin 디렉토리에서 디렉토리를 구함
        $skin_dir="skin/login";
        $handle = opendir($skin_dir);
        while ( $skin_info = readdir($handle) )
        {
            if(!eregi("\.",$skin_info)) {
                if($skin_info==$sysInfor['login_skin']) $select="selected"; else $select="";
                echo"<option value=$skin_info $select>$skin_info</option>";
            }
        }
        closedir($handle);
?>
    </select> ( 디자인보드에서 사용될 기본 로그인을 선택합니다. )
                          </td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td width="200" height="30" align="center" bgcolor="eeeeee" class="text_01"><b> 
                            로그인 추출</b></td>
                          <td bgcolor="f7f7f7" align="center" class="text_01">&nbsp;</td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">스킨설정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
    <select name='skin_name' class='jm_01' onChange='abstractSource();'>
<?
        echo"<option value=''>-----스킨지정-----</option>";
     // /skin 디렉토리에서 디렉토리를 구함
        $skin_dir="skin/login";
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
                          <td bgcolor="ffffff" align="right" class="text_01">화면형식&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;
<?
    $displayMode = $row[display_mode]; // 화면 형식
    if ( $displayMode == '2' ) {
        echo "<input type='radio' name='display_mode' value='1' onClick='abstractSource();enabledPopUp();displayModeToggle();'> 팝업&nbsp;&nbsp;<input type='radio' name='display_mode' value='2' onClick='abstractSource();enabledPopUp();displayModeToggle();' checked> 현재창";
    } else {
        echo "<input type='radio' name='display_mode' value='1' onClick='abstractSource();enabledPopUp();displayModeToggle();' checked> 팝업&nbsp;&nbsp;<input type='radio' name='display_mode' value='2' onClick='abstractSource();enabledPopUp();displayModeToggle();'> 현재창";
    }
?>
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                            <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">로그인 성공시</font>&nbsp;</td>
                            <td class="text_01"> &nbsp;&nbsp; 
                                <span id='_id_suc_mode'></span>
                            </td>
                        </tr>

                        <tr id='_dboard_message' style='display:none;'>
                            <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">메시지</font>&nbsp;</td>
                            <td class="text_01" bgcolor='#FFFFFF'>
<?
    $message = htmlspecialchars ( $row['message'], ENT_QUOTES);
?>
    &nbsp;&nbsp;&nbsp;<input name="message" type="text" size="50" value='<?=$message?>' onKeyDown='abstractSource();'>
                            </td>
                        </tr>

                        <tr id='_dboard_suc_url' style='display:none;'>
                            <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">이동페이지</font>&nbsp;</td>
                            <td class="text_01" bgcolor='#FFFFFF'>
<?
    $sucUrl = $row[suc_url]; // 성공 이동 페이지
    if ( !$sucUrl ) $sucUrl = 'http://';
?>
    &nbsp;&nbsp;&nbsp;<input name="suc_url" type="text" size="50" value='<?=$sucUrl?>' onKeyDown='abstractSource();'>
                            </td>
                        </tr>

                        <tr id='_dboard_popup_pro' style='display:none;'>
                          <td bgcolor="ffffff" align="right" class="text_01">팝업설정&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp;
    Width  <input type="text" name="window_width"  size="5" maxlength="4" value='<?=$row['window_width' ]?>' onChange='if(!isNumber ( this.value) ) { alert("숫자를 입력해주세요.");return false; } else { abstractSource(); }' style='text-align:right'>
    Height <input type="text" name="window_height" size="5" maxlength="4" value='<?=$row['window_height']?>' onChange='if(!isNumber ( this.value) ) { alert("숫자를 입력해주세요.");return false; } else { abstractSource(); }' style='text-align:right'>
    Left   <input type="text" name="left_pos"      size="5" maxlength="4" value='<?=$row['left_pos'     ]?>' onChange='if(!isNumber ( this.value) ) { alert("숫자를 입력해주세요.");return false; } else { abstractSource(); }' style='text-align:right'>
    Top    <input type="text" name="top_pos"       size="5" maxlength="4" value='<?=$row['top_pos'      ]?>' onChange='if(!isNumber ( this.value) ) { alert("숫자를 입력해주세요.");return false; } else { abstractSource(); }' style='text-align:right'>
<?
    $checked = ( $row['scroll_yn'] == 'Y' ) ? "checked" : ''; // 스크롤바 사용
    echo "<input type='checkbox' name='scroll_yn' value='Y' $checked onClick='abstractSource();'> 스크롤바 ";
?>
                          </td>
                        </tr>


    <input type='hidden' name='base_path' value='<?=$row['base_path']?>'>
    <input type="submit" border="0" value ='' name="imageField2" src="images/cancel.gif" width="66" height="21" style='position:absolute;top:800;left:0;'>
    <div style='position:absolute;top:800;left:0;width:100;height:50;background-color:f7f7f7;z-index:1'></div>
    </form>
    <form name='readTempageForm' action='admin/admin_pannel.php' method='post' enctype="multipart/form-data">
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
                var file = null;
                if ( is.ie ) file = obj.innerText;
                else         file = obj.text;
                var dirNm = file;
                if ( explorerWindow.reselect_dir == '' ) { explorerWindow.reselect_dir = '.'; }
                if ( dirNm == explorerWindow.reselect_dir ) {
                    explorerWindow.selectID = id;
                    explorerWindow.selectedItemColor (id);
    //              obj.focus();
                    var pathObj = getObject("path_infor", 'explorerWindow');
                    if ( typeof(pathObj) == 'object' ) {
                        if ( file == '.' ) {
                            pathObj.value = pathObj.value;
                        } else {
                            pathObj.value = pathObj.value + '/' + file;
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
    makeExplorer ('556', '200');
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
                            소스를 삽입하실 HTML 파일 안 해당 위치에 넣어주시면 됍니다</td>
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
                            <a href='admin_member.php?branch=formsetup'><img src='images/button_join_modify.gif' border='0' align='absmiddle'></a>
                            <a href='#' onClick='if ( updateData () ) { document.loginAbstractForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30" align='absmiddle'></a>
                            <a href='admin_login.php'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30" align='absmiddle'></a>&nbsp;&nbsp;
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