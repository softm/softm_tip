<?
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include 'common/member_lib.inc'; // 멤버 라이브러리
include 'common/lib.inc'       ; // 공통 라이브러리
include 'common/message.inc'   ; // 에러 페이지 처리
include 'common/db_connect.inc'; // Data Base 연결 클래스

// 데이터베이스에 접속합니다.
$db   = initDBConnection (); // 데이터베이스에 접속합니다.

$memInfor = getMemInfor();      // 세션에 저장되어있는 회원정보를 읽음
$memForm  = getMemFormSetup (0  ); // 회원 폼 설정

// logs ($memForm['member_level'] . '<BR>',true);
// logs ($memForm['sex'         ] . '<BR>',true);
// logs ($memForm['agreement'   ] . '<BR>',true);
// logs ($memForm['name'        ] . '<BR>',true);
// logs ($memForm['e_mail'      ] . '<BR>',true);
// logs ($memForm['jumin'       ] . '<BR>',true);
// logs ($memForm['tel'         ] . '<BR>',true);
// logs ($memForm['address'     ] . '<BR>',true);
// logs ($memForm['news_yn'     ] . '<BR>',true);

head("아이디비밀번호분실");        // Header 출력
css();

    echo ( "\n<script type='text/javascript'>\n" );
    echo ( " var exec = '".$exec ."';\n" );
    echo ( " var id   = '".$id   ."';\n" );
    echo ( " var no   = '".$no   ."';\n" );
    echo ( " var npop = '".$npop ."';\n" );
    echo ( "</SCRIPT>\n" );

	include $baseDir.'common/js/common_js.php'; // 공통 javascript
	include $baseDir.'common/js/member_js.php'; // 회원 javascript
?>
<script type='text/javascript'>
<!--
    function memberInforSearchOnLoad() {
      var y = parseInt(document.body.clientHeight) / 2 + parseInt(document.body.scrollTop ) - ( parseInt(document.body.clientHeight ) / 2 );
      window.moveTo(0, y);
    }

    function writeData() {
        if ( typeof ( document.memberInforSearchForm.name ) == 'object' && inStrAllBlankCheck (document.memberInforSearchForm.name) ) {
            alert ("이름 입력을 확인해 주세요.");
            document.memberInforSearchForm.name.focus();
            return false;
        }
        // 어드민일 경우 주민 번호 검사를 안함
        if ( typeof ( document.memberInforSearchForm.jumin_1 ) == 'object' && !juminCheck (document.memberInforSearchForm.jumin_1.value, document.memberInforSearchForm.jumin_2.value) ) {
            alert ("주민번호 입력을 확인해 주세요.");
            document.memberInforSearchForm.jumin_1.focus();
            return false;
        }
        var mode     = '<?=$mode?>'      ;
        var succ_url = '<?=$succ_url?>'  ;
        var url = 'member_infor_search_exec.php?id=' + id + '&exec=' + exec + '&no=' + no + '&npop' + npop;
        url += ( mode != ''     ) ? '&mode='     + mode    : '';
        url += ( succ_url != '' ) ? '&succ_url=' + succ_url: '';
        document.memberInforSearchForm.action = url;
        return true;
    }

    function inStrAllBlankCheck (argu) {
        if ( typeof ( argu ) == "object" ) argu = argu.value;
        var ch1="";
        for (var i=0;i<argu.length;i++) ch1 += " ";
        if ( argu == ch1 ) return true;
        else return false;
    }
//-->
</SCRIPT>
<style>
body {margin:0px 0px 0px 0px;overflow:hidden }
</style>
</head>
<body onLoad='memberInforSearchOnLoad();'>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<form name='memberInforSearchForm' method='post' action='member_infor_search_exec.php' onSubmit='return writeData();'>
  <tr>
    <td width="17" height="17"><img src="images/join_01.gif" width="17" height="17"></td>
    <td background="images/join_bg01.gif"></td>
    <td width="17" height="17"><img src="images/join_02.gif" width="17" height="17"></td>
  </tr>
  <tr>
    <td background="images/join_bg02.gif"></td>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="text_01">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="text_01">
              <tr>
                <td><font color="BF0909">+</font> <b>아이디/비밀번호 찾기</b></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td>회원님의 정보는 가입하실때에 기입하신 메일 주소로 발송됩니다.</td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
            </table>
<? if ( $memForm['jumin'] == 'Y' ) {?>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="fafafa">
                <td colspan="2" align="right" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td width="100" align="right" class="text_01"><b>이름</b></td>
                <td>
                  <input type="text" name="name" maxlength="20">
                </td>
              </tr>
              <tr>
                <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td align="right" class="text_01"><b>주민등록번호</b></td>
                <td>
                  <input type="text" name="jumin_1" maxlength="6">
                  -
                  <input type="text" name="jumin_2" maxlength="7">
                </td>
              </tr>

<? } else {?>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr bgcolor="fafafa">
                <td colspan="2" align="right" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td width="100" align="right" class="text_01"><b>이름</b></td>
                <td>
                  <input type="text" name="name" size='34' maxlength="20">
                </td>
              </tr>
              <tr>
                <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
              </tr>
<? }?>
<? if ( $memForm['hint'] == 'Y' ) {?>
              <tr>
                <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td width="100" align="right" class="text_01"><b>힌트</b></td>
                <td>
                <select name='hint'>
                    <option value=''  >----------- 힌트 선택 -----------</option>
                    <option value='1' >나의 보물 제1호는?             </option>
                    <option value='2' >가장 친한 친구 이름은?         </option>
                    <option value='3' >내가 제일 좋아하는 연예인은?   </option>
                    <option value='4' >내 별명은?                     </option>
                    <option value='5' >좋아하는 색은?                 </option>
                </select>
                </td>
              </tr>

              <tr>
                <td colspan="2" height="1" bgcolor="fafafa" background="images/bg2.gif" class="bg_line2"></td>
              </tr>
              <tr bgcolor="fafafa">
                <td width="100" align="right" class="text_01"><b>답변</b></td>
                <td>
                <input type='text' name='answer' size='34' maxlength="100" value='<?=$answer?>'>
                </td>
              </tr>
<? }?>
              <tr bgcolor="fafafa">
                <td align="right" colspan="2" height="1" background="images/bg2.gif" class="text_01 bg_line2"></td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td height="10" align="right">
                <input type='image' src="images/button_ok2.gif" width="66" height="30">
                <a href='#' onClick='self.close();'><img src="images/button_close.gif" width="66" height="30" border='0'></a>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
    <td background="images/join_bg03.gif"></td>
  </tr>
  <tr>
    <td width="17" height="17"><img src="images/join_03.gif" width="17" height="17"></td>
    <td background="images/join_bg04.gif" height="17"></td>
    <td width="17" height="17"><img src="images/join_04.gif" width="17" height="17"></td>
  </tr>
</form>
</table>
<br>
<?
footer(); // Footer 출력
?>
