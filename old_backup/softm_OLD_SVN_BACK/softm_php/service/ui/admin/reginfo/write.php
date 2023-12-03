<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<input type='hidden' name='p_reg_no'/><BR>
				<p class="list_tit">등록정보 - 상세보기</p>
				<div class="data_tb01">
					<table summary="대공종, 공종항목, 공종항목내역 항목으로 구성된 표입니다.">
						<caption>대공종, 공종항목, 공종항목내역 항목으로 구성된 표</caption>
						<colgroup>
							<col width="20%"/>
							<col width="40%"/>
							<col width="40%"/>
						</colgroup>
						<thead>
							<tr>
								<th scope="col">대공종</th>
								<th scope="col"><label for="add01">공종항목</label></th>
								<th scope="col"><label for="add02">공종항목내역</label></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
<select name="p_proc_cd" id="p_proc_cd" class='required trim focus alert' message='대공정을 선택해주세요.' style="width:130px">
	<option value="">대공종</option>
	<option value="">공통가설</option>
</select>
								</td>
								<td>
<select name="p_proc_it_cd" id="p_proc_it_cd" class='trim focus alert' message='공정항목을 선택해주세요.' style="width:150px">
    <option value="">공종항목</option>
    <option value="">공종항목</option>
    <option value="">가설전기</option>
</select>
<input type='text' name='proc_it_nm'       id='proc_it_nm'       class='trim focus alert' maxlength=255 minlength=0 message='공정항목명울 입력해주세요.' />
								</td>
								<td>
<select name="p_proc_bd_cd" id="p_proc_bd_cd" class='trim focus alert' message='공정항목내역을 선택해주세요.' style="width:200px">
    <option value="">공종항목내역</option>
    <option value="">되메우기</option>
    <option value="">잡석깔기 </option>
</select>
<input type='text' name='proc_bd_nm'       id='proc_bd_nm'       class='trim focus alert' maxlength=255 minlength=0 message='공정항목코드명울 입력해주세요.' />

								</td>
							</tr>
						</tbody>
						<thead>
							<tr>
								<th>
                            공종항목내역 Detail
								</th>
                                <th colspan=2 style="text-align:left;padding-left:10px">
<input type='text' name='proc_dt_nm'       id='proc_dt_nm'       class='required trim focus alert' maxlength=255 minlength=0 message='공정항목내역 Detail울 입력해주세요.' style="width:97%"/>

								</th>
							</tr>
						</thead>
					</table>
				</div>
				<div class="data_tb01 tleft">
					<table cellpadding="0" cellspacing="0" summary="규격, 단위, 재료비, 노무비, 경비, 합계 항목으로 구성된 표입니다.">
						<caption>규격, 단위, 재료비, 노무비, 경비, 합계 항목으로 구성된 표</caption>
						<colgroup>
							<col width="*"/>
							<col width="20%"/>
							<col width="*"/>
							<col width="20%"/>
							<col width="*"/>
							<col width="20%"/>
						</colgroup>
						<tbody>
							<tr>
								<th scope="row"><label for="standard">규격</label></th>
								<td>
                                <input type='text' name='std'              id='std'              class='required trim focus alert' maxlength=50  minlength=0 message='규격을 입력해주세요.' />
                                </td>
								<th scope="row"><label for="unit">단위</label></th>
								<td>
                                <input type='text' name='unit'             id='unit'             class='required trim focus alert' maxlength=50  minlength=0 message='단위을 입력해주세요.' />
                                </td>
								<th scope="row"><label for="material_cost">재료비</label></th>
								<td>
                                <input type='text' name='m_amt'            id='m_amt'            class='required number trim focus alert' maxlength=10  minlength=0 message='재료비를  숫자로 입력해주세요.' style="text-align:right"/>
                                </td>
							</tr>
							<tr>
								<th scope="row"><label for="labor_expenses">노무비</label></th>
								<td>
                                <input type='text' name='l_amt'            id='l_amt'            class='required number trim focus alert' maxlength=10  minlength=0 message='노무비를 숫자로 입력해주세요 ' style="text-align:right"/>
                                </td>
								<th scope="row"><label for="expense">경비</label></th>
								<td>
                                <input type='text' name='e_amt'            id='e_amt'            class='required number trim focus alert' maxlength=10  minlength=0 message='경비를 숫자로 입력해주세요.' style="text-align:right"/>
                                </td>
								<th scope="row"><label for="sum">합계</label></th>
								<td>
                                <input type='text' name='t_amt'            id='t_amt'           style="border:0px;text-align:right" readonly disabled />
                                </td>
							</tr>
							<tr>
								<th scope="row"><label for="business">기업명</label></th>
								<td>
                                <input type='text' name='company_nm'       id='company_nm'       class='required trim focus alert' maxlength=50  minlength=0 message='기업명을 입력해주세요.' />
                                </td>
								<th scope="row"><label for="region">지역</label></th>
								<td>
<?php
$creategory_setup['select'          ] = '';
$creategory_setup['prop_name'       ] = 'company_area';
$creategory_setup['title'           ] = '-선택-'  ;
$creategory_setup['script'          ] = ""  ;
$creategory_setup['properties'      ] = " name='company_area' id='company_area' class='required trim focus alert' message='지역을 선택해주세요.' style='width:100px'"  ;
$creategory_setup['loop_end_tag'    ] = ""  ;
$creategory_setup['append_tag'      ] = "";
$selectInfo = Base::$CODE_AREA;
$selectInfo['setup'] = $creategory_setup;
print Util::createGory ('SELECT',$selectInfo);
?>
								</td>
								<th scope="row"><label for="tel1">기업 전화번호</label></th>
								<td colspan="2">
<input type="text" name="company_tel1" style="width:20%" maxlength=4 class='number trim focus alert' message='전화번호를 확인해주세요.'/>
-
<input type="text" name="company_tel2" style="width:20%" maxlength=4 class='number trim focus alert' message='전화번호를 확인해주세요.'/>
-
<input type="text" name="company_tel3" style="width:20%" maxlength=4 class='number trim focus alert' message='전화번호를 확인해주세요.'/>
								</td>
							</tr>
							<tr>
								<th scope="row"><label for="address">기업주소</label></th>
								<td colspan="5">
                                <input type='text' name='company_addr'     id='company_addr'     class='required trim focus alert' maxlength=100 minlength=0 message='기업 주소를 입력해주세요.' style="width:50%"//>
                                </td>
							</tr>
							<tr>
								<th scope="row"><label for="homepage">기업 홈페이지</label></th>
								<td colspan="5">
                                <input type='text' name='company_homepage' id='company_homepage' class='required trim focus alert' maxlength=255 minlength=0 message='기업 홈페이지 주소를 입력해주세요.' style="width:50%"/>
                                </td>
							</tr>
							<tr>
								<th scope="row"><label for="homepage">비고</label></th>
								<td colspan="5">
								<textarea rows="" cols="" id='etc'  name='etc' value='' class='trim focus alert' message='문의내용를 입력해주세요.' style="width:100%"></textarea>
                                </td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="btn_c">
<a href="#" title="저장하기" onclick="return 실행();" class="btn_navy">저장</a>
<a href="#" title="삭제하기" onclick="return 삭제();" class="btn_navy" style="display:none">삭제</a>
<a href="#" title="목록보기" onclick="return 목록();" class="btn_navy">목록</a>

                </div>

<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->
<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->
<!-- <input type='submit' value='전송'><BR> -->
<!-- <input name='test1' type='text' value='test1'><BR> -->
<!-- <input type='file' name='test_file' id='test_file' style='width:450px'/><BR> -->
</form>