<?
echo 'REQUEST_METHOD : ' . $REQUEST_METHOD . '<BR>';
echo 'HTTP_REFERER : ' . $HTTP_REFERER . '<BR>';
if ( $REQUEST_METHOD == 'POST' && ereg($HTTP_HOST, $HTTP_REFERER) ) 
{
	echo '<p>�Է� ���� ����</p>';
} else {
	echo '<p>�Է� ���� �Ұ�</p>';
}
?>