<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);">
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="700">
  <tr>
         <td width="150" class="bt" id="t1">분야</td>
         <td colspan="3"  class="bt br2" ><span class="bt">
<span id=area_tech_l_cat><select name="s_l_cat"><option>1차카테고리</option></select></span>
<span id=area_tech_m_cat><select name="s_m_cat"><option>2차카테고리</option></select></span>
<span id=area_tech_s_cat><select name="s_s_cat"><option>3차카테고리</option></select></span>
         </span></td>
    </tr>
  <tr>
    <td id="t1">기술명</td>
    <td colspan="3"  class="bt br2" >
      <input type="text" name="s_tech_nm" style="width:300px"/>
    </span></td>
  </tr>
      <tr height='30'>
         <td width="150" id="t1">특허번호</td>
         <td  class="br2" ><input type="text" name="s_license_number" style="width:100px"/></td>
        <td width="150" id="t1">기관명</td>
        <td width="25%" align="left" ><input type="text" name="s_organ" style="width:100px"/></td>
      </tr>
      <tr height='30'>
        <td width="150" id="t1">키워드</td>
        <td colspan="3" align="left"><input type="text" name="s_keyword" style="width:100px"/> <input type="image" src="/images/btn_search2.jpg" align="absmiddle"/>
        <a href="#" onclick="return fileDownload('xls')"> <img src="/images/blt_xls.gif" align="absmiddle"/></a> <a href="#" onclick="return fileDownload('doc')"> <img src="images/blt_hwp.gif" align="absmiddle"/></a>
        
        </td>
      </tr>
    </table>
</td>
  </tr>
</table><br /><br />
</form>

<table border="0" cellspacing="0" cellpadding="0" width="700"  id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot></tfoot>
</table>

<div id="list_search" style="padding-right:10px">
  <table width="700" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="40" align="right">
      <!-- <img src="/images/btn_excel.jpg" width="85" height="18" title="검색결과저장" style="cursor:hand" onclick="return 파일다운로드();" /> -->
      <a href=# onclick="return 입력();"><img src="/images/config/button_add.gif"/></a>      
      </td>
    </tr>
  </table>
</div>
