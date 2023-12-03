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
?뚯썝踰덊샇 : <input type='text' name='user_no' size=8 value='' style='width:20px' class='required trim focus alert' maxlength=8 minlength=0 message='?뚯썝踰덊샇를 입력해주세요.' /><BR>
?꾩씠? : <input type='text' name='user_id' size=100 value='' style='width:250px' class='required trim focus alert' maxlength=100 minlength=0 message='?꾩씠?를 입력해주세요.' /><BR>
?뚯썝 ?덈꺼 0 : 鍮꾪쉶?? 1 : ?쇰컲?뚯썝, 2: 以묎컻?뚯썝 , 9 : 愿?━? : <input type='text' name='user_level' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='?뚯썝 ?덈꺼 0 : 鍮꾪쉶?? 1 : ?쇰컲?뚯썝, 2: 以묎컻?뚯썝 , 9 : 愿?━?를 입력해주세요.' /><BR>
鍮꾨?踰덊샇 : <input type='text' name='passwd' size=50 value='' style='width:125px' class='required trim focus alert' maxlength=50 minlength=0 message='鍮꾨?踰덊샇를 입력해주세요.' /><BR>
?대쫫 : <input type='text' name='user_name' size=20 value='' style='width:50px' class='required trim focus alert' maxlength=20 minlength=0 message='?대쫫를 입력해주세요.' /><BR>
蹂꾨챸 : <input type='text' name='nick_name' size=20 value='' style='width:50px' maxlength=20 /><BR>
遺?룞?곗뾽泥대챸 : <input type='text' name='company_name' size=100 value='' style='width:250px' class='required trim focus alert' maxlength=100 minlength=0 message='遺?룞?곗뾽泥대챸를 입력해주세요.' /><BR>
국가코드 : <input type='text' name='country_code' size=2 value='' style='width:5px' maxlength=2 /><BR>
?깅퀎 : <input type='text' name='sex' size=1 value='' style='width:2px' maxlength=1 /><BR>
E-mail : <input type='text' name='e_mail' size=100 value='' style='width:250px' maxlength=100 /><BR>
二쇰?踰덊샇 : <input type='text' name='jumin_no' size=13 value='' style='width:32px' maxlength=13 /><BR>
?ъ뾽?먮쾲? : <input type='text' name='company_no' size=20 value='' style='width:50px' maxlength=20 /><BR>
?몃뱶? : <input type='text' name='tel1' size=20 value='' style='width:50px' maxlength=20 /><BR>
?꾪솕1 : <input type='text' name='tel2' size=20 value='' style='width:50px' maxlength=20 /><BR>
?꾪솕2 : <input type='text' name='tel3' size=20 value='' style='width:50px' maxlength=20 /><BR>
?꾪솕3 : <input type='text' name='tel4' size=20 value='' style='width:50px' maxlength=20 /><BR>
二쇱냼 : <input type='text' name='address1' size=100 value='' style='width:250px' maxlength=100 /><BR>
?섎㉧吏?二쇱냼 : <input type='text' name='address2' size=100 value='' style='width:250px' maxlength=100 /><BR>
?고렪踰덊샇 : <input type='text' name='post_no' size=7 value='' style='width:17px' maxlength=7 /><BR>
?대찓???섏떊 ?щ? : <input type='text' name='email_yn' size=1 value='' style='width:2px' maxlength=1 /><BR>
?묒냽 ?잛닔 : <input type='text' name='access' size=8 value='' style='width:20px' maxlength=8 /><BR>
媛?엯 ?쇱옄 : <input type='text' name='reg_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.reg_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
理쒓렐 ?묎렐? : <input type='text' name='acc_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.acc_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
?뚯썝 ?곹깭 : <input type='text' name='state' size=1 value='' style='width:2px' class='required trim focus alert' maxlength=1 minlength=0 message='?뚯썝 ?곹깭를 입력해주세요.' /><BR>
agreement : <input type='text' name='agreement' size=1 value='' style='width:2px' maxlength=1 /><BR>
agreement_date : <input type='text' name='agreement_date' value='2014-06-10 13:56' readonly  style='width:100px' maxlength= />&nbsp;<input type=button value='Cal' onclick='displayCalendar(this.form.agreement_date,"yyyy-mm-dd hh:ii",this,true)'><BR>
</form>