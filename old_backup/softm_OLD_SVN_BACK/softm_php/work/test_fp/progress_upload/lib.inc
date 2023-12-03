<?
function escapeYN () {
    return ini_get('magic_quotes_gpc');
}

function javascriptExec($str) {
    echo "\r\n<SCRIPT LANGUAGE='JavaScript'>\r\n";
    echo "<!--\r\n";
    if ( $str ) {
        echo $str . ";\r\n";
    }
    echo "//-->";
    echo "</SCRIPT>";
}
?>