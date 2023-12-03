<form id=wForm name=wForm enctype='application/x-www-form-urlencoded' AUTOCOMPLETE='OFF' method='post' onsubmit='return 실행();'>
<!-- <form id=wForm name=wForm enctype='multipart/form-data' method='post' onsubmit='return 파일업로드();'> -->
<!-- <input name='MAX_FILE_SIZE1' type='hidden' value='3' /> -->
<!-- <input type='submit' value='전송'><BR> -->
<!-- <input name='test1' type='text' value='test1'><BR> -->
<!-- <input type='file' name='test_file' id='test_file' style='width:450px'/><BR> -->
<div id="bd_btn">
<input type=image src="/service/images/btn_modify.jpg" style="vertical-align:middle"/>
<a href="#" title="삭제하기" onclick="return 삭제();"><img src="/service/images/btn_del.jpg" /></a>
<a href="#" title="목록보기" onclick="return 목록();"><img src="/service/images/btn_list.jpg" /></a>
</div>
no : <input type='text' name='no' size=10 value='' style='width:25px' class='required trim focus alert' maxlength=10 minlength=0 message='no를 입력해주세요.' /><BR>
user_id : <input type='text' name='user_id' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='user_id를 입력해주세요.' /><BR>
member_level : <input type='text' name='member_level' size=2 value='' style='width:5px' class='required trim focus alert' maxlength=2 minlength=0 message='member_level를 입력해주세요.' /><BR>
password : <input type='text' name='password' size=41 value='' style='width:102px' class='required trim focus alert' maxlength=41 minlength=0 message='password를 입력해주세요.' /><BR>
name : <input type='text' name='name' size=20 value='' style='width:50px' maxlength=20 /><BR>
sex : <input type='text' name='sex' size=1 value='' style='width:2px' maxlength=1 /><BR>
e_mail : <input type='text' name='e_mail' size=100 value='' style='width:250px' maxlength=100 /><BR>
tel : <input type='text' name='tel' size=20 value='' style='width:50px' maxlength=20 /><BR>
address : <input type='text' name='address' size=100 value='' style='width:250px' maxlength=100 /><BR>
post_no : <input type='text' name='post_no' size=7 value='' style='width:17px' class='required trim focus alert' maxlength=7 minlength=0 message='post_no를 입력해주세요.' /><BR>
member_st : <input type='text' name='member_st' size=1 value='' style='width:2px' maxlength=1 /><BR>
news_yn : <input type='text' name='news_yn' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='news_yn를 입력해주세요.' /><BR>
reg_date : <input type='text' name='reg_date' size=14 value='' style='width:35px' class='required trim focus alert' maxlength=14 minlength=0 message='reg_date를 입력해주세요.' /><BR>
acc_date : <input type='text' name='acc_date' size=14 value='' style='width:35px' class='required trim focus alert' maxlength=14 minlength=0 message='acc_date를 입력해주세요.' /><BR>
jumin : <input type='text' name='jumin' size=41 value='' style='width:102px' maxlength=41 /><BR>
home : <input type='text' name='home' size=255 value='' style='width:637px' maxlength=255 /><BR>
point : <input type='text' name='point' size=11 value='' style='width:27px' maxlength=11 /><BR>
user_id_open : <input type='text' name='user_id_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='user_id_open를 입력해주세요.' /><BR>
member_level_open : <input type='text' name='member_level_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='member_level_open를 입력해주세요.' /><BR>
name_open : <input type='text' name='name_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='name_open를 입력해주세요.' /><BR>
sex_open : <input type='text' name='sex_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='sex_open를 입력해주세요.' /><BR>
e_mail_open : <input type='text' name='e_mail_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='e_mail_open를 입력해주세요.' /><BR>
home_open : <input type='text' name='home_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='home_open를 입력해주세요.' /><BR>
tel_open : <input type='text' name='tel_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='tel_open를 입력해주세요.' /><BR>
address_open : <input type='text' name='address_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='address_open를 입력해주세요.' /><BR>
post_no_open : <input type='text' name='post_no_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='post_no_open를 입력해주세요.' /><BR>
point_open : <input type='text' name='point_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='point_open를 입력해주세요.' /><BR>
picture_image_open : <input type='text' name='picture_image_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='picture_image_open를 입력해주세요.' /><BR>
character_image_open : <input type='text' name='character_image_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='character_image_open를 입력해주세요.' /><BR>
birth : <input type='text' name='birth' size=14 value='' style='width:35px' maxlength=14 /><BR>
age : <input type='text' name='age' size=3 value='' style='width:7px' maxlength=3 /><BR>
birth_open : <input type='text' name='birth_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='birth_open를 입력해주세요.' /><BR>
age_open : <input type='text' name='age_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='age_open를 입력해주세요.' /><BR>
access : <input type='text' name='access' size=10 value='' style='width:25px' maxlength=10 /><BR>
access_open : <input type='text' name='access_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='access_open를 입력해주세요.' /><BR>
hint : <input type='text' name='hint' size=3 value='' style='width:7px' maxlength=3 /><BR>
answer : <input type='text' name='answer' size=255 value='' style='width:637px' maxlength=255 /><BR>
nick_name : <input type='text' name='nick_name' size=20 value='' style='width:50px' maxlength=20 /><BR>
nick_name_open : <input type='text' name='nick_name_open' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='nick_name_open를 입력해주세요.' /><BR>
</form>