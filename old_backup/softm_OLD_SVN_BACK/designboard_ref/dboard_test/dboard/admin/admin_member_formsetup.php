<?
if ( function_exists('head') ) {
    if ( $branch == 'formsetup' ) {
        head("����_����������");        // Header ���

        $row = singleRowSQLQuery("select * from $tb_member_config where member_level = 0");
    ?>
    <script type="text/javascript">
    <!--
    function juminEssentialCond(gubun) {
        if ( !isChecked ( document.memberSetupForm.jumin ) ) {
            if ( !isChecked ( document.memberSetupForm.e_mail ) ) {
                alert ( '�ֹι�ȣ�� �̸��� �� �ϳ��� ���� �Ǿ�� �մϴ�. [ ���� �ֹ� ��ȣ ���� ]' );
                document.memberSetupForm.jumin.checked  = true;
            }
        }
        hintEssentialCond();
    }

    function emailEssentialCond() {
        if ( !isChecked ( document.memberSetupForm.e_mail ) ) {
            if ( !isChecked ( document.memberSetupForm.jumin ) ) {
                alert ( '�ֹι�ȣ�� �̸��� �� �ϳ��� ���� �Ǿ�� �մϴ�. [ ���� �̸��� ���� ]' );
                document.memberSetupForm.e_mail.checked  = true;
            }
        }
        hintEssentialCond();
    }

    function hintEssentialCond() {
        if ( !isChecked ( document.memberSetupForm.jumin ) ) {
            document.memberSetupForm.hint.checked  = true;
            if ( isChecked ( document.memberSetupForm.e_mail ) ) {
                objectDisabled(document.memberSetupForm.hint,'Y');
            }
        } else {
            objectDisabled(document.memberSetupForm.hint,'N');
        }
    }

    function essentialCond(field) {
        var essObj = eval('document.memberSetupForm.' + field + '_essential');
        var selObj = eval('document.memberSetupForm.' + field);
        if ( essObj.checked ) {
            selObj.checked = true;
            objectDisabled ( selObj, 'Y' );
        } else {
            objectDisabled ( selObj, 'N' );
        }
    }

    function writeData() {
        objectDisabled ( document.memberSetupForm.name, 'N' );
        objectDisabled ( document.memberSetupForm.hint, 'N' );
        if ( document.memberSetupForm.nick_name_essential.checked       ) { document.memberSetupForm.nick_name.value        = 'C'; objectDisabled ( document.memberSetupForm.nick_name      , 'N' ); }
        if ( document.memberSetupForm.sex_essential.checked             ) { document.memberSetupForm.sex.value              = 'C'; objectDisabled ( document.memberSetupForm.sex            , 'N' ); }
        if ( document.memberSetupForm.home_essential.checked            ) { document.memberSetupForm.home.value             = 'C'; objectDisabled ( document.memberSetupForm.home           , 'N' ); }
        if ( document.memberSetupForm.birth_essential.checked           ) { document.memberSetupForm.birth.value            = 'C'; objectDisabled ( document.memberSetupForm.birth          , 'N' ); }
        if ( document.memberSetupForm.age_essential.checked             ) { document.memberSetupForm.age.value              = 'C'; objectDisabled ( document.memberSetupForm.age            , 'N' ); }
        if ( document.memberSetupForm.tel_essential.checked             ) { document.memberSetupForm.tel.value              = 'C'; objectDisabled ( document.memberSetupForm.tel            , 'N' ); }
        if ( document.memberSetupForm.address_essential.checked         ) { document.memberSetupForm.address.value          = 'C'; objectDisabled ( document.memberSetupForm.address        , 'N' ); }
        if ( document.memberSetupForm.picture_image_essential.checked   ) { document.memberSetupForm.picture_image.value    = 'C'; objectDisabled ( document.memberSetupForm.picture_image  , 'N' ); }
        if ( document.memberSetupForm.character_image_essential.checked ) { document.memberSetupForm.character_image.value  = 'C'; objectDisabled ( document.memberSetupForm.character_image, 'N' ); }
        return true;
    }
    //-->
    </SCRIPT>
</head>
<body>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
                  <tr>
                    <td width="808" valign='top'>
                        <table width="100%" border="0" cellspacing="1" cellpadding="2" class="text_01" bgcolor="CCCCCC">
                        <form name='memberSetupForm' method='post' action='admin_member.php' onSubmit='return writeData();'>
                            <input type='hidden' name='branch'  value='exec'            >
                            <input type='hidden' name='gubun'   value='formsetup'       >
                            <input type='hidden' name='member_level'   value='0'        >
                          <tr bgcolor="#FFFFFF">
                            <td colspan="8" height="45" class="text_01" background="images/top_12.gif" align="right">
                              <b>&nbsp;</b></td>
                          </tr>
                          <tr>
                            <td bgcolor="F7F7F7" width="150" align="right"><b>ȸ������ URL&nbsp;&nbsp;</b></td>
                            <td bgcolor="#FFFFFF" colspan="2" class="text_04">
                            &nbsp;&nbsp;<a href="member_register.php" target='_member_new'><font color="BF0909">http://<?=$HTTP_HOST.$sysInfor["base_dir"]?>member_register.php</font></a>
                            </td>
                          </tr>
                        <!--   <tr>
                            <td bgcolor="F7F7F7" align="right"><b>ȸ������ ����ҽ�&nbsp;&nbsp;</b></td>
                            <td bgcolor="#FFFFFF" class="text_05" colspan="2">&nbsp;&nbsp;&lt;? include
                              ( &quot;../xxx/xxxxx.php ?&gt;</td>
                          </tr> -->
                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>���Ծ�� ����&nbsp;&nbsp;</b></td>
                            <td bgcolor="#FFFFFF" colspan="2" height="90"> &nbsp;
                        &nbsp;<textarea name='agreement_content' cols="99" rows="7"><?=_htmlspecialchars ($row['agreement_content'],ENT_QUOTES)?></textarea>
                            </td>
                          </tr>
                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>���Ծ�� ���&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
 <?
                        $checked = ( $row['agreement'] == 'Y' ) ? 'checked' : '';
                        echo "<input type='checkbox' name='agreement' value='Y' $checked>";
 ?>
                           </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;���Ծ���� ǥ�� �մϴ�.</td>
                          </tr>
                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>���̵�&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center"><b><a href="#">
                        <input type="checkbox" name="user_id" value="checkbox" checked disabled>
                              </a></b></td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;���̵�� �⺻ �Է� �����Դϴ�.</td>
                          </tr>
                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>��й�ȣ&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
                        <input type="checkbox" name="password" value="checkbox" checked disabled>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;��й�ȣ�� �⺻ �Է� �����Դϴ�.</td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>�� ��&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
                        <input type='checkbox' name='name' value='Y' checked disabled>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;�̸��� �Է¹����� �ֽ��ϴ�. </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>�ֹε�Ϲ�ȣ&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
 <?
                        $checked = ( $row['jumin'] == 'Y' ) ? 'checked' : '';
                        echo "<input type='checkbox' name='jumin' value='Y' $checked onClick='juminEssentialCond(\"jumin\");' $checked>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;�ֹε�Ϲ�ȣ�� �Է¹����� �ֽ��ϴ�.&nbsp;</td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>�̸���&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
 <?
                        $checked = ( $row['e_mail'] == 'Y' ) ? 'checked' : '';
                        echo "<input type='checkbox' name='e_mail' value='Y' $checked onClick='emailEssentialCond();' $checked>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;�̸����� �Է¹����� �ֽ��ϴ�.</td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>�� Ʈ&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
 <?
                        $checked = ( $row['hint'] == 'Y' ) ? 'checked' : '';
                        echo "<input type='checkbox' name='hint' value='Y' $checked onClick='hintEssentialCond();' $checked>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;��Ʈ�� �Է¹����� �ֽ��ϴ�.</td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>�� ��&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
 <?
                        $checked = ( $row['nick_name'] == 'Y' || $row['nick_name'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['nick_name'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='nick_name' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;������ �Է¹����� �ֽ��ϴ�. 
 <?
                        $checked = ( $row['nick_name'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='nick_name_essential' value='C' $checked onClick='essentialCond(\"nick_name\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>�� ��&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
 <?
                        $checked = ( $row['sex'] == 'Y' || $row['sex'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['sex'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='sex' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;������ �Է¹����� �ֽ��ϴ�. 
 <?
                        $checked = ( $row['sex'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='sex_essential' value='C' $checked onClick='essentialCond(\"sex\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right"><b>Ȩ������&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center">
 <?
                        $checked = ( $row['home'] == 'Y' || $row['home'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['home'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='home' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF">&nbsp;&nbsp;Ȩ������ �ּҸ� �Է¹����� �ֽ��ϴ�.
 <?
                        $checked = ( $row['home'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='home_essential' value='C' $checked onClick='essentialCond(\"home\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right" height="20"><b>�������&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center" height="20">
 <?
                        $checked = ( $row['birth'] == 'Y' || $row['birth'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['birth'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='birth' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF" height="20">&nbsp;&nbsp;��������� �Է¹����� �ֽ��ϴ�.
 <?
                        $checked = ( $row['birth'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='birth_essential' value='C' $checked onClick='essentialCond(\"birth\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right" height="20"><b>����&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center" height="20">
 <?
                        $checked = ( $row['age'] == 'Y' || $row['age'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['age'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='age' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF" height="20">&nbsp;&nbsp;���̸� �Է¹����� �ֽ��ϴ�.
 <?
                        $checked = ( $row['age'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='age_essential' value='C' $checked onClick='essentialCond(\"age\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right" height="20"><b>����ó ��ȣ&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center" height="20">
 <?
                        $checked = ( $row['tel'] == 'Y' || $row['tel'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['tel'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='tel' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF" height="20">&nbsp;&nbsp;����ó�� �Է¹����� �ֽ��ϴ�.
 <?
                        $checked = ( $row['tel'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='tel_essential' value='C' $checked onClick='essentialCond(\"tel\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>
                          <tr>
                            <td bgcolor="F7F7F7" align="right" height="20"><b>�� ��&nbsp;&nbsp;</b></td>
                            <td bgcolor="F7F7F7" align="center" height="20">
 <?
                        $checked = ( $row['address'] == 'Y' || $row['address'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['address'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='address' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF" height="20">&nbsp;&nbsp;�ּҸ� �Է¹����� �ֽ��ϴ�.
 <?
                        $checked = ( $row['address'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='address_essential' value='C' $checked onClick='essentialCond(\"address\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right" height="20"><b>����&nbsp;&nbsp;<br>
                              </b></td>
                            <td bgcolor="F7F7F7" align="center" height="20">
 <?
                        $checked = ( $row['picture_image'] == 'Y' || $row['picture_image'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['picture_image'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='picture_image' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF" height="20">&nbsp;&nbsp;ȸ�� ������ ���ε� �� �� �ֽ��ϴ�.
 <?
                        $checked = ( $row['picture_image'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='picture_image_essential' value='C' $checked onClick='essentialCond(\"picture_image\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right" height="20"><b>ȸ�� ������&nbsp;&nbsp;<br>
                              </b></td>
                            <td bgcolor="F7F7F7" align="center" height="20">
 <?
                        $checked = ( $row['character_image'] == 'Y' || $row['character_image'] == 'C' ) ? 'checked' : '';
                        $disabled= ( $row['character_image'] == 'C' ) ? 'disabled' : '';
                        echo "<input type='checkbox' name='character_image' value='Y' $checked $disabled>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF" height="20">&nbsp;&nbsp;ȸ�� �������� ���ε� �� �� �ֽ��ϴ�.
 <?
                        $checked = ( $row['character_image'] == 'C' ) ? 'checked' : '';
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                        echo"<input type='checkbox' name='character_image_essential' value='C' $checked onClick='essentialCond(\"character_image\");'> �ʼ� �Է�";
 ?>
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right" height="20"><b>���� ����Ʈ&nbsp;&nbsp;<br>
                              </b></td>
                            <td bgcolor="F7F7F7" align="center" height="20">
 <?
                        $checked = ( $row['point_yn'] == 'Y' ) ? 'checked' : '';
                        echo "<input type='checkbox' name='point_yn' value='Y' $checked>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF" height="20">&nbsp;&nbsp;<input type="text" name='point' size="8" maxlength='10' value='<?=$row['point']?>' style='text-align:right'>
                            ����Ʈ ( ȸ�� ���Խ� ����Ʈ�� �����Ͻ� �� �ֽ��ϴ�. )
                            </td>
                          </tr>

                          <tr>
                            <td bgcolor="F7F7F7" align="right" height="20"><b>�������� ����&nbsp;&nbsp;<br>
                              </b></td>
                            <td bgcolor="F7F7F7" align="center" height="20">
 <?
                        $checked = ( $row['news_yn'] == 'Y' ) ? 'checked' : '';
                        echo "<input type='checkbox' name='news_yn' value='Y' $checked>";
 ?>
                            </td>
                            <td bgcolor="#FFFFFF" height="20">&nbsp;&nbsp;<input type="text" name='news_point' size="8" maxlength='10' value='<?=$row['news_point']?>' style='text-align:right'>
                            ����Ʈ ( �������� ���� ����Ʈ�� �����Ͻ� �� �ֽ��ϴ� .)
                            </td>
                          </tr>

                          <tr bgcolor="#FFFFFF" align="right">
                            <td height="50" colspan="3">
                        <!-- <button class=input_03 style="BORDER-LEFT-COLOR: #003B2B; BORDER-BOTTOM-COLOR: #003B2B; BORDER-TOP-COLOR: #003B2B; HEIGHT: 18px; BORDER-RIGHT-COLOR: #003B2B" onClick='popWindow("member_register.php",600,450)'>������ Ȯ��</button> -->
                        <input type="image" border="0" name="imageField" src="images/confirm.gif" width="66" height="30">
    <!--                     <a href='javascript:self.close();'><img border="0" name="imageField2" src="images/button_close.gif" width="66" height="30" border='0'></a> -->
                              &nbsp;&nbsp; </td>
                          </tr>
                        </form>
                        </table>
                        <table border="0" cellspacing="0" cellpadding="0" height="100%">
                          <tr>
                            <td bgcolor="CCCCCC" width="1"></td>
                          </tr>
                        </table>
                    </td>
                    <td valign="top">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
                        <tr>
                          <td bgcolor="CCCCCC" height="1"></td>
                        </tr>
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
</body>
</html>                
 <?
    } // if END
    else {
        redirectPage("admin_member.php"); // �Խ��� ���� (��ȸ) �̵�
    }
}
?>
