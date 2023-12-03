<table width="350" border="0" cellpadding="0" cellspacing="0" class="text_02">
    <tr> 
        <td width="102" height=102 align=center background='<?=$skinDir?>images/bg.gif'>
<?
if ( $file_preview1 ) {
?><?=$a_file1_popup?><?=$file_preview1?></a></td>
<?
} else {
?><img src='<?=$skinDir?>images/no_picture.gif' border='0'></td>
<?
}
?>

    <td width="20">&nbsp;</td>
    <td valign="top">
    
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="text_01">
    <tr> 
    <td>
         <?=$hide_category_s?>[<?=$cat_name?>]<?=$hide_category_e?><?=$a_view?><?=$title?></a>
        <?=$total_comment?>
        <?=$hide_comment_icon_s?><?=$new_comment_tag?><?=$hide_comment_icon_e?>
        <?=$hide_new_s?><img src="<?=$skinDir?>images/icon_new.gif"><?=$hide_new_e?>

    </td>
    </tr>
    <tr><td height="3"></td></tr>
    <tr><td height="1" background="<?=$skinDir?>images/dot.gif"></td></tr>
    <tr><td height="7"></td></tr>
    <tr><td class="text_01"><?=$content?>
    </td></tr>
    </table>
    
    </td>
    </tr>
    <tr><td height="20" colspan="3" valign="top">&nbsp;</td></tr>
</table>