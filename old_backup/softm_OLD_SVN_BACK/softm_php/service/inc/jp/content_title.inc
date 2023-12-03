<?php
$imageName = "title_11902.jpg";
$titleName = "일반회원관리";
$titleName = "Home &nbsp;>&nbsp; " . $sub;
if ( $sub == 'biz' ) { // 비즈니스정보
	$imageName="title_10801.jpg";
	if      ( $mode == 'index'     ) {
		$imageName="title_10801.jpg";		
		$titleName = "Home &nbsp;>&nbsp; ビジネス情報 &nbsp;>&nbsp; ビジネスマッチング紹介" ;
	}
	else if ( $mode == 'biz_consult_list'    ) {
		$imageName="title_10802.jpg";		
		$titleName = "Home &nbsp;>&nbsp; ビジネス情報 &nbsp;>&nbsp; 韓国企業ビジネス情報" ;
	}
	else if ( $mode == 'jp_company_write'      ) {
		$imageName="title_10803.jpg";		
		$titleName = "Home &nbsp;>&nbsp; ビジネス情報 &nbsp;>&nbsp; 協力希望日本企業申し込み" ;
	}
} else if ( $sub == 'engineer' ) { // 기술자정보
	$imageName="title_10701.jpg";
	if      ( $mode == 'index'     ) {
		$imageName="title_10701.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 技術者情報 &nbsp;>&nbsp; 技術者マッチングス紹介" ;
	}
	else if ( $mode == 'jp_engineer_write'    ) {
		$imageName="title_10703.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 技術者情報 &nbsp;>&nbsp; 技術者申込み" ;
	}
} else if ( $sub == 'tech' ) { // 기술정보
	$imageName="title_10901.jpg";
	if      ( $mode == 'index' ) {
		$imageName="title_10901.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 技術情報 &nbsp;>&nbsp; 技術マッチング紹介" ;
	}
	else if ( $mode == 'tech_need_list'    ) {
		$imageName="title_10902.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 技術情報 &nbsp;>&nbsp; 技術ニーズ" ;
	}
	else if ( $mode == 'tech_seed_write'    ) {
		$imageName="title_10903.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 技術情報 &nbsp;>&nbsp; 技術シーズ登録" ;
	}
}
?>
      <table width='700' border='0' cellspacing='0' cellpadding='0'>
        <tr>
			<td><img src='/images/title_bar/<?=$imageName?>' border='0'></td>
			<td height='30' style='font-size:11px;font-family:dotum;color:#999999;text-align:right;'> <img src='/images/ico_n.jpg' align=''> <?=$titleName?></td>
        </tr>
      </table>
