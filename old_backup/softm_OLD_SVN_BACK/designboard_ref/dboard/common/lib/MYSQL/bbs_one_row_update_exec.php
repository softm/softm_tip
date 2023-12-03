<?
if ( function_exists('_head') ) {
    if ( $id && $grant == 'Y' && !ereg( "(".$HTTP_SERVER_VARS['HTTP_HOST'].")((.)*(/)+)+(bbs_one_row_update_exec.php)", $HTTP_SERVER_VARS['HTTP_HOST'] . $HTTP_SERVER_VARS['PHP_SELF'] ) ) {
        $sql  = "update $tb_bbs_data" . "_" . $id;
        $sql .= " set   hit = hit + 1  ";
        $sql .= " where no  = '$no'";
        $sql .= " and use_st < 8";
        simpleSQLExecute($sql);
    }
}
?>