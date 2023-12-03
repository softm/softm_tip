
                <p class="list_tit">공지사항 - 검색</p>
				<div class="list_search clear">
<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);" style="display: inline">
<span id=area_cat_proc_cd>
<select name="s_gubun" id="s_gubun" style="width:130px">
	<option value=""        >-선택-</option>
	<option value="title"   >제목</option>
	<option value="content" >내용</option>
</select>
</span>
                        <input type="text" name="s_search" id="s_search"/>
                        <a href="#" onclick="return 조회(1);">검색</a>
</form>
					</div>
				</div>

				<div class="data_tb01">
<table border="0" cellspacing="0" cellpadding="0" id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot style="height:50px"></tfoot>
</table>
</div>
<div class="list_search clear" style="border:1px;text-align:right">
      <a href=# onclick="return 입력();">입력</a>
</div>
