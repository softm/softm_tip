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
include $mainDir . 'files/sub_menu_1.html';
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
            <TABLE cellpadding=0 cellspacing=0 width=169 height=64 background=../images/title_box.gif border=0>
                <TR><TD>&nbsp;</TD></TR>
                <TR><TD valign=top align='center'><B>�߾�ٹ�.</B></TD></TR>
            </TABLE>
            <TABLE cellpadding=15 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD>
<pre>
�������� ������ ���� ���� ���� �����ϴ� �츮..

���� �Ͻ� : 2004�� 7�� 19 �� ~ 2004�� 7�� 24��
���� ������ : ����
���� �ο� : ������, ȫ����, ������
</pre>
                </TD></TR>
            </TABLE>

            <TABLE cellpadding=15 cellspacing=0 width=100% border=1 bordercolor=#EEEEEE>
                <TR><TD>
<?
$id = '2004_7_19_travel';
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