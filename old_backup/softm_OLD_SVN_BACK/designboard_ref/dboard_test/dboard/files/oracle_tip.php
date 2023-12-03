<?
$baseDir = '../';
$mainDir = '../../';
include $mainDir . 'files/header.html';
?>

    <TD>
    <TABLE cellpadding=0 cellspacing=0 border=0>
        <TR>
<!-- ¼­ºê ¸Þ´º ½ÃÀÛ -->
        <TD width=179 height=650 valign=top>
<?
include $mainDir . 'files/sub_menu_3_2.html';
?>
        </TD>
<!-- ¼­ºê ¸Þ´º ³¡ -->

        <TD width=1 bgcolor=#DBDBDB></TD>

<!-- ÄÁÅÙÃ÷ ½ÃÀÛ -->
        <TD width=751 valign=top align=left>
        <TABLE cellpadding=0 cellspacing=0 width=100% border=0>
            <TR>
            <TD colspan=2 height=15>&nbsp;</TD>
            </TR>
            <TD width=20></TD>
            <TD>
            <TABLE cellpadding=0 cellspacing=0 width=169 height=64 background=../../images/title_box.gif border=0>
                <TR><TD>&nbsp;</TD></TR>
                <TR><TD valign=top align='center'><font color=#2C5C7A><B>ORACLE °øºÎ¹æ</B></font></TD></TR>
            </TABLE>
            <TABLE cellpadding=15 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD>
<pre>
ORACLE ÆÁ
</pre>
                </TD></TR>
            </TABLE>

            <TABLE cellpadding=1 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD valign=top>
<?
$id = 'oracle_tip';
include $baseDir . "dboard.php"
?>
                </TD></TR>
            </TABLE>

            </TD>
        </TABLE>
        </TD>
<!-- ÄÁÅÙÃ÷ ³¡ -->

<?
include $mainDir . 'files/footer.html';
?>