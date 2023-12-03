<form id="sForm" name="sForm" method="POST" onsubmit="return fGetList(1);">
<table cellspacing="0" cellpadding="0" border="0" width="700" id="admin">
    <tbody>
    <tr>
        <td width="150" id="t1" class="bt">처리상황</td>
        <td class="bt br2">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_state';
$creategory_setup['title'           ] = '선택'  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " id=s_state"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_STATE_BC;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>
        </td>
        <td width="150" id="t1" class="bt">담당자</td>
        <td width="25%" align="left" class="bt">
		<input type="text" style="width:250px" id="s_woker_nm" name="s_woker_nm">
        </td>
    </tr>
    <tr>
    <td id="t1">등록일</td>
    <td colspan="3">
<?php
	$frmDate = Util::getTodayString();
	$frmDate = date("Y-m-") . "01 00:00:00";
	$toDate  = Util::getDateAdd ($frmDate, 'MONTH', 1 );
	$frmDate = substr($frmDate, 0, strlen($frmDate)-9);
	$toDate  = substr($toDate, 0, strlen($toDate)-9);
?>
    <input type='text' name='s_frm_reg_date' id='s_frm_reg_date' value='<?=$frmDate?>' readonly  style='width:72px' maxlength= />
    &nbsp;<img src="/images/blt_calendar.gif" onclick='displayCalendar(document.sForm.s_frm_reg_date,"yyyy-mm-dd",this)'>
    ~
    <input type='text' name='s_to_reg_date' id='s_to_reg_date' value='<?=$toDate?>' readonly  style='width:72px' maxlength= />
    &nbsp;<img src="/images/blt_calendar.gif" onclick='displayCalendar(document.sForm.s_to_reg_date,"yyyy-mm-dd",this)'>
<input type="image" align="absmiddle" src="/images/btn_search2.jpg" style="vertical-align:middle">
    </td>
    </tr>
    </tbody>
</table>
</form>
<BR>
<table border="0" cellspacing="0" cellpadding="0" width="700"  id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot></tfoot>
</table>
