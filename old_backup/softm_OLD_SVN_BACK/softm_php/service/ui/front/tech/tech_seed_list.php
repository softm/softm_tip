<table border="0" width="700" cellspacing="0" cellpadding="0" align="left">
    <tr>
    <td width="78">
        <a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image4','','/images/tab_01.jpg',1)">
            <img src="/images/tab_01_off.jpg" name="Image4" width="77" height="21" border="0">
        </a>
    </td>
    <td width="138">
        <a href="<?=TECH_URL.'&mode=tech_seed_list'?>" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','/images/tab_02.jpg',1)">
            <img src="/images/tab_02_off.jpg" name="Image5" width="137" height="21" border="0">
        </a>
    </td>
    <td width="636" align="left">
        <a href="/sub.php?contents=submenu03&load=menu03_02_02" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','/images/tab_03.jpg',1)">
            <img src="/images/tab_03_off.jpg" name="Image6" width="78" height="21" border="0">
        </a>
    </td>
    </tr>
 	<tr><td colspan="3"   align="left" bgcolor="c0d7f1" height="2"></td></tr>
</table>

<p style='padding-top:10px'>&nbsp;</p>
<p>
    <img src="/images/img_seed02.jpg" name="Image5" border="0">
</p>

<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);">
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="700">
    <tr>
    <td width="150" class="bt" id="t1">기술분야</td>
    <td colspan="3" class="bt br2">
    <span class="bt">
            <span id=area_tech_l_cat><select name="s_l_cat"><option>1차카테고리</option></select></span>
            <span id=area_tech_m_cat><select name="s_m_cat"><option>2차카테고리</option></select></span>
            <span id=area_tech_s_cat><select name="s_s_cat"><option>3차카테고리</option></select></span>
    </span>
    </td>
    </tr>

    <tr>
    <td id="t1">기술명</td>
    <td colspan="3" class="bt br2">
    <input type="text" name="s_tech_nm" style="width:300px" />
    </td>
    </tr>

    <tr height='30'>
    <td width="150" id="t1">특허번호</td>
    <td class="br2">
        <input type="text" name="s_license_number" style="width:100px" />
    </td>
    <td width="150" id="t1">기관명</td>
    <td width="25%" align="left">
        <input type="text" name="s_organ" style="width:100px" />
    </td>
    </tr>
    <tr height='30'>
    <td width="150" id="t1">키워드</td>
    <td colspan="3" align="left">
        <input type="text" name="s_keyword" style="width:100px" /> <input type="image" src="/images/btn_search2.jpg" align="absmiddle" />
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
