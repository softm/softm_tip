<?php
// echo $sub . "/" . $mode . "/" . $_GET['p_user_level'];
?>
       <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr>
          <td align='center'><img src='/images/submenu/12000.jpg' border='0'></td>
        </tr>
<tr height='1'><td align='center'><a href='/sub.php?flashmenu=12001'><img src='/images/submenu/12001_off.jpg' border='0' alt='기본정보설정'></a></td></tr>
<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=member&mode=list'><img src='/images/submenu/12002_<?=$sub == 'member' && $mode=='list' && !$_GET['p_user_level']?'on':'off'?>.jpg' border='0' alt='일반회원관리'></a></td></tr>
<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=member&mode=list&p_user_level=2'><img src='/images/submenu/12003_<?=$sub == 'member' && $mode=='list' && $_GET['p_user_level']==2?'on':'off'?>.jpg' border='0' alt='기업회원관리'></a></td></tr>
<tr height='1'><td align='center'><a href='/sub.php?flashmenu=12004'><img src='/images/submenu/12004_off.jpg' border='0' alt='게시판설정'></a></td></tr>
<tr height='1'><td align='center'><a href='/sub.php?flashmenu=12005'><img src='/images/submenu/12005_off.jpg' border='0' alt='팝업관리'></a></td></tr>
<tr height='1'><td align='center'><a href='/sub.php?flashmenu=12006'><img src='/images/submenu/12006_off.jpg' border='0' alt='배너관리'></a></td></tr>

<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=biz&mode=biz_consult_list'><img src='/images/submenu/12007_<?=$sub == 'biz' && $mode=='biz_consult_list'?'on':'off'?>.jpg' border='0' alt='비즈니스상담'></a></td></tr>
<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=biz&mode=biz_match_list'><img src='/images/submenu/12008_<?=$sub == 'biz' && $mode=='biz_match_list'?'on':'off'?>.jpg' border='0' alt='비즈니스매칭'></a></td></tr>

<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=engineer&mode=engineer_consult_list'><img src='/images/submenu/12009_<?=$sub == 'engineer' && $mode=='engineer_consult_list'?'on':'off'?>.jpg' border='0' alt='기술자매칭'></a></td></tr>
<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=tech&mode=tech_seed_consult_list'><img src='/images/submenu/12010_<?=$sub == 'tech' && $mode=='tech_seed_consult_list'?'on':'off'?>.jpg' border='0' alt='기술매칭'></a></td></tr>

<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=company&mode=jp_company_list'><img src='/images/submenu/12011_<?=$sub == 'company' && $mode=='jp_company_list'?'on':'off'?>.jpg' border='0' alt='일본기업관리'></a></td></tr>
<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=engineer&mode=engineer_list'><img src='/images/submenu/12012_<?=$sub == 'engineer' && $mode=='engineer_list'?'on':'off'?>.jpg' border='0' alt='일본기술자정보관리'></a></td></tr>

<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=tech&mode=tech_need_list'><img src='/images/submenu/12013_<?=$sub == 'tech' && $mode=='tech_need_list'?'on':'off'?>.jpg' border='0' alt='한국기업니즈관리'></a></td></tr>
<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=tech&mode=tech_seed_list'><img src='/images/submenu/12014_<?=$sub == 'tech' && $mode=='tech_seed_list'?'on':'off'?>.jpg' border='0' alt='일본기업시드관리'></a></td></tr>
<tr height='1'><td align='center'><a href='<?=ADMIN_URL?>?sub=engineer&mode=jp_engineer_list'><img src='/images/submenu/12015_<?=$sub == 'engineer' && $mode=='jp_engineer_list'?'on':'off'?>.jpg' border='0' alt='일본기술자관리'></a></td></tr>
		<tr>
			<td height='109'><img src='/images/submenu/footer.jpg' border='0'></td>
		</tr>
       </table>
 