<?
ob_start();
define("DBOARD_PAGE_DIRECT_ACCESS",$_SERVER["SCRIPT_FILENAME"] == str_replace("\\", "/", __FILE__));
include ( 'common/lib.inc'          ); // 공통 라이브러리
include 'common/member_lib.inc'; // 멤버 라이브러리
include ( 'common/message.inc'      ); // 에러 페이지 처리
include ( 'common/db_connect.inc'   ); // Data Base 연결 클래스
// 데이터베이스에 접속합니다.
$db = initDBConnection ($sysInfor["host_nm"],$sysInfor["db_nm"],$sysInfor["id"],$sysInfor["password"],$sysInfor["driver"]);
head('우편 번호 조회');          // Header 출력
css($baseDir);
include $baseDir.'common/js/common_js.php'; // 공통 javascript

//$sql = "select * from $tb_post where address like '%" . $search . "%' limit 0,10;";
$sql = "select * from $tb_post";

if ( $search ) {
    $sql .= " where ( st = '1' and dong like '" . $search . "%' ) or ( st = '2' and dong like '%" . $search . "%' ) order by zipcode";
}
//logs ( '$sql : ' . $sql, true );
//logs ( '$sql : ' . $post_cd_field1, true );
//logs ( '$sql : ' . $post_cd_field2, true );
//logs ( '$sql : ' . $address_field, true );
?>
<script type="text/javascript">
<!--
    var post_cd_field1 = "<?=$post_cd_field1?>";
    var post_cd_field2 = "<?=$post_cd_field2?>";
    var address_field  = "<?=$address_field?>";
    var detail_address_field  = "<?=$detail_address_field?>";

    function postOnLoad() {
        document.postForm.search.focus();
    }

    function setPostValue() {
        var postCd1 = getObject(post_cd_field1,"opener");
        var postCd2 = getObject(post_cd_field2,"opener");
        var address = getObject(address_field ,"opener");
        var detail_address = getObject(detail_address_field,"opener");
        selectAddress = getObject("address");
        var selectValue = selectAddress.value;
            selectValue = selectValue.split("$");
        postCd1.value = selectValue[0];
        postCd2.value = selectValue[1];
        address.value = selectValue[2];
        detail_address.focus();
        self.close();
    }
//-->
</SCRIPT>
<style>
body {margin:0px 0px 0px 0px;overflow:hidden }
</style>
</head>
<body onLoad='postOnLoad();'>
<table width="500" border="0" cellspacing="0" cellpadding="0">
<form name='postForm' method='post'>
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
                <td><font color="BF0909">+</font> <b>주소찾기</b></td>
              </tr>
              <tr>
                <td height="5"></td>
              </tr>
              <tr>
                <td>동/읍/면의 이름을 입력하시고 '<font color="BF0909">주소찾기</font>'를 클릭하세요.
                  (예: 삼성동 또는 건물명) </td>
              </tr>
            </table>
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td bgcolor="fafafa" background="images/dot1.gif" height="1" class="bg_line2"></td>
              </tr>
              <tr>
                <td bgcolor="fafafa">
                  <input type="text" name="search" value='<?=$search?>'>
                  <input type="image" border="0" name="imageField3" src="images/button_fadr.gif" width="67" height="19" align="absmiddle">
                </td>
              </tr>
              <tr>
                <td bgcolor="fafafa" background="images/dot1.gif" height="1" class="bg_line2"></td>
              </tr>
              <tr>
                <td bgcolor="fafafa">

<?
if ( $search ) {
    $stmt   = multiRowSQLQuery ($sql);
    $cnt = 0;
    while ( $row = multiRowFetch ($stmt ) ) {
        $cnt++;
        $zipcode= $row['zipcode' ];  /* 우편번호          */
        $sido   = $row['sido'    ];  /* 특별시,광역시,도  */
        $gugun  = $row['gugun'   ];  /* 시,군,구          */
        $dong   = $row['dong'    ];  /* 읍,면,동          */
        $ri     = $row['ri'      ];  /* 리, 건물명        */
        $bunji  = $row['bunji'   ];  /* 번지,아파트동,호수*/
        $st     = $row['st'      ];  /* '1' : 일반 주소, '2' : 기관 주소 */
        if ( $st == '1' ) {
            $address = $sido . ' ' . $gugun . ' ' . $dong . ' ' . $ri . ' ' . $bunji;
        } else {
            $address = $sido . ' ' . $gugun . ' ' . $dong . ' ' . $ri . ' ' . $bunji;
        }
        $postCd1 = substr ( $zipcode , 0,3 );
        $postCd2 = substr ( $zipcode , 4,3 );
        if ( $cnt == 1 ) {
            echo "<table width='100%' border='0' cellspacing='0' cellpadding='0' class='text_01'>";
            echo "  <tr> ";
            echo "    <td><font color='BF0909'>+</font> 해당주소를 선택, 완료버튼을 누른후 나머지 ";
            echo "      주소를 입력해주세요. </td>";
            echo "  </tr>";
            echo "  <tr> ";
            echo "    <td height='5'></td>";
            echo "  </tr>";
            echo "  <tr> ";
            echo "    <td> ";
            echo "<select name='address' id='address' class='menu1'>";
        }

        echo "<option value='" . $postCd1 . '$' . $postCd2 . '$' . $address . "'>". $zipcode . " " . $address . "</option>";
    }

    if ( $cnt > 0 ) {
        echo "</select>&nbsp;";
        echo "<a href='#' onClick='setPostValue();return false;'><img border='0' name='imageField32' src='images/button_ok.gif' align='top' ></a>";
        echo "      </td>";
        echo "      </tr>";
        echo "    </table>";
        echo "  </td>";
        echo "</tr>";
        echo "<tr> ";
        echo "  <td bgcolor='fafafa' background='images/dot1.gif' height='1' class='bg_line2'></td>";
        echo "</tr>";
    }
}
?>


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
<br>
<br>
<br>
<?
closeDBConnection (); // 데이터베이스 연결 설정 해제
footer(); // Footer 출력
?>