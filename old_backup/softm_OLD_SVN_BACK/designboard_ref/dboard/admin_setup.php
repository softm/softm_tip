<?
include ( "common/lib.inc"          ); // ���� ���̺귯��
include ( "common/message.inc"      ); // ���� ������ ó��

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
head("������ ���� ������");        // Header ���
_css ($skinDir); // css ����

if ( !$config ) { 
    Message ('P', '0002', 'MOVE:setup.php:�̵�');
}

if ( $memInfor['admin_yn'] == "N" ) {
    Message ('U', '0003', 'MOVE:admin.php:�̵�');
} else {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr> 
    <td valign="top" height="122"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td height="70">
<?
    include ( 'admin_top.php' ); // ��� �޴�
?>
          </td>
        </tr>
        <tr> 
          <td height="1" bgcolor="003A43"></td>
        </tr>
        <tr> 
          <td height="40" bgcolor="015966"></td>
        </tr>
        <tr> 
          <td height="1" bgcolor="003A43"></td>
        </tr>
        <tr> 
          <td height="10"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td valign="top" class="unnamed1"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
        <tr> 
          <td width="200" bgcolor="F5F5F5" valign="top"> 
<?
    include ( 'admin_left_menu.php'          ); // ���� �޴�
?>
          </td>
          <td bgcolor="FAFAFA" valign="top"> 


            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="854"> 
                  <table width="100%" border="0" cellspacing="1" cellpadding="2" bgcolor="CCCCCC" class="text_01">
                    <tr bgcolor="#FFFFFF"> 
                      <td colspan="4" height="40" bgcolor="#FFFFFF" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                          <tr> 
                            <td rowspan="3" width="30">&nbsp;</td>
                            <td height="30">&nbsp;</td>
                            <td rowspan="3" width="30">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td class="text_01">
                              <table width="100%" border="0" cellspacing="1" cellpadding="10" bgcolor="cccccc" class="text_01">
                                <tr> 
                                  <td bgcolor="fafafa" class="text_01"><b><font color="015966">�����κ��� 
                                    ����
<?
    $version = explode ( ' ', $_dboard_ver  );
    echo  $version[1];
?>
                                    ������ȭ�� �Դϴ�.</font></b><br>
                                    <br>
                                    �����κ��带 ����� �ּż� �����մϴ�.<br>
                                    �����κ���� PHP���� ����������� mySQL DB���� ���ư��� ����� �����ϴ°����� 
                                    �Խ��� ���α׷� �Դϴ�.<br>
                                    �����κ���� �Խ���, ȸ������, ��������, ���ϸ�����Ʈ, ��Ƽ������ ���ϰ� 
                                    �����ϰ� ����Ҽ� ������ ������ �پ��� ��ɰ� �̻۵������� ��Ų���� ��� �߰��� 
                                    �����Դϴ�. <br>
                                    ���� ASP������ JSP���� ���߰� ��� DB�� ���� �����ϰ� ���ڴ� ���������� 
                                    �ܱⰣ�� ���� �Ǹ���� ���������� �ʽ��ϴ�.<br>
                                    �����κ��忡 �߸��� �κ��� ���Ͻô� ����� �Ǵ� �ñ����� �����ø� <a href="http://www.Designboard.net" target="_blank"><font color="015966">www.Designboard.net</font></a> 
                                    ���� ��ź���� ������ �ֽʽÿ�. ^_^<br>
                                    ���� �������� ������ �Ųپ� ���ڽ��ϴ�.<br>
                                    �����κ��尡 ���е��� Ȩ�������� ����ôµ� �����̳��� ������ �Ǿ����� ���ڽ��ϴ�.<br>
                                    �ٽ��ѹ� �����κ��带 ����� �ּż� ����帮�� �̸� �������ϴ�... (--) 
                                    (__) (--) �ٹ�~</td>
                                </tr>
                              </table>
                              <br>
                              <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td bgcolor="F2F2F2" height="1"></td>
                                </tr>
                              </table>
                              <br>
                              <p><b>1. ���۱�</b> <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr> 
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�����κ���� ������� ����Ʈ����μ� ������ ������ ���Ѿ��� ��밡���ϸ� 
                                    ���α׷��� ���õ� �����鿡 ���� ��� ���۱� �� ���� �������� �����κ��忡�� 
                                    �ֽ��ϴ�. ��, ��Ų ���۱��� ��Ų �����ڿ��� �ֽ��ϴ�.</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�����κ���� �����κ��忡 ���� ���������� å���� ���� �ʽ��ϴ�.</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">- </td>
                                  <td>�� ���α׷� ����� ������Ȧ�� ���� ����Ÿ�� ���ǹ� ��Ÿ ���ؿ� ���� ��� 
                                    å�ӵ� ���� �ʽ��ϴ�.</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�����κ���� ����Ʈ����� ���۱ǹ��� ��ǻ�� ���α׷� ��ȣ���� ���� ��ȣ�ǰ� 
                                    �ֽ��ϴ�. </td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�����κ��� ���α׷� �ڵ��� ������ ���α׷� ���۱ǹ� �������� ��� ������ 
                                    �˴ϴ�. </td>
                                </tr>
                              </table>
                              <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td bgcolor="eeeeee" height="1"></td>
                                </tr>
                              </table>
                              <b><br>
                              2. ���� �� �����</b><br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr> 
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�����κ����� ������ Designboard.net ���� �̷������ ���������� 
                                    �ƴ϶�� ������� �� �ֽ��ϴ�.</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>���� �� ������ �����κ����� ������� Designboard.net �� ���Ǹ� 
                                    ���� �ϸ� Designboard.net ������ ���������մϴ�.</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�����κ��忡�� ������ ��Ų �̿��� ��Ų�� �ش� ��Ų�����ڿ��� ���۱��� �����Ƿ� 
                                    �ش� ��Ų�� ������� ��Ų�������� ���Ǿ��� ����� �Ҽ� �����ϴ�. </td>
                                </tr>
                              </table>
                              <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td bgcolor="eeeeee" height="1"></td>
                                </tr>
                              </table>
                              <br>
                              <b>3. ī�Ƕ���Ʈ ǥ�ÿ���</b><br>
                              <br>
                              1) �Խ��� �ϴ��� �ܺ� ī�Ƕ���Ʈ �ڵ� <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr> 
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�������δ� �����Դϴ�. ��, ȸ�糪 ���������� ����Ʈ�� ���� �ϽǼ� �����ϴ�. 
                                  </td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�� �����κ��忡�� �⺻���� �����ϴ� ��Ų�� �������� �ٸ� ��Ų�� ��Ų�����ڿ��� 
                                    ���۱��� �����Ƿ� ��Ų�������� ���� ���̴� ��Ų������ ��úκ��� �����ϽǼ� 
                                    �����ϴ�.</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>copyright Designboard / skin Designboard </td>
                                </tr>
                              </table>
                              <br>
                              2) HTML ����� ī�Ƕ���Ʈ �ڵ�»��� �ϽǼ� �����ϴ�. ������ ���Ͻø� ���ı��� 
                              ������ ���� ���� �Ͻ� �� �ֽ��ϴ�. <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr> 
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>PROGRAM NAME : Designboard (�����κ���)</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>VERSION : <?=$version[1]?> (<?=$_dboard_update_date?>)</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>DEVELOPER : Designboard</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�� ȹ : ȫ����</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>���α׷��� : ������</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�� �� �� : ������, ������, �ڼ���</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>HOMEPAGE : <a href="http://www.Designboard.net" target="_blank"><font color="015966">www.Designboard.net</font></a></td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">&nbsp;</td>
                                  <td>&nbsp;</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">&nbsp;</td>
                                  <td>copyright Designboard all rights reserved.<br>
                                    �� �����κ��忡 ���� ���� �� �ֽŹ����� Ȩ������(Designboard.net)���� 
                                    Ȯ���Ͻ� �� �ֽ��ϴ�.</td>
                                </tr>
                              </table>
                              <br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr> 
                                  <td bgcolor="eeeeee" height="1"></td>
                                </tr>
                              </table>
                              <b><br>
                              4. ���ı��� (HTML� ����ī�Ƕ����� �������)</b><br>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                <tr> 
                                  <td valign="top" colspan="2" height="8"></td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�����κ��� ����� �����Ǵ� ���α׷����� ����� ����ϽǼ� �ֽ��ϴ�. �����̳� 
                                    �񿵸� �����ΰ�� �ܺ�ī�Ƕ����� ������ �����ο� �������� ��ĥ ����� ������ 
                                    �ǵ��� �׳� ����Ͻñ⸦ �����մϴ�.</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>������ ȸ�糪 ���� ������ ��쳪 HTML� ����ī�Ƕ����͵� �� ����ð� 
                                    ������ �е��� ���� �����Ͻñ� �ٶ��ϴ�. <br>
                                    ���� ���Խ�û : <a href="mailto:order@Designboard.net">order@Designboard.net</a><BR><BR></td>
                                </tr>

                                <tr>
                                  <td valign="top" width="10">-</td>
                                  <td>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
                                      <tr> 
                                        <td>�� ���ı��Ժ� - 1���� ���̼��� ���ı����� 1���� ����Ʈ���� �ش��մϴ�.</td>
                                        <td align="right">(�ΰ�������)</td>
                                      </tr>
                                      <tr> 
                                        <td colspan="2" height="10"></td>
                                      </tr>
                                    </table>
                                    <table width="100%" border="0" cellspacing="1" cellpadding="4" bgcolor="cccccc" class="text_01">
                                      <tr align="center"> 
                                        <td bgcolor="eeeeee" width="25%"><b>���� ����Ȩ������</b></td>
                                        <td bgcolor="eeeeee" width="25%"><b>�����,�񿵸���ü</b></td>
                                        <td bgcolor="eeeeee" width="25%"><b>����, ���λ����</b></td>
                                        <td bgcolor="eeeeee" width="25%"><b>���δ�ü, ����ȸ��</b></td>
                                      </tr>
                                      <tr align="center"> 
                                        <td bgcolor="#FFFFFF">1����</td>
                                        <td bgcolor="#FFFFFF">2����</td>
                                        <td bgcolor="#FFFFFF">3����</td>
                                        <td bgcolor="#FFFFFF">5����</td>
                                      </tr>
                                    </table>
                                    <br>
<pre>
<B>��   ��: ��ü�� | ��   ��: 104539-02-088847 | ������: ȫ����</B>
</pre>
                                    �� ���� �����ϽǶ� ��ϵ� �����ο� ���ϸ� �������� �ٲ�� �Ǹ� ���� �Ͻø� �˴ϴ�. <br>
                                    <br>
                                  </td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>���ı��Ժ�� �����κ����� �������� ���׷��̵忡 ���� Ŀ�ǰ� �� ���� ������� 
                                    ��� �ϰڽ��ϴ�. -_-;;</td>
                                </tr>
                                <tr> 
                                  <td valign="top" width="10">-</td>
                                  <td>�����κ��忡 �߸��� �κ��� ���Ͻô� ����� ������ ��ź���� ������ �ֽʽÿ�. 
                                    �ִ��� �ݿ��ǵ��� ����ϰڽ��ϴ�.</td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td height="50">&nbsp;</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
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
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<?
    footer(); // Footer ���
}// else END
?>
