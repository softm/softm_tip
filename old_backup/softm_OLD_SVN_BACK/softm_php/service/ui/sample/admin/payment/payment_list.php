<?
require_once HOME_DIR . '/inc/form.inc';
require_once HOME_DIR . '/inc/var.inc';

$s_reg_date = !$s_reg_date?date('Y-m').'-01':$s_reg_date;
$e_reg_date = !$e_reg_date?getDateAdd (date('Y-m-d'), 'DAY', 7 ):$e_reg_date;

?>
<form id=sForm style=display:inline onsubmit='return 결제조회(1);'>
    <input type=submit style='position:absolute;top:-1999px'>
<table width=1000 border=0 cellspacing=0 cellpadding=0 id=search-box>
    <tr>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle>회원구분</td>
    <td ><span class=gray>
<?
    unset($user_levegory['9']);
    $creategory_setup['select'          ] = $s_user_level;
    $creategory_setup['prop_name'       ] = 's_user_level';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:95'"  ; // 스크립트
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
    <td width=100><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />결제방법 </td>
    <td>
<?
    $creategory_setup['select'          ] = $s_pay_method;
    $creategory_setup['prop_name'       ] = 's_pay_method';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $pay_methodegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $pay_methodegory);
?>
    </td>
    <td width=100><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />결제상태 </td>
    <td>
<?
    $creategory_setup['select'          ] = $s_payment_state;
    $creategory_setup['prop_name'       ] = 's_payment_state';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $payment_stategory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $payment_stategory);
?>
    </td>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />결제구분 </td>
    <td>
<?
    $creategory_setup['select'          ] = $s_pay_gb;
    $creategory_setup['prop_name'       ] = 's_pay_gb';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $pay_gbegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $pay_gbegory);
?>
    <A HREF=# onclick='결제조회(1);return false;'><img src=/img/bt_search.gif width=52 height=20 align=absmiddle></A></td>
    </tr>
    <tr>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle>검 색</td>
    <td colspan=3><span class=gray>
        <select name=s_gubun style=width:100px ;>
            <option value='USER_NAME'    <?=$s_gubun=='USER_NAME'?'selected':''?>>이름</option>
            <option value='USER_ID'      <?=$s_gubun=='USER_ID'?'selected':''?>>아이디</option>
            <option value='ADDRESS'      <?=$s_gubun=='ADDRESS'?'selected':''?>>주소</option>
            <option value='TEL1'         <?=$s_gubun=='TEL1'?'selected':''?>>핸드폰번호</option>
            <option value='COMPANY_NAME' <?=$s_gubun=='COMPANY_NAME'?'selected':''?>>업체명</option>
        </select>
    </span>
    <input type=text name=s_search id=s_search style='width:100px' value=<?=$s_search?>>
    <A HREF=# onclick='결제조회(1);return false;'><img src=/img/bt_search.gif width=52 height=20 align=absmiddle></A></td>
    <td width=100><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />기간별검색 </td>
    <td colspan=3><input type=text id=s_reg_date style='width:80px' value='<?=$s_reg_date?>' readonly>
     <a href=# onclick='displayCalendar($("s_reg_date"),"yyyy-mm-dd",this)'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a> -
    <input type=text id=e_reg_date style='width:80px' value='<?=$e_reg_date?>' readonly> <a href=# onclick='displayCalendar($("e_reg_date"),"yyyy-mm-dd",this)'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    </td>
    <td><img src=/img/bullet_p.gif width=21 height=21 align=absmiddle />결제형태 </td>
    <td>
<?
    $creategory_setup['select'          ] = $s_pay_add_gb;
    $creategory_setup['prop_name'       ] = 's_pay_add_gb';
    $creategory_setup['title'           ] = '-전체-'  ;
    $creategory_setup['script'          ] = "style='width:65'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $pay_add_gbegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $pay_add_gbegory);
?>
    </tr>

</table>
</form>
<table width=1000 border=0 cellpadding=0 cellspacing=0 id=list-box style='table-layout:fixed'>
<caption>
결제확인
</caption>

<?
include ( HOME_DIR . '/inc/page_tab.inc' ); // 페이지 탭
// 페이지 탭 설정
//echo '$totCnt : ' . $totCnt;
$page_tab['js_function' ] = '결제조회';
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

$where .= ( $s_direct_gb    ?" AND DIRECT_GB  = '". $s_direct_gb    . "'":"");
$where .= ( $s_pay_method   ?" AND PAY_METHOD = '". $s_pay_method   . "'":"");
$where .= ( $s_payment_state?" AND STATE      = '". $s_payment_state. "'":"");
$where .= ( $s_pay_gb       ?" AND PAY_GB     = '". $s_pay_gb       . "'":"");
$where .= ( $s_pay_add_gb   ?" AND PAY_ADD_GB = '". $s_pay_add_gb   . "'":"");

$where .= "AND LEFT(PAY_DATE,10) BETWEEN '". $s_reg_date . "' AND '". $e_reg_date . "'";

$sql = " SELECT "
     . " COUNT(*) "
     . " FROM "
     .  TB_PAYMENT . " "
     . " WHERE USER_LEVEL " . ( $s_user_level?"= '". $s_user_level . "'":"<>''")
     . ( $where ? $where :"" );
$totCnt = $db->simpleSQLQuery ($sql);
$page_tab['tot'      ] = $totCnt ;

$sql = " SELECT "
     . " * "
     . " FROM "
     .  TB_PAYMENT
     . " WHERE USER_LEVEL " . ( $s_user_level   ?"= '". $s_user_level    . "'":"<>''")
     . ( $where ? $where :"" )
     . " ORDER BY PAY_NO DESC"
     . " limit " . ( $page_tab['s'] - 1 ) . ", " . $cur_many;
//echo 'sql : ' . $sql . ' /<BR>';
?>
<colgroup>
    <col width="50"/> <!-- No          -->
    <col width="40"/> <!-- 회원        -->
    <col width="50"/> <!-- 아이디      -->
    <col width=""/> <!-- 이름/업체명 -->
    <col width="30"/><!-- 결제        -->
    <col width="50"/> <!-- 직거래      -->
    <col width="60"/> <!-- 결제방법    -->
    <col width="60"/> <!-- 옵션        -->
    <!-- <col width="65"/> --> <!-- 금액        -->
    <!-- <col width="65"/> --> <!-- 부가세      -->

    <col width="30"/> <!-- 기간        -->
    <col width="65"/> <!-- 총금액      -->
    <col width="50"/> <!-- 입금자     -->
    <col width="82"/><!-- 결제일자    -->
    <col width="82"/><!-- 승인일자    -->
    <col width="82"/><!-- 승인일자    -->
    <col width="30"/><!-- 상태        -->
    <col width="30"/><!-- 결제        -->
    <col width="30"/><!-- 체크        -->
</colgroup>
  <tr>
    <th>No</th>
    <th>회원</th>
    <th>아이디</th>
    <th>이름/업체명</th>
    <th>결제</th>
    <th>직거래</th>
    <th>결제방법</th>
    <th>옵션</th>
<!--     <th>금액</th>
    <th>부가세</th>
 -->
    <th>기간</th>
    <th>총금액</th>
    <th>입금자</th>
    <th>결제일자</th>
    <th>승인일자</th>
    <th>만료일자</th>
    <th>결제</th>
    <th>수정</th>
    <th><input type=checkbox class=check onclick='toggleCheckBox(this,"chk_pay_no");'/></th>
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
    <td title='<?=$rs[PAY_NO]?>'><?=sprintf('%02d',$print_no)?></td>
    <td><?=$user_levegory[$rs[USER_LEVEL]]?>&nbsp;</td>
    <td><?=$rs[USER_ID]?></td>
    <td style='text-align:left' title="<?=$rs[USER_NAME] . ($rs[USER_LEVEL]==2?'('.$rs[COMPANY_NAME].')':'') ?>"><div class='textOf' style="width:155;" title=''><nobr><?=$rs[USER_NAME] . ($rs[USER_LEVEL]==2?'('.$rs[COMPANY_NAME].')':'') ?></nobr></div></td>
    <td><?=$pay_add_gbegory[$rs[PAY_ADD_GB]]?>&nbsp;</td>
    <td><?=$direct_gbegory[$rs[DIRECT_GB]]?>&nbsp;</td>
    <td><?=($pay_methodegory[$rs[PAY_METHOD]])?>&nbsp;</td>
    <td><?=$rs[OPT_PREMIUM]=='Y'?'<img src=../img/pay/bullet_P.gif>':''?>
        <?=$rs[OPT_HOT    ]=='Y'?'<img src=../img/pay/bullet_H.gif>':''?>
        <?=$rs[OPT_SPEED  ]=='Y'?'<img src=../img/pay/bullet_S.gif>':''?>&nbsp;</td>
<!--     <td><?=number_format($rs[AMOUNT])?>&nbsp;</td>
    <td><?=number_format($rs[SURTAX])?>&nbsp;</td> -->
    <td><?=number_format($rs[PERIOD])?>&nbsp;</td>
    <td><?=number_format($rs[TOT_AMOUNT])?>&nbsp;</td>
    <td><div class='textOf' style="width:50;" title='<?=$rs[IN_NAME]?>'><nobr><?=$rs[IN_NAME]?></nobr></div></td>
    <td><?=substr($rs[PAY_DATE],5,11)?>&nbsp;</td>
    <td><?=substr($rs[CONFIRM_DATE],5,11)?>&nbsp;</td>
    <td><?=substr($rs[END_DATE    ],5,11)?>&nbsp;</td>
    <td><?=($payment_stategory[$rs[STATE]])?>&nbsp;</td>
    <td><a href='#' onclick='결제작성(<?=$rs[PAY_NO]?>);return false;'>수정</a></td>
    <td><a href=# class=sky_link>
<!--<?=($rs[STATE]=='R'?'':'disabled')?>-->
      <input type=checkbox name=chk_pay_no value=<?=$rs[PAY_NO]?> class=check />
    </a></td>
  </tr>

<?
}
if ( $cnt == 0 ) {
?>

  <tr>
    <td colspan=16>조회된 자료가 없습니다.</td>
  </tr>
<?
}
?>

  <tr class=bb>
    <td colspan=7 class=c-align>
<form id='pForm' name='pForm' METHOD=POST>
    <input name='s'     type='hidden' value='<?=$s?>'    >
    <input name='tot'   type='hidden' value='<?=$tot?>'  >
</form>
<?
echo pageTab ($page_tab);
?>
<!--     <img src=/img/bt_na04.gif width=16 height=16 align=absmiddle /><img src=/img/bt_na03.gif alt= width=16 height=16 align=absmiddle /> 1 . 2 . 3 . 4 . 5 <img src=/img/bt_na02.gif width=16 height=16 align=absmiddle /><img src=/img/bt_na01.gif alt= width=16 height=16 align=absmiddle />
 -->
     </td>
    <td colspan=9 style='text-align:right'>
<?
    $creategory_setup['select'          ] = $p_chg_state;
    $creategory_setup['prop_name'       ] = 'p_chg_state';
    $creategory_setup['title'           ] = ''  ;
    $creategory_setup['script'          ] = "style='width:55'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $payment_stategory['setup'] = $creategory_setup;
    $payment_stategory['D'] = '삭제';
    unset($payment_stategory['R']);

    echo createGory ('SELECT', $payment_stategory);
?>
&nbsp;<button href='#' onclick='결제선택상태수정();return false;'>변경</button>
     </td>
    </tr>

</table>