<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);">
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="700">
  <tr>
         <td width="150" class="bt" id="t1">기술분야</td>
         <td class="bt br2" ><span class="bt">
<span id=area_tech_l_cat><select name="s_l_cat"><option>1차카테고리</option></select></span>
<span id=area_tech_m_cat><select name="s_m_cat"><option>2차카테고리</option></select></span>
<span id=area_tech_s_cat><select name="s_s_cat"><option>3차카테고리</option></select></span>
         </span></td>
    </tr>
      <tr height='30'>
        <td width="150" id="t1">기술내용</td>
    <td>
      <input type="text" name="s_tech_content" style="width:300px"/>
    </td>
  </tr>
      <tr height='30'>
        <td width="150" id="t1">키워드</td>
        <td align="left"><input type="text" name="s_keyword" style="width:100px"/> <input type="image" src="/images/btn_search2.jpg" align="absmiddle"/></td>
      </tr>
    </table>
</td>
  </tr>
</table>
</form>
<br>
<table border="0" cellspacing="0" cellpadding="0" width="700"  id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot></tfoot>
</table>
