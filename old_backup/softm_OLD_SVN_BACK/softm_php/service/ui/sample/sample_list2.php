<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
    <td width="100%" valign="top">

<?print "<form id='sForm' name='sForm' method='POST' onsubmit='return fGetList(1);'>";?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="formbody">
        <colgroup>
            <col width='30' />
            <col width='100'/>
            <col width='100'/>
            <col width='100'/>
            <col width=''   />
        </colgroup>
        <thead>
            <tr>
            <th colspan="9"><?php print PROGRAM_TITLE?></th>
            </tr>
            <tr>
            <td><?php print "검색"; ?></td>
            <td>
<?
    $creategory_setup['select'          ] = '';
    $creategory_setup['prop_name'       ] = 's_user_level';
    $creategory_setup['title'           ] = '- All -'  ;
    $creategory_setup['script'          ] = " id=s_user_level onchange='fGetList(1);'"  ; // 스크립트
    $selectInfo = Base::$CODE_USER_LEVEL;
    $selectInfo['setup'] = $creategory_setup;
    print Util::createGory ('SELECT',$selectInfo);
?>

            </td>
            <td>
        <INPUT TYPE="text" id="s_user_id" name="s_user_id" style='width:90px'>
            </td>
            <td style="text-align:right">
            <input type=button onclick='fGetList(1);' value='SEARCH' class='button1'>
            </td>
            <td>
<?php 
print Util::listBoxElement ("SELECT","skin_id", 0, 15, 'onchange="fChgSkin(this.value)"',1,'','-스킨-');
?>            
            <input type=button onclick='fExec();' value='저장' class='button1'>
            <input type=button onclick='fNewRow();' value='New' class='button1'>
            </td>
            <td><FONT SIZE="" COLOR="red"><B><!-- 해외영업팀에서는 사용하시마세요. --></B></FONT>&nbsp;</td>
            </tr>
        </thead>
    </table>
</form>
    </td>
    </tr>
    <tr>
    <td colspan="2"><hr /></td>
    </tr>
</table>

<span id='area_list'>
<table border="0" cellspacing="0" cellpadding="0" class="formbodyline" style='table-layout:fixed;width:100%' id='tbl_list'>
<thead></thead>
<!-- <tbody id='data_list' style='overflow:hidden;overflow-y:auto;height:400px;width:1200px'></tbody> -->
<tbody id='data_list'></tbody>
<tfoot></tfoot>
</table>
</span>
<span id='area_write'></span>