<form onSubmit='return pollWriteCommentData(this);' name='writeForm' method='post'>
<?// ���� �Ұ�?>
    <input type="hidden" name="poll_id" value='<?=$poll_id?>'>
<?////////////////////////////////////////////////?>
                    <tr> 
                      <td class="text_01">
<?=$hide_name_s?>
                        �̸� 
                        <input type="text" name="name" size="12" value='<?=$name?>'>
<?=$hide_name_e?>

<?=$hide_password_s?>
                        ��й�ȣ
                        <input type="password" name="password" size="12" value=''>
<?=$hide_password_e?>
</td>
</tr>

<tr>
 <td class="text_01">
                        �ǰ� 
                        <input type="text" name="memo" size="35" style="width:80%">
                        <input type=image src="<?=$skinDir?>images/button_ok.gif" align=absmiddle>
                      </td>
                    </tr>
</form>