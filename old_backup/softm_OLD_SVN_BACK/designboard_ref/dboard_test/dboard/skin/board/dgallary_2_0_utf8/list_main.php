<table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>    
    <tr> 
<?=$show_admin_yn_s?><?// chk값은 어드민 계정을 이용한 자료 이동및 관리를 위해 사용됩니다.
                       // 1. checkbox 이름 ::> chk 
                       // 2. value         ::> $no ?>
      <td height="50" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center"> 
        <input type="checkbox" name="chk" value="<?=$admin_no?>">
      </td>
<?=$show_admin_yn_e?>

<?=$hide_no_s      ?>
      <td height="50" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02">
      <?=$print_no?>
      </td>
<?=$hide_no_e      ?>

<td width=50 height="50" background="<?=$skinDir?>images/bg_list_main.gif">
<?
if ( $file_preview1 ) {
?>
                <?=$a_file1_popup?><?=$file_preview1?></a></td>
<?
} else {
?>
                <img src='<?=$skinDir?>images/no_picture.gif' border='0'></td>
<?
}
?>
</td>

<td height="30" background="<?=$skinDir?>images/bg_list_main.gif">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
<tr>
<td>&nbsp;&nbsp;<?=$hide_category_s?><?=$a_cat_search?>[<?=$cat_name?>]</a><?=$hide_category_e     ?>
</td>
</tr>
<tr>
<td>&nbsp;&nbsp;<?=$a_view?><?=$title?></a>
    <?=$total_comment?>
    <?=$hide_comment_icon_s?><?=$new_comment_tag?><?=$hide_comment_icon_e?>
    <?=$hide_new_s?><img src="<?=$skinDir?>images/icon_new.gif"><?=$hide_new_e?>
    <?=$hide_open_s?><img src='<?=$skinDir?>images/icon_sec.gif' border='0'><?=$hide_open_e?>
</td>
</tr>
</table>



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

<?=$hide_file1_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center">
      <?=$a_file1?><img src="<?=$skinDir?>images/icon_file.gif" width="11" height="13" border='0'></a>
      </td>
<?=$hide_file1_e?>

<?=$hide_down_hit1_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02"><?=$down_hit1?></td>
<?=$hide_down_hit1_e?>

<?=$hide_hit_s?>
      <td height="30" background="<?=$skinDir?>images/bg_list_main.gif" width="40" align="center" class="text_02"><?=$hit?></td>
<?=$hide_hit_e?>

    </tr>
      </table>