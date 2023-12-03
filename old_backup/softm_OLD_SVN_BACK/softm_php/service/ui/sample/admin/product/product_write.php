<?
require_once HOME_DIR . '/inc/form.inc';
require_once HOME_DIR . '/inc/var.inc';
require_once HOME_DIR . '/inc/var_database.inc';
require_once HOME_DIR . '/inc/file.inc'          ;
require_once SERVICE_DIR . '/common/Session.php' ; // 변수

if ( $mode == 'U' ) {
    $sql = " SELECT * FROM " . TB_PRODUCT_TMP
         . " WHERE PROD_NO = '" . $p_prod_no . "'";
    //echo 'sql : ' . $sql . ' /<BR>';
    $rs = $db->singleRowSQLQuery ($sql);
}
$memInfor = Session::getSession();
if ( $memInfor[login_yn] == "Y" ) {
?>
<form id=wForm name=wForm enctype="multipart/form-data" method="post">
    <input name="exec_mode"     type="hidden" value='PROD_WRITE'>
    <input name="mode"          type="hidden" value='<?=$mode?>'>
    <input name="prod_no"       type="hidden" value='<?=$p_prod_no?>'>

    <input name="x1"               id="x1"            type="hidden" value='<?=$rs[X1]?>'     >
    <input name="y1"               id="y1"            type="hidden" value='<?=$rs[Y1]?>'     >
    <input name="x2"               id="x2"            type="hidden" value='<?=$rs[X2]?>'     >
    <input name="y2"               id="y2"            type="hidden" value='<?=$rs[Y2]?>'     >

    <input name="pay_no"           id="pay_no"        type="hidden" value='<?=$rs[PAY_NO]?>'     >

<table width="1000" border="0" cellpadding="0" cellspacing="0" id="details-box">
<caption>
매물 정보<?=$mode=='I'?'입력':'수정'?>
</caption>

  <tr>
    <td width="100%" colspan=4>
        <span id='msg' style='width:100%;top:130;left:1200;font-weight:bold;color:#CC0000'>&nbsp;</span>
    </td>
  </tr>
  <tr>
    <td class="bg-s">글머리</td>
    <td colspan="3"><input type="text" name="head_title" id="head_title" style="width:700px" value='<?=$rs[HEAD_TITLE]?>' onchange='setChanged();'/></td>
  </tr>
  <tr>
    <td class="bg-s">ID</td>
    <td><input type="text" name="p_user_id" id="p_user_id" style="width:120px" value='<?=$mode=='I'?$memInfor[user_id]:$rs[USER_ID]?>' <?=$mode=='I'?' onblur="아이디조회(this.value)"':'readonly'?>>
        <input type="hidden" name="p_user_no" id="p_user_no" value='<?=$rs[USER_NO]?>'>
<?
    $creategory_setup['select'          ] = $rs[USER_LEVEL];
    $creategory_setup['prop_name'       ] = 'p_user_level';
    $creategory_setup['title'           ] = '-선택-'  ;
    $creategory_setup['script'          ] = "style='width:75;display:none'"  ; // 스크립트
    $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
    $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
    $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
    $user_levegory['setup'] = $creategory_setup;
    echo createGory ('SELECT', $user_levegory);
?>
[ <span id=d_user_level style='font-weight:bold'><?=$user_levegory[$rs[USER_LEVEL]]?></span> ]
    </td>
    <td class="bg-s">전화번호</td>
    <td width="505"><span class="gray">
<?
$tel2 = $rs[TEL2];
$tel2Info = split('-',$tel2);
$creategory_setup['select'          ] = $tel2Info[0]?$tel2Info[0]:'02';
$creategory_setup['prop_name'       ] = 'tel2_1';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:50px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$telegory['setup'] = $creategory_setup;
echo createGory ('SELECT', $telegory);
?>
-
<input name="tel2_2" id="tel2_2" type="text" style="width:50px ;" onpropertychange='enforceNumber()' maxlength=4 value='<?=$tel2Info[1]?>' onchange='setChanged();'>
-
<input name="tel2_3" id="tel2_3" type="text" style="width:50px ;" onpropertychange='enforceNumber()' maxlength=4 value='<?=$tel2Info[2]?>' onchange='setChanged();'>
    </span></td>
  </tr>
  <tr>
    <td width="120" class="bg-s">판매자</td>
    <td width="253"><input type="text" name="p_user_name"   id="p_user_name"    style="width:60px"  value='<?=$mode=='I'?$memInfor[user_name]:$rs[USER_NAME]?>' onchange='setChanged();'/> / 
                    <input type="text" name="company_name"  id="company_name"   style="width:150px"  value='<?=$mode=='I'?$memInfor[COMPANY_NAME]:$rs[COMPANY_NAME]?>' onchange='setChanged();'/>
    </td>
    <td width="120" class="bg-s">핸드폰</td>
    <td><span class="gray">
<?
$tel1 = $rs[TEL1];
$tel1Info = split('-',$tel1);

$creategory_setup['select'          ] =  $tel1Info[0]?$tel1Info[0]:'011';
$creategory_setup['prop_name'       ] = 'tel1_1';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:50px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$hpegory['setup'] = $creategory_setup;
echo createGory ('SELECT', $hpegory);
?>
-
<input name="tel1_2" id="tel1_2" type="text" style="width:50px ;" onpropertychange='enforceNumber()' maxlength=4 value='<?=$tel1Info[1]?>' onchange='setChanged();'>
-
<input name="tel1_3" id="tel1_3" type="text" style="width:50px ;" onpropertychange='enforceNumber()' maxlength=4 value='<?=$tel1Info[2]?>' onchange='setChanged();'>
    </span></td>
  </tr>
  <tr>
    <td class="bg-s">주소</td>
    <td colspan="3">
    <input type="text" name="post_no" id="post_no" style="width:50px" value='<?=$rs[POST_NO]?>' readonly onchange='setChanged();'/>
    <input type="text" name="address1" id="address1" style="width:250px" value='<?=$rs[ADDRESS1]?>' readonly onchange='setChanged();'/>
     <a href='#' id='post_btn' onclick='setChanged();openWindow("../common/post_search_pop.php", 320, 170,"ppWin");return false;'><img src="/img/bt_address.gif" align="absmiddle"></a>
    <img src="/img/bt_map.gif" width="65" height="22" hspace="5" align="absmiddle" />
     </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input type="text" name="address2" id="address2" style="width:450px" value='<?=$rs[ADDRESS2]?>' onchange='setChanged();'/></td>
  </tr>

  <tr>
    <td class="bg-s">매물유형</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[PROD_GB];
$creategory_setup['prop_name'       ] = 'prod_gb';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:120px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$prod_gbegory['setup'] = $creategory_setup;
echo createGory ('SELECT', $prod_gbegory);
?>
      <img src=/img/pay/bullet_P.gif alt='프리미엄매물' align=absmiddle><input name="opt_premium" id="opt_premium" type="checkbox" class="check" value="Y" onchange='setChanged();' <?=$rs[OPT_PREMIUM]=='Y'?'checked':''?>>
      <img src=/img/pay/bullet_H.gif alt='핫매물' align=absmiddle><input name="opt_speed" id="opt_speed" type="checkbox" class="check" value="Y" onchange='setChanged();' <?=$rs[OPT_SPEED]=='Y'?'checked':''?>>
      <img src=/img/pay/bullet_S.gif alt='스피드매물' align=absmiddle><input name="opt_hot" id="opt_hot" type="checkbox" class="check" value="Y" onchange='setChanged();' <?=$rs[OPT_HOT]=='Y'?'checked':''?>>

    </span></td>
    <td class="bg-s">조회수</td>
    <td><span class="gray">

<input name="read_cnt" id="read_cnt" type="text" style="width:100px ;"  value='<?=$rs[READ_CNT]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
    </span></td>
  </tr>

  <tr>
    <td class="bg-x">매물상태</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[STATE];
$creategory_setup['prop_name'       ] = 'state';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:60px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$prod_stategory['setup'] = $creategory_setup;
echo createGory ('SELECT', $prod_stategory);
?>
    </span></td>
    <td class="bg-x">작성/수정일자</td>
    <td><span class="gray">
    <input type=text name="reg_date" id=reg_date style='width:85px' value='<?=$rs[REG_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("reg_date"),"yyyy-mm-dd hh:ii",this,true);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
/
    <input type=text name="mod_date" id=mod_date style='width:85px' value='<?=$rs[MOD_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("mod_date"),"yyyy-mm-dd hh:ii",this,true);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    </span></td>
    </tr>

  <tr>
    <td class="bg-x">거래상태</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[TRADE_STATE];
$creategory_setup['prop_name'       ] = 'trade_state';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:70px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$trade_stategory['setup'] = $creategory_setup;
echo createGory ('SELECT', $trade_stategory);
?>
    </span></td>
    <td class="bg-x">거래시작/완료일자</td>
    <td><span class="gray">
    <input type=text name="start_date" id=start_date style='width:85px' value='<?=$rs[START_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("start_date"),"yyyy-mm-dd hh:ii",this,true);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
/
    <input type=text name="end_date" id=end_date style='width:85px' value='<?=$rs[END_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("end_date"),"yyyy-mm-dd hh:ii",this,true);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    </span></td>
    </tr>

  <tr>
    <td class="bg-x">만료여부</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[EXFIRE_YN];
$creategory_setup['prop_name'       ] = 'exfire_yn';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$yesnoegory['setup'] = $creategory_setup;
echo createGory ('RADIO', $yesnoegory);
?>
    </span></td>
    <td class="bg-x">만료일자</td>
    <td><span class="gray">
    <input type=text name="expire_date" id=expire_date style='width:85px' value='<?=$rs[EXPIRE_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("expire_date"),"yyyy-mm-dd hh:ii",this,true);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    </span></td>
    </tr>

  <tr>
    <td class="bg-s">직거래구분</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[DIRECT_GB];
$creategory_setup['prop_name'       ] = 'direct_gb';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:120px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$direct_gbegory['setup'] = $creategory_setup;
echo createGory ('SELECT', $direct_gbegory);
?>
    </span></td>
    <td class="bg-s">거래유형</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[TRADE_GB];
$creategory_setup['prop_name'       ] = 'trade_gb';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:150px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$trade_gbegory['setup'] = $creategory_setup;
echo createGory ('SELECT', $trade_gbegory);
?>

    </span></td>
  </tr>

  <tr>
    <td class="bg-s">가격</td>
    <td colspan="3"><span class="gray">매매가:
      <input name="cost1" id="cost1" type="text" style="width:100px ;"  value='<?=$rs[COST1]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
      융자금:
      <input name="cost2" id="cost2" type="text" style="width:100px ;"  value='<?=$rs[COST2]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
      임대보증금:
      <input name="cost3" id="cost3" type="text" style="width:100px ;"  value='<?=$rs[COST3]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
      임대월세:
      <input name="cost4" id="cost4" type="text" style="width:100px ;"  value='<?=$rs[COST4]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
    </span><span class="green"> ※ 단위 만원</span></td>
  </tr>
  <tr>
    <td class="bg-b">입주가능일</td>
    <td><span class="gray">
    <input type=text name="in_date" id=in_date style='width:80px' value='<?=date('Y-m-d')?>' readonly value='<?=$rs[IN_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("in_date"),"yyyy-mm-dd",this);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    </span></td>
    <td class="bg-b">방/욕실 수</td>
    <td>방<span class="gray">
      <input name="room_cnt1" id="room_cnt1" type="text" style="width:50px;"  value='<?=$rs[ROOM_CNT1]?>' onpropertychange='enforceNumber()' maxlength='2' onchange='setChanged();'/>
      개 / 욕실
      <input name="room_cnt2" id="room_cnt2" type="text" style="width:50px;"  value='<?=$rs[ROOM_CNT2]?>' onpropertychange='enforceNumber()' maxlength='2' onchange='setChanged();'/>
      개</span></td>
  </tr>
  <tr>
    <td class="bg-b">공급면적</td>
    <td><span class="gray">
      <input name="scale1" id="scale1" type="text" style="width:50px;"  value='<?=$rs[SCALE1]?>' onpropertychange='enforceNumber(true)' maxlength='5' onchange='setChanged();'/>
      ㎡</span></td>
    <td class="bg-b">전용면적</td>
    <td><span class="gray">
      <input name="scale2" id="scale2" type="text" style="width:50px;"  value='<?=$rs[SCALE2]?>' onpropertychange='enforceNumber(true)' maxlength='5' onchange='setChanged();'/>
      ㎡</span></td>
  </tr>
  <tr>
    <td class="bg-b">준공연도</td>
    <td><span class="gray">
      <input name="build_year" id="build_year" type="text" style="width:100px;"  value='<?=$mode=='I'?date('Y')-4:$rs[BUILD_YEAR]?>' onpropertychange='enforceNumber()' maxlength='4' onchange='setChanged();'/>
      </span>년 &nbsp; <span class="green">※신축</span>
        <input name="new_yn" id="new_yn" type="checkbox" class="check" value="Y" <?=($rs[NEW_YN]=='Y'?'checked':'')?> onchange='setChanged();'/>
      </td>
    <td class="bg-b">해당층/총층</td>
    <td>해당층<span class="gray">
      <input name="floor1" id="floor1" type="text" style="width:50px;"  value='<?=$rs[FLOOR1]?>' onpropertychange='enforceNumber()' maxlength='3' onchange='setChanged();'/>
      층 / 총층
      <input name="floor2" id="floor2" type="text" style="width:50px;"  value='<?=$rs[FLOOR2]?>' onpropertychange='enforceNumber()' maxlength='3' onchange='setChanged();'/>
      층 </span></td>
  </tr>
  <tr>
    <td class="bg-b">해당동</td>
    <td><span class="gray">
      <input name="house_num" id="house_num" type="text" style="width:50px;" value='<?=$rs[HOUSE_NUM]?>' onchange='setChanged();'/>
      동</span></td>
    <td class="bg-b">방향</td>
    <td><span class="gray">
      <input name="direction" id="direction" type="text" style="width:100px;" value='<?=$rs[DIRECTION]?>' onchange='setChanged();'/>
    </span></td>
  </tr>
  <tr>
    <td class="bg-s">건설사</td>
    <td><input type="text" name="building_company" id="building_company" style="width:150px" value='<?=$rs[BUILDING_COMPANY]?>' onchange='setChanged();'/></td>
    <td class="bg-s">입주연도</td>
    <td><span class="gray">
      <input name="in_year" id="in_year" type="text" style="width:50px ;"  value='<?=$rs[IN_YEAR]?>' onpropertychange='enforceNumber()' maxlength='4' onchange='setChanged();'/>
    </span>년 </td>
  </tr>
  <tr>
    <td class="bg-s">총세대수</td>
    <td><span class="gray">
      <input name="household_num1" name="household_num1" type="text" style="width:100px ;" value='<?=$rs[HOUSEHOLD_NUM1]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
    </span></td>
    <td class="bg-s">동수</td>
    <td><span class="gray">
      <input name="household_num2" name="household_num2" type="text" style="width:100px ;" value='<?=$rs[HOUSEHOLD_NUM2]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
    </span></td>
  </tr>
  <tr>
    <td class="bg-s">난방방식</td>
    <td><input type="text" name="heating_method" id="heating_method" style="width:150px" value='<?=$rs[HEATING_METHOD]?>' onchange='setChanged();'/></td>
    <td class="bg-s">주차대수</td>
    <td><span class="gray"> 세대당
      <input name="parking_cnt1" id="parking_cnt1" type="text" style="width:50px ;"  value='<?=$rs[PARKING_CNT1]?>' onpropertychange='enforceNumber()' maxlength='3' onchange='setChanged();'/>
      대</span></td>
  </tr>
  <tr>
    <td class="bg-s">단지내 시설</td>
    <td colspan="3"><input type="text" name="facilities" id="facilities" style="width:700px" value='<?=$rs[FACILITIES]?>' onchange='setChanged();'/></td>
  </tr>
  <tr>

    <td class="bg-s">단지배치도</td>
    <td colspan="3"><input type="file" name="block_plan" id="block_plan" style="width:450px" onchange='setChanged();'/> <?=$rs[BLOCK_PLAN]?'<a href=# onclick=\'imagePreview("/data/prod/images/block_plan/' . sprintf('%08d.' . getFileExtraName($rs[BLOCK_PLAN]), $rs[PROD_NO]) . '",$("image_preview"));return false;\'>' . $rs[BLOCK_PLAN] . '</a> <input type=checkbox name=del_block_plan value=Y onclick="setChanged();"> 삭제':''?>
        <!-- <img src="/img/bt_file.gif" width="80" height="22" align="absmiddle" /> -->
    </td>

        <div id="image_preview" style="position:absolute;top:710;left:800;border:1px solid #D7D7D7; width:200px; height:170px; text-align:center; overflow:hidden;"></div>
  </tr>
  <tr>
    <td class="bg-s">평면도</td>
    <td colspan="3"><input type="file" name="ground_plan" id="ground_plan" style="width:450px" onchange='setChanged();'/> <?=$rs[GROUND_PLAN]?'<a href=# onclick=\'imagePreview("http://' . $_SERVER["SERVER_NAME"]. '/data/prod/images/ground_plan/' . sprintf('%08d.' . getFileExtraName($rs[GROUND_PLAN]), $rs[PROD_NO]) . '",$("image_preview"));return false;\'>' . $rs[GROUND_PLAN] . '</a> <input type=checkbox name=del_ground_plan value=Y onclick="setChanged();"> 삭제':''?></td>
  </tr>
<?
$sql =  " SELECT"
      . " a.SEQ        SEQ       ,"
      . " b.USER_NO    USER_NO   ,"
      . " b.PROD_NO    PROD_NO   ,"
      . " b.FILE_NAME  FILE_NAME ,"
      . " b.FILE_EXT   FILE_EXT  ,"
      . " b.FILE_SIZE  FILE_SIZE ,"
      . " b.REG_DATE   REG_DATE   "
      . " FROM"
      . " ("
      . " SELECT 1 SEQ UNION"
      . " SELECT 2 UNION"
      . " SELECT 3 UNION"
      . " SELECT 4 "
      . " ) a LEFT OUTER JOIN " . TB_IMAGE . " b"
      . " ON  a.SEQ = b.SEQ"
      . " AND b.USER_NO = '" . $rs[USER_NO] . "'"
      . " AND b.PROD_NO = '" . $rs[PROD_NO] . "'"
     . " ORDER BY a.SEQ";

//echo 'sql : ' . $sql . ' /<BR>';

$stmt = $db->multiRowSQLQuery ($sql);
while ( $rs2 = $db->multiRowFetch  ($stmt) ) {
    $seq = $rs2[SEQ];
?>
  <tr>
    <td class="bg-b">사진등록<?=$seq?></td>
    <td colspan="3"><input type="file" name="image<?=$seq?>" id="image<?=$seq?>" style="width:450px" onchange='setChanged();'/> <?=$rs2[FILE_NAME]?'<a href=# onclick=\'imagePreview("/data/prod/images/user/' . sprintf('%08d' . '_' . '%02d.' . $rs2[FILE_EXT], $rs2[PROD_NO], $rs2[SEQ]) . '",$("image_preview"));return false;\'>' . $rs2[FILE_NAME] . '.' . $rs2[FILE_EXT] . '</a> <input type=checkbox name=del_image' . $seq . ' value=Y onclick="setChanged();"> 삭제':''?></td>
  </tr>
<?
}
?>
  <tr>
    <td class="bg-s">매물특징</td>
    <td colspan="3"><textarea type="text" name="feature" id="feature" style="width:700px; height:80px" onchange='setChanged();'/><?=$rs[FEATURE]?></textarea></td>
  </tr>
  <tr>
    <td colspan="4" class="c-align"><a href='#' onclick='매물작성실행("<?=$mode?>");return false;'>
    <img src="/img/<?=$mode=='I'?'bt_enter.gif':'bt_edit.gif'?>" width="77" height="30" hspace="5">
    </a><a href='#' onclick='매물작성("<?=$rs[PROD_NO]?>");return false;'><img src="/img/bt_cancel.gif" width="77" height="30" hspace="5"></a></td>
  </tr>
</form>
<?
}
?>