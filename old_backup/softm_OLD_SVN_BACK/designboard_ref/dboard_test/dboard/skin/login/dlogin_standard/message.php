<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center" valign="middle">
<table width="300" border="0" cellspacing="0" cellpadding="0" class="text_01">
        <tr bgcolor="cccccc"> 
          <td bgcolor="#FFFFFF" align="center"><b><?=$err->getErrMsg ()?></b></td>
        </tr>
        <tr bgcolor="cccccc"> 
          <td bgcolor="#FFFFFF" height="10"></td>
        </tr>
        <tr bgcolor="cccccc"> 
          <td height="2" bgcolor="F5F5F5"></td>
        </tr>
        <tr bgcolor="cccccc"> 
          <td height="1" bgcolor="cccccc"></td>
        </tr>
        <tr> 
          <td align="right" height="20"></td>
        </tr>
        <tr align="center"> 
          <td height="30"><?
// $this->errAction= ''; ::> 에러시 이동할 유알엘 및 자바 스크립트
// $this->errButton= ''; ::> 버튼 이름
// echo "<button onclick='" . $err->errAction . "'>" . $err->errButton . "</button>";
  echo "<a href='#' onclick='" . $err->errAction . "return false;'><img src='" . $loginSkinDir . "images/confirm.gif' border='0'></a>";
?>
</td>
        </tr>
        <tr> 
          <td height="20"></td>
        </tr>
        <tr> 
          <td bgcolor="cccccc" height="1"></td>
        </tr>
        <tr> 
          <td bgcolor="F5F5F5" height="2"></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>
