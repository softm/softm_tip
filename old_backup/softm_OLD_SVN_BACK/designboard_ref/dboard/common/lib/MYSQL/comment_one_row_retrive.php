<?
if ( !function_exists('_head') && !$no ) {
    /* �ǰ߱� �Ѱ� ��ȸ */
    if ( $package == 'board' ) {
       $sql  = "select * from $tb_bbs_comment" . "_" . $id . " where p_no = '$p_no' and no ='$no'";
    } else if ( $package == 'poll' ) {
        $sql  = "select * from $tb_poll_comment" . "_" . $id . " where no ='$poll_no'";
    }

    $data = singleRowSQLQuery ($sql);
    if ( $data ) {
        $c_no      = $data['no'       ];   /* �ǰ߱� ��ȣ  */
        $p_no      = $data['p_no'     ];   /* �Խù� ��ȣ  */
        $c_user_id = $data['user_id'  ];   /* ����� ID    */
        $name      = $data['name'     ];   /* �̸�         */
    } else {
        $c_no      = '';   /* �ǰ߱� ��ȣ      */
    }
}
?>