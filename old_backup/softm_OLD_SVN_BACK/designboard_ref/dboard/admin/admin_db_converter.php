<?
$baseDir = '../';
include ( "../common/lib.inc"          ); // ���� ���̺귯��
include ( "../common/message.inc"      ); // ���� ������ ó��

if ( $config ) {
    $memInfor = getMemInfor(); // ���ǿ� ����Ǿ��ִ� ȸ�������� ����
    $libDir = "lib/" . $sysInfor['driver'] . '/';
    if ( $memInfor['admin_yn'] == "Y" ) {
    head("�����κ��� DB ��ȯ ��","init();");          // Header ���
    _css($baseDir);
	include $baseDir.'common/js/common_js.php'; // ���� javascript
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
    var st_fRead     = '0' ; // 0 : ���, 1 : �б� ����, 2 : �б� ����(����), 3 : �б� ����(����), 4 : ��ȯ ����, 5 : ��ȯ ����, 6 : ��ȯ ����
    var msgObj       = null; // �޼��� ����� ���� ��ü
    var fInforObj    = null; // ���� ����
    var backFileInfor= null; // ��� ���� ���� ��� ����

    var curKindData  = null; // ������ ������

    var dataPannelObj      = null; // dataPannel IFRAME   OBJECT
    var dataPannelWindow   = null; // dataPannel WINDOW   OBJECT
    var dataPannelDocument = null; // dataPannel DOCUMENT OBJECT

    var dataExecObj        = null; // dataExec   IFRAME   OBJECT
    var dataExecWindow     = null; // dataExec   WINDOW   OBJECT
    var dataExecDocument   = null; // dataExec   DOCUMENT OBJECT
    var total              = 0;
    var member_tot         = 0;
    var member_kind_tot    = 0;

    var board_tot          = 0;
    var category_tot       = 0;
    var comment_tot        = 0;
    var grant_tot          = 0;
    var point_tot          = 0;
    var bbs_id             = null;
    var progressObj = null;
    var percentObj  = null;

    function readTempage(gubun) {
        document.dataReadyForm.target = 'dataPannel';
        document.dataReadyForm.submit();
        readStart();
    }

    function readEnd() {
        curKindData  = document.dataReadyForm.kind_data.value            ; // ������ ������
        document.dataConvertForm.kind_data.value  = curKindData  ;
        if ( st_fRead == '2' ) { // �б� ����
            if ( curKindData == 'member' ) {
                member_tot          = getObject ( 'member_tot'       ,'dataPannel').innerHTML;
                member_kind_tot     = getObject ( 'member_kind_tot'  ,'dataPannel').innerHTML;
                total = parseInt(member_tot) + parseInt(member_kind_tot);

                getObject('member_total'                ).innerHTML = member_tot        ; // ȸ�� �Ѽ�
                getObject('member_insert_total'         ).innerHTML = member_tot        ; // ȸ��

                getObject('member_kind_total'           ).innerHTML = member_kind_tot   ; // ȸ�� ���� �Ѽ�
                getObject('member_kind_insert_total'    ).innerHTML = member_kind_tot   ; // ȸ�� ����
                getObject('board_total'                 ).innerHTML = 0                 ; // �Խñ� �Ѽ�
                getObject('board_insert_total'          ).innerHTML = 0                 ; // �Խñ�

                getObject('category_total'              ).innerHTML = 0                 ; // ī�װ� �Ѽ�
                getObject('category_insert_total'       ).innerHTML = 0                 ; // ī�װ�

                getObject('comment_total'               ).innerHTML = 0                 ; // �ǰ߱� �Ѽ�
                getObject('comment_insert_total'        ).innerHTML = 0                 ; // �ǰ߱�

                getObject('grant_total'                 ).innerHTML = 0                 ; // ���� �Ѽ�
                getObject('grant_insert_total'          ).innerHTML = 0                 ; // ����

            } else if ( curKindData == 'board' ) {
                board_tot          = parseInt( getObject ( 'board_tot'   ,'dataPannel').innerHTML );
                category_tot       = parseInt( getObject ( 'category_tot','dataPannel').innerHTML );
                comment_tot        = parseInt( getObject ( 'comment_tot' ,'dataPannel').innerHTML );
                grant_tot          = parseInt( getObject ( 'grant_tot'   ,'dataPannel').innerHTML );
                point_tot          = parseInt( getObject ( 'point_tot'   ,'dataPannel').innerHTML );
                bbs_id             =           getObject ( 'bbs_id'      ,'dataPannel').innerHTML  ;
                total = board_tot + category_tot + comment_tot + grant_tot + point_tot;

                getObject('board_total'                 ).innerHTML = board_tot     ; // �Խñ� �Ѽ�
                getObject('board_insert_total'          ).innerHTML = 0             ; // �Խñ�

                getObject('category_total'              ).innerHTML = category_tot  ; // ī�װ� �Ѽ�
                getObject('category_insert_total'       ).innerHTML = 0             ; // ī�װ�

                getObject('comment_total'               ).innerHTML = comment_tot   ; // �ǰ߱� �Ѽ�
                getObject('comment_insert_total'        ).innerHTML = 0             ; // �ǰ߱�

                getObject('grant_total'                 ).innerHTML = grant_tot + point_tot; // ���� �Ѽ�
                getObject('grant_insert_total'          ).innerHTML = 0                    ; // ����

                getObject('member_total'                ).innerHTML = 0             ; // ȸ�� �Ѽ�
                getObject('member_insert_total'         ).innerHTML = 0             ; // ȸ��

                getObject('member_kind_total'           ).innerHTML = 0             ; // ȸ�� ���� �Ѽ�
                getObject('member_kind_insert_total'    ).innerHTML = 0             ; // ȸ�� ����

            }

            getObject('all_kind_total'       ).innerHTML = total        ; // ��ü �ڷ��
            getObject('all_kind_insert_total').innerHTML = 0            ; // ��ü

            objectShow( 'convert_bt' );
            fInforObj           = getObject ( 'convert_file','dataPannel');
            backFileInfor.innerHTML = '(<font color="990000"><strong> ��� ���ϸ� : ' + fInforObj.innerHTML + '.sql</strong></font> )';
        } else if ( st_fRead == '3' ) { // // �б� ����
            clearInfor();
        }
    }

    function readStart() {
        msgObj.innerHTML = '��ø� ��ٷ� �ּ���.';
        st_fRead = '1';
    }

    function initMsg(kindData) {
//      alert ( curKindData );
        if ( typeof(kindData)!='undefined' && kindData == '' ) {
            alert ( '������ ������ �������ּ���.' );
            document.dataReadyForm.kind_data.focus();
            return false;
        }
        clearInfor();
    }

    function clearInfor() {
        fInforObj           = null;
        member_tot          = 0;
        member_kind_tot     = 0;
        board_tot           = 0;
        category_tot        = 0;
        comment_tot         = 0;
        grant_tot           = 0;
        objectHide( 'convert_bt' );
        progressObj.width       ='';
        percentObj.innerHTML    ='';
        backFileInfor.innerHTML ='';
        st_fRead = '0';
    }

    function init() {
        objectPosition('board_statistics' , 'absolute' );
        objectPosition('member_statistics', 'absolute' );
        objectHide('board_statistics' );
        objectHide('member_statistics');

        msgObj      = getObject('msg'     ); // �޽��� ��ü
        progressObj = getObject('progress');
        percentObj  = getObject('percent' );
        backFileInfor= getObject('file_infor' );

        initMsg();
        objectHide( 'convert_bt' ); // ��ȯ ��ư

        dataPannelObj      = getObject("dataPannel")    ;
        dataPannelWindow   = dataPannelObj.contentWindow;
        dataPannelDocument = dataPannelWindow.document  ;

        dataExecObj        = getObject("dataExec"  )    ;
        dataExecWindow     = dataExecObj.contentWindow  ;
        dataExecDocument   = dataExecWindow.document    ;
    }

    function kindChange(val) {
        clearInfor();
        curKindData  = document.dataReadyForm.kind_data.value            ; // ������ ������
        if ( curKindData == 'board' ) {
            msgObj.innerHTML    = '������ ���� �Խ��� ����';
            objectShow('board_statistics' );
            objectPosition('board_statistics' , 'relative' );
            objectHide('member_statistics');
            objectPosition('member_statistics' , 'absolute' );
        } else if ( curKindData == 'member' ) {
            msgObj.innerHTML    = '������ ���� ȸ�� ����';
            objectHide('board_statistics' );
            objectPosition('board_statistics' , 'absolute' );
            objectShow('member_statistics');
            objectPosition('member_statistics' , 'relative' );
        } else {
            msgObj.innerHTML    = '����ǥ�ø� ��Ÿ���� �κ��Դϴ�.';
            objectHide('board_statistics' );
            objectHide('member_statistics');
        }

        clearInfor();
    }

    function dataConverStart() {
        if ( fInforObj != null && fInforObj.innerText != '' && st_fRead != '4' ) {
            document.dataConvertForm.c_file.value     = fInforObj.innerText;
            if ( curKindData == 'member' ) {
                document.dataConvertForm.member_order.value      = getObject ( 'member_order'       ,'dataPannel').innerHTML;
                document.dataConvertForm.member_kind_order.value = getObject ( 'member_kind_order'  ,'dataPannel').innerHTML;
            } else if ( curKindData == 'board' ) {
                document.dataConvertForm.infor_order.value      = getObject ( 'infor_order'   ,'dataPannel').innerHTML;
                document.dataConvertForm.board_order.value      = getObject ( 'board_order'   ,'dataPannel').innerHTML;
                document.dataConvertForm.category_order.value   = getObject ( 'category_order','dataPannel').innerHTML;
                document.dataConvertForm.comment_order.value    = getObject ( 'comment_order' ,'dataPannel').innerHTML;
                document.dataConvertForm.grant_order.value      = getObject ( 'grant_order'   ,'dataPannel').innerHTML;
                document.dataConvertForm.point_order.value      = getObject ( 'point_order'   ,'dataPannel').innerHTML;
                document.dataConvertForm.bbs_id.value           = bbs_id;
            }
            document.dataConvertForm.submit();
            msgObj.innerHTML = '��ȯ ����....';
            st_fRead = '4';
        }
    }

    function dataConverEnd() {
        if ( st_fRead == '4' ) {
            msgObj.innerHTML = '��ȯ ����....';
            objectHide( 'convert_bt' );
            total = 0;
            st_fRead = '5';
        } else if ( st_fRead == '6' ) { // ��ȯ ����
        }
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

//          dataPannelDocument.write ( proVal +'<BR>');
//          send_message.innerHTML   = '�� <span class="text_04">' + saveArea.totCnt + '</span>���� <span class="text_04">' + ( saveArea.curIdx ) + '</span>�� �� ȸ���� �߼����Դϴ�.';
    }

function objectShow( id, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) { 
		obj.style.visibility="visible"
	}
/*        obj.style.zIndex=0;     Object���� �⺻���� zIndex ���� 0 �Դϴ�. */
}

function objectHide( id, tier ) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) { 
		obj.style.visibility="hidden"
	}
}

/* sytle�� Position ���� �����մϴ�.
   static , relative, absolute*/
function objectPosition(id,position, tier) {
	var obj = null;
	if ( typeof(id) == 'object' ) {
		obj = id;
	} else {
		obj = getObject(id, tier);
	}
	if ( obj != null && typeof(obj) == 'object' ) { 
		obj.style.position=position;
	}
}
//-->
</SCRIPT>
<table width="100%" height="100%" border="0" cellpadding="20" cellspacing="0" class="text_01">
  <tr>
    <td valign="top"><strong>�����κ��� ����ڷ� ����</strong><br>
      <br>

      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
<form name='dataReadyForm' method='post' action='admin_db_converter_data.php' enctype="multipart/form-data">
    <input type='hidden' name='kind_board' value='dboard'>
        <tr>
          <td width="100" align="right" bgcolor="efefef"><strong>����Ÿ����&nbsp;</strong></td>
          <td bgcolor="fafafa">
            <SELECT name="kind_data" class="listbox_01" onChange='kindChange();'>
                <option selected        >�����������</option>
                <option value='board'   >�Խ��ǹ��  </option>
                <option value='member'  >ȸ�����    </option>
            </SELECT>
          </td>
        </tr>
        <tr>
          <td align="right" bgcolor="efefef"><strong>���ϼ���</strong>&nbsp;</td>
          <td bgcolor="fafafa">
            <input type='file'  name='data_file'  onChange="readTempage('header');" onClick='return initMsg(document.dataReadyForm.kind_data.value);' class="textarea_01">
            &nbsp;<button id='convert_bt' style='visibility:hidden' class="submit_01" onClick='dataConverStart();'>��ȯ ����</button>
          </td>
        </tr>
</form>
        <tr>
          <td align="right" bgcolor="efefef"><strong>����ǥ��&nbsp;</strong></td>
          <td bgcolor="fafafa"><font color="990000"><span id='msg'>����ǥ�ø� ��Ÿ���� �κ��Դϴ�.</span></font></td>
        </tr>
        <tr>
          <td align="right" bgcolor="efefef"><strong>�����Ȳ&nbsp;</strong></td>
          <td bgcolor="fafafa">
            <table width="600" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="500">
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
      <br>
      <strong><font color="990000"><strong><br>
      </strong></font>����ڷ� <font color="990000"></font> �󼼺��� <span id='file_infor'></span><br>
      </strong><br>
      <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
        <tr>
          <td width="100" align="right" bgcolor="efefef">
<p><strong>����Ÿ���&nbsp;</strong></p></td>
          <td bgcolor="fafafa"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="50%" valign="top">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01">
                    <tr align="center" bgcolor="eeeeee">
                      <td height="30" colspan="2"><strong> ��ü��Ȳ ���</strong></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td width="100" bgcolor="f7f7f7">������ �ڷ� </td>
                      <td><font color="990000"><span id='all_kind_total'               >0</span></font>�� (��)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7"> ������ �ڷ�</td>
                      <td><font color="990000"><span id='all_kind_insert_total'        >0</span></font>�� (��)</td>
                    </tr>
                  </table></td>
                <td>&nbsp;&nbsp;</td>
                <td width="50%" valign="top">
                  <table id='board_statistics' width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01" style='visibility:hidden;position:absolute'>
                    <tr align="center" bgcolor="#FFFFFF">
                      <td height="30" colspan="4" bgcolor="eeeeee"><strong>�Խ��� ��� �κ���Ȳ ���</strong></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td width="100" bgcolor="f7f7f7">������ �Խñ�</td>
                      <td><font color="990000"><span id='board_total'                  >0</span></font>�� (��)</td>
                      <td bgcolor="f7f7f7">������ �Խñ� </td>
                      <td><font color="990000"><span id='board_insert_total'           >0</span></font>�� (��)</td>
                    </tr>

                    <tr bgcolor="#FFFFFF">
                      <td width="100" bgcolor="f7f7f7">������ ī�װ�</td>
                      <td><font color="990000"><span id='category_total'               >0</span></font>�� (��)</td>
                      <td bgcolor="f7f7f7">������ ī�װ�</td>
                      <td><font color="990000"><span id='category_insert_total'        >0</span></font>�� (��)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">������ �ǰ߱�</td>
                      <td><font color="990000"><span id='comment_total'                >0</span></font>�� (��)</td>
                      <td bgcolor="f7f7f7">������ �ǰ߱�</td>
                      <td><font color="990000"><span id='comment_insert_total'         >0</span></font>�� (��)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">������ ����</td>
                      <td><font color="990000"><span id='grant_total'                  >0</span></font>�� (��)</td>
                      <td bgcolor="f7f7f7">������ ����</td>
                      <td><font color="990000"><span id='grant_insert_total'           >0</span></font>�� (��)</td>
                    </tr>
                  </table>
                  <table id='member_statistics' width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="cccccc" class="text_01" style='visibility:hidden;position:absolute'>
                    <tr align="center" bgcolor="#FFFFFF">
                      <td height="30" colspan="2" bgcolor="eeeeee"><strong>ȸ�� ��� �κ���Ȳ ���</strong></td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td width="100" bgcolor="f7f7f7">������ ȸ�� �Ѽ� </td>
                      <td><font color="990000"><span id='member_total'                 >0</span></font>�� (��)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">������ ȸ�� </td>
                      <td><font color="990000"><span id='member_insert_total'          >0</span></font>�� (��)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">������ ȸ������ �Ѽ� </td>
                      <td><font color="990000"><span id='member_kind_total'            >0</span></font>�� (��)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td bgcolor="f7f7f7">������ ȸ������</td>
                      <td><font color="990000"><span id='member_kind_insert_total'     >0</span></font>�� (��)</td>
                    </tr>
                  </table>
                 </td>
              </tr>
            </table>
            </td>
        </tr>
      </table>
      </td>
<iframe marginHeight='0' marginWidth='0' frameborder='0' width='0%' height='0%' name='dataPannel' id='dataPannel' scrolling='yes' src='admin_db_converter_data.php'></iframe><BR>
<iframe marginHeight='0' marginWidth='0' frameborder='0' width='0%' height='0%' name='dataExec'   id='dataExec' scrolling='yes' src='<?=$libDir?>admin_db_converter_exec.php'></iframe>
<form name='dataConvertForm' method='post' target='dataExec' action='<?=$libDir?>admin_db_converter_exec.php'>
    <input type='hidden' name='kind_board'        value=''>
    <input type='hidden' name='kind_data'         value=''>
    <input type='hidden' name='c_file'            value=''>
    <input type='hidden' name='member_order'      value=''>
    <input type='hidden' name='member_kind_order' value=''>
    <input type='hidden' name='board_order'       value=''>
    <input type='hidden' name='category_order'    value=''>
    <input type='hidden' name='comment_order'     value=''>
    <input type='hidden' name='grant_order'       value=''>
    <input type='hidden' name='point_order'       value=''>
    <input type='hidden' name='infor_order'       value=''>
    <input type='hidden' name='bbs_id'            value=''>
</form>
  </tr>
</table>
<?
        footer(); // Footer ���
    }
} // if END
else {
    head();          // Header ���
    _css($baseDir);
    Message ("U", "0002", "MOVE:setup.php:��ġ ..");
} // else END
?>