<?
if ( $tr_tmp != 0 ) {
    for ( $i=1; $i<= $list_width_many - $tr_tmp;$i++) {
?>
        <td>
        <table width="92" height="92" border="0" cellpadding="0" cellspacing="1" bgcolor="E3E3E3">
            <tr> 
            <td bgcolor="F9F9F9">&nbsp;</td>
            </tr>
        </table>
        </td>
<?
    }
    echo "</tr>";
}
?>
</table>
<SCRIPT LANGUAGE="JavaScript">
<!--
/* *************** 삭제 불가 *************** */
    if ( ( typeof ( list_image_display_mode ) != 'undefined' && list_image_display_mode == '1' ) ||
         ( typeof ( view_image_display_mode ) != 'undefined' && view_image_display_mode == '1' ) ) { // 자동 사이즈 조정
        imageAutoResize ();
    }
/* *************** 삭제 불가 *************** */
//-->
</SCRIPT>