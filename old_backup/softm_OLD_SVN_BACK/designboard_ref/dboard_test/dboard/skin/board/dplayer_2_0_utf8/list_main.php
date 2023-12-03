<table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
	<tr> 

      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center"> 
        <input type="checkbox" name="chk" value="<?=$admin_no?>" onClick=''>
      </td>

<?=$hide_no_s      ?>
      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02">
      <?=$no?>
      </td>
<?=$hide_no_e      ?>

      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif">
      &nbsp;&nbsp;

        <?=$hide_category_s     ?><?=$a_cat_search?>[<?=$cat_name?>]</a><?=$hide_category_e     ?>
        <?=$a_single_play?><?=$title?></a>
        <?=$total_comment?>
        <?=$hide_comment_icon_s?><?=$new_comment_tag?><?=$hide_comment_icon_e?>

        <?=$hide_new_s?><img src="<?=$skinDir?>images/icon_new.gif"><?=$hide_new_e?>

        <?=$hide_open_s?><img src='<?=$skinDir?>images/icon_sec.gif' border='0'><?=$hide_open_e?>
      </td>

<?=$hide_name_s    ?>
      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="100" align="center">
      <?=$a_e_mail?><?=$name?></a>
      </td>
<?=$hide_name_e    ?>

<?=$hide_reg_date_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="70" align="center" class="text_02">
      <?=$reg_year?>.<?=$reg_month?>.<?=$reg_day?>
      </td>
<?=$hide_reg_date_e?>

	  <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02"><?=$a_single_add_cart?>담기</a></td>
      
	  <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02"><?=$a_single_del_cart?>빼기</a></td>
     
	  <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02"><?=$a_single_play?>듣기</a></td>

<?=$hide_hit_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02"><?=$down_hit1?></td>
<?=$hide_hit_e?>

<?=$show_admin_yn_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02">
	  <?=$a_update    ?>수정</a></td>
<?=$show_admin_yn_e?>
    </tr>
	  </table>