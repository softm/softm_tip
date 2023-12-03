<?
$id = $_GET["id"];
$srcUrl = "";
if      ( $id == '1' ) $srcUrl = "http://www.google.co.kr/logos/2012/hertz-2011-res.png";
else if ( $id == '2' ) $srcUrl = "http://t2.gstatic.com/images?q=tbn:ANd9GcT83qT8NCPKBYNJdRI_9fjPqQsd0jRr4nebRH5ArEhqOEj_dF5K-cZb8TXvmg";
?>

<img src="<?=$srcUrl?>" width=200 border=1>