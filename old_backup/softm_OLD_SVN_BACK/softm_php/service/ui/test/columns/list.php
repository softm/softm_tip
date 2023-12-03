<table border="0" cellspacing="0" cellpadding="0" width="700"  id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot></tfoot>
</table>

<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);">
<div id="list_search">
  <table width="700" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="140" align="center">
      <a href=# onclick="return 입력();">입력</a>
      </td>
      <td height="40" align="center" style="vertical-align:middle"><select id="s_gubun"><option value="USER_EMAIL">아이디</option><option value="USER_NAME">회원명</option></select> <input type="text" name="s_search" id="s_search" /> <input type="image" src="images/btn_search.jpg" width="41" height="18" border="0" titie="검색" style="vertical-align:middle" align=absmiddle></td>
      <td width="140" align="center">
      <img src="images/btn_excel.jpg" width="85" height="18" title="검색결과저장" style="cursor:hand" onclick="파일다운로드();"/>
      </td>
    </tr>
  </table>
</div>
</form>