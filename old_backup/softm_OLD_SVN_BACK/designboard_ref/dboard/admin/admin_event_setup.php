<?
if ( function_exists('_head') ) {
    if ( $branch == 'setup' && ereg($HTTP_HOST,$HTTP_REFERER) && ereg( "(admin_event.php)", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
        include ( 'common/file.inc'         ); // 파일

        $row = singleRowSQLQuery("select * from $tb_event where no = '$event_id'");
        $base_path = $row['base_path'];
?>

<?
    $doc_root = $DOCUMENT_ROOT;
    if ( substr($doc_root,strlen( $doc_root )-1) == '/' ) $doc_root = substr($doc_root,0,strlen( $doc_root )-1);
    echo "   <SCRIPT LANGUAGE='JavaScript'>\n";
    echo "   <!--\n";
    echo 'var setup_dir = "'  .$sysInfor['setup_dir'] . '";'. "\n";
    echo 'var doc_root  = "'  .$doc_root              . '";'. "\n";
    echo 'var event_id  = "'  .$event_id              . '";'. "\n";
    echo "   //-->\n";
    echo "   </SCRIPT>\n";
?>

    <SCRIPT LANGUAGE='javascript'>
    <!--
        function updateData () {
            if ( document.eventSetupForm.login_skin_name.selectedIndex == 0 && !isChecked ( document.eventSetupForm.use_default_login ) ) {
                document.eventSetupForm.login_skin_name.focus();
                alert ( '로그인 스킨을 선택해 주세요.' );
                return false;
            }
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT

            var start_year  = paddingChar(document.eventSetupForm.start_year.value   ,4,'0');
            var start_month = paddingChar(document.eventSetupForm.start_month.value  ,2,'0');
            var start_day   = paddingChar(document.eventSetupForm.start_day.value    ,2,'0');
            var start_hour  = paddingChar(document.eventSetupForm.start_hour.value   ,2,'0');
            var end_year    = paddingChar(document.eventSetupForm.end_year.value     ,4,'0');
            var end_month   = paddingChar(document.eventSetupForm.end_month.value    ,2,'0');
            var end_day     = paddingChar(document.eventSetupForm.end_day.value      ,2,'0');
            var end_hour    = paddingChar(document.eventSetupForm.end_hour.value     ,2,'0');

            if ( parseInt ( start_hour ) > 24 ) { start_hour = 24;  }
            if ( parseInt ( end_hour   ) > 24 ) { end_hour   = 24;  }

            document.eventSetupForm.start_year.value = start_year  ;
            document.eventSetupForm.start_month.value= start_month ;
            document.eventSetupForm.start_day.value  = start_day   ;
            document.eventSetupForm.start_hour.value = start_hour  ;
            document.eventSetupForm.end_year.value   = end_year    ;
            document.eventSetupForm.end_month.value  = end_month   ;
            document.eventSetupForm.end_day.value    = end_day     ;
            document.eventSetupForm.end_hour.value   = end_hour    ;
            var start_date = start_year + start_month + start_day + start_hour;
            var end_date   = end_year   + end_month   + end_day   + end_hour  ;

            document.eventSetupForm.base_path.value = explorerDocument.explorerForm.path_infor.value;
            var obj = getObject ( explorerWindow.selectID , 'explorerWindow' );
    /*
            if (  explorerWindow.selectID == '' || obj.innerText == '..' ) {
                alert ( '디렉토리를 선택해 주세요.' ) ;
                return false;
            }
    */
    //      document.eventSetupForm.base_path.value = explorerDocument.explorerForm.path_infor.value;

            abstractSource();

            document.eventSetupForm.header.value = headerDocument.dataForm.header.value;
    //      return false;
            return true ;
        }

        function eventDateCheck () {
            var start_year  = paddingChar(document.eventSetupForm.start_year.value   ,4,'0');
            var start_month = paddingChar(document.eventSetupForm.start_month.value  ,2,'0');
            var start_day   = paddingChar(document.eventSetupForm.start_day.value    ,2,'0');
            var end_year    = paddingChar(document.eventSetupForm.end_year.value     ,4,'0');
            var end_month   = paddingChar(document.eventSetupForm.end_month.value    ,2,'0');
            var end_day     = paddingChar(document.eventSetupForm.end_day.value      ,2,'0');
            var start_date = start_year + start_month + start_day ;
            var end_date   = end_year   + end_month   + end_day   ;
            if ( !isDate(start_date) ) { alert('설문 시작일자가 올바르지 않습니다.'); return false; }
            if ( !isDate(end_date  ) ) { alert('설문 종료일자가 올바르지 않습니다.'); return false; }
            return true;
        }

        function readTempage(gubun) {
    //        document.eventSetupForm.enctype="multipart/form-data";
            document.readTempageForm.gubun.value  = gubun;
            document.readTempageForm.target = gubun + 'Pannel';
    //        document.eventSetupForm.action='admin_poll_resultsetup_pannel.php';
    //        return true;
            document.readTempageForm.submit();
        }

        function abstractSource() {

            document.eventSetupForm.base_path.value = explorerWindow.document.explorerForm.path_infor.value;
            var base_path = document.eventSetupForm.base_path.value + '/';
            var obj = getObject ( explorerWindow.selectID , 'explorerWindow' );

            if ( explorerWindow.selectID == '' ) {
                baseDir = '디렉토리가 선택되지 않았습니다.';
            } else {
                baseDir = relativeDir(setup_dir, base_path);
            }

            var start_year  = paddingChar(document.eventSetupForm.start_year.value   ,4,'0');
            var start_month = paddingChar(document.eventSetupForm.start_month.value  ,2,'0');
            var start_day   = paddingChar(document.eventSetupForm.start_day.value    ,2,'0');
            var start_hour  = paddingChar(document.eventSetupForm.start_hour.value   ,2,'0');
            var end_year    = paddingChar(document.eventSetupForm.end_year.value     ,4,'0');
            var end_month   = paddingChar(document.eventSetupForm.end_month.value    ,2,'0');
            var end_day     = paddingChar(document.eventSetupForm.end_day.value      ,2,'0');
            var end_hour    = paddingChar(document.eventSetupForm.end_hour.value     ,2,'0');

            var start_date = start_year + start_month + start_day + start_hour;
            var end_date   = end_year   + end_month   + end_day   + end_hour  ;

            var source = '<\?\n';

            var display_mode = checkedValue ( document.eventSetupForm.display_mode );

            source += '$baseDir               = "' + baseDir                                        + '";                // 디보드 설치 경로\n';
            source += "include ($baseDir . 'devent.php');\n";
            source += "\?\>";
            source += "\n";

            var useTop = document.eventSetupForm.use_top.checked;
            source += '<\? // 이벤트 화면 \n';
            if ( !useTop ) {
                source += "createEvent( ";
                source += '"' + event_id + '"';
                source += " );\n";
            } else {
                source += "createRecentEvent(";
                source += ");\n";
            }

            source += "\?\>";

            var abstractObj = getObject('abstract_source');
            abstractObj.value = source;
        }

        function moveItemGrantPage (eventId) {
            document.eventSetupForm.branch.value  = 'grant';
            document.eventSetupForm.event_id.value = eventId;
            document.eventSetupForm.submit();
        }

        function enabledPopUp() {
            var display_mode = checkedValue ( document.eventSetupForm.display_mode );
            var obj = getObject('_dboard_popup_pro');
            if ( display_mode == '1' ) {
                obj.style.display = '' ;
            } else {
                obj.style.display = 'none' ;
            }
        }

        var grantWin = null;
        function moveGrantPage (eventId) {
            if ( grantWin != null ) { grantWin.close(); }
            var url  = 'admin/admin_event_popup_grant.php?event_id=' + eventId;
            grantWin = window.open(url,'grantWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=416,height=225');
    //      grantWin = window.open ("about:blank",'grantWin');
            grantWin.focus();
        }

        function moveResultPage (eventId) {
            document.eventSetupForm.target           = '';
            document.eventSetupForm.method           = 'POST';
            document.eventSetupForm.action           = 'admin_event.php';
            document.eventSetupForm.branch.value     = 'result';
            document.eventSetupForm.event_id.value   = eventId;
            document.eventSetupForm.submit();
        }

        function loginSkinEnabled() {
            if ( isChecked(document.eventSetupForm.use_default_login) ) {
    //            objectBackColor( document.eventSetupForm.login_skin_name, 'E1E1E1'  );
                objectDisabled ( document.eventSetupForm.login_skin_name, 'Y'       );
            } else {
    //          objectBackColor( document.eventSetupForm.login_skin_name, 'white'  );
                objectDisabled ( document.eventSetupForm.login_skin_name,'N'     );
            }
        }

        function returnPage() {
            document.returnForm.submit();
        }
    //-->
    </SCRIPT>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="808">
                      <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" height="100%" class="text_01">
                        <tr bgcolor="#FFFFFF">
                          <td align="right" colspan="2" height="45" background="images/top_18.gif">&nbsp;
                            <a href='#' onClick='moveGrantPage(<?=$event_id?>);return false;'><img border="0" name="imageField422" src="images/button_poll_02.gif" width="66" height="30"></a>
                            <a href='#' onClick='moveResultPage(<?=$event_id?>);return false;'><img border="0" name="imageField422" src="images/button_result.gif" width="66" height="30"></a>
                            <a href='#' onClick='if ( updateData () ) { document.eventSetupForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30"></a>
                            <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30"></a>&nbsp;&nbsp;
                          </td>
                        </tr>
    <form name='returnForm' method='post' action='admin_event.php'>
        <input name='branch'    type='hidden' value='list'            >
        <input name='gubun'     type='hidden' value=''                >
        <input name='s'         type='hidden' value='<?=$s?>'         >
        <input name='tot'       type='hidden' value='<?=$tot?>'       >
        <input name='sort'      type='hidden' value='<?=$sort?>'      >
        <input name='desc'      type='hidden' value='<?=$desc?>'      >
    </form>

    <form name='eventSetupForm' action='admin_event.php' method='post' onSubmit='return updateData();'>
        <input type='hidden' name='branch'  value='exec'           >
        <input type='hidden' name='gubun'   value='update'         >
        <input type='hidden' name='event_id' value='<?=$row['no']?>'>
                        <tr>
                          <td align="center" height="30" bgcolor="EEEEEE" width="160"><b>이벤트 정보 설정</b></td>
                          <td bgcolor="F7F7F7">&nbsp;</td>
                        </tr>

                        <tr>
                          <td bgcolor="ffffff" align="right">이벤트 제목&nbsp;</td>
                          <td bgcolor="#FFFFFF" >&nbsp;&nbsp;
                            <input type="text" name="title" size="90" maxlength="255" value='<?=htmlspecialchars ( $row['title'],ENT_QUOTES);?>'>
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

                        <tr>
                          <td bgcolor="#FFFFFF" align="right">이벤트기간&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;
    <?
    $checked = ( $row['use_top'] == 'Y' ) ? "checked" : ''; // 사용
    echo "<input type='checkbox' name='use_top' value='Y' $checked onClick='abstractSource();'>";
    ?>
                            항상 최근 이벤트으로 </td>
                        </tr>

                        <tr>
                          <td bgcolor="ffffff" align="right">&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF" >&nbsp;&nbsp;
    <?
        $start_date  = $row['start_date'];  // 이벤트 시작일
        $start_year  = substr($start_date, 0,4);
        $start_month = substr($start_date, 4,2);
        $start_day   = substr($start_date, 6,2);
        $start_hour  = substr($start_date, 8,2);
        $start_min   = substr($start_date,10,2);
        $start_sec   = substr($start_date,12,2);
        $end_date    = $row['end_date'];    // 이벤트 종료일
        $end_year    = substr($end_date, 0,4);
        $end_month   = substr($end_date, 4,2);
        $end_day     = substr($end_date, 6,2);
        $end_hour    = substr($end_date, 8,2);
        $end_min     = substr($end_date,10,2);
        $end_sec     = substr($end_date,12,2);
    ?>
                            <input type="text" name="start_year"  size="5" maxlength="4" value='<?=$start_year?>' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !eventDateCheck () ) { return false; } abstractSource();'>년
                            <input type="text" name="start_month" size="2" maxlength="2" value='<?=$start_month?>'onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !eventDateCheck () ) { return false; } abstractSource();'>월
                            <input type="text" name="start_day"   size="2" maxlength="2" value='<?=$start_day?>'  onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !eventDateCheck () ) { return false; } abstractSource();'>일
                            <input type="text" name="start_hour"  size="2" maxlength="2" value='<?=$start_hour?>' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !eventDateCheck () ) { return false; } abstractSource();'>시
    <!--                         <input type="text" name="start_min"   size="2" maxlength="2" value='<?=$start_min?>'  >분
                            <input type="text" name="start_sec"   size="2" maxlength="2" value='<?=$start_sec?>'  >초  -->
                            ~
                            <input type="text" name="end_year"    size="5" maxlength="4" value='<?=$end_year?>'  onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !eventDateCheck () ) { return false; } abstractSource();'>년
                            <input type="text" name="end_month"   size="2" maxlength="2" value='<?=$end_month?>' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !eventDateCheck () ) { return false; } abstractSource();'>월
                            <input type="text" name="end_day"     size="2" maxlength="2" value='<?=$end_day?>'   onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !eventDateCheck () ) { return false; } abstractSource();'>일
                            <input type="text" name="end_hour"    size="2" maxlength="2" value='<?=$end_hour?>'  onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !eventDateCheck () ) { return false; } abstractSource();'>시
    <!--                         <input type="text" name="end_min"     size="2" maxlength="2" value='<?=$end_min?>'  >분
                            <input type="text" name="end_sec"     size="2" maxlength="2" value='<?=$end_sec?>'  >초 -->
                          </td>
                        </tr>
                        <tr>
                          <td bgcolor="ffffff" align="right">제목글자제한&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF" >&nbsp;&nbsp;
                            <input type="text" name="title_limit" size="5" value="<?=$row['title_limit']?>" onChange='abstractSource();'>
                            글자 (제한된 글자수 이상은 ... 로 표시)</td>
                        </tr>

                        <tr>
                          <td bgcolor="ffffff" align="right" class="text_01">이벤트 표시형식&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;
    <?
    $displayMode = $row[display_mode]; // 이벤트 표시형식 [ 1 : 팝업, 2 : 현재창, 3 : 링크 ]
    if ( $displayMode == '1' ) {
        echo "<input type='radio' name='display_mode' value='1' checked onClick='abstractSource();enabledPopUp();'> 팝업 <input type='radio' name='display_mode' value='2'         onClick='abstractSource();enabledPopUp();'> 현재창 <input type='radio' name='display_mode' value='3'         onClick='abstractSource();enabledPopUp();'> 링크";
    } else if ( $displayMode == '2' ) {
        echo "<input type='radio' name='display_mode' value='1'         onClick='abstractSource();enabledPopUp();'> 팝업 <input type='radio' name='display_mode' value='2' checked onClick='abstractSource();enabledPopUp();'> 현재창 <input type='radio' name='display_mode' value='3'         onClick='abstractSource();enabledPopUp();'> 링크";
    } else if ( $displayMode == '3' ) {
        echo "<input type='radio' name='display_mode' value='1'         onClick='abstractSource();enabledPopUp();'> 팝업 <input type='radio' name='display_mode' value='2'         onClick='abstractSource();enabledPopUp();'> 현재창 <input type='radio' name='display_mode' value='3' checked onClick='abstractSource();enabledPopUp();'> 링크";
    }
    ?>
        <textarea name="header" style='display:none'><?=htmlspecialchars ( f_readFile("data/event/$event_id/_dboard_event.php"), ENT_QUOTES)?></textarea>
                           </td>
                        </tr>

                        <tr id='_dboard_popup_pro' style='display:none'>
                          <td bgcolor="ffffff" align="right" class="text_01">&nbsp;</td>
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

                        <tr>
                          <td bgcolor="ffffff" align="right" class="text_01">이벤트후 처리페이지&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01">&nbsp;&nbsp;
    <?
    $sucUrl = $row[suc_url]; // 성공 이동 페이지
    if ( !$sucUrl ) $sucUrl = 'http://';
    ?>
    <input name="suc_url" type="text" value="<?=$sucUrl?>" size="30">
                           </td>
                        </tr>
        <input type="submit" border="0" src="images/cancel.gif" width="66" height="21" style='position:absolute;top:800;left:0;'>
        <div style='position:absolute;top:800;left:0;width:100;height:50;background-color:f7f7f7;z-index:1'></div>

        <input type='hidden' name='base_path' value='<?=$row['base_path']?>'>
    </form>

    <form name='eventItemForm' action='admin_event.php' method='post'>
        <input type='hidden' name='event_id' value='<?=$event_id?>'>
    <SCRIPT LANGUAGE="JavaScript">
    <!--
        var itemWin = null;
        function eventItemPopup() {
            if ( itemWin != null ) { itemWin.close(); }
            itemWin = window.open("about:blank",'itemWin','toolbar=no,menubar=no,resizable=no,scrollbars=yes,width=518,height=600');
    //        itemWin = popWindow("about:blank",518,600,0,0,'itemWin',"location=no,toolbar=no,menubar=no,resizable=yes,scrollbars=YES");
    //        itemWin = window.open ("about:blank",'itemWin');
            document.eventItemForm.action = 'admin/admin_event_popup_item.php';
            document.eventItemForm.target = 'itemWin'                         ;
            document.eventItemForm.submit();
            itemWin.focus();
        }
    //-->
    </SCRIPT>
                        <tr>
                          <td align="center" height="30" bgcolor="EEEEEE"><b>이벤트 페이지 설정</b></td>
                          <td bgcolor="F7F7F7"> &nbsp;&nbsp;
                          <a href='#' onClick='eventItemPopup();return false;'><img border="0" name="imageField422" src="images/button_event.gif" valign='absmiddle'></a>
                          </td>
                        </tr>
    </form>

    <form name='readTempageForm' action='admin/admin_pannel.php' method='post' enctype="multipart/form-data">
        <input type='hidden' name='gubun'  value=''               >
        <input type='hidden' name='no'     value='<?=$row['no']?>'>
                        <tr>
                          <td bgcolor="ffffff" align="right"><font color="#333333">이벤트 페이지 지정&nbsp;</font></td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp;
                            <input type="file" name="header_file" class="textarea_01" onChange="readTempage('header');" style='width:287'>
                            &nbsp;&nbsp;(파일을 불러오면 소스가 자동삽입 됩니다.)</td>
                        </tr>

                        <tr>
                          <td bgcolor="ffffff" align="right"><font color="#333333">이벤트 페이지&nbsp;</font></td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01"> &nbsp;&nbsp;

    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='headerPannel' id='headerPannel' src='admin/admin_pannel.php?no=<?=$no?>&gubun=header'></iframe>
    </iframe>
                          </td>
                        </tr>
    </form>

    <SCRIPT LANGUAGE="JavaScript">
    <!--
    function addScript (gubun) {
        var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
        var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
        var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
        if ( gubun == '1' ) {
            headerDocument.dataForm.header.value += "\n\<\?=$a_event_join\?\>참가</a>";
            headerDocument.dataForm.header.focus();
        } else if ( gubun == '2' ) {
    //        headerDocument.dataForm.header.value += "\<\?=$a_event_close\?\>;하루동안 열지 않음</a>";
            headerDocument.dataForm.header.value += "\n<a href='#' onClick='closeEventPopup(1)'>하루동안 열지 않음</a>";
            headerDocument.dataForm.header.focus();
        }
    }
    //-->
    </SCRIPT>

                        <tr>
                          <td bgcolor="ffffff" align="right"><font color="#333333">기능 버튼 삽입&nbsp;</font></td>
                          <td class="text_01" bgcolor="ffffff">&nbsp;&nbsp;&nbsp;
    <a href='#' onClick='addScript(1);return false;'><B>참가 버튼</B></a>, <a href='#' onClick='addScript(2);return false;'><B>하루동안 열지 않음</B></a>
                          </td>
                        </tr>

                        <tr>
                          <td bgcolor="ffffff" align="right">이벤트추출소스&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF"  class="text_05">
    <!--                       <font color="#0000FF">&nbsp;&nbsp;&nbsp;</font>&lt;? include ( &quot;..xxx/xxxxx.php ?&gt; -->

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

    <?
    echo ('&nbsp;&nbsp;&nbsp;<span class="text_04"> ※추출소스를 삽입하실 파일이 들어있는 폴더를 선택하시면 자동 입력됩니다.</span><BR>');
    function makeExplorer ($width=400,$height=300) {
        global $event_id,$base_path;
        echo "&nbsp;&nbsp;&nbsp;<iframe marginHeight='0' marginWidth='0' frameborder='0' width='$width' height='$height' name='explorer' id='explorer' src='admin/admin_board_explorer_iframe.php?base_path=". urlencode($base_path) ."'></iframe>";
    }
    makeExplorer ('561', '250');
    ?>
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
                            <textarea name="abstract_source" id="abstract_source" cols="90" rows="12"></textarea>
                          </td>
                        </tr>

                        <tr bgcolor="#FFFFFF">
                          <td align="right" colspan="2">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td align="right" colspan="2" height="5"></td>
                              </tr>
                              <tr>
                                <td align="right" width="808">
                                <a href='#' onClick='moveGrantPage(<?=$event_id?>);return false;'><img border="0" name="imageField422" src="images/button_poll_02.gif" width="66" height="30"></a>
                                <a href='#' onClick='moveResultPage(<?=$event_id?>);return false;'><img border="0" name="imageField422" src="images/button_result.gif" width="66" height="30"></a>
                                <a href='#' onClick='if ( updateData () ) { document.eventSetupForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30"></a>
                                <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30"></a>&nbsp;&nbsp;
                                </td>
                              </tr>
                            </table>
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
<?
    } // if END
}
?>