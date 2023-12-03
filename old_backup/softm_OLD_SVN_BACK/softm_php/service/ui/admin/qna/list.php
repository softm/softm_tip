                <p class="list_tit">질문 및 답변 - 조회</p>
				<div class="list_search clear">
<form id="sForm" name="sForm" method="POST" onsubmit="return 조회(1);" style="display: inline">
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_qna_type';
$creategory_setup['title'           ] = '-문의유형-'  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " name='s_qna_type' id='s_qna_type' class='required trim focus alert' message='문의유형을 선택해주세요.' style='width:100px'"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_QNA_TYPE;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>&nbsp;
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 's_qna_state';
$creategory_setup['title'           ] = '-답변상태-'  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " name='s_qna_state' id='s_qna_state' class='required trim focus alert' message='답변상태를 선택해주세요.' style='width:100px'"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_QNA_STATE;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>&nbsp;
<!-- <select name="s_gubun" id="s_gubun" style="width:80px">
    <option value=""        >-선택-</option>
    <option value="title"   >제목</option>
    <option value="content" >내용</option>
</select> -->
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
