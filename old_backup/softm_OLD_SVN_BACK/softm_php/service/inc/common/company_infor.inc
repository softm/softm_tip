<?
/**
 * Filename        : /company_infor.inc
 * Fuction         : 기업정보-보기
 * @version        : 1.0
 * # using
 * include_once SERVICE_DIR . '/classes/inc/common/company_infor.inc';
*/
?>
<?
require_once SERVICE_DIR . '/classes/common/Session.php';
require_once SERVICE_DIR . '/classes/common/Database.class.php';
require_once SERVICE_DIR . '/classes/common/Common.php';
$memInfor = Session::getSession();
//echo 'login_yn : ' . $memInfor['login_yn'];
$mode = !$_GET["mode"]?"login":$_GET["mode"];
// echo "mode : " .$mode;
$chkDb = false;
if ( !($db instanceof DataBase) ) {
	$db = new DataBase();
	$db->getConnect();
	$chkDb = true;
}

// $p_company_no = 1;
// echo $p_company_no;
if ( $p_company_no ) {
	$infor = Common::getCompany($db,array(p_company_no=>$p_company_no));
// 	print_r($infor);
	// echo $infor[FILE_NAME3];
	// echo $company.FILE_NAME3;
	if ( $chkDb ) $db->release();
	$user_no            = $infor[USER_NO           ];
	$reg_code           = $infor[REG_CODE          ];
	$country_type       = $infor[COUNTRY_TYPE      ];
	$company_code       = $infor[COMPANY_CODE      ];
	$company_type       = $infor[COMPANY_TYPE      ];
	$company_nm_kr      = $infor[COMPANY_NM_KR     ];
	$company_nm_en      = $infor[COMPANY_NM_EN     ];
	$company_nm_hj      = $infor[COMPANY_NM_HJ     ];
	$company_nm_jp      = $infor[COMPANY_NM_JP     ];
	$ceo_nm_kr          = $infor[CEO_NM_KR         ];
	$ceo_nm_en          = $infor[CEO_NM_EN         ];
	$ceo_nm_hj          = $infor[CEO_NM_HJ         ];
	$ceo_nm_jp          = $infor[CEO_NM_JP         ];
	$biz_field          = $infor[BIZ_FIELD         ];
	$biz_classified     = $infor[BIZ_CLASSIFIED    ];
	$biz_classified_etc = $infor[BIZ_CLASSIFIED_ETC];
	$biz_name           = $infor[BIZ_NAME          ];
	$establish_date     = $infor[ESTABLISH_DATE    ];
	$zip_code           = $infor[ZIP_CODE          ];
	$addr_kr            = $infor[ADDR_KR           ];
	$addr_en            = $infor[ADDR_EN           ];
	$addr_hj            = $infor[ADDR_HJ           ];
	$addr_jp            = $infor[ADDR_JP           ];
	$worker_cnt         = $infor[WORKER_CNT        ];
	$tel                = $infor[TEL               ];
	$fax                = $infor[FAX               ];
	$homepage           = $infor[HOMEPAGE          ];
	$capital            = $infor[CAPITAL           ];
	$sales              = $infor[SALES             ];
	$expect_sales       = $infor[EXPECT_SALES      ];
	$ordinary_income    = $infor[ORDINARY_INCOME   ];
	$main_product       = $infor[MAIN_PRODUCT      ];
	$company_intro      = $infor[COMPANY_INTRO     ];
	$jp_trade_yn        = $infor[JP_TRADE_YN       ];
	$etc_trade_yn       = $infor[ETC_TRADE_YN      ];
	$internal_customer  = $infor[INTERNAL_CUSTOMER ];
	$external_customer  = $infor[EXTERNAL_CUSTOMER ];
	$file_no1           = $infor[FILE_NO1          ];
	$file_no2           = $infor[FILE_NO2          ];
	$file_no3           = $infor[FILE_NO3          ];
	$file_name1         = $infor[FILE_NAME1        ];
	$file_name2         = $infor[FILE_NAME2        ];
	$file_name3         = $infor[FILE_NAME3        ];
	$file_ext1          = $infor[FILE_EXT1         ];
	$file_ext2          = $infor[FILE_EXT2         ];
	$file_ext3          = $infor[FILE_EXT3         ];
	
	$company_code1 = substr($company_code, 0,3);
	$company_code2 = substr($company_code, 3,2);
	$company_code3 = substr($company_code, 5);
}
// var_dump($infor[product]);
?>
<?php
// echo USER_LEVEL;
if ( USER_LEVEL == MEMBER_TYPE_NON ) return;
?>
<table border="0" cellpadding="0" cellspacing="0" id="admin" width="700">
  <tr>
    <td colspan="2"id="t1" class="bt" >사업자번호</td>
    <td class="bt" ><!-- 1400164731 -->
    <?=$company_code1?> - <?=$company_code2?> - <?=$company_code3?>
    </td>
  </tr>
  <tr>
    <td width="70" rowspan="4" id="t1">기업명</td>
    <td width="70" id="t1">한글</td>
    <td><input type='text' readonly onfocus="this.blur();" name='company_nm_kr' style="border:0px;width:120px" value='<?=$company_nm_kr?>'/></td>
  </tr>
  <tr>
    <td id="t1">영문</td>
    <td><input type='text' readonly onfocus="this.blur();" name='company_nm_en' style="border:0px;width:120px" value='<?=$company_nm_en?>'/></td>
  </tr>
  <tr>
    <td id="t1">한자</td>
    <td><input type='text' readonly onfocus="this.blur();" name='company_nm_hj' style="border:0px;width:120px" value='<?=$company_nm_hj?>'/></td>
  </tr>
  <tr>
    <td id="t1">일문</td>
    <td><input type='text' readonly onfocus="this.blur();" name='company_nm_jp' style="border:0px;width:120px" value='<?=$company_nm_jp?>'/></td>
  </tr>
  <tr>
    <td rowspan="4" id="t1">대표자</td>
    <td id="t1">한글</td>
    <td><input type='text' readonly onfocus="this.blur();" name='ceo_nm_kr' size=50 style="border:0px;width:120px" value='<?=$ceo_nm_kr?>'/></td>
  </tr>
  <tr>
    <td id="t1">영문</td>
    <td><input type='text' readonly onfocus="this.blur();" name='ceo_nm_en' size=50 style="border:0px;width:120px" value='<?=$ceo_nm_en?>'/></td>
  </tr>
  <tr>
    <td id="t1">한자</td>
    <td><input type='text' readonly onfocus="this.blur();" name='ceo_nm_hj' size=50 style="border:0px;width:120px" value='<?=$ceo_nm_hj?>'/></td>
  </tr>
  <tr>
    <td id="t1">일문</td>
    <td><input type='text' readonly onfocus="this.blur();" name='ceo_nm_jp' size=50 style="border:0px;width:120px" value='<?=$ceo_nm_jp?>'/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">업종분야</td>
    <td>
<?=Base::$CODE_BIZ_FIELD[$biz_field]?>
	</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">업종분류</td>
    <td style="height:60px;">
<?
$printBizClasfied = array();
$bizClassified = split(",",$biz_classified);
foreach($bizClassified as $idx => $value) {
	$printBizClasfied[] = Base::$CODE_BIZ_CLASSIFIED[$value];
}
echo join(",",$printBizClasfied);
?>
  </td>
  </tr>
  <tr>
    <td colspan="2" id="t1">업종명</td>
    <td><input type='text' readonly onfocus="this.blur();" name='biz_name' size=50 style="border:0px;width:100px" value='<?=$biz_name?>'/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">설립연월일</td>
    <td>
<?=$establish_date?>
	</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">우편번호</td>
    <td><input type="text" name="zip_code" style="border:0px;width:100px" onfocus="this.blur();" value='<?=$zip_code?>'/></td>
  </tr>
  <tr>
    <td rowspan="4" id="t1">본사주소</td>
    <td id="t1">한글</td>
    <td><input type="text" name="addr_kr" style="border:0px;width:450px" onfocus="this.blur();" value='<?=$addr_kr?>'/></td>
  </tr>
  <tr>
    <td id="t1">영문</td>
    <td><input type="text" name="addr_en" style="border:0px;width:450px" onfocus="this.blur();" value='<?=$addr_en?>'/></td>
  </tr>
  <tr>
    <td id="t1">한자</td>
    <td><input type="text" name="addr_hj" style="border:0px;width:450px" onfocus="this.blur();" value='<?=$addr_hj?>'/></td>
  </tr>
  <tr>
    <td id="t1">일문</td>
    <td><input type="text" name="addr_jp" style="border:0px;width:450px" onfocus="this.blur();" value='<?=$addr_jp?>'/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">종업원수</td>
    <td><input type="text" name="worker_cnt" style="border:0px;width:50px" onfocus="this.blur();" value='<?=$worker_cnt?>'/>
      명</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">전화번호</td>
    <td><input type="text" name="tel" style="border:0px;width:450px" onfocus="this.blur();" value='<?=$tel?>'/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">팩스번호</td>
    <td><input type="text" name="fax" style="border:0px;width:450px" onfocus="this.blur();" value='<?=$fax?>'/></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">홈페이지</td>
    <td><?=($homepage?"<a href=" . $homepage . " target='_blank'>".$homepage."</a>":"")?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">자본금</td>
    <td><input type="text" name="capital" style="border:0px;width:100px;text-align:right" onfocus="this.blur();" value='<?=$capital?>'/>백만원</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">매출액</td>
    <td><input type="text" name="sales" style="border:0px;width:100px;text-align:right" onfocus="this.blur();" value='<?=$sales?>'/>백만원</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">예상매출액</td>
    <td><input type="text" name="expect_sales" style="border:0px;width:100px;text-align:right" onfocus="this.blur();" value='<?=$expect_sales?>'/>백만원</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">경상이익</td>
    <td><input type="text" name="ordinary_income" style="border:0px;width:100px;text-align:right" onfocus="this.blur();" value='<?=$ordinary_income?>'/>백만원</td>
  </tr>
  <tr>
    <td colspan="2" id="t1">주생산품</td>
    <td><input type="text" name="main_product" style="border:0px;width:100px" onfocus="this.blur();" value='<?=$main_product?>'/></td>
  </tr>

  <tr>
    <td colspan="2" id="t1">회사소개(한글)</td>
    <td style="height:100px;"><textarea name="company_intro" cols="45" rows="5" style="border:0px;width:100%" onfocus="this.blur();" readonly><?=$company_intro?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">일본과 거래 경험</td>
    <td>
<?=Base::$CODE_EXIST[$jp_trade_yn]?>
    </td>
  </tr>
  <tr>
    <td colspan="2" id="t1">기타 국가와 거래 경험</td>
    <td>
<?=Base::$CODE_EXIST[$etc_trade_yn]?>
    </td>
  </tr>
<?
$prodInfor = $infor[product];
$size = sizeof($product);
foreach ( $prodInfor as $idx => $product) {
// 	echo $idx . " / " . $product[KR] . " / " . $product[EN] . " / " . $product[JP] ."<br>";
	if ($idx>5) break;
?>
  <tr>
<?
    if ( $idx==1 ) {
?>
    <td colspan="2" rowspan="5" id="t1">생산제품 및 취급품목</td>
<?
    }
?>
    <td>한글 <input type="text" style="border:0px;width:120px" onfocus="this.blur();" value='<?=$product[KR]?>'/>&nbsp;&nbsp;&nbsp;
    영문 <input type="text" style="border:0px;width:120px" onfocus="this.blur();" value='<?=$product[EN]?>'/>&nbsp;&nbsp;&nbsp;
    일문 <input type="text" style="border:0px;width:120px" onfocus="this.blur();" value='<?=$product[JP]?>'/>
    </td>
  </tr>
<?
}
?>

    <tr>
    <td colspan="2" id="t1">주요거래처(국내)</td>
    <td style="height:70px;"><textarea name="internal_customer" cols="45" rows="3" style="border:0px;width:100%" onfocus="this.blur();"><?=$internal_customer?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" id="t1">주요거래처(해외)</td>
    <td style="height:70px;"><textarea name="external_customer" cols="45" rows="3" style="border:0px;width:100%" onfocus="this.blur();"><?=$external_customer?></textarea></td>
  </tr>
  <tr>
    <td rowspan="3" id="t1">첨부파일</td>
    <td id="t1">회사소개서</td>
    <td>&nbsp;
    <SPAN id=file1_infor><a href=# onclick="fileDownloadCompany('<?=$file_no1?>','f1_<?=$p_company_no?>_');return false;"><?=$file_name1?><?=$file_ext1?".":""?><?=$file_ext1?></a></SPAN>
    </td>
  </tr>
  <tr>
    <td id="t1">제품소개서</td>
    <td>&nbsp;
    <SPAN id=file2_infor><a href=# onclick="fileDownloadCompany('<?=$file_no2?>','f2_<?=$p_company_no?>_');return false;"><?=$file_name2?><?=$file_ext2?".":""?><?=$file_ext2?></a></SPAN>
    </td>
  </tr>
  <tr>
    <td id="t1">기타</td>
    <td>&nbsp;
    <SPAN id=file3_infor><a href=# onclick="fileDownloadCompany('<?=$file_no3?>','f3_<?=$p_company_no?>_');return false;"><?=$file_name3?><?=$file_ext3?".":""?><?=$file_ext3?></a></SPAN>
    </td>
  </tr>
</table>
