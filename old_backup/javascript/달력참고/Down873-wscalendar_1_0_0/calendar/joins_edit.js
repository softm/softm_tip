   <!--
      function send_joins() {
         // 새로운 비밀번호 입력 체크
         strtmp = document.joinsform.cpwd1.value;
         if (strtmp != "") {
            if (strtmp.length < 4) {
               alert ('새 비밀번호는 최소 4자 이상이어야 합니다.');
               document.joinsform.cpwd1.focus();

               return;
            }
            if (strtmp != document.joinsform.cpwd2.value) {
               alert ('새 비밀번호가 일치하지 않습니다.');
               document.joinsform.cpwd2.focus();

               return;
            }
		 }

         // 이메일주소 입력 체크
         if (document.joinsform.email.value == '') {
            alert ('이메일주소를 입력해 주세요.');
            document.joinsform.email.focus();

            return;
         }

         // 비밀번호 입력 체크
		 if (document.joinsform.pwd.value == '') {
            alert ('비밀번호를 입력해 주세요.');
            document.joinsform.pwd.focus();

            return;
         }

         document.joinsform.action = 'joins_edit_db.php3';
         document.joinsform.submit ();
      }
   //-->