<?
/*
 Filename        : /index.php
 Fuction         : 인덱스
 Comment         :
 시작 일자       : 2014-10-01,
 수정 일자       : 2014-10-01, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?
$db = new DataBase();
$db->getConnect();
?>
            <div id="m_slide" style="text-align:center;">
<!--
                <div class="ms_inner">
                    <ul>
                        <li><img src="images/main/@img.jpg" alt="" /><span class="txt">목공사 : 253/67</span></li>
                        <li><img src="images/main/@img.jpg" alt="" /><span class="txt">조적/석공사 : 253/67</span></li>
                        <li><img src="images/main/@img.jpg" alt="" /><span class="txt">지붕/홈통 : 253/67</span></li>
                        <li><img src="images/main/@img02.jpg" alt="" /><span class="txt">목공사 : 253/67</span></li>
                        <li><img src="images/main/@img02.jpg" alt="" /><span class="txt">조적/석공사 : 253/67</span></li>
                        <li><img src="images/main/@img02.jpg" alt="" /><span class="txt">지붕/홈통 : 253/67</span></li>
                        <li><img src="images/main/@img.jpg" alt="" /><span class="txt">목공사 : 253/67</span></li>
                        <li><img src="images/main/@img.jpg" alt="" /><span class="txt">조적/석공사 : 253/67</span></li>
                        <li><img src="images/main/@img.jpg" alt="" /><span class="txt">지붕/홈통 : 253/67</span></li>
                    </ul>
                </div>
                <a href="" class="prev"><img src="images/main/btn_prev.gif" alt="" /></a>
                <a href="" class="next"><img src="images/main/btn_next.gif" alt="" /></a>
 -->
<?
$query = array();
$query [] = " SELECT ";
$query [] = "   a.PROC_CD      AS PROC_CD";
$query [] = " , MAX(a.PROC_NM) AS PROC_NM";
$query [] = " , SUM( CASE WHEN b.STATE =  '" . STATE_REGINFO_APPROVAL . "' THEN 1 ELSE 0 END ) A_CNT ";
$query [] = " , SUM( CASE WHEN b.STATE <> '" . STATE_REGINFO_APPROVAL . "' THEN 1 ELSE 0 END ) N_CNT ";
$query [] = " FROM " . TBL_PROC_CD      . " a";
$query [] = " LEFT JOIN " . TBL_REG_INFO      . " b";
$query [] = "   ON a.PROC_CD = b.PROC_CD ";
$query [] = " GROUP BY a.PROC_CD ";
//echo join(PHP_EOL, $query);
?>
    <div class="infiniteCarousel">
      <div class="wrapper" style=" height:180px;" >
        <ul>
<?

$stmt = $db->multiRowSQLQuery (join(PHP_EOL, $query));
$loopCnt = 0;
while ( $rs = $db->multiRowFetch  ($stmt) ) {
    $loopCnt++;
    $proc_cd   = $rs->PROC_CD      ;
    $proc_nm   = $rs->PROC_NM      ;
    $a_cnt     = $rs->A_CNT      ;
    $n_cnt     = $rs->N_CNT      ;
//    $a_cnt     = 100;
//    $n_cnt     = 100;
?>
          <li style="text-align:left"><a href="#" title="<?=$proc_nm?> <?=$a_cnt?>/<?=$n_cnt?>" style="cursor:default;"><img src="/images/proc/<?=$proc_cd?>.jpg" height="140" width="124" alt="<?=$proc_cd?>" /><div class="txt txtcut red" style="white-space:nowrap;overflow: hidden;border:0px solid red;width:75px;color:red;font-weight:bold;text-align:left;display:inline-block;vertical-align:middle"><?=$proc_nm?>:</div><div style="white-space:nowrap;overflow: hidden;border:0px solid red;width:60px;color:red;display:inline-block;text-align:center;vertical-align:middle"><?=$a_cnt?>/<?=$n_cnt?></div></a></li>
<?php
}
?>
<!--           <li><a href="/product.php?sub=procitcd&p_proc_cd=C02" title="토공사"       ><img src="/images/proc/C02.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">토공사       :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C03" title="콘트리트 공사"><img src="/images/proc/C03.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">콘트리트 공사:111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C04" title="조적/석공사"  ><img src="/images/proc/C04.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">조적/석공사  :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C05" title="금속공사"     ><img src="/images/proc/C05.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">금속공사     :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C06" title="목공사"       ><img src="/images/proc/C06.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">목공사       :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C07" title="단열/방수"    ><img src="/images/proc/C07.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">단열/방수    :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C08" title="창호"         ><img src="/images/proc/C08.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">창호         :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C09" title="마감공사"     ><img src="/images/proc/C09.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">마감공사     :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C10" title="지붕/홈통"    ><img src="/images/proc/C10.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">지붕/홈통    :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C11" title="가구공사"     ><img src="/images/proc/C11.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">가구공사     :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C12" title="조경/부대토목"><img src="/images/proc/C12.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">조경/부대토목:111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C13" title="전기"         ><img src="/images/proc/C13.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">전기         :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C14" title="설비"         ><img src="/images/proc/C14.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">설비         :111/22 </span></a></li>
          <li><a href="/product.php?sub=procitcd&p_proc_cd=C15" title="경상비/기타"  ><img src="/images/proc/C15.jpg" height="140" width="124" alt="Tall Glow" /><span class="txt red">경상비/기타  :111/22 </span></a></li> -->
        </ul>
      </div>
    </div>

            </div>
            <!--
            <div class="slide_box">
                <div class="slide_hidden">
                    <ul>
                        <li>
                            <img src="images/main/@img.jpg" alt="" />
                            <img src="images/main/@img.jpg" alt="" />
                            <img src="images/main/@img.jpg" alt="" />
                        </li>
                        <li>
                            <img src="images/main/@img02.jpg" alt="" />
                            <img src="images/main/@img02.jpg" alt="" />
                            <img src="images/main/@img02.jpg" alt="" />
                        </li>
                        <li>
                            <img src="images/main/@img.jpg" alt="" />
                            <img src="images/main/@img.jpg" alt="" />
                            <img src="images/main/@img.jpg" alt="" />
                        </li>
                    </ul>
                </div>
                <div class="btn_area">
                    <a href="#" class="btn_prev"><img src="images/main/btn_prev.gif" alt="" /></a>
                    <a href="#" class="btn_next"><img src="images/main/btn_next.gif" alt="" /></a>
                </div>
            </div>
            -->

            <div class="notice_box">
                <div class="notice_style">
                    <strong><span class="red">■</span> 공지사항</strong>
                    <ul>
<?php
$query = array();
$query [] = " SELECT ";
$query [] = " NO,";
//          $query [] = " NO NO2,";
$query [] = " CAT_NO,";
$query [] = " G_NO,";
$query [] = " DEPTH,";
$query [] = " O_SEQ,";
$query [] = " PRE_NO,";
$query [] = " NEXT_NO,";
$query [] = " USER_LEVEL,";
$query [] = " USER_NO,";
$query [] = " USER_ID,";
$query [] = " NAME,";
$query [] = " PASSWORD,";
$query [] = " TITLE,";
$query [] = " CONTENT,";
$query [] = " E_MAIL,";
$query [] = " HOME,";
$query [] = " FILE_NO1,";
$query [] = " DATE_FORMAT(REG_DATE,'%Y-%m-%d') REG_DATE,";
$query [] = " IP,";
$query [] = " HIT";
$query [] = " FROM " . TBL_BBS_DATA_NOTICE;
$query [] = ' ORDER BY NO DESC';
$query [] = " LIMIT 5";
// echo join(PHP_EOL, $query);
$stmt = $db->multiRowSQLQuery (join(PHP_EOL, $query));
$loopCnt = 0;
while ( $rs = $db->multiRowFetch  ($stmt) ) {
    $loopCnt++;
    $no       = $rs->NO      ;
    $title    = $rs->TITLE   ;
    $reg_date = $rs->REG_DATE;
?>
                        <li><a href="bbs.php?mode=view&p_no=<?=$no?>" style="overflow:hidden; text-overflow:ellipsis;width:445px;display:inline-block;padding-right:15px"><?=$title?></a><span><?=$reg_date?></span></li>
<?php
}
for($i=$loopCnt;$i<5;$i++) {
?>
                        <li>&nbsp;</li>
<?
}
?>
                    </ul>
                </div>
                <div class="notice_style">
                    <strong><span class="red">■</span> 최신 업데이트</strong>
                    <ul>

<?php
$query = array();
$query [] = " SELECT ";
$query [] = "    a.REG_NO           REG_NO          ";
$query [] = "  , a.PROC_CD          PROC_CD         ";
$query [] = "  , a.PROC_IT_CD       PROC_IT_CD      ";
$query [] = "  , a.PROC_BD_CD       PROC_BD_CD      ";
//$query [] = "  , a.PROC_IT_NM       PROC_IT_NM      ";
//$query [] = "  , a.PROC_BD_NM       PROC_BD_NM      ";
//$query [] = "  , a.PROC_DT_NM       PROC_DT_NM      ";
$query [] = "  , a.STD              STD             ";
$query [] = "  , a.UNIT             UNIT            ";
$query [] = "  , a.M_AMT            M_AMT           ";
$query [] = "  , a.L_AMT            L_AMT           ";
$query [] = "  , a.E_AMT            E_AMT           ";
$query [] = "  , a.COMPANY_NM       COMPANY_NM      ";
$query [] = "  , a.COMPANY_TEL      COMPANY_TEL     ";
$query [] = "  , a.COMPANY_AREA     COMPANY_AREA    ";
$query [] = "  , a.COMPANY_ADDR     COMPANY_ADDR    ";
$query [] = "  , a.COMPANY_HOMEPAGE COMPANY_HOMEPAGE";
$query [] = "  , a.M_AMT + a.L_AMT + a.E_AMT T_AMT  ";
$query [] = "  , b.PROC_NM          PROC_NM         ";
$query [] = "  , a.STATE            STATE           ";
$query [] = "  , DATE_FORMAT(REG_DATE,'%Y-%m-%d') REG_DATE";
$query [] = "  , c.PROC_IT_NM       PROC_IT_NM      ";
$query [] = "  , d.PROC_BD_NM       PROC_BD_NM      ";
$query [] = "  , d.PROC_DT_NM       PROC_DT_NM      ";

$query [] = " FROM " . TBL_REG_INFO . " a";
$query [] = " LEFT JOIN " . TBL_PROC_CD      . " b";
$query [] = "   ON a.PROC_CD = b.PROC_CD ";
$query [] = " LEFT JOIN " . TBL_PROC_IT_CD      . " c";
$query [] = "   ON a.PROC_IT_CD = c.PROC_IT_CD ";
$query [] = " LEFT JOIN " . TBL_PROC_BD_CD      . " d";
$query [] = "   ON a.PROC_BD_CD = d.PROC_BD_CD ";
$query [] = " WHERE a.STATE = '" . STATE_REGINFO_APPROVAL . "'";

$query [] = ' ORDER BY REG_NO DESC';
$query [] = " LIMIT 5";
//echo join(PHP_EOL, $query);
$stmt = $db->multiRowSQLQuery (join(PHP_EOL, $query));
$loopCnt = 0;
while ( $rs = $db->multiRowFetch  ($stmt) ) {
    $loopCnt++;
    $reg_no     = $rs->REG_NO      ;
    $proc_cd     = $rs->PROC_CD      ;
    $proc_it_cd  = $rs->PROC_IT_CD   ;
    $proc_bd_cd  = $rs->PROC_BD_CD   ;
    $proc_dt_nm = $rs->PROC_DT_NM;
    $reg_date = $rs->REG_DATE;
?>
                        <li><a href="reginfo.php?p_proc_cd=<?=$proc_cd?>&p_proc_it_cd=<?=$proc_it_cd?>&p_proc_bd_cd=<?=$proc_bd_cd?>&p_reg_no=<?=$reg_no?>" style="overflow:hidden; text-overflow:ellipsis;width:445px;display:inline-block;padding-right:15px"><?=$proc_dt_nm?></a><span><?=$reg_date?></span></li>
<?php
}
for($i=$loopCnt;$i<5;$i++) {
?>
                        <li>&nbsp;</li>
<?
}
?>

                    </ul>
                </div>
            </div>

<?php
$db->release();
?>