 <?
/*
 Filename        : /search.php
 Fuction         : 통합검색
 Comment         :
 시작 일자       : 2014-10-12,
 수정 일자       : 2014-10-12, v1.0 first
 작 성 자        : 김지훈
 수 정 자        :
 @version        : 1.0
*/
?>
<?php
$db = new DataBase();
$db->getConnect();
Session::setSession("s_top_search", $s_top_search);
?>
			<div class="search_result">
<?
$query = array();
$query [] = " SELECT ";
$query [] = "    COUNT(*) PROC_CNT ";
$query [] = " FROM " .      TBL_PROC_BD_CD      . " a";
$query [] = " LEFT JOIN " . TBL_PROC_CD         . " b";
$query [] = "        ON a.PROC_CD = b.PROC_CD ";
$query [] = " LEFT JOIN " . TBL_PROC_IT_CD      . " c";
$query [] = "        ON a.PROC_IT_CD = c.PROC_IT_CD ";
$procCnt  = $db->getOne(join(PHP_EOL, $query)." WHERE b.PROC_NM    LIKE '%" . $s_top_search. "%'");
$procItCnt= $db->getOne(join(PHP_EOL, $query)." WHERE c.PROC_IT_NM LIKE '%" . $s_top_search. "%'");
$procBdCnt= $db->getOne(join(PHP_EOL, $query)." WHERE a.PROC_BD_NM LIKE '%" . $s_top_search. "%'");

$query = array();
$query [] = " SELECT ";
$query [] = "    a.PROC_BD_CD_NO PROC_BD_CD_NO ";
$query [] = "  , a.PROC_BD_CD    PROC_BD_CD    ";
$query [] = "  , a.PROC_BD_NM    PROC_BD_NM    ";
$query [] = "  , a.PROC_DT_NM    PROC_DT_NM    ";
$query [] = "  , a.PROC_CD       PROC_CD       ";
$query [] = "  , a.PROC_IT_CD    PROC_IT_CD    ";
$query [] = "  , a.STD           STD           ";
$query [] = "  , a.UNIT          UNIT          ";
$query [] = "  , a.M_AMT         M_AMT         ";
$query [] = "  , a.L_AMT         L_AMT         ";
$query [] = "  , a.E_AMT         E_AMT         ";
$query [] = "  , a.M_AMT + a.L_AMT + a.E_AMT T_AMT         ";
$query [] = "  , b.PROC_NM       PROC_NM       ";
$query [] = "  , c.PROC_IT_NM    PROC_IT_NM    ";
$query [] = " FROM " . TBL_PROC_BD_CD   . " a";
$query [] = " LEFT JOIN " . TBL_PROC_CD      . " b";
$query [] = "   ON a.PROC_CD = b.PROC_CD ";
$query [] = " LEFT JOIN " . TBL_PROC_IT_CD      . " c";
$query [] = "   ON a.PROC_IT_CD = c.PROC_IT_CD ";
//echo join(PHP_EOL, $query);
?>
				<div class="count">
					<span>“<?=$s_top_search?>”</span>에 관한 전체 <span><?=($procCnt+$procItCnt+$procBdCnt)?></span>개의 결과를 찾았습니다.
				</div>
				<div class="total">
					<p class="tit">통합검색 <span>(<?=($procCnt+$procItCnt+$procBdCnt)?>)</span></p>
					<div>
						대공정 (<?=$procCnt?>) │ 공정항목 (<?=$procItCnt?>) │ 공정항목내역 (<?=$procBdCnt?>)
					</div>
				</div>

				<div class="result">
					<p class="tit">대공정 <span>[검색결과 <?=$procCnt?>건]</span></p>
					<ul>
<?
$stmt = $db->multiRowSQLQuery (join(PHP_EOL, $query)." WHERE b.PROC_NM LIKE '%" . $s_top_search. "%'");
while ( $rs = $db->multiRowFetch  ($stmt) ) {
    $proc_nm    = $rs->PROC_NM      ;
    $proc_it_nm = $rs->PROC_IT_NM   ;
    $proc_bd_nm = $rs->PROC_BD_NM   ;
    $proc_cd    = $rs->PROC_CD      ;
    $proc_it_cd = $rs->PROC_IT_CD   ;
    $proc_bd_cd = $rs->PROC_BD_CD   ;
    $proc_nm = str_replace($s_top_search,'<span>'.$s_top_search.'</span>', $proc_nm);
?>
						<a href="/reginfo.php?p_proc_cd=<?=$proc_cd?>&p_proc_it_cd=<?=$proc_it_cd?>&p_proc_bd_cd=<?=$proc_bd_cd?>"><u><li><?=$proc_nm?> &gt; <?=$proc_it_nm?> &gt; <?=$proc_bd_nm?></li></u></a>
<?php
}
?>
					</ul>
				</div>

				<div class="result">
					<p class="tit">공정항목 <span>[검색결과 <?=$procItCnt?>건]</span></p>
					<ul>
<?
$stmt = $db->multiRowSQLQuery (join(PHP_EOL, $query)." WHERE c.PROC_IT_NM LIKE '%" . $s_top_search. "%'");
while ( $rs = $db->multiRowFetch  ($stmt) ) {
	$proc_nm    = $rs->PROC_NM      ;
	$proc_it_nm = $rs->PROC_IT_NM   ;
	$proc_bd_nm = $rs->PROC_BD_NM   ;
	$proc_cd    = $rs->PROC_CD      ;
	$proc_it_cd = $rs->PROC_IT_CD   ;
	$proc_bd_cd = $rs->PROC_BD_CD   ;
	$proc_it_nm = str_replace($s_top_search,'<span>'.$s_top_search.'</span>', $proc_it_nm);
?>
						<a href="/reginfo.php?p_proc_cd=<?=$proc_cd?>&p_proc_it_cd=<?=$proc_it_cd?>&p_proc_bd_cd=<?=$proc_bd_cd?>"><u><li><?=$proc_nm?> &gt; <?=$proc_it_nm?> &gt; <?=$proc_bd_nm?></li></u></a>
<?php
}
?>
					</ul>
				</div>
				<div class="result">
					<p class="tit">공정항목내역 <span>[검색결과 <?=$procBdCnt?>건]</span></p>
					<ul>
<?
$stmt = $db->multiRowSQLQuery (join(PHP_EOL, $query)." WHERE a.PROC_BD_NM LIKE '%" . $s_top_search. "%'");
while ( $rs = $db->multiRowFetch  ($stmt) ) {
	$proc_nm    = $rs->PROC_NM      ;
	$proc_it_nm = $rs->PROC_IT_NM   ;
	$proc_bd_nm = $rs->PROC_BD_NM   ;
	$proc_cd    = $rs->PROC_CD      ;
	$proc_it_cd = $rs->PROC_IT_CD   ;
	$proc_bd_cd = $rs->PROC_BD_CD   ;
    $proc_bd_nm = str_replace($s_top_search,'<span>'.$s_top_search.'</span>', $proc_bd_nm);
?>
						<a href="/reginfo.php?p_proc_cd=<?=$proc_cd?>&p_proc_it_cd=<?=$proc_it_cd?>&p_proc_bd_cd=<?=$proc_bd_cd?>"><u><li><?=$proc_nm?> &gt; <?=$proc_it_nm?> &gt; <?=$proc_bd_nm?></li></u></a>
<?php
}
?>
					<ul>
				</div>
			</div>

<!-- <table border="0" cellspacing="0" cellpadding="0" width="700"  id="tbl_list">
    <thead></thead>
    <tbody></tbody>
    <tfoot style="height:60px"></tfoot>
</table>
 -->
<?php
$db->release();
?>