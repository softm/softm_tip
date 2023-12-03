<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->
<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->
<!-- <input type='submit' value='전송'><BR> -->
<!-- <input name='test1' type='text' value='test1'><BR> -->
<!-- <input type='file' name='test_file' id='test_file' s1tyle='width:450px'/><BR> -->
				<p class="list_tit">질문 및 답변 - 수정</p>
				<div class="view_tb01 view_tb02">
					<table cellpadding="0" cellspacing="0" summary="">
						<caption>질문과답변</caption>
						<colgroup>
							<col width="10%" />
							<col width="10%" />
							<col width="*" />
						</colgroup>
						<tbody>
						<tr>
							<th scope="row" rowspan="3">문의</th>
							<th scope="row">문의유형</th>
							<td>
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 'qna_type';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " name='qna_type' id='qna_type' class='required trim focus alert' message='문의유형을 선택해주세요.' style='width:100px'"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_QNA_TYPE;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>&nbsp;
                            </td>
                        </tr>
                        <tr>
							<th scope="row">질문자</th>
							<td><input type='text' name='user_name' size=40 value='<?=USER_NAME?>' style='width:100px' class='required trim focus alert' maxlength=40 minlength=0 message='이름를 입력해주세요.' /></td>
						</tr>
						<tr>
							<th scope="row"><label for="q_q">내용</label></th>
							<td>
								<textarea rows="" cols="" id='q_content'  name='q_content' value='' class='required trim focus alert' message='문의내용를 입력해주세요.'></textarea>
							</td>
						</tr>
						<tr>
							<th scope="row" colspan="2"><label for="q_a">답변</label></th>
							<td>
								<textarea rows="" cols="" id='a_content' name='a_content' value='' class='trim focus alert' message='답변내용를 입력해주세요.'></textarea>
							</td>
						</tr>
						</tbody>
					</table>
				</div>

				<div class="btn_area_n clear">
					<a href="#" title="목록보기" onclick="return 목록();" class="fl">목록</a>
					<a href="#" title="목록보기" onclick="return 실행();" class="fl">저장</a>
					<a href="#" title="삭제하기" onclick="return 삭제();" id="btnDel" style="display:none">삭제</a>
				</div>
<input type='hidden' name='qna_no' size=20 value=''/>
</form>