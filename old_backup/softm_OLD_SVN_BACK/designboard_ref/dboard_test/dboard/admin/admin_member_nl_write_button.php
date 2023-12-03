<?
header("Content-type: text/html; charset=euc-kr");
?>
<body>
<?

error_reporting(E_ALL ^ E_NOTICE); // Report all errors except E_NOTICE ( Notice는 제외한 모든에러를 리포팅해라~ )
if ( $mail_start != 'Y' ) {
?>
<script type="text/javascript">
<!--
    function startMail () {
        var frameObj      = parent.getObject("progressArea"); // IFRAME   OBJECT
//      var headerDocument = headerWindow.document    ; // DOCUMENT OBJECT
//      alert (  frameObj.contentWindow );
        frameObj.contentWindow.checkForm();
        return false;
    }
//-->
</SCRIPT>
<form name='buttonForm' method='post' onSubmit='alert ("Mi tiii");'>
    <input type="hidden" name="mail_start"       value='Y'>
<table align='left' width="500" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td background="../images/join_bg02.gif"></td>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="10"></td>
        </tr>
        <tr> 
          <td align="right">
            <a href='#' onClick='return startMail ();'><img border="0" name="imageField" src="../images/button_email.gif" width="79" height="30" align="absmiddle"></a>
            <a href='#' onClick='parent.close();return false;'><img border="0" name="imageField2" src="../images/button_close.gif" width="66" height="30" align="absmiddle"></a>
          </td>
        </tr>
      </table>
    </td>
    <td background="../images/join_bg03.gif"></td>
  </tr>
  <tr> 
    <td width="17" height="17"><img src="../images/join_03.gif" width="17" height="17"></td>
    <td background="../images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="../images/join_04.gif" width="17" height="17"></td>
  </tr>
</table>
</form>
<?
} else {
?>
<script type="text/javascript">
<!--
    function stopMail() { 
        var saveArea      = parent.frames[0];
        saveArea.mailSend = 'N';
    }

//-->
</SCRIPT>
<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td background="../images/join_bg02.gif"></td>
    <td> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="10"></td>
        </tr>
        <tr> 
          <td align="right">
            <a href='#' onClick='return stopMail();return false;'><img src="../images/button_emailc.gif" width="79" height="30" align="absmiddle" border='0'></a>
            <a href='#' onClick='parent.close();return false;'><img border="0" name="imageField2" src="../images/button_close.gif" width="66" height="30" align="absmiddle"></a>
          </td>
        </tr>
      </table>
    </td>
    <td background="../images/join_bg03.gif"></td>
  </tr>
  <tr> 
    <td width="17" height="17"><img src="../images/join_03.gif" width="17" height="17"></td>
    <td background="../images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="../images/join_04.gif" width="17" height="17"></td>
  </tr>
</table>
<?
}
?>
</body>