<?php
$addStyle = "on";
// 비즈니스정보
if ( $sub == 'biz' ) {
?>
	<table width='100%' border='0' cellspacing='0' cellpadding='0'
		align='center'>
		<tr>
			<td align='center'><img src='/images/submenu/10800.jpg' border='0'></td>
		</tr>
		<tr height='1'>
			<td align='center'><a href='<?=JP_BIZ_URL.'&mode=index'?>'><img
					src='/images/submenu/10801_<?=$mode == 'index' ?'on':'off'?>.jpg' border='0' alt='ビジネスマッチング紹介'> </a>
			</td>
		</tr>
		<tr height='1'>
			<td align='center'><a href='<?=JP_BIZ_URL.'&mode=biz_consult_list'?>'><img
					src='/images/submenu/10802_<?=$mode == 'biz_consult_list' ?'on':'off'?>.jpg' border='0' alt='韓国企業ビジネス情報'> </a>
			</td>
		</tr>
		<tr height='1'>
			<td align='center'><a href='<?=JP_BIZ_URL.'&mode=jp_company_write'?>'><img
					src='/images/submenu/10803_<?=$mode == 'jp_company_write' ?'on':'off'?>.jpg' border='0' alt='協力希望日本企業申し込み'>
			</a>
			</td>
		</tr>
		<!--tr>
				<td height='109'><img src='./images/submenu/footer.jpg' border='0'></td>
			</tr-->
	</table>


<?
// 기술자정보
} else if ( $sub == 'engineer' ) {
?>
  <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr>
          <td align='center'><img src='/images/submenu/10700.jpg' border='0'></td>
        </tr>
        <tr height='1'>
		<td align='center'><a href='<?=JP_ENGINEER_URL.'&mode=index'?>'><img
				src='/images/submenu/10701_<?=$mode == 'index' ?'on':'off'?>.jpg' border='0' alt='技術者マッチングス紹介'>
		</a>
		</td>
		</tr>
		<tr height='1'>
		<td align='center'><a href='/sub.php?flashmenu=10702'><img src='/images/submenu/10702_off.jpg' border='0' alt='技術者検索'></a>
		</td>
		</tr>
		<tr height='1'><td align='center'><a
			href='<?=JP_ENGINEER_URL.'&mode=jp_engineer_write'?>'><img
				src='/images/submenu/10703_<?=$mode == 'jp_engineer_write' ?'on':'off'?>.jpg' border='0' alt='技術者申込み'>
		</a>
		</td></tr>
		<!--tr>
			<td height='109'><img src='./images/submenu/footer.jpg' border='0'></td>
		</tr-->
       </table>
<?
// 기술정보
} else if ( $sub == 'tech' ) {
?>

<table width='100%' border='0' cellspacing='0' cellpadding='0'
	align='center'>
	<tr>
		<td align='center'><img src='/images/submenu/10900.jpg' border='0'></td>
	</tr>
	<tr height='1'>
		<td align='center'><a href='<?=JP_TECH_URL.'&mode=index'?>'><img
				src='/images/submenu/10901_<?=$mode == 'index' ?'on':'off'?>.jpg' border='0' alt='技術マッチング紹介'> </a>
		</td>
	</tr>
	<tr height='1'>
		<td align='center'><a href='<?=JP_TECH_URL.'&mode=tech_need_list'?>'><img
				src='/images/submenu/10902_<?=$mode == 'tech_need_list' ?'on':'off'?>.jpg' border='0' alt='技術ニーズ'></a></td>
	</tr>
	<tr height='1'>
		<td align='center'><a href='<?=JP_TECH_URL.'&mode=tech_seed_write'?>'><img
				src='/images/submenu/10903_<?=$mode == 'tech_seed_write' ?'on':'off'?>.jpg' border='0' alt='技術シーズ登録'></a>
		</td>
	</tr>
	<tr height='1'>
		<td align='center'><a href='/sub.php?flashmenu=10904'><img
				src='/images/submenu/10904_off.jpg' border='0' alt='技術シード'> </a></td>
	</tr>
	<!--tr>
			<td height='109'><img src='./images/submenu/footer.jpg' border='0'></td>
		</tr-->
</table>
<?
}
?>
