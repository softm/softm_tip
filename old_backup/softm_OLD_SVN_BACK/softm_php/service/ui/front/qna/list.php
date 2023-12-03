			<div class="cont">
				<div class="tab_cont_area">
					<ul class="tab_area"">
						<li><a href="#" class="active"><span>사용자</span></a></li>
						<li><a href="#"><span>기업</span></a></li>
					</ul>
					<!-- 사용자 -->
					<div class="tab_cont">
						<div class="map_cont">
							<h2><span class="red">◎ </span>한옥 기술 Map 구조 설명</h2>
						</div>
						<div class="qna" id="sub_content" >
							<h2><span class="red">◎ </span>질문 및 답변</h2>
							<div class="btn_area btn_area_r01">
      <a href=# onclick="return 입력();"" class="btn_gray">고객센터 문의하기</a>
							</div>
							<div class="data_tb01 pop">
<table border="0" cellspacing="0" cellpadding="0" id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot style="height:50px"></tfoot>
</table>
							</div>
						</div>
					</div>

					<!-- 기업 -->
					<div class="tab_cont" style="display:none;">
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
											<select name="">
												<option value="">대공증</option>
												<option value="">공통가설</option>
												<option value="">토공사</option>
												<option value="">콘크리트 공사</option>
												<option value="">조적/석공사</option>
												<option value="">금속공사</option>
												<option value="">목공사</option>
												<option value="">단열/방수</option>
												<option value="">창호</option>
												<option value="">마감공사</option>
												<option value="">지붕/홈통</li>
												<option value="">가구공사</option>
												<option value="">조경/부대토목</option>
												<option value="">전기</option>
												<option value="">설비</option>
												<option value="">경상비/기타</option>
											</select>
										</td>
										<td>
											<select name="">
												<option value="">공증항목</option>
												<option value="">aaa</option>
												<option value="">bbb</option>
												<option value="">항목 추가하기</option>
											</select>
											<input type="text" id="add01" class="add" disabled="disabled" />
										</td>
										<td>
											<select name="">
												<option value="">공종항목내역</option>
												<option value="">aaa</option>
												<option value="">bbb</option>
												<option value="">항목 추가하기</option>
											</select>
											<input type="text" id="add02" class="add" disabled="disabled" />
										</td>
									</tr>
								</tbody>
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
										<td><input type="text" id="standard" /></td>
										<th scope="row"><label for="unit">단위</label></th>
										<td><input type="text" id="unit" /></td>
										<th scope="row"><label for="material_cost">재료비</label></th>
										<td><input type="text" id="material_cost" /></td>
									</tr>
									<tr>
										<th scope="row"><label for="labor_expenses">노무비</label></th>
										<td><input type="text" id="labor_expenses" /></td>
										<th scope="row"><label for="expense">경비</label></th>
										<td><input type="text" id="expense" /></td>
										<th scope="row"><label for="sum">합계</label></th>
										<td><input type="text" id="sum" /></td>
									</tr>
									<tr>
										<th scope="row"><label for="business">기업명</label></th>
										<td><input type="text" id="business" /></td>
										<th scope="row"><label for="region">지역</label></th>
										<td>
											<select name="" ,id="region">
												<option value="">서울특별시</option>
												<option value="">강원도</option>
											</select>
										</td>
										<th scope="row"><label for="tel1">기업 전화번호</label></th>
										<td colspan="2">
											<input type="text" id="tel1" style="width:20%" maxlength="3" />
											- 
											<input type="text" id="tel2" style="width:20%" maxlength="4" title="전화번호 두번째 네자리를 입력하세요." />
											- 
											<input type="text" id="tel3" style="width:20%" maxlength="4" title="전화번호 세번째 sp자리를 입력하세요." />
										</td>
									</tr>
									<tr>
										<th scope="row"><label for="address">기업주소</label></th>
										<td colspan="5"><input type="text" id="address" style="width:50%"/></td>
									</tr>
									<tr>
										<th scope="row"><label for="homepage">기업 홈페이지</label></th>
										<td colspan="5"><input type="text" id="homepage" style="width:50%"/></td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="tc"><a href="#" class="btn_navy">관리자에게 전송하기</a></div>
					</div>
				</div>
			</div>
