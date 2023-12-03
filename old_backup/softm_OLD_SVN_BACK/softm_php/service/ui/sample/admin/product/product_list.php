<?
require_once HOME_DIR . '/inc/form.inc';
require_once HOME_DIR . '/inc/var.inc';

$s_reg_date = !$s_reg_date?date('Y-m').'-01':$s_reg_date;
$e_reg_date = !$e_reg_date?getDateAdd (date('Y-m-d'), 'DAY', 7 ):$e_reg_date;
$s_on_date_search= !$s_on_date_search?'N':$s_on_date_search;
?>
<form id=sForm style=display:inline onsubmit='return 매물조회(1);'>
    <input type=submit style='position:absolute;top:-1999px'>
<table width=1000 border=0 cellspacing=0 cellpadding=0 id=search-box>
<colgroup>
    <col width='90'/>
    <col width='75'/>
    <col width='100'/>
    <col width='70'/>
    <col width='85'/>
    <col width='120'/>
    <col width='80'/>
    <col width='60'/>
    <col width='80'/>
    <col width='40'/>
</colgroup>

    <tr>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle>회원구분</td>
    <td ><span class=gray>
<?
    unset($user_levegory['9']);
    $creategory_setup['select'          ] = $s_user_level;
    $creategory_setup['prop_name'       ] = 's_user_level';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:60'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $user_levegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $user_levegory);
?>
    </span>
    </td>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle>직거래구분</td>
    <td ><span class=gray>

<?
    $creategory_setup['select'          ] = $s_direct_gb;
    $creategory_setup['prop_name'       ] = 's_direct_gb';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $direct_gbegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $direct_gbegory);
?>

    </span>
    </td>
    <td width=100><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />매물종류 </td>
    <td>
<?
    $creategory_setup['select'          ] = $s_prod_gb;
    $creategory_setup['prop_name'       ] = 's_prod_gb';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:105'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $prod_gbegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $prod_gbegory);
?>
    </td>
    <td width=100><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />거래유형 </td>
    <td>
<?
    $creategory_setup['select'          ] = $s_trade_gb;
    $creategory_setup['prop_name'       ] = 's_trade_gb';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $trade_gbegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $trade_gbegory);
?>
    </td>
    <td></td>
    <td>

    </td>
    </tr>


    <tr>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />매물상태 </td>
    <td>
<?
    $creategory_setup['select'          ] = $s_state;
    $creategory_setup['prop_name'       ] = 's_state';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $prod_stategory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $prod_stategory);
?>
    </td>

    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />거래상태 </td>
    <td>
<?
    $creategory_setup['select'          ] = $s_trade_state;
    $creategory_setup['prop_name'       ] = 's_trade_state';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $trade_stategory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $trade_stategory);
?>
    </td>

    <td></td>
    <td></td>
    </tr>

    <tr>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle>사이검색</td>
    <td colspan=3><span class=gray>
        <select name=s_gubun2 style=width:95px ;>
            <option value='COST1'                 <?=$s_gubun2=='COST1'         ?'selected':''?>>매매가    </option>
            <option value='COST2'                 <?=$s_gubun2=='COST2'         ?'selected':''?>>융자      </option>
            <option value='COST3'                 <?=$s_gubun2=='COST3'         ?'selected':''?>>임대보증금</option>
            <option value='COST4'                 <?=$s_gubun2=='COST4'         ?'selected':''?>>임대월세  </option>
            <option value='ROOM_CNT1'             <?=$s_gubun2=='ROOM_CNT1'     ?'selected':''?>>방갯수    </option>
            <option value='ROOM_CNT2'             <?=$s_gubun2=='ROOM_CNT2'     ?'selected':''?>>욕실갯수  </option>
            <option value='SCALE1'                <?=$s_gubun2=='SCALE1'        ?'selected':''?>>공급면적  </option>
            <option value='SCALE2'                <?=$s_gubun2=='SCALE2'        ?'selected':''?>>전용면적  </option>
            <option value='FLOOR1'                <?=$s_gubun2=='FLOOR1'        ?'selected':''?>>해당층    </option>
            <option value='FLOOR2'                <?=$s_gubun2=='FLOOR2'        ?'selected':''?>>총층      </option>
            <option value='HOUSEHOLD_NUM1'        <?=$s_gubun2=='HOUSEHOLD_NUM1'?'selected':''?>>총세대수  </option>
            <option value='HOUSEHOLD_NUM2'        <?=$s_gubun2=='HOUSEHOLD_NUM2'?'selected':''?>>총동수    </option>
            <option value='PARKING_CNT1'          <?=$s_gubun2=='PARKING_CNT1'  ?'selected':''?>>주차대수  </option>
        </select>
    </span>
    <input type=text name=s_search2_1 id=s_search2_1 style='width:40px' value=<?=$s_search2_1?>>
    -
    <input type=text name=s_search2_2 id=s_search2_2 style='width:40px' value=<?=$s_search2_2?>>
    <A HREF=# onclick='매물조회(1);return false;'><img src=/img/bt_search.gif width=52 height=20 align=absmiddle></A>
    </td>

    <td width=100><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />입주/신축 </td>
    <td colspan=5>
        <select name=s_directin_yn id=s_directin_yn style=width:95px ;>
            <option value=''    <?=$s_directin_yn==''   ?'selected':''?>>-즉시입주-</option>
            <option value='Y'   <?=$s_directin_yn=='Y'  ?'selected':''?>>Yes</option>
            <option value='N'   <?=$s_directin_yn=='N'  ?'selected':''?>>No </option>
        </select>
        <select name=s_new_yn id=s_new_yn style=width:95px ;>
            <option value=''    <?=$s_new_yn==''   ?'selected':''?>>-신축-</option>
            <option value='Y'   <?=$s_new_yn=='Y'  ?'selected':''?>>Yes</option>
            <option value='N'   <?=$s_new_yn=='N'  ?'selected':''?>>No </option>
        </select>

    <A HREF=# onclick='매물조회(1);return false;'><img src=/img/bt_search.gif width=52 height=20 align=absmiddle></A>
    </td>
    </tr>

    <tr>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle>검 색</td>
    <td colspan=3><span class=gray>
        <select name=s_gubun style=width:95px ;>
            <option value='USER_NAME'           <?=$s_gubun=='USER_NAME'        ?'selected':''?>>이름       </option>
            <option value='USER_ID'             <?=$s_gubun=='USER_ID'          ?'selected':''?>>아이디     </option>
            <option value='ADDRESS'             <?=$s_gubun=='ADDRESS'          ?'selected':''?>>주소       </option>
            <option value='TEL1'                <?=$s_gubun=='TEL1'             ?'selected':''?>>핸드폰번호 </option>
            <option value='COMPANY_NAME'        <?=$s_gubun=='COMPANY_NAME'     ?'selected':''?>>업체명     </option>
            <option value='IN_DATE'             <?=$s_gubun=='IN_DATE'          ?'selected':''?>>입주가능일 </option>
            <option value='BUILD_YEAR'          <?=$s_gubun=='BUILD_YEAR'       ?'selected':''?>>중공연도   </option>
            <option value='HOUSE_NUM'           <?=$s_gubun=='HOUSE_NUM'        ?'selected':''?>>해당동     </option>
            <option value='DIRECTION'           <?=$s_gubun=='DIRECTION'        ?'selected':''?>>방향       </option>
            <option value='BUILDING_COMPANY'    <?=$s_gubun=='BUILDING_COMPANY' ?'selected':''?>>건설사     </option>
            <option value='IN_YEAR'             <?=$s_gubun=='IN_YEAR'          ?'selected':''?>>입주년도   </option>
            <option value='HEATING_METHOD'      <?=$s_gubun=='HEATING_METHOD'   ?'selected':''?>>난방방식   </option>
            <option value='FEATURE'             <?=$s_gubun=='FEATURE'          ?'selected':''?>>매물특징   </option>
        </select>
    </span>
    <input type=text name=s_search id=s_search style='width:100px' value=<?=$s_search?>>
    <A HREF=# onclick='매물조회(1);return false;'><img src=/img/bt_search.gif width=52 height=20 align=absmiddle></A></td>
    <td width=100><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />기간별검색 </td>
    <td colspan=5>
        <select name=s_date_gubun id=s_date_gubun style=width:95px ;>
            <option value=''            <?=$s_date_gubun=='REG_DATE'   ?'selected':''?>>전체    </option>
            <option value='REG_DATE'    <?=$s_date_gubun=='REG_DATE'   ?'selected':''?>>작성일자</option>
            <option value='MOD_DATE'    <?=$s_date_gubun=='MOD_DATE'   ?'selected':''?>>수정일자</option>
            <option value='START_DATE'  <?=$s_date_gubun=='START_DATE' ?'selected':''?>>승인일자</option>
            <option value='EXPIRE_DATE' <?=$s_date_gubun=='EXPIRE_DATE'?'selected':''?>>만료일자</option>
        </select>

    <input type=text id=s_reg_date style='width:80px' value='<?=$s_reg_date?>' readonly>
     <a href=# onclick='displayCalendar($("s_reg_date"),"yyyy-mm-dd",this)'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a> -
    <input type=text id=e_reg_date style='width:80px' value='<?=$e_reg_date?>' readonly> <a href=# onclick='displayCalendar($("e_reg_date"),"yyyy-mm-dd",this)'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    기간검색사용<input type=checkbox name=s_on_date_search id=s_on_date_search <?=$s_on_date_search=='Y' ?'checked':''?> onclick='disableDateSearch(this);'>

    </td>

    </tr>

</table>
</form>
<table width=1000 border=0 cellpadding=0 cellspacing=0 id=list-box>
<caption>
매물조회
</caption>

<?
include ( HOME_DIR . '/inc/page_tab.inc' ); // 페이지 탭
// 페이지 탭 설정
//echo '$totCnt : ' . $totCnt;
$page_tab['js_function' ] = '매물조회';
$page_tab['s'        ] = !$s?1:(int)$s;
$page_tab['how_many' ] = 10;
$page_tab['more_many'] = 10;
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

$where  = " WHERE USER_LEVEL " . ( $s_user_level?"= '". $s_user_level . "'":"<>''");
$where .= ( $s_direct_gb    ?" AND DIRECT_GB    = '". $s_direct_gb  . "'":"");
$where .= ( $s_prod_gb      ?" AND PROD_GB      = '". $s_prod_gb    . "'":"");
$where .= ( $s_trade_gb     ?" AND TRADE_GB     = '". $s_trade_gb   . "'":"");
$where .= ( $s_state        ?" AND STATE        = '". $s_state      . "'":"");
$where .= ( $s_trade_state  ?" AND TRADE_STATE  = '". $s_trade_state. "'":"");
$where .= ( $s_exfire_yn    ?" AND EXFIRE_YN    = '". $s_exfire_yn  . "'":"");

if ( $s_search2_1 || $s_search2_2 ) {
    if ( $s_search2_1 && $s_search2_2 ) {
        $where .= " AND $s_gubun2 BETWEEN '" . $s_search2_1 . "' AND '" . $s_search2_2 . "'";
    } else if ( $s_search2_1 && !$s_search2_2 ) {
        $where .= " AND $s_gubun2 >= " . $s_search2_1 . "";
    } else if ( !$s_search2_1 && $s_search2_2 ) {
        $where .= " AND $s_gubun2 <= '" . $s_search2_2 . "'";
    }
}

$where .= ( $s_directin_yn  ?" AND DIRECTIN_YN  = '". $s_directin_yn  . "'":"");
$where .= ( $s_new_yn       ?" AND NEW_YN       = '". $s_new_yn       . "'":"");

if ( $s_search ) {
    if ( $s_gubun == 'USER_NAME' ) {
        $where .= " AND USER_NAME LIKE '" . $s_search. "%'";
    } else if ( $s_gubun == 'USER_ID' ) {
        $where .= " AND USER_ID LIKE '" . $s_search. "%'";
    } else if ( $s_gubun == 'ADDRESS' ) {
        $where .= " AND ADDRESS1 LIKE '%" . $s_search. "%' OR ADDRESS2 LIKE '%" . $s_search. "%'";
    } else if ( $s_gubun == 'TEL1' ) {
        $where .= " AND TEL1 LIKE '" . $s_search. "%'";
    } else if ( $s_gubun == 'COMPANY_NAME' ) {
        $where .= " AND COMPANY_NAME LIKE '%" . $s_search. "%'";
    } else if ( $s_gubun == 'IN_DATE' || $s_gubun == 'BUILD_YEAR' || $s_gubun == 'HOUSE_NUM' || $s_gubun == 'DIRECTION' ||
                $s_gubun == 'BUILDING_COMPANY' || $s_gubun == 'IN_YEAR' || $s_gubun == 'HEATING_METHOD' || $s_gubun == 'FEATURE') {
        $where .= " AND $s_gubun LIKE '%" . $s_search . "%'";
    }
}
if ( $s_on_date_search == 'Y' ) {
    if ( !$s_date_gubun ) {
        $where .= " AND ( LEFT(REG_DATE   ,10) BETWEEN '". $s_reg_date . "' AND '". $e_reg_date . "' OR";
        $where .= "       LEFT(MOD_DATE   ,10) BETWEEN '". $s_reg_date . "' AND '". $e_reg_date . "' )";
      //$where .= "      LEFT(START_DATE ,10) BETWEEN '". $s_reg_date . "' AND '". $e_reg_date . "' OR";
      //$where .= "      LEFT(EXPIRE_DATE,10) BETWEEN '". $s_reg_date . "' AND '". $e_reg_date . "' )";
    } else {
        $where .= " AND LEFT($s_date_gubun,10) BETWEEN '". $s_reg_date . "' AND '". $e_reg_date . "'";
    }
}
$sql = " SELECT "
     . " COUNT(*) "
     . " FROM "
     .  TB_PRODUCT_TMP . " "
     . ( $where ? $where :"" );
//echo 'sql : ' . $sql . ' /<BR>';
$totCnt = $db->simpleSQLQuery ($sql);
$page_tab['tot'      ] = $totCnt ;

$sql = " SELECT "
     . " * "
     . " FROM "
     .  TB_PRODUCT_TMP
     . ( $where ? $where :"" )
     . " ORDER BY PROD_NO DESC"
     . " limit " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;
//echo 'sql : ' . $sql . ' /<BR>';
?>
<colgroup>
    <col width="50"/><!-- No           -->
    <col width="40"/><!-- 회원         -->
    <col width="50"/><!-- 아이디       -->
    <col width=""  /><!-- 이름/업체명  -->
    <col width="50"/><!-- 직거래       -->
    <col width="105"/><!-- 매물종류     -->
    <col width="60"/><!-- 거래유형     -->
    <col width="120"/><!-- 주소         -->
    <col width="65"/><!-- 옵션         -->
    <col width="65"/><!-- 매매가       -->
    <col width="60"/><!-- 상태         -->
    <col width="65"/><!-- 히스토리     -->
    <col width="65"/><!-- 연장         -->
    <col width="40"/><!-- 수정         -->
</colgroup>
  <tr>
    <th>No          </th>
    <th>회원        </th>
    <th>아이디      </th>
    <th>이름/업체명 </th>
    <th>직거래      </th>
    <th>매물종류    </th>
    <th>거래유형    </th>
    <th>주소        </th>
    <th>옵션        </th>
    <th>매매가      </th>
    <th>상태        </th>
    <th>히스토리    </th>
    <th>연장        </th>
    <th>수정        </th>
    <th><input type=checkbox class=check onclick='toggleCheckBox(this,"chk_prod_no");'/></th>
  </tr>
<?
$stmt = $db->multiRowSQLQuery ($sql);
$cnt = 0;
$print_no = $totCnt - $page_tab['s'] + 2; // 현재 보여지는 번호.
while ( $rs = $db->multiRowFetch  ($stmt) ) {
    $cnt++;
    $print_no--;
?>
  <tr>
    <td title='<?=$rs[PROD_NO] . ' / ' . $rs[HEAD_TITLE]?>'><?=sprintf('%02d',$print_no)?></td>
    <td><?=$user_levegory[$rs[USER_LEVEL]]?>&nbsp;</td>
    <td><?=$rs[USER_ID]?></td>
    <td style='text-align:left'><div class='textOf' style="width:200;" title=''><nobr><?=$rs[USER_NAME] . ($rs[USER_LEVEL]==2?'('.$rs[COMPANY_NAME].')':'') ?></nobr></div></td>
    <td><?=$direct_gbegory[$rs[DIRECT_GB]]?>&nbsp;</td>
    <td><?=($prod_gbegory[$rs[PROD_GB]])?>&nbsp;</td>
    <td><?=($trade_gbegory[$rs[TRADE_GB]])?>&nbsp;</td>
    <td><div class='textOf' style="width:120;" title='<?=$rs[ADDRESS1]?> <?=$rs[ADDRESS2]?>'><nobr><?=$rs[ADDRESS1]?> <?=$rs[ADDRESS2]?></nobr></div>

    <td><?=$rs[OPT_PREMIUM]=='Y'?'<img src=../img/pay/bullet_P.gif>':''?>
        <?=$rs[OPT_HOT    ]=='Y'?'<img src=../img/pay/bullet_H.gif>':''?>
        <?=$rs[OPT_SPEED  ]=='Y'?'<img src=../img/pay/bullet_S.gif>':''?>&nbsp;</td>

    <td><?=number_format($rs[COST1])?></td>
    <td><?=($prod_stategory[$rs[STATE]])?></td>

    <td><a href='#' onclick='매물히스토리보기(<?=$rs[PROD_NO]?>);return false;'>보기</a></td>
    <td><a href='#' onclick='매물기간연장();return false;'>연장</a></td>
    <td><a href='#' onclick='매물작성(<?=$rs[PROD_NO]?>);return false;'>수정</a></td>
    <td><a href=# class=sky_link>
<!--  -->
      <input type=checkbox name=chk_prod_no value=<?=$rs[PROD_NO]?> class=check/>
    </a></td>
  </tr>

<?
}
if ( $cnt == 0 ) {
?>

  <tr>
    <td colspan=14>조회된 자료가 없습니다.</td>
  </tr>
<?
}
?>


  <tr class=bb>
    <td colspan=6 class=c-align>
<FORM id='pForm' name='pForm' METHOD=POST style='display:inline'>
    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >
<?
echo pageTab ($page_tab);
?>
<!--     <img src=/img/bt_na04.gif width=16 height=16 align=absmiddle /><img src=/img/bt_na03.gif alt= width=16 height=16 align=absmiddle /> 1 . 2 . 3 . 4 . 5 <img src=/img/bt_na02.gif width=16 height=16 align=absmiddle /><img src=/img/bt_na01.gif alt= width=16 height=16 align=absmiddle />
 -->
</form>
     </td>
    <td colspan=8 style='text-align:right'>

선택된 매물을
    <input type=text id=p_state_date style='width:85px' value='<?=!$p_state_date?date('Y-m-d H:i'):$p_chg_date?>' readonly>
    <a href=# onclick='displayCalendar($("p_state_date"),"yyyy-mm-dd hh:ii",this,true)'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
시간을 기준으로
<?
    $creategory_setup['select'          ] = $p_chg_state;
    $creategory_setup['prop_name'       ] = 'p_chg_state';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = "style='width:80'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $prod_stategory['setup'] = $creategory_setup;
    $prod_stategory['D'] = '삭제';
    echo createGory ('SELECT', $prod_stategory);
?>
로 변경합니다.
     <button href='#' onclick='매물선택상태수정();return false;'>변경</button>
     </td>
    </tr>

</table>