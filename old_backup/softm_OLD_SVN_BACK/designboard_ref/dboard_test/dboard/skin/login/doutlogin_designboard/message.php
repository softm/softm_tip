<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center" valign="middle">
<table width="300" border="0" cellspacing="0" cellpadding="0" class="text_01">
        <tr bgcolor="red"> 
          <td bgcolor="#FFFFFF" align="center"><b><?=$err->getErrMsg ()?></b></td>
        </tr>
        <tr bgcolor="red"> 
          <td bgcolor="#FFFFFF" height="10"></td>
        </tr>
        <tr bgcolor="red"> 
          <td height="2" bgcolor="F5F5F5"></td>
        </tr>
        <tr bgcolor="red"> 
          <td height="1" bgcolor="F5F5F5"></td>
        </tr>
        <tr> 
          <td align="right" height="20"></td>
        </tr>
        <tr align="center"> 
          <td height="30"><?
// $this->errAction= ''; ::> ������ �̵��� ���˿� �� �ڹ� ��ũ��Ʈ
// $this->errButton= ''; ::> ��ư �̸�
// echo "<button onclick='" . $err->errAction . "'>" . $err->errButton . "</button>";
  echo "<a href='#' onclick='" . $err->errAction . "'><img src='" . $baseDir . "images/button_ok2.gif' border='0'></a>";
?>
</td>
        </tr>
        <tr> 
          <td height="20"></td>
        </tr>
        <tr> 
          <td bgcolor="F5F5F5" height="1"></td>
        </tr>
        <tr> 
          <td bgcolor="F5F5F5" height="2"></td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>