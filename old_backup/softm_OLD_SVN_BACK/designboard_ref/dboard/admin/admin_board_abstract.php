<?
if ( function_exists('_head') ) {
    if ( $branch == 'abstract' ) {
        include ( 'common/file.inc'         ); // ����
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
                alert ( '��Ų�� ������ �ּ���.' );
                return false;
            }

            var dispListNo       = ( isChecked ( document.boardAbstractForm.disp_list_no             ) ) ? '1' : '0';   // ��ȣ      
            var dispListName     = ( isChecked ( document.boardAbstractForm.disp_list_name           ) ) ? '1' : '0';   // �̸�      
            var dispListTitle    = ( isChecked ( document.boardAbstractForm.disp_list_title          ) ) ? '1' : '0';   // ����      
            var dispListFile     = ( isChecked ( document.boardAbstractForm.disp_list_file           ) ) ? '1' : '0';   // ����      
            var dispListHit      = ( isChecked ( document.boardAbstractForm.disp_list_hit            ) ) ? '1' : '0';   // ��ȸ      
            var dispListDownHit  = ( isChecked ( document.boardAbstractForm.disp_list_down_hit       ) ) ? '1' : '0';   // �ٿ��    
            var dispListReg_date = ( isChecked ( document.boardAbstractForm.disp_list_reg_date       ) ) ? '1' : '0';   // ��¥      
            var dispListNew      = ( isChecked ( document.boardAbstractForm.disp_list_new            ) ) ? '1' : '0';   // ����      
            var dispListComment  = ( isChecked ( document.boardAbstractForm.disp_list_comment        ) ) ? '1' : '0';   // �����ǰ߱�

            document.boardAbstractForm.display_list.value = dispListNo + dispListName + dispListTitle + dispListFile + dispListHit + dispListDownHit + dispListReg_date + dispListNew + dispListComment;

            document.boardAbstractForm.base_path.value = explorerDocument.explorerForm.path_infor.value;
            var obj = getObject ( explorerWindow.selectID , 'explorerWindow' );
    //        if (  explorerWindow.selectID == '' || obj.innerText == '..' ) {
    //            alert ( '���丮�� ������ �ּ���.' ) ;
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
                baseDir = '���丮�� ���õ��� �ʾҽ��ϴ�.';
            } else {
                baseDir = relativeDir(setup_dir.toLowerCase(), base_path.toLowerCase());
            }
            var source  = '<\?\n';
                source += "// createNotice(); �Լ� ���� ��ġ ���� �ּ���.\n";
                source += '$baseDir                 = "' + baseDir                                        + '";                // �𺸵� ��ġ ���\n';
                source += "include ($baseDir . 'dnotice.php');\n";
                source += "\?\>\n\n";

            var useCategory      = ( isChecked ( document.boardAbstractForm.use_category			 ) ) ? 'Y' : 'N';   // ī�װ� ��� ����

            var dispListNo       = ( isChecked ( document.boardAbstractForm.disp_list_no             ) ) ? '1' : '0';   // ��ȣ      
            var dispListName     = ( isChecked ( document.boardAbstractForm.disp_list_name           ) ) ? '1' : '0';   // �̸�      
            var dispListTitle    = ( isChecked ( document.boardAbstractForm.disp_list_title          ) ) ? '1' : '0';   // ����      
            var dispListFile     = ( isChecked ( document.boardAbstractForm.disp_list_file           ) ) ? '1' : '0';   // ����      
            var dispListHit      = ( isChecked ( document.boardAbstractForm.disp_list_hit            ) ) ? '1' : '0';   // ��ȸ      
            var dispListDownHit  = ( isChecked ( document.boardAbstractForm.disp_list_down_hit       ) ) ? '1' : '0';   // �ٿ��    
            var dispListReg_date = ( isChecked ( document.boardAbstractForm.disp_list_reg_date       ) ) ? '1' : '0';   // ��¥      
            var dispListNew      = ( isChecked ( document.boardAbstractForm.disp_list_new            ) ) ? '1' : '0';   // ����      
            var dispListComment  = ( isChecked ( document.boardAbstractForm.disp_list_comment        ) ) ? '1' : '0';   // �����ǰ߱�

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
            source += '$notice_id               = "' + bbs_id                                         + '";                // �Խ��� ���̵�\n';
            source += '$notice_skin_name        = "' + document.boardAbstractForm.skin_name.value     + '";                // ��Ų��\n';
            source += '$notice_start_pos        = '  + document.boardAbstractForm.start_pos.value     + ' ;                // �Խù� ���� ���� ��ġ\n' ;
            source += '$notice_end_pos          = '  + document.boardAbstractForm.end_pos.value       + ' ;                // �Խù� ���� ��   ��ġ\n' ;
            source += '$notice_title_limit      = '  + document.boardAbstractForm.title_limit.value   + ' ;                // ���� ����\n' ;
            source += '$notice_content_limit    = '  + document.boardAbstractForm.content_limit.value + ' ;                // ���� ����\n' ;
    //      alert ( document.boardAbstractForm.display_list.value );
            source += '$notice_display_list     = "' + display_list                                   + '";                // ��� �׸� : ��ȣ, �̸�, ����, ����, ��ȸ, �ٿ��, ��¥, ����, �����ǰ߱� ( 1 �̸� ��� , 0 �̸� �����)\n';

            var display_mode = checkedValue ( document.boardAbstractForm.display_mode );
            source += '$notice_display_mode     = '  + display_mode + ';           // ���� �� ǥ�� ���� ( 1: ����â���� �̵�, 2 :  ��â���� ���� )\n';
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
                            ���� ���� ����</b></td>
                          <td bgcolor="f7f7f7" align="center" class="text_01">&nbsp;</td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td bgcolor="#FFFFFF" align="right" class="text_01"><font color="#333333">����Խ���</font></td>
                          <td class="text_03"><b>&nbsp;&nbsp;&nbsp;&nbsp;<?=$row['bbs_id']?></b></td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">ī�װ�����</font>&nbsp;</td>
                          <td class="text_01"> &nbsp;&nbsp;
<?
        $sql1 = "select * from $tb_bbs_category" . "_" . $row['bbs_id'] . " order by o_seq;";
        $stmt1 = multiRowSQLQuery($sql1);
        $_rtn  = "<select name='cat_no' class='jm_01' onChange='abstractSource();'>";
        $_rtn .= "<option value=''>-----ī�װ�����-----</option>";
        while ( $row1 = multiRowFetch  ($stmt1) ) {
                if($row['cat_no']==$row1['no']) $select="selected"; else $select="";
                $_rtn .= "<option value=" . $row1['no'] . " $select>". $row1['name'] . "</option>";
        }
        $_rtn .= "</select>\n";
        echo $_rtn;
?>
<?
    $useCategory = $row[use_category]; // ����Ʈ ȭ�� ����
    $checked = ( $useCategory == 'Y' ) ? "checked " : ' '; // ��ȣ
    echo "<input type='checkbox' name='use_category' value='Y' $checked onClick='abstractSource();'> ī�װ����";
?>

                          </td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">��Ų����</font>&nbsp;</td>
                          <td class="text_01"> &nbsp;&nbsp; 
                            <select name='skin_name' class='jm_01' onChange='abstractSource();'>
<?
                                echo"<option value=''>-----��Ų����-----</option>";
                             // /skin ���丮���� ���丮�� ����
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
                          <td align="right" bgcolor="#FFFFFF" class="text_01"><font color="#333333">�Խù� ���� ����</font>&nbsp;</td>
                          <td class="text_01">&nbsp;&nbsp; 
                            <input type="text"     name="start_pos" size="5" maxlength="3" value="<?=$row['start_pos']?>" onChange='if(!isNumber (this.value)) { alert("���ڸ� �Է����ּ���.");return false; };abstractSource();'> ��° �Խù� ���� ~ <input type="text" name="end_pos" size="10" maxlength="3" value="<?=$row['end_pos']?>" onChange='if(!isNumber (this.value)) { alert("���ڸ� �Է����ּ���.");return false; };abstractSource();' align='absmiddle'> ��° �Խù� ����
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">���� �ؽ�Ʈ ���� ����&nbsp;</td>
                          <td class="text_01"> &nbsp;&nbsp; 
                            ����: <input type="text" name="title_limit"   size="5" maxlength="3" value="<?=$row['title_limit']?>"   onChange='if(!isNumber (this.value)) { alert("���ڸ� �Է����ּ���.");return false; };abstractSource();'>�� ���� &nbsp;&nbsp; | &nbsp;&nbsp;
                            ����: <input type="text" name="content_limit" size="5" maxlength="3" value="<?=$row['content_limit']?>" onChange='if(!isNumber (this.value)) { alert("���ڸ� �Է����ּ���.");return false; };abstractSource();'>�� ����
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">��¿ɼ�&nbsp;</td>
                          <td class="text_01">&nbsp; 
    <input type='hidden' name='display_list' value=''>
<?
    $displayList = $row[display_list]; // ����Ʈ ȭ�� ����
    $checked = ( $displayList[0] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // ��ȣ
    echo "<input type='checkbox' name='disp_list_no'        value='1' $checked> ��ȣ ";
    $checked = ( $displayList[1] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // �̸�
    echo "<input type='checkbox' name='disp_list_name'      value='1' $checked> �̸�  ";
    $checked = ( $displayList[2] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // ����
    echo "<input type='checkbox' name='disp_list_title'         value='1' $checked> ���� ";
    $checked = ( $displayList[3] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // ����
    echo "<input type='checkbox' name='disp_list_file'      value='1' $checked> ���� ";
    $checked = ( $displayList[4] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // ��ȸ
    echo "<input type='checkbox' name='disp_list_hit'       value='1' $checked> ��ȸ ";
    $checked = ( $displayList[5] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // �ٿ��
    echo "<input type='checkbox' name='disp_list_down_hit'  value='1' $checked> �ٿ��";
    $checked = ( $displayList[6] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // ��¥
    echo "<input type='checkbox' name='disp_list_reg_date'  value='1' $checked> ��¥ ";
    $checked = ( $displayList[7] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // ����
    echo "<input type='checkbox' name='disp_list_new'       value='1' $checked> New ";
    $checked = ( $displayList[8] ) ? "checked  onClick='abstractSource();' " : " onClick='abstractSource();' "; // �����ǰ߱�
    echo "<input type='checkbox' name='disp_list_comment'    value='1' $checked> �� �ǰ߱�<font color='#FF0000'> +</font> ǥ��";
?>
                           </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">���� �� ǥ������&nbsp;</td>
                          <td class="text_01"> &nbsp; 
<?
    $displayMode = $row[display_mode]; // ���� �� ǥ������
    if ( $displayMode == '1' ) {
        echo "<input type='radio' name='display_mode' value='1' checked onClick='displayContentInputButton();toggleNoticeContent(\"hide\");abstractSource();'> ����â���� �̵� <input type='radio' name='display_mode' value='2' onClick='displayContentInputButton();abstractSource();'> ��â���� ���� <a id='notice_content_0' style='display:none' href='#' onClick='toggleNoticeContent();return false;'><span class='text_04'>[ �� �˾�â ���ϴ� �κ� ������ ]</span></a>";
    } else {
        echo "<input type='radio' name='display_mode' value='1' onClick='displayContentInputButton();toggleNoticeContent(\"hide\");abstractSource();'> ����â���� �̵� <input type='radio' name='display_mode' value='2' checked onClick='displayContentInputButton();abstractSource();'> ��â���� ���� <a id='notice_content_0' style='display:none' href='#' onClick='toggleNoticeContent();return false;'><span class='text_04'>[ �� �˾�â ���ϴ� �κ� ������ ]</span></a>";
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
                          <td height="30" class="text_01" align="center" bgcolor="eeeeee"><B>�Խ��� ��� �ϴ� �κ� ���� ����</B></td>
                          <td height="30" class="text_01" align="center" bgcolor='#f7f7f7'>&nbsp;</td>
                        </tr>

                        <tr id='notice_content_2' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">������� ����&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="file" name="header_file" class="textarea_01" onChange="readTempage('header');">   
                            &nbsp;&nbsp;(������ �ҷ����� �ҽ��� �ڵ����� �˴ϴ�.)</td>
                        </tr>

        <input type='hidden' name='gubun'  value=''               >
        <input type='hidden' name='no'     value='<?=$row['no']?>'>
                        <tr id='notice_content_3' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">��� �κ� ���� �ۼ�&nbsp;</td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01" align='right'>
    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='headerPannel' id='headerPannel' scrolling='no' src='admin/admin_pannel.php?no=<?=$no?>&gubun=header'></iframe>
    </iframe>
                          </td>
                        </tr>
                        <tr id='notice_content_4' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">�ϴ����� ����&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="file" name="footer_file" class="textarea_01" onChange="readTempage('footer');">
                            &nbsp;&nbsp;(������ �ҷ����� �ҽ��� �ڵ����� �˴ϴ�.)</td>
                        </tr>
                        <tr id='notice_content_5' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">�ϴ� �κ� ���� �ۼ�&nbsp;</td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01" align='right'>
    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='footerPannel' id='footerPannel' scrolling='no' src='admin/admin_pannel.php?no=<?=$no?>&gubun=footer'></iframe>
    </iframe>
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01">����ҽ��� ���� ��&nbsp;<br>������ ����ִ� ���� ����&nbsp;</td>
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
        BoxMenu   (explorerDocument, "menu_panel", 'explorerWindow')      ; // �޴� �ʱ�ȭ
        Menu ();
    }

    function Menu() {
        var menu0 = newMenu();// Menu Group 1
        menu0.appendValue( "delete"     , new MENU_ITEM( '����'  , 'DELETE'      , 0, "required"));
        createMenu(panel, menu0);
    }

    function BoxMenuCommand(key, val){
        switch(key) {
            case "DELETE":
                if ( confirm("���� ���� �Ͻðڽ��ϱ�.") ) {
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
    echo ('<span class="text_04"> ������ҽ��� �����Ͻ� ������ ����ִ� ������ �����Ͻø� �ڵ� �Էµ˴ϴ�.</span><BR>');
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
                          <td align="center" bgcolor="eeeeee" class="text_01" height="30"><b>��Ŭ��� ���� �ҽ�</b></td>
                          <td class="text_01" bgcolor="f7f7f7">&nbsp;&nbsp;&nbsp;�Ʒ� 
                            �ҽ��� �����Ͻ� HTML ���� �� �ش� ��ġ�� �־��ֽø� �˴ϴ�</td>
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