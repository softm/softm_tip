


  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" class="text_01" align='center'>
    <tr> 
      <td height="50" class="text_03">
<?
// ������ �� ����
// $page_tab['pre'      ] = "[���� $page_many]";
// $page_tab['next'     ] = "[���� $page_many]";
   $page_tab['pre'      ] = '<img src="' . $skinDir . 'images/icon_prev.gif" width="17" height="16" align="absmiddle" border="0">&nbsp;';
   $page_tab['next'     ] = '&nbsp;<img src="' . $skinDir . 'images/icon_next.gif" width="17" height="16" align="absmiddle" border="0">';
   $page_tab['pre_1'    ] = "" ; // ����
   $page_tab['next_1'   ] = "" ; // ����

   $page_tab['page_sep' ] = "" ; // ���������� ��ȣ
   $page_tab['page_start']= " ["; // ������ ǥ�� ���� [1] <<-- [
   $page_tab['page_end' ] = "] "; // ������ ǥ�� ��   [1] <<-- ]
   $page_tab['page_pre' ] = "" ; // ������ �� [*����* 1]
   $page_tab['page_next' ]= "" ; // ������ �� [1 *����*]
   $page_tab['page_start_active'] = "<b>"; // ���� ������ ���� �±�
   $page_tab['page_end_active'  ] = "</b>"             ; // ���� ������ ���� �±�
?>
<?=_pageTab ( $s, $tot, $how_many, $more_many, $page_many, $HTTP_SERVER_VARS['PHP_SELF'], $page_tab )?>
     </td>
      <td align="right" width="300"> 
<?=$hide_search_s?>

        <table border="0" cellspacing="0" cellpadding="0">
<form name='searchForm' method='POST' onSubmit='return searchFormSubmit(this);'>
          <tr> 
            <td height="1"></td>
            <td rowspan="2">
              <input type="text" name="<?=$search_word?>" class="textarea_01" value='<?=$search?>'>
              <input type='image' src="<?=$skinDir?>images/search.gif" width="39" height="19" align="absmiddle">
            </td>
          </tr>
          <tr> 
            <td width="55"> 
            <select name="<?=$search_condition?>" class="listbox_01">
            <option value=''        >��ü</option>
            <option value='name'    >�̸�</option>
            <option value='title'   >����</option>
            <option value='content' >����</option>
            </select>
            </td>
          </tr>
</form>
        </table>
<?=$hide_search_e?>
      </td>
    </tr>
  </table>
  <table width="<?=$table_width?>" border="0" cellspacing="0" cellpadding="0" align='center'>
    <tr> 
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="81"><?=$a_list     ?><img src="<?=$skinDir?>images/button_list.gif" width="81" height="40" border='0'></a></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="76"><?=$a_pre_list ?><img src="<?=$skinDir?>images/button_pre.gif"  width="76" height="40" border='0'></a></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="76"><?=$a_next_list?><img src="<?=$skinDir?>images/button_next.gif" width="76" height="40" border='0'></a></td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif">&nbsp;</td>
      <td height="40" background="<?=$skinDir?>images/bg_list_bottom.gif" width="50"><?=$a_insert?><img src="<?=$skinDir?>images/button_write.gif" width="50" height="40" border='0'></a></td>
    </tr>
  </table>