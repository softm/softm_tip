<?
require_once HOME_DIR . '/inc/form.inc';
require_once HOME_DIR . '/inc/var.inc';
require_once HOME_DIR . '/inc/var_database.inc';
require_once HOME_DIR . '/inc/file.inc'          ;
require_once SERVICE_DIR . '/common/Session.php' ; // 변수

if ( $mode == 'U' ) {
    $sql = " SELECT * FROM " . TB_PAYMENT
         . " WHERE PAY_NO = '" . $p_pay_no . "'";
    //echo 'sql : ' . $sql . ' /<BR>';
    $rs = $db->singleRowSQLQuery ($sql);
}
$memInfor = Session::getSession();
?>
<form id=wForm name=wForm enctype="multipart/form-data" method="post">
    <input name="exec_mode"     type="hidden" value='PROD_WRITE'>
    <input name="mode"          type="hidden" value='<?=$mode?>'>
    <input name="pay_no"        type="hidden" value='<?=$p_pay_no?>'>

<table width="1000" border="0" cellpadding="0" cellspacing="0" id="details-box">
<caption>
결제 정보<?=$mode=='I'?'입력':'수정'?>
</caption>
  <tr>
    <td width="100%" colspan=4>
        <span id='msg' style='width:100%;top:130;left:1200;font-weight:bold;color:#CC0000'>&nbsp;</span>
    </td>
  </tr>
  <tr>
    <td class="bg-s" colspan=4 style='text-align:center;color:black'>결제 정보</td>
    </td>
  </tr>
  <tr>
    <td class="bg-s">결제구분/상태</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[PAY_GB];
$creategory_setup['prop_name'       ] = 'pay_gb';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:100px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$pay_gbegory['setup'] = $creategory_setup;
//echo createGory ('SELECT', $pay_gbegory);
echo $pay_gbegory[$rs[PAY_GB]] . '/<b>' . $pay_add_gbegory[$rs[PAY_ADD_GB]] . '</b>('  . $p_pay_no . ')';
?>
/
<?
$creategory_setup['select'          ] = $rs[STATE];
$creategory_setup['prop_name'       ] = 'state';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:100px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$payment_stategory['setup'] = $creategory_setup;
//echo createGory ('SELECT', $payment_stategory);
echo $payment_stategory[$rs[STATE]];

?>
   </span></td>
    <td class="bg-s">직거래구분</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[DIRECT_GB];
$creategory_setup['prop_name'       ] = 'direct_gb';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:15px;border:0' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$direct_gbegory['setup'] = $creategory_setup;
//echo createGory ('RADIO', $direct_gbegory);
echo $direct_gbegory[$rs[DIRECT_GB]];
?>
    </span></td>
  </tr>

  <tr>
    <td class="bg-s">결제방법</td>
    <td><span class="gray">
<?
$creategory_setup['select'          ] = $rs[PAY_METHOD];
$creategory_setup['prop_name'       ] = 'pay_method';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:120px' onchange='setChanged();'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$pay_methodegory['setup'] = $creategory_setup;
//echo createGory ('SELECT', $pay_methodegory);
echo $pay_methodegory[$rs[PAY_METHOD]];
?>

    </span></td>
    <td class="bg-s">옵션</td>
    <td><span class="gray">
        <?=$rs[OPT_PREMIUM]=='Y'?'<img src=../img/pay/bullet_P.gif>':''?>
        <?=$rs[OPT_HOT    ]=='Y'?'<img src=../img/pay/bullet_H.gif>':''?>
        <?=$rs[OPT_SPEED  ]=='Y'?'<img src=../img/pay/bullet_S.gif>':''?>
    </span></td>
  </tr>

  <tr>
    <td class="bg-s">등록가능매물수</td>
    <td><span class="gray">
      <input name="avail_cnt" name="avail_cnt" type="text" style="width:100px ;" value='<?=$rs[AVAIL_CNT]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
    </span></td>

    <td class="bg-s">등록매물수</td>
    <td><span class="gray">
      <input name="reg_cnt" name="reg_cnt" type="text" style="width:100px ;" value='<?=$rs[REG_CNT]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
    </span></td>
  </tr>

  <tr>
    <td class="bg-s">결제일자</td>
    <td><span class="gray">
    <input type=text name="pay_date" id=pay_date style='width:85px' value='<?=$rs[PAY_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("pay_date"),"yyyy-mm-dd hh:ii",this,true);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    </span></td>

    <td class="bg-s">승인일자~만료일자</td>
    <td><span class="gray">
    <input type=text name="confirm_date" id=confirm_date style='width:85px' value='<?=$rs[CONFIRM_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("confirm_date"),"yyyy-mm-dd hh:ii",this,true);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    ~
    <input type=text name="end_date" id=end_date style='width:85px' value='<?=$rs[END_DATE]?>' onchange='setChanged();'>
    <a href=# onclick='displayCalendar($("end_date"),"yyyy-mm-dd hh:ii",this,true);return false;'><img src=/img/bullet_calandar.gif width=18 height=18 align=absmiddle></a>
    </span></td>
  </tr>

  <tr>
    <td colspan=4 style='padding: 0 0 0 0 '>
    <TABLE width=800 cellpadding=0 cellspacing=0>
        <td class="bg-s">금액</td>
        <td><span class="gray">
          <input name="amount" name="amount" type="text" style="width:70px;text-align:right" value='<?=$rs[AMOUNT]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
        </span></td>
        <td class="bg-s">부가세</td>
        <td><span class="gray">
          <input name="surtax" name="surtax" type="text" style="width:70px;text-align:right" value='<?=$rs[SURTAX]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
        </span></td>
        <td class="bg-s">광고기간</td>
        <td><span class="gray">
          <input name="period" name="period" type="text" style="width:50px;text-align:right" value='<?=$rs[PERIOD]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
        </span></td>
        <td class="bg-s">총금액</td>
        <td><span class="gray">
          <input name="tot_amount" name="tot_amount" type="text" style="width:70px;text-align:right" value='<?=$rs[TOT_AMOUNT]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
        </span></td>
        <td class="bg-s">입금자명</td>
        <td><span class="gray">
          <input name="in_name" name="in_name" type="text" style="width:80px ;" value='<?=$rs[IN_NAME]?>' onpropertychange='enforceNumber()' maxlength='6' onchange='setChanged();'/>
        </span></td>
    </TABLE>
    </td>
  </tr>
  <tr>
    <td class="bg-s" colspan=4 style='text-align:center;color:black'>사용자 정보</td>
    </td>
  </tr>
  <tr>
    <td class="bg-s">ID</td>
    <td><input type="text" name="user_id" id="user_id" style="width:120px" value='<?=$mode=='I'?$memInfor[user_id]:$rs[USER_ID]?>' <?=$mode=='I'?' onblur="아이디조회(this.value)"':'readonly'?>>
        <input type="hidden" name="user_no" id="user_no" value='<?=$rs[USER_NO]?>'>
<?
    $creategory_setup['select'          ] = $rs[USER_LEVEL];
    $creategory_setup['prop_name'       ] = 'user_level';
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
    <span name="tel2_info" id="tel2_info"><?=$rs[TEL1]?></span>

    </span></td>
  </tr>
  <tr>
    <td width="120" class="bg-s">판매자</td>
    <td width="253"><input type="text" name="user_name"     id="user_name"    style="width:60px"        value='<?=$mode=='I'?$memInfor[user_name]:$rs[USER_NAME]?>'         onchange='setChanged();'/> /
                    <input type="text" name="company_name"  id="company_name"   style="width:150px"     value='<?=$mode=='I'?$memInfor[company_name]:$rs[COMPANY_NAME]?>'   onchange='setChanged();'/>
    </td>
    <td width="120" class="bg-s">핸드폰</td>
    <td><span class="gray">
    <span name="tel1_info" id="tel1_info"><?=$rs[TEL1]?></span>
    </span></td>
  </tr>
  <tr>
    <td class="bg-s">주소</td>
    <td colspan="3">
    <span name="addr_info" id="addr_info"></span>
     </td>
  </tr>

  <tr>
    <td class="bg-s">내용</td>
    <td colspan="3"><textarea type="text" name="content" id="content" style="width:700px; height:80px" onchange='setChanged();'/><?=$rs[CONTENT]?></textarea></td>
  </tr>

  <tr>
    <td class="bg-s">매물</td>
    <td colspan="3">
    <input name="prod_no" name="prod_no" type="text" style="width:100px ;" value='<?=$rs[PROD_NO]?>'/>
    </td>
  </tr>

  <tr>
    <td colspan="4" class="c-align"><a href='#' onclick='결제작성실행("<?=$mode?>");return false;'>
    <img src="/img/<?=$mode=='I'?'bt_enter.gif':'bt_edit.gif'?>" width="77" height="30" hspace="5">
    </a><a href='#' onclick='결제작성("<?=$rs[PAY_NO]?>");return false;'><img src="/img/bt_cancel.gif" width="77" height="30" hspace="5"></a></td>
  </tr>
</form>