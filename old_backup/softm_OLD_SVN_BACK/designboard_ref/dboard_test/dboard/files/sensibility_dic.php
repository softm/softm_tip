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
include $mainDir . 'files/sub_menu_2.html';
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
            <TABLE cellpadding=0 cellspacing=0 width=169 height=64 background=../../images/title_box.gif border=0>
                <TR><TD>&nbsp;</TD></TR>
                <TR><TD valign=top align='center'><font color=#2C5C7A><B>감성사전</B></font></TD></TR>
            </TABLE>
            <TABLE cellpadding=15 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD>
<pre>
일반적인 단어의 의미를 감성적인 표현으로 만들어 보자.
</pre>
                </TD></TR>
            </TABLE>

            <TABLE cellpadding=1 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD valign=top>
<?
$id = 'sensibility_dic';
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