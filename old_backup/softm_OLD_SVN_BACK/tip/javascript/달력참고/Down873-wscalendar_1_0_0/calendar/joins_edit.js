   <!--
      function send_joins() {
         // ���ο� ��й�ȣ �Է� üũ
         strtmp = document.joinsform.cpwd1.value;
         if (strtmp != "") {
            if (strtmp.length < 4) {
               alert ('�� ��й�ȣ�� �ּ� 4�� �̻��̾�� �մϴ�.');
               document.joinsform.cpwd1.focus();

               return;
            }
            if (strtmp != document.joinsform.cpwd2.value) {
               alert ('�� ��й�ȣ�� ��ġ���� �ʽ��ϴ�.');
               document.joinsform.cpwd2.focus();

               return;
            }
		 }

         // �̸����ּ� �Է� üũ
         if (document.joinsform.email.value == '') {
            alert ('�̸����ּҸ� �Է��� �ּ���.');
            document.joinsform.email.focus();

            return;
         }

         // ��й�ȣ �Է� üũ
		 if (document.joinsform.pwd.value == '') {
            alert ('��й�ȣ�� �Է��� �ּ���.');
            document.joinsform.pwd.focus();

            return;
         }

         document.joinsform.action = 'joins_edit_db.php3';
         document.joinsform.submit ();
      }
   //-->