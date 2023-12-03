<?
$baseDir = '../';
include '../common/lib.inc'         ; // 공통 라이브러리
include '../common/message.inc'     ; // 에러 페이지 처리
$memInfor = getMemInfor(); // 세션에 저장되어있는 회원정보를 읽음

if ( $memInfor['admin_yn'] == "Y" ) {
    head("어드민_뉴스레터");        // Header 출력
    css($baseDir);
    include '../common/js/common_js.php'; // 공통 javascript
    include '../common/js/admin_member_js.php'; // 어드민 member javascript
?>
<script type="text/javascript">
<!--
    function inStrAllBlankCheck (argu) {
        if ( typeof ( argu ) == "object" ) argu = argu.value;
        var ch1="";
        for (var i=0;i<argu.length;i++) ch1 += " ";
        if ( argu == ch1 ) return true;
        else return false;
    }

    function checkForm() {
        var saveArea      = parent.frames[0];
        if ( parseInt(saveArea.totCnt) < 1 ) {
            alert ( '메일 발송할 회원이 없습니다.' );
            return false;
        }

        if ( document.mailerForm.from_mail.value != '' && !isEmail(document.mailerForm.from_mail) ) {
            alert ( '메일을 올바르게 입력해주세요.' );
            document.mailerForm.from_mail.focus();
            return false;
        }

        if ( document.mailerForm.from_name.value == '' || inStrAllBlankCheck(document.mailerForm.from_name) ) {
            alert ( '메일 발송자 이름을 입력해주세요.' );
            document.mailerForm.from_name.focus();
            return false;
        }

        if ( document.mailerForm.title.value == '' || inStrAllBlankCheck(document.mailerForm.title) ) {
            alert ( '제목을 올바르게 입력해주세요.' );
            document.mailerForm.title.focus();
            return false;
        }

        if ( document.mailerForm.content.value == '' || inStrAllBlankCheck(document.mailerForm.content) ) {
            alert ( '내용을 올바르게 입력해주세요.' );
            document.mailerForm.content.focus();
            return false;
        }

        saveArea.document.saveMailForm.content.value = document.mailerForm.content.value;
        saveArea.document.saveMailForm.title.value   = document.mailerForm.title.value  ;
        var buttonArea = parent.frames[3];
        buttonArea.document.buttonForm.submit();
        document.mailerForm.submit();
//      return true;
    }

    function getMailIInfor () {
        var saveArea      = parent.frames[0];

        if ( saveArea.curIdx <= saveArea.totCnt ) {
//          alert ( saveArea.document.saveMailForm.data[saveArea.curIdx] );
            var curInfor = saveArea.document.saveMailForm.data[saveArea.curIdx].value;
            curInfor = curInfor.split('$$');
            document.mailerForm.to_name.value = curInfor[0];
            document.mailerForm.to_mail.value = curInfor[1];
            var progress = getObject('progress');
            var percent  = getObject('percent' );
            var infor_1  = getObject('infor_1' );
            var infor_2  = getObject('infor_2' );
            var send_message = saveArea.getObject('send_message');
            var proVal   = ( saveArea.curIdx  / saveArea.totCnt ) * 100 + '%';
            if ( parseInt(proVal) > 0 ) {
                progress.width      = proVal;
                var _proVal = Math.round(parseFloat(proVal),-2);
                percent.innerHTML   = _proVal + '%';
                if ( _proVal == 100 ) {
                    infor_1.innerHTML   = ''         ;
                    infor_2.innerHTML   = '발송 완료';
                }
            }

            if ( saveArea.send == '0' || saveArea.send == '1' ) {
                if ( _proVal == 100 ) {
                    send_message.innerHTML   = '총 <span class="text_04">' + saveArea.totCnt + '</span>명중 <span class="text_04">' + ( saveArea.curIdx ) + '</span>명 의 회원께 발송되었습니다.';
                } else {
                    send_message.innerHTML   = '총 <span class="text_04">' + saveArea.totCnt + '</span>명중 <span class="text_04">' + ( saveArea.curIdx ) + '</span>명 의 회원께 발송중입니다.';
                }
            } else if ( saveArea.send == '2' ) {
                send_message.innerHTML   = '메일 발송이 완료되었습니다';
            } else if ( saveArea.send == '3' || saveArea.send == '4' ) {
                if ( _proVal == 100 ) {
                    send_message.innerHTML   = '총 <span class="text_04">' + saveArea.totCnt + '</span>명중 <span class="text_04">' + ( saveArea.curIdx ) + '</span>명 의 회원께 발송되었습니다.';
                } else {
                    send_message.innerHTML   = '총 <span class="text_04">' + saveArea.totCnt + '</span>명중 <span class="text_04">' + ( saveArea.curIdx ) + '</span>명 의 회원께 발송중입니다.';
                }
            }
//          alert ( percent + ' || ' + percent.innerHtml );
            saveArea.mailSend = 'Y';
            document.mailerForm.content.value = saveArea.document.saveMailForm.content.value;
            document.mailerForm.title.value   = saveArea.document.saveMailForm.title.value  ;
            document.mailerForm.submit();
            saveArea.curIdx++;
//          alert ( saveArea.document.saveMailForm.data[saveArea.curIdx] );
        } else {
            saveArea.mailSend == 'N';
        }
    }
//-->
</SCRIPT>
</head>
<body onLoad='getMailIInfor()'>

<?if ( $start == 'Y' ) {
?>
<form name='mailerForm' method='post' action='admin_member_nl_send.php' target = 'translateArea'>
<input type='hidden' name='from_mail' value='<?=$from_mail?>'>
<input type='hidden' name='from_name' value='<?=$from_name?>'>
<input type='hidden' name='title'     value=''>
<input type='hidden' name='content'   value=''>
<input type='hidden' name='to_mail'   value=''>
<input type='hidden' name='to_name'   value=''>

<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td background="../images/join_bg02.gif" width="17"></td>
    <td> 
      <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC" class="text_01">
        <tr> 
          <td bgcolor="fafafa" align="right" height="327"> 
            <table width="400" border="0" cellspacing="0" cellpadding="0" align="center" class="text_01">
              <tr> 
                <td>&nbsp;</td>
              </tr>
              <tr> 
                <td> 
                  <table width="100%" border="0" cellspacing="1" cellpadding="0" bgcolor="cccccc">
                    <tr> 
                      <td id='progress' bgcolor="dddddd" width="" height="20">&nbsp;</td>
                      <td bgcolor="#FFFFFF" width="1" height="11"></td>
                    </tr>
                  </table>
                </td>
              </tr>
              <tr> 
                <td align="center">&nbsp; </td>
              </tr>
              <tr> 
                <td align="center"><span id='infor_1'>현재</span> <span class="text_04" id='percent'>0%</span> <span id='infor_2'>발송</span>.</td>
              </tr>
            </table>
            <br>
            <br>
          </td>
        </tr>
      </table>
    </td>
    <td background="../images/join_bg03.gif" width="17"></td>
  </tr>
</table>
</form>
<?} else {
?>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<form name='mailerForm' method='post'>
    <input type="hidden" name="start"       value='Y'>
    <input type="hidden" name="from_mail11" value='<?=$memInfor['e_mail']?>'>
  <tr> 
    <td background="../images/join_bg02.gif" width="17"></td>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr bgcolor="fafafa"> 
          <td colspan="2" align="right" class="bg_line2" height="1" background="../images/bg2.gif"></td>
        </tr>
        <tr bgcolor="fafafa"> 
          <td width="100" align="right" class="text_01"><b>이메일</b></td>
          <td> 
            <input type="text" name="from_mail" maxlength="100" size="55" value='<?=$memInfor['e_mail']?>'>
          </td>
        </tr>
        <tr> 
          <td colspan="2" height="1" bgcolor="fafafa" background="../images/bg2.gif" class="bg_line2"></td>
        </tr>
        <tr bgcolor="fafafa"> 
          <td align="right" class="text_01"><b>이름</b></td>
          <td> 
            <input type="text" name="from_name" maxlength="20" size="55" value='<?=$memInfor['name']?>'>
          </td>
        </tr>
        <tr bgcolor="fafafa"> 
          <td align="right" colspan="2" height="1" background="../images/bg2.gif" class="bg_line2"></td>
        </tr>
        <tr bgcolor="fafafa"> 
          <td align="right" class="text_01"><b>제목</b></td>
          <td> 
            <input type="text" name="title" maxlength="255" size="55">
          </td>
        </tr>
        <tr bgcolor="fafafa"> 
          <td align="right" colspan="2" height="1" background="../images/bg2.gif" class="bg_line2"></td>
        </tr>
        <tr bgcolor="fafafa"> 
          <td align="right" class="text_01"><b>내 용</b></td>
          <td>
            <textarea name="content" cols="53" rows="15"></textarea>
          </td>
        </tr>
        <tr bgcolor="fafafa"> 
          <td align="right" colspan="2" height="1" background="../images/bg2.gif" class="bg_line2"></td>
        </tr>
      </table>
    </td>
    <td background="../images/join_bg03.gif" width="17"></td>
  </tr>
</form>
</table>
<?
    }
    footer(); // Footer 출력
}
?>
