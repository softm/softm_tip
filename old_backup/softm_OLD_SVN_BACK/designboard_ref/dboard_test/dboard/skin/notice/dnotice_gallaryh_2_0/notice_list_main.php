<?
$tr_tmp++;
?>
<?
    if ( $tr_tmp == 1 ) {
        echo "$notice_tot <tr>";
    }
?>
    <td width="<?=$list_image_width ?>" height="<?=$list_image_height?>">
<!------- 이미지 자동 크기 조절을 위해 필요합니다. ------------>
<table width='<?=$list_image_width ?>' border='0' cellspacing='0' cellpadding='0'><tr><td><img src='<?=$skinDir?>images/timg.gif' width='100%' height='0' id='_dboard_image_limit_width'></td></tr></table>
<!------- 삭제할 경우 이미지 크기 자동 조절이 안됩니다. ------->
<?
    if ( $file_preview1 ) {
?>
    <table width="92" height="92" border="0" cellpadding="0" cellspacing="1" bgcolor="E3E3E3">
        <tr> 
        <td bgcolor="F9F9F9"><?=$a_file1_popup?><?=$file_preview1?></a></td>
        </tr>
    </table>
<?
    } else {
?>
    <table width="92" height="92" border="0" cellpadding="0" cellspacing="1" bgcolor="E3E3E3">
        <tr> 
        <td bgcolor="F9F9F9"><img src='<?=$skinDir?>images/no_picture.gif' border='0' width="<?=$list_image_width ?>" height="<?=$list_image_height?>"></td>
        </tr>
    </table>
<?
    }
?>
    </td>
<?
    if ( $tr_tmp == $list_width_many ) {
        echo "</tr>";
        $tr_tmp = 0;
    }
?>
