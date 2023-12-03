<?
/*
* include 되었는지를 검사
**/
if( defined("_dlib_included") ) return;
    define ("_dlib_included", true);
/* 버전 컨르롤 참고 */
if (!defined('PHP_VERSION_ID')) {
    $version = explode('.', PHP_VERSION);
    define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
}
if (PHP_VERSION_ID < 50207) {
    define('PHP_MAJOR_VERSION',   $version[0]);
    define('PHP_MINOR_VERSION',   $version[1]);
    define('PHP_RELEASE_VERSION', $version[2]);
    // and so on, ...
}

if (version_compare(PHP_VERSION, '5.0.0', '<')) {
    echo "트라이불허";
} else {
    include "./test_include_try_catch.php";
}

echo ' PHP_VERSION : ' . PHP_VERSION . "<BR>";
echo ' PHP_VERSION_ID : ' . PHP_VERSION_ID. "<BR>";
echo ' PHP_MAJOR_VERSION : ' . PHP_MAJOR_VERSION. "<BR>";
echo ' PHP_MINOR_VERSION : ' . PHP_MINOR_VERSION. "<BR>";
echo ' PHP_RELEASE_VERSION : ' . PHP_RELEASE_VERSION. "<BR>";
if (version_compare(PHP_VERSION, '6.0.0') >= 0) {
    echo 'I am at least PHP version 6.0.0, my version: ' . PHP_VERSION . "\n";
}

if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
    echo 'I am at least PHP version 5.3.0, my version: ' . PHP_VERSION . "\n";
}

if (version_compare(PHP_VERSION, '5.0.0', '>=')) {
    echo 'I am using PHP 5, my version: ' . PHP_VERSION . "\n";
}

if (version_compare(PHP_VERSION, '5.0.0', '<')) {
    echo 'I am using PHP 4, my version: ' . PHP_VERSION . "\n";
}

?>