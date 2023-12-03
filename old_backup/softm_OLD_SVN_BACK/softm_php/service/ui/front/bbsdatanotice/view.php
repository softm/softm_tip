<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->
<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->
<!-- <input type='submit' value='전송'><BR> -->
<!-- <input name='test1' type='text' value='test1'><BR> -->
<!-- <input type='file' name='test_file' id='test_file' style='width:450px'/><BR> -->
<input type='hidden' name='no' size=20 value=''/>
<input type='hidden' name='cat_no' size=4 value='' />
<input type='hidden' name='g_no' size=20 value='' />
<input type='hidden' name='depth' size=10 value=''/>
<input type='hidden' name='o_seq' size=2 value='' />
<input type='hidden' name='user_no' size=10 value=''/>
				<p class="list_tit">공지사항 - 상세</p>
				<div class="view_tb01">
					<table cellpadding="0" cellspacing="0" summary="">
						<caption>공지사항</caption>
						<colgroup>
							<col width="10%" />
							<col width="*" />
						</colgroup>
						<tbody>
						<tr>
							<th scope="row"><label for="n_writer">작성자</label></th>
							<td><input type='text' name='name' size=40 value='<?=USER_NAME?>' style='border:0px;width:100%' class='required trim focus alert' maxlength=40 minlength=0 message='이름를 입력해주세요.' readonly onfocus="this.blur();" /></td>
						</tr>
						<tr>
							<th scope="row"><label for="n_sub">제목</label></th>
							<td><input type='text' name='title' size=255 value='' style='border:0px;width:100%' class='required trim focus alert' maxlength=255 minlength=0 message='제목를 입력해주세요.' readonly onfocus="this.blur();"/></td>
						</tr>
						<tr>
							<th scope="row" colspan="2" class="tcenter"><label for="n_con">내용</label></th>
						</tr>
						<tr>
							<td colspan="2">
								<textarea rows="" cols="" name='content' value='' class='required trim focus alert' message='내용를 입력해주세요.' readonly onfocus="this.blur();" style='border:0px;'></textarea>
							</td>
						</tr>
						<tr>
							<th scope="row">파일</th>
							<td>
                                <SPAN id=file1_infor></SPAN>
							</td>
						</tr>
						</tbody>
					</table>
				</div>

				<div class="btn_area_n clear">
					<a href="#" title="목록보기" onclick="return 목록();" class="fl">목록</a>
				</div>
</form>