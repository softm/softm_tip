   <!--
      function send_joins() {
         // ����� ID �Է� üũ
         strtmp = document.joinsform.id.value;
         if (strtmp == '') {
            alert ('����� ID�� �Է��� �ּ���.');
            document.joinsform.id.focus();

            return;
         }
         if (strtmp.length < 5) {
            alert ('����� ID�� �ּ� 5�� �̻��̾�� �մϴ�.');
            document.joinsform.id.focus();

            return;
         }

         // ��й�ȣ �Է� üũ
         strtmp = document.joinsform.pwd.value;
         if (strtmp == '') {
            alert ('��й�ȣ�� �Է��� �ּ���.');
            document.joinsform.pwd.focus();

            return;
         }
         if (strtmp.length < 4) {
            alert ('��й�ȣ�� �ּ� 4�� �̻��̾�� �մϴ�.');
            document.joinsform.pwd.focus();

            return;
         }
         if (strtmp != document.joinsform.pwd2.value) {
            alert ('�Էµ� ��й�ȣ�� ��ġ���� �ʽ��ϴ�.');
            document.joinsform.pwd2.focus();

            return;
         }

         // �̸� �Է� üũ
         if (document.joinsform.name.value == '') {
            alert ('�̸��� �Է��� �ּ���.');
            document.joinsform.name.focus();

            return;
         }

         // �̸����ּ� �Է� üũ
         if (document.joinsform.email.value == '') {
            alert ('�̸����ּҸ� �Է��� �ּ���.');
            document.joinsform.email.focus();

            return;
         }

         // �ֹε�Ϲ�ȣ1 �Է� üũ
         str1 = document.joinsform.ssn1.value;
         str2 = document.joinsform.ssn2.value;
         if (str1.length < 6) {
            alert ("�ֹε�Ϲ�ȣ �Է��� �ùٸ��� �ʽ��ϴ�\n\rȮ�� �� ��Ȯ�� �Է��� �ֽʽÿ�");
            document.joinsform.ssn1.focus();

            return;
         }
         // �ֹε�Ϲ�ȣ2 �Է� üũ
         else if (str2.length < 7) {
            alert ("�ֹε�Ϲ�ȣ �Է��� �ùٸ��� �ʽ��ϴ�\n\rȮ�� �� ��Ȯ�� �Է��� �ֽʽÿ�");
            document.joinsform.ssn2.focus();

            return;
         }
         else {
            // �ֹε�Ϲ�ȣ �� 6�ڸ�
            a = parseInt(document.joinsform.ssn1.value.substr(0, 1)) * 2;
            b = parseInt(document.joinsform.ssn1.value.substr(1, 1)) * 3;
            c = parseInt(document.joinsform.ssn1.value.substr(2, 1)) * 4;
            d = parseInt(document.joinsform.ssn1.value.substr(3, 1)) * 5;
            e = parseInt(document.joinsform.ssn1.value.substr(4, 1)) * 6;
            f = parseInt(document.joinsform.ssn1.value.substr(5, 1)) * 7;

            // �ֹε�Ϲ�ȣ �� 7�ڸ�
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

            // �ֹε�Ϲ�ȣ�� ���Ŀ� ���� �ʴٸ�...
            if (pivot != end_number) {
               alert("�ֹε�Ϲ�ȣ�� �� �� �Է��ϼ̽��ϴ�.\n�ùٸ� �ֹε�Ϲ�ȣ�� �ƴմϴ�.");
               document.joinsform.ssn1.focus();

               return;
            }
         }

		 // �����ȣ �Է� üũ
		 if (document.joinsform.zip1.value) {
            if (document.joinsform.zip1.value.length < 3) {
               alert ('�����ȣ�� ��Ȯ�ϰ� �Է��� �ּ���.');
			   document.joinsform.zip1.focus();

               return;
            }
            if (document.joinsform.zip2.value < 3) {
               alert ('�����ȣ�� ��Ȯ�ϰ� �Է��� �ּ���.');
			   document.joinsform.zip2.focus();

               return;
            }
         }
/*
         if (document.joinsform.address.value == '') {
            alert ('�ּҸ� �Է��� �ּ���.');

            return;
         }
*/
         document.joinsform.action = 'joins_db.php3';
         document.joinsform.submit ();
      }

      // ���ڸ� �Է� �޴´�.
      function onlyNumber () {
         if ( (event.keyCode < 48) || (event.keyCode > 57) )
            event.returnValue = false;
      }

      // �����̽� �Է� üũ.
      function onlyNoSpace () {
         if ( (event.keyCode == 32) )
            event.returnValue = false;
      }
   //-->