<?
if ( function_exists('head') ) {
    $sql  = "select no  ,depth, pre_no, next_no, user_id , name, title, e_mail, home, f_path1, f_name1, f_ext1, f_size1, f_date1, f_path2, f_name2, f_ext2, f_size2, f_date2, reg_date, use_st, hit, total_comment from $tb_bbs_data" . "_" . $id . " where no = $pre_no or no = $next_no";
    $stmt = multiRowSQLQuery ($sql);

    $a_pre_view  = "<a href='#' style='display:none'>";
    $a_next_view = "<a href='#' style='display:none'>";

    while ( $data = multiRowFetch  ($stmt) ) {
    /* ----- �� ���� ------------------------------------ */
        if (  $pre_no == $data['no'] ) {
            $pre_no      = $data['no'       ];   /* �Խù� ��ȣ      */
//          $a_pre_view  = $a_view_tmp . '&no=' .$pre_no. "'>";
            $a_pre_view  = $a_view_tmp . $pre_no . "');return false;\">";
            $pre_user_id = $data['user_id'  ];   /* ����� ID        */
            $pre_name    = $data['name'     ];   /* �̸�             */
            $pre_title   = $data['title'    ];   /* ����             */
            $pre_e_mail  = $data['e_mail'   ];   /* E-mail           */
            $pre_home    = $data['home'     ];   /* Homepage         */
            $pre_f_path1 = $data['f_path1'   ];   /* ���� ���� ���1   */
            $pre_f_name1 = $data['f_name1'   ];   /* ���� ��1          */
            $pre_f_ext1  = $data['f_ext1'    ];   /* ���� Ȯ����1      */
            $pre_f_size1 = $data['f_size1'   ];   /* ���� ũ��1        */
            $pre_f_date1 = $data['f_date1'   ];   /* ���� ���ϸ�1      */

            $pre_f_path2 = $data['f_path2'   ];   /* ���� ���� ���2   */
            $pre_f_name2 = $data['f_name2'   ];   /* ���� ��2          */
            $pre_f_ext2  = $data['f_ext2'    ];   /* ���� Ȯ����2      */
            $pre_f_size2 = $data['f_size2'   ];   /* ���� ũ��2        */
            $pre_f_date2 = $data['f_date2'   ];   /* ���� ���ϸ�2      */

            if ( $pre_f_name1 ) {
                $pre_a_file1  = "<a href='download.php?id=$id&no=$no&gubun=1' target='_dboard_iframe'>";
                $pre_f_size1  = f_size($pre_f_size1);
                $pre_f_name1  = $pre_f_name1 . '.' . $pre_f_ext1;
                $pre_f_infor1 = $baseDir . $pre_f_path1 . $pre_f_date1 . '.' . $pre_f_ext1; // ���� ���� ���
            } else {
                $pre_a_file1     = "<a href='#' style='display:none'>";
                $pre_f_size1  = '';
                $pre_f_name1  = '';
                $pre_f_infor1 = '';
            }

            if ( $pre_f_name2 ) {
                $pre_a_file2  = "<a href='download.php?id=$id&no=$no&gubun=1' target='_dboard_iframe'>";
                $pre_f_size2  = f_size($pre_f_size2);
                $pre_f_name2  = $pre_f_name2 . '.' . $pre_f_ext2;
                $pre_f_infor2 = $baseDir . $pre_f_path2 . $pre_f_date2 . '.' . $pre_f_ext2; // ���� ���� ���
            } else {
                $pre_a_file2  = "<a href='#' style='display:none'>";
                $pre_f_size2  = '';
                $pre_f_name2  = '';
                $pre_f_infor2 = '';
            }
            $pre_reg_date       = $data['reg_date' ];   /* �ۼ� �� �������� */
            $pre_reg_date_year  = substr($pre_reg_date, 0 ,4);
            $pre_reg_date_month = substr($pre_reg_date, 4 ,2);
            $pre_reg_date_day   = substr($pre_reg_date, 6 ,2);
            $pre_reg_date_hour  = substr($pre_reg_date, 8 ,2);
            $pre_reg_date_min   = substr($pre_reg_date, 10,2);
            $pre_reg_date_sec   = substr($pre_reg_date, 12,2);
            $pre_use_st         = $data['use_st'   ];   /* �� ����          */
            $pre_hit            = $data['hit'      ];   /* ��ȸ��           */
            $pre_total_comment  = $data['total_comment'];/* �ڸ�Ʈ ��   */
        } else if (  $next_no == $data['no'] ) {
            $next_no      = $data['no'       ];   /* �Խù� ��ȣ      */
//          $a_next_view  = $a_view_tmp . '&no=' .$next_no. "'>";
            $a_next_view  = $a_view_tmp . $next_no . "');return false;\">";
            $next_user_id = $data['user_id'  ];   /* ����� ID        */
            $next_name    = $data['name'     ];   /* �̸�             */
            $next_title   = $data['title'    ];   /* ����             */
            $next_e_mail  = $data['e_mail'   ];   /* E-mail           */
            $next_home    = $data['home'     ];   /* Homepage         */
            $next_f_path1 = $data['f_path1'   ];   /* ���� ���� ���1   */
            $next_f_name1 = $data['f_name1'   ];   /* ���� ��1          */
            $next_f_ext1  = $data['f_ext1'    ];   /* ���� Ȯ����1      */
            $next_f_size1 = $data['f_size1'   ];   /* ���� ũ��1        */
            $next_f_date1 = $data['f_date1'   ];   /* ���� ���ϸ�1      */

            $next_f_path2 = $data['f_path2'   ];   /* ���� ���� ���2   */
            $next_f_name2 = $data['f_name2'   ];   /* ���� ��2          */
            $next_f_ext2  = $data['f_ext2'    ];   /* ���� Ȯ����2      */
            $next_f_size2 = $data['f_size2'   ];   /* ���� ũ��2        */
            $next_f_date2 = $data['f_date2'   ];   /* ���� ���ϸ�2      */

            if ( $next_f_name1 ) {
                $next_a_file1  = "<a href='download.php?id=$id&no=$no&gubun=1' target='_dboard_iframe'>";
                $next_f_size1  = f_size($next_f_size1);
                $next_f_name1  = $next_f_name1 . '.' . $next_f_ext1;
                $next_f_infor1 = $baseDir . $next_f_path1 . $next_f_date1 . '.' . $next_f_ext1; // ���� ���� ���
            } else {
                $next_a_file1  = "<a href='#' style='display:none'>";
                $next_f_size1  = '';
                $next_f_name1  = '';
                $next_f_infor1 = '';
            }

            if ( $next_f_name2 ) {
                $next_a_file2  = "<a href='download.php?id=$id&no=$no&gubun=1' target='_dboard_iframe'>";
                $next_f_size2  = f_size($next_f_size2);
                $next_f_name2  = $next_f_name2 . '.' . $next_f_ext2;
                $next_f_infor2 = $baseDir . $next_f_path2 . $next_f_date2 . '.' . $next_f_ext2; // ���� ���� ���
            } else {
                $next_a_file2  = "<a href='#' style='display:none'>";
                $next_f_size2  = '';
                $next_f_name2  = '';
                $next_f_infor2 = '';
            }

            $next_reg_date       = $data['reg_date'     ];   /* �ۼ� �� �������� */
            $next_reg_date_year  = substr($next_reg_date, 0 ,4);
            $next_reg_date_month = substr($next_reg_date, 4 ,2);
            $next_reg_date_day   = substr($next_reg_date, 6 ,2);
            $next_reg_date_hour  = substr($next_reg_date, 8 ,2);
            $next_reg_date_min   = substr($next_reg_date, 10,2);
            $next_reg_date_sec   = substr($next_reg_date, 12,2);
            $next_use_st         = $data['use_st'       ];   /* �� ����          */
            $next_hit            = $data['hit'          ];   /* ��ȸ��           */
            $next_total_comment  = $data['total_comment'];   /* �ڸ�Ʈ ��        */
        }
    }
}
?>