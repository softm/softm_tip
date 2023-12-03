<?
require_once HOME_DIR . '/inc/form.inc';
require_once HOME_DIR . '/inc/var.inc';

if ( $mode == 'U' ) {
    $sql = " SELECT * FROM " . TB_MEMBER
         . " WHERE USER_NO = '" . $p_user_no . "'";
         //. " AND   USER_LEVEL = 2";

    $rs = $db->singleRowSQLQuery ($sql);
}
?>
<form id=wForm name=wForm>
    <input name="user_no"      type="hidden" value='<?=$p_user_no?>'>

<table width="1000" border="0" cellpadding="0" cellspacing="0" id="details-box">
<caption>
중개회원 정보<?=$mode=='I'?'입력':'수정'?>
</caption>

  <tr>
    <td width="100%" colspan=4>
        <span id='msg' style='width:100%;top:130;left:1200;font-weight:bold;color:#CC0000'>&nbsp;</span>
    </td>
  </tr>

  <tr>
    <td width="120" class="bg-b">아이디</td>
    <td width="220"><input type="text" name="user_id" id="user_id" style="width:120px" value='<?=$rs[USER_ID]?>' <?=$mode=='I'?' onblur="아이디검사(this)"':'readonly'?>>
<?
    if ( $mode == 'I' ) {
        $creategory_setup['select'          ] = $rs[USER_LEVEL];
        $creategory_setup['prop_name'       ] = 'user_level';
        $creategory_setup['title'           ] = ''  ;
        $creategory_setup['script'          ] = "style='width:80'"  ; // 스크립트
        $creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
        $creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
        $creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
        $creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
        $user_levegory['setup'] = $creategory_setup;
        echo createGory ('SELECT', $user_levegory);

    } else {
        echo '<input name="user_level" type="hidden" value="' . $rs[USER_LEVEL] . '">';
        echo '[' . $user_levegory[$rs[USER_LEVEL]] . ']';
    }

?>
    </td>
    <td width="138" class="bg-b">패스워드</td>
    <td>
<?
$upStyle = $mode == 'U'?'style="width:100px;background-color:gray" readonly':'style="width:100px"';
?>
    <input type="password" name="passwd" id="passwd" <?=$upStyle?>/>
      &nbsp;&nbsp;<span class="green">※비밀번호 확인</span>
      <input type="password" name="c_passwd" id="c_passwd"  <?=$upStyle?>/>
<?
if ( $mode == 'U' ) {
?>
      <input type='checkbox' name='change_pwd' id='change_pwd' value='Y' onclick='비밀번호변경()'/> 비밀번호 변경
<?
}
?>
      <!-- <a href='#' onclick='return false;'><img src="/img/bt_enter02.gif" width="54" height="22" align="absmiddle"></a> -->
      </td>
  </tr>
  <tr>
    <td class="bg-b">업채명</td>
    <td><input type="text" name="company_name" id="company_name" style="width:150px" value='<?=$rs[COMPANY_NAME]?>'/></td>
    <td class="bg-b">사업자번호</td>
    <td><input type="text" name="company_no" id="company_no" style="width:150px" value='<?=$rs[COMPANY_NO]?>' maxlength=12/></td>
  </tr>
  <tr>
    <td class="bg-b">이름</td>
    <td><input type="text" name="user_name" id="user_name" style="width:150px" value='<?=$rs[USER_NAME]?>' /></td>
    <td class="bg-b">주민번호</td>
    <td>
<?
$jumin = $rs[JUMIN_NO];
//echo $rs[JUMIN_NO];
//echo substr($jumin,0,6). '<BR>';
//echo substr($jumin,6,7). '<BR>';
?>
    <input type="text" name="jumin_no1" id="jumin_no1" style="width:70px" maxlength=6 value='<?=substr($jumin,0,6)?>'/>
      -
      <input type="text" name="jumin_no2" id="jumin_no2" style="width:80px" maxlength=7 value='<?=substr($jumin,6,7)?>'/></td>
  </tr>
  <tr>
    <td class="bg-b">핸드폰</td>
    <td><span class="gray">
<?
$tel1 = $rs[TEL1];
$tel1Info = split('-',$tel1);

$creategory_setup['select'          ] = $tel1Info[0];
$creategory_setup['prop_name'       ] = 'tel1_1';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:50px'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$hpegory['setup'] = $creategory_setup;
echo createGory ('SELECT', $hpegory);
?>
-
<input name="tel1_2" type="text" style="width:50px ;" maxlength=4 value='<?=$tel1Info[1]?>'>
-
<input name="tel1_3" type="text" style="width:50px ;" maxlength=4 value='<?=$tel1Info[2]?>'>
    </span></td>
<?
$email_yn = $rs[EMAIL_YN]?$rs[EMAIL_YN]:'Y';
?>
    <td class="bg-b">이메일</td>
    <td><input type="text" name="e_mail" id="e_mail" style="width:120px" maxlength=100 value='<?=$rs[E_MAIL]?>'/> <span class="green">이메일수신여부</span> [Yes]<a href="#" class="sky_link">
      <input type="radio" name="email_yn" class="check" <?=$email_yn=='Y'?'checked':''?>>
    </a>[No]<a href="#" class="sky_link">
        <input type="radio" name="email_yn" class="check" <?=$email_yn=='N'?'checked':''?>>
    </a></td>
  </tr>
  <tr>
    <td class="bg-b">주소</td>
    <td colspan="3">
    <input type="text" name="post_no" id="post_no" style="width:50px" value='<?=$rs[POST_NO]?>' readonly/>
    <input type="text" name="address1" id="address1" style="width:250px" value='<?=$rs[ADDRESS1]?>' readonly/>
     <a href='#' id='post_btn' onclick='openWindow("../common/post_search_pop.php", 300, 170,"ppWin");return false;'><img src="/img/bt_address.gif" align="absmiddle"></a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input type="text" name="address2" id="address2" style="width:450px" value='<?=$rs[ADDRESS2]?>' /></td>
  </tr>
  <tr>
    <td class="bg-b">전화번호</td>
    <td><span class="gray">
<?
$tel2 = $rs[TEL2];
$tel2Info = split('-',$tel2);
$creategory_setup['select'          ] = $tel2Info[0];
$creategory_setup['prop_name'       ] = 'tel2_1';
$creategory_setup['title'           ] = ''  ;
$creategory_setup['script'          ] = "style='width:50px'"  ; // 스크립트
$creategory_setup['properties'      ] = ""  ; // 카테고리 html 속성
$creategory_setup['active_start_tag'] = ""  ; // 카테고리 선택 항목 처음   태그
$creategory_setup['active_end_tag'  ] = ""  ; // 카테고리 선택 항목 마지막 태그
$creategory_setup['append_tag'      ] = ""  ; // 카테고리 선택 항목 마지막 태그
$telegory['setup'] = $creategory_setup;
echo createGory ('SELECT', $telegory);
?>
-
<input name="tel2_2" id="tel2_2" type="text" style="width:50px ;" maxlength=4 value='<?=$tel2Info[1]?>'>
-
<input name="tel2_3" id="tel2_3" type="text" style="width:50px ;" maxlength=4 value='<?=$tel2Info[2]?>'>
    </span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4" class="c-align"><a href='#' onclick='중개회원작성실행("<?=$mode?>");return false;'>
    <img src="/img/<?=$mode=='I'?'bt_enter.gif':'bt_edit.gif'?>" width="77" height="30" hspace="5">
    </a><a href='#' onclick='$("wForm").reset();return false;'><img src="/img/bt_cancel.gif" width="77" height="30" hspace="5"></a></td>
  </tr>
</table>
</form>