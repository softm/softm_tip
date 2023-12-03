<?
if ( !function_exists('_head') && !$no ) {
    /* 의견글 한건 조회 */
    if ( $package == 'board' ) {
       $sql  = "select * from $tb_bbs_comment" . "_" . $id . " where p_no = '$p_no' and no ='$no'";
    } else if ( $package == 'poll' ) {
        $sql  = "select * from $tb_poll_comment" . "_" . $id . " where no ='$poll_no'";
    }

    $data = singleRowSQLQuery ($sql);
    if ( $data ) {
        $c_no      = $data['no'       ];   /* 의견글 번호  */
        $p_no      = $data['p_no'     ];   /* 게시물 번호  */
        $c_user_id = $data['user_id'  ];   /* 사용자 ID    */
        $name      = $data['name'     ];   /* 이름         */
    } else {
        $c_no      = '';   /* 의견글 번호      */
    }
}
?>