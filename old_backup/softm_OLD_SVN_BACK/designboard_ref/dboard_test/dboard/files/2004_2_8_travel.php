<?
$baseDir = '../';
$mainDir = '../../';
include $mainDir . 'files/header.html';
?>

    <TD>
    <TABLE cellpadding=0 cellspacing=0 border=0>
        <TR>
<!-- 서브 메뉴 시작 -->
        <TD width=179 height=650 valign=top>
<?
include $mainDir . 'files/sub_menu_1.html';
?>
        </TD>
<!-- 서브 메뉴 끝 -->

        <TD width=1 bgcolor=#DBDBDB></TD>

<!-- 컨텐츠 시작 -->
        <TD width=751 valign=top align=left>
        <TABLE cellpadding=0 cellspacing=0 width=100% border=0>
            <TR>
            <TD colspan=2 height=15>&nbsp;</TD>
            </TR>
            <TD width=20></TD>
            <TD>
            <TABLE cellpadding=0 cellspacing=0 width=169 height=64 background=../images/title_box.gif border=0>
                <TR><TD>&nbsp;</TD></TR>
                <TR><TD valign=top align='center'><B>추억앨범.</B></TD></TR>
            </TABLE>
            <TABLE cellpadding=15 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD>
<pre>
웅도 여행

푸른 하늘과 바다가 있던곳..

참가 일시 : 2004년 2월 8일 ~ 2004년 2월 9일
장소      : 충청남도 서산시 대산 웅도리
참가 인원 : 김용희, 이승우, 남윤성, 김지훈

어머니 고향 외가댁에서의 즐거운 여행이었다..
</pre>
                </TD></TR>
            </TABLE>

            <TABLE cellpadding=15 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD>
<?
$id = '2004_2_8_travel';
include $baseDir . "dboard.php"
?>
                </TD></TR>
            </TABLE>
            </TD>
        </TABLE>
        </TD>
<!-- 컨텐츠 끝 -->

<?
include $mainDir . 'files/footer.html';
?>