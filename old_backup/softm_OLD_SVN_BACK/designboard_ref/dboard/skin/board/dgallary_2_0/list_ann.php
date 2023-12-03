<table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
    <tr> 
<?=$show_admin_yn_s?><?// chk값은 어드민 계정을 이용한 자료 이동및 관리를 위해 사용됩니다.
                       // 1. checkbox 이름 ::> chk 
                       // 2. value         ::> $no ?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center"> 
        <input type="checkbox" name="chk" value="<?=$admin_no?>">
      </td>
<?=$show_admin_yn_e?>

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

<?=$hide_file1_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center">
      <?=$a_file1?><img src="<?=$skinDir?>images/icon_file.gif" width="11" height="13" border='0'></a>
      </td>
<?=$hide_file1_e?>

<?=$hide_down_hit1_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center" class="text_02"><?=$down_hit1?></td>
<?=$hide_down_hit1_e?>

<?=$hide_hit_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_notice.gif" width="40" align="center" class="text_02"><?=$hit?></td>
<?=$hide_hit_e?>

    </tr>
      </table>