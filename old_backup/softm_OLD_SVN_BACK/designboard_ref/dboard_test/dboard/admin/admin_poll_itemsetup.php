<?
if ( function_exists('head') ) {
    if ( $branch == 'itemsetup' && preg_match("/${HTTP_HOST}/",$HTTP_REFERER) && preg_match( "/(admin_poll.php)$/", $HTTP_REFERER) && $REQUEST_METHOD == 'POST' ) {
        include ( 'common/file.inc'         ); // 파일
        $row = singleRowSQLQuery("select * from $tb_poll_master where no = '$poll_id'");
        $base_path = $row['base_path'];
?>

<?
    $doc_root = $DOCUMENT_ROOT;
    if ( substr($doc_root,strlen( $doc_root )-1) == '/' ) $doc_root = substr($doc_root,0,strlen( $doc_root )-1);
    echo "   <script type='text/javascript'>\n";
    echo "   <!--\n";
    echo 'var setup_dir = "'  .$sysInfor['setup_dir'] . '";'. "\n";
    echo 'var doc_root  = "'  .$doc_root              . '";'. "\n";
    echo 'var poll_id   = "'  .$poll_id               . '";'. "\n";
    echo "   //-->\n";
    echo "   </SCRIPT>\n";
?>

    <script type='text/javascript'>
    <!--
        function updateData () {
            var explorerObj      = getObject("explorer")      ; // IFRAME   OBJECT
            explorerWindow   = explorerObj.contentWindow  ; // WINDOW   OBJECT
            explorerDocument = explorerWindow.document    ; // DOCUMENT OBJECT

            if ( document.pollItemSetupForm.skin_name.selectedIndex == 0 ) {
                document.pollItemSetupForm.skin_name.focus();
                alert ( '스킨을 선택해 주세요.' );
                return false;
            }
            var headerObj      = getObject("headerPannel"); // IFRAME   OBJECT
            var headerWindow   = headerObj.contentWindow  ; // WINDOW   OBJECT
            var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
            var footerObj      = getObject("footerPannel"); // IFRAME   OBJECT
            var footerWindow   = footerObj.contentWindow  ; // WINDOW   OBJECT
            var footerDocument = footerWindow.document    ; // DOCUMENT OBJECT

            var start_year  = paddingChar(document.pollItemSetupForm.start_year.value   ,4,'0');
            var start_month = paddingChar(document.pollItemSetupForm.start_month.value  ,2,'0');
            var start_day   = paddingChar(document.pollItemSetupForm.start_day.value    ,2,'0');
            var start_hour  = paddingChar(document.pollItemSetupForm.start_hour.value   ,2,'0');
            var end_year    = paddingChar(document.pollItemSetupForm.end_year.value     ,4,'0');
            var end_month   = paddingChar(document.pollItemSetupForm.end_month.value    ,2,'0');
            var end_day     = paddingChar(document.pollItemSetupForm.end_day.value      ,2,'0');
            var end_hour    = paddingChar(document.pollItemSetupForm.end_hour.value     ,2,'0');

            if ( parseInt ( start_hour ) > 24 ) { start_hour = 24;  }
            if ( parseInt ( end_hour   ) > 24 ) { end_hour   = 24;  }

            document.pollItemSetupForm.start_year.value = start_year  ;
            document.pollItemSetupForm.start_month.value= start_month ;
            document.pollItemSetupForm.start_day.value  = start_day   ;
            document.pollItemSetupForm.start_hour.value = start_hour  ;
            document.pollItemSetupForm.end_year.value   = end_year    ;
            document.pollItemSetupForm.end_month.value  = end_month   ;
            document.pollItemSetupForm.end_day.value    = end_day     ;
            document.pollItemSetupForm.end_hour.value   = end_hour    ;
            var start_date = start_year + start_month + start_day + start_hour;
            var end_date   = end_year   + end_month   + end_day   + end_hour  ;

            abstractSource();

            document.pollItemSetupForm.header.value = headerDocument.dataForm.header.value;
            document.pollItemSetupForm.footer.value = footerDocument.dataForm.footer.value;
    //      return false;
            return true ;
        }

        function pollDateCheck () {
            var start_year  = paddingChar(document.pollItemSetupForm.start_year.value   ,4,'0');
            var start_month = paddingChar(document.pollItemSetupForm.start_month.value  ,2,'0');
            var start_day   = paddingChar(document.pollItemSetupForm.start_day.value    ,2,'0');
            var end_year    = paddingChar(document.pollItemSetupForm.end_year.value     ,4,'0');
            var end_month   = paddingChar(document.pollItemSetupForm.end_month.value    ,2,'0');
            var end_day     = paddingChar(document.pollItemSetupForm.end_day.value      ,2,'0');
            var start_date = start_year + start_month + start_day ;
            var end_date   = end_year   + end_month   + end_day   ;
            if ( !isDate(start_date) ) { alert('설문 시작일자가 올바르지 않습니다.'); return false; }
            if ( !isDate(end_date  ) ) { alert('설문 종료일자가 올바르지 않습니다.'); return false; }
            return true;
        }

        function readTempage(gubun) {
    //        document.pollItemSetupForm.enctype="multipart/form-data";
            document.readTempageForm.gubun.value  = gubun;
            document.readTempageForm.target = gubun + 'Pannel';
    //        document.pollItemSetupForm.action='admin_pannel.php';
    //        return true;
            document.readTempageForm.submit();
        }

        function abstractSource() {
            document.pollItemSetupForm.base_path.value = explorerWindow.document.explorerForm.path_infor.value;
            var base_path = document.pollItemSetupForm.base_path.value + '/';
            var obj = getObject ( explorerWindow.selectID , 'explorerWindow' );

            if ( explorerWindow.selectID == '' ) {
                baseDir = '디렉토리가 선택되지 않았습니다.';
            } else {
                baseDir = relativeDir(setup_dir, base_path);
            }

            var start_year  = paddingChar(document.pollItemSetupForm.start_year.value   ,4,'0');
            var start_month = paddingChar(document.pollItemSetupForm.start_month.value  ,2,'0');
            var start_day   = paddingChar(document.pollItemSetupForm.start_day.value    ,2,'0');
            var start_hour  = paddingChar(document.pollItemSetupForm.start_hour.value   ,2,'0');
            var end_year    = paddingChar(document.pollItemSetupForm.end_year.value     ,4,'0');
            var end_month   = paddingChar(document.pollItemSetupForm.end_month.value    ,2,'0');
            var end_day     = paddingChar(document.pollItemSetupForm.end_day.value      ,2,'0');
            var end_hour    = paddingChar(document.pollItemSetupForm.end_hour.value     ,2,'0');

            var start_date = start_year + start_month + start_day + start_hour;
            var end_date   = end_year   + end_month   + end_day   + end_hour  ;

            var source = '<\?\n';

            var opinion_yn = ( isChecked ( document.pollItemSetupForm.opinion_yn       ) ) ? 'Y' : 'N';

            var display_mode = checkedValue ( document.pollItemSetupForm.display_mode );

            source += '$baseDir               = "' + baseDir                                        + '";                // 디보드 설치 경로\n';
            source += "include ($baseDir . 'dpoll.php');\n";
            source += "\?\>";
            source += "\n";

            var useTop = document.pollItemSetupForm.use_top.checked;
            source += '<\? // 설문 조사 화면 \n';
            if ( !useTop ) {
                source += "createPoll( ";
                source += '"' + poll_id                                        + '",';
                source += '"poll",';
                source += '"' + document.pollItemSetupForm.skin_name.value     + '" ';
            } else {
                source += "createRecentPoll( ";
                source += '"poll"';
            }

            if ( !useTop ) {
    //          source += '"' + start_date                                     + '",';
    //          source += '"' + end_date                                       + '",';
    //          source += ''  + document.pollItemSetupForm.title_limit.value   + ',' ;
    //          source += '"' + opinion_yn                                     + '",';
    //          source += '"' + display_mode                                   + '"' ;
            }
            source += " );\n";
            source += "\?\>";

            source += "\n";
            source += '<\? // 설문 결과 화면 \n';
            if ( !useTop ) {
                source += "createPoll( ";
                source += '"' + poll_id                                        + '",';
                source += '"poll_result",';
                source += '"' + document.pollItemSetupForm.skin_name.value     + '" ';
            } else {
                source += "createRecentPoll( ";
                source += '"poll_result"';
            }

            if ( !useTop ) {
    //          source += '"' + start_date                                     + '",';
    //          source += '"' + end_date                                       + '",';
    //          source += ''  + document.pollItemSetupForm.title_limit.value   + ',' ;
    //          source += '"' + opinion_yn                                     + '",';
    //          source += '"' + display_mode                                   + '"' ;
            }
            source += " );\n";
            source += "\?\>";
    /*
            source += '$poll_id               = "' + poll_id                                        + '";                // 설문 아이디\n';
            source += '$poll_poll_skin_name   = "' + document.pollItemSetupForm.skin_name.value     + '";                // 스킨명\n';
            source += '$poll_start_date       = "' + start_date                                     + '";                // 설문 시작일\n';
            source += '$poll_end_date         = "' + end_date                                       + '";                // 설문 종료일\n';
            source += '$poll_title_limit      =  ' + document.pollItemSetupForm.title_limit.value   + ' ;                // 제목 길이\n' ;
            source += '$poll_opinion_yn       = "' + opinion_yn                                     + '";                // 의견출력\n' ;
            var display_mode = checkedValue ( document.pollItemSetupForm.display_mode );
            source += '$poll_display_mode     = '  + display_mode                                   + ' ;                // 결과화면 출력형식 ( 1 : 현재창에서 이동, 2 : 새창으로 띄우기 )\n';
    */
            var abstractObj = getObject('abstract_source');
            abstractObj.value = source;
        }

        function moveItemGrantPage (pollId) {
            document.pollItemSetupForm.branch.value  = 'grant';
            document.pollItemSetupForm.poll_id.value = pollId;
            document.pollItemSetupForm.submit();
        }

        function sucUrlToggle() {
            var pollProcess = checkedValue ( document.pollItemSetupForm.poll_process );
            if ( pollProcess == '3' ) {
                document.pollItemSetupForm.suc_url.readOnly=false;
                document.pollItemSetupForm.suc_url.style.backgroundColor='white';
                document.pollItemSetupForm.suc_url.focus();
            } else {
                document.pollItemSetupForm.suc_url.readOnly=true ;
                document.pollItemSetupForm.suc_url.style.backgroundColor='#E1E1E1';
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
                          <td align="right" colspan="2" height="45" background="images/top_06.gif">&nbsp;
                            <a href='#' onClick='moveItemGrantPage(<?=$poll_id?>);return false;'><img border="0" name="imageField422" src="images/button_poll_02.gif" width="66" height="30"></a>
                            <a href='#' onClick='if ( updateData () ) { document.pollItemSetupForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30"></a>
                            <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30"></a>&nbsp;&nbsp;
                          </td>
                        </tr>
    <form name='returnForm' method='post' action='admin_poll.php'>
        <input name='branch'    type='hidden' value='list'            >
        <input name='gubun'     type='hidden' value=''                >
        <input name='s'         type='hidden' value='<?=$s?>'         >
        <input name='tot'       type='hidden' value='<?=$tot?>'       >
        <input name='sort'      type='hidden' value='<?=$sort?>'      >
        <input name='desc'      type='hidden' value='<?=$desc?>'      >
    </form>

    <form name='pollItemSetupForm' action='admin_poll.php' method='post' onSubmit='return updateData();'>
        <input type='hidden' name='branch'  value='exec'           >
        <input type='hidden' name='gubun'   value='update'         >
        <input name='s'     type='hidden' value='<?=$s?>'    >
        <input name='tot'   type='hidden' value='<?=$tot?>'  >
        <input name='sort'  type='hidden' value='<?=$sort?>' >
        <input name='desc'  type='hidden' value='<?=$desc?>' >
        <input type='hidden' name='poll_id' value='<?=$row['no']?>'>
                        <tr> 
                          <td align="center" height="30" bgcolor="EEEEEE" width="210"><b>설문조사 정보 및 스킨설정</b></td>
                          <td bgcolor="F7F7F7">&nbsp;</td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" width="200">설문조사 제목&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF" >&nbsp;&nbsp;
                            <input type="text" name="title" size="90" maxlength="255" value='<?=_htmlspecialchars ( $row['title'],ENT_QUOTES);?>'>
                          </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right">설문조사 투표화면 
                            URL&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF"  class="text_04">&nbsp;&nbsp;
                            <a href='dpoll.php?poll_id=<?=$row['no']?>' target='poll_<?=$row['no']?>'>
                            <font color="BF0909">http://<?=$HTTP_HOST.$sysInfor["base_dir"]?>dpoll.php?poll_id=<?=$row['no']?></font>
                            </a>
                          </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right">설문조사 결과화면 URL&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_04">&nbsp;&nbsp;
                            <a href='dpoll.php?poll_id=<?=$row['no']?>&poll_exec=poll_result' target='poll_<?=$row['no']?>'>
                            <font color="BF0909">http://<?=$HTTP_HOST.$sysInfor["base_dir"]?>dpoll.php?poll_id=<?=$row['no']?>&poll_exec=poll_result</font>
                          </a>
                          </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right">스킨설정&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF" >&nbsp;&nbsp; 

    <select name='skin_name' class="jm_01" onChange='abstractSource();'>
<?
        echo"<option value=''>-----스킨지정-----</option>";
     // /skin 디렉토리에서 디렉토리를 구함
        $skin_dir="skin/poll";
        $handle = opendir($skin_dir);
        while ( $skin_info = readdir($handle) )
        {
            if(!preg_match("/\./",$skin_info)) {
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
                          <td bgcolor="EEEEEE" align="center" height="30"><b>권한 및 제한 설정</b></td>
                          <td bgcolor="F7F7F7">&nbsp;</td>
                        </tr>

                        <tr> 
                          <td bgcolor="#FFFFFF" align="right">설문기간&nbsp;</td>
                          <td bgcolor="#FFFFFF">&nbsp;
<?
    $checked = ( $row['use_top'] == 'Y' ) ? "checked" : ''; // 사용
    echo "<input type='checkbox' name='use_top' value='Y' $checked onClick='abstractSource();'>";
?>
                            항상 최근설문으로 </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right">&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF" >&nbsp;&nbsp; 
<?
        $start_date  = $row['start_date']; // 설문 조사 시작일
        $start_year  = substr($start_date, 0,4);
        $start_month = substr($start_date, 4,2);
        $start_day   = substr($start_date, 6,2);
        $start_hour  = substr($start_date, 8,2);
        $start_min   = substr($start_date,10,2);
        $start_sec   = substr($start_date,12,2);
        $end_date    = $row['end_date'];  // 설문 조사 종료일
        $end_year    = substr($end_date, 0,4);
        $end_month   = substr($end_date, 4,2);
        $end_day     = substr($end_date, 6,2);
        $end_hour    = substr($end_date, 8,2);
        $end_min     = substr($end_date,10,2);
        $end_sec     = substr($end_date,12,2);
?>
                            <input type="text" name="start_year"  size="5" maxlength="4" value='<?=$start_year?>' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !pollDateCheck () ) { return false; } abstractSource();'>년 
                            <input type="text" name="start_month" size="2" maxlength="2" value='<?=$start_month?>'onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !pollDateCheck () ) { return false; } abstractSource();'>월 
                            <input type="text" name="start_day"   size="2" maxlength="2" value='<?=$start_day?>'  onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !pollDateCheck () ) { return false; } abstractSource();'>일 
                            <input type="text" name="start_hour"  size="2" maxlength="2" value='<?=$start_hour?>' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !pollDateCheck () ) { return false; } abstractSource();'>시 
    <!--                         <input type="text" name="start_min"   size="2" maxlength="2" value='<?=$start_min?>'  >분 
                            <input type="text" name="start_sec"   size="2" maxlength="2" value='<?=$start_sec?>'  >초  -->
                            ~ 
                            <input type="text" name="end_year"    size="5" maxlength="4" value='<?=$end_year?>'  onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !pollDateCheck () ) { return false; } abstractSource();'>년 
                            <input type="text" name="end_month"   size="2" maxlength="2" value='<?=$end_month?>' onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !pollDateCheck () ) { return false; } abstractSource();'>월 
                            <input type="text" name="end_day"     size="2" maxlength="2" value='<?=$end_day?>'   onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !pollDateCheck () ) { return false; } abstractSource();'>일 
                            <input type="text" name="end_hour"    size="2" maxlength="2" value='<?=$end_hour?>'  onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } if ( !pollDateCheck () ) { return false; } abstractSource();'>시 
    <!--                         <input type="text" name="end_min"     size="2" maxlength="2" value='<?=$end_min?>'  >분 
                            <input type="text" name="end_sec"     size="2" maxlength="2" value='<?=$end_sec?>'  >초 --> 
                          </td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right">제목글자제한&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF" >&nbsp;&nbsp; 
                            <input type="text" name="title_limit" size="5" value="<?=$row['title_limit']?>" onChange='if(!isNumber (this.value)) { alert("숫자를 입력해주세요.");return false; } else { abstractSource(); }'>
                            글자 (제한된 글자수 이상은 ... 로 표시)</td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right">의견출력&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF" >&nbsp; 
<?
    $opinionYn = $row['opinion_yn']; // 의견출력
    $checked = ( $opinionYn == 'Y' ) ? "checked" : '';
    echo "<input type='checkbox' name='opinion_yn' value='Y' $checked onClick='abstractSource();'>";
?>
                            의견출력</td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">결과화면 출력형식&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;

<?
    $displayMode = $row[display_mode]; // 선택 글 표시형식
    if ( $displayMode == '2' ) {
        echo "<input type='radio' name='display_mode' value='2' checked onClick='abstractSource();'> 새창 <input type='radio' name='display_mode' value='1' onClick='abstractSource();'> 현재창 ";
    } else {
        echo "<input type='radio' name='display_mode' value='2' onClick='abstractSource();'> 새창 <input type='radio' name='display_mode' value='1' checked onClick='abstractSource();'> 현재창 ";
    }
?>
        <textarea name="header" style='width:0;height:1'><?=_htmlspecialchars ( f_readFile("data/html/_dpoll_header_" . $row['no'] . ".php"), ENT_QUOTES)?></textarea>
        <textarea name="footer" style='width:0;height:1'><?=_htmlspecialchars ( f_readFile("data/html/_dpoll_footer_" . $row['no'] . ".php"), ENT_QUOTES)?></textarea>
                           </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right" class="text_01">투표후 처리페이지&nbsp;</td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;
<?
    $pollProcess = $row[poll_process]; // 투표후 처리 페이지
    if ( $pollProcess == '1' ) {
        echo "<input type='radio' name='poll_process' value='1' checked onClick='sucUrlToggle();'> 결과화면으로 이동<input type='radio' name='poll_process' value='2' onClick='sucUrlToggle();'> 알림상자<input type='radio' name='poll_process' value='3' onClick='sucUrlToggle();'> 지정URL로 이동";
    } else if ( $pollProcess == '2' ) {
        echo "<input type='radio' name='poll_process' value='1' onClick='sucUrlToggle();'> 결과화면으로 이동<input type='radio' name='poll_process' value='2' checked onClick='sucUrlToggle();'> 알림상자<input type='radio' name='poll_process' value='3' onClick='sucUrlToggle();'> 지정URL로 이동";
    } else if ( $pollProcess == '3' ) {
        echo "<input type='radio' name='poll_process' value='1' onClick='sucUrlToggle();'> 결과화면으로 이동<input type='radio' name='poll_process' value='2' onClick='sucUrlToggle();'> 알림상자<input type='radio' name='poll_process' value='3' checked onClick='sucUrlToggle();'> 지정URL로 이동";
    }

    $sucUrl = $row[suc_url]; // 성공 이동 페이지
    if ( !$sucUrl ) $sucUrl = 'http://';
?>

    &nbsp;&nbsp;<input name="suc_url" type="text" value="<?=$sucUrl?>" size="30">
                           </td>
                        </tr>


                        <tr> 
                          <td bgcolor="EEEEEE" align="center" height="30"><b>설문조사 
                            항목 설정</b></td>
                          <td bgcolor="F7F7F7">&nbsp;</td>
                        </tr>

        <input type="submit" border="0" src="images/cancel.gif" width="66" height="21" style='position:absolute;top:800;left:0;'>
        <div style='position:absolute;top:800;left:0;width:100;height:50;background-color:f7f7f7;z-index:1'></div>

<?
        for ( $i=1; $i<=10; $i++ ) {
        if ( $i < 10 ) { $itemCd = '0'. $i; } else { $itemCd = $i; }
            $sql = "select item from $tb_poll_item where no = '$i' and p_no = '$poll_id';";
            $row  = singleRowSQLQuery ($sql);
            //logs ( $sql . ' / / / / / / / ' . $row['item'] . '<BR>', true);
            echo ("<tr> <td bgcolor='ffffff' align='right' width='200'> + 설문항목 $i&nbsp;&nbsp;</td><td bgcolor='#FFFFFF' > &nbsp;&nbsp; <input type='text' name='poll_item_$itemCd' size='90' value='" . _htmlspecialchars ($row['item'],ENT_QUOTES) . "'></td></tr>");
        }
?>
        <input type='hidden' name="item_cnt" value='10'>
        <input type='hidden' name='base_path' value='<?=$row['base_path']?>'>
    </form>

    <form name='readTempageForm' action='admin/admin_pannel.php' method='post' enctype="multipart/form-data">
        <input type='hidden' name='gubun'  value=''               >
        <input type='hidden' name='no'     value='<?=$row['no']?>'>
                        <tr> 
                          <td bgcolor="EEEEEE" align="right" height="30"><b>설문결과화면 상/하단 파일 삽입</b></td>
                          <td bgcolor="F7F7F7"> &nbsp;&nbsp; </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right"><font color="#333333">상단파일 지정&nbsp;</font></td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="file" name="header_file" class="textarea_01" onChange="readTempage('header');">   
                            &nbsp;&nbsp;(파일을 불러오면 소스가 자동삽입 됩니다.)</td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right"><font color="#333333">상단 
                            출력부분&nbsp;</font></td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01"> &nbsp;&nbsp; 

    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='headerPannel' id='headerPannel' src='admin/admin_pannel.php?no=<?=$no?>&gubun=header'></iframe>
    </iframe>
                          </td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right"><font color="#333333">하단파일 
                            지정&nbsp;</font></b></td>
                          <td bgcolor="#FFFFFF" class="text_01"> &nbsp;&nbsp; 
                            <input type="file" name="footer_file" class="textarea_01" onChange="readTempage('footer');">
                            &nbsp;&nbsp;(파일을 불러오면 소스가 자동삽입 됩니다.)</td>
                        </tr>
                        <tr> 
                          <td bgcolor="ffffff" align="right"><font color="#333333">하단 
                            출력부분&nbsp;</font></td>
                          <td bgcolor="#FFFFFF" height="190" class="text_01"> &nbsp;&nbsp; 
    <iframe marginHeight='0' marginWidth='0' frameborder='0' width='98%' height='100%' name='footerPannel' id='footerPannel' src='admin/admin_pannel.php?no=<?=$no?>&gubun=footer'></iframe>
    </iframe>
                          </td>
                        </tr>
    </form>
                        <tr bgcolor="#FFFFFF"> 
                          <td align="right" bgcolor="#FFFFFF" class="text_01" colspan="2" height="50"> 
                            <a href='#' onClick='moveItemGrantPage(<?=$poll_id?>);return false;'><img border="0" name="imageField422" src="images/button_poll_02.gif" width="66" height="30"></a>
                            <a href='#' onClick='if ( updateData () ) { document.pollItemSetupForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30"></a>
                            <a href='#' onClick='returnPage();return false;'><img border="0" name="imageField22" src="images/cancel.gif" width="66" height="30"></a>&nbsp;&nbsp;
                          </td>
                        </tr>

                        <tr> 
                          <td bgcolor="ffffff" align="right">설문조사 추출소스&nbsp;&nbsp;</td>
                          <td bgcolor="#FFFFFF"  class="text_05">
    <!--                       <font color="#0000FF">&nbsp;&nbsp;&nbsp;</font>&lt;? include ( &quot;..xxx/xxxxx.php ?&gt; -->
     
    <script type="text/javascript">
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
        global $poll_id,$base_path;
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
                                <a href='#' onClick='moveItemGrantPage(<?=$poll_id?>);return false;'><img border="0" name="imageField422" src="images/button_poll_02.gif" width="66" height="30"></a>
                                <a href='#' onClick='if ( updateData () ) { document.pollItemSetupForm.submit(); } return false;'><img border="0" name="imageField" src="images/confirm.gif" width="66" height="30"></a>
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