<table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
	<tr> 

      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center"> 
        <input type="checkbox" name="chk" value="<?=$admin_no?>">
      </td>

<?=$hide_no_s      ?>
        <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center"><font face="tahoma" size="1" color="659708"><b>notice</b></font></td>
<?=$hide_no_e      ?>

      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif">
      &nbsp;&nbsp;<?=$a_view?><?=$title?></a>
        <?=$total_comment?>
        <?=$hide_comment_icon_s?><?=$new_comment_tag?><?=$hide_comment_icon_e?>
        <?=$hide_new_s?>&nbsp;&nbsp;<img src="<?=$skinDir?>images/icon_new.gif"><?=$hide_new_e?>
      </td>
<?=$hide_name_s    ?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="100" align="center">
      <?=$a_e_mail?><?=$name?></a>
      </td>
<?=$hide_name_e    ?>

<?=$hide_reg_date_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="70" align="center" class="text_02">
      <?=$reg_year?>.<?=$reg_month?>.<?=$reg_day?>
      </td>
<?=$hide_reg_date_e?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center"></td>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center"></td>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center"></td>
<?=$hide_hit_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center" class="text_02"><?=$hit?></td>
<?=$hide_hit_e?>

<?=$show_admin_yn_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center" class="text_02">
	  </td>
<?=$show_admin_yn_e?>
    </tr>
	</table>