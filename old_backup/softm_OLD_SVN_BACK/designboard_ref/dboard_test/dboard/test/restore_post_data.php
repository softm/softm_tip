<?
include $baseDir.'common/lib.inc'       ; // ���� ���̺귯��

include $baseDir.'common/board_lib.inc' ; // �Խ��� ���̺귯��
include $baseDir.'common/poll_lib.inc'  ; // ���� ���̺귯��
include $baseDir.'common/event_lib.inc' ; // �̺�Ʈ ���̺귯��
include $baseDir.'common/member_lib.inc'; // ��� ���̺귯��

include $baseDir.'common/message.inc'   ; // ���� ������ ó��
include $baseDir.'common/db_connect.inc'; // Data Base ���� Ŭ����
//strpos(__FILE__)
//preg_match( "/(setup2.php)$/", __FILE__) )
//define ("HOME_DIR" , realpath(dirname(dirname(dirname(__FILE__)))) );

head();          // Header ��� ( Ÿ��Ʋ�� ��µǴ� ���� ������ �߻��� ���)
css($baseDir);
    if ( $_POST['exec'] != 'Y' ) {
?>
<style type="text/css">

.input {
     border: 1px solid #006;
     background: #ffc;
 }
 .input:hover {
     border: 1px solid #f00;
     background: #ff6;
 }
 .button {
     border: 1px solid #006;
     background: #ccf;
 }
 .button:hover {
     border: 1px solid #f00;
     background: #eef;
 }
 label {
     display: block;
     width: 150px;
     float: left;
     margin: 2px 4px 6px 4px;
     text-align: right;
 }
 br { clear: left; }
</style>
<script type="text/javascript">
<!--
    function restoreForm_Sumbit() {
        return confirm('�����ȣ�� ������ �����Ͻðڽ��ϱ�?\n5~10������ �ҿ�˴ϴ�.');
    }
//-->
</script>
<form name='restoreForm' action="restore_post_data.php" method='POST' onsubmit='return restoreForm_Sumbit();'>
    <input type="hidden" name="exec"     value="Y">

<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center"> 
<!-- <span class="text_04"><B>+ �����ȣ�� �ٽ� �����մϴ�.dboard ���丮�� ���α׷� ������ ��ġ��Ű����. +</B></span><BR><BR> -->
      <table width="400" border="0" cellspacing="0" cellpadding="0">
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
                <td class="text_01"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td> 
                        <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" class="text_01">
                          <tr bgcolor="#FFFFFF"> 
                            <td colspan="2" height="30" align="center"> 
                              <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                <tr bgcolor="F7F7F7"> 
                                  <td width="10"></td>
                                  <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                      <tr> 
                                        <td><b>�����κ��� <?=$_dboard_ver?> - [ �����ȣ ���� ]</b></td>
                                      </tr>
                                      <tr> 
                                        <td height="5"></td>
                                      </tr>
                                      <tr> 
                                        <td class="text_04">
                                        �����ȣ�� �����մϴ�.<BR>dboard ���丮�� ���α׷� ������ ��ġ��Ű����. 
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="5"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr bgcolor="fafafa"> 
                      <td align="right" colspan="2" height="1" background="<?=$baseDir?>images/bg2.gif" class="text_01 bg_line2"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="10"></td>
                    </tr>
                    <tr> 
                      <td height="10" align="right"> 
                      <input type="submit" value="�����ȣ ����" class="button" />
                      </td>
                    </tr>
                  </table>
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
</form>
<?
    } else {
        set_time_limit ( 0 );
        $db = initDBConnection ();
        include ( "schema.sql"      ); // ��Ű��
        simpleSQLExecute("drop table $tb_post;" ); /* ���� ��ȣ ���̺� ���� */
        simpleSQLExecute($tb_post_schm          ); /* ���� ��ȣ             */

        if ( !isTable($tb_post) ) {
//          logs ( '$tb_post_schm :  / '. $tb_post_schm . '<BR>' , true);
        }
        //echo getCurrentDir ();
        $sql = "LOAD DATA INFILE '" . getCurrentDir () . "post.dat' INTO TABLE {$tb_post} FIELDS TERMINATED BY '^';";
        simpleSQLExecute($sql);

        /* �ٸ����
        $postFile = file("./post.dat");
        simpleSQLExecute("ALTER TABLE {$tb_post} DISABLE KEYS;");
        while ( $post = each($postFile) ) {
            $postData = explode ('^', $post[1]);
            if ( $postData[6] == 1 ) {
                $sql = 'insert into ' . $tb_post . " values ( '$postData[0]', '$postData[1]', '$postData[2]', '$postData[3]', '$postData[4]', '$postData[5]', '$postData[6]' );";
            } else {
                $sql = 'insert into ' . $tb_post . " values ( '$postData[0]', '', '$postData[4]', '$postData[1]', '$postData[2]', '$postData[3]', '2' );";
            }
            simpleSQLExecute($sql);
        }
        simpleSQLExecute("ALTER TABLE {$tb_post} ENABLE  KEYS;");
        */
        closeDBConnection (); // �����ͺ��̽� ���� ���� ����
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td align="center"> 
<!-- <span class="text_04"><B>+ �����ȣ�� �ٽ� �����մϴ�.dboard ���丮�� ���α׷� ������ ��ġ��Ű����. +</B></span><BR><BR> -->
      <table width="400" border="0" cellspacing="0" cellpadding="0">
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
                <td class="text_01"> 
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td> 
                        <table width="100%" border="0" cellspacing="1" cellpadding="3" bgcolor="CCCCCC" class="text_01">
                          <tr bgcolor="#FFFFFF"> 
                            <td colspan="2" height="30" align="center"> 
                              <table width="100%" border="0" cellspacing="0" cellpadding="5">
                                <tr bgcolor="F7F7F7"> 
                                  <td width="10"></td>
                                  <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                      <tr> 
                                        <td><b>�����κ��� <?=$_dboard_ver?> - [ �����ȣ ���� ]</b></td>
                                      </tr>
                                      <tr> 
                                        <td height="5"></td>
                                      </tr>
                                      <tr> 
                                        <td class="text_04">
                                        �����ȣ�� ���� �Ϸ�!!
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="5"></td>
                    </tr>
                  </table>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td height="10"></td>
                    </tr>
                  </table>
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
<?
    }
footer(); // Footer ���
?>