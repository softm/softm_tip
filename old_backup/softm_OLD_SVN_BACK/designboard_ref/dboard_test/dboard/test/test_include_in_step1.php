<?
echo $_SERVER["PHP_SELF"] . " / ";
	echo $_SERVER["SCRIPT_FILENAME"] . " / ";
	echo __FILE__.'<BR>';
	include 'test_include_in_step2.php'      ; // 에러 페이지 처리
?>