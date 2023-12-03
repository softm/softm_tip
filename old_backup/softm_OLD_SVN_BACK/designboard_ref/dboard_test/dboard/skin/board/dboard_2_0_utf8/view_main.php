  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
    <tr> 
      <td height="3" background="<?=$skinDir?>images/bg_view_top2.gif" colspan="4"></td>
    </tr>
    <tr> 
      <td align="right" height="1" colspan="4"></td>
    </tr>
    <tr> 
      <td height="10" bgcolor="f2f2f2" colspan="2"></td>
      <td height="5" colspan="2"></td>
    </tr>

    <tr> 
      <td align="right" height="10" bgcolor="f2f2f2" width="130"><b>이 름</b></td>
      <td width="10" height="10" bgcolor="f2f2f2">&nbsp;</td>
      <td width="10" height="10"></td>
      <td height="10">
      <?=$character?>
      <?=$a_member_layer_box?><?=$name?></a></td>
    </tr>
    <tr> 
      <td align="right" height="8" bgcolor="f2f2f2" colspan="2"></td>
      <td height="8" colspan="2"></td>
    </tr>
<?=$hide_home_s  ?>
    <tr> 
      <td align="right" height="10" bgcolor="f2f2f2"><b>홈페이지</b></td>
      <td height="10" bgcolor="f2f2f2">&nbsp;</td>
      <td height="10"></td>
      <td height="10"><?=$a_home?><?=$home?></a></td>
    </tr>
    <tr> 
      <td align="right" height="8" bgcolor="f2f2f2" colspan="2"></td>
      <td height="8" colspan="2"></td>
    </tr>
<?=$hide_home_e  ?>

<?=$hide_file1_s  ?>
    <tr> 
      <td align="right" height="10" bgcolor="f2f2f2"><b>첨부파일</b></td>
      <td height="10" bgcolor="f2f2f2">&nbsp;</td>
      <td height="10"></td>
      <td height="10" class="text_03"><?=$a_file1?><?=$f_name1?> (<?=$f_size1?>)</a> - download : <?=$down_hit1?></td>
    </tr>
    <tr> 
      <td align="right" height="8" bgcolor="f2f2f2" colspan="2"></td>
      <td height="8" colspan="2"></td>
    </tr>
<?=$hide_file1_e       ?>

<?=$hide_file2_s       ?>
    <tr> 
      <td align="right" height="10" bgcolor="f2f2f2"><b>첨부파일</b></td>
      <td height="10" bgcolor="f2f2f2">&nbsp;</td>
      <td height="10"></td>
      <td height="10" class="text_03"><?=$a_file2?><?=$f_name2?> (<?=$f_size2?>)</a> - download : <?=$down_hit2?></td>
    </tr>
    <tr> 
      <td align="right" height="8" bgcolor="f2f2f2" colspan="2"></td>
      <td height="8" colspan="2"></td>
    </tr>
<?=$hide_file2_e  ?>


<?=$hide_link1_s ?>
    <tr> 
      <td align="right" height="10" bgcolor="f2f2f2"><b>링크1</b></td>
      <td height="10" bgcolor="f2f2f2">&nbsp;</td>
      <td height="10"></td>
      <td height="10" class="text_03"><?=$a_link1?><?=$link1?></a></td>
    </tr>
    <tr> 
      <td align="right" height="8" bgcolor="f2f2f2" colspan="2"></td>
      <td height="8" colspan="2"></td>
    </tr>
<?=$hide_link1_e ?>

<?=$hide_link2_s ?>
    <tr> 
      <td align="right" height="10" bgcolor="f2f2f2"><b>링크2</b></td>
      <td height="10" bgcolor="f2f2f2">&nbsp;</td>
      <td height="10"></td>
      <td height="10" class="text_03"><?=$a_link2?><?=$link2?></a></td>
    </tr>
    <tr> 
      <td align="right" height="8" bgcolor="f2f2f2" colspan="2"></td>
      <td height="8" colspan="2"></td>
    </tr>
<?=$hide_link2_e ?>

    <tr> 
      <td align="right" height="10" bgcolor="f2f2f2"><b>제 목</b></td>
      <td height="10" bgcolor="f2f2f2">&nbsp;</td>
      <td height="10"></td>
      <td height="10"><?=$hide_category_s?>[<?=$cat_name?>]</a><?=$hide_category_e?> <?=$title?></td>
    </tr>
    <tr> 
      <td align="right" height="10" bgcolor="f2f2f2" colspan="2"></td>
      <td height="10" colspan="2"></td>
    </tr>
    <tr> 
      <td height="1" colspan="4"></td>
    </tr>
    <tr> 
      <td background="<?=$skinDir?>images/bg_view_top.gif" height="3" colspan="4"></td>
    </tr>
  </table>
  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center' style="table-layout:fixed;">
    <tr> 
      <td height="20"></td>
    </tr>
    <tr> 
      <td>
        <!------- 이미지 자동 크기 조절을 위해 필요합니다. ------------>
        <img src='<?=$baseDir?>images/timg.gif' width='100%' height='0' id='_dboard_image_limit_width'>
        <!------- 삭제할 경우 이미지 크기 자동 조절이 안됩니다. ------->
        <?=$a_file1_popup?><?=$file_preview1?></a>
      </td>
    </tr>
    <tr> 
      <td>
        <?=$a_file2_popup?><?=$file_preview2?></a>
      </td>
    </tr>

    <tr> 
      <td>
		<?=$a_link1_popup?><?=$link_preview1?></a>
      </td>
    </tr>
    <tr> 
      <td>
		<?=$a_link2_popup?><?=$link_preview2?></a>
      </td>
    </tr>
    <tr> 
      <td style='word-break:break-all'> 
        <?=$content?>
      </td>
    </tr>
    <tr> 
      <td height="20" align="right"></td>
    </tr>
    <tr> 
      <td height="20" align="right" class="text_04">작성시간 : <?=$reg_year?>.<?=$reg_month?>.<?=$reg_day?> / <?=$reg_hour?>:<?=$reg_min?>:<?=$reg_sec?></td>
    </tr>
    <tr> 
      <td height="30" align="right">&nbsp;</td>
    </tr>
  </table>
  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" align='center'>
    <tr> 
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif"><?=$a_list     ?><img src="<?=$skinDir?>images/button_list.gif"   width="81" height="40" border='0'></a><?=$a_pre_view ?><img src="<?=$skinDir?>images/button_pre_t.gif"  width="58" height="40" border='0'></a><?=$a_next_view?><img src="<?=$skinDir?>images/button_next_t.gif" width="58" height="40" border='0'></a></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif">&nbsp;</td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" align='right'><?=$a_answer    ?><img src="<?=$skinDir?>images/button_reply.gif"  width="58" height="40" border='0'></a><?=$a_update    ?><img src="<?=$skinDir?>images/button_modify.gif" width="50" height="40" border='0'></a><?=$a_delete    ?><img src="<?=$skinDir?>images/button_delete.gif" width="50" height="40" border='0'></a></td>
    </tr>
  </table>