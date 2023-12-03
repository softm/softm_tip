<form id="sForm" name="sForm" method="POST" onsubmit="return fGetList(1);">
<table cellspacing="0" cellpadding="0" border="0" width="700" id="admin">
    <tbody>
    <tr>
        <td width="150" id="t1" class="bt">구분</td>
        <td width="150" class="bt br2">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_company_type';
$creategory_setup['title'           ] = '선택'  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " "  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_COMPANY_TYPE;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>
        </td>
        <td width="150" id="t1" class="bt">업종구분</td>
        <td width="150" align="left" class="bt">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_biz_field';
$creategory_setup['title'           ] = '선택'  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " "  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_BIZ_FIELD;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>
        </td>
        <td width="150" id="t1" class="bt">업체명</td>
        <td align="left" class="bt">
		<input type="text" style="width:150px" id="s_company_nm_kr" name="s_company_nm_kr">
        </td>
        <td width="150" id="t1" class="bt">
<input type="image" align="absmiddle" src="/images/btn_search2.jpg" style="vertical-align:middle">        
        </td>        
        <!-- <td width="" align="left" class="bt" rowspan=2>
		<button type=button id=btn_xls_down>XLS</button>
		<button type=button id=btn_doc_down>DOC</button>
        </td>  -->       
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
