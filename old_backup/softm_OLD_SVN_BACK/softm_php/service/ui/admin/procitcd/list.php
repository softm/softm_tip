                <p class="list_tit">대중소관리 - 공종항목</p>
                <div class="list_search clear">
<form id="aForm" name="aForm" method="POST" onsubmit="return 추가();" style="display: inline">
<span id=area_cat_proc_cd>
<select name="p_proc_cd" id="p_proc_cd" class='required trim focus alert' message='대공정을 선택해주세요.' style="width:150px">
    <option value="">대공종</option>
    <option value="">공통가설</option>
</select>
</span>
                    <input type="text" name="proc_it_nm" id="proc_it_nm"  class='required trim focus alert' maxlength=255 minlength=0 message='공종항목명을 입력해주세요.'/>
                    <a href="#" id="btnReg">추가</a>
</form>
                    <div class="f_r">
<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);" style="display: inline">
                        <input type="text" name="s_search" id="s_search"/>
                        <a href="#" onclick="return 조회(1);">검색</a>
</form>
                    </div>
                </div>

                <div class="data_tb01 pro_list">
<table border="0" cellspacing="0" cellpadding="0" width="700"  id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot style="height:100px"></tfoot>
</table>
<!--
<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);">
<div id="list_search">
  <table width="700" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="140" align="center">
      <a href=# onclick="return 입력();">입력</a>
      </td>
      <td height="40" align="center" style="vertical-align:middle"><select id="s_gubun"><option value="USER_EMAIL">아이디</option><option value="USER_NAME">회원명</option></select> <input type="text" name="s_search" id="s_search" /> <input type="image" src="/service/images/btn_search.jpg" width="41" height="18" border="0" titie="검색" style="vertical-align:middle" align=absmiddle></td>
      <td width="140" align="center">
      <img src="/service/images/btn_excel.jpg" width="85" height="18" title="검색결과저장" style="cursor:hand" onclick="파일다운로드();"/>
      </td>
    </tr>
  </table>
</div>
</form>
 -->
                </div>