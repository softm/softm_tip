<?
/*
 Filename        : /index.php
 Fuction         : 인덱스
 Comment         :
 시작 일자       : 2012-05-16,
 수정 일자       : 2012-05-16, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
require_once SERVICE_DIR . '/classes/common/Session.php';
require_once SERVICE_DIR . '/classes/common/Database.class.php';
require_once SERVICE_DIR . '/classes/common/Common.php';
// echo "mode : " .$mode;
if (!ADMIN) {
	redirect("/sub.php?contents=config&load=cfg_login&usemode=login&failcode=2",true);
	return;
}
$db = new DataBase();
$db->getConnect();
?>
<?
$v01_01 = $db->getOne("SELECT COUNT(*) CNT FROM " . TBL_COMPANY . " a WHERE a.COUNTRY_TYPE = '" . COUNTRY_TYPE_KR . "'");
$v01_02 = $db->getOne("SELECT COUNT(*) CNT FROM " . TBL_COMPANY . " a WHERE a.COUNTRY_TYPE = '" . COUNTRY_TYPE_JP . "'");
$v01_03 = $db->getOne("SELECT COUNT(*) CNT FROM " . TBL_ENGINEER . " a");
$stmt = $db->multiRowSQLQuery ("SELECT  a.PROC_TYPE PROC_TYPE,  COUNT(*) CNT FROM " . TBL_TECH_CONSULT ." a GROUP BY a.PROC_TYPE");
while ( $rs = $db->multiRowFetch  ($stmt) ) {
	if      ( $rs->PROC_TYPE == PROC_TYPE_NC ) $v01_04 = $rs->CNT;
	else if ( $rs->PROC_TYPE == PROC_TYPE_SM ) $v01_05 = $rs->CNT;
}
?>
<span class="p14 b bl06">등록 정보 관련</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin_list" width="100%">
      <TR id="t1" class="b">
        <td class="bt" width='20%'   align="center"><span class="bl06">기업회원</span></td>
        <td class="bt" width='20%' align="center" ><span class="bl06">일본기업</span></td>
        <td class="bt" width='20%' align="center" ><span class="bl06">일본기술자</span></td>
	    <td class="bt" width='20%' align="center" ><span class="bl06">한국기업니즈</span></td>
		<td class="bt" width='20%'  align="center"><span class="bl06">일본기업니즈</span></td>
    </TR>
 <tr>
    <td><?=(sprintf("%03d",$v01_01))?>건</td>
     <td><?=(sprintf("%03d",$v01_02))?>건</td>
    <td><?=(sprintf("%03d",$v01_03))?>건</td>
	 <td><?=(sprintf("%03d",$v01_04))?>건</td>
	  <td><?=(sprintf("%03d",$v01_05))?>건</td>
    </tr>
     </table><br/><br/>
<?php 
$stmt = $db->multiRowSQLQuery ("SELECT  a.PROC_TYPE PROC_TYPE, a.STATE STATE, COUNT(*) CNT FROM " . TBL_BIZ_CONSULT ." a GROUP BY a.PROC_TYPE, a.STATE");
while ( $rs = $db->multiRowFetch  ($stmt) ) {
	if      ( $rs->PROC_TYPE == PROC_TYPE_BC ) {
		if      ( $rs->STATE == STATE_BC_START          ) $v02_01 = $rs->CNT; // 접수
		else if ( $rs->STATE == STATE_BC_UPDATE_REQUEST ) $v02_02 = $rs->CNT; // 수정요청중
		else if ( $rs->STATE == STATE_BC_WAIT           ) $v02_03 = $rs->CNT; // 접수대기
		else if ( $rs->STATE == STATE_BC_JKBIZ_WAIT     ) $v02_04 = $rs->CNT; // JK-BiC등록대기
		else if ( $rs->STATE == STATE_BC_JKBIZ_END      ) $v02_05 = $rs->CNT; // JK-BiC등록완료
	}
	else if ( $rs->PROC_TYPE == PROC_TYPE_BM ) {
		if      ( $rs->STATE == STATE_BM_REQUEST        ) $v03_01 = $rs->CNT; // 매칭신청      
		else if ( $rs->STATE == STATE_BM_UPDATE_REQUEST ) $v03_02 = $rs->CNT; // 수정요청중    
		else if ( $rs->STATE == STATE_BM_UPDATE_CHECK   ) $v03_03 = $rs->CNT; // 검토중        
		else if ( $rs->STATE == STATE_BM_REQUEST_WAIT   ) $v03_04 = $rs->CNT; // 매칭신청접수중
		else if ( $rs->STATE == STATE_BM_REQUEST_END    ) $v03_05 = $rs->CNT; // 매칭신청완료  
		else if ( $rs->STATE == STATE_BM_ING            ) $v03_06 = $rs->CNT; // 매칭진행중    
		else if ( $rs->STATE == STATE_BM_PENDING        ) $v03_07 = $rs->CNT; // 펜딩중        
		else if ( $rs->STATE == STATE_BM_DEALMAKING     ) $v03_08 = $rs->CNT; // 성약          
		else if ( $rs->STATE == STATE_BM_NOT_DEALMAKING ) $v03_09 = $rs->CNT; // 비성약        
	}
}
?>     
<span class="p14 b bl06">매칭관련정보</span><br/><br/>
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
        <tr>
          <td width="210" class="bt" id="t2" colspan="4" ><span class="bl06">2.비즈니스상담</span></td>
 
      </tr>
	  <tr>
         <td width="150"  id="t1">접수</td>
       <td  class="br2" ><?=(sprintf("%03d",$v02_01))?>건</td>
        <td width="150" id="t1">수정요청중</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v02_02))?>건</td>
      </tr>
      <tr>
         <td width="150"  id="t1">접수대기</td>
       <td  class="br2" ><?=(sprintf("%03d",$v02_03))?>건</td>
        <td width="150"id="t1">JK-BiC등록대기</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v02_04))?>건</td>
      </tr>
	   <tr>
         <td width="150"  id="t1">JK-BiC등록완료</td>
       <td  colspan="3" ><?=(sprintf("%03d",$v02_05))?>건</td>
      </tr>
      </table>
	<br/><br/>
	<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
        <tr>
          <td width="210" class="bt" id="t2" colspan="4" ><span class="bl06">2.비즈니스매칭</span></td>
 
      </tr>
  <tr>
         <td width="150"  id="t1">매칭신청</td>
       <td  class="br2" ><?=(sprintf("%03d",$v03_01))?>건</td>
        <td width="150" id="t1">수정요청중</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v03_02))?>건</td>
      </tr>
      <tr>
         <td width="150"  id="t1">검토중</td>
       <td  class="br2" ><?=(sprintf("%03d",$v03_03))?>건</td>
        <td width="150"id="t1">매칭신청접수중</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v03_04))?>건</td>
      </tr>
	   <tr>
         <td width="150"  id="t1">매칭신청완료</td>
       <td  class="br2" ><?=(sprintf("%03d",$v03_05))?>건</td>
        <td width="150"id="t1">매칭진행중</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v03_06))?>건</td>
      </tr>
	   <tr>
         <td width="150"  id="t1">펜딩중</td>
       <td  class="br2" ><?=(sprintf("%03d",$v03_07))?>건</td>
        <td width="150"id="t1">성약</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v03_08))?>건</td>
      </tr>
	   <tr>
         <td width="150"  id="t1">비성약</td>
       <td  class="br2" ><?=(sprintf("%03d",$v03_09))?>건</td>
        <td width="150"id="t1">비선정매칭종료</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v03_10))?>건</td>
      </tr>
	 
      </table>
	<br/><br/>
<?php 
$stmt = $db->multiRowSQLQuery ("SELECT  a.PROC_TYPE PROC_TYPE, a.STATE STATE, COUNT(*) CNT FROM " . TBL_ENGINEER_CONSULT ." a GROUP BY a.PROC_TYPE, a.STATE");
while ( $rs = $db->multiRowFetch  ($stmt) ) {
	if ( $rs->PROC_TYPE == PROC_TYPE_EM ) {
		if      ( $rs->STATE == STATE_EM_REQUEST                         ) $v04_01 = $rs->CNT; // 신청          
		else if ( $rs->STATE == STATE_EM_RE_REQUEST                      ) $v04_02 = $rs->CNT; // 재신청        
		else if ( $rs->STATE == STATE_EM_NEGOTIATIONS                    ) $v04_03 = $rs->CNT; // 교섭          
		else if ( $rs->STATE == STATE_EM_NEGOTIATIONS_BREAK              ) $v04_04 = $rs->CNT; // 매칭(교섭)결렬
		else if ( $rs->STATE == STATE_EM_R_NOMINATION                    ) $v04_05 = $rs->CNT; // 역지명        
		else if ( $rs->STATE == STATE_EM_R_NOMINATION_NEGOTIATIONS       ) $v04_06 = $rs->CNT; // 역지명교섭    
		else if ( $rs->STATE == STATE_EM_R_NOMINATION_NEGOTIATIONS_BREAK ) $v04_07 = $rs->CNT; // 역지명교섭결렬
		else if ( $rs->STATE == STATE_EM_CONSULT_JOIN                    ) $v04_08 = $rs->CNT; // 매칭상담회참가
		else if ( $rs->STATE == STATE_EM_FOUNDATION_REVIEW               ) $v04_09 = $rs->CNT; // 재단심의      
		else if ( $rs->STATE == STATE_EM_BIZ_REVIEW                      ) $v04_10 = $rs->CNT; // 기업심의      
		else if ( $rs->STATE == STATE_EM_ADVISER_START                   ) $v04_11 = $rs->CNT; // 지도시작      
		else if ( $rs->STATE == STATE_EM_ADVISER_END                     ) $v04_12 = $rs->CNT; // 지도완료      
		else if ( $rs->STATE == STATE_EM_END                             ) $v04_13 = $rs->CNT; // 기술매칭완료  
	}
}
?> 
		<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
        <tr>
          <td width="210" class="bt" id="t2" colspan="4" ><span class="bl06">3. 기술자매칭</span></td>
      </tr>
  <tr>
         <td width="150"  id="t1">신청</td>
       <td  class="br2" ><?=(sprintf("%03d",$v04_01))?>건</td>
        <td width="150" id="t1">재신청</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v04_02))?>건</td>
      </tr>
      <tr>
         <td width="150"  id="t1">교섭</td>
       <td  class="br2" ><?=(sprintf("%03d",$v04_03))?>건</td>
        <td width="150"id="t1">매칭교섭결렬</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v04_04))?>건</td>
      </tr>
	   <tr>
         <td width="150"  id="t1">역지명</td>
       <td  class="br2" ><?=(sprintf("%03d",$v04_05))?>건</td>
        <td width="150"id="t1">역지명교섭</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v04_06))?>건</td>
      </tr>
	   <tr>
         <td width="150"  id="t1">역지명교섭결렬</td>
       <td  class="br2" ><?=(sprintf("%03d",$v04_07))?>건</td>
        <td width="150"id="t1">매칭상담회참가</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v04_08))?>건</td>
      </tr>
	   <tr>
         <td width="150"  id="t1">재담심의</td>
       <td  class="br2" ><?=(sprintf("%03d",$v04_09))?>건</td>
        <td width="150"id="t1">기업심의</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v04_10))?>건</td>
      </tr>
	  <tr>
         <td width="150"  id="t1">지도시작</td>
       <td  class="br2" ><?=(sprintf("%03d",$v04_11))?>건</td>
        <td width="150"id="t1">지도완료</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v04_12))?>건</td>
      </tr>
	  <tr>
         <td width="150"  id="t1">기술매칭완료</td>
       <td  colspan="3" ><?=(sprintf("%03d",$v04_13))?>건</td>
      </tr>
      </table>
	<br/><br/>
 
<?php
$stmt = $db->multiRowSQLQuery ("SELECT  a.PROC_TYPE PROC_TYPE, a.STATE STATE, COUNT(*) CNT FROM " . TBL_TECH_CONSULT ." a GROUP BY a.PROC_TYPE, a.STATE");
while ( $rs = $db->multiRowFetch  ($stmt) ) {
	if ( $rs->PROC_TYPE == PROC_TYPE_NC ) {
		if      ( $rs->STATE == STATE_NC_REQUEST        ) $v05_01 = $rs->CNT; // 신청중
		else if ( $rs->STATE == STATE_NC_UPDATE_REQUEST ) $v05_02 = $rs->CNT; // 수정요청중
		else if ( $rs->STATE == STATE_NC_UPDATE_CHECK   ) $v05_03 = $rs->CNT; // 검토중
	} else if ( $rs->PROC_TYPE == PROC_TYPE_SM ) {
		if      ( $rs->STATE == STATE_SM_REQUEST        ) $v06_01 = $rs->CNT; // 신청중
		else if ( $rs->STATE == STATE_SM_UPDATE_REQUEST ) $v06_02 = $rs->CNT; // 수정요청중
		else if ( $rs->STATE == STATE_SM_UPDATE_CHECK   ) $v06_03 = $rs->CNT; // 검토중
		else if ( $rs->STATE == STATE_SM_REQUEST_END    ) $v06_04 = $rs->CNT; // 매칭신청완료
		else if ( $rs->STATE == STATE_SM_ING            ) $v06_05 = $rs->CNT; // 매칭진행중
		else if ( $rs->STATE == STATE_SM_DEALMAKING     ) $v06_06 = $rs->CNT; // 성약
		else if ( $rs->STATE == STATE_SM_NOT_DEALMAKING ) $v06_07 = $rs->CNT; // 비성약
    }
}
?>
	<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
        <tr>
          <td width="210" class="bt" id="t2" colspan="4" ><span class="bl06">4. 개술매칭 - 니드</span></td>
      </tr>
  <tr>
         <td width="150"  id="t1">신청중</td>
       <td  class="br2" ><?=(sprintf("%03d",$v05_01))?>건</td>
        <td width="150" id="t1">수정요청중</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v05_02))?>건</td>
      </tr>
	  <tr>
         <td width="150"  id="t1">검토중</td>
       <td  colspan="3" ><?=(sprintf("%03d",$v05_03))?>건</td>
      </tr>
      </table>
	<br/><br/>
 
	<table border="0" cellpadding="0" cellspacing="0" id="admin" width="100%">
        <tr>
          <td width="210" class="bt" id="t2" colspan="4" ><span class="bl06">5. 기술매칭 - 시드</span></td>
      </tr>
  <tr>
         <td width="150"  id="t1">신청중</td>
       <td  class="br2" ><?=(sprintf("%03d",$v06_01))?>건</td>
        <td width="150" id="t1">수정요청중</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v06_02))?>건</td>
      </tr>
	    <tr>
         <td width="150"  id="t1">검토중</td>
       <td  class="br2" ><?=(sprintf("%03d",$v06_03))?>건</td>
        <td width="150" id="t1">매칭신청완료</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v06_04))?>건</td>
      </tr>
	    <tr>
         <td width="150"  id="t1">매칭진행중</td>
       <td  class="br2" ><?=(sprintf("%03d",$v06_05))?>건</td>
        <td width="150" id="t1">성약</td>
        <td width="25%"  align="left"><?=(sprintf("%03d",$v06_06))?>건</td>
      </tr>
	  <tr>
         <td width="150"  id="t1">비성약</td>
       <td  colspan="3" ><?=(sprintf("%03d",$v06_07))?>건</td>
      </tr>
      </table>
	<br/><br/>        
<?php 
$db->release();
?>	