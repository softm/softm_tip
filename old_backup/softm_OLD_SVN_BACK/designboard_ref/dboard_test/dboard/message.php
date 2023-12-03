<table width="300" height="100%" border="0" cellspacing="0" cellpadding="0" align='center' valign='middle'>
  <tr> 
    <td width="100%" height="100%" valign='middle' align='center'>
    <table width="300" border="0" cellspacing="0" cellpadding="0" align='center' valign='middle'>
      <tr> 
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_01.gif" width="17" height="17"></td>
        <td background="<?=$baseDir?>images/join_bg01.gif"></td>
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_02.gif" width="17" height="17"></td>
      </tr>
      <tr> 
        <td background="<?=$baseDir?>images/join_bg02.gif"></td>
        <td> 
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td class="text_01" align="center"> 
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01" >
                  <tr bgcolor="fafafa"> 
                    <td class="text_01 bg_line2" height="1" background="<?=$baseDir?>images/bg2.gif"></td>
                  </tr>
                  <tr bgcolor="fafafa"> 
                    <td class="text_01" style="padding:10px 10px">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                        <tr> 
                          <td align="center"><b>Message</b></td>
                        </tr>
                        <tr> 
                          <td height="5"></td>
                        </tr>
                        <tr> 
                          <td align="center"> <?=$err->getErrMsg ()?></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr> 
                    <td height="1" bgcolor="fafafa" background="<?=$baseDir?>images/bg2.gif" class="bg_line2"></td>
                  </tr>
                </table>
                <br>
    <?
    echo "<a href='#' onclick='" . $err->errAction . ";return false;'><img src='" . $baseDir . "images/button_ok2.gif' width='66' height='30' border='0'></a>";
    // echo "<button onclick='" . $err->errAction . "'>" . $err->errButton . "</button>";
    // $this->errAction= ''; ::> 에러시 이동할 유알엘 및 자바 스크립트
    // $this->errButton= ''; ::> 버튼 이름
    ?>
                </td>
            </tr>
          </table>
        </td>
        <td background="<?=$baseDir?>images/join_bg03.gif"></td>
      </tr>
      <tr> 
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_03.gif" width="17" height="17"></td>
        <td background="<?=$baseDir?>images/join_bg04.gif" height="17"></td>
        <td width="17" height="17"><img src="<?=$baseDir?>images/join_04.gif" width="17" height="17"></td>
      </tr>
    </table>
    </td>
  </tr>
</table>