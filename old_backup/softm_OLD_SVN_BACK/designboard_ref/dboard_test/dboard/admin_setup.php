<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( "common/lib.inc"          ); // ���� ���̺귯��
include ( "common/message.inc"      ); // ���� ������ ó��

$memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
head("������ ���� ������");        // Header ���
css ($skinDir); // css ����

if ( !$config ) {
    MessageExit('P', '0002', 'MOVE:setup.php:�̵�');
}

if ( $memInfor['admin_yn'] == "N" ) {
    MessageExit('U', '0003', 'MOVE:admin.php:�̵�');
} else {
?>
<!--
-->
<?
include 'common/js/common_js.php'; // ���� javascript
body('class="jui"');
    include 'common/rest/get_site_info.inc'; // ����Ʈ ���� ���. from designboard
//     echo PATCH_VERSION . " / " . MIG_VERSION;
?>
<!-- <a id="btn1" class="btn btn-large btn-purple">Large button</a> -->
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
<?php
include 'common/rest/set_admin_access_info.inc';
include 'common/patch/dboard_patch.inc';
if ( $patch_msg ) {
?>
      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
		<colgroup>
		<col width="100">
		<col width="">
		<col width="80">
		</colgroup>
        <tr>
          <td align="right" bgcolor="efefef"><strong>������Ʈ ����&nbsp;</strong></td>
          <td bgcolor="fafafa"><font color="990000"><span id='msg'>
          <?=$patch_title?>
          </span></font></td>
          <td bgcolor="fafafa" align="center">
          <button onclick="document.location.reload();">�ݱ�</button>
          </td>
        </tr>
        <tr>
          <td align="right" bgcolor="efefef" colspan="3">
          <textarea style="width:100%;height:50px;overflow:scroll;overflow-x:hidden;"><?=$patch_msg?></textarea>
          </td>
        </tr>
      </table>
<?
} else {
// ��ġ�� �Ϸ�Ǹ�
// ���̱׷��̼� ȭ���� �����ش�.
// ���̱׷��̼��� ���� �̱����̸�
// patch/dboard_migration.php�� �ܰ躰�� ajax�� �̿��ؼ� ȣ���ϰ�,
// ���α׷����ٸ� ���� �������� �����ִ� ���·��۾��� ��ȹ�̴�.
?>
	<?php
	if ( IS_DB_SCHEMA_UPDATE ) {
	?>
<SCRIPT type="text/javascript">
<!--
    function fCallSyncDB(){
        url = "";
        $.ajax (
        {
            async:false,
            url:url,
            type: "POST",
            dataType:'json',
            data:{
                param1:"param1",
                param2:"param2"
            }
        }).done(
            function(data) {
                //console.debug(data);
                $("#txt_result").get(0).value = " data.key1 : " + data.key1
                                              + "\n" + " data.key2 : " + data.key2
                                              + "\n" + " data.key3 : " + data.key3
                ;
                //console.debug("data", data);
            }
        );
    }

	function progress(gubun, totProgCnt, curCnt ) {

    var proVal   = parseInt(( totProgCnt / parseInt(total) ) * 100);
        percentObj.innerHTML   = Math.round(parseFloat(proVal),-2) + '%';
        if ( proVal > 0 ) {
            progressObj.width      = proVal + '%';
        }

        if ( gubun == 'board' ) {
            getObject('board_insert_total'          ).innerHTML = curCnt; // �Խñ�
        }

        if ( gubun == 'category' ) {
            getObject('category_insert_total'       ).innerHTML = curCnt; // ī�װ�
        }

        if ( gubun == 'comment' ) {
            getObject('comment_insert_total'        ).innerHTML = curCnt; // �ǰ߱�
        }

        if ( gubun == 'grant' ) {
            getObject('grant_insert_total'          ).innerHTML = curCnt; // ����
        }

        if ( gubun == 'member' ) {
            getObject('member_insert_total'         ).innerHTML = curCnt; // ȸ��
        }

        if ( gubun == 'member_kind' ) {
            getObject('member_kind_insert_total'    ).innerHTML = curCnt; // ȸ�� ����
        }

        getObject('all_kind_insert_total').innerHTML = totProgCnt   ; // ��ü

//      dataPannelDocument.write ( proVal +'<BR>');
//      send_message.innerHTML   = '�� <span class="text_04">' + saveArea.totCnt + '</span>���� <span class="text_04">' + ( saveArea.curIdx ) + '</span>�� �� ȸ���� �߼����Դϴ�.';
}
    jui.ready(function(ui, uix, _) {
    	$("#btnConfirm").click(function(e){
    	});

    	$("#cal1").click(function(e){
    		$("#datepicker1").show();
    		var position = $(this).position();
    		$("#datepicker1").css("top",(position.top)+$(this).height()+3);
    		$("#datepicker1").css("left",(position.left));
    	});
    });
//-->
</SCRIPT>
<!--

	      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
			<colgroup>
			<col width="100">
			<col width="">
			<col width="80">
			</colgroup>
	        <tr>
	          <td align="right" bgcolor="efefef"><strong>������Ʈ����&nbsp;</strong></td>
	          <td bgcolor="fafafa"><font color="990000"><span id='msg'>������� �ֽ�ȭ�մϴ�.
	          </span></font></td>
	          <td bgcolor="fafafa" align="center">
	          <button class="btn btn-gray" type="button" id="btnConfirm">Ȯ��</button>
	          </td>
	        </tr>
	        <tr>
	          <td align="right" bgcolor="efefef" colspan="3">
	          <textarea style="width:100%;height:100px;overflow:scroll;overflow-x:hidden;"><?=$patch_msg?></textarea>
	          </td>
	        </tr>
            <tr>
              <td align="right" bgcolor="efefef"><strong>�����Ȳ&nbsp;</strong></td>
              <td bgcolor="#fafafa" colspan="2" valign="middle" style="vertical-align: middle;padding-top: 20px">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="100%">
                      <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="828282">
                        <tr>
                          <td height="20" id='progress' width="" bgcolor="990000"></td>
                          <td bgcolor="#FFFFFF" width='1'></td>
                        </tr>
                      </table></td>
                    <td width="10">&nbsp;</td>
                    <td class="text_01"><font color="990000">
    <span id='percent'></span>
                    </font></td>
                  </tr>
                </table>
			 </td>
            </tr>
	      </table>
 -->
	<?
	}
	?>
<?
}
?>
<!--       <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01"> -->
<!-- 		<colgroup> -->
<!-- 		<col width="100"> -->
<!-- 		</colgroup>       -->
<!--         <tr> -->
<!--           <td align="right" bgcolor="efefef"><strong>������Ʈ ����&nbsp;</strong></td> -->
<!--           <td bgcolor="fafafa"><font color="990000"><span id='msg'>����ǥ�ø� ��Ÿ���� �κ��Դϴ�.</span></font></td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td align="right" bgcolor="efefef" colspan="2"> -->
<!--           </td> -->
<!--         </tr> -->
<!--         <tr> -->
<!--           <td align="right" bgcolor="efefef"><strong>�����Ȳ&nbsp;</strong></td> -->
<!--           <td bgcolor="fafafa"> -->
<!--             <table width="100%" border="0" cellspacing="0" cellpadding="0"> -->
<!--               <tr> -->
<!--                 <td width="100%"> -->
<!--                   <table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="828282"> -->
<!--                     <tr> -->
<!--                       <td height="20" id='progress' width="" bgcolor="990000"></td> -->
<!--                       <td bgcolor="#FFFFFF" width='1'></td> -->
<!--                     </tr> -->
<!--                   </table></td> -->
<!--                 <td width="10">&nbsp;</td> -->
<!--                 <td class="text_01"><font color="990000"> -->
<!-- <span id='percent'></span> -->
<!--                 </font></td> -->
<!--               </tr> -->
<!--             </table> -->
<!--             </td> -->
<!--         </tr> -->
<!--       </table>     -->
<br/>
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
                                  <td>���: ������</td>
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
<B>��   ��: ������� | ��   ��: 070-037500-02-015 | ������: ������</B>
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
