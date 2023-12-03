<form id="sForm" name="sForm" method="POST" onsubmit="return fGetList(1);">
<table cellspacing="0" cellpadding="0" border="0" width="700" id="admin">
    <tbody>
    <tr>
        <td width="150" id="t1" class="bt">업종분야</td>
        <td class="bt br2">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_biz_field';
$creategory_setup['title'           ] = '선택'  ;
$creategory_setup['script'          ] = " onchange='fGetList(1)'"  ;
$creategory_setup['properties'      ] = " id=s_biz_field"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_BIZ_FIELD;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>
        </td>
        <td width="150" id="t1" class="bt">업종분류</td>
        <td width="25%" align="left" class="bt">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_biz_classified';
$creategory_setup['title'           ] = '선택'  ;
$creategory_setup['script'          ] = " onchange='fGetList(1)'"  ;
$creategory_setup['properties'      ] = " id=s_biz_classified"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_BIZ_CLASSIFIED;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>
        </td>
    </tr>
    <tr>
    <td id="t1">비지니스형태</td>
    <td colspan="3" class="bt">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_hope_biz_type';
$creategory_setup['title'           ] = '선택'  ;
$creategory_setup['script'          ] = " onclick='fGetList(1)'"  ;
$creategory_setup['properties'      ] = ""  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "<input type='radio' name='s_hope_biz_type' value='' onclick='fGetList(1)' checked>전체";
$selectInfo = Base::$CODE_BIZ_TYPE;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('RADIO',$selectInfo);
?>
<BR>    
    </td>
    </tr>
    <tr>
    <td id="t1">키워드</td>
    <td colspan="3">
        <input type="text" style="width:250px" id="s_company_nm" name="s_company_nm">
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
