<form id="sForm" name="sForm" method="POST" onsubmit="return fGetList(1);">

	<table border="0" cellpadding="0" cellspacing="0" id="admin"
		width="100%">
		<tr>
			<td width="150" class="bt" id="t1">업종분야</td>
			<td class="bt br2">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_biz_field';
$creategory_setup['title'           ] = '선택'  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " id=s_biz_field"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_BIZ_FIELD;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>			
			</td>
			<td width="150" class="bt" id="t1">업종분류</td>
			<td class="bt" align="left">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_biz_classified';
$creategory_setup['title'           ] = '선택'  ;
$creategory_setup['script'          ] = ""  ;
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
			<td width="150" id="t1">처리상황</td>
			<td class="bt" align="left">
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
			<td width="150" id="t1">키워드</td>
			<td align="left"> 
		<input type="text" style="width:100px" id="s_keyword" name="s_keyword">
		<input type="image" align="absmiddle" src="/images/btn_search2.jpg" style="vertical-align:middle">	
        <a href="#" onclick="return fileDownload('xls')"> <img src="/images/blt_xls.gif" align="absmiddle"/></a> <a href="#" onclick="return fileDownload('doc')"> <img src="/images/blt_hwp.gif" align="absmiddle"/></a>	
				</td>
		</tr>
	</table>
</form>
<BR>
<table border="0" cellspacing="0" cellpadding="0" width="700"  id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot></tfoot>
</table>
