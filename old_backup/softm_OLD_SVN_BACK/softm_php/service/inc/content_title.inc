<?php
$imageName = "title_11902.jpg";
$titleName = "일반회원관리";
$titleName = "Home &nbsp;>&nbsp; " . $sub;
if ( $sub == 'member' ) {
	if      ( $mode == 'login' ) { 
        $titleName = "Home &nbsp;>&nbsp; 로그인"; 
        $imageName="title_login.jpg";
    }
	if ( !LOGIN ) {
		if ( $mode == 'reg'   ) {
			$imageName="title_11901.jpg";
			$titleName = "Home &nbsp;>&nbsp; 회원가입";
		}		
	} else {
		if      ( $mode == 'write'             ) {
			$titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 회원정보수정";
		}
		
	}
}
else  if ( $sub == 'mypage' ) { // 마이페이지정보
	$imageName="title_11900.jpg";
	if      ( $mode == 'member_upd'             ) { 
		$imageName="title_11901.jpg";
		$titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 회원정보수정"; 
	}
	else if ( $mode == 'company_write'          ) { 
        if ( !LOGIN ) {
            $titleName = "Home &nbsp;>&nbsp; 기업회원가입"; 
        } else {
        	$imageName="title_11902.jpg";        	
            $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 기업정보수정";
        }
    }
	else if ( $mode == 'biz_consult_list'       ) { $imageName="title_11903.jpg"; $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 비즈니스상담"    ; }
	else if ( $mode == 'biz_match_list'         ) { $imageName="title_11904.jpg"; $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 비즈니스매칭"    ; }
	else if ( $mode == 'engineer_consult_list'  ) { $imageName="title_11905.jpg"; $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 기술자매칭"      ; }
	else if ( $mode == 'tech_need_list'         ) { $imageName="title_11906.jpg"; $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 기술니즈신청"    ; }
	else if ( $mode == 'tech_seed_consult_list' ) { $imageName="title_11907.jpg"; $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 기술시드매칭신청"; }
	else if ( $mode == 'interest_company_list'  ) { $imageName="title_11908.jpg"; $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 관심기업"        ; }
	else if ( $mode == 'interest_engineer_list' ) { $imageName="title_11909.jpg"; $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 관심기술자"      ; }
	else if ( $mode == 'member_secession'       ) { $imageName="title_11910.jpg"; $titleName = "Home &nbsp;>&nbsp; 마이페이지 &nbsp;>&nbsp; 회원탈퇴"        ; }

} else if ( $sub == 'biz' ) { // 비즈니스정보
	$imageName="title_10101.jpg";
	if      ( $mode == 'index'     ) {
		$imageName="title_10101.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 비즈니스정보 &nbsp;>&nbsp; 사업소개" ;
	}
	else if      ( $mode == 'company_raise_list'     ) {
		$imageName="title_10102.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 비즈니스정보 &nbsp;>&nbsp; 일본기업조달정보" ;
	}
	else if ( $mode == 'company_supply_list'    ) {
		$imageName="title_10103.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 비즈니스정보 &nbsp;>&nbsp; 일본기업공급정보" ;
	}
	else if ( $mode == 'biz_consult_write_pre' || $mode == 'biz_consult_write' ) {
		$imageName="title_10104.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 비즈니스정보 &nbsp;>&nbsp; 비즈니스상담신청" ;
	}
	else if ( $mode == 'company_coop_list'      ) {
		$imageName="title_10105.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 비즈니스정보 &nbsp;>&nbsp; 일본기업정보"     ;
	}
} else if ( $sub == 'engineer' ) { // 기술자정보
	$imageName="title_12007.jpg";
	if      ( $mode == 'engineer_list'     ) {
		$imageName="title_10204.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 기술자정보 &nbsp;>&nbsp; 재단DB지술자조회및 매칭신청" ;
	}
	else if ( $mode == 'search_consult_write'    ) {
		$imageName="title_10205.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 기술자정보 &nbsp;>&nbsp; 기술자search 매칭신청" ;
	}
	else if ( $mode == 'self_consult_write'      ) {
		$imageName="title_10206.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 기술자정보 &nbsp;>&nbsp; 자체보유기술자지원신청" ;
	}	
	
} else if ( $sub == 'tech' ) { // 기술정보
	$imageName="title_10301.jpg";
	if      ( $mode == 'index'     ) {
		$imageName="title_10301.jpg";
		$titleName = "Home &nbsp;>&nbsp; 기술정보 &nbsp;>&nbsp; 기술매칭소개" ;
	}
	else if      ( $mode == 'tech_seed_list' ) {
		$imageName="title_10302.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 기술정보 &nbsp;>&nbsp; 시드검색" ;
	}
	else if ( $mode == 'tech_need_write'    ) {
		$imageName="title_10303.jpg";		
		$titleName = "Home &nbsp;>&nbsp; 기술정보 &nbsp;>&nbsp; 니즈접수" ;
	}
}
?>
      <table width='700' border='0' cellspacing='0' cellpadding='0'>
        <tr>
			<td><img src='/images/title_bar/<?=$imageName?>' border='0'></td>
			<td height='30' style='font-size:11px;font-family:dotum;color:#999999;text-align:right;'> <img src='/images/ico_n.jpg' align=''> <?=$titleName?></td>
        </tr>
      </table>
