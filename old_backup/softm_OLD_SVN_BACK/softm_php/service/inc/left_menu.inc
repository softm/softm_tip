<?php
$addStyle = "on";
if ( $sub == 'member' ) {
?>

       <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr>
          <td align='center'><img src='/images/submenu/11900.jpg' border='0'></td>
        </tr>
        <tr height='1'><td align='center'>
<tr height='1'><td align='center'><a href='<?=MEMBER_UPD_URL?>'                             ><img src='/images/submenu/11901_<?=$mode == 'member_upd'               ?'on':'off'?>.jpg' border='0' alt='회원정보수정'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=company_write'?>"           ><img src='/images/submenu/11902_<?=$mode == 'company_write'            ?'on':'off'?>.jpg' border='0' alt='기업정보수정'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=biz_consult_list'?>"        ><img src='/images/submenu/11903_<?=$mode == 'biz_consult_list'         ?'on':'off'?>.jpg' border='0' alt='비즈니스상담'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=biz_match_list'?>"          ><img src='/images/submenu/11904_<?=$mode == 'biz_match_list'           ?'on':'off'?>.jpg' border='0' alt='비즈니스매칭'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=engineer_consult_list'?>"   ><img src='/images/submenu/11905_<?=$mode == 'engineer_consult_list'    ?'on':'off'?>.jpg' border='0' alt='기술자매칭'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=tech_need_list'?>"          ><img src='/images/submenu/11906_<?=$mode == 'tech_need_list'           ?'on':'off'?>.jpg' border='0' alt='기술니즈신청'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=tech_seed_consult_list'?>"  ><img src='/images/submenu/11907_<?=$mode == 'tech_seed_consult_list'   ?'on':'off'?>.jpg' border='0' alt='기술시드매칭신청'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=interest_company_list'?>"   ><img src='/images/submenu/11908_<?=$mode == 'interest_company_list'    ?'on':'off'?>.jpg' border='0' alt='관심기업'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=interest_engineer_list'?>"  ><img src='/images/submenu/11909_<?=$mode == 'interest_engineer_list'   ?'on':'off'?>.jpg' border='0' alt='관심기술자'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=member_secession'?>"        ><img src='/images/submenu/11910_<?=$mode == 'member_secession'         ?'on':'off'?>.jpg' border='0' alt='회원탈퇴'></a></td></tr>
		</td></tr>
		<tr>
			<td height='109'><img src='/images/submenu/footer.jpg' border='0'></td>
		</tr>

       </table>
<?
// 마이페이지정보
} else if ( $sub == 'mypage' ) {
?>

      <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr>
          <td align='center'><img src='/images/submenu/11900.jpg' border='0'></td>
        </tr>
<tr height='1'><td align='center'><a href='<?=MEMBER_UPD_URL?>'                             ><img src='/images/submenu/11901_<?=$mode == 'member_upd'               ?'on':'off'?>.jpg' border='0' alt='회원정보수정'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=company_write'?>"           ><img src='/images/submenu/11902_<?=$mode == 'company_write'            ?'on':'off'?>.jpg' border='0' alt='기업정보수정'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=biz_consult_list'?>"        ><img src='/images/submenu/11903_<?=$mode == 'biz_consult_list'         ?'on':'off'?>.jpg' border='0' alt='비즈니스상담'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=biz_match_list'?>"          ><img src='/images/submenu/11904_<?=$mode == 'biz_match_list'           ?'on':'off'?>.jpg' border='0' alt='비즈니스매칭'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=engineer_consult_list'?>"   ><img src='/images/submenu/11905_<?=$mode == 'engineer_consult_list'    ?'on':'off'?>.jpg' border='0' alt='기술자매칭'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=tech_need_list'?>"          ><img src='/images/submenu/11906_<?=$mode == 'tech_need_list'           ?'on':'off'?>.jpg' border='0' alt='기술니즈신청'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=tech_seed_consult_list'?>"  ><img src='/images/submenu/11907_<?=$mode == 'tech_seed_consult_list'   ?'on':'off'?>.jpg' border='0' alt='기술시드매칭신청'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=interest_company_list'?>"   ><img src='/images/submenu/11908_<?=$mode == 'interest_company_list'    ?'on':'off'?>.jpg' border='0' alt='관심기업'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=interest_engineer_list'?>"  ><img src='/images/submenu/11909_<?=$mode == 'interest_engineer_list'   ?'on':'off'?>.jpg' border='0' alt='관심기술자'></a></td></tr>
<tr height='1'><td align='center'><a href="<?=MYPAGE_URL.'&mode=member_secession'?>"        ><img src='/images/submenu/11910_<?=$mode == 'member_secession'         ?'on':'off'?>.jpg' border='0' alt='회원탈퇴'></a></td></tr>
        		<tr>
			<td height='109'><img src='/images/submenu/footer.jpg' border='0'></td>
		</tr>
       </table>
 
<?
// 비즈니스정보
} else if ( $sub == 'biz' ) {
?>
      <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr>
          <td align='center'><img src='/images/submenu/10100.jpg' border='0'></td>
        </tr>
        <tr height='1'><td align='center'><a href='<?=BIZ_URL.'&mode=index'?>'><img src='/images/submenu/10101_<?=$mode == 'index'?'on':'off'?>.jpg' border='0' alt='사업소개'></a></td></tr>
        <tr height='1'><td align='center'><a href='<?=BIZ_URL.'&mode=company_raise_list&p_company_type=' .COMPANY_TYPE_RAISE     ?>'><img src='/images/submenu/10102_<?=$mode == 'company_raise_list' ?'on':'off'?>.jpg' border='0' alt='일본기업조달정보'></a></td></tr>
        <tr height='1'><td align='center'><a href='<?=BIZ_URL.'&mode=company_supply_list&p_company_type=' .COMPANY_TYPE_SUPPLY    ?>'><img src='/images/submenu/10103_<?=$mode == 'company_supply_list'?'on':'off'?>.jpg' border='0' alt='일본기업공급정보'></a></td></tr>
        <tr height='1'><td align='center'><a href='<?=BIZ_URL.'&mode=biz_consult_write_pre&p_proc_type='.PROC_TYPE_BC?>'><img src='/images/submenu/10104_<?=$mode == 'biz_consult_write_pre'  ?'on':'off'?>.jpg' border='0' alt='비즈니스상담신청'></a></td></tr>
        <tr height='1'><td align='center'><a href='<?=BIZ_URL.'&mode=company_coop_list&p_company_type=' .COMPANY_TYPE_COOPERATION  ?>'><img src='/images/submenu/10105_<?=$mode == 'company_coop_list'  ?'on':'off'?>.jpg' border='0' alt='일본기업'></a></td></tr>
        <tr height='1'><td align='center'><a href='/sub.php?flashmenu=10106'><img src='/images/submenu/10106_<?=$mode == '6'?'on':'off'?>.jpg' border='0' alt='비즈니스매칭사례'></a></td></tr>
        <tr height='1'><td align='center'><a href='/sub.php?flashmenu=10107'><img src='/images/submenu/10107_<?=$mode == '7'?'on':'off'?>.jpg' border='0' alt='공지사항'></a></td></tr>
        <tr height='1'><td align='center'><a href='/sub.php?flashmenu=10108'><img src='/images/submenu/10108_<?=$mode == '8'?'on':'off'?>.jpg' border='0' alt='행사게시판'></a></td></tr>
        <tr height='1'><td align='center'><a href='/sub.php?flashmenu=10109'><img src='/images/submenu/10109_<?=$mode == '9'?'on':'off'?>.jpg' border='0' alt='추천사이트'></a></td></tr>

		<!--tr>
			<td height='109'><img src='/images/submenu/footer.jpg' border='0'></td>
		</tr-->
       </table>

<?
// 기술자정보
} else if ( $sub == 'engineer' ) {
?>
      <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr>
          <td align='center'><img src='/images/submenu/10200.jpg' border='0'></td>
        </tr>

        <tr height='1'><td align='center'><a href='/sub.php?flashmenu=10201'                        ><img src='/images/submenu/10201_off.jpg' border='0' alt='사업소개'></a></td></tr>
        <tr height='1'><td align='center'><a href='/sub.php?flashmenu=10202'                        ><img src='/images/submenu/10202_off.jpg' border='0' alt='모집안내'></a></td></tr>
        <tr height='1'><td align='center'><a href='/sub.php?flashmenu=10203'                        ><img src='/images/submenu/10203_off.jpg' border='0' alt='공지안내'></a></td></tr>
        <tr height='1'><td align='center'><a href='<?=ENGINEER_URL.'&mode=engineer_list'?>'         ><img src='/images/submenu/10204_<?=$mode == 'engineer_list'        ?'on':'off'?>.jpg' border='0' alt='재단DB지술자조회및 매칭신청'></a>-->조회후 관심기술자등록.</td></tr>
        <tr height='1'><td align='center'><a href='<?=ENGINEER_URL.'&mode=search_consult_write'?>'  ><img src='/images/submenu/10205_<?=$mode == 'search_consult_write' ?'on':'off'?>.jpg' border='0' alt='기술자search 매칭신청'></a></td></tr>
        <tr height='1'><td align='center'><a href='<?=ENGINEER_URL.'&mode=self_consult_write'?>'    ><img src='/images/submenu/10206_<?=$mode == 'self_consult_write'   ?'on':'off'?>.jpg' border='0' alt='자체보유기술자지원신청'></a></td></tr>
        <tr height='1'><td align='center'><a href='/sub.php?flashmenu=10207'><img src='/images/submenu/10207_off.jpg' border='0' alt='행사게시판'></a></td></tr>
		<!--tr>
			<td height='109'><img src='./images/submenu/footer.jpg' border='0'></td>
		</tr-->
       </table>
<?
// 기술정보
} else if ( $sub == 'tech' ) {
?>
      <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center'>
        <tr>
          <td align='center'><img src='/images/submenu/10300.jpg' border='0'></td>
        </tr>

		<tr height='1'><td align='center'><a href='<?=TECH_URL.'&mode=index'?>'><img src='/images/submenu/10301_<?=$mode == 'index' ?'on':'off'?>.jpg' border='0' alt='기술매칭소개'></a></td></tr>
		<tr height='1'><td align='center'><a href='/sub.php?flashmenu=10302'><img src='/images/submenu/10302_off.jpg' border='0' alt='시드검색'>-일본api</a></td></tr>
		<tr height='1'><td align='center'><a href='<?=TECH_URL.'&mode=tech_seed_list'?>'><img src='/images/submenu/10302_<?=$mode == 'tech_seed_list' ?'on':'off'?>.jpg' border='0' alt='시드검색'></a></td></tr>
		<tr height='1'><td align='center'><a href='<?=TECH_URL.'&mode=tech_need_write'?>'><img src='/images/submenu/10303_<?=$mode == 'tech_need_write' ?'on':'off'?>.jpg' border='0' alt='니즈접수'></a></td></tr>
		<tr height='1'><td align='center'><a href='/sub.php?flashmenu=10304'><img src='/images/submenu/10304_off.jpg' border='0' alt='특허검색'></a></td></tr>
		<tr height='1'><td align='center'><a href='/sub.php?flashmenu=10305'><img src='/images/submenu/10305_off.jpg' border='0' alt='신기술정보'></a></td></tr>

		<!--tr>
			<td height='109'><img src='./images/submenu/footer.jpg' border='0'></td>
		</tr-->
       </table>
<?
}
?>
