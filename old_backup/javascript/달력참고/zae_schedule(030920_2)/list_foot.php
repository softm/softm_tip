</table>
<table border=0 cellspacing=1 cellpadding=1 width=100%>
<tr>
<td align=left><?=$a_prev_page?><img src=<?=$dir?>/year_prev.gif border=0></a> <?=$print_page?> <?=$a_next_page?><img src=<?=$dir?>/year_next.gif border=0></a>
</td>
 <td height=20 nowrap> 
</td>
 <td align=right width=40%>
  <?=$a_list?><img src=<?=$dir?>/images/i_list.gif border=0 align=absmiddle></a>
  <?=$a_delete_all?><img src=<?=$dir?>/images/i_delete.gif border=0 align=absmiddle></a>
 </td>
</tr>
</table>
</form>
		</td>
	</tr>
</table>
<!-- 검색폼 부분 ---------------------->
<!-- 폼태그 부분;; 수정하지 않는 것이 좋습니다 -->
<form method=post name=search action=<?=$PHP_SELF?>>
<input type=hidden name=page value=<?=$page?>>
<input type=hidden name=id value=<?=$id?>>
<input type=hidden name=select_arrange value=<?=$select_arrange?>>
<input type=hidden name=desc value=<?=$desc?>>
<input type=hidden name=page_num value=<?=$page_num?>>
<input type=hidden name=selected>
<input type=hidden name=exec>
<input type=hidden name=sn value="<?=$sn?>">
<input type=hidden name=ss value="<?=$ss?>">
<input type=hidden name=sc value="<?=$sc?>">
<input type=hidden name=category value="<?=$category?>">
<!----------------------------------------------->
<table border=0 width=<?=$width?> cellspcing=0 cellpadding=0>
<tr>
 <td colspan=0 align=center>
 <a href="javascript:OnOff('sn')"><img src=<?=$dir?>/name_<?=$sn?>.gif border=0 name=sn align=absmiddle></a>
    <a href="javascript:OnOff('ss')"><img src=<?=$dir?>/subject_<?=$ss?>.gif border=0 name=ss align=absmiddle></a>
    <a href="javascript:OnOff('sc')"><img src=<?=$dir?>/content_<?=$sc?>.gif border=0 name=sc align=absmiddle></a>
   <img src=<?=$dir?>/images/search_left.gif align=absmiddle><input type=text name=keyword value="<?=$keyword?>" <?=size(15)?> class=input style=font-size:8pt;font-family:Arial;vertical-align:top;border-left-color:#ffffff;border-right-color:#ffffff;border-top-color:<?=$sC_search?>;border-bottom-color:<?=$sC_search?>;height:18px;><input type=image border=0 align=absmiddle src=<?=$dir?>/images/search_right.gif><?=$a_cancel?><img src=<?=$dir?>/images/search_right2.gif align=absmiddle border=0></a>
 </td>
</form>
</tr>
<tr>
 <td colspan=0 align=center class=orangered>
 </td>
</tr>

<!-- 페이지 출력 ---------------------->
</form>
</table>

