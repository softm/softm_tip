<?
$baseDir = '../';
$mainDir = '../../';
include $mainDir . 'files/header.html';
?>

    <TD>
    <TABLE cellpadding=0 cellspacing=0 border=0>
        <TR>
<!-- ���� �޴� ���� -->
        <TD width=179 height=650 valign=top>
<?
include $mainDir . 'files/sub_menu_4.html';
?>
        </TD>
<!-- ���� �޴� �� -->

        <TD width=1 bgcolor=#DBDBDB></TD>

<!-- ������ ���� -->
        <TD width=751 valign=top align=left>
        <TABLE cellpadding=0 cellspacing=0 width=100% border=0>
            <TR>
            <TD colspan=2 height=15>&nbsp;</TD>
            </TR>
            <TD width=20></TD>
            <TD>
            <TABLE cellpadding=0 cellspacing=0 width=169 height=64 background=../../images/title_box.gif border=0>
                <TR><TD>&nbsp;</TD></TR>
                <TR><TD valign=top align='center'><font color=#2C5C7A><B>���ã��</B></font></TD></TR>
            </TABLE>
            <TABLE cellpadding=15 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD>
<pre>
���� ����Ʈ �Ұ��ϼ���.
</pre>
                </TD></TR>
            </TABLE>

            <TABLE cellpadding=1 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD valign=top>
<?
$id = 'favorite';
$sort = 'cat_no';
$desc = 'desc';
include $baseDir . "dboard.php"
?>
                </TD></TR>
            </TABLE>

            </TD>
        </TABLE>
        </TD>
<!-- ������ �� -->

<?
include $mainDir . 'files/footer.html';
?>