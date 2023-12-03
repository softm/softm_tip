<?
require_once HOME_DIR . '/inc/form.inc';
require_once HOME_DIR . '/inc/var.inc';
?>
<form id=sForm style=display:inline onsubmit='return 일반회원조회(1);'>
    <input type=submit style='position:absolute;top:-1999'>
<table width=1000 border=0 cellspacing=0 cellpadding=0 id=search-box>
    <tr>
    <td width=70><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle>검 색</td>
    <td width=405><span class=gray>
<?
    $creategory_setup['select'          ] = $s_user_level;
    $creategory_setup['prop_name'       ] = 's_user_level';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $user_levegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $user_levegory);
?>
        <select name=s_gubun style=width:100px ;>
            <option value='USER_NAME'    <?=$s_gubun=='USER_NAME'?'selected':''?>>이름</option>
            <option value='USER_ID'      <?=$s_gubun=='USER_ID'?'selected':''?>>아이디</option>
            <option value='ADDRESS'      <?=$s_gubun=='ADDRESS'?'selected':''?>>주소</option>
            <option value='TEL1'         <?=$s_gubun=='TEL1'?'selected':''?>>핸드폰번호</option>
            <option value='COMPANY_NAME' <?=$s_gubun=='COMPANY_NAME'?'selected':''?>>업체명</option>
        </select>
    </span>

    <input type=text name=s_search id=s_search style='width:130px' value=<?=$s_search?>>
    <A HREF=# onclick='중개회원조회();return false;'><img src=/img/bt_search.gif width=52 height=20 align=absmiddle></A></td>
    <td width=100><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />기간별검색 </td>
    <td width=423><input type=text id=s_reg_date style='width:80px' value='<?=date('Y-m-d')?>' readonly>
     <a href=# onclick='displayCalendar($("s_reg_date"),"yyyy-mm-dd",this)'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a> -
    <input type=text id=e_reg_date style='width:80px' value='<?=getDateAdd (date('Y-m-d'), 'DAY', 7 )?>' readonly> <a href=# onclick='displayCalendar($("e_reg_date"),"yyyy-mm-dd",this)'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    <A HREF=# onclick='중개회원조회();return false;'><img src=/img/bt_search.gif width=52 height=20 align=absmiddle></A></td>
    </tr>
</table>
</form>
<table width=1000 border=0 cellpadding=0 cellspacing=0 id=list-box>
<caption>
중개회원 등록정보
</caption>
  <tr>
    <th width=50>No</th>
    <th width=60>종류</th>
    <th width=110>ID</th>
    <th width=80>이름</th>
    <th width=''>주소</th>
    <th width=168>메일</th>
    <th width=110>핸드폰번호</th>
    <th width=90>등록일</th>
    <th width=60>수정</th>
    <th width=30>&nbsp;</th>
  </tr>
<?
include ( HOME_DIR . '/inc/page_tab.inc' ); // 페이지 탭
// 페이지 탭 설정
//echo '$totCnt : ' . $totCnt;
$page_tab['js_function' ] = '중개회원조회';
$page_tab['s'        ] = !$s?1:(int)$s;
$page_tab['how_many' ] = 2;
$page_tab['more_many'] = 2;
$page_tab['page_many'] = 10;
$page_tab['target'   ] = $HTTP_SERVER_VARS['PHP_SELF'];
$page_tab['pre'      ] = '<img src=/img/bt_na03.gif alt= width=16 height=16 align=absmiddle />';
$page_tab['next'     ] = '<img src=/img/bt_na02.gif alt= width=16 height=16 align=absmiddle />';
$page_tab['pre_1'    ] = "" ; // 이전
$page_tab['next_1'   ] = "" ; // 이후
$page_tab['page_sep' ] = "" ; // 페이지구분 기호
$page_tab['page_start']= " "; // 페이지 표시 시작 [1] <<-- [
$page_tab['page_end' ] = " . "; // 페이지 표시 끝   [1] <<-- ]
$page_tab['page_pre' ] = "" ; // 페이지 앞 [*여기* 1]
$page_tab['page_next' ]= "" ; // 페이지 뒤 [1 *여기*]
$page_tab['page_start_active'] = "<font color='BF0909'>" ;   // 선택 페이지 앞쪽 태그
$page_tab['page_end_active'  ] = "</font> ."               ;   // 선택 페이지 뒷쪽 태그

$cur_many = 0;
if ( $page_tab['s'] >= $page_tab['how_many' ] + 1 ) $cur_many = $page_tab['more_many']; else $cur_many = $page_tab['how_many'];

$where = '';
if ( $s_search ) {
    if ( $s_gubun == 'USER_NAME' ) {
        $where = " AND USER_NAME LIKE '" . $s_search. "%'";
    } else if ( $s_gubun == 'USER_ID' ) {
        $where = " AND USER_ID LIKE '" . $s_search. "%'";
    } else if ( $s_gubun == 'ADDRESS' ) {
        $where = " AND ADDRESS1 LIKE '%" . $s_search. "%' OR ADDRESS2 LIKE '%" . $s_search. "%'";
    } else if ( $s_gubun == 'TEL1' ) {
        $where = " AND TEL1 LIKE '" . $s_search. "%'";
    } else if ( $s_gubun == 'COMPANY_NAME' ) {
        $where = " AND COMPANY_NAME LIKE '%" . $s_search. "%'";
    }
}
$sql = " SELECT COUNT(*) FROM " . TB_MEMBER
     . " WHERE USER_LEVEL " . ( $s_user_level?"= '". $s_user_level . "'":"<>''") // 중계회원
     . ( $where ? $where :"" );
$totCnt = $db->simpleSQLQuery ($sql);
$page_tab['tot'      ] = $totCnt ;

$sql = " SELECT * FROM " . TB_MEMBER
     . " WHERE USER_LEVEL " . ( $s_user_level?"= '". $s_user_level . "'":"<>''") // 중계회원
     . ( $where ? $where :"" )
     . " ORDER BY USER_NO DESC"
     . " limit " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;
//echo 'sql : ' . $sql . ' /<BR>';
$stmt = $db->multiRowSQLQuery ($sql);
$cnt = 0;
$print_no = $totCnt - $page_tab['s'] + 2; // 현재 보여지는 번호.
while ( $rs = $db->multiRowFetch  ($stmt) ) {
    $cnt++;
    $print_no--;
?>
  <tr>
    <td><?=sprintf('%02d',$print_no)?></td>
    <td><?=$user_levegory[$rs[USER_LEVEL]]?></td>
    <td><?=$rs[USER_ID]?></td>
    <td><?=$rs[USER_NAME]?></td>
    <td><div class='textOf' style="width:210;" title='<?=$rs[ADDRESS1]?> <?=$rs[ADDRESS2]?>'><nobr><?=$rs[ADDRESS1]?> <?=$rs[ADDRESS2]?></nobr></div>
    </td>
    <td><a href='mailto:<?=$rs[E_MAIL]?>'><?=$rs[E_MAIL]?$rs[E_MAIL]:'&nbsp;'?></a></td>
    <td><?=$rs[TEL1]?></td>
    <td><?=$rs[REG_DATE]?></td>
    <td><a href=# onclick='중개회원작성("<?=$rs[USER_NO]?>");return false;'>[수정]</a></td>
    <td><a href=# class=sky_link>
      <input type=checkbox name=delete_no value=<?=$rs[USER_NO]?> class=check/>
    </a></td>
  </tr>
<?
}
if ( $cnt == 0 ) {
?>

  <tr>
    <td colspan=9>조회된 자료가 없습니다.</td>
  </tr>
<?
}
?>
<FORM id='pForm' name='pForm' METHOD=POST>
    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >

  <tr class=bb>
    <td colspan=9 class=c-align>
<?
echo pageTab ($page_tab);
?>
</form>
<!--     <img src=/img/bt_na04.gif width=16 height=16 align=absmiddle /><img src=/img/bt_na03.gif alt= width=16 height=16 align=absmiddle /> 1 . 2 . 3 . 4 . 5 <img src=/img/bt_na02.gif width=16 height=16 align=absmiddle /><img src=/img/bt_na01.gif alt= width=16 height=16 align=absmiddle />
 -->
     <a href='#' onclick='중개회원선택삭제();return false;'><img src=/img/bt_delete02.gif width=54 height=22 hspace=25 align=absmiddle /></a></td>
    </tr>
</table>