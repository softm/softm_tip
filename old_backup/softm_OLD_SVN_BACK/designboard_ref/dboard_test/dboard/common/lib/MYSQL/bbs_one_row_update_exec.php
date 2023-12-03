<?
if ( function_exists('head') ) {
    if ( $id && $grant == 'Y' && !preg_match( "/(".$_SERVER['HTTP_HOST'].")((.)*(\/)+)+(bbs_one_row_update_exec.php)/", $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) ) {
        $sql  = "update $tb_bbs_data" . "_" . $id;
        $sql .= " set   hit = hit + 1  ";
        $sql .= " where no  = '$no'";
        $sql .= " and use_st < 8";
        simpleSQLExecute($sql);
    }
}
?>