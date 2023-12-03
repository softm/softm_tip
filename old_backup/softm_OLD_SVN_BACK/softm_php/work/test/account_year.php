<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</HEAD>

<BODY>
<?
//    2008/10/01 ~ 2009/09/30 : 0809
//    2009/10/01 ~ 2010/09/30 : 0910

$tY = (int)substr(date('Y'),2,2);
$tM = (int)date('m');
echo 'tY :' . date('Y') . '<BR>';
echo 'tY :' . $tY . '<BR>';
echo 'tM :' . $tM . '<BR>';
define('ACCOUNTING_YEAR' , sprintf("%02d%02d", ($tM<=9?$tY-1:$tY), ($tM<=9?$tY:$tY+1)));  // 회계년도
echo 'ACCOUNTING_YEAR :' . ACCOUNTING_YEAR . '<BR>';
?>
</BODY>
</HTML>
