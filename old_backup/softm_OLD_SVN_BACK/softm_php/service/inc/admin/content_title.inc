<?php
$imageName = "title_12002.jpg";
$titleName = "Home &nbsp;>&nbsp; " . $sub;
if ( $sub == '' && $mode=='index' ) {
	$imageName="title_12000.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자"    ;
} else if ( $sub == 'member' && $mode=='list' && !$_GET['p_user_level'] ) { 
	$imageName="title_12002.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 일반회원관리"    ;
} else if ( $sub == 'member' && $mode=='list' && $_GET['p_user_level']==2 ) { 
	$imageName="title_12003.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 기업회원관리"    ;
} else if ( $sub == 'biz' && $mode=='biz_consult_list' ) { 
	$imageName="title_12007.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 비즈니스상담"    ;
} else if ( $sub == 'biz' && $mode=='biz_match_list' ) { 
	$imageName="title_12008.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 비즈니스매칭"    ;
} else if ( $sub == 'engineer' && $mode=='engineer_consult_list' ) { 
	$imageName="title_12009.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 기술자매칭"    ;
} else if ( $sub == 'tech' && $mode=='tech_seed_consult_list' ) { 
	$imageName="title_12010.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 기술매칭"    ;
} else if ( $sub == 'company' && $mode=='jp_company_list' ) { 
	$imageName="title_12011.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 일본기업관리"    ;
} else if ( $sub == 'engineer' && $mode=='engineer_list' ) { 
	$imageName="title_12012.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 일본기술자정보관리"    ;
} else if ( $sub == 'tech' && $mode=='tech_need_list' ) { 
	$imageName="title_12013.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 한국기업니즈관리"    ;
} else if ( $sub == 'tech' && $mode=='tech_seed_list' ) { 
	$imageName="title_12014.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 일본기업시드관리"    ;
} else if ( $sub == 'engineer' && $mode=='jp_engineer_list' ) { 
	$imageName="title_12015.jpg"; $titleName = "Home &nbsp;>&nbsp; 관리자 &nbsp;>&nbsp; 일본기술자관리"    ;
}
?>
      <table width='700' border='0' cellspacing='0' cellpadding='0'>
        <tr>
			<td><img src='/images/title_bar/<?=$imageName?>' border='0'></td>
			<td height='30' style='font-size:11px;font-family:dotum;color:#999999;text-align:right;'> <img src='/images/ico_n.jpg' align=''> <?=$titleName?></td>
        </tr>
      </table>
