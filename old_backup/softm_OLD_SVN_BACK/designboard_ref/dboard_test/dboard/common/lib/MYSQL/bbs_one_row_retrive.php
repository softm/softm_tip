<?
if ( function_exists('head') && $no ) {
    /* �Խù� �Ѱ� ��ȸ */
    $sql = "select * from $tb_bbs_data" . "_" . $id . " where no = '$no'";

    $data = singleRowSQLQuery ($sql);
    if ( $data ) {
        $use_st     = $data['use_st'   ];   /* �� ����          */
        if ( ( $use_st != 8 && $use_st != 9 ) || $admin_yn == 'Y' ) {
            /* ----- �� ���� ------------------------------------ */
            $no         = $data['no'       ];   /* �Խù� ��ȣ      */
            $cat_no     = $data['cat_no'   ];   /* ī�װ� ��ȣ    */
            $cat_name   = $category ['name'][$cat_no];   /* ī�װ� �� */

    //      $a_view    .= $a_view_tmp . '&no=' .$no . "'>";
            $a_view    .= $a_view_tmp . $no . "');return false;\">";
            $g_no       = $data['g_no'     ];   /* �׷���̵�       */
            $depth      = $data['depth'    ];   /* �亯����         */
            $o_seq      = $data['o_seq'    ];   /* ���� ����        */
            $pre_no     = $data['pre_no'   ];   /* ���� �Խù� ��ȣ */
            $next_no    = $data['next_no'  ];   /* ���� �Խù� ��ȣ */
            $w_member_level = $data['member_level']; /* ȸ�� ����   */
            $w_user_id  = $data['user_id'  ];   /* ����� ID        */
            $name       = $data['name'     ];   /* �̸�             */
            $password   = $data['password' ];   /* ��й�ȣ         */
            $title      = $data['title'    ];   /* ����             */

            $html_yn    = $data['html_yn'  ];   /* Html ��뿩��    */
            $mail_yn    = $data['mail_yn'  ];   /* �亯 Ȯ�� ����   */

            $content    = $data['content'  ];   /* ����             */
            $e_mail     = $data['e_mail'   ];   /* E-mail           */
            $home       = $data['home'     ];   /* Homepage         */

            $f_path1    = $data['f_path1'  ];   /* ���� ���� ���1   */
            $f_name1    = $data['f_name1'  ];   /* ���� ��1          */
            $f_ext1     = $data['f_ext1'   ];   /* ���� Ȯ����1      */
            $f_size1    = $data['f_size1'  ];   /* ���� ũ��1        */
            $f_date1    = $data['f_date1'  ];   /* ���� ���ϸ�1      */

            $f_path2    = $data['f_path2'  ];   /* ���� ���� ���2   */
            $f_name2    = $data['f_name2'  ];   /* ���� ��2          */
            $f_ext2     = $data['f_ext2'   ];   /* ���� Ȯ����2      */
            $f_size2    = $data['f_size2'  ];   /* ���� ũ��2        */
            $f_date2    = $data['f_date2'  ];   /* ���� ���ϸ�2      */

            $reg_date   = $data['reg_date' ];   /* �ۼ� �� �������� */
            $reg_year   = substr($reg_date, 0 ,4);
            $reg_month  = substr($reg_date, 4 ,2);
            $reg_day    = substr($reg_date, 6 ,2);
            $reg_hour   = substr($reg_date, 8 ,2);
            $reg_min    = substr($reg_date, 10,2);
            $reg_sec    = substr($reg_date, 12,2);
            $reg_date   = substr($reg_date, 0,4) . '.' . substr($reg_date, 4,2) . '.' . substr($reg_date, 6,2);

            $recom_hit  = $data['recom_hit'];   /* ��õ ��          */
            $hit        = $data['hit'      ];   /* ��ȸ��           */
            $down_hit1  = $data['down_hit1'];   /* �ٿ��1          */
            $down_hit2  = $data['down_hit2'];   /* �ٿ��2          */
            $link1      = $data['link1'    ];   /* ��ũ1            */
            $link2      = $data['link2'    ];   /* ��ũ2            */
            $ip         = $data['ip'       ];   /* �ۼ� IP �ּ�     */
        }
    } else {
        $no         = '';   /* �Խù� ��ȣ      */
    }
    
    if ( $exec == 'update' || $exec == 'answer' ) {
    	$content = str_replace("<!--?", "<?", $content);
    	$content = str_replace("?-->" , "?>", $content);
    }    
}
?>