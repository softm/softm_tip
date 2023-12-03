  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
<form onSubmit='return writeData(this);' name='writeForm' method='POST' enctype="multipart/form-data">
    <tr> 
      <td bgcolor="F2F2F2" height="5"></td>
      <td bgcolor="F2F2F2" height="5"></td>
      <td bgcolor="F2F2F2" height="5"></td>
    </tr>
    <tr> 
      <td colspan="3" align="right" height="10"></td>
    </tr>

<?=$hide_category_s     ?>
    <tr> 
      <td width="60" align="right"><b>카테고리</b></td>
      <td width="10"></td>
      <td> 
        <?
          $category_setup['select'] = 1;
          $category_setup['title' ] = '--카테고리 선택--';
          $category_setup['script'            ]   = ""  ; // 스크립트
          $category_setup['properties'        ]   = "class=admin_listbox"        ; // 카테고리 html 속성
          $category_setup['active_start_tag'  ]   = ""  ; // 카테고리 선택 항목 처음   태그
          $category_setup['active_end_tag'    ]   = ""  ; // 카테고리 선택 항목 마지막 태그
        ?>
        <?=createCategory ('W','SELECT')?>
      </td>
    </tr>
<?=$hide_category_e     ?>

<?=$hide_name_s     ?>
    <tr> 
      <td colspan="3" height="3"></td>
    </tr>
    <tr> 
      <td width="60" align="right"><b>이 름</b></td>
      <td width="10"></td>
      <td class="text_04"> 
        <input type="text" name="name" class="textarea_01" style="width:100%" value='<?=$name?>'>
      </td>
    </tr>
<?=$hide_name_e     ?>

<?=$hide_home_s     ?>
    <tr> 
      <td colspan="3" height="3"></td>
    </tr>
    <tr> 
      <td width="60" align="right"><b>홈페이지</b></td>
      <td></td>
      <td class="text_04"> 
        <input type="text" name="home" class="textarea_01" style="width:100%" value='<?=$home?>'>
      </td>
    </tr>
<?=$hide_home_e     ?>

<?=$hide_e_mail_s   ?>
    <tr> 
      <td colspan="3" height="3"></td>
    </tr>
    <tr> 
      <td width="60" align="right"><b>이메일</b></td>
      <td></td>
      <td class="text_03"> 
        <input type="text" name="e_mail" class="textarea_01" style="width:100%" value='<?=$e_mail?>'>
      </td>
    </tr>
<?=$hide_e_mail_e   ?>

    <tr> 
      <td colspan="3" height="3"></td>
    </tr>
    <tr> 
      <td width="60" align="right"><b>제 목</b></td>
      <td></td>
      <td class="text_04"> 
        <input type="text" name="title" class="textarea_01" style="width:100%" value='<?=$title?>'>
      </td>
    </tr>

    <tr> 
      <td height="3" colspan="3"></td>
    </tr>
    <tr> 
      <td align="right">&nbsp;</td>
      <td></td>
      <td class="text_04">
<?=$hide_ann_yn_s?>
                        <input type="checkbox" name="ann_yn"      value="Y">
                        공지사항
<?=$hide_ann_yn_e?>
<?=$hide_html_yn_s       ?>
                        <input type="checkbox" name="html_yn"     value="Y" onClick='htmlMode (this);'>
                        HTML 사용 
<?=$hide_html_yn_e       ?>

<?=$hide_open_yn_s       ?>
                        <input type="checkbox" name="open_yn"     value="Y">
                        비공개 
<?=$hide_open_yn_e       ?>

<?=$hide_answer_mail_s?>
                        <input type="checkbox" name="mail_yn"     value="Y">
                        답변시에 메일받음 
<?=$hide_answer_mail_e?>

     </td>
    </tr>
    <tr> 
      <td colspan="3" height="10"></td>
    </tr>
    <tr> 
      <td background="<?=$skinDir?>images/bg_view_top.gif" height="3"></td>
      <td background="<?=$skinDir?>images/bg_view_top.gif" height="3"></td>
      <td background="<?=$skinDir?>images/bg_view_top.gif" height="3"></td>
    </tr>
  </table>
  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
    <tr> 
      <td height="20" colspan="3"></td>
    </tr>
    <tr> 
      <td width="60" align="right"><b>내 용</b></td>
      <td width="10"></td>
      <td style='word-break:break-all'> 
        <textarea name="content" class="textarea_01" rows="15" style="width:100%"><?=$content?></textarea>
      </td>
    </tr>
    <tr align="left"> 
      <td colspan="3" height="5"></td>
    </tr>

<?=$hide_file1_s       ?>
    <tr> 
      <td width="60" align="right"><b>파일첨부1</b></td>
      <td></td>
      <td class="text_03"> 
        <input type="file" name="file1" class="textarea_01">
        &nbsp; <?=$a_file1?><?=$f_name1?> (<?=$f_size1?>)</a>
        <input type="checkbox" name="file1_delete" value="Y"><span id='file1_delete_lable'>삭제</span>
      </td>
    </tr>
<?=$hide_file1_e       ?>
<?=$hide_file2_s       ?>
    <tr> 
      <td width="60" align="right"><b>파일첨부2</b></td>
      <td></td>
      <td class="text_03"> 
        <input type="file" name="file2" class="textarea_01">
        &nbsp; <?=$a_file2?><?=$f_name2?> (<?=$f_size2?>)</a>
        <input type="checkbox" name="file2_delete" value="Y"><span id='file2_delete_lable'>삭제</span>
      </td>
    </tr>
<?=$hide_file2_e       ?>

<?=$hide_password_s   ?>
    <tr> 
      <td colspan="3" height="5"></td>
    </tr>
    <tr> 
      <td width="60" align="right"><b>비밀번호</b></td>
      <td></td>
      <td> 
        <input type="password" name="password" class="textarea_01" size="20">
        &nbsp;(비회원의경우 패스워드를 입력하지 않으면 글수정 및 삭제를 하실 수 없습니다.)</td>
    </tr>
<?=$hide_password_e   ?>

    <tr> 
      <td height="30" align="right" colspan="3"></td>
    </tr>
  </table>
  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" align='center'>
    <tr> 
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="81"><?=$a_list?><img src="<?=$skinDir?>images/button_list.gif" width="81" height="40" border='0'></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif">&nbsp;</td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="50"><input type='image' src="<?=$skinDir?>images/button_write.gif" width="50" height="40"></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="59"><?=$a_cancle?><img src="<?=$skinDir?>images/button_cancel.gif" width="59" height="40" border='0'></td>
    </tr>
</form>
  </table>
