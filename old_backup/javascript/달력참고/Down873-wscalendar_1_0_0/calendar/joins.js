   <!--
      function send_joins() {
         // 사용자 ID 입력 체크
         strtmp = document.joinsform.id.value;
         if (strtmp == '') {
            alert ('사용자 ID를 입력해 주세요.');
            document.joinsform.id.focus();

            return;
         }
         if (strtmp.length < 5) {
            alert ('사용자 ID는 최소 5자 이상이어야 합니다.');
            document.joinsform.id.focus();

            return;
         }

         // 비밀번호 입력 체크
         strtmp = document.joinsform.pwd.value;
         if (strtmp == '') {
            alert ('비밀번호를 입력해 주세요.');
            document.joinsform.pwd.focus();

            return;
         }
         if (strtmp.length < 4) {
            alert ('비밀번호는 최소 4자 이상이어야 합니다.');
            document.joinsform.pwd.focus();

            return;
         }
         if (strtmp != document.joinsform.pwd2.value) {
            alert ('입력된 비밀번호가 일치하지 않습니다.');
            document.joinsform.pwd2.focus();

            return;
         }

         // 이름 입력 체크
         if (document.joinsform.name.value == '') {
            alert ('이름을 입력해 주세요.');
            document.joinsform.name.focus();

            return;
         }

         // 이메일주소 입력 체크
         if (document.joinsform.email.value == '') {
            alert ('이메일주소를 입력해 주세요.');
            document.joinsform.email.focus();

            return;
         }

         // 주민등록번호1 입력 체크
         str1 = document.joinsform.ssn1.value;
         str2 = document.joinsform.ssn2.value;
         if (str1.length < 6) {
            alert ("주민등록번호 입력이 올바르지 않습니다\n\r확인 후 정확히 입력해 주십시오");
            document.joinsform.ssn1.focus();

            return;
         }
         // 주민등록번호2 입력 체크
         else if (str2.length < 7) {
            alert ("주민등록번호 입력이 올바르지 않습니다\n\r확인 후 정확히 입력해 주십시오");
            document.joinsform.ssn2.focus();

            return;
         }
         else {
            // 주민등록번호 앞 6자리
            a = parseInt(document.joinsform.ssn1.value.substr(0, 1)) * 2;
            b = parseInt(document.joinsform.ssn1.value.substr(1, 1)) * 3;
            c = parseInt(document.joinsform.ssn1.value.substr(2, 1)) * 4;
            d = parseInt(document.joinsform.ssn1.value.substr(3, 1)) * 5;
            e = parseInt(document.joinsform.ssn1.value.substr(4, 1)) * 6;
            f = parseInt(document.joinsform.ssn1.value.substr(5, 1)) * 7;

            // 주민등록번호 뒤 7자리
            g = parseInt(document.joinsform.ssn2.value.substr(0, 1)) * 8;
            h = parseInt(document.joinsform.ssn2.value.substr(1, 1)) * 9;
            i = parseInt(document.joinsform.ssn2.value.substr(2, 1)) * 2;
            j = parseInt(document.joinsform.ssn2.value.substr(3, 1)) * 3;
            k = parseInt(document.joinsform.ssn2.value.substr(4, 1)) * 4;
            l = parseInt(document.joinsform.ssn2.value.substr(5, 1)) * 5;

            pivot = parseInt(document.joinsform.ssn2.value.substr(6, 1));

            sum = a + b + c + d + e + f + g + h + i + j + k + l;

            modulus = sum % 11;
            end_number = 11 - modulus;

            if (end_number == 11)
               end_number = 1;
            else if (end_number == 10)
               end_number = 0;

            // 주민등록번호가 혁식에 맞지 않다면...
            if (pivot != end_number) {
               alert("주민등록번호를 잘 못 입력하셨습니다.\n올바른 주민등록번호가 아닙니다.");
               document.joinsform.ssn1.focus();

               return;
            }
         }

		 // 우편번호 입력 체크
		 if (document.joinsform.zip1.value) {
            if (document.joinsform.zip1.value.length < 3) {
               alert ('우편번호를 정확하게 입력해 주세요.');
			   document.joinsform.zip1.focus();

               return;
            }
            if (document.joinsform.zip2.value < 3) {
               alert ('우편번호를 정확하게 입력해 주세요.');
			   document.joinsform.zip2.focus();

               return;
            }
         }
/*
         if (document.joinsform.address.value == '') {
            alert ('주소를 입력해 주세요.');

            return;
         }
*/
         document.joinsform.action = 'joins_db.php3';
         document.joinsform.submit ();
      }

      // 숫자만 입력 받는다.
      function onlyNumber () {
         if ( (event.keyCode < 48) || (event.keyCode > 57) )
            event.returnValue = false;
      }

      // 스페이스 입력 체크.
      function onlyNoSpace () {
         if ( (event.keyCode == 32) )
            event.returnValue = false;
      }
   //-->